<?php

namespace App\Console\Commands;

use App\Mail\AppointmentReminder;
use App\Models\Appointment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schedule;

class SendAppointmentReminders extends Command
{
    protected $signature = 'appointments:send-reminders';
    protected $description = 'Send reminder emails to patients for appointments scheduled tomorrow';

    public function handle()
    {
        $tomorrow = now()->addDay()->toDateString(); // e.g., 2025-04-06

        $appointments = Appointment::with(['patient.user', 'dentist.user', 'servicesAvailed.service'])
            ->where('AppointmentDate', $tomorrow)
            ->where('AppointmentStatus', 'Confirmed')
            ->get();

        if ($appointments->isEmpty()) {
            Log::info('No confirmed appointments found for tomorrow.', ['date' => $tomorrow]);
            $this->info('No reminders to send.');
            return;
        }

        foreach ($appointments as $appointment) {
            try {
                $patientEmail = $appointment->patient->user->Email ?? null;
                if (!$patientEmail) {
                    Log::warning('No email found for patient.', [
                        'AppointmentID' => $appointment->AppointmentID,
                        'PatientID' => $appointment->PatientID,
                    ]);
                    continue;
                }

                Mail::to($patientEmail)->send(new AppointmentReminder($appointment));
                Log::info('Reminder email sent successfully.', [
                    'AppointmentID' => $appointment->AppointmentID,
                    'PatientEmail' => $patientEmail,
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to send reminder email: ' . $e->getMessage(), [
                    'AppointmentID' => $appointment->AppointmentID,
                    'PatientEmail' => $patientEmail ?? 'N/A',
                    'Stack' => $e->getTraceAsString(),
                ]);
            }
        }

        $this->info('Appointment reminders processed successfully.');
    }

    // Define the schedule in the command (Laravel 11+ approach)
    public static function schedule()
    {
        Schedule::command('appointments:send-reminders')
                ->dailyAt('10:00')
                ->timezone('Asia/Manila'); // Adjust to your clinic's timezone
    }
}