<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- Add CSRF token -->
    <title>Patient Information</title>
    @vite(['resources/js/app.js'])
</head>
<style>
    body {
        background-color: #f2f2f2;
    }
</style>
<body>
    <div id="app">
        @if (auth()->check())
            <patient-information
                :patient-id="'{{ session('user_patientId', '') }}'"
                :age="'{{ session('user_age', '') }}'"
                :first-name="'{{ session('user_first_name', '') }}'"
                :last-name="'{{ session('user_last_name', '') }}'"
                :email="'{{ session('user_email', '') }}'"
                :gender="'{{ session('user_gender', '') }}'"
                :birthdate="'{{ session('user_birthdate', '') }}'"
                :contact-number="'{{ session('user_contact_number', '') }}'"
                :religion="'{{ session('user_religion', '') }}'"
                :nationality="'{{ session('user_nationality', '') }}'"
                :status="'{{ session('user_status', '') }}'"
                :address="'{{ session('user_address', '') }}'"
                :telephone-number="'{{ session('user_telephoneNumber', '') }}'"
                :occupation="'{{ session('user_occupation', '') }}'"
                :office-number="'{{ session('user_officeNumber', '') }}'"
                :profile-picture="'{{ session('user_profile_picture', '') }}'"
            ></patient-information>
        @else
            <div>
                <p>You are not logged in. Please <a href="{{ route('login') }}">log in</a> to view this page.</p>
            </div>
        @endif
    </div>
</body>
</html>