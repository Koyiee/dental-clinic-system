<template>
  <div class="sidebar close">
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
          <li>
            <a class="link_name" href="/patientdashboard">Dashboard</a>
          </li>
        </ul>
      </li>
      <li>
        <a href="/patientannouncements">
          <i class="bx bxs-megaphone"></i>
          <span class="link_name">Announcements</span>
        </a>
        <ul class="sub-menu blank">
          <li>
            <a class="link_name" href="/patientannouncements">Announcements</a>
          </li>
        </ul>
      </li>
      <li>
        <a href="/patientinformation">
          <i class="bx bx-clipboard"></i>
          <span class="link_name">Patient Information</span>
        </a>
        <ul class="sub-menu blank">
          <li>
            <a class="link_name" href="/patientinformation">Patient Information</a>
          </li>
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
          <li>
            <a class="link_name" href="/patientappointments">Appointment</a>
          </li>
          <li>
            <a href="/patientscheduleanappointment">Schedule Appointment</a>
          </li>
        </ul>
      </li>
      <li>
        <a href="/patientbillings">
          <i class="bx bx-wallet"></i>
          <span class="link_name">Billing</span>
        </a>
        <ul class="sub-menu blank">
          <li>
            <a class="link_name" href="/patientbillings">Billing</a>
          </li>
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
          <li>
            <a class="link_name" href="/patienttreatments">Treatments</a>
          </li>
          <li>
            <a href="/patienttreatmentplan">Treatment Plan</a>
          </li>
          <li>
            <a href="/patientdentalphotos">Dental Photos</a>
          </li>
          <li>
            <a href="/patientforms">Forms</a>
          </li>
          <li>
            <a href="/patientdentaltreatmenthistory">Dental Treatment History</a>
          </li>
        </ul>
      </li>
      <li>
        <a href="/patientsettings">
          <i class="bx bx-cog"></i>
          <span class="link_name">Settings</span>
        </a>
        <ul class="sub-menu blank">
          <li>
            <a class="link_name" href="/patientsettings">Settings</a>
          </li>
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
          <h3>Dashboard</h3>
          <div class="breadcrumbs">
            <a class="none" href=""><p>Home / </p></a>
            <a class="current" href="/patientdashboard"><p> Dashboard</p></a>
          </div>
        </div>
      </div>
      <hr color="#06693a">
      
      <div class="dashboard-container">
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
            <img 
                v-if="profilePicture && profilePicture !== ''" 
                :src="`/storage/${profilePicture}`" 
                alt="profile" 
                class="profile-image" 
                @error="handleImageError"
              >
              <img 
                v-else 
                src="@/components/Images/profile_1.jpg" 
                alt="profile" 
                class="profile-image"
              >
          </div>
        </div>
        
        <div class="quick-actions-container">
          <div class="section-header">
            <i class='bx bx-bulb'></i>
            <h3>Quick Actions</h3>
          </div>
          <div class="actions-grid">
            <a href="/patientscheduleanappointment" class="action-card">
              <i class='bx bx-calendar-plus'></i>
              <span>Schedule Appointment</span>
            </a>
            <a href="/patienttreatmentplan" class="action-card">
              <i class='bx bx-list-check'></i>
              <span>View Treatment Plan</span>
            </a>
            <a href="/patientbillings" class="action-card">
              <i class='bx bx-credit-card'></i>
              <span>Billings History</span>
            </a>
            <a href="/patientforms" class="action-card">
              <i class='bx bx-file'></i>
              <span>Complete Forms</span>
            </a>
          </div>
        </div>
        
        <div v-if="hasUpdatedAppointments" class="notification-container">
          <div class="section-header">
            <i class='bx bx-bell'></i>
            <h3>Appointment Updates</h3>
          </div>
          <div class="notification-list">
            <div v-for="(appointment, index) in updatedAppointments" :key="appointment.AppointmentID" class="notification-card">
              <div class="notification-icon">
                <i class='bx bx-check-circle'></i>
              </div>
              <div class="notification-content">
                <p>
                  {{ appointment.StatusMessage }} Scheduled for {{ appointment.AppointmentDate }} at {{ appointment.AppointmentTime }} with {{ appointment.DentistName }}. 
                  Services: {{ appointment.services }}.
                </p>
                <a href="/patientappointments" class="notification-link">View details</a>
              </div>
              <button @click="dismissNotification(appointment.AppointmentID, index)" class="notification-dismiss">
                <i class='bx bx-x'></i>
              </button>
            </div>
          </div>
        </div>
        
        <div class="appointments-container">
          <div class="section-header">
            <i class='bx bx-calendar-check'></i>
            <h3>Upcoming Appointments</h3>
            <a href="/patientappointments" class="view-all">View All</a>
          </div>
          <div class="appointments-list">
            <div v-if="isLoading.appointments" class="loading-spinner">
              <i class='bx bx-loader-alt bx-spin'></i>
              <span>Loading appointments...</span>
            </div>
            <div v-else-if="upcomingAppointments.length === 0" class="empty-state">
              <i class='bx bx-calendar-x'></i>
              <p>No upcoming appointments</p>
              <a href="/patientscheduleanappointment" class="action-button"> Schedule Now </a>
            </div>
            <div v-else>
              <div v-for="appointment in upcomingAppointments.slice(0, 3)" :key="appointment.AppointmentID" class="appointment-card">
                <div class="appointment-time">
                  <i class='bx bx-time'></i>
                  <span>{{ formatAppointmentTime(appointment.AppointmentTime) }}</span>
                  <span class="appointment-date">{{ formatAppointmentDate(appointment.AppointmentDate) }}</span>
                </div>
                <div class="appointment-details">
                  <h4>{{ appointment.Services && appointment.Services.length > 0 ? appointment.Services.join(', ') : 'Dental Appointment' }}</h4>
                  <p>with Dr. {{ appointment.DentistName || 'TBD' }}</p>
                </div>
                <div class="appointment-status" :class="getStatusClass(appointment.AppointmentStatus)">
                  {{ appointment.AppointmentStatus }}
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <div class="announcements-container">
          <div class="section-header">
            <i class='bx bx-news'></i>
            <h3>Recent Announcements</h3>
            <a href="/patientannouncements" class="view-all">View All</a>
          </div>
          <div class="announcements-list">
            <div v-if="isLoading.announcements" class="loading-spinner">
              <i class='bx bx-loader-alt bx-spin'></i>
              <span>Loading announcements...</span>
            </div>
            <div v-else-if="recentAnnouncements.length === 0" class="empty-state">
              <i class='bx bx-megaphone'></i>
              <p>No recent announcements</p>
            </div>
            <div v-else>
              <div v-for="announcement in recentAnnouncements.slice(0, 3)" :key="announcement.AnnouncementId" class="announcement-card">
                <div class="announcement-header">
                  <div class="announcement-title">{{ announcement.AnnouncementTitle }}</div>
                  <div class="announcement-date">{{ formatDate(announcement.created_at) }}</div>
                </div>
                <div class="announcement-content">
                  <p>{{ truncateText(announcement.AnnouncementDescription, 100) }}</p>
                </div>
                <div class="announcement-footer">
                  <span class="announcement-author">
                    <i class='bx bx-user'></i> {{ announcement.CreatedBy }}
                  </span>
                  <button @click="viewAnnouncementDetails(announcement)" class="read-more">Read more</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div v-if="selectedAnnouncement" class="modal-overlay" @click="closeAnnouncementModal">
        <div class="modal-content" @click.stop>
          <div class="modal-header">
            <h3>{{ selectedAnnouncement.AnnouncementTitle }}</h3>
            <button class="close-button" @click="closeAnnouncementModal">
              <i class='bx bx-x'></i>
            </button>
          </div>
          <div class="modal-body">
            <div class="modal-meta">
              <div class="meta-item">
                <i class='bx bx-calendar'></i>
                <span>{{ formatDate(selectedAnnouncement.created_at) }}</span>
              </div>
              <div class="meta-item">
                <i class='bx bx-user'></i>
                <span>{{ selectedAnnouncement.CreatedBy }}</span>
              </div>
            </div>
            
            <div class="modal-description">
              {{ selectedAnnouncement.AnnouncementDescription }}
            </div>
            
            <div v-if="selectedAnnouncement.AnnouncementPicture" class="modal-image-container">
              <img 
                :src="selectedAnnouncement.AnnouncementPicture" 
                alt="Announcement Image" 
                class="modal-image"
                @error="handleImageError"
              />
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
  name: "PatientDashboard",
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
      profilePicture: sessionStorage.getItem('user_profile_picture') || null,
      updatedAppointments: [],
      upcomingAppointments: [],
      recentAnnouncements: [],
      recentTreatments: [],
      isLoading: {
        appointments: true,
        announcements: true,
        treatments: true
      },
      selectedAnnouncement: null,
      errors: {
        appointments: null,
        announcements: null,
        treatments: null
      },
      timeInterval: null,
      currentTimeValue: new Date()
    };
  },
  computed: {
    fullName() {
      return `${this.firstName} ${this.lastName}`;
    },
    hasUpdatedAppointments() {
      return this.updatedAppointments.length > 0;
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
    this.setupSidebar();
    this.fetchAllData();
    this.fetchPatientData();
    this.timeInterval = setInterval(() => {
      this.currentTimeValue = new Date();
    }, 1000);
  },
  beforeUnmount() {
    if (this.timeInterval) {
      clearInterval(this.timeInterval);
    }
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
        const overlay = document.querySelector(".mobile-overlay");
        if (window.innerWidth <= 768) {
          overlay.classList.toggle("active");
        }
      });
    },
    closeMobileSidebar() {
      const sidebar = document.querySelector(".sidebar");
      const overlay = document.querySelector(".mobile-overlay");
      if (window.innerWidth <= 768) {
        sidebar.classList.add("close");
        overlay.classList.remove("active");
      }
    },
    async fetchAllData() {
      this.fetchUpdatedAppointments();
      this.fetchUpcomingAppointments();
      this.fetchRecentAnnouncements();
      this.fetchRecentTreatments();
    },
    async fetchUpdatedAppointments() {
      try {
        const response = await axios.get('/patient/updated-appointments');
        this.updatedAppointments = response.data;
      } catch (error) {
        console.error('Error fetching updated appointments:', error);
      }
    },
    async dismissNotification(appointmentId, index) {
      try {
        await axios.post(`/patient/appointments/${appointmentId}/mark-as-viewed`);
        this.updatedAppointments.splice(index, 1);
      } catch (error) {
        console.error('Error marking appointment as viewed:', error);
      }
    },
    async fetchUpcomingAppointments() {
      this.isLoading.appointments = true;
      try {
        const response = await axios.get('/patientappointments');
        this.upcomingAppointments = response.data.upcoming || [];
        this.upcomingAppointments = this.upcomingAppointments.filter(app => 
          app.AppointmentStatus !== 'Declined' && 
          app.AppointmentStatus !== 'Cancelled'
        );
      } catch (error) {
        console.error("Error fetching appointments:", error);
        this.errors.appointments = "Failed to load appointments";
        this.upcomingAppointments = [];
      } finally {
        this.isLoading.appointments = false;
      }
    },
    async fetchRecentAnnouncements() {
      this.isLoading.announcements = true;
      try {
        const response = await axios.get('/announcements/patient');
        const now = new Date();
        this.recentAnnouncements = response.data
          .filter(announcement => {
            const startDate = new Date(announcement.StartDate);
            const endDate = new Date(announcement.EndDate);
            return startDate <= now && endDate >= now && announcement.Status === 'active';
          })
          .sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
      } catch (error) {
        console.error("Error fetching announcements:", error);
        this.errors.announcements = "Failed to load announcements";
        this.recentAnnouncements = [];
      } finally {
        this.isLoading.announcements = false;
      }
    },  
    viewAnnouncementDetails(announcement) {
      this.selectedAnnouncement = announcement;
    }, 
    closeAnnouncementModal() {
      this.selectedAnnouncement = null;
    },
    async fetchRecentTreatments() {
      this.isLoading.treatments = true;
      try {
        const response = await axios.get('/api/patienttreatments/new');
        this.recentTreatments = response.data.sort((a, b) => new Date(b.dateAdded) - new Date(a.dateAdded));
      } catch (error) {
        console.error("Error fetching treatments:", error);
        this.errors.treatments = "Failed to load treatments";
        this.recentTreatments = [];
      } finally {
        this.isLoading.treatments = false;
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
    formatDate(date) {
      if (!date) return "N/A";
      const parsedDate = new Date(date);
      return isNaN(parsedDate.getTime()) ? "N/A" : parsedDate.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
      });
    },  
    formatAppointmentDate(dateString) {
      if (!dateString) return "N/A";
      const date = new Date(dateString);
      return date.toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric'
      });
    },   
    formatAppointmentTime(timeString) {
      if (!timeString) return "N/A";
      const timeParts = timeString.split(':');
      if (timeParts.length < 2) return timeString;
      let hours = parseInt(timeParts[0]);
      const minutes = timeParts[1];
      const ampm = hours >= 12 ? 'PM' : 'AM';
      hours = hours % 12;
      hours = hours ? hours : 12;
      return `${hours}:${minutes} ${ampm}`;
    },   
    truncateText(text, maxLength) {
      if (!text) return "";
      return text.length > maxLength ? text.substring(0, maxLength) + "..." : text;
    },  
    getStatusClass(status) {
      if (!status) return "";
      status = status.toLowerCase();
      if (status === 'confirmed') return 'status-confirmed';
      if (status === 'pending') return 'status-pending';
      if (status === 'cancelled') return 'status-cancelled';
      if (status === 'completed') return 'status-completed';
      if (status === 'scheduled') return 'status-scheduled';
      return '';
    }, 
    handleImageError(event) {
      console.error("Failed to load image:", event);
      event.target.src = "@/components/Images/placeholder-image.jpg";
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
  background: #F2F2F2;
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

.welcome-illustration .profile-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

/* Notification Container */
.notification-container {
  grid-column: span 12;
  background: white;
  border-radius: 15px;
  padding: 20px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
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

.notification-list {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.notification-card {
  display: flex;
  align-items: flex-start;
  background: #f8f9fa;
  border-radius: 10px;
  padding: 15px;
  gap: 15px;
  position: relative;
}

.notification-icon {
  background: rgba(6, 105, 58, 0.1);
  width: 40px;
  height: 40px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #06693A;
  font-size: 20px;
  flex-shrink: 0;
}

.notification-content {
  flex-grow: 1;
}

.notification-content p {
  margin: 0 0 8px 0;
  color: #333;
  line-height: 1.5;
}

.notification-link {
  color: #06693A;
  font-size: 14px;
  font-weight: 500;
  text-decoration: none;
}

.notification-link:hover {
  text-decoration: underline;
}

.notification-dismiss {
  background: none;
  border: none;
  color: #999;
  cursor: pointer;
  font-size: 18px;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 5px;
  border-radius: 50%;
  transition: all 0.2s;
  position: absolute;
  top: 10px;
  right: 10px;
}

.notification-dismiss:hover {
  background: rgba(0, 0, 0, 0.05);
  color: #666;
}

/* Quick Actions Container */
.quick-actions-container {
  grid-column: span 12;
  background: white;
  border-radius: 15px;
  padding: 20px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}

.actions-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 15px;
}

.action-card {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 20px;
  background-color: #f9f9f9;
  border-radius: 10px;
  text-decoration: none;
  transition: all 0.3s ease;
}

.action-card:hover {
  background-color: #06693A;
  color: white;
  transform: translateY(-5px);
}

.action-card i {
  font-size: 30px;
  color: #06693A;
  margin-bottom: 10px;
  transition: color 0.3s ease;
}

.action-card:hover i {
  color: white;
}

.action-card span {
  font-size: 14px;
  font-weight: 500;
  color: #333;
  text-align: center;
  transition: color 0.3s ease;
}

.action-card:hover span {
  color: white;
}

/* Appointments Container */
.appointments-container {
  grid-column: span 12;
  background: white;
  border-radius: 15px;
  padding: 20px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}

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
  text-align: center;
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

.appointment-details p {
  margin: 0;
  font-size: 14px;
  color: #666;
}

.appointment-status {
  font-size: 12px;
  font-weight: 500;
  padding: 4px 10px;
  border-radius: 20px;
  text-align: center;
  min-width: 90px;
}

.status-scheduled {
  background: #e3f2fd;
  color: #0277bd;
}

.status-confirmed {
  background: #e0f7fa;
  color: #00838f;
}

.status-pending {
  background: #fff8e1;
  color: #ff8f00;
}

.status-cancelled {
  background: #ffebee;
  color: #c62828;
}

.status-completed {
  background: #e8f5e9;
  color: #2e7d32;
}

/* Announcements Container */
.announcements-container {
  grid-column: span 12;
  background: white;
  border-radius: 15px;
  padding: 20px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}

.announcements-list {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.announcement-card {
  background: #f8f9fa;
  border-radius: 10px;
  overflow: hidden;
  transition: transform 0.2s;
}

.announcement-card:hover {
  transform: translateY(-5px);
}

.announcement-header {
  padding: 15px 15px 10px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.announcement-title {
  font-weight: 500;
  color: #333;
}

.announcement-date {
  font-size: 12px;
  color: #666;
}

.announcement-content {
  padding: 0 15px 10px;
}

.announcement-content p {
  margin: 0;
  color: #555;
  font-size: 14px;
  line-height: 1.5;
}

.announcement-footer {
  padding: 10px 15px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: rgba(6, 105, 58, 0.05);
  font-size: 12px;
}

.announcement-author {
  display: flex;
  align-items: center;
  gap: 5px;
  color: #666;
}

.announcement-author i {
  font-size: 14px;
  color: #06693A;
}

.read-more {
  color: #06693A;
  text-decoration: none;
  font-weight: 500;
  background: none;
  border: none;
  cursor: pointer;
  padding: 0;
}

.read-more:hover {
  text-decoration: underline;
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

.action-button {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background-color: #06693A;
  color: white;
  border: none;
  padding: 16px 16px;
  border-radius: 6px;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  text-decoration: none;
  transition: background-color 0.2s;
  margin-top: 10px;
}

.action-button:hover {
  background-color: #055a32;
}

/* Modal */
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

.modal-content {
  width: 90%;
  max-width: 800px;
  max-height: 90vh;
  background-color: white;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
  animation: modalFadeIn 0.3s ease;
}

@keyframes modalFadeIn {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
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

.modal-header .close-button {
  background: none;
  border: none;
  font-size: 24px;
  color: #777;
  cursor: pointer;
  transition: color 0.3s ease;
}

.modal-header .close-button:hover {
  color: #333;
}

.modal-body {
  padding: 25px;
  overflow-y: auto;
  max-height: calc(90vh - 70px);
}

.modal-meta {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  margin-bottom: 25px;
}

.meta-item {
  display: flex;
  align-items: center;
  gap: 8px;
  color: #666;
  font-size: 14px;
}

.meta-item i {
  font-size: 18px;
  color: #06693A;
}

.modal-description {
  font-size: 16px;
  line-height: 1.7;
  color: #333;
  margin-bottom: 25px;
  white-space: pre-line;
}

.modal-image-container {
  width: 100%;
  border-radius: 8px;
  overflow: hidden;
  margin-bottom: 20px;
}

.modal-image {
  width: 100%;
  max-height: 500px;
  object-fit: contain;
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
  
  .actions-grid {
    grid-template-columns: repeat(2, 1fr);
  }
  
  .welcome-content h2 {
    font-size: 22px;
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
  
  .actions-grid {
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
  }
  
  .action-card {
    padding: 15px;
  }
  
  .action-card i {
    font-size: 24px;
  }
  
  .action-card span {
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
  
  .actions-grid {
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
  }
  
  .action-card {
    padding: 15px 10px;
  }
  
  .action-card i {
    font-size: 20px;
    margin-bottom: 8px;
  }
  
  .action-card span {
    font-size: 12px;
  }
  
  .section-header {
    flex-wrap: wrap;
    gap: 8px;
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
  
  .notification-card {
    flex-direction: column;
    text-align: left;
    gap: 10px;
    padding: 12px;
  }
  
  .notification-icon {
    width: 35px;
    height: 35px;
    font-size: 16px;
    align-self: flex-start;
  }
  
  .notification-dismiss {
    position: static;
    align-self: flex-end;
    margin-top: 10px;
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
    gap: 10px;
    min-width: auto;
  }
  
  .appointment-time i {
    margin-bottom: 0;
  }
  
  .appointment-status {
    align-self: flex-start;
    min-width: auto;
  }
  
  .announcement-card {
    margin-bottom: 10px;
  }
  
  .announcement-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 5px;
    padding: 12px;
  }
  
  .announcement-title {
    font-size: 14px;
  }
  
  .announcement-content {
    padding: 0 12px 8px;
  }
  
  .announcement-footer {
    padding: 8px 12px;
    flex-direction: column;
    align-items: flex-start;
    gap: 8px;
  }
  
  .modal-content {
    width: 95%;
    max-height: 85vh;
  }
  
  .modal-header {
    padding: 15px 20px;
  }
  
  .modal-body {
    padding: 20px;
  }
  
  .modal-meta {
    flex-direction: column;
    gap: 10px;
  }
  
  .modal-description {
    font-size: 14px;
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
  
  .actions-grid {
    grid-template-columns: 1fr;
    gap: 8px;
  }
  
  .action-card {
    padding: 12px;
    flex-direction: row;
    justify-content: flex-start;
    text-align: left;
    gap: 12px;
  }
  
  .action-card i {
    margin-bottom: 0;
    font-size: 18px;
  }
  
  .section-header {
    margin-bottom: 12px;
  }
  
  .section-header h3 {
    font-size: 15px;
  }
  
  .notification-card,
  .appointment-card,
  .announcement-card {
    padding: 10px;
  }
  
  .modal-header {
    padding: 12px 15px;
  }
  
  .modal-body {
    padding: 15px;
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
  
  .modal-content {
    max-height: 95vh;
  }
}
</style>
