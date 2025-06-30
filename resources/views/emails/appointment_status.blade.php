<!DOCTYPE html>
<html>
<head>
    <title>Appointment Status Update - Aguila-Titular Dental Clinic</title>
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
            line-height: 1.6;
            color: black;
            margin: 0;
            padding: 0;
            background-color: #F2F2F2;
        }
        .container {
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
        .status-confirmed {
            font-weight: 600;
            color: #0D904B;
        }
        .status-declined {
            font-weight: 600;
            color: #D32F2F;
        }
        .status-pending {
            font-weight: 600;
            color: #F9A825; /* Yellow-ish for "Pending" to distinguish it */
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
            <h2>Appointment Status Update</h2>
        </div>
        <div class="content">
            <p>Dear {{ $appointment->patient->user->FirstName ?? 'Patient' }} {{ $appointment->patient->user->LastName ?? '' }},</p>
            
            @if ($status === 'Pending')
                <p>Thank you for choosing Aguila-Titular Dental Clinic. We are pleased to confirm that your appointment request has been successfully received and is currently <span class="status-pending">{{ $status }}</span> approval.</p>
                <div class="details-box">
                    <h3>Appointment Details</h3>
                    <ul>
                        <li><strong>Date:</strong> {{ date('F j, Y', strtotime($appointment->AppointmentDate)) }}</li>
                        <li><strong>Time:</strong> {{ date('g:i A', strtotime($appointment->AppointmentTime)) }} 
                            <em>(This time may vary depending on clinic hours or scheduling demands.)</em></li>
                        <li><strong>Dentist:</strong> {{ $dentistName ?? 'Not yet assigned' }}</li>
                        <li><strong>Services:</strong> {{ $appointment->servicesAvailed->pluck('service.ServiceName')->implode(', ') ?? 'N/A' }}</li>
                        @if($appointment->PatientNote)
                            <li><strong>Your Note:</strong> {{ $appointment->PatientNote }}</li>
                        @endif
                    </ul>
                </div>
                <p>Please note that your appointment is pending approval, which typically takes <strong>1-2 business days</strong>. Once approved, you will receive a follow-up confirmation with any additional instructions. We kindly ask for your patience during this time.</p>
            @elseif ($status === 'Confirmed')
                <p>We are pleased to inform you that your appointment request with Aguila-Titular Dental Clinic has been <span class="status-confirmed">{{ $status }}</span>. Below are the details of your appointment:</p>
                <div class="details-box">
                    <h3>Appointment Details</h3>
                    <ul>
                        <li><strong>Date:</strong> {{ date('F j, Y', strtotime($appointment->AppointmentDate)) }}</li>
                        <li><strong>Time:</strong> {{ date('g:i A', strtotime($appointment->AppointmentTime)) }} 
                            <em>(Please note that this time may vary depending on clinic hours or scheduling demands.)</em></li>
                        <li><strong>Dentist:</strong> {{ $dentistName ?? 'Not yet assigned' }}</li>
                        <li><strong>Services:</strong> {{ $appointment->servicesAvailed->pluck('service.ServiceName')->implode(', ') ?? 'N/A' }}</li>
                        @if($appointment->PatientNote)
                            <li><strong>Your Note:</strong> {{ $appointment->PatientNote }}</li>
                        @endif
                    </ul>
                </div>
                <p>We kindly ask you to arrive a few minutes early to ensure a smooth visit. If you need to reschedule or have any questions, please contact us at your earliest convenience.</p>
                @elseif ($status === 'Declined')
                <p>We regret to inform you that your appointment request with Aguila-Titular Dental Clinic has been <span class="status-declined">{{ $status }}</span>. Below are the details of your requested appointment:</p>
                <div class="details-box">
                    <h3>Requested Appointment Details</h3>
                    <ul>
                        <li><strong>Date:</strong> {{ date('F j, Y', strtotime($appointment->AppointmentDate)) }}</li>
                        <li><strong>Time:</strong> {{ date('g:i A', strtotime($appointment->AppointmentTime)) }} <em>(This time may vary depending on clinic hours or scheduling demands.)</em></li>
                        <li><strong>Dentist:</strong> {{ $dentistName ?? 'Not yet assigned' }}</li>
                        <li><strong>Services:</strong> {{ $appointment->servicesAvailed->pluck('service.ServiceName')->implode(', ') ?? 'N/A' }}</li>
                        @if($appointment->PatientNote)
                            <li><strong>Your Note:</strong> {{ $appointment->PatientNote }}</li>
                        @endif
                        @if($declineReason)
                            <li><strong>Reason for Decline:</strong> {{ $declineReason }}</li>
                        @endif
                    </ul>
                </div>
                <p>We regret any inconvenience this may cause. You are welcome to schedule a new appointment at a time that suits you best. Please don’t hesitate to reach out if you need assistance.</p>
            @endif

            <p><em>This is an auto-generated email. Please do not reply directly to this message.</em></p>
        </div>
        <div class="footer">
            <p>Thank you for choosing Aguila-Titular Dental Clinic.<br>
            For inquiries, contact us at <a href="mailto:atdc@gmail.com">atdc@gmail.com</a>.</p>
        </div>
    </div>
</body>
</html>