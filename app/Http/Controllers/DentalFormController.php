<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class DentalFormController extends Controller
{
    public function getDentalForms(Request $request)
    {
        try {
            // Get the authenticated user
            $authenticatedUserId = Auth::id();
            if (!$authenticatedUserId) {
                return response()->json(['message' => 'User not authenticated'], 401);
            }

            // Fetch the patient's PatientID based on the authenticated user's UserID
            $patient = DB::table('patients')
                ->where('UserID', $authenticatedUserId)
                ->first();

            if (!$patient) {
                return response()->json(['message' => 'Patient record not found for the authenticated user'], 404);
            }

            $patientId = $patient->PatientID;

            // Fetch dental forms with associated appointments in a single query
            $dentalForms = DB::table('dental_forms as df')
                ->select('df.*', 'a.AppointmentID', 'a.AppointmentDate', 'a.AppointmentTime', 'a.AppointmentStatus')
                ->leftJoin('appointments as a', function ($join) use ($patientId) {
                    $join->on('a.PatientID', '=', 'df.PatientID')
                        ->where('a.created_at', '<=', 'df.created_at')
                        ->where('a.PatientID', '=', $patientId);
                })
                ->where('df.PatientID', $patientId)
                ->orderBy('df.created_at', 'desc')
                ->orderBy('a.created_at', 'desc')
                ->get()
                ->groupBy('DentalFormID');

            // Map the results to the desired format
            $formsWithAppointments = $dentalForms->map(function ($forms, $dentalFormId) {
                $form = $forms->first(); // Take the first row (most recent appointment)
                return [
                    'DentalFormID' => $form->DentalFormID,
                    'PatientID' => $form->PatientID,
                    'FileName' => $form->FileName,
                    'FileType' => $form->FileType,
                    'created_at' => $form->created_at,
                    'Appointment' => $form->AppointmentID ? [
                        'AppointmentID' => $form->AppointmentID,
                        'AppointmentDate' => $form->AppointmentDate,
                        'AppointmentTime' => $form->AppointmentTime,
                        'AppointmentStatus' => $form->AppointmentStatus,
                    ] : null,
                ];
            })->values();

            return response()->json($formsWithAppointments, 200);
        } catch (\Exception $e) {
            Log::error('Failed to fetch dental forms', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'patientId' => $patientId ?? 'not_set',
                'userId' => $authenticatedUserId ?? 'not_set',
            ]);
            return response()->json(['message' => 'Failed to fetch dental forms due to an internal error'], 500);
        }
    }

    public function saveDentalForm(Request $request)
    {
        try {
            Log::info('Incoming request to save-dental-form', [
                'PatientID' => $request->input('PatientID'),
                'FileName' => $request->input('FileName'),
                'FileType' => $request->input('FileType'),
                'FileContent_exists' => $request->hasFile('FileContent'),
                'AppointmentID' => $request->input('AppointmentID'),
            ]);

            // Validate incoming request data
            $request->validate([
                'PatientID' => 'required|integer',
                'FileName' => 'required|string|max:255',
                'FileContent' => 'required|file',
                'FileType' => 'required|string|in:application/pdf,image/jpeg,image/png,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/msword',
                'AppointmentID' => 'nullable|integer|exists:appointments,AppointmentID',
            ]);

            $patientId = $request->input('PatientID');
            $fileName = $request->input('FileName');
            $fileType = $request->input('FileType');
            $fileContent = $request->file('FileContent')->get();
            $appointmentId = $request->input('AppointmentID');

            // Map the MIME type to the enum value
            $fileTypeMap = [
                'application/pdf' => 'pdf',
                'image/jpeg' => 'jpg',
                'image/png' => 'png',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
                'application/msword' => 'doc',
            ];
            $fileType = $fileTypeMap[$fileType] ?? 'pdf';

            // Validate that the mapped FileType is in the allowed enum values
            $allowedFileTypes = ['jpg', 'png', 'docx', 'pdf', 'doc'];
            if (!in_array($fileType, $allowedFileTypes)) {
                throw new \Exception('Invalid FileType: ' . $fileType);
            }

            // Get the authenticated user's UserID
            $uploadedBy = Auth::id();
            if (!$uploadedBy) {
                throw new \Exception('User not authenticated');
            }

            // Verify that the authenticated user is the patient or has permission
            $patient = DB::table('patients')->where('PatientID', $patientId)->first();
            if (!$patient || $patient->UserID != $uploadedBy) {
                throw new \Exception('Unauthorized: PatientID does not match the authenticated user');
            }

            Log::info('FileContent size', ['size' => strlen($fileContent)]);

            // Log the data to be inserted
            Log::info('Data to be inserted into dental_forms', [
                'PatientID' => $patientId,
                'FileName' => $fileName,
                'FileType' => $fileType,
                'UploadedBy' => $uploadedBy,
                'AppointmentID' => $appointmentId,
                'FileContent_size' => strlen($fileContent),
            ]);

            // Insert into dental_forms table within a transaction
            DB::transaction(function () use ($patientId, $fileName, $fileContent, $fileType, $uploadedBy, $appointmentId) {
                DB::table('dental_forms')->insert([
                    'PatientID' => $patientId,
                    'FileName' => $fileName,
                    'FileContent' => $fileContent,
                    'FileType' => $fileType,
                    'UploadedBy' => $uploadedBy,
                    'AppointmentID' => $appointmentId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });

            Log::info('Dental form saved successfully', ['FileName' => $fileName]);

            return response()->json(['message' => 'Form saved successfully'], 201);
        } catch (\Exception $e) {
            Log::error('Failed to save dental form', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'patientId' => $patientId ?? 'not_set',
                'fileName' => $fileName ?? 'not_set',
                'fileType' => $fileType ?? 'not_set',
                'uploadedBy' => $uploadedBy ?? 'not_set',
                'appointmentId' => $appointmentId ?? 'not_set',
                'fileContent_size' => isset($fileContent) ? strlen($fileContent) : 'not_set',
            ]);

            return response()->json(['message' => 'Failed to save form due to an internal error'], 500);
        }
    }

    public function downloadPatientDentalForm(Request $request, $id)
    {
        try {
            // Get the authenticated user
            $authenticatedUserId = Auth::id();
            if (!$authenticatedUserId) {
                return response()->json(['message' => 'User not authenticated'], 401);
            }

            // Fetch the patient's PatientID based on the authenticated user's UserID
            $patient = DB::table('patients')
                ->where('UserID', $authenticatedUserId)
                ->first();

            if (!$patient) {
                return response()->json(['message' => 'Patient record not found for the authenticated user'], 404);
            }

            $patientId = $patient->PatientID;

            // Fetch the dental form
            $dentalForm = DB::table('dental_forms')
                ->where('DentalFormID', $id)
                ->where('PatientID', $patientId)
                ->first();

            if (!$dentalForm) {
                return response()->json(['message' => 'Dental form not found or access denied'], 404);
            }

            // Map FileType to MIME type
            $mimeTypeMap = [
                'pdf' => 'application/pdf',
                'jpg' => 'image/jpeg',
                'png' => 'image/png',
                'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'doc' => 'application/msword',
            ];
            $mimeType = $mimeTypeMap[$dentalForm->FileType] ?? 'application/octet-stream';

            // Determine if the response should be inline (preview) or attachment (download)
            $inline = $request->query('inline', false) === 'true';
            $disposition = $inline ? 'inline' : 'attachment';

            // Log the action for debugging
            Log::info('Downloading dental form', [
                'DentalFormID' => $id,
                'PatientID' => $patientId,
                'FileName' => $dentalForm->FileName,
                'FileType' => $dentalForm->FileType,
                'Disposition' => $disposition,
                'FileContent_size' => strlen($dentalForm->FileContent),
            ]);

            // Return the file content as a response
            return response($dentalForm->FileContent, 200)
                ->header('Content-Type', $mimeType)
                ->header('Content-Disposition', "$disposition; filename=\"{$dentalForm->FileName}\"")
                ->header('Content-Length', strlen($dentalForm->FileContent));
        } catch (\Exception $e) {
            Log::error('Failed to download dental form', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'dentalFormId' => $id,
                'patientId' => $patientId ?? 'not_set',
                'userId' => $authenticatedUserId ?? 'not_set',
            ]);
            return response()->json(['message' => 'Failed to download dental form due to an internal error'], 500);
        }
    }
}