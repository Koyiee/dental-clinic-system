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
        <patient-schedule-an-appointment
            :first-name="{{ json_encode(session('user_first_name')) }}"
            :last-name="{{ json_encode(session('user_last_name')) }}"
        ></patient-schedule-an-appointment>
    </div>

    <!-- Add jsPDF CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
        // Make jsPDF available globally for Vue to use
        window.jsPDF = window.jspdf.jsPDF;
    </script>

</body>
</html>