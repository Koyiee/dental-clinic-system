<?php

namespace App\Http\Controllers;

use App\Models\LoginTracer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OwnerLoginTracerController extends Controller
{
    public function index()
    {
        $tracerLogs = LoginTracer::with('user')
            ->orderBy('ActionDate', 'desc')
            ->get();

        return response()->json($tracerLogs);
    }

    public static function logAction($userId, $actionType, $description)
    {
        LoginTracer::create([
            'UserID' => $userId,
            'ActionType' => $actionType,
            'Description' => $description,
        ]);
    }
}