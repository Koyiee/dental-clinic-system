<template>
  <div class="sidebar close">
    <div class="logo-details">
      <img src="../Images/ATDC_Logo.png" alt="" class="logo">
      <div class="logo_name"><img class="img2" src="../Images/ATDC_Logo3.png" alt=""></div>
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
          <h3>Announcements</h3>
          <div class="breadcrumbs">
            <a class="none" href=""><p>Home / </p></a>
            <a class="current" href="/patientannouncements"><p>Announcements</p></a>
          </div>
        </div>
      </div>
      <hr color="#06693a">

      <div class="search-wrapper">
        <div class="search-container">
          <input 
            v-model="searchQuery" 
            placeholder="Search announcements" 
            @keyup.enter="filterAnnouncements" 
            class="search-input"
            :class="{ 'has-reset': searchQuery && isSearchActive }"
          />
          <i class="bx bx-search search-icon" @click="filterAnnouncements"></i>
          <button 
            v-if="isSearchActive" 
            @click="resetSearch" 
            class="reset-button"
            title="Reset search"
          >
            <i class='bx bx-x'></i>
          </button>
        </div>
      </div>

      <div class="announcements-container">
        <div v-if="isInitialLoading" class="loading-container">
          <div class="loading-spinner"></div>
          <p>Loading announcements...</p>
        </div>

        <div v-else-if="displayedAnnouncements.length > 0" class="announcements-list">
          <div 
            v-for="announcement in displayedAnnouncements" 
            :key="announcement.AnnouncementId" 
            class="announcement-card" 
            @click="viewAnnouncement(announcement)"
          >
            <div class="announcement-header">
              <div class="announcement-title-area">
                <div class="announcement-icon">
                  <i class='bx bx-news'></i>
                </div>
                <h3 class="announcement-title">{{ announcement.AnnouncementTitle }}</h3>
              </div>
              <div class="announcement-date">
                <i class='bx bx-calendar'></i>
                <span>Uploaded: {{ formatDate(announcement.created_at) }}</span>
              </div>
            </div>

            <div class="announcement-content">
              <p class="announcement-description">{{ announcement.AnnouncementDescription }}</p>
              
              <div v-if="announcement.AnnouncementPicture" class="announcement-image-container">
                <img 
                  :src="announcement.AnnouncementPicture" 
                  alt="Announcement Image" 
                  class="announcement-image"
                  @error="handleImageError"
                />
              </div>
            </div>
            
            <div class="announcement-footer">
              <div class="announcement-author">
                <i class='bx bx-user'></i>
                <span>{{ announcement.CreatedBy }}</span>
              </div>
              <button class="read-more-button">
                Read more <i class='bx bx-right-arrow-alt'></i>
              </button>
            </div>
          </div>

          <div class="pagination-container">
            <button class="pagination-button">
              <i class='bx bx-chevron-left'></i>
            </button>
            <span class="pagination-info">Page 1 of 1</span>
            <button class="pagination-button">
              <i class='bx bx-chevron-right'></i>
            </button>
          </div>
        </div>

        <div v-else class="empty-state">
          <div class="empty-icon">
            <i class='bx bx-news'></i>
          </div>
          <h3>No Announcements Found</h3>
          <p>No announcements match your search criteria.</p>
        </div>
      </div>
    </div>
  </section>

  <div v-if="selectedAnnouncement" class="modal-overlay" @click="closeAnnouncement">
    <div class="modal-content" @click.stop>
      <div class="modal-header">
        <h3>{{ selectedAnnouncement.AnnouncementTitle }}</h3>
        <button class="close-button" @click="closeAnnouncement">
          <i class='bx bx-x'></i>
        </button>
      </div>
      <div class="modal-body">
        <div class="modal-meta">
          <div class="meta-item">
            <i class='bx bx-calendar'></i>
            <span>Uploaded: {{ formatDate(selectedAnnouncement.created_at) }}</span>
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
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
  name: "PatientAnnouncements",
  data() {
    return {
      announcements: [],
      selectedAnnouncement: null,
      announcementsInterval: null,
      endTimeInterval: null,
      isInitialLoading: true,
      isPollingLoading: false,
      error: null,
      lastFetchTime: null,
      searchQuery: '',
      displayedAnnouncements: [],
      isSearchActive: false,
      profilePicture: null,
      handledImages: new Set()
    };
  },
  props: {
    firstName: { type: String, required: true },
    lastName: { type: String, required: true },
  },
  computed: {
    fullName() {
      return `${this.firstName} ${this.lastName}`;
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
    async fetchPatientData() {
      if (this.profilePicture !== null) {
        console.log("profilePicture already fetched, skipping...");
        return;
      }
      try {
        const response = await axios.get('/api/patient-data');
        if (response.data.success) {
          this.profilePicture = response.data.patient.profilePicture;
          console.log("Fetched profilePicture:", this.profilePicture);
        } else {
          console.error('Failed to fetch patient data:', response.data.message);
        }
      } catch (error) {
        console.error('Error fetching patient data:', error);
      }
    },
    handleImageError(event) {
      const imgElement = event.target;
      if (this.handledImages.has(imgElement)) {
        return;
      }
      console.error("Failed to load image:", event);
      this.handledImages.add(imgElement);
      imgElement.src = "../Images/profile_1.jpg";
      imgElement.onerror = null;
    },
    filterAnnouncements() {
      if (!this.searchQuery.trim()) {
        this.displayedAnnouncements = this.activeAnnouncements;
        this.isSearchActive = false;
        return;
      }
      const query = this.searchQuery.toLowerCase().trim();
      this.displayedAnnouncements = this.activeAnnouncements.filter(announcement => 
        announcement.AnnouncementTitle?.toLowerCase().includes(query) ||
        announcement.AnnouncementDescription?.toLowerCase().includes(query) ||
        announcement.CreatedBy?.toLowerCase().includes(query)
      );
      this.isSearchActive = true;
    },
    resetSearch() {
      this.searchQuery = '';
      this.displayedAnnouncements = this.activeAnnouncements;
      this.isSearchActive = false;
    },
    async fetchAnnouncements(isInitial = false) {
      try {
        if (isInitial) this.isInitialLoading = true;
        else this.isPollingLoading = true;
        this.error = null;

        const timestamp = new Date().getTime();
        const response = await axios.get(`/announcements/patient?t=${timestamp}`);
        console.log("Raw response from backend (PatientAnnouncements):", response.data);

        const now = new Date();
        this.announcements = response.data
          .filter(announcement => {
            const startDate = new Date(announcement.StartDate);
            return startDate <= now;
          })
          .map(announcement => ({
            ...announcement,
            AnnouncementPicture: announcement.AnnouncementPicture ? announcement.AnnouncementPicture : null,
          }));
        if (!this.isSearchActive) {
          this.displayedAnnouncements = this.activeAnnouncements;
        }       
        this.lastFetchTime = new Date();
      } catch (error) {
        console.error("Error fetching patient announcements:", error);
        this.error = "Failed to load announcements. Please try again later.";
      } finally {
        if (isInitial) this.isInitialLoading = false;
        else this.isPollingLoading = false;
      }
    },
    formatDate(date) {
      if (!date) return "N/A";
      const parsedDate = new Date(date);
      return isNaN(parsedDate.getTime()) ? "N/A" : parsedDate.toLocaleString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      });
    },
    viewAnnouncement(announcement) {
      const currentDate = new Date();
      const endDate = new Date(announcement.EndDate);
      if (endDate > currentDate) {
        this.selectedAnnouncement = announcement;
      }
    },
    closeAnnouncement() {
      this.selectedAnnouncement = null;
    },
    checkExpiredAnnouncements() {
      const currentDate = new Date();
      this.announcements = this.announcements.filter(announcement => {
        const startDate = new Date(announcement.StartDate);
        const endDate = new Date(announcement.EndDate);
        return startDate <= currentDate && endDate > currentDate && announcement.Status === 'active';
      });
      if (!this.isSearchActive) {
        this.displayedAnnouncements = this.activeAnnouncements;
      }

      if (this.selectedAnnouncement) {
        const endDate = new Date(this.selectedAnnouncement.EndDate);
        if (endDate <= currentDate) {
          this.selectedAnnouncement = null;
        }
      }
    },
    startPolling() {
      console.log("Starting polling intervals at:", new Date().toISOString());
      this.announcementsInterval = setInterval(() => {
        this.fetchAnnouncements(false);
      }, 5000);
      this.endTimeInterval = setInterval(() => {
        this.checkExpiredAnnouncements();
      }, 1000);
    },
  },
  mounted() {
    this.fetchAnnouncements(true);
    this.startPolling();
    this.fetchPatientData();

    const arrows = document.querySelectorAll('.arrow');
    arrows.forEach(arrow => {
      arrow.addEventListener('click', () => {
        const li = arrow.closest('li');
        li.classList.toggle('showMenu');
      });
    });

    const sidebar = document.querySelector('.sidebar');
    const menu = document.querySelector('.bx-menu');
    if (menu && sidebar) {
      menu.addEventListener('click', () => {
        sidebar.classList.toggle('close');
        // Handle mobile overlay
        const overlay = document.querySelector(".mobile-overlay");
        if (window.innerWidth <= 768) {
          overlay.classList.toggle("active");
        }
      });
    }
  },
  beforeUnmount() {
    if (this.announcementsInterval) clearInterval(this.announcementsInterval);
    if (this.endTimeInterval) clearInterval(this.endTimeInterval);
  },
  watch: {
    '$route'(to) {
      if (to.path === '/patientannouncements') {
        this.fetchAnnouncements(true);
        if (!this.announcementsInterval) this.startPolling();
      }
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

/* Sidebar styles */
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

.search-wrapper {
  width: 97%;
  margin: 25px 20px 15px;
}

.search-container {
  position: relative;
  width: 100%;
}

.search-input {
  width: 100%;
  height: 48px;
  padding: 0 45px 0 15px;
  border: none;
  border-radius: 8px;
  background-color: white;
  font-size: 15px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
  transition: all 0.3s ease;
}

.search-input.has-reset {
  padding-right: 80px;
}

.search-input:focus {
  outline: none;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
}

.search-icon {
  position: absolute;
  right: 15px;
  top: 50%;
  transform: translateY(-50%);
  font-size: 20px;
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

.announcements-container {
  margin: 20px;
  padding: 0;
}

.section-header {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 20px;
  padding: 0 5px;
}

.section-header i {
  font-size: 24px;
  color: #06693A;
}

.section-header h2 {
  font-size: 22px;
  font-weight: 600;
  color: #333;
  margin: 0;
}

.announcements-list {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.announcement-card {
  background-color: white;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  cursor: pointer;
}

.announcement-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
}

.announcement-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  padding: 20px 20px 15px;
  border-bottom: 1px solid #f0f0f0;
}

.announcement-title-area {
  display: flex;
  align-items: center;
  gap: 12px;
}

.announcement-icon {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 40px;
  height: 40px;
  background-color: rgba(6, 105, 58, 0.1);
  border-radius: 8px;
  color: #06693A;
  flex-shrink: 0;
}

.announcement-icon i {
  font-size: 20px;
}

.announcement-title {
  font-size: 18px;
  font-weight: 600;
  color: #333;
  margin: 0;
  word-break: break-word;
}

.announcement-date {
  display: flex;
  align-items: center;
  gap: 6px;
  color: #666;
  font-size: 14px;
  white-space: nowrap;
  flex-shrink: 0;
}

.announcement-date .date-item {
  display: flex;
  align-items: center;
  gap: 6px;
}

.announcement-date i {
  font-size: 16px;
  color: #06693A;
}

.announcement-content {
  padding: 20px;
}

.announcement-description {
  font-size: 15px;
  line-height: 1.6;
  color: #444;
  margin: 0 0 20px;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
}

.announcement-image-container {
  width: 100%;
  height: 200px;
  overflow: hidden;
  border-radius: 8px;
}

.announcement-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.5s ease;
}

.announcement-card:hover .announcement-image {
  transform: scale(1.05);
}

.announcement-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px 20px;
  border-top: 1px solid #f0f0f0;
  background-color: #f9f9f9;
}

.announcement-author {
  display: flex;
  align-items: center;
  gap: 6px;
  color: #666;
  font-size: 14px;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.announcement-author i {
  font-size: 16px;
  color: #06693A;
  flex-shrink: 0;
}

.announcement-author span {
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.read-more-button {
  display: flex;
  align-items: center;
  gap: 5px;
  background: none;
  border: none;
  color: #06693A;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  padding: 6px 10px;
  border-radius: 4px;
  transition: background-color 0.2s ease;
  white-space: nowrap;
  flex-shrink: 0;
}

.read-more-button:hover {
  background-color: rgba(6, 105, 58, 0.1);
}

.read-more-button i {
  font-size: 18px;
  transition: transform 0.2s ease;
}

.read-more-button:hover i {
  transform: translateX(3px);
}

.pagination-container {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 15px;
  margin-top: 10px;
}

.pagination-button {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: white;
  border: 1px solid #e0e0e0;
  cursor: pointer;
  transition: all 0.2s ease;
}

.pagination-button:hover {
  background-color: #f0f0f0;
}

.pagination-button i {
  font-size: 18px;
  color: #06693A;
}

.pagination-info {
  font-size: 14px;
  color: #666;
}

.loading-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 60px 0;
  background-color: white;
  border-radius: 12px;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
}

.loading-spinner {
  width: 40px;
  height: 40px;
  border: 3px solid rgba(6, 105, 58, 0.1);
  border-radius: 50%;
  border-top-color: #06693A;
  animation: spin 1s linear infinite;
  margin-bottom: 15px;
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}

.loading-container p {
  color: #666;
  font-size: 16px;
}

.empty-state {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 60px 0;
  background-color: white;
  border-radius: 12px;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
  text-align: center;
}

.empty-icon {
  width: 70px;
  height: 70px;
  border-radius: 50%;
  background-color: rgba(6, 105, 58, 0.1);
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 20px;
}

.empty-icon i {
  font-size: 28px;
  color: #06693A;
}

.empty-state h3 {
  font-size: 18px;
  font-weight: 600;
  color: #333;
  margin: 0 0 10px;
}

.empty-state p {
  font-size: 14px;
  color: #666;
  max-width: 300px;
  margin: 0;
}

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
  word-break: break-word;
}

.close-button {
  background: none;
  border: none;
  font-size: 24px;
  color: #777;
  cursor: pointer;
  transition: color 0.3s ease;
  flex-shrink: 0;
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
  flex-shrink: 0;
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
  .announcements-container {
    margin: 30px;
  }
  
  .announcement-image-container {
    height: 240px;
  }
}

/* Desktop */
@media (max-width: 1200px) {
  .announcement-header {
    flex-direction: column;
    gap: 10px;
  }
  
  .announcement-date {
    align-self: flex-start;
  }
  
  .announcement-image-container {
    height: 180px;
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
  
  .search-wrapper {
    margin: 20px 15px 10px;
  }
  
  .announcements-container {
    margin: 15px;
  }
  
  .announcement-card {
    border-radius: 10px;
  }
  
  .announcement-header {
    padding: 15px 15px 12px;
  }
  
  .announcement-icon {
    width: 36px;
    height: 36px;
  }
  
  .announcement-title {
    font-size: 16px;
  }
  
  .announcement-content {
    padding: 15px;
  }
  
  .announcement-description {
    font-size: 14px;
    margin-bottom: 15px;
  }
  
  .announcement-footer {
    padding: 12px 15px;
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
  
  .modal-description {
    font-size: 15px;
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
  
  .search-wrapper {
    margin: 15px 10px 10px;
    width: calc(100% - 20px);
  }
  
  .search-input {
    height: 42px;
    font-size: 14px;
  }
  
  .announcements-container {
    margin: 10px;
  }
  
  .announcement-card {
    border-radius: 8px;
  }
  
  .announcement-header {
    padding: 15px 15px 12px;
  }
  
  .announcement-title-area {
    gap: 10px;
  }
  
  .announcement-icon {
    width: 32px;
    height: 32px;
  }
  
  .announcement-icon i {
    font-size: 16px;
  }
  
  .announcement-title {
    font-size: 16px;
  }
  
  .announcement-date {
    font-size: 12px;
  }
  
  .announcement-content {
    padding: 15px;
  }
  
  .announcement-description {
    font-size: 14px;
    margin-bottom: 15px;
    -webkit-line-clamp: 2;
  }
  
  .announcement-image-container {
    height: 160px;
  }
  
  .announcement-footer {
    padding: 12px 15px;
    flex-direction: column;
    align-items: flex-start;
    gap: 10px;
  }
  
  .read-more-button {
    align-self: flex-end;
    margin-top: -30px;
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
    max-height: calc(85vh - 60px);
  }
  
  .modal-meta {
    gap: 15px;
    margin-bottom: 20px;
  }
  
  .modal-description {
    font-size: 14px;
    margin-bottom: 20px;
  }
  
  .modal-image {
    max-height: 400px;
  }
  
  .empty-icon {
    width: 60px;
    height: 60px;
  }
  
  .empty-icon i {
    font-size: 24px;
  }
  
  .empty-state h3 {
    font-size: 16px;
  }
  
  .empty-state p {
    font-size: 13px;
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
    font-size: 18px;
  }
  
  .reset-button {
    right: 40px;
    width: 24px;
    height: 24px;
  }
  
  .reset-button i {
    font-size: 16px;
  }
  
  .announcements-container {
    margin: 8px;
  }
  
  .announcement-card {
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
  }
  
  .announcement-header {
    padding: 12px 12px 10px;
  }
  
  .announcement-title-area {
    gap: 8px;
  }
  
  .announcement-icon {
    width: 28px;
    height: 28px;
  }
  
  .announcement-icon i {
    font-size: 14px;
  }
  
  .announcement-title {
    font-size: 15px;
  }
  
  .announcement-date {
    font-size: 11px;
  }
  
  .announcement-date i {
    font-size: 14px;
  }
  
  .announcement-content {
    padding: 12px;
  }
  
  .announcement-description {
    font-size: 13px;
    line-height: 1.5;
    margin-bottom: 12px;
  }
  
  .announcement-image-container {
    height: 140px;
  }
  
  .announcement-footer {
    padding: 10px 12px;
  }
  
  .announcement-author {
    font-size: 12px;
  }
  
  .announcement-author i {
    font-size: 14px;
  }
  
  .read-more-button {
    font-size: 12px;
    padding: 5px 8px;
  }
  
  .read-more-button i {
    font-size: 16px;
  }
  
  .pagination-container {
    gap: 10px;
  }
  
  .pagination-button {
    width: 32px;
    height: 32px;
  }
  
  .pagination-button i {
    font-size: 16px;
  }
  
  .pagination-info {
    font-size: 12px;
  }
  
  .modal-content {
    width: 95%;
    border-radius: 10px;
  }
  
  .modal-header {
    padding: 12px;
  }
  
  .modal-header h3 {
    font-size: 16px;
  }
  
  .close-button i {
    font-size: 18px;
  }
  
  .modal-body {
    padding: 12px;
  }
  
  .modal-meta {
    gap: 12px;
    margin-bottom: 15px;
  }
  
  .meta-item {
    font-size: 12px;
  }
  
  .meta-item i {
    font-size: 16px;
  }
  
  .modal-description {
    font-size: 13px;
    line-height: 1.6;
    margin-bottom: 15px;
  }
  
  .modal-image {
    max-height: 300px;
  }
}

/* Landscape Mobile */
@media (max-height: 500px) and (orientation: landscape) {
  .modal-content {
    max-height: 95vh;
  }
  
  .modal-body {
    max-height: calc(95vh - 60px);
  }
  
  .modal-image {
    max-height: 200px;
  }
  
  .announcement-image-container {
    height: 120px;
  }
}
</style>