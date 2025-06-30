<?php
namespace App\Mail\Transport;

use Illuminate\Mail\Transport\Transport;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Http;

class SendinblueTransport extends Transport
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('SENDINBLUE_API_KEY');
    }

    public function send(MailMessage $message, array $failedRecipients = [])
    {
        $htmlContent = $message->getBody();
        $subject = $message->getSubject();
        $toEmail = $message->getTo()[0]['address'];

        $response = Http::withHeaders([
            'api-key' => $this->apiKey,
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ])->post('https://api.brevo.com/v3/smtp/email', [
            'sender' => [
                'name' => 'Aguila-Titular Dental Clinic',
                'email' => 'fionahmarie121717@gmail.com',
            ],
            'to' => [
                ['email' => $toEmail],
            ],
            'subject' => $subject,
            'htmlContent' => $htmlContent,
        ]);

        return $response->successful();
    }
}
