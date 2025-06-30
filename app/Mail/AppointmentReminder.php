<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    public function build()
    {
        $dentistName = $this->appointment->dentist 
            ? "{$this->appointment->dentist->user->FirstName} {$this->appointment->dentist->user->LastName}" 
            : "Not yet assigned";

        return $this->subject('Reminder: Your Appointment Tomorrow with Aguila-Titular Dental Clinic')
                    ->view('emails.appointment_reminder')
                    ->with([
                        'appointment' => $this->appointment,
                        'dentistName' => $dentistName,
                    ]);
    }
}