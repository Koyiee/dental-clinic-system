<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;
    public $status;
    public $declineReason;

    public function __construct(Appointment $appointment, string $status, string $declineReason = null)
    {
        $this->appointment = $appointment;
        $this->status = $status;
        $this->declineReason = $declineReason;
    }

    public function build()
    {
        $subject = "Your Appointment Request - {$this->status}";
        $dentistName = $this->appointment->dentist ? 
            "{$this->appointment->dentist->user->FirstName} {$this->appointment->dentist->user->LastName}" : 
            "Not yet assigned";

        return $this->subject($subject)
                    ->view('emails.appointment_status')
                    ->with([
                        'appointment' => $this->appointment,
                        'status' => $this->status,
                        'dentistName' => $dentistName,
                        'declineReason' => $this->declineReason,
                    ]);
    }
}