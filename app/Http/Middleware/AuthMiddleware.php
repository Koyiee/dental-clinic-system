<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\UserActionOccurred; // Add this for login tracer

class AuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in to access this page.');
        }

        $userAccount = \App\Models\UserAccount::where('UserID', $user->UserID)->first();

        if (!$userAccount || $userAccount->UserType !== 'Patient') {
            // Log the unauthorized access attempt
            event(new UserActionOccurred(
                $user->UserID,
                $user->UserID,
                'Unauthorized access attempt to patient route by ' . $userAccount->UserType
            ));

            // Log the user out
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('error', 'Unauthorized: You have been logged out for attempting to access a restricted page.');
        }

        return $next($request);
    }
}