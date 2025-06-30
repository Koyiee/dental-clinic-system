<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Aguila-Titular Dental Clinic!</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 20px;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            display: inline-block;
        }
        h1 {
            color: #2c3e50;
        }
        p {
            color: #555;
        }
        .details {
            text-align: left;
            margin: 20px auto;
            display: inline-block;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 15px;
            text-decoration: none;
            background-color: #27ae60;
            color: #fff;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: #219150;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Welcome to Aguila-Titular Dental Clinic, {{ $user['FirstName'] }}!</h1>
        <p>We’re excited to have you as part of our dental family.</p>
        
        <p>Here are your account details:</p>
        <div class="details">
            <ul>
                <li><strong>Name:</strong> {{ $user['FirstName'] }} {{ $user['LastName'] }}</li>
                <li><strong>Email:</strong> {{ $user['Email'] }}</li>
                <li><strong>Username:</strong> {{ $user->userAccount->Username }}</li>
            </ul>
        </div>

        <p>We’re here to help you achieve a brighter and healthier smile! Feel free to book an appointment anytime.</p>

        <a href="[Appointment Booking URL]" class="btn">Schedule Your Appointment</a>

        <p>If you have any questions, feel free to reach out to us.</p>
        <p>Best Regards, <br> <strong>ATDC Team</strong></p>
    </div>

</body>
</html>
