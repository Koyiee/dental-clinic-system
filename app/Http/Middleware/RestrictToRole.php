<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\UserActionOccurred;
use Illuminate\Support\Facades\Log;
use App\Models\UserAccount;

class RestrictToRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if (!$user) {
            Log::warning("No authenticated user found for request", [
                'url' => $request->url(),
                'session_id' => $request->session()->getId(),
            ]);
            return redirect()->route('login')->with('error', 'Please log in to access this page.');
        }

        Log::info("Authenticated user found", [
            'user_id' => $user->UserID,
            'url' => $request->url(),
            'session_id' => $request->session()->getId(),
        ]);

        $userAccount = UserAccount::where('UserID', $user->UserID)->first();

        if (!$userAccount) {
            Log::error("UserAccount not found for user", [
                'user_id' => $user->UserID,
                'url' => $request->url(),
                'session_id' => $request->session()->getId(),
            ]);

            return redirect()->route('login')->with('error', 'Unauthorized: User account not found.');
        }

        // Make role comparison case-insensitive
        $userType = strtolower($userAccount->UserType);
        $roles = array_map('strtolower', $roles);

        if (!in_array($userType, $roles)) {
            Log::warning("Unauthorized access attempt", [
                'user_id' => $user->UserID,
                'user_type' => $userAccount->UserType,
                'required_roles' => $roles,
                'url' => $request->url(),
                'session_id' => $request->session()->getId(),
            ]);

            return redirect()->route('login')->with('error', 'Unauthorized: You have been logged out for attempting to access a restricted page.');
        }

        return $next($request);
    }
}