<!DOCTYPE html>
<html>
<head>
    <title>Appointment Reminder - Aguila-Titular Dental Clinic</title>
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            margin: 0;
            padding: 0;
            background-color: #F2F2F2;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #FFFFFF;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }
        .header {
            background-color: #06693A;
            color: #FFFFFF;
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid #055A32;
        }
        .header h2 {
            margin: 0;
            font-size: 20px;
            font-weight: 600;
        }
        .content {
            padding: 25px;
        }
        .content p {
            margin: 0 0 15px;
        }
        .details-box {
            background-color: #F9F9F9;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .details-box h3 {
            font-size: 16px;
            font-weight: 600;
            color: #06693A;
            margin: 0 0 10px;
        }
        .details-box ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .details-box li {
            margin-bottom: 8px;
            font-size: 14px;
        }
        .details-box li strong {
            color: #06693A;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #666666;
            padding: 15px;
            background-color: #F9F9F9;
            border-top: 1px solid #F0F0F0;
        }
        .footer a {
            color: #06693A;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Appointment Reminder</h2>
        </div>
        <div class="content">
            <p>Dear {{ $appointment->patient->user->FirstName ?? 'Patient' }} {{ $appointment->patient->user->LastName ?? '' }},</p>
            
            <p>This is a friendly reminder that you have an appointment scheduled with Aguila-Titular Dental Clinic tomorrow. Here are the details:</p>

            <div class="details-box">
                <h3>Appointment Details</h3>
                <ul>
                    <li><strong>Date:</strong> {{ date('F j, Y', strtotime($appointment->AppointmentDate)) }}</li>
                    <li><strong>Time:</strong> {{ date('g:i A', strtotime($appointment->AppointmentTime)) }} 
                        <em>(Please note that this time may vary depending on clinic hours or scheduling demands.)</em></li>
                    <li><strong>Dentist:</strong> {{ $dentistName }}</li>
                    <li><strong>Services:</strong> {{ $appointment->servicesAvailed->pluck('service.ServiceName')->implode(', ') ?? 'N/A' }}</li>
                    @if($appointment->PatientNote)
                        <li><strong>Your Note:</strong> {{ $appointment->PatientNote }}</li>
                    @endif
                </ul>
            </div>

            <p>We kindly request that you arrive a few minutes early to ensure a smooth visit. If you need to reschedule or cancel, please contact us as soon as possible.</p>

            <p><em>This is an auto-generated email. Please do not reply directly to this message.</em></p>
        </div>
        <div class="footer">
            <p>Thank you for choosing Aguila-Titular Dental Clinic.<br>
            For inquiries, contact us at <a href="mailto:atdc@gmail.com">atdc@gmail.com</a>.</p>
        </div>
    </div>
</body>
</html>