<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\User;

class ListPatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::with('user');

        if ($request->has('search') && !empty($request->input('search'))) {
            $search = $request->input('search');
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('FirstName', 'like', "%{$search}%")
                  ->orWhere('LastName', 'like', "%{$search}%");
            });
        }

        $patients = $query->paginate(15);

        // Transform the response to include GovernmentID and other necessary fields
        $patients->getCollection()->transform(function ($patient) {
            return [
                'PatientID' => $patient->PatientID,
                'user' => [
                    'UserID' => $patient->user->UserID,
                    'FirstName' => $patient->user->FirstName,
                    'LastName' => $patient->user->LastName,
                    'Email' => $patient->user->Email,
                    'Gender' => $patient->user->Gender,
                    'BirthDate' => $patient->user->BirthDate,
                    'Age' => $patient->user->Age,
                    'ContactNumber' => $patient->user->ContactNumber,
                    'HomeTelephoneNumber' => $patient->user->HomeTelephoneNumber,
                    'Address' => $patient->user->Address,
                ],
                'GuardianName' => $patient->GuardianName,
                'GuardianTelNumber' => $patient->GuardianTelNumber,
                'GovernmentID' => $patient->GovernmentID, // Include GovernmentID
                'created_at' => $patient->created_at->toDateTimeString(),
            ];
        });

        if ($request->wantsJson()) {
            return response()->json($patients);
        }

        return view('hrpatientlist', compact('patients'));
    }

    public function getPatientList(Request $request)
    {
        $dentistID = Auth::user()->dentist->DentistID;

        $query = Appointment::where('DentistID', $dentistID)
            ->whereIn('AppointmentStatus', ['Completed', 'Confirmed'])
            ->join('patients', 'appointments.PatientID', '=', 'patients.PatientID')
            ->join('users', 'patients.UserID', '=', 'users.UserID')
            ->select(
                'users.FirstName',
                'users.LastName',
                'users.ContactNumber',
                'users.Email',
                'users.Gender',
                'users.BirthDate',
                'users.Age',
                'users.Address',
                'patients.PatientID',
                'patients.GuardianName',
                'patients.GuardianTelNumber',
                'patients.created_at',
                'patients.Religion',
                'patients.Nationality',
                'patients.MaritalStatus',
                \DB::raw('MAX(appointments.AppointmentDate) as lastAppointment'),
                \DB::raw('(SELECT AppointmentDate FROM appointments a2 WHERE a2.PatientID = patients.PatientID AND a2.AppointmentDate > NOW() ORDER BY a2.AppointmentDate ASC LIMIT 1) as nextAppointment')
            )
            ->groupBy('patients.PatientID', 'users.FirstName', 'users.LastName', 'users.ContactNumber', 'users.Email', 'users.Gender', 'users.BirthDate', 'users.Age', 'users.Address', 'patients.GuardianName', 'patients.GuardianTelNumber', 'patients.created_at','patients.Religion','patients.Nationality','patients.MaritalStatus',);

        // Count distinct patients instead of total appointment rows
        $totalPatients = Appointment::where('DentistID', $dentistID)
            ->whereIn('AppointmentStatus', ['Completed', 'Confirmed'])
            ->distinct('PatientID')
            ->count('PatientID');

        $patients = $query->paginate(15);

        return response()->json([
            'data' => $patients->items(),
            'current_page' => $patients->currentPage(),
            'last_page' => $patients->lastPage(),
            'total' => $totalPatients,
        ]);
    }

}
