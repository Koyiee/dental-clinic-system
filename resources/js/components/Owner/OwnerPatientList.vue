<template>
  <div class="sidebar close">
    <div class="logo-details">
      <img src="@/components/Images/ATDC_Logo.png" alt="" class="logo">
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
          <h3>Patient List</h3>
          <div class="breadcrumbs">
            <a class="none" href=""><p>Home / </p></a>
            <a class="current" href="/ownerpatientlist"><p>Patient List</p></a>
          </div>
        </div>
      </div>
      <hr color="#06693a">

      <!-- Updated Search and Filter Section -->
      <div class="search-wrapper">
        <div class="search-container">
          <input 
            v-model="searchQuery" 
            placeholder="Search by name, phone, or appointment date" 
            @keyup.enter="filterPatients" 
            class="search-input"
            :class="{ 'has-reset': searchQuery && isSearchActive }"
          />
          <i class="bx bx-search search-icon" @click="filterPatients"></i>
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
              <label>Appointment Date Range:</label>
              <input type="date" v-model="filter.startDate">
              <input type="date" v-model="filter.endDate">
            </div>
            <div class="filter-group">
              <label>Sort By:</label>
              <select v-model="filter.sortBy">
                <option value="">Default</option>
                <option value="name-asc">Name (A-Z)</option>
                <option value="name-desc">Name (Z-A)</option>
                <option value="nextAppointment-asc">Next Appointment (Oldest First)</option>
                <option value="nextAppointment-desc">Next Appointment (Newest First)</option>
                <option value="lastAppointment-asc">Last Appointment (Oldest First)</option>
                <option value="lastAppointment-desc">Last Appointment (Newest First)</option>
              </select>
            </div>
            <div class="filter-actions">
              <button class="apply-btn" @click="applyFilters">Apply</button>
              <button class="reset-btn" @click="resetFilters">Reset</button>
            </div>
          </div>
        </div>
      </div>

      <!-- List View -->
      <div class="patient-container">
        <div class="patient-header">
          <h3>{{ totalPatients }} Patients</h3>
        </div>
        <div class="table-wrapper">
          <!-- Desktop Table -->
          <table class="patient-table desktop-table">
            <thead>
              <tr>
                <th @click="sortTable('PatientID')" class="sortable-header">
                  Patient ID
                  <i v-if="sortConfig.key === 'PatientID'" class="bx" :class="getSortIconClass('PatientID')"></i>
                </th>
                <th @click="sortTable('name')" class="sortable-header">
                  Patients Name
                  <i v-if="sortConfig.key === 'name'" class="bx" :class="getSortIconClass('name')"></i>
                </th>
                <th @click="sortTable('phone')" class="sortable-header">
                  Phone Number
                  <i v-if="sortConfig.key === 'phone'" class="bx" :class="getSortIconClass('phone')"></i>
                </th>
                <th @click="sortTable('nextAppointment')" class="sortable-header">
                  Next Appointment
                  <i v-if="sortConfig.key === 'nextAppointment'" class="bx" :class="getSortIconClass('nextAppointment')"></i>
                </th>
                <th @click="sortTable('lastAppointment')" class="sortable-header">
                  Last Appointment
                  <i v-if="sortConfig.key === 'lastAppointment'" class="bx" :class="getSortIconClass('lastAppointment')"></i>
                </th>
              </tr>
            </thead>
            <tbody class="container-patient">
              <tr v-for="(patient, index) in filteredPatients" :key="patient.PatientID" @click="showPatientDetails(patient)" class="patient-row">
                <td>{{ patient.PatientID }}</td>
                <td class="truncate-cell">{{ patient.user.FirstName }} {{ patient.user.LastName }}</td>
                <td class="truncate-cell">{{ patient.user.ContactNumber }}</td>
                <td class="truncate-cell">{{ formatAppointmentDate(patient.nextAppointment) || 'N/A' }}</td>
                <td class="truncate-cell">{{ formatAppointmentDate(patient.lastAppointment) || 'N/A' }}</td>
              </tr>
              <tr v-if="filteredPatients.length === 0">
                <td colspan="5" class="no-data">No patients found...</td>
              </tr>
            </tbody>
          </table>
          
          <!-- Mobile Cards -->
          <div class="mobile-cards">
            <div 
              v-for="(patient, index) in filteredPatients" 
              :key="patient.PatientID"
              class="patient-card"
              @click="showPatientDetails(patient)"
            >
              <div class="card-header">
                <h4>{{ patient.user.FirstName }} {{ patient.user.LastName }}</h4>
                <span class="patient-number">{{ (currentPage - 1) * 15 + index + 1 }}</span>
              </div>
              <div class="card-content">
                <div class="card-row">
                  <span class="card-label">Phone:</span>
                  <span>{{ patient.user.ContactNumber }}</span>
                </div>
                <div class="card-row">
                  <span class="card-label">Next Appointment:</span>
                  <span>{{ formatAppointmentDate(patient.nextAppointment) || 'N/A' }}</span>
                </div>
                <div class="card-row">
                  <span class="card-label">Last Appointment:</span>
                  <span>{{ formatAppointmentDate(patient.lastAppointment) || 'N/A' }}</span>
                </div>
              </div>
            </div>
            <div v-if="filteredPatients.length === 0" class="no-data-mobile">
              No patients found
            </div>
          </div>
        </div>
        
        <!-- See More Button (Pagination) -->
        <div class="see-more-container">
            <div class="pagination-info">
              Page {{ currentPage }} of {{ lastPage }}
            </div>
            <div class="pagination-actions">
              <button 
                class="pagination-btn prev" 
                @click="changePage(currentPage - 1)" 
                :disabled="currentPage === 1"
              >
                <i class='bx bx-chevron-left'></i> Previous
              </button>
              <button 
                class="pagination-btn next" 
                @click="changePage(currentPage + 1)" 
                :disabled="currentPage === lastPage"
              >
                Next <i class='bx bx-chevron-right'></i>
              </button>
            </div>
          </div>
        </div>
        <br>
      </div>

      <!-- Patient Details Modal -->
      <div v-if="selectedPatient && isModalVisible" class="modal-overlay">
        <div class="modal-content">
          <div class="modal-header">
            <h2>Patient Details</h2>
            <button class="close-btn" @click="closeModal">
              <i class='bx bx-x'></i>
            </button>
          </div>
          
          <div class="patient-profile-card">
            <div class="patient-profile-header">
              <div class="patient-avatar">
                <i class='bx bx-user-circle'></i>
              </div>
              <div class="patient-basic-info">
                <h2>{{ selectedPatient.user.FirstName }} {{ selectedPatient.user.LastName }}</h2>
                <p class="patient-id">Patient ID: {{ selectedPatient.PatientID || '0000' }}</p>
                <p class="patient-email">{{ selectedPatient.user.Email || 'No email provided' }}</p>
              </div>
            </div>
            
            <div class="patient-details-grid">
              <div class="details-column">
                <div class="detail-item">
                  <div class="detail-label">Gender</div>
                  <div class="detail-value">{{ selectedPatient.user.Gender || 'N/A' }}</div>
                </div>
                <div class="detail-item">
                  <div class="detail-label">Birthday</div>
                  <div class="detail-value">{{ selectedPatient.user.BirthDate || 'N/A' }}</div>
                </div>
                <div class="detail-item">
                  <div class="detail-label">Age</div>
                  <div class="detail-value">{{ selectedPatient.user.Age || 'N/A' }} years old</div>
                </div>
              </div>
              
              <div class="details-column">
                <div class="detail-item">
                  <div class="detail-label">Religion</div>
                  <div class="detail-value">{{ selectedPatient.Religion || 'N/A' }}</div>
                </div>
                <div class="detail-item">
                  <div class="detail-label">Nationality</div>
                  <div class="detail-value">{{ selectedPatient.Nationality || 'N/A' }}</div>
                </div>
                <div class="detail-item">
                  <div class="detail-label">Marital Status</div>
                  <div class="detail-value">{{ selectedPatient.MaritalStatus || 'N/A' }}</div>
                </div>
              </div>
              
              <div class="details-column">
                <div class="detail-item">
                  <div class="detail-label">Home Address</div>
                  <div class="detail-value">{{ selectedPatient.user.Address || 'N/A' }}</div>
                </div>
                <div class="detail-item">
                  <div class="detail-label">Phone Number</div>
                  <div class="detail-value">{{ selectedPatient.user.ContactNumber || 'N/A' }}</div>
                </div>
                <div class="detail-item">
                  <div class="detail-label">Home Telephone</div>
                  <div class="detail-value">{{ selectedPatient.user.HomeTelephoneNumber || 'N/A' }}</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </section>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
  name: "OwnerPatientList",
  props: {
    firstName: { type: String, required: true },
    lastName: { type: String, required: true },
  },
  data() {
    return {
      patients: [],
      filteredPatients: [],
      currentPage: 1,
      lastPage: 1,
      totalPatients: 0,
      searchQuery: '',
      isSearchActive: false,
      showFilterMenu: false,
      isModalVisible: false,
      selectedPatient: null,
      filter: {
        startDate: '',
        endDate: '',
        sortBy: ''
      },
      sortConfig: {
        key: null,
        direction: 'asc'
      },
      formData: {
        LastName: "",
        FirstName: "",
        MiddleName: "",
        ContactNumber: "",
        Email: "",
        Username: "",
        Password: "",
        Password_confirmation: "",
        Gender: "",
        Birthdate: "",
        Age: "",
        Religion: "",
        Nationality: "",
        Status: "",
        HomeAddress: "",
        HomeTelephoneNumber: "",
        Occupation: "",
        OfficeNumber: "",
        ReferredBy: "",
        GovernmentID: null,
      },
      imagePreview: null,
      errors: [],
    };
  },
  computed: {
    fullName() {
      return `${this.firstName} ${this.lastName}`;
    },
  },
  mounted() {
    this.setupSidebar();
    this.fetchPatients();
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
    async fetchPatients(page = 1) {
      try {
        const response = await axios.get('/patient-list', {
          params: { page, search: this.searchQuery }
        });
        
        // Fetch appointments to get next and last appointment dates
        const appointmentsResponse = await axios.get('/hr/appointments/calendar');
        const appointments = appointmentsResponse.data || [];
        
        // Process patients data to include next and last appointments
        this.patients = response.data.data.map(patient => {
          const patientName = `${patient.user.FirstName} ${patient.user.LastName}`;
          const patientAppointments = appointments.filter(
            appt => appt.patient_name === patientName
          );
          
          // Sort appointments by date
          patientAppointments.sort((a, b) => {
            return new Date(a.AppointmentDate) - new Date(b.AppointmentDate);
          });
          
          const now = new Date();
          
          // Filter upcoming appointments to only include confirmed ones
          const upcomingAppointments = patientAppointments.filter(
            appt => 
              new Date(`${appt.AppointmentDate}T${appt.AppointmentTime}`) > now && 
              appt.AppointmentStatus === 'Confirmed'
          );
          
          // Filter past appointments to only include completed ones
          const pastAppointments = patientAppointments.filter(
            appt => 
              new Date(`${appt.AppointmentDate}T${appt.AppointmentTime}`) <= now && 
              appt.AppointmentStatus === 'Completed'
          );
          
          // Get next appointment (first upcoming confirmed) and last appointment (most recent completed)
          const nextAppointment = upcomingAppointments.length > 0 ? 
            `${upcomingAppointments[0].AppointmentDate}T${upcomingAppointments[0].AppointmentTime}` : null;
          
          const lastAppointment = pastAppointments.length > 0 ?
            `${pastAppointments[pastAppointments.length - 1].AppointmentDate}T${pastAppointments[pastAppointments.length - 1].AppointmentTime}` : null;
          
          return {
            ...patient,
            nextAppointment,
            lastAppointment
          };
        });
        
        this.filteredPatients = [...this.patients];
        this.currentPage = response.data.current_page;
        this.lastPage = response.data.last_page;
        this.totalPatients = response.data.total;
        this.updateDisplayedPatients();
      } catch (error) {
        console.error("Error fetching patients:", error);
        this.$notify({
          type: 'error',
          title: 'Fetch Failed',
          text: 'Failed to fetch patient list. Please try again.'
        });
        this.patients = [];
        this.filteredPatients = [];
      }
    },
    changePage(page) {
      if (page > 0 && page <= this.lastPage) {
        this.fetchPatients(page);
      }
    },
    showPatientDetails(patient) {
      this.selectedPatient = patient;
      this.isModalVisible = true;
    },
    closeModal() {
      this.isModalVisible = false;
      this.selectedPatient = null;
    },
    resetForm() {
      this.formData = {
        LastName: "",
        FirstName: "",
        MiddleName: "",
        ContactNumber: "",
        Email: "",
        Username: "",
        Password: "",
        Password_confirmation: "",
        Gender: "",
        Birthdate: "",
        Age: "",
        Religion: "",
        Nationality: "",
        Status: "",
        HomeAddress: "",
        HomeTelephoneNumber: "",
        Occupation: "",
        OfficeNumber: "",
        ReferredBy: "",
        GovernmentID: null,
      };
      this.imagePreview = null;
      this.errors = [];
    },
    calculateAge() {
      if (this.formData.Birthdate) {
        const birthdate = new Date(this.formData.Birthdate);
        const today = new Date();
        let age = today.getFullYear() - birthdate.getFullYear();
        const monthDiff = today.getMonth() - birthdate.getMonth();
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthdate.getDate())) {
          age--;
        }
        this.formData.Age = age;
      }
    },
    handleFileUpload(event) {
      const file = event.target.files[0];
      if (file) {
        this.imagePreview = URL.createObjectURL(file);
        this.formData.GovernmentID = file;
      }
    },
    async submitForm() {
      const formData = new FormData();
      for (const key in this.formData) {
        if (this.formData[key] !== null && this.formData[key] !== undefined) {
          formData.append(key, this.formData[key]);
        }
      }
      try {
        const response = await axios.post('/users', formData, {
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        });
        alert('Patient added successfully!');
        this.closeModal();
      } catch (error) {
        if (error.response && error.response.status === 422) {
          this.errors = Object.values(error.response.data.errors).flat();
        } else {
          this.errors = ["An unexpected error occurred. Please try again later."];
        }
      }
    },
    matchesSearch(patient) {
      const query = this.searchQuery.toLowerCase();
      return (
        `${patient.user.FirstName} ${patient.user.LastName}`.toLowerCase().includes(query) ||
        (patient.user.ContactNumber || '').toLowerCase().includes(query) ||
        (patient.nextAppointment || '').toLowerCase().includes(query) ||
        (patient.lastAppointment || '').toLowerCase().includes(query)
      );
    },
    applyAllFilters(patients) {
      let filtered = [...patients];
      
      if (this.searchQuery && this.isSearchActive) {
        filtered = filtered.filter(patient => this.matchesSearch(patient));
      }

      if (this.filter.startDate || this.filter.endDate) {
        filtered = filtered.filter(patient => {
          const nextDate = patient.nextAppointment ? new Date(patient.nextAppointment) : null;
          const lastDate = patient.lastAppointment ? new Date(patient.lastAppointment) : null;
          const start = this.filter.startDate ? new Date(this.filter.startDate) : null;
          const end = this.filter.endDate ? new Date(this.filter.endDate) : null;
          return (
            (!start || (nextDate && nextDate >= start) || (lastDate && lastDate >= start)) &&
            (!end || (nextDate && nextDate <= end) || (lastDate && lastDate <= end))
          );
        });
      }

      if (this.filter.sortBy) {
        const [field, direction] = this.filter.sortBy.split('-');
        filtered.sort((a, b) => {
          if (field === 'name') {
            const nameA = `${a.user.FirstName} ${a.user.LastName}`.toLowerCase();
            const nameB = `${b.user.FirstName} ${b.user.LastName}`.toLowerCase();
            return direction === 'asc' ? nameA.localeCompare(nameB) : nameB.localeCompare(nameA);
          } else if (field === 'nextAppointment' || field === 'lastAppointment') {
            const dateA = new Date(a[field] || '1970-01-01');
            const dateB = new Date(b[field] || '1970-01-01');
            return direction === 'asc' ? dateA - dateB : dateB - dateA;
          }
          return 0;
        });
      }

      return filtered;
    },
    filterPatients() {
      if (!this.searchQuery.trim()) {
        this.isSearchActive = false;
      } else {
        this.isSearchActive = true;
      }
      this.updateDisplayedPatients();
    },
    updateDisplayedPatients() {
      this.filteredPatients = this.applyAllFilters(this.patients);
      this.applySorting();
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
    applyFilters() {
      this.updateDisplayedPatients();
      this.showFilterMenu = false;
    },
    resetFilters() {
      this.filter = {
        startDate: '',
        endDate: '',
        sortBy: ''
      };
      this.showFilterMenu = false;
      this.updateDisplayedPatients();
    },
    resetSearch() {
      this.searchQuery = '';
      this.isSearchActive = false;
      this.updateDisplayedPatients();
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
    applySorting() {
      const { key, direction } = this.sortConfig;
      if (!key) return;

      this.filteredPatients.sort((a, b) => {
        let valueA = key === 'index' ? this.filteredPatients.indexOf(a) + 1 : a[key];
        let valueB = key === 'index' ? this.filteredPatients.indexOf(b) + 1 : b[key];
        
        if (key === 'name') {
          valueA = `${a.user.FirstName} ${a.user.LastName}`.toLowerCase();
          valueB = `${b.user.FirstName} ${b.user.LastName}`.toLowerCase();
        } else if (key === 'phone') {
          valueA = a.user.ContactNumber || '';
          valueB = b.user.ContactNumber || '';
        } else if (key === 'nextAppointment' || key === 'lastAppointment') {
          valueA = new Date(valueA || '1970-01-01');
          valueB = new Date(valueB || '1970-01-01');
          return direction === 'asc' ? valueA - valueB : valueB - valueA;
        }
        
        valueA = valueA || '';
        valueB = valueB || '';
        
        if (typeof valueA === 'string' && typeof valueB === 'string') {
          return direction === 'asc' 
            ? valueA.localeCompare(valueB)
            : valueB.localeCompare(valueA);
        }

        return direction === 'asc'
          ? (valueA > valueB ? 1 : -1) 
          : (valueA < valueB ? 1 : -1);
      });
    },
    getSortIconClass(key) {
      if (this.sortConfig.key === key) {
        return this.sortConfig.direction === 'asc' ? 'bx-caret-up' : 'bx-caret-down';
      }
      return '';
    },
    formatAppointmentDate(dateString) {
      if (!dateString || dateString === 'N/A') return '';
      
      try {
        const date = new Date(dateString);
        if (isNaN(date.getTime())) return ''; // Check for invalid date
        
        return date.toLocaleDateString('en-US', { 
          month: 'short', 
          day: 'numeric',
          year: 'numeric'
        });
      } catch (error) {
        console.error("Error formatting date:", error);
        return '';
      }
    },
  },
};
</script>

<style scoped>
@import url('https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css');
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap');

/* Base Styles */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Poppins', sans-serif;
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

.breadcrumbs .current{
  text-decoration: none;
  color: #000000;
  font-size: 10pt;
  font-weight: 100;
}

.breadcrumbs .none{
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

.sidebar .nav-link li.showMenu .sub-menu{
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

.sidebar .profile-details{
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
}

.sidebar.close .profile-details {
  width: 78px;
}

.sidebar .profile-details .profile-content{
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

/* Search and Filter Styles */
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
  flex-shrink: 0;
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

/* Patient Table Styles */
.patient-container {
  margin: 20px;
  background-color: white;
  border-radius: 12px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
  overflow: hidden;
}

.patient-header {
  padding: 20px 25px 0;
  border-bottom: 1px solid #f0f0f0;
}

.patient-header h3 {
  font-size: 18px;
  color: #333;
  font-weight: 600;
  margin: 0;
  padding-bottom: 15px;
}

.table-wrapper {
  padding: 0;
}

.patient-table {
  width: 100%;
  border-collapse: collapse;
  background-color: white;
  table-layout: fixed;
}

.patient-table th,
.patient-table td {
  padding: 16px;
  text-align: left;
  border-bottom: 1px solid #f5f5f5;
  color: #333;
  font-size: 14px;
  width: 20%; /* Equal width for all 5 columns */
}

.patient-table th {
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

.patient-row {
  cursor: pointer;
  transition: background-color 0.2s;
}

.patient-row:hover {
  background-color: #f9f9f9;
}

.patient-table tr:last-child td {
  border-bottom: none;
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

.patient-card {
  background-color: white;
  border-radius: 12px;
  border: 1px solid #e0e0e0;
  margin-bottom: 16px;
  overflow: hidden;
  cursor: pointer;
  transition: transform 0.2s, box-shadow 0.2s;
}

.patient-card:hover {
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
  margin-right: 10px;
}

.patient-number {
  background-color: #06693A;
  color: white;
  padding: 4px 8px;
  border-radius: 12px;
  font-size: 12px;
  font-weight: 600;
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

/* Pagination Styles */
.see-more-container {
  padding: 20px;
  border-top: 1px solid #f0f0f0;
  display: flex;
  justify-content: space-between;
  align-items: center;
  background-color: #f9f9f9;
}

.pagination-info {
  color: #666;
  font-size: 14px;
}

.pagination-actions {
  display: flex;
  gap: 10px;
}

.pagination-btn {
  background-color: #06693A;
  color: white;
  border: none;
  padding: 8px 16px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 14px;
  display: flex;
  align-items: center;
  gap: 5px;
  transition: background-color 0.2s;
}

.pagination-btn:hover:not(:disabled) {
  background-color: #055a32;
}

.pagination-btn:disabled {
  background-color: #ccc;
  cursor: not-allowed;
}

.pagination-btn i {
  font-size: 14px;
}

/* Modal Styles */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}

.modal-content {
  background: white;
  border-radius: 12px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
  width: 90%;
  max-width: 800px;
  max-height: 90vh;
  overflow-y: auto;
  display: flex;
  flex-direction: column;
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

.modal-header h2 {
  margin: 0;
  font-size: 22px;
  font-weight: 600;
}

.close-btn {
  background: none;
  border: none;
  font-size: 24px;
  color: #777;
  cursor: pointer;
  transition: color 0.3s ease;
}

.close-btn:hover {
  color: #333;
}

.close-btn i {
  font-size: 20px;
}

.patient-profile-card {
  padding: 20px;
}

.patient-profile-header {
  display: flex;
  align-items: center;
  margin-bottom: 25px;
  padding-bottom: 20px;
  border-bottom: 1px solid #f0f0f0;
}

.patient-avatar {
  width: 80px;
  height: 80px;
  background-color: #e8f5ee;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-right: 25px;
  flex-shrink: 0;
}

.patient-avatar i {
  font-size: 48px;
  color: #06693a;
}

.patient-basic-info {
  flex: 1;
}

.patient-basic-info h2 {
  margin: 0 0 5px 0;
  font-size: 24px;
  color: #333;
}

.patient-id {
  font-size: 14px;
  color: #666;
  margin-bottom: 5px;
}

.patient-email {
  font-size: 14px;
  color: #06693a;
}

.patient-details-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
  margin-bottom: 25px;
}

.details-column {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.detail-item {
  display: flex;
  flex-direction: column;
  gap: 5px;
}

.detail-label {
  font-size: 12px;
  font-weight: 600;
  color: #666;
  text-transform: uppercase;
}

.detail-value {
  font-size: 14px;
  color: #333;
}

/* Responsive Design */

/* Large Desktop */
@media (min-width: 1400px) {
  .patient-container {
    margin: 30px;
  }

  .patient-profile-card {
    padding: 30px;
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

  .patient-table th,
  .patient-table td {
    padding: 12px 15px;
    font-size: 13px;
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

  .patient-container {
    margin: 15px;
  }

  .patient-header h3 {
    font-size: 16px;
  }

  .patient-details-grid {
    grid-template-columns: 1fr 1fr;
  }

  .modal-content {
    width: 95%;
    max-width: 600px;
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

  .patient-container {
    margin: 10px;
  }

  .patient-header h3 {
    font-size: 16px;
    padding: 15px 0 10px 0;
  }

  .patient-card {
    border-radius: 8px;
    margin-bottom: 12px;
  }

  .card-header {
    padding: 12px 15px;
  }

  .card-header h4 {
    font-size: 15px;
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

  .see-more-container {
    padding: 15px;
    flex-direction: column;
    gap: 10px;
    align-items: flex-start;
  }

  .pagination-actions {
    width: 100%;
    justify-content: space-between;
  }

  .patient-profile-header {
    flex-direction: column;
    text-align: center;
    gap: 15px;
  }

  .patient-details-grid {
    grid-template-columns: 1fr;
    gap: 15px;
  }

  .modal-content {
    width: 95%;
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

  .patient-container {
    margin: 8px;
  }

  .patient-header h3 {
    font-size: 14px;
    padding: 12px 0 8px 0;
  }

  .patient-card {
    margin-bottom: 10px;
  }

  .card-header {
    padding: 10px 12px;
  }

  .card-header h4 {
    font-size: 13px;
  }

  .patient-number {
    padding: 3px 6px;
    font-size: 11px;
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

  .see-more-container {
    padding: 12px;
  }

  .pagination-info {
    font-size: 12px;
  }

  .pagination-btn {
    padding: 6px 12px;
    font-size: 12px;
  }

  .patient-profile-header {
    gap: 10px;
  }

  .patient-avatar {
    width: 50px;
    height: 50px;
    font-size: 24px;
  }

  .patient-basic-info h2 {
    font-size: 18px;
  }

  .patient-id,
  .patient-email {
    font-size: 12px;
  }

  .detail-label {
    font-size: 11px;
  }

  .detail-value {
    font-size: 13px;
  }

  .modal-content {
    width: 95%;
    border-radius: 10px;
  }

  .modal-header {
    padding: 10px 12px;
  }

  .modal-header h2 {
    font-size: 16px;
  }

  .close-btn {
    font-size: 1.2em;
  }

  .patient-profile-card {
    padding: 12px;
  }
}

/* Landscape Mobile */
@media (max-height: 500px) and (orientation: landscape) {
  .modal-content {
    max-height: 95vh;
  }

  .patient-card {
    margin-bottom: 8px;
  }
}

/* Touch-friendly improvements */
@media (hover: none) and (pointer: coarse) {
  .patient-card {
    min-height: 48px; /* Minimum touch target size */
  }

  .patient-card:active {
    transform: scale(0.98);
    transition: transform 0.1s ease;
  }

  .pagination-btn {
    min-height: 44px;
  }
}
</style>
