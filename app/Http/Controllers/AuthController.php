<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    // Handle logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
