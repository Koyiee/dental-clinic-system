<template>
  <div class="sidebar close">
    <div class="logo-details">
      <img src="@/components/Images/ATDC_logo.png" alt="" class="logo">
      <div class="logo_name"><img class="img2" src="@/components/Images/ATDC_Logo3.png" alt=""></div>
    </div>
    <ul class="nav-link">
      <li>
        <a href="/ownerdashboard">
          <i class="bx bx-grid-alt"></i>
          <span class="link_name">Dashboard</span>
        </a>
        <ul class="sub-menu blank">
            <li>
              <a class="link_name" href="/ownerdashboard">Dashboard</a>
            </li>
        </ul>
      </li>
      <li>
        <div class="icon-link">
          <a href="/ownerappointmentsreport">
            <i class="bx bx-calendar"></i>
            <span class="link_name">Appointments Report</span>
          </a>
          <i class="bx bxs-chevron-down arrow"></i>
        </div>
          <ul class="sub-menu">
            <li><a class="link_name" href="/ownerappointmentsreport">Appointments Report</a></li>
            <li><a href="/ownerappointments">Appointments</a></li>
            <li><a href="/ownercalendarschedule">Calendar Schedule</a></li>
          </ul>
      </li>
      <li>
        <a href="/ownerfinancereports">
          <i class="bx bx-bar-chart"></i>
          <span class="link_name">Finance Report</span>
        </a>
        <ul class="sub-menu blank">
            <li>
              <a class="link_name" href="/ownerfinancereports">Finance Report</a>
            </li>
        </ul>
      </li>
      <li>
        <a href="/ownerpatientbillings">
          <i class="bx bx-receipt"></i>
          <span class="link_name">Patient Billing</span>
        </a>
        <ul class="sub-menu blank">
            <li>
              <a class="link_name" href="/ownerpatientbillings">Patient Billing</a>
            </li>
        </ul>
      </li>
      <li>
        <a href="/ownerpatientlist">
          <i class="bx bx-user"></i>
          <span class="link_name">Patient List</span>
        </a>
        <ul class="sub-menu blank">
            <li>
              <a class="link_name" href="/ownerpatientlist">Patient List</a>
            </li>
        </ul>
      </li>
      <li>
        <a href="/ownerannouncements">
          <i class="bx bx-news"></i>
          <span class="link_name">Announcements</span>
        </a>
        <ul class="sub-menu blank">
            <li>
              <a class="link_name" href="/ownerannouncements">Announcements</a>
            </li>
        </ul>
      </li>
      <li>
        <a href="/ownermanageusers">
          <i class="bx bx-group"></i>
          <span class="link_name">Manage Users</span>
        </a>
        <ul class="sub-menu blank">
            <li>
              <a class="link_name" href="/ownermanageusers">Manage Users</a>
            </li>
        </ul>
      </li>
      <li>
        <a href="/ownermanageservices">
          <i class="bx bx-briefcase-alt-2"></i>
          <span class="link_name">Manage Services</span>
        </a>
        <ul class="sub-menu blank">
            <li>
              <a class="link_name" href="/ownermanageservices">Manage Services</a>
            </li>
        </ul>
      </li>
      <li>
        <a href="/ownerlogintracer">
          <i class="bx bx-user-check"></i>
          <span class="link_name">Login Tracer</span>
        </a>
        <ul class="sub-menu blank">
            <li>
              <a class="link_name" href="/ownerlogintracer">Login Tracer</a>
            </li>
        </ul>
      </li>
      <li>
        <a href="/ownersettings">
          <i class="bx bx-cog"></i>
          <span class="link_name">Settings</span>
        </a>
        <ul class="sub-menu blank">
            <li>
              <a class="link_name" href="/ownersettings">Settings</a>
            </li>
        </ul>
      </li>
      <li>
        <div class="profile-details" @click="confirmLogout">
          <div class="profile-content">
            <img src="@/components/Images/profile_1.jpg" alt="profile">
          </div>
          <div class="name-job">
            <div class="profile_name">{{ fullName }}</div>
            <div class="job">Owner</div>
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
            <a class="current" href="/ownerappointments"><p>Appointments</p></a>
          </div>
        </div>
      </div>
      <hr color="#06693a">

      <!-- Search and Filter Section -->
      <div class="search-wrapper">
        <div class="search-container">
          <input 
            v-model="searchQuery" 
            placeholder="Search by patient, dentist, or procedure" 
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
            <button class="reset-btn" @click="resetFilters">Reset Filters</button>
          </div>
        </div>
      </div>

      <!-- Appointment Container -->
      <div class="appointment-container">
        <div class="appointment">
          <h3>PENDING REQUESTS</h3>
        </div>
        <div class="table-wrapper">
          <!-- Desktop Table -->
          <table class="appointment-table desktop-table">
            <thead>
              <tr>
                <th @click="sortTable('PatientName')" class="sortable-header">Patient's Name <i v-if="sortConfig.key === 'PatientName'" class="bx" :class="getSortIconClass('PatientName')"></i></th>
                <th @click="sortTable('AppointmentDate')" class="sortable-header">Date & Time <i v-if="sortConfig.key === 'AppointmentDate'" class="bx" :class="getSortIconClass('AppointmentDate')"></i></th>
                <th @click="sortTable('DentistName')" class="sortable-header">Dentist <i v-if="sortConfig.key === 'DentistName'" class="bx" :class="getSortIconClass('DentistName')"></i></th>
                <th @click="sortTable('PatientNote')" class="sortable-header">Notes <i v-if="sortConfig.key === 'PatientNote'" class="bx" :class="getSortIconClass('PatientNote')"></i></th>
                <th @click="sortTable('Services')" class="sortable-header">Procedure <i v-if="sortConfig.key === 'Services'" class="bx" :class="getSortIconClass('Services')"></i></th>
                <th class="actions-header">Actions</th>
              </tr>
            </thead>
            <tbody class="container-appointment">
              <tr 
                v-for="appointment in displayedAppointments" 
                :key="appointment.AppointmentID"
                @click="openDetailModal(appointment)"
                class="appointment-row"
              >
                <td class="truncate-cell">{{ appointment.PatientName || 'N/A' }}</td>
                <td class="truncate-cell">{{ formatDateTime(appointment.AppointmentDate, appointment.AppointmentTime) }}</td>
                <td class="truncate-cell">{{ appointment.DentistName || 'N/A' }}</td>
                <td class="truncate-cell">{{ appointment.PatientNote || 'No notes' }}</td>
                <td class="truncate-cell">{{ appointment.Services && appointment.Services.length > 0 ? appointment.Services.join(', ') : 'N/A' }}</td>
                <td class="actions-cell" @click.stop>
                  <button 
                    @click="confirmAppointment(appointment.AppointmentID)" 
                    :disabled="appointment.DentistName === 'Any Dentist'"
                    class="action-button accept-button"
                    :class="{ 'disabled-button': appointment.DentistName === 'Any Dentist' }"
                  >
                    <span class="checkmark">✓</span>
                  </button>
                  <button 
                    @click="declineAppointment(appointment.AppointmentID)" 
                    class="action-button decline-button"
                  >
                    <span class="x-mark">✕</span>
                  </button>
                  <button 
                    v-if="appointment.Status === 'Pending'" 
                    @click.stop="openEditModal(appointment)" 
                    class="edit-button"
                  >
                    <i class='bx bx-edit-alt'></i> Edit
                  </button>
                </td>
              </tr>
              <tr v-if="displayedAppointments.length === 0">
                <td colspan="6" class="no-data">No Matching Appointments Found...</td>
              </tr>
            </tbody>
          </table>

          <!-- Mobile Cards -->
          <div class="mobile-cards">
            <div 
              v-for="appointment in displayedAppointments" 
              :key="appointment.AppointmentID"
              class="appointment-card"
              @click="openDetailModal(appointment)"
            >
              <div class="card-header">
                <h4>{{ appointment.PatientName || 'N/A' }}</h4>
                <div class="card-actions" @click.stop>
                  <button 
                    @click="confirmAppointment(appointment.AppointmentID)" 
                    :disabled="appointment.DentistName === 'Any Dentist'"
                    class="action-button accept-button"
                    :class="{ 'disabled-button': appointment.DentistName === 'Any Dentist' }"
                  >
                    <span class="checkmark">✓</span>
                  </button>
                  <button 
                    @click="declineAppointment(appointment.AppointmentID)" 
                    class="action-button decline-button"
                  >
                    <span class="x-mark">✕</span>
                  </button>
                </div>
              </div>
              <div class="card-content">
                <div class="card-row">
                  <span class="card-label">Date & Time:</span>
                  <span>{{ formatDateTime(appointment.AppointmentDate, appointment.AppointmentTime) }}</span>
                </div>
                <div class="card-row">
                  <span class="card-label">Dentist:</span>
                  <span>{{ appointment.DentistName || 'N/A' }}</span>
                </div>
                <div class="card-row">
                  <span class="card-label">Procedure:</span>
                  <span>{{ appointment.Services && appointment.Services.length > 0 ? appointment.Services.join(', ') : 'N/A' }}</span>
                </div>
                <div class="card-row">
                  <span class="card-label">Notes:</span>
                  <span class="card-notes">{{ appointment.PatientNote || 'No notes' }}</span>
                </div>
              </div>
              <div class="card-footer" v-if="appointment.Status === 'Pending'">
                <button 
                  @click.stop="openEditModal(appointment)" 
                  class="edit-button-mobile"
                >
                  <i class='bx bx-edit-alt'></i> Edit
                </button>
              </div>
            </div>
            <div v-if="displayedAppointments.length === 0" class="no-data-mobile">
              No Matching Appointments Found
            </div>
          </div>
        </div>

        <!-- Detail Modal -->
        <Teleport to="body">
          <div class="modal-overlay" v-if="showDetailModal" @click="closeDetailModal">
            <div class="modal-content" @click.stop>
              <div class="modal-header">
                <h3>Appointment Details</h3>
                <button class="close-btn" @click="closeDetailModal">
                  <i class='bx bx-x'></i>
                </button>
              </div>
              <div class="modal-body" v-if="selectedAppointment">
                <div class="status-banners" :class="getStatusClass(selectedAppointment)">
                  <span class="status-icon">
                    <i class="bx bx-time" v-if="selectedAppointment.Status === 'Pending'"></i>
                    <i class="bx bx-check-circle" v-else-if="selectedAppointment.Status === 'Confirmed'"></i>
                    <i class="bx bx-x-circle" v-else-if="selectedAppointment.Status === 'Declined'"></i>
                    <i class="bx bx-calendar" v-else></i>
                  </span>
                  <span class="status-text">{{ selectedAppointment.Status || 'Pending' }}</span>
                </div>
                <div class="section-header">
                  <i class='bx bx-user-circle'></i>
                  <h4>Patient Information</h4>
                </div>
                <div class="form-section">
                  <div class="form-row">
                    <div class="form-group">
                      <label>Name</label>
                      <input :value="selectedAppointment.PatientName" readonly class="readonly-field" />
                    </div>
                    <div class="form-group" v-if="selectedAppointment.PatientContact">
                      <label>Contact</label>
                      <input :value="selectedAppointment.PatientContact" readonly class="readonly-field" />
                    </div>
                  </div>
                  <div class="form-row" v-if="selectedAppointment.PatientEmail">
                    <div class="form-group">
                      <label>Email</label>
                      <input :value="selectedAppointment.PatientEmail" readonly class="readonly-field" />
                    </div>
                  </div>
                </div>
                <div class="section-header">
                  <i class='bx bx-calendar-check'></i>
                  <h4>Appointment Details</h4>
                </div>
                <div class="form-section">
                  <div class="form-row">
                    <div class="form-group">
                      <label>Date & Time</label>
                      <input :value="formatDateTime(selectedAppointment.AppointmentDate, selectedAppointment.AppointmentTime)" readonly class="readonly-field" />
                    </div>
                    <div class="form-group">
                      <label>Dentist</label>
                      <div v-if="selectedAppointment.DentistName !== 'Any Dentist'">
                        <input :value="selectedAppointment.DentistName" readonly class="readonly-field" />
                      </div>
                      <div v-else class="unassigned-field">
                        <i class="bx bx-user-plus"></i> Unassigned
                      </div>
                    </div>
                  </div>
                </div>
                <div class="section-header">
                  <i class='bx bx-clipboard'></i>
                  <h4>Services</h4>
                </div>
                <div class="form-section">
                  <div class="services-container">
                    <div v-if="selectedAppointment.Services && selectedAppointment.Services.length > 0" class="services-list">
                      <div v-for="(service, index) in selectedAppointment.Services" :key="index" class="service-chip">
                        <i class="bx bx-check-circle"></i>
                        <span>{{ service }}</span>
                      </div>
                    </div>
                    <div v-else class="no-services">No services specified</div>
                  </div>
                </div>
                <div class="section-header">
                  <i class='bx bx-note'></i>
                  <h4>Notes</h4>
                </div>
                <div class="form-section">
                  <div class="notes-container">
                    {{ selectedAppointment.PatientNote || 'No notes available' }}
                  </div>
                </div>
                <div class="section-header">
                  <i class='bx bx-file'></i>
                  <h4>Consent Form</h4>
                </div>
                <div class="form-section">
                  <div class="pdf-container">
                    <div v-if="isLoadingPdf" class="loading-pdf">
                      <i class='bx bx-loader-alt bx-spin'></i> Loading consent form...
                    </div>
                    <div v-else-if="pdfUrl" class="pdf-viewer">
                      <iframe :src="pdfUrl" frameborder="0" class="pdf-iframe"></iframe>
                    </div>
                    <div v-else class="no-pdf">
                      <i class='bx bx-info-circle'></i> No consent form available
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="modal-footer">
                <button 
                  @click="declineAppointment(selectedAppointment.AppointmentID)" 
                  class="cancel-btn"
                >
                  <i class='bx bx-x'></i> Decline
                </button>
                <button 
                  v-if="selectedAppointment && selectedAppointment.Status === 'Pending'" 
                  @click="openEditModalFromDetail()" 
                  class="edit-btn"
                >
                  <i class="bx bx-edit"></i> Edit Dentist
                </button>
                <button 
                  @click="confirmAppointment(selectedAppointment.AppointmentID)" 
                  :disabled="selectedAppointment && selectedAppointment.DentistName === 'Any Dentist'"
                  class="update-btn"
                  :class="{ 'disabled-button': selectedAppointment && selectedAppointment.DentistName === 'Any Dentist' }"
                >
                  <i class='bx bx-check'></i> Accept
                </button>
              </div>
            </div>
          </div>
        </Teleport>

        <!-- Edit Modal -->
        <Teleport to="body">
          <div class="modal-overlay" v-if="isModalOpen" @click="closeModal">
            <div class="modal-content" @click.stop>
              <div class="modal-header">
                <h3>{{ selectedAppointment && selectedAppointment.DentistName !== 'Any Dentist' ? 'Edit Dentist Assignment' : 'Assign Dentist' }}</h3>
                <button class="close-btn" @click="closeModal">
                  <i class='bx bx-x'></i>
                </button>
              </div>
              <div class="modal-body" v-if="selectedAppointment">
                <div class="section-header">
                  <i class='bx bx-user-circle'></i>
                  <h4>Patient Information</h4>
                </div>
                <div class="form-section">
                  <div class="form-row">
                    <div class="form-group">
                      <label>Name</label>
                      <input :value="selectedAppointment.PatientName" readonly class="readonly-field" />
                    </div>
                  </div>
                </div>
                <div class="section-header">
                  <i class='bx bx-calendar-check'></i>
                  <h4>Appointment Details</h4>
                </div>
                <div class="form-section">
                  <div class="form-row">
                    <div class="form-group">
                      <label>Date & Time</label>
                      <input :value="formatDateTime(selectedAppointment.AppointmentDate, selectedAppointment.AppointmentTime)" readonly class="readonly-field" />
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group">
                      <label>Services</label>
                      <input :value="selectedAppointment.Services && selectedAppointment.Services.length > 0 ? selectedAppointment.Services.join(', ') : 'No services specified'" readonly class="readonly-field" />
                    </div>
                  </div>
                </div>
                <div class="section-header">
                  <i class='bx bx-user-pin'></i>
                  <h4>Select Dentist</h4>
                </div>
                <div class="form-section">
                  <div class="form-row">
                    <div class="form-group">
                      <label for="dentistSelect">Assign a dentist to this appointment</label>
                      <div class="select-wrapper">
                        <select id="dentistSelect" v-model="selectedDentist" class="form-select" @change="onDentistChange" required>
                          <option value="" disabled>Choose a dentist</option>
                          <option v-if="filteredDentists.length === 0" disabled>No dentists available</option>
                          <option v-for="dentist in filteredDentists" :key="dentist.UserID" :value="dentist.UserID">
                            {{ dentist.FullName }}
                          </option>
                        </select>
                        <i class="bx bx-chevron-down select-icon"></i>
                      </div>
                      <p class="form-help" v-if="filteredDentists.length === 0">
                        <i class="bx bx-info-circle"></i> No dentists are available for this date.
                      </p>
                      <p class="form-help" v-else>
                        <i class="bx bx-info-circle"></i> Assigning a dentist will allow you to confirm this appointment.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button @click="closeModal" class="cancel-btn">
                  <i class='bx bx-x'></i> Cancel
                </button>
                <button 
                  @click="assignDentist" 
                  class="update-btn"
                  :disabled="!selectedDentist"
                  :class="{ 'disabled-button': !selectedDentist }"
                >
                  <i class='bx bx-check'></i> Assign Dentist
                </button>
              </div>
            </div>
          </div>
        </Teleport>

        <!-- Status Notification Popup for Confirmation -->
        <Teleport to="body">
          <div class="status-notification" v-if="showConfirmNotification">
            <div class="notification-content status-confirmed">
              <i class="bx bx-check-circle"></i>
              <span>The appointment of {{ confirmAppointmentData?.PatientName || 'N/A' }} has been confirmed.</span>
            </div>
          </div>
        </Teleport>

        <!-- Status Notification Popup for Decline -->
        <Teleport to="body">
          <div class="status-notification" v-if="showDeclineNotification">
            <div class="notification-content status-declined">
              <i class="bx bx-x-circle"></i>
              <span>The appointment of {{ declineAppointmentData?.PatientName || 'N/A' }} has been declined.</span>
            </div>
          </div>
        </Teleport>

        <!-- Decline Modal with separated button styling -->
        <Teleport to="body">
            <div class="modal-overlay" v-if="showDeclineModal" @click="closeDeclineModal">
                <div class="decline-modal" @click.stop>
                    <div class="decline-modal-header">
                        <h3>Decline Appointment</h3>
                        <button class="close-btn" @click="closeDeclineModal">
                            <i class='bx bx-x'></i>
                        </button>
                    </div>
                    <div class="decline-modal-body">
                        <div class="patient-info" v-if="appointmentToDecline">
                            <div class="patient-avatar">
                                <i class='bx bx-user-circle'></i>
                            </div>
                            <div class="patient-details">
                                <h4>{{ appointmentToDecline.PatientName || 'Patient' }}</h4>
                                <p>{{ formatDateTime(appointmentToDecline.AppointmentDate, appointmentToDecline.AppointmentTime) }}</p>
                            </div>
                        </div>

                        <div class="form-section">
                            <label for="declineReason">
                                <i class='bx bx-message-square-detail'></i>
                                Reason for Declining
                            </label>
                            <div class="textarea-wrapper">
                                <textarea
                                    id="declineReason"
                                    v-model="declineReason"
                                    placeholder="Please provide a reason for declining this appointment..."
                                    rows="4"
                                    class="decline-textarea"
                                ></textarea>
                            </div>
                            <p class="helper-text">This reason will be sent to the patient.</p>
                        </div>
                    </div>
                    <div class="decline-modal-footer">
                        <button @click="closeDeclineModal" class="modal-cancel-button">
                            <i class='bx bx-x'></i> Cancel
                        </button>
                        <button
                            @click="submitDecline"
                            class="modal-decline-button"
                            :disabled="!declineReason.trim()"
                            :class="{ 'disabled-button': !declineReason.trim() }"
                        >
                            <i class='bx bx-check'></i> Decline Appointment
                        </button>
                    </div>
                </div>
            </div>
        </Teleport>
      </div>
    </div>
  </section>
</template>

<script>
import axios from "axios";
import Swal from 'sweetalert2';

export default {
  name: "OwnerAppointments",
  props: {
    firstName: { type: String, required: true },
    lastName: { type: String, required: true },
  },
  data() {
    return {
      pendingAppointments: [],
      displayedAppointments: [],
      isModalOpen: false,
      showDetailModal: false,
      showConfirmNotification: false,
      selectedAppointment: null,
      confirmAppointmentData: null,
      selectedDentist: null,
      dentists: [],
      unavailableDentists: [],
      searchQuery: '',
      isSearchActive: false,
      showFilterMenu: false,
      filter: { startDate: '', endDate: '', dentist: '' },
      sortConfig: { key: 'CreatedAt', direction: 'desc' },
      tempAppointment: null,
      pdfUrl: null,
      isLoadingPdf: false,
      showDeclineModal: false,
      declineReason: '',
      appointmentToDecline: null,
    };
  },
  computed: {
    fullName() {
      return `${this.firstName} ${this.lastName}`;
    },
    uniqueDentists() {
      return [...new Set(this.pendingAppointments.map(app => app.DentistName).filter(Boolean))];
    },
    filteredDentists() {
      return this.dentists.filter(dentist => 
        !this.unavailableDentists.includes(String(dentist.UserID))
      );
    },
  },
  mounted() {
    this.fetchPendingAppointments();
    this.fetchDentists();
    this.setupSidebar();
    document.addEventListener('click', this.handleClickOutside);
  },
  beforeDestroy() {
    document.removeEventListener('click', this.handleClickOutside);
  },
  methods: {
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
          if (arrowParent) arrowParent.classList.toggle("showMenu");
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
    async fetchPendingAppointments() {
      try {
        const response = await axios.get('/owner/appointments-data');
        this.pendingAppointments = response.data.map(appointment => ({
          ...appointment,
          Services: Array.isArray(appointment.Services) ? appointment.Services : [],
          PatientName: appointment.PatientName || 'N/A',
          DentistName: appointment.DentistName || 'Any Dentist',
          PatientNote: appointment.PatientNote || 'No notes available',
          Status: appointment.Status || 'Pending'
        }));
        this.displayedAppointments = [...this.pendingAppointments];
        this.applySorting();
      } catch (error) {
        console.error("Error fetching pending appointments:", error.response?.status, error.response?.data || error.message);
        await Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Failed to fetch appointments. Please try again later.',
        });
        this.pendingAppointments = [];
        this.displayedAppointments = [];
      }
    },
    updateDisplayedAppointments() {
      this.displayedAppointments = this.applyAllFilters(this.pendingAppointments);
      this.applySorting();
    },
    applySorting() {
      const { key, direction } = this.sortConfig;
      if (!key) return;

      this.displayedAppointments.sort((a, b) => {
        let valueA = a[key];
        let valueB = b[key];

        if (Array.isArray(valueA)) valueA = valueA.join(', ');
        if (Array.isArray(valueB)) valueB = valueB.join(', ');

        valueA = valueA || '';
        valueB = valueB || '';

        if (key === 'CreatedAt' || key === 'AppointmentDate') {
          valueA = new Date(valueA);
          valueB = new Date(valueB);
          return direction === 'asc' ? valueA - valueB : valueB - valueA;
        }

        if (typeof valueA === 'string' && typeof valueB === 'string') {
          return direction === 'asc' ? valueA.localeCompare(valueB) : valueB.localeCompare(valueA);
        }

        return direction === 'asc' ? (valueA > valueB ? 1 : -1) : (valueA < valueB ? 1 : -1);
      });
    },
    sortTable(key) {
      if (this.sortConfig.key === key) {
        this.sortConfig.direction = this.sortConfig.direction === 'asc' ? 'desc' : 'asc';
      } else {
        this.sortConfig.key = key;
        this.sortConfig.direction = 'asc';
      }
      this.applySorting();
    },
    async fetchConsentForm(appointmentId) {
      try {
        const response = await axios.get(`/appointments/${appointmentId}/consent-form`, {
          responseType: 'blob',
          withCredentials: true,
        });
        return response;
      } catch (error) {
        console.error('Error fetching consent form:', error);
        await Swal.fire({
          icon: 'error',
          title: 'Error',
          text: error.response?.status === 403
            ? 'You do not have permission to access this consent form.'
            : 'Failed to fetch the consent form. Please try again later.',
        });
        throw error;
      }
    },
    async fetchDentists() {
      try {
        const response = await axios.get('/dentist-mapping');
        this.dentists = response.data.map(dentist => ({
          UserID: dentist.UserID,
          DentistID: dentist.DentistID,
          FullName: `${dentist.FirstName} ${dentist.LastName}`.trim() || 'Unnamed Dentist',
        }));
      } catch (error) {
        console.error("Error fetching dentists:", error);
        await Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Failed to fetch dentists. Please try again later.',
        });
      }
    },
    async checkDentistAvailability(date, time) {
      try {
        const response = await axios.get(`/dentist-availability/${date}`, {
          params: { time: time }
        });
        const unavailableDentistIDs = response.data.unavailable_dentists || [];
        this.unavailableDentists = this.dentists
          .filter(dentist => unavailableDentistIDs.map(String).includes(String(dentist.DentistID)))
          .map(dentist => String(dentist.UserID));
      } catch (error) {
        console.error("Error checking dentist availability:", error);
        this.unavailableDentists = [];
      }
    },
    matchesSearch(appointment) {
      const query = this.searchQuery.toLowerCase();
      return (
        (appointment.PatientName || '').toLowerCase().includes(query) ||
        (appointment.AppointmentDate || '').toLowerCase().includes(query) ||
        (appointment.AppointmentTime || '').toLowerCase().includes(query) ||
        (appointment.DentistName || '').toLowerCase().includes(query) ||
        (appointment.Services || []).some(service => service.toLowerCase().includes(query)) ||
        (appointment.PatientNote || '').toLowerCase().includes(query)
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
    getSortIconClass(key) {
      if (this.sortConfig.key === key) {
        return this.sortConfig.direction === 'asc' ? 'bx-caret-up' : 'bx-caret-down';
      }
      return '';
    },
    formatDateTime(date, time) {
      if (!date || !time) return 'N/A';
      const dateObj = new Date(`${date} ${time}`);
      return dateObj.toLocaleString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: 'numeric',
        minute: '2-digit',
        hour12: true
      });
    },
    getStatusClass(appointment) {
      const status = appointment.Status?.toLowerCase() || 'pending';
      switch(status) {
        case 'confirmed': return 'status-confirmed';
        case 'declined':
        case 'cancelled': return 'status-declined';
        case 'completed': return 'status-completed';
        default: return 'status-pending';
      }
    },
    async openDetailModal(appointment) {
      this.selectedAppointment = { ...appointment };
      this.tempAppointment = { ...appointment };
      this.showDetailModal = true;
      this.isLoadingPdf = true;
      this.pdfUrl = null;

      try {
        const response = await this.fetchConsentForm(appointment.AppointmentID);
        const blob = new Blob([response.data], { type: 'application/pdf' });
        this.pdfUrl = URL.createObjectURL(blob);
      } catch (error) {
        this.pdfUrl = null;
      } finally {
        this.isLoadingPdf = false;
      }

      document.body.style.overflow = 'hidden';
    },
    closeDetailModal() {
      this.showDetailModal = false;
      if (this.pdfUrl) {
        URL.revokeObjectURL(this.pdfUrl);
        this.pdfUrl = null;
      }
      this.isLoadingPdf = false;
      document.body.style.overflow = 'auto';
      setTimeout(() => {
        if (!this.isModalOpen) {
          this.selectedAppointment = null;
          this.tempAppointment = null;
        }
      }, 300);
    },
    openEditModal(appointment) {
      this.tempAppointment = { ...appointment };
      this.selectedDentist = appointment.UserID || null;
      this.isModalOpen = true;
      this.selectedAppointment = this.tempAppointment;
      this.checkDentistAvailability(appointment.AppointmentDate, appointment.AppointmentTime);
    },
    closeModal() {
      this.isModalOpen = false;
      this.unavailableDentists = [];
      setTimeout(() => {
        if (!this.showDetailModal) {
          this.selectedAppointment = null;
          this.tempAppointment = null;
        } else {
          this.selectedAppointment = this.tempAppointment;
        }
      }, 300);
    },
    openEditModalFromDetail() {
      if (this.selectedAppointment) {
        const appointment = { ...this.selectedAppointment };
        this.closeDetailModal();
        setTimeout(() => {
          this.openEditModal(appointment);
        }, 300);
      }
    },
    async assignDentist() {
      if (!this.selectedAppointment || !this.selectedDentist) {
        await Swal.fire({
          icon: 'warning',
          title: 'No Dentist Selected',
          text: 'Please select a dentist to assign.',
        });
        return;
      }

      const dentistName = this.dentists.find(d => d.UserID == this.selectedDentist)?.FullName || 'the selected dentist';
      const patientName = this.selectedAppointment.PatientName || 'the patient';

      const result = await Swal.fire({
        title: 'Are you sure?',
        text: `Do you want to assign ${dentistName} to ${patientName}'s appointment?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#06693a',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, assign',
        cancelButtonText: 'Cancel'
      });

      if (result.isConfirmed) {
        try {
          await axios.post('/assign-dentist', {
            AppointmentID: this.selectedAppointment.AppointmentID,
            UserID: parseInt(this.selectedDentist),
          });
          await Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Dentist assigned successfully!',
            timer: 2000,
            showConfirmButton: false,
          });
          this.fetchPendingAppointments();
          this.closeModal();
        } catch (error) {
          console.error("Error assigning dentist:", error.response?.data || error);
          await Swal.fire({
            icon: 'error',
            title: 'Error',
            text: `Failed to assign dentist: ${error.response?.data?.message || error.message}`,
          });
        }
      }
    },
    async confirmAppointment(appointmentId) {
      const appointment = this.pendingAppointments.find(app => app.AppointmentID === appointmentId);
      if (appointment.DentistName === 'Any Dentist') {
        await Swal.fire({
          icon: 'warning',
          title: 'Dentist Required',
          text: 'Please assign a dentist before confirming the appointment.',
        });
        return;
      }
      this.confirmAppointmentData = { ...appointment };
      try {
        await axios.put(`/owner/appointments/${appointmentId}`, { status: 'Confirmed' });
        this.showConfirmNotification = true;
        if (this.showDetailModal) {
          this.closeDetailModal();
        }
        setTimeout(() => {
          this.showConfirmNotification = false;
          this.confirmAppointmentData = null;
        }, 3000);
        this.fetchPendingAppointments();
      } catch (error) {
        console.error("Error confirming appointment:", error.response?.data || error);
        await Swal.fire({
          icon: 'error',
          title: 'Error',
          text: `Failed to confirm appointment: ${error.response?.data?.message || error.message}`,
        });
      }
    },
    async declineAppointment(appointmentId) {
      const appointment = this.pendingAppointments.find(app => app.AppointmentID === appointmentId);
      this.appointmentToDecline = appointment;
      this.declineReason = '';
      this.showDeclineModal = true;
      document.body.style.overflow = 'hidden';
    },
    async submitDecline() {
      if (!this.declineReason.trim()) {
        await Swal.fire({
          icon: 'warning',
          title: 'Reason Required',
          text: 'Please provide a reason for declining the appointment.',
        });
        return;
      }
      if (!this.appointmentToDecline) return;

      const patientName = this.appointmentToDecline.PatientName || 'the patient';
      const result = await Swal.fire({
        title: 'Are you sure?',
        text: `Do you want to decline ${patientName}'s appointment?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#06693a',
        confirmButtonText: 'Yes, decline',
        cancelButtonText: 'Cancel'
      });

      if (result.isConfirmed) {
        try {
          await axios.put(`/owner/appointments/${this.appointmentToDecline.AppointmentID}`, {
            status: 'Declined',
            declineReason: this.declineReason,
          });
          await Swal.fire({
            icon: 'success',
            title: 'Appointment Declined',
            text: `The appointment for ${patientName} has been declined.`,
            timer: 2000,
            showConfirmButton: false,
          });
          this.closeDeclineModal();
          if (this.showDetailModal) {
            this.closeDetailModal();
          }
          this.fetchPendingAppointments();
        } catch (error) {
          console.error("Error declining appointment:", error.response?.data || error);
          await Swal.fire({
            icon: 'error',
            title: 'Error',
            text: `Failed to decline appointment: ${error.response?.data?.message || error.message}`,
          });
        }
      }
    },
    closeDeclineModal() {
      this.showDeclineModal = false;
      this.declineReason = '';
      this.appointmentToDecline = null;
      document.body.style.overflow = 'auto';
    },
    openInfoModal(message) {
      Swal.fire({
        icon: 'info',
        title: 'Information',
        text: message,
      });
    }
  },
};
</script>

<style scoped>
@import url('https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css');
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

/* Base styles */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Poppins', sans-serif;
}

/* Sidebar and Layout Styles */
.logo-details .logo {
  max-width: 70px;
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

.sidebar .logo-details i {
  font-size: 30px;
  color: white;
  height: 50px;
  min-width: 78px;
  text-align: center;
  line-height: 50px;
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

.nav-link {
  margin-top: -30px;
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
  overflow: hidden;
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

.sidebar.close .profile-details i,
.sidebar.close .profile-details .profile_name,
.sidebar.close .profile-details .job {
  display: none;
}

.sidebar .profile-details .job {
  font-size: 12px;
  color: #06693A;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  max-width: 100%;
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
  min-width: 0;
}

.sidebar .profile-details .profile_name {
  color: #06693A;
  font-size: 16px;
  font-weight: 500;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  max-width: 100%;
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

.reset-btn {
  width: 100%;
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

/* Appointment Container */
.appointment-container {
  margin: 20px;
  background-color: white;
  border-radius: 12px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
  overflow: hidden;
}

.appointment {
  padding: 20px 12px 0;
  border-bottom: 1px solid #f0f0f0;
}

.appointment h3 {
  font-size: 18px;
  color: #333;
  font-weight: 600;
  margin-left: 10px;
  padding-bottom: 15px;
}

.table-wrapper {
  padding: 0;
}

.appointment-table {
  width: 100%;
  border-collapse: collapse;
  background-color: white;
}

.appointment-table th,
.appointment-table td {
  padding: 12px;
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

.actions-cell {
  display: flex;
  align-items: center;
  gap: 8px;
}

.action-button {
  width: 32px;
  height: 32px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  border: none;
  transition: all 0.2s;
}

.accept-button {
  background-color: #e6f7ee;
}

.accept-button:hover:not(:disabled) {
  background-color: #d1f0e0;
}

.accept-button .checkmark {
  color: #0d904b;
  font-size: 16px;
  font-weight: bold;
}

.decline-button {
  background-color: #ffebee;
}

.decline-button:hover {
  background-color: #ffd8db;
}

.decline-button .x-mark {
  color: #d32f2f;
  font-size: 16px;
  font-weight: bold;
}

.edit-button {
  background-color: #06693A;
  border: none;
  padding: 6px 12px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 14px;
  color: white;
  display: flex;
  align-items: center;
  gap: 5px;
}

.edit-button:hover {
  background-color: #055a32;
}

.edit-button i {
  font-size: 14px;
}

.disabled-button {
  opacity: 0.6;
  cursor: not-allowed;
}

.no-data {
  text-align: center;
  color: #757575;
  padding: 30px !important;
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
}

.card-header h4 {
  margin: 0;
  font-size: 16px;
  font-weight: 600;
  color: #333;
}

.card-actions {
  display: flex;
  gap: 8px;
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
  font-weight: 500;
  color: #666;
  font-size: 14px;
  margin-bottom: 4px;
}

.card-notes {
  word-break: break-word;
}

.card-footer {
  padding: 12px 16px;
  border-top: 1px solid #f5f5f5;
  display: flex;
  justify-content: flex-end;
}

.edit-button-mobile {
  background-color: #06693A;
  border: none;
  padding: 8px 16px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 14px;
  color: white;
  display: flex;
  align-items: center;
  gap: 5px;
}

.edit-button-mobile:hover {
  background-color: #055a32;
}

.edit-button-mobile i {
  font-size: 14px;
}

.no-data-mobile {
  text-align: center;
  color: #757575;
  padding: 30px;
  background-color: white;
  border-radius: 12px;
  border: 1px solid #e0e0e0;
}

/* Modal Styles */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  backdrop-filter: blur(4px);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
  animation: fadeIn 0.2s ease-out;
}

@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

.modal-content {
  background: white;
  width: 90%;
  max-width: 800px;
  border-radius: 12px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
  overflow: hidden;
  animation: slideUp 0.3s ease-out;
}

@keyframes slideUp {
  from { transform: translateY(30px); opacity: 0; }
  to { transform: translateY(0); opacity: 1; }
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px 25px;
  border-bottom: 1px solid #f0f0f0;
  background-color: #fff;
  color: #06693A;
}

.modal-header h3 {
  margin: 0;
  font-size: 22px;
  font-weight: 600;
  word-break: break-word;
}

.close-btn {
  background: none;
  border: none;
  font-size: 24px;
  color: #777;
  cursor: pointer;
  transition: color 0.3s ease;
  flex-shrink: 0;
}

.close-btn:hover {
  color: #333;
}

.close-btn i {
  font-size: 20px;
}

.modal-body {
  padding: 25px;
  max-height: 70vh;
  overflow-y: auto;
}

.status-banners {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 15px;
  border-radius: 8px;
  margin-bottom: 20px;
}

.status-banners.status-confirmed {
  background-color: #e6f7ee;
  color: #0d904b;
}

.status-banners.status-pending {
  background-color: #fff8e6;
  color: #e6a700;
}

.status-banners.status-declined {
  background-color: #ffebee;
  color: #d32f2f;
}

.status-banners.status-completed {
  background-color: #535353;
  color: white;
}

.status-icon i {
  font-size: 20px;
}

.status-text {
  font-weight: 600;
  font-size: 16px;
}

.section-header {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 15px;
  color: #06693A;
}

.section-header i {
  font-size: 22px;
}

.section-header h4 {
  font-size: 18px;
  font-weight: 600;
  margin: 0;
}

.form-section {
  margin-bottom: 30px;
  background-color: #f9f9f9;
  padding: 20px;
  border-radius: 8px;
}

.form-row {
  display: flex;
  gap: 20px;
  margin-bottom: 15px;
}

.form-row:last-child {
  margin-bottom: 0;
}

.form-group {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.form-group label {
  font-weight: 500;
  color: #555;
  font-size: 14px;
}

.form-group input,
.form-group select {
  padding: 10px 12px;
  font-weight: 500;
  color: #555;
  font-size: 14px;
}

.form-group input,
.form-group select {
  padding: 10px 12px;
  border: 1px solid #e0e0e0;
  border-radius: 6px;
  font-size: 14px;
}

.readonly-field {
  background-color: #f5f5f5;
  cursor: not-allowed;
  opacity: 0.8;
}

.unassigned-field {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 10px 12px;
  background-color: #f5f5f5;
  border-radius: 6px;
  font-size: 14px;
  color: #666;
}

.unassigned-field i {
  font-size: 20px;
  color: #06693A;
}

.services-container {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
}

.service-chip {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 6px 12px;
  margin: 5px;
  background-color: #e6f7ee;
  border-radius: 16px;
  font-size: 14px;
  color: #0d904b;
}

.service-chip i {
  font-size: 16px;
}

.no-services {
  color: #666;
  font-style: italic;
}

.notes-container {
  color: #333;
  line-height: 1.5;
  white-space: pre-wrap;
  word-break: break-word;
}

.select-wrapper {
  position: relative;
}

.form-select {
  width: 100%;
  padding: 10px 12px;
  border: 1px solid #e0e0e0;
  border-radius: 6px;
  font-size: 14px;
  appearance: none;
  background-color: white;
}

.select-icon {
  position: absolute;
  right: 12px;
  top: 50%;
  transform: translateY(-50%);
  color: #666;
  pointer-events: none;
}

.form-help {
  margin-top: 8px;
  font-size: 13px;
  color: #666;
  display: flex;
  align-items: center;
  gap: 6px;
}

.form-help i {
  font-size: 16px;
  color: #06693A;
}

.modal-footer {
  display: flex;
  justify-content: flex-end;
  gap: 15px;
  padding: 20px 25px;
  border-top: 1px solid #f0f0f0;
  background-color: #f9f9f9;
}

.cancel-btn, .edit-btn, .update-btn {
  padding: 10px 20px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-size: 14px;
  font-weight: 500;
  display: flex;
  align-items: center;
  gap: 5px;
  transition: background-color 0.2s;
}

.cancel-btn {
  background: #f0f0f0;
  color: #333;
}

.cancel-btn:hover {
  background: #e0e0e0;
}

.edit-btn {
  background: #f5f5f5;
  color: #333;
}

.edit-btn:hover {
  background: #e0e0e0;
}

.update-btn {
  background: #06693a;
  color: white;
}

.update-btn:hover:not(:disabled) {
  background: #055a32;
}

.update-btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

/* Status Notification Styles */
.status-notification {
  position: fixed;
  top: 20px;
  right: 20px;
  z-index: 1001;
  animation: slideIn 0.5s ease-out forwards, slideOut 0.5s ease-out 2.5s forwards;
}

.notification-content {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 15px 20px;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  font-size: 14px;
  font-weight: 500;
}

.notification-content.status-confirmed {
  background-color: #e6f7ee;
  color: #0d904b;
}

.notification-content.status-declined {
  background-color: #ffebee;
  color: #d32f2f;
}

.notification-content i {
  font-size: 20px;
}

@keyframes slideIn {
  from {
    transform: translateX(100%);
    opacity: 0;
  }
  to {
    transform: translateX(0);
    opacity: 1;
  }
}

@keyframes slideOut {
  from {
    transform: translateX(0);
    opacity: 1;
  }
  to {
    transform: translateX(100%);
    opacity: 0;
  }
}

.pdf-container {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.loading-pdf {
  display: flex;
  align-items: center;
  gap: 8px;
  color: #06693A;
  font-size: 14px;
  font-style: italic;
}

.loading-pdf i {
  font-size: 20px;
}

.pdf-viewer {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.pdf-iframe {
  width: 100%;
  height: 400px;
  border: 1px solid #e0e0e0;
  border-radius: 6px;
  background-color: white;
}

.download-btn {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  padding: 8px 16px;
  background-color: #06693A;
  color: white;
  text-decoration: none;
  border-radius: 6px;
  font-size: 14px;
  font-weight: 500;
  transition: background-color 0.2s;
}

.download-btn:hover {
  background-color: #055a32;
}

.download-btn i {
  font-size: 16px;
}

.no-pdf {
  display: flex;
  align-items: center;
  gap: 8px;
  color: #666;
  font-size: 14px;
  font-style: italic;
}

.no-pdf i {
  font-size: 16px;
  color: #06693A;
}

.form-textarea {
  width: 100%;
  padding: 10px 12px;
  border: 1px solid #e0e0e0;
  border-radius: 6px;
  font-size: 14px;
  resize: vertical;
}

.decline-btn {
  padding: 10px 20px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-size: 14px;
  font-weight: 500;
  display: flex;
  align-items: center;
  gap: 5px;
  background: #d32f2f;
  color: white;
  transition: background-color 0.2s;
}

.decline-btn:hover:not(:disabled) {
  background: #b71c1c;
}

.decline-btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

/* Separate styles for the modal buttons */
.modal-cancel-button, .modal-decline-button {
  padding: 12px 20px;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-size: 15px;
  font-weight: 500;
  display: flex;
  align-items: center;
  gap: 8px;
  transition: all 0.2s;
}

.modal-cancel-button {
  background: #f0f0f0;
  color: #333;
}

.modal-cancel-button:hover {
  background: #e0e0e0;
}

.modal-decline-button {
  background: #d32f2f;
  color: white;
}

.modal-decline-button:hover:not(:disabled) {
  background: #b71c1c;
  transform: translateY(-1px);
  box-shadow: 0 4px 8px rgba(211, 47, 47, 0.2);
}

.modal-decline-button:active:not(:disabled) {
  transform: translateY(0);
  box-shadow: none;
}

.modal-decline-button:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

/* Decline Modal Styles */
.decline-modal {
  background: white;
  width: 90%;
  max-width: 800px;
  border-radius: 16px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
  overflow: hidden;
  animation: slideUp 0.3s ease-out;
}

.decline-modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px 25px;
  border-bottom: 1px solid #f0f0f0;
  background-color: #fff;
  color: #06693A;
}

.decline-modal-header h3 {
  margin: 0;
  font-size: 22px;
  font-weight: 600;
}

.decline-modal-body {
  padding: 25px;
}

.patient-info {
  display: flex;
  align-items: center;
  gap: 15px;
  padding: 15px;
  background-color: #f9f9f9;
  border-radius: 12px;
  margin-bottom: 20px;
}

.patient-avatar {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  background-color: #e6f7ee;
  display: flex;
  align-items: center;
  justify-content: center;
}

.patient-avatar i {
  font-size: 28px;
  color: #06693A;
}

.patient-details h4 {
  margin: 0 0 5px 0;
  font-size: 16px;
  font-weight: 600;
  color: #333;
}

.patient-details p {
  margin: 0;
  font-size: 14px;
  color: #666;
}

.textarea-wrapper {
  position: relative;
  border: 2px solid #e0e0e0;
  border-radius: 12px;
  transition: border-color 0.2s;
  overflow: hidden;
}

.textarea-wrapper:focus-within {
  border-color: #06693A;
}

.decline-textarea {
  width: 100%;
  padding: 15px;
  border: none;
  font-size: 15px;
  line-height: 1.5;
  outline: none;
  resize: none;
  font-family: 'Poppins', sans-serif;
}

.helper-text {
  margin-top: 8px;
  font-size: 13px;
  color: #666;
  font-style: italic;
}

.decline-modal-footer {
  display: flex;
  justify-content: flex-end;
  gap: 15px;
  padding: 20px 25px;
  border-top: 1px solid #f0f0f0;
  background-color: #f9f9f9;
}

.appointment-table th:first-child,
.appointment-table td:first-child {
  padding-left: 25px;
}

/* Responsive Design */

/* Large Desktop */
@media (min-width: 1400px) {
  .appointment-container {
    margin: 30px;
  }
  
  .search-wrapper {
    margin-left: 30px;
    width: calc(100% - 60px);
  }
}

/* Desktop */
@media (max-width: 1200px) {
  .appointment-table th,
  .appointment-table td {
    padding: 10px;
    font-size: 13px;
  }
  
  .search-wrapper {
    margin-left: 15px;
    width: calc(100% - 30px);
  }
}

/* Tablet - iPad Air Fix */
@media (max-width: 1024px) {
  .sidebar {
    width: 250px;
  }
  
  .sidebar.close {
    width: 78px;
  }
  
  .sidebar .profile-details {
    width: 250px;
    padding: 6px 8px;
  }
  
  .sidebar.close .profile-details {
    width: 78px;
    padding: 6px 0;
  }
  
  .sidebar .profile-details .profile_name {
    font-size: 14px;
    max-width: 120px;
  }
  
  .sidebar .profile-details .job {
    font-size: 11px;
    max-width: 120px;
  }
  
  .home-section {
    left: 250px;
    width: calc(100% - 250px);
  }
  
  .sidebar.close ~ .home-section {
    left: 78px;
    width: calc(100% - 78px);
  }
  
  .search-wrapper {
    margin-left: 15px;
    width: calc(100% - 30px);
  }
  
  .appointment-container {
    margin: 15px;
  }
  
  .appointment h3 {
    font-size: 16px;
  }
  
  .filter-menu {
    width: 220px;
  }
  
  .modal-content {
    max-width: 700px;
  }
  
  .modal-header {
    padding: 18px 20px;
  }
  
  .modal-body {
    padding: 20px;
  }
  
  .form-row {
    gap: 15px;
  }
  
  /* Ensure Edit button is visible on iPad Air */
  .edit-button {
    display: flex;
    font-size: 13px;
    padding: 5px 10px;
  }
  
  .actions-cell {
    gap: 6px;
  }
  
  .appointment-table th,
  .appointment-table td {
    padding: 8px;
    font-size: 13px;
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
  
  .desktop-table {
    display: none;
  }
  
  .mobile-cards {
    display: block;
  }
  
  .appointment h3 {
    font-size: 16px;
    margin-left: 5px;
  }
  
  .search-wrapper {
    flex-direction: column;
    gap: 15px;
    width: calc(100% - 20px);
    margin-left: 10px;
  }
  
  .search-container {
    width: 100%;
    margin-right: 0;
  }
  
  .search-input {
    height: 42px;
    font-size: 14px;
  }
  
  .buttons {
    align-self: flex-end;
  }
  
  .filter-menu {
    width: 200px;
    right: 0;
  }
  
  .appointment-container {
    margin: 10px;
  }
  
  .modal-content {
    width: 95%;
    max-width: 500px;
    max-height: 85vh;
  }
  
  .modal-header {
    padding: 15px;
  }
  
  .modal-header h3 {
    font-size: 18px;
  }
  
  .modal-body {
    padding: 15px;
    max-height: calc(85vh - 120px);
  }
  
  .form-row {
    flex-direction: column;
    gap: 15px;
  }
  
  .form-section {
    padding: 15px;
  }
  
  .section-header {
    margin-bottom: 12px;
  }
  
  .section-header h4 {
    font-size: 16px;
  }
  
  .modal-footer {
    padding: 15px;
    flex-direction: column;
    gap: 10px;
  }
  
  .cancel-btn, .edit-btn, .update-btn {
    width: 100%;
    justify-content: center;
  }
  
  .decline-modal {
    width: 95%;
  }
  
  .decline-modal-footer {
    flex-direction: column;
  }
  
  .modal-cancel-button, .modal-decline-button {
    width: 100%;
    justify-content: center;
  }
  
  .pdf-iframe {
    height: 300px;
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
    margin-left: 8px;
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
    right: 40px;
    width: 24px;
    height: 24px;
  }
  
  .reset-button i {
    font-size: 16px;
  }
  
  .filter {
    padding: 10px 16px;
    font-size: 13px;
  }
  
  .filter-menu {
    width: 180px;
    padding: 12px;
  }
  
  .appointment-container {
    margin: 8px;
  }
  
  .appointment h3 {
    font-size: 15px;
    padding: 8px 0;
  }
  
  .appointment-card {
    margin-bottom: 12px;
  }
  
  .card-header {
    padding: 12px;
  }
  
  .card-header h4 {
    font-size: 15px;
  }
  
  .card-content {
    padding: 12px;
  }
  
  .card-row {
    margin-bottom: 10px;
  }
  
  .card-label {
    font-size: 13px;
  }
  
  .card-footer {
    padding: 10px 12px;
  }
  
  .edit-button-mobile {
    padding: 6px 12px;
    font-size: 13px;
  }
  
  .action-button {
    width: 28px;
    height: 28px;
  }
  
  .accept-button .checkmark,
  .decline-button .x-mark {
    font-size: 14px;
  }
  
  .modal-content {
    border-radius: 10px;
  }
  
  .modal-header {
    padding: 12px;
  }
  
  .modal-header h3 {
    font-size: 16px;
  }
  
  .close-btn i {
    font-size: 18px;
  }
  
  .modal-body {
    padding: 12px;
  }
  
  .form-section {
    padding: 12px;
    margin-bottom: 20px;
  }
  
  .section-header h4 {
    font-size: 15px;
  }
  
  .form-group label {
    font-size: 13px;
  }
  
  .form-group input,
  .form-group select {
    padding: 8px 10px;
    font-size: 13px;
  }
  
  .service-chip {
    padding: 4px 8px;
    font-size: 12px;
    margin: 3px;
  }
  
  .modal-footer {
    padding: 12px;
  }
  
  .cancel-btn, .edit-btn, .update-btn {
    padding: 8px 16px;
    font-size: 13px;
  }
  
  .decline-modal-header {
    padding: 12px;
  }
  
  .decline-modal-header h3 {
    font-size: 16px;
  }
  
  .decline-modal-body {
    padding: 12px;
  }
  
  .patient-info {
    padding: 12px;
  }
  
  .patient-avatar {
    width: 40px;
    height: 40px;
  }
  
  .patient-avatar i {
    font-size: 24px;
  }
  
  .patient-details h4 {
    font-size: 15px;
  }
  
  .patient-details p {
    font-size: 13px;
  }
  
  .decline-textarea {
    padding: 12px;
    font-size: 14px;
  }
  
  .decline-modal-footer {
    padding: 12px;
  }
  
  .modal-cancel-button, .modal-decline-button {
    padding: 10px 16px;
    font-size: 14px;
  }
  
  .pdf-iframe {
    height: 250px;
  }
  
  .status-notification {
    top: 10px;
    right: 10px;
    left: 10px;
  }
  
  .notification-content {
    padding: 12px 15px;
    font-size: 13px;
  }
}

/* Landscape Mobile */
@media (max-height: 500px) and (orientation: landscape) {
  .modal-content {
    max-height: 95vh;
  }
  
  .modal-body {
    max-height: calc(95vh - 120px);
  }
  
  .pdf-iframe {
    height: 200px;
  }
  
  .decline-modal {
    max-height: 95vh;
  }
  
  .decline-modal-body {
    max-height: calc(95vh - 120px);
    overflow-y: auto;
  }
}
</style>