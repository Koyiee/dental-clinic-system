<template>
<div class="sidebar close">
  <div class="logo-details">
    <img src="@/components/Images/ATDC_Logo.png" alt="" class="logo">
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
              <div class="profile_name">{{ fullName }}</div>
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
        <h3>Calendar Schedule</h3>
        <div class="breadcrumbs">
          <a class="none" href=""><p>Home / </p></a>
          <a class="current" href="/dentistcalendarschedule"><p> &nbsp;Calendar Schedule</p></a>
        </div>
      </div>
    </div>
    <hr color="#06693a">

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
      </div>

      <!-- Simplified Legend for appointment status -->
      <div class="calendar-legend">
        <div class="legend-title">Appointment Status:</div>
        <div class="legend-items">
          <div class="legend-item">
            <span class="legend-color finished"></span>
            <span class="legend-label">Finished</span>
          </div>
          <div class="legend-item">
            <span class="legend-color unfinished"></span>
            <span class="legend-label">Unfinished</span>
          </div>
        </div>
      </div>

      <div class="calendar-container">
        <FullCalendar class="dentist-calendar" :options="calendarOptions" />
      </div>

      <div class="appointments-summary">
        <div class="summary-header">
          <h3>Upcoming Appointments</h3>
          <div class="summary-actions">
            <button class="btn-refresh" @click="fetchAppointments">
              <i class="bx bx-refresh"></i> Refresh
            </button>
          </div>
        </div>
        <div class="summary-table-container">
          <!-- Desktop Table -->
          <table class="summary-table desktop-table">
            <thead>
              <tr>
                <th>Date & Time</th>
                <th>Patient</th>
                <th>Services</th>
                <th>Notes</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-if="paginatedAppointments.length === 0">
                <td colspan="6" class="no-appointments">No upcoming appointments</td>
              </tr>
              <tr v-for="(appointment, index) in paginatedAppointments" :key="index" @click="openAppointmentDetails(appointment)" class="appointment-row">
                <td>
                  <div class="appointment-date">{{ formatDate(appointment.start) }}</div>
                  <div class="appointment-time">{{ formatTime(appointment.start) }}</div>
                </td>
                <td>{{ appointment.extendedProps.PatientName }}</td>
                <td>
                  <div class="services-list">
                    <span v-for="(service, i) in appointment.extendedProps.Services" :key="i" class="service-tag">
                      {{ service }}
                    </span>
                    <span v-if="!appointment.extendedProps.Services || appointment.extendedProps.Services.length === 0">
                      N/A
                    </span>
                  </div>
                </td>
                <td>{{ appointment.extendedProps.PatientNote || 'No notes' }}</td>
                <td>
                  <span class="status-badge" :class="getStatusClass(appointment)">
                    {{ getStatus(appointment) }}
                  </span>
                </td>
                <td>
                  <button class="btn-view" @click.stop="openAppointmentDetails(appointment)">
                    <i class="bx bx-show"></i>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>

          <!-- Mobile Cards -->
          <div class="mobile-cards">
            <div 
              v-for="(appointment, index) in paginatedAppointments" 
              :key="index"
              class="appointment-card"
              @click="openAppointmentDetails(appointment)"
            >
              <div class="card-header">
                <h4>{{ appointment.extendedProps.PatientName }}</h4>
                <span class="status-badge" :class="getStatusClass(appointment)">
                  {{ getStatus(appointment) }}
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
                    <span v-for="(service, i) in appointment.extendedProps.Services" :key="i" class="service-tag-mobile">
                      {{ service }}
                    </span>
                    <span v-if="!appointment.extendedProps.Services || appointment.extendedProps.Services.length === 0">
                      N/A
                    </span>
                  </div>
                </div>
                <div class="card-row" v-if="appointment.extendedProps.PatientNote">
                  <span class="card-label">Notes:</span>
                  <span>{{ appointment.extendedProps.PatientNote }}</span>
                </div>
              </div>
              <div class="card-footer">
                <button @click.stop="openAppointmentDetails(appointment)" class="btn-view-mobile">
                  <i class="bx bx-show"></i> View Details
                </button>
              </div>
            </div>
            <div v-if="paginatedAppointments.length === 0" class="no-appointments-mobile">
              No upcoming appointments
            </div>
          </div>
          
          <!-- Pagination Controls -->
          <div v-if="upcomingAppointments.length > itemsPerPage" class="pagination-controls">
            <div class="pagination-info">
              Showing {{ Math.min(upcomingAppointments.length, currentPage * itemsPerPage) }} of {{ upcomingAppointments.length }} appointments
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
                :disabled="currentPage * itemsPerPage >= upcomingAppointments.length"
              >
                Next <i class="bx bx-chevron-right"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Appointment Details Modal -->
<div class="modal-overlay" v-if="showModal" @click="closeModal">
  <div class="modal-container" @click.stop>
    <div class="modal-header">
      <h3>Appointment Details</h3>
      <button class="modal-close" @click="closeModal">
        <i class="bx bx-x"></i>
      </button>
    </div>
    <div class="modal-body" v-if="selectedAppointment">
      <div class="modal-section">
        <div class="appointment-status-banner" :class="getStatusClass(selectedAppointment)">
          <i class="bx bx-calendar-check"></i>
          <span>{{ getStatus(selectedAppointment) }}</span>
        </div>
      </div>
      
      <div class="modal-section">
        <h4 class="section-title">
          <i class="bx bx-time"></i> Date & Time
        </h4>
        <div class="detail-row">
          <div class="detail-item">
            <span class="detail-label">Date:</span>
            <span class="detail-value">{{ formatDate(selectedAppointment.start) }}</span>
          </div>
          <div class="detail-item">
            <span class="detail-label">Time:</span>
            <span class="detail-value">{{ formatTime(selectedAppointment.start) }}</span>
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
            <span class="detail-value">{{ selectedAppointment.extendedProps.PatientName }}</span>
          </div>
          <div class="detail-item" v-if="selectedAppointment.extendedProps.PatientContact">
            <span class="detail-label">Contact:</span>
            <span class="detail-value">{{ selectedAppointment.extendedProps.PatientContact }}</span>
          </div>
        </div>
        <div class="detail-row" v-if="selectedAppointment.extendedProps.PatientEmail">
          <div class="detail-item">
            <span class="detail-label">Email:</span>
            <span class="detail-value">{{ selectedAppointment.extendedProps.PatientEmail }}</span>
          </div>
        </div>
      </div>
      
      <div class="modal-section">
        <h4 class="section-title">
          <i class="bx bx-clipboard"></i> Services
        </h4>
        <div class="services-grid">
          <div v-for="(service, i) in selectedAppointment.extendedProps.Services" :key="i" class="service-item">
            <i class="bx bx-check-circle"></i>
            <span>{{ service }}</span>
          </div>
          <div v-if="!selectedAppointment.extendedProps.Services || selectedAppointment.extendedProps.Services.length === 0" class="no-services">
            No services specified
          </div>
        </div>
      </div>
      
      <div class="modal-section" v-if="selectedAppointment.extendedProps.PatientNote">
        <h4 class="section-title">
          <i class="bx bx-note"></i> Notes
        </h4>
        <div class="notes-container">
          {{ selectedAppointment.extendedProps.PatientNote }}
        </div>
      </div>
      
      <div class="modal-section" v-if="selectedAppointment.extendedProps.MedicalHistory">
        <h4 class="section-title">
          <i class="bx bx-plus-medical"></i> Medical History
        </h4>
        <div class="notes-container">
          {{ selectedAppointment.extendedProps.MedicalHistory }}
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <!-- Removed both buttons as requested, keeping only the X in the header -->
    </div>
  </div>
</div>
</template>

<script>
import axios from "axios";
import FullCalendar from '@fullcalendar/vue3';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';
import Swal from 'sweetalert2';

export default {
name: "DentistCalendarSchedule",
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
  upcomingAppointments() {
    // Sort appointments by date
    return [...this.calendarOptions.events]
      .filter(event => new Date(event.start) >= new Date())
      .sort((a, b) => new Date(a.start) - new Date(b.start));
  },
  paginatedAppointments() {
    // Return paginated appointments based on currentPage
    const startIndex = (this.currentPage - 1) * this.itemsPerPage;
    const endIndex = startIndex + this.itemsPerPage;
    return this.upcomingAppointments.slice(startIndex, endIndex);
  },
  todayAppointments() {
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    const tomorrow = new Date(today);
    tomorrow.setDate(tomorrow.getDate() + 1);
    
    return this.calendarOptions.events.filter(event => {
      const eventDate = new Date(event.start);
      return eventDate >= today && eventDate < tomorrow;
    }).length;
  },
  weekAppointments() {
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    const startOfWeek = new Date(today);
    startOfWeek.setDate(today.getDate() - today.getDay());
    const endOfWeek = new Date(startOfWeek);
    endOfWeek.setDate(startOfWeek.getDate() + 7);
    
    return this.calendarOptions.events.filter(event => {
      const eventDate = new Date(event.start);
      return eventDate >= startOfWeek && eventDate < endOfWeek;
    }).length;
  },
  monthAppointments() {
    const today = new Date();
    const startOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
    const endOfMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0);
    
    return this.calendarOptions.events.filter(event => {
      const eventDate = new Date(event.start);
      return eventDate >= startOfMonth && eventDate <= endOfMonth;
    }).length;
  },
  canEditAppointment() {
    if (!this.selectedAppointment) return false;
    
    // Check if appointment is in the future
    const now = new Date();
    const appointmentDate = new Date(this.selectedAppointment.start);
    return appointmentDate > now;
  }
},
components: {
  FullCalendar,
},
data() {
  return {
    calendarOptions: {
      plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
      initialView: 'dayGridMonth',
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      buttonText: {
        today: 'Today',
        month: 'Month',
        week: 'Week',
        day: 'Day',
      },
      events: [],
      eventContent: function(arg) {
        const services = arg.event.extendedProps.Services && arg.event.extendedProps.Services.length > 0 
          ? arg.event.extendedProps.Services.join(', ') 
          : 'N/A';
        
        const now = new Date();
        const appointmentDate = new Date(arg.event.start);
        const status = appointmentDate < now ? 'finished' : 'unfinished';
        
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
            <div class="event-patient-name">${arg.event.extendedProps.PatientName}</div>
            <div class="event-time">${startTime} - ${endTime}</div>
            <div class="event-services">${services}</div>
          </div>` 
        };
      },
      dateClick: function(info) {
        info.view.calendar.changeView('timeGridDay', info.dateStr);
      },
      eventClick: this.handleEventClick,
      eventClassNames: function(arg) {
        const now = new Date();
        const appointmentDate = new Date(arg.event.start);
        const status = appointmentDate < now ? 'event-finished' : 'event-unfinished';
        return [status];
      },
      eventTimeFormat: {
        hour: '2-digit',
        minute: '2-digit',
        meridiem: 'short'
      },
      // Added maxEvents property to handle many events in a day
      dayMaxEvents: 1, // Show only 3 events, then show a "+X more" link
      height: 'auto',
      // Add dayCellClassNames to style past dates
      dayCellClassNames: function(arg) {
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        
        if (arg.date < today) {
          return ['past-date'];
        }
        return [];
      }
    },
    showModal: false,
    selectedAppointment: null,
    itemsPerPage: 10, // Number of appointments per page
    currentPage: 1 // Current page for pagination
  };
},
mounted() {
  this.fetchAppointments();

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
  let sidebarBtn = document.querySelector(".bx-menu");
  console.log(sidebar);
  sidebarBtn.addEventListener("click", ()=> {
      sidebar.classList.toggle("close"); 
      // Handle mobile overlay
      const overlay = document.querySelector(".mobile-overlay");
      if (window.innerWidth <= 768) {
        overlay.classList.toggle("active");
      }
  });

  // Add event listener for escape key to close modal
  document.addEventListener('keydown', this.handleKeyDown);
},
beforeUnmount() {
  // Remove event listener when component is destroyed
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
  async fetchAppointments() {
    try {
      const response = await axios.get('/dentist/appointments');
      console.log("Fetched Appointments:", response.data);

      if (response.data && response.data.length > 0) {
        this.calendarOptions.events = response.data.map((appointment) => ({
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

        this.calendarOptions.events = [...this.calendarOptions.events];
        this.currentPage = 1;

        console.log("Formatted Events:", this.calendarOptions.events);
      } else {
        console.warn("No appointments found");
      }
    } catch (error) {
      console.error("Error fetching appointments:", error);
    }
  },
  formatDate(dateString) {
    if (!dateString) return 'N/A';
    
    try {
      const date = new Date(dateString);
      if (isNaN(date.getTime())) return 'N/A'; // Check for invalid date
      
      return date.toLocaleDateString('en-US', { 
        weekday: 'long', 
        month: 'long', 
        day: 'numeric',
        year: 'numeric'
      });
    } catch (error) {
      console.error("Error formatting date:", error);
      return 'N/A';
    }
  },
  formatTime(dateString) {
    if (!dateString) return 'N/A';
    
    try {
      const date = new Date(dateString);
      if (isNaN(date.getTime())) return 'N/A'; // Check for invalid date
      
      return date.toLocaleTimeString('en-US', { 
        hour: '2-digit', 
        minute: '2-digit',
        hour12: true
      });
    } catch (error) {
      console.error("Error formatting time:", error);
      return 'N/A';
    }
  },
  getEndTime(startTimeString) {
    if (!startTimeString) return 'N/A';
    
    try {
      // Default appointment duration is 1 hour if no end time is specified
      const startTime = new Date(startTimeString);
      if (isNaN(startTime.getTime())) return 'N/A'; // Check for invalid date
      
      const endTime = new Date(startTime);
      endTime.setHours(startTime.getHours() + 1);
      return endTime.toLocaleTimeString('en-US', { 
        hour: '2-digit', 
        minute: '2-digit',
        hour12: true
      });
    } catch (error) {
      console.error("Error calculating end time:", error);
      return 'N/A';
    }
  },
  getStatus(appointment) {
    const now = new Date();
    const appointmentDate = new Date(appointment.start);
    
    if (appointmentDate < now) {
      return 'Finished';
    }
    
    return 'Unfinished';
  },
  getStatusClass(appointment) {
    const status = this.getStatus(appointment);
    
    if (status === 'Finished') {
      return 'status-finished';
    } else {
      return 'status-unfinished';
    }
  },
  handleEventClick(info) {
    // Open modal with appointment details when calendar event is clicked
    this.openAppointmentDetails(info.event);
  },
  openAppointmentDetails(appointment) {
    this.selectedAppointment = appointment;
    this.showModal = true;
    // Prevent scrolling of the background when modal is open
    document.body.style.overflow = 'hidden';
  },
  closeModal() {
    this.showModal = false;
    this.selectedAppointment = null;
    // Re-enable scrolling
    document.body.style.overflow = 'auto';
  },
  handleKeyDown(e) {
    if (e.key === 'Escape' && this.showModal) {
      this.closeModal();
    }
  }
  // Removed editAppointment method as it's no longer needed
},
};
</script>

<style scoped>
/* Keep all existing styles */
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

/* Calendar Legend - New Styles */
.calendar-legend {
background: white;
border-radius: 10px;
padding: 15px 20px;
margin-bottom: 15px;
box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
display: flex;
flex-wrap: wrap;
align-items: center;
gap: 15px;
}

.legend-title {
font-weight: 600;
color: #06693a;
margin-right: 10px;
}

.legend-items {
display: flex;
flex-wrap: wrap;
gap: 15px;
}

.legend-item {
display: flex;
align-items: center;
gap: 6px;
}

.legend-color {
width: 16px;
height: 16px;
border-radius: 4px;
}

/* Status colors for legend - Updated to match HR calendar */
.legend-color.finished {
background-color: #06693a;
}

.legend-color.unfinished {
background-color: #f5f5f5;
border: 1px solid #ddd;
}

.legend-label {
font-size: 0.9rem;
color: #444;
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
margin-bottom: 20px;
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

/* Calendar container */
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

.status-badge {
display: inline-block;
padding: 4px 10px;
border-radius: 20px;
font-size: 0.75rem;
font-weight: 500;
}

/* Status badge colors - Updated to match HR calendar */
.status-finished {
background: #e8f5e9;
color: #06693a;
}

.status-unfinished {
background: #f5f5f5;
color: #555;
border: 1px solid #ddd;
}

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

.modal-container {
background-color: white;
border-radius: 10px;
width: 90%;
max-width: 600px;
max-height: 90vh;
overflow-y: auto;
box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
display: flex;
flex-direction: column;
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

.appointment-status-banner i {
font-size: 1.3rem;
}

.services-grid {
display: grid;
grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
gap: 10px;
}

.service-item {
display: flex;
align-items: center;
gap: 8px;
background: #f0f8f4;
padding: 8px 12px;
border-radius: 6px;
color: #06693a;
}

.service-item i {
font-size: 1.1rem;
}

.no-services {
grid-column: 1 / -1;
color: #666;
font-style: italic;
padding: 10px;
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
}

.btn-primary:hover {
background: #055a32;
}

/* Pagination Controls - New Styles */
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

/* Event status colors - Updated to match HR calendar */
.event-finished {
background-color: #06693a !important;
color: white !important;
}

.event-unfinished {
background-color: #f5f5f5 !important;
color: #333 !important;
border: 1px solid #ddd !important;
}

/* New style for past dates - more prominent gray background */
.past-date {
  background-color: #f0f0f0 !important;
}

.past-date .fc-daygrid-day-frame {
  background-color: #e6e6e6 !important;
}

.past-date .fc-daygrid-day-number {
  color: #999 !important;
}

/* Responsive adjustments */

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

.summary-table th:nth-child(4),
.summary-table td:nth-child(4) {
  display: none;
}

.modal-container {
  width: 95%;
  max-width: 500px;
}

.detail-row {
  flex-direction: column;
  gap: 10px;
}

.detail-item {
  min-width: 100%;
}

.services-grid {
  grid-template-columns: 1fr 1fr;
}

.pagination-controls {
  flex-direction: column;
  gap: 10px;
  align-items: flex-start;
}

.calendar-legend {
  flex-direction: column;
  align-items: flex-start;
  gap: 10px;
}

.legend-items {
  width: 100%;
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

.calendar-legend {
  padding: 12px 15px;
  border-radius: 8px;
}

.legend-title {
  font-size: 14px;
}

.legend-label {
  font-size: 0.85rem;
}

.calendar-container {
  padding: 15px;
  border-radius: 8px;
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

.modal-container {
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

.services-grid {
  grid-template-columns: 1fr;
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

.calendar-legend {
  padding: 10px 12px;
}

.legend-title {
  font-size: 13px;
}

.legend-label {
  font-size: 0.8rem;
}

.calendar-container {
  padding: 12px;
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
}

/* Landscape Mobile */
@media (max-height: 500px) and (orientation: landscape) {
.modal-container {
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
}
</style>

<style>
/* Keep all existing global styles */
.dentist-calendar {
font-family: 'Poppins', sans-serif;
color: #06693a;
}

/* Calendar header and navigation */
.fc .fc-toolbar {
margin-bottom: 1.5em !important;
}

.fc .fc-toolbar-title {
font-size: 1.5rem !important;
font-weight: 600 !important;
}

.fc .fc-button-primary {
background-color: #06693a !important;
border-color: #06693a !important;
box-shadow: none !important;
padding: 8px 16px !important;
font-weight: 500 !important;
transition: background-color 0.2s !important;
}

.fc .fc-button-primary:hover {
background-color: #054d2c !important;
border-color: #054d2c !important;
}

.fc-button.fc-button-active {
background-color: #06693a !important;
border-color: #06693a !important;
color: white !important;
}

.fc-today-button {
background-color: #06693a !important;
border-color: #06693a !important;
color: white !important;
}

.fc-today-button:disabled {
opacity: 0.7 !important;
}

/* Calendar day cells */
.fc .fc-daygrid-day-frame {
padding: 8px 4px !important;
}

.fc .fc-daygrid-day-number {
font-size: 0.9rem !important;
font-weight: 500 !important;
color: #444 !important;
}

.fc .fc-day-today {
background-color: #f0f8f4 !important;
}

.fc .fc-day-today .fc-daygrid-day-number {
color: #06693a !important;
font-weight: 600 !important;
}

/* Event styling - Updated to match HR calendar */
.fc-event {
border-radius: 4px !important;
border: none !important;
box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;
margin: 2px 0 !important;
cursor: pointer !important;
padding: 0 !important;
overflow: hidden !important;
}

.fc-daygrid-event {
padding: 0 !important;
}

/* Event content styling */
.fc-event-content {
padding: 8px 10px !important;
height: 100% !important;
}

.event-patient-name {
font-weight: 600 !important;
font-size: 0.85rem !important;
white-space: nowrap !important;
overflow: hidden !important;
text-overflow: ellipsis !important;
margin-bottom: 2px !important;
}

.event-time {
font-size: 0.75rem !important;
opacity: 0.9 !important;
margin-bottom: 2px !important;
}

.event-services {
font-size: 0.75rem !important;
opacity: 0.8 !important;
white-space: nowrap !important;
overflow: hidden !important;
text-overflow: ellipsis !important;
}

/* Status-specific event styling - Updated to match HR calendar */
.event-finished {
background-color: #06693a !important;
}

.event-finished .fc-event-content {
color: white !important;
}

.event-unfinished {
background-color: #f5f5f5 !important;
}

.event-unfinished .fc-event-content {
color: #333 !important;
}

.fc-timeGridDay-view .fc-event {
padding: 0 !important;
}

/* Time grid view */
.fc-timegrid-slot {
height: 3em !important;
}

.fc-timegrid-slot-label {
font-size: 0.8rem !important;
color: #666 !important;
}

/* Past dates styling */
.past-date .fc-daygrid-day-number {
color: #999 !important;
}

/* Style for the "more" link when there are too many events */
.fc-daygrid-more-link {
background: #f0f8f4 !important;
color: #06693a !important;
font-weight: 500 !important;
padding: 2px 5px !important;
border-radius: 4px !important;
margin-top: 2px !important;
}

.fc-daygrid-more-link:hover {
background: #e0f0e8 !important;
}

/* Popup that shows when clicking the "more" link */
.fc-popover {
border: none !important;
box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
border-radius: 8px !important;
}

.fc-popover-header {
background: #f0f8f4 !important;
color: #06693a !important;
padding: 8px 10px !important;
font-weight: 500 !important;
border-top-left-radius: 8px !important;
border-top-right-radius: 8px !important;
}

.fc-popover-body {
padding: 10px !important;
}

/* Responsive adjustments for FullCalendar */
@media (max-width: 768px) {
.fc .fc-toolbar {
  flex-direction: column !important;
  gap: 10px !important;
}

.fc .fc-toolbar-title {
  font-size: 1.2rem !important;
}

.fc-header-toolbar .fc-toolbar-chunk:last-child {
  display: flex !important;
  flex-wrap: wrap !important;
  justify-content: center !important;
  gap: 5px !important;
}

.fc .fc-button-primary {
  padding: 6px 12px !important;
  font-size: 0.85rem !important;
}

.event-patient-name {
  font-size: 0.8rem !important;
}

.event-time {
  font-size: 0.7rem !important;
}

.event-services {
  font-size: 0.7rem !important;
}
}

@media (max-width: 480px) {
.fc .fc-toolbar-title {
  font-size: 1.1rem !important;
}

.fc .fc-button-primary {
  padding: 5px 10px !important;
  font-size: 0.8rem !important;
}

.fc .fc-daygrid-day-number {
  font-size: 0.8rem !important;
}

.event-patient-name {
  font-size: 0.75rem !important;
}

.event-time {
  font-size: 0.65rem !important;
}

.event-services {
  font-size: 0.65rem !important;
}
}

/* New style for past dates - darker gray background and no hover effect */
.past-date {
  background-color: #e0e0e0 !important;
}

.past-date .fc-daygrid-day-frame {
  background-color: #e8e8e8 !important;
}

.past-date .fc-daygrid-day-number {
  color: #888 !important;
}

/* Disable hover effects on past dates */
.past-date:hover {
  background-color: #e0e0e0 !important;
}

.past-date .fc-daygrid-day-frame:hover {
  background-color: #e8e8e8 !important;
  cursor: default !important;
}

/* Make sure events in past dates are still clickable */
.past-date .fc-event {
  cursor: pointer !important;
}

/* NEW STYLES: Change text color in day view (timeGridDay) to white */
.fc-timeGridDay-view .fc-event-content {
  color: white !important;
}

/* Keep calendar view (dayGridMonth) text color as black */
.fc-dayGridMonth-view .fc-event-content {
  color: black !important;
}

/* Ensure unfinished events in day view have white text */
.fc-timeGridDay-view .event-unfinished .fc-event-content {
  color: white !important;
}

/* Ensure unfinished events in calendar view have black text */
.fc-dayGridMonth-view .event-unfinished .fc-event-content {
  color: black !important;
}
</style>
