import './bootstrap';

// Import Vue 3
import { createApp } from 'vue';

// Website Components
import HomePage from './components/Website/HomePage.vue';
import Login from './components/Website/Login.vue';
import Signup from './components/Website/Signup.vue';
import AboutUs from './components/Website/AboutUs.vue';
import Services from './components/Website/Services.vue';
import SmileGallery from './components/Website/SmileGallery.vue';
import Announcements from './components/Website/Announcements.vue';
import Faqs from './components/Website/Faqs.vue';
import ContactUs from './components/Website/ContactUs.vue';
import ForgotPassword from './components/Website/ForgotPassword.vue';
import VerifyPin from './components/Website/VerifyPin.vue';
import ResetPassword from './components/Website/ResetPassword.vue';

// Patient Components
import PatientDashboard from './components/Patients/PatientDashboard.vue';
import PatientInformation from './components/Patients/PatientInformation.vue';
import PatientAppointments from './components/Patients/PatientAppointments.vue';
import PatientScheduleAnAppointment from './components/Patients/PatientScheduleAnAppointment.vue';
import PatientBillings from './components/Patients/PatientBillings.vue';
import PatientTreatments from './components/Patients/PatientTreatments.vue';
import PatientTreatmentPlan from './components/Patients/PatientTreatmentPlan.vue';
import PatientDentalPhotos from './components/Patients/PatientDentalPhotos.vue';
import PatientForms from './components/Patients/PatientForms.vue';
import PatientDentalTreatmentHistory from './components/Patients/PatientDentalTreatmentHistory.vue';
import PatientSettings from './components/Patients/PatientSettings.vue';
import PatientAnnouncements from './components/Patients/PatientAnnouncements.vue';

// Owner Components
import OwnerDashboard from './components/Owner/OwnerDashboard.vue';
import OwnerAnnouncements from './components/Owner/OwnerAnnouncements.vue';
import OwnerAppointments from './components/Owner/OwnerAppointments.vue';
import OwnerCalendarSchedule from './components/Owner/OwnerCalendarSchedule.vue';
import OwnerFinanceReports from './components/Owner/OwnerFinanceReports.vue';
import OwnerAppointmentsReport from './components/Owner/OwnerAppointmentsReport.vue';
import OwnerManageServices from './components/Owner/OwnerManageServices.vue';
import OwnerManageUsers from './components/Owner/OwnerManageUsers.vue';
import OwnerPatientBillings from './components/Owner/OwnerPatientBillings.vue';
import OwnerPatientList from './components/Owner/OwnerPatientList.vue';
import OwnerLoginTracer from './components/Owner/OwnerLoginTracer.vue';
import OwnerSettings from './components/Owner/OwnerSettings.vue';

// HR Components
import HRDashboard from './components/HR/HRDashboard.vue';
import HRAnnouncements from './components/HR/HRAnnouncements.vue';
import HRAppointments from './components/HR/HRAppointments.vue';
import HRManageServices from './components/HR/HRManageServices.vue';
import HRManageUsers from './components/HR/HRManageUsers.vue';
import HRPatientBillings from './components/HR/HRPatientBillings.vue';
import HRSettings from './components/HR/HRSettings.vue';
import HRPatientList from './components/HR/HRPatientList.vue';
import HRCalendarSchedule from './components/HR/HRCalendarSchedule.vue';

// Dentist Components
import DentistDashboard from './components/Dentist/DentistDashboard.vue';
import DentistCalendarSchedule from './components/Dentist/DentistCalendarSchedule.vue';
import DentistPatientList from './components/Dentist/DentistPatientList.vue';
import DentistSettings from './components/Dentist/DentistSettings.vue';
import DentistAnnouncements from './components/Dentist/DentistAnnouncements.vue';

const app = createApp({
    components: {
        HomePage,
        Login,
        Signup,
        AboutUs,
        Services,
        SmileGallery,
        Announcements,
        Faqs,
        ContactUs,
        ForgotPassword,
        VerifyPin,
        ResetPassword,

        PatientDashboard,
        PatientAppointments,
        PatientBillings,
        PatientInformation,
        PatientSettings,
        PatientTreatments,
        PatientTreatmentPlan,
        PatientScheduleAnAppointment,
        PatientDentalPhotos,
        PatientForms,
        PatientDentalTreatmentHistory,
        PatientAnnouncements,

        OwnerDashboard,
        OwnerAppointmentsReport,
        OwnerAnnouncements,
        OwnerAppointments,
        OwnerCalendarSchedule,
        OwnerFinanceReports,
        OwnerManageServices,
        OwnerManageUsers,
        OwnerPatientBillings,
        OwnerPatientList,
        OwnerLoginTracer,
        OwnerSettings,

        HRDashboard,
        HRAnnouncements,
        HRAppointments,
        HRManageServices,
        HRManageUsers,
        HRPatientBillings,
        HRSettings,
        HRPatientList,
        HRCalendarSchedule,

        DentistDashboard,
        DentistCalendarSchedule,
        DentistPatientList,
        DentistSettings,
        DentistAnnouncements,
    }
});

// Configure Axios safely
axios.defaults.baseURL = '/';

// Safely set the CSRF token
const csrfToken = document.querySelector('meta[name="csrf-token"]');
if (csrfToken) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken.getAttribute('content');
} else {
    console.warn('CSRF token meta tag not found. POST requests may fail.');
}

// Debug: Log before mounting
console.log("Mounting Vue app...");

app.mount("#app");

// Debug: Log after mounting
console.log("Vue app mounted successfully");