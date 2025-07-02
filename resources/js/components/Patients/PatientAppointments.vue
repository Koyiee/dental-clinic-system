<template>
<div class="sidebar close">
  <!-- Sidebar content unchanged -->
  <div class="logo-details">
    <img src="@/components/Images/ATDC_Logo.png" alt="" class="logo">
    <div class="logo_name"><img class="img2" src="@/components/Images/ATDC_Logo3.png" alt=""></div>
  </div>
  <ul class="nav-link">
    <li>
      <a href="/patientdashboard">
        <i class="bx bx-grid-alt"></i>
        <span class="link_name">Dashboard</span>
      </a>
      <ul class="sub-menu blank">
          <li><a class="link_name" href="/patientdashboard">Dashboard</a></li>
      </ul>
    </li>
    <li>
      <a href="/patientannouncements">
        <i class="bx bxs-megaphone"></i>
        <span class="link_name">Announcements</span>
      </a>
      <ul class="sub-menu blank">
          <li><a class="link_name" href="/patientannouncements">Announcements</a></li>
      </ul>
    </li>
    <li>
      <a href="/patientinformation">
        <i class="bx bx-clipboard"></i>
        <span class="link_name">Patient Information</span>
      </a>
      <ul class="sub-menu blank">
          <li><a class="link_name" href="/patientinformation">Patient Information</a></li>
      </ul>
    </li>
    <li>
      <div class="icon-link">
        <a href="/patientappointments">
          <i class="bx bx-calendar"></i>
          <span class="link_name">Appointment</span>
        </a>
        <i class="bx bxs-chevron-down arrow"></i>
      </div>
      <ul class="sub-menu">
        <li><a class="link_name" href="/patientappointments">Appointment</a></li>
        <li><a href="/patientscheduleanappointment">Schedule Appointment</a></li>
      </ul>
    </li>
    <li>
      <a href="/patientbillings">
        <i class="bx bx-wallet"></i>
        <span class="link_name">Billing</span>
      </a>
      <ul class="sub-menu blank">
          <li><a class="link_name" href="/patientbillings">Billing</a></li>
      </ul>
    </li>
    <li>
      <div class="icon-link">
        <a href="/patienttreatments">
          <i class="bx bx-clipboard"></i>
          <span class="link_name">Treatments</span>
        </a>
        <i class="bx bxs-chevron-down arrow"></i>
      </div>
      <ul class="sub-menu">
        <li><a class="link_name" href="/patienttreatments">Treatments</a></li>
        <li><a href="/patienttreatmentplan">Treatment Plan</a></li>
        <li><a href="/patientdentalphotos">Dental Photos</a></li>
        <li><a href="/patientforms">Forms</a></li>
        <li><a href="/patientdentaltreatmenthistory">Dental Treatment History</a></li>
      </ul>
    </li>
    <li>
      <a href="/patientsettings">
        <i class="bx bx-cog"></i>
        <span class="link_name">Settings</span>
      </a>
      <ul class="sub-menu blank">
          <li><a class="link_name" href="/patientsettings">Settings</a></li>
      </ul>
    </li>
    <li>
      <div class="profile-details" @click="confirmLogout">
        <div class="profile-content">
          <img 
            v-if="profilePicture" 
            :src="`/storage/${profilePicture}`" 
            alt="profile" 
            class="profile-image" 
            @error="handleImageError"
          >
          <img 
            v-else 
            src="../Images/profile_1.jpg" 
            alt="profile" 
            class="profile-image"
          >
        </div>
        <div class="name-job">
          <div class="profile_name">{{ fullName }}</div>
          <div class="job">Patient</div>
        </div>
        <i class="bx bx-log-out"></i>
      </div>
    </li>
  </ul>
</div>

<!-- Mobile Overlay -->
<div class="mobile-overlay" @click="closeMobileSidebar"></div>

<section class="home-section">
  <div class="home-content">
    <div class="header">
      <i class="bx bx-menu"></i>
      <div class="text">
          <h3>Appointments</h3>
          <div class="breadcrumbs">
            <a class="none" href=""><p>Home / </p></a>
            <a class="current" href="/patientappointments"><p>  Appointments</p></a>
          </div>
      </div>
    </div>
    <hr color="#06693a">
    
    <!-- Search and Filter Section -->
    <div class="search-wrapper">
      <div class="search-container">
        <input 
          v-model="searchQuery" 
          placeholder="Search by dentist, procedure or date" 
          @keyup.enter="filterAppointments" 
          class="search-input"
          :class="{ 'has-reset': searchQuery && isSearchActive }"
        />
        <i class="bx bx-search search-icon" @click="filterAppointments"></i>
        <button 
          v-if="isSearchActive" 
          @click="resetSearch" 
          class="reset-button"
          title="Reset search"
        >
          <i class='bx bx-x'></i>
        </button>
      </div>
      <div class="buttons">
        <button class="filter" @click="toggleFilterMenu">
          <i class='bx bx-filter'></i> Filter
        </button>
        <div v-if="showFilterMenu" class="filter-menu">
          <div class="filter-group">
            <label>Date Range:</label>
            <input type="date" v-model="filter.startDate">
            <input type="date" v-model="filter.endDate">
          </div>
          <div class="filter-group">
            <label>Dentist:</label>
            <select v-model="filter.dentist">
              <option value="">All Dentists</option>
              <option v-for="dentist in uniqueDentists" :key="dentist" :value="dentist">
                {{ dentist }}
              </option>
            </select>
          </div>
          <div class="filter-actions">
            <button class="apply-btn" @click="applyFilters">Apply Filters</button>
            <button class="reset-btn" @click="resetFilters">Reset</button>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Toggle buttons for appointment types -->
    <div class="toggle-buttons">
      <button class="toggle-btn" :class="{ 'active': activeTab === 'upcoming' }" @click="activeTab = 'upcoming'">
        <i class='bx bx-time'></i> Upcoming Appointments
      </button>
      <button class="toggle-btn" :class="{ 'active': activeTab === 'declined' }" @click="activeTab = 'declined'">
        <i class='bx bx-x-circle'></i> Declined & Cancelled
      </button>
      <button class="toggle-btn" :class="{ 'active': activeTab === 'passed' }" @click="activeTab = 'passed'">
        <i class='bx bx-check-circle'></i> Past Appointments
      </button>
    </div>
    
    <!-- Upcoming Appointments Section -->
    <div class="appointment-container" v-show="activeTab === 'upcoming'">
      <div class="appointment">
        <h3>UPCOMING APPOINTMENTS</h3>
      </div>
      <div class="table-wrapper">
        <table class="appointment-table desktop-table">
          <thead>
            <tr>
              <th style="padding-left:25px;" @click="sortTable('AppointmentDate', 'upcoming')" class="sortable-header">Date and Time <i v-if="sortConfig.upcoming.key === 'AppointmentDate'" class="bx" :class="getSortIconClass('AppointmentDate', 'upcoming')"></i></th>
              <th @click="sortTable('AppointmentStatus', 'upcoming')" class="sortable-header">Status <i v-if="sortConfig.upcoming.key === 'AppointmentStatus'" class="bx" :class="getSortIconClass('AppointmentStatus', 'upcoming')"></i></th>
              <th @click="sortTable('Services', 'upcoming')" class="sortable-header services-column">Services <i v-if="sortConfig.upcoming.key === 'Services'" class="bx" :class="getSortIconClass('Services', 'upcoming')"></i></th>
              <th @click="sortTable('PatientNote', 'upcoming')" class="sortable-header">Notes <i v-if="sortConfig.upcoming.key === 'PatientNote'" class="bx" :class="getSortIconClass('PatientNote', 'upcoming')"></i></th>
              <th @click="sortTable('DentistName', 'upcoming')" class="sortable-header">Dentist <i v-if="sortConfig.upcoming.key === 'DentistName'" class="bx" :class="getSortIconClass('DentistName', 'upcoming')"></i></th>
              <th style="text-align: center;" class="action-header">Action</th>
            </tr>
          </thead>
          <tbody class="container-appointment">
            <tr v-for="appointment in displayedUpcomingAppointments" :key="appointment.AppointmentID" class="appointment-row">
              <td style="padding-left: 25px;" class="truncate-cell">{{ formatDateAndTime(appointment.AppointmentDate, appointment.AppointmentTime) }}</td>
              <td class="truncate-cell">
                <span class="status-badge" :class="getStatusClass(appointment.ServiceStatus || appointment.AppointmentStatus)">
                  {{ appointment.ServiceStatus || appointment.AppointmentStatus || 'N/A' }}
                </span>
              </td>
              <td class="truncate-cell services-cell">{{ appointment.Services && appointment.Services.length > 0 ? appointment.Services.join(', ') : 'N/A' }}</td>
              <td class="truncate-cell">{{ appointment.PatientNote || 'No notes' }}</td>
              <td class="truncate-cell">{{ appointment.DentistName || 'N/A' }}</td>
              <td class="action-cell">
                <button class="view-details-btn" @click="openAppointmentModal(appointment)" title="View Details">
                  <i class='bx bx-show'></i>
                </button>
              </td>
            </tr>
            <tr v-if="displayedUpcomingAppointments.length === 0">
              <td colspan="6" class="no-data">No Upcoming Appointments...</td>
            </tr>
          </tbody>
        </table>
        <div class="mobile-cards">
          <div v-for="appointment in displayedUpcomingAppointments" :key="appointment.AppointmentID" class="appointment-card">
            <div class="card-header">
              <h4>{{ formatDateAndTime(appointment.AppointmentDate, appointment.AppointmentTime) }}</h4>
              <button class="view-details-btn mobile" @click="openAppointmentModal(appointment)" title="View Details">
                <i class='bx bx-show'></i>
              </button>
            </div>
            <div class="card-content">
              <div class="card-row">
                <span class="card-label">Status:</span>
                <span class="status-badge" :class="getStatusClass(appointment.ServiceStatus || appointment.AppointmentStatus)">
                  {{ appointment.ServiceStatus || appointment.AppointmentStatus || 'N/A' }}
                </span>
              </div>
              <div class="card-row">
                <span class="card-label">Services:</span>
                <span>{{ appointment.Services && appointment.Services.length > 0 ? appointment.Services.join(', ') : 'N/A' }}</span>
              </div>
              <div class="card-row">
                <span class="card-label">Notes:</span>
                <span class="card-notes">{{ appointment.PatientNote || 'No notes' }}</span>
              </div>
              <div class="card-row">
                <span class="card-label">Dentist:</span>
                <span>{{ appointment.DentistName || 'N/A' }}</span>
              </div>
            </div>
          </div>
          <div v-if="displayedUpcomingAppointments.length === 0" class="no-data-mobile">No Upcoming Appointments</div>
        </div>
      </div>
    </div>
    
    <!-- Declined & Cancelled Appointments Section -->
    <div class="appointment-container" v-show="activeTab === 'declined'">
      <div class="appointment">
        <h3>DECLINED & CANCELLED APPOINTMENTS</h3>
      </div>
      <div class="table-wrapper">
        <table class="appointment-table desktop-table">
          <thead>
            <tr>
              <th style="padding-left:25px;" @click="sortTable('AppointmentDate', 'declined')" class="sortable-header">Date and Time <i v-if="sortConfig.declined.key === 'AppointmentDate'" class="bx" :class="getSortIconClass('AppointmentDate', 'declined')"></i></th>
              <th @click="sortTable('AppointmentStatus', 'declined')" class="sortable-header">Status <i v-if="sortConfig.declined.key === 'AppointmentStatus'" class="bx" :class="getSortIconClass('AppointmentStatus', 'declined')"></i></th>
              <th @click="sortTable('Services', 'declined')" class="sortable-header services-column">Services <i v-if="sortConfig.declined.key === 'Services'" class="bx" :class="getSortIconClass('Services', 'declined')"></i></th>
              <th @click="sortTable('PatientNote', 'declined')" class="sortable-header">Notes <i v-if="sortConfig.declined.key === 'PatientNote'" class="bx" :class="getSortIconClass('PatientNote', 'declined')"></i></th>
              <th @click="sortTable('DentistName', 'declined')" class="sortable-header">Dentist <i v-if="sortConfig.declined.key === 'DentistName'" class="bx" :class="getSortIconClass('DentistName', 'declined')"></i></th>
              <th style="text-align: center;" class="action-header">Action</th>
            </tr>
          </thead>
          <tbody class="container-appointment">
            <tr v-for="appointment in displayedDeclinedCancelledAppointments" :key="appointment.AppointmentID" class="appointment-row">
              <td style="padding-left: 25px;" class="truncate-cell">{{ formatDateAndTime(appointment.AppointmentDate, appointment.AppointmentTime) }}</td>
              <td class="truncate-cell">
                <span class="status-badge" :class="getStatusClass(appointment.ServiceStatus || appointment.AppointmentStatus)">
                  {{ appointment.ServiceStatus || appointment.AppointmentStatus || 'N/A' }}
                </span>
              </td>
              <td class="truncate-cell services-cell">{{ appointment.Services && appointment.Services.length > 0 ? appointment.Services.join(', ') : 'N/A' }}</td>
              <td class="truncate-cell">{{ appointment.PatientNote || 'No notes' }}</td>
              <td class="truncate-cell">{{ appointment.DentistName || 'N/A' }}</td>
              <td class="action-cell">
                <button class="view-details-btn" @click="openAppointmentModal(appointment)" title="View Details">
                  <i class='bx bx-show'></i>
                </button>
              </td>
            </tr>
            <tr v-if="displayedDeclinedCancelledAppointments.length === 0">
              <td colspan="6" class="no-data">No Declined or Cancelled Appointments...</td>
            </tr>
          </tbody>
        </table>
        <div class="mobile-cards">
          <div v-for="appointment in displayedDeclinedCancelledAppointments" :key="appointment.AppointmentID" class="appointment-card">
            <div class="card-header">
              <h4>{{ formatDateAndTime(appointment.AppointmentDate, appointment.AppointmentTime) }}</h4>
              <button class="view-details-btn mobile" @click="openAppointmentModal(appointment)" title="View Details">
                <i class='bx bx-show'></i>
              </button>
            </div>
            <div class="card-content">
              <div class="card-row">
                <span class="card-label">Status:</span>
                <span class="status-badge" :class="getStatusClass(appointment.ServiceStatus || appointment.AppointmentStatus)">
                  {{ appointment.ServiceStatus || appointment.AppointmentStatus || 'N/A' }}
                </span>
              </div>
              <div class="card-row">
                <span class="card-label">Services:</span>
                <span>{{ appointment.Services && appointment.Services.length > 0 ? appointment.Services.join(', ') : 'N/A' }}</span>
              </div>
              <div class="card-row">
                <span class="card-label">Notes:</span>
                <span class="card-notes">{{ appointment.PatientNote || 'No notes' }}</span>
              </div>
              <div class="card-row">
                <span class="card-label">Dentist:</span>
                <span>{{ appointment.DentistName || 'N/A' }}</span>
              </div>
            </div>
          </div>
          <div v-if="displayedDeclinedCancelledAppointments.length === 0" class="no-data-mobile">No Declined or Cancelled Appointments</div>
        </div>
      </div>
    </div>
    
    <!-- Passed Appointments Section -->
    <div class="appointment-container" v-show="activeTab === 'passed'">
      <div class="appointment">
        <h3>PAST APPOINTMENTS</h3>
      </div>
      <div class="table-wrapper">
        <table class="appointment-table desktop-table">
          <thead>
            <tr>
              <th style="padding-left:25px;" @click="sortTable('AppointmentDate', 'passed')" class="sortable-header">Date and Time <i v-if="sortConfig.passed.key === 'AppointmentDate'" class="bx" :class="getSortIconClass('AppointmentDate', 'passed')"></i></th>
              <th @click="sortTable('AppointmentStatus', 'passed')" class="sortable-header">Status <i v-if="sortConfig.passed.key === 'AppointmentStatus'" class="bx" :class="getSortIconClass('AppointmentStatus', 'passed')"></i></th>
              <th @click="sortTable('Services', 'passed')" class="sortable-header services-column">Services <i v-if="sortConfig.passed.key === 'Services'" class="bx" :class="getSortIconClass('Services', 'passed')"></i></th>
              <th @click="sortTable('PatientNote', 'passed')" class="sortable-header">Notes <i v-if="sortConfig.passed.key === 'PatientNote'" class="bx" :class="getSortIconClass('PatientNote', 'passed')"></i></th>
              <th @click="sortTable('DentistName', 'passed')" class="sortable-header">Dentist <i v-if="sortConfig.passed.key === 'DentistName'" class="bx" :class="getSortIconClass('DentistName', 'passed')"></i></th>
              <th style="text-align: center;" class="action-header">Action</th>
            </tr>
          </thead>
          <tbody class="container-appointment">
            <tr v-for="appointment in displayedPassedAppointments" :key="appointment.AppointmentID" class="appointment-row">
              <td style="padding-left: 25px;" class="truncate-cell">{{ formatDateAndTime(appointment.AppointmentDate, appointment.AppointmentTime) }}</td>
              <td class="truncate-cell">
                <span class="status-badge" :class="getStatusClass(appointment.ServiceStatus || appointment.AppointmentStatus)">
                  {{ appointment.ServiceStatus || appointment.AppointmentStatus || 'N/A' }}
                </span>
              </td>
              <td class="truncate-cell services-cell">{{ appointment.Services && appointment.Services.length > 0 ? appointment.Services.join(', ') : 'N/A' }}</td>
              <td class="truncate-cell">{{ appointment.PatientNote || 'No notes' }}</td>
              <td class="truncate-cell">{{ appointment.DentistName || 'N/A' }}</td>
              <td class="action-cell">
                <button class="view-details-btn" @click="openAppointmentModal(appointment)" title="View Details">
                  <i class='bx bx-show'></i>
                </button>
              </td>
            </tr>
            <tr v-if="displayedPassedAppointments.length === 0">
              <td colspan="6" class="no-data">No Past Appointments...</td>
            </tr>
          </tbody>
        </table>
        <div class="mobile-cards">
          <div v-for="appointment in displayedPassedAppointments" :key="appointment.AppointmentID" class="appointment-card">
            <div class="card-header">
              <h4>{{ formatDateAndTime(appointment.AppointmentDate, appointment.AppointmentTime) }}</h4>
              <button class="view-details-btn mobile" @click="openAppointmentModal(appointment)" title="View Details">
                <i class='bx bx-show'></i>
              </button>
            </div>
            <div class="card-content">
              <div class="card-row">
                <span class="card-label">Status:</span>
                <span class="status-badge" :class="getStatusClass(appointment.ServiceStatus || appointment.AppointmentStatus)">
                  {{ appointment.ServiceStatus || appointment.AppointmentStatus || 'N/A' }}
                </span>
              </div>
              <div class="card-row">
                <span class="card-label">Services:</span>
                <span>{{ appointment.Services && appointment.Services.length > 0 ? appointment.Services.join(', ') : 'N/A' }}</span>
              </div>
              <div class="card-row">
                <span class="card-label">Notes:</span>
                <span class="card-notes">{{ appointment.PatientNote || 'No notes' }}</span>
              </div>
              <div class="card-row">
                <span class="card-label">Dentist:</span>
                <span>{{ appointment.DentistName || 'N/A' }}</span>
              </div>
            </div>
          </div>
          <div v-if="displayedPassedAppointments.length === 0" class="no-data-mobile">No Past Appointments</div>
        </div>
      </div>
    </div>

    <!-- Appointment Details Modal -->
    <div v-if="showModal" class="modal-overlay" @click="closeModal">
      <div class="modal" @click.stop>
        <div class="modal-header">
          <h3>Appointment Details</h3>
          <button class="close-icon" @click="closeModal">×</button>
        </div>
        <div class="modal-body">
          <div class="appointment-info">
            <div class="info-group">
              <i class="bx bx-calendar"></i>
              <div>
                <label>Date & Time:</label>
                <span>{{ formatFullDateAndTime(selectedAppointment.AppointmentDate, selectedAppointment.AppointmentTime) }}</span>
              </div>
            </div>
            <div class="info-group">
              <i class="bx bx-check-circle"></i>
              <div>
                <label>Appointment Status:</label>
                <span class="status-badge" :class="getStatusClass(selectedAppointment.ServiceStatus || selectedAppointment.AppointmentStatus)">
                  {{ selectedAppointment.ServiceStatus || selectedAppointment.AppointmentStatus || 'N/A' }}
                </span>
              </div>
            </div>
            <div class="info-group">
              <i class="bx bx-briefcase-alt-2"></i>
              <div>
                <label>Services:</label>
                <span>{{ selectedAppointment.Services && selectedAppointment.Services.length > 0 ? selectedAppointment.Services.join(', ') : 'N/A' }}</span>
              </div>
            </div>
            <div class="info-group">
              <i class="bx bx-note"></i>
              <div>
                <label>Patient Note:</label>
                <span>{{ selectedAppointment.PatientNote || 'No notes' }}</span>
              </div>
            </div>
            <div class="info-group">
              <i class="bx bx-user-pin"></i>
              <div>
                <label>Dentist:</label>
                <span>{{ selectedAppointment.DentistName || 'N/A' }}</span>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="cancel-btn" @click="cancelAppointment" :disabled="selectedAppointment.AppointmentStatus !== 'Pending' || isCancelling">
            {{ isCancelling ? 'Cancelling...' : 'Cancel Appointment' }}
          </button>
        </div>
      </div>
    </div>

    <!-- Confirmation Modal for Cancelling Appointment -->
    <div v-if="showCancelConfirmModal" class="modal-overlay" @click="showCancelConfirmModal = false">
      <div class="confirm-modal-container" @click.stop>
        <div class="confirm-modal-header">
          <h3>Confirm Cancellation</h3>
          <button class="close-btn" @click="showCancelConfirmModal = false">
            <i class="bx bx-x"></i>
          </button>
        </div>
        <div class="confirm-modal-body">
          <p>Are you sure you want to cancel this appointment?</p>
        </div>
        <div class="confirm-modal-footer">
          <button class="confirm-cancel-btn" @click="showCancelConfirmModal = false">No, Keep</button>
          <button class="confirm-save-btn" @click="confirmCancelAppointment">Yes, Cancel</button>
        </div> 
      </div>
    </div>
  </div>
</section>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2'; // Import SweetAlert2

export default {
name: "PatientAppointments",
props: {
  firstName: { type: String, required: true },
  lastName: { type: String, required: true },
  profilePicture: {
    type: String,
    default: null,
  },
},
data() {
  return {
    profilePicture: sessionStorage.getItem('user_profile_picture') || this.profilePicture,
    upcomingAppointments: [],
    passedAppointments: [],
    declinedCancelledAppointments: [],
    searchQuery: '',
    showModal: false,
    showCancelConfirmModal: false, // New modal state
    showFilterMenu: false,
    selectedAppointment: null,
    isCancelling: false,
    activeTab: 'upcoming',
    filter: {
      startDate: '',
      endDate: '',
      dentist: ''
    },
    isSearchActive: false,
    displayedUpcomingAppointments: [],
    displayedPassedAppointments: [],
    displayedDeclinedCancelledAppointments: [],
    sortConfig: {
      upcoming: { key: 'CreatedAt', direction: 'desc' },
      declined: { key: 'CreatedAt', direction: 'desc' },
      passed: { key: 'CreatedAt', direction: 'desc' }
    }
  };
},
computed: {
  fullName() {
    return `${this.firstName} ${this.lastName}`;
  },
  uniqueDentists() {
    const allAppointments = [
      ...this.upcomingAppointments,
      ...this.passedAppointments,
      ...this.declinedCancelledAppointments
    ];
    return [...new Set(allAppointments.map(app => app.DentistName).filter(Boolean))];
  },
  filteredUpcomingAppointments() {
    return this.applyAllFilters(this.upcomingAppointments);
  },
  filteredPassedAppointments() {
    return this.applyAllFilters(this.passedAppointments);
  },
  filteredDeclinedCancelledAppointments() {
    return this.applyAllFilters(this.declinedCancelledAppointments);
  },
},
mounted() {
  this.fetchAppointments();
  this.setupSidebar();
  document.addEventListener('click', this.handleClickOutside);
},
beforeDestroy() {
  document.removeEventListener('click', this.handleClickOutside);
},
methods: {
  async fetchPatientData() {
    try {
      const response = await axios.get('/api/patient-data');
      if (response.data.success) {
        this.profilePicture = response.data.patient.profilePicture;
        console.log('Fetched Profile Picture:', this.profilePicture);
      } else {
        console.error('Failed to fetch patient data:', response.data.message);
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Failed to fetch patient data. Please try again.',
          showConfirmButton: false,
          timer: 1500,
          customClass: {
            popup: 'sweetalert-theme',
            title: 'sweetalert-title',
            content: 'sweetalert-content',
          },
        });
      }
    } catch (error) {
      console.error('Error fetching patient data:', error);
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Error fetching patient data. Please try again.',
        showConfirmButton: false,
        timer: 1500,
        customClass: {
          popup: 'sweetalert-theme',
          title: 'sweetalert-title',
          content: 'sweetalert-content',
        },
      });
    }
  },
  async confirmLogout() {
    const result = await Swal.fire({
      title: 'Are you sure?',
      text: 'Do you really want to log out?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#06693A',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, log out',
      cancelButtonText: 'Cancel'
    });

    if (result.isConfirmed) {
      window.location.href = '/logout';
    }
  },
  closeMobileSidebar() {
    const sidebar = document.querySelector(".sidebar");
    const overlay = document.querySelector(".mobile-overlay");
    if (window.innerWidth <= 768) {
      sidebar.classList.add("close");
      overlay.classList.remove("active");
    }
  },
  setupSidebar() {
    const arrows = document.querySelectorAll(".arrow");
    arrows.forEach((arrow) => {
      arrow.addEventListener("click", (e) => {
        const arrowParent = e.target.closest("li");
        if (arrowParent) {
          arrowParent.classList.toggle("showMenu");
        }
      });
    });

    let sidebar = document.querySelector(".sidebar");
    let sidebarBtn = document.querySelector(".bx-menu");
    sidebarBtn.addEventListener("click", () => {
      sidebar.classList.toggle("close");
      // Handle mobile overlay
      const overlay = document.querySelector(".mobile-overlay");
      if (window.innerWidth <= 768) {
        overlay.classList.toggle("active");
      }
    });
  },
  async fetchAppointments() {
    try {
      const response = await axios.get('/patientappointments');
      const sortByCreatedAt = (a, b) => new Date(b.CreatedAt) - new Date(a.CreatedAt);
      
      this.upcomingAppointments = (response.data.upcoming || []).sort(sortByCreatedAt);
      this.passedAppointments = (response.data.passed || []).sort(sortByCreatedAt);
      this.declinedCancelledAppointments = (response.data.declined_cancelled || []).sort(sortByCreatedAt);

      this.displayedUpcomingAppointments = [...this.upcomingAppointments];
      this.displayedPassedAppointments = [...this.passedAppointments];
      this.displayedDeclinedCancelledAppointments = [...this.declinedCancelledAppointments];
      
      this.applySorting();
    } catch (error) {
      console.error("Error fetching appointments:", error.message);
      this.upcomingAppointments = [];
      this.passedAppointments = [];
      this.declinedCancelledAppointments = [];
      this.displayedUpcomingAppointments = [];
      this.displayedPassedAppointments = [];
      this.displayedDeclinedCancelledAppointments = [];
    }
  },
  matchesSearch(appointment) {
    const query = this.searchQuery.toLowerCase();
    // Enhanced to better search by date
    const appointmentDate = appointment.AppointmentDate ? appointment.AppointmentDate.toLowerCase() : '';
    
    return (
      appointmentDate.includes(query) ||
      (appointment.AppointmentTime || '').toLowerCase().includes(query) ||
      (appointment.AppointmentStatus || '').toLowerCase().includes(query) ||
      (appointment.ServiceStatus || '').toLowerCase().includes(query) ||
      (appointment.Services || []).some(service => service.toLowerCase().includes(query)) ||
      (appointment.PatientNote || '').toLowerCase().includes(query) ||
      (appointment.DentistName || '').toLowerCase().includes(query)
    );
  },
  applyAllFilters(appointments) {
    let filtered = [...appointments];
    
    if (this.searchQuery && this.isSearchActive) {
      filtered = filtered.filter(app => this.matchesSearch(app));
    }

    if (this.filter.startDate || this.filter.endDate) {
      filtered = filtered.filter(app => {
        const appDate = new Date(app.AppointmentDate);
        const start = this.filter.startDate ? new Date(this.filter.startDate) : null;
        const end = this.filter.endDate ? new Date(this.filter.endDate) : null;
        return (!start || appDate >= start) && (!end || appDate <= end);
      });
    }

    if (this.filter.dentist) {
      filtered = filtered.filter(app => app.DentistName === this.filter.dentist);
    }

    return filtered;
  },
  toggleFilterMenu() {
    this.showFilterMenu = !this.showFilterMenu;
  },
  handleClickOutside(event) {
    const filterContainer = this.$el.querySelector('.buttons');
    if (filterContainer && !filterContainer.contains(event.target)) {
      this.showFilterMenu = false;
    }
  },
  resetFilters() {
    this.filter = { startDate: '', endDate: '', dentist: '' };
    this.showFilterMenu = false;
    this.updateDisplayedAppointments();
  },
  applyFilters() {
    this.updateDisplayedAppointments();
    this.showFilterMenu = false;
  },
  resetSearch() {
    this.searchQuery = '';
    this.isSearchActive = false;
    this.updateDisplayedAppointments();
  },
  filterAppointments() {
    if (!this.searchQuery.trim()) {
      this.isSearchActive = false;
    } else {
      this.isSearchActive = true;
    }
    this.updateDisplayedAppointments();
  },
  updateDisplayedAppointments() {
    this.displayedUpcomingAppointments = this.applyAllFilters(this.upcomingAppointments);
    this.displayedPassedAppointments = this.applyAllFilters(this.passedAppointments);
    this.displayedDeclinedCancelledAppointments = this.applyAllFilters(this.declinedCancelledAppointments);
    this.applySorting();
  },
  formatDateAndTime(date, time) {
    if (!date || !time) return 'N/A';
    const d = new Date(date);
    const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    const shortDate = `${monthNames[d.getMonth()]} ${d.getDate()}, ${d.getFullYear()}`;
    
    const [hours, minutes] = time.split(':');
    const h = parseInt(hours, 10);
    const period = h >= 12 ? 'P.M.' : 'A.M.';
    const adjustedHour = h % 12 || 12;
    const formattedTime = `${adjustedHour}:${minutes} ${period}`;
    
    return `${shortDate} at ${formattedTime}`;
  },
  formatFullDateAndTime(date, time) {
    if (!date || !time) return 'N/A';
    const d = new Date(date);
    const monthNames = [
      'January', 'February', 'March', 'April', 'May', 'June',
      'July', 'August', 'September', 'October', 'November', 'December'
    ];
    const fullDate = `${monthNames[d.getMonth()]} ${d.getDate()}, ${d.getFullYear()}`;
    
    const [hours, minutes] = time.split(':');
    const h = parseInt(hours, 10);
    const period = h >= 12 ? 'P.M.' : 'A.M.';
    const adjustedHour = h % 12 || 12;
    const formattedTime = `${adjustedHour}:${minutes} ${period}`;
    
    return `${fullDate} at ${formattedTime}`;
  },
  openAppointmentModal(appointment) {
    this.selectedAppointment = { ...appointment };
    this.showModal = true;
  },
  closeModal() {
    this.showModal = false;
    this.selectedAppointment = null;
    this.isCancelling = false;
  },
  sortTable(key, tabType) {
    if (this.sortConfig[tabType].key === key) {
      this.sortConfig[tabType].direction = this.sortConfig[tabType].direction === 'asc' ? 'desc' : 'asc';
    } else {
      this.sortConfig[tabType].key = key;
      this.sortConfig[tabType].direction = 'asc';
    }
    this.applySorting();
  },
  applySorting() {
    const sortAppointments = (appointments, tabType) => {
      const { key, direction } = this.sortConfig[tabType];
      if (!key) return appointments;
      
      return [...appointments].sort((a, b) => {
        let valueA = a[key];
        let valueB = b[key];
        
        if (Array.isArray(valueA)) valueA = valueA.join(', ');
        if (Array.isArray(valueB)) valueB = valueB.join(', ');
        
        valueA = valueA || '';
        valueB = valueB || '';
        
        if (key === 'AppointmentDate' || key === 'CreatedAt') {
          valueA = new Date(valueA);
          valueB = new Date(valueB);
          return direction === 'asc' ? valueA - valueB : valueB - valueA;
        }
        
        if (typeof valueA === 'string' && typeof valueB === 'string') {
          return direction === 'asc' ? valueA.localeCompare(valueB) : valueB.localeCompare(valueA);
        }
        
        return direction === 'asc' ? (valueA > valueB ? 1 : -1) : (valueA < valueB ? 1 : -1);
      });
    };
    
    this.displayedUpcomingAppointments = sortAppointments(this.displayedUpcomingAppointments, 'upcoming');
    this.displayedPassedAppointments = sortAppointments(this.displayedPassedAppointments, 'passed');
    this.displayedDeclinedCancelledAppointments = sortAppointments(this.displayedDeclinedCancelledAppointments, 'declined');
  },
  cancelAppointment() {
    if (this.selectedAppointment.AppointmentStatus !== 'Pending') {
      alert('You can only cancel appointments that are in "Pending" status.');
      return;
    }
    this.showCancelConfirmModal = true; // Show confirmation modal
  },
  async confirmCancelAppointment() {
    this.isCancelling = true;
    this.showCancelConfirmModal = false;

    try {
      const response = await axios.post(`/patient/appointments/${this.selectedAppointment.AppointmentID}/cancel`);
      
      Swal.fire({
        icon: 'success',
        title: 'Success',
        text: 'Appointment cancelled successfully!',
        showConfirmButton: false,
        timer: 1500,
        customClass: {
          popup: 'sweetalert-theme',
          title: 'sweetalert-title',
          content: 'sweetalert-content',
        },
      });
      
      const updateAppointmentList = (list) => {
        const index = list.findIndex(app => app.AppointmentID === this.selectedAppointment.AppointmentID);
        if (index !== -1) {
          const [appointment] = list.splice(index, 1);
          appointment.AppointmentStatus = 'Cancelled';
          this.declinedCancelledAppointments.push(appointment);
          this.declinedCancelledAppointments.sort((a, b) => new Date(b.CreatedAt) - new Date(a.CreatedAt));
        }
      };
      
      updateAppointmentList(this.upcomingAppointments);
      updateAppointmentList(this.passedAppointments);
      this.updateDisplayedAppointments();
      this.closeModal();
    } catch (error) {
      console.error('Error cancelling appointment:', error.response?.data || error.message);
      alert('Failed to cancel appointment: ' + (error.response?.data?.message || error.message));
    } finally {
      this.isCancelling = false;
    }
  },
  getSortIconClass(key, tabType) {
    if (this.sortConfig[tabType].key === key) {
      return this.sortConfig[tabType].direction === 'asc' ? 'bx-caret-up' : 'bx-caret-down';
    }
    return '';
  },
  getStatusClass(status) {
    if (!status) return 'status-default';
    
    const statusLower = status.toLowerCase();
    
    if (statusLower.includes('decline')) return 'status-declined';
    if (statusLower.includes('cancel')) return 'status-cancelled';
    if (statusLower.includes('pending')) return 'status-pending';
    if (statusLower.includes('confirm')) return 'status-confirmed';
    if (statusLower.includes('complete')) return 'status-completed';
    
    return 'status-default';
  }
},
};
</script>

<style scoped>
@import url('https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css');
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

* {
margin: 0;
padding: 0;
box-sizing: border-box;
font-family: 'Poppins', sans-serif;
}

/* Sidebar and Layout Styles */
.logo-details .logo {
max-width: 10px;
min-width: 70px;
text-align: center;
line-height: 50px;
margin-left: 3px;
}

.logo_name img {
width: 80%;
margin-top: 25px;
margin-left: 10px;
}

.text {
color: black;
margin: -6px 0 0 0;
}

hr {
width: 97%;
margin-left: 20px;
margin-top: 10px;
}

.breadcrumbs .current {
text-decoration: none;
color: #000000;
font-size: 10pt;
font-weight: 100;
}

.breadcrumbs .none {
text-decoration: none;
color: #D9D9D9;
font-size: 10pt;
font-weight: 100;
}

.breadcrumbs {
display: flex;
}

.header {
width: 95%;
display: flex;
}

/* Mobile Overlay */
.mobile-overlay {
position: fixed;
top: 0;
left: 0;
width: 100%;
height: 100%;
background-color: rgba(0, 0, 0, 0.5);
z-index: 99;
opacity: 0;
visibility: hidden;
transition: all 0.3s ease;
}

.mobile-overlay.active {
opacity: 1;
visibility: visible;
}

.sidebar {
position: fixed;
top: 0;
left: 0;
height: 100%;
width: 290px;
background: #FFFFFF;
z-index: 100;
transition: all 0.5s ease;
box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.sidebar.close {
width: 78px;
}

.sidebar .logo-details {
height: 60px;
width: 100%;
display: flex;
align-items: center;
line-height: 50px;
margin-top: 20px;
}

.sidebar .logo-details .logo_name {
font-size: 22px;
color: white;
font-weight: 600;
transition: 0.3s ease;
transition-delay: 0.1s;
}

.sidebar.close .logo-details .logo_name {
transition-delay: 0s;
opacity: 0;
pointer-events: none;
}

.sidebar .nav-link {
height: 100%;
padding: 70px 0 150px 0;
overflow: auto;
}

.sidebar.close .nav-link {
overflow: visible;
}

.sidebar .nav-link::-webkit-scrollbar {
display: none;
}

.sidebar .nav-link li {
position: relative;
list-style: none;
transition: all 0.4s ease;
}

.sidebar .nav-link li:hover {
background: #FFFFFF;
}

.sidebar .nav-link li .icon-link {
display: flex;
align-items: center;
justify-content: space-between;
}

.sidebar.close .nav-link li .icon-link {
display: block;
}

.sidebar .nav-link li i {
height: 50px;
min-width: 78px;
text-align: center;
line-height: 50px;
color: #06693A;
font-size: 20px;
transform: all 0.3s ease;
cursor: pointer;
}

.sidebar .nav-link li.showMenu i.arrow {
transform: rotate(-180deg);
}

.sidebar.close .nav-link i.arrow {
display: none;
}

.sidebar .nav-link li a {
display: flex;
align-items: center;
text-decoration: none;
}

.sidebar .nav-link li a .link_name {
font-size: 16px;
font-weight: 400;
color: #06693A;
}

.sidebar.close .nav-link li a .link_name {
opacity: 0;
pointer-events: none;
}

.sidebar .nav-link li .sub-menu {
padding: 6px 6px 14px 80px;
margin-top: 10px;
background: #FFFFFF;
display: none;
}

.sidebar .nav-link li.showMenu .sub-menu {
display: block;
}

.sidebar .nav-link li .sub-menu a {
color: #06693A;
font-size: 16px;
padding: 5px 0;
white-space: nowrap;
opacity: 0.6;
transition: all 0.3s ease;
}

.sidebar .nav-link li .sub-menu a:hover {
opacity: 1;
}

.sidebar.close .nav-link li .sub-menu {
position: absolute;
left: 100%;
top: -10px;
margin-top: 0;
padding: 10px 20px;
border-radius: 0 6px 6px 0;
opacity: 0;
display: block;
pointer-events: none;
transition: 0s;
}

.sidebar.close .nav-link li:hover .sub-menu {
top: 0px;
opacity: 1;
pointer-events: auto;
transition: all 0.4s ease;
}

.sidebar .nav-link li .sub-menu .link_name {
display: none;
}

.sidebar.close .nav-link li .sub-menu .link_name {
font-size: 18px;
opacity: 1;
display: block;
}

.sidebar .nav-link li .sub-menu.blank {
opacity: 1;
pointer-events: auto;
padding: 3px 20px 6px 16px;
opacity: 0;
pointer-events: none;
}

.sidebar .nav-link li:hover .sub-menu.blank {
top: 50%;
transform: translateY(-50%);
}

.sidebar .profile-details {
position: fixed;
bottom: 0;
width: 290px;
display: flex;
align-items: center;
justify-content: space-between;
background-color: #FFFFFF;
padding: 6px 0;
transition: all 0.5s ease;
cursor: pointer;
}

.sidebar.close .profile-details {
background: none;
width: 78px;
}

.sidebar .profile-details .profile-content {
display: flex;
align-items: center;
}

.sidebar .profile-details img {
height: 52px;
width: 52px;
object-fit: cover;
border-radius: 16px;
margin: 0 14px 0 12px;
background: #FFFFFF;
transition: all 0.5s ease;
}

.sidebar.close .profile-details img {
padding: 10px;
}

.sidebar .profile-details .profile_name,
.sidebar .profile-details .job {
color: #06693A;
font-size: 18px;
font-weight: 500;
white-space: nowrap;
}

.sidebar .profile-details .profile_name {
color: #06693A;
font-size: 16px;
font-weight: 500;
white-space: nowrap;
overflow: hidden;
text-overflow: ellipsis; 
}

.sidebar.close .profile-details i,
.sidebar.close .profile-details .profile_name,
.sidebar.close .profile-details .job {
display: none;
}

.sidebar .profile-details .job {
font-size: 12px;
}

.home-section {
position: relative;
background: #f2f2f2;
min-height: 100vh;
left: 290px;
width: calc(100% - 290px);
transition: all 0.5s ease;
}

.sidebar.close ~ .home-section {
left: 78px;
width: calc(100% - 78px);
}

.home-section .home-content {
margin-top: 35px;
height: 60px;
align-items: center;
}

.home-section .home-content .bx-menu,
.home-section .home-content .text {
color: #06693A;
font-size: 35px;
}

.home-section .home-content .bx-menu {
margin: 0 15px;
cursor: pointer;
}

.home-section .home-content .text {
font-size: 26px;
font-weight: 600;
}

.sidebar .profile-details .name-job {
display: flex;
flex-direction: column;
overflow: hidden;
flex-grow: 1;
margin-right: 10px;
}

/* Search and Filter */
.search-wrapper {
width: 97%;
margin-left: 20px;
display: flex;
align-items: center;
justify-content: space-between;
margin-top: 20px;
}

.search-container {
position: relative;
flex-grow: 1;
margin-right: 15px;
}

.search-input {
width: 100%;
padding: 12px 40px 12px 15px;
border: none;
border-radius: 8px;
background-color: white;
font-size: 15px;
outline: none;
box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
transition: box-shadow 0.3s;
}

.search-input.has-reset {
padding-right: 80px;
}

.search-input:focus {
box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.search-icon {
position: absolute;
right: 15px;
top: 50%;
transform: translateY(-50%);
font-size: 18px;
color: #06693A;
cursor: pointer;
}

.reset-button {
position: absolute;
right: 45px;
top: 50%;
transform: translateY(-50%);
width: 28px;
height: 28px;
border-radius: 50%;
background-color: rgba(6, 105, 58, 0.1);
border: none;
display: flex;
align-items: center;
justify-content: center;
cursor: pointer;
color: #06693A;
transition: all 0.2s ease;
z-index: 2;
}

.reset-button:hover {
background-color: rgba(6, 105, 58, 0.2);
}

.reset-button i {
font-size: 18px;
}

.buttons {
position: relative;
}

.filter {
display: flex;
align-items: center;
gap: 5px;
background-color: white;
color: #333;
border: none;
padding: 12px 20px;
border-radius: 8px;
cursor: pointer;
font-size: 14px;
font-weight: 500;
transition: background-color 0.2s;
box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
}

.filter:hover {
background-color: #f5f5f5;
}

.filter i {
color: #06693A;
font-size: 16px;
}

.filter-menu {
position: absolute;
top: 45px;
right: 0;
background: white;
border-radius: 8px;
box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
z-index: 10;
width: 250px;
padding: 15px;
}

.filter-group {
margin-bottom: 15px;
}

.filter-group label {
display: block;
font-weight: 600;
color: #06693a;
margin-bottom: 5px;
}

.filter-group input,
.filter-group select {
width: 100%;
padding: 8px;
border: 1px solid #e0e0e0;
border-radius: 4px;
font-size: 14px;
}

.filter-group input[type="date"] {
margin-bottom: 10px;
}

.filter-actions {
display: flex;
gap: 8px;
}

.apply-btn {
flex: 1;
background-color: #06693a;
color: white;
padding: 8px;
border: none;
border-radius: 4px;
cursor: pointer;
font-size: 11pt;
text-align: center;
}

.apply-btn:hover {
background-color: #055a32;
}

.reset-btn {
flex: 1;
background-color: #666;
color: white;
padding: 8px;
border: none;
border-radius: 4px;
cursor: pointer;
font-size: 11pt;
text-align: center;
}

.reset-btn:hover {
background-color: #555;
}

/* Toggle Buttons */
.toggle-buttons {
display: flex;
gap: 15px;
margin: 20px;
justify-content: center;
}

.toggle-btn {
padding: 10px 20px;
background-color: white;
border: 1px solid #e0e0e0;
border-radius: 8px;
cursor: pointer;
font-size: 14px;
font-weight: 500;
display: flex;
align-items: center;
gap: 8px;
transition: all 0.3s ease;
color: #555;
}

.toggle-btn i {
color: #06693A;
font-size: 16px;
}

.toggle-btn.active {
background-color: #06693A;
color: white;
border-color: #06693A;
}

.toggle-btn.active i {
color: white;
}

.toggle-btn:hover:not(.active) {
background-color: #f5f5f5;
}

/* Appointment Container */
.appointment-container {
margin: 20px;
background-color: white;
border-radius: 12px;
box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
overflow: hidden;
}

.appointment {
padding: 20px 25px 0;
border-bottom: 1px solid #f0f0f0;
}

.appointment h3 {
font-size: 18px;
color: #333;
font-weight: 600;
margin: 0;
padding-bottom: 15px;
}

.table-wrapper {
padding: 0;
}

.appointment-table {
width: 100%;
border-collapse: collapse;
background-color: white;
table-layout: fixed;
}

.appointment-table th,
.appointment-table td {
padding: 16px;
text-align: left;
border-bottom: 1px solid #f5f5f5;
color: #333;
font-size: 14px;
}

.appointment-table th {
color: #06693A;
font-weight: 600;
font-size: 14px;
background-color: #f9f9f9;
}

.sortable-header {
cursor: pointer;
position: relative;
user-select: none;
padding-right: 25px !important;
}

.sortable-header i {
position: absolute;
right: 10px;
top: 50%;
transform: translateY(-50%);
font-size: 14px;
}

.truncate-cell {
white-space: nowrap;
overflow: hidden;
text-overflow: ellipsis;
}

.appointment-row {
cursor: pointer;
transition: background-color 0.2s;
}

.appointment-row:hover {
background-color: #f9f9f9;
}

.appointment-table tr:last-child td {
border-bottom: none;
}

.no-data {
text-align: center;
color: #757575;
padding: 30px !important;
}

/* Action Column */
.action-header {
width: 10%; /* Reduced width for action column */
text-align: center;
}

.action-cell {
text-align: center;
vertical-align: middle;
}

.view-details-btn {
background-color: rgba(6, 105, 58, 0.1);
color: #06693A;
border: none;
width: 36px;
height: 36px;
border-radius: 50%;
align-items: center;
justify-content: center;
cursor: pointer;
transition: all 0.2s ease;
}

.view-details-btn i {
margin-top: 5px;
font-size: 22px; 
}

/* Mobile Cards */
.mobile-cards {
display: none;
padding: 15px;
}

.appointment-card {
background-color: white;
border-radius: 12px;
border: 1px solid #e0e0e0;
margin-bottom: 16px;
overflow: hidden;
cursor: pointer;
transition: transform 0.2s, box-shadow 0.2s;
}

.appointment-card:hover {
transform: translateY(-2px);
box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.card-header {
display: flex;
justify-content: space-between;
align-items: center;
padding: 16px;
border-bottom: 1px solid #f0f0f0;
background-color: #f9f9f9;
}

.card-header h4 {
margin: 0;
font-size: 16px;
font-weight: 600;
color: #333;
flex: 1;
}

.card-content {
padding: 16px;
}

.card-row {
margin-bottom: 12px;
display: flex;
flex-direction: column;
}

.card-label {
font-weight: 600;
color: #06693A;
font-size: 14px;
margin-bottom: 4px;
}

.card-notes {
word-break: break-word;
}

.no-data-mobile {
text-align: center;
color: #757575;
padding: 30px;
background-color: white;
border-radius: 12px;
border: 1px solid #e0e0e0;
min-height: 200px;
display: flex;
align-items: center;
justify-content: center;
}

/* Modal Styles */
.modal-overlay {
position: fixed;
top: 0;
left: 0;
width: 100%;
height: 100%;
background: rgba(0, 0, 0, 0.5);
display: flex;
justify-content: center;
align-items: center;
z-index: 1000;
}

.modal {
background: white;
border-radius: 8px;
width: 700px;
max-width: 100%;
box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
display: flex;
flex-direction: column;
}

.modal-header {
display: flex;
justify-content: space-between;
align-items: center;
padding: 15px 20px;
border-bottom: 1px solid #e0e0e0;
}

.modal-header h3 {
margin: 0;
font-size: 15pt;
color: #06693a;
}

.close-icon {
background: none;
border: none;
font-size: 1.5em;
cursor: pointer;
color: #666;
text-align: right;
}

.modal-body {
padding: 20px;
max-height: none;
overflow-y: visible;
}

.appointment-info .info-group {
display: flex;
align-items: center;
margin-bottom: 15px;
}

.appointment-info .info-group i {
font-size: 1.2em;
color: #06693a;
margin-right: 10px;
}

.appointment-info .info-group label {
font-weight: bold;
margin-right: 5px;
}

.appointment-info .info-group span {
color: #333;
}

.modal-footer {
display: flex;
justify-content: flex-end;
padding: 15px 20px;
border-top: 1px solid #e0e0e0;
gap: 10px;
}

.cancel-btn, .close-btn {
padding: 8px 16px;
border: none;
border-radius: 4px;
cursor: pointer;
font-size: 14px;
transition: background-color 0.2s;
}

.cancel-btn {
background-color: #dc3545;
color: white;
}

.cancel-btn:disabled {
background-color: #cccccc;
cursor: not-allowed;
}

.close-btn {
background-color: #666;
color: white;
}

/* Confirmation Modal Styles */
.confirm-modal-container {
background: #fff;
border-radius: 8px;
width: 400px;
max-width: 90%;
box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
overflow: hidden;
}

.confirm-modal-header {
display: flex;
justify-content: space-between;
align-items: center;
padding: 15px 20px;
border-bottom: 1px solid #e0e0e0;
}

.confirm-modal-header h3 {
margin: 0;
font-size: 18px;
font-weight: 600;
color: #dc3545;
}

.confirm-modal-header .close-btn {
background: none;
border: none;
font-size: 20px;
cursor: pointer;
color: #666;
}

.confirm-modal-body {
padding: 20px;
text-align: center;
}

.confirm-modal-body p {
margin: 0;
font-size: 16px;
color: #333;
}

.confirm-modal-footer {
display: flex;
justify-content: flex-end;
padding: 15px 20px;
border-top: 1px solid #e0e0e0;
gap: 10px;
}

.confirm-cancel-btn {
background: #e0e0e0;
color: #333;
border: none;
padding: 8px 16px;
border-radius: 4px;
cursor: pointer;
font-size: 14px;
transition: background 0.3s;
}

.confirm-cancel-btn:hover {
background: #d0d0d0;
}

.confirm-save-btn {
background: #dc3545;
color: #fff;
border: none;
padding: 8px 16px;
border-radius: 4px;
cursor: pointer;
font-size: 14px;
transition: background 0.3s;
}

.confirm-save-btn:hover {
background: #dc3545;
}

/* SweetAlert2 Custom Styles */
.sweetalert-theme {
font-family: 'Poppins', sans-serif !important;
border-radius: 8px !important;
box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2) !important;
background: #FFFFFF !important;
color: #333 !important;
}

.sweetalert-title {
color: #06693A !important;
font-size: 22px !important;
font-weight: 600 !important;
margin-bottom: 10px !important;
}

.sweetalert-content {
font-size: 16px !important;
color: #555 !important;
}

.swal2-success .swal2-success-ring {
border-color: rgba(6, 105, 58, 0.3) !important;
}

.swal2-success [class^='swal2-success-line'] {
background-color: #06693A !important;
}

/* Status Colors - UPDATED TO COMPLEMENT GREEN THEME */
.status-badge {
display: inline-block;
padding: 6px 12px;
border-radius: 20px;
font-size: 12px;
font-weight: 600;
text-transform: uppercase;
letter-spacing: 0.5px;
border: 2px solid transparent;
}

.status-declined {
background: linear-gradient(135deg, #e57373, #d32f2f);
color: white;
border-color: #d32f2f;
box-shadow: 0 2px 8px rgba(229, 115, 115, 0.3);
}

.status-cancelled {
background: linear-gradient(135deg, #ff8a65, #ff5722);
color: white;
border-color: #ff5722;
box-shadow: 0 2px 8px rgba(255, 138, 101, 0.3);
}

.status-pending {
background: linear-gradient(135deg, #fff176, #fbc02d);
color: #333;
border-color: #fbc02d;
box-shadow: 0 2px 8px rgba(255, 241, 118, 0.3);
}

.status-confirmed {
background: linear-gradient(135deg, #81c784, #4caf50);
color: white;
border-color: #4caf50;
box-shadow: 0 2px 8px rgba(129, 199, 132, 0.3);
}

.status-completed {
background: linear-gradient(135deg, #4db6ac, #00695c);
color: white;
border-color: #00695c;
box-shadow: 0 2px 8px rgba(77, 182, 172, 0.3);
}

.status-default {
background: linear-gradient(135deg, #90a4ae, #546e7a);
color: white;
border-color: #546e7a;
box-shadow: 0 2px 8px rgba(144, 164, 174, 0.3);
}

/* Updated styles for improved table layout with equal column widths */
.appointment-table th,
.appointment-table td {
width: 18%; /* Equal width for most columns (18% x 5 = 90%) */
padding: 14px 16px; /* Consistent padding */
}

/* Make the action column smaller */
.action-header,
.action-cell {
width: 10%; /* Smaller width for action column */
}

/* Ensure view button is properly centered */
.view-details-btn {
display: flex;
align-items: center;
justify-content: center;
margin: 0 auto;
}

.view-details-btn i {
margin: 0;
}

/* Improved modal layout to avoid scrolling */
.modal-body {
padding: 20px;
max-height: none; /* Remove max-height to avoid scrolling */
overflow-y: visible; /* Remove scrolling */
}

.appointment-info {
display: grid;
grid-template-columns: 1fr 1fr; /* Two columns layout */
gap: 15px;
}

/* For smaller screens, revert to single column */
@media (max-width: 600px) {
.appointment-info {
  grid-template-columns: 1fr;
}
}

.info-group {
padding: 12px;
background-color: #f9f9f9;
border-radius: 8px;
margin-bottom: 0 !important;
display: flex;
align-items: flex-start;
}

.info-group i {
margin-top: 3px;
}

.info-group div {
display: flex;
flex-direction: column;
gap: 5px;
flex: 1;
}

/* Make sure long content doesn't overflow */
.info-group div span {
word-break: break-word;
}

/* Enhanced table styling for better readability */
.appointment-table {
border-spacing: 0;
box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}

.appointment-table thead tr {
border-bottom: 2px solid #e0e0e0;
}

.appointment-table tbody tr:nth-child(even) {
background-color: #fafafa;
}

.appointment-table th {
padding: 16px;
font-weight: 600;
}

.appointment-table td {
padding: 14px 16px;
}

/* Ensure the appointment header aligns with the table content */
.appointment {
padding: 20px 25px 0; /* Match left padding with the table cells */
text-align: left;
}

/* Ensure table headers are properly aligned with their content */
.appointment-table thead th {
vertical-align: middle;
padding-top: 16px;
padding-bottom: 16px;
}

/* Fix for the view button spacing */
.action-cell {
padding: 8px !important;
}

/* Responsive Design */

/* Large Desktop */
@media (min-width: 1400px) {
.appointment-container {
  margin: 30px;
}

.appointment-card {
  margin-bottom: 20px;
}
}

/* Desktop */
@media (max-width: 1200px) {
.sidebar {
  width: 250px;
}

.sidebar.close {
  width: 78px;
}

.sidebar .profile-details {
  width: 250px;
}

.sidebar.close .profile-details {
  width: 78px;
}

.home-section {
  left: 250px;
  width: calc(100% - 250px);
}

.sidebar.close ~ .home-section {
  left: 78px;
  width: calc(100% - 78px);
}

.appointment-table th,
.appointment-table td {
  padding: 12px 15px;
  font-size: 13px;
}

.toggle-buttons {
  flex-wrap: wrap;
}
}

/* Tablet */
@media (max-width: 992px) {
.search-wrapper {
  flex-direction: column;
  gap: 15px;
  width: 95%;
  margin-left: 15px;
}

.search-container {
  width: 100%;
  margin-right: 0;
}

.buttons {
  align-self: flex-end;
}

.toggle-buttons {
  flex-direction: column;
  gap: 10px;
  margin: 15px;
}

.toggle-btn {
  width: 100%;
  justify-content: center;
}

.appointment-container {
  margin: 15px;
}

.appointment h3 {
  font-size: 16px;
}

.modal {
  width: 95%;
  max-width: 600px;
}

.modal-header {
  padding: 15px 18px;
}

.modal-body {
  padding: 18px;
}
}

/* Mobile */
@media (max-width: 768px) {
.sidebar {
  width: 290px;
  transform: translateX(-100%);
  z-index: 101;
}

.sidebar.close {
  transform: translateX(-100%);
}

.sidebar:not(.close) {
  transform: translateX(0);
}

.home-section {
  left: 0;
  width: 100%;
}

.sidebar.close ~ .home-section {
  left: 0;
  width: 100%;
}

.desktop-table {
  display: none;
}

.mobile-cards {
  display: block;
}

.home-content {
  margin-top: 20px;
}

.header {
  width: 100%;
  padding: 0 10px;
}

.text h3 {
  font-size: 20px;
}

.breadcrumbs {
  font-size: 12px;
}

hr {
  width: 95%;
  margin-left: 10px;
}

.search-wrapper {
  margin: 15px 10px 10px;
  width: calc(100% - 20px);
  flex-direction: column;
  gap: 10px;
}

.search-input {
  height: 42px;
  font-size: 14px;
}

.filter {
  width: 100%;
  justify-content: center;
}

.toggle-buttons {
  flex-direction: row;
  flex-wrap: wrap;
  justify-content: center;
  gap: 8px;
  margin: 15px 10px;
  padding: 0;
}

.toggle-btn {
  flex: 1;
  min-width: 0;
  padding: 10px 8px;
  font-size: 12px;
  text-align: center;
  white-space: nowrap;
}

.toggle-btn i {
  font-size: 14px;
}

.appointment-container {
  margin: 10px;
}

.appointment h3 {
  font-size: 16px;
  padding: 15px 0 10px 0;
}

.appointment-card {
  border-radius: 8px;
  margin-bottom: 12px;
}

.card-header {
  padding: 12px 15px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 10px;
}

.card-header h4 {
  font-size: 15px;
  margin: 0;
  flex: 1;
  word-wrap: break-word;
  overflow-wrap: break-word;
  hyphens: auto;
}

.view-details-btn.mobile {
  flex-shrink: 0;
  width: 32px;
  height: 32px;
  margin: 0;
}

.view-details-btn.mobile i {
  font-size: 18px;
  margin-top: 2px;
}

.card-content {
  padding: 12px 15px;
}

.card-row {
  margin-bottom: 10px;
}

.card-label {
  font-size: 13px;
}

.modal {
  width: 95%;
  max-width: 500px;
  max-height: 85vh;
}

.modal-header {
  padding: 12px 15px;
}

.modal-header h3 {
  font-size: 16px;
}

.modal-body {
  padding: 15px;
  max-height: calc(85vh - 60px);
}

.modal-footer {
  padding: 12px 15px;
  flex-direction: column;
  gap: 8px;
}

.cancel-btn {
  width: 100%;
  justify-content: center;
}

.confirm-modal-container {
  width: 95%;
  max-width: 400px;
}
}

/* Small Mobile */
@media (max-width: 480px) {
.home-section .home-content .bx-menu {
  font-size: 28px;
  margin: 0 10px;
}

.text h3 {
  font-size: 18px;
}

.breadcrumbs {
  font-size: 10px;
}

.search-wrapper {
  margin: 12px 8px 8px;
  width: calc(100% - 16px);
}

.search-input {
  height: 38px;
  font-size: 13px;
  padding: 0 40px 0 12px;
}

.search-icon {
  right: 12px;
  font-size: 16px;
}

.reset-button {
  right: 35px;
  width: 24px;
  height: 24px;
}

.reset-button i {
  font-size: 14px;
}

.filter {
  padding: 8px 15px;
  font-size: 12px;
}

.filter i {
  font-size: 14px;
}

.toggle-buttons {
  flex-direction: column;
  gap: 8px;
  margin: 12px 8px;
}

.toggle-btn {
  width: 100%;
  padding: 12px 16px;
  font-size: 13px;
  justify-content: center;
  min-width: auto;
}

.toggle-btn i {
  font-size: 16px;
}

.appointment-container {
  margin: 8px;
}

.appointment h3 {
  font-size: 14px;
  padding: 12px 0 8px 0;
}

.appointment-card {
  margin-bottom: 10px;
}

.card-header {
  padding: 10px 12px;
  gap: 8px;
}

.card-header h4 {
  font-size: 13px;
  line-height: 1.3;
}

.view-details-btn.mobile {
  width: 28px;
  height: 28px;
}

.view-details-btn.mobile i {
  font-size: 16px;
  margin-top: 1px;
}

.card-content {
  padding: 10px 12px;
}

.card-row {
  margin-bottom: 8px;
}

.card-label {
  font-size: 12px;
}

.no-data-mobile {
  padding: 20px;
  min-height: 150px;
  font-size: 14px;
}

.modal {
  width: 95%;
  border-radius: 10px;
}

.modal-header {
  padding: 10px 12px;
}

.modal-header h3 {
  font-size: 14px;
}

.close-icon {
  font-size: 1.2em;
}

.modal-body {
  padding: 12px;
}

.modal-footer {
  padding: 10px 12px;
}

.confirm-modal-container {
  width: 95%;
  max-width: 350px;
}

.confirm-modal-header {
  padding: 12px 15px;
}

.confirm-modal-header h3 {
  font-size: 16px;
}

.confirm-modal-body {
  padding: 15px;
}

.confirm-modal-body p {
  font-size: 14px;
}

.confirm-modal-footer {
  padding: 12px 15px;
  flex-direction: column;
  gap: 8px;
}

.confirm-cancel-btn,
.confirm-save-btn {
  width: 100%;
  justify-content: center;
}
}

/* Landscape Mobile */
@media (max-height: 500px) and (orientation: landscape) {
.modal {
  max-height: 95vh;
}

.modal-body {
  max-height: calc(95vh - 60px);
  overflow-y: auto;
}

.appointment-card {
  margin-bottom: 8px;
}
}
</style>
