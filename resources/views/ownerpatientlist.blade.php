<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <owner-patient-list
        :first-name="{{ json_encode(session('user_first_name')) }}"
        :last-name="{{ json_encode(session('user_last_name')) }}"
        ></owner-patient-list>
    </div>
</body>
</html>