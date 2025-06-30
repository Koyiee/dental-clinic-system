<?php

namespace App\Http\Controllers;

use App\Models\PatientNote;
use App\Models\HRAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PatientNoteController extends Controller
{
    public function index($patientId)
    {
        $notes = PatientNote::where('PatientID', $patientId)
            ->with(['dentist', 'hradmin'])
            ->get();
        return response()->json($notes);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'PatientID' => 'required|exists:patients,PatientID',
                'NoteDescription' => 'required|string|max:1000',
            ]);

            $user = Auth::user();
            $dentistId = null;
            $hrAdminId = null;

            if ($user->isDentist()) {
                $dentistId = Auth::id();
            } elseif ($user->isHRAdmin()) {
                $hrAdmin = HRAdmin::where('UserID', Auth::id())->first();
                if (!$hrAdmin) {
                    Log::warning('No HRAdmin record found for UserID: ' . Auth::id());
                    return response()->json(['error' => 'HR Admin record not found for this user'], 400);
                }
                $hrAdminId = $hrAdmin->HRAdminID;
            } else {
                return response()->json(['error' => 'Unauthorized: User is not a Dentist or HR Admin'], 403);
            }

            $note = PatientNote::create([
                'PatientID' => $request->PatientID,
                'DentistID' => $dentistId,
                'HRAdminID' => $hrAdminId,
                'NoteDescription' => $request->NoteDescription,
            ]);

            return response()->json($note->load(['dentist', 'hradmin']), 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Validation failed', 'messages' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Error saving patient note: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Failed to save note', 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $note = PatientNote::findOrFail($id);
            $user = Auth::user();
            $isAuthorized = false;

            if ($user->isDentist() && $note->DentistID === Auth::id()) {
                $isAuthorized = true;
            } elseif ($user->isHRAdmin()) {
                $hrAdmin = HRAdmin::where('UserID', Auth::id())->first();
                if ($hrAdmin && $note->HRAdminID === $hrAdmin->HRAdminID) {
                    $isAuthorized = true;
                }
            }

            if (!$isAuthorized) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            $request->validate([
                'NoteDescription' => 'required|string|max:1000',
            ]);

            $note->update([
                'NoteDescription' => $request->NoteDescription,
            ]);

            return response()->json($note->load(['dentist', 'hradmin']));
        } catch (\Exception $e) {
            Log::error('Error updating patient note: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Failed to update note', 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $note = PatientNote::findOrFail($id);
            $user = Auth::user();
            $isAuthorized = false;

            if ($user->isDentist() && $note->DentistID === Auth::id()) {
                $isAuthorized = true;
            } elseif ($user->isHRAdmin()) {
                $hrAdmin = HRAdmin::where('UserID', Auth::id())->first();
                if ($hrAdmin && $note->HRAdminID === $hrAdmin->HRAdminID) {
                    $isAuthorized = true;
            }
            }

            if (!$isAuthorized) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            $note->delete();
            return response()->json(['message' => 'Note deleted']);
        } catch (\Exception $e) {
            Log::error('Error deleting patient note: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Failed to delete note', 'message' => $e->getMessage()], 500);
        }
    }
}
