<?php

namespace App\Http\Controllers\Hr;

use App\Models\Appointment;
use App\Models\Dentist;
use App\Models\User;
use App\Models\UserAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Events\UserActionOccurred;
use App\Http\Controllers\Controller;

class DentistController extends Controller
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
            'DayOff' => 'nullable|array',
            'DayOff.*' => 'string',
        ]);

        // Ensure HR admin is authenticated
        $hrAdmin = Auth::user();
        if (!$hrAdmin) {
            \Log::error('No authenticated user');
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        DB::transaction(function () use ($validatedData, $hrAdmin) {
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

            $account = UserAccount::create([
                'UserID' => $user->UserID,
                'Username' => $validatedData['Username'],
                'Password' => Hash::make($validatedData['Password']),
                'UserType' => 'Dentist',
                'AccountStatus' => 'active',
            ]);

            Dentist::create([
                'UserID' => $user->UserID,
                'DayOff' => $validatedData['DayOff'] ? json_encode($validatedData['DayOff']) : null,
            ]);

            // Dispatch UserActionOccurred event
            event(new UserActionOccurred(
                $hrAdmin->UserID,
                'Account Created',
                "HR Admin {$hrAdmin->FirstName} {$hrAdmin->LastName} created {$account->UserType} account for {$user->FirstName} {$user->LastName}"
            ));
            \Log::info('Dentist account created successfully', [
                'user_id' => $user->UserID,
                'hr_admin_id' => $hrAdmin->UserID,
            ]);
        });

        return response()->json([
            'message' => 'Dentist account created successfully!',
        ], 201);
    }

    public function index()
    {
        try {
            $dentists = Dentist::with(['user' => function ($query) {
                    $query->join('user_accounts', 'user_accounts.UserID', '=', 'users.UserID')
                          ->whereIn('user_accounts.AccountStatus', ['active', 'deactivated'])
                          ->select(
                              'users.UserID',
                              'users.FirstName',
                              'users.LastName',
                              'user_accounts.AccountStatus'
                          );
                }])
                ->get();
    
            \Log::info('Fetched dentists count: ' . $dentists->count());
    
            $formattedDentists = $dentists->map(function ($dentist) {
                if (!$dentist->user) {
                    \Log::warning('Dentist missing user data', [
                        'DentistID' => $dentist->DentistID,
                        'UserID' => $dentist->UserID
                    ]);
                    return null; // Skip this dentist
                }
                return [
                    'UserID' => $dentist->user->UserID,
                    'FirstName' => $dentist->user->FirstName ?? '',
                    'LastName' => $dentist->user->LastName ?? '',
                    'AccountStatus' => $dentist->user->AccountStatus ?? 'unknown'
                ];
            })->filter(); // Remove null entries
    
            \Log::info('Formatted dentists: ' . json_encode($formattedDentists));
    
            return response()->json($formattedDentists);
        } catch (\Exception $e) {
            \Log::error('Error in DentistController@index: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function getAvailability($date, Request $request = null)
{
    $time = $request ? $request->query('time') : null; // Make time optional
    $dateTime = new \DateTime($date);
    $dayOfWeek = $dateTime->format('l');
    \Log::info("Checking dentist availability for Date: {$date}, Day of Week: {$dayOfWeek}");

    // Fetch all active dentists
    $dentists = Dentist::join('user_accounts', 'dentists.UserID', '=', 'user_accounts.UserID')
        ->where('user_accounts.AccountStatus', 'active')
        ->select('dentists.DentistID', 'dentists.DayOff')
        ->get();

    // Dentists unavailable due to day-off
    $unavailableDueToDayOff = $dentists->filter(function ($dentist) use ($dayOfWeek) {
        $dayOff = json_decode($dentist->DayOff, true);
        return is_array($dayOff) && in_array($dayOfWeek, $dayOff);
    })->pluck('DentistID')->toArray();

    \Log::info("Dentists unavailable due to day-off on {$dayOfWeek}: " . json_encode($unavailableDueToDayOff));

    // Dentists unavailable due to conflicting Pending appointments (only if time is provided)
    $unavailableDueToConflicts = [];
    if ($time) {
        $conflictingAppointments = Appointment::where('AppointmentDate', $date)
            ->where('AppointmentTime', $time)
            ->where('AppointmentStatus', 'Pending')
            ->whereNotNull('DentistID')
            ->pluck('DentistID')
            ->unique()
            ->toArray();

        $unavailableDueToConflicts = $conflictingAppointments;
        \Log::info("Dentists unavailable due to conflicting appointments at {$time}: " . json_encode($unavailableDueToConflicts));
    }

    // Combine unavailable dentists
    $unavailableDentists = array_unique(array_merge($unavailableDueToDayOff, $unavailableDueToConflicts));

    \Log::info("Total unavailable dentists for {$date}" . ($time ? " at {$time}" : "") . ": " . json_encode($unavailableDentists));

    return response()->json(['unavailable_dentists' => $unavailableDentists]);
}

    public function getDentistMapping()
    {
        $dentists = Dentist::join('users', 'dentists.UserID', '=', 'users.UserID')
            ->join('user_accounts', 'dentists.UserID', '=', 'user_accounts.UserID')
            ->where('user_accounts.UserType', 'Dentist')
            ->where('user_accounts.AccountStatus', 'active')
            ->select('dentists.UserID', 'dentists.DentistID', 'users.FirstName', 'users.LastName')
            ->get();

        return response()->json($dentists->map(function ($dentist) {
            return [
                'UserID' => $dentist->UserID,
                'DentistID' => $dentist->DentistID,
                'FirstName' => $dentist->FirstName,
                'LastName' => $dentist->LastName,
            ];
        }));
    }

    public function getDaysOff($userId)
    {
        $dentist = Dentist::where('UserID', $userId)->first();
        if (!$dentist) {
            return response()->json(['error' => 'Dentist not found'], 404);
        }
        return response()->json([
            'DayOff' => $dentist->DayOff ? json_decode($dentist->DayOff, true) : []
        ]);
    }
    
    public function updateDaysOff(Request $request, $userId)
    {
        $dentist = Dentist::where('UserID', $userId)->first();
        if (!$dentist) {
            return response()->json(['error' => 'Dentist not found'], 404);
        }
    
        $validatedData = $request->validate([
            'DayOff' => 'nullable|array|max:2',
            'DayOff.*' => 'string|in:Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
        ]);
    
        $dentist->update([
            'DayOff' => $validatedData['DayOff'] ? json_encode($validatedData['DayOff']) : null,
        ]);
    
        return response()->json(['message' => 'Days off updated successfully']);
    }

}
