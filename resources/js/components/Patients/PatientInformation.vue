<template>
  <div class="sidebar close">
    <div class="logo-details">
      <img src="@/components/Images/ATDC_Logo.png" alt="" class="logo">
      <div class="logo_name"><img class="img2" src="@/components/Images/ATDC_Logo3.png" alt=""></div>
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
          <h3>Patient Information</h3>
          <div class="breadcrumbs">
            <a class="none" href=""><p>Home / </p></a>
            <a class="current" href="/patientinformation"><p>Patient Information</p></a>
          </div>
        </div>
      </div>
    </div>
    <hr color="#06693a">

    <section class="patient-info">
      <div class="patient-info">
        <div class="info-container">
          <div class="photo-section">
            <div class="photo-wrapper">
              <img :src="patientData.profilePicture ? `/storage/${patientData.profilePicture}` : '/images/profile_1.jpg'" alt="Patient Photo">
              <div class="photo-overlay" @click="triggerFileInput">
                <i class="bx bx-camera"></i>
              </div>
              <input type="file" ref="profilePictureInput" @change="handleFileUpload" accept="image/*" style="display: none;">
            </div>
            <p class="patient-name">{{ fullName }}</p>
            <div class="patient-id-badge">
              <i class="bx bx-id-card"></i>
              <span>{{ patientData.patientId || 'Not available' }}</span>
            </div>
            <button class="edit-btn" @click="handleEditClick">
              <i class="bx bx-edit"></i> Edit Information
            </button>
            <!-- Added View ID Button -->
            <button class="view-id-btn" @click="showIdModal = true">
              <i class="bx bx-id-card"></i> View Valid ID
            </button>
          </div>
          
          <div class="details-section">
            <div class="section-title">
              <i class="bx bx-user-circle"></i>
              <h4>Personal Information</h4>
            </div>
            
            <div class="info-grid">
              <div class="info-item">
                <p class="info-label">Age</p>
                <p class="info-value">{{ patientData.age || 'Not provided' }}</p>
              </div>
              
              <div class="info-item">
                <p class="info-label">Birthdate</p>
                <p class="info-value">{{ patientData.birthdate || 'Not provided' }}</p>
              </div>
              
              <div class="info-item">
                <p class="info-label">Gender</p>
                <p class="info-value">{{ patientData.gender || 'Not provided' }}</p>
              </div>
              
              <div class="info-item">
                <p class="info-label">Religion</p>
                <p class="info-value">{{ patientData.religion || 'Not provided' }}</p>
              </div>
              
              <div class="info-item">
                <p class="info-label">Nationality</p>
                <p class="info-value">{{ patientData.nationality || 'Not provided' }}</p>
              </div>
              
              <div class="info-item">
                <p class="info-label">Civil Status</p>
                <p class="info-value">{{ patientData.status || 'Not provided' }}</p>
              </div>
            </div>
            
            <div class="section-title">
              <i class="bx bx-home-alt"></i>
              <h4>Contact Information</h4>
            </div>
            
            <div class="info-grid">
              <div class="info-item info-item-wide">
                <p class="info-label">Home Address</p>
                <p class="info-value">{{ patientData.address || 'Not provided' }}</p>
              </div>
              
              <div class="info-item">
                <p class="info-label">Occupation</p>
                <p class="info-value">{{ patientData.occupation || 'Not provided' }}</p>
              </div>
              
              <div class="info-item">
                <p class="info-label">Email</p>
                <p class="info-value">{{ patientData.email || 'Not provided' }}</p>
              </div>
              
              <div class="info-item">
                <p class="info-label">Contact Number</p>
                <p class="info-value">{{ patientData.contactNumber || 'Not provided' }}</p>
              </div>
              
              <div class="info-item">
                <p class="info-label">Telephone Number</p>
                <p class="info-value">{{ patientData.telephoneNumber || 'Not provided' }}</p>
              </div>
              
              <div class="info-item">
                <p class="info-label">Office Number</p>
                <p class="info-value">{{ patientData.officeNumber || 'Not provided' }}</p>
              </div>
            </div>
            
            <div class="section-title">
              <i class="bx bx-shield-quarter"></i>
              <h4>Guardian Information</h4>
            </div>
            
            <div class="info-grid">
              <div class="info-item">
                <p class="info-label">Guardian Name</p>
                <p class="info-value">{{ patientData.guardianName || 'Not provided' }}</p>
              </div>
              
              <div class="info-item">
                <p class="info-label">Guardian Tel. Number</p>
                <p class="info-value">{{ patientData.guardianTel || 'Not provided' }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Edit Information Modal -->
      <div class="modal-overlay" v-if="showEditModal" @click="showEditModal = false">
        <div class="modal-container" @click.stop>
          <div class="modal-header">
            <h3>Edit Patient Information</h3>
            <button class="close-btn" @click="showEditModal = false">
              <i class="bx bx-x"></i>
            </button>
          </div>
          
          <div class="modal-body">
            <div class="modal-photo-section">
              <div class="modal-photo-wrapper">
                <img :src="patientData.profilePicture ? `/storage/${patientData.profilePicture}` : '/images/profile_1.jpg'" alt="Patient Photo" class="modal-patient-photo">
                <div class="modal-photo-overlay" @click="$refs.profilePictureInput.click()">
                  <i class="bx bx-camera"></i>
                  <span>Change Photo</span>
                </div>
              </div>
            </div>
            
            <div class="form-section">
              <h4 class="form-section-title">
                <i class="bx bx-user-circle"></i>
                Personal Information
              </h4>
              
              <div class="form-row">
                <div class="form-group">
                  <label for="firstName">First Name</label>
                  <input type="text" id="firstName" v-model="editedPatient.firstName" class="form-control" disabled>
                </div>
                
                <div class="form-group">
                  <label for="lastName">Last Name</label>
                  <input type="text" id="lastName" v-model="editedPatient.lastName" class="form-control" disabled>
                </div>
              </div>
              
              <div class="form-row">
                <div class="form-group">
                  <label for="birthdate">Birthdate</label>
                  <input type="date" id="birthdate" v-model="editedPatient.birthdate" class="form-control" disabled>
                </div>
                
                <div class="form-group">
                  <label for="gender">Gender</label>
                  <select id="gender" v-model="editedPatient.gender" class="form-control" disabled>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                  </select>
                </div>
              </div>
              
              <div class="form-row">
                <div class="form-group">
                  <label for="religion">Religion</label>
                  <input type="text" id="religion" v-model="editedPatient.religion" class="form-control" disabled>
                </div>
                
                <div class="form-group">
                  <label for="nationality">Nationality</label>
                  <input type="text" id="nationality" v-model="editedPatient.nationality" class="form-control" disabled>
                </div>
              </div>
              
              <div class="form-row">
                <div class="form-group">
                  <label for="status">Civil Status</label>
                  <select id="status" v-model="editedPatient.status" class="form-control">
                    <option value="Single">Single</option>
                    <option value="Married">Married</option>
                    <option value="Divorced">Divorced</option>
                    <option value="Widowed">Widowed</option>
                  </select>
                </div>
                
                <div class="form-group">
                  <label for="occupation">Occupation</label>
                  <input type="text" id="occupation" v-model="editedPatient.occupation" class="form-control">
                </div>
              </div>
              
              <h4 class="form-section-title">
                <i class="bx bx-home-alt"></i>
                Contact Information
              </h4>
              
              <div class="form-group full-width">
                <label for="address">Home Address</label>
                <input type="text" id="address" v-model="editedPatient.address" class="form-control">
              </div>
              
              <div style="margin-top: 15px;" class="form-row">
                <div class="form-group">
                  <label for="email">Email <span>*</span> <span class="hint-text">example@domain.com</span></label>
                  <input 
                    type="email" 
                    id="email" 
                    v-model="editedPatient.email" 
                    class="form-control"
                    required
                    @input="validateEmail"
                    @blur="checkEmailAvailability"
                    :class="{ 'is-invalid': emailInvalid }"
                  >
                  <div v-if="emailInvalid" class="invalid-feedback">
                    {{ emailErrorMessage }}
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="contactNumber">Contact Number <span>*</span> <span class="hint-text">+63 XXX XXX XXXX</span></label>
                  <input 
                    type="tel" 
                    id="contactNumber" 
                    v-model="editedPatient.contactNumber" 
                    class="form-control"
                    required
                    placeholder="+63"
                    @input="validateContactNumber"
                    @focus="prefixContactNumber"
                    maxlength="13"
                    :class="{ 'is-invalid': contactNumberInvalid }"
                  >
                  <div v-if="contactNumberInvalid" class="invalid-feedback">
                    Please enter a valid contact number (+63 followed by 10 digits)
                  </div>
                </div>
              </div>
              
              <div class="form-row">
                <div class="form-group">
                  <label for="telephoneNumber">Telephone Number <span class="hint-text">02 XXXX XXXX</span></label>
                  <input 
                    type="tel" 
                    id="telephoneNumber" 
                    v-model="editedPatient.telephoneNumber" 
                    class="form-control"
                    placeholder="02"
                    @input="validateTelephoneNumber"
                    @focus="prefixTelephoneNumber"
                    maxlength="10"
                    :class="{ 'is-invalid': telephoneNumberInvalid }"
                  >
                  <div v-if="telephoneNumberInvalid" class="invalid-feedback">
                    Please enter a valid telephone number (02 followed by 8 digits)
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="officeNumber">Office Number <span class="hint-text">02 XXXX XXXX</span></label>
                  <input 
                    type="tel" 
                    id="officeNumber" 
                    v-model="editedPatient.officeNumber" 
                    class="form-control"
                    placeholder="02"
                    @input="validateOfficeNumber"
                    @focus="prefixOfficeNumber"
                    maxlength="10"
                    :class="{ 'is-invalid': officeNumberInvalid }"
                  >
                  <div v-if="officeNumberInvalid" class="invalid-feedback">
                    Please enter a valid office number (02 followed by 8 digits)
                  </div>
                </div>
              </div>
              
              <h4 class="form-section-title">
                <i class="bx bx-shield-quarter"></i>
                Guardian Information
              </h4>
              
              <div class="form-row">
                <div class="form-group">
                  <label for="guardianName">Guardian Name</label>
                  <input type="text" id="guardianName" v-model="editedPatient.guardianName" class="form-control">
                </div>
                
                <div class="form-group">
                  <label for="guardianTel">Guardian Tel. Number</label>
                  <input type="tel" id="guardianTel" v-model="editedPatient.guardianTel" class="form-control">
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="cancel-btn" @click="showEditModal = false">Cancel</button>
              <button type="button" class="save-btn" @click="handleSaveChanges">Save Changes</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Confirmation Modal for Save Changes -->
      <div class="modal-overlay" v-if="showConfirmModal" @click="showConfirmModal = false">
        <div class="confirm-modal-container" @click.stop>
          <div class="confirm-modal-header">
            <h3>Confirm Save Changes</h3>
            <button class="close-btn" @click="showConfirmModal = false">
              <i class="bx bx-x"></i>
            </button>
          </div>
          <div class="confirm-modal-body">
            <p>Are you sure you want to save your changes?</p>
          </div>
          <div class="confirm-modal-footer">
            <button class="confirm-cancel-btn" @click="showConfirmModal = false">No, Cancel</button>
            <button class="confirm-save-btn" @click="confirmSaveChanges">Yes, Save</button>
          </div>
        </div>
      </div>

      <!-- Confirmation Modal for Changing Profile Picture -->
      <div class="modal-overlay" v-if="showChangePhotoModal" @click="showChangePhotoModal = false">
        <div class="confirm-modal-container" @click.stop>
          <div class="confirm-modal-header">
            <h3>Confirm Change Photo</h3>
            <button class="close-btn" @click="showChangePhotoModal = false">
              <i class="bx bx-x"></i>
            </button>
          </div>
          <div class="confirm-modal-body">
            <p>Are you sure you want to change your profile picture?</p>
          </div>
          <div class="confirm-modal-footer">
            <button class="confirm-cancel-btn" @click="showChangePhotoModal = false">No, Cancel</button>
            <button class="confirm-save-btn" @click="confirmChangePhoto">Yes, Change</button>
          </div>
        </div>
      </div>

      <!-- Edit Limit Modal -->
      <div class="modal-overlay" v-if="showEditLimitModal" @click="showEditLimitModal = false">
        <div class="confirm-modal-container" @click.stop>
          <div class="confirm-modal-header">
            <h3>Edit Limit Reached</h3>
            <button class="close-btn" @click="showEditLimitModal = false">
              <i class="bx bx-x"></i>
            </button>
          </div>
          <div class="confirm-modal-body">
            <p>You have reached the maximum number of edits (3). Editing is now disabled.</p>
          </div>
          <div class="confirm-modal-footer">
            <button class="confirm-save-btn" @click="showEditLimitModal = false">OK</button>
          </div>
        </div>
      </div>

      <!-- Simplified Valid ID Modal -->
    <div class="modal-overlay" v-if="showIdModal" @click="showIdModal = false">
      <div class="id-modal-container" @click.stop>
        <div class="confirm-modal-header">
          <h3>Valid ID</h3>
          <button class="close-btn" @click="showIdModal = false">
            <i class="bx bx-x"></i>
          </button>
        </div>
        <div class="id-modal-body">
          <div class="id-image-container">
            <img 
              v-if="patientData.GovernmentID"
              :src="`/storage/${patientData.GovernmentID}`"
              alt="Valid ID" 
              class="valid-id-image"
              @error="handleImageError"
            >
            <p v-else class="no-id-text">No government ID uploaded</p>
          </div>
        </div>
      </div>
    </div>
    </section>
  </section>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2'; // Import SweetAlert2

export default {
  name: "PatientInformation",
  props: {
    patientId: {
      type: String,
      required: true,
    },
    age: {
      type: String,
      required: true,
    },
    firstName: {
      type: String,
      required: true,
    },
    lastName: {
      type: String,
      required: true,
    },
    email: {
      type: String,
      required: true,
    },
    gender: {
      type: String,
      required: true,
    },
    birthdate: {
      type: String,
      required: true,
    },
    contactNumber: {
      type: String,
      required: true,
    },
    religion: {
      type: String,
      required: true,
    },
    nationality: {
      type: String,
      required: true,
    },
    status: {
      type: String,
      required: true,
    },
    address: {
      type: String,
      required: true,
    },
    telephoneNumber: {
      type: String,
      required: true,
    },
    occupation: {
      type: String,
      required: true,
    },
    officeNumber: {
      type: String,
      required: true,
    },
    guardianName: {
      type: String,
      default: '',
    },
    guardianTel: {
      type: String,
      default: '',
    },
    recordCreatedDate: {
      type: String,
      default: '',
    },
    profilePicture: {
      type: String,
      default: null,
    },
    GovernmentID: {
      type: String,
      default: null,
    },
    validIdType: {
      type: String,
      default: '',
    },
    validIdNumber: {
      type: String,
      default: '',
    },
    validIdIssueDate: {
      type: String,
      default: '',
    },
  },
  data() {
    return {
      showEditModal: false,
      showConfirmModal: false,
      showChangePhotoModal: false, // New modal state
      showEditLimitModal: false,
      showIdModal: false,
      editCount: 0,
      editedPatient: {},
      patientData: {},
      emailInvalid: false,
      emailErrorMessage: '',
      contactNumberInvalid: false,
      telephoneNumberInvalid: false,
      officeNumberInvalid: false,
    };
  },
  computed: {
    fullName() {
      return `${this.patientData.firstName || 'Unknown'} ${this.patientData.lastName || ''}`;
    },
    isEditDisabled() {
      return this.editCount >= 3;
    },
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
    // Fixed sidebar methods to match owner announcements exactly
    closeMobileSidebar() {
      const sidebar = document.querySelector(".sidebar");
      const overlay = document.querySelector(".mobile-overlay");
      if (window.innerWidth <= 768) {
        sidebar.classList.add("close");
        overlay.classList.remove("active");
      }
    },
    async fetchPatientData() {
      try {
        const response = await axios.get('/api/patient-data');
        if (response.data.success) {
          this.patientData = response.data.patient;
          this.editedPatient = { ...this.patientData };
          console.log('Fetched patient data:', this.patientData);
          console.log('Fetched GovernmentID:', this.patientData.GovernmentID);
        } else {
          console.error('Failed to fetch patient data:', response.data.message);
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to fetch patient data. Please try again.',
            showConfirmButton: false,
            timer: 1500,
            customClass: {
              popup: 'sweetalert-theme',
              title: 'sweetalert-title',
              content: 'sweetalert-content',
            },
          });
        }
      } catch (error) {
        console.error('Error fetching patient data:', error);
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Error fetching patient data. Please try again.',
          showConfirmButton: false,
          timer: 1500,
          customClass: {
            popup: 'sweetalert-theme',
            title: 'sweetalert-title',
            content: 'sweetalert-content',
          },
        });
      }
    },
    async fetchPatientId() {
      try {
        const response = await axios.get('/api/patient-id');
        return response.data.patient_id;
      } catch (error) {
        console.error('Error fetching patient ID:', error);
        return null;
      }
    },
    validateEmail() {
      if (!this.editedPatient.email) {
        this.emailInvalid = true;
        this.emailErrorMessage = 'Email is required';
        return;
      }
      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailPattern.test(this.editedPatient.email)) {
        this.emailInvalid = true;
        this.emailErrorMessage = 'Please enter a valid email address';
      } else {
        this.emailInvalid = false;
        this.emailErrorMessage = '';
      }
    },
    async checkEmailAvailability() {
      if (!this.emailInvalid && this.editedPatient.email !== this.patientData.email) {
        try {
          const response = await axios.post('/users/check-email', {
            email: this.editedPatient.email,
          });
          if (response.data.exists) {
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
      }
    },
    validateContactNumber() {
      if (!this.editedPatient.contactNumber) {
        this.contactNumberInvalid = true;
      } else if (!this.editedPatient.contactNumber.match(/^\+63\d{10}$/)) {
        this.contactNumberInvalid = true;
      } else {
        this.contactNumberInvalid = false;
      }
    },
    validateTelephoneNumber() {
      if (this.editedPatient.telephoneNumber && !this.editedPatient.telephoneNumber.match(/^02\d{8}$/)) {
        this.telephoneNumberInvalid = true;
      } else {
        this.telephoneNumberInvalid = false;
      }
    },
    validateOfficeNumber() {
      if (this.editedPatient.officeNumber && !this.editedPatient.officeNumber.match(/^02\d{8}$/)) {
        this.officeNumberInvalid = true;
      } else {
        this.officeNumberInvalid = false;
      }
    },
    prefixContactNumber() {
      if (!this.editedPatient.contactNumber || !this.editedPatient.contactNumber.startsWith('+63')) {
        this.editedPatient.contactNumber = '+63';
      }
    },
    prefixTelephoneNumber() {
      if (!this.editedPatient.telephoneNumber || !this.editedPatient.telephoneNumber.startsWith('02')) {
        this.editedPatient.telephoneNumber = '02';
      }
    },
    prefixOfficeNumber() {
      if (!this.editedPatient.officeNumber || !this.editedPatient.officeNumber.startsWith('02')) {
        this.editedPatient.officeNumber = '02';
      }
    },
    async handleEditClick() {
      if (this.isEditDisabled) {
        console.log("Edit limit reached, showing Edit Limit Modal");
        this.showEditLimitModal = true;
        return;
      }
      this.emailInvalid = false;
      this.emailErrorMessage = '';
      this.contactNumberInvalid = false;
      this.telephoneNumberInvalid = false;
      this.officeNumberInvalid = false;
      this.showEditModal = true;
    },
    async handleSaveChanges() {
      // Run validations
      this.validateEmail();
      this.validateContactNumber();
      this.validateTelephoneNumber();
      this.validateOfficeNumber();
      await this.checkEmailAvailability();

      // Prevent submission if any validation fails
      if (this.emailInvalid || this.contactNumberInvalid || this.telephoneNumberInvalid || this.officeNumberInvalid) {
        return;
      }

      // Proceed to confirmation modal (original behavior)
      this.showConfirmModal = true;
    },
    async confirmSaveChanges() {
      let patientId = this.patientData.patientId;

      if (!patientId || patientId !== '30') {
        patientId = await this.fetchPatientId();
        if (!patientId) {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error: Could not fetch Patient ID. Please log in again.',
            showConfirmButton: false,
            timer: 1500,
            customClass: {
              popup: 'sweetalert-theme',
              title: 'sweetalert-title',
              content: 'sweetalert-content',
            },
          });
          this.showConfirmModal = false;
          this.showEditModal = false;
          return;
        }
        this.patientData.patientId = patientId;
      }

      if (this.isEditDisabled) {
        this.showEditModal = false;
        this.showConfirmModal = false;
        this.showEditLimitModal = true;
        return;
      }

      this.editCount++;

      const payload = {
        firstName: this.editedPatient.firstName,
        lastName: this.editedPatient.lastName,
        birthdate: this.editedPatient.birthdate,
        gender: this.editedPatient.gender,
        email: this.editedPatient.email,
        contactNumber: this.editedPatient.contactNumber,
        telephoneNumber: this.editedPatient.telephoneNumber,
        officeNumber: this.editedPatient.officeNumber,
        address: this.editedPatient.address,
        religion: this.editedPatient.religion,
        nationality: this.editedPatient.nationality,
        status: this.editedPatient.status,
        occupation: this.editedPatient.occupation,
        guardianName: this.editedPatient.guardianName,
        guardianTel: this.editedPatient.guardianTel,
      };

      console.log('Sending PUT request with patientId:', patientId);

      try {
        const response = await axios.put(`/api/patients/${patientId}`, payload);
        if (response.data.success) {
          await this.fetchPatientData();
          this.showConfirmModal = false;
          this.showEditModal = false;
          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Patient information updated successfully!',
            showConfirmButton: false,
            timer: 1500,
            customClass: {
              popup: 'sweetalert-theme',
              title: 'sweetalert-title',
              content: 'sweetalert-content',
            },
          });
        } else {
          this.editCount--;
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: response.data.message || 'Failed to update patient information.',
            showConfirmButton: false,
            timer: 1500,
            customClass: {
              popup: 'sweetalert-theme',
              title: 'sweetalert-title',
              content: 'sweetalert-content',
            },
          });
        }
      } catch (error) {
        this.editCount--;
        if (error.response && error.response.status === 422) {
          const errors = error.response.data.errors;
          let errorMessage = 'Validation failed:\n';
          for (const field in errors) {
            errorMessage += `- ${errors[field].join(', ')}\n`;
          }
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: errorMessage,
            showConfirmButton: false,
            timer: 1500,
            customClass: {
              popup: 'sweetalert-theme',
              title: 'sweetalert-title',
              content: 'sweetalert-content',
            },
          });
        } else {
          console.error('Error updating patient information:', error);
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to update patient information. Please try again.',
            showConfirmButton: false,
            timer: 1500,
            customClass: {
              popup: 'sweetalert-theme',
              title: 'sweetalert-title',
              content: 'sweetalert-content',
            },
          });
        }
      }
    },
    triggerFileInput() {
      this.showChangePhotoModal = true; // Show confirmation modal instead of triggering file input
    },
    confirmChangePhoto() {
      this.showChangePhotoModal = false;
      this.$refs.profilePictureInput.click(); // Trigger file input after confirmation
    },
    showValidIdModal() {
      console.log('Government ID Image:', this.patientData.GovernmentID);
      this.showIdModal = true;
    },
    handleImageError(event) {
      console.error('Failed to load government ID image:', this.patientData.GovernmentID);
      event.target.src = '/images/id-placeholder.jpg';
    },
    async handleFileUpload(event) {
      const file = event.target.files[0];
      if (!file) return;

      const img = new Image();
      img.src = URL.createObjectURL(file);
      img.onload = () => {
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');

        canvas.width = 180;
        canvas.height = 180;

        ctx.fillStyle = '#f9f9f9';
        ctx.fillRect(0, 0, canvas.width, canvas.height);

        const scale = Math.min(180 / img.width, 180 / img.height);
        const scaledWidth = img.width * scale;
        const scaledHeight = img.height * scale;

        const offsetX = (180 - scaledWidth) / 2;
        const offsetY = (180 - scaledHeight) / 2;

        ctx.drawImage(img, offsetX, offsetY, scaledWidth, scaledHeight);

        canvas.toBlob(async (blob) => {
          const resizedImageUrl = URL.createObjectURL(blob);
          this.editedPatient.profilePicture = resizedImageUrl;

          const formData = new FormData();
          formData.append('profilePicture', blob, 'profile-image.jpg');

          const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

          try {
            const response = await axios.post('/upload-profile-picture', formData, {
              headers: {
                'Content-Type': 'multipart/form-data',
                'X-CSRF-TOKEN': csrfToken,
              },
            });

            if (response.data.success) {
              this.patientData.profilePicture = response.data.profilePicture;
              sessionStorage.setItem('user_profile_picture', response.data.profilePicture);
              Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Profile picture uploaded successfully!',
                showConfirmButton: false,
                timer: 1500,
                customClass: {
                  popup: 'sweetalert-theme',
                  title: 'sweetalert-title',
                  content: 'sweetalert-content',
                },
              });
              this.$forceUpdate();
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: response.data.message || 'Failed to upload profile picture.',
                showConfirmButton: false,
                timer: 1500,
                customClass: {
                  popup: 'sweetalert-theme',
                  title: 'sweetalert-title',
                  content: 'sweetalert-content',
                },
              });
            }
          } catch (error) {
            console.error('Error uploading profile picture:', error);
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Failed to upload profile picture. Please try again.',
              showConfirmButton: false,
              timer: 1500,
              customClass: {
                popup: 'sweetalert-theme',
                title: 'sweetalert-title',
                content: 'sweetalert-content',
              },
            });
          }
        }, 'image/jpeg');
      };
    },
  },
  mounted() {
    console.log('PatientInformation mounted with props:', this.$props);
    this.patientData = { ...this.$props };
    this.editedPatient = { ...this.$props };

    if (!this.patientData.guardianName || !this.patientData.guardianTel) {
      this.fetchPatientData();
    }

    // Fixed sidebar toggle logic to match owner announcements exactly
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
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Poppins', sans-serif;
}

/* Sidebar styles */
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
  background-color: #FFFFFF !important;
  z-index: 100;
  transition: all 0.5s ease;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.sidebar.close {
  width: 78px;
  background-color: #FFFFFF !important;
}

.sidebar .logo-details {
  height: 60px;
  width: 100%;
  display: flex;
  align-items: center;
  line-height: 50px;
  margin-top: 20px;
  background-color: #FFFFFF;
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
  background-color: #FFFFFF;
}

.sidebar.close .nav-link {
  overflow: visible;
  background-color: #FFFFFF;
}

.sidebar .nav-link::-webkit-scrollbar {
  display: none;
}

.sidebar .nav-link li {
  position: relative;
  list-style: none;
  transition: all 0.4s ease;
  background-color: #FFFFFF;
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
  background-color: #FFFFFF !important;
  padding: 6px 0;
  transition: all 0.5s ease;
  cursor: pointer;
}

.sidebar.close .profile-details {
  background-color: #FFFFFF !important;
}

.sidebar.close .profile-details {
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
  min-height: 60px;
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

.sidebar .profile-details .profile_name {
  color: #06693A;
  font-size: 16px;
  font-weight: 500;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

/* Patient Information Styles */
.patient-info {
  border-radius: 12px;
  box-shadow: 0 6px 18px rgba(0,0,0,0.08);
  margin: 30px 50px;
  background-color: #FFFFFF;
  overflow: hidden;
}

.info-container {
  display: flex;
  flex-direction: row;
}

.photo-section {
  width: 300px;
  padding: 40px 20px;
  background-color: #f9f9f9;
  display: flex;
  flex-direction: column;
  align-items: center;
  border-right: 1px solid #eaeaea;
}

.photo-wrapper {
  position: relative;
  width: 180px;
  height: 180px;
  border-radius: 50%;
  overflow: hidden;
  margin-bottom: 20px;
  box-shadow: 0 4px 12px rgba(6, 105, 58, 0.15);
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
}

.patient-photo {
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center;
}

.photo-overlay {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  background-color: rgba(6, 105, 58, 0.7);
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  opacity: 0;
  transition: opacity 0.3s ease;
}

.photo-wrapper:hover .photo-overlay {
  opacity: 1;
}

.patient-name {
  font-size: 24px;
  font-weight: 600;
  color: #333;
  margin-bottom: 10px;
  text-align: center;
}

.patient-id-badge {
  display: flex;
  align-items: center;
  background-color: #f0f7f3;
  padding: 8px 16px;
  border-radius: 20px;
  margin-bottom: 25px;
  color: #06693A;
}

.patient-id-badge i {
  margin-right: 8px;
}

.edit-btn {
  background-color: #06693A;
  color: white;
  border: none;
  border-radius: 8px;
  padding: 12px 24px;
  font-size: 16px;
  font-weight: 500;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.3s ease;
  width: 100%;
  max-width: 220px;
  margin-bottom: 15px;
}

.edit-btn:hover {
  background-color: #055a31;
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(6, 105, 58, 0.2);
}

.edit-btn i {
  margin-right: 8px;
}

/* Added View ID Button Styles */
.view-id-btn {
  background-color: #f0f7f3;
  color: #06693A;
  border: 1px solid #06693A;
  border-radius: 8px;
  padding: 12px 24px;
  font-size: 16px;
  font-weight: 500;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.3s ease;
  width: 100%;
  max-width: 220px;
}

.view-id-btn:hover {
  background-color: #e0f0e6;
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(6, 105, 58, 0.1);
}

.view-id-btn i {
  margin-right: 8px;
}

.details-section {
  flex: 1;
  padding: 40px;
}

.section-title {
  display: flex;
  align-items: center;
  margin-bottom: 20px;
  color: #06693A;
  border-bottom: 1px solid #eaeaea;
  padding-bottom: 10px;
}

.section-title i {
  font-size: 24px;
  margin-right: 10px;
}

.section-title h4 {
  font-size: 18px;
  font-weight: 600;
}

.info-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 25px;
  margin-bottom: 30px;
}

.info-item {
  position: relative;
}

.info-item-wide {
  grid-column: span 3;
}

.info-label {
  font-size: 14px;
  color: #777;
  margin-bottom: 5px;
}

.info-value {
  font-size: 16px;
  color: #333;
  font-weight: 500;
}

/* Modal Styles */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.confirm-modal-container {
  background: #fff;
  border-radius: 8px;
  width: 400px;
  max-width: 90%;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  overflow: hidden;
}

.confirm-modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px 20px;
  border-bottom: 1px solid #e0e0e0;
}

.confirm-modal-header h3 {
  margin: 0;
  font-size: 18px;
  font-weight: 600;
  color: #333;
}

.confirm-modal-header .close-btn {
  background: none;
  border: none;
  font-size: 20px;
  cursor: pointer;
  color: #666;
}

.confirm-modal-body {
  padding: 20px;
  text-align: center;
}

.confirm-modal-body p {
  margin: 0;
  font-size: 16px;
  color: #333;
}

.confirm-modal-footer {
  display: flex;
  justify-content: flex-end;
  padding: 15px 20px;
  border-top: 1px solid #e0e0e0;
  gap: 10px;
}

.confirm-cancel-btn {
  background: #e0e0e0;
  color: #333;
  border: none;
  padding: 8px 16px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 14px;
  transition: background 0.3s;
}

.confirm-cancel-btn:hover {
  background: #d0d0d0;
}

.confirm-save-btn {
  background: #06693A;
  color: #fff;
  border: none;
  padding: 8px 16px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 14px;
  transition: background 0.3s;
}

.confirm-save-btn:hover {
  background: #055a31;
}

.modal-container {
  background-color: white;
  border-radius: 12px;
  width: 90%;
  max-width: 800px;
  max-height: 90vh;
  overflow: hidden;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
  display: flex;
  flex-direction: column;
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px 30px;
  border-bottom: 1px solid #eaeaea;
}

.modal-body {
  padding: 30px;
  overflow-y: auto;
  flex: 1;
}

.modal-body::-webkit-scrollbar {
  width: 8px;
}

.modal-body::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 10px;
}

.modal-body::-webkit-scrollbar-thumb {
  background: #c1c1c1;
  border-radius: 10px;
}

.modal-body::-webkit-scrollbar-thumb:hover {
  background: #a8a8a8;
}

.modal-header h3 {
  color: #06693A;
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

.modal-photo-section {
  display: flex;
  justify-content: center;
  margin-bottom: 30px;
}

.modal-photo-wrapper {
  position: relative;
  width: 120px;
  height: 120px;
  border-radius: 50%;
  overflow: hidden;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  cursor: pointer;
}

.modal-patient-photo {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.modal-photo-overlay {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(6, 105, 58, 0.7);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  color: white;
  opacity: 0;
  transition: opacity 0.3s ease;
}

.modal-photo-overlay i {
  font-size: 24px;
  margin-bottom: 5px;
}

.modal-photo-wrapper:hover .modal-photo-overlay {
  opacity: 1;
}

.form-section {
  margin-top: 20px;
}

.form-section-title {
  display: flex;
  align-items: center;
  margin: 25px 0 15px;
  color: #06693A;
  font-size: 18px;
  font-weight: 500;
}

.form-section-title i {
  margin-right: 10px;
}

.form-row {
  display: flex;
  gap: 20px;
  margin-bottom: 15px;
}

.form-group {
  flex: 1;
}

.full-width {
  width: 100%;
}

label {
  display: block;
  margin-bottom: 5px;
  font-size: 14px;
  color: #555;
}

label span.hint-text {
  font-size: 12px;
  color: #888;
  font-weight: 400;
  margin-left: 4px;
}

label span:not(.hint-text) {
  color: red;
}

.form-control {
  width: 100%;
  padding: 10px 15px;
  border: 1px solid #ddd;
  border-radius: 6px;
  font-size: 15px;
  transition: border-color 0.3s ease;
}

.form-control:focus {
  border-color: #06693A;
  outline: none;
}

.modal-footer {
  display: flex;
  justify-content: flex-end;
  padding: 20px 30px;
  border-top: 1px solid #eaeaea;
  gap: 15px;
}

.cancel-btn {
  background-color: #f2f2f2;
  color: #555;
  border: none;
  border-radius: 6px;
  padding: 12px 24px;
  font-size: 16px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.cancel-btn:hover {
  background-color: #e5e5e5;
}

.save-btn {
  background-color: #06693A;
  color: white;
  border: none;
  border-radius: 6px;
  padding: 12px 24px;
  font-size: 16px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.save-btn:hover {
  background-color: #055a31;
}

/* Validation Styles */
.is-invalid {
  border-color: red;
}

.is-invalid:focus {
  border-color: red;
  box-shadow: 0 0 3px rgba(255, 0, 0, 0.5);
}

.invalid-feedback {
  color: red;
  font-size: 12px;
  margin-top: 5px;
}

/* ID Modal Styles */
.id-modal-container {
  background: #fff;
  border-radius: 8px;
  width: 500px;
  max-width: 90%;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  overflow: hidden;
}

.id-modal-body {
  padding: 20px;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.id-image-container {
  width: 100%;
  margin-bottom: 20px;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.valid-id-image {
  width: 100%;
  height: auto;
  display: block;
}

.no-id-text {
  text-align: center;
  color: #666;
  font-style: italic;
  padding: 40px 20px;
}

/* SweetAlert2 Custom Styles */
.sweetalert-theme {
  font-family: 'Poppins', sans-serif !important;
  border-radius: 8px !important;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2) !important;
  background: #FFFFFF !important;
  color: #333 !important;
}

.sweetalert-title {
  color: #06693A !important;
  font-size: 22px !important;
  font-weight: 600 !important;
  margin-bottom: 10px !important;
}

.sweetalert-content {
  font-size: 16px !important;
  color: #555 !important;
}

/* Adjust icon colors to match theme */
.swal2-success .swal2-success-ring {
  border-color: rgba(6, 105, 58, 0.3) !important;
}

.swal2-success [class^='swal2-success-line'] {
  background-color: #06693A !important;
}

.swal2-error .swal2-x-mark-line-left,
.swal2-error .swal2-x-mark-line-right {
  background-color: #d32f2f !important;
}

/* Enhanced Responsive Styles */

/* Large Desktop */
@media screen and (min-width: 1400px) {
  .patient-info {
    margin: 30px 40px;
  }
  
  .photo-wrapper {
    width: 200px;
    height: 200px;
  }
  
  .details-section {
    padding: 50px;
  }
  
  .info-grid {
    gap: 30px;
  }
}

/* Desktop */
@media screen and (max-width: 1200px) {
  .patient-info {
    margin: 25px 30px;
  }
  
  .info-grid {
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
  }
  
  .info-item-wide {
    grid-column: span 2;
  }
  
  .details-section {
    padding: 30px;
  }
}

/* Tablet */
@media screen and (max-width: 992px) {
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
  
  .home-section {
    left: 250px;
    width: calc(100% - 250px);
  }
  
  .sidebar.close ~ .home-section {
    left: 78px;
    width: calc(100% - 78px);
  }
  
  .info-container {
    flex-direction: column;
  }
  
  .photo-section {
    width: 100%;
    border-right: none;
    border-bottom: 1px solid #eaeaea;
    padding: 30px 20px;
    flex-direction: row;
    justify-content: space-around;
    align-items: center;
    flex-wrap: wrap;
  }
  
  .photo-wrapper {
    margin-bottom: 0;
    margin-right: 20px;
  }
  
  .patient-name {
    margin-bottom: 5px;
  }
  
  .edit-btn, .view-id-btn {
    max-width: 200px;
    margin-bottom: 10px;
  }
  
  .patient-info {
    margin: 20px 15px;
  }
  
  .modal-container {
    max-width: 700px;
  }
}

/* Mobile */
@media screen and (max-width: 768px) {
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
  
  .patient-info {
    margin: 15px 10px;
  }
  
  .home-section .home-content .bx-menu {
    font-size: 28px;
    padding: 10px;
  }
  
  .photo-section {
    flex-direction: column;
    align-items: center;
    padding: 25px 15px;
  }
  
  .photo-wrapper {
    width: 150px;
    height: 150px;
    margin-bottom: 15px;
    margin-right: 0;
  }
  
  .patient-name {
    font-size: 20px;
    margin-bottom: 8px;
  }
  
  .patient-id-badge {
    margin-bottom: 20px;
    font-size: 14px;
  }
  
  .edit-btn, .view-id-btn {
    width: 100%;
    max-width: 280px;
    margin-bottom: 10px;
    font-size: 14px;
    padding: 10px 20px;
  }
  
  .details-section {
    padding: 20px 15px;
  }
  
  .section-title {
    margin-bottom: 15px;
  }
  
  .section-title h4 {
    font-size: 16px;
  }
  
  .info-grid {
    grid-template-columns: 1fr;
    gap: 15px;
    margin-bottom: 25px;
  }
  
  .info-item-wide {
    grid-column: span 1;
  }
  
  .info-label {
    font-size: 13px;
  }
  
  .info-value {
    font-size: 15px;
  }
  
  .modal-container {
    width: 95%;
    max-height: 85vh;
  }
  
  .modal-header, 
  .modal-body, 
  .modal-footer {
    padding: 15px;
  }
  
  .modal-header h3 {
    font-size: 18px;
  }
  
  .form-row {
    flex-direction: column;
    gap: 15px;
  }
  
  .modal-footer {
    flex-direction: column;
    gap: 10px;
  }
  
  .cancel-btn, 
  .save-btn {
    width: 100%;
    justify-content: center;
  }
  
  .confirm-modal-container {
    width: 95%;
    max-width: 400px;
  }
  
  .id-modal-container {
    width: 95%;
    max-width: 450px;
  }
}

/* Small Mobile */
@media screen and (max-width: 480px) {
  .patient-info {
    margin: 10px 10px;
  }
  
  .home-section .home-content .bx-menu {
    font-size: 24px;
    margin: 0 10px;
  }
  
  .home-section .home-content .text h3 {
    font-size: 18px;
  }
  
  .breadcrumbs {
    font-size: 10px;
  }
  
  .photo-section {
    padding: 20px 10px;
  }
  
  .photo-wrapper {
    width: 120px;
    height: 120px;
  }
  
  .patient-name {
    font-size: 18px;
  }
  
  .patient-id-badge {
    font-size: 12px;
    padding: 6px 12px;
  }
  
  .edit-btn, .view-id-btn {
    font-size: 13px;
    padding: 8px 16px;
  }
  
  .details-section {
    padding: 15px 10px;
  }
  
  .section-title h4 {
    font-size: 15px;
  }
  
  .section-title i {
    font-size: 20px;
  }
  
  .info-grid {
    gap: 12px;
  }
  
  .info-label {
    font-size: 12px;
  }
  
  .info-value {
    font-size: 14px;
  }
  
  .modal-container {
    width: 98%;
    border-radius: 8px;
  }
  
  .modal-header {
    padding: 12px;
  }
  
  .modal-header h3 {
    font-size: 16px;
  }
  
  .modal-body {
    padding: 12px;
  }
  
  .modal-footer {
    padding: 12px;
  }
  
  .form-section-title {
    font-size: 16px;
    margin: 20px 0 12px;
  }
  
  .form-control {
    padding: 8px 12px;
    font-size: 14px;
  }
  
  .modal-photo-wrapper {
    width: 100px;
    height: 100px;
  }
  
  .confirm-modal-container {
    width: 98%;
  }
  
  .confirm-modal-header h3 {
    font-size: 16px;
  }
  
  .confirm-modal-body p {
    font-size: 14px;
  }
  
  .id-modal-container {
    width: 98%;
  }
}

/* Landscape Mobile */
@media (max-height: 500px) and (orientation: landscape) {
  .modal-container {
    max-height: 95vh;
  }
  
  .modal-body {
    max-height: calc(95vh - 120px);
  }
  
  .photo-wrapper {
    width: 100px;
    height: 100px;
  }
  
  .modal-photo-wrapper {
    width: 80px;
    height: 80px;
  }
}

/* Animation and transition enhancements */
.confirm-modal-header .close-btn:hover {
  color: #333;
}

.confirm-modal-container {
  animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: scale(0.95);
  }
  to {
    opacity: 1;
    transform: scale(1);
  }
}

.modal-overlay {
  animation: fadeOverlay 0.3s ease-in-out;
}

@keyframes fadeOverlay {
  from {
    background: rgba(0, 0, 0, 0);
  }
  to {
    background: rgba(0, 0, 0, 0.5);
  }
}

.confirm-cancel-btn,
.confirm-save-btn {
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
}

.confirm-modal-footer .confirm-save-btn:only-child {
  margin-left: auto;
  margin-right: auto;
}

.form-control:disabled {
  background-color: #e9ecef;
  opacity: 0.6;
  cursor: not-allowed;
}
</style>
