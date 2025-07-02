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
        <i class="bx bx-menu" @click="toggleSidebar"></i>
        <div class="text">
            <h3>Finance Report</h3>
            <div class="breadcrumbs">
              <a class="none" href=""><p>Home / </p></a>
              <a class="current" href="/ownerfinancereports"><p>Finance Report</p></a>
            </div>
        </div>
      </div>
      <hr color="#06693a">

      <!-- Main Dashboard Content -->
      <div class="dashboard-container">
        <!-- Report Period Selector -->
        <div class="report-filters">
          <div class="filter-section">
            <div class="filter-container">
              <div class="date-filter">
                <div class="period-selector">
                  <button 
                    v-for="(period, index) in periods" 
                    :key="index"
                    :class="['period-btn', { active: activePeriod === period.value }]"
                    @click="setActivePeriod(period.value)"
                  >
                    <i :class="period.icon"></i>
                    <span class="btn-text">{{ period.label }}</span>
                  </button>
                </div>
                
                <div class="date-range-picker" v-if="activePeriod === 'custom'">
                  <div class="date-input-group">
                    <label for="start-date">From:</label>
                    <input 
                      type="date" 
                      id="start-date" 
                      v-model="startDate" 
                      @change="fetchReportData"
                    >
                  </div>
                  <div class="date-input-group">
                    <label for="end-date">To:</label>
                    <input 
                      type="date" 
                      id="end-date" 
                      v-model="endDate" 
                      @change="fetchReportData"
                    >
                  </div>
                  <button class="apply-btn" @click="fetchReportData">
                    <i class="bx bx-filter"></i> <span class="btn-text">Apply</span>
                  </button>
                </div>
              </div>
              
              <div class="other-filters">
                <div class="search-container">
                  <i class="bx bx-search search-icon"></i>
                  <input 
                    type="text" 
                    v-model="searchQuery" 
                    placeholder="Search patient or procedure..." 
                    class="search-input"
                  >
                </div>
                
                <div class="payment-type-filter">
                  <select v-model="paymentTypeFilter" @change="applyFilters">
                    <option value="all">All Payment Types</option>
                    <option value="cash">Cash</option>
                    <option value="insurance">Insurance</option>
                    <option value="card">Card</option>
                    <option value="e-wallet">E-Wallet</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Summary Stats -->
        <div class="summary-stats">
          <div class="stat-card">
            <div class="stat-icon">
              <i class="bx bx-money-withdraw"></i>
            </div>
            <div class="stat-content">
              <h3>Total Revenue</h3>
              <p class="stat-value">₱ {{ formatNumber(totalRevenue) }}</p>
            </div>
          </div>
          
          <div class="stat-card">
            <div class="stat-icon payments-icon">
              <i class="bx bx-receipt"></i>
            </div>
            <div class="stat-content">
              <h3>Total Payments</h3>
              <p class="stat-value">{{ totalPayments }}</p>
            </div>
          </div>
          
          <div class="stat-card">
            <div class="stat-icon patients-icon">
              <i class="bx bx-user"></i>
            </div>
            <div class="stat-content">
              <h3>Unique Patients</h3>
              <p class="stat-value">{{ uniquePatients }}</p>
            </div>
          </div>
          
          <div class="stat-card">
            <div class="stat-icon period-icon">
              <i class="bx bx-calendar-check"></i>
            </div>
            <div class="stat-content">
              <h3>Report Period</h3>
              <p class="stat-date">{{ formattedDateRange }}</p>
            </div>
          </div>
        </div>

        <!-- Additional Statistics -->
        <div class="additional-stats">
          <div class="stat-row">
            <div class="stat-card-wide">
              <div class="stat-header">
                <i class="bx bx-line-chart"></i>
                <h3>Revenue by Payment Method</h3>
              </div>
              <div class="stat-chart">
                <div v-for="(amount, method) in revenueByPaymentMethod" :key="method" class="chart-bar">
                  <div class="bar-label">{{ method }}</div>
                  <div class="bar-container">
                    <div class="bar" :style="{ width: getPercentage(amount, totalRevenue) + '%', backgroundColor: getPaymentMethodColor(method) }"></div>
                  </div>
                  <div class="bar-value">₱ {{ formatNumber(amount) }}</div>
                  <div class="bar-percentage">{{ getPercentage(amount, totalRevenue) }}%</div>
                </div>
              </div>
            </div>
            
            <div class="stat-card-wide">
              <div class="stat-header">
                <i class="bx bx-trending-up"></i>
                <h3>Top Procedures</h3>
              </div>
              <div class="top-procedures">
                <div v-for="(procedure, index) in topProcedures" :key="index" class="procedure-item">
                  <div class="procedure-name">{{ procedure.name }}</div>
                  <div class="procedure-count">{{ procedure.count }} appointments</div>
                  <div class="procedure-revenue">₱ {{ formatNumber(procedure.revenue) }}</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="action-buttons">
          <button class="action-btn print-btn" @click="printReport">
            <i class="bx bx-printer"></i> <span class="btn-text">Print Report</span>
          </button>
          <button class="action-btn export-btn" @click="exportToCSV">
            <i class="bx bx-download"></i> <span class="btn-text">Export to CSV</span>
          </button>
        </div>
        
        <!-- Detailed Transactions Table -->
        <div class="transactions-container">
          <div class="table-heading">
            <h2><i class="bx bx-table"></i> Detailed Payment Transactions</h2>
            <span class="record-count">{{ filteredTransactions.length }} records found</span>
          </div>
          
          <!-- Desktop Table -->
          <div class="table-responsive desktop-table">
            <table class="transactions-table">
              <thead>
                <tr>
                  <th @click="sortBy('AppointmentDateTime')">
                    Appointment Date
                    <i :class="getSortIcon('AppointmentDateTime')"></i>
                  </th>
                  <th @click="sortBy('PatientName')">
                    Patient Name
                    <i :class="getSortIcon('PatientName')"></i>
                  </th>
                  <th @click="sortBy('Procedure')">
                    Procedure
                    <i :class="getSortIcon('Procedure')"></i>
                  </th>
                  <th @click="sortBy('AmountPaid')">
                    Amount Paid
                    <i :class="getSortIcon('AmountPaid')"></i>
                  </th>
                  <th @click="sortBy('PaymentMethod')">
                    Payment Method
                    <i :class="getSortIcon('PaymentMethod')"></i>
                  </th>
                  <th @click="sortBy('PaymentDate')">
                    Payment Date
                    <i :class="getSortIcon('PaymentDate')"></i>
                  </th>
                  <th>Reference ID</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(transaction, index) in paginatedTransactions" :key="index">
                  <td>{{ formatDateTime(transaction.AppointmentDateTime) }}</td>
                  <td>{{ transaction.PatientName }}</td>
                  <td>{{ transaction.Procedure }}</td>
                  <td class="amount">₱ {{ formatNumber(transaction.AmountPaid) }}</td>
                  <td>
                    <span class="payment-badge" :class="getPaymentMethodClass(transaction.PaymentMethod)">
                      {{ transaction.PaymentMethod }}
                    </span>
                  </td>
                  <td>{{ formatDate(transaction.PaymentDate) }}</td>
                  <td>{{ transaction.ReferenceID || 'N/A' }}</td>
                </tr>
                <tr v-if="filteredTransactions.length === 0">
                  <td colspan="7" class="no-data">
                    <div class="empty-state">
                      <i class="bx bx-search-alt"></i>
                      <p>No payment transactions found for the selected criteria</p>
                      <button class="reset-btn" @click="resetFilters">Reset Filters</button>
                    </div>
                  </td>
                </tr>
              </tbody>
              <tfoot v-if="filteredTransactions.length > 0">
                <tr>
                  <td colspan="3" class="footer-label">Total:</td>
                  <td class="footer-amount">₱ {{ formatNumber(pageTotal) }}</td>
                  <td colspan="3"></td>
                </tr>
                <tr>
                  <td colspan="3" class="footer-label">Grand Total (All Records):</td>
                  <td class="footer-amount">₱ {{ formatNumber(totalRevenue) }}</td>
                  <td colspan="3"></td>
                </tr>
              </tfoot>
            </table>
          </div>

          <!-- Mobile Cards -->
          <div class="mobile-cards">
            <div 
              v-for="(transaction, index) in paginatedTransactions" 
              :key="index"
              class="transaction-card"
            >
              <div class="card-header-mobile">
                <div class="transaction-info">
                  <h4>{{ transaction.PatientName }}</h4>
                  <div class="transaction-date">
                    <span class="date">{{ formatDateTime(transaction.AppointmentDateTime) }}</span>
                  </div>
                </div>
                <div class="transaction-amount">
                  <span class="amount-value">₱ {{ formatNumber(transaction.AmountPaid) }}</span>
                </div>
              </div>
              <div class="card-content-mobile">
                <div class="card-row">
                  <span class="card-label">Procedure:</span>
                  <span class="card-value">{{ transaction.Procedure }}</span>
                </div>
                <div class="card-row">
                  <span class="card-label">Payment Method:</span>
                  <span class="payment-badge" :class="getPaymentMethodClass(transaction.PaymentMethod)">
                    {{ transaction.PaymentMethod }}
                  </span>
                </div>
                <div class="card-row">
                  <span class="card-label">Payment Date:</span>
                  <span class="card-value">{{ formatDate(transaction.PaymentDate) }}</span>
                </div>
                <div class="card-row" v-if="transaction.ReferenceID">
                  <span class="card-label">Reference ID:</span>
                  <span class="card-value">{{ transaction.ReferenceID }}</span>
                </div>
              </div>
            </div>
            <div v-if="filteredTransactions.length === 0" class="no-data-mobile">
              <div class="empty-state">
                <i class="bx bx-search-alt"></i>
                <p>No payment transactions found for the selected criteria</p>
                <button class="reset-btn" @click="resetFilters">Reset Filters</button>
              </div>
            </div>
          </div>
          
          <!-- Pagination Controls -->
          <div class="pagination-controls" v-if="filteredTransactions.length > 0">
            <div class="page-size">
              <label for="page-size">Show:</label>
              <select id="page-size" v-model="pageSize" @change="handlePageSizeChange">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
              </select>
              <span>entries</span>
            </div>
            
            <div class="pagination">
              <button 
                class="page-btn" 
                :disabled="currentPage === 1" 
                @click="goToPage(1)"
              >
                <i class="bx bx-chevrons-left"></i>
              </button>
              <button 
                class="page-btn" 
                :disabled="currentPage === 1" 
                @click="goToPage(currentPage - 1)"
              >
                <i class="bx bx-chevron-left"></i>
              </button>
              
              <div class="page-info">
                Page {{ currentPage }} of {{ totalPages }}
              </div>
              
              <button 
                class="page-btn" 
                :disabled="currentPage === totalPages" 
                @click="goToPage(currentPage + 1)"
              >
                <i class="bx bx-chevron-right"></i>
              </button>
              <button 
                class="page-btn" 
                :disabled="currentPage === totalPages" 
                @click="goToPage(totalPages)"
              >
                <i class="bx bx-chevrons-right"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import axios from 'axios';
import { jsPDF } from 'jspdf';
import autoTable from 'jspdf-autotable';
import logoImg from '@/components/Images/ATDC_Logo.png';
import Swal from 'sweetalert2';

export default {
  name: "OwnerFinanceReport",
  props: {
    firstName: {
      type: String,
      required: true
    },
    lastName: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      // Date filtering
      periods: [
        { label: 'Today', value: 'today', icon: 'bx bx-calendar-day' },
        { label: 'This Week', value: 'week', icon: 'bx bx-calendar-week' },
        { label: 'This Month', value: 'month', icon: 'bx bx-calendar' },
        { label: 'This Year', value: 'year', icon: 'bx bx-calendar-alt' },
        { label: 'Custom', value: 'custom', icon: 'bx bx-calendar-edit' }
      ],
      activePeriod: 'month',
      startDate: this.getStartOfMonth(),
      endDate: this.getEndOfMonth(),
      
      // Filtering
      searchQuery: '',
      paymentTypeFilter: 'all',
      
      // Sorting
      sortKey: 'PaymentDate',
      sortOrder: 'desc',
      
      // Pagination
      currentPage: 1,
      pageSize: 10,
      
      // Data
      transactions: [],
      isLoading: false,
      
      // Additional statistics
      revenueByPaymentMethod: {},
      topProcedures: [],

      // Mobile sidebar state
      isSidebarClosed: true,
    };
  },
  computed: {
    fullName() {
      return `${this.firstName} ${this.lastName}`;
    },
    
    filteredTransactions() {
      let result = [...this.transactions];
      
      // Apply search filter
      if (this.searchQuery) {
        const query = this.searchQuery.toLowerCase();
        result = result.filter(transaction => 
          transaction.PatientName.toLowerCase().includes(query) ||
          transaction.Procedure.toLowerCase().includes(query)
        );
      }
      
      // Apply payment type filter
      if (this.paymentTypeFilter !== 'all') {
        result = result.filter(transaction => {
          const paymentMethod = transaction.PaymentMethod.toLowerCase();
          
          switch(this.paymentTypeFilter) {
            case 'cash':
              return paymentMethod === 'cash';
            case 'insurance':
              return ['medicard', 'maxicare', 'intelligentcare'].includes(paymentMethod);
            case 'card':
              return ['visa', 'mastercard', 'debit card', 'credit card'].includes(paymentMethod);
            case 'e-wallet':
              return ['gcash', 'paymaya', 'grab pay', 'shopee pay'].includes(paymentMethod);
            default:
              return true;
          }
        });
      }
      
      // Apply sorting
      result.sort((a, b) => {
        let modifier = this.sortOrder === 'asc' ? 1 : -1;
        
        // Handle numeric sorting
        if (this.sortKey === 'AmountPaid') {
          return modifier * (a[this.sortKey] - b[this.sortKey]);
        }
        
        // Handle date sorting
        if (['AppointmentDateTime', 'PaymentDate'].includes(this.sortKey)) {
          return modifier * (new Date(a[this.sortKey]) - new Date(b[this.sortKey]));
        }
        
        // Handle string sorting
        if (a[this.sortKey] < b[this.sortKey]) return -1 * modifier;
        if (a[this.sortKey] > b[this.sortKey]) return 1 * modifier;
        return 0;
      });
      
      return result;
    },
    
    paginatedTransactions() {
      const startIndex = (this.currentPage - 1) * this.pageSize;
      const endIndex = startIndex + this.pageSize;
      return this.filteredTransactions.slice(startIndex, endIndex);
    },
    
    totalPages() {
      return Math.ceil(this.filteredTransactions.length / this.pageSize) || 1;
    },
    
    totalRevenue() {
      return this.filteredTransactions.reduce((sum, transaction) => sum + transaction.AmountPaid, 0);
    },
    
    pageTotal() {
      return this.paginatedTransactions.reduce((sum, transaction) => sum + transaction.AmountPaid, 0);
    },
    
    totalPayments() {
      return this.filteredTransactions.length;
    },
    
    uniquePatients() {
      const uniquePatientIds = new Set(this.filteredTransactions.map(t => t.PatientID));
      return uniquePatientIds.size;
    },
    
    formattedDateRange() {
      const formatDate = (dateString) => {
        const date = new Date(dateString);
        return date.toLocaleDateString('en-US', {
          year: 'numeric',
          month: 'long',
          day: 'numeric'
        });
      };
      
      if (this.startDate === this.endDate) {
        return formatDate(this.startDate);
      }
      
      return `${formatDate(this.startDate)} — ${formatDate(this.endDate)}`;
    }
  },
  mounted() {
    this.setupSidebar();
    this.fetchReportData();
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
    
    // Date Helper Methods
    getToday() {
      return new Date().toISOString().split('T')[0];
    },
    
    getStartOfWeek() {
      const now = new Date();
      const day = now.getDay(); // 0 = Sunday, 1 = Monday, etc.
      const diff = now.getDate() - day + (day === 0 ? -6 : 1); // Adjust to get Monday
      return new Date(now.setDate(diff)).toISOString().split('T')[0];
    },
    
    getEndOfWeek() {
      const now = new Date();
      const day = now.getDay();
      const diff = now.getDate() + (7 - day) % 7; // Adjust to get Sunday
      return new Date(now.setDate(diff)).toISOString().split('T')[0];
    },
    
    getStartOfMonth() {
      const now = new Date();
      return new Date(now.getFullYear(), now.getMonth(), 1).toISOString().split('T')[0];
    },
    
    getEndOfMonth() {
      const now = new Date();
      return new Date(now.getFullYear(), now.getMonth() + 1, 0).toISOString().split('T')[0];
    },
    
    getStartOfYear() {
      const now = new Date();
      return new Date(now.getFullYear(), 0, 1).toISOString().split('T')[0];
    },
    
    getEndOfYear() {
      const now = new Date();
      return new Date(now.getFullYear(), 11, 31).toISOString().split('T')[0];
    },
    
    // Date Formatting
    formatDate(dateString) {
      if (!dateString) return 'N/A';
      
      const date = new Date(dateString);
      if (isNaN(date)) return 'Invalid Date';
      
      return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      });
    },
    
    formatDateTime(dateTimeString) {
      if (!dateTimeString) return 'N/A';
      
      const date = new Date(dateTimeString);
      if (isNaN(date)) return 'Invalid Date';
      
      return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      });
    },
    
    formatNumber(value) {
      return value.toLocaleString('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      });
    },
    
    formatCurrency(value) {
      // Clean currency format without ± symbols
      return value.toLocaleString('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      });
    },
    
    // Period Selection
    setActivePeriod(period) {
      this.activePeriod = period;
      
      switch(period) {
        case 'today':
          this.startDate = this.getToday();
          this.endDate = this.getToday();
          break;
        case 'week':
          this.startDate = this.getStartOfWeek();
          this.endDate = this.getEndOfWeek();
          break;
        case 'month':
          this.startDate = this.getStartOfMonth();
          this.endDate = this.getEndOfMonth();
          break;
        case 'year':
          this.startDate = this.getStartOfYear();
          this.endDate = this.getEndOfYear();
          break;
        // For custom, keep existing dates
      }
      
      if (period !== 'custom') {
        this.fetchReportData();
      }
    },
    
    // Fetching Data
    async fetchReportData() {
      this.isLoading = true;
      
      try {
        // Construct the API endpoint with query parameters
        const endpoint = `/owner/finance/report?start_date=${this.startDate}&end_date=${this.endDate}`;
        
        const response = await axios.get(endpoint, {
          withCredentials: true,
          headers: {
            'Accept': 'application/json'
          }
        });
        
        if (response.data && Array.isArray(response.data.transactions)) {
          // Process the transaction data
          this.transactions = response.data.transactions.map(transaction => ({
            ...transaction,
            AmountPaid: Number(transaction.AmountPaid) || 0,
            PaymentDate: transaction.PaymentDate || transaction.AppointmentDateTime
          }));
          
          // Process additional statistics if available
          if (response.data.revenueByPaymentMethod) {
            this.revenueByPaymentMethod = response.data.revenueByPaymentMethod;
          } else {
            this.calculateRevenueByPaymentMethod();
          }
          
          if (response.data.topProcedures) {
            this.topProcedures = response.data.topProcedures;
          } else {
            this.calculateTopProcedures();
          }
        } else {
          this.transactions = [];
          this.calculateRevenueByPaymentMethod();
          this.calculateTopProcedures();
          console.warn('Invalid data format received from the server');
        }
      } catch (error) {
        console.error('Error fetching finance report data:', error);
        
        // Extract data from the HR patient billings module
        this.extractDataFromBillings();
      } finally {
        this.isLoading = false;
        this.currentPage = 1; // Reset to first page when fetching new data
      }
    },
    
    // Extract data from existing billings
    async extractDataFromBillings() {
      try {
        // Fetch all billings from the HR module
        const response = await axios.get('/hr/billings', { withCredentials: true });
        
        if (response.data && Array.isArray(response.data)) {
          // Filter billings by date range
          const startDate = new Date(this.startDate);
          const endDate = new Date(this.endDate);
          endDate.setHours(23, 59, 59, 999); // Include the entire end date
          
          const filteredBillings = response.data.filter(billing => {
            const appointmentDate = new Date(billing.AppointmentDateTime);
            return appointmentDate >= startDate && appointmentDate <= endDate && billing.BillingStatus === 'Paid';
          });
          
          // Transform billings into transactions format
          this.transactions = filteredBillings.map(billing => {
            // Determine the payment method from services if available
            let paymentMethod = billing.PaymentMethod || 'N/A';
            let referenceID = billing.ReferenceID || '';
            
            if (billing.services && billing.services.length > 0) {
              const paidService = billing.services.find(s => s.AmountPaid > 0);
              if (paidService) {
                paymentMethod = paidService.PaymentMethod || paymentMethod;
                referenceID = paidService.ReferenceID || referenceID;
              }
            }
            
            return {
              BillingID: billing.BillingID,
              PatientID: billing.PatientID,
              PatientName: billing.PatientName,
              AppointmentDateTime: billing.AppointmentDateTime,
              Procedure: billing.Procedure,
              AmountPaid: Number(billing.AmountPaid) || 0,
              PaymentMethod: paymentMethod,
              PaymentDate: billing.PaymentDate || billing.AppointmentDateTime,
              ReferenceID: referenceID
            };
          });
          
          // Calculate additional statistics
          this.calculateRevenueByPaymentMethod();
          this.calculateTopProcedures();
        } else {
          this.transactions = [];
          console.warn('No billing data available');
        }
      } catch (error) {
        console.error('Error extracting data from billings:', error);
        this.transactions = [];
      }
    },
    
    // Calculate statistics from transactions
    calculateRevenueByPaymentMethod() {
      const revenueMap = {};
      
      this.transactions.forEach(transaction => {
        const method = transaction.PaymentMethod || 'Other';
        if (!revenueMap[method]) {
          revenueMap[method] = 0;
        }
        revenueMap[method] += transaction.AmountPaid;
      });
      
      this.revenueByPaymentMethod = revenueMap;
    },
    
    calculateTopProcedures() {
      const procedureMap = {};
      
      this.transactions.forEach(transaction => {
        const procedure = transaction.Procedure;
        if (!procedureMap[procedure]) {
          procedureMap[procedure] = {
            name: procedure,
            count: 0,
            revenue: 0
          };
        }
        procedureMap[procedure].count += 1;
        procedureMap[procedure].revenue += transaction.AmountPaid;
      });
      
      this.topProcedures = Object.values(procedureMap)
        .sort((a, b) => b.revenue - a.revenue)
        .slice(0, 5); // Get top 5 procedures by revenue
    },
    
    // Filtering
    applyFilters() {
      this.currentPage = 1; // Reset to first page when applying filters
    },
    
    resetFilters() {
      this.searchQuery = '';
      this.paymentTypeFilter = 'all';
      this.currentPage = 1;
    },
    
    // Sorting
    sortBy(key) {
      // If clicking on the same column, toggle sort order
      if (this.sortKey === key) {
        this.sortOrder = this.sortOrder === 'asc' ? 'desc' : 'asc';
      } else {
        // If clicking on a new column, set it as the sort key with default desc order
        this.sortKey = key;
        this.sortOrder = 'desc';
      }
    },
    
    getSortIcon(key) {
      if (this.sortKey !== key) return 'bx bx-sort';
      return this.sortOrder === 'asc' ? 'bx bx-sort-up' : 'bx bx-sort-down';
    },
    
    // Pagination
    goToPage(page) {
      this.currentPage = page;
    },
    
    handlePageSizeChange() {
      this.currentPage = 1; // Reset to first page when changing page size
    },
    
    // Styling helpers
    getPaymentMethodClass(method) {
      if (!method) return '';
      
      const methodLower = method.toLowerCase();
      
      if (methodLower === 'cash') return 'cash';
      if (['gcash', 'paymaya', 'grab pay', 'shopee pay'].includes(methodLower)) return 'e-wallet';
      if (['medicard', 'maxicare', 'intelligentcare'].includes(methodLower)) return 'insurance';
      if (['visa', 'mastercard', 'credit card', 'debit card'].includes(methodLower)) return 'card';
      
      return 'other';
    },
    
    getPaymentMethodColor(method) {
      if (!method) return '#ccc';
      
      const methodLower = method.toLowerCase();
      
      if (methodLower === 'cash') return '#2e7d32'; // Green
      if (['gcash', 'paymaya', 'grab pay', 'shopee pay'].includes(methodLower)) return '#1565c0'; // Blue
      if (['medicard', 'maxicare', 'intelligentcare'].includes(methodLower)) return '#7b1fa2'; // Purple
      if (['visa', 'mastercard', 'credit card', 'debit card'].includes(methodLower)) return '#e65100'; // Orange
      
      return '#616161'; // Gray for others
    },
    
    getPercentage(value, total) {
      if (!total) return 0;
      return Math.round((value / total) * 100);
    },
    
    // Export to CSV
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
      csvContent += 'FINANCE REPORT\r\n';
      csvContent += `Generated on: ${formattedDate} at ${formattedTime}\r\n`;
      csvContent += `Date Range: ${this.formatDate(this.startDate)} to ${this.formatDate(this.endDate)}\r\n\r\n`;
      
      csvContent += 'SUMMARY STATISTICS\r\n';
      csvContent += `Total Revenue,PHP ${this.formatCurrency(this.totalRevenue)}\r\n`;
      csvContent += `Total Payments,${this.totalPayments}\r\n`;
      csvContent += `Unique Patients,${this.uniquePatients}\r\n\r\n`;
      
      csvContent += 'REVENUE BY PAYMENT METHOD\r\n';
      csvContent += 'Payment Method,Amount,Percentage\r\n';
      for (const [method, amount] of Object.entries(this.revenueByPaymentMethod)) {
        csvContent += `${method},PHP ${this.formatCurrency(amount)},${this.getPercentage(amount, this.totalRevenue)}%\r\n`;
      }
      csvContent += '\r\n';
      
      csvContent += 'TOP PROCEDURES\r\n';
      csvContent += 'Procedure,Count,Revenue\r\n';
      this.topProcedures.forEach(procedure => {
        csvContent += `${procedure.name},${procedure.count},PHP ${this.formatCurrency(procedure.revenue)}\r\n`;
      });
      csvContent += '\r\n';
      
      csvContent += 'DETAILED PAYMENT TRANSACTIONS\r\n';
      const headers = ['Appointment Date', 'Patient Name', 'Procedure', 'Amount Paid', 'Payment Method', 'Payment Date', 'Reference ID'];
      csvContent += headers.join(',') + '\r\n';
      
      this.filteredTransactions.forEach(transaction => {
        const rowData = [
          this.formatDateTime(transaction.AppointmentDateTime),
          transaction.PatientName,
          transaction.Procedure,
          `PHP ${this.formatCurrency(transaction.AmountPaid)}`,
          transaction.PaymentMethod,
          this.formatDate(transaction.PaymentDate),
          transaction.ReferenceID || 'N/A'
        ];
        
        // Escape commas in fields by wrapping in quotes
        const escapedRowData = rowData.map(field => {
          if (field.includes(',')) {
            return `"${field}"`;
          }
          return field;
        });
        
        csvContent += escapedRowData.join(',') + '\r\n';
      });
      
      csvContent += `\r\nTotal,,,PHP ${this.formatCurrency(this.totalRevenue)},,\r\n`;
      csvContent += '\r\nEnd of Report';
      csvContent += '\r\nAguila-Titular Dental Clinic - All Rights Reserved';
      
      const encodedUri = encodeURI('data:text/csv;charset=utf-8,' + csvContent);
      const link = document.createElement('a');
      link.setAttribute('href', encodedUri);
      
      const fileDate = now.toISOString().split('T')[0];
      const fileTime = now.toTimeString().split(' ')[0].replace(/:/g, '-');
      link.setAttribute('download', `ATDC_Finance_Report_${fileDate}_${fileTime}.csv`);
      
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
    },
    
    // Print Report to PDF
    printReport() {
      // Create PDF in landscape orientation for better readability
      const doc = new jsPDF({
        orientation: 'landscape',
        unit: 'mm',
        format: 'a4'
      });
      
      const pageWidth = doc.internal.pageSize.getWidth();
      const pageHeight = doc.internal.pageSize.getHeight();
      const margin = 14;
      const primaryColor = [6, 105, 58]; // RGB for #06693A
      
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
      doc.text('FINANCE REPORT', logoX + logoWidth + 10, logoY + 16);
      
      doc.setFontSize(10);
      doc.setTextColor(100);
      doc.setFont(undefined, 'normal');
      doc.text(`Date Range: ${this.formatDate(this.startDate)} to ${this.formatDate(this.endDate)}`, margin, logoY + logoHeight + 10);
      
      const now = new Date();
      const formattedDate = now.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
      const formattedTime = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
      doc.text(`Generated on: ${formattedDate} at ${formattedTime}`, margin, logoY + logoHeight + 18);
      
      doc.setDrawColor(...primaryColor);
      doc.setLineWidth(0.5);
      doc.line(margin, logoY + logoHeight + 22, pageWidth - margin, logoY + logoHeight + 22);
      
      let yPos = logoY + logoHeight + 30;
      
      // Summary Statistics
      doc.setFontSize(12);
      doc.setTextColor(...primaryColor);
      doc.setFont(undefined, 'bold');
      doc.text('SUMMARY STATISTICS', margin, yPos);
      yPos += 8;
      
      doc.setFontSize(10);
      doc.setTextColor(80);
      doc.setFont(undefined, 'normal');
      
      const statsData = [
        ['Total Revenue', `PHP ${this.formatCurrency(this.totalRevenue)}`],
        ['Total Payments', this.totalPayments],
        ['Unique Patients', this.uniquePatients]
      ];
      
      autoTable(doc, {
        startY: yPos,
        head: [['Metric', 'Value']],
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
          1: { cellWidth: 50, halign: 'right' }
        },
        margin: { left: margin }
      });
      
      yPos = doc.lastAutoTable.finalY + 15;
      
      // Revenue by Payment Method
      doc.setFontSize(12);
      doc.setTextColor(...primaryColor);
      doc.setFont(undefined, 'bold');
      doc.text('REVENUE BY PAYMENT METHOD', margin, yPos);
      yPos += 8;
      
      const paymentMethodData = Object.entries(this.revenueByPaymentMethod).map(([method, amount]) => [
        method,
        `PHP ${this.formatCurrency(amount)}`,
        `${this.getPercentage(amount, this.totalRevenue)}%`
      ]);
      
      autoTable(doc, {
        startY: yPos,
        head: [['Payment Method', 'Amount', 'Percentage']],
        body: paymentMethodData,
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
          1: { cellWidth: 50, halign: 'right' },
          2: { cellWidth: 30, halign: 'right' }
        },
        margin: { left: margin }
      });
      
      yPos = doc.lastAutoTable.finalY + 15;
      
      // Top Procedures
      doc.setFontSize(12);
      doc.setTextColor(...primaryColor);
      doc.setFont(undefined, 'bold');
      doc.text('TOP PROCEDURES', margin, yPos);
      yPos += 8;
      
      const procedureData = this.topProcedures.map(procedure => [
        procedure.name,
        procedure.count,
        `PHP ${this.formatCurrency(procedure.revenue)}`
      ]);
      
      autoTable(doc, {
        startY: yPos,
        head: [['Procedure', 'Count', 'Revenue']],
        body: procedureData,
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
          0: { cellWidth: 'auto' },
          1: { cellWidth: 30, halign: 'center' },
          2: { cellWidth: 50, halign: 'right' }
        },
        margin: { left: margin }
      });
      
      yPos = doc.lastAutoTable.finalY + 15;
      
      // Check if we need a new page for the transactions table
      if (yPos > pageHeight - 100) {
        doc.addPage();
        yPos = margin + 20;
        
        // Add header to new page
        doc.setFillColor(...primaryColor);
        doc.rect(margin, margin, 10, 10, 'F');
        doc.setTextColor(255, 255, 255);
        doc.setFontSize(8);
        doc.text('ATDC', margin + 5, margin + 5, { align: 'center', baseline: 'middle' });
        
        doc.setTextColor(...primaryColor);
        doc.setFontSize(10);
        doc.setFont(undefined, 'bold');
        doc.text('AGUILA-TITULAR DENTAL CLINIC - FINANCE REPORT', margin + 15, margin + 6);
      }
      
      // Detailed Transactions
      doc.setFontSize(12);
      doc.setTextColor(...primaryColor);
      doc.setFont(undefined, 'bold');
      doc.text('DETAILED PAYMENT TRANSACTIONS', margin, yPos);
      yPos += 8;
      
      const tableColumn = ["Appointment Date", "Patient Name", "Procedure", "Amount Paid", "Payment Method", "Payment Date", "Reference ID"];
      const tableRows = [];
      
      this.filteredTransactions.forEach(transaction => {
        const rowData = [
          this.formatDateTime(transaction.AppointmentDateTime),
          transaction.PatientName,
          transaction.Procedure,
          `PHP ${this.formatCurrency(transaction.AmountPaid)}`,
          transaction.PaymentMethod,
          this.formatDate(transaction.PaymentDate),
          transaction.ReferenceID || 'N/A'
        ];
        tableRows.push(rowData);
      });
      
      // Add total row
      tableRows.push([
        '', 
        '', 
        'TOTAL', 
        `PHP ${this.formatCurrency(this.totalRevenue)}`, 
        '', 
        '',
        ''
      ]);
      
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
          0: { cellWidth: 35 },
          1: { cellWidth: 35 },
          2: { cellWidth: 'auto' },
          3: { cellWidth: 30, halign: 'right' },
          4: { cellWidth: 30 },
          5: { cellWidth: 35 },
          6: { cellWidth: 30 }
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
            doc.text('AGUILA-TITULAR DENTAL CLINIC - FINANCE REPORT', margin + 15, margin + 6);
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
      doc.save(`ATDC_Finance_Report_${fileDate}_${fileTime}.pdf`);
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

/* Sidebar styles - keeping original styling as requested */
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
  margin-bottom: 20px;
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
  padding-bottom: 50px;
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

/* Dashboard Container */
.dashboard-container {
  padding: 0 20px 30px;
}

/* Report Filters */
.filter-section {
  margin-bottom: 24px;
}

.filter-container {
  background-color: #fff;
  border-radius: 12px;
  padding: 20px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.date-filter {
  margin-bottom: 16px;
}

.period-selector {
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
  margin-bottom: 16px;
}

.period-btn {
  background-color: #f5f5f5;
  border: none;
  border-radius: 8px;
  padding: 10px 16px;
  font-size: 14px;
  font-weight: 500;
  color: #555;
  cursor: pointer;
  transition: all 0.2s ease;
  display: flex;
  align-items: center;
  gap: 8px;
}

.period-btn i {
  font-size: 18px;
}

.period-btn:hover {
  background-color: #e5e5e5;
}

.period-btn.active {
  background-color: #06693A;
  color: #fff;
}

.date-range-picker {
  display: flex;
  gap: 16px;
  align-items: center;
  flex-wrap: wrap;
}

.date-input-group {
  display: flex;
  align-items: center;
  gap: 8px;
}

.date-input-group label {
  font-size: 14px;
  font-weight: 500;
  color: #555;
}

.date-input-group input {
  padding: 10px 12px;
  border: 1px solid #ddd;
  border-radius: 8px;
  font-size: 14px;
}

.apply-btn {
  background-color: #06693A;
  color: white;
  border: none;
  border-radius: 8px;
  padding: 10px 16px;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  transition: background-color 0.2s;
  display: flex;
  align-items: center;
  gap: 8px;
}

.apply-btn:hover {
  background-color: #055a32;
}

.other-filters {
  display: flex;
  gap: 16px;
  align-items: center;
  flex-wrap: wrap;
}

.search-container {
  position: relative;
  flex: 1;
  min-width: 200px;
}

.search-icon {
  position: absolute;
  left: 12px;
  top: 50%;
  transform: translateY(-50%);
  color: #777;
  font-size: 18px;
}

.search-input {
  width: 100%;
  padding: 10px 10px 10px 38px;
  border: 1px solid #ddd;
  border-radius: 8px;
  font-size: 14px;
  transition: border-color 0.2s;
}

.search-input:focus {
  border-color: #06693A;
  outline: none;
}

.payment-type-filter {
  min-width: 180px;
}

.payment-type-filter select {
  width: 100%;
  padding: 10px 12px;
  border: 1px solid #ddd;
  border-radius: 8px;
  font-size: 14px;
  background-color: white;
}

/* Summary Stats Cards */
.summary-stats {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
  gap: 16px;
  margin-bottom: 24px;
}

.stat-card {
  background-color: white;
  border-radius: 12px;
  padding: 20px;
  display: flex;
  align-items: center;
  box-shadow: 0 2px 8px rgba(0,0,0,0.08);
  transition: transform 0.3s, box-shadow 0.3s;
}

.stat-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 6px 12px rgba(0,0,0,0.12);
}

.stat-icon {
  width: 56px;
  height: 56px;
  border-radius: 12px;
  background-color: rgba(6, 105, 58, 0.1);
  color: #06693A;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-right: 16px;
  flex-shrink: 0;
}

.stat-icon i {
  font-size: 28px;
}

.payments-icon {
  background-color: rgba(255, 152, 0, 0.1);
  color: #ff9800;
}

.patients-icon {
  background-color: rgba(3, 169, 244, 0.1);
  color: #03a9f4;
}

.period-icon {
  background-color: rgba(156, 39, 176, 0.1);
  color: #9c27b0;
}

.stat-content {
  flex: 1;
}

.stat-content h3 {
  font-size: 14px;
  color: #666;
  margin-bottom: 8px;
  font-weight: 500;
}

.stat-value {
  font-size: 22px;
  font-weight: 600;
  color: #333;
  margin: 0;
}

.stat-date {
  font-size: 16px;
  font-weight: 500;
  color: #333;
  margin: 0;
}

/* Additional Statistics */
.additional-stats {
  margin-bottom: 24px;
}

.stat-row {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
  gap: 16px;
}

.stat-card-wide {
  background-color: white;
  border-radius: 12px;
  padding: 20px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.08);
  transition: transform 0.3s, box-shadow 0.3s;
}

.stat-card-wide:hover {
  transform: translateY(-4px);
  box-shadow: 0 6px 12px rgba(0,0,0,0.12);
}

.stat-header {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 16px;
  color: #06693A;
}

.stat-header i {
  font-size: 22px;
}

.stat-header h3 {
  font-size: 18px;
  font-weight: 600;
  margin: 0;
}

.stat-chart {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.chart-bar {
  display: flex;
  align-items: center;
  gap: 10px;
  flex-wrap: wrap;
}

.bar-label {
  width: 100px;
  font-size: 14px;
  font-weight: 500;
  color: #555;
}

.bar-container {
  flex: 1;
  height: 12px;
  background-color: #f0f0f0;
  border-radius: 6px;
  overflow: hidden;
}

.bar {
  height: 100%;
  border-radius: 6px;
  transition: width 0.5s ease;
}

.bar-value {
  width: 100px;
  font-size: 14px;
  font-weight: 600;
  color: #333;
  text-align: right;
}

.bar-percentage {
  width: 50px;
  font-size: 14px;
  color: #666;
  text-align: right;
}

.top-procedures {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.procedure-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 12px;
  background-color: #f9f9f9;
  border-radius: 8px;
  transition: background-color 0.2s;
}

.procedure-item:hover {
  background-color: #f0f0f0;
}

.procedure-name {
  font-weight: 500;
  color: #333;
  flex: 1;
}

.procedure-count {
  color: #666;
  margin: 0 16px;
}

.procedure-revenue {
  font-weight: 600;
  color: #06693A;
}

/* Action Buttons */
.action-buttons {
  display: flex;
  gap: 12px;
  margin-bottom: 24px;
  justify-content: flex-end;
}

.action-btn {
  padding: 10px 18px;
  border-radius: 8px;
  font-size: 14px;
  font-weight: 500;
  border: none;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 8px;
  transition: all 0.2s;
}

.action-btn i {
  font-size: 18px;
}

.print-btn {
  background-color: #f5f5f5;
  color: #333;
}

.print-btn:hover {
  background-color: #e0e0e0;
}

.export-btn {
  background-color: #06693A;
  color: white;
}

.export-btn:hover {
  background-color: #055a32;
}

/* Transactions Table */
.transactions-container {
  background-color: white;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.08);
  overflow: hidden;
}

.table-heading {
  padding: 20px;
  border-bottom: 1px solid #eee;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.table-heading h2 {
  font-size: 18px;
  font-weight: 600;
  color: #333;
  margin: 0;
  display: flex;
  align-items: center;
  gap: 8px;
}

.table-heading h2 i {
  color: #06693A;
  font-size: 20px;
}

.record-count {
  font-size: 14px;
  color: #666;
}

.table-responsive {
  overflow-x: auto;
}

.transactions-table {
  width: 100%;
  border-collapse: collapse;
}

.transactions-table th {
  background-color: #f8f9fa;
  padding: 14px 16px;
  text-align: left;
  color: #555;
  font-weight: 600;
  border-bottom: 1px solid #eee;
  cursor: pointer;
  white-space: nowrap;
  font-size: 14px;
  transition: background-color 0.2s;
}

.transactions-table th:hover {
  background-color: #e9ecef;
}

.transactions-table th i {
  font-size: 16px;
  vertical-align: middle;
  margin-left: 4px;
}

.transactions-table td {
  padding: 14px 16px;
  border-bottom: 1px solid #eee;
  color: #333;
  font-size: 14px;
}

.transactions-table tr:last-child td {
  border-bottom: none;
}

.transactions-table tr:hover td {
  background-color: #f8f9fa;
}

.amount {
  font-weight: 600;
  text-align: right;
}

.payment-badge {
  display: inline-block;
  padding: 4px 12px;
  border-radius: 20px;
  font-size: 12px;
  font-weight: 500;
  text-align: center;
}

.payment-badge.cash {
  background-color: #e8f5e9;
  color: #2e7d32;
}

.payment-badge.e-wallet {
  background-color: #e3f2fd;
  color: #1565c0;
}

.payment-badge.insurance {
  background-color: #f3e5f5;
  color: #7b1fa2;
}

.payment-badge.card {
  background-color: #fff3e0;
  color: #e65100;
}

.payment-badge.other {
  background-color: #f5f5f5;
  color: #616161;
}

.transactions-table tfoot {
  background-color: #f8f9fa;
  font-weight: 600;
}

.footer-label {
  text-align: right;
  color: #555;
}

.footer-amount {
  color: #06693A;
  font-weight: 700;
  text-align: right;
}

.no-data {
  text-align: center;
  padding: 40px 20px;
}

.empty-state {
  display: flex;
  flex-direction: column;
  align-items: center;
  color: #666;
}

.empty-state i {
  font-size: 48px;
  margin-bottom: 16px;
  opacity: 0.5;
}

.empty-state p {
  margin-bottom: 16px;
}

.reset-btn {
  padding: 8px 16px;
  background-color: #f5f5f5;
  border: none;
  border-radius: 8px;
  color: #555;
  font-weight: 500;
  cursor: pointer;
  transition: background-color 0.2s;
}

.reset-btn:hover {
  background-color: #e0e0e0;
}

/* Mobile Cards */
.mobile-cards {
  display: none;
  padding: 15px;
}

.transaction-card {
  background-color: white;
  border-radius: 12px;
  border: 1px solid #e0e0e0;
  margin-bottom: 16px;
  overflow: hidden;
  transition: transform 0.2s, box-shadow 0.2s;
  cursor: pointer;
}

.transaction-card:hover {
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

.transaction-info h4 {
  margin: 0 0 8px 0;
  font-size: 16px;
  font-weight: 600;
  color: #333;
}

.transaction-date {
  display: flex;
  flex-direction: column;
  gap: 2px;
}

.transaction-date .date {
  font-size: 14px;
  color: #666;
  font-weight: 500;
}

.transaction-amount {
  text-align: right;
}

.amount-value {
  font-size: 18px;
  font-weight: 700;
  color: #06693A;
}

.card-content-mobile {
  padding: 16px;
}

.card-row {
  margin-bottom: 12px;
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.card-row:last-child {
  margin-bottom: 0;
}

.card-label {
  font-weight: 500;
  color: #666;
  font-size: 14px;
}

.card-value {
  color: #333;
  word-break: break-word;
}

.no-data-mobile {
  text-align: center;
  color: #757575;
  padding: 30px;
  background-color: white;
  border-radius: 12px;
  border: 1px solid #e0e0e0;
}

/* Pagination */
.pagination-controls {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 16px 20px;
  border-top: 1px solid #eee;
}

.page-size {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 14px;
  color: #555;
}

.page-size select {
  padding: 6px 10px;
  border: 1px solid #ddd;
  border-radius: 6px;
  background-color: white;
}

.pagination {
  display: flex;
  align-items: center;
  gap: 8px;
}

.page-btn {
  width: 36px;
  height: 36px;
  border-radius: 6px;
  border: 1px solid #ddd;
  background-color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.2s;
}

.page-btn:hover:not(:disabled) {
  background-color: #f5f5f5;
  border-color: #ccc;
}

.page-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.page-info {
  font-size: 14px;
  color: #555;
  padding: 0 8px;
}

/* Responsive Styles */

/* Large Desktop */
@media (min-width: 1400px) {
  .dashboard-container {
    padding: 0 30px 30px;
  }
}

/* Desktop */
@media (max-width: 1200px) {
  .stat-row {
    grid-template-columns: 1fr;
  }

  .dashboard-container {
    padding: 0 15px 30px;
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

  .summary-stats {
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  }

  .date-range-picker {
    flex-direction: column;
    align-items: flex-start;
  }
  
  .date-input-group {
    width: 100%;
  }
  
  .date-input-group input {
    width: 100%;
  }
  
  .apply-btn {
    width: 100%;
    justify-content: center;
  }
  
  .action-buttons {
    flex-direction: column;
    align-items: stretch;
  }
  
  .pagination-controls {
    flex-direction: column;
    gap: 16px;
  }
  
  .page-size {
    width: 100%;
    justify-content: center;
  }
  
  .chart-bar {
    flex-direction: column;
    align-items: flex-start;
  }
  
  .bar-label, .bar-value, .bar-percentage {
    width: 100%;
    text-align: left;
  }
  
  .procedure-item {
    flex-direction: column;
    align-items: flex-start;
    gap: 8px;
  }
  
  .procedure-count, .procedure-revenue {
    margin: 0;
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

  .dashboard-container {
    padding: 0 10px 30px;
  }

  .filter-container {
    padding: 15px;
  }

  .period-selector {
    flex-direction: column;
    width: 100%;
  }
  
  .period-btn {
    width: 100%;
    justify-content: center;
    padding: 12px 16px;
    font-size: 14px;
    min-height: 44px;
  }

  .period-btn .btn-text {
    display: inline;
  }

  .other-filters {
    flex-direction: column;
  }

  .search-container,
  .payment-type-filter {
    width: 100%;
  }

  .summary-stats {
    grid-template-columns: 1fr;
    gap: 15px;
  }

  .stat-card {
    padding: 15px;
  }

  .stat-icon {
    width: 48px;
    height: 48px;
  }

  .stat-icon i {
    font-size: 24px;
  }

  .stat-value {
    font-size: 18px;
  }

  .stat-date {
    font-size: 14px;
  }

  .stat-card-wide {
    padding: 15px;
  }

  .stat-header h3 {
    font-size: 16px;
  }

  .action-buttons {
    flex-direction: row;
    justify-content: space-between;
    gap: 10px;
  }

  .action-btn {
    flex: 1;
    justify-content: center;
    padding: 12px 8px;
    font-size: 13px;
    min-height: 44px;
  }

  .table-heading {
    padding: 15px;
    flex-direction: column;
    align-items: flex-start;
    gap: 10px;
  }

  .table-heading h2 {
    font-size: 16px;
  }

  .pagination-controls {
    padding: 12px 15px;
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

  .dashboard-container {
    padding: 0 8px 30px;
  }

  .filter-container {
    padding: 12px;
  }

  .date-input-group input,
  .payment-type-filter select {
    padding: 6px 10px;
    font-size: 13px;
  }

  .action-btn {
    padding: 8px 12px;
    font-size: 13px;
  }

  .btn-text {
    display: none;
  }

  /* Keep period button text visible on mobile */
  .period-btn .btn-text {
    display: inline !important;
  }

  .stat-card {
    padding: 12px;
  }

  .stat-icon {
    width: 40px;
    height: 40px;
  }

  .stat-icon i {
    font-size: 20px;
  }

  .stat-value {
    font-size: 16px;
  }

  .stat-content h3 {
    font-size: 12px;
  }

  .stat-card-wide {
    padding: 12px;
  }

  .stat-header h3 {
    font-size: 14px;
  }

  .chart-bar {
    gap: 8px;
  }

  .bar-label {
    font-size: 12px;
  }

  .bar-value, .bar-percentage {
    font-size: 12px;
  }

  .procedure-item {
    padding: 10px;
  }

  .procedure-name {
    font-size: 14px;
  }

  .procedure-count, .procedure-revenue {
    font-size: 12px;
  }

  .transaction-card {
    margin-bottom: 12px;
  }

  .card-header-mobile {
    padding: 12px;
  }

  .transaction-info h4 {
    font-size: 15px;
  }

  .amount-value {
    font-size: 16px;
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

  .table-heading h2 {
    font-size: 14px;
  }

  .record-count {
    font-size: 12px;
  }
}

/* Landscape Mobile */
@media (max-height: 500px) and (orientation: landscape) {
  .sidebar {
    height: 100vh;
    overflow-y: auto;
  }

  .home-content {
    margin-top: 15px;
  }
}

/* Print Styles */
@media print {
  body {
    background: white;
    font-size: 12pt;
    width: 100%;
    height: 100%;
    margin: 0;
    padding: 0;
  }
  
  .sidebar,
  .filter-section,
  .action-buttons,
  .pagination-controls,
  .reset-btn,
  .mobile-overlay {
    display: none !important;
  }
  
  .home-section {
    position: static;
    width: 100%;
    left: 0;
    margin: 0;
    padding: 0;
  }
  
  .dashboard-container {
    padding: 0;
  }
  
  .transactions-container,
  .summary-stats,
  .stat-card,
  .additional-stats,
  .stat-card-wide {
    box-shadow: none;
    margin-bottom: 20px;
    page-break-inside: avoid;
  }
  
  .transactions-table th,
  .transactions-table td {
    padding: 10px;
  }
  
  .transactions-table th {
    background-color: #f5f5f5 !important;
    color: black !important;
  }
  
  .transactions-table tr {
    page-break-inside: avoid;
  }
  
  @page {
    size: landscape;
    margin: 1cm;
  }
}
</style>
