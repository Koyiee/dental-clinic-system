<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Billing;
use App\Models\Dentist;
use App\Models\ServicesAvailed;
use App\Models\Service;
use App\Models\TreatmentProgress;
use App\Models\Payment;
use App\Events\UserActionOccurred;
use App\Mail\AppointmentStatusUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Services\BrevoMailService;
use Carbon\Carbon;

class AppointmentController extends Controller
{

    private function isDateBlocked($date, $dentistId = null)
    {
        return DB::table('blocked_dates')
            ->where('BlockedDate', $date)
            ->where(function ($query) use ($dentistId) {
                $query->whereNull('DentistID') // Clinic-wide block
                    ->orWhere('DentistID', $dentistId); // Dentist-specific block
            })
            ->exists();
    }

    public function store(Request $request)
    {
        try {
            \Log::info('Incoming request data:', $request->all());
    
            $request->validate([
                'AppointmentDate' => 'required|date|after_or_equal:today',
                'AppointmentTime' => 'required|date_format:H:i',
                'services' => 'required|array|min:1|max:3',
                'services.*' => 'string|exists:services,ServiceName',
                'DentistID' => 'nullable|exists:dentists,DentistID',
                'PatientID' => 'required|exists:patients,PatientID',
                'PatientNote' => 'nullable|string',
            ]);
    
            $PatientId = auth()->user()->patient ? auth()->user()->patient->PatientID : null;
            if (!$PatientId) {
                return response()->json(['success' => false, 'message' => 'Patient ID not found.'], 400);
            }
    
            $DentistID = $request->input('DentistID');
            if ($DentistID === 'any') {
                $DentistID = null;
            }
    
            // Check if the date is blocked
            $appointmentDate = $request->input('AppointmentDate');
            if ($this->isDateBlocked($appointmentDate, $DentistID)) {
                return response()->json([
                    'success' => false,
                    'message' => 'This date is blocked. Please choose another date.',
                ], 400);
            }
    
            $serviceCount = count($request->input('services'));
            try {
                $startTime = Carbon::createFromFormat('Y-m-d H:i', $request->AppointmentDate . ' ' . $request->AppointmentTime);
            } catch (\Exception $e) {
                \Log::error('Invalid AppointmentTime format: ' . $request->AppointmentTime);
                return response()->json(['success' => false, 'message' => 'Invalid time format. Use HH:MM (e.g., 11:00).'], 400);
            }
            $endTime = $startTime->copy()->addHours($serviceCount);
    
            // Check slot availability (direct + overlaps)
            $appointments = Appointment::where('AppointmentDate', $request->AppointmentDate)
                ->whereNotIn('AppointmentStatus', ['Declined', 'Cancelled'])
                ->with('servicesAvailed')
                ->get()
                ->map(function ($appointment) {
                    $serviceCount = $appointment->servicesAvailed->count();
                    return [
                        'start' => Carbon::parse($appointment->AppointmentTime),
                        'duration' => $serviceCount,
                    ];
                });
    
            $affectedTimes = [];
            $currentTime = $startTime->copy();
            while ($currentTime->lessThan($endTime)) {
                $affectedTimes[] = $currentTime->format('H:i');
                $currentTime->addHours(1);
            }
    
            foreach ($affectedTimes as $time) {
                $directBookings = $appointments->where('start.format', 'H:i', $time)->count();
                $overlaps = $appointments->filter(function ($appt) use ($time) {
                    $apptStart = $appt['start'];
                    $apptEnd = $apptStart->copy()->addHours($appt['duration']);
                    return $apptStart->lessThan(Carbon::parse($time)) && $apptEnd->greaterThan(Carbon::parse($time));
                })->count();
                if ($directBookings + $overlaps >= 5) {
                    return response()->json(['success' => false, 'message' => "Time slot $time is fully booked"], 400);
                }
            }
    
            // Check dentist availability if specified
            if ($DentistID) {
                $dentist = Dentist::find($DentistID);
                if (!$dentist) {
                    return response()->json(['success' => false, 'message' => 'Dentist not found.'], 400);
                }
                $dayOff = json_decode($dentist->DayOff, true);
                $appointmentDay = date('l', strtotime($request->AppointmentDate));
                if (is_array($dayOff) && in_array($appointmentDay, $dayOff)) {
                    return response()->json(['success' => false, 'message' => 'The selected dentist is unavailable on the chosen date.'], 400);
                }
    
                \Log::info('Checking dentist availability', [
                    'DentistID' => $DentistID,
                    'AppointmentDate' => $request->AppointmentDate,
                    'StartTime' => $startTime->format('H:i'),
                    'EndTime' => $endTime->format('H:i'),
                ]);
    
                $conflictingAppointments = Appointment::where('DentistID', $DentistID)
                    ->where('AppointmentDate', $request->AppointmentDate)
                    ->whereNotIn('AppointmentStatus', ['Cancelled', 'Declined'])
                    ->where(function ($query) use ($startTime, $endTime) {
                        $query->whereBetween('AppointmentTime', [$startTime->format('H:i'), $endTime->subMinute()->format('H:i')])
                            ->orWhere(function ($q) use ($startTime, $endTime) {
                                $q->where('AppointmentTime', '<', $endTime->format('H:i'))
                                    ->whereHas('servicesAvailed', function ($subQ) use ($startTime) {
                                        $subQ->select('services_availed.AppointmentID') // Explicitly select only AppointmentID
                                            ->selectRaw('COUNT(*) as service_count, appointments.AppointmentTime')
                                            ->groupBy('services_availed.AppointmentID', 'appointments.AppointmentTime')
                                            ->havingRaw('ADDTIME(appointments.AppointmentTime, CONCAT(service_count, ":00:00")) > ?', [$startTime->format('H:i')]);
                                    });
                            });
                    })
                    ->exists();
    
                if ($conflictingAppointments) {
                    return response()->json(['success' => false, 'message' => 'Dentist is unavailable for this duration'], 400);
                }
            }
    
            $appointment = Appointment::create([
                'AppointmentDate' => $request->AppointmentDate,
                'AppointmentTime' => $request->AppointmentTime,
                'DentistID' => $DentistID,
                'PatientID' => $PatientId,
                'AppointmentStatus' => 'Pending',
                'PatientNote' => $request->PatientNote,
            ]);
    
            // Logging
            $user = auth()->user();
            $dentistName = $appointment->dentist 
                ? "Dr. {$appointment->dentist->user->FirstName} {$appointment->dentist->user->LastName}" 
                : "Any Dentist";
            event(new UserActionOccurred(
                auth()->id(),
                'Appointment Booked',
                "Patient {$user->FirstName} {$user->LastName} booked an appointment on " . 
                date('F j, Y g:i A', strtotime($appointment->AppointmentDate . ' ' . $appointment->AppointmentTime)) . 
                " with {$dentistName}"
            ));
    
            // Define $serviceNames and ensure it's an array
            $serviceNames = $request->input('services', []);
            \Log::info('Service Names from Request:', ['serviceNames' => $serviceNames]);
    
            $serviceIDs = Service::whereIn('ServiceName', $serviceNames)
                ->pluck('ServiceID')
                ->toArray();
    
            \Log::info('Mapped Service IDs:', ['serviceNames' => $serviceNames, 'serviceIDs' => $serviceIDs]);
    
            if (empty($serviceIDs)) {
                throw new \Exception('No valid ServiceIDs found for services: ' . implode(', ', $serviceNames));
            }
    
            foreach ($serviceIDs as $serviceID) {
                $service = Service::find($serviceID);
                $serviceAvailed = ServicesAvailed::create([
                    'AppointmentID' => $appointment->AppointmentID,
                    'ServiceID' => $serviceID,
                    'Status' => 'Pending',
                ]);
    
                \Log::info('Created ServicesAvailed record:', [
                    'ServiceAvailedID' => $serviceAvailed->ServiceAvailedID,
                    'AppointmentID' => $serviceAvailed->AppointmentID,
                    'ServiceID' => $serviceAvailed->ServiceID,
                ]);
    
                if ($service->IsMultiVisit) {
                    $existingProgress = TreatmentProgress::where('PatientID', $appointment->PatientID)
                        ->where('TreatmentName', $service->ServiceName)
                        ->where('Status', '!=', 'Completed')
                        ->first();
    
                    if ($existingProgress) {
                        $visitCount = ServicesAvailed::where('TreatmentProgressID', $existingProgress->TreatmentProgressID)
                            ->join('appointments', 'services_availed.AppointmentID', '=', 'appointments.AppointmentID')
                            ->distinct('appointments.AppointmentID')
                            ->count('appointments.AppointmentID');
                        $existingProgress->VisitCount = $visitCount;
                        $existingProgress->save();
                        $serviceAvailed->TreatmentProgressID = $existingProgress->TreatmentProgressID;
                        $serviceAvailed->save();
    
                        \Log::info("Updated existing TreatmentProgress VisitCount", [
                            'PatientID' => $appointment->PatientID,
                            'TreatmentProgressID' => $existingProgress->TreatmentProgressID,
                            'NewVisitCount' => $visitCount,
                            'StartDate' => $existingProgress->StartDate->toDateString(),
                            'EndDate' => $existingProgress->EndDate ? $existingProgress->EndDate->toDateString() : 'NULL',
                            'ServiceAvailedID' => $serviceAvailed->ServiceAvailedID,
                            'UpdatedTreatmentProgressID' => $serviceAvailed->TreatmentProgressID,
                        ]);
                    } else {
                        $treatmentProgress = TreatmentProgress::create([
                            'PatientID' => $appointment->PatientID,
                            'TreatmentName' => $service->ServiceName,
                            'StartDate' => $appointment->AppointmentDate,
                            'VisitCount' => 1,
                            'EndDate' => null,
                            'Status' => 'In Progress',
                        ]);
    
                        \Log::info('Created new TreatmentProgress record:', [
                            'TreatmentProgressID' => $treatmentProgress->TreatmentProgressID,
                            'PatientID' => $treatmentProgress->PatientID,
                            'TreatmentName' => $treatmentProgress->TreatmentName,
                        ]);
    
                        $serviceAvailed->TreatmentProgressID = $treatmentProgress->TreatmentProgressID;
                        $serviceAvailed->save();
    
                        \Log::info("Updated ServicesAvailed with TreatmentProgressID", [
                            'ServiceAvailedID' => $serviceAvailed->ServiceAvailedID,
                            'TreatmentProgressID' => $serviceAvailed->TreatmentProgressID,
                        ]);
                    }
                }
            }
    
            // Send booking confirmation email to patient
            try {
                $patientEmail = $appointment->patient->user->Email;

                // Render the appointment status updated email manually
                $html = view('emails.appointment_status', [
                    'appointment' => $appointment,
                    'status' => 'Pending',
                    'dentistName' => $dentistName ?? null,
                    'declineReason' => $declineReason ?? null,
                ])->render();
                
                // Send using BrevoMailService
                $brevo = new BrevoMailService();
                $brevo->sendEmail(
                    $patientEmail,
                    'Booking Confirmation - Appointment Pending',
                    $html
                );

                \Log::info("Booking confirmation email sent to patient", [
                    'AppointmentID' => $appointment->AppointmentID,
                    'PatientEmail' => $patientEmail,
                ]);
            } catch (\Exception $e) {
                \Log::error("Failed to send booking confirmation email: " . $e->getMessage(), [
                    'AppointmentID' => $appointment->AppointmentID,
                    'PatientEmail' => $patientEmail ?? 'N/A',
                    'Stack' => $e->getTraceAsString(),
                ]);
            }
    
            if ($request->expectsJson()) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Appointment booked successfully!',
                        'appointment' => [
                            'AppointmentID' => $appointment->AppointmentID,
                            'AppointmentDate' => $appointment->AppointmentDate,
                            'AppointmentTime' => $appointment->AppointmentTime,
                            'PatientNote' => $appointment->PatientNote,
                            'AppointmentStatus' => $appointment->AppointmentStatus,
                            'DentistID' => $appointment->DentistID,
                            'services' => $serviceNames,
                        ],
                    ],
                    201
                );
            }
    
            return redirect()->route('patientappointments');
        } catch (\Exception $e) {
            \Log::error('Error booking appointment: ' . $e->getMessage() . ' | Stack: ' . $e->getTraceAsString(), [
                'request_data' => $request->all(),
            ]);
            return response()->json(['success' => false, 'message' => 'An error occurred while booking the appointment. Please try again.'], 500);
        }
    }
    public function checkPatientAppointmentDate(Request $request)
    {
        try {
            // Ensure the user is authenticated
            if (!auth()->check()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized. Please log in.'], 401);
            }
    
            $PatientId = auth()->user()->patient ? auth()->user()->patient->PatientID : null;
            if (!$PatientId) {
                // Log this for debugging and return an error
                \Log::warning('Patient ID not found for authenticated user', ['user_id' => auth()->id()]);
                return response()->json(['success' => false, 'message' => 'Patient ID not found.'], 400);
            }
    
            $request->validate([
                'date' => 'required|date|after_or_equal:today',
            ]);
    
            $date = $request->input('date');
    
            // Check if the date is blocked (clinic-wide or for any specific dentist)
            if ($this->isDateBlocked($date)) {
                return response()->json([
                    'success' => true,
                    'hasAppointment' => true, // Treat blocked dates as unavailable
                    'message' => 'This date is blocked and unavailable for booking.',
                ]);
            }
    
            $hasAppointment = Appointment::where('PatientID', $PatientId)
                ->where('AppointmentDate', $date)
                ->exists();
    
            return response()->json([
                'success' => true,
                'hasAppointment' => $hasAppointment,
                'message' => $hasAppointment ? 'You already have an appointment scheduled on this day. Please choose a different date.' : 'Date is available.'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error checking appointment date: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to check date availability: ' . $e->getMessage()], 500);
        }
    }

    public function index(Request $request) {
        $user = auth()->user();
        $patient = $user->patient;
        if (!$patient) {
            if ($request->expectsJson()) {
                return response()->json(['upcoming' => [], 'passed' => [], 'declined_cancelled' => []]);
            }
            return view('patientappointments', ['upcomingAppointments' => [], 'passedAppointments' => [], 'declinedCancelledAppointments' => []]);
        }
    
        $currentDate = now()->toDateString();
    
        $appointments = Appointment::with(['dentist.user', 'servicesAvailed.service'])
            ->where('PatientID', $patient->PatientID)
            ->orderBy('created_at', 'desc')
            ->get();
    
        $upcomingAppointments = $appointments->filter(function ($appointment) use ($currentDate) {
            $status = strtolower($appointment->AppointmentStatus);
            $isUpcomingStatus = in_array($status, ['pending', 'confirmed']);
            $isFutureOrToday = $appointment->AppointmentDate >= $currentDate;
            return $isUpcomingStatus && $isFutureOrToday;
        })->map(function ($appointment) {
            return $this->formatAppointment($appointment);
        })->values();
    
        $declinedCancelledAppointments = $appointments->filter(function ($appointment) {
            $status = strtolower($appointment->AppointmentStatus);
            return in_array($status, ['declined', 'cancelled']);
        })->map(function ($appointment) {
            return $this->formatAppointment($appointment);
        })->values();
    
        $passedAppointments = $appointments->filter(function ($appointment) {
            $status = strtolower($appointment->AppointmentStatus);
            return $status === 'completed';
        })->map(function ($appointment) {
            return $this->formatAppointment($appointment);
        })->values();
    
        if ($request->expectsJson()) {
            return response()->json([
                'upcoming' => $upcomingAppointments,
                'declined_cancelled' => $declinedCancelledAppointments,
                'passed' => $passedAppointments,
            ]);
        }
    
        return view('patientappointments', [
            'upcomingAppointments' => $upcomingAppointments,
            'declinedCancelledAppointments' => $declinedCancelledAppointments,
            'passedAppointments' => $passedAppointments,
        ]);
    }
    
    // Update formatAppointment to include ServiceStatus
    private function formatAppointment($appointment, $serviceAvailed = null)
    {
        $dentist = $appointment->dentist ? $appointment->dentist->user : null;
        $dentistName = $appointment->DentistID === null
            ? 'Any Dentist'
            : ($dentist ? "{$dentist->FirstName} {$dentist->LastName}" : 'N/A');
    
        $services = $serviceAvailed
            ? [$serviceAvailed->service->ServiceName]
            : $appointment->servicesAvailed->map(fn($sa) => $sa->service->ServiceName)->toArray();
    
        $serviceStatus = $serviceAvailed ? $serviceAvailed->Status : null;
    
        return [
            'AppointmentID' => $appointment->AppointmentID,
            'AppointmentDate' => $appointment->AppointmentDate,
            'AppointmentTime' => $appointment->AppointmentTime,
            'Services' => $services,
            'PatientNote' => $appointment->PatientNote,
            'AppointmentStatus' => $appointment->AppointmentStatus,
            'ServiceStatus' => $serviceStatus, // Add service-level status
            'DentistID' => $appointment->DentistID,
            'DentistName' => $dentistName,
        ];
    }

    public function getPendingAppointments(Request $request)
    {
        $pendingAppointments = Appointment::where('AppointmentStatus', 'Pending')
            ->with(['patient.user', 'dentist.user', 'servicesAvailed.service'])
            ->orderBy('created_at', 'desc')
            ->get();

        Log::info('Pending Appointments Count:', ['count' => $pendingAppointments->count()]);
        Log::info('Pending Appointments Raw Data:', $pendingAppointments->toArray());

        $appointmentsWithDetails = $pendingAppointments->map(function ($appointment) {
            $patient = $appointment->patient ? $appointment->patient->user : null;
            $dentist = $appointment->dentist ? $appointment->dentist->user : null;
            $dentistName = $appointment->DentistID === null
                ? 'Any Dentist'
                : ($dentist ? "{$dentist->FirstName} {$dentist->LastName}" : 'N/A');

            $services = $appointment->servicesAvailed->map(function ($ServicesAvailed) {
                return $ServicesAvailed->service->ServiceName;
            })->toArray();

            return [
                'AppointmentID' => $appointment->AppointmentID,
                'PatientName' => $patient ? "{$patient->FirstName} {$patient->LastName}" : 'N/A',
                'DentistName' => $dentistName,
                'UserID' => $dentist ? $dentist->UserID : null, // Add UserID
                'Services' => $services,
                'AppointmentDate' => $appointment->AppointmentDate,
                'AppointmentTime' => $appointment->AppointmentTime,
                'PatientNote' => $appointment->PatientNote ?? 'No notes available',
                'Status' => $appointment->AppointmentStatus,
            ];
        });

        if ($request->expectsJson()) {
            return response()->json($appointmentsWithDetails);
        }
        return view('hrappointments', compact('appointmentsWithDetails'));
    }

    public function update(Request $request, $id) {
        Log::info("update called for ID: $id", ['request' => $request->all()]);
        
        // Validation rules (adding confirmSave)
        $validated = $request->validate([
            'status' => 'required|in:Pending,Confirmed,Completed,Cancelled,Declined',
            'declineReason' => 'required_if:status,Declined|string|max:500',
            'user_id' => 'nullable|exists:users,UserID',
            'patient_notes' => 'nullable|string',
            'total_amount' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'services' => 'sometimes|array|min:1',
            'services.*.ServiceAvailedID' => 'nullable|exists:services_availed,ServiceAvailedID',
            'services.*.ServiceID' => 'nullable|exists:services,ServiceID',
            'services.*.Status' => 'required_with:services|in:Pending,Completed,Cancelled',
            'confirmSave' => 'sometimes|boolean', // New parameter for confirmation
        ]);
        
        $appointment = Appointment::with(['servicesAvailed.service', 'patient.user', 'dentist.user'])->findOrFail($id);
        $oldStatus = $appointment->AppointmentStatus;
        
        // Prevent edits if already Completed
        if (strtolower($oldStatus) === 'completed') {
            return response()->json(['message' => 'This appointment is already completed and cannot be edited.'], 403);
        }
        
        // Restrict service modifications to Confirmed status (original logic)
        if (isset($validated['services']) && $oldStatus !== 'Confirmed') {
            return response()->json(['message' => 'Services can only be modified for Confirmed appointments'], 400);
        }
        
        // Handle dentist assignment
        if (isset($validated['user_id'])) {
            $dentist = DB::table('dentists')->where('UserID', $validated['user_id'])->first();
            $appointment->DentistID = $dentist ? $dentist->DentistID : null;
        }
        if (isset($validated['patient_notes'])) {
            $appointment->PatientNote = $validated['patient_notes'];
        }
        
        $requiresConfirmation = false;
        
        // Handle services: update existing, add new, delete removed
        if (isset($validated['services']) && is_array($validated['services'])) {
            $incomingServiceAvailedIDs = array_filter(array_column($validated['services'], 'ServiceAvailedID'));
            $existingServiceAvailedIDs = $appointment->servicesAvailed->pluck('ServiceAvailedID')->toArray();
        
            // Delete services not in the request
            $servicesToDelete = array_diff($existingServiceAvailedIDs, $incomingServiceAvailedIDs);
            if (!empty($servicesToDelete)) {
                ServicesAvailed::whereIn('ServiceAvailedID', $servicesToDelete)->delete();
                Log::info("Deleted ServicesAvailed", ['ServiceAvailedIDs' => $servicesToDelete]);
            }
        
            // Process each service in the request
            foreach ($validated['services'] as $serviceData) {
                if ($serviceData['ServiceAvailedID']) {
                    // Update existing service
                    $serviceAvailed = ServicesAvailed::findOrFail($serviceData['ServiceAvailedID']);
                    $oldServiceStatus = $serviceAvailed->Status;
                    $serviceAvailed->Status = $serviceData['Status'];
                    $serviceAvailed->save();
                    Log::info("Service status updated", [
                        'ServiceAvailedID' => $serviceAvailed->ServiceAvailedID,
                        'OldStatus' => $oldServiceStatus,
                        'NewStatus' => $serviceAvailed->Status,
                    ]);
                } elseif ($serviceData['ServiceID']) {
                    // Add new service
                    $serviceAvailed = ServicesAvailed::create([
                        'AppointmentID' => $appointment->AppointmentID,
                        'ServiceID' => $serviceData['ServiceID'],
                        'Status' => $serviceData['Status'],
                    ]);
                    Log::info("Added new ServiceAvailed", [
                        'ServiceAvailedID' => $serviceAvailed->ServiceAvailedID,
                        'ServiceID' => $serviceData['ServiceID'],
                        'Status' => $serviceAvailed->Status,
                    ]);
                }
            }
        
            // Reload services to reflect changes
            $appointment->load('servicesAvailed.service');
            $allServiceStatuses = $appointment->servicesAvailed->pluck('Status')->toArray();
            $uniqueStatuses = array_unique($allServiceStatuses);
            $completedCount = count(array_filter($allServiceStatuses, fn($status) => $status === 'Completed'));
            $cancelledCount = count(array_filter($allServiceStatuses, fn($status) => $status === 'Cancelled'));
            $totalServices = count($allServiceStatuses);
            
            // New logic: Check if all services are not Pending and dentist is assigned
            $allServicesNotPending = !in_array('Pending', $allServiceStatuses);
            $hasDentist = $appointment->DentistID !== null;
            
            if ($allServicesNotPending && $hasDentist && !($validated['confirmSave'] ?? false)) {
                $requiresConfirmation = true;
                $appointment->AppointmentStatus = 'Completed'; // Tentatively set to Completed
            } else {
                // Original status determination logic
                if ($uniqueStatuses === ['Completed']) {
                    $appointment->AppointmentStatus = 'Completed';
                } elseif ($uniqueStatuses === ['Cancelled'] || $cancelledCount === $totalServices) {
                    $appointment->AppointmentStatus = 'Cancelled';
                } elseif ($completedCount > 0) {
                    $appointment->AppointmentStatus = 'Completed';
                } else {
                    $appointment->AppointmentStatus = $validated['status'];
                }
            }
            
            Log::info("Appointment status determined", [
                'AppointmentID' => $appointment->AppointmentID,
                'ServiceStatuses' => $allServiceStatuses,
                'NewAppointmentStatus' => $appointment->AppointmentStatus,
                'RequiresConfirmation' => $requiresConfirmation,
            ]);
        } else {
            $appointment->AppointmentStatus = $validated['status'];
        }
        
        // Save only if no confirmation is required or if confirmed
        if (!$requiresConfirmation) {
            $appointment->save();
            
            Log::info("Appointment updated", [
                'AppointmentID' => $appointment->AppointmentID,
                'OldStatus' => $oldStatus,
                'NewStatus' => $appointment->AppointmentStatus,
                'DentistID' => $appointment->DentistID,
                'PatientNote' => $appointment->PatientNote,
            ]);
        }
        
        // Email notification logic
    if (!$requiresConfirmation && $oldStatus !== $appointment->AppointmentStatus && 
        in_array($appointment->AppointmentStatus, ['Confirmed', 'Declined'])) {
        try {
            $patientEmail = $appointment->patient->user->Email;
            $declineReason = $appointment->AppointmentStatus === 'Declined' ? $validated['declineReason'] : null;

            // Explicitly calculate dentistName like in store method
            $dentistName = $appointment->dentist && $appointment->dentist->user
                ? "Dr. {$appointment->dentist->user->FirstName} {$appointment->dentist->user->LastName}"
                : "Any Dentist";

            Log::info("Preparing to send email", [
                'AppointmentID' => $appointment->AppointmentID,
                'DentistID' => $appointment->DentistID,
                'DentistName' => $dentistName,
            ]);

            $brevo = new BrevoMailService();
            $html = view('emails.appointment_status', [
                'appointment' => $appointment,
                'status' => $appointment->AppointmentStatus,
                'dentistName' => $dentistName, // Pass explicitly
                'declineReason' => $declineReason
            ])->render();

            $brevo->sendEmail(
                $patientEmail,
                'Appointment Status Updated',
                $html
            );

            Log::info("Email sent to patient", [
                'AppointmentID' => $appointment->AppointmentID,
                'PatientEmail' => $patientEmail,
                'Status' => $appointment->AppointmentStatus,
                'DentistName' => $dentistName,
                'DeclineReason' => $declineReason,
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to send email notification: " . $e->getMessage(), [
                'AppointmentID' => $appointment->AppointmentID,
                'PatientEmail' => $patientEmail ?? 'N/A',
                'Stack' => $e->getTraceAsString(),
            ]);
        }
    }
        
        // Billing logic (unchanged)
        if (!$requiresConfirmation && strtolower($oldStatus) !== 'completed' && 
            strtolower($appointment->AppointmentStatus) === 'completed') {
            try {
                $billing = Billing::where('AppointmentID', $appointment->AppointmentID)->first();
                $servicesAvailed = $appointment->servicesAvailed;
                
                if ($servicesAvailed->isEmpty()) {
                    Log::warning("No services availed for AppointmentID: $id");
                    return response()->json(['message' => 'No services found for billing creation'], 400);
                }
                
                $totalCost = 0;
                $latestPaymentMethodId = null;
                
                Log::info("Processing services for billing", [
                    'servicesAvailed' => $servicesAvailed->map(function ($sa) {
                        return ['ServiceAvailedID' => $sa->ServiceAvailedID, 'Status' => $sa->Status, 'Cost' => $sa->service->Cost];
                    })->toArray(),
                ]);
                
                foreach ($servicesAvailed as $sa) {
                    $service = $sa->service;
                    if ($sa->Status === 'Completed') {
                        if ($service->IsMultiVisit) {
                            $treatmentProgress = $sa->TreatmentProgressID 
                                ? TreatmentProgress::find($sa->TreatmentProgressID)
                                : TreatmentProgress::where('PatientID', $appointment->PatientID)
                                    ->where('TreatmentName', $service->ServiceName)
                                    ->orderBy('created_at', 'desc')
                                    ->first();
                
                            if (!$treatmentProgress) {
                                $treatmentProgress = TreatmentProgress::create([
                                    'PatientID' => $appointment->PatientID,
                                    'TreatmentName' => $service->ServiceName,
                                    'StartDate' => $appointment->AppointmentDate,
                                    'VisitCount' => 1,
                                    'EndDate' => null,
                                    'Status' => 'In Progress',
                                ]);
                                $totalCost += $service->Cost;
                                Log::info("Created new TreatmentProgress for first visit", [
                                    'TreatmentProgressID' => $treatmentProgress->TreatmentProgressID,
                                    'PatientID' => $appointment->PatientID,
                                    'ServiceName' => $service->ServiceName,
                                    'InitialCost' => $service->Cost,
                                ]);
                            } else {
                                $treatmentProgress->VisitCount = $treatmentProgress->VisitCount + 1;
                                if ($treatmentProgress->Status !== 'Completed') {
                                    $treatmentProgress->Status = 'In Progress';
                                }
                                $treatmentProgress->save();
                                Log::info("Updated TreatmentProgress for subsequent visit", [
                                    'TreatmentProgressID' => $treatmentProgress->TreatmentProgressID,
                                    'VisitCount' => $treatmentProgress->VisitCount,
                                    'Status' => $treatmentProgress->Status,
                                ]);
                
                                $priorBilling = Billing::whereHas('appointment.servicesAvailed', function ($query) use ($treatmentProgress) {
                                    $query->where('TreatmentProgressID', $treatmentProgress->TreatmentProgressID);
                                })->orderBy('created_at', 'desc')->first();
                
                                if ($priorBilling) {
                                    $totalCost += $priorBilling->Balance;
                                    Log::info("Using prior billing balance for multi-visit service", [
                                        'TreatmentProgressID' => $treatmentProgress->TreatmentProgressID,
                                        'PriorBillingID' => $priorBilling->BillingID,
                                        'BalanceUsed' => $priorBilling->Balance,
                                        'BillingStatus' => $priorBilling->BillingStatus,
                                    ]);
            
                                    if ($totalCost == 0) {
                                        $latestPayment = Payment::whereHas('billing.appointment.servicesAvailed', function ($query) use ($treatmentProgress) {
                                            $query->where('TreatmentProgressID', $treatmentProgress->TreatmentProgressID);
                                        })->orderBy('PaymentDate', 'desc')->first();
                                        if ($latestPayment) {
                                            $latestPaymentMethodId = $latestPayment->PaymentMethodID;
                                            Log::info("Fetched latest payment method for fully paid multi-visit", [
                                                'TreatmentProgressID' => $treatmentProgress->TreatmentProgressID,
                                                'PaymentMethodID' => $latestPaymentMethodId,
                                            ]);
                                        }
                                    }
                                } else {
                                    $totalCost += $service->Cost;
                                    Log::info("Added multi-visit service cost", [
                                        'ServiceAvailedID' => $sa->ServiceAvailedID,
                                        'Cost' => $service->Cost,
                                        'TotalCost' => $totalCost,
                                    ]);
                                }
                            }
                
                            $sa->TreatmentProgressID = $treatmentProgress->TreatmentProgressID;
                            $sa->save();
                        } else {
                            $totalCost += $service->Cost;
                            Log::info("Added single-visit service cost", [
                                'ServiceAvailedID' => $sa->ServiceAvailedID,
                                'Cost' => $service->Cost,
                                'TotalCost' => $totalCost,
                            ]);
                        }
                    } else {
                        Log::info("Skipping billing for service due to non-Completed status", [
                            'ServiceAvailedID' => $sa->ServiceAvailedID,
                            'Status' => $sa->Status,
                        ]);
                    }
                }
                
                if ($totalCost > 0) {
                    $finalTotalAmount = isset($validated['total_amount']) ? (float) $validated['total_amount'] : $totalCost;
                    $discount = isset($validated['discount']) ? (float) $validated['discount'] : 0.00;
                
                    if (!$billing) {
                        $billing = Billing::create([
                            'AppointmentID' => $appointment->AppointmentID,
                            'TotalAmount' => $finalTotalAmount,
                            'Balance' => max(0, $finalTotalAmount - $discount),
                            'Discount' => $discount,
                            'BillingStatus' => $finalTotalAmount <= $discount ? 'Paid' : 'Unpaid',
                        ]);
                        Log::info("Created new billing", [
                            'BillingID' => $billing->BillingID,
                            'TotalAmount' => $billing->TotalAmount,
                            'Balance' => $billing->Balance,
                            'Discount' => $billing->Discount,
                            'BillingStatus' => $billing->BillingStatus,
                        ]);
                    } else {
                        if (isset($validated['total_amount']) || isset($validated['discount'])) {
                            $totalPayments = $billing->payments->sum('AmountPaid');
                            $billing->TotalAmount = $finalTotalAmount;
                            $billing->Discount = $discount;
                            $billing->Balance = max(0, $billing->TotalAmount - $billing->Discount - $totalPayments);
                            $billing->BillingStatus = $billing->Balance <= 0 ? 'Paid' : ($totalPayments > 0 ? 'Partially Paid' : 'Unpaid');
                            $billing->save();
                            Log::info("Updated existing billing with provided values", [
                                'BillingID' => $billing->BillingID,
                                'TotalAmount' => $billing->TotalAmount,
                                'Balance' => $billing->Balance,
                                'Discount' => $billing->Discount,
                                'BillingStatus' => $billing->BillingStatus,
                            ]);
                        }
                    }
                } else {
                    Log::info("No billing generated: Total cost is 0", [
                        'AppointmentID' => $appointment->AppointmentID,
                        'Status' => $appointment->AppointmentStatus,
                        'TotalCost' => $totalCost,
                    ]);
                }
                
            } catch (\Exception $e) {
                Log::error("Error in billing creation: " . $e->getMessage(), ['stack' => $e->getTraceAsString()]);
            }
        }
        
        $dentist = Dentist::with('user')->find($appointment->DentistID);
        $responseServices = (strtolower($appointment->AppointmentStatus) === 'completed')
            ? $appointment->servicesAvailed
            : $appointment->servicesAvailed->filter(function ($sa) {
                return $sa->Status === 'Completed';
            });
        
        $response = [
            'id' => $appointment->AppointmentID,
            'dentist_name' => $dentist && $dentist->user ? $dentist->user->FirstName . ' ' . $dentist->user->LastName : 'No dentist assigned',
            'status' => $appointment->AppointmentStatus,
            'patient_notes' => $appointment->PatientNote,
            'services' => $appointment->servicesAvailed->map(function ($sa) {
                return [
                    'ServiceAvailedID' => $sa->ServiceAvailedID,
                    'ServiceName' => $sa->service->ServiceName,
                    'Status' => $sa->Status,
                ];
            })->values()->toArray(),
            'requiresConfirmation' => $requiresConfirmation, // Add flag to response
        ];
        Log::info("Returning response", ['response' => $response]);
        return response()->json($response, 200);
    }

    public function getUpdatedAppointments()
    {
        if (!auth()->check()) {
            return response()->json([], 401);
        }

        $patientId = auth()->user()->patient ? auth()->user()->patient->PatientID : null;

        if (!$patientId) {
            return response()->json(['error' => 'Patient ID not found.'], 400);
        }

        $updatedAppointments = Appointment::with('dentist.user')
            ->where('PatientID', $patientId)
            ->whereIn('AppointmentStatus', ['confirmed', 'declined'])
            ->where('ViewedNotification', false)
            ->get();

        $appointmentsWithDetails = $updatedAppointments->map(function ($appointment) {
            $dentist = $appointment->dentist ? $appointment->dentist->user : null;
            $statusMessage = match ($appointment->AppointmentStatus) {
                'confirmed' => 'Your appointment has been confirmed!',
                'declined' => 'Your appointment has been declined.',
                default => 'Your appointment status has been updated.',
            };
            return [
                'AppointmentID' => $appointment->AppointmentID,
                'AppointmentDate' => $appointment->AppointmentDate,
                'AppointmentTime' => $appointment->AppointmentTime,
                'services' => $appointment->servicesAvailed->pluck('service.ServiceName')->implode(', '), // Update variable name
                'DentistName' => $dentist ? "{$dentist->FirstName} {$dentist->LastName}" : 'N/A',
                'StatusMessage' => $statusMessage,
            ];
        });

        return response()->json($appointmentsWithDetails);
    }

    public function markAsViewed($appointmentId)
    {
        $appointment = Appointment::find($appointmentId);

        if (!$appointment) {
            return response()->json(['error' => 'Appointment not found.'], 404);
        }

        $appointment->ViewedNotification = true;
        $appointment->save();

        return response()->json(['message' => 'Notification marked as viewed successfully.']);
    }

    public function assignDentist(Request $request)
    {
        try {
            \Log::info('Assign dentist request data:', $request->all());

            $validatedData = $request->validate([
                'AppointmentID' => 'required|integer|exists:appointments,AppointmentID',
                'UserID' => 'required|integer|exists:users,UserID',
            ]);

            $UserID = (int) $validatedData['UserID'];
            \Log::info('Validated UserID:', ['UserID' => $UserID]);

            $dentist = Dentist::where('UserID', $UserID)->first();
            if (!$dentist) {
                \Log::error('Dentist not found for UserID:', ['UserID' => $UserID]);
                return response()->json(['message' => 'Dentist not found'], 404);
            }

            $appointment = Appointment::find($validatedData['AppointmentID']);
            $date = $appointment->AppointmentDate;

            // Check day-off availability
            $dateTime = new \DateTime($date);
            $dayOfWeek = $dateTime->format('l');
            $dayOff = json_decode($dentist->DayOff, true);
            if (is_array($dayOff) && in_array($dayOfWeek, $dayOff)) {
                \Log::warning('Dentist unavailable on this date:', [
                    'UserID' => $UserID,
                    'DentistID' => $dentist->DentistID,
                    'Date' => $date,
                    'DayOfWeek' => $dayOfWeek,
                ]);
                return response()->json(['message' => "Dentist is unavailable on {$dayOfWeek}"], 400);
            }

            $appointment->DentistID = $dentist->DentistID;
            $appointment->save();

            \Log::info('Dentist assigned successfully:', [
                'AppointmentID' => $appointment->AppointmentID,
                'DentistID' => $appointment->DentistID,
                'UserID' => $UserID
            ]);

            return response()->json(['message' => 'Dentist assigned successfully!']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error in assignDentist:', $e->errors());
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            \Log::error('Error in assignDentist: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to assign dentist: ' . $e->getMessage()], 500);
        }
    }

    public function getDentistAppointments(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    
        $dentist = auth()->user()->dentist;
        if (!$dentist) {
            return response()->json(['error' => 'You are not assigned as a dentist.'], 403);
        }
    
        $appointments = Appointment::where('DentistID', $dentist->DentistID)
            ->orderBy('AppointmentDate', 'asc')
            ->with(['patient.user', 'servicesAvailed.service'])
            ->get();
    
        $formattedAppointments = $appointments->map(function ($appointment) {
            $services = $appointment->servicesAvailed->map(function ($ServicesAvailed) {
                return $ServicesAvailed->service->ServiceName;
            })->toArray();
    
            // Calculate end time based on number of services (1 hour per service)
            $serviceCount = count($services);
            $startDateTime = Carbon::createFromFormat(
                'Y-m-d H:i:s',
                $appointment->AppointmentDate . ' ' . $appointment->AppointmentTime
            );
            $endDateTime = $startDateTime->copy()->addHours($serviceCount);
    
            return [
                'AppointmentID' => $appointment->AppointmentID,
                'AppointmentDate' => $appointment->AppointmentDate,
                'AppointmentTime' => $appointment->AppointmentTime,
                'EndTime' => $endDateTime->format('H:i:s'), // e.g., "13:00:00"
                'Services' => $services,
                'AppointmentStatus' => $appointment->AppointmentStatus,
                'PatientName' => $appointment->patient ? "{$appointment->patient->user->FirstName} {$appointment->patient->user->LastName}" : 'N/A',
                'PatientNote' => $appointment->PatientNote,
            ];
        });
    
        return response()->json($formattedAppointments);
    }

    public function getHrAppointments() {
        Log::info('Fetching HR appointments');
        
        $appointments = Appointment::with(['patient.user', 'dentist.user', 'servicesAvailed.service', 'servicesAvailed.treatmentProgress'])
            ->get();
            
        Log::info('Raw appointments data:', ['appointments' => $appointments->toArray()]);
        
        if ($appointments->isEmpty()) {
            Log::warning('No appointments found');
            return response()->json([]);
        }
        
        $formatted = $appointments->map(function ($appointment) {
            Log::info("Processing Appointment {$appointment->AppointmentID}", [
                'servicesAvailed' => $appointment->servicesAvailed->toArray(),
            ]);
            
            $visitProgress = null;
            $multiVisitService = $appointment->servicesAvailed->first(function ($sa) {
                return $sa->service->IsMultiVisit && $sa->treatmentProgress;
            });
            if ($multiVisitService && $multiVisitService->treatmentProgress) {
                $visitProgress = [
                    'TreatmentProgressID' => $multiVisitService->treatmentProgress->TreatmentProgressID,
                    'TreatmentName' => $multiVisitService->treatmentProgress->TreatmentName,
                    'VisitCount' => $multiVisitService->treatmentProgress->VisitCount,
                    'StartDate' => $multiVisitService->treatmentProgress->StartDate ? $multiVisitService->treatmentProgress->StartDate->toDateString() : null,
                    'EndDate' => $multiVisitService->treatmentProgress->EndDate ? $multiVisitService->treatmentProgress->EndDate->toDateString() : null,
                    'Status' => $multiVisitService->treatmentProgress->Status ?? 'In Progress',
                ];
            }
            
            $normalizedStatus = match (strtolower($appointment->AppointmentStatus)) {
                'pending' => 'Pending',
                'confirmed' => 'Confirmed',
                'completed' => 'Completed',
                'cancelled' => 'Cancelled',
                'declined' => 'Declined',
                default => 'Pending',
            };
            
            $eventClass = strtolower($normalizedStatus);
    
            $formattedAppointment = [
                'AppointmentID' => $appointment->AppointmentID,
                'patient_name' => $appointment->patient && $appointment->patient->user
                    ? $appointment->patient->user->FirstName . ' ' . $appointment->patient->user->LastName
                    : 'N/A',
                'dentist_name' => $appointment->dentist && $appointment->dentist->user
                    ? $appointment->dentist->user->FirstName . ' ' . $appointment->dentist->user->LastName
                    : 'No dentist assigned',
                'DentistID' => $appointment->DentistID,
                'UserID' => $appointment->dentist ? $appointment->dentist->UserID : null,
                'AppointmentDate' => $appointment->AppointmentDate,
                'AppointmentTime' => $appointment->AppointmentTime,
                'PatientNote' => $appointment->PatientNote ?? 'No notes available',
                'AppointmentStatus' => $normalizedStatus,
                'services' => $appointment->servicesAvailed->map(function ($sa) {
                    return [
                        'ServiceAvailedID' => $sa->ServiceAvailedID,
                        'ServiceName' => $sa->service->ServiceName,
                        'Status' => $sa->Status ?? 'Pending',
                        'IsMultiVisit' => $sa->service->IsMultiVisit,
                        'TreatmentProgressID' => $sa->TreatmentProgressID,
                    ];
                })->toArray(),
                'visitProgress' => $visitProgress,
                'classNames' => [$eventClass],
            ];
            
            Log::info("Formatted Appointment {$appointment->AppointmentID}", ['formatted' => $formattedAppointment]);
            
            return $formattedAppointment;
        })->toArray();
        
        Log::info('Final formatted appointments:', ['formatted' => $formatted]);
        
        return response()->json($formatted);
    }

    public function getOwnerAppointments(Request $request)
{
    \Log::info('Fetching Owner appointments');

    try {
        // Fetch only Pending appointments for the Owner role
        $appointments = Appointment::with(['patient.user', 'dentist.user', 'servicesAvailed.service'])
            ->where('AppointmentStatus', 'Pending')
            ->orderBy('created_at', 'desc')
            ->get();

        \Log::info('Pending Appointments Count:', ['count' => $appointments->count()]);

        $appointmentsWithDetails = $appointments->map(function ($appointment) {
            $patient = $appointment->patient ? $appointment->patient->user : null;
            $dentist = $appointment->dentist ? $appointment->dentist->user : null;
            $dentistName = $appointment->DentistID === null
                ? 'Any Dentist'
                : ($dentist ? "Dr. {$dentist->FirstName} {$dentist->LastName}" : 'N/A');

            $services = $appointment->servicesAvailed->map(function ($serviceAvailed) {
                return $serviceAvailed->service->ServiceName;
            })->toArray();

            return [
                'AppointmentID' => $appointment->AppointmentID,
                'PatientName' => $patient ? "{$patient->FirstName} {$patient->LastName}" : 'N/A',
                'DentistName' => $dentistName,
                'UserID' => $dentist ? $dentist->UserID : null,
                'Services' => $services,
                'AppointmentDate' => $appointment->AppointmentDate,
                'AppointmentTime' => $appointment->AppointmentTime,
                'PatientNote' => $appointment->PatientNote ?? 'No notes available',
                'Status' => $appointment->AppointmentStatus,
            ];
        });

        \Log::info('Formatted Owner Appointments:', ['appointments' => $appointmentsWithDetails->toArray()]);

        return response()->json($appointmentsWithDetails);
    } catch (\Exception $e) {
        \Log::error('Error fetching Owner appointments:', ['error' => $e->getMessage()]);
        return response()->json(['success' => false, 'message' => 'Failed to fetch appointments'], 500);
    }
}    

public function getOwnerCalendarAppointments(Request $request)
{
    Log::info('Fetching Owner calendar appointments');

    try {
        // Fetch all appointments for the Owner calendar
        $appointments = Appointment::with(['patient.user', 'dentist.user', 'servicesAvailed.service', 'servicesAvailed.treatmentProgress'])
            ->orderBy('created_at', 'desc')
            ->get();

        Log::info('Appointments Count:', ['count' => $appointments->count()]);

        if ($appointments->isEmpty()) {
            Log::warning('No appointments found');
            return response()->json([]);
        }

        $formatted = $appointments->map(function ($appointment) {
            Log::info("Processing Appointment {$appointment->AppointmentID}", [
                'servicesAvailed' => $appointment->servicesAvailed->toArray(),
            ]);

            $visitProgress = null;
            $multiVisitService = $appointment->servicesAvailed->first(function ($sa) {
                return $sa->service->IsMultiVisit && $sa->treatmentProgress;
            });
            if ($multiVisitService && $multiVisitService->treatmentProgress) {
                $visitProgress = [
                    'TreatmentProgressID' => $multiVisitService->treatmentProgress->TreatmentProgressID,
                    'TreatmentName' => $multiVisitService->treatmentProgress->TreatmentName,
                    'VisitCount' => $multiVisitService->treatmentProgress->VisitCount,
                    'StartDate' => $multiVisitService->treatmentProgress->StartDate ? $multiVisitService->treatmentProgress->StartDate->toDateString() : null,
                    'EndDate' => $multiVisitService->treatmentProgress->EndDate ? $multiVisitService->treatmentProgress->EndDate->toDateString() : null,
                    'Status' => $multiVisitService->treatmentProgress->Status ?? 'In Progress',
                ];
            }

            $normalizedStatus = match (strtolower($appointment->AppointmentStatus)) {
                'pending' => 'Pending',
                'confirmed' => 'Confirmed',
                'completed' => 'Completed',
                'cancelled' => 'Cancelled',
                'declined' => 'Declined',
                default => 'Pending',
            };

            $eventClass = strtolower($normalizedStatus);

            $formattedAppointment = [
                'AppointmentID' => $appointment->AppointmentID,
                'patient_name' => $appointment->patient && $appointment->patient->user
                    ? $appointment->patient->user->FirstName . ' ' . $appointment->patient->user->LastName
                    : 'N/A',
                'dentist_name' => $appointment->dentist && $appointment->dentist->user
                    ? $appointment->dentist->user->FirstName . ' ' . $appointment->dentist->user->LastName
                    : 'No dentist assigned',
                'DentistID' => $appointment->DentistID,
                'UserID' => $appointment->dentist ? $appointment->dentist->UserID : null,
                'AppointmentDate' => $appointment->AppointmentDate,
                'AppointmentTime' => $appointment->AppointmentTime,
                'PatientNote' => $appointment->PatientNote ?? 'No notes available',
                'AppointmentStatus' => $normalizedStatus,
                'services' => $appointment->servicesAvailed->map(function ($sa) {
                    return [
                        'ServiceAvailedID' => $sa->ServiceAvailedID,
                        'ServiceName' => $sa->service->ServiceName,
                        'Status' => $sa->Status ?? 'Pending',
                        'IsMultiVisit' => $sa->service->IsMultiVisit,
                        'TreatmentProgressID' => $sa->TreatmentProgressID,
                    ];
                })->toArray(),
                'visitProgress' => $visitProgress,
                'classNames' => [$eventClass],
            ];

            Log::info("Formatted Appointment {$appointment->AppointmentID}", ['formatted' => $formattedAppointment]);

            return $formattedAppointment;
        })->toArray();

        Log::info('Final formatted appointments:', ['formatted' => $formatted]);

        return response()->json($formatted);
    } catch (\Exception $e) {
        Log::error('Error fetching Owner calendar appointments:', ['error' => $e->getMessage()]);
        return response()->json(['success' => false, 'message' => 'Failed to fetch appointments'], 500);
    }
}

    public function updateTreatmentProgress(Request $request)
    {
        try {
            $request->validate([
                'TreatmentProgressID' => 'required|exists:treatment_progress,TreatmentProgressID',
                'Status' => 'required|in:In Progress,Completed,Cancelled',
                'EndDate' => 'nullable|date',
            ]);
    
            $treatmentProgress = TreatmentProgress::findOrFail($request->TreatmentProgressID);
            $treatmentProgress->Status = $request->Status;
    
            if ($request->Status === 'Completed' && !$treatmentProgress->EndDate) {
                $treatmentProgress->EndDate = now()->toDateString();
            } elseif ($request->Status !== 'Completed' && $treatmentProgress->EndDate) {
                $treatmentProgress->EndDate = null;
            }
    
            $treatmentProgress->save();
    
            \Log::info('Updated TreatmentProgress', [
                'TreatmentProgressID' => $treatmentProgress->TreatmentProgressID,
                'Status' => $treatmentProgress->Status,
                'EndDate' => $treatmentProgress->EndDate ? $treatmentProgress->EndDate->toDateString() : 'NULL',
            ]);
    
            return response()->json(['success' => true, 'message' => 'Treatment progress updated successfully']);
        } catch (\Exception $e) {
            \Log::error('Error updating treatment progress: ' . $e->getMessage() . ' | Stack: ' . $e->getTraceAsString());
            return response()->json(['success' => false, 'message' => 'Failed to update treatment progress: ' . $e->getMessage()], 500);
        }
    }

    public function getPatientAppointments($patientId)
    {
        try {
            $appointments = Appointment::where('PatientID', $patientId)
                ->select('AppointmentID', 'AppointmentDate', 'AppointmentTime', 'AppointmentStatus')
                ->orderBy('AppointmentDate', 'asc')
                ->get();
            return response()->json($appointments);
        } catch (\Exception $e) {
            \Log::error('Error fetching patient appointments: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to fetch appointments'], 500);
        }
    }

    public function storeHrConfirmedAppointment(Request $request)
    {
      try {
        \Log::info('HR confirmed appointment creation request data:', $request->all());
    
        $request->validate([
            'AppointmentDate' => 'required|date|after_or_equal:today',
            'AppointmentTime' => 'required',
            'services' => 'required|array|min:1',
            'services.*' => 'integer|exists:services,ServiceID',
            'UserID' => 'nullable|exists:users,UserID',
            'PatientID' => 'required|exists:patients,PatientID',
            'PatientNote' => 'nullable|string',
        ]);
        
        $UserID = $request->input('UserID');
        \Log::info('Received UserID:', ['UserID' => $UserID, 'Type' => gettype($UserID)]);
        
        $DentistID = null;
        if ($UserID) {
            $dentist = Dentist::where('UserID', $UserID)->first();
            \Log::info('Dentist lookup result:', ['UserID' => $UserID, 'DentistFound' => !is_null($dentist)]);
            if (!$dentist) {
                return response()->json(['success' => false, 'message' => 'Dentist not found.'], 400);
            }
            $DentistID = $dentist->DentistID;
            $dayOff = json_decode($dentist->DayOff, true);
            $appointmentDay = date('l', strtotime($request->AppointmentDate));
            if (is_array($dayOff) && in_array($appointmentDay, $dayOff)) {
                return response()->json(['success' => false, 'message' => 'The selected dentist is unavailable on the chosen date.'], 400);
            }
        }
        
        // Check if the date is blocked
        $appointmentDate = $request->input('AppointmentDate');
        if ($this->isDateBlocked($appointmentDate, $DentistID)) {
            return response()->json([
                'success' => false,
                'message' => 'This date is blocked. Please choose another date.',
            ], 400);
        }
        
        // For same-day bookings, ensure the selected time is in the future
        $isToday = Carbon::parse($appointmentDate)->isToday();
        if ($isToday) {
            $appointmentTime = Carbon::createFromFormat('H:i', $request->AppointmentTime);
            if ($appointmentTime->lessThanOrEqualTo(Carbon::now())) {
                return response()->json(['success' => false, 'message' => 'Selected time is in the past.'], 400);
            }
        }

        $PatientId = $request->input('PatientID');
    
        $appointment = Appointment::create([
          'AppointmentDate' => $request->AppointmentDate,
          'AppointmentTime' => $request->AppointmentTime,
          'DentistID' => $DentistID, // Save the mapped DentistID
          'PatientID' => $PatientId,
          'AppointmentStatus' => 'Confirmed',
          'PatientNote' => $request->PatientNote,
        ]);

        // Add logging for HR-confirmed appointment
        $hrUser = auth()->user();
        $patient = \App\Models\Patient::where('PatientID', $PatientId)->first();
        $patientUser = $patient ? \App\Models\User::find($patient->UserID) : null;
        $dentistName = $DentistID 
            ? "Dr. {$dentist->user->FirstName} {$dentist->user->LastName}" 
            : "Any Dentist";
        
        if ($patientUser && $hrUser) {
            event(new UserActionOccurred(
                $patientUser->UserID,
                'Appointment Booked (HR)',
                "HR {$hrUser->FirstName} {$hrUser->LastName} has booked an appointment for " .
                "Patient {$patientUser->FirstName} {$patientUser->LastName} on " . 
                date('F j, Y g:i A', strtotime($appointment->AppointmentDate . ' ' . $appointment->AppointmentTime)) . 
                " with {$dentistName}"
            ));
        } else {
            // Fallback log if patient user is missing
            \Log::warning('Could not log HR appointment booking due to missing patient user', [
                'PatientID' => $PatientId,
                'AppointmentID' => $appointment->AppointmentID
            ]);
        }
    
        \Log::info('Appointment created:', ['AppointmentID' => $appointment->AppointmentID, 'DentistID' => $appointment->DentistID]);
    
        $serviceIDs = $request->input('services');
    
        foreach ($serviceIDs as $serviceID) {
          $service = Service::find($serviceID);
          $serviceAvailed = ServicesAvailed::create([
            'AppointmentID' => $appointment->AppointmentID,
            'ServiceID' => $serviceID,
            'Status' => 'Pending',
          ]);
    
          \Log::info('Created ServicesAvailed record:', [
            'ServiceAvailedID' => $serviceAvailed->ServiceAvailedID,
            'AppointmentID' => $serviceAvailed->AppointmentID,
            'ServiceID' => $serviceAvailed->ServiceID,
          ]);
    
          if ($service->IsMultiVisit) {
            $existingProgress = TreatmentProgress::where('PatientID', $appointment->PatientID)
              ->where('TreatmentName', $service->ServiceName)
              ->where('Status', '!=', 'Completed')
              ->first();
    
            if ($existingProgress) {
              $visitCount = ServicesAvailed::where('TreatmentProgressID', $existingProgress->TreatmentProgressID)
                ->join('appointments', 'services_availed.AppointmentID', '=', 'appointments.AppointmentID')
                ->distinct('appointments.AppointmentID')
                ->count('appointments.AppointmentID');
              $existingProgress->VisitCount = $visitCount;
              $existingProgress->save();
              $serviceAvailed->TreatmentProgressID = $existingProgress->TreatmentProgressID;
              $serviceAvailed->save();
    
              \Log::info("Updated existing TreatmentProgress VisitCount", [
                'PatientID' => $appointment->PatientID,
                'TreatmentProgressID' => $existingProgress->TreatmentProgressID,
                'NewVisitCount' => $visitCount,
                'StartDate' => $existingProgress->StartDate->toDateString(),
                'EndDate' => $existingProgress->EndDate ? $existingProgress->EndDate->toDateString() : 'NULL',
                'ServiceAvailedID' => $serviceAvailed->ServiceAvailedID,
                'UpdatedTreatmentProgressID' => $serviceAvailed->TreatmentProgressID,
              ]);
            } else {
              $treatmentProgress = TreatmentProgress::create([
                'PatientID' => $appointment->PatientID,
                'TreatmentName' => $service->ServiceName,
                'StartDate' => $appointment->AppointmentDate,
                'VisitCount' => 1,
                'EndDate' => null,
                'Status' => 'In Progress',
              ]);
    
              \Log::info('Created new TreatmentProgress record:', [
                'TreatmentProgressID' => $treatmentProgress->TreatmentProgressID,
                'PatientID' => $treatmentProgress->PatientID,
                'TreatmentName' => $treatmentProgress->TreatmentName,
              ]);
    
              $serviceAvailed->TreatmentProgressID = $treatmentProgress->TreatmentProgressID;
              $serviceAvailed->save();
    
              \Log::info("Updated ServicesAvailed with TreatmentProgressID", [
                'ServiceAvailedID' => $serviceAvailed->ServiceAvailedID,
                'TreatmentProgressID' => $serviceAvailed->TreatmentProgressID,
              ]);
            }
          }
        }
    
        return response()->json([
          'success' => true,
          'message' => 'Appointment booked successfully!',
          'appointment' => [
            'AppointmentID' => $appointment->AppointmentID,
            'AppointmentDate' => $appointment->AppointmentDate,
            'AppointmentTime' => $appointment->AppointmentTime,
            'PatientNote' => $appointment->PatientNote,
            'AppointmentStatus' => $appointment->AppointmentStatus,
            'DentistID' => $appointment->DentistID,
            'services' => $serviceIDs,
          ],
        ], 201);
      } catch (\Exception $e) {
        \Log::error('Error booking HR confirmed appointment: ' . $e->getMessage() . ' | Stack: ' . $e->getTraceAsString());
        return response()->json(['success' => false, 'message' => 'Failed to book appointment: ' . $e->getMessage()], 500);
      }
    }

    public function cancelPatientAppointment(Request $request, $appointmentId) {
        try {
            \Log::info("Patient attempting to cancel appointment", ['AppointmentID' => $appointmentId]);
        
            $appointment = Appointment::with(['servicesAvailed.service', 'servicesAvailed.treatmentProgress'])
                ->find($appointmentId);
            if (!$appointment) {
                \Log::warning("Appointment not found", ['AppointmentID' => $appointmentId]);
                return response()->json(['success' => false, 'message' => 'Appointment not found.'], 404);
            }
        
            $patient = auth()->user()->patient;
            if (!$patient || $appointment->PatientID !== $patient->PatientID) {
                \Log::warning("Unauthorized cancellation attempt", [
                    'AppointmentID' => $appointmentId,
                    'PatientID' => $patient ? $patient->PatientID : 'N/A',
                ]);
                return response()->json(['success' => false, 'message' => 'Unauthorized to cancel this appointment.'], 403);
            }
        
            if ($appointment->AppointmentStatus !== 'Pending') {
                \Log::warning("Cannot cancel appointment: Not in Pending status", [
                    'AppointmentID' => $appointmentId,
                    'CurrentStatus' => $appointment->AppointmentStatus,
                ]);
                return response()->json(['success' => false, 'message' => 'Only Pending appointments can be cancelled.'], 400);
            }
        
            $appointment->AppointmentStatus = 'Cancelled';
            $appointment->save();
        
            \Log::info("Appointment status updated to Cancelled", ['AppointmentID' => $appointmentId]);
    
            $user = auth()->user();
            $dentistName = $appointment->dentist 
                ? "Dr. {$appointment->dentist->user->FirstName} {$appointment->dentist->user->LastName}" 
                : "Any Dentist";
            event(new UserActionOccurred(
                auth()->id(),
                'Appointment Cancelled',
                "Patient {$user->FirstName} {$user->LastName} cancelled their appointment on " . 
                date('F j, Y g:i A', strtotime($appointment->AppointmentDate . ' ' . $appointment->AppointmentTime)) . 
                " with {$dentistName}"
            ));
        
            $servicesAvailed = $appointment->servicesAvailed;
            if ($servicesAvailed->isNotEmpty()) {
                foreach ($servicesAvailed as $serviceAvailed) {
                    $oldStatus = $serviceAvailed->Status;
                    $serviceAvailed->Status = 'Cancelled';
                    $serviceAvailed->save();
        
                    \Log::info("Updated ServicesAvailed status to Cancelled", [
                        'ServiceAvailedID' => $serviceAvailed->ServiceAvailedID,
                        'OldStatus' => $oldStatus,
                        'NewStatus' => $serviceAvailed->Status,
                    ]);
        
                    if ($serviceAvailed->service->IsMultiVisit && $serviceAvailed->treatmentProgress) {
                        $treatmentProgress = $serviceAvailed->treatmentProgress;
                        $oldTreatmentStatus = $treatmentProgress->Status;
                        $treatmentProgress->Status = 'Cancelled';
                        $treatmentProgress->EndDate = now()->toDateString();
                        $treatmentProgress->save();
        
                        \Log::info("Updated TreatmentProgress status to Cancelled", [
                            'TreatmentProgressID' => $treatmentProgress->TreatmentProgressID,
                            'OldStatus' => $oldTreatmentStatus,
                            'NewStatus' => $treatmentProgress->Status,
                            'EndDate' => $treatmentProgress->EndDate,
                        ]);
                    }
                }
            } else {
                \Log::warning("No services_availed records found for appointment", ['AppointmentID' => $appointmentId]);
            }
        
            \Log::info("Appointment cancellation completed successfully", ['AppointmentID' => $appointmentId]);
        
            return response()->json(['success' => true, 'message' => 'Appointment cancelled successfully.']);
        } catch (\Exception $e) {
            \Log::error("Error cancelling appointment: " . $e->getMessage(), [
                'AppointmentID' => $appointmentId,
                'Stack' => $e->getTraceAsString(),
            ]);
            return response()->json(['success' => false, 'message' => 'Failed to cancel appointment: ' . $e->getMessage()], 500);
        }
    }

    public function getAvailableTimes(Request $request)
    {
        try {
            $request->validate([
                'date' => 'required|date|after_or_equal:today',
            ]);
            
            $date = $request->input('date');
            $startTime = Carbon::createFromTime(9, 0); // 9:00 AM
            $endTime = Carbon::createFromTime(17, 0);  // 5:00 PM
            $interval = 60; // 1-hour increments (in minutes)
            
            // For same-day bookings, adjust start time to exclude past slots
            $isToday = Carbon::parse($date)->isToday();
            if ($isToday) {
                $currentTime = Carbon::now();
                $startTime = $currentTime->greaterThan($startTime) ? $currentTime->copy()->addHour()->startOfHour() : $startTime;
                if ($startTime->greaterThanOrEqualTo($endTime)) {
                    return response()->json(['available_times' => [], 'message' => 'No available time slots for today.']);
                }
            }
            
            // Fetch all appointments for the date with service counts, excluding Declined and Cancelled
            $appointments = Appointment::where('AppointmentDate', $date)
                ->whereNotIn('AppointmentStatus', ['Declined', 'Cancelled'])
                ->with('servicesAvailed')
                ->get()
                ->map(function ($appointment) {
                    $serviceCount = $appointment->servicesAvailed->count();
                    return [
                        'start' => Carbon::parse($appointment->AppointmentTime),
                        'duration' => $serviceCount,
                    ];
                });
            
            // Calculate slot usage per time
            $slotUsage = [];
            $currentTime = $startTime->copy();
            while ($currentTime->lessThanOrEqualTo($endTime)) {
                $timeStr = $currentTime->format('H:i');
                $directBookings = $appointments->where('start.format', 'H:i', $timeStr)->count();
                $overlaps = $appointments->filter(function ($appt) use ($currentTime) {
                    $endTime = $appt['start']->copy()->addHours($appt['duration']);
                    return $appt['start']->lessThan($currentTime) && $endTime->greaterThan($currentTime);
                })->count();
                $slotUsage[$timeStr] = $directBookings + $overlaps;
                $currentTime->addMinutes($interval);
            }
            
            // Determine available times
            $availableTimes = [];
            $currentTime = $startTime->copy();
            while ($currentTime->lessThanOrEqualTo($endTime)) {
                $timeStr = $currentTime->format('H:i');
                if ($slotUsage[$timeStr] < 5) {
                    $availableTimes[] = $timeStr;
                }
                $currentTime->addMinutes($interval);
            }
            
            return response()->json(['available_times' => $availableTimes]);
        } catch (\Exception $e) {
            Log::error('Error fetching available times: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to fetch available times'], 500);
        }
    }

    public function checkDentistAvailability(Request $request)
{
    try {
        $request->validate([
            'dentist_id' => 'required|exists:dentists,DentistID',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'service_count' => 'required|integer|min:1|max:3',
        ]);
        
        $dentistId = $request->input('dentist_id');
        $date = $request->input('date');
        $time = $request->input('time');
        $serviceCount = (int) $request->input('service_count');
        $durationHours = $serviceCount;
        
        $dentist = Dentist::find($dentistId);
        $dayOff = json_decode($dentist->DayOff, true);
        $appointmentDay = Carbon::parse($date)->format('l');
        if (is_array($dayOff) && in_array($appointmentDay, $dayOff)) {
            return response()->json(['is_available' => false, 'message' => 'Dentist is off on this day']);
        }
        
        $startTime = Carbon::createFromFormat('Y-m-d H:i', "$date $time");
        $endTime = $startTime->copy()->addHours($durationHours);
        
        // For same-day bookings, ensure the selected time is in the future
        $isToday = Carbon::parse($date)->isToday();
        if ($isToday && $startTime->isPast()) {
            return response()->json(['is_available' => false, 'message' => 'Selected time is in the past.']);
        }
        
        $appointments = Appointment::withCount('servicesAvailed')
            ->where('DentistID', $dentistId)
            ->where('AppointmentDate', $date)
            ->whereNotIn('AppointmentStatus', ['Cancelled', 'Declined'])
            ->get();
        
        $conflictingAppointments = $appointments->filter(function ($appt) use ($startTime, $endTime) {
            $apptStart = Carbon::createFromFormat('H:i:s', $appt->AppointmentTime);
            $apptEnd = $apptStart->copy()->addHours($appt->services_availed_count ?? 1);
            return $startTime->lessThan($apptEnd) && $endTime->greaterThan($apptStart);
        });
        
        return response()->json(['is_available' => $conflictingAppointments->isEmpty()]);

    
    } catch (\Exception $e) {
        Log::error('Error checking dentist availability: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Failed to check availability'], 500);
    }
}


    public function filterAvailableTimes(Request $request)
    {
        try {
            Log::info('Received filterAvailableTimes request:', $request->all());

            $request->validate([
                'date' => 'required|date|after_or_equal:today',
                'times' => 'required|array',
                'times.*' => 'string|regex:/^\d{1,2}:\d{2}$/',
            ]);
            
            $date = $request->input('date');
            $times = $request->input('times');
            
            // Exclude Declined and Cancelled appointments
            $appointments = Appointment::where('AppointmentDate', $date)
                ->whereNotIn('AppointmentStatus', ['Declined', 'Cancelled'])
                ->with(['servicesAvailed' => function ($query) {
                    $query->select('AppointmentID', 'ServiceID');
                }])
                ->get();
            
            $appointmentData = $appointments->map(function ($appointment) {
                $serviceCount = $appointment->servicesAvailed ? $appointment->servicesAvailed->count() : 0;
                $time = $appointment->AppointmentTime;
            
                $time = preg_match('/^([0-9]{1,2}):([0-9]{2})$/', $time, $matches)
                    ? sprintf('%02d:%02d', $matches[1], $matches[2])
                    : $time;
            
                try {
                    $start = Carbon::createFromFormat('H:i', $time);
                } catch (\Exception $e) {
                    try {
                        $start = Carbon::createFromFormat('H:i:s', $time);
                    } catch (\Exception $e) {
                        Log::warning("Invalid AppointmentTime format: $time", ['error' => $e->getMessage()]);
                        return null;
                    }
                }
            
                return [
                    'start' => $start,
                    'duration' => $serviceCount ?: 1,
                ];
            })->filter();
            
            $isToday = Carbon::parse($date)->isToday();
            $currentTime = Carbon::now();
            
            $timeSlots = [];
            foreach ($times as $time) {
                try {
                    $carbonTime = Carbon::createFromFormat('H:i', $time);
                    // Skip past times for same-day bookings
                    if ($isToday && $carbonTime->lessThanOrEqualTo($currentTime)) {
                        $timeSlots[] = [
                            'time' => $time,
                            'is_available' => false,
                        ];
                        continue;
                    }
            
                    $formattedTime = $carbonTime->format('H:i');
                    $directBookings = $appointmentData->filter(function ($appt) use ($formattedTime) {
                        return $appt['start']->format('H:i') === $formattedTime;
                    })->count();
            
                    $overlaps = $appointmentData->filter(function ($appt) use ($carbonTime) {
                        $endTime = $appt['start']->copy()->addHours($appt['duration']);
                        return $appt['start']->lessThan($carbonTime) && $endTime->greaterThan($carbonTime);
                    })->count();
            
                    $totalUsage = $directBookings + $overlaps;
                    $isAvailable = $totalUsage < 5;
            
                    $timeSlots[] = [
                        'time' => $time,
                        'is_available' => $isAvailable,
                    ];
                } catch (\Exception $e) {
                    Log::warning("Failed to parse time: $time", ['error' => $e->getMessage()]);
                    $timeSlots[] = [
                        'time' => $time,
                        'is_available' => false,
                    ];
                }
            }
            
            return response()->json(['time_slots' => $timeSlots]);
        } catch (\Exception $e) {
            Log::error('Error filtering available times: ' . $e->getMessage(), ['stack' => $e->getTraceAsString()]);
            return response()->json(['success' => false, 'message' => 'Failed to filter available times'], 500);
        }
    }

    public function getConsentForm(Request $request, $appointmentId)
    {
        try {
            \Log::info("Fetching consent form for AppointmentID: {$appointmentId}");
    
            // Ensure the user is authenticated
            if (!auth()->check()) {
                \Log::warning("Unauthorized access attempt to consent form", ['AppointmentID' => $appointmentId]);
                return response()->json(['success' => false, 'message' => 'Unauthorized. Please log in.'], 401);
            }
    
            // Find the appointment
            $appointment = Appointment::find($appointmentId);
            if (!$appointment) {
                \Log::warning("Appointment not found", ['AppointmentID' => $appointmentId]);
                return response()->json(['success' => false, 'message' => 'Appointment not found.'], 404);
            }
    
            // Check user permissions
            $user = auth()->user();
            $isPatient = $user->patient && $user->patient->PatientID === $appointment->PatientID;
            $isDentist = $user->dentist && $user->dentist->DentistID === $appointment->DentistID;
    
            // Check if the user has a userAccount and get the UserType
            $userType = $user->userAccount ? $user->userAccount->UserType : null;
            $isAuthorizedAdmin = $userType && in_array(
                trim(strtolower($userType)),
                array_map('strtolower', ['HR', 'HRAdmin', 'Owner']) // Added 'Owner'
            );
    
            \Log::info("Permission check details", [
                'UserID' => $user->UserID,
                'UserType' => $userType,
                'PatientID' => $user->patient ? $user->patient->PatientID : 'N/A',
                'DentistID' => $user->dentist ? $user->dentist->DentistID : 'N/A',
                'AppointmentPatientID' => $appointment->PatientID,
                'AppointmentDentistID' => $appointment->DentistID,
                'isPatient' => $isPatient,
                'isDentist' => $isDentist,
                'isAuthorizedAdmin' => $isAuthorizedAdmin,
            ]);
    
            if (!$isPatient && !$isDentist && !$isAuthorizedAdmin) {
                \Log::warning("Unauthorized access to consent form", [
                    'AppointmentID' => $appointmentId,
                    'UserID' => $user->UserID,
                    'UserType' => $userType,
                ]);
                return response()->json(['success' => false, 'message' => 'You do not have permission to access this consent form.'], 403);
            }
    
            // Query the dental_forms table for the consent form
            $consentForm = DB::table('dental_forms')
                ->where('AppointmentID', $appointmentId)
                ->where('FileName', 'Consent Form')
                ->first();
    
            if (!$consentForm) {
                \Log::warning("Consent form not found in dental_forms", ['AppointmentID' => $appointmentId]);
                return response()->json(['success' => false, 'message' => 'Consent form not found for this appointment.'], 404);
            }
    
            // Ensure the FileContent is a valid binary (BLOB)
            if (empty($consentForm->FileContent)) {
                \Log::error("Consent form FileContent is empty", ['DentalFormID' => $consentForm->DentalFormID]);
                return response()->json(['success' => false, 'message' => 'Consent form file content is missing.'], 500);
            }
    
            // Log successful retrieval
            \Log::info("Consent form retrieved successfully", [
                'DentalFormID' => $consentForm->DentalFormID,
                'AppointmentID' => $appointmentId,
                'FileType' => $consentForm->FileType,
            ]);
    
            // Return the PDF as a downloadable response
            return response($consentForm->FileContent, 200)
                ->header('Content-Type', $consentForm->FileType ?? 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="consent_form_' . $appointmentId . '.pdf"')
                ->header('Content-Length', strlen($consentForm->FileContent));
    
        } catch (\Exception $e) {
            \Log::error("Error fetching consent form: " . $e->getMessage(), [
                'AppointmentID' => $appointmentId,
                'Stack' => $e->getTraceAsString(),
            ]);
            return response()->json(['success' => false, 'message' => 'Failed to fetch consent form: ' . $e->getMessage()], 500);
        }
    }
        
    public function getMyTreatmentHistory(Request $request)
    {
        try {
            // Ensure the user is authenticated
            if (!auth()->check()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
            }
    
            $patient = auth()->user()->patient;
            if (!$patient) {
                \Log::warning('No patient record found for authenticated user', ['user_id' => auth()->id()]);
                return response()->json(['success' => false, 'message' => 'Patient record not found'], 403);
            }
    
            $patientId = $patient->PatientID;
    
            // Fetch appointments with related data
            $appointments = Appointment::where('PatientID', $patientId)
                ->with([
                    'dentist.user' => function ($query) {
                        $query->select('UserID', 'FirstName', 'LastName');
                    },
                    'servicesAvailed.service' => function ($query) {
                        $query->select('ServiceID', 'ServiceName');
                    }
                ])
                ->orderBy('AppointmentDate', 'desc')
                ->get();
    
            // Map the data to the required format
            $treatmentHistory = $appointments->map(function ($appointment) {
                $dentistName = $appointment->dentist && $appointment->dentist->user
                    ? "{$appointment->dentist->user->FirstName} {$appointment->dentist->user->LastName}"
                    : 'N/A';
    
                $services = $appointment->servicesAvailed->map(function ($sa) {
                    return [
                        'ServiceName' => $sa->service->ServiceName ?? 'N/A',
                        'Status' => $sa->Status ?? 'Pending',
                        'ToothNumber' => $sa->ToothNumber ?? null,
                    ];
                })->toArray();
    
                return [
                    'AppointmentID' => $appointment->AppointmentID,
                    'AppointmentDate' => $appointment->AppointmentDate,
                    'AppointmentTime' => $appointment->AppointmentTime,
                    'DentistName' => $dentistName,
                    'Services' => $services,
                    'PatientNote' => $appointment->PatientNote ?? 'No notes available',
                    'AppointmentStatus' => $appointment->AppointmentStatus,
                ];
            })->values();
    
            \Log::info("Treatment history fetched successfully for logged-in patient", [
                'PatientID' => $patientId,
                'RecordCount' => $treatmentHistory->count(),
            ]);
    
            return response()->json($treatmentHistory);
        } catch (\Exception $e) {
            \Log::error("Error fetching treatment history: " . $e->getMessage(), [
                'PatientID' => auth()->user()->patient->PatientID ?? 'N/A',
                'Stack' => $e->getTraceAsString(),
            ]);
            return response()->json(['success' => false, 'message' => 'Failed to fetch treatment history'], 500);
        }
    }

    public function checkAppointmentsOnDate(Request $request)
    {
        try {
            $request->validate([
                'date' => 'required|date',
            ]);

            $date = $request->input('date');

            $appointmentCount = Appointment::where('AppointmentDate', $date)
                ->whereNotIn('AppointmentStatus', ['Cancelled', 'Declined'])
                ->count();

            return response()->json([
                'success' => true,
                'hasAppointments' => $appointmentCount > 0,
                'appointmentCount' => $appointmentCount,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error checking appointments on date: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to check appointments: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function checkBlockedDate(Request $request)
    {
        try {
            $request->validate([
                'date' => 'required|date',
            ]);

            if (!$this->canManageDates()) {
                \Log::warning('Unauthorized attempt to check blocked date', ['UserID' => auth()->user()->UserID]);
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized to check blocked dates.',
                ], 403);
            }

            $date = $request->input('date');

            $blocked = DB::table('blocked_dates')
                ->where('BlockedDate', $date)
                ->whereNull('DentistID')
                ->exists();

            return response()->json([
                'success' => true,
                'isBlocked' => $blocked,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error checking blocked date: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to check blocked date: ' . $e->getMessage(),
            ], 500);
        }
    }

    private function canManageDates()
    {
        $userType = auth()->user()->userAccount ? auth()->user()->userAccount->UserType : null;
        return $userType && in_array(
            trim(strtolower($userType)),
            array_map('strtolower', ['hr', 'HRAdmin', 'HR', 'Owner'])
        );
    }

    public function blockDate(Request $request)
    {
        try {
            $request->validate([
                'date' => 'required|date',
                'reason' => 'nullable|string|max:255',
            ]);

            $date = $request->input('date');
            $reason = $request->input('reason');
            $blockedBy = auth()->user()->UserID;

            // Check if the user has permission (HR or HRAdmin)
            // $userType = auth()->user()->userAccount ? auth()->user()->userAccount->UserType : null;
            if (!$this->canManageDates()) {
                \Log::warning('Unauthorized attempt to block date', ['UserID' => auth()->user()->UserID]);
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized to block dates.',
                ], 403);
            }

            // Check if the date is already blocked
            $isBlocked = DB::table('blocked_dates')
                ->where('BlockedDate', $date)
                ->whereNull('DentistID')
                ->exists();

            if ($isBlocked) {
                return response()->json([
                    'success' => false,
                    'message' => 'This date is already blocked.',
                ], 400);
            }

            // Check for existing appointments
            $appointmentCount = Appointment::where('AppointmentDate', $date)
                ->whereNotIn('AppointmentStatus', ['Cancelled', 'Declined'])
                ->count();

            if ($appointmentCount > 0) {
                return response()->json([
                    'success' => false,
                    'message' => "This date has $appointmentCount appointments. Blocking is not allowed.",
                ], 400);
            }

            // Block the date
            DB::table('blocked_dates')->insert([
                'BlockedDate' => $date,
                'DentistID' => null, // Clinic-wide block
                'BlockedBy' => $blockedBy,
                'Reason' => $reason,
                'CreatedAt' => now(),
            ]);

            \Log::info('Date blocked successfully', [
                'BlockedDate' => $date,
                'BlockedBy' => $blockedBy,
                'Reason' => $reason,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Date blocked successfully.',
            ]);
        } catch (\Exception $e) {
            \Log::error('Error blocking date: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to block date: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getBlockedDates(Request $request)
    {
        try {
            \Log::info('Fetching blocked dates for user:', ['UserID' => auth()->id()]);
    
            $blockedDates = DB::table('blocked_dates')
                ->whereNull('DentistID') // Clinic-wide blocks only
                ->select('BlockedDate AS Date', 'Reason') // Match the expected frontend format
                ->get()
                ->map(function ($blockedDate) {
                    return [
                        'Date' => $blockedDate->Date,
                        'Reason' => $blockedDate->Reason,
                    ];
                })->toArray();
    
            \Log::info('Blocked dates fetched:', ['dates' => $blockedDates]);
    
            return response()->json($blockedDates);
        } catch (\Exception $e) {
            \Log::error('Error fetching blocked dates: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch blocked dates: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function unblockDate($date)
    {
        try {
            // Check if the user has permission (HR or HRAdmin)
            // $userType = auth()->user()->userAccount ? auth()->user()->userAccount->UserType : null;
            // $isHr = $userType && in_array(trim(strtolower($userType)), array_map('strtolower', ['hr', 'HRAdmin', 'HR']));
            if (!$this->canManageDates()) {
                \Log::warning('Unauthorized attempt to unblock date', ['UserID' => auth()->user()->UserID]);
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized to unblock dates.',
                ], 403);
            }

            // Check if the date is blocked
            $isBlocked = DB::table('blocked_dates')
                ->where('BlockedDate', $date)
                ->whereNull('DentistID')
                ->exists();

            if (!$isBlocked) {
                return response()->json([
                    'success' => false,
                    'message' => 'This date is not blocked.',
                ], 400);
            }

            // Unblock the date
            DB::table('blocked_dates')
                ->where('BlockedDate', $date)
                ->whereNull('DentistID')
                ->delete();

            \Log::info('Date unblocked successfully', [
                'BlockedDate' => $date,
                'UnblockedBy' => auth()->user()->UserID,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Date unblocked successfully.',
            ]);
        } catch (\Exception $e) {
            \Log::error('Error unblocking date: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to unblock date: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function book(Request $request)
{
    // Validate the request data
    $validated = $request->validate([
        'PatientID' => 'required|integer',
        'AppointmentDate' => 'required|date|after_or_equal:today',
        'AppointmentTime' => 'required|string|regex:/^\d{1,2}:\d{2}$/',
        'UserID' => 'nullable|integer',
        'services' => 'required|array',
        'services.*' => 'integer',
        'PatientNote' => 'nullable|string',
        'AppointmentStatus' => 'required|string',
    ]);
    
    // For same-day bookings, ensure the selected time is in the future
    $isToday = Carbon::parse($validated['AppointmentDate'])->isToday();
    if ($isToday) {
        $appointmentTime = Carbon::createFromFormat('H:i', $validated['AppointmentTime']);
        if ($appointmentTime->lessThanOrEqualTo(Carbon::now())) {
            return response()->json(['success' => false, 'message' => 'Selected time is in the past.'], 400);
        }
    }
    
    // Check if the date is blocked
    if ($this->isDateBlocked($validated['AppointmentDate'], null)) {
        return response()->json([
            'success' => false,
            'message' => 'This date is blocked. Please choose another date.',
        ], 400);
    }
    
    // Logic to create the appointment
    $appointment = Appointment::create([
        'PatientID' => $validated['PatientID'],
        'AppointmentDate' => $validated['AppointmentDate'],
        'AppointmentTime' => $validated['AppointmentTime'],
        'UserID' => $validated['UserID'],
        'PatientNote' => $validated['PatientNote'],
        'AppointmentStatus' => $validated['AppointmentStatus'],
    ]);
    
    // Attach services to the appointment
    foreach ($validated['services'] as $serviceId) {
        ServicesAvailed::create([
            'AppointmentID' => $appointment->AppointmentID,
            'ServiceID' => $serviceId,
            'Status' => 'Pending',
        ]);
    }
    
    return response()->json(['success' => true, 'message' => 'Appointment booked successfully']);
}

}
