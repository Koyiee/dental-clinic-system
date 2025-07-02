<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\UserAccount;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ArchiveInactivePatients
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $inactivityThreshold = Carbon::now()->subMonths(6);
            $patientsToArchive = UserAccount::where('UserType', 'Patient')
                ->where('AccountStatus', 'active')
                ->where('last_login_at', '<', $inactivityThreshold)
                ->whereNotNull('last_login_at')
                ->get();

            foreach ($patientsToArchive as $patient) {
                $patient->update(['AccountStatus' => 'archived']);
                Log::info("Archived patient UserID: {$patient->UserID} due to inactivity.");
            }
        } catch (\Exception $e) {
            Log::error("Error archiving inactive patients: " . $e->getMessage());
        }

        return $next($request);
    }
}
