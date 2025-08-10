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
          <h3>Calendar Schedule</h3>
          <div class="breadcrumbs">
            <a class="none" href=""><p>Home / </p></a>
            <a class="none" href="/hrappointments"><p>Appointments / </p></a>
            <a class="current" href="/hrcalendarschedule"><p>  Calendar Schedule</p></a>
          </div>
        </div>
      </div>
      <hr color="#06693A">
      
      <!-- Dashboard Stats -->
      <div class="dashboard-container">
        <div class="calendar-stats">
          <div class="stat-card">
            <i class="bx bx-calendar-check"></i>
            <div class="stat-info">
              <h4>{{ todayAppointments }}</h4>
              <p>Today's Appointments</p>
            </div>
          </div>
          <div class="stat-card">
            <i class="bx bx-calendar-week"></i>
            <div class="stat-info">
              <h4>{{ weekAppointments }}</h4>
              <p>This Week</p>
            </div>
          </div>
          <div class="stat-card">
            <i class="bx bx-calendar"></i>
            <div class="stat-info">
              <h4>{{ monthAppointments }}</h4>
              <p>This Month</p>
            </div>
          </div>
          <div class="stat-card action-card">
            <button @click="openNewAppointmentModal" class="new-appointment-btn">
              <i class="bx bx-plus"></i> Book an Appointment
            </button>
          </div>
        </div>

        <!-- Calendar View Controls -->
        <div class="view-controls">
          <div class="view-selector">
            <button @click="changeView('dayGridMonth')" :class="['view-btn', calendarOptions.initialView === 'dayGridMonth' ? 'active' : '']">
              <i class="bx bx-calendar"></i> Month
            </button>
            <button @click="changeView('timeGridWeek')" :class="['view-btn', calendarOptions.initialView === 'timeGridWeek' ? 'active' : '']">
              <i class="bx bx-calendar-week"></i> Week
            </button>
            <button @click="changeView('timeGridDay')" :class="['view-btn', calendarOptions.initialView === 'timeGridDay' ? 'active' : '']">
              <i class="bx bx-calendar-day"></i> Day
            </button>
          </div>
          <div class="date-navigation">
            <button @click="navigateCalendar('prev')" class="nav-btn">
              <i class="bx bx-chevron-left"></i>
            </button>
            <button @click="navigateCalendar('today')" class="today-btn">Today</button>
            <button @click="navigateCalendar('next')" class="nav-btn">
              <i class="bx bx-chevron-right"></i>
            </button>
          </div>
        </div>

        <!-- Calendar Component -->
        <div class="calendar-container">
          <!-- Calendar Header moved inside container -->
          <div class="calendar-header">
            <h2 class="calendar-title">{{ currentMonthYear }}</h2>
            <div class="calendar-actions">
              <button @click="toggleBlockMode" class="block-date-btn">
                <i class="bx bx-block"></i> {{ isBlockMode ? 'Cancel Blocking' : 'Block a Date' }}
              </button>
            </div>
          </div>
          
          <div class="legend">
            <div class="legend-item">
              <span class="legend-color completed"></span>
              <span>Completed</span>
            </div>
            <div class="legend-item">
              <span class="legend-color confirmed"></span>
              <span>Confirmed</span>
            </div>
            <div class="legend-item">
              <span class="legend-color pending"></span>
              <span>Pending</span>
            </div>
            <div class="legend-item">
              <span class="legend-color declined"></span>
              <span>Declined</span>
            </div>
            <div class="legend-item">
              <span class="legend-color cancelled"></span>
              <span>Cancelled</span>
            </div>
            <div class="legend-item">
              <span class="legend-color blocked"></span>
              <span>Blocked</span>
            </div>
          </div>
          
          <FullCalendar
            v-if="blockedDates.length >= 0"
            ref="fullCalendar"
            :key="calendarKey"
            class="hr-calendar"
            :options="calendarOptions"
          />
        </div>

        <!-- Upcoming Appointments Table - Redesigned -->
        <div class="appointments-summary">
          <div class="summary-header">
            <h3>Upcoming Appointments</h3>
            <div class="summary-actions">
              <button class="btn-refresh" @click="fetchAppointments">
                <i class="bx bx-refresh"></i> Refresh
              </button>
            </div>
          </div>
          
          <!-- Status Tabs -->
          <div class="status-tabs">
            <button 
              v-for="status in ['All', 'Confirmed', 'Completed', 'Pending', 'Declined', 'Cancelled']" 
              :key="status"
              :class="['status-tab', { active: selectedStatusTab === status }]"
              @click="selectedStatusTab = status"
            >
              {{ status }}
              <span class="status-count">{{ getAppointmentCountByStatus(status) }}</span>
            </button>
          </div>
          
          <!-- Upcoming Appointments Table -->
          <div class="summary-table-container">
            <!-- Desktop Table -->
            <table class="summary-table desktop-table">
              <thead>
                <tr>
                  <th>Date & Time</th>
                  <th>Patient</th>
                  <th>Services</th>
                  <th>Dentist</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-if="filteredAppointments.length === 0">
                  <td colspan="6" class="no-appointments">No upcoming appointments</td>
                </tr>
                <template v-for="(appointment, index) in paginatedAppointments" :key="index">
                  <tr class="appointment-row" @click="handleEventClick({event: appointment})">
                    <td>
                      <div class="appointment-date">{{ formatDate(appointment.start) }}</div>
                      <div class="appointment-time">{{ formatTime(appointment.start) }}</div>
                    </td>
                    <td>{{ appointment.extendedProps.patient_name }}</td>
                    <td>
                      <div class="services-list">
                        <span v-for="(service, i) in appointment.extendedProps.services" :key="i" class="service-tag">
                          {{ service.ServiceName }}
                        </span>
                        <span v-if="!appointment.extendedProps.services || appointment.extendedProps.services.length === 0">
                          N/A
                        </span>
                      </div>
                    </td>
                    <td>{{ appointment.extendedProps.dentist_name || 'Unassigned' }}</td>
                    <td>
                      <span class="status-badge" :class="getStatusClass(appointment.extendedProps.AppointmentStatus)">
                        {{ appointment.extendedProps.AppointmentStatus }}
                      </span>
                    </td>
                    <td>
                      <button class="btn-view" @click.stop="handleEventClick({event: appointment})">
                        <i class="bx bx-show"></i>
                      </button>
                    </td>
                  </tr>
                </template>
              </tbody>
            </table>

            <!-- Mobile Cards -->
            <div class="mobile-cards">
              <div 
                v-for="(appointment, index) in paginatedAppointments" 
                :key="index"
                class="appointment-card"
                @click="handleEventClick({event: appointment})"
              >
                <div class="card-header">
                  <h4>{{ appointment.extendedProps.patient_name }}</h4>
                  <span class="status-badge" :class="getStatusClass(appointment.extendedProps.AppointmentStatus)">
                    {{ appointment.extendedProps.AppointmentStatus }}
                  </span>
                </div>
                <div class="card-content">
                  <div class="card-row">
                    <span class="card-label">Date:</span>
                    <span>{{ formatDate(appointment.start) }}</span>
                  </div>
                  <div class="card-row">
                    <span class="card-label">Time:</span>
                    <span>{{ formatTime(appointment.start) }}</span>
                  </div>
                  <div class="card-row">
                    <span class="card-label">Services:</span>
                    <div class="services-list-mobile">
                      <span v-for="(service, i) in appointment.extendedProps.services" :key="i" class="service-tag-mobile">
                        {{ service.ServiceName }}
                      </span>
                      <span v-if="!appointment.extendedProps.services || appointment.extendedProps.services.length === 0">
                        N/A
                      </span>
                    </div>
                  </div>
                  <div class="card-row">
                    <span class="card-label">Dentist:</span>
                    <span>{{ appointment.extendedProps.dentist_name || 'Unassigned' }}</span>
                  </div>
                </div>
                <div class="card-footer">
                  <button @click.stop="handleEventClick({event: appointment})" class="btn-view-mobile">
                    <i class="bx bx-show"></i> View Details
                  </button>
                </div>
              </div>
              <div v-if="paginatedAppointments.length === 0" class="no-appointments-mobile">
                No upcoming appointments
              </div>
            </div>
          </div>
          
          <!-- Pagination Controls -->
          <div v-if="filteredAppointments.length > itemsPerPage" class="pagination-controls">
            <div class="pagination-info">
              Showing {{ Math.min(filteredAppointments.length, currentPage * itemsPerPage) }} of {{ filteredAppointments.length }} appointments
            </div>
            <div class="pagination-buttons">
              <button 
                class="pagination-btn" 
                @click="currentPage = Math.max(1, currentPage - 1)"
                :disabled="currentPage === 1"
              >
                <i class="bx bx-chevron-left"></i> Previous
              </button>
              <button 
                class="pagination-btn" 
                @click="currentPage++"
                :disabled="currentPage * itemsPerPage >= filteredAppointments.length"
              >
                Next <i class="bx bx-chevron-right"></i>
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Appointment Details Modal -->
      <div v-if="showModal" class="modal-overlay" @click="closeModal">
        <div class="modal-containers" @click.stop>
          <div class="modal-header">
            <h3>Appointment Details {{ isViewOnly ? '(View Only)' : '' }}</h3>
            <button class="modal-close" @click="closeModal">
              <i class="bx bx-x"></i>
            </button>
          </div>
          
          <div class="modal-body">
            <div class="modal-section">
              <div class="appointment-status-banner" :class="getStatusClass(selectedAppointment.status)">
                <i class="bx bx-check-circle"></i>
                {{ selectedAppointment.status }}
              </div>
            </div>
            
            <div class="modal-section">
              <h4 class="section-title">
                <i class="bx bx-time"></i> Date & Time
              </h4>
              <div class="detail-row">
                <div class="detail-item">
                  <span class="detail-label">Date:</span>
                  <span class="detail-value">{{ formatDate(selectedAppointment.AppointmentDate) }}</span>
                </div>
                <div class="detail-item">
                  <span class="detail-label">Time:</span>
                  <span class="detail-value">{{ formatTime(selectedAppointment.AppointmentTime) }}</span>
                </div>
                <div class="detail-item" v-if="selectedAppointment.EndTime">
                  <span class="detail-label">End Time:</span>
                  <span class="detail-value">{{ formatTime(selectedAppointment.EndTime) }}</span>
                </div>
              </div>
            </div>
            
            <div class="modal-section">
              <h4 class="section-title">
                <i class="bx bx-user"></i> Patient Information
              </h4>
              <div class="detail-row">
                <div class="detail-item">
                  <span class="detail-label">Name:</span>
                  <span class="detail-value">{{ selectedAppointment.patient_name }}</span>
                </div>
              </div>
            </div>
            
            <!-- Services Section - Modified to support view-only mode -->
            <div class="modal-section">
              <h4 class="section-title">
                <i class="bx bx-clipboard"></i> Services
              </h4>
              <div v-if="selectedAppointment.services && selectedAppointment.services.length > 0">
                <div v-for="(service, index) in selectedAppointment.services" :key="service.ServiceAvailedID || `new-${index}`" class="service-detail">
                  <div class="service-header">
                    <div class="service-name">{{ service.ServiceName }}</div>
                    <div class="service-actions">
                      <div class="status-badge" :class="getStatusClass(service.Status || 'Pending')">
                        {{ service.Status || 'Pending' }}
                      </div>
                      <button 
                        v-if="!isViewOnly"
                        @click="deleteService(index)" 
                        :disabled="selectedAppointment.services.length <= 1"
                        class="btn-delete"
                        title="Delete Service"
                      >
                        <i class="bx bx-trash"></i>
                      </button>
                    </div>
                  </div>
                  <!-- Service controls - hidden in view-only mode -->
                  <div class="service-controls" v-if="!isViewOnly">
                    <div class="service-status">
                      <label>Update Status:</label>
                      <select v-model="service.Status" @change="markAsEdited" class="form-select">
                        <option value="Pending">Pending</option>
                        <option value="Completed">Completed</option>
                        <!-- <option value="Cancelled">Cancelled</option> -->
                      </select>
                    </div>
                  </div>
                </div>
                <!-- Add service section - hidden in view-only mode -->
                <div class="add-service" v-if="!isViewOnly">
                  <label>Add Service:</label>
                  <select v-model="newServiceId" @change="addService" class="form-select">
                    <option value="" disabled>Select a service</option>
                    <option v-for="service in services" :key="service.ServiceID" :value="service.ServiceID">
                      {{ service.ServiceName }}
                    </option>
                  </select>
                </div>
              </div>
              <div v-else class="no-services">No services available</div>
            </div>
            
            <!-- Treatment Progress Section -->
            <div v-if="selectedAppointment.visitProgress" class="modal-section">
              <h4 class="section-title">
                <i class="bx bx-line-chart"></i> Treatment Progress
              </h4>
              <div class="detail-row">
                <div class="detail-item">
                  <span class="detail-label">Started On:</span>
                  <span class="detail-value">{{ formatDate(selectedAppointment.visitProgress.StartDate) || 'N/A' }}</span>
                </div>
                <div class="detail-item">
                  <span class="detail-label">Ended On:</span>
                  <span class="detail-value">{{ formatDate(selectedAppointment.visitProgress.EndDate) || 'N/A' }}</span>
                </div>
              </div>
              <div class="detail-row">
                <div class="detail-item">
                  <span class="detail-label">Total Visits:</span>
                  <span class="detail-value">{{ selectedAppointment.visitProgress.VisitCount }}</span>
                </div>
                <div class="detail-item">
                  <span class="detail-label">Treatment Status:</span>
                  <span v-if="isViewOnly" class="detail-value">{{ selectedAppointment.treatmentProgressStatus }}</span>
                  <select v-else v-model="selectedAppointment.treatmentProgressStatus" @change="markAsEdited" class="form-select">
                    <option value="In Progress">In Progress</option>
                    <option value="Completed">Completed</option>
                    <option value="Cancelled">Cancelled</option>
                  </select>
                </div>
              </div>
            </div>
            
            <!-- Dentist Assignment Section - Modified to support view-only mode -->
            <div class="modal-section">
              <h4 class="section-title">
                <i class="bx bx-user-pin"></i> Dentist Assignment
              </h4>
              <div class="detail-row">
                <div class="detail-item">
                  <span class="detail-label">Current Dentist:</span>
                  <span class="detail-value">{{ selectedAppointment.dentist_name || 'Unassigned' }}</span>
                </div>
                <div class="detail-item" v-if="!isViewOnly">
                  <span class="detail-label">Assign Dentist:</span>
                  <select v-model="selectedDentistId" class="form-select" @change="markAsEdited">
                    <option value="" disabled>Select a dentist</option>
                    <option v-for="dentist in filteredDentists" :key="dentist.id" :value="dentist.id">
                      {{ dentist.name }}
                    </option>
                  </select>
                  <small v-if="!selectedAppointment.UserID && !selectedDentistId && isEdited" class="text-danger">
                    A specific dentist must be assigned to update the status.
                  </small>
                </div>
              </div>
            </div>
            
            <!-- Notes Section -->
            <div class="modal-section" v-if="selectedAppointment.patient_notes">
              <h4 class="section-title">
                <i class="bx bx-note"></i> Notes
              </h4>
              <div class="notes-container">
                {{ selectedAppointment.patient_notes }}
              </div>
            </div>
          </div>
          
          <div class="modal-footer">
            <button class="btn-secondary" @click="closeModal">Close</button>
            
            <!-- Accept/Decline buttons for pending appointments - hidden in view-only mode -->
            <div v-if="selectedAppointment.status === 'Pending' && !isViewOnly" class="action-buttons">
              <button 
                @click="declineAppointment(selectedAppointment.id)" 
                class="btn-decline"
              >
                <i class='bx bx-x'></i> Decline
              </button>
              <button 
                @click="confirmAppointment(selectedAppointment.id)" 
                :disabled="!selectedDentistId && !selectedAppointment.UserID"
                class="btn-accept"
                :class="{ 'disabled-button': !selectedDentistId && !selectedAppointment.UserID }"
              >
                <i class='bx bx-check'></i> Accept
              </button>
            </div>
            
            <!-- Save Changes button - hidden in view-only mode -->
            <button v-if="!isViewOnly && selectedAppointment.status !== 'Pending'" class="btn-primary" @click="saveChanges" :disabled="!isEdited">Save Changes</button>
          </div>
        </div>
      </div>

      <!-- New Appointment Modal -->
      <div v-if="showNewAppointmentModal" class="modal-overlay" @click="closeNewAppointmentModal">
        <div class="modal-containers new-appointment-modal" @click.stop>
          <div class="modal-header">
            <h3>Book New Appointment</h3>
            <button class="modal-close" @click="closeNewAppointmentModal">
              <i class="bx bx-x"></i>
            </button>
          </div>
          
          <div class="modal-body">
            <!-- Step indicator -->
            <div class="steps-container">
              <div 
                v-for="(step, index) in ['Patient & Date', 'Services', 'Confirmation']" 
                :key="index"
                :class="['step', { active: currentStep === index + 1, completed: currentStep > index + 1 }]"
              >
                <div class="step-number">{{ index + 1 }}</div>
                <div class="step-label">{{ step }}</div>
              </div>
            </div>
            
            <!-- Step 1: Patient and Date Selection -->
            <div v-if="currentStep === 1" class="step-content">
              <div class="form-group">
                <label>Select Patient</label>
                <select v-model="newAppointment.patientId" class="form-select">
                  <option value="">Select a patient</option>
                  <option v-for="patient in patients" :key="patient.PatientID" :value="patient.PatientID">
                    {{ patient.PatientID }} - {{ patient.name }}
                  </option>
                </select>
              </div>
              
              <div class="form-group">
                <label>Select Date</label>
                <input 
                  type="date" 
                  v-model="newAppointment.date" 
                  class="form-input"
                  :min="minDate"
                >
                <div v-if="isDateBlocked(newAppointment.date)" class="alert alert-danger">
                  <i class="bx bx-exclamation-circle"></i>
                  This date is blocked and cannot be booked.
                </div>
              </div>
              
              <div v-if="newAppointment.date" class="form-group">
                <label>Select Time</label>
                <div class="time-slots">
                  <button 
                    v-for="time in availableTimes" 
                    :key="time.time"
                    :class="['time-slot', { selected: newAppointment.time === time.time, disabled: !time.is_available }]"
                    @click="selectTime(time.time)"
                    :disabled="!time.is_available"
                  >
                    {{ formatTimeDisplay(time.time) }}
                  </button>
                </div>
              </div>
            </div>
            
            <!-- Step 2: Service Selection -->
            <div v-if="currentStep === 2" class="step-content">
              <div class="form-group">
                <label>Select Services</label>
                <div class="services-list-selection">
                  <div 
                    v-for="service in services" 
                    :key="service.ServiceID"
                    :class="['service-card', { selected: newAppointment.services.includes(service.ServiceID) }]"
                    @click="toggleService(service.ServiceID)"
                  >
                    <div class="service-details">
                      <div class="service-name">{{ service.ServiceName }}</div>
                      <!-- <div class="service-cost">₱{{ service.Cost }}</div> -->
                      <div v-if="service.IsMultiVisit" class="service-badge multi-visit">Multi-visit</div>
                    </div>
                    <div class="service-checkbox">
                      <i v-if="newAppointment.services.includes(service.ServiceID)" class='bx bx-check'></i>
                    </div>
                  </div>
                </div>
              </div>
              
              <div v-if="newAppointment.services.length > 0" class="selected-services">
                <h4>Selected Services</h4>
                <div v-for="serviceId in newAppointment.services" :key="serviceId" class="selected-service">
                  <span>{{ getServiceName(serviceId) }}</span>
                  <span>₱{{ getServiceCost(serviceId) }}</span>
                </div>
                <div class="total-cost">
                  <span>Total</span>
                  <span>₱{{ calculateTotalCost() }}</span>
                </div>
              </div>
              <br>
              <div class="form-group">
                <label>Additional Notes</label>
                <textarea 
                  v-model="newAppointment.notes" 
                  class="form-textarea" 
                  placeholder="Enter any additional notes or special requests"
                ></textarea>
              </div>
            </div>
            
            <!-- Step 3: Dentist Selection & Confirmation -->
            <div v-if="currentStep === 3" class="step-content">
              <div class="form-group">
                <label>Select Dentist</label>
                <select v-model="newAppointment.dentistId" class="form-select">
                  <option value="any">Any Available Dentist</option>
                  <option v-if="filteredDentists.length === 0" disabled>No available dentists</option>
                  <option v-for="dentist in filteredDentists" :key="dentist.id" :value="dentist.id">
                    {{ dentist.name }}
                  </option>
                </select>
              </div>
              <div class="appointment-summary">
                <h4>Appointment Summary</h4>
                <div class="summary-item">
                  <span class="summary-label">Patient:</span>
                  <span>{{ getPatientName(newAppointment.patientId) }}</span>
                </div>
                <div class="summary-item">
                  <span class="summary-label">Date & Time:</span>
                  <span>{{ formatDate(newAppointment.date) }} at {{ formatTimeDisplay(newAppointment.time) }}</span>
                </div>
                <div class="summary-item">
                  <span class="summary-label">Dentist:</span>
                  <span>{{ newAppointment.dentistId === 'any' ? 'Any Available Dentist' : getDentistName(newAppointment.dentistId) }}</span>
                </div>
                <div class="summary-item">
                  <span class="summary-label">Services:</span>
                  <ul class="services-summary">
                    <li v-for="serviceId in newAppointment.services" :key="serviceId">
                      {{ getServiceName(serviceId) }}
                    </li>
                  </ul>
                </div>
                <!-- <div class="summary-item total">
                  <span class="summary-label">Total Cost:</span>
                  <span>₱{{ calculateTotalCost() }}</span>
                </div> -->
                <div v-if="newAppointment.notes" class="summary-item">
                  <span class="summary-label">Additional Notes:</span>
                  <p class="notes-text">{{ newAppointment.notes}}</p>
                </div>
              </div>
            </div>
          </div>
          
          <div class="modal-footer">
            <button 
              v-if="currentStep > 1" 
              class="btn-secondary" 
              @click="currentStep--"
            >
              <i class="bx bx-arrow-back"></i> Back
            </button>
            <button 
              v-else 
              class="btn-secondary" 
              @click="closeNewAppointmentModal"
            >
              <i class="bx bx-x"></i> Cancel
            </button>
            
            <button 
              v-if="currentStep < 3" 
              class="btn-primary" 
              @click="nextStep"
              :disabled="!canProceedToNextStep"
            >
              Next <i class="bx bx-arrow-right"></i>
            </button>
            <button 
              v-else 
              class="btn-primary" 
              @click="bookAppointment"
              :disabled="isBooking"
            >
              <i class="bx bx-check"></i> {{ isBooking ? 'Booking...' : 'Book Appointment' }}
            </button>
          </div>
        </div>
      </div>

      <!-- Decline Modal -->
      <div v-if="showDeclineModal" class="modal-overlay" @click="closeDeclineModal">
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
                <h4>{{ appointmentToDecline.patient_name || 'Patient' }}</h4>
                <p>{{ formatDate(appointmentToDecline.AppointmentDate) }} at {{ formatTime(appointmentToDecline.AppointmentTime) }}</p>
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

      <!-- Status Notification Popup for Confirmation -->
      <div class="status-notification" v-if="showConfirmNotification">
        <div class="notification-content status-confirmed">
          <i class="bx bx-check-circle"></i>
          <span>The appointment of {{ confirmAppointmentData?.patient_name || 'N/A' }} has been confirmed.</span>
        </div>
      </div>

      <!-- Status Notification Popup for Decline -->
      <div class="status-notification" v-if="showDeclineNotification">
        <div class="notification-content status-declined">
          <i class="bx bx-x-circle"></i>
          <span>The appointment of {{ declineAppointmentData?.patient_name || 'N/A' }} has been declined.</span>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import axios from "axios";
import FullCalendar from '@fullcalendar/vue3';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';
import Swal from 'sweetalert2';

export default {
  name: "HRCalendarSchedule",
  components: { FullCalendar },
  props: {
    firstName: { type: String, required: true },
    lastName: { type: String, required: true },
  },
  data() {
    return {
      calendarKey: 0,
      isViewOnly: false,
      newServiceId: '',
      selectedAppointment: { services: [] },
      showModal: false,
      isEdited: false,
      showDentistAssignmentModal: false,
      selectedDentistId: '',
      availableDentists: [],
      unavailableDentists: [],
      showNewAppointmentModal: false,
      currentStep: 1,
      patients: [],
      services: [],
      availableTimes: [],
      isBooking: false,
      newAppointment: {
        patientId: '',
        date: '',
        time: '',
        dentistId: 'any',
        services: [],
        notes: ''
      },
      currentMonthYear: '',
      selectedStatusTab: 'All',
      currentPage: 1,
      itemsPerPage: 10,
      calendarOptions: {
        plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
        initialView: 'dayGridMonth',
        headerToolbar: false,
        events: [],
        eventClick: this.handleEventClick,
        dateClick: this.handleDateClick,
        displayEventTime: true,
        height: 'auto',
        contentHeight: 'auto',
        themeSystem: 'standard',
        eventTimeFormat: { hour: '2-digit', minute: '2-digit', meridiem: 'short' },
        eventDisplay: 'block',
        eventBorderColor: 'transparent',
        eventTextColor: '#ffffff',
        dayMaxEvents: 1,
        nowIndicator: true,
        slotMinTime: '08:00:00',
        slotMaxTime: '18:00:00',
        slotDuration: '00:30:00',
        allDaySlot: false,
        slotLabelFormat: { hour: 'numeric', minute: '2-digit', omitZeroMinute: false, meridiem: 'short' },
        datesSet: this.handleDatesSet,
        eventDidMount: this.eventDidMount,
        dayCellDidMount: (info) => {
  const dateStr = info.date.toISOString().split('T')[0];
  const today = new Date();
  today.setHours(0, 0, 0, 0);

  console.log("Checking date:", dateStr);
  console.log("Blocked dates:", this.blockedDates);

  if (this.blockedDates.includes(dateStr)) {
    console.log("Date is blocked:", dateStr);
    info.el.classList.add('fc-day-blocked');
    this.getBlockReason(dateStr).then(reason => {
      if (reason) {
        const tooltip = document.createElement('div');
        tooltip.className = 'blocked-date-tooltip';
        tooltip.textContent = reason;
        info.el.addEventListener('mouseenter', () => {
          document.body.appendChild(tooltip);
          const rect = info.el.getBoundingClientRect();
          tooltip.style.position = 'absolute';
          tooltip.style.left = `${rect.left + window.scrollX}px`;
          tooltip.style.top = `${rect.bottom + window.scrollY + 5}px`;
          tooltip.style.zIndex = 1000;
        });
        info.el.addEventListener('mouseleave', () => {
          if (document.body.contains(tooltip)) document.body.removeChild(tooltip);
        });
      }
    });
  }

  // Additional logic for Sundays and past dates
  if (info.date.getDay() === 0) {
    info.el.classList.add('sunday-blocked');
  }

  if (info.date < today) {
    info.el.classList.add('past-date');
  }

  // Hover effects
  info.el.addEventListener('mouseenter', () => info.el.classList.add('day-cell-hover'));
  info.el.addEventListener('mouseleave', () => info.el.classList.remove('day-cell-hover'));
},
        dayHeaderDidMount: this.dayHeaderDidMount,
        eventContent: function(arg) {
          const services = arg.event.extendedProps.services?.length > 0 
            ? arg.event.extendedProps.services.map(s => s.ServiceName).join(', ') 
            : 'No Services';
          const status = arg.event.extendedProps.AppointmentStatus || 'Pending';
          
          // Format the start time
          const startTime = new Date(arg.event.start).toLocaleTimeString('en-US', { 
            hour: '2-digit', 
            minute: '2-digit', 
            hour12: true 
          });
          
          // Format the end time (subtract 1 minute to show "12:59 PM" instead of "1:00 PM")
          let endTime = 'N/A';
          if (arg.event.end) {
            const adjustedEndTime = new Date(arg.event.end);
            adjustedEndTime.setMinutes(adjustedEndTime.getMinutes() - 1); // Subtract 1 minute
            endTime = adjustedEndTime.toLocaleTimeString('en-US', { 
              hour: '2-digit', 
              minute: '2-digit', 
              hour12: true 
            });
          }
          
          return { 
            html: `<div class="fc-event-content">
              <b>${arg.event.extendedProps.patient_name}</b>
              <div class="fc-event-time">${startTime}</div>
              <div class="fc-event-services">${services}</div>
              <div class="fc-event-status">${status}</div>
            </div>` 
          };
        },
      },
      blockedDates: [],
      blockedDateReasons: {},
      isBlockMode: false,
      blockReason: '',
      isBlocking: false,
      // New properties for accept/decline functionality
      showDeclineModal: false,
      declineReason: '',
      appointmentToDecline: null,
      showConfirmNotification: false,
      showDeclineNotification: false,
      confirmAppointmentData: null,
      declineAppointmentData: null,
    };
  },
  computed: {
    fullName() {
      return `${this.firstName} ${this.lastName}`;
    },
    
    filteredDentists() {
      // Return all dentists, only filtering those who have appointments at the selected time
      // This will be handled by the checkDentistAvailabilityForTime method
      // console.log('Filtered Dentists:', this.availableDentists);
      return this.availableDentists.filter(dentist => 
          !this.unavailableDentists.includes(String(dentist.id))
      );
    },
    
    calculatedAppointmentStatus() {
      if (!this.selectedAppointment?.services?.length) return 'Pending';
      const statuses = this.selectedAppointment.services.map(s => s.Status);
      if (statuses.every(s => s === 'Completed')) return 'Completed';
      if (statuses.every(s => s === 'Cancelled')) return 'Cancelled';
      if (statuses.some(s => s === 'Completed')) return 'Completed';
      return this.selectedAppointment.status || 'Pending';
    },
    isSaveDisabled() {
      return this.selectedAppointment?.status?.toLowerCase() === 'completed' || !this.isEdited;
    },
    minDate() {
  const today = new Date();
  return today.toISOString().split('T')[0];
},
    canProceedToNextStep() {
      if (this.currentStep === 1) {
        return this.newAppointment.patientId && 
              this.newAppointment.date && 
              this.newAppointment.time && 
              !this.isDateBlocked(this.newAppointment.date);
      } else if (this.currentStep === 2) {
        return this.newAppointment.services.length > 0;
      }
      return true;
    },
    todayAppointments() {
      const today = new Date();
      today.setHours(0, 0, 0, 0);
      const tomorrow = new Date(today);
      tomorrow.setDate(tomorrow.getDate() + 1);
      
      // Filter out cancelled, declined, and pending appointments
      return this.calendarOptions.events.filter(event => {
        const eventDate = new Date(event.start);
        const isToday = eventDate >= today && eventDate < tomorrow;
        const status = event.extendedProps.AppointmentStatus?.toLowerCase();
        return isToday && status !== 'cancelled' && status !== 'declined' && status !== 'pending';
      }).length;
    },
    
    weekAppointments() {
      const today = new Date();
      today.setHours(0, 0, 0, 0);
      const startOfWeek = new Date(today);
      startOfWeek.setDate(today.getDate() - today.getDay());
      const endOfWeek = new Date(startOfWeek);
      endOfWeek.setDate(startOfWeek.getDate() + 7);
      
      // Filter out cancelled, declined, and pending appointments
      return this.calendarOptions.events.filter(event => {
        const eventDate = new Date(event.start);
        const status = event.extendedProps.AppointmentStatus?.toLowerCase();
        return eventDate >= startOfWeek && eventDate < endOfWeek && 
              status !== 'cancelled' && status !== 'declined' && status !== 'pending';
      }).length;
    },
    
    monthAppointments() {
      const today = new Date();
      const startOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
      const endOfMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0);
      
      // Filter out cancelled, declined, and pending appointments
      return this.calendarOptions.events.filter(event => {
        const eventDate = new Date(event.start);
        const status = event.extendedProps.AppointmentStatus?.toLowerCase();
        return eventDate >= startOfMonth && eventDate <= endOfMonth && 
              status !== 'cancelled' && status !== 'declined' && status !== 'pending';
      }).length;
    },
    sortedAppointments() {
      return [...this.calendarOptions.events]
        .filter(event => new Date(event.start) >= new Date())
        .sort((a, b) => {
          const statusPriority = { 'confirmed': 1, 'pending': 2, 'completed': 3, 'cancelled': 4, 'declined': 5 };
          const priorityA = statusPriority[a.extendedProps.AppointmentStatus?.toLowerCase()] || 99;
          const priorityB = statusPriority[b.extendedProps.AppointmentStatus?.toLowerCase()] || 99;
          if (priorityA !== priorityB) return priorityA - priorityB;
          return new Date(a.start) - new Date(b.start);
        });
    },
    filteredAppointments() {
      if (this.selectedStatusTab === 'All') return this.sortedAppointments;
      return this.sortedAppointments.filter(appointment => appointment.extendedProps.AppointmentStatus === this.selectedStatusTab);
    },
    paginatedAppointments() {
      const startIndex = (this.currentPage - 1) * this.itemsPerPage;
      const endIndex = startIndex + this.itemsPerPage;
      return this.filteredAppointments.slice(startIndex, endIndex);
    },
    isDateBlocked() {
      return (date) => {
        if (!date) return false;
        const dateStr = new Date(date).toISOString().split('T')[0];
        return this.blockedDates.includes(dateStr);
      };
    },
  },
  watch: {
    calculatedAppointmentStatus(newStatus) {
      if (this.selectedAppointment) {
        this.selectedAppointment.status = newStatus;
        this.markAsEdited();
      }
    },
    'newAppointment.date': {
      handler(newDate) {
        if (newDate && this.isDateBlocked(newDate)) {
          this.newAppointment.time = '';
        }
        if (newDate) {
          this.generateAvailableTimes();
          this.checkDentistAvailability(newDate);
        }
      },
      immediate: true,
    },
    selectedStatusTab() {
      this.currentPage = 1;
    }
  },
  mounted() {
    this.fetchServices();
    const arrows = document.querySelectorAll(".arrow");
    arrows.forEach(arrow => {
      arrow.addEventListener("click", (e) => {
        const arrowParent = e.target.closest("li");
        if (arrowParent) arrowParent.classList.toggle("showMenu");
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
    this.fetchDentists();
    this.updateCurrentMonthYear();
    document.addEventListener('keydown', this.handleKeyDown);
    this.fetchBlockedDates();
  },
  beforeUnmount() {
    document.removeEventListener('keydown', this.handleKeyDown);
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
    async getBlockReason(dateStr) {
      // Check if the reason for this date is already known
      if (this.blockedDateReasons[dateStr]) {
        return this.blockedDateReasons[dateStr];
      }

      // Check if the date is already blocked
      if (this.blockedDates.includes(dateStr)) {
        return "This date is already blocked.";
      }

      try {
        const response = await axios.post('/appointments/block-date', {
          date: dateStr,
          reason: "Fetching block reason" // Optional reason
        });

        if (response.data && response.data.reason) {
          this.blockedDateReasons[dateStr] = response.data.reason;
          return response.data.reason;
        }
        return "Date is blocked";
      } catch (error) {
        if (error.response && error.response.data && error.response.data.message) {
          this.blockedDateReasons[dateStr] = error.response.data.message;
          return error.response.data.message;
        }
        console.error('Error fetching block reason:', error);
        return "Date is blocked";
      }
    },

    openDentistAssignmentModal(appointment) {
      this.selectedAppointment = appointment;
      this.selectedDentistId = appointment.UserID || '';
      this.showDentistAssignmentModal = true;
      this.fetchDentists();
    },
    async assignDentist() {
      if (!this.selectedDentistId) {
        Swal.fire('Error', 'Please select a dentist to assign.', 'error');
        return;
      }
      try {
        const response = await axios.post('/assign-dentist', {
          AppointmentID: this.selectedAppointment.AppointmentID,
          UserID: parseInt(this.selectedDentistId),
        });
        Swal.fire({
          title: 'Success',
          text: 'Dentist assigned successfully!',
          icon: 'success',
          showConfirmButton: false,
          timer: 1500
        });
        this.showDentistAssignmentModal = false;
        this.fetchAppointments();
      } catch (error) {
        console.error('Error assigning dentist:', error.response?.data || error);
        Swal.fire('Error', 'Failed to assign dentist: ' + (error.response?.data?.message || error.message), 'error');
      }
    },
    getAppointmentCountByStatus(status) {
      if (status === 'All') return this.sortedAppointments.length;
      return this.sortedAppointments.filter(appointment => appointment.extendedProps.AppointmentStatus === status).length;
    },
    formatDate(dateString) {
      if (!dateString) return 'N/A';
      return new Date(dateString).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
    },
    formatTime(timeString) {
      if (!timeString) return 'N/A';
      const [hours, minutes] = timeString.split(':');
      const hour = parseInt(hours, 10);
      const ampm = hour >= 12 ? 'PM' : 'AM';
      const hour12 = hour % 12 || 12;
      return `${hour12}:${minutes} ${ampm}`;
    },
    formatTimeDisplay(time) {
      if (!time) return '';
      const [hours, minutes] = time.split(':');
      const hour = parseInt(hours, 10);
      const ampm = hour >= 12 ? 'PM' : 'AM';
      const hour12 = hour % 12 || 12;
      return `${hour12}:${minutes} ${ampm}`;
    },
    getStatusClass(status) {
      if (!status) return "status-pending";
      switch (status.toLowerCase()) {
        case "completed": return "status-completed";
        case "confirmed": return "status-confirmed";
        case "pending": return "status-pending";
        case "declined": return "status-declined";
        case "cancelled": return "status-cancelled";
        default: return "status-pending";
      }
    },
    getStatusColor(status) {
      if (!status) return "#6c757d";
      switch (status.toLowerCase()) {
        case "completed": return "#28a745";
        case "confirmed": return "#007bff";
        case "pending": return "#6c757d";
        case "declined": return "#ff6b6b";
        case "cancelled": return "#dc3545";
        default: return "#6c757d";
      }
    },
    async fetchAppointments() {
      try {
        const response = await axios.get('/hr/appointments/calendar');
        this.calendarOptions.events = response.data.map(event => {
          if (!event.AppointmentDate || !event.AppointmentTime) return null;
          const services = event.services || [];
          const mappedServices = services.map(s => ({
            ServiceName: s.ServiceName || 'Unknown Service',
            ServiceAvailedID: s.ServiceAvailedID || null,
            Status: s.Status || 'Pending',
          }));
          const title = `${event.patient_name} - ${services.length > 0 ? services.map(s => s.ServiceName).join(', ') : 'No Services'}`;
          const status = event.AppointmentStatus?.toLowerCase() || 'pending';
          
          return {
            id: event.AppointmentID,
            title,
            start: `${event.AppointmentDate}T${event.AppointmentTime}`,
            end: event.EndTime ? `${event.AppointmentDate}T${event.EndTime}` : null,
            classNames: [`status-${status}`], // Apply status class for color
            backgroundColor: this.getStatusColor(event.AppointmentStatus), // Set background color based on status
            extendedProps: {
              patient_name: event.patient_name || 'Unknown',
              patient_notes: event.PatientNote || 'No notes available',
              dentist_name: event.dentist_name || 'Unassigned',
              dentist_id: event.UserID || null,
              AppointmentStatus: event.AppointmentStatus || 'Pending',
              services: mappedServices,
              visitProgress: event.visitProgress || null,
              AppointmentDate: event.AppointmentDate,
              AppointmentTime: event.AppointmentTime,
              EndTime: event.EndTime || null,
            },
            textColor: '#ffffff',
          };
        }).filter(event => event !== null);
        this.calendarOptions.events = [...this.calendarOptions.events];
        await this.fetchBlockedDates();
      } catch (error) {
        console.error("Error fetching appointments:", error.response?.data || error.message);
        this.calendarOptions.events = [];
      }
    },
    async fetchDentists() {
      try {
        const response = await axios.get('/hr/dentist-mapping');
        this.availableDentists = response.data.map(dentist => ({
          id: dentist.UserID,
          dentistId: dentist.DentistID,
          name: `${dentist.FirstName} ${dentist.LastName}`.trim() || 'Unnamed Dentist',
        }));
        // console.log('Fetched Dentists:', this.availableDentists);
      } catch (error) {
        console.error('Error fetching dentists:', error);
      }
    },
    
    async checkDentistAvailability(date) {
  if (!date) return;
  
  try {
    // Get unavailable dentists for the selected date
    const response = await axios.get(`/hr/dentist-availability/${date}`);
    
    // Extract dentist IDs who are unavailable due to day-off
    const unavailableDentistIDs = response.data.unavailable_dentists || [];
    // console.log('Unavailable dentists due to day-off on', date, ':', unavailableDentistIDs);
    
    // Convert dentist IDs to user IDs for filtering
    const unavailableUserIDs = [];
    unavailableDentistIDs.forEach(dentistId => {
      const dentist = this.availableDentists.find(d => String(d.dentistId) === String(dentistId));
      if (dentist && !unavailableUserIDs.includes(String(dentist.id))) {
        unavailableUserIDs.push(String(dentist.id));
      }
    });
    
    this.unavailableDentists = unavailableUserIDs;
    // console.log('Updated unavailable dentists (UserIDs):', this.unavailableDentists);
  } catch (error) {
    console.error('Error checking dentist availability:', error);
    this.unavailableDentists = [];
  }
},
    
    // Add a new method to check dentist availability for a specific time
    async checkDentistAvailabilityForTime(date, time) {
      if (!date || !time) return;
      
      try {
        // Get all appointments for the selected date and time
        const response = await axios.get('/appointments/time-availability', {
          params: {
            date: date,
            time: time
          }
        });
        
        // Extract dentist IDs who already have appointments at this time
        const busyDentistIDs = response.data.busy_dentists || [];
        // console.log('Busy dentists at', time, 'on', date, ':', busyDentistIDs);
        
        // Update the unavailableDentists array to include busy dentists
        const unavailableDentists = [];
        
        // Add busy dentists to the unavailableDentists array
        busyDentistIDs.forEach(dentistId => {
          const dentist = this.availableDentists.find(d => String(d.dentistId) === String(dentistId));
          if (dentist && !unavailableDentists.includes(String(dentist.id))) {
            unavailableDentists.push(String(dentist.id));
          }
        });
        
        this.unavailableDentists = unavailableDentists;
        // console.log('Updated unavailable dentists:', this.unavailableDentists);
      } catch (error) {
        console.error('Error checking dentist availability for time:', error);
      }
    },
    
    // Modify the handleEventClick method to only check time availability
    async handleEventClick(info) {
      const event = info.event;
      const extendedProps = event.extendedProps;
      const services = extendedProps.services || [];
      
      this.selectedAppointment = {
        id: event.id,
        patient_name: extendedProps.patient_name || "Unknown",
        UserID: extendedProps.dentist_id || null,
        original_UserID: extendedProps.dentist_id || null,
        dentist_name: extendedProps.dentist_name || "Unassigned",
        patient_notes: extendedProps.patient_notes || "No notes available",
        status: extendedProps.AppointmentStatus || "Pending",
        services: services.map(s => ({
          ServiceName: s.ServiceName || 'Unknown Service',
          ServiceID: s.ServiceID || null,
          ServiceAvailedID: s.ServiceAvailedID || null,
          Status: s.Status || 'Pending',
        })),
        visitProgress: extendedProps.visitProgress || null,
        treatmentProgressStatus: extendedProps.visitProgress?.Status || "In Progress",
        AppointmentDate: extendedProps.AppointmentDate,
        AppointmentTime: extendedProps.AppointmentTime,
        EndTime: extendedProps.EndTime || null,
      };
      
      this.unavailableDentists = [];
      // Only check time availability, not day-off
      await this.checkDentistAvailabilityForTime(extendedProps.AppointmentDate, extendedProps.AppointmentTime);
      
      this.selectedDentistId = this.selectedAppointment.UserID ? String(this.selectedAppointment.UserID) : '';
      
      // Check if this appointment should be view-only
      // If it  : '';
      
      // Check if this appointment should be view-only
      // If it has a dentist assigned AND all services are not pending, set to view-only
      const hasDentist = this.selectedAppointment.UserID || this.selectedDentistId;
      const allServicesNotPending = this.selectedAppointment.services.every(service => 
        service.Status.toLowerCase() !== 'pending'
      );
      
      this.isViewOnly = hasDentist && allServicesNotPending;
      
      this.showModal = true;
      document.body.style.overflow = 'hidden';
    },
    
    // Update the openNewAppointmentModal method to reset unavailableDentists
    openNewAppointmentModal() {
      this.showNewAppointmentModal = true;
      this.currentStep = 1;
      this.resetNewAppointmentForm();
      this.fetchPatients();
      this.fetchServices();
      this.unavailableDentists = []; // Reset unavailable dentists
      document.body.style.overflow = 'hidden';
    },
    
    selectTime(time) {
  const slot = this.availableTimes.find(slot => slot.time === time);
  if (slot && slot.is_available) {
    this.newAppointment.time = time;
    
    // Check both day-off and time availability
    if (this.newAppointment.date) {
      this.checkDentistAvailability(this.newAppointment.date);
      this.checkDentistAvailabilityForTime(this.newAppointment.date, time);
    }
  }
},
    
    // Update the nextStep method to check dentist availability when moving to step 3
    nextStep() {
  if (this.currentStep === 1) {
    if (!this.newAppointment.patientId || !this.newAppointment.date || !this.newAppointment.time) {
      Swal.fire('Error', 'Please select a patient, date, and time.', 'error');
      return;
    }
    
    // Check both day-off and time availability
    this.checkDentistAvailability(this.newAppointment.date);
    this.checkDentistAvailabilityForTime(this.newAppointment.date, this.newAppointment.time);
  } else if (this.currentStep === 2) {
    if (this.newAppointment.services.length === 0) {
      Swal.fire('Error', 'Please select at least one service.', 'error');
      return;
    }
    
    // Check both day-off and time availability
    this.checkDentistAvailability(this.newAppointment.date);
    this.checkDentistAvailabilityForTime(this.newAppointment.date, this.newAppointment.time);
  }
  this.currentStep++;
},
    
    async saveChanges() {
      if (!this.isEdited) return;

      const userIdToAssign = this.selectedDentistId || this.selectedAppointment.UserID;

      // Check if a dentist is assigned
      const hasDentist = userIdToAssign ? true : false;

      // Check if all services are not in pending status
      const allServicesNotPending = this.selectedAppointment.services.every(service => 
        service.Status.toLowerCase() !== 'pending'
      );

      // Check if we're trying to save as "completed" but have pending services
      const tryingToCompleteWithPendingServices = 
        this.calculatedAppointmentStatus.toLowerCase() === 'completed' && 
        !allServicesNotPending;

      if (tryingToCompleteWithPendingServices) {
        Swal.fire({
          title: 'Cannot Complete',
          text: 'All services must be completed before the appointment can be marked as completed.',
          icon: 'warning',
          confirmButtonColor: '#06693A',
        });
        return;
      }

      // Prepare the payload
      const servicesData = this.selectedAppointment.services.map(service => ({
        ServiceAvailedID: service.ServiceAvailedID || null,
        ServiceID: service.ServiceAvailedID ? null : service.ServiceID,
        Status: service.Status || 'Pending',
      }));

      const payload = {
        status: this.calculatedAppointmentStatus,
        user_id: userIdToAssign ? parseInt(userIdToAssign) : null,
        patient_notes: this.selectedAppointment.patient_notes,
        services: servicesData,
        confirmSave: false,
      };

      try {
        // Handle treatment progress if it exists
        if (this.selectedAppointment.visitProgress) {
          const treatmentProgressPayload = {
            TreatmentProgressID: this.selectedAppointment.visitProgress.TreatmentProgressID,
            Status: this.selectedAppointment.treatmentProgressStatus,
            EndDate: this.selectedAppointment.treatmentProgressStatus === "Completed" ? new Date().toISOString().split('T')[0] : null,
          };
          await axios.post('/hr/appointments/update-treatment-progress', treatmentProgressPayload);
        }

        // Only show confirmation if both conditions are met: has dentist AND all services are not pending
        if (hasDentist && allServicesNotPending) {
          const result = await Swal.fire({
            title: 'Confirm Save',
            text: 'Are you sure you want to save the changes? Once saved, this appointment will be marked as "Completed" and cannot be edited.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#06693A',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Save Changes',
            cancelButtonText: 'No, Cancel',
          });

          if (result.isConfirmed) {
            payload.confirmSave = true;
            const response = await axios.put(`/hr/appointments/${this.selectedAppointment.id}`, payload);
            
            Swal.fire({
              title: 'Saved!',
              text: 'The appointment has been updated successfully.',
              icon: 'success',
              showConfirmButton: false,
              timer: 1500
            });
            
            // Update the appointment data
            this.selectedAppointment.services = response.data.services;
            this.selectedAppointment.status = response.data.status;
            this.selectedAppointment.dentist_name = response.data.dentist_name;
            this.selectedAppointment.patient_notes = response.data.patient_notes;
            
            // Set view-only mode
            this.isViewOnly = true;
            
            await this.fetchAppointments();
            this.isEdited = false;
          }
        } else {
          // No confirmation needed, just save
          const response = await axios.put(`/hr/appointments/${this.selectedAppointment.id}`, payload);
          
          Swal.fire({
            title: 'Success',
            text: 'Appointment updated successfully!',
            icon: 'success',
            showConfirmButton: false,
            timer: 1500
          });
          
          // Update the appointment data
          this.selectedAppointment.services = response.data.services;
          this.selectedAppointment.status = response.data.status;
          this.selectedAppointment.dentist_name = response.data.dentist_name;
          this.selectedAppointment.patient_notes = response.data.patient_notes;
          
          await this.fetchAppointments();
          this.closeModal();
          this.isEdited = false;
        }
      } catch (error) {
        console.error("Error saving changes:", error.response?.data || error.message);
        Swal.fire('Error', `Failed to save changes: ${error.response?.data?.message || error.message}`, 'error');
      }
    },
    closeModal() {
      this.showModal = false;
      this.selectedAppointment = { services: [] };
      this.isEdited = false;
      this.isViewOnly = false;
      this.unavailableDentists = [];
      document.body.style.overflow = 'auto';
    },
    handleKeyDown(e) {
      if (e.key === 'Escape' && this.showModal) this.closeModal();
      else if (e.key === 'Escape' && this.showNewAppointmentModal) this.closeNewAppointmentModal();
      else if (e.key === 'Escape' && this.showDeclineModal) this.closeDeclineModal();
    },
    closeNewAppointmentModal() {
      this.showNewAppointmentModal = false;
      this.unavailableDentists = [];
      document.body.style.overflow = 'auto';
    },
    resetNewAppointmentForm() {
      this.newAppointment = {
        patientId: '',
        date: '',
        time: '',
        dentistId: 'any',
        services: [],
        notes: ''
      };
    },
    async fetchPatients() {
      try {
        const response = await axios.get('/hr/patients');
        this.patients = response.data;
      } catch (error) {
        console.error('Error fetching patients:', error);
      }
    },
    async fetchServices() {
      try {
        const response = await axios.get('/services/list');
        this.services = response.data;
      } catch (error) {
        console.error('Error fetching services:', error);
      }
    },
    generateAvailableTimes() {
  // console.log("Generating available times for date:", this.newAppointment.date);
  const times = [];
  const startHour = 9;
  const endHour = 16.5;
  const today = new Date();
  const isToday = this.newAppointment.date === today.toISOString().split('T')[0];
  const currentHour = today.getHours();
  const currentMinute = today.getMinutes();

  for (let hour = startHour; hour <= endHour; hour++) {
    for (let minute of [0, 30]) {
      if (hour === 17 && minute === 30) continue;
      // Skip past times if it's today
      if (isToday && (hour < currentHour || (hour === currentHour && minute <= currentMinute))) {
        continue;
      }
      const formattedHour = Math.floor(hour).toString().padStart(2, '0');
      const formattedMinute = minute.toString().padStart(2, '0');
      times.push(`${formattedHour}:${formattedMinute}`);
    }
  }
  this.availableTimes = times.map(time => ({ time, is_available: true }));
  // console.log("Generated times:", this.availableTimes);
  this.filterTimesFromBackend();
},

    // Add this new method to filter times based on backend data
    async filterTimesFromBackend() {
      // console.log("Filtering available times for date:", this.newAppointment.date);
      try {
        const payload = {
          date: this.newAppointment.date,
          times: this.availableTimes.map(slot => slot.time),
        };
        // console.log("Request payload:", payload);
        const response = await axios.post('/filter-available-times', payload, {
          withCredentials: true,
        });
        const timeSlots = response.data.time_slots;
        // Update availableTimes with the new availability status
        this.availableTimes = this.availableTimes.map(slot => {
          const updatedSlot = timeSlots.find(ts => ts.time === slot.time);
          return {
            time: slot.time,
            is_available: updatedSlot ? updatedSlot.is_available : false,
          };
        });
        // console.log("Updated time slots:", this.availableTimes);
      } catch (error) {
        console.error("Error filtering available times:", error.response?.data || error.message);
        // In case of error, keep all slots as available to avoid blocking interaction
        this.availableTimes = this.availableTimes.map(slot => ({
          time: slot.time,
          is_available: true,
        }));
      }
    },

    toggleService(serviceId) {
      const index = this.newAppointment.services.indexOf(serviceId);
      if (index === -1) {
        this.newAppointment.services.push(serviceId);
      } else {
        this.newAppointment.services.splice(index, 1);
      }
    },
    getServiceName(serviceId) {
      const service = this.services.find(s => s.ServiceID === serviceId);
      return service ? service.ServiceName : 'Unknown Service';
    },
    getServiceCost(serviceId) {
      const service = this.services.find(s => s.ServiceID === serviceId);
      return service ? parseFloat(service.Cost).toFixed(2) : '0.00';
    },
    calculateTotalCost() {
      return this.newAppointment.services.reduce((total, serviceId) => {
        const service = this.services.find(s => s.ServiceID === serviceId);
        return total + (service ? parseFloat(service.Cost) : 0);
      }, 0).toFixed(2);
    },
    getPatientName(patientId) {
      const patient = this.patients.find(p => p.PatientID === patientId);
      return patient ? patient.name : 'Unknown Patient';
    },
    getDentistName(dentistId) {
      const dentist = this.availableDentists.find(d => String(d.id) === String(dentistId));
      return dentist ? dentist.name : 'Unknown Dentist';
    },
    async bookAppointment() {
      if (!this.newAppointment.patientId || !this.newAppointment.date || 
          !this.newAppointment.time || this.newAppointment.services.length === 0) {
        Swal.fire('Error', 'Please fill in all required fields.', 'error');
        return;
      }

      const result = await Swal.fire({
        title: 'Confirm Appointment',
        text: 'Are you sure you want to book this appointment?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#06693A',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Book It',
        cancelButtonText: 'No, Cancel',
      });

      if (!result.isConfirmed) return;

      this.isBooking = true;
      try {
        const appointmentData = {
          PatientID: this.newAppointment.patientId,
          AppointmentDate: this.newAppointment.date,
          AppointmentTime: this.newAppointment.time,
          UserID: this.newAppointment.dentistId === 'any' ? null : this.newAppointment.dentistId,
          services: this.newAppointment.services,
          PatientNote: this.newAppointment.notes,
          AppointmentStatus: 'Pending'
        };
        await axios.post('/hr/appointments/book', appointmentData);
        Swal.fire({
          title: 'Success',
          text: 'Appointment booked successfully!',
          icon: 'success',
          showConfirmButton: false,
          timer: 1500
        });
        this.closeNewAppointmentModal();
        this.fetchAppointments();
      } catch (error) {
        console.error('Error booking appointment:', error.response?.data || error);
        Swal.fire('Error', 'Failed to book appointment: ' + (error.response?.data?.message || error.message), 'error');
      } finally {
        this.isBooking = false;
      }
    },
    changeView(viewName) {
      const calendarApi = this.$refs.fullCalendar.getApi();
      calendarApi.changeView(viewName);
      this.calendarOptions.initialView = viewName;
      this.updateCurrentMonthYear();
    },
    navigateCalendar(direction) {
      const calendarApi = this.$refs.fullCalendar.getApi();
      if (direction === 'prev') calendarApi.prev();
      else if (direction === 'next') calendarApi.next();
      else if (direction === 'today') calendarApi.today();
      this.updateCurrentMonthYear();
    },
    updateCurrentMonthYear() {
      if (!this.$refs.fullCalendar) return;
      const calendarApi = this.$refs.fullCalendar.getApi();
      const currentDate = calendarApi.getDate();
      const options = { month: 'long', year: 'numeric' };
      if (this.calendarOptions.initialView === 'timeGridDay') options.day = 'numeric';
      else if (this.calendarOptions.initialView === 'timeGridWeek') {
        const startOfWeek = new Date(currentDate);
        startOfWeek.setDate(currentDate.getDate() - currentDate.getDay());
        const endOfWeek = new Date(startOfWeek);
        endOfWeek.setDate(startOfWeek.getDate() + 6);
        const startMonth = startOfWeek.toLocaleString('default', { month: 'short' });
        const endMonth = endOfWeek.toLocaleString('default', { month: 'short' });
        this.currentMonthYear = startMonth === endMonth 
          ? `${startMonth} ${startOfWeek.getDate()} - ${endOfWeek.getDate()}, ${endOfWeek.getFullYear()}`
          : `${startMonth} ${startOfWeek.getDate()} - ${endMonth} ${endOfWeek.getDate()}, ${endOfWeek.getFullYear()}`;
        return;
      }
      this.currentMonthYear = currentDate.toLocaleDateString('en-US', options);
    },
    handleDatesSet() {
      this.updateCurrentMonthYear();
    },
    eventDidMount(info) {
      const event = info.event;
      const tooltip = document.createElement('div');
      tooltip.className = 'event-tooltip';
      const patientName = event.extendedProps.patient_name || 'Unknown';
      const dentistName = event.extendedProps.dentist_name || 'Unassigned';
      const time = this.formatTime(event.extendedProps.AppointmentTime);
      const status = event.extendedProps.AppointmentStatus || 'Pending';
      tooltip.innerHTML = `
        <div class="tooltip-title">${patientName}</div>
        <div class="tooltip-time">${time}</div>
        <div class="tooltip-dentist">Dentist: ${dentistName}</div>
        <div class="tooltip-status">Status: ${status}</div>
      `;
      info.el.addEventListener('mouseenter', () => {
        document.body.appendChild(tooltip);
        const rect = info.el.getBoundingClientRect();
        tooltip.style.position = 'absolute';
        tooltip.style.left = `${rect.left + window.scrollX}px`;
        tooltip.style.top = `${rect.bottom + window.scrollY + 5}px`;
        tooltip.style.zIndex = 1000;
      });
      info.el.addEventListener('mouseleave', () => {
        if (document.body.contains(tooltip)) document.body.removeChild(tooltip);
      });
    },
    dayCellDidMount(info) {
      info.el.addEventListener('mouseenter', () => info.el.classList.add('day-cell-hover'));
      info.el.addEventListener('mouseleave', () => info.el.classList.remove('day-cell-hover'));
    },
    dayHeaderDidMount(info) {
      const dayName = info.el.querySelector('.fc-col-header-cell-cushion');
      if (dayName && (info.date.getDay() === 0 || info.date.getDay() === 6)) {
        dayName.classList.add('weekend-day');
      }
    },
    async fetchBlockedDates() {
  try {
    const response = await axios.get('/appointments/blocked-dates');
    
    // Fix: Parse dates in local timezone to prevent day shifting
    this.blockedDates = response.data.map(item => {
      // Create date object in local timezone to prevent UTC conversion issues
      const date = new Date(item.Date + 'T00:00:00'); // Add time component to prevent timezone shift
      return date.toISOString().split('T')[0];
    });
    
    console.log("Blocked Dates (fixed):", this.blockedDates);
    this.calendarKey += 1; // Force re-render of the calendar
    
    this.blockedDates.forEach(dateStr => {
      this.getBlockReason(dateStr);
    });
  } catch (error) {
    console.error('Error fetching blocked dates:', error);
    this.blockedDates = [];
  }
},
    toggleBlockMode() {
      this.isBlockMode = !this.isBlockMode;
      this.blockReason = '';
    },
    async handleDateClick(info) {
  const dateStr = info.dateStr;
  const selectedDate = new Date(dateStr);
  const today = new Date();
  today.setHours(0, 0, 0, 0);

  // Prevent interaction with Sundays
  if (selectedDate.getDay() === 0) {
    Swal.fire('Info', 'The clinic is closed on Sundays and cannot be blocked or unblocked.', 'info');
    return;
  }

  if (!this.isBlockMode) {
    // Make day clickable like in dentist calendar
    info.view.calendar.changeView('timeGridDay', info.dateStr);
    return;
  }

  if (selectedDate < today) {
    Swal.fire('Error', 'Cannot block past dates.', 'error');
    return;
  }

  try {
    const [blockResponse, appointmentResponse] = await Promise.all([
      axios.post('/appointments/check-blocked', { date: dateStr }),
      axios.post('/appointments/check-date', { date: dateStr }),
    ]);
    const isBlocked = blockResponse.data.isBlocked;
    const appointmentCount = appointmentResponse.data.appointmentCount;

    if (appointmentCount > 0 && !isBlocked) {
      Swal.fire('Error', `This date has ${appointmentCount} appointment(s). Blocking is not allowed.`, 'error');
      return;
    }

    const action = isBlocked ? 'unblock' : 'block';
    const actionText = isBlocked ? 'Unblock' : 'Block';
    const result = await Swal.fire({
      title: `Confirm ${actionText} Date`,
      text: `Are you sure you want to ${action} the date ${this.formatDate(dateStr)}?`,
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#06693A',
      cancelButtonColor: '#d33',
      confirmButtonText: `Yes, ${actionText} It`,
      cancelButtonText: 'No, Cancel',
      input: isBlocked ? null : 'textarea',
      inputLabel: isBlocked ? null : 'Reason (Optional)',
      inputPlaceholder: isBlocked ? null : 'Enter the reason for blocking this date (e.g., clinic closure, holiday)',
      inputAttributes: isBlocked ? {} : { maxlength: 200 },
    });

    if (result.isConfirmed) {
      if (isBlocked) {
        await this.unblockDate(dateStr);
      } else {
        this.blockReason = result.value || '';
        await this.blockDate(dateStr);
      }
    }
  } catch (error) {
    console.error('Error checking date status:', error);
    Swal.fire('Error', 'Failed to check date status: ' + (error.response?.data?.message || error.message), 'error');
  }
},
    async blockDate(dateStr) {
      this.isBlocking = true;
      try {
        const response = await axios.post('/appointments/block-date', {
          date: dateStr,
          reason: this.blockReason,
        });
        if (response.data.success) {
          Swal.fire({
            title: 'Success',
            text: 'Date blocked successfully!',
            icon: 'success',
            showConfirmButton: false,
            timer: 1500
          });
          await this.fetchBlockedDates();
          this.isBlockMode = false;
          this.blockReason = '';
        } else {
          Swal.fire('Error', response.data.message || 'Failed to block date.', 'error');
        }
      } catch (error) {
        console.error('Error blocking date:', error);
        Swal.fire('Error', 'Failed to block date: ' + (error.response?.data?.message || error.message), 'error');
      } finally {
        this.isBlocking = false;
      }
    },
    async unblockDate(dateStr) {
      this.isBlocking = true;
      try {
        const response = await axios.delete(`/appointments/block-date/${dateStr}`);
        if (response.data.success) {
          Swal.fire({
            title: 'Success',
            text: 'Date unblocked successfully!',
            icon: 'success',
            showConfirmButton: false,
            timer: 1500
          });
          await this.fetchBlockedDates();
          this.isBlockMode = false;
        } else {
          Swal.fire('Error', response.data.message || 'Failed to unblock date.', 'error');
        }
      } catch (error) {
        console.error('Error unblocking date:', error);
        Swal.fire('Error', 'Failed to unblock date: ' + (error.response?.data?.message || error.message), 'error');
      } finally {
        this.isBlocking = false;
      }
    },
    // New methods for accept/decline functionality
    async confirmAppointment(appointmentId) {
      if (!this.selectedDentistId && !this.selectedAppointment.UserID) {
        Swal.fire('Warning', 'Please assign a dentist before confirming the appointment.', 'warning');
        return;
      }
      
      try {
        this.confirmAppointmentData = { ...this.selectedAppointment };
        await axios.put(`/hr/appointments/${appointmentId}`, { 
          status: 'Confirmed',
          user_id: this.selectedDentistId ? parseInt(this.selectedDentistId) : this.selectedAppointment.UserID
        });
        
        this.showConfirmNotification = true;
        if (this.showModal) {
          this.closeModal();
        }
        
        setTimeout(() => {
          this.showConfirmNotification = false;
          this.confirmAppointmentData = null;
        }, 3000);
        
        this.fetchAppointments();
      } catch (error) {
        console.error("Error confirming appointment:", error.response?.data || error);
        Swal.fire('Error', `Failed to confirm appointment: ${error.response?.data?.message || error.message}`, 'error');
      }
    },
    declineAppointment(appointmentId) {
      this.appointmentToDecline = { ...this.selectedAppointment };
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
        Swal.fire('Error', 'Please provide a reason for declining the appointment.', 'error');
        return;
      }
      
      if (!this.appointmentToDecline) return;
      
      try {
        this.declineAppointmentData = { ...this.appointmentToDecline };
        await axios.put(`/hr/appointments/${this.appointmentToDecline.id}`, {
          status: 'Declined',
          declineReason: this.declineReason
        });
        
        this.showDeclineNotification = true;
        this.closeDeclineModal();
        
        if (this.showModal) {
          this.closeModal();
        }
        
        setTimeout(() => {
          this.showDeclineNotification = false;
          this.declineAppointmentData = null;
        }, 3000);
        
        this.fetchAppointments();
      } catch (error) {
        console.error("Error declining appointment:", error.response?.data || error);
        Swal.fire('Error', `Failed to decline appointment: ${error.response?.data?.message || error.message}`, 'error');
      }
    },
    markAsEdited() {
      this.isEdited = true;
    },
    addService() {
      if (!this.newServiceId) return;
      
      const service = this.services.find(s => s.ServiceID === this.newServiceId);
      if (!service) return;
      
      this.selectedAppointment.services.push({
        ServiceName: service.ServiceName,
        ServiceID: service.ServiceID,
        Status: 'Pending'
      });
      
      this.newServiceId = '';
      this.markAsEdited();
    },
    deleteService(index) {
      if (this.selectedAppointment.services.length <= 1) {
        Swal.fire('Warning', 'At least one service is required.', 'warning');
        return;
      }
      
      this.selectedAppointment.services.splice(index, 1);
      this.markAsEdited();
    }
  }
};
</script>

<style scoped>
@import url('https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css');
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

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

/* Keep existing sidebar and layout styles */
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
margin-bottom: 15px;
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
margin-right: 10px;
}

/* Dashboard container */
.dashboard-container {
display: flex;
flex-direction: column;
gap: 20px;
padding: 0 20px 20px;
}

/* Stats cards */
.calendar-stats {
display: flex;
gap: 20px;
margin-bottom: 10px;
flex-wrap: wrap;
}

.stat-card {
background: white;
border-radius: 10px;
padding: 20px;
display: flex;
align-items: center;
flex: 1;
min-width: 200px;
box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
transition: transform 0.2s, box-shadow 0.2s;
}

.stat-card:hover {
transform: translateY(-5px);
box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
}

.stat-card i {
font-size: 2.5rem;
color: #06693a;
margin-right: 15px;
}

.stat-info h4 {
font-size: 1.8rem;
font-weight: 600;
color: #06693a;
margin: 0;
}

.stat-info p {
margin: 5px 0 0;
color: #666;
font-size: 0.9rem;
}

.action-card {
display: flex;
justify-content: center;
align-items: center;
padding: 0;
overflow: hidden;
}

.new-appointment-btn {
background-color: #06693A;
color: white;
border: none;
border-radius: 6px;
padding: 12px 20px;
font-size: 15px;
font-weight: 500;
cursor: pointer;
display: flex;
align-items: center;
gap: 8px;
transition: all 0.2s ease;
width: 100%;
height: 100%;
justify-content: center;
}

.new-appointment-btn:hover {
background-color: #055a31;
}

.new-appointment-btn i {
font-size: 18px;
color: white;
margin-right: 0;
}

/* View Controls */
.view-controls {
display: flex;
justify-content: space-between;
align-items: center;
background: white;
border-radius: 10px;
padding: 15px 20px;
box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
}

.view-selector {
display: flex;
background: #f0f0f0;
border-radius: 8px;
overflow: hidden;
}

.view-btn {
background: none;
border: none;
padding: 10px 16px;
font-size: 14px;
font-weight: 500;
color: #555;
cursor: pointer;
display: flex;
align-items: center;
gap: 8px;
transition: all 0.2s ease;
}

.view-btn:hover {
background-color: rgba(6, 105, 58, 0.1);
}

.view-btn.active {
background-color: #06693A;
color: white;
}

.date-navigation {
display: flex;
align-items: center;
gap: 12px;
}

.nav-btn {
background: none;
border: none;
width: 36px;
height: 36px;
border-radius: 50%;
display: flex;
align-items: center;
justify-content: center;
cursor: pointer;
color: #555;
transition: all 0.2s ease;
}

.nav-btn:hover {
background-color: rgba(6, 105, 58, 0.1);
color: #06693A;
}

.today-btn {
background-color: #f0f0f0;
border: none;
padding: 8px 16px;
border-radius: 8px;
font-size: 14px;
font-weight: 500;
color: #555;
cursor: pointer;
transition: all 0.2s ease;
}

.today-btn:hover {
background-color: rgba(6, 105, 58, 0.1);
color: #06693A;
}

/* Calendar Header */
.calendar-header {
display: flex;
justify-content: space-between;
align-items: center;
padding: 0 10px;
margin-bottom: 15px;
}

.calendar-title {
font-size: 22px;
font-weight: 600;
color: #06693A;
}

.calendar-actions {
display: flex;
align-items: center;
gap: 15px;
}

.legend {
display: flex;
flex-wrap: wrap;
gap: 15px;
margin-bottom: 15px;
padding: 0 10px;
}

.legend-item {
display: flex;
align-items: center;
gap: 8px;
font-size: 14px;
color: #555;
}

.legend-color {
width: 12px;
height: 12px;
border-radius: 50%;
}

.legend-color.completed { background-color: #28a745; }
.legend-color.confirmed { background-color: #007bff; }
.legend-color.pending { background-color: #6c757d; }
.legend-color.declined { background-color: #ff6b6b; }
.legend-color.did-not-proceed { background-color: #ff9800; }
.legend-color.cancelled { background-color: #dc3545; }
.legend-color.blocked { background-color: #e8e8e8 !important; }

/* Calendar Container */
.calendar-container {
background: white;
border-radius: 10px;
padding: 20px;
box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
margin-bottom: 20px;
}

/* Appointments summary */
.appointments-summary {
background: white;
border-radius: 10px;
padding: 20px;
box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
}

.summary-header {
display: flex;
justify-content: space-between;
align-items: center;
margin-bottom: 15px;
}

.summary-header h3 {
color: #06693a;
font-size: 1.2rem;
font-weight: 600;
margin: 0;
}

.btn-refresh {
background: #f0f8f4;
color: #06693a;
border: none;
border-radius: 5px;
padding: 8px 15px;
display: flex;
align-items: center;
gap: 5px;
cursor: pointer;
transition: background 0.2s;
}

.btn-refresh:hover {
background: #e0f0e8;
}

.summary-table-container {
overflow-x: auto;
}

.summary-table {
width: 100%;
border-collapse: collapse;
font-size: 0.9rem;
}

.summary-table th {
background: #f0f8f4;
color: #06693a;
font-weight: 500;
text-align: left;
padding: 12px 15px;
}

.summary-table td {
padding: 12px 15px;
border-bottom: 1px solid #eee;
color: #444;
}

.summary-table tr:last-child td {
border-bottom: none;
}

.summary-table tr:hover td {
background: #f9fcfa;
}

.appointment-date {
font-weight: 500;
color: #333;
}

.appointment-time {
font-size: 0.8rem;
color: #666;
margin-top: 3px;
}

.services-list {
display: flex;
flex-wrap: wrap;
gap: 5px;
}

.service-tag {
background: #f0f8f4;
color: #06693a;
padding: 3px 8px;
border-radius: 4px;
font-size: 0.75rem;
}

/* Status Badges */
.status-badge {
display: inline-block;
padding: 4px 10px;
border-radius: 20px;
font-size: 0.75rem;
font-weight: 500;
}

.status-badge.status-completed { background-color: #28a745; color: white; }
.status-badge.status-confirmed { background-color: #007bff; color: white; }
.status-badge.status-pending { background-color: #6c757d; color: white; }
.status-badge.status-declined { background-color: #ff6b6b; color: white; }
.status-badge.status-did-not-proceed { background-color: #ff9800; color: white; }
.status-badge.status-cancelled { background-color: #dc3545; color: white; }

.no-appointments {
text-align: center;
color: #999;
font-style: italic;
}

/* Appointment row styles */
.appointment-row {
cursor: pointer;
transition: background-color 0.2s;
}

.appointment-row:hover {
background-color: #f0f8f4;
}

/* View button */
.btn-view {
background: #f0f8f4;
color: #06693a;
border: none;
border-radius: 50%;
width: 32px;
height: 32px;
display: flex;
align-items: center;
justify-content: center;
cursor: pointer;
transition: all 0.2s;
}

.btn-view:hover {
background: #06693a;
color: white;
}

/* Mobile Cards */
.mobile-cards {
display: none;
padding: 0;
}

.appointment-card {
background-color: white;
border-radius: 12px;
border: 1px solid #e0e0e0;
margin-bottom: 16px;
overflow: hidden;
cursor: pointer;
transition: transform 0.2s, box-shadow 0.2s;
}

.appointment-card:hover {
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

.services-list-mobile {
display: flex;
flex-wrap: wrap;
gap: 5px;
margin-top: 4px;
}

.service-tag-mobile {
background: #f0f8f4;
color: #06693a;
padding: 3px 8px;
border-radius: 4px;
font-size: 0.75rem;
}

.card-footer {
padding: 12px 16px;
border-top: 1px solid #f5f5f5;
display: flex;
justify-content: flex-end;
gap: 8px;
}

.btn-view-mobile {
background-color: #06693A;
border: none;
padding: 8px 16px;
border-radius: 4px;
cursor: pointer;
font-size: 14px;
color: white;
display: flex;
align-items: center;
gap: 5px;
transition: background-color 0.2s;
}

.btn-view-mobile:hover {
background-color: #055a32;
}

.btn-view-mobile i {
font-size: 14px;
}

.no-appointments-mobile {
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

/* Desktop Table */
.desktop-table {
display: table;
}

/* Modal styles */
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

.modal-containers {
background-color: white;
border-radius: 10px;
width: 90%;
max-width: 600px;
max-height: 80vh;
overflow-y: auto;
box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
display: flex;
flex-direction: column;
}

.new-appointment-modal {
max-width: 700px;
}

.modal-header {
display: flex;
justify-content: space-between;
align-items: center;
padding: 15px 20px;
border-bottom: 1px solid #eee;
}

.modal-header h3 {
margin: 0;
color: #06693a;
font-size: 1.3rem;
}

.modal-close {
background: none;
border: none;
font-size: 1.5rem;
color: #666;
cursor: pointer;
display: flex;
align-items: center;
justify-content: center;
padding: 5px;
border-radius: 50%;
transition: background 0.2s;
}

.modal-close:hover {
background: #f0f0f0;
color: #333;
}

.modal-body {
padding: 20px;
overflow-y: auto;
}

.modal-section {
margin-bottom: 20px;
padding-bottom: 15px;
border-bottom: 1px solid #eee;
}

.modal-section:last-child {
border-bottom: none;
margin-bottom: 0;
padding-bottom: 0;
}

.section-title {
display: flex;
align-items: center;
gap: 8px;
color: #06693a;
font-size: 1.1rem;
margin-bottom: 12px;
}

.section-title i {
font-size: 1.2rem;
}

.detail-row {
display: flex;
flex-wrap: wrap;
gap: 15px;
margin-bottom: 10px;
}

.detail-item {
flex: 1;
min-width: 200px;
}

.detail-label {
font-weight: 500;
color: #666;
display: block;
margin-bottom: 3px;
font-size: 0.9rem;
}

.detail-value {
color: #333;
font-size: 1rem;
}

.appointment-status-banner {
display: flex;
align-items: center;
gap: 10px;
padding: 12px 15px;
border-radius: 8px;
margin-bottom: 15px;
font-weight: 500;
}

.appointment-status-banner.status-completed { background-color: #28a745; color: white; }
.appointment-status-banner.status-confirmed { background-color: #007bff; color: white; }
.appointment-status-banner.status-pending { background-color: #6c757d; color: white; }
.appointment-status-banner.status-declined { background-color: #ff6b6b; color: white; }
.appointment-status-banner.status-did-not-proceed { background-color: #ff9800; color: white; }
.appointment-status-banner.status-cancelled { background-color: #dc3545; color: white; }

.appointment-status-banner i {
font-size: 1.3rem;
}

.service-detail {
background: #f9f9f9;
border-radius: 8px;
padding: 15px;
margin-bottom: 10px;
}

.service-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 10px;
}

.service-name {
  font-weight: 600;
  color: #333;
  flex: 1;
}

.service-actions {
  display: flex;
  align-items: center;
  gap: 8px;
}

.service-controls {
margin-top: 10px;
}

.service-status {
display: flex;
flex-direction: column;
gap: 5px;
}

.service-status label {
font-weight: 500;
color: #555;
font-size: 0.9rem;
}

.form-select, .form-input, .form-textarea {
padding: 10px 12px;
border-radius: 6px;
border: 1px solid #ddd;
background-color: white;
font-family: 'Poppins', sans-serif;
transition: all 0.2s ease;
width: 100%;
font-size: 14px;
}

.form-select:focus, .form-input:focus, .form-textarea:focus {
border-color: #06693A;
outline: none;
box-shadow: 0 0 0 2px rgba(6, 105, 58, 0.1);
}

.form-textarea {
min-height: 100px;
resize: none;
}

.no-services {
padding: 15px;
text-align: center;
color: #666;
background: #f5f5f5;
border-radius: 6px;
font-style: italic;
}

.notes-container {
background: #f9f9f9;
padding: 12px 15px;
border-radius: 6px;
color: #444;
line-height: 1.5;
}

.modal-footer {
display: flex;
justify-content: flex-end;
gap: 10px;
padding: 15px 20px;
border-top: 1px solid #eee;
}

.btn-secondary {
background: #f0f0f0;
color: #444;
border: none;
border-radius: 5px;
padding: 8px 16px;
cursor: pointer;
font-weight: 500;
transition: background 0.2s;
display: flex;
align-items: center;
gap: 5px;
}

.btn-secondary:hover {
background: #e0e0e0;
}

.btn-primary {
background: #06693a;
color: white;
border: none;
border-radius: 5px;
padding: 8px 16px;
cursor: pointer;
font-weight: 500;
transition: background 0.2s;
display: flex;
align-items: center;
gap: 5px;
}

.btn-primary:hover {
background: #055a32;
}

.btn-primary:disabled {
background: #aaa;
cursor: not-allowed;
}

/* Steps container */
.steps-container {
display: flex;
margin-bottom: 25px;
position: relative;
}

.steps-container::before {
content: '';
position: absolute;
top: 20px;
left: 0;
right: 0;
height: 2px;
background-color: #ddd;
z-index: 1;
}

.step {
flex: 1;
text-align: center;
position: relative;
z-index: 2;
}

.step-number {
width: 40px;
height: 40px;
border-radius: 50%;
background-color: #f0f0f0;
border: 2px solid #ddd;
display: flex;
align-items: center;
justify-content: center;
margin: 0 auto 10px;
font-weight: 600;
color: #666;
transition: all 0.2s ease;
}

.step-label {
font-size: 14px;
color: #666;
transition: all 0.2s ease;
}

.step.active .step-number {
background-color: #06693A;
border-color: #06693A;
color: white;
}

.step.active .step-label {
color: #06693A;
font-weight: 500;
}

.step.completed .step-number {
background-color: #28a745;
border-color: #28a745;
color: white;
}

/* Form Group */
.form-group {
margin-bottom: 20px;
}

.form-group label {
display: block;
margin-bottom: 8px;
font-weight: 500;
color: #444;
}

.text-muted {
color: #777;
font-weight: normal;
}

.text-danger {
font-size: 0.875em;
color: #dc3545;
}

.fc-event-status {
font-size: 0.85em;
margin-top: 2px;
opacity: 0.9;
}

/* Time Slots */
.time-slots {
display: grid;
grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
gap: 10px;
}

.time-slot {
padding: 10px;
border: 1px solid #ddd;
border-radius: 6px;
text-align: center;
cursor: pointer;
background-color: white;
transition: all 0.2s ease;
}

.time-slot:hover {
border-color: #06693A;
background-color: rgba(6, 105, 58, 0.05);
}

.time-slot.selected {
background-color: #06693A;
color: white;
border-color: #06693A;
box-shadow: 0 2px 4px rgba(6, 105, 58, 0.2);
}

.time-slot.disabled {
background-color: #f5f5f5;
color: #999;
cursor: not-allowed;
border-color: #ddd;
}

/* Services List */
.services-list-selection {
display: grid;
grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
gap: 15px;
max-height: 300px;
overflow-y: auto;
padding-right: 5px;
}

.services-list-selection::-webkit-scrollbar {
width: 6px;
}

.services-list-selection::-webkit-scrollbar-track {
background: #f1f1f1;
border-radius: 10px;
}

.services-list-selection::-webkit-scrollbar-thumb {
background: #06693A;
border-radius: 10px;
}

.service-card {
display: flex;
justify-content: space-between;
align-items: center;
padding: 15px;
border: 1px solid #ddd;
border-radius: 8px;
cursor: pointer;
transition: all 0.2s ease;
background-color: white;
}

.service-card:hover {
border-color: #06693A;
box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}

.service-card.selected {
background-color: rgba(6, 105, 58, 0.1);
border-color: #06693A;
}

.service-details {
flex: 1;
}

.service-name {
font-weight: 600;
color: #333;
margin-bottom: 4px;
}

.service-cost {
color: #06693A;
font-weight: 500;
margin-top: 4px;
}

.service-badge {
display: inline-block;
padding: 3px 10px;
border-radius: 12px;
font-size: 12px;
margin-top: 5px;
}

.service-badge.multi-visit {
background-color: #e0f2f1;
color: #00796b;
}

.service-checkbox {
width: 24px;
height: 24px;
border-radius: 50%;
background-color: #06693A;
color: white;
display: flex;
align-items: center;
justify-content: center;
opacity: 0;
transition: all 0.2s ease;
}

.service-card.selected .service-checkbox {
opacity: 1;
}

/* Selected Services */
.selected-services {
margin-top: 20px;
background-color: #f9f9f9;
padding: 15px;
border-radius: 8px;
}

.selected-services h4 {
margin-bottom: 12px;
font-weight: 500;
color: #06693A;
}

.selected-service {
display: flex;
justify-content: space-between;
margin-bottom: 8px;
padding: 8px;
background-color: white;
border-radius: 4px;
}

.total-cost {
display: flex;
justify-content: space-between;
margin-top: 12px;
padding-top: 12px;
border-top: 1px solid #ddd;
font-weight: 600;
color: #06693A;
}

/* Appointment Summary */
.appointment-summary {
background-color: #f9f9f9;
padding: 20px;
border-radius: 8px;
margin-top: 20px;
}

.appointment-summary h4 {
margin-bottom: 18px;
font-weight: 600;
color: #06693A;
}

.summary-item {
margin-bottom: 14px;
}

.summary-label {
font-weight: 500;
display: inline-block;
width: 120px;
color: #555;
}

.services-summary {
margin-top: 8px;
margin-left: 20px;
list-style-type: disc;
}

.services-summary li {
margin-bottom: 6px;
}

.summary-item.total {
margin-top: 18px;
padding-top: 18px;
border-top: 1px solid #ddd;
font-weight: 600;
color: #06693A;
}

.notes-text {
margin-top: 8px;
font-style: italic;
background: white;
padding: 10px;
border-radius: 4px;
border: 1px solid #eee;
}

/* New styles for the redesigned appointments table */
.status-tabs {
display: flex;
gap: 10px;
margin-bottom: 15px;
overflow-x: auto;
padding-bottom: 5px;
}

.status-tab {
background: #f0f0f0;
border: none;
border-radius: 20px;
padding: 8px 16px;
font-size: 14px;
font-weight: 500;
color: #555;
cursor: pointer;
transition: all 0.2s ease;
white-space: nowrap;
display: flex;
align-items: center;
gap: 8px;
}

.status-tab:hover {
background-color: rgba(6, 105, 58, 0.1);
}

.status-tab.active {
background-color: #06693A;
color: white;
}

.status-count {
background: rgba(255, 255, 255, 0.3);
border-radius: 12px;
padding: 2px 8px;
font-size: 12px;
min-width: 24px;
text-align: center;
}

.status-tab.active .status-count {
background: rgba(255, 255, 255, 0.3);
}

.pagination-controls {
display: flex;
justify-content: space-between;
align-items: center;
margin-top: 15px;
padding-top: 15px;
border-top: 1px solid #eee;
}

.pagination-info {
color: #666;
font-size: 14px;
}

.pagination-buttons {
display: flex;
gap: 10px;
}

.pagination-btn {
background: #f0f0f0;
border: none;
border-radius: 5px;
padding: 8px 16px;
font-size: 14px;
font-weight: 500;
color: #555;
cursor: pointer;
transition: all 0.2s ease;
display: flex;
align-items: center;
gap: 5px;
}

.pagination-btn:hover:not(:disabled) {
background-color: rgba(6, 105, 58, 0.1);
color: #06693A;
}

.pagination-btn:disabled {
opacity: 0.5;
cursor: not-allowed;
}

/* Block Date Button */
.block-date-btn {
background-color: #dc3545;
color: white;
border: none;
padding: 8px 16px;
border-radius: 5px;
cursor: pointer;
display: flex;
align-items: center;
gap: 5px;
transition: background-color 0.2s;
font-family: 'Poppins', sans-serif;
font-weight: 500;
font-size: 14px;
}

.block-date-btn:hover {
background-color: #c82333;
}

/* Alert Styling */
.alert {
padding: 10px;
border-radius: 5px;
margin-top: 10px;
display: flex;
align-items: center;
gap: 5px;
font-size: 0.875em;
}

.alert-danger {
background-color: #f8d7da;
color: #721c24;
border: 1px solid #f5c6cb;
}

.alert-warning {
background-color: #fff3cd;
color: #856404;
border: 1px solid #ffeeba;
}

/* Accept/Decline button styles */
.action-buttons {
display: flex;
gap: 10px;
}

.btn-accept {
background-color: #28a745;
color: white;
border: none;
border-radius: 5px;
padding: 8px 16px;
cursor: pointer;
font-weight: 500;
transition: background 0.2s;
display: flex;
align-items: center;
gap: 5px;
}

.btn-accept:hover:not(:disabled) {
background-color: #218838;
}

.btn-accept:disabled {
opacity: 0.6;
cursor: not-allowed;
}

.btn-decline {
background-color: #dc3545;
color: white;
border: none;
border-radius: 5px;
padding: 8px 16px;
cursor: pointer;
font-weight: 500;
transition: background 0.2s;
display: flex;
align-items: center;
gap: 5px;
}

.btn-decline:hover {
background-color: #c82333;
}

/* Decline Modal Styles */
.decline-modal {
background: white;
width: 90%;
max-width: 500px;
border-radius: 12px;
box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
overflow: hidden;
}

.decline-modal-header {
display: flex;
justify-content: space-between;
align-items: center;
padding: 20px 25px;
border-bottom: 1px solid #f0f0f0;
background-color: #fff;
color: #06693A;
}

.decline-modal-header h3 {
margin: 0;
font-size: 22px;
font-weight: 600;
}

.close-btn {
background: none;
border: none;
color: #666;
font-size: 24px;
cursor: pointer;
display: flex;
align-items: center;
justify-content: center;
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
border-radius: 10px;
margin-bottom: 20px;
}

.patient-avatar {
font-size: 40px;
color: #06693A;
}

.patient-details h4 {
margin: 0 0 5px 0;
font-weight: 600;
color: #333;
}

.patient-details p {
margin: 0;
color: #666;
font-size: 14px;
}

.form-section {
margin-bottom: 20px;
}

.form-section label {
display: flex;
align-items: center;
gap: 8px;
font-weight: 500;
color: #444;
margin-bottom: 10px;
}

.form-section label i {
color: #06693A;
font-size: 18px;
}

.textarea-wrapper {
position: relative;
}

.decline-textarea {
width: 100%;
padding: 12px 15px;
border: 1px solid #ddd;
border-radius: 8px;
resize: none;
font-family: 'Poppins', sans-serif;
font-size: 14px;
transition: border-color 0.2s;
}

.decline-textarea:focus {
outline: none;
border-color: #06693A;
box-shadow: 0 0 0 2px rgba(6, 105, 58, 0.1);
}

.helper-text {
font-size: 12px;
color: #666;
margin-top: 5px;
font-style: italic;
}

.decline-modal-footer {
display: flex;
justify-content: flex-end;
gap: 10px;
padding: 20px 25px;
border-top: 1px solid #f0f0f0;
}

.modal-cancel-button {
background-color: #f0f0f0;
color: #444;
border: none;
border-radius: 5px;
padding: 10px 16px;
cursor: pointer;
font-weight: 500;
display: flex;
align-items: center;
gap: 5px;
transition: background 0.2s;
}

.modal-cancel-button:hover {
background-color: #e0e0e0;
}

.modal-decline-button {
background-color: #dc3545;
color: white;
border: none;
border-radius: 5px;
padding: 10px 16px;
cursor: pointer;
font-weight: 500;
display: flex;
align-items: center;
gap: 5px;
transition: background 0.2s;
}

.modal-decline-button:hover:not(.disabled-button) {
background-color: #c82333;
}

.disabled-button {
opacity: 0.6;
cursor: not-allowed;
}

/* Status Notification Popup */
.status-notification {
position: fixed;
top: 20px;
right: 20px;
z-index: 1100;
animation: slideIn 0.3s ease-out forwards;
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

.notification-content {
display: flex;
align-items: center;
gap: 12px;
padding: 15px 20px;
border-radius: 8px;
box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
color: white;
font-weight: 500;
}

.notification-content i {
font-size: 24px;
}

.status-confirmed {
background-color: #28a745;
}

.status-declined {
background-color: #dc3545;
}

.add-service {
margin-top: 15px;
}

.add-service label {
display: block;
margin-bottom: 5px;
}

.btn-delete {
  background: none;
  border: none;
  color: #dc3545;
  cursor: pointer;
  padding: 0 5px;
  display: flex;
  align-items: center;
}

.btn-delete:disabled {
  color: #6c757d;
  cursor: not-allowed;
}



/* Large Desktop */
@media (min-width: 1400px) {
.dashboard-container {
  padding: 0 30px 30px;
}

.stat-card {
  padding: 25px;
}

.calendar-container,
.appointments-summary {
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

.stat-card {
  min-width: 180px;
  padding: 18px;
}

.stat-card i {
  font-size: 2.2rem;
}

.stat-info h4 {
  font-size: 1.6rem;
}
}

/* Tablet */
@media (max-width: 992px) {
.calendar-stats {
  flex-direction: column;
  gap: 15px;
}

.stat-card {
  width: 100%;
  min-width: 100%;
}

.view-controls {
  flex-direction: column;
  gap: 15px;
}

.view-selector, .date-navigation {
  width: 100%;
}

.view-btn {
  flex: 1;
  justify-content: center;
}

.calendar-header {
  flex-direction: column;
  align-items: flex-start;
  gap: 10px;
}

.legend {
  flex-wrap: wrap;
  justify-content: flex-start;
}

.summary-table th:nth-child(4),
.summary-table td:nth-child(4) {
  display: none;
}

.modal-containers {
  width: 95%;
}

.detail-row {
  flex-direction: column;
  gap: 10px;
}

.detail-item {
  min-width: 100%;
}

.services-list-selection {
  grid-template-columns: 1fr;
}

.time-slots {
  grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
}

.pagination-controls {
  flex-direction: column;
  gap: 10px;
  align-items: flex-start;
}

.status-tabs {
  padding-bottom: 10px;
}

.status-tab {
  padding: 6px 12px;
  font-size: 13px;
}

.dashboard-container {
  padding: 0 15px 15px;
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

.dashboard-container {
  padding: 0 10px 10px;
  gap: 15px;
}

.calendar-stats {
  gap: 12px;
}

.stat-card {
  padding: 15px;
  border-radius: 8px;
}

.stat-card i {
  font-size: 2rem;
  margin-right: 12px;
}

.stat-info h4 {
  font-size: 1.4rem;
}

.stat-info p {
  font-size: 0.85rem;
}

.view-controls {
  padding: 12px 15px;
  border-radius: 8px;
}

.view-btn {
  padding: 8px 12px;
  font-size: 13px;
}

.nav-btn {
  width: 32px;
  height: 32px;
}

.today-btn {
  padding: 6px 12px;
  font-size: 13px;
}

.calendar-container {
  padding: 15px;
  border-radius: 8px;
}

.calendar-header {
  padding: 0 5px;
  margin-bottom: 12px;
}

.calendar-title {
  font-size: 18px;
}

.calendar-actions {
  gap: 10px;
}

.block-date-btn {
  padding: 6px 12px;
  font-size: 13px;
}

.legend {
  gap: 12px;
  margin-bottom: 12px;
  padding: 0 5px;
}

.legend-item {
  font-size: 13px;
}

.appointments-summary {
  padding: 15px;
  border-radius: 8px;
}

.summary-header {
  flex-direction: column;
  gap: 10px;
  align-items: flex-start;
}

.summary-header h3 {
  font-size: 1.1rem;
}

.btn-refresh {
  align-self: flex-end;
  padding: 6px 12px;
  font-size: 13px;
}

.status-tabs {
  gap: 8px;
  margin-bottom: 12px;
}

.status-tab {
  padding: 6px 12px;
  font-size: 12px;
}

.appointment-card {
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

.service-tag-mobile {
  font-size: 0.7rem;
  padding: 2px 6px;
}

.modal-containers {
  width: 95%;
  max-height: 85vh;
}

.modal-header {
  padding: 12px 15px;
}

.modal-header h3 {
  font-size: 1.1rem;
}

.modal-body {
  padding: 15px;
}

.section-title {
  font-size: 1rem;
}

.services-list-selection {
  grid-template-columns: 1fr;
}

.time-slots {
  grid-template-columns: repeat(auto-fill, minmax(70px, 1fr));
}

.time-slot {
  padding: 8px;
  font-size: 13px;
}

.decline-modal {
  width: 95%;
}

.decline-modal-header {
  padding: 15px 20px;
}

.decline-modal-header h3 {
  font-size: 18px;
}

.decline-modal-body {
  padding: 20px;
}

.patient-info {
  padding: 12px;
  gap: 12px;
}

.patient-avatar {
  font-size: 32px;
}

.patient-details h4 {
  font-size: 15px;
}

.patient-details p {
  font-size: 13px;
}

.decline-textarea {
  padding: 10px 12px;
  font-size: 13px;
}

.decline-modal-footer {
  padding: 15px 20px;
}

.modal-cancel-button,
.modal-decline-button {
  padding: 8px 14px;
  font-size: 13px;
}

.status-notification {
  top: 15px;
  right: 15px;
}

.notification-content {
  padding: 12px 16px;
  font-size: 14px;
}

.notification-content i {
  font-size: 20px;
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

.dashboard-container {
  padding: 0 8px 8px;
  gap: 12px;
}

.stat-card {
  padding: 12px;
}

.stat-card i {
  font-size: 1.8rem;
  margin-right: 10px;
}

.stat-info h4 {
  font-size: 1.2rem;
}

.stat-info p {
  font-size: 0.8rem;
}

.view-controls {
  padding: 10px 12px;
}

.view-btn {
  padding: 6px 10px;
  font-size: 12px;
}

.nav-btn {
  width: 28px;
  height: 28px;
}

.today-btn {
  padding: 5px 10px;
  font-size: 12px;
}

.calendar-container {
  padding: 12px;
}

.calendar-title {
  font-size: 16px;
}

.block-date-btn {
  padding: 5px 10px;
  font-size: 12px;
}

.legend {
  gap: 10px;
  margin-bottom: 10px;
}

.legend-item {
  font-size: 12px;
}

.appointments-summary {
  padding: 12px;
}

.summary-header h3 {
  font-size: 1rem;
}

.btn-refresh {
  padding: 5px 10px;
  font-size: 12px;
}

.status-tab {
  padding: 5px 10px;
  font-size: 11px;
}

.appointment-card {
  margin-bottom: 10px;
}

.card-header {
  padding: 10px 12px;
}

.card-header h4 {
  font-size: 14px;
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

.service-tag-mobile {
  font-size: 0.65rem;
  padding: 2px 5px;
}

.no-appointments-mobile {
  padding: 20px;
  min-height: 150px;
  font-size: 14px;
}

.modal-header {
  padding: 10px 12px;
}

.modal-header h3 {
  font-size: 1rem;
}

.modal-body {
  padding: 12px;
}

.section-title {
  font-size: 0.95rem;
}

.time-slots {
  grid-template-columns: repeat(auto-fill, minmax(60px, 1fr));
}

.time-slot {
  padding: 6px;
  font-size: 12px;
}

.pagination-controls {
  padding: 10px 0;
}

.pagination-info {
  font-size: 12px;
}

.pagination-btn {
  padding: 6px 12px;
  font-size: 12px;
}

.decline-modal-header h3 {
  font-size: 16px;
}

.patient-avatar {
  font-size: 28px;
}

.patient-details h4 {
  font-size: 14px;
}

.patient-details p {
  font-size: 12px;
}

.decline-textarea {
  padding: 8px 10px;
  font-size: 12px;
}

.modal-cancel-button,
.modal-decline-button {
  padding: 6px 12px;
  font-size: 12px;
}
}

/* Landscape Mobile */
@media (max-height: 500px) and (orientation: landscape) {
.modal-containers {
  max-height: 95vh;
}

.modal-body {
  max-height: calc(95vh - 120px);
  overflow-y: auto;
}

.appointment-card {
  margin-bottom: 8px;
}

.stat-card {
  padding: 10px 15px;
}

.calendar-container {
  padding: 10px;
}

.appointments-summary {
  padding: 10px;
}

.steps-container {
  flex-direction: column;
  gap: 10px;
}

.steps-container::before {
  display: none;
}

.step {
  display: flex;
  align-items: center;
  gap: 10px;
}

.step-number {
  margin: 0;
}
}
</style>

<style>
/* HR Calendar Styles for Blocked Dates and Sundays */
.hr-calendar .fc-daygrid-day.fc-day-blocked {
  background-color: #e8e8e8 !important;
  pointer-events: none;
  color: #999 !important;
  opacity: 0.6;
  position: relative;
}

.hr-calendar .fc-daygrid-day.fc-day-blocked::after {
  content: "Blocked";
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  font-size: 10px;
  color: white;
  font-weight: 500;
}

.hr-calendar .fc-daygrid-day.sunday-blocked {
  background-color: #e8e8e8 !important;
  pointer-events: none;
  color: #999 !important;
  opacity: 0.6;
  position: relative;
}

.hr-calendar .fc-daygrid-day.sunday-blocked::after {
  content: "Closed";
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  font-size: 10px;
  color: white;
  font-weight: 500;
}

.hr-calendar .blocked-date-tooltip {
  background-color: #e8e8e8 !important;
  color: #999 !important;
  padding: 5px 10px;
  border-radius: 4px;
  font-size: 12px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
  z-index: 1000;
}

/* Blocked Date Styling */
.fc-day-blocked {
background-color: #e8e8e8 !important;
position: relative;
}

.fc-day-blocked::after {
content: "Blocked";
position: absolute;
top: 5px;
right: 5px;
background-color: #e8e8e8 !important;
color: white;
padding: 2px 5px;
border-radius: 3px;
font-size: 12px;
}

/* New styles for blocked date tooltip */
.blocked-date-tooltip {
background-color: #e8e8e8 !important;
border-left: 4px solid #dc3545;
border-radius: 4px;
box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
color: #333;
font-size: 14px;
max-width: 250px;
padding: 10px 12px;
z-index: 1000;
}
</style>
