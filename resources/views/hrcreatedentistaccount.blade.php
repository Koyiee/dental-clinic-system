<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Dentist Account - Aguila Titular Dental Clinic</title>
    @vite('resources/js/app.js')
</head>
<style>
    body {
        background-color: #F2F2F2;
    }
</style>
<body>
    <div id="app">
        <h-r-create-dentist-account
        :first-name="{{ json_encode(session('user_first_name')) }}"
        :last-name="{{ json_encode(session('user_last_name')) }}"
        ></h-r-create-dentist-account>
    </div>
</body>
</html>