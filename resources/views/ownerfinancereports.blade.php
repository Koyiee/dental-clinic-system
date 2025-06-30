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
        background-color: #F2F2F2;
    }
</style>
<body>
    <div id="app">
        <owner-finance-reports
        :first-name="{{ json_encode(session('user_first_name')) }}"
        :last-name="{{ json_encode(session('user_last_name')) }}"
        ></owner-finance-reports>
    </div>
</body>
</html>