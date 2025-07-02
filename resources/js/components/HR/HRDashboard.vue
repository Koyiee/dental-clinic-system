<template>
  <div class="sidebar close">
    <div class="logo-details">
      <img src="@/components/Images/ATDC_Logo.png" alt="" class="logo">
      <div class="logo_name"><img class="img2" src="@/components/Images/ATDC_Logo3.png" alt=""></div>
    </div>
    <ul class="nav-link">
      <li>
        <a href="/hrdashboard">
          <i class="bx bx-grid-alt"></i>
          <span class="link_name">Dashboard</span>
        </a>
        <ul class="sub-menu blank">
          <li>
            <a class="link_name" href="/hrdashboard">Dashboard</a>
          </li>
        </ul>
      </li>
      <li>
        <div class="icon-link">
          <a href="/hrappointments">
            <i class="bx bx-calendar"></i>
            <span class="link_name">Appointments</span>
          </a>
          <i class="bx bxs-chevron-down arrow"></i>
        </div>
        <ul class="sub-menu">
          <li><a class="link_name" href="/hrappointments">Appointments</a></li>
          <li><a href="/hrcalendarschedule">Calendar Schedule</a></li>
        </ul>
      </li>
      <li>
        <a href="/hrpatientbillings">
          <i class="bx bx-receipt"></i>
          <span class="link_name">Patient Billing</span>
        </a>
        <ul class="sub-menu blank">
          <li>
            <a class="link_name" href="/hrpatientbillings">Patient Billing</a>
          </li>
        </ul>
      </li>
      <li>
        <a href="/hrpatientlist">
          <i class="bx bx-user"></i>
          <span class="link_name">Patient List</span>
        </a>
        <ul class="sub-menu blank">
          <li>
            <a class="link_name" href="/hrpatientlist">Patient List</a>
          </li>
        </ul>
      </li>
      <li>
        <a href="/hrannouncements">
          <i class="bx bx-news"></i>
          <span class="link_name">Announcements</span>
        </a>
        <ul class="sub-menu blank">
          <li>
            <a class="link_name" href="/hrannouncements">Announcements</a>
          </li>
        </ul>
      </li>
      <li>
        <a href="/hrmanageusers">
          <i class="bx bx-group"></i>
          <span class="link_name">Manage Users</span>
        </a>
        <ul class="sub-menu blank">
          <li>
            <a class="link_name" href="/hrmanageusers">Manage Users</a>
          </li>
        </ul>
      </li>
      <li>
        <a href="/hrmanageservices">
          <i class="bx bx-briefcase-alt-2"></i>
          <span class="link_name">Manage Services</span>
        </a>
        <ul class="sub-menu blank">
          <li>
            <a class="link_name" href="/hrmanageservices">Manage Services</a>
          </li>
        </ul>
      </li>
      <li>
        <a href="/hrsettings">
          <i class="bx bx-cog"></i>
          <span class="link_name">Settings</span>
        </a>
        <ul class="sub-menu blank">
          <li>
            <a class="link_name" href="/hrsettings">Settings</a>
          </li>
        </ul>
      </li>
        <li>
          <div class="profile-details" @click="confirmLogout">
            <div class="profile-content">
              <img src="@/components/Images/profile_1.jpg" alt="profile">
            </div>
            <div class="name-job">
              <div class="profile_name">{{fullName}}</div>
              <div class="job">HR Admin</div>
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
            <a class="current" href="/hrdashboard"><p>  Dashboard</p></a>
          </div>
        </div>
      </div>
      <hr color="#06693a">
      
      <!-- Welcome Section -->
      <div class="dashboard-container">
        <div class="welcome-card">
          <div class="welcome-content">
            <h2>Good Day, {{fullName}}!</h2>
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

        <!-- Stats Overview -->
        <div class="stats-overview">
          <div class="stat-card">
            <div class="stat-icon appointments">
              <i class='bx bx-calendar-check'></i>
            </div>
            <div class="stat-content">
              <h3>{{ todayAppointmentsCount }}</h3>
              <p>Today's Appointments</p>
            </div>
          </div>
          <div class="stat-card">
            <div class="stat-icon patients">
              <i class='bx bx-user'></i>
            </div>
            <div class="stat-content">
              <h3>{{ totalPatientsCount }}</h3>
              <p>Total Patients</p>
            </div>
          </div>
          <div class="stat-card">
            <div class="stat-icon revenue">
              <i class='bx bx-money'></i>
            </div>
            <div class="stat-content">
              <h3>₱{{ formatNumber(monthlyRevenue) }}</h3>
              <p>Monthly Revenue</p>
            </div>
          </div>
          <div class="stat-card">
            <div class="stat-icon services">
              <i class='bx bx-briefcase-alt-2'></i>
            </div>
            <div class="stat-content">
              <h3>{{ activeServicesCount }}</h3>
              <p>Active Services</p>
            </div>
          </div>
        </div>

        <!-- Appointments Section -->
        <div class="module-section appointments-section">
          <div class="section-header">
            <i class='bx bx-calendar'></i>
            <h3>Pending Appointments</h3>
            <a href="/hrappointments" class="view-all">View All</a>
          </div>
          <div class="appointments-list">
            <div v-if="pendingAppointments.length === 0" class="empty-state">
              <i class='bx bx-calendar'></i>
              <p>No pending appointments</p>
            </div>
            <div v-for="appointment in pendingAppointments" :key="appointment.AppointmentID" class="appointment-card">
              <div class="appointment-time">
                <i class='bx bx-time'></i>
                <span>{{ formatTime(appointment.AppointmentTime) }}</span>
                <span class="appointment-date">{{ formatDate(appointment.AppointmentDate) }}</span>
              </div>
              <div class="appointment-details">
                <h4>{{ appointment.PatientName }}</h4>
                <div class="appointment-services">
                  <span v-for="(service, i) in getAppointmentServices(appointment)" :key="i" class="service-tag">
                    {{ service }}
                  </span>
                  <span v-if="!getAppointmentServices(appointment).length" class="no-service">
                    No services specified
                  </span>
                </div>
              </div>
              <div class="appointment-dentist">
                <i class='bx bx-user-pin'></i>
                <span>{{ appointment.DentistName || 'Unassigned' }}</span>
              </div>
              <div class="appointment-actions">
                <button 
                  @click="confirmAppointment(appointment.AppointmentID)" 
                  class="action-btn confirm-btn"
                  :disabled="appointment.DentistName === 'Any Dentist'"
                  :class="{ 'disabled-button': appointment.DentistName === 'Any Dentist' }"
                >
                  <i class='bx bx-check'></i> Accept
                </button>
                <button @click="declineAppointment(appointment.AppointmentID)" class="action-btn decline-btn">
                  <i class='bx bx-x'></i> Decline
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Billing Summary -->
        <div class="module-section billing-section">
          <div class="section-header">
            <i class='bx bx-receipt'></i>
            <h3>Billing Summary</h3>
            <a href="/hrpatientbillings" class="view-all">View All</a>
          </div>
          <div class="billing-summary">
            <div class="summary-card">
              <div class="summary-title">Total Revenue</div>
              <div class="summary-value">₱{{ formatNumber(totalRevenue) }}</div>
              <div class="summary-period">All Time</div>
            </div>
            <div class="summary-card">
              <div class="summary-title">Pending Payments</div>
              <div class="summary-value">₱{{ formatNumber(pendingPayments) }}</div>
              <div class="summary-period">{{ pendingInvoicesCount }} invoices</div>
            </div>
            <div class="summary-card">
              <div class="summary-title">This Month</div>
              <div class="summary-value">₱{{ formatNumber(monthlyRevenue) }}</div>
              <div class="summary-period">{{ currentMonthName }}</div>
            </div>
          </div>
          <div class="recent-transactions">
            <h4>Recent Transactions</h4>
            <div v-if="recentTransactions.length === 0" class="empty-state">
              <i class='bx bx-receipt'></i>
              <p>No recent transactions</p>
            </div>
            <div v-for="transaction in recentTransactions" :key="transaction.BillingID" class="transaction-item">
              <div class="transaction-info">
                <div class="transaction-patient">{{ transaction.PatientName }}</div>
                <div class="transaction-date">{{ formatDate(transaction.AppointmentDateTime) }}</div>
              </div>
              <div class="transaction-services">
                {{ transaction.Procedure || 'No services' }}
              </div>
              <div class="transaction-amount">₱{{ formatNumber(transaction.TotalPaid || transaction.Amount) }}</div>
              <div class="transaction-status" :class="getPaymentStatusClass(transaction.BillingStatus)">
                {{ transaction.BillingStatus }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Decline Modal -->
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
  </section>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
  name: 'HRDashboard',
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
      // Time tracking
      timeInterval: null,
      currentTimeValue: new Date(),
      
      // Appointments data
      pendingAppointments: [],
      allAppointments: [],
      
      // Billing data
      allBillings: [],
      recentTransactions: [],
      
      // Patient data
      totalPatientsCount: 0,
      
      // Services data
      uniqueServices: new Set(),
      
      // Notifications
      showConfirmNotification: false,
      showDeclineNotification: false,
      confirmAppointmentData: null,
      declineAppointmentData: null,
      
      // Decline modal
      showDeclineModal: false,
      declineReason: '',
      appointmentToDecline: null,
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
    },
    currentMonthName() {
      return new Date().toLocaleString('default', { month: 'long' });
    },
    todayAppointmentsCount() {
      const today = new Date();
      today.setHours(0, 0, 0, 0);
      const tomorrow = new Date(today);
      tomorrow.setDate(tomorrow.getDate() + 1);

      return this.allAppointments.filter(appointment => {
        const appointmentDate = new Date(appointment.AppointmentDate);
        return (
          appointmentDate >= today &&
          appointmentDate < tomorrow &&
          appointment.Status === 'Confirmed'
        );
      }).length;
    },
    totalRevenue() {
      return this.allBillings.reduce((sum, billing) => {
        return sum + (Number(billing.TotalPaid) || 0);
      }, 0);
    },
    monthlyRevenue() {
      const currentMonth = new Date().getMonth();
      const currentYear = new Date().getFullYear();
      
      return this.allBillings.reduce((sum, billing) => {
        const billingDate = billing.PaymentDate ? new Date(billing.PaymentDate) : 
                           (billing.AppointmentDateTime ? new Date(billing.AppointmentDateTime) : null);
        if (billingDate && billingDate.getMonth() === currentMonth && billingDate.getFullYear() === currentYear) {
          return sum + (Number(billing.TotalPaid) || 0);
        }
        return sum;
      }, 0);
    },
    pendingPayments() {
      return this.allBillings
        .filter(billing => billing.BillingStatus === 'Unpaid')
        .reduce((sum, billing) => {
          return sum + (Number(billing.Amount) || 0);
        }, 0);
    },
    pendingInvoicesCount() {
      return this.allBillings.filter(billing => billing.BillingStatus === 'Unpaid').length;
    },
    activeServicesCount() {
      return this.uniqueServices.size;
    }
  },
  mounted() {
    // Setup sidebar functionality
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

    // Fetch all data
    this.fetchAppointments();
    this.fetchBillings();
    this.fetchPatientCount();
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
    async fetchAppointments() {
      try {
        // Fetch appointments from hrappointments endpoint
        const response = await axios.get('/hrappointments');
        const allAppointments = response.data || [];
        
        // Store all appointments for calculations
        this.allAppointments = allAppointments;
        
        // Filter for pending appointments and limit to 5 for display
        this.pendingAppointments = allAppointments
          .filter(app => app.Status === 'Pending')
          .slice(0, 5);
        
        console.log('Fetched appointments:', this.pendingAppointments);
      } catch (error) {
        console.error("Error fetching appointments:", error);
        this.pendingAppointments = [];
        this.allAppointments = [];
      }
    },

    async fetchPatientCount() {
      try {
        const response = await axios.get('/patient-list', {
          params: {
            page: 1,
            per_page: 1
          }
        });
        this.totalPatientsCount = response.data.total || 0;
      } catch (error) {
        console.error("Error fetching patient count:", error);
        this.totalPatientsCount = 0;
      }
    },
    
    async fetchBillings() {
      try {
        const response = await axios.get('/hr/billings');
        this.allBillings = response.data || [];
        
        // Extract unique services for active services count
        this.uniqueServices = new Set();
        this.allBillings.forEach(billing => {
          if (billing.services && billing.services.length > 0) {
            billing.services.forEach(service => {
              if (service.ServiceName) {
                this.uniqueServices.add(service.ServiceName);
              }
            });
          }
        });
        
        // Get recent transactions (paid billings) for display
        this.recentTransactions = this.allBillings
          .filter(billing => billing.BillingStatus === 'Paid')
          .sort((a, b) => {
            const dateA = a.PaymentDate ? new Date(a.PaymentDate) : new Date(a.AppointmentDateTime || '1970-01-01');
            const dateB = b.PaymentDate ? new Date(b.PaymentDate) : new Date(b.AppointmentDateTime || '1970-01-01');
            return dateB - dateA;
          })
          .slice(0, 5);
        
        console.log('Fetched billings:', this.allBillings);
        console.log('Recent transactions:', this.recentTransactions);
      } catch (error) {
        console.error("Error fetching billings:", error);
        this.allBillings = [];
        this.recentTransactions = [];
      }
    },
    
    getAppointmentServices(appointment) {
      if (!appointment.Services) return [];
      if (Array.isArray(appointment.Services)) return appointment.Services;
      if (typeof appointment.Services === 'string') {
        return appointment.Services.split(',').map(s => s.trim()).filter(s => s);
      }
      return [];
    },
    
    formatDate(dateString) {
      if (!dateString) return 'N/A';
      const date = new Date(dateString);
      if (isNaN(date.getTime())) return 'Invalid Date';
      
      return date.toLocaleDateString('en-US', { 
        year: 'numeric', 
        month: 'short', 
        day: 'numeric' 
      });
    },
    
    formatTime(timeString) {
      if (!timeString) return 'N/A';
      const [hours, minutes] = timeString.split(':');
      const hour = parseInt(hours, 10);
      const ampm = hour >= 12 ? 'PM' : 'AM';
      const hour12 = hour % 12 || 12;
      return `${hour12}:${minutes} ${ampm}`;
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
    
    formatNumber(value) {
      if (typeof value !== 'number' || isNaN(value)) return '0.00';
      return value.toLocaleString('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      });
    },
    
    getPaymentStatusClass(status) {
      if (!status) return 'status-pending';
      
      switch(status.toLowerCase()) {
        case 'paid': return 'status-completed';
        case 'partially paid': return 'status-confirmed';
        case 'unpaid': return 'status-pending';
        default: return 'status-pending';
      }
    },
    
    async confirmAppointment(appointmentId) {
      const appointment = this.pendingAppointments.find(app => app.AppointmentID === appointmentId);
      if (appointment.DentistName === 'Any Dentist') {
        alert("Please assign a dentist before confirming the appointment.");
        return;
      }
      
      this.confirmAppointmentData = { ...appointment };
      try {
        await axios.put(`/hr/appointments/${appointmentId}`, { status: 'Confirmed' });
        this.showConfirmNotification = true;
        
        // Remove the appointment from the list
        this.pendingAppointments = this.pendingAppointments.filter(
          appointment => appointment.AppointmentID !== appointmentId
        );
        
        setTimeout(() => {
          this.showConfirmNotification = false;
          this.confirmAppointmentData = null;
        }, 3000);
        
        // Refresh appointments
        this.fetchAppointments();
      } catch (error) {
        console.error("Error confirming appointment:", error.response?.data || error);
        alert(`Failed to confirm appointment: ${error.response?.data?.message || error.message}`);
      }
    },
    
    declineAppointment(appointmentId) {
      const appointment = this.pendingAppointments.find(app => app.AppointmentID === appointmentId);
      this.appointmentToDecline = appointment;
      this.declineReason = '';
      this.showDeclineModal = true;
      document.body.style.overflow = 'hidden';
    },
    
    closeDeclineModal() {
      this.showDeclineModal = false;
      this.declineReason = '';
      this.appointmentToDecline = null;
      document.body.style.overflow = 'auto';
    },
    
    async submitDecline() {
      if (!this.declineReason.trim()) {
        alert("Please provide a reason for declining the appointment.");
        return;
      }
      
      if (!this.appointmentToDecline) return;
      
      this.declineAppointmentData = { ...this.appointmentToDecline };
      try {
        await axios.put(`/hr/appointments/${this.appointmentToDecline.AppointmentID}`, {
          status: 'Declined',
          declineReason: this.declineReason,
        });
        
        this.showDeclineNotification = true;
        this.closeDeclineModal();
        
        // Remove the appointment from the list
        this.pendingAppointments = this.pendingAppointments.filter(
          appointment => appointment.AppointmentID !== this.appointmentToDecline.AppointmentID
        );
        
        setTimeout(() => {
          this.showDeclineNotification = false;
          this.declineAppointmentData = null;
        }, 3000);
        
        // Refresh appointments
        this.fetchAppointments();
      } catch (error) {
        console.error("Error declining appointment:", error.response?.data || error);
        alert(`Failed to decline appointment: ${error.response?.data?.message || error.message}`);
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
  overflow: hidden; /* Add this to prevent overflow */
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
  padding: 20px;
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

.profile-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

/* Stats Overview */
.stats-overview {
  grid-column: span 12;
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 20px;
}

.stat-card {
  background: white;
  border-radius: 15px;
  padding: 20px;
  display: flex;
  align-items: center;
  gap: 15px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
  transition: transform 0.3s;
}

.stat-card:hover {
  transform: translateY(-5px);
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

.stat-icon.appointments {
  background: rgba(6, 105, 58, 0.1);
  color: #06693A;
}

.stat-icon.patients {
  background: rgba(25, 118, 210, 0.1);
  color: #1976d2;
}

.stat-icon.revenue {
  background: rgba(76, 175, 80, 0.1);
  color: #4caf50;
}

.stat-icon.services {
  background: rgba(245, 124, 0, 0.1);
  color: #f57c00;
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

/* Module Sections */
.module-section {
  background: white;
  border-radius: 15px;
  padding: 20px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}

.appointments-section, .billing-section {
  grid-column: span 6;
}

.section-header {
  display: flex;
  align-items: center;
  margin-bottom: 15px;
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

/* Appointments List */
.appointments-list {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.appointment-card {
  display: flex;
  align-items: center;
  padding: 15px;
  background: #f8f9fa;
  border-radius: 10px;
  gap: 15px;
  transition: transform 0.2s;
}

.appointment-card:hover {
  transform: translateX(5px);
  background: #f0f8f4;
}

.appointment-time {
  display: flex;
  flex-direction: column;
  align-items: center;
  min-width: 80px;
}

.appointment-time i {
  font-size: 20px;
  color: #06693A;
  margin-bottom: 5px;
}

.appointment-time span {
  font-size: 14px;
  font-weight: 500;
  color: #333;
}

.appointment-date {
  font-size: 12px;
  color: #666;
  margin-top: 3px;
}

.appointment-details {
  flex-grow: 1;
}

.appointment-details h4 {
  margin: 0 0 5px;
  font-size: 16px;
  font-weight: 500;
  color: #333;
}

.appointment-services {
  display: flex;
  flex-wrap: wrap;
  gap: 5px;
}

.service-tag {
  background: rgba(6, 105, 58, 0.1);
  color: #06693A;
  font-size: 12px;
  padding: 3px 8px;
  border-radius: 4px;
}

.no-service {
  font-size: 12px;
  color: #666;
  font-style: italic;
}

.appointment-dentist {
  display: flex;
  flex-direction: column;
  align-items: center;
  min-width: 100px;
  font-size: 14px;
  color: #555;
}

.appointment-dentist i {
  font-size: 18px;
  color: #06693A;
  margin-bottom: 5px;
}

.appointment-status {
  font-size: 12px;
  font-weight: 500;
  padding: 4px 10px;
  border-radius: 20px;
  text-align: center;
  min-width: 90px;
}

.status-completed {
  background: #e8f5e9;
  color: #2e7d32;
}

.status-confirmed {
  background: #e3f2fd;
  color: #0277bd;
}

.status-pending {
  background: #f5f5f5;
  color: #616161;
}

.status-declined {
  background: #ffebee;
  color: #c62828;
}

.status-cancelled {
  background: #fbe9e7;
  color: #d84315;
}

/* Billing Summary */
.billing-summary {
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
  color: #06693A;
  margin-bottom: 5px;
}

.summary-period {
  font-size: 12px;
  color: #999;
}

.recent-transactions h4 {
  font-size: 16px;
  font-weight: 500;
  color: #333;
  margin-bottom: 15px;
}

.transaction-item {
  display: flex;
  align-items: center;
  padding: 12px;
  background: #f8f9fa;
  border-radius: 8px;
  margin-bottom: 10px;
  gap: 15px;
}

.transaction-info {
  flex-grow: 1;
}

.transaction-patient {
  font-weight: 500;
  color: #333;
  font-size: 14px;
}

.transaction-date {
  font-size: 12px;
  color: #666;
}

.transaction-services {
  font-size: 13px;
  color: #555;
  max-width: 200px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.transaction-amount {
  font-weight: 600;
  color: #06693A;
  min-width: 80px;
  text-align: right;
}

.transaction-status {
  font-size: 12px;
  font-weight: 500;
  padding: 3px 8px;
  border-radius: 20px;
  text-align: center;
  min-width: 70px;
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

/* Appointment Actions */
.appointment-actions {
  display: flex;
  gap: 8px;
}

.action-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 5px;
  padding: 5px 10px;
  border: none;
  border-radius: 4px;
  font-size: 12px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s;
}

.confirm-btn {
  background-color: #e8f5e9;
  color: #2e7d32;
}

.confirm-btn:hover:not(:disabled) {
  background-color: #c8e6c9;
}

.decline-btn {
  background-color: #ffebee;
  color: #c62828;
}

.decline-btn:hover {
  background-color: #ffcdd2;
}

.disabled-button {
  opacity: 0.6;
  cursor: not-allowed;
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

.decline-modal {
  background: white;
  width: 90%;
  max-width: 800px;
  border-radius: 16px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
  overflow: hidden;
  animation: slideUp 0.3s ease-out;
}

@keyframes slideUp {
  from { transform: translateY(30px); opacity: 0; }
  to { transform: translateY(0); opacity: 1; }
}

.decline-modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px 25px;
  border-bottom: 1px solid #f0f0f0;
  background-color: #06693A;
  color: white;
}

.decline-modal-header h3 {
  margin: 0;
  font-size: 20px;
  font-weight: 600;
}

.close-btn {
  background: rgba(255, 255, 255, 0.2);
  border: none;
  width: 32px;
  height: 32px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  color: white;
  font-size: 20px;
}

.close-btn:hover {
  background: rgba(255, 255, 255, 0.3);
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
  flex-shrink: 0;
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

.form-section {
  margin-bottom: 20px;
}

.form-section label {
  display: flex;
  align-items: center;
  gap: 8px;
  font-weight: 500;
  color: #333;
  margin-bottom: 10px;
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

/* Status Notification */
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
    padding: 15px;
  }

  .stats-overview {
    grid-template-columns: repeat(2, 1fr);
  }

  .appointments-section, .billing-section {
    grid-column: span 12;
  }

  .welcome-content h2 {
    font-size: 22px;
  }

  .billing-summary {
    grid-template-columns: repeat(2, 1fr);
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

  .stats-overview {
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
  }

  .stat-card {
    padding: 15px;
  }

  .stat-icon {
    width: 45px;
    height: 45px;
    font-size: 20px;
  }

  .stat-content h3 {
    font-size: 20px;
  }

  .billing-summary {
    grid-template-columns: repeat(2, 1fr);
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
    padding: 10px;
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

  .stats-overview {
    grid-template-columns: 1fr;
    gap: 12px;
  }

  .stat-card {
    padding: 15px;
    flex-direction: row;
    justify-content: flex-start;
    text-align: left;
  }

  .stat-icon {
    width: 40px;
    height: 40px;
    font-size: 18px;
  }

  .stat-content h3 {
    font-size: 18px;
  }

  .stat-content p {
    font-size: 13px;
  }

  .section-header {
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 12px;
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

  .appointment-card {
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
    font-size: 12px;
  }

  .appointment-date {
    font-size: 11px;
  }

  .appointment-details h4 {
    font-size: 14px;
  }

  .service-tag {
    font-size: 10px;
    padding: 2px 6px;
  }

  .no-service {
    font-size: 11px;
  }

  .appointment-dentist {
    flex-direction: row;
    align-items: center;
    gap: 8px;
    min-width: auto;
    font-size: 12px;
  }

  .appointment-dentist i {
    margin-bottom: 0;
    font-size: 16px;
  }

  .appointment-actions {
    gap: 6px;
    align-self: flex-start;
  }

  .action-btn {
    padding: 4px 8px;
    font-size: 11px;
  }

  .billing-summary {
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

  .summary-period {
    font-size: 11px;
  }

  .recent-transactions h4 {
    font-size: 14px;
    margin-bottom: 12px;
  }

  .transaction-item {
    flex-direction: column;
    align-items: flex-start;
    gap: 8px;
    padding: 10px;
  }

  .transaction-info {
    width: 100%;
  }

  .transaction-patient {
    font-size: 13px;
  }

  .transaction-date {
    font-size: 11px;
  }

  .transaction-services {
    font-size: 12px;
    max-width: none;
    white-space: normal;
    overflow: visible;
    text-overflow: initial;
  }

  .transaction-amount {
    font-size: 14px;
    min-width: auto;
    text-align: left;
    align-self: flex-start;
  }

  .transaction-status {
    font-size: 11px;
    padding: 2px 6px;
    min-width: auto;
    align-self: flex-start;
  }

  .decline-modal {
    width: 95%;
    max-width: none;
  }

  .decline-modal-header {
    padding: 12px 15px;
  }

  .decline-modal-header h3 {
    font-size: 18px;
  }

  .decline-modal-body {
    padding: 15px;
  }

  .decline-modal-footer {
    padding: 12px 15px;
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
    padding: 8px;
    gap: 12px;
  }

  .welcome-card {
    padding: 15px;
  }

  .welcome-content h2 {
    font-size: 18px;
  }

  .stats-overview {
    gap: 10px;
  }

  .stat-card {
    padding: 12px;
  }

  .stat-icon {
    width: 35px;
    height: 35px;
    font-size: 16px;
  }

  .stat-content h3 {
    font-size: 16px;
  }

  .section-header {
    margin-bottom: 10px;
  }

  .section-header h3 {
    font-size: 15px;
  }

  .appointment-card,
  .transaction-item {
    padding: 8px;
  }

  .billing-summary {
    gap: 8px;
  }

  .summary-card {
    padding: 10px;
  }

  .decline-modal-header {
    padding: 12px 15px;
  }

  .decline-modal-body {
    padding: 15px;
  }

  .decline-modal-footer {
    padding: 12px 15px;
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
    margin-bottom: 8px;
  }

  .decline-modal {
    max-height: 90vh;
    overflow-y: auto;
  }
}
</style>
