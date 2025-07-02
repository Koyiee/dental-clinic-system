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
          <h3>Dashboard</h3>
          <div class="breadcrumbs">
            <a class="none" href=""><p>Home / </p></a>
            <a class="current" href="/ownerdashboard"><p> &nbsp;Dashboard</p></a>
          </div>
      </div>
    </div>
    <hr color="#06693a">
    
    <div class="dashboard-container">
      <!-- Welcome Card -->
      <div class="welcome-card">
        <div class="welcome-content">
          <h2>Good Day, {{ fullName }}!</h2>
          <p>Welcome to Aguila-Titular Dental Clinic</p>
          <div class="welcome-date">
            <i class='bx bx-calendar'></i>
            <span>{{ currentDate }}</span>
            <i class='bx bx-time-five'></i>
            <span>{{ currentTime }}</span>
          </div>
        </div>
        <div class="welcome-illustration">
          <img src="@/components/Images/profile_1.jpg" alt="profile" class="profile-image">
        </div>
      </div>

      <!-- Key Metrics -->
      <div class="metrics-container">
        <div class="metric-card">
          <div class="metric-icon appointments">
            <i class='bx bx-calendar-check'></i>
          </div>
          <div class="metric-content">
            <h3>{{ todayAppointments }}</h3>
            <p>Today's Appointments</p>
          </div>
        </div>
        
        <div class="metric-card">
          <div class="metric-icon patients">
            <i class='bx bx-user'></i>
          </div>
          <div class="metric-content">
            <h3>{{ totalPatients }}</h3>
            <p>Total Patients</p>
          </div>
        </div>
        
        <div class="metric-card">
          <div class="metric-icon revenue">
            <i class='bx bx-money'></i>
          </div>
          <div class="metric-content">
            <h3>₱{{ formatCurrency(monthlyRevenue) }}</h3>
            <p>Monthly Revenue</p>
          </div>
        </div>
        
        <div class="metric-card">
          <div class="metric-icon dentists">
            <i class='bx bx-plus-medical'></i>
          </div>
          <div class="metric-content">
            <h3>{{ activeDentists }}</h3>
            <p>Active Dentists</p>
          </div>
        </div>
      </div>

      <!-- Appointments Overview -->
      <div class="appointments-overview">
        <div class="section-header">
          <i class='bx bx-calendar'></i>
          <h3>Appointments Overview</h3>
          <a href="/ownerappointments" class="view-all">View All</a>
        </div>
        
        <div class="appointments-stats">
          <div class="stat-item">
            <div class="stat-value">{{ pendingAppointments }}</div>
            <div class="stat-label">Pending</div>
            <div class="progress-bar">
              <div class="progress" :style="`width: ${(pendingAppointments / totalAppointments) * 100}%`"></div>
            </div>
          </div>
          
          <div class="stat-item">
            <div class="stat-value">{{ confirmedAppointments }}</div>
            <div class="stat-label">Confirmed</div>
            <div class="progress-bar">
              <div class="progress confirmed" :style="`width: ${(confirmedAppointments / totalAppointments) * 100}%`"></div>
            </div>
          </div>
          
          <div class="stat-item">
            <div class="stat-value">{{ completedAppointments }}</div>
            <div class="stat-label">Completed</div>
            <div class="progress-bar">
              <div class="progress completed" :style="`width: ${(completedAppointments / totalAppointments) * 100}%`"></div>
            </div>
          </div>
          
          <div class="stat-item">
            <div class="stat-value">{{ cancelledAppointments }}</div>
            <div class="stat-label">Cancelled</div>
            <div class="progress-bar">
              <div class="progress cancelled" :style="`width: ${(cancelledAppointments / totalAppointments) * 100}%`"></div>
            </div>
          </div>
        </div>
        
        <div class="upcoming-appointments">
          <h4>Today's Appointments</h4>
          <div v-if="todayAppointmentsList.length === 0" class="empty-state">
            <i class='bx bx-calendar-x'></i>
            <p>No appointments scheduled for today</p>
          </div>
          <div v-else class="appointment-list">
            <div v-for="appointment in todayAppointmentsList" :key="appointment.AppointmentID" class="appointment-item">
              <div class="appointment-time">
                <i class='bx bx-time'></i>
                <span>{{ formatTime(appointment.AppointmentTime) }}</span>
              </div>
              <div class="appointment-details">
                <h5>{{ appointment.PatientName }}</h5>
                <div class="appointment-services">
                  <span v-for="(service, i) in appointment.Services" :key="i" class="service-tag">
                    {{ service }}
                  </span>
                  <span v-if="!appointment.Services || appointment.Services.length === 0">
                    No services specified
                  </span>
                </div>
              </div>
              <div class="appointment-dentist">
                <i class='bx bx-user-circle'></i>
                <span>{{ appointment.DentistName || 'Unassigned' }}</span>
              </div>
              <div class="appointment-status" :class="getStatusClass(appointment.Status)">
                {{ appointment.Status }}
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Financial Overview -->
      <div class="financial-overview">
        <div class="section-header">
          <i class='bx bx-bar-chart-alt-2'></i>
          <h3>Financial Overview</h3>
          <a href="/ownerfinancereports" class="view-all">View Report</a>
        </div>
        
        <div class="financial-summary">
          <div class="summary-card">
            <div class="summary-title">Monthly Revenue</div>
            <div class="summary-value">₱{{ formatCurrency(monthlyRevenue) }}</div>
            <div class="summary-change" :class="revenueGrowth >= 0 ? 'increase' : 'decrease'">
              <i :class="revenueGrowth >= 0 ? 'bx bx-up-arrow-alt' : 'bx bx-down-arrow-alt'"></i>
              <span>{{ Math.abs(revenueGrowth).toFixed(1) }}% from last month</span>
            </div>
          </div>
          
          <div class="summary-card">
            <div class="summary-title">Top Service</div>
            <div class="summary-value">{{ topService.name }}</div>
            <div class="summary-detail">₱{{ formatCurrency(topService.revenue) }} revenue</div>
          </div>
          
          <div class="summary-card">
            <div class="summary-title">Avg. Revenue per Patient</div>
            <div class="summary-value">₱{{ formatCurrency(avgRevenuePerPatient) }}</div>
            <div class="summary-detail">Based on {{ totalPayments }} payments</div>
          </div>
        </div>
        
        <div class="top-services">
          <h4>Top Services by Revenue</h4>
          <div class="services-list">
            <div v-for="(service, index) in topServices" :key="index" class="service-item">
              <div class="service-rank">{{ index + 1 }}</div>
              <div class="service-info">
                <div class="service-name">{{ service.name }}</div>
                <div class="service-progress">
                  <div class="progress-bar">
                    <div class="progress" :style="`width: ${(service.revenue / topServices[0].revenue) * 100}%`"></div>
                  </div>
                </div>
              </div>
              <div class="service-revenue">₱{{ formatCurrency(service.revenue) }}</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Patient Overview -->
      <div class="patient-overview">
        <div class="section-header">
          <i class='bx bx-user'></i>
          <h3>Patient Overview</h3>
          <a href="/ownerpatientlist" class="view-all">View All</a>
        </div>
        
        <div class="patient-stats">
          <div class="stat-card">
            <div class="stat-value">{{ totalPatients }}</div>
            <div class="stat-label">Total Patients</div>
          </div>
          
          <div class="stat-card">
            <div class="stat-value">{{ newPatients }}</div>
            <div class="stat-label">New This Month</div>
          </div>
          
          <div class="stat-card">
            <div class="stat-value">{{ returningPatients }}</div>
            <div class="stat-label">Returning Patients</div>
          </div>
        </div>
        
        <div class="recent-patients">
          <h4>Recently Added Patients</h4>
          <div v-if="recentPatients.length === 0" class="empty-state">
            <i class='bx bx-user-x'></i>
            <p>No patients added recently</p>
          </div>
          <div v-else class="patient-list">
            <div v-for="patient in recentPatients" :key="patient.PatientID" class="patient-item">
              <div class="patient-avatar">
                <i class='bx bx-user-circle'></i>
              </div>
              <div class="patient-info">
                <div class="patient-name">{{ patient.FirstName }} {{ patient.LastName }}</div>
                <div class="patient-contact">{{ patient.ContactNumber }}</div>
              </div>
              <div class="patient-date">
                <i class='bx bx-calendar-plus'></i>
                <span>{{ formatDate(patient.CreatedAt) }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Staff Overview -->
      <div class="staff-overview">
        <div class="section-header">
          <i class='bx bx-group'></i>
          <h3>Staff Overview</h3>
          <a href="/ownermanageusers" class="view-all">Manage Users</a>
        </div>
        
        <div class="staff-stats">
          <div class="stat-card">
            <div class="stat-icon dentists">
              <i class='bx bx-plus-medical'></i>
            </div>
            <div class="stat-content">
              <h3>{{ activeDentists }}</h3>
              <p>Active Dentists</p>
            </div>
          </div>
          
          <div class="stat-card">
            <div class="stat-icon admins">
              <i class='bx bx-user-check'></i>
            </div>
            <div class="stat-content">
              <h3>{{ activeAdmins }}</h3>
              <p>HR Admins</p>
            </div>
          </div>
        </div>
        
        <div class="dentist-performance">
          <h4>Dentist Performance</h4>
          <div class="performance-list">
            <div v-for="dentist in topDentists" :key="dentist.id" class="performance-item">
              <div class="dentist-info">
                <div class="dentist-avatar">
                  <i class='bx bx-user-circle'></i>
                </div>
                <div class="dentist-name">{{ dentist.name }}</div>
              </div>
              <div class="performance-stats">
                <div class="performance-stat">
                  <div class="stat-label">Appointments</div>
                  <div class="stat-value">{{ dentist.appointments }}</div>
                </div>
                <div class="performance-stat">
                  <div class="stat-label">Revenue</div>
                  <div class="stat-value">₱{{ formatCurrency(dentist.revenue) }}</div>
                </div>
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
name: "OwnerDashboard",
props: {
  firstName: {
    type: String,
    required: true,
  },
  lastName: {
    type: String,
    required: true,
  },
},
data() {
  return {
    // Time and date
    currentTimeValue: new Date(),
    timeInterval: null,
    
    // Appointments data
    todayAppointmentsList: [],
    pendingAppointments: 0,
    confirmedAppointments: 0,
    completedAppointments: 0,
    cancelledAppointments: 0,
    totalAppointments: 0,
    todayAppointments: 0,
    
    // Financial data
    monthlyRevenue: 0,
    revenueGrowth: 0,
    topService: { name: 'N/A', revenue: 0 },
    avgRevenuePerPatient: 0,
    topServices: [],
    totalPayments: 0,
    revenueByPaymentMethod: {},
    
    // Patient data
    totalPatients: 0,
    newPatients: 0,
    returningPatients: 0,
    recentPatients: [],
    uniquePatients: 0,
    
    // Staff data
    activeDentists: 0,
    activeAdmins: 0,
    topDentists: []
  };
},
computed: {
  fullName() {
    return `${this.firstName} ${this.lastName}`;
  },
  currentDate() {
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    return this.currentTimeValue.toLocaleDateString('en-US', options);
  },
  currentTime() {
    const options = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true };
    return this.currentTimeValue.toLocaleTimeString('en-US', options);
  }
},
mounted() {
  // Setup sidebar
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
  
  // Update time every second
  this.timeInterval = setInterval(() => {
    this.currentTimeValue = new Date();
  }, 1000);
  
  // Fetch all dashboard data
  this.fetchDashboardData();
},
beforeUnmount() {
  // Clear the interval when component is destroyed
  if (this.timeInterval) {
    clearInterval(this.timeInterval);
  }
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
  async fetchDashboardData() {
    try {
      // Fetch appointments data
      await this.fetchAppointmentsData();
      
      // Fetch financial data
      await this.fetchFinancialData();
      
      // Fetch patient data
      await this.fetchPatientData();
      
      // Fetch staff data
      await this.fetchStaffData();
      
    } catch (error) {
      console.error("Error fetching dashboard data:", error);
    }
  },
  
  async fetchAppointmentsData() {
    try {
      const response = await axios.get('/hrappointments');
      
      // Filter today's appointments
      const today = new Date();
      today.setHours(0, 0, 0, 0);
      const tomorrow = new Date(today);
      tomorrow.setDate(today.getDate() + 1);
      
      this.todayAppointmentsList = response.data.filter(event => {
        const eventDate = new Date(event.AppointmentDate);
        return eventDate >= today && eventDate < tomorrow;
      });
      
      this.pendingAppointments = response.data.filter(app => app.Status === 'Pending').length;
      this.confirmedAppointments = response.data.filter(app => app.Status === 'Confirmed').length;
      this.completedAppointments = response.data.filter(app => app.Status === 'Completed').length;
      this.cancelledAppointments = response.data.filter(app => app.Status === 'Cancelled').length;
      this.totalAppointments = response.data.length;
      this.todayAppointments = this.todayAppointmentsList.length;
      
    } catch (error) {
      console.error("Error fetching appointments data:", error);
    }
  },
  
  async fetchFinancialData() {
    try {
      // Get current date for default period
      const now = new Date();
      const startDate = new Date(now.getFullYear(), now.getMonth(), 1).toISOString().split('T')[0]; // First day of current month
      const endDate = new Date(now.getFullYear(), now.getMonth() + 1, 0).toISOString().split('T')[0]; // Last day of current month
      
      // Fetch financial data from the finance report endpoint
      const response = await axios.get(`/owner/finance/report?start_date=${startDate}&end_date=${endDate}`);
      
      if (response.data && response.data.transactions) {
        // Calculate monthly revenue from actual payments
        const transactions = response.data.transactions;
        this.monthlyRevenue = transactions.reduce((sum, transaction) => sum + Number(transaction.AmountPaid || 0), 0);
        this.totalPayments = transactions.length;
        
        // Get unique patients count
        const uniquePatientIds = new Set(transactions.map(t => t.PatientID));
        this.uniquePatients = uniquePatientIds.size;
        
        // Calculate average revenue per patient
        this.avgRevenuePerPatient = this.uniquePatients > 0 ? this.monthlyRevenue / this.uniquePatients : 0;
        
        // Process revenue by payment method
        if (response.data.revenueByPaymentMethod) {
          this.revenueByPaymentMethod = response.data.revenueByPaymentMethod;
        } else {
          // Calculate revenue by payment method from transactions
          const revenueMap = {};
          transactions.forEach(transaction => {
            const method = transaction.PaymentMethod || 'Other';
            if (!revenueMap[method]) {
              revenueMap[method] = 0;
            }
            revenueMap[method] += Number(transaction.AmountPaid || 0);
          });
          this.revenueByPaymentMethod = revenueMap;
        }
        
        // Process top procedures
        if (response.data.topProcedures) {
          this.topServices = response.data.topProcedures.slice(0, 5).map(proc => ({
            name: proc.name,
            revenue: proc.revenue
          }));
          
          // Set top service
          if (this.topServices.length > 0) {
            this.topService = this.topServices[0];
          }
        } else {
          // Calculate top procedures from transactions
          const procedureMap = {};
          transactions.forEach(transaction => {
            const procedure = transaction.Procedure;
            if (!procedureMap[procedure]) {
              procedureMap[procedure] = {
                name: procedure,
                revenue: 0
              };
            }
            procedureMap[procedure].revenue += Number(transaction.AmountPaid || 0);
          });
          
          this.topServices = Object.values(procedureMap)
            .sort((a, b) => b.revenue - a.revenue)
            .slice(0, 5);
          
          // Set top service
          if (this.topServices.length > 0) {
            this.topService = this.topServices[0];
          }
        }
      }
      
      // Get previous month's data to calculate growth
      const prevMonthStart = new Date(now.getFullYear(), now.getMonth() - 1, 1).toISOString().split('T')[0];
      const prevMonthEnd = new Date(now.getFullYear(), now.getMonth(), 0).toISOString().split('T')[0];
      
      try {
        const prevMonthResponse = await axios.get(`/owner/finance/report?start_date=${prevMonthStart}&end_date=${prevMonthEnd}`);
        
        if (prevMonthResponse.data && prevMonthResponse.data.transactions) {
          const prevMonthTransactions = prevMonthResponse.data.transactions;
          const prevMonthRevenue = prevMonthTransactions.reduce((sum, transaction) => sum + Number(transaction.AmountPaid || 0), 0);
          
          // Calculate growth percentage
          if (prevMonthRevenue > 0) {
            this.revenueGrowth = ((this.monthlyRevenue - prevMonthRevenue) / prevMonthRevenue) * 100;
          } else {
            this.revenueGrowth = 0;
          }
        }
      } catch (error) {
        console.error("Error fetching previous month financial data:", error);
        
        // Fallback to HR billings if finance report API fails
        await this.fetchFinancialDataFromBillings();
      }
    } catch (error) {
      console.error("Error fetching financial data:", error);
      
      // Fallback to HR billings if finance report API fails
      await this.fetchFinancialDataFromBillings();
    }
  },
  
  async fetchFinancialDataFromBillings() {
    try {
      // Fetch all billings from the HR module
      const response = await axios.get('/hr/billings', { withCredentials: true });
      
      if (response.data && Array.isArray(response.data)) {
        // Get current month date range
        const now = new Date();
        const startDate = new Date(now.getFullYear(), now.getMonth(), 1);
        const endDate = new Date(now.getFullYear(), now.getMonth() + 1, 0);
        endDate.setHours(23, 59, 59, 999); // Include the entire end date
        
        // Filter billings for current month
        const currentMonthBillings = response.data.filter(billing => {
          const paymentDate = new Date(billing.PaymentDate || billing.AppointmentDateTime);
          return paymentDate >= startDate && paymentDate <= endDate && billing.BillingStatus === 'Paid';
        });
        
        // Calculate monthly revenue from amount paid
        this.monthlyRevenue = currentMonthBillings.reduce((sum, billing) => sum + Number(billing.AmountPaid || 0), 0);
        this.totalPayments = currentMonthBillings.length;
        
        // Get unique patients
        const uniquePatientIds = new Set(currentMonthBillings.map(b => b.PatientID));
        this.uniquePatients = uniquePatientIds.size;
        
        // Calculate average revenue per patient
        this.avgRevenuePerPatient = this.uniquePatients > 0 ? this.monthlyRevenue / this.uniquePatients : 0;
        
        // Calculate revenue by payment method
        const revenueMap = {};
        currentMonthBillings.forEach(billing => {
          let paymentMethod = billing.PaymentMethod || 'N/A';
          
          // Try to get payment method from services if available
          if (billing.services && billing.services.length > 0) {
            const paidService = billing.services.find(s => s.AmountPaid > 0);
            if (paidService) {
              paymentMethod = paidService.PaymentMethod || paymentMethod;
            }
          }
          
          if (!revenueMap[paymentMethod]) {
            revenueMap[paymentMethod] = 0;
          }
          revenueMap[paymentMethod] += Number(billing.AmountPaid || 0);
        });
        this.revenueByPaymentMethod = revenueMap;
        
        // Calculate top procedures
        const procedureMap = {};
        currentMonthBillings.forEach(billing => {
          const procedure = billing.Procedure;
          if (!procedureMap[procedure]) {
            procedureMap[procedure] = {
              name: procedure,
              revenue: 0
            };
          }
          procedureMap[procedure].revenue += Number(billing.AmountPaid || 0);
        });
        
        this.topServices = Object.values(procedureMap)
          .sort((a, b) => b.revenue - a.revenue)
          .slice(0, 5);
        
        // Set top service
        if (this.topServices.length > 0) {
          this.topService = this.topServices[0];
        }
        
        // Calculate revenue growth
        // Get previous month date range
        const prevMonthStart = new Date(now.getFullYear(), now.getMonth() - 1, 1);
        const prevMonthEnd = new Date(now.getFullYear(), now.getMonth(), 0);
        prevMonthEnd.setHours(23, 59, 59, 999);
        
        // Filter billings for previous month
        const prevMonthBillings = response.data.filter(billing => {
          const paymentDate = new Date(billing.PaymentDate || billing.AppointmentDateTime);
          return paymentDate >= prevMonthStart && paymentDate <= prevMonthEnd && billing.BillingStatus === 'Paid';
        });
        
        // Calculate previous month revenue
        const prevMonthRevenue = prevMonthBillings.reduce((sum, billing) => sum + Number(billing.AmountPaid || 0), 0);
        
        // Calculate growth percentage
        if (prevMonthRevenue > 0) {
          this.revenueGrowth = ((this.monthlyRevenue - prevMonthRevenue) / prevMonthRevenue) * 100;
        } else {
          this.revenueGrowth = 0;
        }
      }
    } catch (error) {
      console.error("Error fetching financial data from billings:", error);
    }
  },
  
  async fetchPatientData() {
    try {
      const response = await axios.get('/patient-list');
      
      this.totalPatients = response.data.total;
      this.recentPatients = response.data.data.slice(0, 5).map(patient => ({
        PatientID: patient.PatientID,
        FirstName: patient.user.FirstName,
        LastName: patient.user.LastName,
        ContactNumber: patient.user.ContactNumber,
        CreatedAt: patient.user.CreatedAt
      }));
      
      // Get new patients this month
      try {
        const newPatientsResponse = await axios.get('/patient-list?filter=new-this-month');
        this.newPatients = newPatientsResponse.data.total;
        
        // Calculate returning patients (total - new)
        this.returningPatients = this.totalPatients - this.newPatients;
      } catch (error) {
        console.error("Error fetching new patients data:", error);
        this.newPatients = 0;
        this.returningPatients = 0;
      }
      
    } catch (error) {
      console.error("Error fetching patient data:", error);
    }
  },
  
  async fetchStaffData() {
    try {
      const response = await axios.get('/hr/dentist-mapping');
      
      this.activeDentists = response.data.length;
      
      // Get active admins count
      try {
        const adminsResponse = await axios.get('/hr/admin-users');
        this.activeAdmins = adminsResponse.data.filter(admin => admin.Status === 'Active').length;
        
        // Get dentist performance data
        const dentistPerformanceResponse = await axios.get('/hr/dentist-performance');
        this.topDentists = dentistPerformanceResponse.data
          .sort((a, b) => b.revenue - a.revenue)
          .slice(0, 3)
          .map(dentist => ({
            id: dentist.DentistID,
            name: dentist.Name,
            appointments: dentist.CompletedAppointments,
            revenue: dentist.TotalRevenue
          }));
      } catch (error) {
        console.error("Error fetching staff performance data:", error);
        this.activeAdmins = 0;
        this.topDentists = [];
      }
      
    } catch (error) {
      console.error("Error fetching staff data:", error);
    }
  },
  
  formatCurrency(value) {
    return value.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
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
    if (!status) return 'status-pending';
    switch(status.toLowerCase()) {
      case 'completed': return 'status-completed';
      case 'confirmed': return 'status-confirmed';
      case 'pending': return 'status-pending';
      case 'cancelled': return 'status-cancelled';
      case 'declined': return 'status-declined';
      default: return 'status-pending';
    }
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
overflow: hidden; /* Add this to prevent overflow */
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
max-width: 100%; /* Ensure it doesn't exceed container */
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
min-width: 0; /* Add this to allow proper text truncation */
}

.sidebar .profile-details .profile_name {
color: #06693A;
font-size: 16px;
font-weight: 500;
white-space: nowrap;
overflow: hidden;
text-overflow: ellipsis;
max-width: 100%; /* Ensure it doesn't exceed container */
}

/* Dashboard Container */
.dashboard-container {
padding: 0 20px 30px;
display: grid;
grid-template-columns: repeat(12, 1fr);
gap: 20px;
}

/* Welcome Card */
.welcome-card {
grid-column: span 12;
background: linear-gradient(135deg, #06693A, #0a8c4e);
border-radius: 15px;
padding: 30px;
color: white;
display: flex;
justify-content: space-between;
align-items: center;
box-shadow: 0 10px 20px rgba(6, 105, 58, 0.1);
}

.welcome-content h2 {
font-size: 24px;
font-weight: 600;
margin-bottom: 10px;
}

.welcome-content p {
font-size: 16px;
opacity: 0.9;
margin-bottom: 15px;
}

.welcome-date {
display: flex;
align-items: center;
gap: 8px;
font-size: 14px;
opacity: 0.8;
}

.welcome-illustration {
background: rgba(255, 255, 255, 0.2);
width: 80px;
height: 80px;
border-radius: 50%;
display: flex;
align-items: center;
justify-content: center;
overflow: hidden;
border: 5px solid white;
}

.welcome-illustration .profile-image {
width: 100%;
height: 100%;
object-fit: cover;
}

/* Metrics Container */
.metrics-container {
grid-column: span 12;
display: grid;
grid-template-columns: repeat(4, 1fr);
gap: 20px;
}

.metric-card {
background: white;
border-radius: 15px;
padding: 20px;
display: flex;
align-items: center;
gap: 15px;
box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
transition: transform 0.3s;
}

.metric-card:hover {
transform: translateY(-5px);
}

.metric-icon {
width: 50px;
height: 50px;
border-radius: 12px;
display: flex;
align-items: center;
justify-content: center;
font-size: 24px;
flex-shrink: 0;
}

.metric-icon.appointments {
background: rgba(6, 105, 58, 0.1);
color: #06693A;
}

.metric-icon.patients {
background: rgba(25, 118, 210, 0.1);
color: #1976d2;
}

.metric-icon.revenue {
background: rgba(245, 124, 0, 0.1);
color: #f57c00;
}

.metric-icon.dentists {
background: rgba(156, 39, 176, 0.1);
color: #9c27b0;
}

.metric-icon.admins {
background: rgba(76, 175, 80, 0.1);
color: #4caf50;
}

.metric-content h3 {
font-size: 24px;
font-weight: 600;
margin: 0 0 5px;
color: #333;
}

.metric-content p {
margin: 0;
color: #666;
font-size: 14px;
}

/* Section Headers */
.section-header {
display: flex;
align-items: center;
margin-bottom: 20px;
gap: 10px;
}

.section-header i {
font-size: 24px;
color: #06693A;
}

.section-header h3 {
font-size: 18px;
font-weight: 600;
color: #333;
flex-grow: 1;
}

.view-all {
font-size: 14px;
color: #06693A;
text-decoration: none;
display: flex;
align-items: center;
}

.view-all:hover {
text-decoration: underline;
}

/* Appointments Overview */
.appointments-overview {
grid-column: span 6;
background: white;
border-radius: 15px;
padding: 20px;
box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}

.appointments-stats {
display: grid;
grid-template-columns: repeat(4, 1fr);
gap: 15px;
margin-bottom: 20px;
}

.stat-item {
text-align: center;
}

.stat-value {
font-size: 24px;
font-weight: 600;
color: #333;
}

.stat-label {
font-size: 14px;
color: #666;
margin-bottom: 5px;
}

.progress-bar {
height: 6px;
background: #f0f0f0;
border-radius: 3px;
overflow: hidden;
}

.progress {
height: 100%;
background: #06693A;
border-radius: 3px;
}

.progress.confirmed {
background: #1976d2;
}

.progress.completed {
background: #2e7d32;
}

.progress.cancelled {
background: #c62828;
}

.upcoming-appointments h4 {
font-size: 16px;
font-weight: 600;
color: #333;
margin-bottom: 15px;
}

.appointment-list {
display: flex;
flex-direction: column;
gap: 10px;
}

.appointment-item {
display: flex;
align-items: center;
padding: 12px;
background: #f8f9fa;
border-radius: 10px;
gap: 12px;
transition: transform 0.2s;
}

.appointment-item:hover {
transform: translateX(5px);
background: #f0f8f4;
}

.appointment-time {
display: flex;
flex-direction: column;
align-items: center;
min-width: 60px;
}

.appointment-time i {
font-size: 18px;
color: #06693A;
margin-bottom: 3px;
}

.appointment-time span {
font-size: 12px;
font-weight: 500;
color: #333;
}

.appointment-details {
flex-grow: 1;
}

.appointment-details h5 {
margin: 0 0 3px;
font-size: 14px;
font-weight: 500;
color: #333;
}

.appointment-services {
display: flex;
flex-wrap: wrap;
gap: 4px;
}

.service-tag {
background: rgba(6, 105, 58, 0.1);
color: #06693A;
font-size: 10px;
padding: 2px 6px;
border-radius: 4px;
}

.appointment-dentist {
display: flex;
align-items: center;
gap: 5px;
font-size: 12px;
color: #666;
min-width: 100px;
}

.appointment-status {
font-size: 11px;
font-weight: 500;
padding: 3px 8px;
border-radius: 20px;
text-align: center;
min-width: 70px;
}

.status-pending {
background: #e3f2fd;
color: #0277bd;
}

.status-confirmed {
background: #e0f7fa;
color: #00838f;
}

.status-completed {
background: #e8f5e9;
color: #2e7d32;
}

.status-cancelled, .status-declined {
background: #ffebee;
color: #c62828;
}

/* Financial Overview */
.financial-overview {
grid-column: span 6;
background: white;
border-radius: 15px;
padding: 20px;
box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}

.financial-summary {
display: grid;
grid-template-columns: repeat(3, 1fr);
gap: 15px;
margin-bottom: 20px;
}

.summary-card {
background: #f8f9fa;
border-radius: 10px;
padding: 15px;
text-align: center;
}

.summary-title {
font-size: 14px;
color: #666;
margin-bottom: 5px;
}

.summary-value {
font-size: 20px;
font-weight: 600;
color: #333;
margin-bottom: 5px;
}

.summary-change {
font-size: 12px;
display: flex;
align-items: center;
justify-content: center;
gap: 3px;
}

.summary-change.increase {
color: #2e7d32;
}

.summary-change.decrease {
color: #c62828;
}

.summary-detail {
font-size: 12px;
color: #666;
}

.top-services h4 {
font-size: 16px;
font-weight: 600;
color: #333;
margin-bottom: 15px;
}

.services-list {
display: flex;
flex-direction: column;
gap: 10px;
}

.service-item {
display: flex;
align-items: center;
gap: 12px;
}

.service-rank {
width: 24px;
height: 24px;
background: #06693A;
color: white;
border-radius: 50%;
display: flex;
align-items: center;
justify-content: center;
font-size: 12px;
font-weight: 600;
flex-shrink: 0;
}

.service-info {
flex-grow: 1;
}

.service-name {
font-size: 14px;
font-weight: 500;
color: #333;
margin-bottom: 5px;
}

.service-progress {
width: 100%;
}

.service-revenue {
font-size: 14px;
font-weight: 600;
color: #06693A;
min-width: 80px;
text-align: right;
}

/* Patient Overview */
.patient-overview {
grid-column: span 6;
background: white;
border-radius: 15px;
padding: 20px;
box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}

.patient-stats {
display: grid;
grid-template-columns: repeat(3, 1fr);
gap: 15px;
margin-bottom: 20px;
}

.stat-card {
background: #f8f9fa;
border-radius: 10px;
padding: 15px;
text-align: center;
display: flex;
align-items: center;
gap: 15px;
}

.stat-value {
font-size: 24px;
font-weight: 600;
color: #333;
}

.stat-label {
font-size: 14px;
color: #666;
}

.stat-icon {
width: 50px;
height: 50px;
border-radius: 12px;
display: flex;
align-items: center;
justify-content: center;
font-size: 24px;
flex-shrink: 0;
}

.stat-content h3 {
font-size: 24px;
font-weight: 600;
margin: 0 0 5px;
color: #333;
}

.stat-content p {
margin: 0;
color: #666;
font-size: 14px;
}

.recent-patients h4 {
font-size: 16px;
font-weight: 600;
color: #333;
margin-bottom: 15px;
}

.patient-list {
display: flex;
flex-direction: column;
gap: 10px;
}

.patient-item {
display: flex;
align-items: center;
padding: 12px;
background: #f8f9fa;
border-radius: 10px;
gap: 12px;
}

.patient-avatar {
width: 40px;
height: 40px;
background: rgba(6, 105, 58, 0.1);
border-radius: 50%;
display: flex;
align-items: center;
justify-content: center;
color: #06693A;
font-size: 20px;
flex-shrink: 0;
}

.patient-info {
flex-grow: 1;
}

.patient-name {
font-size: 14px;
font-weight: 500;
color: #333;
}

.patient-contact {
font-size: 12px;
color: #666;
}

.patient-date {
display: flex;
align-items: center;
gap: 5px;
font-size: 12px;
color: #666;
}

/* Staff Overview */
.staff-overview {
grid-column: span 6;
background: white;
border-radius: 15px;
padding: 20px;
box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}

.staff-stats {
display: grid;
grid-template-columns: repeat(2, 1fr);
gap: 15px;
margin-bottom: 20px;
}

.dentist-performance h4 {
font-size: 16px;
font-weight: 600;
color: #333;
margin-bottom: 15px;
}

.performance-list {
display: flex;
flex-direction: column;
gap: 10px;
}

.performance-item {
display: flex;
justify-content: space-between;
align-items: center;
padding: 12px;
background: #f8f9fa;
border-radius: 10px;
}

.dentist-info {
display: flex;
align-items: center;
gap: 10px;
}

.dentist-avatar {
width: 40px;
height: 40px;
background: rgba(156, 39, 176, 0.1);
border-radius: 50%;
display: flex;
align-items: center;
justify-content: center;
color: #9c27b0;
font-size: 20px;
flex-shrink: 0;
}

.dentist-name {
font-size: 14px;
font-weight: 500;
color: #333;
}

.performance-stats {
display: flex;
gap: 15px;
}

.performance-stat {
text-align: center;
}

/* Empty State */
.empty-state {
display: flex;
flex-direction: column;
align-items: center;
justify-content: center;
padding: 30px;
color: #999;
text-align: center;
}

.empty-state i {
font-size: 40px;
margin-bottom: 10px;
opacity: 0.5;
}

/* Responsive Design */

/* Large Desktop */
@media (min-width: 1400px) {
.dashboard-container {
  max-width: 1400px;
  margin: 0 auto;
}
}

/* Desktop */
@media (max-width: 1200px) {
.dashboard-container {
  gap: 15px;
  padding: 0 15px 30px;
}

.metrics-container {
  grid-template-columns: repeat(2, 1fr);
}

.appointments-overview,
.financial-overview,
.patient-overview,
.staff-overview {
  grid-column: span 12;
}

.welcome-content h2 {
  font-size: 22px;
}

.financial-summary {
  grid-template-columns: 1fr;
  gap: 12px;
}

.patient-stats {
  grid-template-columns: 1fr;
  gap: 12px;
}

.staff-stats {
  grid-template-columns: 1fr;
  gap: 12px;
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
  width: 250px; /* Match the sidebar width */
  padding: 6px 8px; /* Add horizontal padding to prevent edge overflow */
}

.sidebar.close .profile-details {
  width: 78px;
  padding: 6px 0;
}

.sidebar .profile-details .profile_name {
  font-size: 14px; /* Slightly smaller font for tablet */
  max-width: 120px; /* Constrain width on tablet */
}

.sidebar .profile-details .job {
  font-size: 11px; /* Slightly smaller font for tablet */
  max-width: 120px; /* Constrain width on tablet */
}

.home-section {
  left: 250px;
  width: calc(100% - 250px);
}

.sidebar.close ~ .home-section {
  left: 78px;
  width: calc(100% - 78px);
}

.welcome-card {
  flex-direction: column;
  text-align: center;
  gap: 20px;
  padding: 25px;
}

.welcome-date {
  justify-content: center;
  flex-wrap: wrap;
}

.metrics-container {
  grid-template-columns: repeat(2, 1fr);
  gap: 15px;
}

.metric-card {
  padding: 15px;
}

.metric-icon {
  width: 45px;
  height: 45px;
  font-size: 20px;
}

.metric-content h3 {
  font-size: 20px;
}

.appointments-stats {
  grid-template-columns: repeat(2, 1fr);
  gap: 12px;
}

.stat-value {
  font-size: 20px;
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

.dashboard-container {
  padding: 0 10px 30px;
  gap: 15px;
}

.welcome-card {
  padding: 20px;
  flex-direction: column;
  text-align: center;
  gap: 15px;
}

.welcome-content h2 {
  font-size: 20px;
}

.welcome-content p {
  font-size: 14px;
}

.welcome-date {
  font-size: 12px;
  flex-direction: column;
  gap: 5px;
}

.welcome-illustration {
  width: 60px;
  height: 60px;
}

.metrics-container {
  grid-template-columns: 1fr;
  gap: 12px;
}

.metric-card {
  padding: 15px;
  flex-direction: row;
  justify-content: flex-start;
  text-align: left;
}

.metric-icon {
  width: 40px;
  height: 40px;
  font-size: 18px;
}

.metric-content h3 {
  font-size: 18px;
}

.metric-content p {
  font-size: 13px;
}

.section-header {
  flex-wrap: wrap;
  gap: 8px;
  margin-bottom: 15px;
}

.section-header h3 {
  font-size: 16px;
}

.section-header i {
  font-size: 20px;
}

.view-all {
  font-size: 12px;
}

.appointments-stats {
  grid-template-columns: repeat(2, 1fr);
  gap: 10px;
  margin-bottom: 15px;
}

.stat-value {
  font-size: 18px;
}

.stat-label {
  font-size: 12px;
}

.upcoming-appointments h4,
.top-services h4,
.recent-patients h4,
.dentist-performance h4 {
  font-size: 14px;
  margin-bottom: 12px;
}

.appointment-item {
  flex-direction: column;
  align-items: flex-start;
  gap: 10px;
  padding: 12px;
}

.appointment-time {
  flex-direction: row;
  align-items: center;
  gap: 8px;
  min-width: auto;
}

.appointment-time i {
  margin-bottom: 0;
  font-size: 16px;
}

.appointment-time span {
  font-size: 11px;
}

.appointment-details h5 {
  font-size: 13px;
}

.service-tag {
  font-size: 9px;
  padding: 1px 4px;
}

.appointment-dentist {
  font-size: 11px;
  min-width: auto;
}

.appointment-status {
  font-size: 10px;
  padding: 2px 6px;
  min-width: auto;
  align-self: flex-start;
}

.financial-summary {
  grid-template-columns: 1fr;
  gap: 10px;
  margin-bottom: 15px;
}

.summary-card {
  padding: 12px;
}

.summary-title {
  font-size: 12px;
}

.summary-value {
  font-size: 16px;
}

.summary-change {
  font-size: 11px;
}

.summary-detail {
  font-size: 11px;
}

.service-item {
  gap: 8px;
}

.service-rank {
  width: 20px;
  height: 20px;
  font-size: 10px;
}

.service-name {
  font-size: 12px;
  margin-bottom: 3px;
}

.service-revenue {
  font-size: 12px;
  min-width: 60px;
}

.patient-stats {
  grid-template-columns: 1fr;
  gap: 10px;
  margin-bottom: 15px;
}

.stat-card {
  padding: 12px;
  flex-direction: row;
  text-align: left;
}

.stat-value {
  font-size: 16px;
}

.stat-label {
  font-size: 12px;
}

.patient-item {
  padding: 10px;
  gap: 10px;
}

.patient-avatar {
  width: 35px;
  height: 35px;
  font-size: 16px;
}

.patient-name {
  font-size: 13px;
}

.patient-contact {
  font-size: 11px;
}

.patient-date {
  font-size: 11px;
}

.staff-stats {
  grid-template-columns: 1fr;
  gap: 10px;
  margin-bottom: 15px;
}

.performance-item {
  flex-direction: column;
  align-items: flex-start;
  gap: 10px;
  padding: 12px;
}

.dentist-info {
  gap: 8px;
}

.dentist-avatar {
  width: 35px;
  height: 35px;
  font-size: 16px;
}

.dentist-name {
  font-size: 13px;
}

.performance-stats {
  gap: 12px;
  align-self: stretch;
  justify-content: space-around;
}

.performance-stat {
  text-align: center;
}

.performance-stat .stat-label {
  font-size: 11px;
}

.performance-stat .stat-value {
  font-size: 13px;
}
}

/* Small Mobile */
@media (max-width: 480px) {
.home-content .bx-menu {
  font-size: 28px;
}

.text h3 {
  font-size: 18px;
}

.dashboard-container {
  padding: 0 8px 30px;
  gap: 12px;
}

.welcome-card {
  padding: 15px;
}

.welcome-content h2 {
  font-size: 18px;
}

.metrics-container {
  gap: 10px;
}

.metric-card {
  padding: 12px;
}

.metric-icon {
  width: 35px;
  height: 35px;
  font-size: 16px;
}

.metric-content h3 {
  font-size: 16px;
}

.section-header {
  margin-bottom: 12px;
}

.section-header h3 {
  font-size: 15px;
}

.appointments-stats {
  grid-template-columns: 1fr;
  gap: 8px;
}

.appointment-item,
.service-item,
.patient-item,
.performance-item {
  padding: 10px;
}

.financial-summary,
.patient-stats,
.staff-stats {
  gap: 8px;
}
}

/* Landscape Mobile */
@media (max-height: 500px) and (orientation: landscape) {
.welcome-card {
  padding: 15px;
}

.welcome-content h2 {
  font-size: 16px;
  margin-bottom: 5px;
}

.welcome-content p {
  font-size: 12px;
  margin-bottom: 8px;
}

.welcome-date {
  font-size: 11px;
}

.welcome-illustration {
  width: 50px;
  height: 50px;
}

.dashboard-container {
  gap: 10px;
}

.section-header {
  margin-bottom: 10px;
}
}
</style>
