<template>
  <div class="sidebar close">
    <!-- Sidebar content remains unchanged -->
    <div class="logo-details">
      <img src="@/components/Images/ATDC_logo.png" alt="" class="logo">
      <div class="logo_name"><img class="img2" src="@/components/Images/ATDC_Logo3.png" alt=""></div>
    </div>
    <ul class="nav-link">
      <li><a href="/patientdashboard"><i class="bx bx-grid-alt"></i><span class="link_name">Dashboard</span></a><ul class="sub-menu blank"><li><a class="link_name" href="/patientdashboard">Dashboard</a></li></ul></li>
      <li><a href="/patientannouncements"><i class="bx bxs-megaphone"></i><span class="link_name">Announcements</span></a><ul class="sub-menu blank"><li><a class="link_name" href="/patientannouncements">Announcements</a></li></ul></li>
      <li><a href="/patientinformation"><i class="bx bx-clipboard"></i><span class="link_name">Patient Information</span></a><ul class="sub-menu blank"><li><a class="link_name" href="/patientinformation">Patient Information</a></li></ul></li>
      <li><div class="icon-link"><a href="/patientappointments"><i class="bx bx-calendar"></i><span class="link_name">Appointment</span></a><i class="bx bxs-chevron-down arrow"></i></div><ul class="sub-menu"><li><a class="link_name" href="/patientappointments">Appointment</a></li><li><a href="/patientscheduleanappointment">Schedule Appointment</a></li></ul></li>
      <li><a href="/patientbillings"><i class="bx bx-wallet"></i><span class="link_name">Billing</span></a><ul class="sub-menu blank"><li><a class="link_name" href="/patientbillings">Billing</a></li></ul></li>
      <li><div class="icon-link"><a href="/patienttreatments"><i class="bx bx-clipboard"></i><span class="link_name">Treatments</span></a><i class="bx bxs-chevron-down arrow"></i></div><ul class="sub-menu"><li><a class="link_name" href="/patienttreatments">Treatments</a></li><li><a href="/patienttreatmentplan">Treatment Plan</a></li><li><a href="/patientdentalphotos">Dental Photos</a></li><li><a href="/patientforms">Forms</a></li><li><a href="/patientdentaltreatmenthistory">Dental Treatment History</a></li></ul></li>
      <li><a href="/patientsettings"><i class="bx bx-cog"></i><span class="link_name">Settings</span></a><ul class="sub-menu blank"><li><a class="link_name" href="/patientsettings">Settings</a></li></ul></li>
      <li><div class="profile-details" @click="confirmLogout"><div class="profile-content"><img src="@/components/Images/profile_1.jpg" alt="profile"></div><div class="name-job"><div class="profile_name">{{ fullName }}</div><div class="job">Patient</div></div><i class="bx bx-log-out"></i></div></li>
    </ul>
  </div>

  <!-- Mobile Overlay -->
  <div class="mobile-overlay" @click="closeMobileSidebar"></div>

  <section class="home-section">
    <div class="home-content">
      <div class="header">
        <i class="bx bx-menu"></i>
        <div class="text">
          <h3>Treatments</h3>
          <div class="breadcrumbs">
            <a class="none" href=""><p>Home / </p></a>
            <a class="none" href="/patienttreatments"><p>Treatments / </p></a>
            <a class="current" href="/patientdentaltreatmenthistory"><p>Dental Treatment History</p></a>
          </div>
        </div>
      </div>
      <hr color="#06693a">
      
      <!-- Updated Search and Filter Section -->
      <div class="search-wrapper">
        <div class="search-container">
          <input 
            v-model="searchQuery" 
            placeholder="Search by dentist, treatment, or date" 
            @keyup.enter="filterTreatmentHistory" 
            class="search-input"
            :class="{ 'has-reset': searchQuery && isSearchActive }"
          />
          <i class="bx bx-search search-icon" @click="filterTreatmentHistory"></i>
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
              <label>Sort By:</label>
              <select v-model="filter.sortBy">
                <option value="">Default</option>
                <option value="date-asc">Date (Oldest First)</option>
                <option value="date-desc">Date (Newest First)</option>
                <option value="dentist-asc">Dentist (A-Z)</option>
                <option value="dentist-desc">Dentist (Z-A)</option>
                <option value="treatment-asc">Treatment (A-Z)</option>
                <option value="treatment-desc">Treatment (Z-A)</option>
              </select>
            </div>
            <div class="filter-actions">
              <button class="apply-btn" @click="applyFilters">Apply</button>
              <button class="reset-btn" @click="resetFilters">Reset</button>
            </div>
          </div>
        </div>
      </div>

      <div class="treatment-container">
        <div class="treatment">
          <h3>DENTAL TREATMENT HISTORY</h3>
        </div>
        <div class="table-wrapper">
          <!-- Desktop Table -->
          <table class="treatment-table desktop-table">
            <thead>
              <tr>
                <th @click="sortTable('dateTime')" class="sortable-header">
                  Date & Time
                  <i v-if="sortConfig.key === 'dateTime'" class="bx" :class="getSortIconClass('dateTime')"></i>
                </th>
                <th @click="sortTable('dentist')" class="sortable-header">
                  Dentist
                  <i v-if="sortConfig.key === 'dentist'" class="bx" :class="getSortIconClass('dentist')"></i>
                </th>
                <th @click="sortTable('treatment')" class="sortable-header treatment-column">
                  Treatment
                  <i v-if="sortConfig.key === 'treatment'" class="bx" :class="getSortIconClass('treatment')"></i>
                </th>
                <th style="text-align: center;" class="action-header">Action</th>
              </tr>
            </thead>
            <tbody class="container-treatment">
              <tr 
                v-for="(history, index) in filteredTreatmentHistory" 
                :key="history.id"
                class="treatment-row"
              >
                <td class="truncate-cell">{{ formatDateTime(history.dateTime) }}</td>
                <td class="truncate-cell">{{ history.dentist }}</td>
                <td class="truncate-cell treatment-column">{{ history.treatment }}</td>
                <td class="action-cell">
                  <button @click="viewTreatmentDetails(history)" class="view-details-btn" title="View Details">
                    <i class='bx bx-show'></i>
                  </button>
                </td>
              </tr>
              <tr v-if="filteredTreatmentHistory.length === 0">
                <td colspan="4" class="no-data">No treatment history found.</td>
              </tr>
            </tbody>
          </table>

          <!-- Mobile Cards -->
          <div class="mobile-cards">
            <div 
              v-for="(history, index) in filteredTreatmentHistory" 
              :key="history.id"
              class="treatment-card"
            >
              <div class="card-header">
                <h4>{{ history.treatment }}</h4>
              </div>
              <div class="card-content">
                <div class="card-row">
                  <span class="card-label">Date & Time:</span>
                  <span>{{ formatDateTime(history.dateTime) }}</span>
                </div>
                <div class="card-row">
                  <span class="card-label">Dentist:</span>
                  <span>{{ history.dentist }}</span>
                </div>
              </div>
              <div class="card-footer">
                <button @click.stop="viewTreatmentDetails(history)" class="action-button-mobile">
                  <i class='bx bx-show'></i> View Details
                </button>
              </div>
            </div>
            <div v-if="filteredTreatmentHistory.length === 0" class="no-data-mobile">
              No treatment history found
            </div>
          </div>
        </div>
      </div>

      <!-- Details Modal -->
      <div v-if="showDetailsModal" class="modal-overlay" @click="closeDetailsModal">
        <div class="modal-content" @click.stop>
          <div class="modal-header">
            <h3>Treatment Details</h3>
            <button @click="closeDetailsModal" class="close-btn">
              <i class='bx bx-x'></i>
            </button>
          </div>
          <div class="modal-body">
            <div class="details-info">
              <div class="details-row">
                <span class="details-label">Date & Time:</span>
                <span>{{ formatDateTime(selectedTreatment?.dateTime) }}</span>
              </div>
              <div class="details-row">
                <span class="details-label">Dentist:</span>
                <span>{{ selectedTreatment?.dentist }}</span>
              </div>
              <div class="details-row">
                <span class="details-label">Treatment:</span>
                <span>{{ selectedTreatment?.treatment }}</span>
              </div>
              <div class="details-row">
                <span class="details-label">Notes:</span>
                <p class="details-notes">{{ selectedTreatment?.notes || 'No additional notes.' }}</p>
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
  name: "PatientDentalTreatmentHistory",
  props: {
    firstName: { type: String, required: true },
    lastName: { type: String, required: true },
  },
  data() {
    return {
      treatmentHistory: [],
      filteredTreatmentHistory: [],
      searchQuery: '',
      showDetailsModal: false,
      selectedTreatment: null,
      showFilterMenu: false,
      isSearchActive: false,
      filter: { startDate: '', endDate: '', sortBy: '' },
      sortConfig: { key: null, direction: 'asc' }
    };
  },
  computed: {
    fullName() {
      return `${this.firstName} ${this.lastName}`;
    }
  },
  mounted() {
    this.setupSidebar();
    this.fetchTreatmentHistory();
    document.addEventListener('click', this.handleClickOutside);
  },
  beforeUnmount() {
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
    applyFilters() {
      this.updateDisplayedHistory();
      this.showFilterMenu = false;
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
    async fetchTreatmentHistory() {
      try {
        console.log('Fetching treatment history for logged-in patient');
        const response = await axios.get('/patient/my-treatment-history', {
          headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
        });
        // Filter for only completed appointments
        this.treatmentHistory = response.data
          .filter(appointment => appointment.AppointmentStatus === 'Completed')
          .map(appointment => ({
            id: appointment.AppointmentID,
            dateTime: `${appointment.AppointmentDate} ${appointment.AppointmentTime}`,
            dentist: appointment.DentistName,
            treatment: appointment.Services.length > 0 
              ? appointment.Services.map(s => s.ServiceName).join(', ') 
              : 'N/A',
            toothNumber: appointment.Services[0]?.ToothNumber || null,
            notes: appointment.PatientNote,
            status: appointment.AppointmentStatus
          }));
        this.filteredTreatmentHistory = [...this.treatmentHistory];
      } catch (error) {
        console.error('Error fetching treatment history:', error);
        alert('Failed to fetch treatment history. Please try again.');
        this.treatmentHistory = [];
        this.filteredTreatmentHistory = [];
      }
    },
    matchesSearch(history) {
      const query = this.searchQuery.toLowerCase();
      return (
        (history.dentist || '').toLowerCase().includes(query) ||
        (history.treatment || '').toLowerCase().includes(query) ||
        this.formatDateTime(history.dateTime).toLowerCase().includes(query)
      );
    },
    applyAllFilters(histories) {
      let filtered = [...histories];
      if (this.searchQuery && this.isSearchActive) {
        filtered = filtered.filter(history => this.matchesSearch(history));
      }
      if (this.filter.startDate || this.filter.endDate) {
        filtered = filtered.filter(history => {
          const historyDate = new Date(history.dateTime);
          const start = this.filter.startDate ? new Date(this.filter.startDate) : null;
          const end = this.filter.endDate ? new Date(this.filter.endDate) : null;
          return (!start || historyDate >= start) && (!end || historyDate <= end);
        });
      }
      if (this.filter.sortBy) {
        const [field, direction] = this.filter.sortBy.split('-');
        filtered.sort((a, b) => {
          if (field === 'date') {
            const dateA = new Date(a.dateTime || 0);
            const dateB = new Date(b.dateTime || 0);
            return direction === 'asc' ? dateA - dateB : dateB - dateA;
          } else if (field === 'dentist') {
            const dentistA = (a.dentist || '').toLowerCase();
            const dentistB = (b.dentist || '').toLowerCase();
            return direction === 'asc' ? dentistA.localeCompare(dentistB) : dentistB.localeCompare(dentistA);
          } else if (field === 'treatment') {
            const treatmentA = (a.treatment || '').toLowerCase();
            const treatmentB = (b.treatment || '').toLowerCase();
            return direction === 'asc' ? treatmentA.localeCompare(treatmentB) : treatmentB.localeCompare(treatmentA);
          }
          return 0;
        });
      }
      return filtered;
    },
    filterTreatmentHistory() {
      if (!this.searchQuery.trim()) {
        this.isSearchActive = false;
      } else {
        this.isSearchActive = true;
      }
      this.updateDisplayedHistory();
    },
    updateDisplayedHistory() {
      this.filteredTreatmentHistory = this.applyAllFilters(this.treatmentHistory);
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
    resetFilters() {
      this.filter = { startDate: '', endDate: '', sortBy: '' };
      this.showFilterMenu = false;
      this.updateDisplayedHistory();
    },
    resetSearch() {
      this.searchQuery = '';
      this.isSearchActive = false;
      this.updateDisplayedHistory();
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
      this.filteredTreatmentHistory.sort((a, b) => {
        let valueA = key === 'index' ? this.filteredTreatmentHistory.indexOf(a) + 1 : a[key];
        let valueB = key === 'index' ? this.filteredTreatmentHistory.indexOf(b) + 1 : b[key];
        valueA = valueA || '';
        valueB = valueB || '';
        if (key === 'dateTime') {
          valueA = new Date(valueA);
          valueB = new Date(valueB);
          return direction === 'asc' ? valueA - valueB : valueB - valueA;
        }
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
    formatDateTime(dateTime) {
      if (!dateTime) return 'N/A';
      const d = new Date(dateTime);
      const date = d.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
      const time = d.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
      return `${date}, ${time}`;
    },
    viewTreatmentDetails(treatment) {
      this.selectedTreatment = treatment;
      this.showDetailsModal = true;
      document.body.style.overflow = 'hidden';
    },
    closeDetailsModal() {
      this.selectedTreatment = null;
      this.showDetailsModal = false;
      document.body.style.overflow = 'auto';
    }
  }
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

/* Treatment Container */
.treatment-container {
  margin: 20px;
  background-color: white;
  border-radius: 12px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
  overflow: hidden;
}

.treatment {
  padding: 20px 25px 0;
  border-bottom: 1px solid #f0f0f0;
}

.treatment h3 {
  font-size: 18px;
  color: #333;
  font-weight: 600;
  margin: 0;
  padding-bottom: 15px;
}

.table-wrapper {
  padding: 0;
}

.treatment-table {
  width: 100%;
  border-collapse: collapse;
  background-color: white;
  table-layout: fixed;
}

.treatment-table th,
.treatment-table td {
  padding: 16px;
  text-align: left;
  border-bottom: 1px solid #f5f5f5;
  color: #333;
  font-size: 14px;
}

.treatment-table th {
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

.treatment-row {
  cursor: pointer;
  transition: background-color 0.2s;
}

.treatment-row:hover {
  background-color: #f9f9f9;
}

.treatment-table tr:last-child td {
  border-bottom: none;
}

.no-data {
  text-align: center;
  color: #757575;
  padding: 30px !important;
}

/* Action Column */
.action-header {
  width: 15%;
  text-align: center;
}

.action-cell {
  text-align: center;
  vertical-align: middle;
  display: flex;
  gap: 8px;
  justify-content: center;
  align-items: center;
}

.view-details-btn {
  background-color: rgba(6, 105, 58, 0.1);
  color: #06693A;
  border: none;
  width: 32px;
  height: 32px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.2s ease;
}

.view-details-btn:hover {
  background-color: rgba(6, 105, 58, 0.2);
}

.view-details-btn i {
  font-size: 16px;
}

/* Mobile Cards */
.mobile-cards {
  display: none;
  padding: 15px;
}

.treatment-card {
  background-color: white;
  border-radius: 12px;
  border: 1px solid #e0e0e0;
  margin-bottom: 16px;
  overflow: hidden;
  cursor: pointer;
  transition: transform 0.2s, box-shadow 0.2s;
}

.treatment-card:hover {
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

.card-footer {
  padding: 12px 16px;
  border-top: 1px solid #f5f5f5;
  display: flex;
  justify-content: flex-end;
  gap: 8px;
}

.action-button-mobile {
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
  transition: background-color 0.2s;
}

.action-button-mobile:hover {
  background-color: #055a32;
}

.action-button-mobile i {
  font-size: 14px;
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
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.6);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
  backdrop-filter: blur(3px);
}

.modal-content {
  background: white;
  width: 90%;
  max-width: 800px;
  border-radius: 12px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
  overflow: hidden;
  animation: modalFadeIn 0.3s ease;
}

@keyframes modalFadeIn {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
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

.modal-body {
  padding: 25px;
  max-height: 70vh;
  overflow-y: auto;
}

.details-info {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.details-row {
  display: flex;
  flex-direction: column;
  gap: 5px;
}

.details-label {
  font-weight: 600;
  color: #06693A;
  font-size: 14px;
}

.details-notes {
  background-color: #f9f9f9;
  padding: 15px;
  border-radius: 8px;
  color: #555;
  line-height: 1.5;
  margin: 0;
}

/* Responsive Design */

/* Large Desktop */
@media (min-width: 1400px) {
.treatment-container {
  margin: 30px;
}

.treatment-card {
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

.treatment-table th,
.treatment-table td {
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

.treatment-container {
  margin: 15px;
}

.treatment h3 {
  font-size: 16px;
}

.modal-content {
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

.treatment-container {
  margin: 10px;
}

.treatment h3 {
  font-size: 16px;
  padding: 15px 0 10px 0;
}

.treatment-card {
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

.card-content {
  padding: 12px 15px;
}

.card-row {
  margin-bottom: 10px;
}

.card-label {
  font-size: 13px;
}

.modal-content {
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

.treatment-container {
  margin: 8px;
}

.treatment h3 {
  font-size: 14px;
  padding: 12px 0 8px 0;
}

.treatment-card {
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

.modal-content {
  width: 95%;
  border-radius: 10px;
}

.modal-header {
  padding: 10px 12px;
}

.modal-header h3 {
  font-size: 14px;
}

.close-btn {
  font-size: 1.2em;
}

.modal-body {
  padding: 12px;
}
}

/* Landscape Mobile */
@media (max-height: 500px) and (orientation: landscape) {
.modal-content {
  max-height: 95vh;
}

.modal-body {
  max-height: calc(95vh - 60px);
  overflow-y: auto;
}

.treatment-card {
  margin-bottom: 8px;
}
}
</style>