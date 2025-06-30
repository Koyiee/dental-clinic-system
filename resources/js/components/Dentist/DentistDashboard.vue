<template>
<div class="sidebar close">
  <div class="logo-details">
    <img src="@/components/Images/ATDC_logo.png" alt="" class="logo">
    <div class="logo_name"><img class="img2" src="@/components/Images/ATDC_Logo3.png" alt=""></div>
  </div>
  <ul class="nav-link">
    <li>
      <a href="/dentistdashboard">
        <i class="bx bx-grid-alt"></i>
        <span class="link_name">Dashboard</span>
      </a>
      <ul class="sub-menu blank">
          <li>
            <a class="link_name" href="/dentistdashboard">Dashboard</a>
          </li>
      </ul>
    </li>
    <li>
      <a href="/dentistannouncements">
        <i class="bx bxs-megaphone"></i>
        <span class="link_name">Announcements</span>
      </a>
      <ul class="sub-menu blank">
          <li>
            <a class="link_name" href="/dentistannouncements">Announcements</a>
          </li>
      </ul>
    </li>
    <li>
      <a href="/dentistcalendarschedule">
        <i class="bx bx-calendar"></i>
        <span class="link_name">Calendar Schedule</span>
      </a>
      <ul class="sub-menu blank">
          <li>
            <a class="link_name" href="/dentistcalendarschedule">Calendar Schedule</a>
          </li>
      </ul>
    </li>
    <li>
      <a href="/dentistpatientlist">
        <i class="bx bx-user"></i>
        <span class="link_name">Patient List</span>
      </a>
      <ul class="sub-menu blank">
          <li>
            <a class="link_name" href="/dentistpatientlist">Patient List</a>
          </li>
      </ul>
    </li>
    <li>
      <a href="/dentistsettings">
        <i class="bx bx-cog"></i>
        <span class="link_name">Settings</span>
      </a>
      <ul class="sub-menu blank">
          <li>
            <a class="link_name" href="/dentistsettings">Settings</a>
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
          <div class="job">Dentist</div>
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
            <a class="current" href="/dentistdashboard"><p> Dashboard</p></a>
          </div>
      </div>
    </div>
    <hr color="#06693a">

    <div class="dashboard-container">
      <!-- Welcome Card -->
      <div class="welcome-card">
        <div class="welcome-content">
          <h2>Good Day, Doc. {{fullName}}!</h2>
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

      <!-- Notification Section -->
      <div v-if="hasNotifications" class="notification-container">
        <div class="section-header">
          <i class='bx bx-bell'></i>
          <h3>Notifications</h3>
        </div>
        <div class="notification-list">
          <div v-for="(notification, index) in notifications" :key="notification.AppointmentID" class="notification-card">
            <div class="notification-icon">
              <i class='bx bx-check-circle'></i>
            </div>
            <div class="notification-content">
              <p>{{ notification.StatusMessage }}</p>
            </div>
            <button @click="dismissNotification(index)" class="notification-dismiss">
              <i class='bx bx-x'></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Stats Overview -->
      <div class="stats-container">
        <a href="/dentistcalendarschedule" class="stat-card-link">
          <div class="stat-card">
            <div class="stat-icon appointments">
              <i class='bx bx-calendar-check'></i>
            </div>
            <div class="stat-content">
              <h3>{{ todayAppointments }}</h3>
              <p>Today's Appointments</p>
            </div>
          </div>
        </a>
        <a href="/dentistcalendarschedule" class="stat-card-link">
          <div class="stat-card">
            <div class="stat-icon patients">
              <i class='bx bx-calendar-week'></i>
            </div>
            <div class="stat-content">
              <h3>{{ weekAppointments }}</h3>
              <p>This Week</p>
            </div>
          </div>
        </a>
        <a href="/dentistcalendarschedule" class="stat-card-link">
          <div class="stat-card">
            <div class="stat-icon announcements">
              <i class='bx bx-calendar'></i>
            </div>
            <div class="stat-content">
              <h3>{{ monthAppointments }}</h3>
              <p>This Month</p>
            </div>
          </div>
        </a>
      </div>

      <!-- Today's Appointments -->
      <div class="appointments-container">
        <div class="section-header">
          <i class='bx bx-time'></i>
          <h3>Today's Appointments</h3>
          <a href="/dentistcalendarschedule" class="view-all">View All</a>
        </div>
        <div class="appointments-list">
          <div v-if="todayAppointmentsList.length === 0" class="empty-state">
            <i class='bx bx-calendar'></i>
            <p>No appointments scheduled for today</p>
          </div>
          <div v-for="appointment in todayAppointmentsList" :key="appointment.id" class="appointment-card">
            <div class="appointment-time">
              <i class='bx bx-time'></i>
              <span>{{ formatTime(appointment.start) }}</span>
            </div>
            <div class="appointment-details">
              <h4>{{ appointment.extendedProps.PatientName }}</h4>
              <div class="appointment-services">
                <span v-for="(service, i) in appointment.extendedProps.Services" :key="i" class="service-tag">
                  {{ service }}
                </span>
                <span v-if="!appointment.extendedProps.Services || appointment.extendedProps.Services.length === 0">
                  No services specified
                </span>
              </div>
            </div>
            <div class="appointment-status" :class="getStatusClass(appointment)">
              {{ getStatus(appointment) }}
            </div>
          </div>
        </div>
      </div>

      <!-- Recent Announcements -->
      <div class="announcements-container">
        <div class="section-header">
          <i class='bx bx-news'></i>
          <h3>Recent Announcements</h3>
          <a href="/dentistannouncements" class="view-all">View All</a>
        </div>
        <div class="announcements-list">
          <div v-if="activeAnnouncements.length === 0" class="empty-state">
            <i class='bx bx-megaphone'></i>
            <p>No recent announcements</p>
          </div>
          <div v-else>
            <div v-for="announcement in activeAnnouncements.slice(0, 3)" :key="announcement.AnnouncementId" class="announcement-card">
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

      <!-- Modal for Announcement Details -->
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
  </div>
</section>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
  name: "DentistDashboard",
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
      notifications: [],
      error: '',
      isSidebarOpen: false,
      upcomingAppointments: [],
      todayAppointmentsList: [],
      announcements: [],
      todayAppointments: 0,
      weekAppointments: 0,
      monthAppointments: 0,
      timeInterval: null,
      currentTimeValue: new Date(),
      selectedAnnouncement: null,
    };
  },
  computed: {
    fullName() {
      return `${this.firstName} ${this.lastName}`;
    },
    hasNotifications() {
      return this.notifications.length > 0;
    },
    currentDate() {
      const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
      return this.currentTimeValue.toLocaleDateString('en-US', options);
    },
    currentTime() {
      const options = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true };
      return this.currentTimeValue.toLocaleTimeString('en-US', options);
    },
    activeAnnouncements() {
      const now = new Date();
      return this.announcements.filter(announcement => {
        const startDate = new Date(announcement.StartDate);
        const endDate = new Date(announcement.EndDate);
        return startDate <= now && endDate >= now && announcement.Status === 'active';
      });
    }
  },
  mounted() {
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

    this.fetchAppointments();
    this.fetchAnnouncements();
    this.fetchNotifications();

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
    async dismissNotification(index) {
      const notification = this.notifications[index];
      try {
        await axios.post(`/dentist/appointments/${notification.AppointmentID}/mark-as-viewed`);
      } catch (error) {
        console.error("Error marking notification as viewed:", error);
      }
      this.notifications.splice(index, 1);
    },
    async fetchAppointments() {
      try {
        const response = await axios.get('/dentist/appointments');
        if (response.data && response.data.length > 0) {
          const formattedAppointments = response.data.map((appointment) => ({
            id: appointment.AppointmentID,
            title: `Patient: ${appointment.PatientName} - ${appointment.Services && appointment.Services.length > 0 ? appointment.Services.join(', ') : 'N/A'}`,
            start: `${appointment.AppointmentDate}T${appointment.AppointmentTime}`,
            end: appointment.EndTime ? `${appointment.AppointmentDate}T${appointment.EndTime}` : null,
            allDay: false,
            extendedProps: {
              PatientName: appointment.PatientName,
              PatientContact: appointment.PatientContact || null,
              PatientEmail: appointment.PatientEmail || null,
              Services: appointment.Services || [],
              PatientNote: appointment.PatientNote || null,
              MedicalHistory: appointment.MedicalHistory || null,
              Status: appointment.Status || 'Scheduled'
            },
          }));

          const today = new Date();
          today.setHours(0, 0, 0, 0);
          const tomorrow = new Date(today);
          tomorrow.setDate(tomorrow.getDate() + 1);

          this.upcomingAppointments = formattedAppointments
            .filter(event => new Date(event.start) >= new Date())
            .sort((a, b) => new Date(a.start) - new Date(b.start))
            .slice(0, 5);

          this.todayAppointmentsList = formattedAppointments
            .filter(event => {
              const eventDate = new Date(event.start);
              return eventDate >= today && eventDate < tomorrow;
            })
            .sort((a, b) => new Date(a.start) - new Date(b.start));

          this.calculateAppointmentStats(formattedAppointments);
        }
      } catch (error) {
        console.error("Error fetching appointments:", error);
      }
    },
    calculateAppointmentStats(appointments) {
      const today = new Date();
      today.setHours(0, 0, 0, 0);
      const tomorrow = new Date(today);
      tomorrow.setDate(tomorrow.getDate() + 1);

      this.todayAppointments = appointments.filter(event => {
        const eventDate = new Date(event.start);
        return eventDate >= today && eventDate < tomorrow;
      }).length;

      const startOfWeek = new Date(today);
      startOfWeek.setDate(today.getDate() - today.getDay());
      const endOfWeek = new Date(startOfWeek);
      endOfWeek.setDate(startOfWeek.getDate() + 7);

      this.weekAppointments = appointments.filter(event => {
        const eventDate = new Date(event.start);
        return eventDate >= startOfWeek && eventDate < endOfWeek;
      }).length;

      const startOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
      const endOfMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0);

      this.monthAppointments = appointments.filter(event => {
        const eventDate = new Date(event.start);
        return eventDate >= startOfMonth && eventDate <= endOfMonth;
      }).length;
    },
    async fetchAnnouncements() {
      try {
        const timestamp = new Date().getTime();
        const response = await axios.get(`/announcements/dentist?t=${timestamp}`);
        if (response.data && response.data.length > 0) {
          this.announcements = response.data.map(announcement => ({
            ...announcement,
            AnnouncementPicture: announcement.AnnouncementPicture || null,
            created_at: announcement.created_at
          }));
        }
      } catch (error) {
        console.error("Error fetching announcements:", error);
      }
    },
    async fetchNotifications() {
      try {
        const response = await axios.get('/dentist/notifications');
        if (response.data) {
          this.notifications = response.data;
        }
      } catch (error) {
        console.error("Error fetching notifications:", error);
      }
    },
    formatDate(date) {
      if (!date || date === null || date === undefined || date === "") return "N/A";
      const parsedDate = new Date(date);
      return isNaN(parsedDate.getTime()) ? "N/A" : parsedDate.toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric'
      });
    },
    formatTime(dateString) {
      if (!dateString) return 'N/A';
      const date = new Date(dateString);
      return date.toLocaleTimeString('en-US', {
        hour: '2-digit',
        minute: '2-digit',
        hour12: true
      });
    },
    getStatus(appointment) {
      if (appointment.extendedProps.Status) {
        return appointment.extendedProps.Status.charAt(0).toUpperCase() +
               appointment.extendedProps.Status.slice(1);
      }
      const now = new Date();
      const appointmentDate = new Date(appointment.start);
      if (appointmentDate < now) {
        return 'Completed';
      }
      return 'Scheduled';
    },
    getStatusClass(appointment) {
      const status = this.getStatus(appointment).toLowerCase();
      switch(status) {
        case 'completed':
          return 'status-completed';
        case 'cancelled':
          return 'status-cancelled';
        case 'rescheduled':
          return 'status-rescheduled';
        case 'confirmed':
          return 'status-confirmed';
        default:
          return 'status-scheduled';
      }
    },
    truncateText(text, maxLength) {
      if (!text) return '';
      if (text.length <= maxLength) return text;
      return text.substring(0, maxLength) + '...';
    },
    viewAnnouncementDetails(announcement) {
      this.selectedAnnouncement = announcement;
    },
    closeAnnouncementModal() {
      this.selectedAnnouncement = null;
    },
    handleImageError(event) {
      console.error("Failed to load image:", event);
      event.target.src = "@/components/Images/placeholder-image.jpg";
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

/* Dashboard Styles */
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
  align-items: center;
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
  margin: 0;
  color: #333;
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
}

.notification-dismiss:hover {
  background: rgba(0, 0, 0, 0.05);
  color: #666;
}

/* Stats Container */
.stats-container {
  grid-column: span 12;
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
}

.stat-card-link {
  text-decoration: none;
  color: inherit;
  transition: transform 0.3s;
  display: block;
}

.stat-card-link:hover {
  transform: translateY(-5px);
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
  cursor: pointer;
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

.stat-icon.announcements {
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

/* Appointments Container */
.appointments-container {
  grid-column: span 6;
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

.status-completed {
  background: #e8f5e9;
  color: #2e7d32;
}

.status-cancelled {
  background: #ffebee;
  color: #c62828;
}

.status-rescheduled {
  background: #fff8e1;
  color: #ff8f00;
}

.status-confirmed {
  background: #e0f7fa;
  color: #00838f;
}

/* Announcements Container */
.announcements-container {
  grid-column: span 6;
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

.close-button {
  background: none;
  border: none;
  font-size: 24px;
  color: #777;
  cursor: pointer;
  transition: color 0.3s ease;
}

.close-button:hover {
  color: #333;
}

.close-button i {
  font-size: 20px;
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
  
  .appointments-container,
  .announcements-container {
    grid-column: span 12;
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
  
  .stats-container {
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
  
  .stats-container {
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
    position: absolute;
    top: 10px;
    right: 10px;
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
  
  .appointment-services {
    margin-top: 5px;
  }
  
  .service-tag {
    font-size: 11px;
    padding: 2px 6px;
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
  
  .stats-container {
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