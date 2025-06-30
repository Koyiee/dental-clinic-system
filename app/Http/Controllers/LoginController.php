<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserAccount;

class LoginController extends Controller
{
    // Handle login logic
    public function login(Request $request)
    {
        $credentials = $request->only('Username', 'Password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            // Redirect based on user type
            if ($user->role == 'patient') {
                return redirect()->route('patientdashboard');
            } elseif ($user->role == 'dentist') {
                return redirect()->route('dentistdashboard');
            } elseif ($user->role == 'hradmin') {
                return redirect()->route('hrdashboard');
            }elseif ($user->role == 'owner') {
                return redirect()->route('ownerdashboard');
            }

            // Default route
            return redirect()->route('home');
        }

        // If login fails, redirect back to login page with an error
        return redirect()->route('login')->withErrors('Invalid credentials');
    }

    // Handle logout logic
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('home');
    }
}
