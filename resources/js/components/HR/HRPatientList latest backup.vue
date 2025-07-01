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

  <!-- Mobile Overlay -->
  <div class="mobile-overlay" @click="closeMobileSidebar"></div>

  <section class="home-section">
    <div class="home-content">
      <div class="header">
        <i class="bx bx-menu"></i>
        <div class="text">
          <h3>Patient List</h3>
          <div class="breadcrumbs">
            <a class="none" href=""><p>Home / </p></a>
            <a class="current" href="/hrpatientlist"><p>  Patient List</p></a>
          </div>
        </div>
      </div>
      <hr color="#06693a">

      <!-- List View -->
      <div v-if="!selectedPatient">
        <!-- Search and Filter Section (Copied from dentistpatientlist) -->
        <div class="search-wrapper">
          <div class="search-container">
            <input 
              v-model="searchQuery" 
              placeholder="Search by name, phone, or appointment" 
              @keyup.enter="filterPatients" 
              class="search-input"
              :class="{ 'has-reset': searchQuery && isSearchActive }"
            />
            <i class="bx bx-search search-icon" @click="filterPatients"></i>
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
                <label>Appointment Status:</label>
                <select v-model="filter.appointmentStatus">
                  <option value="">All Statuses</option>
                  <option value="upcoming">Has Upcoming Appointment</option>
                  <option value="none">No Upcoming Appointment</option>
                </select>
              </div>
              <div class="filter-group">
                <label>Sort By:</label>
                <select v-model="filter.sortBy">
                  <option value="">Default</option>
                  <option value="name-asc">Name (A-Z)</option>
                  <option value="name-desc">Name (Z-A)</option>
                  <option value="next-asc">Next Appointment (Earliest First)</option>
                  <option value="next-desc">Next Appointment (Latest First)</option>
                  <option value="last-asc">Last Appointment (Earliest First)</option>
                  <option value="last-desc">Last Appointment (Latest First)</option>
                </select>
              </div>
              <button class="reset-btn" @click="resetFilters">Reset Filters</button>
            </div>
          </div>
        </div>

        <div class="patient-container">
          <div class="patient-header">
            <h3>{{ totalPatients }} Patients</h3>
          </div>
          <div class="table-wrapper">
            <!-- Desktop Table -->
            <table class="patient-table desktop-table">
              <thead>
                <tr>
                  <th @click="sortTable('PatientID')" class="sortable-header">
                    No.
                    <i v-if="sortConfig.key === 'PatientID'" class="bx" :class="getSortIconClass('PatientID')"></i>
                  </th>
                  <th @click="sortTable('FullName')" class="sortable-header">
                    Patients Name
                    <i v-if="sortConfig.key === 'FullName'" class="bx" :class="getSortIconClass('FullName')"></i>
                  </th>
                  <th @click="sortTable('ContactNumber')" class="sortable-header">
                    Phone Number
                    <i v-if="sortConfig.key === 'ContactNumber'" class="bx" :class="getSortIconClass('ContactNumber')"></i>
                  </th>
                  <th @click="sortTable('nextAppointment')" class="sortable-header">
                    Next Appointment
                    <i v-if="sortConfig.key === 'nextAppointment'" class="bx" :class="getSortIconClass('nextAppointment')"></i>
                  </th>
                  <th @click="sortTable('lastAppointment')" class="sortable-header">
                    Last Appointment
                    <i v-if="sortConfig.key === 'lastAppointment'" class="bx" :class="getSortIconClass('lastAppointment')"></i>
                  </th>
                </tr>
              </thead>
              <tbody class="container-patient">
                <tr v-for="(patient, index) in filteredPatients" :key="patient.PatientID" @click="selectPatient(patient)" class="patient-row">
                  <td>{{ (currentPage - 1) * 15 + index + 1 }}</td>
                  <td class="truncate-cell">{{ patient.user.FirstName }} {{ patient.user.LastName }}</td>
                  <td class="truncate-cell">{{ patient.user.ContactNumber || 'N/A' }}</td>
                  <td class="truncate-cell">{{ formatAppointmentDate(patient.nextAppointment) || 'N/A' }}</td>
                  <td class="truncate-cell">{{ formatAppointmentDate(patient.lastAppointment) || 'N/A' }}</td>
                </tr>
                <tr v-if="filteredPatients.length === 0">
                  <td colspan="5" class="no-data">No patients found...</td>
                </tr>
              </tbody>
            </table>
            
            <!-- Mobile Cards -->
            <div class="mobile-cards">
              <div 
                v-for="(patient, index) in filteredPatients" 
                :key="patient.PatientID"
                class="patient-card"
                @click="selectPatient(patient)"
              >
                <div class="card-header">
                  <h4>{{ patient.user.FirstName }} {{ patient.user.LastName }}</h4>
                  <span class="patient-number">{{ (currentPage - 1) * 15 + index + 1 }}</span>
                </div>
                <div class="card-content">
                  <div class="card-row">
                    <span class="card-label">Phone:</span>
                    <span>{{ patient.user.ContactNumber || 'N/A' }}</span>
                  </div>
                  <div class="card-row">
                    <span class="card-label">Next Appointment:</span>
                    <span>{{ formatAppointmentDate(patient.nextAppointment) || 'N/A' }}</span>
                  </div>
                  <div class="card-row">
                    <span class="card-label">Last Appointment:</span>
                    <span>{{ formatAppointmentDate(patient.lastAppointment) || 'N/A' }}</span>
                  </div>
                </div>
              </div>
              <div v-if="filteredPatients.length === 0" class="no-data-mobile">
                No patients found
              </div>
            </div>
          </div>
          
          <!-- See More Button (Pagination) -->
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
      </div>

      <!-- Patient Details View -->
      <div v-if="selectedPatient" class="details-container">
        <button @click="goBack" class="back-btn">
          <i class='bx bx-arrow-back'></i> Back to List
        </button>

        <!-- Redesigned Patient Details Section -->
        <div class="patient-profile-section">
          <div class="patient-details-notes-container">
            <!-- Patient Profile Card -->
            <div class="patient-profile-card">
              <div class="patient-profile-header">
                <div class="patient-avatar">
                  <i class='bx bx-user-circle'></i>
                </div>
                <div class="patient-basic-info">
                  <h2>{{ selectedPatient.user.FirstName }} {{ selectedPatient.user.LastName }}</h2>
                  <p class="patient-id">Patient ID: {{ selectedPatient.PatientID || '0000' }}</p>
                  <p class="patient-email">{{ selectedPatient.user.Email || 'No email provided' }}</p>
                </div>
                <div class="patient-stats">
                  <div class="stat-item">
                    <div class="stat-value">{{ selectedPatient.totalVisits || '0' }}</div>
                    <div class="stat-label">Past Visits</div>
                  </div>
                  <div class="stat-divider"></div>
                  <div class="stat-item">
                    <div class="stat-value">{{ selectedPatient.upcomingAppointments || '0' }}</div>
                    <div class="stat-label">Upcoming</div>
                  </div>
                </div>
              </div>
              
              <div class="patient-details-grid">
                <div class="details-column">
                  <div class="detail-item">
                    <div class="detail-label">Gender</div>
                    <div class="detail-value">{{ selectedPatient.user.Gender || 'N/A' }}</div>
                  </div>
                  <div class="detail-item">
                    <div class="detail-label">Birthday</div>
                    <div class="detail-value">{{ selectedPatient.user.BirthDate || 'N/A' }}</div>
                  </div>
                  <div class="detail-item">
                    <div class="detail-label">Age</div>
                    <div class="detail-value">{{ selectedPatient.user.Age || 'N/A' }} years old</div>
                  </div>
                </div>
                
                <div class="details-column">
                  <div class="detail-item">
                    <div class="detail-label">Home Address</div>
                    <div class="detail-value">{{ selectedPatient.user.Address || 'N/A' }}</div>
                  </div>
                  <div class="detail-item">
                    <div class="detail-label">Phone Number</div>
                    <div class="detail-value">{{ selectedPatient.user.HomeTelephoneNumber || selectedPatient.user.ContactNumber || 'N/A' }}</div>
                  </div>
                </div>
                
                <div class="details-column">
                  <div class="detail-item">
                    <div class="detail-label">Guardian's Name</div>
                    <div class="detail-value">{{ selectedPatient.GuardianName || 'N/A' }}</div>
                  </div>
                  <div class="detail-item">
                    <div class="detail-label">Guardian's Phone</div>
                    <div class="detail-value">{{ selectedPatient.GuardianTelNumber || 'N/A' }}</div>
                  </div>
                  <div class="detail-item">
                    <div class="detail-label">Government ID</div>
                    <div class="detail-value">
                      <button 
                        class="view-id-btn" 
                        @click="openGovernmentIdModal" 
                        :disabled="!selectedPatient.GovernmentID"
                      >
                        View Government ID
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="record-creation">
                <i class='bx bx-calendar-check'></i>
                <span>Record Created On: {{ formatAppointmentDate(selectedPatient.created_at) || 'N/A' }}</span>
              </div>
            </div>
            
            <!-- Notes Section -->
            <div class="notes-container">
              <h3><i class='bx bx-note'></i> Patient Notes</h3>
              <textarea 
                v-model="patientNote" 
                placeholder="Write notes about this patient here..." 
                class="notes-textarea"
              ></textarea>
              <button class="save-btn" @click="saveNote">
                <i class='bx bx-save'></i> Save Note
              </button>
            </div>
          </div>
        </div>

        <!-- Patient View Tabs Section -->
        <div class="patient-view-layout">
          <div class="slider-container">
            <div class="slider-tabs-wrapper">
              <button class="tab-nav-arrow prev" @click="navigateTabs('prev')" :disabled="isFirstTab">
                <i class='bx bx-chevron-left'></i>
              </button>
              
              <div class="slider-tabs">
                <button 
                  class="tab-btn" 
                  :class="{ active: activeTab === 'upcoming' }" 
                  @click="activeTab = 'upcoming'"
                >
                  <i class='bx bx-calendar-check'></i> <span class="tab-text">Upcoming Appointment</span>
                </button>
                <button 
                  class="tab-btn" 
                  :class="{ active: activeTab === 'past' }" 
                  @click="activeTab = 'past'"
                >
                  <i class='bx bx-history'></i> <span class="tab-text">Past Appointments</span>
                </button>
                <button 
                  class="tab-btn" 
                  :class="{ active: activeTab === 'medical' }" 
                  @click="activeTab = 'medical'"
                >
                  <i class='bx bx-file-find'></i> <span class="tab-text">Medical Records</span>
                </button>
                <button 
                  class="tab-btn" 
                  :class="{ active: activeTab === 'treatment' }" 
                  @click="activeTab = 'treatment'"
                >
                  <i class='bx bx-list-check'></i> <span class="tab-text">Treatment Plan</span>
                </button>
                <button 
                  class="tab-btn" 
                  :class="{ active: activeTab === 'dental' }" 
                  @click="activeTab = 'dental'"
                >
                  <i class='bx bx-images'></i> <span class="tab-text">Dental Photos</span>
                </button>
                <button 
                  class="tab-btn" 
                  :class="{ active: activeTab === 'ledger' }" 
                  @click="activeTab = 'ledger'"
                >
                  <i class='bx bx-wallet'></i> <span class="tab-text">Ledger</span>
                </button>
              </div>
              
              <button class="tab-nav-arrow next" @click="navigateTabs('next')" :disabled="isLastTab">
                <i class='bx bx-chevron-right'></i>
              </button>
            </div>
            
            <div class="slider-content">
              <div class="view-more">
                <a href="#">View more <i class='bx bx-link-external'></i></a>
                <button v-if="activeTab === 'medical'" class="add-files-btn" @click="openMedicalFileUpload">
                  <i class='bx bx-plus'></i> Add files
                </button>
                <!-- Add files button for dental tab -->
                <button v-if="activeTab === 'dental'" class="add-files-btn" @click="openFileUpload">
                  <i class='bx bx-plus'></i> Add files
                </button>
                <!-- Add files button for treatment plan tab -->
                <button v-if="activeTab === 'treatment'" class="add-files-btn" @click="openTreatmentFileUpload">
                  <i class='bx bx-plus'></i> Add files
                </button>
              </div>
              
              <!-- Upcoming Appointments Tab -->
              <div v-if="activeTab === 'upcoming'" class="tab-content">
                <div v-if="upcomingAppointments && upcomingAppointments.length > 0">
                  <!-- Content for upcoming appointments -->
                  <div v-for="appointment in paginatedUpcomingAppointments" :key="appointment.id" class="appointment-item">
                    <!-- Appointment details -->
                    <div class="appointment-card">
                      <div class="appointment-icon">
                        <i class='bx bx-calendar-check'></i>
                      </div>
                      <div class="appointment-details">
                        <h4>{{ appointment.title || 'Appointment' }}</h4>
                        <p>{{ formatDateTime(appointment.start) }}</p>
                        <p>{{ truncateText(appointment.extendedProps?.PatientNote || 'No notes', 100) }}</p>
                      </div>
                    </div>
                  </div>
                  
                  <!-- Pagination for upcoming appointments -->
                  <div class="appointments-pagination">
                    <div class="pagination-info">
                      Page {{ upcomingAppointmentsPage }} of {{ upcomingAppointmentsLastPage }}
                    </div>
                    <div class="pagination-actions">
                      <button 
                        class="pagination-btn prev" 
                        @click="changeUpcomingAppointmentsPage(upcomingAppointmentsPage - 1)" 
                        :disabled="upcomingAppointmentsPage === 1"
                      >
                        <i class='bx bx-chevron-left'></i> Previous
                      </button>
                      <button 
                        class="pagination-btn next" 
                        @click="changeUpcomingAppointmentsPage(upcomingAppointmentsPage + 1)" 
                        :disabled="upcomingAppointmentsPage === upcomingAppointmentsLastPage"
                      >
                        Next <i class='bx bx-chevron-right'></i>
                      </button>
                    </div>
                  </div>
                </div>
                <div v-else class="no-content">
                  <i class='bx bx-calendar-x empty-icon'></i>
                  <p>No upcoming appointments</p>
                </div>
              </div>
              
              <!-- Past Appointments Tab -->
              <div v-if="activeTab === 'past'" class="tab-content">
                <div v-if="pastAppointments && pastAppointments.length > 0">
                  <!-- Content for past appointments -->
                  <div v-for="appointment in paginatedPastAppointments" :key="appointment.id" class="appointment-item">
                    <!-- Appointment details -->
                    <div class="appointment-card">
                      <div class="appointment-icon">
                        <i class='bx bx-calendar-check'></i>
                      </div>
                      <div class="appointment-details">
                        <h4>{{ appointment.title || 'Past Appointment' }}</h4>
                        <p>{{ formatDateTime(appointment.start) }}</p>
                        <p>{{ truncateText(appointment.extendedProps?.Services?.join(', ') || 'No services specified', 100) }}</p>
                        <p>{{ truncateText(appointment.extendedProps?.PatientNote || 'No notes', 100) }}</p>
                      </div>
                    </div>
                  </div>
                  
                  <!-- Pagination for past appointments -->
                  <div class="appointments-pagination">
                    <div class="pagination-info">
                      Page {{ pastAppointmentsPage }} of {{ pastAppointmentsLastPage }}
                    </div>
                    <div class="pagination-actions">
                      <button 
                        class="pagination-btn prev" 
                        @click="changePastAppointmentsPage(pastAppointmentsPage - 1)" 
                        :disabled="pastAppointmentsPage === 1"
                      >
                        <i class='bx bx-chevron-left'></i> Previous
                      </button>
                      <button 
                        class="pagination-btn next" 
                        @click="changePastAppointmentsPage(pastAppointmentsPage + 1)" 
                        :disabled="pastAppointmentsPage === pastAppointmentsLastPage"
                      >
                        Next <i class='bx bx-chevron-right'></i>
                      </button>
                    </div>
                  </div>
                </div>
                <div v-else class="no-content">
                  <i class='bx bx-calendar-x empty-icon'></i>
                  <p>No past appointments</p>
                </div>
              </div>
              
              <!-- Medical Records Tab -->
              <div v-if="activeTab === 'medical'" class="tab-content">
                <div v-if="medicalRecords && medicalRecords.length > 0">
                  <!-- Content for medical records -->
                  <div v-for="record in medicalRecords" :key="record.id" class="document-item">
                    <i class='bx bxs-file-doc'></i>
                    <div class="document-info">
                      <span class="file-name">{{ record.name || 'Medical Record' }}</span>
                    </div>
                    <div class="document-actions">
                      <button class="doc-action-btn" title="Preview" @click.stop="handleFilePreview(record)">
                        <i class='bx bx-show'></i>
                      </button>
                      <button class="doc-action-btn" title="Remove" @click.stop="deleteFile(record.id, 'medical')">
                        <i class='bx bx-trash' style="color: red;"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <div v-else class="no-content">
                  <i class='bx bx-file empty-icon'></i>
                  <p>No medical records</p>
                </div>
              </div>
              
              <!-- Treatment Plan Tab -->
              <div v-if="activeTab === 'treatment'" class="tab-content">
                <div v-if="treatmentPlans && treatmentPlans.length > 0">
                  <div v-for="plan in treatmentPlans" :key="plan.id" class="document-item">
                    <i class='bx bxs-file-doc'></i>
                    <div class="document-info">
                      <span class="file-name">{{ plan.name }}</span>
                    </div>
                    <div class="document-actions">
                      <button class="doc-action-btn" title="Preview" @click.stop="handleFilePreview(plan)">
                        <i class='bx bx-show'></i>
                      </button>
                      <button class="doc-action-btn" title="Remove" @click.stop="deleteFile(plan.id, 'treatment')">
                        <i class='bx bx-trash' style="color: red;"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <div v-else class="no-content">
                  <i class='bx bx-list-ul empty-icon'></i>
                  <p>No treatment plans</p>
                </div>
              </div>
              
              <!-- Dental Photos Tab -->
              <div v-if="activeTab === 'dental'" class="tab-content">
                <div v-if="dentalPhotos && dentalPhotos.length > 0" class="documents-list">
                  <div v-for="photo in dentalPhotos" :key="photo.id" class="document-item">
                    <i class='bx bxs-file-image'></i>
                    <div class="document-info">
                      <span class="file-name">{{ photo.name }}</span>
                    </div>
                    <div class="document-actions">
                      <button class="doc-action-btn" title="Preview" @click.stop="handleFilePreview(photo)">
                        <i class='bx bx-show'></i>
                      </button>
                      <button class="doc-action-btn" title="Remove" @click.stop="deleteFile(photo.id, 'dental')">
                        <i class='bx bx-trash' style="color: red;"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <div v-else class="no-content">
                  <i class='bx bx-image empty-icon'></i>
                  <p>No dental photos</p>
                </div>
              </div>

              <!-- Ledger Tab -->
              <div v-if="activeTab === 'ledger'" class="tab-content">
                <div v-if="ledger && ledger.length > 0">
                  <table class="ledger-table">
                    <thead>
                      <tr>
                        <th>Details</th>
                        <th>Date</th>
                        <th>Reference</th>
                        <th>Debit</th>
                        <th>Credit</th>
                        <th>Balance</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="entry in sortedLedger" :key="entry.Reference">
                        <td>
                          <span 
                            :title="entry.Remarks ? truncateText(entry.Remarks, 100) : ''" 
                            class="details-cell"
                          >
                            {{ formatDetails(entry) }}
                          </span>
                        </td>
                        <td>{{ formatDateTime(entry.TransactionDate) }}</td>
                        <td>{{ entry.Reference }}</td>
                        <td>{{ formatCurrency(entry.Debit) }}</td>
                        <td>{{ formatCurrency(entry.Credit) }}</td>
                        <td :class="{ 'balance-negative': entry.Balance < 0 }">
                          {{ formatCurrency(entry.Balance) }}
                        </td>
                      </tr>
                      <!-- Total Row -->
                      <tr class="ledger-total-row">
                        <td colspan="3">TOTAL</td>
                        <td>{{ formatCurrency(totalDebit) }}</td>
                        <td>{{ formatCurrency(totalCredit) }}</td>
                        <td :class="{ 'balance-negative': finalBalance < 0 }">
                          {{ formatCurrency(finalBalance) }}
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div v-else class="no-content">
                  <i class='bx bx-wallet empty-icon'></i>
                  <p>No ledger entries available</p>
                </div>
              </div>
            </div>
          </div>
        
          <div class="document-files-container">
            <div class="document-files-header">
              <h3><i class='bx bxs-file-doc'></i> Documents</h3>
              <button class="add-files-btn" @click="openDocumentUpload">
                <i class='bx bx-plus'></i> Add Files
              </button>
            </div>
            <div class="document-files-content">
              <div v-if="documents && documents.length > 0" class="documents-list">
                <div v-for="doc in documents" :key="doc.id" class="document-item">
                  <i :class="getDocumentIcon(doc.name)"></i>
                  <div class="document-info">
                    <span class="document-name">{{ doc.name }}</span>
                    <span class="document-size">{{ formatFileSize(doc.size) }}</span>
                  </div>
                  <div class="document-actions">
                    <button class="doc-action-btn" title="Preview" @click.stop="handleFilePreview(doc)">
                      <i class='bx bx-show'></i>
                    </button>
                    <button class="doc-action-btn" title="Remove" @click.stop="deleteFile(doc.id, 'document')">
                      <i class='bx bx-trash' style="color: red;"></i>
                    </button>
                  </div>
                </div>
              </div>
              <div v-else class="no-documents">
                <i class='bx bxs-file-blank empty-icon'></i>
                <p>No added files</p>
                <p class="drag-hint">Use the Add Files button</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- File Upload Modal -->
    <div class="modal-overlay" v-if="showUploadModal" @click.self="cancelUpload">
      <div class="modal-container">
        <div class="modal-header">
          <h3>Upload Files</h3>
          <button class="close-btn" @click="cancelUpload">
            <i class='bx bx-x'></i>
          </button>
        </div>
        <div class="modal-body">
          <div class="selected-files-list">
            <div v-for="(file, index) in selectedFiles" :key="index" class="selected-file-item">
              <div class="file-icon">
                <i :class="getDocumentIcon(file.name)"></i>
              </div>
              <div class="file-details">
                <div class="file-name-input">
                  <label>File Name:</label>
                  <input 
                    type="text" 
                    v-model="file.customName" 
                    placeholder="Enter file name (e.g., myfile.jpg)"
                    class="custom-name-input"
                  />
                </div>
              </div>
              <button class="remove-file-btn" @click="removeSelectedFile(index)">
                <i class='bx bx-trash' style="color: red;"></i>
              </button>
            </div>
          </div>
          
          <div v-if="selectedFiles.length === 0" class="no-files-selected">
            <i class='bx bx-file empty-icon'></i>
            <p>No files selected</p>
          </div>
          
          <div class="upload-type" v-if="uploadType">
            <p>Uploading to: <strong>{{ getUploadTypeName() }}</strong></p>
          </div>
        </div>
        <div class="modal-footer">
          <button class="cancel-btn" @click="cancelUpload">Cancel</button>
          <button 
            class="confirm-btn" 
            @click="confirmUpload" 
            :disabled="selectedFiles.length === 0"
          >
            Upload Files
          </button>
        </div>
      </div>
    </div>

    <!-- File Preview Modal -->
    <div class="modal-overlay" v-if="showPreviewModal" @click.self="closePreview">
      <div class="preview-modal-container">
        <div class="modal-header">
          <h3>{{ previewFile ? previewFile.name : 'File Preview' }}</h3>
          <button class="close-btn" @click="closePreview">
            <i class='bx bx-x'></i>
          </button>
        </div>
        <div class="preview-modal-body">
          <img 
            v-if="isImageFile(previewFile) && previewFile?.url" 
            :src="previewFile.url" 
            alt="File preview" 
            class="preview-image"
            @error="handlePreviewError"
          />
          <iframe 
            v-else-if="isPdfFile(previewFile) && previewFile?.url" 
            :src="previewFile.url" 
            class="preview-pdf"
          ></iframe>
          <div v-else class="preview-not-available">
            <i class='bx bx-file'></i>
            <p>Preview not available for this file type</p>
            <a :href="previewFile?.url" target="_blank" class="download-link" v-if="previewFile?.url">Download file</a>
          </div>
        </div>
      </div> 
    </div>  

    <!-- Government ID Modal -->
    <div class="modal-overlay" v-if="showGovernmentIdModal" @click.self="closeGovernmentIdModal">
      <div class="id-modal-container">
        <div class="modal-header">
          <h3>Government ID</h3>
          <button class="close-btn" @click="closeGovernmentIdModal">
            <i class='bx bx-x'></i>
          </button>
        </div>
        <div class="id-modal-body">
          <img 
            v-if="governmentIdUrl" 
            :src="governmentIdUrl" 
            alt="Government ID" 
            class="id-image"
            @error="handleIdImageError"
          />
          <div v-else class="no-id">
            <i class='bx bx-id-card empty-icon'></i>
            <p>No Government ID available</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Error Modal -->
    <div class="modal-overlay" v-if="showErrorModal" @click.self="closeErrorModal">
      <div class="modal-container error-modal">
        <div class="modal-header">
          <h3><i class='bx bx-error-circle'></i> Upload Error</h3>
          <button class="close-btn" @click="closeErrorModal">
            <i class='bx bx-x'></i>
          </button>
        </div>
        <div class="modal-body">
          <p>{{ errorMessage }}</p>
          <p v-if="uploadType === 'dental'" class="error-hint">
            Only image files are allowed for Dental Photos. Supported formats: <strong>jpg, jpeg, png, gif, bmp, webp</strong>.
          </p>
          <p v-else class="error-hint">
            Supported formats: <strong>jpg, jpeg, png, gif, bmp, webp, pdf, doc, docx</strong>.
          </p>
        </div>
        <div class="modal-footer">
          <button class="confirm-btn" @click="closeErrorModal">OK</button>
        </div>
      </div>
    </div>

    <!-- Success Modal -->
    <div class="modal-overlay" v-if="showSuccessModal">
      <div class="modal-container success-modal">
        <div class="modal-header">
          <h3><i class='bx bx-check-circle'></i> Success</h3>
        </div>
        <div class="modal-body">
          <p>{{ successMessage }}</p>
        </div>
      </div>
    </div>

    <!-- Hidden file inputs -->
    <input 
      type="file" 
      ref="medicalFileInput" 
      style="display: none" 
      @change="prepareFileUpload($event, 'medical')" 
      multiple
      accept="image/*,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
    />

    <input 
      type="file" 
      ref="fileInput" 
      style="display: none" 
      @change="prepareFileUpload($event, 'dental')" 
      multiple
      accept="image/*"
    />

    <input 
      type="file" 
      ref="treatmentFileInput" 
      style="display: none" 
      @change="prepareFileUpload($event, 'treatment')" 
      multiple
    />

    <input 
      type="file" 
      ref="documentInput" 
      style="display: none" 
      @change="prepareFileUpload($event, 'document')" 
      multiple
    />

    <!-- Delete Confirmation Modal -->
    <div class="modal-overlay" v-if="showDeleteModal" @click.self="cancelDelete">
      <div class="modal-container delete-modal">
        <div class="modal-header">
          <h3><i class='bx bx-trash'></i> Confirm Deletion</h3>
          <button class="close-btn" @click="cancelDelete">
            <i class='bx bx-x'></i>
          </button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete "<strong>{{ fileToDelete?.name }}</strong>"? This action cannot be undone.</p>
        </div>
        <div class="modal-footer">
          <button class="cancel-btn" @click="cancelDelete">Cancel</button>
          <button class="delete-btn" @click="confirmDelete">Delete</button>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import axios from 'axios';

export default {
  name: "HRPatientList",
  props: {
    firstName: { type: String, required: true },
    lastName: { type: String, required: true },
  },
  data() {
    return {
      patients: [],
      filteredPatients: [], // New property to store filtered results
      currentPage: 1,
      lastPage: 1,
      searchQuery: '',
      totalPatients: 0,
      selectedPatient: null,
      patientNote: '',
      activeTab: 'upcoming',
      tabs: ['upcoming', 'past', 'medical', 'treatment', 'dental', 'ledger'],
      upcomingAppointments: [],
      pastAppointments: [],
      medicalRecords: [],
      treatmentPlans: [],
      dentalPhotos: [],
      documents: [],
      fullName: `${this.firstName} ${this.lastName}`,
      ledger: [],
      showGovernmentIdModal: false,
      governmentIdUrl: null,
      
      // Search and filter properties
      isSearchActive: false,
      showFilterMenu: false,
      filter: {
        appointmentStatus: '',
        sortBy: ''
      },
      sortConfig: {
        key: null,
        direction: 'asc'
      },
      
      // Upload modal properties
      showUploadModal: false,
      selectedFiles: [],
      uploadType: null,
      
      // Preview modal properties
      showPreviewModal: false,
      previewFile: null,
      showErrorModal: false,
      errorMessage: '',
      
      // Success modal properties
      showSuccessModal: false,
      successMessage: '',
      
      // Delete confirmation modal properties
      showDeleteModal: false,
      fileToDelete: null,
      deleteType: null,
      
      // Pagination for appointments
      upcomingAppointmentsPage: 1,
      upcomingAppointmentsPerPage: 3,
      pastAppointmentsPage: 1,
      pastAppointmentsPerPage: 3,
    };
  },
  computed: {
    isFirstTab() {
      return this.tabs.indexOf(this.activeTab) === 0;
    },
    isLastTab() {
      return this.tabs.indexOf(this.activeTab) === this.tabs.length - 1;
    },
    paginatedUpcomingAppointments() {
      const start = (this.upcomingAppointmentsPage - 1) * this.upcomingAppointmentsPerPage;
      const end = start + this.upcomingAppointmentsPerPage;
      return this.upcomingAppointments.slice(start, end);
    },
    upcomingAppointmentsLastPage() {
      return Math.ceil(this.upcomingAppointments.length / this.upcomingAppointmentsPerPage) || 1;
    },
    paginatedPastAppointments() {
      const start = (this.pastAppointmentsPage - 1) * this.pastAppointmentsPerPage;
      const end = start + this.pastAppointmentsPerPage;
      return this.pastAppointments.slice(start, end);
    },
    pastAppointmentsLastPage() {
      return Math.ceil(this.pastAppointments.length / this.pastAppointmentsPerPage) || 1;
    },
    sortedLedger() {
      return [...this.ledger].sort((a, b) => new Date(a.TransactionDate) - new Date(b.TransactionDate));
    },
    totalDebit() {
      return this.ledger.reduce((sum, entry) => sum + (entry.Debit || 0), 0);
    },
    totalCredit() {
      return this.ledger.reduce((sum, entry) => sum + (entry.Credit || 0), 0);
    },
    finalBalance() {
      return this.totalDebit - this.totalCredit;
    },
  },
  methods: {
    formatDetails(entry) {
  let baseDetail = '';
  if (entry.PaymentMethod === 'Adjustment') {
    baseDetail = 'Adjustment';
  } else if (entry.PaymentMethod === 'Discount') {
    baseDetail = 'Discount';
  } else if (entry.PaymentMethod) {
    baseDetail = `Payment - ${entry.PaymentMethod}`;
  } else {
    baseDetail = entry.Service || 'N/A';
  }

  // Append remarks only for Adjustment entries, truncated for display
  if (entry.PaymentMethod === 'Adjustment' && entry.Remarks) {
    return `${baseDetail} - ${this.truncateText(entry.Remarks, 20)}`;
  }
  return baseDetail;
},
    closeMobileSidebar() {
      const sidebar = document.querySelector(".sidebar");
      const overlay = document.querySelector(".mobile-overlay");
      if (window.innerWidth <= 768) {
        sidebar.classList.add("close");
        overlay.classList.remove("active");
      }
    },
    // Updated to match dentistpatientlist.vue behavior
    filterPatients() {
      if (!this.searchQuery.trim()) {
        this.filteredPatients = [...this.patients];
        this.isSearchActive = false;
        return;
      }

      const query = this.searchQuery.toLowerCase().trim();
      this.filteredPatients = this.patients.filter(patient =>
        `${patient.user.FirstName} ${patient.user.LastName}`.toLowerCase().includes(query) ||
        (patient.user.ContactNumber || '').toLowerCase().includes(query) ||
        (this.formatAppointmentDate(patient.nextAppointment) || '').toLowerCase().includes(query) ||
        (this.formatAppointmentDate(patient.lastAppointment) || '').toLowerCase().includes(query)
      );

      this.isSearchActive = true;
      this.totalPatients = this.filteredPatients.length;
      this.currentPage = 1; // Reset to first page
      this.lastPage = Math.ceil(this.filteredPatients.length / 15) || 1;
    },

    // Updated to match dentistpatientlist.vue behavior
    resetSearch() {
      this.searchQuery = '';
      this.filteredPatients = [...this.patients];
      this.isSearchActive = false;
      this.totalPatients = this.patients.length;
      this.currentPage = 1;
      this.lastPage = Math.ceil(this.patients.length / 15) || 1;
    },

    toggleFilterMenu() {
      this.showFilterMenu = !this.showFilterMenu;
    },

    handleClickOutside(event) {
      const filterContainer = document.querySelector('.buttons');
      if (filterContainer && !filterContainer.contains(event.target)) {
        this.showFilterMenu = false;
      }
    },

    resetFilters() {
      this.filter = {
        appointmentStatus: '',
        sortBy: ''
      };
      this.showFilterMenu = false;
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

      this.filteredPatients.sort((a, b) => {
        let valueA, valueB;

        if (key === 'PatientID') {
          valueA = a.PatientID || 0;
          valueB = b.PatientID || 0;
        } else if (key === 'FullName') {
          valueA = `${a.user.FirstName} ${a.user.LastName}`.toLowerCase();
          valueB = `${b.user.FirstName} ${b.user.LastName}`.toLowerCase();
        } else if (key === 'ContactNumber') {
          valueA = a.user.ContactNumber || '';
          valueB = b.user.ContactNumber || '';
        } else if (key === 'nextAppointment' || key === 'lastAppointment') {
          valueA = a[key] ? new Date(a[key]) : new Date(0);
          valueB = b[key] ? new Date(b[key]) : new Date(0);
        }

        if (typeof valueA === 'string') {
          return direction === 'asc' ? valueA.localeCompare(valueB) : valueB.localeCompare(valueA);
        } else {
          return direction === 'asc' ? valueA - valueB : valueB - valueA;
        }
      });
    },

    getSortIconClass(key) {
      if (this.sortConfig.key === key) {
        return this.sortConfig.direction === 'asc' ? 'bx-caret-up' : 'bx-caret-down';
      }
      return '';
    },

    async handleFilePreview(file) {
      console.log('Previewing file:', file);
      if (!file || (!file.id && !file.file)) {
        console.error('Invalid file object:', file);
        this.showErrorModal = true;
        this.errorMessage = 'Invalid file selected for preview.';
        return;
      }

      try {
        let url;
        if (file.file instanceof File) {
          url = URL.createObjectURL(file.file);
          this.previewFile = { ...file, url, name: file.customName || file.name };
        } else {
          let endpoint = '';
          switch (true) {
            case this.dentalPhotos.includes(file):
              endpoint = `/api/hr/download/dental/${file.id}?inline=true`;
              break;
            case this.treatmentPlans.includes(file):
              endpoint = `/api/hr/download/treatment/${file.id}?inline=true`;
              break;
            case this.documents.includes(file):
              endpoint = `/api/hr/download/form/${file.id}?inline=true`;
              break;
            case this.medicalRecords.includes(file):
              endpoint = `/api/hr/download/medical/${file.id}?inline=true`;
              break;
            default:
              throw new Error('Unknown file source');
          }

          const response = await axios.get(endpoint, { responseType: 'blob' });
          const mimeType = response.headers['content-type'] || this.getMimeType(file);
          const blob = new Blob([response.data], { type: mimeType });
          url = URL.createObjectURL(blob);
          this.previewFile = { ...file, url };
        }

        this.showPreviewModal = true;
      } catch (error) {
        console.error('Error previewing file:', error);
        this.showErrorModal = true;
        this.errorMessage = 'Failed to load file preview. Please try again.';
      }
    },

    handlePreviewError() {
      console.error('Image failed to load:', this.previewFile);
      this.showErrorModal = true;
      this.errorMessage = 'Unable to display image preview.';
      this.closePreview();
    },

    getMimeType(file) {
      const mimeTypes = {
        'jpg': 'image/jpeg',
        'jpeg': 'image/jpeg',
        'png': 'image/png',
        'gif': 'image/gif',
        'bmp': 'image/bmp',
        'webp': 'image/webp',
        'pdf': 'application/pdf',
        'doc': 'application/msword',
        'docx': 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
      };
      const ext = file.name?.split('.').pop()?.toLowerCase() || file.type?.toLowerCase();
      return mimeTypes[ext] || 'application/octet-stream';
    },

    closePreview() {
      if (this.previewFile?.url) {
        window.URL.revokeObjectURL(this.previewFile.url);
      }
      this.showPreviewModal = false;
      this.previewFile = null;
    },

    isImageFile(file) {
      if (!file) return false;
      const extFromName = file.name?.split('.').pop()?.toLowerCase();
      const isImageFromName = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'].includes(extFromName);
      const extFromType = file.type?.toLowerCase();
      const isImageFromType = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'].includes(extFromType);
      return isImageFromName || isImageFromType;
    },

    isPdfFile(file) {
      if (!file) return false;
      const extFromName = file.name?.split('.').pop()?.toLowerCase();
      const isPdfFromName = extFromName === 'pdf';
      const extFromType = file.type?.toLowerCase();
      const isPdfFromType = extFromType === 'pdf';
      return isPdfFromName || isPdfFromType;
    },

    deleteFile(id, type) {
      const fileArray = {
        'dental': this.dentalPhotos,
        'treatment': this.treatmentPlans,
        'document': this.documents,
        'medical': this.medicalRecords,
      }[type];

      const file = fileArray.find(f => f.id === id);
      if (!file) return;

      this.fileToDelete = file;
      this.deleteType = type;
      this.showDeleteModal = true;
    },

    async confirmDelete() {
      const { id, type } = { id: this.fileToDelete.id, type: this.deleteType };
      try {
        let endpoint = '';
        let arrayToUpdate = null;

        switch(type) {
          case 'dental':
            endpoint = `/api/hr/delete/dental/${id}`;
            arrayToUpdate = this.dentalPhotos;
            break;
          case 'treatment':
            endpoint = `/api/hr/delete/treatment/${id}`;
            arrayToUpdate = this.treatmentPlans;
            break;
          case 'document':
            endpoint = `/api/hr/delete/form/${id}`;
            arrayToUpdate = this.documents;
            break;
          case 'medical':
            endpoint = `/api/hr/delete/medical/${id}`;
            arrayToUpdate = this.medicalRecords;
            break;
          default:
            throw new Error('Invalid file type');
        }

        await axios.delete(endpoint);

        if (arrayToUpdate) {
          const index = arrayToUpdate.findIndex(item => item.id === id);
          if (index !== -1) arrayToUpdate.splice(index, 1);
        }

        this.showSuccessMessage('File removed successfully');
      } catch (error) {
        console.error('Error removing file:', error);
        this.showErrorModal = true;
        this.errorMessage = error.response?.data?.error || 'Failed to remove file. Please try again.';
      } finally {
        this.cancelDelete();
      }
    },

    cancelDelete() {
      this.showDeleteModal = false;
      this.fileToDelete = null;
      this.deleteType = null;
    },

    openMedicalFileUpload() {
      this.$refs.medicalFileInput.click();
    },

    prepareFileUpload(event, type) {
      const files = event.target.files;
      if (!files.length) return;

      this.uploadType = type;
      this.selectedFiles = Array.from(files).map(file => ({
        file: file,
        name: file.name,
        customName: file.name.split('.')[0],
        size: file.size,
        type: file.type
      }));

      this.showUploadModal = true;

      if (type === 'dental') {
        this.$refs.fileInput.value = '';
      } else if (type === 'treatment') {
        this.$refs.treatmentFileInput.value = '';
      } else if (type === 'document') {
        this.$refs.documentInput.value = '';
      } else if (type === 'medical') {
        this.$refs.medicalFileInput.value = '';
      }
    },

    cancelUpload() {
      this.showUploadModal = false;
      this.selectedFiles = [];
      this.uploadType = null;
    },

    removeSelectedFile(index) {
      this.selectedFiles.splice(index, 1);
    },

    getUploadTypeName() {
      switch(this.uploadType) {
        case 'dental': return 'Dental Photos';
        case 'treatment': return 'Treatment Plans';
        case 'document': return 'Documents';
        case 'medical': return 'Medical Records';
        default: return '';
      }
    },

    async confirmUpload() {
      if (!this.selectedFiles.length) return;

      const formData = new FormData();
      formData.append('patient_id', this.selectedPatient.PatientID);

      let validExtensions;
      if (this.uploadType === 'dental') {
        validExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
      } else {
        validExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'pdf', 'doc', 'docx'];
      }

      for (const fileObj of this.selectedFiles) {
        const extension = fileObj.file.name.split('.').pop().toLowerCase();
        if (!validExtensions.includes(extension)) {
          this.errorMessage = `The file "${fileObj.file.name}" has an invalid format.`;
          this.showErrorModal = true;
          return;
        }
      }

      this.selectedFiles.forEach((fileObj, index) => {
        formData.append(`files[${index}]`, fileObj.file);

        let customName = fileObj.customName || fileObj.file.name;
        const extension = fileObj.file.name.split('.').pop().toLowerCase();

        const customExt = customName.split('.').pop().toLowerCase();
        if (!validExtensions.includes(customExt)) {
          customName = customName.split('.')[0] + '.' + extension;
        }

        formData.append(`file_names[${index}]`, customName);
      });

      try {
        let endpoint = '';
        switch (this.uploadType) {
          case 'dental':
            endpoint = '/api/hr/upload-dental-photos';
            break;
          case 'treatment':
            endpoint = '/api/hr/upload-treatment-plans';
            break;
          case 'document':
            endpoint = '/api/hr/upload-dental-forms';
            break;
          case 'medical':
            endpoint = '/api/hr/upload-medical-records';
            break;
        }

        const response = await axios.post(endpoint, formData, {
          headers: { 'Content-Type': 'multipart/form-data' },
        });

        this.fetchPatientFiles();
        this.showUploadModal = false;
        this.selectedFiles = [];
        this.uploadType = null;

        this.showSuccessMessage('Files uploaded successfully!');
      } catch (error) {
        console.error(`Error uploading files:`, error);
        this.errorMessage = error.response?.data?.message || 'An error occurred while uploading files.';
        this.showErrorModal = true;
      }
    },

    showSuccessMessage(message) {
      this.successMessage = message;
      this.showSuccessModal = true;

      setTimeout(() => {
        this.showSuccessModal = false;
        this.successMessage = '';
      }, 3000);
    },

    closeErrorModal() {
      this.showErrorModal = false;
      this.errorMessage = '';
    },

    openFileUpload() {
      this.$refs.fileInput.click();
    },

    openTreatmentFileUpload() {
      this.$refs.treatmentFileInput.click();
    },

    openDocumentUpload() {
      this.$refs.documentInput.click();
    },

    getDocumentIcon(filename) {
      if (!filename) return 'bx bxs-file';

      const ext = filename.split('.').pop().toLowerCase();
      if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) return 'bx bxs-file-image';
      if (['pdf'].includes(ext)) return 'bx bxs-file-pdf';
      if (['doc', 'docx'].includes(ext)) return 'bx bxs-file-doc';
      if (['xls', 'xlsx'].includes(ext)) return 'bx bxs-file-spreadsheet';
      if (['ppt', 'pptx'].includes(ext)) return 'bx bxs-file-presentation';
      return 'bx bxs-file';
    },

    formatFileSize(bytes) {
      if (!bytes) return '0 Bytes';
      const k = 1024;
      const sizes = ['Bytes', 'KB', 'MB', 'GB'];
      const i = Math.floor(Math.log(bytes) / Math.log(k));
      return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    },

    formatAppointmentDate(dateString) {
      if (!dateString) return '';

      try {
        const date = new Date(dateString);
        if (isNaN(date.getTime())) return '';
        return date.toLocaleDateString('en-US', {
          month: 'short',
          day: 'numeric',
          year: 'numeric'
        });
      } catch (error) {
        console.error("Error formatting date:", error);
        return '';
      }
    },

    formatDateTime(dateString) {
      if (!dateString) return 'N/A';

      try {
        const date = new Date(dateString);
        if (isNaN(date.getTime())) return 'N/A';
        return date.toLocaleString('en-US', {
          weekday: 'short',
          month: 'short',
          day: 'numeric',
          year: 'numeric',
          hour: '2-digit',
          minute: '2-digit',
          hour12: true
        });
      } catch (error) {
        console.error("Error formatting date time:", error);
        return 'N/A';
      }
    },

    truncateText(text, maxLength) {
      if (!text) return '';
      if (text.length <= maxLength) return text;
      return text.substring(0, maxLength) + '...';
    },

    formatCurrency(amount) {
      if (!amount && amount !== 0) return 'N/A';
      return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'PHP' }).format(amount);
    },

    async fetchPatients(page = 1) {
      try {
        const response = await axios.get('/patient-list', {
          params: { 
            page, 
            search: this.isSearchActive ? this.searchQuery : '',
            appointmentStatus: this.filter.appointmentStatus,
            sortBy: this.filter.sortBy
          },
        });
        
        const appointmentsResponse = await axios.get('/hr/appointments/calendar');
        const appointments = appointmentsResponse.data || [];
        
        this.patients = response.data.data.map(patient => {
          const patientName = `${patient.user.FirstName} ${patient.user.LastName}`;
          const patientAppointments = appointments.filter(
            appt => appt.patient_name === patientName
          );
          
          patientAppointments.sort((a, b) => {
            return new Date(a.AppointmentDate) - new Date(b.AppointmentDate);
          });
          
          const now = new Date();
          const upcomingAppointments = patientAppointments.filter(
            appt => new Date(`${appt.AppointmentDate}T${appt.AppointmentTime}`) > now
          );
          const pastAppointments = patientAppointments.filter(
            appt => new Date(`${appt.AppointmentDate}T${appt.AppointmentTime}`) <= now
          );
          
          const nextAppointment = upcomingAppointments.length > 0 ? 
            `${upcomingAppointments[0].AppointmentDate}T${upcomingAppointments[0].AppointmentTime}` : null;
          
          const lastAppointment = pastAppointments.length > 0 ?
            `${pastAppointments[pastAppointments.length - 1].AppointmentDate}T${pastAppointments[pastAppointments.length - 1].AppointmentTime}` : null;
          
          return {
            ...patient,
            nextAppointment,
            lastAppointment,
            totalVisits: pastAppointments.length,
            upcomingAppointments: upcomingAppointments.length
          };
        });
        
        this.filteredPatients = [...this.patients]; // Initialize filteredPatients
        this.currentPage = response.data.current_page;
        this.lastPage = response.data.last_page;
        this.totalPatients = response.data.total;

        if (this.sortConfig.key) {
          this.applySorting();
        }
      } catch (error) {
        console.error("Error fetching patients:", error);
      }
    },

    async fetchPatientFiles() {
      if (!this.selectedPatient) return;
      try {
        const [photosResponse, plansResponse, formsResponse, medicalResponse] = await Promise.all([
          axios.get(`/api/hr/patient/${this.selectedPatient.PatientID}/dental-photos`).catch(error => {
            console.error('Error fetching dental photos:', error);
            return { data: [] };
          }),
          axios.get(`/api/hr/patient/${this.selectedPatient.PatientID}/treatment-plans`).catch(error => {
            console.error('Error fetching treatment plans:', error);
            return { data: [] };
          }),
          axios.get(`/api/hr/patient/${this.selectedPatient.PatientID}/dental-forms`).catch(error => {
            console.error('Error fetching dental forms:', error);
            return { data: [] };
          }),
          axios.get(`/api/hr/patient/${this.selectedPatient.PatientID}/medical-records`).catch(error => {
            console.error('Error fetching medical records:', error);
            return { data: [] };
          }),
        ]);

        this.dentalPhotos = photosResponse.data
          .map(photo => ({
            id: photo.DentalPhotoID,
            name: photo.FileName,
            type: photo.FileType,
            description: photo.Description || '',
            date: photo.UploadDate,
            isTreatmentPlan: false
          }))
          .sort((a, b) => new Date(b.date) - new Date(a.date));

        this.treatmentPlans = plansResponse.data
          .map(plan => ({
            id: plan.TreatmentPlanID,
            name: plan.FileName,
            type: plan.FileType,
            description: plan.Description || '',
            date: plan.UploadDate,
            isTreatmentPlan: true
          }))
          .sort((a, b) => new Date(b.date) - new Date(a.date));

        this.documents = formsResponse.data
          .map(form => ({
            id: form.DentalFormID,
            name: form.FileName,
            type: form.FileType,
            size: form.FileSize || 0,
            date: form.UploadDate,
            isTreatmentPlan: false
          }))
          .sort((a, b) => new Date(b.date) - new Date(a.date));

        this.medicalRecords = medicalResponse.data
          .map(record => ({
            id: record.MedicalRecordID,
            name: record.FileName,
            type: record.FileType,
            recordType: record.RecordType || '',
            date: record.UploadDate,
            isTreatmentPlan: false
          }))
          .sort((a, b) => new Date(b.date) - new Date(a.date));

        await this.fetchPatientAppointments();
      } catch (error) {
        console.error('Error fetching patient files:', error);
        this.showErrorModal = true;
        this.errorMessage = 'Failed to load patient files. Please try again.';
      }
    },

    async fetchPatientAppointments() {
      if (!this.selectedPatient) return;
      
      try {
        const response = await axios.get('/hr/appointments/calendar');
        const allAppointments = response.data || [];
        
        const patientName = `${this.selectedPatient.user.FirstName} ${this.selectedPatient.user.LastName}`;
        const patientAppointments = allAppointments.filter(
          appt => appt.patient_name === patientName
        ).map(appt => ({
          id: appt.AppointmentID,
          title: `Patient: ${appt.patient_name} - ${appt.services && appt.services.length > 0 ? appt.services.map(s => s.ServiceName).join(', ') : 'N/A'}`,
          start: `${appt.AppointmentDate}T${appt.AppointmentTime}`,
          end: appt.EndTime ? `${appt.AppointmentDate}T${appt.EndTime}` : null,
          allDay: false,
          extendedProps: {
            PatientName: appt.patient_name,
            PatientContact: appt.PatientContact || null,
            PatientEmail: appt.PatientEmail || null,
            Services: appt.services || [],
            PatientNote: appt.PatientNote || null,
            MedicalHistory: appt.MedicalHistory || null,
            Status: appt.AppointmentStatus || 'Scheduled'
          },
        }));
        
        patientAppointments.sort((a, b) => new Date(a.start) - new Date(b.start));
        
        const now = new Date();
        this.upcomingAppointments = patientAppointments.filter(
          appt => new Date(appt.start) >= now
        );
        
        this.pastAppointments = patientAppointments.filter(
          appt => new Date(appt.start) < now
        );
        
        if (this.selectedPatient) {
          this.selectedPatient.totalVisits = this.pastAppointments.length;
          this.selectedPatient.upcomingAppointments = this.upcomingAppointments.length;
        }
        
        this.upcomingAppointmentsPage = 1;
        this.pastAppointmentsPage = 1;
      } catch (error) {
        console.error('Error fetching patient appointments:', error);
      }
    },

    async fetchLedger() {
      if (!this.selectedPatient) return;
      try {
        const response = await axios.get(`/hr/patient-ledger/${this.selectedPatient.PatientID}`);
        this.ledger = response.data.ledger;
      } catch (error) {
        console.error('Error fetching ledger:', error);
        this.showErrorModal = true;
        this.errorMessage = error.response?.data?.error || 'Failed to load ledger data. Please try again later.';
      }
    },

    changePage(page) {
      if (page > 0 && page <= this.lastPage) {
        this.currentPage = page;
        // Update displayed patients based on page
        const start = (page - 1) * 15;
        const end = start + 15;
        this.filteredPatients = this.filteredPatients.slice(start, end);
      }
    },

    changeUpcomingAppointmentsPage(page) {
      if (page > 0 && page <= this.upcomingAppointmentsLastPage) {
        this.upcomingAppointmentsPage = page;
      }
    },

    changePastAppointmentsPage(page) {
      if (page > 0 && page <= this.pastAppointmentsLastPage) {
        this.pastAppointmentsPage = page;
      }
    },

    async selectPatient(patient) {
      this.selectedPatient = patient;
      this.activeTab = 'upcoming';
      this.patientNote = ''; // Reset while fetching
      await Promise.all([
        this.fetchPatientFiles(),
        this.fetchPatientNote(),
      ]);
    },

    goBack() {
      this.selectedPatient = null;
      this.patientNote = '';
      this.activeTab = 'upcoming';
      this.dentalPhotos = [];
      this.treatmentPlans = [];
      this.documents = [];
      this.medicalRecords = [];
      this.upcomingAppointments = [];
      this.pastAppointments = [];
    },

    async saveNote() {
      if (!this.patientNote.trim()) {
        this.showErrorModal = true;
        this.errorMessage = 'Note cannot be empty.';
        return;
      }
      try {
        await axios.post('/patient/notes', {
          PatientID: this.selectedPatient.PatientID,
          NoteDescription: this.patientNote.trim(),
        });
        this.showSuccessMessage('Note saved successfully');
      } catch (error) {
        console.error('Error saving note:', error);
        this.showErrorModal = true;
        this.errorMessage = error.response?.data?.message || 'Failed to save note.';
      }
    },

    async fetchPatientNote() {
      if (!this.selectedPatient) return;
      try {
        const response = await axios.get(`/patient/${this.selectedPatient.PatientID}/notes`);
        const notes = response.data || [];
        const latestNote = notes.sort((a, b) => new Date(b.created_at) - new Date(a.created_at))[0];
        this.patientNote = latestNote?.NoteDescription || '';
      } catch (error) {
        console.error('Error fetching note:', error);
        this.patientNote = '';
      }
    },

    navigateTabs(direction) {
      const currentIndex = this.tabs.indexOf(this.activeTab);

      if (direction === 'next' && currentIndex < this.tabs.length - 1) {
        this.activeTab = this.tabs[currentIndex + 1];
      } else if (direction === 'prev' && currentIndex > 0) {
        this.activeTab = this.tabs[currentIndex - 1];
      }

      this.$nextTick(() => {
        const activeTabElement = document.querySelector('.tab-btn.active');
        if (activeTabElement) {
          activeTabElement.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
        }
      });
    },

    openGovernmentIdModal() {
      if (this.selectedPatient.GovernmentID) {
        this.governmentIdUrl = `/storage/${this.selectedPatient.GovernmentID}`;
      } else {
        this.governmentIdUrl = null;
      }
      this.showGovernmentIdModal = true;
    },

    closeGovernmentIdModal() {
      this.showGovernmentIdModal = false;
      this.governmentIdUrl = null;
    },

    handleIdImageError() {
      this.governmentIdUrl = null;
      this.errorMessage = 'Failed to load Government ID image.';
      this.showErrorModal = true;
    },
  },
  watch: {
    activeTab(newTab) {
      if (newTab === 'ledger') {
        this.fetchLedger();
      }
    },
    'selectedPatient.PatientID': function(newId) {
      if (this.activeTab === 'ledger' && newId) {
        this.fetchLedger();
      }
    }
  },
  mounted() {
    this.$nextTick(() => {
      const sidebar = document.querySelector(".sidebar");
      const sidebarBtn = document.querySelector(".bx-menu");
      if (sidebar && sidebarBtn) {
        sidebarBtn.addEventListener("click", () => {
          sidebar.classList.toggle("close");
          // Handle mobile overlay
          const overlay = document.querySelector(".mobile-overlay");
          if (window.innerWidth <= 768) {
            overlay.classList.toggle("active");
          }
        });
      }

      document.addEventListener('click', this.handleClickOutside);
    });

    this.fetchPatients();
  },
  beforeDestroy() {
    document.removeEventListener('click', this.handleClickOutside);
  }
};
</script>

<style scoped>
@import url('https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css');
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap');

/* Base Styles */
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

.sidebar.close .nav-link li i.arrow {
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
  flex-shrink: 0;
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
  width: 250px;
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

.filter-group input,
.filter-group select {
  width: 100%;
  padding: 8px;
  border: 1px solid #e0e0e0;
  border-radius: 4px;
  font-size: 14px;
}

.filter-group input[type="date"] {
  margin-bottom: 10px;
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

/* Patient Table Styles */
.patient-container {
  margin: 20px;
  background-color: white;
  border-radius: 12px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
  overflow: hidden;
}

.patient-header {
  padding: 20px 25px 0;
  border-bottom: 1px solid #f0f0f0;
}

.patient-header h3 {
  font-size: 18px;
  color: #333;
  font-weight: 600;
  margin: 0;
  padding-bottom: 15px;
}

.table-wrapper {
  padding: 0;
}

.patient-table {
  width: 100%;
  border-collapse: collapse;
  background-color: white;
  table-layout: fixed;
}

.patient-table th,
.patient-table td {
  padding: 16px;
  text-align: left;
  border-bottom: 1px solid #f5f5f5;
  color: #333;
  font-size: 14px;
  width: 20%;
}

.patient-table th {
  color: #06693A;
  font-weight: 600;
  font-size: 14px;
  background-color: #f9f9f9;
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

.patient-row {
  cursor: pointer;
  transition: background-color 0.2s;
}

.patient-row:hover {
  background-color: #f9f9f9;
}

.patient-table tr:last-child td {
  border-bottom: none;
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

.patient-card {
  background-color: white;
  border-radius: 12px;
  border: 1px solid #e0e0e0;
  margin-bottom: 16px;
  overflow: hidden;
  cursor: pointer;
  transition: transform 0.2s, box-shadow 0.2s;
}

.patient-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 16px;
  border-bottom: 1px solid #f0f0f0;
  background-color: #f9f9f9;
}

.card-header h4 {
  margin: 0;
  font-size: 16px;
  font-weight: 600;
  color: #333;
  flex: 1;
  margin-right: 10px;
}

.patient-number {
  background-color: #06693A;
  color: white;
  padding: 4px 8px;
  border-radius: 12px;
  font-size: 12px;
  font-weight: 600;
}

.card-content {
  padding: 16px;
}

.card-row {
  margin-bottom: 12px;
  display: flex;
  flex-direction: column;
}

.card-label {
  font-weight: 600;
  color: #06693A;
  font-size: 14px;
  margin-bottom: 4px;
}

.no-data-mobile {
  text-align: center;
  color: #757575;
  padding: 30px;
  background-color: white;
  border-radius: 12px;
  border: 1px solid #e0e0e0;
  min-height: 200px;
  display: flex;
  align-items: center;
  justify-content: center;
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
}

.pagination-btn i {
  font-size: 14px;
}

/* Patient Details Styles */
.details-container {
  margin: 20px;
}

.back-btn {
  background-color: #06693A;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 8px;
  cursor: pointer;
  font-size: 14px;
  display: flex;
  align-items: center;
  gap: 8px;
  margin-bottom: 20px;
  transition: background-color 0.2s;
}

.back-btn:hover {
  background-color: #055a32;
}

.back-btn i {
  font-size: 16px;
}

/* Patient Profile Section */
.patient-profile-section {
  margin-bottom: 30px;
}

.patient-details-notes-container {
  display: flex;
  gap: 20px;
  margin-bottom: 20px;
}

.patient-profile-card {
  flex: 2;
  background: white;
  border-radius: 12px;
  padding: 25px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.patient-profile-header {
  display: flex;
  align-items: center;
  gap: 20px;
  margin-bottom: 25px;
  padding-bottom: 20px;
  border-bottom: 1px solid #f0f0f0;
}

.patient-avatar {
  width: 80px;
  height: 80px;
  background: linear-gradient(135deg, #06693A, #0a8a4a);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-size: 40px;
  flex-shrink: 0;
}

.patient-basic-info {
  flex: 1;
}

.patient-basic-info h2 {
  margin: 0 0 8px 0;
  color: #333;
  font-size: 24px;
  font-weight: 600;
}

.patient-id {
  color: #06693A;
  font-weight: 500;
  margin: 0 0 4px 0;
  font-size: 14px;
}

.patient-email {
  color: #666;
  margin: 0;
  font-size: 14px;
}

.patient-stats {
  display: flex;
  align-items: center;
  gap: 20px;
}

.stat-item {
  text-align: center;
}

.stat-value {
  font-size: 24px;
  font-weight: 700;
  color: #06693A;
  margin-bottom: 4px;
}

.stat-label {
  font-size: 12px;
  color: #666;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.stat-divider {
  width: 1px;
  height: 40px;
  background-color: #e0e0e0;
}

.patient-details-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 20px;
  margin-bottom: 20px;
}

.details-column {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.detail-item {
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.detail-label {
  font-size: 12px;
  color: #666;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  font-weight: 500;
}

.detail-value {
  font-size: 14px;
  color: #333;
  font-weight: 500;
}

.record-creation {
  display: flex;
  align-items: center;
  gap: 8px;
  color: #666;
  font-size: 13px;
  padding-top: 15px;
  border-top: 1px solid #f0f0f0;
}

.record-creation i {
  color: #06693A;
  font-size: 16px;
}

/* Notes Container */
.notes-container {
  flex: 1;
  background: white;
  border-radius: 12px;
  padding: 20px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
  display: flex;
  flex-direction: column;
  height: fit-content;
}

.notes-container h3 {
  margin: 0 0 15px 0;
  color: #333;
  font-size: 18px;
  font-weight: 600;
  display: flex;
  align-items: center;
  gap: 8px;
}

.notes-container h3 i {
  color: #06693A;
  font-size: 20px;
}

.notes-textarea {
  width: 100%;
  min-height: 120px;
  padding: 15px;
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  font-family: 'Poppins', sans-serif;
  font-size: 14px;
  line-height: 1.5;
  resize: vertical;
  outline: none;
  transition: border-color 0.2s;
  margin-bottom: 15px;
}

.notes-textarea:focus {
  border-color: #06693A;
}

.save-btn {
  background-color: #06693A;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 6px;
  cursor: pointer;
  font-size: 14px;
  font-weight: 500;
  display: flex;
  align-items: center;
  gap: 8px;
  align-self: flex-end;
  transition: background-color 0.2s;
}

.save-btn:hover {
  background-color: #055a32;
}

.save-btn i {
  font-size: 16px;
}

/* Patient View Layout */
.patient-view-layout {
  display: flex;
  gap: 20px;
}

.slider-container {
  flex: 2;
  background: white;
  border-radius: 12px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
  overflow: hidden;
}

.slider-tabs-wrapper {
  display: flex;
  align-items: center;
  background-color: #f9f9f9;
  border-bottom: 1px solid #e0e0e0;
  position: relative;
}

.tab-nav-arrow {
  background: none;
  border: none;
  padding: 15px 10px;
  cursor: pointer;
  color: #06693A;
  font-size: 18px;
  transition: background-color 0.2s;
  flex-shrink: 0;
}

.tab-nav-arrow:hover:not(:disabled) {
  background-color: #e0e0e0;
}

.tab-nav-arrow:disabled {
  color: #ccc;
  cursor: not-allowed;
}

.slider-tabs {
  display: flex;
  overflow-x: auto;
  flex: 1;
  scrollbar-width: none;
  -ms-overflow-style: none;
}

.slider-tabs::-webkit-scrollbar {
  display: none;
}

.tab-btn {
  background: none;
  border: none;
  padding: 15px 20px;
  cursor: pointer;
  font-size: 14px;
  font-weight: 500;
  color: #666;
  transition: all 0.2s;
  white-space: nowrap;
  display: flex;
  align-items: center;
  gap: 8px;
  border-bottom: 3px solid transparent;
  flex-shrink: 0;
}

.tab-btn:hover {
  background-color: #f0f0f0;
  color: #333;
}

.tab-btn.active {
  color: #06693A;
  background-color: white;
  border-bottom-color: #06693A;
}

.tab-btn i {
  font-size: 16px;
}

.tab-text {
  display: inline;
}

.slider-content {
  padding: 20px;
}

.view-more {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
  padding-bottom: 15px;
  border-bottom: 1px solid #f0f0f0;
}

.view-more a {
  color: #06693A;
  text-decoration: none;
  font-size: 14px;
  display: flex;
  align-items: center;
  gap: 5px;
}

.view-more a:hover {
  text-decoration: underline;
}

.add-files-btn {
  background-color: #06693A;
  color: white;
  border: none;
  padding: 8px 16px;
  border-radius: 6px;
  cursor: pointer;
  font-size: 13px;
  display: flex;
  align-items: center;
  gap: 6px;
  transition: background-color 0.2s;
}

.add-files-btn:hover {
  background-color: #055a32;
}

.add-files-btn i {
  font-size: 14px;
}

/* Tab Content */
.tab-content {
  min-height: 300px;
}

.appointment-item {
  margin-bottom: 15px;
}

.appointment-card {
  display: flex;
  align-items: center;
  gap: 15px;
  padding: 15px;
  background-color: #f9f9f9;
  border-radius: 8px;
  border-left: 4px solid #06693A;
}

.appointment-icon {
  width: 40px;
  height: 40px;
  background-color: #06693A;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-size: 18px;
  flex-shrink: 0;
}

.appointment-details {
  flex: 1;
}

.appointment-details h4 {
  margin: 0 0 5px 0;
  color: #333;
  font-size: 16px;
  font-weight: 600;
}

.appointment-details p {
  margin: 0 0 3px 0;
  color: #666;
  font-size: 14px;
  line-height: 1.4;
}

.appointments-pagination {
  margin-top: 20px;
  padding-top: 15px;
  border-top: 1px solid #f0f0f0;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.no-content {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 40px;
  color: #666;
  text-align: center;
}

.empty-icon {
  font-size: 48px;
  color: #ddd;
  margin-bottom: 15px;
}

.no-content p {
  font-size: 16px;
  margin: 0;
}

/* Document Styles */
.documents-list {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.document-item {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 12px;
  background-color: #f9f9f9;
  border-radius: 8px;
  transition: background-color 0.2s;
}

.document-item:hover {
  background-color: #f0f0f0;
}

.document-item i {
  font-size: 24px;
  color: #06693A;
  flex-shrink: 0;
}

.document-info {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 2px;
}

.file-name,
.document-name {
  font-weight: 500;
  color: #333;
  font-size: 14px;
}

.document-size {
  font-size: 12px;
  color: #666;
}

.document-actions {
  display: flex;
  gap: 8px;
}

.doc-action-btn {
  background: none;
  border: none;
  padding: 6px;
  border-radius: 4px;
  cursor: pointer;
  color: #666;
  transition: all 0.2s;
  display: flex;
  align-items: center;
  justify-content: center;
}

.doc-action-btn:hover {
  background-color: #e0e0e0;
  color: #333;
}

.doc-action-btn i {
  font-size: 16px;
}

/* Document Files Container */
.document-files-container {
  flex: 1;
  background: white;
  border-radius: 12px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
  overflow: hidden;
  height: fit-content;
}

.document-files-header {
  padding: 20px;
  border-bottom: 1px solid #f0f0f0;
  display: flex;
  justify-content: space-between;
  align-items: center;
  background-color: #f9f9f9;
}

.document-files-header h3 {
  margin: 0;
  color: #333;
  font-size: 18px;
  font-weight: 600;
  display: flex;
  align-items: center;
  gap: 8px;
}

.document-files-header h3 i {
  color: #06693A;
  font-size: 20px;
}

.document-files-content {
  padding: 20px;
  max-height: 400px;
  overflow-y: auto;
}

.no-documents {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 40px 20px;
  color: #666;
  text-align: center;
}

.no-documents .empty-icon {
  font-size: 48px;
  color: #ddd;
  margin-bottom: 15px;
}

.no-documents p {
  margin: 0 0 5px 0;
  font-size: 14px;
}

.drag-hint {
  font-size: 12px;
  color: #999;
}

/* Ledger Table */
.ledger-table {
  width: 100%;
  border-collapse: collapse;
  background-color: white;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
  table-layout: fixed;
}

.ledger-table th,
.ledger-table td {
  padding: 16px;
  text-align: left;
  border-bottom: 1px solid #f5f5f5;
  color: #333;
  font-size: 14px;
}

.ledger-table th {
  color: #06693A;
  font-weight: 600;
  font-size: 14px;
  background-color: #f9f9f9;
  position: sticky;
  top: 0;
  z-index: 1;
}

.ledger-table tr {
  transition: 0.2s;
}

.ledger-table tr:hover {
  background-color: #e8f5ee;
}

.ledger-table td {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.ledger-table tr:last-child td {
  border-bottom: none;
}

.ledger-table td.balance-negative {
  color: #d32f2f;
  font-weight: 500;
}

.ledger-total-row {
  background-color: #e8f5ee;
  font-weight: 600;
}

.ledger-total-row td {
  padding: 12px 16px;
  color: #333;
  border-top: 2px solid #d0e8db;
}

/* Government ID Button */
.view-id-btn {
  background-color: #06693a;
  color: white;
  border: none;
  padding: 6px 12px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 14px;
  transition: background-color 0.3s;
}

.view-id-btn:hover {
  background-color: #055630;
}

.view-id-btn:disabled {
  background-color: #cccccc;
  cursor: not-allowed;
}

/* Modal Styles */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.6);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
  backdrop-filter: blur(3px);
}

.modal-container {
  background: white;
  width: 90%;
  max-width: 600px;
  border-radius: 12px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
  overflow: hidden;
  animation: modalFadeIn 0.3s ease;
}

@keyframes modalFadeIn {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px 25px;
  border-bottom: 1px solid #f0f0f0;
  background-color: #fff;
}

.modal-header h3 {
  margin: 0;
  font-size: 20px;
  font-weight: 600;
  color: #333;
}

.close-btn {
  background: none;
  border: none;
  font-size: 24px;
  color: #777;
  cursor: pointer;
  transition: color 0.3s ease;
  padding: 5px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.close-btn:hover {
  color: #333;
  background-color: #f0f0f0;
}

.close-btn i {
  font-size: 20px;
}

.modal-body {
  padding: 25px;
  max-height: 70vh;
  overflow-y: auto;
}

.modal-footer {
  display: flex;
  justify-content: flex-end;
  gap: 10px;
  padding: 20px 25px;
  border-top: 1px solid #f0f0f0;
  background-color: #f9f9f9;
}

/* File Upload Modal */
.selected-files-list {
  display: flex;
  flex-direction: column;
  gap: 15px;
  margin-bottom: 20px;
}

.selected-file-item {
  display: flex;
  align-items: center;
  gap: 15px;
  padding: 15px;
  background-color: #f9f9f9;
  border-radius: 8px;
  border: 1px solid #e0e0e0;
}

.file-icon {
  width: 40px;
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: #06693A;
  border-radius: 8px;
  color: white;
  font-size: 20px;
  flex-shrink: 0;
}

.file-details {
  flex: 1;
}

.file-name-input {
  display: flex;
  flex-direction: column;
  gap: 5px;
}

.file-name-input label {
  font-size: 12px;
  font-weight: 600;
  color: #666;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.custom-name-input {
  padding: 8px 12px;
  border: 1px solid #e0e0e0;
  border-radius: 4px;
  font-size: 14px;
  outline: none;
  transition: border-color 0.2s;
}

.custom-name-input:focus {
  border-color: #06693A;
}

.remove-file-btn {
  background: none;
  border: none;
  padding: 8px;
  border-radius: 4px;
  cursor: pointer;
  color: #666;
  transition: all 0.2s;
  flex-shrink: 0;
}

.remove-file-btn:hover {
  background-color: #ffe6e6;
  color: #d32f2f;
}

.remove-file-btn i {
  font-size: 18px;
}

.no-files-selected {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 40px;
  color: #666;
  text-align: center;
}

.upload-type {
  margin-top: 15px;
  padding: 10px;
  background-color: #f0f8f4;
  border-radius: 6px;
  border-left: 4px solid #06693A;
}

.upload-type p {
  margin: 0;
  font-size: 14px;
  color: #333;
}

.upload-type strong {
  color: #06693A;
}

/* Modal Buttons */
.cancel-btn {
  background-color: #f5f5f5;
  color: #666;
  border: none;
  padding: 10px 20px;
  border-radius: 6px;
  cursor: pointer;
  font-size: 14px;
  font-weight: 500;
  transition: background-color 0.2s;
}

.cancel-btn:hover {
  background-color: #e0e0e0;
}

.confirm-btn {
  background-color: #06693A;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 6px;
  cursor: pointer;
  font-size: 14px;
  font-weight: 500;
  transition: background-color 0.2s;
}

.confirm-btn:hover:not(:disabled) {
  background-color: #055a32;
}

.confirm-btn:disabled {
  background-color: #ccc;
  cursor: not-allowed;
}

.delete-btn {
  background-color: #d32f2f;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 6px;
  cursor: pointer;
  font-size: 14px;
  font-weight: 500;
  transition: background-color 0.2s;
}

.delete-btn:hover {
  background-color: #b71c1c;
}

/* Preview Modal */
.preview-modal-container {
  background: white;
  width: 90%;
  max-width: 800px;
  max-height: 90vh;
  border-radius: 12px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
  overflow: hidden;
  animation: modalFadeIn 0.3s ease;
}

.preview-modal-body {
  padding: 0;
  max-height: calc(90vh - 80px);
  overflow: auto;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: #f5f5f5;
}

.preview-image {
  max-width: 100%;
  max-height: 100%;
  object-fit: contain;
}

.preview-pdf {
  width: 100%;
  height: 70vh;
  border: none;
}

.preview-not-available {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 60px;
  color: #666;
  text-align: center;
}

.preview-not-available i {
  font-size: 64px;
  color: #ddd;
  margin-bottom: 20px;
}

.preview-not-available p {
  margin: 0 0 15px 0;
  font-size: 16px;
}

.download-link {
  color: #06693A;
  text-decoration: none;
  font-weight: 500;
}

.download-link:hover {
  text-decoration: underline;
}

/* Government ID Modal */
.id-modal-container {
  background: white;
  border-radius: 8px;
  width: 500px;
  max-width: 90%;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.id-modal-body {
  padding: 20px;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 200px;
}

.id-image {
  max-width: 100%;
  max-height: 400px;
  object-fit: contain;
  border-radius: 4px;
}

.no-id {
  text-align: center;
  color: #666;
}

.no-id .empty-icon {
  font-size: 48px;
  margin-bottom: 10px;
  color: #999;
}

.no-id p {
  margin: 0;
  font-size: 16px;
}

/* Error and Success Modals */
.error-modal .modal-header {
  background-color: #ffebee;
  color: #d32f2f;
}

.error-modal .modal-header h3 {
  color: #d32f2f;
}

.error-hint {
  margin-top: 10px;
  font-size: 13px;
  color: #666;
  background-color: #f9f9f9;
  padding: 10px;
  border-radius: 4px;
}

.success-modal .modal-header {
  background-color: #e8f5e8;
  color: #06693A;
}

.success-modal .modal-header h3 {
  color: #06693A;
}

/* Delete Modal */
.delete-modal .modal-header {
  background-color: #ffebee;
  color: #d32f2f;
}

.delete-modal .modal-header h3 {
  color: #d32f2f;
}

/* Responsive Design */

/* Large Desktop */
@media (min-width: 1400px) {
  .patient-container {
    margin: 30px;
  }

  .patient-profile-card {
    padding: 30px;
  }

  .notes-container {
    padding: 25px;
  }

  .slider-content {
    padding: 25px;
  }

  .document-files-content {
    padding: 25px;
  }
}

/* Desktop */
@media (max-width: 1200px) {
  .sidebar {
    width: 250px;
  }

  .sidebar.close {
    width: 78px;
  }

  .sidebar .profile-details {
    width: 250px;
  }

  .sidebar.close .profile-details {
    width: 78px;
  }

  .home-section {
    left: 250px;
    width: calc(100% - 250px);
  }

  .sidebar.close ~ .home-section {
    left: 78px;
    width: calc(100% - 78px);
  }

  .patient-table th,
  .patient-table td {
    padding: 12px 15px;
    font-size: 13px;
  }

  .patient-stats {
    gap: 15px;
  }

  .stat-value {
    font-size: 20px;
  }
}

/* Tablet */
@media (max-width: 992px) {
  .search-wrapper {
    flex-direction: column;
    gap: 15px;
    width: 95%;
    margin-left: 15px;
  }

  .search-container {
    width: 100%;
    margin-right: 0;
  }

  .buttons {
    align-self: flex-end;
  }

  .patient-container {
    margin: 15px;
  }

  .patient-header h3 {
    font-size: 16px;
  }

  .patient-details-notes-container {
    flex-direction: column;
    gap: 15px;
  }

  .patient-view-layout {
    flex-direction: column;
    gap: 15px;
  }

  .patient-profile-header {
    flex-direction: column;
    text-align: center;
    gap: 15px;
  }

  .patient-stats {
    justify-content: center;
  }

  .patient-details-grid {
    grid-template-columns: 1fr;
    gap: 15px;
  }

  .modal-container {
    width: 95%;
    max-width: 600px;
  }

  .modal-header {
    padding: 15px 18px;
  }

  .modal-body {
    padding: 18px;
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

  .desktop-table {
    display: none;
  }

  .mobile-cards {
    display: block;
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
    flex-direction: column;
    gap: 10px;
  }

  .search-input {
    height: 42px;
    font-size: 14px;
  }

  .filter {
    width: 100%;
    justify-content: center;
  }

  .patient-container {
    margin: 10px;
  }

  .patient-header h3 {
    font-size: 16px;
    padding: 15px 0 10px 0;
  }

  .patient-card {
    border-radius: 8px;
    margin-bottom: 12px;
  }

  .card-header {
    padding: 12px 15px;
  }

  .card-header h4 {
    font-size: 15px;
  }

  .card-content {
    padding: 12px 15px;
  }

  .card-row {
    margin-bottom: 10px;
  }

  .card-label {
    font-size: 13px;
  }

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

  .details-container {
    margin: 10px;
  }

  .back-btn {
    padding: 8px 16px;
    font-size: 13px;
  }

  .patient-profile-card {
    padding: 20px;
  }

  .patient-profile-header {
    gap: 12px;
  }

  .patient-avatar {
    width: 60px;
    height: 60px;
    font-size: 30px;
  }

  .patient-basic-info h2 {
    font-size: 20px;
  }

  .stat-value {
    font-size: 18px;
  }

  .notes-container {
    padding: 15px;
  }

  .notes-textarea {
    min-height: 100px;
  }

  .tab-btn {
    padding: 12px 15px;
    font-size: 13px;
  }

  .tab-text {
    display: none;
  }

  .slider-content {
    padding: 15px;
  }

  .view-more {
    flex-direction: column;
    gap: 10px;
    align-items: flex-start;
  }

  .add-files-btn {
    width: 100%;
    justify-content: center;
  }

  .appointment-card {
    flex-direction: column;
    align-items: flex-start;
    gap: 10px;
  }

  .appointment-icon {
    width: 35px;
    height: 35px;
    font-size: 16px;
  }

  .appointments-pagination {
    flex-direction: column;
    gap: 10px;
    align-items: flex-start;
  }

  .document-files-header {
    padding: 15px;
    flex-direction: column;
    gap: 10px;
    align-items: flex-start;
  }

  .document-files-content {
    padding: 15px;
  }

  .document-item {
    padding: 10px;
  }

  .modal-container {
    width: 95%;
    max-width: 500px;
    max-height: 85vh;
  }

  .modal-header {
    padding: 12px 15px;
  }

  .modal-header h3 {
    font-size: 16px;
  }

  .modal-body {
    padding: 15px;
    max-height: calc(85vh - 60px);
  }

  .selected-file-item {
    flex-direction: column;
    align-items: flex-start;
    gap: 10px;
  }

  .file-icon {
    width: 35px;
    height: 35px;
    font-size: 18px;
  }

  .ledger-table {
    font-size: 12px;
  }

  .ledger-table th,
  .ledger-table td {
    padding: 8px 12px;
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
    font-size: 16px;
  }

  .reset-button {
    right: 35px;
    width: 24px;
    height: 24px;
  }

  .reset-button i {
    font-size: 14px;
  }

  .filter {
    padding: 8px 15px;
    font-size: 12px;
  }

  .filter i {
    font-size: 14px;
  }

  .patient-container {
    margin: 8px;
  }

  .patient-header h3 {
    font-size: 14px;
    padding: 12px 0 8px 0;
  }

  .patient-card {
    margin-bottom: 10px;
  }

  .card-header {
    padding: 10px 12px;
  }

  .card-header h4 {
    font-size: 13px;
  }

  .patient-number {
    padding: 3px 6px;
    font-size: 11px;
  }

  .card-content {
    padding: 10px 12px;
  }

  .card-row {
    margin-bottom: 8px;
  }

  .card-label {
    font-size: 12px;
  }

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

  .details-container {
    margin: 8px;
  }

  .back-btn {
    padding: 6px 12px;
    font-size: 12px;
  }

  .patient-profile-card {
    padding: 15px;
  }

  .patient-profile-header {
    gap: 10px;
  }

  .patient-avatar {
    width: 50px;
    height: 50px;
    font-size: 24px;
  }

  .patient-basic-info h2 {
    font-size: 18px;
  }

  .patient-id,
  .patient-email {
    font-size: 12px;
  }

  .stat-value {
    font-size: 16px;
  }

  .stat-label {
    font-size: 10px;
  }

  .detail-label {
    font-size: 11px;
  }

  .detail-value {
    font-size: 13px;
  }

  .notes-container {
    padding: 12px;
  }

  .notes-container h3 {
    font-size: 16px;
  }

  .notes-textarea {
    min-height: 80px;
    font-size: 13px;
  }

  .save-btn {
    padding: 8px 15px;
    font-size: 13px;
  }

  .tab-btn {
    padding: 10px 12px;
    font-size: 12px;
  }

  .slider-content {
    padding: 12px;
  }

  .view-more a {
    font-size: 12px;
  }

  .add-files-btn {
    padding: 6px 12px;
    font-size: 12px;
  }

  .appointment-icon {
    width: 30px;
    height: 30px;
    font-size: 14px;
  }

  .appointment-details h4 {
    font-size: 14px;
  }

  .appointment-details p {
    font-size: 12px;
  }

  .document-files-header {
    padding: 12px;
  }

  .document-files-header h3 {
    font-size: 16px;
  }

  .document-files-content {
    padding: 12px;
  }

  .document-item {
    padding: 8px;
  }

  .document-item i {
    font-size: 20px;
  }

  .file-name,
  .document-name {
    font-size: 13px;
  }

  .document-size {
    font-size: 11px;
  }

  .no-documents {
    padding: 30px 15px;
  }

  .no-documents .empty-icon {
    font-size: 40px;
  }

  .no-documents p {
    font-size: 13px;
  }

  .drag-hint {
    font-size: 11px;
  }

  .modal-container {
    width: 95%;
    border-radius: 10px;
  }

  .modal-header {
    padding: 10px 12px;
  }

  .modal-header h3 {
    font-size: 14px;
  }

  .close-btn {
    font-size: 1.2em;
  }

  .modal-body {
    padding: 12px;
  }

  .selected-file-item {
    padding: 12px;
  }

  .file-icon {
    width: 30px;
    height: 30px;
    font-size: 16px;
  }

  .file-name-input label {
    font-size: 11px;
  }

  .custom-name-input {
    padding: 6px 8px;
    font-size: 13px;
  }

  .upload-type p {
    font-size: 13px;
  }

  .modal-footer {
    padding: 10px 12px;
  }

  .cancel-btn,
  .confirm-btn,
  .delete-btn {
    padding: 8px 15px;
    font-size: 13px;
  }

  .ledger-table {
    font-size: 11px;
  }

  .ledger-table th,
  .ledger-table td {
    padding: 6px 8px;
  }

  .view-id-btn {
    padding: 4px 8px;
    font-size: 12px;
  }
}

/* Landscape Mobile */
@media (max-height: 500px) and (orientation: landscape) {
  .modal-container {
    max-height: 95vh;
  }

  .modal-body {
    max-height: calc(95vh - 60px);
    overflow-y: auto;
  }

  .patient-card {
    margin-bottom: 8px;
  }
}

/* Touch-friendly improvements */
@media (hover: none) and (pointer: coarse) {
  .patient-card {
    min-height: 48px; /* Minimum touch target size */
  }

  .patient-card:active {
    transform: scale(0.98);
    transition: transform 0.1s ease;
  }

  .tab-btn {
    min-height: 44px;
    padding: 12px 16px;
  }

  .add-files-btn,
  .pagination-btn,
  .save-btn,
  .back-btn {
    min-height: 44px;
  }

  .doc-action-btn {
    min-width: 44px;
    min-height: 44px;
  }
}
</style>