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
use Illuminate\Validation\ValidationException;
use App\Events\UserActionOccurred;

class HRFileController extends Controller
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

            $patient = Patient::findOrFail($request->patient_id);
            $user = User::findOrFail($patient->UserID);
            $hrAdmin = Auth::user();

            $files = $request->file('files');
            $fileNames = $request->input('file_names');
            $descriptions = $request->input('descriptions', []);

            foreach ($files as $index => $file) {
                $fileContent = file_get_contents($file->getRealPath());
                $fileType = $file->getClientOriginalExtension();
                $mimeType = $file->getClientMimeType();

                \Log::info('HR uploading dental photo', [
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
                    'UploadedBy' => $hrAdmin->UserID,
                    'Description' => $descriptions[$index] ?? null,
                ]);

                event(new UserActionOccurred(
                    $hrAdmin->UserID,
                    'File Uploaded',
                    "HR Admin {$hrAdmin->FirstName} {$hrAdmin->LastName} uploaded a Dental Photo for Patient {$user->FirstName} {$user->LastName}"
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
                'files.*' => 'file|mimes:jpg,jpeg,png,gif,bmp,webp,pdf,doc,docx|max:10240',
                'file_names' => 'required|array',
                'file_names.*' => [
                    'string',
                    'max:255',
                    'regex:#\.(jpg|jpeg|png|gif|bmp|webp|pdf|doc|docx)$#i',
                ],
                'descriptions' => 'nullable|array',
                'descriptions.*' => 'nullable|string',
            ]);

            $patient = Patient::findOrFail($request->patient_id);
            $user = User::findOrFail($patient->UserID);
            $hrAdmin = Auth::user();

            $files = $request->file('files');
            $fileNames = $request->input('file_names');
            $descriptions = $request->input('descriptions', []);

            \Log::info('HR received file names for treatment plan upload', ['file_names' => $fileNames]);

            foreach ($files as $index => $file) {
                $fileContent = file_get_contents($file->getRealPath());
                $fileType = $file->getClientOriginalExtension();
                $mimeType = $file->getClientMimeType();

                \Log::info('HR uploading treatment plan', [
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
                    'UploadedBy' => $hrAdmin->UserID,
                    'Description' => $descriptions[$index] ?? null,
                ]);

                event(new UserActionOccurred(
                    $hrAdmin->UserID,
                    'File Uploaded',
                    "HR Admin {$hrAdmin->FirstName} {$hrAdmin->LastName} uploaded a Treatment Plan for Patient {$user->FirstName} {$user->LastName}"
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

    // Upload Dental Forms
    public function uploadDentalForm(Request $request)
    {
        try {
            $request->validate([
                'patient_id' => 'required|exists:patients,PatientID',
                'files' => 'required|array',
                'files.*' => 'file|mimes:jpg,jpeg,png,gif,bmp,webp,pdf,doc,docx|max:10240',
                'file_names' => 'required|array',
                'file_names.*' => [
                    'string',
                    'max:255',
                    'regex:#\.(jpg|jpeg|png|gif|bmp|webp|pdf|doc|docx)$#i',
                ],
                'form_types' => 'nullable|array',
                'form_types.*' => 'nullable|string',
            ]);

            $patient = Patient::findOrFail($request->patient_id);
            $user = User::findOrFail($patient->UserID);
            $hrAdmin = Auth::user();

            $files = $request->file('files');
            $fileNames = $request->input('file_names');
            $formTypes = $request->input('form_types', []);

            foreach ($files as $index => $file) {
                $fileContent = file_get_contents($file->getRealPath());
                $fileType = $file->getClientOriginalExtension();
                $mimeType = $file->getClientMimeType();

                \Log::info('HR uploading dental form', [
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
                    'UploadedBy' => $hrAdmin->UserID,
                    'FormType' => $formTypes[$index] ?? null,
                ]);

                $formType = $formTypes[$index] ?? 'N/A';
                event(new UserActionOccurred(
                    $hrAdmin->UserID,
                    'File Uploaded',
                    "HR Admin {$hrAdmin->FirstName} {$hrAdmin->LastName} uploaded a Dental Form for Patient {$user->FirstName} {$user->LastName}"
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
        try {
            $photos = DentalPhoto::where('PatientID', $patientId)->get(['DentalPhotoID', 'FileName', 'FileType', 'Description', 'UploadDate']);
            return response()->json($photos);
        } catch (\Exception $e) {
            \Log::error('Error fetching dental photos: ' . $e->getMessage(), ['patient_id' => $patientId, 'exception' => $e]);
            return response()->json(['error' => 'Failed to fetch dental photos'], 500);
        }
    }

    // Fetch Treatment Plans for a Patient
    public function getTreatmentPlans($patientId)
    {
        try {
            $plans = TreatmentPlan::where('PatientID', $patientId)->get(['TreatmentPlanID', 'FileName', 'FileType', 'Description', 'UploadDate']);
            return response()->json($plans);
        } catch (\Exception $e) {
            \Log::error('Error fetching treatment plans: ' . $e->getMessage(), ['patient_id' => $patientId, 'exception' => $e]);
            return response()->json(['error' => 'Failed to fetch treatment plans'], 500);
        }
    }

    // Fetch Dental Forms for a Patient
    public function getDentalForms($patientId)
    {
        try {
            $forms = DentalForm::where('PatientID', $patientId)->get(['DentalFormID', 'FileName', 'FileType', 'FormType', 'UploadDate']);
            return response()->json($forms);
        } catch (\Exception $e) {
            \Log::error('Error fetching dental forms: ' . $e->getMessage(), ['patient_id' => $patientId, 'exception' => $e]);
            return response()->json(['error' => 'Failed to fetch dental forms'], 500);
        }
    }

    // Download a File (Generic)
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
            return response()->json(['error' => 'Invalid file type'], 400);
        }

        try {
            $file = $modelMap[$type]::findOrFail($id);
            $hrAdmin = Auth::user();
            $displayType = $typeNames[$type] ?? $type;

            $patient = Patient::find($file->PatientID);
            $patientUser = $patient ? User::find($patient->UserID) : null;

            $fileContent = $file->getRawOriginal('FileContent');
            if (empty($fileContent)) {
                \Log::error('FileContent is empty', [
                    'type' => $type,
                    'id' => $id,
                    'filename' => $file->FileName,
                    'patient_id' => $file->PatientID
                ]);
                return response()->json(['error' => 'File content not found'], 404);
            }

            \Log::info('HR Admin downloading file', [
                'type' => $displayType,
                'id' => $id,
                'filename' => $file->FileName,
                'content_length' => strlen($fileContent),
                'patient_id' => $file->PatientID
            ]);

            $logMessage = $patientUser
                ? "HR Admin {$hrAdmin->FirstName} {$hrAdmin->LastName} downloaded {$displayType} '{$file->FileName}' for patient {$patientUser->FirstName} {$patientUser->LastName}"
                : "HR Admin {$hrAdmin->FirstName} {$hrAdmin->LastName} downloaded {$displayType} '{$file->FileName}'";

            event(new UserActionOccurred(
                $hrAdmin->UserID,
                'File Downloaded',
                $logMessage
            ));

            $mimeType = $this->getMimeType($file->FileType);
            $disposition = $request->query('inline', 'false') === 'true' ? 'inline' : 'attachment';

            $headers = [
                'Content-Type' => $mimeType,
                'Content-Disposition' => "$disposition; filename=\"{$file->FileName}\"",
                'Content-Length' => strlen($fileContent),
            ];

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
            $hrAdmin = Auth::user();

            $fileName = $photo->FileName;
            $photo->delete();

            event(new UserActionOccurred(
                $hrAdmin->UserID,
                'File Deleted',
                "HR Admin {$hrAdmin->FirstName} {$hrAdmin->LastName} deleted a Dental Photo for Patient {$user->FirstName} {$user->LastName}"
            ));

            return response()->json(['message' => 'Dental photo deleted successfully'], 200);
        } catch (\Exception $e) {
            \Log::error('Error deleting dental photo: ' . $e->getMessage(), [
                'dental_photo_id' => $id,
                'exception' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Failed to delete dental photo'], 500);
        }
    }

    // Delete Treatment Plan
    public function deleteTreatmentPlan($id)
    {
        try {
            $plan = TreatmentPlan::findOrFail($id);
            $patient = Patient::findOrFail($plan->PatientID);
            $user = User::findOrFail($patient->UserID); // Fix: Use $patient->UserID
            $hrAdmin = Auth::user();
    
            $fileName = $plan->FileName;
            $plan->delete();
    
            event(new UserActionOccurred(
                $hrAdmin->UserID,
                'File Deleted',
                "HR Admin {$hrAdmin->FirstName} {$hrAdmin->LastName} deleted a Treatment Plan for Patient {$user->FirstName} {$user->LastName}"
            ));
    
            return response()->json(['message' => 'Treatment plan deleted successfully'], 200);
        } catch (\Exception $e) {
            \Log::error('Error deleting treatment plan: ' . $e->getMessage(), [
                'treatment_plan_id' => $id,
                'exception' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Failed to delete treatment plan: ' . $e->getMessage()], 500);
        }
    }

    // Delete Dental Form
    public function deleteDentalForm($id)
    {
        try {
            $form = DentalForm::findOrFail($id);
            $patient = Patient::findOrFail($form->PatientID);
            $user = User::findOrFail($patient->UserID);
            $hrAdmin = Auth::user();

            $fileName = $form->FileName;
            $formType = $form->FormType ?? 'N/A';
            $form->delete();

            event(new UserActionOccurred(
                $hrAdmin->UserID,
                'File Deleted',
                "HR Admin {$hrAdmin->FirstName} {$hrAdmin->LastName} deleted a Dental Form for Patient {$user->FirstName} {$user->LastName}"
            ));

            return response()->json(['message' => 'Dental form deleted successfully'], 200);
        } catch (\Exception $e) {
            \Log::error('Error deleting dental form: ' . $e->getMessage(), [
                'dental_form_id' => $id,
                'exception' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Failed to delete dental form'], 500);
        }
    }

    // Get Logged-in Patient's Dental Photos
    public function getLoggedInPatientDentalPhotos()
    {
        try {
            $userId = Auth::id();
            $patient = Patient::where('UserID', $userId)->first();

            if (!$patient) {
                return response()->json(['error' => 'Patient record not found for this user'], 404);
            }

            $photos = DentalPhoto::where('PatientID', $patient->PatientID)
                ->get(['DentalPhotoID', 'FileName', 'FileType', 'Description', 'UploadDate']);

            return response()->json($photos);
        } catch (\Exception $e) {
            \Log::error('Error fetching dental photos for logged-in patient: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Failed to fetch dental photos'], 500);
        }
    }

    // Get Logged-in Patient's Treatment Plans
    public function getLoggedInPatientTreatmentPlans()
    {
        try {
            $userId = Auth::id();
            $patient = Patient::where('UserID', $userId)->first();

            if (!$patient) {
                return response()->json(['error' => 'Patient record not found for this user'], 404);
            }

            $plans = TreatmentPlan::where('PatientID', $patient->PatientID)
                ->get(['TreatmentPlanID', 'FileName', 'FileType', 'Description', 'UploadDate']);

            return response()->json($plans);
        } catch (\Exception $e) {
            \Log::error('Error fetching treatment plans for logged-in patient: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Failed to fetch treatment plans'], 500);
        }
    }

    // Get Logged-in Patient's Dental Forms
    public function getLoggedInPatientDentalForms()
    {
        try {
            $userId = Auth::id();
            $patient = Patient::where('UserID', $userId)->first();

            if (!$patient) {
                return response()->json(['error' => 'Patient record not found for this user'], 404);
            }

            $forms = DentalForm::where('PatientID', $patient->PatientID)
                ->get(['DentalFormID', 'FileName', 'FileType', 'FormType', 'UploadDate']);

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
                'files.*' => 'file|mimes:jpg,jpeg,png,gif,bmp,webp,pdf,doc,docx|max:10240',
                'file_names' => 'required|array',
                'file_names.*' => [
                    'string',
                    'max:255',
                    'regex:#\.(jpg|jpeg|png|gif|bmp|webp|pdf|doc|docx)$#i',
                ],
                'record_types' => 'nullable|array',
                'record_types.*' => 'nullable|string|max:255',
            ]);

            $patient = Patient::findOrFail($request->patient_id);
            $user = User::findOrFail($patient->UserID);
            $hrAdmin = Auth::user();

            $files = $request->file('files');
            $fileNames = $request->input('file_names');
            $recordTypes = $request->input('record_types', []);

            \Log::info('Validated request', [
                'patient_id' => $request->patient_id,
                'file_count' => count($files),
                'file_names' => $fileNames,
                'record_types' => $recordTypes,
            ]);

            foreach ($files as $index => $file) {
                \Log::info('Processing file', [
                    'index' => $index,
                    'filename' => $fileNames[$index],
                    'original_name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                ]);

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
                    $hrAdmin->UserID,
                    'File Uploaded',
                    "HR Admin {$hrAdmin->FirstName} {$hrAdmin->LastName} uploaded a Medical Record '{$fileNames[$index]}' for patient {$user->FirstName} {$user->LastName}"
                ));
            }

            \Log::info('Medical records upload completed');
            return response()->json(['message' => 'Medical records uploaded successfully'], 200);
        } catch (ValidationException $e) {
            \Log::error('Validation failed for medical record upload', ['errors' => $e->errors()]);
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Error uploading medical records: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Failed to upload medical records: ' . $e->getMessage()], 500);
        }
    }

    // Fetch Medical Records for a Patient
    public function getMedicalRecords($patientId)
    {
        try {
            if (!is_numeric($patientId) || $patientId <= 0) {
                return response()->json(['error' => 'Invalid patient ID'], 400);
            }

            $patient = Patient::find($patientId);
            if (!$patient) {
                return response()->json(['error' => 'Patient not found'], 404);
            }

            $records = MedicalRecord::where('PatientID', $patientId)
                ->get(['MedicalRecordID', 'FileName', 'FileType', 'RecordType', 'UploadDate']);

            return response()->json($records);
        } catch (\Exception $e) {
            \Log::error('Error fetching medical records: ' . $e->getMessage(), [
                'patient_id' => $patientId,
                'exception' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Failed to fetch medical records'], 500);
        }
    }

    // Download Medical Record
    public function downloadMedicalRecord(Request $request, $id)
    {
        try {
            $record = MedicalRecord::findOrFail($id);
            $hrAdmin = Auth::user();

            $patient = Patient::find($record->PatientID);
            $patientUser = $patient ? User::find($patient->UserID) : null;

            $fileContent = $record->getRawOriginal('FileContent');
            if (empty($fileContent)) {
                \Log::error('FileContent is empty', [
                    'type' => 'medical',
                    'id' => $id,
                    'filename' => $record->FileName,
                    'patient_id' => $record->PatientID
                ]);
                return response()->json(['error' => 'File content not found'], 404);
            }

            \Log::info('HR Admin downloading medical record', [
                'type' => 'Medical Record',
                'id' => $id,
                'filename' => $record->FileName,
                'content_length' => strlen($fileContent),
                'patient_id' => $record->PatientID
            ]);

            $logMessage = $patientUser
                ? "HR Admin {$hrAdmin->FirstName} {$hrAdmin->LastName} downloaded Medical Record '{$record->FileName}' for patient {$patientUser->FirstName} {$patientUser->LastName}"
                : "HR Admin {$hrAdmin->FirstName} {$hrAdmin->LastName} downloaded Medical Record '{$record->FileName}'";

            event(new UserActionOccurred(
                $hrAdmin->UserID,
                'File Downloaded',
                $logMessage
            ));

            $mimeType = $this->getMimeType($record->FileType);
            $disposition = $request->query('inline', 'false') === 'true' ? 'inline' : 'attachment';

            $headers = [
                'Content-Type' => $mimeType,
                'Content-Disposition' => "$disposition; filename=\"{$record->FileName}\"",
                'Content-Length' => strlen($fileContent),
            ];

            return response()->make($fileContent, 200, $headers);
        } catch (\Exception $e) {
            \Log::error('Error downloading medical record: ' . $e->getMessage(), [
                'id' => $id,
                'exception' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Failed to download medical record'], 500);
        }
    }

    // Delete Medical Record
    public function deleteMedicalRecord($id)
    {
        try {
            $record = MedicalRecord::findOrFail($id);
            $patient = Patient::findOrFail($record->PatientID);
            $user = User::findOrFail($patient->UserID);
            $hrAdmin = Auth::user();

            $fileName = $record->FileName;
            $record->delete();

            event(new UserActionOccurred(
                $hrAdmin->UserID,
                'File Deleted',
                "HR Admin {$hrAdmin->FirstName} {$hrAdmin->LastName} deleted medical record '{$fileName}' for patient {$user->FirstName} {$user->LastName}"
            ));

            return response()->json(['message' => 'Medical record deleted successfully'], 200);
        } catch (\Exception $e) {
            \Log::error('Error deleting medical record: ' . $e->getMessage(), [
                'medical_record_id' => $id,
                'exception' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Failed to delete medical record'], 500);
        }
    }

}