<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserAccount;
use App\Models\Owner;
use App\Models\Patient; 
use App\Mail\AccountCreated;
use App\Events\UserActionOccurred;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Services\BrevoMailService;

class UserController extends Controller
{
    public function update(Request $request, $patientId)
    {
        try {
            $validatedData = $request->validate([
                'firstName' => 'required|string|max:255',
                'lastName' => 'required|string|max:255',
                'birthdate' => 'required|date',
                'gender' => 'required|string|in:Male,Female,Other',
                'email' => 'required|email|max:255|unique:users,email,' . $request->user()->UserID . ',UserID',
                'contactNumber' => 'required|regex:/^\+63\d{10}$/',
                'telephoneNumber' => 'nullable|string|max:20',
                'officeNumber' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:255',
                'religion' => 'nullable|string|max:255',
                'nationality' => 'nullable|string|max:255',
                'status' => 'required|string|in:Single,Married,Divorced,Widowed',
                'occupation' => 'nullable|string|max:255',
                'guardianName' => 'nullable|string|max:255',
                'guardianTel' => 'nullable|string|max:20',
                'profilePicture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            DB::beginTransaction();

            $patient = Patient::where('PatientID', $patientId)->firstOrFail();
            $user = User::findOrFail($patient->UserID);

            $user->FirstName = $validatedData['firstName'];
            $user->LastName = $validatedData['lastName'];
            $user->BirthDate = $validatedData['birthdate'];
            $user->Gender = $validatedData['gender'];
            $user->Email = $validatedData['email'];
            $user->ContactNumber = $validatedData['contactNumber'];
            $user->HomeTelephoneNumber = $validatedData['telephoneNumber'];
            $user->OfficeNumber = $validatedData['officeNumber'];
            $user->Address = $validatedData['address'];

            if ($request->hasFile('profilePicture')) {
                $profilePicturePath = $request->file('profilePicture')->store('profile_pictures', 'public');
                $user->ProfilePicture = $profilePicturePath;
            }

            $birthdate = new \DateTime($validatedData['birthdate']);
            $today = new \DateTime();
            $user->Age = $today->diff($birthdate)->y;

            $user->save();

            $patient->Religion = $validatedData['religion'];
            $patient->Nationality = $validatedData['nationality'];
            $patient->MaritalStatus = $validatedData['status'];
            $patient->Occupation = $validatedData['occupation'];
            $patient->GuardianName = $validatedData['guardianName'];
            $patient->GuardianTelNumber = $validatedData['guardianTel'];
            $patient->save();

            session([
                'user_age' => $user->Age,
                'user_first_name' => $user->FirstName,
                'user_last_name' => $user->LastName,
                'user_email' => $user->Email,
                'user_gender' => $user->Gender,
                'user_birthdate' => $user->BirthDate,
                'user_contact_number' => $user->ContactNumber,
                'user_religion' => $patient->Religion,
                'user_nationality' => $patient->Nationality,
                'user_status' => $patient->MaritalStatus,
                'user_address' => $user->Address,
                'user_telephoneNumber' => $user->HomeTelephoneNumber,
                'user_occupation' => $patient->Occupation,
                'user_officeNumber' => $user->OfficeNumber,
            ]);

            event(new UserActionOccurred(
                auth()->id(),
                'Profile Updated',
                "Patient {$user->FirstName} {$user->LastName} updated their personal information"
            ));

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Patient information updated successfully',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error updating patient information: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update patient information'
            ], 500);
        }
    }

    public function store(Request $request)
    {
        \Log::info('Signup attempt started', [
            'username' => $request->input('Username'),
            'email' => $request->input('Email'),
            'password_length' => strlen($request->input('Password')),
            'raw_password' => substr($request->input('Password'), 0, 3) . '...' // Avoid logging full password
        ]);
    
        $validatedData = $request->validate([
            'LastName' => 'required|string|max:255',
            'FirstName' => 'required|string|max:255',
            'MiddleName' => 'nullable|string|max:255',
            'ContactNumber' => 'required|regex:/^\+63\d{10}$/',
            'Email' => 'required|email|unique:users,email',
            'Username' => 'required|string|max:255|unique:user_accounts,Username',
            'Password' => 'required|string|min:8|confirmed|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/',
            'Gender' => 'required|string',
            'BirthDate' => 'required|date',
            'Religion' => 'nullable|string|max:255',
            'Nationality' => 'nullable|string|max:255',
            'MaritalStatus' => 'required|string|in:Single,Married,Divorced,Widowed',
            'HomeAddress' => 'nullable|string|max:255',
            'HomeTelephoneNumber' => 'nullable|string|max:20',
            'Occupation' => 'nullable|string|max:255',
            'OfficeNumber' => 'nullable|string|max:20',
            'ReferredBy' => 'nullable|string|max:255',
            'Age' => 'required|integer|min:0',
            'GovernmentID' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'profilePicture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        \Log::info('Validation passed', [
            'username' => $validatedData['Username'],
            'password_length' => strlen($validatedData['Password']),
            'validated_password' => substr($validatedData['Password'], 0, 3) . '...'
        ]);
    
        \DB::beginTransaction();
    
        try {
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
                'ProfilePicture' => $request->hasFile('profilePicture')
                    ? $request->file('profilePicture')->store('profile_pictures', 'public')
                    : null,
            ]);
    
            // Create the user account
            $hashedPassword = Hash::make($validatedData['Password']);
            \Log::info('Password hashed', [
                'username' => $validatedData['Username'],
                'hash_prefix' => substr($hashedPassword, 0, 20) . '...'
            ]);
    
            $account = new UserAccount([
                'UserID' => $user->UserID,
                'Username' => $validatedData['Username'],
                'Password' => $hashedPassword,
                'UserType' => 'Patient',
                'AccountStatus' => 'active',
            ]);
            $account->save();
    
            \Log::info('UserAccount created', [
                'username' => $account->Username,
                'account_id' => $account->AccountID,
                'stored_hash' => substr($account->Password, 0, 20) . '...'
            ]);
    
            // Handle government ID upload
            $governmentIDPath = null;
            if ($request->hasFile('GovernmentID')) {
                $governmentIDPath = $request->file('GovernmentID')->store('government_ids', 'public');
            }
    
            // Create the patient record
            $patient = new Patient([
                'UserID' => $user->UserID,
                'GuardianID' => null,
                'Occupation' => $validatedData['Occupation'],
                'Religion' => $validatedData['Religion'],
                'Nationality' => $validatedData['Nationality'],
                'MaritalStatus' => $validatedData['MaritalStatus'],
                'GovernmentID' => $governmentIDPath,
                'ReferredBy' => $validatedData['ReferredBy'],
            ]);
            $patient->save();
    
            // Check if the request is from an authenticated HR admin
            $hrAdmin = Auth::user();
            if ($hrAdmin && $hrAdmin->userAccount->UserType === 'HRAdmin') {
                // Log HR admin action
                event(new UserActionOccurred(
                    $hrAdmin->UserID,
                    'Account Created',
                    "HR Admin {$hrAdmin->FirstName} {$hrAdmin->LastName} created Patient account for {$user->FirstName} {$user->LastName}"
                ));
                \Log::info('Patient account created by HR Admin', [
                    'user_id' => $user->UserID,
                    'hr_admin_id' => $hrAdmin->UserID,
                ]);
            } else {
                // Log public signup action
                event(new UserActionOccurred(
                    $user->UserID,
                    'Account Created',
                    "Patient {$user->FirstName} {$user->LastName} created their account via signup"
                ));
                \Log::info('Patient account created via public signup', [
                    'user_id' => $user->UserID,
                ]);
            }
    
            // Send account creation email
            try {
                // Retrieve the UserAccount by Username
                $userAccount = UserAccount::where('Username', $validatedData['Username'])->first();
            
                if ($userAccount) {
                    $brevo = new BrevoMailService();
                    // Pass the username explicitly to the email view
                    $html = view('account_created', [
                        'user' => $user,  // User details (first name, last name, etc.)
                        'username' => $userAccount->Username,  // Username from UserAccount
                    ])->render();
            
                    // Send the email
                    $brevo->sendEmail(
                        $user->Email,
                        'Account Created Successfully',
                        $html
                    );
            
                    \Log::info('Account creation email sent', ['email' => $user->Email]);
                } else {
                    \Log::error('UserAccount not found for username: ' . $validatedData['Username']);
                }
            } catch (\Exception $e) {
                \Log::error('Email sending failed: ' . $e->getMessage());
            }
    
            \DB::commit();
    
            \Log::info('Signup successful', [
                'username' => $account->Username,
                'user_id' => $user->UserID,
                'account_id' => $account->AccountID
            ]);
    
            return response()->json([
                'message' => 'Account created successfully!',
                'redirectUrl' => route('login'),
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \DB::rollBack();
            \Log::error('Validation failed during signup', ['errors' => $e->errors()]);
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Error creating patient account: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to create account',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        \Log::info('Login attempt started for username: ' . $request->input('Username'));

        $validatedData = $request->validate([
            'Username' => 'required|string',
            'Password' => 'required|string',
        ]);

        $userAccount = UserAccount::where('Username', $validatedData['Username'])->first();

        if ($userAccount && Hash::check($validatedData['Password'], $userAccount->Password)) {
            // Update last_login_at for all successful logins
            $updates = ['last_login_at' => now()];

            // If patient is archived, reactivate on login
            if ($userAccount->UserType === 'Patient' && $userAccount->AccountStatus === 'archived') {
                $updates['AccountStatus'] = 'active';
            } elseif ($userAccount->AccountStatus !== 'active') {
                // Deactivated accounts (or non-patient archived) can't log in
                return response()->json([
                    'status' => 'Login failed!',
                    'errors' => ['Account is deactivated'],
                ], 401);
            }

            // Apply the updates
            $userAccount->update($updates);

            Auth::loginUsingId($userAccount->UserID);

            $user = User::find($userAccount->UserID);
            $patient = Patient::where('UserID', $userAccount->UserID)->first();

            \Log::info('Fetched Patient:', ['patient' => $patient]);
            
            $uniqueId = uniqid(); // Add a unique ID to track this event
            \Log::info('Dispatching UserActionOccurred with ID: ' . $uniqueId);
            event(new UserActionOccurred(
                $user->UserID, 
                'Logged In', 
                "{$userAccount->UserType} {$user->FirstName} {$user->LastName} logged in."
            ));

            session([
                'user_patientId' => $patient ? $patient->PatientID : null,
                'user_age' => $user->Age,
                'user_first_name' => $user->FirstName,
                'user_last_name' => $user->LastName,
                'user_email' => $user->Email,
                'user_gender' => $user->Gender,
                'user_birthdate' => $user->BirthDate,
                'user_contact_number' => $user->ContactNumber,
                'user_religion' => $patient ? $patient->Religion : null,
                'user_nationality' => $patient ? $patient->Nationality : null,
                'user_status' => $patient ? $patient->MaritalStatus : null,
                'user_address' => $user->Address,
                'user_telephoneNumber' => $user->HomeTelephoneNumber,
                'user_occupation' => $patient ? $patient->Occupation : null,
                'user_officeNumber' => $user->OfficeNumber,
                'user_profile_picture' => $user->ProfilePicture,
                'user_guardianName' => $patient ? $patient->GuardianName : null,
                'user_guardianTel' => $patient ? $patient->GuardianTelNumber : null,
            ]);

            $redirectUrl = match ($userAccount->UserType) {
                'Patient' => route('patientdashboard'),
                'Dentist' => route('dentistdashboard'),
                'HRAdmin' => route('hrdashboard'),
                'Owner' => route('ownerdashboard'),
                default => route('home'),
            };

            return response()->json([
                'status' => 'Login successful!',
                'redirectUrl' => $redirectUrl,
            ]);
        }

        return response()->json([
            'status' => 'Login failed!',
            'errors' => ['Username or password is incorrect'],
        ], 401);
    }

    public function logout(Request $request)
    {
        try {
            $user = Auth::user();
            
            if ($user) {
                $userAccount = UserAccount::where('UserID', $user->UserID)->first();
                
                \Log::info('Logout attempt started for user: ' . $user->UserID);
    
                // Trigger the logout event
                event(new UserActionOccurred(
                    $user->UserID,
                    'Logged Out',
                    "{$userAccount->UserType} {$user->FirstName} {$user->LastName} logged out."
                ));
    
                // Perform the logout
                Auth::logout();
                
                // Invalidate the session
                $request->session()->invalidate();
                $request->session()->regenerateToken();
    
                \Log::info('User logged out successfully: ' . $user->UserID);
    
                return redirect()->route('login');
            }
    
            return redirect()->route('login')->with('error', 'No active session found');
        } catch (\Exception $e) {
            \Log::error('Error during logout: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'An error occurred during logout');
        }
    }

    public function getDentists()
    {
        try {
            \Log::info('Fetching active dentists...');
            
            $dentists = DB::table('dentists')
            ->join('user_accounts', 'user_accounts.UserID', '=', 'dentists.UserID')
            ->join('users', 'users.UserID', '=', 'user_accounts.UserID')
            ->where('user_accounts.UserType', 'Dentist')
            ->where('user_accounts.AccountStatus', 'active')
            ->select(
                'dentists.DentistID',
                DB::raw("CONCAT(users.FirstName, ' ', users.LastName) as Name")
            )
            ->get();      
        
            \Log::info('Fetched active dentists: ', $dentists->toArray());
        
            return response()->json($dentists);
        } catch (\Exception $e) {
            \Log::error('Error fetching active dentists: ' . $e->getMessage());
            return response()->json([], 500);
        }
    }       

    public function getPatientId()
    {
        $user = Auth::user();
    
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    
        $patient = Patient::where('UserID', $user->UserID)->first();
    
        if ($patient) {
            return response()->json(['patient_id' => $patient->PatientID]);
        }
    
        return response()->json(['error' => 'Patient not found'], 404);
    }  
    
    public function storeOwner(Request $request)
    {
        $validatedData = $request->validate([
            'LastName' => 'required|string|max:255',
            'FirstName' => 'required|string|max:255',
            'MiddleName' => 'nullable|string|max:255',
            'ContactNumber' => 'required|regex:/^\+63\d{10}$/',
            'Email' => 'required|email|unique:users,email',
            'Username' => 'required|string|max:255|unique:user_accounts,Username',
            'Password' => 'required|string|min:8|confirmed',
            'Gender' => 'required|string',
            'BirthDate' => 'required|date',
            'HomeAddress' => 'nullable|string|max:255',
            'HomeTelephoneNumber' => 'nullable|string|max:20',
            'OfficeNumber' => 'nullable|string|max:20',
            'Age' => 'required|integer|min:0',
            'IsSuperOwner' => 'nullable|boolean', // Add validation for IsSuperOwner
        ]);
    
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
    
        $account = new UserAccount([
            'UserID' => $user->UserID,
            'Username' => $validatedData['Username'],
            'Password' => bcrypt($validatedData['Password']), // Ensure password is hashed
            'UserType' => 'Owner',
            'AccountStatus' => 'active',
        ]);
        $account->save();
    
        $owner = new Owner([
            'UserID' => $user->UserID,
            'IsSuperOwner' => $validatedData['IsSuperOwner'] ?? false, // Default to false
        ]);
        $owner->save();
    
        // Send account creation email
            try {
                // Retrieve the UserAccount by Username
                $userAccount = UserAccount::where('Username', $validatedData['Username'])->first();
            
                if ($userAccount) {
                    $brevo = new BrevoMailService();
                    // Pass the username explicitly to the email view
                    $html = view('account_created', [
                        'user' => $user,  // User details (first name, last name, etc.)
                        'username' => $userAccount->Username,  // Username from UserAccount
                    ])->render();
            
                    // Send the email
                    $brevo->sendEmail(
                        $user->Email,
                        'Account Created Successfully',
                        $html
                    );
            
                    \Log::info('Account creation email sent', ['email' => $user->Email]);
                } else {
                    \Log::error('UserAccount not found for username: ' . $validatedData['Username']);
                }
            } catch (\Exception $e) {
                \Log::error('Email sending failed: ' . $e->getMessage());
            }
    
        return response()->json(['message' => 'Owner added successfully!'], 201);
    }

    public function getOwners()
    {
        try {
            $owners = DB::table('owners')
                ->join('user_accounts', 'user_accounts.UserID', '=', 'owners.UserID')
                ->join('users', 'users.UserID', '=', 'user_accounts.UserID')
                ->where('user_accounts.UserType', 'Owner')
                ->select(
                    'users.UserID', // Required by frontend for table and actions
                    'users.LastName',
                    'users.FirstName',
                    'user_accounts.AccountStatus',
                    'owners.IsSuperOwner'
                )
                ->get();
    
            return response()->json($owners);
        } catch (\Exception $e) {
            \Log::error('Error fetching owners: ' . $e->getMessage());
            return response()->json([], 500);
        }
    }

    public function checkEmail(Request $request)
    {
        $email = $request->input('email');
        $exists = User::where('email', $email)->exists();
        return response()->json(['exists' => $exists]);
    }
    
    public function checkUsername(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
        ]);

        $username = $request->input('username');
        $exists = UserAccount::where('Username', $username)->exists();
        return response()->json(['exists' => $exists]);
    }

    public function uploadProfilePicture(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'profilePicture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized',
                ], 403);
            }

            $patient = Patient::where('UserID', $user->UserID)->first();
            if (!$patient) {
                return response()->json([
                    'success' => false,
                    'message' => 'Patient not found',
                ], 404);
            }

            if ($request->hasFile('profilePicture')) {
                $profilePicturePath = $request->file('profilePicture')->store('profile_pictures', 'public');
                $user->ProfilePicture = $profilePicturePath;
                $user->save();

                // Log profile picture update
                event(new UserActionOccurred(
                    auth()->id(),
                    'Profile Picture Updated',
                    "Patient {$user->FirstName} {$user->LastName} updated their profile picture"
                ));

                // Update session
                session(['user_profile_picture' => $user->ProfilePicture]);

                return response()->json([
                    'success' => true,
                    'message' => 'Profile picture uploaded successfully',
                    'profilePicture' => $user->ProfilePicture,
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'No file uploaded',
            ], 400);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error uploading profile picture: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload profile picture',
            ], 500);
        }
    }

    public function getPatientData(Request $request)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }
    
            $patient = Patient::where('UserID', $user->UserID)->first();
            if (!$patient) {
                return response()->json(['success' => false, 'message' => 'Patient not found'], 404);
            }
    
            return response()->json([
                'success' => true,
                'patient' => [
                    'patientId' => $patient->PatientID,
                    'age' => $user->Age,
                    'firstName' => $user->FirstName,
                    'lastName' => $user->LastName,
                    'email' => $user->Email,
                    'gender' => $user->Gender,
                    'birthdate' => $user->BirthDate,
                    'contactNumber' => $user->ContactNumber,
                    'religion' => $patient->Religion,
                    'nationality' => $patient->Nationality,
                    'status' => $patient->MaritalStatus,
                    'address' => $user->Address,
                    'telephoneNumber' => $user->HomeTelephoneNumber,
                    'occupation' => $patient->Occupation,
                    'officeNumber' => $user->OfficeNumber,
                    'guardianName' => $patient->GuardianName,
                    'guardianTel' => $patient->GuardianTelNumber,
                    'profilePicture' => $user->ProfilePicture,
                    'GovernmentID' => $patient->GovernmentID, // Add this line to fetch from patients table
                ],
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching patient data: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to fetch patient data'], 500);
        }
    }

}
