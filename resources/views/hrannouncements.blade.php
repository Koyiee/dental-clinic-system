<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- Add CSRF token meta tag -->
    <title>Aguila Titular Dental Clinic</title>
    @vite('resources/js/app.js')
</head>
<style>
    body {
        background-color: #f2f2f2;
    }
</style>
<body>
    <div id="app">
        <h-r-announcements
            :first-name="{{ json_encode(session('user_first_name')) }}"
            :last-name="{{ json_encode(session('user_last_name')) }}"
        ></h-r-announcements>
    </div>

    <!-- Add script to set up Axios with CSRF token -->
    <script>
        // Set up Axios to include the CSRF token in all requests
        window.axios = require('axios');
        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    </script>
</body>
</html>