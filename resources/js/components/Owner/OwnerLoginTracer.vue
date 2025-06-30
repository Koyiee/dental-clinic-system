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
            <h3>Login Tracer</h3>
            <div class="breadcrumbs">
              <a class="none" href=""><p>Home / </p></a>
              <a class="current" href="/ownerlogintracer"><p> &nbsp;Login Tracer</p></a>
            </div>
        </div>
      </div>
      <hr color="#06693a">
      
      <div class="tracer-content">
        <div class="tracer-card">
          <div class="card-header">
            <h2>User Login Activity</h2>
            <div class="header-actions">
              <div class="search-container">
                <i class="bx bx-search search-icon"></i>
                <input 
                  type="text" 
                  placeholder="Search logs..." 
                  class="search-input"
                  v-model="searchQuery"
                  @input="filterLogs"
                >
              </div>
            </div>
          </div>
          
          <!-- Desktop Table -->
          <div class="table-container desktop-table">
            <table class="tracer-table">
              <colgroup>
                <col width="25%">
                <col width="20%">
                <col width="35%">
                <col width="20%">
              </colgroup>
              <thead>
                <tr>
                  <th><i class="bx bx-user"></i> User</th>
                  <th><i class="bx bx-notepad"></i> Action</th>
                  <th><i class="bx bx-info-circle"></i> Description</th>
                  <th><i class="bx bx-calendar"></i> Date</th>
                </tr>
              </thead>
              <tbody>
                <tr 
                  v-for="log in filteredLogs" 
                  :key="log.TracerID" 
                  class="log-row"
                  @click="showLogDetails(log)"
                >
                  <td>
                    <div class="user-cell">
                      <div class="user-avatar">{{ getUserInitials(log.user.FirstName, log.user.LastName) }}</div>
                      <span>{{ log.user.FirstName }} {{ log.user.LastName }}</span>
                    </div>
                  </td>
                  <td>
                    <span :class="getActionClass(log.ActionType)">{{ log.ActionType }}</span>
                  </td>
                  <td class="description-cell">
                    <div class="truncate">{{ log.Description }}</div>
                  </td>
                  <td>{{ formatDate(log.ActionDate) }}</td>
                </tr>
                <tr v-if="filteredLogs.length === 0">
                  <td colspan="4" class="no-data">No login activity found</td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- Mobile Cards -->
          <div class="mobile-cards">
            <div 
              v-for="log in filteredLogs" 
              :key="log.TracerID"
              class="log-card"
              @click="showLogDetails(log)"
            >
              <div class="card-header-mobile">
                <div class="user-info">
                  <div class="user-avatar">{{ getUserInitials(log.user.FirstName, log.user.LastName) }}</div>
                  <div class="user-details">
                    <h4>{{ log.user.FirstName }} {{ log.user.LastName }}</h4>
                    <span class="user-role">{{ log.user.Role || 'User' }}</span>
                  </div>
                </div>
                <span :class="getActionClass(log.ActionType)">{{ log.ActionType }}</span>
              </div>
              <div class="card-content-mobile">
                <div class="card-row">
                  <span class="card-label">Description:</span>
                  <span class="card-value">{{ log.Description }}</span>
                </div>
                <div class="card-row">
                  <span class="card-label">Date & Time:</span>
                  <span class="card-value">{{ formatDate(log.ActionDate) }}</span>
                </div>
              </div>
            </div>
            <div v-if="filteredLogs.length === 0" class="no-data-mobile">
              No login activity found
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Modal for log details -->
  <div class="modal-overlay" v-if="showModal" @click="closeModal">
    <div class="modal-container" @click.stop>
      <div class="modal-header">
        <h3>Login Activity Details</h3>
        <button class="close-button" @click="closeModal">
          <i class="bx bx-x"></i>
        </button>
      </div>
      <div class="modal-content" v-if="selectedLog">
        <div class="detail-row">
          <div class="detail-label">User:</div>
          <div class="detail-value">
            <div class="user-detail">
              <div class="user-avatar modal-avatar">
                {{ getUserInitials(selectedLog.user.FirstName, selectedLog.user.LastName) }}
              </div>
              <div>
                <div class="user-name">{{ selectedLog.user.FirstName }} {{ selectedLog.user.LastName }}</div>
                <div class="user-role">{{ selectedLog.user.Role || 'User' }}</div>
              </div>
            </div>
          </div>
        </div>
        
        <div class="detail-row">
          <div class="detail-label">Action:</div>
          <div class="detail-value">
            <span :class="getActionClass(selectedLog.ActionType)">{{ selectedLog.ActionType }}</span>
          </div>
        </div>
        
        <div class="detail-row">
          <div class="detail-label">Description:</div>
          <div class="detail-value">{{ selectedLog.Description }}</div>
        </div>
        
        <div class="detail-row">
          <div class="detail-label">Date & Time:</div>
          <div class="detail-value">{{ formatDate(selectedLog.ActionDate) }}</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
  name: "Ownerlogintracer",
  props: {
    firstName: { type: String, required: true },
    lastName: { type: String, required: true },
  },
  data() {
    return {
      tracerLogs: [],
      filteredLogs: [],
      searchQuery: '',
      showModal: false,
      selectedLog: null,
      isSidebarClosed: true,
    };
  },
  computed: {
    fullName() {
      return `${this.firstName} ${this.lastName}`;
    },
  },
  mounted() {
    this.fetchTracerLogs();

    // Sidebar toggle logic (unchanged)
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
    async fetchTracerLogs() {
      try {
          const response = await axios.get('/owner/login-tracer-data', {
              headers: { Authorization: `Bearer ${localStorage.getItem('token')}` },
          });
          console.log('Tracer logs fetched:', response.data);
          this.tracerLogs = response.data;
          this.filteredLogs = response.data; // Initialize filtered logs with all logs
      } catch (error) {
          console.error('Error fetching tracer logs:', error.response ? error.response.data : error.message);
      }
    },
    formatDate(date) {
      return new Date(date).toLocaleString(); // Format date for display
    },
    getUserInitials(firstName, lastName) {
      return (firstName ? firstName.charAt(0) : '') + (lastName ? lastName.charAt(0) : '');
    },
    getActionClass(actionType) {
      const actionMap = {
        'Login': 'action-login',
        'Logout': 'action-logout',
        'Failed Login': 'action-failed',
      };
      return actionMap[actionType] || 'action-default';
    },
    filterLogs() {
      if (!this.searchQuery.trim()) {
        this.filteredLogs = this.tracerLogs;
        return;
      }
      
      const query = this.searchQuery.toLowerCase();
      this.filteredLogs = this.tracerLogs.filter(log => {
        const fullName = `${log.user.FirstName} ${log.user.LastName}`.toLowerCase();
        const actionType = log.ActionType.toLowerCase();
        const description = log.Description.toLowerCase();
        const date = this.formatDate(log.ActionDate).toLowerCase();
        
        return fullName.includes(query) || 
               actionType.includes(query) || 
               description.includes(query) || 
               date.includes(query);
      });
    },
    showLogDetails(log) {
      this.selectedLog = log;
      this.showModal = true;
      // Prevent body scrolling when modal is open
      document.body.style.overflow = 'hidden';
    },
    closeModal() {
      this.showModal = false;
      this.selectedLog = null;
      // Re-enable body scrolling
      document.body.style.overflow = 'auto';
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
  margin-right: 10px; /* Add space for the logout button */
}

.sidebar .profile-details .profile_name {
  color: #06693A;
  font-size: 16px;
  font-weight: 500;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis; 
}

.nav-link {
  margin-top: -30px;
}

/* Enhanced Tracer Content Styling */
.tracer-content {
  padding: 20px;
}

.tracer-card {
  background: white;
  border-radius: 12px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
  overflow: hidden;
}

.card-header {
  padding: 20px 24px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-bottom: 1px solid #f0f0f0;
}

.card-header h2 {
  color: #06693a;
  font-size: 1.25rem;
  font-weight: 600;
  margin: 0;
}

.header-actions {
  display: flex;
  align-items: center;
  gap: 12px;
}

.search-container {
  position: relative;
  width: 250px;
}

.search-input {
  width: 100%;
  padding: 8px 12px 8px 36px;
  border: 1px solid #e0e0e0;
  border-radius: 6px;
  font-size: 0.875rem;
  transition: all 0.2s;
}

.search-input:focus {
  outline: none;
  border-color: #06693a;
  box-shadow: 0 0 0 2px rgba(6, 105, 58, 0.1);
}

.search-icon {
  position: absolute;
  left: 10px;
  top: 50%;
  transform: translateY(-50%);
  color: #888;
}

.table-container {
  overflow-x: auto;
  padding: 0 4px;
}

.tracer-table {
  width: 100%;
  table-layout: fixed; /* Fixed table layout for consistent column widths */
  border-collapse: separate;
  border-spacing: 0;
  margin: 16px 0;
}

.tracer-table th,
.tracer-table td {
  padding: 14px 20px;
  text-align: left;
  border-bottom: 1px solid #f0f0f0;
  overflow: hidden;
}

.tracer-table th {
  background-color: #f9fafb;
  color: #06693a;
  font-weight: 600;
  font-size: 0.875rem;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.tracer-table th i {
  margin-right: 6px;
  font-size: 1rem;
  vertical-align: middle;
}

.tracer-table tbody tr {
  transition: background-color 0.2s;
  cursor: pointer;
}

.tracer-table tbody tr:hover {
  background-color: #f9fafb;
}

.tracer-table tbody tr:last-child td {
  border-bottom: none;
}

.user-cell {
  display: flex;
  align-items: center;
  gap: 10px;
}

.user-avatar {
  width: 32px;
  height: 32px;
  background-color: #06693a;
  color: white;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.75rem;
  font-weight: 600;
}

.action-login {
  display: inline-block;
  padding: 4px 10px;
  background-color: #e6f7ef;
  color: #06693a;
  border-radius: 4px;
  font-size: 0.75rem;
  font-weight: 600;
}

.action-logout {
  display: inline-block;
  padding: 4px 10px;
  background-color: #f0f0f0;
  color: #666;
  border-radius: 4px;
  font-size: 0.75rem;
  font-weight: 600;
}

.action-failed {
  display: inline-block;
  padding: 4px 10px;
  background-color: #fee2e2;
  color: #dc2626;
  border-radius: 4px;
  font-size: 0.75rem;
  font-weight: 600;
}

.action-default {
  display: inline-block;
  padding: 4px 10px;
  background-color: #f0f7ff;
  color: #0369a1;
  border-radius: 4px;
  font-size: 0.75rem;
  font-weight: 600;
}

.no-data {
  text-align: center;
  color: #888;
  padding: 40px 0;
  font-style: italic;
}

/* Description cell with truncation */
.description-cell {
  position: relative;
}

.truncate {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  max-width: 100%;
}

/* Mobile Cards */
.mobile-cards {
  display: none;
  padding: 15px;
}

.log-card {
  background-color: white;
  border-radius: 12px;
  border: 1px solid #e0e0e0;
  margin-bottom: 16px;
  overflow: hidden;
  transition: transform 0.2s, box-shadow 0.2s;
  cursor: pointer;
}

.log-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.card-header-mobile {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 16px;
  border-bottom: 1px solid #f0f0f0;
}

.user-info {
  display: flex;
  align-items: center;
  gap: 12px;
}

.user-details h4 {
  margin: 0;
  font-size: 16px;
  font-weight: 600;
  color: #333;
}

.user-role {
  font-size: 12px;
  color: #666;
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

.no-data-mobile {
  text-align: center;
  color: #757575;
  padding: 30px;
  background-color: white;
  border-radius: 12px;
  border: 1px solid #e0e0e0;
}

/* Modal Styles */
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
  backdrop-filter: blur(2px);
}

.modal-container {
  background-color: white;
  border-radius: 12px;
  width: 90%;
  max-width: 600px;
  max-height: 90vh;
  overflow-y: auto;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 16px 24px;
  border-bottom: 1px solid #f0f0f0;
}

.modal-header h3 {
  color: #06693a;
  margin: 0;
  font-size: 1.25rem;
}

.close-button {
  background: none;
  border: none;
  cursor: pointer;
  font-size: 1.5rem;
  color: #888;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 4px;
  border-radius: 4px;
  transition: all 0.2s;
}

.close-button:hover {
  background-color: #f5f5f5;
  color: #06693a;
}

.modal-content {
  padding: 24px;
}

.detail-row {
  display: flex;
  margin-bottom: 16px;
}

.detail-label {
  width: 120px;
  font-weight: 600;
  color: #555;
}

.detail-value {
  flex: 1;
}

.user-detail {
  display: flex;
  align-items: center;
  gap: 12px;
}

.modal-avatar {
  width: 40px;
  height: 40px;
  font-size: 1rem;
}

.user-name {
  font-weight: 500;
}

.user-role {
  font-size: 0.875rem;
  color: #666;
}

/* Responsive Design */

/* Large Desktop */
@media (min-width: 1400px) {
  .tracer-content {
    padding: 30px;
  }
}

/* Desktop */
@media (max-width: 1200px) {
  .tracer-table th,
  .tracer-table td {
    padding: 12px;
    font-size: 13px;
  }

  .search-container {
    width: 200px;
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

  .tracer-content {
    padding: 15px;
  }

  .card-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 15px;
  }

  .header-actions {
    width: 100%;
  }

  .search-container {
    width: 100%;
  }

  .tracer-table th,
  .tracer-table td {
    padding: 10px;
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

  .desktop-table {
    display: none;
  }
  
  .mobile-cards {
    display: block;
  }

  .tracer-content {
    padding: 10px;
  }

  .card-header {
    padding: 15px;
  }

  .card-header h2 {
    font-size: 18px;
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

  .modal-content {
    padding: 15px;
  }

  .detail-row {
    flex-direction: column;
    margin-bottom: 20px;
  }

  .detail-label {
    width: 100%;
    margin-bottom: 4px;
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

  .tracer-content {
    padding: 8px;
  }

  .card-header {
    padding: 12px;
  }

  .card-header h2 {
    font-size: 16px;
  }

  .search-container {
    width: 100%;
  }

  .search-input {
    height: 38px;
    font-size: 13px;
    padding: 0 36px 0 12px;
  }

  .search-icon {
    right: 12px;
    font-size: 16px;
  }

  .log-card {
    margin-bottom: 12px;
  }

  .card-header-mobile {
    padding: 12px;
  }

  .user-details h4 {
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

  .modal-container {
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

  .modal-content {
    padding: 12px;
  }
}

/* Landscape Mobile */
@media (max-height: 500px) and (orientation: landscape) {
  .modal-container {
    max-height: 95vh;
  }

  .modal-content {
    max-height: calc(95vh - 120px);
  }
}
</style>