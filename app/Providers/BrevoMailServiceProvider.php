<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BrevoMailService
{
    public function sendEmail($toEmail, $subject, $htmlContent)
    {
        $response = Http::withHeaders([
            'api-key' => env('SENDINBLUE_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post('https://api.brevo.com/v3/smtp/email', [
            'sender' => [
                'name' => 'Aguila-Titular Dental Clinic',
                'email' => env('MAIL_FROM_ADDRESS'),
            ],
            'to' => [
                ['email' => $toEmail],
            ],
            'subject' => $subject,
            'htmlContent' => $htmlContent,
        ]);

        if ($response->failed()) {
            Log::error('Brevo API email send failed', ['error' => $response->body()]);
        } else {
            Log::info('Email sent via Brevo API', ['email' => $toEmail]);
        }

        return $response->successful();
    }
}
