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
use App\Http\Controllers\OwnerLoginTracerController;
use App\Http\Controllers\DentalFormController;
use App\Http\Controllers\PatientNoteController;

// Public Routes
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login']);
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/signup', function () {
    return view('signup');
})->name('signup');

Route::post('/users', [UserController::class, 'store'])->name('users.store');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/services', function () {
    return view('services');
})->name('services');

Route::get('/smilegallery', function () {
    return view('smilegallery');
})->name('smilegallery');

Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements');
Route::get('/announcements/{id}/image', [AnnouncementController::class, 'getAnnouncementImage']);

Route::get('/faqs', function () {
    return view('faqs');
})->name('faqs');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

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

// Patient Routes
Route::middleware(['auth', 'patient'])->group(function () {
    
    Route::get('/patientdashboard', function () {
        return view('patientdashboard');
    })->name('patientdashboard');

    Route::get('/patientinformation', function () {
        return view('patientinformation');
    })->name('patientinformation');

    Route::get('/patientappointments', [AppointmentController::class, 'index'])->name('patient.appointments');
    Route::get('/get-blocked-dates', [AppointmentController::class, 'getBlockedDates']);

    Route::get('/patientscheduleanappointment', function () {
        return view('patientscheduleanappointment');
    })->name('patientscheduleanappointment');

    Route::get('/patientbillings', function () {
        return view('patientbillings');
    })->name('patientbillings');

    Route::get('/api/patientbillings', [BillingController::class, 'getPatientLedger'])->name('api.patient.billings')->middleware(['auth', 'patient']);

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

    Route::post('/patient/appointments/{appointmentId}/cancel', [AppointmentController::class, 'cancelPatientAppointment'])
        ->name('patient.appointments.cancel');

    Route::get('/patient/appointments/updated', [AppointmentController::class, 'getUpdatedAppointments']);
    Route::post('/patient/appointments/{appointmentId}/mark-as-viewed', [AppointmentController::class, 'markAsViewed']);

    Route::post('/patient/update-password', [ForgotPasswordController::class, 'updatePatientPassword'])
        ->name('patient.update-password');

    Route::get('/patient/my-treatment-history', [AppointmentController::class, 'getMyTreatmentHistory']);
    Route::get('/patient/{patientId}/treatment-history', [AppointmentController::class, 'getTreatmentHistory']);

    Route::get('/api/patient-id', [UserController::class, 'getPatientId'])->name('patient.id');
    Route::get('/api/patient-data', [UserController::class, 'getPatientData'])->name('patient.data');
    Route::post('/upload-profile-picture', [UserController::class, 'uploadProfilePicture']);
    Route::put('/api/patients/{patientId}', [UserController::class, 'update'])->name('patients.update');

    Route::prefix('api/patient')->group(function () {
        Route::get('/my-treatment-plans', [DentistFileController::class, 'getLoggedInPatientTreatmentPlans']);
        Route::get('/my-dental-photos', [DentistFileController::class, 'getLoggedInPatientDentalPhotos']);
        Route::get('/download/{type}/{id}', [DentistFileController::class, 'downloadFile']);
        Route::get('/dental-forms', [DentalFormController::class, 'getDentalForms']);
    });
});

// Dentist Routes
Route::middleware(['auth', 'restrict.to:Dentist'])->group(function () {
    Route::get('/dentistdashboard', function () {
        return view('dentistdashboard');
    })->name('dentistdashboard');

    Route::get('/dentistappointments', function () {
        return view('dentistappointments');
    })->name('dentistappointments');

    Route::get('/dentistcalendarschedule', function () {
        return view('dentistcalendarschedule');
    })->name('dentistcalendarschedule');

    Route::get('/dentistpatientlist', function () {
        return view('dentistpatientlist');
    })->name('dentistpatientlist');

    Route::get('/dentistsettings', function () {
        return view('dentistsettings');
    })->name('dentistsettings');

    Route::get('/dentistannouncements', function () {
        return view('dentistannouncements');
    })->name('dentistannouncements');

    Route::get('/dentist/appointments', [AppointmentController::class, 'getDentistAppointments'])->name('dentist.appointments');

    Route::post('/dentist/update-password', [ForgotPasswordController::class, 'updateDentistPassword'])->name('dentist.update-password');

    Route::prefix('api/dentist')->group(function () {
        Route::post('/upload-dental-photos', [DentistFileController::class, 'uploadDentalPhoto']);
        Route::post('/upload-treatment-plans', [DentistFileController::class, 'uploadTreatmentPlan']);
        Route::post('/upload-dental-forms', [DentistFileController::class, 'uploadDentalForm']);
        Route::get('/patient/{patientId}/dental-photos', [DentistFileController::class, 'getDentalPhotos']);
        Route::get('/patient/{patientId}/treatment-plans', [DentistFileController::class, 'getTreatmentPlans']);
        Route::get('/patient/{patientId}/dental-forms', [DentistFileController::class, 'getDentalForms']);
        Route::get('/download/{type}/{id}', [DentistFileController::class, 'downloadFile']);
        Route::delete('/delete/dental/{id}', [DentistFileController::class, 'deleteDentalPhoto']);
        Route::delete('/delete/treatment/{id}', [DentistFileController::class, 'deleteTreatmentPlan']);
        Route::delete('/delete/form/{id}', [DentistFileController::class, 'deleteDentalForm']);
        Route::post('/upload-medical-records', [DentistFileController::class, 'uploadMedicalRecord']);
        Route::get('/patient/{patientId}/medical-records', [DentistFileController::class, 'getMedicalRecords']);

        // New Patient Notes Routes
         Route::get('/patient/{patientId}/notes', [PatientNoteController::class, 'index'])->name('dentist.patient-notes.index');
         Route::post('/patient/notes', [PatientNoteController::class, 'store'])->name('dentist.patient-notes.store');
         Route::put('/patient/notes/{id}', [PatientNoteController::class, 'update'])->name('dentist.patient-notes.update');
         Route::delete('/patient/notes/{id}', [PatientNoteController::class, 'destroy'])->name('dentist.patient-notes.destroy');


    });

    Route::get('/api/dentist/patient-list', [ListPatientController::class, 'getPatientList'])->name('dentist.patient-list');
});

// HR Admin Routes
Route::middleware(['auth', 'restrict.to:HRAdmin'])->group(function () {
    Route::get('/hrdashboard', function () {
        return view('hrdashboard');
    })->name('hrdashboard');

    Route::get('/hrappointments', [AppointmentController::class, 'getPendingAppointments'])->name('hr.appointments.index');

    Route::get('/hrannouncements', function () {
        return view('hrannouncements');
    })->name('hrannouncements');

    // Route::get('/hrmanageservices', function () {
    //     return view('hrmanageservices');
    // })->name('hrmanageservices');

    Route::get('/hrmanageusers', function () {
        return view('hrmanageusers');
    })->name('hrmanageusers');

    // Route::get('/hrpatientbillings', function () {
    //     return view('hrpatientbillings');
    // })->name('hrpatientbillings');

    Route::get('/hrsettings', function () {
        return view('hrsettings');
    })->name('hrsettings');

    Route::get('/hrcalendarschedule', function () {
        return view('hrcalendarschedule');
    })->name('hrcalendarschedule');

    // Route::get('/hrpatientlist', function () {
    //     return view('hrpatientlist');
    // })->name('hrpatientlist');

    Route::get('/hrcreatedentistaccount', function () {
        return view('hrcreatedentistaccount');
    })->name('hrcreatedentistaccount');

    // Route::get('/hr/patients', [PatientController::class, 'indexForHr'])->name('hr.patients.index');
    Route::get('/hr/dentists', [DentistController::class, 'index'])->name('hr.dentists.index');

    Route::post('/hr/update-status', [HRAdminController::class, 'updateStatus'])->name('hr.update-status');
    
    Route::post('/hr/update-password', [ForgotPasswordController::class, 'updatehrPassword'])->name('hr.update-password');

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
});

// Owner Routes
Route::middleware(['auth', 'restrict.to:Owner'])->group(function () {
    Route::get('/ownerdashboard', function () {
        return view('ownerdashboard');
    })->name('ownerdashboard');

    Route::get('/ownerannouncements', function () {
        return view('ownerannouncements');
    })->name('ownerannouncements');

    Route::get('/ownerappointmentsreport', function () {
        return view('ownerappointmentsreport');
    })->name('ownerappointmentsreport');

    Route::get('/ownerappointments', function () {
        return view('ownerappointments');
    })->name('ownerappointments');
    Route::get('/owner/appointments-data', [AppointmentController::class, 'getOwnerAppointments'])->middleware(['auth', 'owner']);
    Route::get('/owner/appointments-data', [AppointmentController::class, 'getOwnerAppointments'])->name('owner.appointments.data');
    Route::put('/owner/appointments/{id}', [AppointmentController::class, 'update'])->name('owner.appointments.update');

    Route::get('/ownercalendarschedule', function () {
        return view('ownercalendarschedule');
    })->name('ownercalendarschedule');

    Route::get('/ownerfinancereports', function () {
        return view('ownerfinancereports');
    })->name('ownerfinancereports');

    Route::get('/ownermanageservices', function () {
        return view('ownermanageservices');
    })->name('ownermanageservices');

    Route::get('/ownermanageusers', function () {
        return view('ownermanageusers');
    })->name('ownermanageusers');

    Route::get('/ownerpatientbillings', function () {
        return view('ownerpatientbillings');
    })->name('ownerpatientbillings');

    Route::get('/ownerlogintracer', function () {
        return view('ownerlogintracer');
    })->name('ownerlogintracer');

    Route::get('/owner/login-tracer-data', [OwnerLoginTracerController::class, 'index'])->name('ownerlogintracer.api');

    Route::get('/ownersettings', function () {
        return view('ownersettings');
    })->name('ownersettings');

    Route::get('/ownerpatientlist', function () {
        return view('ownerpatientlist');
    })->name('ownerpatientlist');

    Route::post('/owner/update-password', [ForgotPasswordController::class, 'updateOwnerPassword'])->name('owner.update-password');

    // Existing owner-specific API endpoints
    Route::get('/owner/billings', [BillingController::class, 'getAllBillings'])->name('owner.billings.index');

    // Add missing billing-related endpoints for Owner role
    Route::get('/owner/payment-methods', [BillingController::class, 'getPaymentMethods'])->name('owner.payment.methods');
    Route::get('/owner/patients-with-balances', [BillingController::class, 'getPatientsWithBalances'])->name('owner.patients-with-balances');
    Route::put('/owner/billings/{id}', [BillingController::class, 'updateBilling'])->name('owner.billings.update');
    Route::post('/owner/billings/add-payment-without-appointment', [BillingController::class, 'addPaymentWithoutAppointment'])->name('owner.billings.add-payment-without-appointment');

    // New routes for calendar and date-blocking functionality
    Route::get('/owner/appointments/calendar', [AppointmentController::class, 'getOwnerAppointments'])->name('owner.appointments.calendar');
    Route::get('/owner/appointments/calendar-data', [AppointmentController::class, 'getOwnerCalendarAppointments'])->name('owner.appointments.calendar-data');


    Route::get('/owner/blocked-dates', [AppointmentController::class, 'getBlockedDates'])->name('owner.blocked-dates');
    Route::post('/owner/block-date', [AppointmentController::class, 'blockDate'])->name('owner.block-date');
    Route::delete('/owner/unblock-date/{date}', [AppointmentController::class, 'unblockDate'])->name('owner.unblock-date');
    Route::post('/owner/check-blocked-date', [AppointmentController::class, 'checkBlockedDate'])->name('owner.check-blocked-date');

    Route::get('/owner/patients', [PatientController::class, 'getOwnerPatients'])->name('owner.patients');

    Route::post('/owner/appointments/book', [AppointmentController::class, 'book']);

});

// Shared Routes (Accessible by multiple roles)
Route::middleware(['auth'])->group(function () {
    Route::get('/get-patient-id', [UserController::class, 'getPatientId'])->name('get-patient-id');

    Route::get('/available-times', [AppointmentController::class, 'getAvailableTimes'])->name('available-times');
    Route::get('/check-dentist-availability', [AppointmentController::class, 'checkDentistAvailability'])->name('check-dentist-availability');
    Route::post('/filter-available-times', [AppointmentController::class, 'filterAvailableTimes'])->name('filter-available-times');

    Route::post('/save-dental-form', [DentalFormController::class, 'saveDentalForm'])->name('save-dental-form');

    Route::get('/appointments/{appointmentId}/consent-form', [AppointmentController::class, 'getConsentForm'])->name('appointments.consent-form');

    Route::post('/announcements/store', [AnnouncementController::class, 'store'])->name('announcements.store');
    Route::get('/announcements/patient', [AnnouncementController::class, 'getPatientAnnouncements'])->name('announcements.patient');
    Route::get('/announcements/dentist', [AnnouncementController::class, 'getDentistAnnouncements'])->name('announcements.dentist');
    Route::get('/announcements/hr', [AnnouncementController::class, 'getHrAnnouncements'])->name('announcements.hr');
    Route::get('/announcements/{audience}', [AnnouncementController::class, 'getAnnouncementsByAudience'])
        ->whereIn('audience', ['patient', 'dentist'])
        ->name('announcements.byAudience');
    Route::post('/announcements/store/hr', [AnnouncementController::class, 'storeHr'])->name('announcements.store.hr');
    Route::post('/announcements/store/owner', [AnnouncementController::class, 'storeOwner'])->name('announcements.store.owner');

    Route::get('/service-sales-report', [ServiceSalesReportController::class, 'index'])->name('service-sales-report');

    Route::get('/get-available-dentists', [AppointmentController::class, 'getAvailableDentists'])->name('get-available-dentists');

    Route::get('/dentist-availability/{date}/{time}', [AppointmentController::class, 'getDentistAvailability'])->name('dentist-availability');

    Route::get('/available-dentists', [AppointmentController::class, 'getAvailableDentists'])->name('available-dentists');

    Route::get('/dentist-availability/{date}', [DentistController::class, 'getAvailability'])->name('dentist-availability.date');

    Route::put('/announcements/update/{id}', [AnnouncementController::class, 'update'])->name('announcements.update');

    Route::delete('/announcements/{id}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');

    Route::post('/appointments/check-date', [AppointmentController::class, 'checkAppointmentsOnDate'])->name('appointments.check-date');
    Route::post('/appointments/check-blocked', [AppointmentController::class, 'checkBlockedDate'])->name('appointments.check-blocked');
    Route::post('/appointments/block-date', [AppointmentController::class, 'blockDate'])->name('appointments.block-date');
    Route::get('/appointments/blocked-dates', [AppointmentController::class, 'getBlockedDates'])->name('appointments.blocked-dates');
    Route::delete('/appointments/block-date/{date}', [AppointmentController::class, 'unblockDate'])->name('appointments.unblock-date');
});

// User Management Routes (HRAdmin and Owner only)
Route::middleware(['auth', 'restrict.to:HRAdmin,Owner'])->group(function () {

Route::get('/hr/billings', [BillingController::class, 'getAllBillings'])->name('hr.billings.index');
    Route::get('/hr/billings/{appointmentId}', [BillingController::class, 'getBilling'])->name('hr.billings.show');
    Route::put('/hr/billings/{id}', [BillingController::class, 'updateBilling'])->name('hr.billings.update');
    Route::get('/hr/multi-visit-billing/{patientId}/{procedure}', [BillingController::class, 'getMultiVisitBilling'])->name('hr.multi-visit-billing');
    Route::get('/hr/payment-methods', [BillingController::class, 'getPaymentMethods'])->name('hr.payment.methods');
    Route::get('/hr/get-service-cost/{appointmentId}', [BillingController::class, 'getServiceCost'])->name('hr.get-service-cost');
    Route::post('/hr/billings/approve-insurance', [BillingController::class, 'approveInsuranceBillings'])->name('hr.billings.approve-insurance');

    Route::put('/hr/billings/{billingId}/decline-insurance', [BillingController::class, 'declineInsuranceBilling'])->name('hr.billings.decline-insurance');

    Route::post('/hr/payments/{billingId}', [PaymentController::class, 'recordPayment'])->name('hr.payments.store');

    Route::get('/appointments/consent-form/{appointmentId}', [AppointmentController::class, 'getConsentForm'])->name('hr.appointments.consent-form');

    Route::get('/hr/patient-ledger/{patientId}', [BillingController::class, 'getPatientLedger'])->name('hr.patient-ledger');

    Route::post('/hr/billings/add-payment-without-appointment', [BillingController::class, 'addPaymentWithoutAppointment'])->name('hr.billings.add-payment-without-appointment');


    Route::post('/hr/appointments/book', [AppointmentController::class, 'storeHrConfirmedAppointment'])->name('hr.appointments.book');
     Route::put('/hr/appointments/{id}', [AppointmentController::class, 'update'])->name('hr.appointments.update');
     Route::post('/hr/appointments/update-treatment-progress', [AppointmentController::class, 'updateTreatmentProgress'])->name('hr.appointments.update-treatment-progress');
     Route::get('/hr/dentist-mapping', [DentistController::class, 'getDentistMapping'])->name('hr.dentist-mapping');
     Route::get('/hr/appointments/calendar', [AppointmentController::class, 'getHrAppointments'])->name('hr.appointments.calendar');
     Route::get('/hr/patients-with-balances', [BillingController::class, 'getPatientsWithBalances'])->name('hr.patients-with-balances');

    
    Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
    Route::post('/patients', [UserController::class, 'store'])->name('patients.store');

    Route::post('/dentists', [DentistController::class, 'store'])->name('dentists.store');
    Route::get('/dentists', [DentistController::class, 'index'])->name('dentists.index');

    Route::post('/owners', [UserController::class, 'storeOwner'])->name('owners.store');
    Route::get('/owners', [UserController::class, 'getOwners'])->name('owners.index');

    Route::get('/hradmins', [HRAdminController::class, 'index'])->name('hradmins.index');
    Route::post('/hradmins', [HRAdminController::class, 'store'])->name('hradmins.store');

    Route::get('/dentist-mapping', [DentistController::class, 'getDentistMapping'])->name('dentist-mapping');
    Route::get('/billings', [BillingController::class, 'getAllBillings'])->name('billings.index');
    Route::get('/payment-methods', [BillingController::class, 'getPaymentMethods'])->name('payment.methods');
    Route::get('/patients-with-balances', [BillingController::class, 'getPatientsWithBalances'])->name('patients-with-balances');
    Route::put('/billings/{id}', [BillingController::class, 'updateBilling'])->name('billings.update');
    Route::post('/billings/add-payment-without-appointment', [BillingController::class, 'addPaymentWithoutAppointment'])->name('billings.add-payment-without-appointment');

    Route::get('/hr/patients', [PatientController::class, 'indexForHr'])->name('hr.patients.index');

    Route::get('/hrmanageservices', function () {
        return view('hrmanageservices');
    })->name('hrmanageservices');

    Route::get('/hrpatientbillings', function () {
        return view('hrpatientbillings');
    })->name('hrpatientbillings');

    Route::get('/hrpatientlist', function () {
        return view('hrpatientlist');
    })->name('hrpatientlist');

    Route::post('/hr/update-status', [HRAdminController::class, 'updateStatus'])->name('hr.update-status');

    Route::get('/hr/{userId}/days-off', [DentistController::class, 'getDaysOff']);
    Route::put('/hr/{userId}/days-off', [DentistController::class, 'updateDaysOff']);

});

// User Management Routes (Dentist and HRAdmin only)
Route::middleware(['auth', 'restrict.to:Dentist,HRAdmin'])->group(function () {

    Route::get('/patient/{patientId}/notes', [PatientNoteController::class, 'index'])->name('dentist.patient-notes.index');
    Route::post('/patient/notes', [PatientNoteController::class, 'store'])->name('dentist.patient-notes.store');
    Route::put('/patient/notes/{id}', [PatientNoteController::class, 'update'])->name('dentist.patient-notes.update');
    Route::delete('/patient/notes/{id}', [PatientNoteController::class, 'destroy'])->name('dentist.patient-notes.destroy');

});

// User Management Routes (Dentist and HRAdmin only)
 Route::middleware(['auth', 'restrict.to:Dentist,HRAdmin'])->group(function () {
 
     Route::get('/patient/{patientId}/notes', [PatientNoteController::class, 'index'])->name('dentist.patient-notes.index');
     Route::post('/patient/notes', [PatientNoteController::class, 'store'])->name('dentist.patient-notes.store');
     Route::put('/patient/notes/{id}', [PatientNoteController::class, 'update'])->name('dentist.patient-notes.update');
     Route::delete('/patient/notes/{id}', [PatientNoteController::class, 'destroy'])->name('dentist.patient-notes.destroy');
 
 });

// Other Routes
Route::get('/get-dentists', [UserController::class, 'getDentists'])->name('get-dentists');
Route::post('/services/store', [ServiceController::class, 'store'])->name('services.store');
Route::put('/services/update/{id}', [ServiceController::class, 'update'])->name('services.update');
Route::get('/services/list', [ServiceController::class, 'list'])->name('services.list');

Route::get('/patient-list', [ListPatientController::class, 'index'])->name('patient.list');

Route::post('/assign-dentist', [AppointmentController::class, 'assignDentist'])->name('assign.dentist');

Route::post('/users/check-email', [UserController::class, 'checkEmail'])->name('users.check-email');
Route::post('/users/check-username', [UserController::class, 'checkUsername'])->name('users.check-username');

Route::get('/patient/appointments/{patientId}', [AppointmentController::class, 'getPatientAppointments'])->name('patient.appointments');

Route::get('/check-appointment-date', [AppointmentController::class, 'checkPatientAppointmentDate'])->middleware('auth')->name('check-appointment-date');

Route::get('/hr/dentist-availability/{date}', [DentistController::class, 'getAvailability']);
