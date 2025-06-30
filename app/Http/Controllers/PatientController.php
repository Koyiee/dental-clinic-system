<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::join('users', 'patients.UserID', '=', 'users.UserID')
            ->join('user_accounts', 'user_accounts.UserID', '=', 'users.UserID')
            ->select(
                'users.UserID', // Include UserID
                'users.LastName',
                'users.FirstName',
                'users.MiddleName',
                'user_accounts.AccountStatus' // Include AccountStatus
            )
            ->get();
    
        return response()->json($patients);
    }

    // Function to add a new patient
    public function store(Request $request)
    {
        $request->validate([
            'UserID' => 'required|exists:users,UserID',
            'GuardianID' => 'nullable|integer',
            'Occupation' => 'nullable|string',
            'Religion' => 'nullable|string',
            'Nationality' => 'nullable|string',
            'MaritalStatus' => 'nullable|string',
            'GovernmentID' => 'nullable|string',
            'ReferredBy' => 'nullable|string',
        ]);

        Patient::create($request->all());

        return response()->json(['message' => 'Patient added successfully'], 201);
    }

    public function indexForHr(Request $request)
    {
        $patients = Patient::with('user')
            ->get()
            ->map(function ($patient) {
                return [
                    'PatientID' => $patient->PatientID, // Match frontend expectation
                    'name' => $patient->user->FirstName . ' ' . $patient->user->LastName,
                ];
            });

        return response()->json($patients);
    }

    public function getOwnerPatients(Request $request)
    {
        try {
            $patients = Patient::with(['user' => function ($query) {
                $query->select('UserID', 'FirstName', 'LastName');
            }])->get()->map(function ($patient) {
                return [
                    'PatientID' => $patient->PatientID,
                    'user' => [
                        'UserID' => $patient->user->UserID,
                        'FirstName' => $patient->user->FirstName,
                        'LastName' => $patient->user->LastName,
                    ]
                ];
            });
            return response()->json($patients);
        } catch (\Exception $e) {
            Log::error('Error fetching patients: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to fetch patients'], 500);
        }
    }



}
