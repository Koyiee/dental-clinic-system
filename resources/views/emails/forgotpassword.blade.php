<!-- resources/views/emails/forgotpassword.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <style>
        .button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
        }

        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <p>Hello,</p>
    <p>We received a request to reset your password. Please use the following PIN to reset your password:</p>
    <h2>{{ $pin }}</h2>

    <p>Click the button below to proceed to the page where you can verify your PIN:</p>

    <!-- Send only the email to the verification page -->
    <a href="{{ route('verifyPin', ['email' => $email]) }}" class="button">Reset Password</a>

    <p>If you did not request a password reset, please ignore this email.</p>

    <p>Best regards,<br>Your Team</p>
</body>
</html>
