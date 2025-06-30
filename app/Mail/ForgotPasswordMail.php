<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pin;
    public $email;

    public function __construct($pin, $email)
    {
        $this->pin = $pin;
        $this->email = $email;
    }

    public function build()
    {
        return $this->subject('Password Reset Request')
                    ->view('emails.forgotpassword')
                    ->with([
                        'pin' => $this->pin,
                        'email' => $this->email,
                    ]);
    }
}