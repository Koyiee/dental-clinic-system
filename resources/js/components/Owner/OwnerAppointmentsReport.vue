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
        <i class="bx bx-menu" @click="toggleSidebar"></i>
        <div class="text">
          <h3>Appointments Report</h3>
          <div class="breadcrumbs">
            <a class="none" href=""><p>Home / </p></a>
            <a class="current" href="/ownerappointmentsreport"><p>Appointments Report</p></a>
          </div>
        </div>
      </div>
      <hr color="#06693a">
  
      <!-- Date Range Filter -->
      <div class="filter-container">
        <div class="filter-section">
          <div class="date-range">
            <div class="date-input">
              <label>From:</label>
              <input type="date" v-model="filters.startDate" @change="applyFilters">
            </div>
            <div class="date-input">
              <label>To:</label>
              <input type="date" v-model="filters.endDate" @change="applyFilters">
            </div>
          </div>
        </div>
        
        <div class="filter-section">
          <div class="filter-options">
            <div class="filter-select">
              <label>Status:</label>
              <select v-model="filters.status" @change="applyFilters">
                <option value="">All Statuses</option>
                <option value="Confirmed">Confirmed</option>
                <option value="Completed">Completed</option>
                <option value="Pending">Pending</option>
                <option value="Cancelled">Cancelled</option>
                <option value="Declined">Declined</option>
              </select>
            </div>
            <div class="filter-select">
              <label>Service:</label>
              <select v-model="filters.service" @change="applyFilters">
                <option value="">All Services</option>
                <option v-for="service in services" :key="service.ServiceID" :value="service.ServiceID">
                  {{ service.ServiceName }}
                </option>
              </select>
            </div>
          </div>
        </div>
        
        <div class="filter-section">
          <div class="export-buttons">
            <button @click="exportToPDF" class="btn-export pdf">
              <i class='bx bxs-file-pdf'></i> <span class="btn-text">Export PDF</span>
            </button>
            <button @click="exportToCSV" class="btn-export csv">
              <i class='bx bxs-file-csv'></i> <span class="btn-text">Export CSV</span>
            </button>
          </div>
        </div>
      </div>
  
      <!-- Dashboard Stats -->
      <div class="calendar-stats">
        <div class="stat-card">
          <i class="bx bx-calendar-check"></i>
          <div class="stat-info">
            <h4>{{ stats.totalAppointments }}</h4>
            <p>Total Appointments</p>
          </div>
        </div>
        <div class="stat-card">
          <i class="bx bx-check-circle"></i>
          <div class="stat-info">
            <h4>{{ stats.completedAppointments }}</h4>
            <p>Completed</p>
          </div>
        </div>
        <div class="stat-card confirmed-card">
          <i class="bx bx-check-double"></i>
          <div class="stat-info">
            <h4>{{ stats.confirmedAppointments }}</h4>
            <p>Confirmed</p>
          </div>
        </div>
        <div class="stat-card pending-card">
          <i class="bx bx-time"></i>
          <div class="stat-info">
            <h4>{{ stats.pendingAppointments }}</h4>
            <p>Pending</p>
          </div>
        </div>
        <div class="stat-card">
          <i class="bx bx-x-circle"></i>
          <div class="stat-info">
            <h4>{{ stats.cancelledAppointments }}</h4>
            <p>Cancelled/Declined</p>
          </div>
        </div>
      </div>
  
      <!-- Charts Section -->
      <div class="charts-container">
        <div class="chart-card">
          <div class="chart-header">
            <h3>Monthly Appointments</h3>
            <div class="chart-actions">
              <select v-model="chartFilters.year" @change="updateCharts">
                <option v-for="year in availableYears" :key="year" :value="year">{{ year }}</option>
              </select>
            </div>
          </div>
          <div class="chart-body">
            <canvas id="monthlyAppointmentsChart"></canvas>
          </div>
        </div>
      </div>
  
      <div class="charts-container">
        <div class="chart-card">
          <div class="chart-header">
            <h3>Top Services</h3>
          </div>
          <div class="chart-body">
            <canvas id="topServicesChart"></canvas>
          </div>
        </div>
      </div>
  
      <!-- Detailed Appointments Table -->
      <div class="appointments-summary">
        <div class="summary-header">
          <h3>Detailed Appointment Data</h3>
          <div class="summary-actions">
            <div class="search-container">
              <input 
                type="text" 
                v-model="searchQuery" 
                placeholder="Search appointments..." 
                @input="applyFilters"
              >
              <i class='bx bx-search'></i>
            </div>
          </div>
        </div>
        
        <!-- Status Tabs -->
        <div class="status-tabs">
          <button 
            v-for="status in ['All', 'Confirmed', 'Completed', 'Pending', 'Declined', 'Cancelled']" 
            :key="status"
            :class="['status-tab', { active: selectedStatusTab === status }]"
            @click="selectedStatusTab = status"
          >
            {{ status }}
            <span class="status-count">{{ getAppointmentCountByStatus(status) }}</span>
          </button>
        </div>
        
        <!-- Desktop Table -->
        <div class="summary-table-container desktop-table">
          <table class="summary-table">
            <thead>
              <tr>
                <th @click="sortTable('AppointmentDate')">
                  Date & Time
                  <i class='bx' :class="getSortIconClass('AppointmentDate')"></i>
                </th>
                <th @click="sortTable('PatientName')">
                  Patient
                  <i class='bx' :class="getSortIconClass('PatientName')"></i>
                </th>
                <th @click="sortTable('Services')">
                  Services
                  <i class='bx' :class="getSortIconClass('Services')"></i>
                </th>
                <th @click="sortTable('DentistName')">
                  Dentist
                  <i class='bx' :class="getSortIconClass('DentistName')"></i>
                </th>
                <th @click="sortTable('Status')">
                  Status
                  <i class='bx' :class="getSortIconClass('Status')"></i>
                </th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-if="filteredAppointments.length === 0">
                <td colspan="6" class="no-appointments">No appointments found matching your criteria</td>
              </tr>
              <tr v-for="appointment in paginatedAppointments" :key="appointment.AppointmentID" class="appointment-row">
                <td>
                  <div class="appointment-date">{{ formatDate(appointment.AppointmentDate) }}</div>
                  <div class="appointment-time">{{ formatTime(appointment.AppointmentTime) }}</div>
                </td>
                <td>{{ appointment.PatientName }}</td>
                <td>
                  <div class="services-list">
                    <span v-for="(service, index) in appointment.Services" :key="index" class="service-tag">
                      {{ service }}
                    </span>
                    <span v-if="!appointment.Services || appointment.Services.length === 0">No services</span>
                  </div>
                </td>
                <td>{{ appointment.DentistName || 'Unassigned' }}</td>
                <td>
                  <span class="status-badge" :class="getStatusClass(appointment.Status)">
                    {{ appointment.Status }}
                  </span>
                </td>
                <td>
                  <button class="btn-view" @click="viewAppointmentDetails(appointment)">
                    <i class="bx bx-show"></i>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Mobile Cards -->
        <div class="mobile-cards">
          <div 
            v-for="appointment in paginatedAppointments" 
            :key="appointment.AppointmentID"
            class="appointment-card"
            @click="viewAppointmentDetails(appointment)"
          >
            <div class="card-header-mobile">
              <div class="appointment-info">
                <h4>{{ appointment.PatientName }}</h4>
                <div class="appointment-datetime">
                  <span class="date">{{ formatDate(appointment.AppointmentDate) }}</span>
                  <span class="time">{{ formatTime(appointment.AppointmentTime) }}</span>
                </div>
              </div>
              <span class="status-badge" :class="getStatusClass(appointment.Status)">
                {{ appointment.Status }}
              </span>
            </div>
            <div class="card-content-mobile">
              <div class="card-row">
                <span class="card-label">Services:</span>
                <div class="services-list-mobile">
                  <span v-for="(service, index) in appointment.Services" :key="index" class="service-tag-mobile">
                    {{ service }}
                  </span>
                  <span v-if="!appointment.Services || appointment.Services.length === 0" class="no-services-mobile">No services</span>
                </div>
              </div>
              <div class="card-row">
                <span class="card-label">Dentist:</span>
                <span class="card-value">{{ appointment.DentistName || 'Unassigned' }}</span>
              </div>
            </div>
          </div>
          <div v-if="filteredAppointments.length === 0" class="no-data-mobile">
            No appointments found matching your criteria
          </div>
        </div>
        
        <!-- Pagination -->
        <div class="pagination-controls">
          <div class="pagination-info">
            Showing {{ paginationStart }} to {{ paginationEnd }} of {{ filteredAppointments.length }} entries
          </div>
          <div class="pagination-buttons">
            <button 
              class="pagination-btn" 
              @click="currentPage = Math.max(1, currentPage - 1)"
              :disabled="currentPage === 1"
            >
              <i class="bx bx-chevron-left"></i> <span class="btn-text">Previous</span>
            </button>
            <button 
              class="pagination-btn" 
              @click="currentPage++"
              :disabled="currentPage === totalPages"
            >
              <span class="btn-text">Next</span> <i class="bx bx-chevron-right"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Appointment Details Modal -->
    <div v-if="showModal" class="modal-overlay" @click="closeModal">
      <div class="modal-container" @click.stop>
        <div class="modal-header">
          <h3>Appointment Details</h3>
          <button class="modal-close" @click="closeModal">
            <i class="bx bx-x"></i>
          </button>
        </div>
        
        <div class="modal-body">
          <div class="modal-section">
            <div class="appointment-status-banner" :class="getStatusClass(selectedAppointment.Status)">
              <i class="bx bx-check-circle"></i>
              {{ selectedAppointment.Status }}
            </div>
          </div>
          
          <div class="modal-section">
            <h4 class="section-title">
              <i class="bx bx-time"></i> Date & Time
            </h4>
            <div class="detail-row">
              <div class="detail-item">
                <span class="detail-label">Date:</span>
                <span class="detail-value">{{ formatDate(selectedAppointment.AppointmentDate) }}</span>
              </div>
              <div class="detail-item">
                <span class="detail-label">Time:</span>
                <span class="detail-value">{{ formatTime(selectedAppointment.AppointmentTime) }}</span>
              </div>
            </div>
          </div>
          
          <div class="modal-section">
            <h4 class="section-title">
              <i class="bx bx-user"></i> Patient Information
            </h4>
            <div class="detail-row">
              <div class="detail-item">
                <span class="detail-label">Name:</span>
                <span class="detail-value">{{ selectedAppointment.PatientName }}</span>
              </div>
            </div>
          </div>
          
          <!-- Services Section -->
          <div class="modal-section">
            <h4 class="section-title">
              <i class="bx bx-clipboard"></i> Services
            </h4>
            <div v-if="selectedAppointment.Services && selectedAppointment.Services.length > 0">
              <div v-for="(service, index) in selectedAppointment.Services" :key="index" class="service-detail">
                <div class="service-header">
                  <div class="service-name">{{ service }}</div>
                </div>
              </div>
            </div>
            <div v-else class="no-services">No services available</div>
          </div>
          
          <!-- Dentist Assignment Section -->
          <div class="modal-section">
            <h4 class="section-title">
              <i class="bx bx-user-pin"></i> Dentist Assignment
            </h4>
            <div class="detail-row">
              <div class="detail-item">
                <span class="detail-label">Assigned Dentist:</span>
                <span class="detail-value">{{ selectedAppointment.DentistName || 'Unassigned' }}</span>
              </div>
            </div>
          </div>
        </div>
        
        <div class="modal-footer">
          <button class="btn-secondary" @click="closeModal">Close</button>
        </div>
      </div>
    </div>
  </section>
</template>
  
<script>
import axios from 'axios';
import Chart from 'chart.js/auto';
import { jsPDF } from 'jspdf';
import autoTable from 'jspdf-autotable';
import logoImg from '@/components/Images/ATDC_logo.png';
import Swal from 'sweetalert2';

export default {
  name: "OwnerAppointmentsReport",
  props: {
    firstName: { type: String, required: true },
    lastName: { type: String, required: true },
  },
  data() {
    return {
      appointments: [],
      filteredAppointments: [],
      services: [],
      charts: {
        monthlyAppointments: null,
        topServices: null
      },
      filters: {
        startDate: this.getFirstDayOfMonth(),
        endDate: this.getLastDayOfMonth(),
        status: '',
        service: ''
      },
      chartFilters: {
        year: new Date().getFullYear()
      },
      searchQuery: '',
      sortConfig: { key: 'AppointmentDate', direction: 'desc' },
      currentPage: 1,
      itemsPerPage: 10,
      stats: {
        totalAppointments: 0,
        completedAppointments: 0,
        confirmedAppointments: 0,
        pendingAppointments: 0,
        cancelledAppointments: 0
      },
      selectedStatusTab: 'All',
      showModal: false,
      selectedAppointment: {},
      isSidebarClosed: true,
    };
  },
  computed: {
    fullName() {
      return `${this.firstName} ${this.lastName}`;
    },
    paginatedAppointments() {
      const start = (this.currentPage - 1) * this.itemsPerPage;
      const end = start + this.itemsPerPage;
      return this.filteredAppointments.slice(start, end);
    },
    totalPages() {
      return Math.ceil(this.filteredAppointments.length / this.itemsPerPage);
    },
    paginationStart() {
      return this.filteredAppointments.length === 0 ? 0 : (this.currentPage - 1) * this.itemsPerPage + 1;
    },
    paginationEnd() {
      return Math.min(this.currentPage * this.itemsPerPage, this.filteredAppointments.length);
    },
    availableYears() {
      const currentYear = new Date().getFullYear();
      const years = [];
      for (let i = currentYear - 2; i <= currentYear; i++) {
        years.push(i);
      }
      return years;
    }
  },
  watch: {
    selectedStatusTab() {
      this.applyFilters();
      this.currentPage = 1;
    }
  },
  mounted() {
    this.setupSidebar();
    this.fetchAppointments();
    this.fetchServices();
    document.addEventListener('keydown', this.handleKeyDown);
  },
  beforeUnmount() {
    document.removeEventListener('keydown', this.handleKeyDown);
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
    toggleSidebar() {
      this.isSidebarClosed = !this.isSidebarClosed;
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
    async fetchAppointments() {
      try {
        const response = await axios.get('/hr/appointments/calendar');
        console.log('API Response:', response.data);
        
        this.appointments = response.data.map(appointment => {
          const services = appointment.services || [];
          return {
            AppointmentID: appointment.AppointmentID,
            AppointmentDate: appointment.AppointmentDate,
            AppointmentTime: appointment.AppointmentTime,
            PatientName: appointment.patient_name || 'Unknown',
            DentistName: appointment.dentist_name || 'Unassigned',
            UserID: appointment.UserID,
            Status: appointment.AppointmentStatus || 'Pending',
            Services: services.map(s => s.ServiceName || 'Unknown Service'),
            ServiceIDs: services.map(s => s.ServiceID || null)
          };
        });
        
        this.applyFilters();
        this.updateCharts();
        this.calculateStats();
      } catch (error) {
        console.error("Error fetching appointments:", error.response?.data || error.message);
        this.appointments = [];
        this.filteredAppointments = [];
      }
    },
    async fetchServices() {
      try {
        const response = await axios.get('/services/list');
        this.services = response.data;
      } catch (error) {
        console.error("Error fetching services:", error);
        this.services = [];
      }
    },
    applyFilters() {
      let filtered = [...this.appointments];
      
      if (this.filters.startDate) {
        filtered = filtered.filter(app => new Date(app.AppointmentDate) >= new Date(this.filters.startDate));
      }
      if (this.filters.endDate) {
        filtered = filtered.filter(app => new Date(app.AppointmentDate) <= new Date(this.filters.endDate));
      }
      
      if (this.filters.status) {
        filtered = filtered.filter(app => app.Status === this.filters.status);
      }
      
      if (this.filters.service) {
        filtered = filtered.filter(app => {
          if (!app.ServiceIDs) return false;
          return app.ServiceIDs.includes(parseInt(this.filters.service));
        });
      }
      
      if (this.searchQuery) {
        const query = this.searchQuery.toLowerCase();
        filtered = filtered.filter(app => 
          (app.PatientName && app.PatientName.toLowerCase().includes(query)) ||
          (app.DentistName && app.DentistName.toLowerCase().includes(query)) ||
          (app.Status && app.Status.toLowerCase().includes(query)) ||
          (app.Services && app.Services.some(service => service.toLowerCase().includes(query)))
        );
      }
      
      if (this.selectedStatusTab !== 'All') {
        filtered = filtered.filter(app => app.Status === this.selectedStatusTab);
      }
      
      this.applySorting(filtered);
      
      this.filteredAppointments = filtered;
      this.calculateStats();
    },
    applySorting(data) {
      const { key, direction } = this.sortConfig;
      
      data.sort((a, b) => {
        let valueA = a[key];
        let valueB = b[key];
        
        if (Array.isArray(valueA)) valueA = valueA.join(', ');
        if (Array.isArray(valueB)) valueB = valueB.join(', ');
        
        valueA = valueA || '';
        valueB = valueB || '';
        
        if (key === 'AppointmentDate') {
          valueA = new Date(valueA);
          valueB = new Date(valueB);
          return direction === 'asc' ? valueA - valueB : valueB - valueA;
        }
        
        if (key === 'AppointmentTime') {
          const timeA = this.convertTimeToMinutes(valueA);
          const timeB = this.convertTimeToMinutes(valueB);
          return direction === 'asc' ? timeA - timeB : timeB - timeA;
        }
        
        if (typeof valueA === 'string' && typeof valueB === 'string') {
          return direction === 'asc' ? valueA.localeCompare(valueB) : valueB.localeCompare(valueA);
        }
        
        return direction === 'asc' ? (valueA > valueB ? 1 : -1) : (valueA < valueB ? 1 : -1);
      });
      
      return data;
    },
    sortTable(key) {
      if (this.sortConfig.key === key) {
        this.sortConfig.direction = this.sortConfig.direction === 'asc' ? 'desc' : 'asc';
      } else {
        this.sortConfig.key = key;
        this.sortConfig.direction = 'asc';
      }
      
      this.applyFilters();
    },
    getSortIconClass(key) {
      if (this.sortConfig.key !== key) return '';
      return this.sortConfig.direction === 'asc' ? 'bx-up-arrow-alt' : 'bx-down-arrow-alt';
    },
    convertTimeToMinutes(timeString) {
      if (!timeString) return 0;
      const [hours, minutes] = timeString.split(':').map(Number);
      return hours * 60 + minutes;
    },
    formatDate(dateString) {
      if (!dateString) return 'N/A';
      const date = new Date(dateString);
      return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
    },
    formatTime(timeString) {
      if (!timeString) return 'N/A';
      const [hours, minutes] = timeString.split(':');
      const hour = parseInt(hours, 10);
      const ampm = hour >= 12 ? 'PM' : 'AM';
      const hour12 = hour % 12 || 12;
      return `${hour12}:${minutes} ${ampm}`;
    },
    getStatusClass(status) {
      if (!status) return "status-pending";
      switch (status.toLowerCase()) {
        case "completed": return "status-completed";
        case "confirmed": return "status-confirmed";
        case "pending": return "status-pending";
        case "declined": return "status-declined";
        case "cancelled": return "status-cancelled";
        default: return "status-pending";
      }
    },
    getFirstDayOfMonth() {
      const date = new Date();
      return new Date(date.getFullYear(), date.getMonth(), 1).toISOString().split('T')[0];
    },
    getLastDayOfMonth() {
      const date = new Date();
      return new Date(date.getFullYear(), date.getMonth() + 1, 0).toISOString().split('T')[0];
    },
    calculateStats() {
      // Only count appointments that are not Cancelled or Declined
      this.stats.totalAppointments = this.filteredAppointments.filter(app => 
        app.Status !== 'Cancelled' && app.Status !== 'Declined'
      ).length;
      this.stats.completedAppointments = this.filteredAppointments.filter(app => app.Status === 'Completed').length;
      this.stats.confirmedAppointments = this.filteredAppointments.filter(app => app.Status === 'Confirmed').length;
      this.stats.pendingAppointments = this.filteredAppointments.filter(app => app.Status === 'Pending').length;
      this.stats.cancelledAppointments = this.filteredAppointments.filter(app => 
        app.Status === 'Cancelled' || app.Status === 'Declined'
      ).length;
    },
    exportToPDF() {
      const doc = new jsPDF();
      const pageWidth = doc.internal.pageSize.getWidth();
      const pageHeight = doc.internal.pageSize.getHeight();
      const margin = 14;
      const primaryColor = [6, 105, 58];

      // Add clinic logo
      const logoHeight = 20;
      const logoWidth = 20;
      const logoX = margin;
      const logoY = margin;

      doc.addImage(logoImg, 'PNG', logoX, logoY, logoWidth, logoHeight);

      doc.setTextColor(...primaryColor);
      doc.setFontSize(18);
      doc.setFont(undefined, 'bold');
      doc.text('AGUILA-TITULAR DENTAL CLINIC', logoX + logoWidth + 10, logoY + 8);

      doc.setFontSize(14);
      doc.text('APPOINTMENTS REPORT', logoX + logoWidth + 10, logoY + 16);

      doc.setFontSize(10);
      doc.setTextColor(100);
      doc.setFont(undefined, 'normal');
      doc.text(`Date Range: ${this.formatDate(this.filters.startDate)} to ${this.formatDate(this.filters.endDate)}`, margin, logoY + logoHeight + 10);

      const now = new Date();
      const formattedDate = now.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
      const formattedTime = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
      doc.text(`Generated on: ${formattedDate} at ${formattedTime}`, margin, logoY + logoHeight + 18);

      doc.setDrawColor(...primaryColor);
      doc.setLineWidth(0.5);
      doc.line(margin, logoY + logoHeight + 22, pageWidth - margin, logoY + logoHeight + 22);

      let yPos = logoY + logoHeight + 30;

      doc.setFontSize(12);
      doc.setTextColor(...primaryColor);
      doc.setFont(undefined, 'bold');
      doc.text('SUMMARY STATISTICS', margin, yPos);
      yPos += 8;

      doc.setFontSize(10);
      doc.setTextColor(80);
      doc.setFont(undefined, 'normal');

      const statsData = [
        ['Total Appointments', this.stats.totalAppointments],
        ['Completed', this.stats.completedAppointments],
        ['Confirmed', this.stats.confirmedAppointments],
        ['Pending', this.stats.pendingAppointments],
        ['Cancelled/Declined', this.stats.cancelledAppointments]
      ];

      autoTable(doc, {
        startY: yPos,
        head: [['Status', 'Count']],
        body: statsData,
        theme: 'grid',
        headStyles: { 
          fillColor: primaryColor,
          textColor: [255, 255, 255],
          fontStyle: 'bold'
        },
        styles: {
          fontSize: 9,
          cellPadding: 3
        },
        columnStyles: {
          0: { cellWidth: 80 },
          1: { cellWidth: 30, halign: 'center' }
        },
        margin: { left: margin }
      });

      yPos = doc.lastAutoTable.finalY + 15;

      doc.setFontSize(12);
      doc.setTextColor(...primaryColor);
      doc.setFont(undefined, 'bold');
      doc.text('DETAILED APPOINTMENT DATA', margin, yPos);
      yPos += 8;

      const tableColumn = ["Appointment ID", "Date", "Time", "Patient Name", "Services", "Dentist", "Status"];
      const tableRows = [];

      this.filteredAppointments.forEach(appointment => {
        const date = new Date(appointment.AppointmentDate);
        const formattedDate = `${date.toLocaleDateString('en-US', { month: 'short', day: '2-digit' })} ${date.getFullYear()}`;
        const [hours, minutes] = appointment.AppointmentTime.split(':');
        const hour = parseInt(hours, 10);
        const ampm = hour >= 12 ? 'PM' : 'AM';
        const hour12 = hour % 12 || 12;
        const formattedTime = `${hour12}:${minutes} ${ampm}`;
        const services = appointment.Services && appointment.Services.length > 0 
          ? appointment.Services.join(' | ') 
          : 'None';

        const rowData = [
          appointment.AppointmentID,
          formattedDate,
          formattedTime,
          appointment.PatientName,
          services,
          appointment.DentistName || 'Unassigned',
          appointment.Status
        ];
        tableRows.push(rowData);
      });

      autoTable(doc, {
        startY: yPos,
        head: [tableColumn],
        body: tableRows,
        theme: 'grid',
        headStyles: { 
          fillColor: primaryColor,
          textColor: [255, 255, 255],
          fontStyle: 'bold'
        },
        styles: {
          fontSize: 8,
          cellPadding: 2,
          overflow: 'linebreak'
        },
        columnStyles: {
          0: { cellWidth: 25 },
          1: { cellWidth: 25 },
          2: { cellWidth: 20 },
          4: { cellWidth: 'auto' }
        },
        margin: { left: margin, right: margin },
        didDrawPage: function(data) {
          if (data.pageNumber > 1) {
            doc.setFillColor(...primaryColor);
            doc.rect(margin, margin, 10, 10, 'F');
            doc.setTextColor(255, 255, 255);
            doc.setFontSize(8);
            doc.text('ATDC', margin + 5, margin + 5, { align: 'center', baseline: 'middle' });
            
            doc.setTextColor(...primaryColor);
            doc.setFontSize(10);
            doc.setFont(undefined, 'bold');
            doc.text('AGUILA-TITULAR DENTAL CLINIC - APPOINTMENTS REPORT', margin + 15, margin + 6);
          }
          
          doc.setFontSize(8);
          doc.setTextColor(100);
          doc.setFont(undefined, 'normal');
          doc.text(`Page ${data.pageNumber} of`, pageWidth - 40, pageHeight - 10);
          doc.text('Aguila-Titular Dental Clinic - All Rights Reserved', margin, pageHeight - 10);
        }
      });

      const totalPages = doc.internal.getNumberOfPages();
      for (let i = 1; i <= totalPages; i++) {
        doc.setFontSize(8);
        doc.setTextColor(100);
        doc.setFont(undefined, 'normal');
        doc.setPage(i);
        doc.text(`${totalPages}`, pageWidth - 27, pageHeight - 10);
      }

      const fileDate = now.toISOString().split('T')[0];
      const fileTime = now.toTimeString().split(' ')[0].replace(/:/g, '-');
      doc.save(`ATDC_Appointment_Report_${fileDate}_${fileTime}.pdf`);
    },
    updateCharts() {
      this.createMonthlyAppointmentsChart();
      this.createTopServicesChart();
    },
    createMonthlyAppointmentsChart() {
      const ctx = document.getElementById('monthlyAppointmentsChart');
      if (!ctx) return;
      
      if (this.charts.monthlyAppointments) {
        this.charts.monthlyAppointments.destroy();
      }
      
      const monthlyData = this.getMonthlyAppointmentsData();
      
      this.charts.monthlyAppointments = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
          datasets: [
            {
              label: 'Completed',
              data: monthlyData.completed,
              backgroundColor: '#28a745',
              borderColor: '#28a745',
              borderWidth: 1
            },
            {
              label: 'Confirmed',
              data: monthlyData.confirmed,
              backgroundColor: '#007bff',
              borderColor: '#007bff',
              borderWidth: 1
            },
            {
              label: 'Pending',
              data: monthlyData.pending,
              backgroundColor: '#6c757d',
              borderColor: '#6c757d',
              borderWidth: 1
            },
            {
              label: 'Cancelled/Declined',
              data: monthlyData.cancelled,
              backgroundColor: '#dc3545',
              borderColor: '#dc3545',
              borderWidth: 1
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: 'top',
            },
            title: {
              display: false
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              title: {
                display: true,
                text: 'Number of Appointments'
              }
            }
          }
        }
      });
    },
    createTopServicesChart() {
      const ctx = document.getElementById('topServicesChart');
      if (!ctx) return;
      
      if (this.charts.topServices) {
        this.charts.topServices.destroy();
      }
      
      const serviceData = this.getTopServicesData();
      
      this.charts.topServices = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: serviceData.labels,
          datasets: [{
            label: 'Number of Appointments',
            data: serviceData.data,
            backgroundColor: '#06693a',
            borderColor: '#06693a',
            borderWidth: 1
          }]
        },
        options: {
          indexAxis: 'y',
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false
            }
          },
          scales: {
            x: {
              beginAtZero: true,
              title: {
                display: true,
                text: 'Number of Appointments'
              }
            }
          }
        }
      });
    },
    getMonthlyAppointmentsData() {
      const year = this.chartFilters.year;
      const months = Array(12).fill(0).map(() => ({
        completed: 0,
        confirmed: 0,
        pending: 0,
        cancelled: 0
      }));
       
      this.appointments.forEach(app => {
        const date = new Date(app.AppointmentDate);
        if (date.getFullYear() === parseInt(year)) {
          const month = date.getMonth();
          
          if (app.Status === 'Completed') {
            months[month].completed++;
          } else if (app.Status === 'Confirmed') {
            months[month].confirmed++;
          } else if (app.Status === 'Pending') {
            months[month].pending++;
          } else if (app.Status === 'Cancelled' || app.Status === 'Declined') {
            months[month].cancelled++;
          }
        }
      });
      
      return {
        completed: months.map(m => m.completed),
        confirmed: months.map(m => m.confirmed),
        pending: months.map(m => m.pending),
        cancelled: months.map(m => m.cancelled)
      };
    },
    getTopServicesData() {
      const serviceCounts = {};
      
      this.appointments.forEach(app => {
        if (app.Services && Array.isArray(app.Services)) {
          app.Services.forEach(service => {
            if (!serviceCounts[service]) {
              serviceCounts[service] = 0;
            }
            serviceCounts[service]++;
          });
        }
      });
      
      const sortedServices = Object.entries(serviceCounts)
        .sort((a, b) => b[1] - a[1])
        .slice(0, 10);
      
      return {
        labels: sortedServices.map(s => s[0]),
        data: sortedServices.map(s => s[1])
      };
    },
    getAppointmentCountByStatus(status) {
      if (status === 'All') return this.appointments.length;
      return this.appointments.filter(appointment => appointment.Status === status).length;
    },
    viewAppointmentDetails(appointment) {
      this.selectedAppointment = { ...appointment };
      this.showModal = true;
      document.body.style.overflow = 'hidden';
    },
    closeModal() {
      this.showModal = false;
      document.body.style.overflow = 'auto';
    },
    handleKeyDown(e) {
      if (e.key === 'Escape' && this.showModal) this.closeModal();
    },
    exportToCSV() {
      const now = new Date();
      const formattedDate = now.toLocaleDateString('en-US', { 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric' 
      });
      const formattedTime = now.toLocaleTimeString('en-US', { 
        hour: '2-digit', 
        minute: '2-digit', 
        hour12: true 
      });
      
      let csvContent = 'AGUILA-TITULAR DENTAL CLINIC\r\n';
      csvContent += 'APPOINTMENTS REPORT\r\n';
      csvContent += `Generated on: ${formattedDate} at ${formattedTime}\r\n`;
      csvContent += `Date Range: ${this.formatDate(this.filters.startDate)} to ${this.formatDate(this.filters.endDate)}\r\n\r\n`;
      
      csvContent += 'SUMMARY STATISTICS\r\n';
      csvContent += `Total Appointments,${this.stats.totalAppointments}\r\n`;
      csvContent += `Completed,${this.stats.completedAppointments}\r\n`;
      csvContent += `Confirmed,${this.stats.confirmedAppointments}\r\n`;
      csvContent += `Pending,${this.stats.pendingAppointments}\r\n`;
      csvContent += `Cancelled/Declined,${this.stats.cancelledAppointments}\r\n\r\n`;
      
      csvContent += 'DETAILED APPOINTMENT DATA\r\n';
      const headers = ['Appointment ID', 'Date', 'Time', 'Patient Name', 'Services', 'Dentist', 'Status'];
      csvContent += headers.join(',') + '\r\n';
      
      this.filteredAppointments.forEach(appointment => {
        const date = new Date(appointment.AppointmentDate);
        const formattedDate = `${date.toLocaleDateString('en-US', { month: 'short', day: '2-digit' })} ${date.getFullYear()}`;
        const [hours, minutes] = appointment.AppointmentTime.split(':');
        const hour = parseInt(hours, 10);
        const ampm = hour >= 12 ? 'PM' : 'AM';
        const hour12 = hour % 12 || 12;
        const formattedTime = `${hour12}:${minutes} ${ampm}`;
        const services = appointment.Services && appointment.Services.length > 0 
          ? appointment.Services.join(' | ') 
          : 'None';
        
        const rowData = [
          appointment.AppointmentID,
          formattedDate,
          formattedTime,
          appointment.PatientName,
          services,
          appointment.DentistName || 'Unassigned',
          appointment.Status
        ];
        csvContent += rowData.join(',') + '\r\n';
      });
      
      csvContent += '\r\nEnd of Report';
      csvContent += '\r\nAguila-Titular Dental Clinic - All Rights Reserved';
      
      const encodedUri = encodeURI('data:text/csv;charset=utf-8,' + csvContent);
      const link = document.createElement('a');
      link.setAttribute('href', encodedUri);
      
      const fileDate = now.toISOString().split('T')[0];
      const fileTime = now.toTimeString().split(' ')[0].replace(/:/g, '-');
      link.setAttribute('download', `ATDC_Appointment_Report_${fileDate}_${fileTime}.csv`);
      
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
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
  padding-bottom: 5px;
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
  
.sidebar .profile-details .profile_name {
  color: #06693A;
  font-size: 16px;
  font-weight: 500;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
  
/* Filter Container */
.filter-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  align-items: flex-start;
  background: white;
  margin: 20px;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
  gap: 20px;
}

.filter-section {
  display: flex;
  flex-direction: column;
  gap: 10px;
}
  
.date-range {
  display: flex;
  gap: 15px;
}
  
.date-input {
  display: flex;
  flex-direction: column;
  gap: 5px;
}
  
.date-input label {
  font-size: 14px;
  font-weight: 500;
  color: #555;
}
  
.date-input input {
  padding: 8px 12px;
  border: 1px solid #ddd;
  border-radius: 6px;
  font-size: 14px;
}
  
.filter-options {
  display: flex;
  gap: 15px;
}
  
.filter-select {
  display: flex;
  flex-direction: column;
  gap: 5px;
}
  
.filter-select label {
  font-size: 14px;
  font-weight: 500;
  color: #555;
}
  
.filter-select select {
  padding: 8px 12px;
  border: 1px solid #ddd;
  border-radius: 6px;
  font-size: 14px;
  min-width: 150px;
}
  
.export-buttons {
  display: flex;
  gap: 10px;
}
  
.btn-export {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 10px 15px;
  border: none;
  border-radius: 6px;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s ease;
}
  
.btn-export.pdf {
  background-color: #dc3545;
  color: white;
}
  
.btn-export.pdf:hover {
  background-color: #c82333;
}
  
.btn-export.csv {
  background-color: #28a745;
  color: white;
}
  
.btn-export.csv:hover {
  background-color: #218838;
}
  
/* Stats Container */
.calendar-stats {
  display: flex;
  gap: 20px;
  margin: 20px;
  flex-wrap: wrap;
}
  
.stat-card {
  background: white;
  border-radius: 10px;
  padding: 20px;
  display: flex;
  align-items: center;
  gap: 15px;
  flex: 1;
  min-width: 180px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
  transition: transform 0.2s, box-shadow 0.2s;
}
  
.stat-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
}
  
.stat-card i {
  font-size: 2.5rem;
  color: #06693a;
  margin-right: 15px;
}
  
.stat-info h4 {
  font-size: 1.8rem;
  font-weight: 600;
  color: #06693a;
  margin: 0;
}
  
.stat-info p {
  margin: 5px 0 0;
  color: #666;
  font-size: 0.9rem;
}
  
/* Charts Container */
.charts-container {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  margin: 20px;
}
  
.chart-card {
  background: white;
  border-radius: 10px;
  padding: 20px;
  flex: 1;
  min-width: 300px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
}
  
.chart-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 15px;
}
  
.chart-header h3 {
  font-size: 18px;
  font-weight: 600;
  color: #06693A;
  margin: 0;
}
  
.chart-actions select {
  padding: 6px 10px;
  border: 1px solid #ddd;
  border-radius: 6px;
  font-size: 14px;
}
  
.chart-body {
  height: 300px;
  position: relative;
}
  
/* Appointments summary */
.appointments-summary {
  background: white;
  border-radius: 10px;
  padding: 20px;
  margin: 20px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
}
  
.summary-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 15px;
}
  
.summary-header h3 {
  color: #06693a;
  font-size: 1.2rem;
  font-weight: 600;
  margin: 0;
}
  
.search-container {
  position: relative;
}
  
.search-container input {
  padding: 8px 12px 8px 35px;
  border: 1px solid #ddd;
  border-radius: 6px;
  font-size: 14px;
  width: 250px;
}
  
.search-container i {
  position: absolute;
  left: 12px;
  top: 50%;
  transform: translateY(-50%);
  color: #666;
}
  
/* Status Tabs */
.status-tabs {
  display: flex;
  gap: 10px;
  margin-bottom: 15px;
  overflow-x: auto;
  padding-bottom: 5px;
}
  
.status-tab {
  background: #f0f0f0;
  border: none;
  border-radius: 20px;
  padding: 8px 16px;
  font-size: 14px;
  font-weight: 500;
  color: #555;
  cursor: pointer;
  transition: all 0.2s ease;
  white-space: nowrap;
  display: flex;
  align-items: center;
  gap: 8px;
}
  
.status-tab:hover {
  background-color: rgba(6, 105, 58, 0.1);
}
  
.status-tab.active {
  background-color: #06693A;
  color: white;
}
  
.status-count {
  background: rgba(255, 255, 255, 0.3);
  border-radius: 12px;
  padding: 2px 8px;
  font-size: 12px;
  min-width: 24px;
  text-align: center;
}
  
.status-tab.active .status-count {
  background: rgba(255, 255, 255, 0.3);
}
  
.summary-table-container {
  overflow-x: auto;
}
  
.summary-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 0.9rem;
}
  
.summary-table th {
  background: #f0f8f4;
  color: #06693a;
  font-weight: 500;
  text-align: left;
  padding: 12px 15px;
  cursor: pointer;
  position: relative;
}
  
.summary-table th i {
  position: absolute;
  right: 10px;
  top: 50%;
  transform: translateY(-50%);
  font-size: 14px;
}
  
.summary-table td {
  padding: 12px 15px;
  border-bottom: 1px solid #eee;
  color: #444;
}
  
.summary-table tr:last-child td {
  border-bottom: none;
}
  
.summary-table tr:hover td {
  background: #f9fcfa;
}
  
.appointment-date {
  font-weight: 500;
  color: #333;
}
  
.appointment-time {
  font-size: 0.8rem;
  color: #666;
  margin-top: 3px;
}
  
.services-list {
  display: flex;
  flex-wrap: wrap;
  gap: 5px;
}
  
.service-tag {
  background: #f0f8f4;
  color: #06693a;
  padding: 3px 8px;
  border-radius: 4px;
  font-size: 0.75rem;
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
  transition: transform 0.2s, box-shadow 0.2s;
  cursor: pointer;
}

.appointment-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.card-header-mobile {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  padding: 16px;
  border-bottom: 1px solid #f0f0f0;
}

.appointment-info h4 {
  margin: 0 0 8px 0;
  font-size: 16px;
  font-weight: 600;
  color: #333;
}

.appointment-datetime {
  display: flex;
  flex-direction: column;
  gap: 2px;
}

.appointment-datetime .date {
  font-size: 14px;
  color: #666;
  font-weight: 500;
}

.appointment-datetime .time {
  font-size: 12px;
  color: #888;
}

.card-content-mobile {
  padding: 16px;
}

.card-row {
  margin-bottom: 12px;
  display: flex;
  flex-direction: column;
}

.card-row:last-child {
  margin-bottom: 0;
}

.card-label {
  font-weight: 500;
  color: #666;
  font-size: 14px;
  margin-bottom: 4px;
}

.card-value {
  color: #333;
  word-break: break-word;
}

.services-list-mobile {
  display: flex;
  flex-wrap: wrap;
  gap: 4px;
}

.service-tag-mobile {
  background: #f0f8f4;
  color: #06693a;
  padding: 2px 6px;
  border-radius: 4px;
  font-size: 0.7rem;
}

.no-services-mobile {
  color: #999;
  font-style: italic;
  font-size: 0.8rem;
}

.no-data-mobile {
  text-align: center;
  color: #757575;
  padding: 30px;
  background-color: white;
  border-radius: 12px;
  border: 1px solid #e0e0e0;
}
  
/* Status Badges */
.status-badge {
  display: inline-block;
  padding: 4px 10px;
  border-radius: 20px;
  font-size: 0.75rem;
  font-weight: 500;
}
  
.status-badge.status-completed { background-color: #28a745; color: white; }
.status-badge.status-confirmed { background-color: #007bff; color: white; }
.status-badge.status-pending { background-color: #6c757d; color: white; }
.status-badge.status-declined { background-color: #ff6b6b; color: white; }
.status-badge.status-cancelled { background-color: #dc3545; color: white; }
  
.no-appointments {
  text-align: center;
  color: #999;
  font-style: italic;
  padding: 30px;
}
  
/* Appointment row styles */
.appointment-row {
  cursor: pointer;
  transition: background-color 0.2s;
}
  
.appointment-row:hover {
  background-color: #f0f8f4;
}
  
/* View button */
.btn-view {
  background: #f0f8f4;
  color: #06693a;
  border: none;
  border-radius: 50%;
  width: 32px;
  height: 32px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.2s;
}
  
.btn-view:hover {
  background: #06693a;
  color: white;
}
  
/* Pagination */
.pagination-controls {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 15px;
  padding-top: 15px;
  border-top: 1px solid #eee;
}
  
.pagination-info {
  color: #666;
  font-size: 14px;
}
  
.pagination-buttons {
  display: flex;
  gap: 10px;
}
  
.pagination-btn {
  background: #f0f0f0;
  border: none;
  border-radius: 5px;
  padding: 8px 16px;
  font-size: 14px;
  font-weight: 500;
  color: #555;
  cursor: pointer;
  transition: all 0.2s ease;
  display: flex;
  align-items: center;
  gap: 5px;
}
  
.pagination-btn:hover:not(:disabled) {
  background-color: rgba(6, 105, 58, 0.1);
  color: #06693A;
}
  
.pagination-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}
  
/* Modal styles */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
  backdrop-filter: blur(3px);
}
  
.modal-container {
  background-color: white;
  border-radius: 10px;
  width: 90%;
  max-width: 600px;
  max-height: 90vh;
  overflow-y: auto;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
  display: flex;
  flex-direction: column;
}
  
.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px 20px;
  border-bottom: 1px solid #eee;
}
  
.modal-header h3 {
  margin: 0;
  color: #06693a;
  font-size: 1.3rem;
}
  
.modal-close {
  background: none;
  border: none;
  font-size: 1.5rem;
  color: #666;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 5px;
  border-radius: 50%;
  transition: background 0.2s;
}
  
.modal-close:hover {
  background: #f0f0f0;
  color: #333;
}
  
.modal-body {
  padding: 20px;
  overflow-y: auto;
}
  
.modal-section {
  margin-bottom: 20px;
  padding-bottom: 15px;
  border-bottom: 1px solid #eee;
}
  
.modal-section:last-child {
  border-bottom: none;
  margin-bottom: 0;
  padding-bottom: 0;
}
  
.section-title {
  display: flex;
  align-items: center;
  gap: 8px;
  color: #06693a;
  font-size: 1.1rem;
  margin-bottom: 12px;
}
  
.section-title i {
  font-size: 1.2rem;
}
  
.detail-row {
  display: flex;
  flex-wrap: wrap;
  gap: 15px;
  margin-bottom: 10px;
}
  
.detail-item {
  flex: 1;
  min-width: 200px;
}
  
.detail-label {
  font-weight: 500;
  color: #666;
  display: block;
  margin-bottom: 3px;
  font-size: 0.9rem;
}
  
.detail-value {
  color: #333;
  font-size: 1rem;
}
  
.appointment-status-banner {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 12px 15px;
  border-radius: 8px;
  margin-bottom: 15px;
  font-weight: 500;
}
  
.appointment-status-banner.status-completed { background-color: #28a745; color: white; }
.appointment-status-banner.status-confirmed { background-color: #007bff; color: white; }
.appointment-status-banner.status-pending { background-color: #6c757d; color: white; }
.appointment-status-banner.status-declined { background-color: #ff6b6b; color: white; }
.appointment-status-banner.status-cancelled { background-color: #dc3545; color: white; }
  
.service-detail {
  background: #f9f9f9;
  border-radius: 6px;
  padding: 10px;
  margin-bottom: 8px;
}
  
.service-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
  
.service-name {
  font-weight: 500;
  color: #06693a;
}
  
.no-services {
  color: #999;
  font-style: italic;
  text-align: center;
  padding: 15px;
}
  
.modal-footer {
  display: flex;
  justify-content: flex-end;
  padding: 15px 20px;
  border-top: 1px solid #eee;
  gap: 10px;
}
  
.btn-secondary {
  background-color: #f0f0f0;
  color: #333;
  border: none;
  border-radius: 6px;
  padding: 8px 16px;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s;
}
  
.btn-secondary:hover {
  background-color: #e0e0e0;
}

/* Responsive Styles */

/* Large Desktop */
@media (min-width: 1400px) {
  .filter-container {
    margin: 30px;
  }

  .calendar-stats {
    margin: 30px;
  }

  .charts-container {
    margin: 30px;
  }

  .appointments-summary {
    margin: 30px;
  }
}

/* Desktop */
@media (max-width: 1200px) {
  .calendar-stats {
    flex-wrap: wrap;
  }
  
  .stat-card {
    flex: 1 1 calc(50% - 20px);
  }
  
  .chart-card {
    flex: 1 1 100%;
  }

  .filter-container {
    margin: 15px;
  }

  .calendar-stats {
    margin: 15px;
  }

  .charts-container {
    margin: 15px;
  }

  .appointments-summary {
    margin: 15px;
  }
}

/* Tablet */
@media (max-width: 992px) {
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

  .filter-container {
    flex-direction: column;
    gap: 20px;
    align-items: flex-start;
  }
  
  .date-range, .filter-options {
    width: 100%;
    flex-wrap: wrap;
  }
  
  .date-input, .filter-select {
    flex: 1 1 calc(50% - 10px);
    min-width: 150px;
  }
  
  .export-buttons {
    width: 100%;
    justify-content: flex-end;
  }
  
  .stat-card {
    flex: 1 1 100%;
  }
  
  .status-tabs {
    padding-bottom: 10px;
  }
  
  .status-tab {
    padding: 6px 12px;
    font-size: 13px;
  }
  
  .pagination-controls {
    flex-direction: column;
    gap: 10px;
    align-items: flex-start;
  }
  
  .search-container input {
    width: 100%;
  }
  
  .modal-container {
    width: 95%;
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

  .filter-container {
    margin: 10px;
    padding: 15px;
  }

  .date-input, .filter-select {
    flex: 1 1 100%;
  }
  
  .export-buttons {
    flex-direction: row;
    width: 100%;
    justify-content: space-between;
    gap: 10px;
  }
  
  .btn-export {
    flex: 1;
    justify-content: center;
    padding: 12px 8px;
    font-size: 13px;
    min-height: 44px;
  }
  
  .btn-export .btn-text {
    display: inline;
  }

  .calendar-stats {
    margin: 10px;
    gap: 15px;
  }

  .charts-container {
    margin: 10px;
  }

  .chart-card {
    padding: 15px;
  }

  .chart-body {
    height: 250px;
  }

  .appointments-summary {
    margin: 10px;
    padding: 15px;
  }

  .summary-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 15px;
  }

  .search-container {
    width: 100%;
  }

  .search-container input {
    width: 100%;
  }

  .modal-container {
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
  }

  .detail-row {
    flex-direction: column;
    gap: 10px;
  }

  .detail-item {
    min-width: 100%;
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

  .filter-container {
    margin: 8px;
    padding: 12px;
  }

  .date-input input,
  .filter-select select {
    padding: 6px 10px;
    font-size: 13px;
  }

  .btn-export {
    padding: 8px 12px;
    font-size: 13px;
  }

  /*.btn-text {
    display: none;
  }*/

  .calendar-stats {
    margin: 8px;
    gap: 12px;
  }

  .stat-card {
    padding: 15px;
  }

  .stat-card i {
    font-size: 2rem;
  }

  .stat-info h4 {
    font-size: 1.5rem;
  }

  .charts-container {
    margin: 8px;
  }

  .chart-card {
    padding: 12px;
  }

  .chart-body {
    height: 200px;
  }

  .appointments-summary {
    margin: 8px;
    padding: 12px;
  }

  .summary-header h3 {
    font-size: 16px;
  }

  .status-tab {
    padding: 5px 10px;
    font-size: 12px;
  }

  .appointment-card {
    margin-bottom: 12px;
  }

  .card-header-mobile {
    padding: 12px;
  }

  .appointment-info h4 {
    font-size: 15px;
  }

  .card-content-mobile {
    padding: 12px;
  }

  .card-row {
    margin-bottom: 10px;
  }

  .card-label {
    font-size: 13px;
  }

  .pagination-btn .btn-text {
    display: none;
  }

  .modal-container {
    border-radius: 10px;
  }

  .modal-header {
    padding: 12px;
  }

  .modal-header h3 {
    font-size: 16px;
  }

  .modal-body {
    padding: 12px;
  }

  .section-title {
    font-size: 1rem;
  }
  
  .export-buttons {
    flex-direction: column;
    width: 100%;
    gap: 8px;
  }
  
  .btn-export {
    width: 100%;
    justify-content: center;
    padding: 12px 15px;
    font-size: 14px;
    min-height: 44px;
  }
  
  .btn-export .btn-text {
    display: inline;
  }
  
  /* Remove the btn-text hiding rule for export buttons */
  .btn-export .btn-text {
    display: inline !important;
  }
}

/* Landscape Mobile */
@media (max-height: 500px) and (orientation: landscape) {
  .modal-container {
    max-height: 95vh;
  }

  .modal-body {
    max-height: calc(95vh - 120px);
  }
}

.nav-link {
  margin-top: -30px;
}
</style>