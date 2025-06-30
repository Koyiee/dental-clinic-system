<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Reset Password - {{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @vite(['resources/js/app.js'])
    <style>
        body {
            background-color: rgba(237, 241, 247, 1);
        }
    </style>
</head>
<body>
    <div id="app">
        <reset-password
            :email="{{ json_encode(request()->query('email')) }}"
            :pin="{{ json_encode(request()->query('pin')) }}"
        ></reset-password>
    </div>

    <!-- Debug script to check if Vue is loaded -->
    <script>
        console.log("Vue available:", typeof window.Vue !== 'undefined');
    </script>
</body>
</html>