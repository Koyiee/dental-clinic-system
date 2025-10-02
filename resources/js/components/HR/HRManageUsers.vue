<template>
  <div class="sidebar close">
    <div class="logo-details">
      <img src="../Images/ATDC_Logo.png" alt="" class="logo">
      <div class="logo_name"><img class="img2" src="../Images/ATDC_Logo3.png" alt=""></div>
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
            <img src="../Images/profile_1.jpg" alt="profile">
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
        <i class="bx bx-menu" @click="toggleSidebar"></i>
        <div class="text">
          <h3>Manage Users</h3>
          <div class="breadcrumbs">
            <a class="none" href=""><p>Home / </p></a>
            <a class="current" href="/hrmanageusers"><p>Manage Users</p></a>
          </div>
        </div>
      </div>
      <hr color="#06693a">
      
      <!-- Search and Filter Section -->
      <div class="search-wrapper">
        <div class="search-container">
          <input 
            v-model="searchQuery" 
            placeholder="Search by name, ID, or status" 
            @keyup.enter="filterUsers" 
            class="search-input"
            :class="{ 'has-reset': searchQuery && isSearchActive }"
          />
          <i class="bx bx-search search-icon" @click="filterUsers"></i>
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
              <label>Status:</label>
              <select v-model="filter.status">
                <option value="">All Statuses</option>
                <option value="active">Active</option>
                <option value="archived">Archived</option>
                <option value="deactivated">Deactivated</option>
              </select>
            </div>
            <button class="reset-btn" @click="resetFilters">Reset Filters</button>
          </div>
        </div>
      </div>
      
      <!-- Users Container -->
      <div class="users-container">
  <div class="users-header">
    <h3>{{ totalUsers }} {{ selectedUserType === 'patient' ? 'Patients' : 'Dentists' }}</h3>
    <div class="header-actions">
      <div class="user-type-selector">
        <select id="user-type" v-model="selectedUserType" @change="onUserTypeChange">
          <option value="patient">Patient</option>
          <!-- <option value="dentist">Dentist</option> -->
        </select>
      </div>
      <button class="add-user-btn" @click="openModal">
        <i class='bx bx-plus'></i> Add {{ selectedUserType === 'patient' ? 'Patient' : 'Dentist' }}
      </button>
    </div>
  </div>
  
  <!-- Desktop Table -->
  <div class="table-wrapper">
    <table class="users-table desktop-table">
      <thead>
        <tr>
          <th @click="sortTable('PatientID')" class="sortable-header">
            Patient ID
            <i v-if="sortConfig.key === 'PatientID'" class="bx" :class="getSortIconClass('PatientID')"></i>
          </th>
          <th @click="sortTable('LastName')" class="sortable-header">
            {{ selectedUserType === 'patient' ? 'Patient Name' : 'Dentist Name' }}
            <i v-if="sortConfig.key === 'LastName'" class="bx" :class="getSortIconClass('LastName')"></i>
          </th>
          <th @click="sortTable('AccountStatus')" class="sortable-header">
            Account Status
            <i v-if="sortConfig.key === 'AccountStatus'" class="bx" :class="getSortIconClass('AccountStatus')"></i>
          </th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr 
          v-for="user in displayedUsers" 
          :key="user.UserID" 
          class="user-row"
          :class="{ 'clickable-row': selectedUserType === 'dentist' }"
        >
          <td class="truncate-cell">{{ user.PatientID || user.UserID }}</td>
          <td class="truncate-cell">{{ user.LastName }}, {{ user.FirstName }}</td>
          <td class="truncate-cell">
            <span class="status-badge" :class="getStatusClass(user.AccountStatus)">
              {{ capitalizeStatus(user.AccountStatus) }}
            </span>
          </td>
          <td class="actions-cell">
            <button 
              v-if="selectedUserType === 'dentist'"
              @click.stop="openDaysOffModal(user.UserID)" 
              class="action-button edit-btn"
              title="Edit Days Off"
            >
              Edit
            </button>
            <button 
              @click.stop="toggleStatus(user.UserID, user.AccountStatus)" 
              class="action-button"
              :class="{ 'activate-btn': user.AccountStatus === 'deactivated', 'deactivate-btn': user.AccountStatus === 'active' || user.AccountStatus === 'archived' }"
            >
              {{ user.AccountStatus === 'deactivated' ? 'Activate' : 'Deactivate' }}
            </button>
          </td>
        </tr>
        <tr v-if="displayedUsers.length === 0">
          <td :colspan="selectedUserType === 'dentist' ? 4 : 4" class="no-data">No Matching Users Found...</td>
        </tr>
      </tbody>
    </table>
  </div>
  
  <!-- Mobile Cards -->
  <div class="mobile-cards">
    <div 
      v-for="user in displayedUsers" 
      :key="user.UserID"
      class="user-card"
      :class="{ 'clickable-card': selectedUserType === 'dentist' }"
    >
      <div class="card-header">
        <h4>{{ user.LastName }}, {{ user.FirstName }}</h4>
        <span class="status-badge" :class="getStatusClass(user.AccountStatus)">
          {{ capitalizeStatus(user.AccountStatus) }}
        </span>
      </div>
      <div class="card-content">
        <div class="card-row">
          <span class="card-label">Patient ID:</span>
          <span>{{ user.PatientID || user.UserID }}</span>
        </div>
        <div class="card-row">
          <div class="mobile-actions">
            <button 
              v-if="selectedUserType === 'dentist'"
              @click.stop="openDaysOffModal(user.UserID)" 
              class="action-button-mobile edit-btn"
            >
              <i class='bx bx-calendar-edit'></i> Days Off
            </button>
            <button 
              @click.stop="toggleStatus(user.UserID, user.AccountStatus)" 
              class="action-button-mobile"
              :class="{ 'activate-btn': user.AccountStatus === 'deactivated', 'deactivate-btn': user.AccountStatus === 'active' || user.AccountStatus === 'archived' }"
            >
              {{ user.AccountStatus === 'deactivated' ? 'Activate' : 'Deactivate' }}
            </button>
          </div>
        </div>
      </div>
    </div>
    <div v-if="displayedUsers.length === 0" class="no-data-mobile">
      No Matching Users Found
    </div>
  </div>
  
  <!-- Pagination Section - ADD THIS -->
  <div class="see-more-container">
    <div class="pagination-info">
      Page {{ currentPage }} of {{ lastPage }}
    </div>
    <div class="pagination-actions">
      <button 
        class="pagination-btn prev" 
        @click="changePage(currentPage - 1)" 
        :disabled="currentPage === 1"
      >
        <i class='bx bx-chevron-left'></i> Previous
      </button>
      <button 
        class="pagination-btn next" 
        @click="changePage(currentPage + 1)" 
        :disabled="currentPage === lastPage"
      >
        Next <i class='bx bx-chevron-right'></i>
      </button>
    </div>
  </div>
</div>
      
      <!-- Modal for Adding Users -->
      <div class="modal-overlay" v-if="isModalVisible" @click.self="closeModal">
        <div class="modal-content">
          <div class="modal-header">
            <h3>Add {{ selectedUserType === 'patient' ? 'Patient' : 'Dentist' }}</h3>
            <button class="close-btn" @click="closeModal">
              <i class='bx bx-x'></i>
            </button>
          </div>
          
          <!-- Display errors -->
          <div v-if="errors.length" class="error-messages">
            <p v-for="(error, index) in errors" :key="index" class="error">{{ error }}</p>
          </div>
          
          <form ref="formRef" @submit.prevent="submitForm" enctype="multipart/form-data" novalidate>
            <div class="form-container">
              <!-- Common Fields -->
              <div class="form-group">
                <label for="LastName">Last Name <span class="required">*</span></label>
                <input
                  v-model="formData.LastName"
                  type="text"
                  id="LastName"
                  required
                  :class="{ 'is-invalid': formSubmitted && !formData.LastName }"
                >
                <div v-if="formSubmitted && !formData.LastName" class="invalid-feedback">
                  Last Name is required
                </div>
              </div>

              <div class="form-group">
                <label for="FirstName">First Name <span class="required">*</span></label>
                <input
                  v-model="formData.FirstName"
                  type="text"
                  id="FirstName"
                  required
                  :class="{ 'is-invalid': formSubmitted && !formData.FirstName }"
                >
                <div v-if="formSubmitted && !formData.FirstName" class="invalid-feedback">
                  First Name is required
                </div>
              </div>

              <div class="form-group">
                <label for="MiddleName">Middle Name</label>
                <input v-model="formData.MiddleName" type="text" id="MiddleName">
              </div>

              <div class="form-group">
                <label for="ContactNumber">Contact Number <span class="required">*</span> <span class="example-text">+63 xxx xxx xxxx</span></label>
                <input
                  v-model="formData.ContactNumber"
                  type="tel"
                  id="ContactNumber"
                  required
                  placeholder="+63"
                  maxlength="13"
                  pattern="^\+63\d{10}$"
                  @focus="prefixContactNumber"
                  :class="{ 'is-invalid': formSubmitted && (!formData.ContactNumber || !formData.ContactNumber.match(/^\+63\d{10}$/)) }"
                >
                <div v-if="formSubmitted && (!formData.ContactNumber || !formData.ContactNumber.match(/^\+63\d{10}$/))" class="invalid-feedback">
                  Please enter a valid contact number (+63 followed by 10 digits)
                </div>
              </div>

              <div class="form-group">
                <label for="Email">Email <span class="required">*</span> <span class="example-text">example@domain.com</span></label>
                <input
                  v-model="formData.Email"
                  type="email"
                  id="Email"
                  required
                  @input="checkEmailAvailability"
                  @blur="checkEmailAvailability"
                  :class="{ 'is-invalid': emailInvalid || (formSubmitted && !formData.Email) }"
                >
                <div v-if="formSubmitted && !formData.Email" class="invalid-feedback">
                  Email is required
                </div>
                <div v-else-if="emailInvalid" class="invalid-feedback">
                  {{ emailErrorMessage }}
                </div>
              </div>

              <div class="form-group">
                <label for="Username">Username <span class="required">*</span></label>
                <input
                  v-model="formData.Username"
                  type="text"
                  id="Username"
                  required
                  @input="checkUsernameAvailability"
                  @blur="checkUsernameAvailability"
                  :class="{ 'is-invalid': usernameInvalid || (formSubmitted && !formData.Username) }"
                >
                <div v-if="formSubmitted && !formData.Username" class="invalid-feedback">
                  Username is required
                </div>
                <div v-else-if="usernameInvalid" class="invalid-feedback">
                  {{ usernameErrorMessage }}
                </div>
              </div>

              <div class="form-group">
                <label for="Password">Password <span class="required">*</span> <span class="example-text">Must include A-Z, a-z, 0-9, and symbol.</span></label>
                <div class="password-input-wrapper">
                  <input
                    v-model="formData.Password"
                    :type="showPassword ? 'text' : 'password'"
                    id="Password"
                    required
                    pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$"
                    :class="{ 'is-invalid': formSubmitted && (!formData.Password || !formData.Password.match(/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/)) }"
                  >
                  <div class="eye-icon-container" @click="togglePasswordVisibility">
                    <svg v-if="!showPassword" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="eye-icon">
                      <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                      <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                    <svg v-else xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="eye-icon">
                      <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                      <circle cx="12" cy="12" r="3"></circle>
                      <line x1="3" y1="3" x2="21" y2="21"></line>
                    </svg>
                  </div>
                </div>
                <div v-if="formSubmitted && (!formData.Password || !formData.Password.match(/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/))" class="invalid-feedback">
                  Password must be at least 8 characters and include uppercase, lowercase, number, and symbol
                </div>
              </div>

              <div class="form-group">
                <label for="Password_confirmation">Confirm Password <span class="required">*</span> <span class="example-text">Must include A-Z, a-z, 0-9, and symbol.</span></label>
                <div class="password-input-wrapper">
                  <input
                    v-model="formData.Password_confirmation"
                    :type="showConfirmPassword ? 'text' : 'password'"
                    id="Password_confirmation"
                    required
                    pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$"
                    :class="{ 'is-invalid': formSubmitted && (!formData.Password_confirmation || formData.Password !== formData.Password_confirmation) }"
                  >
                  <div class="eye-icon-container" @click="toggleConfirmPasswordVisibility">
                    <svg v-if="!showConfirmPassword" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="eye-icon">
                      <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                      <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                    <svg v-else xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="eye-icon">
                      <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                      <circle cx="12" cy="12" r="3"></circle>
                      <line x1="3" y1="3" x2="21" y2="21"></line>
                    </svg>
                  </div>
                </div>
                <div v-if="formSubmitted && (!formData.Password_confirmation || formData.Password !== formData.Password_confirmation)" class="invalid-feedback">
                  {{ !formData.Password_confirmation ? 'Please confirm your password' : 'Passwords do not match' }}
                </div>
              </div>

              <div class="form-group">
                <label for="Gender">Gender <span class="required">*</span></label>
                <select
                  v-model="formData.Gender"
                  id="Gender"
                  required
                  :class="{ 'is-invalid': formSubmitted && !formData.Gender }"
                >
                  <option value="" disabled selected>Select</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                  <option value="Other">Other</option>
                </select>
                <div v-if="formSubmitted && !formData.Gender" class="invalid-feedback">
                  Gender is required
                </div>
              </div>

              <div class="form-group">
                <label for="BirthDate">Birth Date <span class="required">*</span></label>
                <input
                  v-model="formData.BirthDate"
                  type="date"
                  id="BirthDate"
                  required
                  @input="validateBirthDate"
                  @blur="validateBirthDate"
                  :max="maxDate"
                  :class="{ 'is-invalid': birthDateInvalid || (formSubmitted && !formData.BirthDate) }"
                >
                <div v-if="formSubmitted && !formData.BirthDate" class="invalid-feedback">
                  Birth Date is required
                </div>
                <div v-else-if="birthDateInvalid" class="invalid-feedback">
                  You must be at least 6 months old to register
                </div>
              </div>

              <div class="form-group">
                <label for="Age">Age <span class="required">*</span></label>
                <input
                  v-model="formData.Age"
                  type="text"
                  id="Age"
                  readonly
                  :class="{ 'is-invalid': birthDateInvalid || (formSubmitted && !formData.Age) }"
                >
                <div v-if="birthDateInvalid" class="invalid-feedback">
                  Age must be at least 6 months
                </div>
                <div v-else-if="formSubmitted && !formData.Age" class="invalid-feedback">
                  Age is required
                </div>
              </div>

              <div class="form-group">
                <label for="HomeTelephoneNumber">Home Tel. No. <span class="example-text">+63 2 XXXX XXXX</span></label>
                <input
                  v-model="formData.HomeTelephoneNumber"
                  type="tel"
                  id="HomeTelephoneNumber"
                  placeholder="+63 2"
                  @focus="prefixTelephoneNumber"
                  maxlength="14"
                  :class="{ 'is-invalid': formSubmitted && formData.HomeTelephoneNumber && formData.HomeTelephoneNumber !== '+63 2 ' && !formData.HomeTelephoneNumber.match(/^\+63 2 \d{8}$/) }"
                >
                <div v-if="formSubmitted && formData.HomeTelephoneNumber && formData.HomeTelephoneNumber !== '+63 2 ' && !formData.HomeTelephoneNumber.match(/^\+63 2 \d{8}$/)" class="invalid-feedback">
                  Please enter a valid home telephone number (+63 2 followed by 8 digits)
                </div>
              </div>

              <div class="form-group">
                <label for="OfficeNumber">Office No. <span class="example-text">+63 2 XXXX XXXX</span></label>
                <input
                  v-model="formData.OfficeNumber"
                  type="tel"
                  id="OfficeNumber"
                  placeholder="+63 2"
                  @focus="prefixOfficeNumber"
                  maxlength="14"
                  :class="{ 'is-invalid': formSubmitted && formData.OfficeNumber && formData.OfficeNumber !== '+63 2 ' && !formData.OfficeNumber.match(/^\+63 2 \d{8}$/) }"
                >
                <div v-if="formSubmitted && formData.OfficeNumber && formData.OfficeNumber !== '+63 2 ' && !formData.OfficeNumber.match(/^\+63 2 \d{8}$/)" class="invalid-feedback">
                  Please enter a valid office number (+63 2 followed by 8 digits)
                </div>
              </div>

              <div class="form-group">
                <label for="HomeAddress">Home Address <span class="required">*</span></label>
                <input
                  v-model="formData.HomeAddress"
                  type="text"
                  id="HomeAddress"
                  required
                  :class="{ 'is-invalid': formSubmitted && !formData.HomeAddress }"
                >
                <div v-if="formSubmitted && !formData.HomeAddress" class="invalid-feedback">
                  Home Address is required
                </div>
              </div>

              <!-- Patient-Specific Fields -->
              <template v-if="selectedUserType === 'patient'">
                <div class="form-group">
                  <label for="Religion">Religion <span class="required">*</span></label>
                  <select
                    v-model="formData.Religion"
                    id="Religion"
                    required
                    :class="{ 'is-invalid': formSubmitted && !formData.Religion }"
                  >
                    <option value="" disabled selected>Select</option>
                    <option value="Catholic">Roman Catholic</option>
                    <option value="Christian">Christian</option>
                    <option value="Iglesia ni Cristo">Iglesia ni Cristo</option>
                    <option value="Buddhist">Buddhism</option>
                    <option value="Hindu">Hinduism</option>
                    <option value="Other">Other</option>
                  </select>
                  <div v-if="formSubmitted && !formData.Religion" class="invalid-feedback">
                    Religion is required
                  </div>
                </div>

                <div class="form-group">
                  <label for="Nationality">Nationality <span class="required">*</span></label>
                  <select
                    v-model="formData.Nationality"
                    id="Nationality"
                    required
                    :class="{ 'is-invalid': formSubmitted && !formData.Nationality }"
                  >
                    <option value="" disabled selected>Select</option>
                    <option value="Filipino">Filipino</option>
                  </select>
                  <div v-if="formSubmitted && !formData.Nationality" class="invalid-feedback">
                    Nationality is required
                  </div>
                </div>

                <div class="form-group">
                  <label for="MaritalStatus">Marital Status <span class="required">*</span></label>
                  <select
                    v-model="formData.MaritalStatus"
                    id="MaritalStatus"
                    required
                    :class="{ 'is-invalid': formSubmitted && !formData.MaritalStatus }"
                  >
                    <option value="" disabled selected>Select</option>
                    <option value="Single">Single</option>
                    <option value="Married">Married</option>
                    <option value="Divorced">Divorced</option>
                    <option value="Widowed">Widowed</option>
                  </select>
                  <div v-if="formSubmitted && !formData.MaritalStatus" class="invalid-feedback">
                    Marital Status is required
                  </div>
                </div>

                <div class="form-group">
                  <label for="Occupation">Occupation <span class="required">*</span></label>
                  <input
                    v-model="formData.Occupation"
                    type="text"
                    id="Occupation"
                    required
                    :class="{ 'is-invalid': formSubmitted && !formData.Occupation }"
                  >
                  <div v-if="formSubmitted && !formData.Occupation" class="invalid-feedback">
                    Occupation is required
                  </div>
                </div>

                <div class="form-group">
                  <label for="ReferredBy">Referred By</label>
                  <input v-model="formData.ReferredBy" type="text" id="ReferredBy">
                </div>

                <div class="form-group">
                  <label for="GovernmentID">Upload Government ID <span class="required">*</span><span class="example-text">jpeg/png, max 10MB</span></label>
                  <div class="file-upload-wrapper">
                    <input
                      type="file"
                      id="GovernmentID"
                      @change="handleFileUpload"
                      required
                      accept="image/jpeg,image/png"
                      ref="governmentIDInput"
                      :class="{ 'is-invalid': formSubmitted && !formData.GovernmentID }"
                    >
                    <div class="file-upload-label">
                      <i class='bx bx-upload'></i>
                      <span>Choose a file</span>
                    </div>
                  </div>
                  <div v-if="formSubmitted && !formData.GovernmentID" class="invalid-feedback">
                    Please upload a valid government ID (JPG or PNG), 10 MB max
                  </div>
                </div>

                <div v-if="imagePreview" class="image-preview">
                  <p>Preview:</p>
                  <img :src="imagePreview" alt="Government ID Preview" width="300" height="auto"/>
                  <button type="button" class="remove-image-btn" @click="removeImage">
                    <i class='bx bx-x'></i>
                  </button>
                </div>
              </template>

              <!-- Dentist-Specific Fields -->
              <div v-if="selectedUserType === 'dentist'" class="form-group full-width">
                <label>Day Off (Select up to 2 days):</label>
                <div class="days-row">
                  <div class="day-checkbox-wrapper" v-for="day in weekDays" :key="day">
                    <input 
                      type="checkbox" 
                      :id="day.toLowerCase()" 
                      class="day-checkbox" 
                      v-model="formData.DayOff" 
                      :value="day"
                      :disabled="!formData.DayOff.includes(day) && formData.DayOff.length >= 2"
                    >
                    <label :for="day.toLowerCase()" class="custom-checkbox"></label>
                    <label :for="day.toLowerCase()" class="day-label">{{ day }}</label>
                  </div>
                </div>
                <div v-if="formData.DayOff.length >= 2" class="invalid-feedback mt-1">
                  You can only select up to 2 days off.
                </div>
              </div>

              <!-- Form Submission -->
              <div class="form-actions">
                <button class="cancel-btn" type="button" @click="closeModal">
                  <i class='bx bx-x'></i> Cancel
                </button>
                <button class="submit-btn" type="submit">
                  <i class='bx bx-check'></i> Submit
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <!-- Redesigned Days Off Modal -->
      <div v-if="isDaysOffModalVisible" class="modal-overlay" @click.self="closeDaysOffModal">
        <div class="modal-content days-off-modal">
          <div class="modal-header">
            <h3>
              <i class='bx bx-calendar-check'></i>
              Dentist Days Off
            </h3>
            <button class="close-btn" @click="closeDaysOffModal">
              <i class='bx bx-x'></i>
            </button>
          </div>
          
          <div class="days-off-content">
            <div class="days-off-info">
              <p class="days-off-description">
                Select up to 2 days when the dentist will not be available for appointments.
              </p>
              
              <div class="days-off-selection">
                <div 
                  v-for="day in weekDays" 
                  :key="day" 
                  class="day-card"
                  :class="{ 
                    'day-selected': selectedDaysOff.includes(day),
                    'day-disabled': !selectedDaysOff.includes(day) && selectedDaysOff.length >= 2
                  }"
                  @click="toggleDaySelection(day)"
                >
                  <div class="day-checkbox-container">
                    <input
                      type="checkbox"
                      :id="`modal-${day.toLowerCase()}`"
                      :value="day"
                      v-model="selectedDaysOff"
                      :disabled="!selectedDaysOff.includes(day) && selectedDaysOff.length >= 2"
                      class="sr-only"
                    />
                    <label :for="`modal-${day.toLowerCase()}`" class="day-checkbox">
                      <i class='bx bx-check'></i>
                    </label>
                  </div>
                  <span class="day-name">{{ day }}</span>
                </div>
              </div>
              
              <div v-if="selectedDaysOff.length > 0" class="selected-days-summary">
                <p>
                  <i class='bx bx-info-circle'></i>
                  <span>Selected days off: <strong>{{ selectedDaysOff.join(', ') }}</strong></span>
                </p>
              </div>
              
              <div v-if="daysOffError" class="error-message">
                <i class='bx bx-error-circle'></i>
                <span>{{ daysOffError }}</span>
              </div>
            </div>
          </div>
          
          <div class="modal-footer">
            <button @click="closeDaysOffModal" class="cancel-btn">
              <i class='bx bx-x'></i> Cancel
            </button>
            <button @click="updateDaysOff" class="save-btn">
              <i class='bx bx-check'></i> Save Changes
            </button>
          </div>
        </div>
      </div>
      <br>
    </div>
  </section>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
  name: "HRManageUsers",
  props: {
    firstName: { type: String, required: true },
    lastName: { type: String, required: true },
  },
  computed: {
    fullName() {
      return `${this.firstName} ${this.lastName}`;
    },
    filteredUsers() {
      return this.applyAllFilters(this.users);
    },
    uniqueStatuses() {
      return [...new Set(this.users.map(user => user.AccountStatus).filter(Boolean))];
    },
  },
  data() {
    return {
      currentPage: 1,
      lastPage: 1,
      perPage: 15, // Users per page
      totalUsers: 0,
      isSidebarClosed: true,
      isModalVisible: false,
      isDaysOffModalVisible: false,
      selectedUserType: 'patient',
      users: [],
      displayedUsers: [],
      searchQuery: '',
      formSubmitted: false,
      birthDateInvalid: false,
      usernameInvalid: false,
      usernameErrorMessage: '',
      emailInvalid: false,
      emailErrorMessage: '',
      emailTaken: false,
      usernameTaken: false,
      maxDate: '',
      showFilterMenu: false,
      isSearchActive: false,
      weekDays: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
      filter: {
        status: ''
      },
      sortConfig: {
        key: null,
        direction: 'asc'
      },
      formData: {
        LastName: "",
        FirstName: "",
        MiddleName: "",
        ContactNumber: "",
        Email: "",
        Username: "",
        Password: "",
        Password_confirmation: "",
        Gender: "",
        BirthDate: "",
        Age: "",
        Religion: "",
        Nationality: "",
        MaritalStatus: "",
        HomeAddress: "",
        HomeTelephoneNumber: "",
        Occupation: "",
        OfficeNumber: "",
        ReferredBy: "",
        GovernmentID: null,
        DayOff: [],
      },
      imagePreview: null,
      errors: [],
      selectedDentistId: null,
      selectedDaysOff: [],
      daysOffError: '',
      showPassword: false,
      showConfirmPassword: false,
    };
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
    toggleDaySelection(day) {
      if (this.selectedDaysOff.includes(day)) {
        this.selectedDaysOff = this.selectedDaysOff.filter(d => d !== day);
      } else if (this.selectedDaysOff.length < 2) {
        this.selectedDaysOff.push(day);
      }
    },
    async openDaysOffModal(userId) {
      this.selectedDentistId = userId;
      try {
        const response = await axios.get(`/hr/${userId}/days-off`);
        this.selectedDaysOff = response.data.DayOff || [];
        this.isDaysOffModalVisible = true;
        this.daysOffError = '';
      } catch (error) {
        console.error('Error fetching days off:', error);
        await Swal.fire({
          title: 'Error',
          text: 'Failed to fetch days off. Please try again.',
          icon: 'error',
          confirmButtonColor: '#06693A',
        });
      }
    },
    closeDaysOffModal() {
      this.isDaysOffModalVisible = false;
      this.selectedDentistId = null;
      this.selectedDaysOff = [];
      this.daysOffError = '';
    },
    async updateDaysOff() {
      if (this.selectedDaysOff.length > 2) {
        this.daysOffError = 'You can only select up to 2 days off.';
        return;
      }

      try {
        const response = await axios.put(`/hr/${this.selectedDentistId}/days-off`, {
          DayOff: this.selectedDaysOff
        });
        await Swal.fire({
          title: 'Success',
          text: response.data.message,
          icon: 'success',
          timer: 2000,
          showConfirmButton: false
        });
        this.closeDaysOffModal();
        this.fetchUsers();
      } catch (error) {
        console.error('Error updating days off:', error);
        await Swal.fire({
          title: 'Error',
          text: 'Failed to update days off. Please try again.',
          icon: 'error',
          confirmButtonColor: '#06693A',
        });
      }
    },
    getStatusClass(status) {
      if (!status) return '';
      switch(status.toLowerCase()) {
        case 'active': return 'status-active';
        case 'archived': return 'status-archived';
        case 'deactivated': return 'status-deactivated';
        default: return '';
      }
    },
    capitalizeStatus(status) {
      if (!status) return '';
      return status.charAt(0).toUpperCase() + status.slice(1).toLowerCase();
    },
    async toggleStatus(userId, currentStatus) {
  const newStatus = currentStatus === 'deactivated' ? 'active' : 'deactivated';
  const action = newStatus === 'deactivated' ? 'deactivate' : 'activate';
  const userTypeDisplay = this.selectedUserType === 'patient' ? 'patient' : 'dentist';
  
  const result = await Swal.fire({
    title: `Confirm ${action}`,
    text: `Are you sure you want to ${action} this ${userTypeDisplay}?`,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#06693A',
    cancelButtonColor: '#d33',
    confirmButtonText: `Yes, ${action}`,
    cancelButtonText: 'No, cancel'
  });

  if (!result.isConfirmed) return;

  try {
    // Log what we're sending
    console.log('Sending data:', {
      AccountID: userId,
      AccountStatus: newStatus
    });
    
    const response = await axios.post('/hr/update-status', {
      AccountID: userId,
      AccountStatus: newStatus
    });
    
    if (response.data.message) {
      await Swal.fire({
        title: 'Success',
        text: `${userTypeDisplay.charAt(0).toUpperCase() + userTypeDisplay.slice(1)} ${action}d successfully!`,
        icon: 'success',
        timer: 2000,
        showConfirmButton: false
      });
      
      const userIndex = this.users.findIndex(user => user.UserID === userId);
      if (userIndex !== -1) {
        this.users[userIndex].AccountStatus = newStatus;
        this.users = [...this.users];
        this.updateDisplayedUsers();
      }
    }
  } catch (error) {
    console.error(`Error ${action}ing ${userTypeDisplay}:`, error);
    
    // ADD THIS: Log the actual validation errors
    if (error.response && error.response.data && error.response.data.errors) {
      console.log('Validation errors:', error.response.data.errors);
    }
    
    await Swal.fire({
      title: 'Error',
      text: `Failed to ${action} ${userTypeDisplay}. Please try again.`,
      icon: 'error',
      confirmButtonColor: '#06693A',
    });
  }
},
    toggleSidebar() {
      this.isSidebarClosed = !this.isSidebarClosed;
    },
    openModal() {
      this.isModalVisible = true;
      this.formSubmitted = false;
      this.usernameInvalid = false;
      this.emailInvalid = false;
      this.birthDateInvalid = false;
      this.errors = [];
      this.resetForm();
      this.$nextTick(() => {
        this.prefixContactNumber();
        this.prefixTelephoneNumber();
        this.prefixOfficeNumber();
      });
    },
    async closeModal() {
      if (Object.values(this.formData).some(field => field !== '' && field !== null && !(Array.isArray(field) && field.length === 0))) {
        const result = await Swal.fire({
          title: 'Cancel Account Creation',
          text: 'Are you sure you want to cancel creating this account? All entered data will be lost.',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#06693A',
          confirmButtonText: 'Yes, cancel',
          cancelButtonText: 'No, continue'
        });

        if (!result.isConfirmed) {
          return;
        }
      }
      this.isModalVisible = false;
      this.resetForm();
    },
    resetForm() {
      this.formData = {
        LastName: "",
        FirstName: "",
        MiddleName: "",
        ContactNumber: "",
        Email: "",
        Username: "",
        Password: "",
        Password_confirmation: "",
        Gender: "",
        BirthDate: "",
        Age: "",
        Religion: "",
        Nationality: "",
        MaritalStatus: "",
        HomeAddress: "",
        HomeTelephoneNumber: "",
        Occupation: "",
        OfficeNumber: "",
        ReferredBy: "",
        GovernmentID: null,
        DayOff: [],
      };
      this.imagePreview = null;
      this.errors = [];
      this.formSubmitted = false;
      this.birthDateInvalid = false;
      this.usernameInvalid = false;
      this.emailInvalid = false;
      this.emailTaken = false;
      this.usernameTaken = false;
      this.showPassword = false;
      this.showConfirmPassword = false;
      if (this.$refs.governmentIDInput) {
        this.$refs.governmentIDInput.value = '';
      }
    },
    prefixContactNumber() {
      if (!this.formData.ContactNumber || !this.formData.ContactNumber.startsWith('+63')) {
        this.formData.ContactNumber = '+63';
      }
    },
    prefixTelephoneNumber() {
      if (!this.formData.HomeTelephoneNumber || !this.formData.HomeTelephoneNumber.startsWith('+63 2')) {
        this.formData.HomeTelephoneNumber = '+63 2 ';
      }
    },
    prefixOfficeNumber() {
      if (!this.formData.OfficeNumber || !this.formData.OfficeNumber.startsWith('+63 2')) {
        this.formData.OfficeNumber = '+63 2 ';
      }
    },
    validateBirthDate() {
      const birthdate = new Date(this.formData.BirthDate);
      const today = new Date();

      if (!this.formData.BirthDate || isNaN(birthdate)) {
        this.formData.Age = "";
        this.birthDateInvalid = false;
        return;
      }

      let age = today.getFullYear() - birthdate.getFullYear();
      let months = today.getMonth() - birthdate.getMonth();
      const days = today.getDate() - birthdate.getDate();

      if (months < 0 || (months === 0 && days < 0)) {
        age -= 1;
        months += 12;
      }

      if (days < 0) {
        months -= 1;
        if (months < 0) {
          months += 12;
        }
      }

      const totalMonths = (age * 12) + months;

      this.formData.Age = age;

      this.birthDateInvalid = totalMonths < 6;

      if (this.birthDateInvalid) {
        this.errors = this.errors.filter(e => e !== 'You must be at least 6 months old to register');
        this.errors.push('You must be at least 6 months old to register');
      } else {
        this.errors = this.errors.filter(e => e !== 'You must be at least 6 months old to register');
      }
    },
    handleFileUpload(event) {
      const file = event.target.files[0];
      
      if (file) {
        const validTypes = ['image/jpeg', 'image/png'];
        if (!validTypes.includes(file.type)) {
          this.errors.push('Government ID must be a JPG or PNG file');
          this.formData.GovernmentID = null;
          this.imagePreview = null;
          this.$refs.governmentIDInput.value = '';
          return;
        }

        const maxSize = 10 * 1024 * 1024; // 10MB
        if (file.size > maxSize) {
          this.errors.push('Government ID file size must not exceed 10MB');
          this.formData.GovernmentID = null;
          this.imagePreview = null;
          this.$refs.governmentIDInput.value = '';
          return;
        }

        this.formData.GovernmentID = file;
        this.imagePreview = URL.createObjectURL(file);
      } else {
        this.formData.GovernmentID = null;
        this.imagePreview = null;
      }
    },
    debounce(func, wait) {
      let timeout;
      return function (...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
      };
    },
    async checkEmailAvailability() {
      if (!this.formData.Email) {
        this.emailInvalid = true;
        this.emailErrorMessage = 'Email is required';
        return;
      }

      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailPattern.test(this.formData.Email)) {
        this.emailInvalid = true;
        this.emailErrorMessage = 'Please enter a valid email address';
        return;
      }

      try {
        const response = await axios.post('/users/check-email', {
          email: this.formData.Email,
        });
        this.emailTaken = response.data.exists;
        if (this.emailTaken) {
          this.emailInvalid = true;
          this.emailErrorMessage = 'This email is already in use';
        } else {
          this.emailInvalid = false;
          this.emailErrorMessage = '';
        }
      } catch (error) {
        console.error('Email check error:', error);
        this.emailInvalid = true;
        this.emailErrorMessage = 'Error checking email availability';
      }
    },
    async checkUsernameAvailability() {
      if (!this.formData.Username) {
        this.usernameInvalid = true;
        this.usernameErrorMessage = 'Username is required';
        return;
      }

      try {
        const response = await axios.post('/users/check-username', {
          username: this.formData.Username,
        });
        this.usernameTaken = response.data.exists;
        if (this.usernameTaken) {
          this.usernameInvalid = true;
          this.usernameErrorMessage = 'This username is already in use';
        } else {
          this.usernameInvalid = false;
          this.usernameErrorMessage = '';
        }
      } catch (error) {
        console.error('Username check error:', error);
        this.usernameInvalid = true;
        this.usernameErrorMessage = 'Error checking username availability';
      }
    },
    scrollToFirstError() {
      const firstInvalid = this.$el.querySelector('.was-validated :invalid, .form-group .invalid-feedback:not(:empty)');
      if (firstInvalid) {
        firstInvalid.scrollIntoView({ 
          behavior: 'smooth', 
          block: 'center' 
        });
      }
    },
    togglePasswordVisibility() {
      this.showPassword = !this.showPassword;
    },
    toggleConfirmPasswordVisibility() {
      this.showConfirmPassword = !this.showConfirmPassword;
    },
    async submitForm() {
      this.formSubmitted = true;
      this.errors = [];

      if (!this.$refs.formRef) {
        console.error('Form reference is missing');
        this.errors.push('Form submission failed due to an internal error.');
        return;
      }

      const form = this.$refs.formRef;
      form.classList.add('was-validated');

      await Promise.all([
        this.checkEmailAvailability(),
        this.checkUsernameAvailability()
      ]);
      this.validateBirthDate();

      if (this.birthDateInvalid) {
        this.errors.push('You must be at least 6 months old to register');
      }

      const passwordPattern = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/;
      if (!this.formData.Password || !passwordPattern.test(this.formData.Password)) {
        this.errors.push('Password must be at least 8 characters and include uppercase, lowercase, number, and symbol');
      }
      if (!this.formData.Password_confirmation) {
        this.errors.push('Please confirm your password');
      } else if (this.formData.Password !== this.formData.Password_confirmation) {
        this.errors.push('Passwords do not match');
      }
      if (!this.formData.ContactNumber || !this.formData.ContactNumber.match(/^\+63\d{10}$/)) {
        this.errors.push('Please enter a valid contact number (+63 followed by 10 digits)');
      }
      if (this.emailTaken) {
        this.errors.push('This email is already in use');
      }
      if (this.usernameTaken) {
        this.errors.push('This username is already in use');
      }
      if (this.formData.HomeTelephoneNumber && this.formData.HomeTelephoneNumber !== '+63 2 ' && !this.formData.HomeTelephoneNumber.match(/^\+63 2 \d{8}$/)) {
        this.errors.push('Please enter a valid home telephone number (+63 2 followed by 8 digits)');
      }
      if (this.formData.OfficeNumber && this.formData.OfficeNumber !== '+63 2 ' && !this.formData.OfficeNumber.match(/^\+63 2 \d{8}$/)) {
        this.errors.push('Please enter a valid office number (+63 2 followed by 8 digits)');
      }

      if (this.selectedUserType === 'patient') {
        if (!this.formData.Religion) {
          this.errors.push('Religion is required');
        }
        if (!this.formData.Nationality) {
          this.errors.push('Nationality is required');
        }
        if (!this.formData.MaritalStatus) {
          this.errors.push('Marital Status is required');
        }
        if (!this.formData.Occupation) {
          this.errors.push('Occupation is required');
        }
        if (!this.formData.GovernmentID) {
          this.errors.push('Please upload a valid government ID');
        }
      }

      if (!form.checkValidity() || this.errors.length) {
        console.log('Form errors:', this.errors);
        this.$nextTick(() => this.scrollToFirstError());
        return;
      }

      const formData = new FormData();
      const commonFields = [
        'LastName',
        'FirstName',
        'MiddleName',
        'ContactNumber',
        'Email',
        'Username',
        'Password',
        'Password_confirmation',
        'Gender',
        'BirthDate',
        'Age',
        'HomeAddress',
        'HomeTelephoneNumber',
        'OfficeNumber',
      ];

      const fieldsToInclude = [...commonFields];
      if (this.selectedUserType === 'patient') {
        fieldsToInclude.push('Religion', 'Nationality', 'MaritalStatus', 'Occupation', 'ReferredBy', 'GovernmentID');
      } else {
        fieldsToInclude.push('DayOff');
      }

      for (let key in this.formData) {
        if (fieldsToInclude.includes(key) && this.formData[key] !== null && this.formData[key] !== undefined) {
          if (key === 'DayOff' && Array.isArray(this.formData[key])) {
            this.formData[key].forEach((day, index) => {
              formData.append(`DayOff[${index}]`, day);
            });
          } else {
            formData.append(key, this.formData[key]);
          }
        }
      }

      try {
        let endpoint = this.selectedUserType === 'patient' ? '/patients' : '/dentists';
        const response = await axios.post(endpoint, formData, {
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        });
        const userTypeDisplay = this.selectedUserType === 'patient' ? 'Patient' : 'Dentist';
        await Swal.fire({
          title: 'Success!',
          text: `${userTypeDisplay} added successfully!`,
          icon: 'success',
          timer: 2000,
          showConfirmButton: false
        });
        this.resetForm();
        this.closeModal();
        this.fetchUsers();
      } catch (error) {
        console.error('Submission error:', error);
        if (error.response && error.response.status === 422) {
          this.errors = Object.values(error.response.data.errors).flat();
          this.$nextTick(() => this.scrollToFirstError());
        } else {
          this.errors = ['An unexpected error occurred. Please try again later.'];
          this.$nextTick(() => this.scrollToFirstError());
        }
      }
    },
    // async fetchUsers() {
    //   try {
    //     const endpoint = this.selectedUserType === 'patient' ? '/patients' : '/dentists';
    //     const response = await axios.get(endpoint);
    //     this.users = response.data;
    //     this.displayedUsers = [...this.users];
    //     this.updateDisplayedUsers();
    //   } catch (error) {
    //     console.error(`Error fetching ${this.selectedUserType}:`, error);
    //     this.users = [];
    //     this.displayedUsers = [];
    //   }
    // },
    async fetchUsers(page = 1) {
  try {
    let endpoint, response;
    if (this.selectedUserType === 'patient') {
      response = await axios.get('/patient-list', {
        params: {
          page: page,
          search: this.isSearchActive ? this.searchQuery : '',
          status: this.filter.status
        }
      });
      
      // FIX: Use the actual UserID from patient.user, not PatientID
      this.users = response.data.data.map(patient => ({
        UserID: patient.user.UserID,  // Changed from patient.PatientID
        PatientID: patient.PatientID,
        LastName: patient.user.LastName,
        FirstName: patient.user.FirstName,
        AccountStatus: patient.user.AccountStatus || 'active',
        user: patient.user
      }));
      
      this.currentPage = response.data.current_page;
      this.lastPage = response.data.last_page;
      this.totalUsers = response.data.total;
    } else {
      endpoint = '/dentists';
      response = await axios.get(endpoint, {
        params: {
          page: page,
          search: this.isSearchActive ? this.searchQuery : '',
          status: this.filter.status
        }
      });
      
      if (response.data.data) {
        this.users = response.data.data;
        this.currentPage = response.data.current_page || 1;
        this.lastPage = response.data.last_page || 1;
        this.totalUsers = response.data.total || response.data.data.length;
      } else {
        this.users = response.data;
        this.totalUsers = this.users.length;
      }
    }
    
    this.displayedUsers = [...this.users];
    
    if (this.sortConfig.key) {
      this.applySorting();
    }
  } catch (error) {
    console.error(`Error fetching ${this.selectedUserType}:`, error);
    this.users = [];
    this.displayedUsers = [];
    this.totalUsers = 0;
  }
},
changePage(page) {
  if (page > 0 && page <= this.lastPage) {
    this.fetchUsers(page);
  }
},
onUserTypeChange() {
  this.currentPage = 1;
  this.searchQuery = '';
  this.isSearchActive = false;
  this.filter.status = '';
  this.fetchUsers(1);
},
    setMaxDate() {
      const today = new Date();
      this.maxDate = today.toISOString().split('T')[0];
    },
    removeImage() {
      this.imagePreview = null;
      this.formData.GovernmentID = null;
      if (this.$refs.governmentIDInput) {
        this.$refs.governmentIDInput.value = '';
      }
    },
    matchesSearch(user) {
      const query = this.searchQuery.toLowerCase();
      return (
        `${user.LastName} ${user.FirstName}`.toLowerCase().includes(query) ||
        (user.PatientID || user.UserID).toString().includes(query) ||
        (user.AccountStatus || '').toLowerCase().includes(query)
      );
    },
    applyAllFilters(users) {
      let filtered = [...users];
      
      if (this.searchQuery && this.isSearchActive) {
        filtered = filtered.filter(user => this.matchesSearch(user));
      }

      if (this.filter.status) {
        filtered = filtered.filter(user => 
          user.AccountStatus.toLowerCase() === this.filter.status.toLowerCase()
        );
      }

      return filtered;
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
    status: ''
  };
  this.showFilterMenu = false;
  this.currentPage = 1;
  this.fetchUsers(1);
},
    resetSearch() {
  this.searchQuery = '';
  this.isSearchActive = false;
  this.currentPage = 1;
  this.fetchUsers(1);
},
    filterUsers() {
  if (!this.searchQuery.trim()) {
    this.isSearchActive = false;
  } else {
    this.isSearchActive = true;
  }
  this.currentPage = 1; // Reset to first page when filtering
  this.fetchUsers(1);
},
    updateDisplayedUsers() {
  // If you're doing server-side pagination, this method might just apply sorting
  this.applySorting();
},
    sortTable(key) {
      if (this.sortConfig.key === key) {
        this.sortConfig.direction = this.sortConfig.direction === 'asc' ? 'desc' : 'asc';
      } else {
        this.sortConfig.key = key;
        this.sortConfig.direction = 'asc';
      }
      this.applySorting();
    },
    applySorting() {
      const { key, direction } = this.sortConfig;
      if (!key) return;

      this.displayedUsers = [...this.displayedUsers].sort((a, b) => {
        let valueA = a[key];
        let valueB = b[key];

        valueA = valueA || '';
        valueB = valueB || '';

        if (key === 'UserID' || key === 'PatientID') {
          valueA = parseInt(valueA, 10);
          valueB = parseInt(valueB, 10);
          return direction === 'asc' ? valueA - valueB : valueB - valueA;
        }

        if (typeof valueA === 'string' && typeof valueB === 'string') {
          return direction === 'asc' 
            ? valueA.localeCompare(valueB) 
            : valueB.localeCompare(valueA);
        }

        return direction === 'asc' 
          ? (valueA > valueB ? 1 : -1) 
          : (valueA < valueB ? 1 : -1);
      });
    },
    getSortIconClass(key) {
      if (this.sortConfig.key === key) {
        return this.sortConfig.direction === 'asc' ? 'bx-caret-up' : 'bx-caret-down';
      }
      return '';
    },
  },
  created() {
    this.setMaxDate();
  },
  mounted() {
    this.fetchUsers();
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
    document.addEventListener('click', this.handleClickOutside);
  },
  beforeDestroy() {
    document.removeEventListener('click', this.handleClickOutside);
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
  min-width: 0;
}

/* Search and Filter Styles */
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
  width: 200px;
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

.filter-group select {
  width: 100%;
  padding: 8px;
  border: 1px solid #e0e0e0;
  border-radius: 4px;
  font-size: 14px;
}

.reset-btn {
  width: 100%;
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

/* Users Container */
.users-container {
  margin: 20px;
  background-color: white;
  border-radius: 12px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
  overflow: hidden;
}

.users-header {
  padding: 20px 25px;
  border-bottom: 1px solid #f0f0f0;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.users-header h3 {
  font-size: 18px;
  color: #333;
  font-weight: 600;
  margin: 0;
}

.header-actions {
  display: flex;
  align-items: center;
  gap: 15px;
}

.user-type-selector select {
  padding: 10px 35px 10px 15px;
  border-radius: 8px;
  border: 1px solid #e0e0e0;
  background-color: white;
  font-size: 14px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
  outline: none;
  cursor: pointer;
  appearance: none;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23333' d='M6 8.825L1.175 4 2.05 3.125 6 7.075 9.95 3.125 10.825 4z'/%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: right 12px center;
  min-width: 150px;
}

.add-user-btn {
  background-color: #06693A;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 8px;
  cursor: pointer;
  font-size: 14px;
  font-weight: 500;
  display: flex;
  align-items: center;
  gap: 8px;
  transition: background-color 0.2s, transform 0.1s;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

.add-user-btn:hover {
  background-color: #055a32;
}

.add-user-btn:active {
  transform: scale(0.98);
}

.table-wrapper {
  padding: 0;
}

.users-table {
  width: 100%;
  border-collapse: collapse;
  background-color: white;
  table-layout: fixed;
}

.users-table th,
.users-table td {
  padding: 16px;
  text-align: left;
  border-bottom: 1px solid #f5f5f5;
  color: #333;
  font-size: 14px;
}

.users-table th {
  color: #06693A;
  font-weight: 600;
  font-size: 14px;
  background-color: #f9f9f9;
}

.users-table th:nth-child(1),
.users-table td:nth-child(1) {
  width: 25%;
}

.users-table th:nth-child(2),
.users-table td:nth-child(2) {
  width: 25%;
}

.users-table th:nth-child(3),
.users-table td:nth-child(3) {
  width: 25%;
}

.users-table th:nth-child(4),
.users-table td:nth-child(4) {
  width: 15%;
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

.user-row {
  transition: background-color 0.2s;
}

.user-row:hover {
  background-color: #f9f9f9;
}

.users-table tr:last-child td {
  border-bottom: none;
}

.status-badge {
  display: inline-block;
  padding: 4px 10px;
  border-radius: 12px;
  font-size: 12px;
  font-weight: 500;
}

.status-active {
  background-color: #e6f7ee;
  color: #0d904b;
}

.status-archived {
  background-color: #e3f2fd;
  color: #1565c0;
}

.status-deactivated {
  background-color: #ffebee;
  color: #d32f2f;
}

.actions-cell {
  display: flex;
  align-items: center;
  gap: 8px;
}

.action-button {
  padding: 6px 12px;
  border-radius: 4px;
  font-size: 12px;
  font-weight: 500;
  cursor: pointer;
  border: none;
  transition: background-color 0.2s;
}

.activate-btn {
  background-color: #e6f7ee;
  color: #0d904b;
}

.activate-btn:hover {
  background-color: #d1f0e0;
}

.deactivate-btn {
  background-color: #ffebee;
  color: #d32f2f;
}

.deactivate-btn:hover {
  background-color: #ffd8db;
}

.no-data {
  text-align: center;
  color: #757575;
  padding: 30px !important;
}

/* Mobile Cards */
.mobile-cards {
  display: none;
  padding: 15px;
}

.user-card {
  background-color: white;
  border-radius: 12px;
  border: 1px solid #e0e0e0;
  margin-bottom: 16px;
  overflow: hidden;
  transition: transform 0.2s, box-shadow 0.2s;
}

.user-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 16px;
  border-bottom: 1px solid #f0f0f0;
}

.card-header h4 {
  margin: 0;
  font-size: 16px;
  font-weight: 600;
  color: #333;
}

.card-content {
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

.action-button-mobile {
  width: 100%;
  padding: 8px 12px;
  border-radius: 4px;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  border: none;
  transition: background-color 0.2s;
  margin-top: 8px;
}

.no-data-mobile {
  text-align: center;
  color: #757575;
  padding: 30px;
  background-color: white;
  border-radius: 12px;
  border: 1px solid #e0e0e0;
}

/* Enhanced Modal Styles */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.7);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
  backdrop-filter: blur(4px);
  transition: all 0.3s ease;
}

.modal-content {
  background: white;
  width: 100%;
  max-width: 1300px;
  max-height: 90vh;
  border-radius: 16px;
  box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);
  overflow: hidden;
  animation: modalFadeIn 0.4s ease;
  display: flex;
  flex-direction: column;
}

@keyframes modalFadeIn {
  from {
    opacity: 0;
    transform: translateY(30px) scale(0.95);
  }
  to {
    opacity: 1;
    transform: translateY(0) scale(1);
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

.close-btn {
  background: none;
  border: none;
  font-size: 24px;
  color: #777;
  cursor: pointer;
  transition: color 0.3s ease;
}

.close-btn:hover {
  color: #333;
}

.close-btn i {
  font-size: 20px;
}

.error-messages {
  margin: 15px 30px 0;
  padding: 12px 18px;
  background-color: #ffebee;
  border-radius: 10px;
  border-left: 4px solid #d32f2f;
}

.error {
  color: #d32f2f;
  font-size: 14px;
  margin: 5px 0;
}

form {
  overflow-y: auto;
  max-height: calc(90vh - 80px);
  scrollbar-width: thin;
  scrollbar-color: #06693A #f0f0f0;
}

form::-webkit-scrollbar {
  width: 8px;
}

form::-webkit-scrollbar-track {
  background: #f0f0f0;
  border-radius: 4px;
}

form::-webkit-scrollbar-thumb {
  background-color: #06693A;
  border-radius: 4px;
}

.form-container {
  display: flex;
  flex-wrap: wrap;
  padding: 25px 30px;
  gap: 20px;
}

.form-group {
  flex: 0 0 calc(33.333% - 20px);
  min-width: 250px;
  position: relative;
}

.label-container {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 8px;
  width: 100%;
}

.label-container label {
  flex-shrink: 0;
  margin-right: 10px;
}

.example-text {
  color: #888;
  font-size: 12px;
  font-style: italic;
  white-space: nowrap;
  margin-left: 5px;
}

.form-group label {
  display: inline-block;
  font-weight: 500;
  margin-bottom: 8px;
  color: #444;
  font-size: 14px;
}

.required {
  color: #d32f2f;
  margin-left: 2px;
}

input,
select,
input[type="file"] {
  width: 100%;
  padding: 12px 15px;
  border: 1px solid #e0e0e0;
  border-radius: 10px;
  font-size: 14px;
  background-color: white;
  transition: all 0.2s ease;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.03);
}

input:focus,
select:focus {
  border-color: #06693A;
  box-shadow: 0 0 0 3px rgba(6, 105, 58, 0.1);
  outline: none;
}

select {
  appearance: none;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2306693A' d='M6 8.825L1.175 4 2.05 3.125 6 7.075 9.95 3.125 10.825 4z'/%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: right 15px center;
  padding-right: 40px;
}

input.is-invalid,
select.is-invalid,
input[type="file"].is-invalid {
  border-color: #d32f2f;
  background-color: #fff8f8;
}

input.is-invalid:focus,
select.is-invalid:focus,
input[type="file"].is-invalid:focus {
  border-color: #d32f2f;
  box-shadow: 0 0 0 3px rgba(211, 47, 47, 0.1);
}

.invalid-feedback {
  color: #d32f2f;
  font-size: 12px;
  margin-top: 6px;
  display: block;
}

.form-group.full-width {
  flex: 0 0 100%;
  width: 100%;
}

/* Password input wrapper and eye icon styles */
.password-input-wrapper {
  position: relative;
  display: flex;
  align-items: center;
}

.password-input-wrapper input {
  padding-right: 45px;
}

.eye-icon-container {
  position: absolute;
  right: 12px;
  top: 50%;
  transform: translateY(-50%);
  cursor: pointer;
  color: #666;
  display: flex;
  align-items: center;
  justify-content: center;
  pointer-events: auto;
  padding: 5px;
  z-index: 2;
}

.eye-icon {
  color: #666;
  transition: color 0.3s ease;
}

.eye-icon-container:hover .eye-icon {
  color: #06693A;
}

/* File upload styling */
.file-upload-wrapper {
  position: relative;
  overflow: hidden;
  border-radius: 10px;
  border: 1px dashed #06693A;
  background-color: rgba(6, 105, 58, 0.05);
  transition: all 0.2s ease;
  cursor: pointer;
}

.file-upload-wrapper:hover {
  background-color: rgba(6, 105, 58, 0.08);
}

.file-upload-wrapper input[type="file"] {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  opacity: 0;
  cursor: pointer;
  z-index: 2;
}

.file-upload-label {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 15px;
  color: #06693A;
  font-weight: 500;
  gap: 10px;
}

.file-upload-label i {
  font-size: 20px;
}

.image-preview {
  flex: 0 0 100%;
  margin-top: 10px;
  position: relative;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.image-preview p {
  font-weight: 500;
  margin-bottom: 10px;
  color: #444;
}

.image-preview img {
  border-radius: 10px;
  border: 1px solid #e0e0e0;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  max-width: 100%;
  height: auto;
}

.remove-image-btn {
  position: absolute;
  top: 10px;
  right: 10px;
  background: rgba(211, 47, 47, 0.8);
  color: white;
  border: none;
  width: 30px;
  height: 30px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.2s ease;
}

.remove-image-btn:hover {
  background: rgba(211, 47, 47, 1);
  transform: scale(1.1);
}

/* Day Off Checkboxes */
.days-row {
  display: flex;
  flex-wrap: wrap;
  gap: 15px;
  margin-top: 10px;
}

.day-checkbox-wrapper {
  display: flex;
  align-items: center;
  min-width: 120px;
  position: relative;
}

.day-checkbox {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  width: 20px;
  height: 20px;
  z-index: 1;
  margin: 0;
  left: 0;
  top: 50%;
  transform: translateY(-50%);
}

.custom-checkbox {
  position: relative;
  height: 20px;
  width: 20px;
  margin-right: 10px;
  cursor: pointer;
  display: inline-block;
}

.custom-checkbox::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  height: 20px;
  width: 20px;
  border: 2px solid #06693A;
  border-radius: 6px;
  background-color: white;
  transition: all 0.2s ease;
  box-sizing: border-box;
}

.day-checkbox:checked + .custom-checkbox::before {
  background-color: #06693A;
  border-color: #06693A;
}

.day-checkbox:checked + .custom-checkbox::after {
  content: "";
  position: absolute;
  left: 7px;
  top: 3px;
  width: 6px;
  height: 12px;
  border: solid white;
  border-width: 0 2px 2px 0;
  transform: rotate(45deg);
}

.day-checkbox:focus + .custom-checkbox::before {
  box-shadow: 0 0 0 3px rgba(6, 105, 58, 0.2);
}

.custom-checkbox:hover::before {
  border-color: #06693A;
  background-color: rgba(6, 105, 58, 0.05);
}

.day-label {
  cursor: pointer;
  user-select: none;
  font-size: 14px;
  color: #444;
}

/* Form Actions */
.form-actions {
  display: flex;
  justify-content: flex-end;
  width: 100%;
  margin-top: 30px;
  gap: 15px;
}

.cancel-btn, .submit-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding: 12px 24px;
  border-radius: 10px;
  font-size: 15px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s ease;
  border: none;
}

.cancel-btn {
  background: #f5f5f5;
  color: #555;
}

.cancel-btn:hover {
  background: #e0e0e0;
}

.submit-btn {
  background: #06693A;
  color: white;
  box-shadow: 0 4px 10px rgba(6, 105, 58, 0.2);
}

.submit-btn:hover {
  background: #055a32;
  transform: translateY(-2px);
  box-shadow: 0 6px 15px rgba(6, 105, 58, 0.25);
}

.submit-btn:active {
  transform: translateY(0);
  box-shadow: 0 2px 5px rgba(6, 105, 58, 0.2);
}

.clickable-row, .clickable-card {
  cursor: pointer;
}
.clickable-row:hover, .clickable-card:hover {
  background-color: #f5f5f5;
}

/* New styles for the enhanced UI */

/* Action buttons */
.edit-btn {
  background-color: #e3f2fd;
  color: #1565c0;
  display: flex;
  align-items: center;
  gap: 5px;
}

.edit-btn:hover {
  background-color: #bbdefb;
}

.edit-btn i {
  font-size: 14px;
}

.mobile-actions {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

/* Days Off Modal Styles */
.days-off-modal {
  max-width: 600px;
  border-radius: 16px;
  overflow: hidden;
}

.days-off-content {
  padding: 20px 25px;
}

.days-off-description {
  color: #555;
  font-size: 15px;
  margin-bottom: 20px;
  line-height: 1.5;
}

.days-off-selection {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
  gap: 15px;
  margin-bottom: 20px;
}

.day-card {
  display: flex;
  align-items: center;
  padding: 12px 15px;
  background-color: #f9f9f9;
  border-radius: 10px;
  cursor: pointer;
  transition: all 0.2s ease;
  border: 2px solid transparent;
}

.day-card:hover {
  background-color: #f0f0f0;
}

.day-selected {
  background-color: #e6f7ee;
  border-color: #06693A;
}

.day-selected:hover {
  background-color: #d1f0e0;
}

.day-disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.day-checkbox-container {
  margin-right: 10px;
}

.sr-only {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0, 0, 0, 0, 0);
  white-space: nowrap;
  border-width: 0;
}

.day-checkbox {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 22px;
  height: 22px;
  border: 2px solid #ccc;
  border-radius: 6px;
  transition: all 0.2s ease;
}

.day-selected .day-checkbox {
  background-color: #06693A;
  border-color: #06693A;
  color: white;
}

.day-checkbox i {
  opacity: 0;
  transform: scale(0);
  transition: all 0.2s ease;
}

.day-selected .day-checkbox i {
  opacity: 1;
  transform: scale(1);
}

.day-name {
  font-size: 14px;
  font-weight: 500;
}

.selected-days-summary {
  background-color: #f5f5f5;
  border-radius: 10px;
  padding: 15px;
  margin-bottom: 20px;
}

.selected-days-summary p {
  display: flex;
  align-items: center;
  gap: 10px;
  margin: 0;
  color: #444;
}

.selected-days-summary i {
  color: #06693A;
  font-size: 18px;
}

.error-message {
  display: flex;
  align-items: center;
  gap: 10px;
  background-color: #ffebee;
  color: #d32f2f;
  padding: 15px;
  border-radius: 10px;
  margin-top: 15px;
}

.error-message i {
  font-size: 18px;
}

.modal-footer {
  display: flex;
  justify-content: flex-end;
  gap: 15px;
  padding: 20px 25px;
  border-top: 1px solid #f0f0f0;
  background-color: #f9f9f9;
}

.save-btn {
  display: flex;
  align-items: center;
  gap: 8px;
  background-color: #06693A;
  color: white;
  border: none;
  padding: 12px 20px;
  border-radius: 10px;
  font-size: 15px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s ease;
  box-shadow: 0 4px 10px rgba(6, 105, 58, 0.2);
}

.save-btn:hover {
  background-color: #055a32;
  transform: translateY(-2px);
  box-shadow: 0 6px 15px rgba(6, 105, 58, 0.25);
}

.save-btn:active {
  transform: translateY(0);
  box-shadow: 0 2px 5px rgba(6, 105, 58, 0.2);
}

/* Responsive Design */

/* Large Desktop */
@media (min-width: 1400px) {
  .users-container {
    margin: 30px;
  }
  
  .search-wrapper {
    margin-left: 30px;
    width: calc(100% - 60px);
  }
}

/* Desktop */
@media (max-width: 1200px) {
  .users-table th,
  .users-table td {
    padding: 12px;
    font-size: 13px;
  }
  
  .search-wrapper {
    margin-left: 15px;
    width: calc(100% - 30px);
  }
  
  .form-group {
    flex: 0 0 calc(50% - 20px);
    min-width: 200px;
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
    margin-left: 15px;
    width: calc(100% - 30px);
  }
  
  .users-container {
    margin: 15px;
  }
  
  .users-header {
    flex-direction: column;
    gap: 15px;
    align-items: flex-start;
  }
  
  .header-actions {
    width: 100%;
    justify-content: space-between;
  }
  
  .filter-menu {
    width: 180px;
  }
  
  .modal-content {
    max-width: 700px;
  }
  
  .form-group {
    flex: 0 0 100%;
    min-width: auto;
  }
  
  .days-off-selection {
    grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
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
  
  .users-header h3 {
    font-size: 16px;
  }
  
  .search-wrapper {
    flex-direction: column;
    gap: 15px;
    width: calc(100% - 20px);
    margin-left: 10px;
  }
  
  .search-container {
    width: 100%;
    margin-right: 0;
  }
  
  .search-input {
    height: 42px;
    font-size: 14px;
  }
  
  .buttons {
    align-self: flex-end;
  }
  
  .filter-menu {
    width: 160px;
    right: 0;
  }
  
  .users-container {
    margin: 10px;
  }
  
  .users-header {
    padding: 15px;
  }
  
  .header-actions {
    flex-direction: column;
    gap: 10px;
    width: 100%;
  }
  
  .user-type-selector select {
    width: 100%;
    min-width: auto;
  }
  
  .add-user-btn {
    width: 100%;
    justify-content: center;
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
  
  .form-container {
    padding: 15px;
    gap: 15px;
  }
  
  .form-group {
    flex: 0 0 100%;
    min-width: auto;
  }
  
  .days-row {
    gap: 10px;
  }
  
  .day-checkbox-wrapper {
    min-width: 100px;
  }
  
  .form-actions {
    flex-direction: column;
    gap: 10px;
  }
  
  .cancel-btn, .submit-btn {
    width: 100%;
    justify-content: center;
  }
  
  .days-off-modal {
    width: 95%;
  }
  
  .days-off-selection {
    grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
    gap: 10px;
  }
  
  .modal-footer {
    flex-direction: column;
  }
  
  .cancel-btn, .save-btn {
    width: 100%;
    justify-content: center;
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
    margin-left: 8px;
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
    right: 40px;
    width: 24px;
    height: 24px;
  }
  
  .reset-button i {
    font-size: 16px;
  }
  
  .filter {
    padding: 10px 16px;
    font-size: 13px;
  }
  
  .filter-menu {
    width: 140px;
    padding: 12px;
  }
  
  .users-container {
    margin: 8px;
  }
  
  .users-header {
    padding: 12px;
  }
  
  .users-header h3 {
    font-size: 15px;
  }
  
  .user-card {
    margin-bottom: 12px;
  }
  
  .card-header {
    padding: 12px;
  }
  
  .card-header h4 {
    font-size: 15px;
  }
  
  .card-content {
    padding: 12px;
  }
  
  .card-row {
    margin-bottom: 10px;
  }
  
  .card-label {
    font-size: 13px;
  }
  
  .action-button-mobile {
    padding: 6px 12px;
    font-size: 13px;
  }
  
  .modal-content {
    border-radius: 10px;
  }
  
  .modal-header {
    padding: 12px;
  }
  
  .modal-header h3 {
    font-size: 16px;
  }
  
  .close-btn i {
    font-size: 18px;
  }
  
  .form-container {
    padding: 12px;
  }
  
  .form-group label {
    font-size: 13px;
  }
  
  .example-text {
    font-size: 11px;
  }
  
  input, select {
    padding: 10px 12px;
    font-size: 13px;
  }
  
  .password-input-wrapper input {
    padding-right: 40px;
  }
  
  .eye-icon-container {
    right: 10px;
    padding: 4px;
  }
  
  .days-row {
    gap: 8px;
  }
  
  .day-checkbox-wrapper {
    min-width: 80px;
  }
  
  .day-label {
    font-size: 13px;
  }
  
  .form-actions {
    margin-top: 20px;
  }
  
  .cancel-btn, .submit-btn {
    padding: 10px 16px;
    font-size: 14px;
  }
  
  .days-off-modal {
    border-radius: 10px;
  }
  
  .days-off-content {
    padding: 15px;
  }
  
  .days-off-description {
    font-size: 14px;
  }
  
  .days-off-selection {
    grid-template-columns: repeat(auto-fill, minmax(70px, 1fr));
    gap: 8px;
  }
  
  .day-card {
    padding: 8px 10px;
  }
  
  .day-checkbox {
    width: 18px;
    height: 18px;
  }
  
  .day-name {
    font-size: 12px;
  }
  
  .modal-footer {
    padding: 12px;
  }
  
  .cancel-btn, .save-btn {
    padding: 10px 16px;
    font-size: 14px;
  }
}

/* Landscape Mobile */
@media (max-height: 500px) and (orientation: landscape) {
  .modal-content {
    max-height: 95vh;
  }
  
  .form-container {
    max-height: calc(95vh - 120px);
  }
  
  .days-off-content {
    max-height: calc(95vh - 120px);
    overflow-y: auto;
  }
}

/* Pagination Styles */
.see-more-container {
  padding: 20px;
  border-top: 1px solid #f0f0f0;
  display: flex;
  justify-content: space-between;
  align-items: center;
  background-color: #f9f9f9;
}

.pagination-info {
  color: #666;
  font-size: 14px;
  font-weight: 500;
}

.pagination-actions {
  display: flex;
  gap: 10px;
}

.pagination-btn {
  background-color: #06693A;
  color: white;
  border: none;
  padding: 8px 16px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 14px;
  display: flex;
  align-items: center;
  gap: 5px;
  transition: background-color 0.2s;
}

.pagination-btn:hover:not(:disabled) {
  background-color: #055a32;
}

.pagination-btn:disabled {
  background-color: #ccc;
  cursor: not-allowed;
  opacity: 0.6;
}

.pagination-btn i {
  font-size: 14px;
}

@media (max-width: 768px) {
  /* ... existing mobile styles ... */
  
  .see-more-container {
    padding: 15px;
    flex-direction: column;
    gap: 10px;
    align-items: flex-start;
  }
  
  .pagination-actions {
    width: 100%;
    justify-content: space-between;
  }
  
  .pagination-btn {
    flex: 1;
    justify-content: center;
  }
}

@media (max-width: 480px) {
  .see-more-container {
    padding: 12px;
  }
  
  .pagination-info {
    font-size: 12px;
  }
  
  .pagination-btn {
    padding: 6px 12px;
    font-size: 12px;
  }
}

</style>
