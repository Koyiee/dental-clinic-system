<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Forgot Password</title>
    @vite('resources/js/app.js')
    <style>
        body {
            background-color: rgba(237, 241, 247, 1);
        }
    </style>
</head>
<body>
    <div id="app">
        <forgot-password></forgot-password>
    </div>
</body>
</html>