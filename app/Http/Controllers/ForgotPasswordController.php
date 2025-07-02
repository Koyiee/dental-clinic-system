<?php

namespace App\Http\Controllers;

use App\Events\UserActionOccurred;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\ForgotPasswordMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Services\BrevoMailService;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    public function submitForgotPasswordForm(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    $user = User::where('Email', $value)->first();
                    if (!$user) {
                        $fail('The email does not exist in our records.');
                    }

                    if (!$user->userAccount) {
                        $fail('No user account found for this email.');
                    }
                },
            ],
        ]);

        DB::beginTransaction();
        try {
            DB::table('password_resets')->where('email', $request->email)->delete();
            $pin = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $expiresAt = Carbon::now()->addMinutes(5);

            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $pin,
                'created_at' => Carbon::now(),
                'expires_at' => $expiresAt,
            ]);

            try {
                $email = $request->email;

                // Manually render the same view used by your Mailable
                $html = view('emails.forgotpassword', [
                    'pin' => $pin,
                    'email' => $email,
                ])->render();
            
                // Send using your BrevoMailService
                $brevo = new BrevoMailService();
                $brevo->sendEmail(
                    $email,
                    'Password Reset Request',
                    $html
                );

            } catch (\Exception $mailException) {
                logger()->error('Failed to send password reset email:', [
                    'email' => $request->email,
                    'error' => $mailException->getMessage(),
                ]);
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Unable to send the reset PIN email. Please try again later or contact support.',
                ], 500);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'A 6-digit PIN has been sent to your email. It will expire in 5 minutes.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Error in processing password reset request:', [
                'error' => $e->getMessage(),
                'email' => $request->email,
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function verifyPin(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    $user = User::where('Email', $value)->first();
                    if (!$user) {
                        $fail('The email does not exist in our records.');
                    }

                    if (!$user->userAccount) {
                        $fail('No user account found for this email.');
                    }
                },
            ],
            'pin' => 'required|string',
        ]);

        $resetRecord = DB::table('password_resets')->where('email', $request->email)->first();
        if (!$resetRecord) {
            return response()->json(['success' => false, 'message' => 'No password reset request found for this email.']);
        }

        if ($request->pin === $resetRecord->token && Carbon::parse($resetRecord->expires_at)->isFuture()) {
            return response()->json(['success' => true, 'message' => 'PIN verified successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Invalid PIN or PIN has expired']);
        }
    }

    public function resetPassword(Request $request)
{
    try {
        $validated = $request->validate([
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    $user = User::where('Email', $value)->first();
                    if (!$user) {
                        $fail('The email does not exist in our records.');
                    }
                    if (!$user->userAccount) {
                        $fail('No user account found for this email.');
                    }
                },
            ],
            'pin' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        DB::beginTransaction();

        $resetRecord = DB::table('password_resets')
            ->where('email', $request->email)
            ->first();

        if (!$resetRecord) {
            return response()->json([
                'success' => false,
                'message' => 'No password reset request found for this email.',
            ], 400);
        }

        if ($validated['pin'] !== $resetRecord->token) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid PIN.',
            ], 400);
        }

        if (!Carbon::parse($resetRecord->expires_at)->isFuture()) {
            return response()->json([
                'success' => false,
                'message' => 'PIN has expired.',
            ], 400);
        }

        $user = User::where('Email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.',
            ], 404);
        }

        $account = $user->userAccount;
        if (!$account) {
            return response()->json([
                'success' => false,
                'message' => 'Account not found.',
            ], 404);
        }

        // Hash the new password before saving
        if (Hash::check($validated['password'], $account->Password)) {
            return response()->json([
                'success' => false,
                'message' => 'The new password cannot be the same as your current password.',
            ], 400);
        }

        if ($account->previous_password && Hash::check($validated['password'], $account->previous_password)) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot reuse your previous password.',
            ], 400);
        }

        // Hash the password before saving
        $account->previous_password = $account->Password;
        $account->password_change_count = $account->password_change_count + 1;
        $account->Password = Hash::make($validated['password']);  // Make sure to hash the password here
        $account->save();

        event(new UserActionOccurred(
            $user->UserID,
            'Password Changed',
            "{$account->UserType} {$user->FirstName} {$user->LastName} changed their password via forgot password."
        ));

        DB::table('password_resets')
            ->where('email', $request->email)
            ->delete();

        DB::commit();
        return response()->json([
            'success' => true,
            'message' => 'Password reset successfully.',
        ]);
    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Password reset failed: ' . $e->getMessage(), [
            'request' => $request->all(),
            'trace' => $e->getTraceAsString(),
        ]);
        return response()->json([
            'success' => false,
            'message' => 'An error occurred while resetting your password: ' . $e->getMessage(),
        ], 500);
    }
}


    public function showVerifyPinPage(Request $request)
    {
        $email = $request->query('email');
        return view('verifypin', compact('email'));
    }

    public function updatePatientPassword(Request $request)
{
    $user = Auth::user();

    $account = $user->userAccount;
    if (!$account) {
        return response()->json([
            'success' => false,
            'message' => 'Account not found.',
        ], 404);
    }

    $request->validate([
        'current_password' => [
            'required',
            function ($attribute, $value, $fail) use ($account) {
                if (!Hash::check($value, $account->Password)) {
                    $fail('The current password is incorrect.');
                }
            },
        ],
        'new_password' => [
            'required',
            'min:8',
            'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
            function ($attribute, $value, $fail) use ($account) {
                if (Hash::check($value, $account->Password)) {
                    $fail('The new password cannot be the same as the current password.');
                }
                if ($account->settings_previous_password) {
                    $previousPasswords = explode(',', $account->settings_previous_password);
                    foreach ($previousPasswords as $prevPass) {
                        if (Hash::check($value, $prevPass)) {
                            $fail('The new password cannot be the same as a previous password.');
                        }
                    }
                }
            },
        ],
        'confirm_password' => 'required|same:new_password',
    ], [
        'current_password.required' => 'Current password is required.',
        'new_password.required' => 'New password is required.',
        'new_password.min' => 'New password must be at least 8 characters.',
        'new_password.regex' => 'New password must include at least one uppercase letter, lowercase letter, number, and special character.',
        'confirm_password.required' => 'Confirm password is required.',
        'confirm_password.same' => 'Passwords do not match.',
    ]);

    DB::beginTransaction();
    try {
        $previousPassword = $account->Password;
        $account->Password = Hash::make($request->new_password); // Hash the new password
        $account->settings_password_change_count = ($account->settings_password_change_count ?? 0) + 1;

        if ($account->settings_previous_password) {
            $account->settings_previous_password = $account->settings_previous_password . ',' . $previousPassword;
        } else {
            $account->settings_previous_password = $previousPassword;
        }

        $account->save();

        event(new UserActionOccurred(
            $user->UserID,
            'Password Changed',
            "Patient {$user->FirstName} {$user->LastName} changed their password via settings."
        ));

        DB::commit();
        return response()->json([
            'success' => true, // Changed to boolean to align with resetPassword
            'message' => 'Password updated successfully!'
        ]);
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Error updating patient password: ' . $e->getMessage(), [
            'user_id' => $user->UserID,
            'trace' => $e->getTraceAsString(),
        ]);
        return response()->json([
            'success' => false,
            'message' => 'An error occurred while updating your password: ' . $e->getMessage(),
        ], 500);
    }
}

    public function updateDentistPassword(Request $request)
{
    $user = Auth::user();

    $account = $user->userAccount;
    if (!$account) {
        return response()->json([
 Ascending: [success] => false, [message] => 'Account not found.'], 404);
    }

    if ($account->UserType !== 'Dentist') {
        return response()->json([
            'success' => false,
            'message' => 'This action is only allowed for dentist accounts.'
        ], 403);
    }

    $request->validate([
        'current_password' => [
            'required',
            function ($attribute, $value, $fail) use ($account) {
                if (!Hash::check($value, $account->Password)) {
                    $fail('The current password is incorrect.');
                }
            },
        ],
        'new_password' => [
            'required',
            'min:8',
            'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
            function ($attribute, $value, $fail) use ($account) {
                if (Hash::check($value, $account->Password)) {
                    $fail('The new password cannot be the same as the current password.');
                }
                if ($account->settings_previous_password) {
                    $previousPasswords = explode(',', $account->settings_previous_password);
                    foreach ($previousPasswords as $prevPass) {
                        if (Hash::check($value, $prevPass)) {
                            $fail('The new password cannot be the same as a previous password.');
                        }
                    }
                }
            },
        ],
        'confirm_password' => 'required|same:new_password',
    ], [
        'current_password.required' => 'Current password is required.',
        'new_password.required' => 'New password is required.',
        'new_password.min' => 'New password must be at least 8 characters.',
        'new_password.regex' => 'New password must include at least one uppercase letter, lowercase letter, number, and special character.',
        'confirm_password.required' => 'Confirm password is required.',
        'confirm_password.same' => 'Passwords do not match.',
    ]);

    DB::beginTransaction();
    try {
        $previousPassword = $account->Password;
        $account->Password = Hash::make($request->new_password); // Hash the new password
        $account->settings_password_change_count = ($account->settings_password_change_count ?? 0) + 1;

        if ($account->settings_previous_password) {
            $account->settings_previous_password = $account->settings_previous_password . ',' . $previousPassword;
        } else {
            $account->settings_previous_password = $previousPassword;
        }

        $account->save();

        event(new UserActionOccurred(
            $user->UserID,
            'Password Changed',
            "Dentist {$user->FirstName} {$user->LastName} changed their password via settings."
        ));

        DB::commit();
        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully!'
        ]);
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Error updating dentist password: ' . $e->getMessage(), [
            'user_id' => $user->UserID,
            'trace' => $e->getTraceAsString(),
        ]);
        return response()->json([
            'success' => false,
            'message' => 'An error occurred while updating your password: ' . $e->getMessage(),
        ], 500);
    }
}

    public function updateHrPassword(Request $request)
{
    $user = Auth::user();

    $account = $user->userAccount;
    if (!$account) {
        return response()->json([
            'success' => false,
            'message' => 'Account not found.',
        ], 404);
    }

    if ($account->UserType !== 'HRAdmin') {
        return response()->json([
            'success' => false,
            'message' => 'This action is only allowed for HR Admin accounts.'
        ], 403);
    }

    $request->validate([
        'current_password' => [
            'required',
            function ($attribute, $value, $fail) use ($account) {
                if (!Hash::check($value, $account->Password)) {
                    $fail('The current password is incorrect.');
                }
            },
        ],
        'new_password' => [
            'required',
            'min:8',
            'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
            function ($attribute, $value, $fail) use ($account) {
                if (Hash::check($value, $account->Password)) {
                    $fail('The new password cannot be the same as the current password.');
                }
                if ($account->settings_previous_password) {
                    $previousPasswords = explode(',', $account->settings_previous_password);
                    foreach ($previousPasswords as $prevPass) {
                        if (Hash::check($value, $prevPass)) {
                            $fail('The new password cannot be the same as a previous password.');
                        }
                    }
                }
            },
        ],
        'confirm_password' => 'required|same:new_password',
    ], [
        'current_password.required' => 'Current password is required.',
        'new_password.required' => 'New password is required.',
        'new_password.min' => 'New password must be at least 8 characters.',
        'new_password.regex' => 'New password must include at least one uppercase letter, lowercase letter, number, and special character.',
        'confirm_password.required' => 'Confirm password is required.',
        'confirm_password.same' => 'Passwords do not match.',
    ]);

    DB::beginTransaction();
    try {
        $previousPassword = $account->Password;
        $account->Password = Hash::make($request->new_password); // Hash the new password
        $account->settings_password_change_count = ($account->settings_password_change_count ?? 0) + 1;

        if ($account->settings_previous_password) {
            $account->settings_previous_password = $account->settings_previous_password . ',' . $previousPassword;
        } else {
            $account->settings_previous_password = $previousPassword;
        }

        $account->save();

        event(new UserActionOccurred(
            $user->UserID,
            'Password Changed',
            "HRAdmin {$user->FirstName} {$user->LastName} changed their password via settings."
        ));

        DB::commit();
        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully!'
        ]);
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Error updating HR admin password: ' . $e->getMessage(), [
            'user_id' => $user->UserID,
            'trace' => $e->getTraceAsString(),
        ]);
        return response()->json([
            'success' => false,
            'message' => 'An error occurred while updating your password: ' . $e->getMessage(),
        ], 500);
    }
}

    public function updateOwnerPassword(Request $request)
{
    $user = Auth::user();

    $account = $user->userAccount;
    if (!$account) {
        return response()->json([
            'success' => false,
            'message' => 'Account not found.',
        ], 404);
    }

    if ($account->UserType !== 'Owner') {
        return response()->json([
            'success' => false,
            'message' => 'This action is only allowed for owner accounts.'
        ], 403);
    }

    $request->validate([
        'current_password' => [
            'required',
            function ($attribute, $value, $fail) use ($account) {
                if (!Hash::check($value, $account->Password)) {
                    $fail('The current password is incorrect.');
                }
            },
        ],
        'new_password' => [
            'required',
            'min:8',
            'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
            function ($attribute, $value, $fail) use ($account) {
                if (Hash::check($value, $account->Password)) {
                    $fail('The new password cannot be the same as the current password.');
                }
                if ($account->settings_previous_password) {
                    $previousPasswords = explode(',', $account->settings_previous_password);
                    foreach ($previousPasswords as $prevPass) {
                        if (Hash::check($value, $prevPass)) {
                            $fail('The new password cannot be the same as a previous password.');
                        }
                    }
                }
            },
        ],
        'confirm_password' => 'required|same:new_password',
    ], [
        'current_password.required' => 'Current password is required.',
        'new_password.required' => 'New password is required.',
        'new_password.min' => 'New password must be at least 8 characters.',
        'new_password.regex' => 'New password must include at least one uppercase letter, lowercase letter, number, and special character.',
        'confirm_password.required' => 'Confirm password is required.',
        'confirm_password.same' => 'Passwords do not match.',
    ]);

    DB::beginTransaction();
    try {
        $previousPassword = $account->Password;
        $account->Password = Hash::make($request->new_password); // Hash the new password
        $account->settings_password_change_count = ($account->settings_password_change_count ?? 0) + 1;

        if ($account->settings_previous_password) {
            $account->settings_previous_password = $account->settings_previous_password . ',' . $previousPassword;
        } else {
            $account->settings_previous_password = $previousPassword;
        }

        $account->save();

        event(new UserActionOccurred(
            $user->UserID,
            'Password Changed',
            "Owner {$user->FirstName} {$user->LastName} changed their password via settings."
        ));

        DB::commit();
        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully!'
        ]);
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Error updating owner password: ' . $e->getMessage(), [
            'user_id' => $user->UserID,
            'trace' => $e->getTraceAsString(),
        ]);
        return response()->json([
            'success' => false,
            'message' => 'An error occurred while updating your password: ' . $e->getMessage(),
        ], 500);
    }
}
}
