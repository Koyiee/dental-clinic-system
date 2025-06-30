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
          <h3>Manage Users</h3>
          <div class="breadcrumbs">
            <a class="none" href=""><p>Home / </p></a>
            <a class="current" href="/ownermanageusers"><p>Manage Users</p></a>
          </div>
        </div>
      </div>
      <hr color="#06693a">
      
      <!-- Search and Filter Section -->
      <div class="search-wrapper">
        <div class="search-container">
          <input v-model="searchQuery" placeholder="Search by name, ID, or status" @input="" class="search-input"/>
          <i class="bx bx-search search-icon"></i>
        </div>
        <div class="buttons">
          <button class="filter" @click="toggleFilterMenu">
            <i class='bx bx-filter'></i> Filter
          </button>
          <div v-if="showFilterDropdown" class="filter-menu">
            <button @click="filterUsers('active')">Active</button>
            <button @click="filterUsers('archived')">Archived</button>
            <button @click="filterUsers('deactivated')">Deactivated</button>
          </div>
        </div>
      </div>
      
      <!-- Users Container -->
      <div class="users-container">
        <div class="users-header">
        <h3>List of {{ selectedUserType === 'patient' ? 'Patients' : 
                      selectedUserType === 'dentist' ? 'Dentists' : 
                      selectedUserType === 'hradmin' ? 'HR Admins' : 'Owners' }}</h3>
        <div class="header-actions">
          <div class="user-type-selector">
            <select id="user-type" v-model="selectedUserType" @change="fetchUsers">
              <option value="patient">Patient</option>
              <option value="dentist">Dentist</option>
              <option value="hradmin">HR Admin</option>
              <option value="owner">Owner</option>
            </select>
          </div>
          <button class="add-user-btn" @click="openModal">
            <i class='bx bx-plus'></i> Add {{ selectedUserType === 'patient' ? 'Patient' : 
                                            selectedUserType === 'dentist' ? 'Dentist' : 
                                            selectedUserType === 'hradmin' ? 'HR Admin' : 'Owner' }}
          </button>
        </div>
      </div>
        
        <!-- Desktop Table -->
        <div class="table-wrapper">
          <table class="users-table desktop-table">
            <thead>
              <tr>
                <th style="padding-left: 25px;">User ID</th>
                <th>{{ selectedUserType === 'patient' ? 'Patient Name' : 
                      selectedUserType === 'dentist' ? 'Dentist Name' : 
                      selectedUserType === 'hradmin' ? 'HR Admin Name' : 'Owner Name' }}</th>
                <th>Account Status</th>
                <th v-if="selectedUserType !== 'patient'">Action</th> <!-- Hide Action column for patients -->
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="user in filteredUsers"
                :key="user.UserID"
                class="user-row"
              >
                <td style="padding-left: 25px;">{{ user.UserID }}</td>
                <td>
                  {{ user.LastName }}, {{ user.FirstName }}
                  {{ user.IsSuperOwner && selectedUserType === 'owner' ? '(Superowner)' : '' }}
                </td>
                <td>
                  <span class="status-badge" :class="getStatusClass(user.AccountStatus)">
                    {{ capitalizeStatus(user.AccountStatus) }}
                  </span>
                </td>
                <td v-if="selectedUserType !== 'patient'" class="actions-cell">
                  <button
                    v-if="selectedUserType === 'dentist'"
                    @click.stop="openDaysOffModal(user.UserID)"
                    class="action-button edit-btn"
                    title="Edit Days Off"
                  >
                    Edit
                  </button>
                  <button
                    v-if="selectedUserType !== 'patient' && (!user.IsSuperOwner || selectedUserType !== 'owner')"
                    @click.stop="toggleStatus(user.UserID, user.AccountStatus)"
                    class="action-button"
                    :class="{ 'activate-btn': user.AccountStatus === 'deactivated', 'deactivate-btn': user.AccountStatus === 'active' }"
                  >
                    {{ user.AccountStatus === 'active' ? 'Deactivate' : 'Activate' }}
                  </button>
                 
                  <span v-else-if="user.IsSuperOwner && selectedUserType === 'owner'" class="disabled-text">
                    <!-- Superowner (Non-deactivatable) -->
                  </span>
                </td>
              </tr>
              <tr v-if="filteredUsers.length === '0' || filteredUsers.length === 0">
                <td :colspan="selectedUserType === 'patient' ? 3 : 4" class="no-data">No Matching Users Found...</td>
              </tr>
            </tbody>
          </table>
        </div>
        
        <!-- Mobile Cards -->
        <div class="mobile-cards">
          <div
            v-for="user in filteredUsers"
            :key="user.UserID"
            class="user-card"
          >
            <div class="card-header">
              <h4>
                {{ user.LastName }}, {{ user.FirstName }}
                {{ user.IsSuperOwner && selectedUserType === 'owner' ? '(Superowner)' : '' }}
              </h4>
              <span class="status-badge" :class="getStatusClass(user.AccountStatus)">
                {{ capitalizeStatus(user.AccountStatus) }}
              </span>
            </div>
            <div class="card-content">
              <div class="card-row">
                <span class="card-label">User ID:</span>
                <span>{{ user.UserID }}</span>
              </div>
              <div v-if="selectedUserType !== 'patient'" class="card-row">
                <div class="mobile-actions">
                  <button
                    v-if="selectedUserType === 'dentist'"
                    @click.stop="openDaysOffModal(user.UserID)"
                    class="action-button-mobile edit-btn"
                    title="Edit Days Off"
                  >
                    <i class='bx bx-calendar-edit'></i> Days Off
                  </button>
                  <button
                    v-if="selectedUserType !== 'patient' && (!user.IsSuperOwner || selectedUserType !== 'owner')"
                    @click.stop="toggleStatus(user.UserID, user.AccountStatus)"
                    class="action-button-mobile"
                    :class="{ 'activate-btn': user.AccountStatus === 'deactivated', 'deactivate-btn': user.AccountStatus === 'active' }"
                  >
                    {{ user.AccountStatus === 'active' ? 'Deactivate' : 'Activate' }}
                  </button>
                  <span v-else-if="user.IsSuperOwner && selectedUserType === 'owner'" class="disabled-text">
                    Superowner (Non-deactivatable)
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div v-if="filteredUsers.length === '0' || filteredUsers.length === 0" class="no-data-mobile">
            No Matching Users Found
          </div>
        </div>
      </div>
      
      <!-- Modal for Adding Users -->
      <div class="modal-overlay" v-if="isModalVisible" @click.self="closeModal">
        <div class="modal-content">
          <div class="modal-header">
            <h3>Add {{ selectedUserType === 'patient' ? 'Patient' : 
                       selectedUserType === 'dentist' ? 'Dentist' : 
                       selectedUserType === 'hradmin' ? 'HR Admin' : 'Owner' }}</h3>
            <button class="close-btn" @click="closeModal">
              <i class='bx bx-x'></i>
            </button>
          </div>
          
          <!-- Display errors -->
          <div v-if="errors.length" class="error-messages">
            <p v-for="(error, index) in errors" :key="index" class="error">{{ error }}</p>
          </div>
          
          <form @submit.prevent="submitForm" enctype="multipart/form-data" novalidate>
            <div class="form-container">
              <!-- Common Fields -->
              <div class="form-group">
                <label for="LastName">Last Name <span class="required">*</span></label>
                <input
                  v-model="formData.LastName"
                  type="text"
                  id="LastName"
                  @input="restrictNumbers($event, 'LastName'); errors = []"
                  :class="{ 'is-invalid': errors.includes('Last Name is required') || errors.includes('Last Name must not contain numbers') }"
                >
                <div v-if="errors.includes('Last Name is required')" class="invalid-feedback">
                  Last Name is required
                </div>
                <div v-if="errors.includes('Last Name must not contain numbers')" class="invalid-feedback">
                  Last Name must not contain numbers
                </div>
              </div>

              <div class="form-group">
                <label for="FirstName">First Name <span class="required">*</span></label>
                <input
                  v-model="formData.FirstName"
                  type="text"
                  id="FirstName"
                  @input="restrictNumbers($event, 'FirstName'); errors = []"
                  :class="{ 'is-invalid': errors.includes('First Name is required') || errors.includes('First Name must not contain numbers') }"
                >
                <div v-if="errors.includes('First Name is required')" class="invalid-feedback">
                  First Name is required
                </div>
                <div v-if="errors.includes('First Name must not contain numbers')" class="invalid-feedback">
                  First Name must not contain numbers
                </div>
              </div>

              <div class="form-group">
                <label for="MiddleName">Middle Name</label>
                <input
                  v-model="formData.MiddleName"
                  type="text"
                  id="MiddleName"
                  @input="restrictNumbers($event, 'MiddleName'); errors = []"
                  :class="{ 'is-invalid': errors.includes('Middle Name must not contain numbers') }"
                >
                <div v-if="errors.includes('Middle Name must not contain numbers')" class="invalid-feedback">
                  Middle Name must not contain numbers
                </div>
              </div>

              <div class="form-group">
                <label for="ContactNumber">Contact Number <span class="required">*</span> <span class="example-text">+63 xxx xxx xxxx</span></label>
                <input
                  v-model="formData.ContactNumber"
                  type="tel"
                  id="ContactNumber"
                  placeholder="+63"
                  maxlength="13"
                  @input="restrictLetters($event, 'ContactNumber'); errors = []"
                  @focus="handleContactNumberInput"
                  :class="{ 'is-invalid': errors.includes('Contact Number is required') || errors.includes('Contact Number must be a valid number starting with +63 followed by 10 digits') }"
                >
                <div v-if="errors.includes('Contact Number is required')" class="invalid-feedback">
                  Contact Number is required
                </div>
                <div v-if="errors.includes('Contact Number must be a valid number starting with +63 followed by 10 digits')" class="invalid-feedback">
                  Contact Number must be a valid number starting with +63 followed by 10 digits
                </div>
              </div>

              <div class="form-group">
                <label for="Email">Email <span class="required">*</span> <span class="example-text">example@domain.com</span></label>
                <input
                  v-model="formData.Email"
                  type="email"
                  id="Email"
                  @blur="checkEmailAvailability"
                  @input="errors = []"
                  :class="{ 'is-invalid': errors.includes('Email is required') || errors.includes('Email must be a valid email address') || errors.includes('This email is already in use') }"
                >
                <div v-if="errors.includes('Email is required')" class="invalid-feedback">
                  Email is required
                </div>
                <div v-if="errors.includes('Email must be a valid email address')" class="invalid-feedback">
                  Email must be a valid email address
                </div>
                <div v-if="errors.includes('This email is already in use')" class="invalid-feedback">
                  This email is already in use
                </div>
              </div>

              <div class="form-group">
                <label for="Username">Username <span class="required">*</span></label>
                <input
                  v-model="formData.Username"
                  type="text"
                  id="Username"
                  @blur="checkUsernameAvailability"
                  @input="errors = []"
                  :class="{ 'is-invalid': errors.includes('Username is required') || errors.includes('This username is already taken') }"
                >
                <div v-if="errors.includes('Username is required')" class="invalid-feedback">
                  Username is required
                </div>
                <div v-if="errors.includes('This username is already taken')" class="invalid-feedback">
                  This username is already taken
                </div>
              </div>

              <div class="form-group">
                <label for="Password">Password <span class="required">*</span> <span class="example-text">Must include A-Z, a-z, 0-9, and symbol</span></label>
                <div class="password-input-wrapper">
                  <input
                    v-model="formData.Password"
                    :type="showPassword ? 'text' : 'password'"
                    id="Password"
                    @input="errors = []"
                    :class="{ 'is-invalid': errors.includes('Password is required') || errors.includes('Password must be at least 8 characters and include uppercase, lowercase, number, and symbol') }"
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
                <div v-if="errors.includes('Password is required')" class="invalid-feedback">
                  Password is required
                </div>
                <div v-if="errors.includes('Password must be at least 8 characters and include uppercase, lowercase, number, and symbol')" class="invalid-feedback">
                  Password must be at least 8 characters and include uppercase, lowercase, number, and symbol
                </div>
              </div>

              <div class="form-group">
                <label for="Password_confirmation">Confirm Password <span class="required">*</span></label>
                <div class="password-input-wrapper">
                  <input
                    v-model="formData.Password_confirmation"
                    :type="showConfirmPassword ? 'text' : 'password'"
                    id="Password_confirmation"
                    @input="errors = []"
                    :class="{ 'is-invalid': errors.includes('Please confirm your password') || errors.includes('Passwords do not match') }"
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
                <div v-if="errors.includes('Please confirm your password')" class="invalid-feedback">
                  Please confirm your password
                </div>
                <div v-if="errors.includes('Passwords do not match')" class="invalid-feedback">
                  Passwords do not match
                </div>
              </div>

              <div class="form-group">
                <label for="Gender">Gender <span class="required">*</span></label>
                <select
                  v-model="formData.Gender"
                  id="Gender"
                  @change="errors = []"
                  :class="{ 'is-invalid': errors.includes('Gender is required') }"
                >
                  <option value="">Select</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                  <option value="Other">Other</option>
                </select>
                <div v-if="errors.includes('Gender is required')" class="invalid-feedback">
                  Gender is required
                </div>
              </div>

              <div class="form-group">
                <label for="BirthDate">Birth Date <span class="required">*</span></label>
                <input
                  v-model="formData.BirthDate"
                  type="date"
                  id="BirthDate"
                  @change="validateBirthDate(); errors = []"
                  :max="maxDate"
                  :class="{ 'is-invalid': errors.includes('Birth Date is required') || errors.includes('You must be at least 6 months old') }"
                >
                <div v-if="errors.includes('Birth Date is required')" class="invalid-feedback">
                  Birth Date is required
                </div>
                <div v-if="errors.includes('You must be at least 6 months old')" class="invalid-feedback">
                  You must be at least 6 months old
                </div>
              </div>

              <div class="form-group">
                <label for="Age">Age <span class="required">*</span></label>
                <input
                  v-model="formData.Age"
                  type="text"
                  id="Age"
                  readonly
                  :class="{ 'is-invalid': errors.includes('Age is required') || errors.includes('You must be at least 6 months old') }"
                >
                <div v-if="errors.includes('Age is required')" class="invalid-feedback">
                  Age is required
                </div>
                <div v-if="errors.includes('You must be at least 6 months old')" class="invalid-feedback">
                  You must be at least 6 months old
                </div>
              </div>

              <div class="form-group">
                <label for="HomeTelephoneNumber">Home Tel. No. <span class="example-text">+63 2 XXXX XXXX</span></label>
                <input
                  v-model="formData.HomeTelephoneNumber"
                  type="tel"
                  id="HomeTelephoneNumber"
                  @input="restrictLetters($event, 'HomeTelephoneNumber'); handleHomeTelInput(); errors = []"
                  @focus="handleHomeTelInput"
                  :class="{ 'is-invalid': errors.includes('Home Telephone Number must be a valid number starting with +63 2 followed by 8 digits') }"
                >
                <div v-if="errors.includes('Home Telephone Number must be a valid number starting with +63 2 followed by 8 digits')" class="invalid-feedback">
                  Home Telephone Number must be a valid number starting with +63 2 followed by 8 digits
                </div>
              </div>

              <div class="form-group">
                <label for="OfficeNumber">Office No. <span class="example-text">+63 2 XXXX XXXX</span></label>
                <input
                  v-model="formData.OfficeNumber"
                  type="tel"
                  id="OfficeNumber"
                  @input="restrictLetters($event, 'OfficeNumber'); handleOfficeNumberInput(); errors = []"
                  @focus="handleOfficeNumberInput"
                  :class="{ 'is-invalid': errors.includes('Office Number must be a valid number starting with +63 2 followed by 8 digits') }"
                >
                <div v-if="errors.includes('Office Number must be a valid number starting with +63 2 followed by 8 digits')" class="invalid-feedback">
                  Office Number must be a valid number starting with +63 2 followed by 8 digits
                </div>
              </div>

              <div class="form-group">
                <label for="HomeAddress">Home Address <span class="required">*</span></label>
                <input
                  v-model="formData.HomeAddress"
                  type="text"
                  id="HomeAddress"
                  @input="errors = []"
                  :class="{ 'is-invalid': errors.includes('Home Address is required') }"
                >
                <div v-if="errors.includes('Home Address is required')" class="invalid-feedback">
                  Home Address is required
                </div>
              </div>

              <div class="form-group">
                <label for="Religion">Religion <span class="required">*</span></label>
                <select
                  v-model="formData.Religion"
                  id="Religion"
                  @change="errors = []"
                  :class="{ 'is-invalid': errors.includes('Religion is required') }"
                >
                  <option value="">Select</option>
                  <option value="Catholic">Catholic</option>
                  <option value="Christian">Christian</option>
                  <option value="Islam">Islam</option>
                  <option value="Buddhism">Buddhism</option>
                  <option value="Hinduism">Hinduism</option>
                  <option value="Other">Other</option>
                </select>
                <div v-if="errors.includes('Religion is required')" class="invalid-feedback">
                  Religion is required
                </div>
              </div>

              <!-- Patient-Specific Fields -->
              <template v-if="selectedUserType === 'patient'">
                <div class="form-group">
                  <label for="Nationality">Nationality <span class="required">*</span></label>
                  <input
                    v-model="formData.Nationality"
                    type="text"
                    id="Nationality"
                    @input="restrictNumbers($event, 'Nationality'); errors = []"
                    :class="{ 'is-invalid': errors.includes('Nationality is required') || errors.includes('Nationality must not contain numbers') }"
                  >
                  <div v-if="errors.includes('Nationality is required')" class="invalid-feedback">
                    Nationality is required
                  </div>
                  <div v-if="errors.includes('Nationality must not contain numbers')" class="invalid-feedback">
                    Nationality must not contain numbers
                  </div>
                </div>

                <div class="form-group">
                  <label for="MaritalStatus">Marital Status <span class="required">*</span></label>
                  <select
                    v-model="formData.MaritalStatus"
                    id="MaritalStatus"
                    @change="errors = []"
                    :class="{ 'is-invalid': errors.includes('Marital Status is required') }"
                  >
                    <option value="">Select</option>
                    <option value="Single">Single</option>
                    <option value="Married">Married</option>
                    <option value="Divorced">Divorced</option>
                    <option value="Widowed">Widowed</option>
                  </select>
                  <div v-if="errors.includes('Marital Status is required')" class="invalid-feedback">
                    Marital Status is required
                  </div>
                </div>

                <div class="form-group">
                  <label for="Occupation">Occupation <span class="required">*</span></label>
                  <input
                    v-model="formData.Occupation"
                    type="text"
                    id="Occupation"
                    @input="errors = []"
                    :class="{ 'is-invalid': errors.includes('Occupation is required') }"
                  >
                  <div v-if="errors.includes('Occupation is required')" class="invalid-feedback">
                    Occupation is required
                  </div>
                </div>

                <div class="form-group">
                  <label for="ReferredBy">Referred By</label>
                  <input
                    v-model="formData.ReferredBy"
                    type="text"
                    id="ReferredBy"
                    @input="restrictNumbers($event, 'ReferredBy'); errors = []"
                    :class="{ 'is-invalid': errors.includes('Referred By must not contain numbers') }"
                  >
                  <div v-if="errors.includes('Referred By must not contain numbers')" class="invalid-feedback">
                    Referred By must not contain numbers
                  </div>
                </div>

                <div class="form-group">
                  <label for="GovernmentID">Upload Government ID <span class="required">*</span></label>
                  <div class="file-upload-wrapper">
                    <input
                      type="file"
                      id="GovernmentID"
                      @change="handleFileUpload"
                      accept="image/*"
                      :class="{ 'is-invalid': errors.includes('Please upload a valid government ID') }"
                    >
                    <div class="file-upload-label">
                      <i class='bx bx-upload'></i>
                      <span>Choose a file</span>
                    </div>
                  </div>
                  <div v-if="errors.includes('Please upload a valid government ID')" class="invalid-feedback">
                    Please upload a valid government ID
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
                <label>Day Off: <span class="required">*</span></label>
                <div class="days-row">
                  <div class="day-checkbox-wrapper" v-for="day in weekDays" :key="day">
                    <input 
                      type="checkbox" 
                      :id="day.toLowerCase()" 
                      class="day-checkbox" 
                      v-model="formData.DayOff" 
                      :value="day"
                      :disabled="formData.DayOff.length >= 2 && !formData.DayOff.includes(day)"
                    >
                    <label :for="day.toLowerCase()" class="custom-checkbox"></label>
                    <label :for="day.toLowerCase()" class="day-label">{{ day }}</label>
                  </div>
                </div>
                <div v-if="errors.includes('You can select a maximum of 2 days off')" class="invalid-feedback">
                  You can select a maximum of 2 days off
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

      <!-- Days Off Modal -->
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
                  @click="toggleDay(day)"
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
  name: "OwnerManageUsers",
  props: {
    firstName: { type: String, required: true },
    lastName: { type: String, required: true },
  },
  computed: {
    fullName() {
      return `${this.firstName} ${this.lastName}`;
    },
    filteredUsers() {
      if (!this.searchQuery) {
        return [...this.users].sort((a, b) => a.LastName.localeCompare(b.LastName));
      }
      
      const query = this.searchQuery.toLowerCase();
      const filtered = this.users.filter(user => 
        `${user.LastName} ${user.FirstName}`.toLowerCase().includes(query) ||
        user.UserID.toString().includes(query) ||
        user.AccountStatus.toLowerCase().includes(query)
      );
      
      return filtered.sort((a, b) => a.LastName.localeCompare(b.LastName));
    },
  },
  data() {
    return {
      isSidebarClosed: true,
      isModalVisible: false,
      selectedUserType: 'patient',
      users: [],
      searchQuery: '',
      formSubmitted: false,
      isSubmitting: false,
      usernameInvalid: false,
      emailInvalid: false,
      maxDate: '',
      showFilterDropdown: false,
      weekDays: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
      formData: {
        LastName: "",
        FirstName: "",
        MiddleName: "",
        ContactNumber: "+63",
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
        HomeTelephoneNumber: "+63 2 ",
        Occupation: "",
        OfficeNumber: "+63 2 ",
        ReferredBy: "",
        GovernmentID: null,
        DayOff: [],
      },
      imagePreview: null,
      errors: [],
      isDaysOffModalVisible: false,
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
    toggleDay(day) {
      if (this.selectedDaysOff.includes(day)) {
        this.selectedDaysOff = this.selectedDaysOff.filter(d => d !== day);
      } else if (this.selectedDaysOff.length < 2) {
        this.selectedDaysOff.push(day);
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
    filterUsers(status) {
      this.searchQuery = status;
      this.showFilterDropdown = false;
    },
    toggleFilterMenu() {
      this.showFilterDropdown = !this.showFilterDropdown;
    },
    capitalizeStatus(status) {
      if (!status) return '';
      return status.charAt(0).toUpperCase() + status.slice(1).toLowerCase();
    },
    async toggleStatus(userId, currentStatus) {
      const user = this.users.find(u => u.UserID === userId);
      if (user.IsSuperOwner && this.selectedUserType === 'owner') {
        await Swal.fire({
          title: 'Error',
          text: 'Superowner cannot be deactivated.',
          icon: 'error',
          confirmButtonColor: '#06693A',
        });
        return;
      }

      const newStatus = currentStatus === 'active' ? 'deactivated' : 'active';
      const action = newStatus === 'deactivated' ? 'deactivate' : 'activate';
      const result = await Swal.fire({
        title: `Confirm ${action}`,
        text: `Are you sure you want to ${action} this user?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#06693A',
        cancelButtonColor: '#d33',
        confirmButtonText: `Yes, ${action}`,
        cancelButtonText: 'No, cancel'
      });

      if (!result.isConfirmed) return;

      try {
        const response = await axios.post('/hr/update-status', {
          AccountID: userId,
          AccountStatus: newStatus
        });

        if (response.data.message) {
          await Swal.fire({
            title: 'Success',
            text: `User ${action}d successfully!`,
            icon: 'success',
            timer: 2000,
            showConfirmButton: false
          });
          const userIndex = this.users.findIndex(user => user.UserID === userId);
          if (userIndex !== -1) {
            this.users[userIndex].AccountStatus = newStatus;
            this.users = [...this.users];
          }
        }
      } catch (error) {
        console.error(`Error ${action}ing user:`, error);
        await Swal.fire({
          title: 'Error',
          text: error.response && error.response.status === 403
            ? error.response.data.message
            : `Failed to ${action} user. Please try again.`,
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
      this.isSubmitting = false;
      this.usernameInvalid = false;
      this.emailInvalid = false;
      this.errors = [];
      this.$nextTick(() => {
        this.initializePhoneNumbers();
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
        ContactNumber: "+63",
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
        HomeTelephoneNumber: "+63 2 ",
        Occupation: "",
        OfficeNumber: "+63 2 ",
        ReferredBy: "",
        GovernmentID: null,
        DayOff: [],
      };
      this.imagePreview = null;
      this.errors = [];
      this.formSubmitted = false;
      this.isSubmitting = false;
      this.usernameInvalid = false;
      this.emailInvalid = false;
      this.showPassword = false;
      this.showConfirmPassword = false;
    },
    initializePhoneNumbers() {
      if (!this.formData.ContactNumber) {
        this.formData.ContactNumber = '+63';
      } else if (!this.formData.ContactNumber.startsWith('+63')) {
        this.formData.ContactNumber = '+63' + this.formData.ContactNumber.replace('+63', '');
      }
      if (!this.formData.HomeTelephoneNumber) {
        this.formData.HomeTelephoneNumber = '+63 2 ';
      } else if (!this.formData.HomeTelephoneNumber.startsWith('+63 2')) {
        this.formData.HomeTelephoneNumber = '+63 2 ' + this.formData.HomeTelephoneNumber.replace('+63 2', '');
      }
      if (!this.formData.OfficeNumber) {
        this.formData.OfficeNumber = '+63 2 ';
      } else if (!this.formData.OfficeNumber.startsWith('+63 2')) {
        this.formData.OfficeNumber = '+63 2 ' + this.formData.OfficeNumber.replace('+63 2', '');
      }
    },
    handleContactNumberInput() {
      if (!this.formData.ContactNumber.startsWith('+63')) {
        this.formData.ContactNumber = '+63' + this.formData.ContactNumber.replace('+63', '');
      }
    },
    handleHomeTelInput() {
      if (!this.formData.HomeTelephoneNumber.startsWith('+63 2')) {
        this.formData.HomeTelephoneNumber = '+63 2 ' + this.formData.HomeTelephoneNumber.replace('+63 2', '');
      }
    },
    handleOfficeNumberInput() {
      if (!this.formData.OfficeNumber && this.formData.OfficeNumber !== '') {
        this.formData.OfficeNumber = '+63 2 ';
      } else if (!this.formData.OfficeNumber.startsWith('+63 2')) {
        this.formData.OfficeNumber = '+63 2 ' + this.formData.OfficeNumber.replace('+63 2', '');
      }
    },
    restrictLetters(event, field) {
      let value = event.target.value;
      value = value.replace(/[^0-9+\s]/g, '');
      this.formData[field] = value;
    },
    restrictNumbers(event, field) {
      let value = event.target.value;
      value = value.replace(/[0-9]/g, '');
      this.formData[field] = value;
    },
    validateBirthDate() {
      if (this.formData.BirthDate) {
        const birthDate = new Date(this.formData.BirthDate);
        const today = new Date();
        if (birthDate > today) {
          this.errors = ["Birth date cannot be in the future"];
          this.formData.Age = "";
          return;
        }
        const diffMs = today - birthDate;
        const diffYears = Math.floor(diffMs / (1000 * 60 * 60 * 24 * 365.25));
        const remainingMs = diffMs % (1000 * 60 * 60 * 24 * 365.25);
        const diffMonths = Math.floor(remainingMs / (1000 * 60 * 60 * 24 * 30.44));
        const totalMonths = diffYears * 12 + diffMonths;
        if (totalMonths < 6) {
          this.errors = ["You must be at least 6 months old"];
          this.formData.Age = "";
          return;
        }
        this.formData.Age = diffYears > 0 ? diffYears.toString() : "0";
        this.errors = [];
      } else {
        this.formData.Age = "";
        this.errors = [];
      }
    },
    handleFileUpload(event) {
      const file = event.target.files[0];
      if (file) {
        if (!file.type.startsWith('image/')) {
          this.errors = ["Please upload a valid image file"];
          this.formData.GovernmentID = null;
          this.imagePreview = null;
          return;
        }
        this.imagePreview = URL.createObjectURL(file);
        this.formData.GovernmentID = file;
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
        this.emailInvalid = false;
        return false;
      }
      try {
        const response = await axios.post('/users/check-email', {
          email: this.formData.Email,
        });
        this.emailInvalid = response.data.exists;
        if (this.emailInvalid) {
          this.errors.push('This email is already in use');
        }
        return this.emailInvalid;
      } catch (error) {
        console.error('Email check error:', error);
        this.emailInvalid = false;
        this.errors.push('Error checking email availability');
        return false;
      }
    },
    async checkUsernameAvailability() {
      if (!this.formData.Username) {
        this.usernameInvalid = false;
        return false;
      }
      try {
        const response = await axios.post('/users/check-username', {
          username: this.formData.Username,
        });
        this.usernameInvalid = response.data.exists;
        if (this.usernameInvalid) {
          this.errors.push('This username is already taken');
        }
        return this.usernameInvalid;
      } catch (error) {
        console.error('Username check error:', error);
        this.usernameInvalid = false;
        this.errors.push('Error checking username availability');
        return false;
      }
    },
    togglePasswordVisibility() {
      this.showPassword = !this.showPassword;
    },
    toggleConfirmPasswordVisibility() {
      this.showConfirmPassword = !this.showConfirmPassword;
    },
    validateForm() {
      this.errors = [];
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      const passwordRegex = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/;
      const contactNumberRegex = /^\+63\d{10}$/;
      const phoneNumberRegex = /^\+63 2 \d{8}$/;

      if (!this.formData.LastName) this.errors.push('Last Name is required');
      if (this.formData.LastName && /\d/.test(this.formData.LastName)) this.errors.push('Last Name must not contain numbers');
      if (!this.formData.FirstName) this.errors.push('First Name is required');
      if (this.formData.FirstName && /\d/.test(this.formData.FirstName)) this.errors.push('First Name must not contain numbers');
      if (this.formData.MiddleName && /\d/.test(this.formData.MiddleName)) this.errors.push('Middle Name must not contain numbers');
      if (!this.formData.ContactNumber) this.errors.push('Contact Number is required');
      if (this.formData.ContactNumber && !contactNumberRegex.test(this.formData.ContactNumber)) this.errors.push('Contact Number must be a valid number starting with +63 followed by 10 digits');
      if (!this.formData.Email) this.errors.push('Email is required');
      if (this.formData.Email && !emailRegex.test(this.formData.Email)) this.errors.push('Email must be a valid email address');
      if (!this.formData.Username) this.errors.push('Username is required');
      if (!this.formData.Password) this.errors.push('Password is required');
      if (this.formData.Password && !passwordRegex.test(this.formData.Password)) this.errors.push('Password must be at least 8 characters and include uppercase, lowercase, number, and symbol');
      if (!this.formData.Password_confirmation) this.errors.push('Please confirm your password');
      if (this.formData.Password !== this.formData.Password_confirmation) this.errors.push('Passwords do not match');
      if (!this.formData.Gender) this.errors.push('Gender is required');
      if (!this.formData.BirthDate) this.errors.push('Birth Date is required');
      if (!this.formData.Age) this.errors.push('Age is required');
      if (this.formData.HomeTelephoneNumber && this.formData.HomeTelephoneNumber !== '+63 2 ' && !phoneNumberRegex.test(this.formData.HomeTelephoneNumber)) this.errors.push('Home Telephone Number must be a valid number starting with +63 2 followed by 8 digits');
      if (this.formData.OfficeNumber && this.formData.OfficeNumber !== '+63 2 ' && !phoneNumberRegex.test(this.formData.OfficeNumber)) this.errors.push('Office Number must be a valid number starting with +63 2 followed by 8 digits');
      if (!this.formData.HomeAddress) this.errors.push('Home Address is required');
      if (!this.formData.Religion) this.errors.push('Religion is required');

      if (this.selectedUserType === 'patient') {
        if (!this.formData.Nationality) this.errors.push('Nationality is required');
        if (this.formData.Nationality && /\d/.test(this.formData.Nationality)) this.errors.push('Nationality must not contain numbers');
        if (!this.formData.MaritalStatus) this.errors.push('Marital Status is required');
        if (!this.formData.Occupation) this.errors.push('Occupation is required');
        if (this.formData.ReferredBy && /\d/.test(this.formData.ReferredBy)) this.errors.push('Referred By must not contain numbers');
        if (!this.formData.GovernmentID) this.errors.push('Please upload a valid government ID');
      }

      if (this.selectedUserType === 'dentist' && this.formData.DayOff.length > 2) {
        this.errors.push('You can select a maximum of 2 days off');
      }

      if (this.errors.length > 0) {
        this.$nextTick(() => {
          const firstInvalidField = document.querySelector('.is-invalid');
          if (firstInvalidField) {
            firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
          }
        });
      }

      return this.errors.length === 0;
    },
    async submitForm() {
      if (this.isSubmitting) return;
      this.isSubmitting = true;
      this.formSubmitted = true;
      this.errors = [];
      this.usernameInvalid = false;
      this.emailInvalid = false;

      const [usernameInvalid, emailInvalid] = await Promise.all([
        this.checkUsernameAvailability(),
        this.checkEmailAvailability()
      ]);

      if (usernameInvalid || emailInvalid) {
        this.isSubmitting = false;
        return;
      }

      if (!this.validateForm()) {
        this.isSubmitting = false;
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
        'Religion',
        'HomeAddress',
        'HomeTelephoneNumber',
        'OfficeNumber',
      ];

      const fieldsToInclude = [...commonFields];
      if (this.selectedUserType === 'patient') {
        fieldsToInclude.push('Nationality', 'MaritalStatus', 'Occupation', 'ReferredBy', 'GovernmentID');
      } else if (this.selectedUserType === 'dentist') {
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
        let endpoint = '';
        switch(this.selectedUserType) {
          case 'patient': endpoint = '/patients'; break;
          case 'dentist': endpoint = '/dentists'; break;
          case 'hradmin': endpoint = '/hradmins'; break;
          case 'owner': endpoint = '/owners'; break;
        }
        
        const response = await axios.post(endpoint, formData, {
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        });

        const userTypeDisplay = 
          this.selectedUserType === 'patient' ? 'Patient' :
          this.selectedUserType === 'dentist' ? 'Dentist' :
          this.selectedUserType === 'hradmin' ? 'HR Admin' : 'Owner';
          
        await Swal.fire({
          title: 'Success!',
          text: `${userTypeDisplay} added successfully!`,
          icon: 'success',
          timer: 2000,
          showConfirmButton: false
        });
        
        this.resetForm(); // Reset form before closing modal
        this.isModalVisible = false; // Close modal directly
        this.fetchUsers();
      } catch (error) {
        if (error.response && error.response.status === 422) {
          this.errors = Object.values(error.response.data.errors).flat();
        } else {
          this.errors = ["An unexpected error occurred. Please try again later."];
          console.error('Unexpected error:', error);
        }
      } finally {
        this.isSubmitting = false;
      }
    },
    async fetchUsers() {
      try {
        let endpoint = '';
        switch(this.selectedUserType) {
          case 'patient': endpoint = '/patients'; break;
          case 'dentist': endpoint = '/dentists'; break;
          case 'hradmin': endpoint = '/hradmins'; break;
          case 'owner': endpoint = '/owners'; break;
        }
        
        const response = await axios.get(endpoint);
        console.log(`Fetched ${this.selectedUserType} data:`, response.data);
        this.users = response.data;
      } catch (error) {
        console.error(`Error fetching ${this.selectedUserType}:`, error);
        this.users = [];
      }
    },
    setMaxDate() {
      const today = new Date();
      this.maxDate = today.toISOString().split('T')[0];
    },
    removeImage() {
      this.imagePreview = null;
      this.formData.GovernmentID = null;
      const fileInput = document.getElementById('GovernmentID');
      if (fileInput) fileInput.value = '';
    },
  },
  created() {
    this.setMaxDate();
  },
  mounted() {
    this.fetchUsers();
    this.initializePhoneNumbers();
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

.nav-link {
    margin-top: -30px
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
  overflow: hidden;
}

.filter-menu button {
  display: block;
  width: 100%;
  text-align: left;
  border-radius: 0;
  background-color: white;
  color: #333;
  padding: 12px 16px;
  margin: 0;
  border: none;
  border-bottom: 1px solid #f0f0f0;
  transition: background-color 0.2s;
}

.filter-menu button:last-child {
  border-bottom: none;
}

.filter-menu button:hover {
  background-color: #f5f5f5;
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
  width: 35%;
}

.users-table th:nth-child(3),
.users-table td:nth-child(3) {
  width: 25%;
}

.users-table th:nth-child(4),
.users-table td:nth-child(4) {
  width: 15%;
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

.edit-btn {
  background-color: #e3f2fd;
  color: #1565c0;
}

.edit-btn:hover {
  background-color: #bbdefb;
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

.mobile-actions {
  display: flex;
  flex-direction: column;
  gap: 8px;
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
  display: flex;
  align-items: center;
  gap: 6px;
  justify-content: center;
}

.action-button-mobile.edit-btn {
  background-color: #e3f2fd;
  color: #1565c0;
}

.action-button-mobile.edit-btn:hover {
  background-color: #bbdefb;
}

.action-button-mobile.activate-btn {
  background-color: #e6f7ee;
  color: #0d904b;
}

.action-button-mobile.activate-btn:hover {
  background-color: #d1f0e0;
}

.action-button-mobile.deactivate-btn {
  background-color: #ffebee;
  color: #d32f2f;
}

.action-button-mobile.deactivate-btn:hover {
  background-color: #ffd8db;
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

.days-off-modal {
  max-width: 600px;
  border-radius: 16px;
  overflow: hidden;
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

.example-text {
  color: #888;
  font-size: 12px;
  font-style: italic;
  white-space: nowrap;
  margin-left: 5px;
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

/* Days Off Modal Styles */
.days-off-content {
  padding: 20px 25px;
}

.days-off-info {
  display: flex;
  flex-direction: column;
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
</style>