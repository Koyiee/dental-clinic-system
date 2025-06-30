<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Hr\DentistController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ListPatientController;
use App\Http\Controllers\HRAdminController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ServiceSalesReportController;
use App\Http\Controllers\DentistFileController;
use App\Http\Controllers\HRFileController;
use App\Models\Announcement;
use App\Http\Controllers\OwnerLoginTracerController;
use App\Http\Controllers\DentalFormController;

Route::middleware('auth')->get('/owner/login-tracer', [OwnerLoginTracerController::class, 'index']);

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login']);
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    // Patients
    Route::get('/patientdashboard', function () {
        return view('patientdashboard');
    })->name('patientdashboard');

    Route::get('/hr/patients', [PatientController::class, 'indexForHr'])->name('hr.patients.index');

    Route::get('/patientinformation', function () {
        return view('patientinformation');
    })->name('patientinformation');

    Route::get('/patientappointments', [AppointmentController::class, 'index'])->name('patient.appointments');
    // Route::get('/get-blocked-dates', [AppointmentController::class, 'getBlockedDates']);

    Route::get('/patientscheduleanappointment', function () {
        return view('patientscheduleanappointment');
    })->name('patientscheduleanappointment');

    Route::get('/patientbillings', function () {
        return view('patientbillings');
    })->name('patientbillings');

    Route::get('/api/patientbillings', [BillingController::class, 'getPatientBillings'])->name('api.patient.billings');

    Route::get('/patienttreatments', function () {
        return view('patienttreatments');
    })->name('patienttreatments');

    Route::get('/patienttreatmentplan', function () {
        return view('patienttreatmentplan');
    })->name('patienttreatmentplan');

    Route::get('/patientdentalphotos', function () {
        return view('patientdentalphotos');
    })->name('patientdentalphotos');

    Route::get('/patientforms', function () {
        return view('patientforms');
    })->name('patientforms');

    Route::get('/patientdentaltreatmenthistory', function () {
        return view('patientdentaltreatmenthistory');
    })->name('patientdentaltreatmenthistory');

    Route::get('/patientannouncements', function () {
        return view('patientannouncements');
    })->name('patientannouncements');

    Route::get('/patientsettings', function () {
        return view('patientsettings');
    })->name('patientsettings');

    Route::get('/patient/updated-appointments', [AppointmentController::class, 'getUpdatedAppointments'])
        ->name('patient.updated-appointments');

    Route::post('/patient/appointments/{appointmentId}/mark-as-viewed', [AppointmentController::class, 'markAsViewed'])
        ->name('patient.mark-as-viewed');

    Route::post('/patientappointments', [AppointmentController::class, 'store']);

    // New route for cancelling a patient appointment
    Route::post('/patient/appointments/{appointmentId}/cancel', [AppointmentController::class, 'cancelPatientAppointment'])
        ->name('patient.appointments.cancel');

    // Add the missing route for /dentistannouncements
    Route::get('/dentistannouncements', function () {
        return view('dentistannouncements');
    })->name('dentistannouncements');

    // New dentist file routes with 'api/dentist' prefix
    Route::prefix('api/dentist')->group(function () {
        Route::post('/upload-dental-photos', [DentistFileController::class, 'uploadDentalPhoto']);
        Route::post('/upload-treatment-plans', [DentistFileController::class, 'uploadTreatmentPlan']);
        Route::post('/upload-dental-forms', [DentistFileController::class, 'uploadDentalForm']);
        Route::get('/patient/{patientId}/dental-photos', [DentistFileController::class, 'getDentalPhotos']);
        Route::get('/patient/{patientId}/treatment-plans', [DentistFileController::class, 'getTreatmentPlans']);
        Route::get('/patient/{patientId}/dental-forms', [DentistFileController::class, 'getDentalForms']);
        Route::get('/download/{type}/{id}', [DentistFileController::class, 'downloadFile']);

        // Add DELETE routes
        Route::delete('/delete/dental/{id}', [DentistFileController::class, 'deleteDentalPhoto']);
        Route::delete('/delete/treatment/{id}', [DentistFileController::class, 'deleteTreatmentPlan']);
        Route::delete('/delete/form/{id}', [DentistFileController::class, 'deleteDentalForm']);

        // New route for logged-in patient's dental photos
        Route::get('/my-dental-photos', [DentistFileController::class, 'getLoggedInPatientDentalPhotos']);
        Route::get('/my-treatment-plans', [DentistFileController::class, 'getLoggedInPatientTreatmentPlans']);
        Route::get('/my-dental-forms', [DentistFileController::class, 'getLoggedInPatientDentalForms']);

        Route::post('/upload-medical-records', [DentistFileController::class, 'uploadMedicalRecord']);
        Route::get('/patient/{patientId}/medical-records', [DentistFileController::class, 'getMedicalRecords']);
        Route::delete('/delete/medical/{id}', [DentistFileController::class, 'deleteMedicalRecord']);
    });

    // New HR file routes with 'api/hr' prefix
    Route::prefix('api/hr')->group(function () {
        Route::post('/upload-dental-photos', [HRFileController::class, 'uploadDentalPhoto']);
        Route::post('/upload-treatment-plans', [HRFileController::class, 'uploadTreatmentPlan']);
        Route::post('/upload-dental-forms', [HRFileController::class, 'uploadDentalForm']);
        Route::post('/upload-medical-records', [HRFileController::class, 'uploadMedicalRecord']);
        Route::get('/patient/{patientId}/dental-photos', [HRFileController::class, 'getDentalPhotos']);
        Route::get('/patient/{patientId}/treatment-plans', [HRFileController::class, 'getTreatmentPlans']);
        Route::get('/patient/{patientId}/dental-forms', [HRFileController::class, 'getDentalForms']);
        Route::get('/patient/{patientId}/medical-records', [HRFileController::class, 'getMedicalRecords']);
        Route::get('/download/{type}/{id}', [HRFileController::class, 'downloadFile']);
        Route::delete('/delete/dental/{id}', [HRFileController::class, 'deleteDentalPhoto']);
        Route::delete('/delete/treatment/{id}', [HRFileController::class, 'deleteTreatmentPlan']);
        Route::delete('/delete/form/{id}', [HRFileController::class, 'deleteDentalForm']);
        Route::delete('/delete/medical/{id}', [HRFileController::class, 'deleteMedicalRecord']);
    });

    // Announcements (Protected Routes)
    Route::post('/announcements/store', [AnnouncementController::class, 'store']);
    Route::get('/announcements/patient', [AnnouncementController::class, 'getPatientAnnouncements']);
    Route::get('/announcements/dentist', [AnnouncementController::class, 'getDentistAnnouncements']);
    Route::get('/announcements/hr', [AnnouncementController::class, 'getHrAnnouncements']);
    Route::get('/announcements/{audience}', [AnnouncementController::class, 'getAnnouncementsByAudience'])
        ->whereIn('audience', ['patient', 'dentist'])
        ->name('announcements.byAudience');
    Route::post('/announcements/store/hr', [AnnouncementController::class, 'storeHr']);
    Route::post('/announcements/store/owner', [AnnouncementController::class, 'storeOwner']);

    // Routes for updating and fetching patient information
    Route::put('/api/patients/{patientId}', [UserController::class, 'update'])->name('patients.update');
    Route::get('/api/patient-id', [UserController::class, 'getPatientId'])->name('patient.id');
    Route::get('/api/patient-data', [UserController::class, 'getPatientData'])->name('patient.data');
    Route::post('/upload-profile-picture', [UserController::class, 'uploadProfilePicture'])->middleware('auth');

    Route::get('/available-times', [AppointmentController::class, 'getAvailableTimes'])->name('available-times');
    Route::get('/check-dentist-availability', [AppointmentController::class, 'checkDentistAvailability'])->name('check-dentist-availability');
    Route::post('/filter-available-times', [AppointmentController::class, 'filterAvailableTimes'])->middleware('auth')->name('filter-available-times');

    Route::post('/save-dental-form', [DentalFormController::class, 'saveDentalForm']);
    Route::get('/api/patient/dental-forms', [DentalFormController::class, 'getDentalForms']);

    Route::get('/appointments/consent-form/{appointmentId}', [AppointmentController::class, 'getConsentForm'])->name('hr.appointments.consent-form');
    Route::get('/appointments/{appointmentId}/consent-form', [AppointmentController::class, 'getConsentForm']);
    
    Route::get('/patient/my-treatment-history', [AppointmentController::class, 'getMyTreatmentHistory']);
    // Keep existing route for flexibility
    Route::get('/patient/{patientId}/treatment-history', [AppointmentController::class, 'getTreatmentHistory']);

    Route::get('/hr/patient-ledger/{patientId}', [BillingController::class, 'getPatientLedger']);
    Route::get('/hr/patients-with-balances', [BillingController::class, 'getPatientsWithBalances']);
    Route::post('/hr/billings/add-payment-without-appointment', [BillingController::class, 'addPaymentWithoutAppointment']);

});

Route::middleware('auth')->get('/get-patient-id', [UserController::class, 'getPatientId']);

Route::get('/signup', function () {
    return view('signup');
})->name('signup');

Route::post('/users', [UserController::class, 'store'])->name('users.store');

Route::get('/about', function () {
    return view('about');
});

Route::get('/services', function () {
    return view('services');
});

Route::get('/smilegallery', function () {
    return view('smilegallery');
});

Route::get('/announcements', function () {
    return view('announcements');
});

Route::get('/faqs', function () {
    return view('faqs');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/forgotpassword', function () {
    return view('forgotpassword');
})->name('password.forgot');
Route::post('/forgotpassword', [ForgotPasswordController::class, 'submitForgotPasswordForm']);

Route::get('/verify-pin', [ForgotPasswordController::class, 'showVerifyPinPage'])->name('verifyPin');
Route::post('/verify-pin', [ForgotPasswordController::class, 'verifyPin']);

Route::get('/resetpassword', function () {
    return view('resetpassword');
})->name('resetpassword');
Route::post('/resetpassword', [ForgotPasswordController::class, 'resetPassword']);

// Patient
Route::get('/patients', [PatientController::class, 'index']);
Route::post('/patients', [UserController::class, 'store']);

// Owner
Route::get('/ownerdashboard', function () {
    return view('ownerdashboard');
})->name('ownerdashboard')->middleware('auth');

Route::get('/ownerannouncements', function () {
    return view('ownerannouncements');
});

Route::get('/ownerappointmentsreport', function () {
    return view('ownerappointmentsreport');
});

Route::get('/ownerappointments', function () {
    return view('ownerappointments');
});

Route::get('/ownercalendarschedule', function () {
    return view('ownercalendarschedule');
});

Route::get('/ownerfinancereports', function () {
    return view('ownerfinancereports');
});

Route::get('/ownermanageservices', function () {
    return view('ownermanageservices');
});

Route::get('/ownermanageusers', function () {
    return view('ownermanageusers');
});

Route::get('/ownerpatientbillings', function () {
    return view('ownerpatientbillings');
});

Route::get('/ownerlogintracer', function () {
    return view('ownerlogintracer');
});

Route::get('/ownersettings', function () {
    return view('ownersettings');
});

Route::get('/ownerpatientlist', function () {
    return view('ownerpatientlist');
});

// HR
Route::get('/hrdashboard', function () {
    return view('hrdashboard');
})->name('hrdashboard');

Route::get('/hrappointments', [AppointmentController::class, 'getPendingAppointments'])->name('hr.appointments.index');
Route::put('/hr/appointments/{id}', [AppointmentController::class, 'update']);

Route::get('/hrannouncements', function () {
    return view('hrannouncements');
});

Route::get('/hrmanageservices', function () {
    return view('hrmanageservices');
});

Route::get('/hrmanageusers', function () {
    return view('hrmanageusers');
});

Route::get('/hrpatientbillings', function () {
    return view('hrpatientbillings');
});

Route::get('/hrsettings', function () {
    return view('hrsettings');
});

Route::get('/hrcalendarschedule', function () {
    return view('hrcalendarschedule');
});

Route::get('/hrpatientlist', function () {
    return view('hrpatientlist');
});

Route::get('/hrcreatedentistaccount', function () {
    return view('hrcreatedentistaccount');
});

// Dentist
Route::post('/dentists', [DentistController::class, 'store']);
Route::get('/dentists', [DentistController::class, 'index'])->name('dentists.index');
Route::get('/hr/dentists', [DentistController::class, 'index'])->name('hr.dentists.index');
Route::get('/get-dentists', [UserController::class, 'getDentists']);

Route::get('/dentistdashboard', function () {
    return view('dentistdashboard');
})->name('dentistdashboard');

Route::get('/dentistappointments', function () {
    return view('dentistappointments');
});

Route::get('/dentistcalendarschedule', function () {
    return view('dentistcalendarschedule');
});

Route::get('/dentistpatientlist', function () {
    return view('dentistpatientlist');
});

Route::get('/dentistsettings', function () {
    return view('dentistsettings');
});

Route::post('/services/store', [ServiceController::class, 'store']);
Route::put('/services/update/{id}', [ServiceController::class, 'update']);
Route::get('/services/list', [ServiceController::class, 'list']);

// Patient Management
Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');

// List of Patients
Route::get('/patient-list', [ListPatientController::class, 'index'])->name('patient.list');

Route::get('/hradmins', [HRAdminController::class, 'index'])->name('hradmins.index');
Route::post('/hradmins', [HRAdminController::class, 'store'])->name('hradmins.store');

Route::post('/assign-dentist', [AppointmentController::class, 'assignDentist'])->name('assign.dentist');

Route::get('/dentist/appointments', [AppointmentController::class, 'getDentistAppointments'])->name('dentist.appointments');

Route::get('/hr/appointments/calendar', [AppointmentController::class, 'getHrAppointments']);

Route::post('/hr/appointments/update-treatment-progress', [AppointmentController::class, 'updateTreatmentProgress']);

Route::post('/hr/appointments/book', [AppointmentController::class, 'storeHrConfirmedAppointment'])->middleware('auth');

Route::get('/api/dentist/patient-list', [ListPatientController::class, 'getPatientList']);

Route::get('/hr/billings', [BillingController::class, 'getAllBillings'])->name('hr.billings.index');
Route::get('/hr/billings/{appointmentId}', [BillingController::class, 'getBilling'])->name('hr.billings.show');
Route::put('/hr/billings/{id}', [BillingController::class, 'updateBilling']);
Route::get('/hr/multi-visit-billing/{patientId}/{procedure}', [BillingController::class, 'getMultiVisitBilling']);
Route::get('/hr/payment-methods', [BillingController::class, 'getPaymentMethods'])->name('hr.payment.methods');
Route::get('/hr/get-service-cost/{appointmentId}', [BillingController::class, 'getServiceCost']);
Route::post('/hr/billings/approve-insurance', [BillingController::class, 'approveInsuranceBillings']);
Route::post('/hr/billings/decline-insurance/{billingId}', [BillingController::class, 'declineInsuranceBilling']);

Route::post('/hr/update-status', [HRAdminController::class, 'updateStatus']);

Route::get('/patient/appointments/{patientId}', [AppointmentController::class, 'getPatientAppointments']);

Route::get('/check-appointment-date', [AppointmentController::class, 'checkPatientAppointmentDate'])->middleware('auth');

// Public Announcement Routes (for the public-facing announcements page)
Route::get('/announcements', [AnnouncementController::class, 'index']);
Route::get('/announcements/{id}/image', [AnnouncementController::class, 'getAnnouncementImage']);


Route::post('/owners', [UserController::class, 'storeOwner']);
Route::get('/owners', [UserController::class, 'getOwners']);

Route::post('/users/check-email', [UserController::class, 'checkEmail']);

Route::post('/users/check-username', [UserController::class, 'checkUsername']);

Route::post('/hr/payments/{billingId}', [PaymentController::class, 'recordPayment'])->name('hr.payments.store');

Route::get('/patient/appointments/updated', [AppointmentController::class, 'getUpdatedAppointments'])->middleware('auth');
Route::post('/patient/appointments/{appointmentId}/mark-as-viewed', [AppointmentController::class, 'markAsViewed'])->middleware('auth');

// Route::get('/patientappointments', [AppointmentController::class, 'index'])->middleware('auth');

Route::get('/service-sales-report', [ServiceSalesReportController::class, 'index'])->middleware('auth');

// Added by Grok for patient settings password change
Route::post('/patient/update-password', [ForgotPasswordController::class, 'updatePatientPassword'])
    ->middleware('auth')
    ->name('patient.update-password');

    // Added by Grok: Route for dentist settings password change
Route::post('/dentist/update-password', [ForgotPasswordController::class, 'updateDentistPassword'])->middleware('auth');
// End of addition by Grok

// Added by Grok: Route for owner settings password change
Route::post('/owner/update-password', [ForgotPasswordController::class, 'updateOwnerPassword'])->middleware('auth');
// End of addition by Grok

// Added by Grok: Route for hradmin settings password change
Route::post('/hr/update-password', [ForgotPasswordController::class, 'updatehrPassword'])->middleware('auth');

Route::get('/hr/dentist-mapping', [DentistController::class, 'getDentistMapping'])->middleware('auth');

Route::get('/get-available-dentists', [AppointmentController::class, 'getAvailableDentists'])->middleware('auth');

Route::get('/dentist-availability/{date}/{time}', [AppointmentController::class, 'getDentistAvailability']);

Route::get('/available-dentists', [AppointmentController::class, 'getAvailableDentists']);

Route::get('/dentist-availability/{date}', [DentistController::class, 'getAvailability']);

Route::put('/announcements/update/{id}', [AnnouncementController::class, 'update']);

Route::delete('/announcements/{id}', [AnnouncementController::class, 'destroy']);

Route::post('/appointments/check-date', [AppointmentController::class, 'checkAppointmentsOnDate']);
Route::post('/appointments/check-blocked', [AppointmentController::class, 'checkBlockedDate']);
Route::post('/appointments/block-date', [AppointmentController::class, 'blockDate']);
Route::get('/appointments/blocked-dates', [AppointmentController::class, 'getBlockedDates']);
Route::delete('/appointments/block-date/{date}', [AppointmentController::class, 'unblockDate']);