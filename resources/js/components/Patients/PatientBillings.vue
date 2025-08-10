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
          <h3>Billing</h3>
          <div class="breadcrumbs">
            <a class="none" href=""><p>Home / </p></a>
            <a class="current" href="/patientbillings"><p>  Billings</p></a>
          </div>
      </div>
    </div>
    <hr color="#06693a">
    
    <!-- Search and Filter Section -->
    <div class="search-wrapper">
      <div class="search-container">
        <input 
          v-model="searchQuery" 
          placeholder="Search by date, details, or reference" 
          @keyup.enter="filterBillings" 
          class="search-input"
          :class="{ 'has-reset': searchQuery && isSearchActive }"
        />
        <i class="bx bx-search search-icon" @click="filterBillings"></i>
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
              <option value="debit-asc">Debit (Low to High)</option>
              <option value="debit-desc">Debit (High to Low)</option>
              <option value="credit-asc">Credit (Low to High)</option>
              <option value="credit-desc">Credit (High to Low)</option>
            </select>
          </div>
          <div class="filter-actions">
            <button class="apply-btn" @click="applyFilters">Apply Filters</button>
            <button class="reset-btn" @click="resetFilters">Reset</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Payments Section -->
    <div class="payment-container">
      <div class="payment">
        <h3>PAYMENTS</h3>
      </div>
      <div class="table-wrapper">
        <!-- Loading State -->
        <div v-if="isLoading" class="loading-spinner">
          <i class='bx bx-loader-alt bx-spin'></i>
          <span>Loading billings...</span>
        </div>

        <!-- Desktop Table -->
        <table v-else class="payment-table desktop-table">
          <thead>
            <tr>
              <th style="padding-left:25px;" @click="sortTable('Details')" class="sortable-header">
                Details <i v-if="sortConfig.key === 'Details'" class="bx" :class="getSortIconClass('Details')"></i>
              </th>
              <th @click="sortTable('DateTime')" class="sortable-header">
                Date <i v-if="sortConfig.key === 'DateTime'" class="bx" :class="getSortIconClass('DateTime')"></i>
              </th>
              <th @click="sortTable('Reference')" class="sortable-header">
                Reference <i v-if="sortConfig.key === 'Reference'" class="bx" :class="getSortIconClass('Reference')"></i>
              </th>
              <th @click="sortTable('Debit')" class="sortable-header">
                Debit <i v-if="sortConfig.key === 'Debit'" class="bx" :class="getSortIconClass('Debit')"></i>
              </th>
              <th @click="sortTable('Credit')" class="sortable-header">
                Credit <i v-if="sortConfig.key === 'Credit'" class="bx" :class="getSortIconClass('Credit')"></i>
              </th>
              <th @click="sortTable('ComputedBalance')" class="sortable-header">
                Balance <i v-if="sortConfig.key === 'ComputedBalance'" class="bx" :class="getSortIconClass('ComputedBalance')"></i>
              </th>
              <th style="text-align: center;" class="action-header">Action</th>
            </tr>
          </thead>
          <tbody class="container-payment">
            <tr 
              v-for="entry in billingsWithComputedBalance" 
              :key="entry.Reference"
              class="payment-row"
              :class="{ 'standalone-row': entry.IsStandalonePayment }"
            >
              <td style="padding-left: 25px;" class="truncate-cell">
                {{ entry.Treatment || (entry.PaymentMethod === 'Adjustment' ? 'Adjustment' : `Payment - ${entry.PaymentMethod}`) }}
              </td>
              <td class="truncate-cell">{{ formatDateTime(entry.DateTime) }}</td>
              <td class="truncate-cell">{{ entry.Reference }}</td>
              <td class="truncate-cell">{{ formatNumber(entry.Debit) }}</td>
              <td class="truncate-cell">{{ formatNumber(entry.Credit) }}</td>
              <td class="truncate-cell">
                <span :class="getBalanceClass(entry.ComputedBalance)">
                  {{ formatNumber(entry.ComputedBalance) }}
                </span>
              </td>
              <td class="action-cell">
                <button class="view-details-btn" @click="openBillingModal(entry)" title="View Details">
                  <i class='bx bx-show'></i>
                </button>
              </td>
            </tr>
            <tr v-if="billingsWithComputedBalance.length === 0">
              <td colspan="7" class="no-data">No billing records found...</td>
            </tr>
            <tr v-if="billingsWithComputedBalance.length > 0" class="total-row">
              <td colspan="3" class="total-label">Total</td>
              <td>{{ formatNumber(calculateTotal('Debit')) }}</td>
              <td>{{ formatNumber(calculateTotal('Credit')) }}</td>
              <td>
                <span :class="getBalanceClass(calculateTotal('Balance'))">
                  {{ formatNumber(calculateTotal('Balance')) }}
                </span>
              </td>
              <td></td>
            </tr>
          </tbody>
        </table>

        <!-- Mobile Cards -->
        <div v-if="!isLoading" class="mobile-cards">
          <div 
            v-for="entry in billingsWithComputedBalance" 
            :key="entry.Reference"
            class="payment-card"
            :class="{ 'standalone-card': entry.IsStandalonePayment }"
          >
            <div class="card-header">
              <h4>{{ formatDateTime(entry.DateTime) }}</h4>
              <button class="view-details-btn mobile" @click="openBillingModal(entry)" title="View Details">
                <i class='bx bx-show'></i>
              </button>
            </div>
            <div class="card-content">
              <div class="card-row">
                <span class="card-label">Details:</span>
                <span>
                  {{ entry.Treatment || (entry.PaymentMethod === 'Adjustment' ? 'Adjustment' : `Payment - ${entry.PaymentMethod}`) }}
                </span>
              </div>
              <div class="card-row">
                <span class="card-label">Reference:</span>
                <span>{{ entry.Reference }}</span>
              </div>
              <div class="card-row">
                <span class="card-label">Debit:</span>
                <span>{{ formatNumber(entry.Debit) }}</span>
              </div>
              <div class="card-row">
                <span class="card-label">Credit:</span>
                <span>{{ formatNumber(entry.Credit) }}</span>
              </div>
              <div class="card-row">
                <span class="card-label">Balance:</span>
                <span :class="getBalanceClass(entry.ComputedBalance)">
                  {{ formatNumber(entry.ComputedBalance) }}
                </span>
              </div>
            </div>
          </div>
          <div v-if="billingsWithComputedBalance.length > 0" class="total-card">
            <div class="total-card-header">
              <h4>Summary</h4>
            </div>
            <div class="total-card-content">
              <div class="total-card-row">
                <span class="total-card-label">Total Debit:</span>
                <span class="total-card-value">{{ formatNumber(calculateTotal('Debit')) }}</span>
              </div>
              <div class="total-card-row">
                <span class="total-card-label">Total Credit:</span>
                <span class="total-card-value">{{ formatNumber(calculateTotal('Credit')) }}</span>
              </div>
              <div class="total-card-row">
                <span class="total-card-label">Total Balance:</span>
                <span class="total-card-value" :class="getBalanceClass(calculateTotal('Balance'))">
                  {{ formatNumber(calculateTotal('Balance')) }}
                </span>
              </div>
            </div>
          </div>
          <div v-if="billingsWithComputedBalance.length === 0" class="no-data-mobile">
            No Billing Records
          </div>
        </div>
      </div>
    </div>

    <!-- Billing Details Modal -->
    <div v-if="showModal" class="modal-overlay" @click="closeModal">
      <div class="modal" @click.stop>
        <div class="modal-header">
          <h3>Billing Details</h3>
          <button class="close-icon" @click="closeModal">×</button>
        </div>
        <div class="modal-body">
          <div class="billing-info">
            <div class="info-group">
              <i class="bx bx-briefcase-alt-2"></i>
              <div>
                <label>Details:</label>
                <span>
                  {{ selectedBilling.Treatment || (selectedBilling.PaymentMethod === 'Adjustment' ? 'Adjustment' : `Payment - ${selectedBilling.PaymentMethod}`) }}
                </span>
              </div>
            </div>
            <div class="info-group">
              <i class="bx bx-calendar"></i>
              <div>
                <label>Date:</label>
                <span>{{ formatDateTime(selectedBilling.DateTime) }}</span>
              </div>
            </div>
            <div class="info-group">
              <i class="bx bx-receipt"></i>
              <div>
                <label>Reference:</label>
                <span>{{ selectedBilling.Reference }}</span>
              </div>
            </div>
            <div class="info-group">
              <i class="bx bx-money"></i>
              <div>
                <label>Debit:</label>
                <span>{{ formatNumber(selectedBilling.Debit) }}</span>
              </div>
            </div>
            <div class="info-group">
              <i class="bx bx-money"></i>
              <div>
                <label>Credit:</label>
                <span>{{ formatNumber(selectedBilling.Credit) }}</span>
              </div>
            </div>
            <div class="info-group">
              <i class="bx bx-wallet"></i>
              <div>
                <label>Balance:</label>
                <span :class="getBalanceClass(selectedBilling.ComputedBalance)">
                  {{ formatNumber(selectedBilling.ComputedBalance) }}
                </span>
              </div>
            </div>
            <div class="info-group">
              <i class="bx bx-wallet"></i>
              <div>
                <label>Remarks:</label>
                <span :class="getBalanceClass(selectedBilling.Remarks)">
                  <span>{{ selectedBilling.Remarks }}</span>
                </span>
              </div>
            </div>
            <div v-if="selectedBilling.IsStandalonePayment" class="info-group standalone-note">
              <i class="bx bx-info-circle"></i>
              <div>
                <label>Note:</label>
                <span>This is a payment without appointment, not tied to a specific appointment.</span>
              </div>
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
name: "PatientBillings",
props: {
  firstName: {
    type: String,
    required: true,
  },
  lastName: {
    type: String,
    required: true,
  },
  profilePicture: {
    type: String,
    default: null,
  },
},
data() {
  return {
    profilePicture: sessionStorage.getItem('user_profile_picture') || this.profilePicture,
    searchQuery: '',
    allBillings: [],
    filteredBillings: [],
    showModal: false,
    selectedBilling: null,
    showFilterMenu: false,
    isSearchActive: false,
    isLoading: false,
    filter: {
      startDate: '',
      endDate: '',
      sortBy: ''
    },
    sortConfig: {
      key: null,
      direction: 'asc'
    }
  };
},
computed: {
  fullName() {
    return `${this.firstName} ${this.lastName}`;
  },
  billingsWithComputedBalance() {
    return this.filteredBillings;
  }
},
mounted() {
  this.fetchBillings();
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
  async fetchBillings() {
    this.isLoading = true;
    try {
      const response = await axios.get('/api/patientbillings', { withCredentials: true });
      console.log('API Response:', response.data);
      const ledger = response.data.ledger || [];

      this.allBillings = ledger.map(entry => ({
        DateTime: entry.TransactionDate,
        Treatment: entry.Service,
        PaymentMethod: entry.PaymentMethod,
        Debit: entry.Debit || 0,
        Credit: entry.Credit || 0,
        ComputedBalance: entry.Balance || 0,
        Reference: entry.Reference,
        Remarks: entry.Remarks || entry.Notes || 'N/A', // Add this line - map Remarks field
        IsStandalonePayment: entry.IsStandalonePayment || false,
      }));

      this.filteredBillings = [...this.allBillings];
    } catch (error) {
      console.error("Error fetching billings:", error);
      if (error.response && error.response.status === 401) {
        alert('Unauthorized: Please log in to view your billings.');
        window.location.href = '/login';
      } else {
        alert('Unable to fetch your billings at this time. Please try again later.');
      }
      this.allBillings = [];
      this.filteredBillings = [];
    } finally {
      this.isLoading = false;
    }
  },
  matchesSearch(entry) {
    const query = this.searchQuery.toLowerCase();
    const formattedDate = this.formatDateTime(entry.DateTime).toLowerCase();
    const details = (entry.Treatment || (entry.PaymentMethod === 'Adjustment' ? 'Adjustment' : `Payment - ${entry.PaymentMethod}`)).toLowerCase();
    const reference = (entry.Reference || '').toLowerCase();
    return (
      formattedDate.includes(query) ||
      details.includes(query) ||
      reference.includes(query)
    );
  },
  applyAllFilters() {
    let filtered = [...this.allBillings];
    
    if (this.searchQuery && this.isSearchActive) {
      filtered = filtered.filter(entry => this.matchesSearch(entry));
    }

    if (this.filter.startDate || this.filter.endDate) {
      filtered = filtered.filter(entry => {
        const entryDate = new Date(entry.DateTime);
        const start = this.filter.startDate ? new Date(this.filter.startDate) : null;
        const end = this.filter.endDate ? new Date(this.filter.endDate) : null;
        return (!start || entryDate >= start) && (!end || entryDate <= end);
      });
    }

    if (this.filter.sortBy) {
      const [field, direction] = this.filter.sortBy.split('-');
      filtered.sort((a, b) => {
        if (field === 'date') {
          const dateA = new Date(a.DateTime || 0);
          const dateB = new Date(b.DateTime || 0);
          return direction === 'asc' ? dateA - dateB : dateB - dateA;
        } else if (field === 'debit') {
          const debitA = parseFloat(a.Debit || 0);
          const debitB = parseFloat(b.Debit || 0);
          return direction === 'asc' ? debitA - debitB : debitB - debitA;
        } else if (field === 'credit') {
          const creditA = parseFloat(a.Credit || 0);
          const creditB = parseFloat(b.Credit || 0);
          return direction === 'asc' ? creditA - creditB : creditB - creditA;
        }
        return 0;
      });
    }

    return filtered;
  },
  filterBillings() {
    if (!this.searchQuery.trim()) {
      this.isSearchActive = false;
    } else {
      this.isSearchActive = true;
    }
    this.updateDisplayedBillings();
  },
  updateDisplayedBillings() {
    this.filteredBillings = this.applyAllFilters();
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
    this.filter = {
      startDate: '',
      endDate: '',
      sortBy: ''
    };
    this.showFilterMenu = false;
    this.updateDisplayedBillings();
  },
  resetSearch() {
    this.searchQuery = '';
    this.isSearchActive = false;
    this.updateDisplayedBillings();
  },
  applyFilters() {
    this.updateDisplayedBillings();
    this.showFilterMenu = false;
  },
  sortTable(key) {
    this.filter.sortBy = '';
    if (this.sortConfig.key === key) {
      this.sortConfig.direction = this.sortConfig.direction === 'asc' ? 'desc' : 'asc';
    } else {
      this.sortConfig.key = key;
      this.sortConfig.direction = 'asc';
    }

    this.filteredBillings.sort((a, b) => {
      let valueA, valueB;
      if (key === 'Details') {
        valueA = a.Treatment || (a.PaymentMethod === 'Adjustment' ? 'Adjustment' : `Payment - ${a.PaymentMethod}`);
        valueB = b.Treatment || (b.PaymentMethod === 'Adjustment' ? 'Adjustment' : `Payment - ${b.PaymentMethod}`);
        return this.sortConfig.direction === 'asc' ? valueA.localeCompare(valueB) : valueB.localeCompare(valueA);
      } else if (key === 'DateTime') {
        const dateA = new Date(a.DateTime || 0);
        const dateB = new Date(b.DateTime || 0);
        return this.sortConfig.direction === 'asc' ? dateA - dateB : dateB - dateA;
      } else if (key === 'Reference') {
        valueA = a.Reference || '';
        valueB = b.Reference || '';
        return this.sortConfig.direction === 'asc' ? valueA.localeCompare(valueB) : valueB.localeCompare(valueA);
      } else if (key === 'Debit') {
        valueA = parseFloat(a.Debit || 0);
        valueB = parseFloat(b.Debit || 0);
        return this.sortConfig.direction === 'asc' ? valueA - valueB : valueB - valueA;
      } else if (key === 'Credit') {
        valueA = parseFloat(a.Credit || 0);
        valueB = parseFloat(b.Credit || 0);
        return this.sortConfig.direction === 'asc' ? valueA - valueB : valueB - valueA;
      } else if (key === 'ComputedBalance') {
        valueA = parseFloat(a.ComputedBalance || 0);
        valueB = parseFloat(b.ComputedBalance || 0);
        return this.sortConfig.direction === 'asc' ? valueA - valueB : valueB - valueA;
      }
      return 0;
    });
  },
  getSortIconClass(key) {
    if (this.sortConfig.key === key) {
      return this.sortConfig.direction === 'asc' ? 'bx-caret-up' : 'bx-caret-down';
    }
    return '';
  },
  formatNumber(value) {
    return typeof value === 'number' && !isNaN(value) ? value.toFixed(2) : '0.00';
  },
  formatDateTime(date) {
    if (!date) return 'N/A';
    const parsedDate = new Date(date);
    const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    const shortDate = `${monthNames[parsedDate.getMonth()]} ${parsedDate.getDate()}, ${parsedDate.getFullYear()}`;
    
    const hours = parsedDate.getHours();
    const minutes = parsedDate.getMinutes();
    const period = hours >= 12 ? 'P.M.' : 'A.M.';
    const adjustedHour = hours % 12 || 12;
    const formattedTime = `${adjustedHour}:${minutes.toString().padStart(2, '0')} ${period}`;
    
    return `${shortDate} at ${formattedTime}`;
  },
  openBillingModal(entry) {
    this.selectedBilling = { ...entry };
    this.showModal = true;
  },
  closeModal() {
    this.showModal = false;
    this.selectedBilling = null;
  },
  calculateTotal(field) {
    if (field === 'Balance') {
      return this.billingsWithComputedBalance.length > 0
        ? this.billingsWithComputedBalance[this.billingsWithComputedBalance.length - 1].ComputedBalance
        : 0;
    }
    return this.billingsWithComputedBalance.reduce((total, entry) => {
      return total + (parseFloat(entry[field]) || 0);
    }, 0);
  },
  getBalanceClass(computedBalance) {
    const balanceValue = parseFloat(computedBalance) || 0;
    if (balanceValue === 0) return 'balance-zero';
    if (balanceValue > 0) return 'balance-positive';
    return 'balance-negative';
  },
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

/* Payment Container */
.payment-container {
margin: 20px;
background-color: white;
border-radius: 12px;
box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
overflow: hidden;
}

.payment {
padding: 20px 25px 0;
border-bottom: 1px solid #f0f0f0;
}

.payment h3 {
font-size: 18px;
color: #333;
font-weight: 600;
margin: 0;
padding-bottom: 15px;
}

.table-wrapper {
padding: 0;
}

.payment-table {
width: 100%;
border-collapse: collapse;
background-color: white;
table-layout: fixed;
}

.payment-table th,
.payment-table td {
padding: 16px;
text-align: left;
border-bottom: 1px solid #f5f5f5;
color: #333;
font-size: 14px;
}

.payment-table th {
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

.payment-row {
cursor: pointer;
transition: background-color 0.2s;
}

.payment-row:hover {
background-color: #f9f9f9;
}

.payment-table tr:last-child td {
border-bottom: none;
}

.no-data {
text-align: center;
color: #757575;
padding: 30px !important;
}

/* Action Column */
.action-header {
width: 10%;
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
display: flex;
align-items: center;
justify-content: center;
cursor: pointer;
transition: all 0.2s ease;
margin: 0 auto;
}

.view-details-btn:hover {
background-color: rgba(6, 105, 58, 0.2);
}

.view-details-btn i {
font-size: 18px;
}

/* Total Row Styling */
.total-row {
background-color: #f0f7f3;
font-weight: 600;
}

.total-row td {
border-top: 2px solid #e0e0e0;
}

.total-label {
text-align: right;
color: #06693A !important;
font-size: 15px !important;
}

/* Loading Spinner */
.loading-spinner {
display: flex;
flex-direction: column;
align-items: center;
justify-content: center;
padding: 30px 0;
color: #666;
}

.loading-spinner i {
font-size: 30px;
color: #06693A;
margin-bottom: 10px;
}

/* Mobile Cards */
.mobile-cards {
display: none;
padding: 15px;
}

.payment-card {
background-color: white;
border-radius: 12px;
border: 1px solid #e0e0e0;
margin-bottom: 16px;
overflow: hidden;
cursor: pointer;
transition: transform 0.2s, box-shadow 0.2s;
}

.payment-card:hover {
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

/* Total Card Styling */
.total-card {
background-color: #f0f7f3;
border-radius: 12px;
border: 2px solid #06693A;
margin-top: 16px;
overflow: hidden;
}

.total-card-header {
padding: 12px 16px;
background-color: #06693A;
border-bottom: 1px solid #e0e0e0;
}

.total-card-header h4 {
margin: 0;
font-size: 16px;
font-weight: 600;
color: white;
}

.total-card-content {
padding: 16px;
}

.total-card-row {
display: flex;
justify-content: space-between;
margin-bottom: 8px;
}

.total-card-row:last-child {
margin-bottom: 0;
}

.total-card-label {
font-weight: 600;
color: #06693A;
}

.total-card-value {
font-weight: 600;
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

.billing-info {
display: grid;
grid-template-columns: 1fr 1fr;
gap: 15px;
}

.billing-info .info-group {
padding: 12px;
background-color: #f9f9f9;
border-radius: 8px;
margin-bottom: 0 !important;
display: flex;
align-items: flex-start;
}

.billing-info .info-group i {
font-size: 1.2em;
color: #06693a;
margin-right: 10px;
margin-top: 3px;
}

.billing-info .info-group div {
display: flex;
flex-direction: column;
gap: 5px;
flex: 1;
}

.billing-info .info-group label {
font-weight: bold;
margin-right: 5px;
}

.billing-info .info-group span {
color: #333;
word-break: break-word;
}

.standalone-note {
grid-column: 1 / -1;
background-color: #fff3cd !important;
border: 1px solid #ffeaa7;
}

.standalone-note i {
color: #856404 !important;
}

.standalone-note label {
color: #856404 !important;
}

/* Balance Styling */
.balance-zero {
color: #2e7d32;
font-weight: 500;
}

.balance-positive {
color: #c62828;
font-weight: 500;
}

.balance-negative {
color: #1565c0;
font-weight: 500;
}

/* Responsive Design */

/* Large Desktop */
@media (min-width: 1400px) {
.payment-container {
  margin: 30px;
}

.payment-card {
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

.payment-table th,
.payment-table td {
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

.payment-container {
  margin: 15px;
}

.payment h3 {
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

.payment-container {
  margin: 10px;
}

.payment h3 {
  font-size: 16px;
  padding: 15px 0 10px 0;
}

.payment-card {
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

.billing-info {
  grid-template-columns: 1fr;
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

.payment-container {
  margin: 8px;
}

.payment h3 {
  font-size: 14px;
  padding: 12px 0 8px 0;
}

.payment-card {
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

.payment-card {
  margin-bottom: 8px;
}
}
</style>
