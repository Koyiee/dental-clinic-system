<?php

namespace App\Listeners;

use App\Events\AppointmentCompleted;
use App\Models\Billing;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GenerateBilling
{
    public function handle(AppointmentCompleted $event)
    {
        $appointment = $event->appointment;
        Log::info("GenerateBilling triggered for AppointmentID: {$appointment->AppointmentID}");

        $servicesDetails = DB::table('services_availed')
            ->join('services', 'services_availed.ServiceID', '=', 'services.ServiceID')
            ->where('services_availed.AppointmentID', $appointment->AppointmentID)
            ->select(
                'services.ServiceName',
                'services.Cost',
                'services.IsMultiVisit',
                'services_availed.ServicesAvailedID',
                'services_availed.TreatmentProgressID'
            )
            ->get()
            ->toArray();

        if (empty($servicesDetails)) {
            Log::warning("No services found for AppointmentID: {$appointment->AppointmentID}");
            return;
        }

        $totalCost = array_sum(array_column($servicesDetails, 'Cost'));
        $isSingleVisitOnly = collect($servicesDetails)->every(fn($s) => !$s->IsMultiVisit);
        Log::info("Services for AppointmentID: {$appointment->AppointmentID}", [
            'services' => $servicesDetails,
            'TotalCost' => $totalCost,
            'IsSingleVisitOnly' => $isSingleVisitOnly
        ]);

        try {
            if ($isSingleVisitOnly) {
                if (!Billing::where('AppointmentID', $appointment->AppointmentID)->exists()) {
                    Billing::create([
                        'AppointmentID' => $appointment->AppointmentID,
                        'TotalAmount' => $totalCost,
                        'Balance' => $totalCost,
                    ]);
                    Log::info("Single-visit billing created", [
                        'AppointmentID' => $appointment->AppointmentID,
                        'TotalAmount' => $totalCost,
                        'Balance' => $totalCost
                    ]);
                }
            } else {
                $service = $servicesDetails[0];
                $treatmentProgressId = $service->TreatmentProgressID;
                $existingBilling = Billing::whereHas('appointment.servicesAvailed', function ($query) use ($appointment, $treatmentProgressId) {
                    $query->where('TreatmentProgressID', $treatmentProgressId)
                          ->whereHas('appointment', fn($q) => $q->where('PatientID', $appointment->PatientID));
                })->first();

                if (!$existingBilling) {
                    Billing::create([
                        'AppointmentID' => $appointment->AppointmentID,
                        'TotalAmount' => $totalCost,
                        'Balance' => $totalCost,
                    ]);
                    Log::info("Multi-visit initial billing created", [
                        'AppointmentID' => $appointment->AppointmentID,
                        'TotalAmount' => $totalCost,
                        'Balance' => $totalCost,
                        'TreatmentProgressID' => $treatmentProgressId
                    ]);
                } else {
                    Log::info("Multi-visit billing reused", [
                        'AppointmentID' => $appointment->AppointmentID,
                        'ExistingBillingID' => $existingBilling->BillingID,
                        'Balance' => $existingBilling->Balance,
                        'TreatmentProgressID' => $treatmentProgressId
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error("Failed to create billing for AppointmentID: {$appointment->AppointmentID}", ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}