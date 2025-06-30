<template>
  <div class="sidebar close">
    <!-- Sidebar content remains unchanged -->
    <div class="logo-details">
      <img src="@/components/Images/ATDC_logo.png" alt="" class="logo">
      <div class="logo_name"><img class="img2" src="@/components/Images/ATDC_Logo3.png" alt=""></div>
    </div>
    <ul class="nav-link">
      <li><a href="/patientdashboard"><i class="bx bx-grid-alt"></i><span class="link_name">Dashboard</span></a><ul class="sub-menu blank"><li><a class="link_name" href="/patientdashboard">Dashboard</a></li></ul></li>
      <li><a href="/patientannouncements"><i class="bx bxs-megaphone"></i><span class="link_name">Announcements</span></a><ul class="sub-menu blank"><li><a class="link_name" href="/patientannouncements">Announcements</a></li></ul></li>
      <li><a href="/patientinformation"><i class="bx bx-clipboard"></i><span class="link_name">Patient Information</span></a><ul class="sub-menu blank"><li><a class="link_name" href="/patientinformation">Patient Information</a></li></ul></li>
      <li><div class="icon-link"><a href="/patientappointments"><i class="bx bx-calendar"></i><span class="link_name">Appointment</span></a><i class="bx bxs-chevron-down arrow"></i></div><ul class="sub-menu"><li><a class="link_name" href="/patientappointments">Appointment</a></li><li><a href="/patientscheduleanappointment">Schedule Appointment</a></li></ul></li>
      <li><a href="/patientbillings"><i class="bx bx-wallet"></i><span class="link_name">Billing</span></a><ul class="sub-menu blank"><li><a class="link_name" href="/patientbillings">Billing</a></li></ul></li>
      <li><div class="icon-link"><a href="/patienttreatments"><i class="bx bx-clipboard"></i><span class="link_name">Treatments</span></a><i class="bx bxs-chevron-down arrow"></i></div><ul class="sub-menu"><li><a class="link_name" href="/patienttreatments">Treatments</a></li><li><a href="/patienttreatmentplan">Treatment Plan</a></li><li><a href="/patientdentalphotos">Dental Photos</a></li><li><a href="/patientforms">Forms</a></li><li><a href="/patientdentaltreatmenthistory">Dental Treatment History</a></li></ul></li>
      <li><a href="/patientsettings"><i class="bx bx-cog"></i><span class="link_name">Settings</span></a><ul class="sub-menu blank"><li><a class="link_name" href="/patientsettings">Settings</a></li></ul></li>
      <li>
        <div class="profile-details" @click="confirmLogout">
          <div class="profile-content">
            <img src="@/components/Images/profile_1.jpg" alt="profile">
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
          <h3>Settings</h3>
          <div class="breadcrumbs">
            <a class="none" href=""><p>Home / </p></a>
            <a class="current" href="/patientsettings"><p> Settings</p></a>
          </div>
        </div>
      </div>
      <hr color="#06693a">
    </div>

    <section class="settings-section">
      <div class="settings-card">
        <div class="card-header">
          <div class="user-info">
            <div class="user-avatar">
              <span>{{ getInitials(fullName) }}</span>
            </div>
            <h4>{{ fullName }}</h4>
          </div>
        </div>
        <div class="card-divider"></div>
        
        <div class="card-content">
          <h5 class="section-title">Change Password</h5>
          
          <div class="password-requirements">
            <div class="requirements-icon">
              <i class="bx bx-shield-quarter"></i>
            </div>
            <div class="requirements-text">
              <p>Password must contain:</p>
              <ul>
                <li :class="{ 'requirement-met': hasMinLength }">
                  <i class="bx" :class="hasMinLength ? 'bx-check' : 'bx-x'"></i>
                  At least 8 characters
                </li>
                <li :class="{ 'requirement-met': hasUpperCase }">
                  <i class="bx" :class="hasUpperCase ? 'bx-check' : 'bx-x'"></i>
                  One uppercase letter
                </li>
                <li :class="{ 'requirement-met': hasLowerCase }">
                  <i class="bx" :class="hasLowerCase ? 'bx-check' : 'bx-x'"></i>
                  One lowercase letter
                </li>
                <li :class="{ 'requirement-met': hasNumber }">
                  <i class="bx" :class="hasNumber ? 'bx-check' : 'bx-x'"></i>
                  One number
                </li>
                <li :class="{ 'requirement-met': hasSpecialChar }">
                  <i class="bx" :class="hasSpecialChar ? 'bx-check' : 'bx-x'"></i>
                  One special character
                </li>
              </ul>
              <div class="password-strength" v-if="form.new_password">
                <div class="strength-label">Password Strength:</div>
                <div class="strength-meter">
                  <div class="strength-progress" :class="passwordStrengthClass" :style="{ width: passwordStrengthWidth }"></div>
                </div>
                <div class="strength-text" :class="passwordStrengthClass">{{ passwordStrengthText }}</div>
              </div>
            </div>
          </div>
          
          <form @submit.prevent="changePassword" class="password-form">
            <div class="form-row">
              <div class="form-group">
                <label for="new_password">New Password</label>
                <div class="password-input-container">
                  <input
                    :type="showNewPassword ? 'text' : 'password'"
                    class="password-input"
                    :class="newPasswordClass"
                    id="new_password"
                    v-model.trim="form.new_password"
                    @input="validateNewPassword"
                    @blur="validateNewPassword"
                    placeholder="Enter new password"
                  >
                  <button 
                    type="button" 
                    class="toggle-password" 
                    @click="showNewPassword = !showNewPassword"
                    tabindex="-1"
                  >
                    <i class="bx" :class="showNewPassword ? 'bx-hide' : 'bx-show'"></i>
                  </button>
                </div>
                <div v-if="errors.new_password" class="error-message">
                  <i class="bx bx-error-circle"></i>
                  {{ errors.new_password }}
                </div>
              </div>
              
              <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <div class="password-input-container">
                  <input
                    :type="showConfirmPassword ? 'text' : 'password'"
                    class="password-input"
                    :class="confirmPasswordClass"
                    id="confirm_password"
                    v-model.trim="form.confirm_password"
                    @input="validateConfirmPassword"
                    @blur="validateConfirmPassword"
                    placeholder="Confirm your password"
                  >
                  <button 
                    type="button" 
                    class="toggle-password" 
                    @click="showConfirmPassword = !showConfirmPassword"
                    tabindex="-1"
                  >
                    <i class="bx" :class="showConfirmPassword ? 'bx-hide' : 'bx-show'"></i>
                  </button>
                </div>
                <div v-if="errors.confirm_password" class="error-message">
                  <i class="bx bx-error-circle"></i>
                  {{ errors.confirm_password }}
                </div>
              </div>
            </div>
            
            <div class="form-actions">
              <button type="submit" class="submit-button" :disabled="isSubmitting || !isFormValid">
                <i class="bx bx-lock-alt"></i>
                {{ isSubmitting ? 'Changing...' : 'Change Password' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </section>
  </section>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
  name: "PatientSettings",
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
      form: {
        new_password: '',
        confirm_password: '',
      },
      errors: {
        new_password: '',
        confirm_password: '',
      },
      isNewPasswordValid: false,
      isConfirmPasswordValid: false,
      isSubmitting: false,
      showNewPassword: false,
      showConfirmPassword: false,
      // Password requirement flags
      hasMinLength: false,
      hasUpperCase: false,
      hasLowerCase: false,
      hasNumber: false,
      hasSpecialChar: false,
    };
  },
  computed: {
    fullName() {
      return `${this.firstName} ${this.lastName}`;
    },
    newPasswordClass() {
      if (this.errors.new_password) {
        return 'input-error';
      }
      return this.isNewPasswordValid ? 'input-success' : '';
    },
    confirmPasswordClass() {
      if (this.errors.confirm_password) {
        return 'input-error';
      }
      return this.isConfirmPasswordValid ? 'input-success' : '';
    },
    isFormValid() {
      return this.isNewPasswordValid && this.isConfirmPasswordValid;
    },
    passwordStrength() {
      if (!this.form.new_password) return 0;
      
      let strength = 0;
      if (this.hasMinLength) strength += 1;
      if (this.hasUpperCase) strength += 1;
      if (this.hasLowerCase) strength += 1;
      if (this.hasNumber) strength += 1;
      if (this.hasSpecialChar) strength += 1;
      
      return strength;
    },
    passwordStrengthClass() {
      const strength = this.passwordStrength;
      if (strength <= 2) return 'weak';
      if (strength <= 4) return 'medium';
      return 'strong';
    },
    passwordStrengthWidth() {
      const strength = this.passwordStrength;
      return `${(strength / 5) * 100}%`;
    },
    passwordStrengthText() {
      const strength = this.passwordStrength;
      if (strength <= 2) return 'Weak';
      if (strength <= 4) return 'Medium';
      return 'Strong';
    }
  },
  methods: {
    closeMobileSidebar() {
      const sidebar = document.querySelector(".sidebar");
      const overlay = document.querySelector(".mobile-overlay");
      if (window.innerWidth <= 768) {
        sidebar.classList.add("close");
        overlay.classList.remove("active");
      }
    },
    getInitials(name) {
      return name
        .split(' ')
        .map(word => word.charAt(0))
        .join('')
        .toUpperCase();
    },
    validateNewPassword() {
      this.errors.new_password = '';

      // Check minimum length
      this.hasMinLength = this.form.new_password.length >= 8;
      
      // Check for uppercase
      this.hasUpperCase = /[A-Z]/.test(this.form.new_password);
      
      // Check for lowercase
      this.hasLowerCase = /[a-z]/.test(this.form.new_password);
      
      // Check for number
      this.hasNumber = /\d/.test(this.form.new_password);
      
      // Check for special character
      this.hasSpecialChar = /[!@#$%^&*(),.?":{}|<>_=+]/.test(this.form.new_password);

      if (!this.form.new_password) {
        this.errors.new_password = 'Password is required.';
        this.isNewPasswordValid = false;
        return;
      }

      if (this.form.new_password.length < 8) {
        this.errors.new_password = 'Password must be at least 8 characters.';
        this.isNewPasswordValid = false;
        return;
      }

      if (!this.hasUpperCase || !this.hasLowerCase || !this.hasNumber || !this.hasSpecialChar) {
        this.errors.new_password = 'Password must include at least one uppercase letter, lowercase letter, number, and special character.';
        this.isNewPasswordValid = false;
        return;
      }

      this.isNewPasswordValid = true;
    },
    validateConfirmPassword() {
      this.errors.confirm_password = '';

      if (!this.form.confirm_password) {
        this.errors.confirm_password = 'Confirm Password is required.';
        this.isConfirmPasswordValid = false;
        return;
      }

      if (this.form.confirm_password !== this.form.new_password) {
        this.errors.confirm_password = 'Passwords do not match.';
        this.isConfirmPasswordValid = false;
        return;
      }

      this.isConfirmPasswordValid = true;
    },
    async changePassword() {
      if (this.isSubmitting) {
        return;
      }

      this.validateNewPassword();
      this.validateConfirmPassword();

      if (this.errors.new_password || this.errors.confirm_password) {
        return;
      }

      this.isSubmitting = true;
      try {
        const response = await axios.post('/patient/update-password', this.form);
        alert('Password updated successfully! Please log out and log in with your new password.');

        this.form.new_password = '';
        this.form.confirm_password = '';
        this.isNewPasswordValid = false;
        this.isConfirmPasswordValid = false;
        this.errors.new_password = '';
        this.errors.confirm_password = '';
        this.hasMinLength = false;
        this.hasUpperCase = false;
        this.hasLowerCase = false;
        this.hasNumber = false;
        this.hasSpecialChar = false;
      } catch (error) {
        if (error.response && error.response.status === 422) {
          const errors = error.response.data.errors;
          if (errors.new_password) {
            this.errors.new_password = errors.new_password[0];
            this.isNewPasswordValid = false;
          }
          if (errors.confirm_password) {
            this.errors.confirm_password = errors.confirm_password[0];
            this.isConfirmPasswordValid = false;
          }
        } else {
          console.error('Error changing password:', error);
          alert('An error occurred while changing your password: ' + (error.response?.data?.message || error.message));
        }
      } finally {
        this.isSubmitting = false;
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
  },
};
</script>

<style scoped>
@import url('https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css');
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

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
  cursor: pointer;
  overflow: hidden;
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

/* Settings section styles */
.settings-section {
  padding: 20px 30px;
  width: 100%;
}

.settings-card {
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
  overflow: hidden;
  transition: all 0.3s ease;
  width: 100%;
  max-width: 1400px;
  margin: 0 auto;
  margin-top: 20px;
}

.card-header {
  padding: 24px;
  background-color: #f9f9f9;
}

.user-info {
  display: flex;
  align-items: center;
  gap: 16px;
}

.user-avatar {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  background-color: #06693A;
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 24px;
  font-weight: 600;
  flex-shrink: 0;
}

.card-divider {
  height: 1px;
  background-color: #e5e5e5;
  margin: 0;
}

.card-content {
  padding: 24px;
}

.section-title {
  font-size: 20px;
  font-weight: 600;
  color: #333;
  margin-bottom: 20px;
}

.password-requirements {
  display: flex;
  background-color: #f8f9fa;
  border-radius: 8px;
  padding: 20px;
  margin-bottom: 24px;
  gap: 20px;
  align-items: flex-start;
}

.requirements-icon {
  font-size: 24px;
  color: #06693A;
  flex-shrink: 0;
}

.requirements-icon i {
  font-size: 32px;
}

.requirements-text {
  flex: 1;
  min-width: 0;
}

.requirements-text p {
  font-weight: 500;
  margin-bottom: 12px;
  color: #333;
}

.requirements-text ul {
  list-style: none;
  padding: 0;
  margin: 0 0 16px;
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 12px;
}

.requirements-text li {
  position: relative;
  padding-left: 28px;
  color: #666;
  font-size: 14px;
  display: flex;
  align-items: center;
  transition: all 0.3s ease;
}

.requirements-text li i {
  position: absolute;
  left: 0;
  font-size: 18px;
  color: #dc3545;
}

.requirements-text li.requirement-met {
  color: #06693A;
  font-weight: 500;
}

.requirements-text li.requirement-met i {
  color: #06693A;
  animation: checkmark 0.5s ease-in-out;
}

@keyframes checkmark {
  0% {
    transform: scale(0);
    opacity: 0;
  }
  50% {
    transform: scale(1.2);
  }
  100% {
    transform: scale(1);
    opacity: 1;
  }
}

.password-strength {
  margin-top: 16px;
  padding-top: 16px;
  border-top: 1px solid #eee;
}

.strength-label {
  font-weight: 500;
  margin-bottom: 8px;
  color: #333;
}

.strength-meter {
  height: 8px;
  background-color: #e9ecef;
  border-radius: 4px;
  overflow: hidden;
  margin-bottom: 8px;
}

.strength-progress {
  height: 100%;
  border-radius: 4px;
  transition: width 0.3s ease;
}

.strength-progress.weak {
  background-color: #dc3545;
}

.strength-progress.medium {
  background-color: #ffc107;
}

.strength-progress.strong {
  background-color: #28a745;
}

.strength-text {
  font-size: 14px;
  font-weight: 500;
}

.strength-text.weak {
  color: #dc3545;
}

.strength-text.medium {
  color: #ffc107;
}

.strength-text.strong {
  color: #28a745;
}

.password-form {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.form-row {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 24px;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.form-group label {
  font-weight: 500;
  color: #333;
  font-size: 14px;
}

.password-input-container {
  position: relative;
  display: flex;
  align-items: center;
}

.password-input {
  width: 100%;
  padding: 12px 16px;
  border: 1px solid #ddd;
  border-radius: 8px;
  font-size: 14px;
  transition: all 0.3s ease;
  padding-right: 45px;
}

.password-input:focus {
  outline: none;
  border-color: #06693A;
  box-shadow: 0 0 0 2px rgba(6, 105, 58, 0.1);
}

.password-input::placeholder {
  color: #aaa;
}

.toggle-password {
  position: absolute;
  right: 12px;
  background: none;
  border: none;
  color: #666;
  cursor: pointer;
  font-size: 18px;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 4px;
  border-radius: 4px;
}

.toggle-password:hover {
  color: #06693A;
  background-color: rgba(6, 105, 58, 0.1);
}

.toggle-password i {
  font-size: 20px;
}

.input-error {
  border-color: #dc3545;
}

.input-success {
  border-color: #28a745;
}

.error-message {
  display: flex;
  align-items: center;
  gap: 6px;
  color: #dc3545;
  font-size: 12px;
  margin-top: 4px;
}

.error-message i {
  font-size: 14px;
}

.form-actions {
  margin-top: 12px;
  display: flex;
  justify-content: flex-end;
}

.submit-button {
  padding: 14px 28px;
  background-color: #06693A;
  color: white;
  border: none;
  border-radius: 8px;
  font-weight: 600;
  font-size: 16px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  transition: all 0.3s ease;
  min-width: 160px;
}

.submit-button:hover {
  background-color: #055a32;
  transform: translateY(-1px);
}

.submit-button:disabled {
  background-color: #ccc;
  cursor: not-allowed;
  transform: none;
}

.submit-button i {
  font-size: 18px;
}

/* Responsive Design */

/* Large Desktop */
@media (min-width: 1400px) {
  .settings-section {
    padding: 30px 40px;
  }
}

/* Desktop */
@media (max-width: 1200px) {
  .settings-section {
    padding: 20px 25px;
  }
  
  .requirements-text ul {
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
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
  
  .settings-section {
    padding: 15px 20px;
  }
  
  .card-header {
    padding: 20px;
  }
  
  .card-content {
    padding: 20px;
  }
  
  .user-avatar {
    width: 50px;
    height: 50px;
    font-size: 20px;
  }
  
  .password-requirements {
    flex-direction: column;
    gap: 15px;
    padding: 16px;
  }
  
  .requirements-icon {
    align-self: flex-start;
  }
  
  .requirements-text ul {
    grid-template-columns: 1fr;
    gap: 8px;
  }
  
  .form-row {
    grid-template-columns: 1fr;
    gap: 20px;
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
  
  .settings-section {
    padding: 10px 15px;
  }
  
  .settings-card {
    margin-top: 10px;
    border-radius: 8px;
  }
  
  .card-header {
    padding: 16px;
  }
  
  .card-content {
    padding: 16px;
  }
  
  .user-info {
    gap: 12px;
  }
  
  .user-avatar {
    width: 45px;
    height: 45px;
    font-size: 18px;
  }
  
  .user-info h4 {
    font-size: 16px;
  }
  
  .section-title {
    font-size: 18px;
    margin-bottom: 16px;
  }
  
  .password-requirements {
    padding: 12px;
    gap: 12px;
  }
  
  .requirements-icon i {
    font-size: 24px;
  }
  
  .requirements-text p {
    font-size: 14px;
    margin-bottom: 8px;
  }
  
  .requirements-text li {
    font-size: 13px;
    padding-left: 24px;
  }
  
  .requirements-text li i {
    font-size: 16px;
  }
  
  .password-strength {
    margin-top: 12px;
    padding-top: 12px;
  }
  
  .strength-label {
    font-size: 14px;
  }
  
  .strength-text {
    font-size: 13px;
  }
  
  .form-row {
    gap: 16px;
  }
  
  .form-group label {
    font-size: 13px;
  }
  
  .password-input {
    padding: 10px 12px;
    padding-right: 40px;
    font-size: 14px;
  }
  
  .toggle-password {
    right: 10px;
    font-size: 16px;
  }
  
  .toggle-password i {
    font-size: 18px;
  }
  
  .error-message {
    font-size: 11px;
  }
  
  .form-actions {
    margin-top: 16px;
    justify-content: stretch;
  }
  
  .submit-button {
    width: 100%;
    padding: 12px 20px;
    font-size: 14px;
    min-width: auto;
  }
  
  .submit-button i {
    font-size: 16px;
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
  
  .settings-section {
    padding: 8px 12px;
  }
  
  .card-header {
    padding: 12px;
  }
  
  .card-content {
    padding: 12px;
  }
  
  .user-info {
    gap: 10px;
  }
  
  .user-avatar {
    width: 40px;
    height: 40px;
    font-size: 16px;
  }
  
  .user-info h4 {
    font-size: 15px;
  }
  
  .section-title {
    font-size: 16px;
    margin-bottom: 12px;
  }
  
  .password-requirements {
    padding: 10px;
    gap: 10px;
  }
  
  .requirements-text p {
    font-size: 13px;
  }
  
  .requirements-text li {
    font-size: 12px;
    padding-left: 20px;
  }
  
  .requirements-text li i {
    font-size: 14px;
  }
  
  .form-row {
    gap: 12px;
  }
  
  .password-input {
    padding: 8px 10px;
    padding-right: 35px;
    font-size: 13px;
  }
  
  .toggle-password {
    right: 8px;
  }
  
  .submit-button {
    padding: 10px 16px;
    font-size: 13px;
  }
}

/* Landscape Mobile */
@media (max-height: 500px) and (orientation: landscape) {
  .settings-section {
    padding: 8px 15px;
  }
  
  .card-header {
    padding: 12px;
  }
  
  .card-content {
    padding: 12px;
  }
  
  .user-avatar {
    width: 35px;
    height: 35px;
    font-size: 14px;
  }
  
  .section-title {
    font-size: 16px;
    margin-bottom: 10px;
  }
  
  .password-requirements {
    padding: 8px;
    margin-bottom: 16px;
  }
  
  .requirements-text ul {
    margin-bottom: 8px;
  }
  
  .password-strength {
    margin-top: 8px;
    padding-top: 8px;
  }
  
  .form-row {
    gap: 12px;
  }
  
  .form-actions {
    margin-top: 12px;
  }
}
</style>