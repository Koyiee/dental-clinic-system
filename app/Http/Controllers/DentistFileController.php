<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Patient;
use App\Models\User;
use App\Models\TreatmentPlan;
use App\Models\DentalPhoto;
use App\Models\DentalForm;
use App\Models\MedicalRecord;
use App\Models\DentalTreatmentHistory;
use Illuminate\Validation\ValidationException;
use App\Events\UserActionOccurred;
use Illuminate\Support\Facades\DB;

class DentistFileController extends Controller
{
    // Upload Dental Photos
    public function uploadDentalPhoto(Request $request)
    {
        try {
            $request->validate([
                'patient_id' => 'required|exists:patients,PatientID',
                'files' => 'required|array',
                'files.*' => 'file|mimes:jpg,jpeg,png,gif,bmp,webp|max:10240',
                'file_names' => 'required|array',
                'file_names.*' => [
                    'string',
                    'max:255',
                    'regex:#\.(jpg|jpeg|png|gif|bmp|webp)$#i',
                ],
                'descriptions' => 'nullable|array',
                'descriptions.*' => 'nullable|string',
            ]);
    
            $files = $request->file('files');
            $fileNames = $request->input('file_names');
            $descriptions = $request->input('descriptions', []);
    
            // Get patient, user, and dentist information
            $patient = Patient::findOrFail($request->patient_id);
            $user = User::findOrFail($patient->UserID);
            $dentist = Auth::user();
    
            foreach ($files as $index => $file) {
                $fileContent = file_get_contents($file->getRealPath());
                $fileType = $file->getClientOriginalExtension();
                $mimeType = $file->getClientMimeType();
                \Log::info('Uploading dental photo', [
                    'filename' => $fileNames[$index],
                    'filetype' => $fileType,
                    'mime_type' => $mimeType,
                    'content_length' => strlen($fileContent)
                ]);
    
                DentalPhoto::create([
                    'PatientID' => $request->patient_id,
                    'FileName' => $fileNames[$index],
                    'FileContent' => $fileContent,
                    'FileType' => $fileType,
                    'UploadedBy' => Auth::id(),
                    'Description' => $descriptions[$index] ?? null,
                ]);
    
                // Log the file upload event
                event(new UserActionOccurred(
                    Auth::id(),
                    'File Uploaded',
                    "Dentist {$dentist->FirstName} {$dentist->LastName} uploaded a Dental Photo for Patient {$user->FirstName} {$user->LastName}"
                ));
            }
    
            return response()->json(['message' => 'Dental photos uploaded successfully'], 200);
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Error uploading dental photos: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Failed to upload dental photos'], 500);
        }
    }

    // Upload Treatment Plans
    public function uploadTreatmentPlan(Request $request)
    {
        try {
            $request->validate([
                'patient_id' => 'required|exists:patients,PatientID',
                'files' => 'required|array',
                'files.*' => 'file|mimes:jpg,png,docx,pdf,doc|max:10240',
                'file_names' => 'required|array',
                'file_names.*' => [
                    'string',
                    'max:255',
                    'regex:#\.(jpg|jpeg|png|gif|bmp|webp|pdf|doc|docx)$#i',
                ],
                'descriptions' => 'nullable|array',
                'descriptions.*' => 'nullable|string',
            ]);
    
            // Get patient, user, and dentist information
            $patient = Patient::findOrFail($request->patient_id);
            $user = User::findOrFail($patient->UserID);
            $dentist = Auth::user();
    
            $files = $request->file('files');
            $fileNames = $request->input('file_names');
            $descriptions = $request->input('descriptions', []);
    
            \Log::info('Received file names for treatment plan upload', ['file_names' => $fileNames]);
    
            foreach ($files as $index => $file) {
                // Read the file content as a binary string
                $fileContent = file_get_contents($file->getRealPath());
                $fileType = $file->getClientOriginalExtension();
                $mimeType = $file->getClientMimeType();
                \Log::info('Uploading treatment plan', [
                    'filename' => $fileNames[$index],
                    'filetype' => $fileType,
                    'mime_type' => $mimeType,
                    'content_length' => strlen($fileContent)
                ]);
    
                TreatmentPlan::create([
                    'PatientID' => $request->patient_id,
                    'FileName' => $fileNames[$index],
                    'FileContent' => $fileContent,
                    'FileType' => $fileType,
                    'UploadedBy' => Auth::id(),
                    'Description' => $descriptions[$index] ?? null,
                ]);
    
                // Log the file upload event
                event(new UserActionOccurred(
                    Auth::id(),
                    'File Uploaded',
                    "Dentist {$dentist->FirstName} {$dentist->LastName} uploaded a Treatment Plan for Patient {$user->FirstName} {$user->LastName}"
                ));
            }
    
            return response()->json(['message' => 'Treatment plans uploaded successfully'], 200);
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Error uploading treatment plans: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Failed to upload treatment plans'], 500);
        }
    }

    // Upload Dental Forms (Documents section)
    public function uploadDentalForm(Request $request)
    {
        try {
            $request->validate([
                'patient_id' => 'required|exists:patients,PatientID',
                'files' => 'required|array',
                'files.*' => 'file|mimes:jpg,png,docx,pdf,doc|max:10240',
                'file_names' => 'required|array',
                'file_names.*' => [
                    'string',
                    'max:255',
                    'regex:#\.(jpg|jpeg|png|gif|bmp|webp|pdf|doc|docx)$#i',
                ],
                'form_types' => 'nullable|array',
                'form_types.*' => 'nullable|string',
            ]);
    
            // Get patient, user, and dentist information
            $patient = Patient::findOrFail($request->patient_id);
            $user = User::findOrFail($patient->UserID);
            $dentist = Auth::user();
    
            $files = $request->file('files');
            $fileNames = $request->input('file_names');
            $formTypes = $request->input('form_types', []);
    
            foreach ($files as $index => $file) {
                $fileContent = file_get_contents($file->getRealPath());
                $fileType = $file->getClientOriginalExtension();
                $mimeType = $file->getClientMimeType();
                \Log::info('Uploading dental form', [
                    'filename' => $fileNames[$index],
                    'filetype' => $fileType,
                    'mime_type' => $mimeType,
                    'content_length' => strlen($fileContent)
                ]);
    
                DentalForm::create([
                    'PatientID' => $request->patient_id,
                    'FileName' => $fileNames[$index],
                    'FileContent' => $fileContent,
                    'FileType' => $fileType,
                    'UploadedBy' => Auth::id(),
                    'FormType' => $formTypes[$index] ?? null,
                ]);
    
                // Log the file upload event
                $formType = $formTypes[$index] ?? 'N/A';
                event(new UserActionOccurred(
                    Auth::id(),
                    'File Uploaded',
                    "Dentist {$dentist->FirstName} {$dentist->LastName} uploaded a Dental Form for Patient {$user->FirstName} {$user->LastName}"
                ));
            }
    
            return response()->json(['message' => 'Dental forms uploaded successfully'], 200);
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Error uploading dental forms: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Failed to upload dental forms'], 500);
        }
    }

    // Fetch Dental Photos for a Patient
    public function getDentalPhotos($patientId)
    {
        $photos = DentalPhoto::where('PatientID', $patientId)->get(['DentalPhotoID', 'FileName', 'FileType', 'Description', 'UploadDate']);
        return response()->json($photos);
    }

    // Fetch Treatment Plans for a Patient
    public function getTreatmentPlans($patientId)
    {
        $plans = TreatmentPlan::where('PatientID', $patientId)->get(['TreatmentPlanID', 'FileName', 'FileType', 'Description', 'UploadDate']);
        return response()->json($plans);
    }

    // Fetch Dental Forms for a Patient
    public function getDentalForms($patientId)
    {
        $forms = DentalForm::where('PatientID', $patientId)->get(['DentalFormID', 'FileName', 'FileType', 'FormType', 'UploadDate']);
        return response()->json($forms);
    }

    // Download a File (Generic) - Enhanced with patient download logging
    public function downloadFile(Request $request, $type, $id)
    {
        $modelMap = [
            'dental' => DentalPhoto::class,
            'treatment' => TreatmentPlan::class,
            'form' => DentalForm::class,
            'medical' => MedicalRecord::class,
        ];
    
        $typeNames = [
            'dental' => 'Dental Photo',
            'treatment' => 'Treatment Plan',
            'form' => 'Dental Form',
            'medical' => 'Medical Record',
        ];
    
        if (!isset($modelMap[$type])) {
            \Log::warning('Invalid file type requested', ['type' => $type]);
            return response()->json(['error' => 'Invalid file type'], 400);
        }
    
        try {
            \Log::info('Attempting to download file', ['type' => $type, 'id' => $id]);
    
            // Find the file
            $file = $modelMap[$type]::findOrFail($id);
            \Log::info('File found', ['type' => $type, 'id' => $id, 'patient_id' => $file->PatientID]);
    
            $user = Auth::user();
            $displayType = $typeNames[$type] ?? $type;
    
            // Get patient info
            $patient = Patient::find($file->PatientID);
            if (!$patient) {
                \Log::warning('Patient not found for file', ['type' => $type, 'id' => $id, 'patient_id' => $file->PatientID]);
                return response()->json(['error' => 'Patient not found for this file'], 404);
            }
            \Log::info('Patient found', ['patient_id' => $patient->PatientID, 'user_id' => $patient->UserID]);
    
            $patientUser = User::find($patient->UserID);
            if (!$patientUser) {
                \Log::warning('Patient user not found', ['patient_id' => $patient->PatientID, 'user_id' => $patient->UserID]);
                return response()->json(['error' => 'Patient user not found'], 404);
            }
            \Log::info('Patient user found', ['patient_user_id' => $patientUser->UserID]);
    
            // Determine if the downloader is the patient or a dentist
            $userAccount = \App\Models\UserAccount::where('UserID', $user->UserID)->first();
            if (!$userAccount) {
                \Log::warning('User account not found for authenticated user, assuming Patient due to middleware', ['user_id' => $user->UserID]);
                $isPatient = true; // Assume Patient since the route is under patient middleware
            } else {
                $isPatient = $userAccount->UserType === 'Patient';
            }
            \Log::info('User type determined', ['user_id' => $user->UserID, 'is_patient' => $isPatient]);
    
            if ($isPatient) {
                if ($patient->UserID !== $user->UserID) {
                    \Log::warning('Unauthorized access attempt by patient', [
                        'user_id' => $user->UserID,
                        'patient_user_id' => $patient->UserID,
                        'type' => $type,
                        'id' => $id
                    ]);
                    return response()->json(['error' => 'Unauthorized to download this file'], 403);
                }
    
                \Log::info('Patient downloading their file', [
                    'type' => $displayType,
                    'id' => $id,
                    'filename' => $file->FileName,
                ]);
    
                try {
                    event(new UserActionOccurred(
                        $user->UserID,
                        'File Downloaded',
                        "Patient {$user->FirstName} {$user->LastName} downloaded a {$displayType}"
                    ));
                    \Log::info('Event dispatched for patient download', ['user_id' => $user->UserID]);
                } catch (\Exception $e) {
                    \Log::error('Failed to dispatch UserActionOccurred event for patient', [
                        'user_id' => $user->UserID,
                        'exception' => $e->getMessage(),
                        'stack' => $e->getTraceAsString()
                    ]);
                    // Continue execution even if event fails
                }
            } else {
                \Log::info('Dentist downloading file', [
                    'type' => $displayType,
                    'id' => $id,
                    'filename' => $file->FileName,
                ]);
    
                $logMessage = $patientUser 
                    ? "Dentist {$user->FirstName} {$user->LastName} downloaded a {$displayType} for Patient {$patientUser->FirstName} {$patientUser->LastName}"
                    : "Dentist {$user->FirstName} {$user->LastName} downloaded a {$displayType}";
    
                try {
                    event(new UserActionOccurred(
                        $user->UserID,
                        'File Downloaded',
                        $logMessage
                    ));
                    \Log::info('Event dispatched for dentist download', ['user_id' => $user->UserID]);
                } catch (\Exception $e) {
                    \Log::error('Failed to dispatch UserActionOccurred event for dentist', [
                        'user_id' => $user->UserID,
                        'exception' => $e->getMessage(),
                        'stack' => $e->getTraceAsString()
                    ]);
                    // Continue execution even if event fails
                }
            }
    
            // Get raw FileContent to bypass cast
            $fileContent = $file->getRawOriginal('FileContent');
            if (is_null($fileContent) || $fileContent === '') {
                \Log::error('FileContent is empty or null', ['type' => $type, 'id' => $id]);
                return response()->json(['error' => 'File content not found'], 404);
            }
    
            // Verify the content is a string (binary data)
            if (!is_string($fileContent)) {
                \Log::error('FileContent is not a valid binary string', [
                    'type' => $type,
                    'id' => $id,
                    'content_type' => gettype($fileContent)
                ]);
                return response()->json(['error' => 'Invalid file content format'], 500);
            }
    
            \Log::info('FileContent retrieved', [
                'type' => $type,
                'id' => $id,
                'filename' => $file->FileName,
                'content_length' => strlen($fileContent)
            ]);
    
            $mimeType = $this->getMimeType($file->FileType);
            $disposition = $request->query('inline', 'false') === 'true' ? 'inline' : 'attachment';
    
            $headers = [
                'Content-Type' => $mimeType,
                'Content-Disposition' => "$disposition; filename=\"{$file->FileName}\"",
                'Content-Length' => strlen($fileContent),
            ];
    
            \Log::info('Returning file response', [
                'type' => $type,
                'id' => $id,
                'mime_type' => $mimeType,
                'disposition' => $disposition
            ]);
    
            return response()->make($fileContent, 200, $headers);
        } catch (\Exception $e) {
            \Log::error('Error downloading file: ' . $e->getMessage(), [
                'type' => $type,
                'id' => $id,
                'exception' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Failed to download file: ' . $e->getMessage()], 500);
        }
    }

    // Helper to determine MIME type
    private function getMimeType($fileType)
    {
        $mimeTypes = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'webp' => 'image/webp',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
        ];

        return $mimeTypes[strtolower($fileType)] ?? 'application/octet-stream';
    }

    // Delete Dental Photo
    public function deleteDentalPhoto($id)
    {
        try {
            $photo = DentalPhoto::findOrFail($id);
            $patient = Patient::findOrFail($photo->PatientID);
            $user = User::findOrFail($patient->UserID);
            $dentist = Auth::user();

            $photo->delete();

            // Log the deletion event
            event(new UserActionOccurred(
                $dentist->UserID,
                'File Deleted',
                "Dentist {$dentist->FirstName} {$dentist->LastName} deleted a Dental Photo for Patient {$user->FirstName} {$user->LastName}"
            ));

            return response()->json(['message' => 'Dental photo deleted successfully'], 200);
        } catch (\Exception $e) {
            \Log::error('Error deleting dental photo: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Failed to delete dental photo'], 500);
        }
    }

    // Delete Treatment Plan
    public function deleteTreatmentPlan($id)
    {
        try {
            $plan = TreatmentPlan::findOrFail($id);
            $patient = Patient::findOrFail($plan->PatientID);
            $user = User::findOrFail($patient->UserID);
            $dentist = Auth::user();

            $plan->delete();

            // Log the deletion event
            event(new UserActionOccurred(
                $dentist->UserID,
                'File Deleted',
                "Dentist {$dentist->FirstName} {$dentist->LastName} deleted a Treatment Plan for Patient {$user->FirstName} {$user->LastName}"
            ));

            return response()->json(['message' => 'Treatment plan deleted successfully'], 200);
        } catch (\Exception $e) {
            \Log::error('Error deleting treatment plan: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Failed to delete treatment plan'], 500);
        }
    }

    // Delete Dental Form
    public function deleteDentalForm($id)
    {
        try {
            $form = DentalForm::find($id);

            if (!$form) {
                return response()->json(['error' => 'Dental form not found'], 404);
            }

            $patient = Patient::findOrFail($form->PatientID);
            $user = User::findOrFail($patient->UserID);
            $currentUser = Auth::user();
            $userType = \App\Models\UserAccount::where('UserID', $currentUser->UserID)->first()->UserType;

            // Authorization logic
            if ($userType === 'Patient') {
                $patientUser = \App\Models\Patient::where('UserID', $currentUser->UserID)->first();
                if (!$patientUser || $form->PatientID !== $patientUser->PatientID) {
                    return response()->json(['error' => 'Unauthorized to delete this form'], 403);
                }
            } elseif ($userType !== 'Dentist') {
                return response()->json(['error' => 'Unauthorized to delete this form'], 403);
            }

            // Prepare the form type for logging
            $formType = $form->FormType ?? 'N/A';
            $patientName = "{$user->FirstName} {$user->LastName}";

            $form->delete();

            // Log the deletion event
            $actorType = ($userType === 'Patient') ? 'Patient' : 'Dentist';
            $actorName = ($userType === 'Patient') ? $patientName : $currentUser->FirstName . ' ' . $currentUser->LastName;
            event(new UserActionOccurred(
                $currentUser->UserID,
                'File Deleted',
                "{$actorType} {$actorName} deleted a Dental Form for Patient {$patientName}"
            ));

            return response()->json(['message' => 'Dental form deleted successfully']);
        } catch (\Exception $e) {
            \Log::error('Error deleting dental form: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Failed to delete dental form'], 500);
        }
    }

    public function getLoggedInPatientDentalPhotos()
    {
        try {
            // Get the authenticated user's ID
            $userId = Auth::id();

            // Find the patient record associated with this user
            $patient = \App\Models\Patient::where('UserID', $userId)->first();

            if (!$patient) {
                return response()->json(['error' => 'Patient record not found for this user'], 404);
            }

            // Fetch dental photos for this patient
            $photos = DentalPhoto::where('PatientID', $patient->PatientID)
                ->get(['DentalPhotoID', 'FileName', 'FileType', 'Description', 'UploadDate']);

            return response()->json($photos);
        } catch (\Exception $e) {
            \Log::error('Error fetching dental photos for logged-in patient: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Failed to fetch dental photos'], 500);
        }
    }

    public function getLoggedInPatientTreatmentPlans()
    {
        try {
            // Get the authenticated user's ID
            $userId = Auth::id();
    
            // Find the patient record associated with this user
            $patient = \App\Models\Patient::where('UserID', $userId)->first();
    
            if (!$patient) {
                return response()->json(['error' => 'Patient record not found for this user'], 404);
            }
    
            $patientId = $patient->PatientID;
    
            // Fetch treatment plans with associated appointments
            $treatmentPlans = DB::table('treatment_plans as tp')
                ->select('tp.*', 'a.AppointmentID', 'a.AppointmentDate', 'a.AppointmentTime', 'a.AppointmentStatus')
                ->leftJoin('appointments as a', function ($join) use ($patientId) {
                    $join->on('a.PatientID', '=', 'tp.PatientID')
                        ->where('a.created_at', '<=', 'tp.created_at')
                        ->where('a.PatientID', '=', $patientId);
                })
                ->where('tp.PatientID', $patientId)
                ->orderBy('tp.created_at', 'desc')
                ->orderBy('a.created_at', 'desc')
                ->get()
                ->groupBy('TreatmentPlanID');
    
            // Map the results to the desired format
            $plansWithAppointments = $treatmentPlans->map(function ($plans, $treatmentPlanId) {
                $plan = $plans->first(); // Take the first row (most recent appointment)
                return [
                    'TreatmentPlanID' => $plan->TreatmentPlanID,
                    'PatientID' => $plan->PatientID,
                    'FileName' => $plan->FileName,
                    'FileType' => $plan->FileType,
                    'Description' => $plan->Description,
                    'UploadDate' => $plan->UploadDate, // Keep for compatibility
                    'created_at' => $plan->created_at, // Add for consistency
                    'Appointment' => $plan->AppointmentID ? [
                        'AppointmentID' => $plan->AppointmentID,
                        'AppointmentDate' => $plan->AppointmentDate,
                        'AppointmentTime' => $plan->AppointmentTime,
                        'AppointmentStatus' => $plan->AppointmentStatus,
                    ] : null,
                ];
            })->values();
    
            return response()->json($plansWithAppointments);
        } catch (\Exception $e) {
            \Log::error('Error fetching treatment plans for logged-in patient: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Failed to fetch treatment plans'], 500);
        }
    }

    public function getLoggedInPatientDentalForms()
    {
        try {
            // Get the authenticated user's ID
            $userId = Auth::id();

            // Find the patient record associated with this user
            $patient = \App\Models\Patient::where('UserID', $userId)->first();

            if (!$patient) {
                return response()->json(['error' => 'Patient record not found for this user'], 404);
            }

            // Fetch dental forms for this patient
            $forms = DentalForm::where('PatientID', $patient->PatientID)
                ->get(['DentalFormID', 'FileName', 'FileType', 'UploadDate']);

            return response()->json($forms);
        } catch (\Exception $e) {
            \Log::error('Error fetching dental forms for logged-in patient: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Failed to fetch dental forms'], 500);
        }
    }

    public function uploadMedicalRecord(Request $request)
    {
        try {
            \Log::info('Received upload request for medical records', $request->all());

            $request->validate([
                'patient_id' => 'required|exists:patients,PatientID',
                'files' => 'required|array',
                'files.*' => 'file|mimes:jpg,png,docx,pdf,doc|max:10240',
                'file_names' => 'required|array',
                'file_names.*' => [
                    'string',
                    'max:255',
                    'regex:#\.(jpg|jpeg|png|gif|bmp|webp|pdf|doc|docx)$#i',
                ],
                'record_types' => 'nullable|array',
                'record_types.*' => 'nullable|string|max:255',
            ]);

            $files = $request->file('files');
            $fileNames = $request->input('file_names');
            $recordTypes = $request->input('record_types', []);

            \Log::info('Validated request', [
                'patient_id' => $request->patient_id,
                'file_count' => count($files),
                'file_names' => $fileNames,
                'record_types' => $recordTypes,
            ]);

            $patient = Patient::findOrFail($request->patient_id);
            $user = User::findOrFail($patient->UserID);
            $dentist = Auth::user();

            foreach ($files as $index => $file) {
                \Log::info('Processing file', [
                    'index' => $index,
                    'filename' => $fileNames[$index],
                    'original_name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                ]);

                // Read the file content as a string
                $fileContent = file_get_contents($file->getRealPath());
                $fileType = $file->getClientOriginalExtension();
                $mimeType = $file->getClientMimeType();

                \Log::info('File details', [
                    'filename' => $fileNames[$index],
                    'filetype' => $fileType,
                    'mime_type' => $mimeType,
                    'record_type' => $recordTypes[$index] ?? null,
                    'file_content_length' => strlen($fileContent),
                ]);

                $record = MedicalRecord::create([
                    'PatientID' => $request->patient_id,
                    'FileName' => $fileNames[$index],
                    'FileContent' => $fileContent,
                    'FileType' => $fileType,
                    'RecordType' => $recordTypes[$index] ?? null,
                    'UploadDate' => now(),
                ]);

                \Log::info('Medical record created', [
                    'MedicalRecordID' => $record->MedicalRecordID,
                    'PatientID' => $record->PatientID,
                    'FileName' => $record->FileName,
                ]);

                $recordType = $recordTypes[$index] ?? 'N/A';
                event(new UserActionOccurred(
                    Auth::id(),
                    'File Uploaded',
                    "Dentist {$dentist->FirstName} {$dentist->LastName} uploaded a Medical Record for Patient {$user->FirstName} {$user->LastName}"
                ));
            }

            \Log::info('Medical records upload completed');
            return response()->json(['message' => 'Medical records uploaded successfully'], 200);
        } catch (ValidationException $e) {
            \Log::error('Validation failed for medical record upload', ['errors' => $e->errors()]);
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Error uploading medical records: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Failed to upload medical records'], 500);
        }
    }

    // Fetch Medical Records for a Patient
    public function getMedicalRecords($patientId)
    {
        try {
            // Validate patient ID
            if (!is_numeric($patientId) || $patientId <= 0) {
                return response()->json(['error' => 'Invalid patient ID'], 400);
            }

            // Check if patient exists
            $patient = Patient::find($patientId);
            if (!$patient) {
                return response()->json(['error' => 'Patient not found'], 404);
            }

            $records = MedicalRecord::where('PatientID', $patientId)
                ->get(['MedicalRecordID', 'FileName', 'FileType', 'RecordType', 'UploadDate']);

            return response()->json($records);
        } catch (\Exception $e) {
            \Log::error('Error fetching medical records: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Failed to fetch medical records'], 500);
        }
    }

    // Delete Medical Record
    public function deleteMedicalRecord($id)
    {
        try {
            $record = MedicalRecord::findOrFail($id);
            $patient = Patient::findOrFail($record->PatientID);
            $user = User::findOrFail($patient->UserID);
            $dentist = Auth::user();

            $recordType = $record->RecordType ?? 'N/A';

            $record->delete();

            // Log the deletion event
            event(new UserActionOccurred(
                $dentist->UserID,
                'File Deleted',
                "Dentist {$dentist->FirstName} {$dentist->LastName} deleted a Medical Record for Patient {$user->FirstName} {$user->LastName}"
            ));

            return response()->json(['message' => 'Medical record deleted successfully'], 200);
        } catch (\Exception $e) {
            \Log::error('Error deleting medical record: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Failed to delete medical record'], 500);
        }
    }
}