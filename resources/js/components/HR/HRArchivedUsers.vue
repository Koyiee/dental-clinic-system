<template>
<div class="sidebar close">
  <div class="logo-details">
    <img src="@/components/Images/ATDC_logo.png" alt="" class="logo">
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
      <div class="icon-link">
        <a href="/hrmanageusers">
          <i class="bx bx-group"></i>
          <span class="link_name">Manage Users</span>
        </a>
        <i class="bx bxs-chevron-down arrow"></i>
      </div>
      <ul class="sub-menu">
        <li>
          <a class="link_name" href="/hrmanageusers">Manage Users</a>
        </li>
        <li>
          <a href="/hrarchivedusers">Archived Users</a>
        </li>
        <li>
          <a href="/hrdeactivatedusers">Deactivated Users</a>
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
    <a href="/logout">
    <li>
      <div class="profile-details">
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
   </a>
  </ul>
</div>
<section class="home-section">
  <div class="home-content">
    <div class="header">
      <i class="bx bx-menu"></i>
      <div class="text">
          <h3>Manage users</h3>
          <div class="breadcrumbs">
            <a class="none" href=""><p>Home / </p></a>
            <a class="none" href="/hrmanageusers"><p>&nbsp;Manage Users /</p></a>
            <a class="current" href="/hrarchivedusers"><p> &nbsp;Archived Users</p></a>
          </div>
      </div>
    </div>
    <hr color="#06693a">
    <div>
        <div class="search-container">
          <input v-model="searchQuery" placeholder="Search" @input="" class="search-input"/>
          <i class="bx bx-search search-icon"></i>
        </div>
        <div class="buttons">
          <!-- <button class="date">Date</button> -->
          <button class="filter"><i class='bx bx-filter' style="font-size: 15pt;"></i> Filter</button>
        </div>
      </div>
    <div class="add">
      <div class="user-type-selector">
        <select id="user-type" v-model="selectedUserType" @change="fetchUsers">
          <option value="patient">Patient</option>
          <option value="dentist">Dentist</option>
        </select>
      </div>
    </div>
    <div class="manage-container">
      <div class="manage">
        <h3>List of</h3>
      </div>
      <table class="manage-table">
        <thead>
          <tr>
            <th>User ID</th>
            <th>Patient Name</th>
            <th>Account Status</th>
          </tr>
        </thead>
        <tbody class="container-manage">
          <tr v-for="user in users" :key="user.id">
            <td></td>
            <td>{{ user.LastName }}, {{ user.FirstName }}</td>
            <td></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</section>
</template>
  
<script>
export default {
  name: "HRArchivedUsers",
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
  computed: {
    fullName() {
      return `${this.firstName} ${this.lastName}`;
    },
  },
  mounted() {
    // Access the arrow elements after the component is mounted
    const arrows = document.querySelectorAll(".arrow");

    arrows.forEach((arrow) => {
      arrow.addEventListener("click", (e) => {
        const arrowParent = e.target.closest("li"); // Get the closest parent <li> element
        if (arrowParent) {
          arrowParent.classList.toggle("showMenu");
        }
      });
    });

    let sidebar = document.querySelector(".sidebar");
    let sidebarBtn = document.querySelector(".bx-menu") ;
    console.log(sidebar);
    sidebarBtn.addEventListener("click", ()=> {
        sidebar.classList.toggle("close"); 
    });
  },
};
</script>

  
<style scoped>
@import url('https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css');
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap');

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'poppins', sans-serif;
}

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

.user-type-selector select {
  padding: 13px;
  width: 115%;
  border-radius: 5px;
  border: 1px solid #ccc;
  font-size: 16px;
}

.user-list {
  margin-top: 20px;
}

button {
  margin-right: 5px;
  padding: 5px 10px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.manage-container {
  margin: -60px 20px 20px 20px;
}

.manage-table {
  width: 100%;
  border-collapse: separate; /* Change from collapse to separate */
  border-spacing: 0;
  border: 1px solid #E0E0E0;
  border-radius: 10px; /* This might work better now */
  overflow: hidden;
}  

.manage-table th,
.manage-table td {
  text-align: center;
  background-color: #FFFFFF;
  width: 20%;
}

.manage-table td {
  padding-bottom: 30px;
}

.manage-table th {
  color: #06693A;
  padding-top: 30px;
  padding-bottom: 30px;
}

.manage h3 {
  font-size: 20pt;
  color: #000;
  padding: 10px 20px 20px 20px;
}

.buttons {
  display: flex;
  gap: 6px;
  margin: 20px;
  justify-content: flex-end;
  margin-top: -66px;
}

/* .date {
  background-color: #E8E8E8;
  color: #8E8C8C;
  width: 12%;
  font-size: 11pt;
  padding: 11px;
} */

.filter {
  width: 8%;
  font-size: 11pt;
  padding: 11px; 
}

button {
  margin-right: 5px;
  padding: 10px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  background-color: #044f2b;
  color: white;
  font-size: 10pt;
  width: 5%;
}

.search-container {
  position: relative;
  display: flex;
  align-items: center;
  width: 100%;
  max-width: 88%; /* Adjust width as needed */
  margin: 20px;
}

.search-input {
  width: 100%;
  padding: 12px 40px 12px 15px; 
  border: none;
  border-radius: 5px; /* Rounded corners */
  background-color: #E8E8E8; /* Light gray background */
  font-size: 15px;
  outline: none;
}

.search-icon {
  position: absolute;
  right: 15px;
  font-size: 18px;
  color: gray;
  cursor: pointer;
}

.manage {
  display: flex;
}

.add {
  display: flex;
  padding-right: 40px;
  padding-bottom: 20px;
  justify-content: flex-end;
}

.open-modal-btn {
  background-color: #06693A;
  color: white;
  width: 10%;
  font-size: 11pt;
}
</style>
  
