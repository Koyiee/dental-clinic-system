<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserAccount;
use App\Models\HRAdmin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\AccountCreated;
use App\Services\BrevoMailService;

class HRAdminController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'LastName' => 'required|string|max:255',
            'FirstName' => 'required|string|max:255',
            'MiddleName' => 'nullable|string|max:255',
            'ContactNumber' => 'required|regex:/^\+63\d{10}$/',
            'HomeTelephoneNumber' => 'nullable|string|max:20',
            'OfficeNumber' => 'nullable|string|max:20',
            'Email' => 'required|email|unique:users,email',
            'BirthDate' => 'required|date',
            'Age' => 'required|integer|min:0',
            'Gender' => 'required|string',
            'HomeAddress' => 'nullable|string|max:255',
            'Username' => 'required|string|max:255|unique:user_accounts,Username',
            'Password' => 'required|string|min:8|confirmed',
        ]);

        // Ensure HR admin is authenticated
        $hrAdmin = Auth::user();
        if (!$hrAdmin) {
            \Log::error('No authenticated user');
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Create the user
        $user = User::create([
            'LastName' => $validatedData['LastName'],
            'FirstName' => $validatedData['FirstName'],
            'MiddleName' => $validatedData['MiddleName'],
            'ContactNumber' => $validatedData['ContactNumber'],
            'HomeTelephoneNumber' => $validatedData['HomeTelephoneNumber'],
            'OfficeNumber' => $validatedData['OfficeNumber'],
            'Email' => $validatedData['Email'],
            'BirthDate' => $validatedData['BirthDate'],
            'Age' => $validatedData['Age'],
            'Gender' => $validatedData['Gender'],
            'Address' => $validatedData['HomeAddress'],
        ]);

        // Create the user account
        $account = new UserAccount([
            'UserID' => $user->UserID,
            'Username' => $validatedData['Username'],
            'Password' => Hash::make($validatedData['Password']),
            'UserType' => 'HRAdmin',
            'AccountStatus' => 'active',
        ]);
        $account->save();

        // Create the HRAdmin record
        $hradmin = HRAdmin::create([
            'UserID' => $user->UserID,
        ]);

        // Determine user role for logging
        $userRole = $hrAdmin->userAccount && $hrAdmin->userAccount->UserType === 'Owner' ? 'Owner' : 'HR Admin';
        $userName = "{$hrAdmin->FirstName} {$hrAdmin->LastName}";

        // Dispatch UserActionOccurred event for account creation
        event(new \App\Events\UserActionOccurred(
            $hrAdmin->UserID,
            'Account Created',
            "{$userRole} {$userName} created {$account->UserType} account for {$user->FirstName} {$user->LastName}"
        ));

        // Send email notification
        try {
            
            // Manually render the Blade view for "AccountCreated" email
            $html = view('account_created', [
                'user' => $user,
            ])->render();

            $brevo = new BrevoMailService();
            $brevo->sendEmail(
                $user->Email,
                'Account Created Successfully',
                $html
            );
            
        } catch (\Exception $e) {
            \Log::error('Email sending failed: ' . $e->getMessage());
        }

        return response()->json([
            'message' => 'HR Admin account created successfully!',
            'redirectUrl' => route('hrdashboard'),
        ], 201);
    }
    
    public function index()
    {
        $hradmins = HRAdmin::with(['user' => function ($query) {
                $query->join('user_accounts', 'user_accounts.UserID', '=', 'users.UserID')
                      ->whereIn('user_accounts.AccountStatus', ['active', 'deactivated']) // Include both
                      ->select('users.UserID', 'users.FirstName', 'users.LastName', 'user_accounts.AccountStatus');
            }])
            ->get();
    
        $formatted = $hradmins->map(function ($hradmin) {
            return [
                'UserID' => $hradmin->user->UserID,
                'LastName' => $hradmin->user->LastName ?? '',
                'FirstName' => $hradmin->user->FirstName ?? '',
                'MiddleName' => $hradmin->user->MiddleName ?? '',
                'AccountStatus' => $hradmin->user->AccountStatus
            ];
        });
    
        return response()->json($formatted);
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'AccountID' => 'required|exists:user_accounts,UserID',
            'AccountStatus' => 'required|in:active,deactivated',
        ]);
    
        // Ensure HR admin or owner is authenticated
        $loggedUser = Auth::user();
        if (!$loggedUser) {
            \Log::error('No authenticated user');
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    
        // Check if the current user is HRAdmin or Owner
        if (!in_array($loggedUser->UserAccount->UserType, ['HRAdmin', 'Owner'])) {
            \Log::error('Unauthorized attempt to update status', ['user_id' => $loggedUser->UserID]);
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    
        // Find the user account
        $account = UserAccount::where('UserID', $request->AccountID)->firstOrFail();
    
        // Allow toggling for Dentist, HRAdmin, Owner, or Patient
        if (!in_array($account->UserType, ['Dentist', 'HRAdmin', 'Owner', 'Patient'])) {
            \Log::error('Invalid user type for status update', [
                'id' => $request->AccountID,
                'type' => $account->UserType
            ]);
            return response()->json(['error' => 'Can only toggle dentist, HR admin, owner, or patient accounts'], 400);
        }
    
        // If the target account is an Owner, check if it's the superowner
        if ($account->UserType === 'Owner') {
            $owner = \App\Models\Owner::where('UserID', $account->UserID)->first();
            if ($owner && $owner->IsSuperOwner && $request->AccountStatus === 'deactivated') {
                \Log::error('Attempt to deactivate superowner', [
                    'user_id' => $account->UserID,
                    'attempted_by' => $loggedUser->UserID
                ]);
                return response()->json(['message' => 'Superowner cannot be deactivated'], 403);
            }
        }
    
        // Get user details for logging
        $user = User::where('UserID', $account->UserID)->first();
        if (!$user) {
            \Log::error('User details not found', ['id' => $request->AccountID]);
            return response()->json(['message' => 'User details not found'], 404);
        }
    
        // Check if status is actually changing
        $previousStatus = $account->AccountStatus;
        if ($previousStatus === $request->AccountStatus) {
            return response()->json(['message' => 'No status change required'], 200);
        }
    
        // Update the account status
        $account->AccountStatus = $request->AccountStatus;
        $account->save();
    
        // Dispatch UserActionOccurred event for deactivation or activation
        $actionType = $request->AccountStatus === 'deactivated' ? 'User Deactivated' : 'User Activated';
        $actionMessage = $request->AccountStatus === 'deactivated'
            ? "{$loggedUser->UserAccount->UserType} {$loggedUser->FirstName} {$loggedUser->LastName} deactivated {$account->UserType} {$user->FirstName} {$user->LastName}"
            : "{$loggedUser->UserAccount->UserType} {$loggedUser->FirstName} {$loggedUser->LastName} activated {$account->UserType} {$user->FirstName} {$user->LastName}";
    
        event(new \App\Events\UserActionOccurred(
            $loggedUser->UserID,
            $actionType,
            $actionMessage
        ));
    
        \Log::info("User {$request->AccountStatus} successfully", [
            'user_id' => $account->UserID,
            'updated_by' => $loggedUser->UserID,
        ]);
    
        return response()->json(['message' => 'Status updated successfully']);
    }

    public function getOwners()
    {
        $owners = User::join('user_accounts', 'user_accounts.UserID', '=', 'users.UserID')
            ->join('owners', 'owners.UserID', '=', 'users.UserID') // Join with owners table to get IsSuperOwner
            ->where('user_accounts.UserType', 'Owner')
            ->whereIn('user_accounts.AccountStatus', ['active', 'deactivated']) // Include both active and deactivated
            ->select('users.UserID', 'users.LastName', 'users.FirstName', 'user_accounts.AccountStatus', 'owners.IsSuperOwner')
            ->get();
        return response()->json($owners);
    }

}
