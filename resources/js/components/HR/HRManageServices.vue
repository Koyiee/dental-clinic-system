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
        <i class="bx bx-menu" @click="toggleSidebar"></i>
        <div class="text">
            <h3>Manage Services</h3>
            <div class="breadcrumbs">
              <a class="none" href=""><p>Home / </p></a>
              <a class="current" href="/hrmanageservices"><p> Manage Services</p></a>
            </div>
        </div>
      </div>
      <hr color="#06693a">
      
      <!-- Search and Filter Section -->
      <div class="search-wrapper">
        <div class="search-container">
          <input 
            v-model="searchQuery" 
            placeholder="Search by service name or description" 
            @keyup.enter="filterServices" 
            class="search-input"
            :class="{ 'has-reset': searchQuery && isSearchActive }"
          />
          <i class="bx bx-search search-icon" @click="filterServices"></i>
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
          <div v-if="showFilterDropdown" class="filter-menu">
            <div class="filter-section">
                <div class="filter-header">Multi-Visit</div>
                <button @click="filterByMultiVisit(true)">Multi-Visit</button>
                <button @click="filterByMultiVisit(false)">Not Multi-Visit</button>
            </div>
            <div class="filter-section">
                <div class="filter-header">Status</div>
                <button @click="filterByActive(true)">Enabled</button>
                <button @click="filterByActive(false)">Disabled</button>
            </div>
            <div class="filter-section">
                <div class="filter-header">Cost</div>
                <button @click="sortByCost('asc')">Cost: Low to High</button>
                <button @click="sortByCost('desc')">Cost: High to Low</button>
            </div>
            <button class="clear-filter" @click="clearFilters">Clear Filters</button>
          </div>
        </div>
      </div>
      
      <!-- Services Container -->
      <div class="services-container">
        <div class="services-header">
          <h3>Services List</h3>
          <button class="add-service-btn" @click="openModal">
            <i class='bx bx-plus'></i> Add Service
          </button>
        </div>
        
        <!-- Desktop Table -->
        <div class="table-wrapper">
          <table class="services-table desktop-table">
            <thead>
                <tr>
                    <th style="padding-left: 25px; width: 20%; "@click="sortTable('ServiceName')" class="sortable-header">
                      Service Name <i v-if="sortConfig.key === 'ServiceName'" class="bx" :class="getSortIconClass('ServiceName')"></i>
                    </th>
                    <th style="width: 20%;" @click="sortTable('Description')" class="sortable-header">
                      Description <i v-if="sortConfig.key === 'Description'" class="bx" :class="getSortIconClass('Description')"></i>
                    </th>
                    <th style="width: 15%" @click="sortTable('Cost')" class="sortable-header">
                      Cost <i v-if="sortConfig.key === 'Cost'" class="bx" :class="getSortIconClass('Cost')"></i>
                    </th>
                    <th style="width: 15%" @click="sortTable('IsMultiVisit')" class="sortable-header">
                      Multi-Visit <i v-if="sortConfig.key === 'IsMultiVisit'" class="bx" :class="getSortIconClass('IsMultiVisit')"></i>
                    </th>
                    <th style="width: 15%"@click="sortTable('IsActive')" class="sortable-header">
                      Status <i v-if="sortConfig.key === 'IsActive'" class="bx" :class="getSortIconClass('IsActive')"></i>
                    </th>
                    <th class="actions-col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr 
                    v-for="service in filteredServices" 
                    :key="service.ServiceID"
                    @click="openDetailModal(service)"
                    class="service-row"
                >
                    <td style="padding-left: 25px;">{{ service.ServiceName }}</td>
                    <td class="description-cell">
                        <div class="truncate-text">{{ service.Description || 'No description' }}</div>
                    </td>
                    <td>₱ {{ formatCost(service.Cost) }}</td>
                    <td>
                        <span class="status-badge" :class="service.IsMultiVisit ? 'status-multi' : 'status-single'">
                            {{ service.IsMultiVisit ? 'Yes' : 'No' }}
                        </span>
                    </td>
                    <td>
                        <span class="status-badge" :class="service.IsActive ? 'status-active' : 'status-inactive'">
                            {{ service.IsActive ? 'Enabled' : 'Disabled' }}
                        </span>
                    </td>
                    <td class="actions-cell" @click.stop>
                        <button 
                            @click="confirmToggleService(service)" 
                            class="action-button"
                            :class="service.IsActive ? 'disable-btn' : 'enable-btn'"
                        >
                            {{ service.IsActive ? 'Disable' : 'Enable' }}
                        </button>
                        <button 
                            @click="openEditModal(service)" 
                            class="action-button"
                        >
                            Edit
                        </button>
                    </td>
                </tr>
                <tr v-if="filteredServices.length === 0">
                    <td colspan="6" class="no-data">No Services Available...</td>
                </tr>
            </tbody>
          </table>
        </div>
        
        <!-- Mobile Cards -->
        <div class="mobile-cards">
            <div 
                v-for="service in filteredServices" 
                :key="service.ServiceID"
                class="service-card"
                @click="openDetailModal(service)"
            >
                <div class="card-header">
                    <h4>{{ service.ServiceName }}</h4>
                    <span class="status-badge" :class="service.IsActive ? 'status-active' : 'status-inactive'">
                        {{ service.IsActive ? 'Enabled' : 'Disabled' }}
                    </span>
                </div>
                <div class="card-content">
                    <div class="card-row">
                        <span class="card-label">Description:</span>
                        <span class="card-value">{{ service.Description || 'No description' }}</span>
                    </div>
                    <div class="card-row">
                        <span class="card-label">Cost:</span>
                        <span class="card-value">₱ {{ formatCost(service.Cost) }}</span>
                    </div>
                    <div class="card-row">
                        <span class="card-label">Multi-Visit:</span>
                        <span class="card-value">
                            <span class="status-badge" :class="service.IsMultiVisit ? 'status-multi' : 'status-single'">
                                {{ service.IsMultiVisit ? 'Yes' : 'No' }}
                            </span>
                        </span>
                    </div>
                    <div class="card-actions" @click.stop>
                        <button 
                            @click="confirmToggleService(service)" 
                            class="action-button-mobile"
                            :class="service.IsActive ? 'disable-btn' : 'enable-btn'"
                        >
                            <i :class="service.IsActive ? 'bx bx-x' : 'bx bx-check'"></i>
                            {{ service.IsActive ? 'Disable' : 'Enable' }}
                        </button>
                        <button 
                            @click="openEditModal(service)" 
                            class="action-button-mobile edit-btn"
                        >
                            <i class='bx bx-edit-alt'></i> Edit
                        </button>
                    </div>
                </div>
            </div>
            <div v-if="filteredServices.length === 0" class="no-data-mobile">
                No Services Available
            </div>
        </div>
      </div>

      <!-- Detail Modal -->
      <div class="modal-overlay" v-if="showDetailModal" @click="closeDetailModal">
        <div class="modal-content" @click.stop>
          <div class="modal-header">
            <h3>Service Details</h3>
            <button class="close-btn" @click="closeDetailModal">
              <i class='bx bx-x'></i>
            </button>
          </div>
          <div class="modal-body" v-if="selectedService">
            <div class="detail-row">
                <div class="detail-label">Service Name:</div>
                <div class="detail-value">{{ selectedService.ServiceName }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Description:</div>
                <div class="detail-value">{{ selectedService.Description || 'No description' }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Cost:</div>
                <div class="detail-value">₱ {{ formatCost(selectedService.Cost) }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Multi-Visit:</div>
                <div class="detail-value">
                    <span class="status-badge" :class="selectedService.IsMultiVisit ? 'status-multi' : 'status-single'">
                        {{ selectedService.IsMultiVisit ? 'Yes' : 'No' }}
                    </span>
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Status:</div>
                <div class="detail-value">
                    <span class="status-badge" :class="selectedService.IsActive ? 'status-active' : 'status-inactive'">
                        {{ selectedService.IsActive ? 'Enabled' : 'Disabled' }}
                    </span>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <div class="modal-actions">
              <button class="cancel-btn" @click="closeDetailModal">
                <i class='bx bx-x'></i> Close
              </button>
              <button class="edit-btn" @click="openEditModalFromDetail">
                <i class='bx bx-edit-alt'></i> Edit
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Edit Modal -->
      <div class="modal-overlay" v-if="isEditModalVisible">
        <div class="modal-content">
          <div class="modal-header">
            <h3>Edit Service</h3>
            <button class="close-btn" @click="closeEditModal">
              <i class='bx bx-x'></i>
            </button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="confirmEditService">
                <div class="form-container">
                    <div class="form-group">
                        <label for="ServiceName">Service Name <span class="required">*</span></label>
                        <input 
                            v-model="editForm.ServiceName" 
                            type="text" 
                            id="ServiceName" 
                            required 
                            class="modal-input"
                        />
                    </div>
                    
                    <div class="form-group full-width">
                        <label for="Description">Description<span class="required">*</span></label>
                        <textarea 
                            v-model="editForm.Description" 
                            id="Description" 
                            rows="3" 
                            class="modal-textarea"
                        ></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="Cost">Cost <span class="required">*</span></label>
                        <div class="cost-input-wrapper">
                            <span class="currency-symbol">₱</span>
                            <input 
                                v-model="editForm.Cost" 
                                type="number" 
                                id="Cost" 
                                step="0.01" 
                                required 
                                class="modal-input cost-input"
                            />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="IsMultiVisit">Multi-Visit Service</label>
                        <div class="toggle-wrapper">
                            <input 
                                type="checkbox" 
                                id="IsMultiVisit" 
                                v-model="editForm.IsMultiVisit" 
                                class="toggle-checkbox"
                            />
                            <label for="IsMultiVisit" class="toggle-label"></label>
                            <span class="toggle-text">{{ editForm.IsMultiVisit ? 'Yes' : 'No' }}</span>
                        </div>
                    </div>
                </div>
            </form>
          </div>
          <div class="modal-footer">
            <div class="modal-actions">
              <button class="cancel-btn" @click="closeEditModal">
                <i class='bx bx-x'></i> Cancel
              </button>
              <button class="submit-btn" @click="confirmEditService">
                <i class='bx bx-check'></i> Save
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Add Service Modal -->
      <div class="modal-overlay" v-if="isModalVisible">
        <div class="modal-content">
          <div class="modal-header">
            <h3>Add Service</h3>
            <button class="close-btn" @click="closeModal">
              <i class='bx bx-x'></i>
            </button>
          </div>
          <div class="modal-body">
            <div v-if="errorMessage" class="error-message">
                <i class='bx bx-error-circle'></i>
                {{ errorMessage }}
            </div>
            
            <form @submit.prevent="confirmAddService">
                <div class="form-container">
                    <div class="form-group">
                        <label for="AddServiceName">Service Name <span class="required">*</span></label>
                        <input 
                            v-model="formData.ServiceName" 
                            type="text" 
                            id="AddServiceName" 
                            required 
                            class="modal-input"
                        />
                    </div>
                    
                    <div class="form-group full-width">
                        <label for="AddDescription">Description<span class="required">*</span></label>
                        <textarea 
                            v-model="formData.Description" 
                            id="AddDescription" 
                            rows="3" 
                            class="modal-textarea"
                        ></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="AddCost">Cost <span class="required">*</span></label>
                        <div class="cost-input-wrapper">
                            <span class="currency-symbol">₱</span>
                            <input 
                                v-model="formData.Cost" 
                                type="number" 
                                id="AddCost" 
                                step="0.01" 
                                required 
                                class="modal-input cost-input"
                            />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="AddIsMultiVisit">Multi-Visit Service</label>
                        <div class="toggle-wrapper">
                            <input 
                                type="checkbox" 
                                id="AddIsMultiVisit" 
                                v-model="formData.IsMultiVisit" 
                                class="toggle-checkbox"
                            />
                            <label for="AddIsMultiVisit" class="toggle-label"></label>
                            <span class="toggle-text">{{ formData.IsMultiVisit ? 'Yes' : 'No' }}</span>
                        </div>
                    </div>
                </div>
            </form>
          </div>
          <div class="modal-footer">
            <div class="modal-actions">
              <button class="cancel-btn" @click="closeModal">
                <i class='bx bx-x'></i> Cancel
              </button>
              <button class="submit-btn" @click="confirmAddService">
                <i class='bx bx-check'></i> Save
              </button>
            </div>
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
  name: "HrManageServices",
  props: {
    firstName: { type: String, required: true },
    lastName: { type: String, required: true },
  },
  computed: {
    fullName() {
      return `${this.firstName} ${this.lastName}`;
    },
    filteredServices() {
      let result = [...this.displayedServices];
      
      // Apply multi-visit filter
      if (this.filterMultiVisit !== null) {
        result = result.filter(service => service.IsMultiVisit === this.filterMultiVisit);
      }
      
      // Apply active filter
      if (this.filterActive !== null) {
        result = result.filter(service => service.IsActive === this.filterActive);
      }
      
      return result;
    }
  },
  data() {
    return {
      isSidebarClosed: true,
      isModalVisible: false,
      isEditModalVisible: false,
      showDetailModal: false,
      errorMessage: "",
      selectedService: null,
      formData: {
        ServiceName: "",
        Description: "",
        Cost: "",
        IsMultiVisit: false,
        IsActive: true,
      },
      editForm: {
        ServiceID: '',
        ServiceName: "",
        Description: "",
        Cost: "",
        IsMultiVisit: false,
        IsActive: true,
      },
      services: [],
      displayedServices: [],
      searchQuery: "",
      isSearchActive: false,
      showFilterDropdown: false,
      filterMultiVisit: null,
      filterActive: null,
      sortConfig: { key: null, direction: 'asc' },
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
    toggleSidebar() {
      this.isSidebarClosed = !this.isSidebarClosed;
    },
    toggleFilterMenu() {
      this.showFilterDropdown = !this.showFilterDropdown;
    },
    filterByMultiVisit(isMulti) {
      this.filterMultiVisit = isMulti;
      this.showFilterDropdown = false;
    },
    sortByCost(order) {
      this.sortConfig = { key: 'Cost', direction: order };
      this.applySorting();
      this.showFilterDropdown = false;
    },
    clearFilters() {
      this.filterMultiVisit = null;
      this.filterActive = null;
      this.sortConfig = { key: null, direction: 'asc' };
      this.searchQuery = "";
      this.isSearchActive = false;
      this.showFilterDropdown = false;
      this.updateDisplayedServices();
    },
    filterByActive(isActive) {
      this.filterActive = isActive;
      this.showFilterDropdown = false;
    },
    async confirmToggleService(service) {
      const action = service.IsActive ? 'disable' : 'enable';
      const result = await Swal.fire({
        title: `Are you sure you want to ${action} this service?`,
        text: `This will ${action} "${service.ServiceName}".`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, Proceed',
        cancelButtonText: 'No, Cancel',
        confirmButtonColor: '#06693A',
        cancelButtonColor: '#d32f2f',
        customClass: {
          popup: 'swal2-custom',
          title: 'swal2-title',
          content: 'swal2-content',
        }
      });
      if (result.isConfirmed) {
        this.toggleServiceActive(service);
      }
    },
    async toggleServiceActive(service) {
      try {
        const updatedService = { ...service, IsActive: !service.IsActive };
        const response = await axios.put(`/services/update/${service.ServiceID}`, updatedService);
        console.log("Updated service:", response.data);
        await Swal.fire({
          icon: 'success',
          title: 'Success',
          text: `Service ${updatedService.IsActive ? 'enabled' : 'disabled'} successfully!`,
          confirmButtonColor: '#06693A',
          timer: 1500,
          showConfirmButton: false,
          customClass: {
            popup: 'swal2-custom',
            title: 'swal2-title',
            content: 'swal2-content',
          }
        });
        this.fetchServices();
      } catch (error) {
        console.error("Error updating service status:", error);
        await Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'There was an error updating the service status.',
          confirmButtonColor: '#06693A',
          customClass: {
            popup: 'swal2-custom',
            title: 'swal2-title',
            content: 'swal2-content',
          }
        });
      }
    },
    openModal() {
      this.isModalVisible = true;
      this.errorMessage = "";
    },
    closeModal() {
      this.isModalVisible = false;
      this.resetForm();
    },
    resetForm() {
      this.formData = { ServiceName: "", Description: "", Cost: "", IsMultiVisit: false };
    },
    openEditModal(service) {
      this.editForm = { ...service };
      this.isEditModalVisible = true;
    },
    closeEditModal() {
      this.isEditModalVisible = false;
      this.resetEditForm();
    },
    resetEditForm() {
      this.editForm = { ServiceID: '', ServiceName: "", Description: "", Cost: "", IsMultiVisit: false };
    },
    async confirmEditService() {
      const result = await Swal.fire({
        title: 'Are you sure you want to save changes to this service?',
        text: `This will update "${this.editForm.ServiceName}".`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, Save',
        cancelButtonText: 'No, Cancel',
        confirmButtonColor: '#06693A',
        cancelButtonColor: '#d32f2f',
        customClass: {
          popup: 'swal2-custom',
          title: 'swal2-title',
          content: 'swal2-content',
        }
      });
      if (result.isConfirmed) {
        this.submitEdit();
      }
    },
    async submitEdit() {
      try {
        const response = await axios.put(`/services/update/${this.editForm.ServiceID}`, this.editForm);
        console.log("Updated service:", response.data);
        await Swal.fire({
          icon: 'success',
          title: 'Success',
          text: 'Service updated successfully!',
          confirmButtonColor: '#06693A',
          timer: 1500,
          showConfirmButton: false,
          customClass: {
            popup: 'swal2-custom',
            title: 'swal2-title',
            content: 'swal2-content',
          }
        });
        this.closeEditModal();
        this.fetchServices();
      } catch (error) {
        console.error("Error updating service:", error);
        await Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'There was an error updating the service.',
          confirmButtonColor: '#06693A',
          customClass: {
            popup: 'swal2-custom',
            title: 'swal2-title',
            content: 'swal2-content',
          }
        });
      }
    },
    async fetchServices() {
      try {
        const response = await axios.get('/services/list');
        console.log('Fetched services:', response.data);
        this.services = response.data;
        this.displayedServices = [...this.services];
        this.applySorting();
      } catch (error) {
        console.error('Error fetching services:', error);
        this.services = [];
        this.displayedServices = [];
      }
    },
    async confirmAddService() {
      const result = await Swal.fire({
        title: 'Are you sure you want to add this service?',
        text: `This will add "${this.formData.ServiceName}".`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, Add',
        cancelButtonText: 'No, Cancel',
        confirmButtonColor: '#06693A',
        cancelButtonColor: '#d32f2f',
        customClass: {
          popup: 'swal2-custom',
          title: 'swal2-title',
          content: 'swal2-content',
        }
      });
      if (result.isConfirmed) {
        this.submitService();
      }
    },
    async submitService() {
      const duplicate = this.services.find(service => 
        service.ServiceName.toLowerCase() === this.formData.ServiceName.trim().toLowerCase()
      );
      if (duplicate) {
        this.errorMessage = "This service already exists.";
        return;
      }
      try {
        const response = await axios.post('/services/store', this.formData);
        console.log("Response:", response.data);
        await Swal.fire({
          icon: 'success',
          title: 'Success',
          text: 'Service added successfully!',
          confirmButtonColor: '#06693A',
          timer: 1500,
          showConfirmButton: false,
          customClass: {
            popup: 'swal2-custom',
            title: 'swal2-title',
            content: 'swal2-content',
          }
        });
        this.closeModal();
        this.fetchServices();
      } catch (error) {
        console.error("Error adding service:", error);
        await Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'There was an error adding the service.',
          confirmButtonColor: '#06693A',
          customClass: {
            popup: 'swal2-custom',
            title: 'swal2-title',
            content: 'swal2-content',
          }
        });
      }
    },
    openDetailModal(service) {
      this.selectedService = service;
      this.showDetailModal = true;
    },
    closeDetailModal() {
      this.showDetailModal = false;
      this.selectedService = null;
    },
    openEditModalFromDetail() {
      if (this.selectedService) {
        this.openEditModal(this.selectedService);
        this.closeDetailModal();
      }
    },
    matchesSearch(service) {
      const query = this.searchQuery.toLowerCase();
      return (
        (service.ServiceName || '').toLowerCase().includes(query) ||
        (service.Description || '').toLowerCase().includes(query)
      );
    },
    filterServices() {
      if (!this.searchQuery.trim()) {
        this.isSearchActive = false;
      } else {
        this.isSearchActive = true;
      }
      this.updateDisplayedServices();
    },
    resetSearch() {
      this.searchQuery = '';
      this.isSearchActive = false;
      this.updateDisplayedServices();
    },
    updateDisplayedServices() {
      let filtered = [...this.services];
      if (this.searchQuery && this.isSearchActive) {
        filtered = filtered.filter(service => this.matchesSearch(service));
      }
      this.displayedServices = filtered;
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

      this.displayedServices.sort((a, b) => {
        let valueA = a[key];
        let valueB = b[key];

        valueA = valueA || '';
        valueB = valueB || '';

        if (key === 'Cost') {
          valueA = Number(valueA);
          valueB = Number(valueB);
          return direction === 'asc' ? valueA - valueB : valueB - valueA;
        }

        if (key === 'IsMultiVisit' || key === 'IsActive') {
          valueA = valueA ? 1 : 0;
          valueB = valueB ? 1 : 0;
          return direction === 'asc' ? valueA - valueB : valueB - valueA;
        }

        if (typeof valueA === 'string' && typeof valueB === 'string') {
          return direction === 'asc' ? valueA.localeCompare(valueB) : valueB.localeCompare(valueA);
        }

        return direction === 'asc' ? (valueA > valueB ? 1 : -1) : (valueA < valueB ? 1 : -1);
      });
    },
    getSortIconClass(key) {
      if (this.sortConfig.key === key) {
        return this.sortConfig.direction === 'asc' ? 'bx-caret-up' : 'bx-caret-down';
      }
      return '';
    },
    formatCost(cost) {
      return cost ? Number(cost).toFixed(2) : '0.00';
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
    this.fetchServices();
  }
};
</script>

<style scoped>
@import url('https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css');
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

/* SweetAlert2 Custom Styling */
.swal2-custom {
  border-radius: 12px !important;
  font-family: 'Poppins', sans-serif !important;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2) !important;
}

.swal2-title {
  color: #06693A !important;
  font-weight: 600 !important;
  font-size: 20px !important;
}

.swal2-content {
  color: #333 !important;
  font-size: 16px !important;
}

.swal2-confirm {
  background-color: #06693A !important;
  border-radius: 8px !important;
  font-size: 14px !important;
  font-weight: 500 !important;
  padding: 10px 20px !important;
  transition: background-color 0.2s !important;
}

.swal2-confirm:hover {
  background-color: #055a32 !important;
}

.swal2-cancel {
  background-color: #d32f2f !important;
  border-radius: 8px !important;
  font-size: 14px !important;
  font-weight: 500 !important;
  padding: 10px 20px !important;
  transition: background-color 0.2s !important;
}

.swal2-cancel:hover {
  background-color: #b71c1c !important;
}

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
  overflow: hidden;
}

.filter-section {
  border-bottom: 1px solid #f0f0f0;
  padding-bottom: 8px;
}

.filter-header {
  padding: 12px 16px 8px;
  font-weight: 600;
  color: #06693A;
  font-size: 14px;
}

.filter-menu button {
  display: block;
  width: 100%;
  text-align: left;
  border-radius: 0;
  background-color: white;
  color: #333;
  padding: 10px 16px;
  margin: 0;
  border: none;
  transition: background-color 0.2s;
  font-size: 13px;
}

.filter-menu button:hover {
  background-color: #f5f5f5;
}

.clear-filter {
  margin-top: 8px !important;
  color: #d32f2f !important;
  font-weight: 500;
}

/* Services Container */
.services-container {
  margin: 20px;
  background-color: white;
  border-radius: 12px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
  overflow: hidden;
}

.services-header {
  padding: 20px 25px;
  border-bottom: 1px solid #f0f0f0;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.services-header h3 {
  font-size: 18px;
  color: #333;
  font-weight: 600;
  margin: 0;
}

.add-service-btn {
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

.add-service-btn:hover {
  background-color: #055a32;
}

.add-service-btn:active {
  transform: scale(0.98);
}

.table-wrapper {
  padding: 0;
}

.services-table {
  width: 100%;
  border-collapse: collapse;
  background-color: white;
}

.services-table th,
.services-table td {
  padding: 16px;
  text-align: left;
  border-bottom: 1px solid #f5f5f5;
  color: #333;
  font-size: 14px;
}

.services-table th {
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

.service-row {
  transition: background-color 0.2s;
  cursor: pointer;
}

.service-row:hover {
  background-color: #f9f9f9;
}

.services-table tr:last-child td {
  border-bottom: none;
}

.service-name-col {
    width: 20%;
}

.description-col {
    width: 20%;
}

.cost-col {
    width: 15%;
}

.multi-visit-col {
    width: 15%;
}

.active-col {
    width: 15%;
}

.actions-col {
    width: 15%;
}

.description-cell {
  max-width: 300px;
}

.truncate-text {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  max-width: 100%;
}

.status-badge {
  display: inline-block;
  padding: 4px 10px;
  border-radius: 12px;
  font-size: 12px;
  font-weight: 500;
}

.status-multi {
  background-color: #e6f7ee;
  color: #0d904b;
}

.status-single {
  background-color: #e3f2fd;
  color: #1565c0;
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
  background-color: #06693A;
  color: white;
}

.action-button:hover {
  background-color: #055a32;
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

.service-card {
  background-color: white;
  border-radius: 12px;
  border: 1px solid #e0e0e0;
  margin-bottom: 16px;
  overflow: hidden;
  transition: transform 0.2s, box-shadow 0.2s;
  cursor: pointer;
}

.service-card:hover {
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

.card-value {
  color: #333;
  word-break: break-word;
}

.card-actions {
  margin-top: 16px;
  display: flex;
  gap: 8px;
  justify-content: flex-end;
}

.action-button-mobile {
  display: flex;
  align-items: center;
  gap: 6px;
  padding: 8px 16px;
  border-radius: 6px;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  border: none;
  transition: background-color 0.2s;
  background-color: #06693A;
  color: white;
}

.action-button-mobile:hover {
  background-color: #055a32;
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
  max-width: 600px;
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

.modal-body {
  padding: 25px 30px;
  overflow-y: auto;
  max-height: calc(90vh - 180px);
}

.error-message {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 20px;
  padding: 12px 16px;
  background-color: #ffebee;
  border-radius: 8px;
  color: #d32f2f;
  font-size: 14px;
}

.error-message i {
  font-size: 20px;
}

.form-container {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
}

.form-group {
  flex: 0 0 calc(50% - 10px);
  position: relative;
}

.form-group.full-width {
  flex: 0 0 100%;
}

.form-group label {
  display: block;
  font-weight: 500;
  margin-bottom: 8px;
  color: #444;
  font-size: 14px;
}

.required {
  color: #d32f2f;
  margin-left: 2px;
}

.modal-input,
.modal-textarea {
  width: 100%;
  padding: 12px 15px;
  border: 1px solid #e0e0e0;
  border-radius: 10px;
  font-size: 14px;
  background-color: white;
  transition: all 0.2s ease;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.03);
}

.modal-input:focus,
.modal-textarea:focus {
  border-color: #06693A;
  box-shadow: 0 0 0 3px rgba(6, 105, 58, 0.1);
  outline: none;
}

.modal-textarea {
  resize: none;
  min-height: 100px;
}

.cost-input-wrapper {
  position: relative;
}

.currency-symbol {
  position: absolute;
  left: 15px;
  top: 50%;
  transform: translateY(-50%);
  color: #666;
  font-size: 14px;
}

.cost-input {
  padding-left: 30px;
}

/* Toggle Switch */
.toggle-wrapper {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-top: 5px;
}

.toggle-checkbox {
  position: absolute;
  opacity: 0;
  width: 0;
  height: 0;
}

.toggle-label {
  position: relative;
  display: inline-block;
  width: 50px;
  height: 26px;
  background-color: #e0e0e0;
  border-radius: 13px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.toggle-label::after {
  content: "";
  position: absolute;
  top: 3px;
  left: 3px;
  width: 20px;
  height: 20px;
  background-color: white;
  border-radius: 50%;
  transition: transform 0.3s;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}

.toggle-checkbox:checked + .toggle-label {
  background-color: #06693A;
}

.toggle-checkbox:checked + .toggle-label::after {
  transform: translateX(24px);
}

.toggle-text {
  font-size: 14px;
  color: #666;
}

/* Detail Row Styling */
.detail-row {
  margin-bottom: 20px;
}

.detail-row:last-child {
  margin-bottom: 0;
}

.detail-label {
  font-weight: 600;
  color: #06693A;
  margin-bottom: 8px;
  font-size: 14px;
}

.detail-value {
  color: #333;
  font-size: 16px;
}

/* Modal Footer */
.modal-footer {
  padding: 20px 30px;
  border-top: 1px solid #f0f0f0;
  display: flex;
  justify-content: flex-end;
}

.modal-actions {
  display: flex;
  gap: 12px;
}

.cancel-btn,
.submit-btn,
.edit-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding: 10px 20px;
  border-radius: 8px;
  font-size: 14px;
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

.edit-btn {
  background: #f0f4c3;
  color: #827717;
}

.edit-btn:hover {
  background: #e6ee9c;
}

.status-active {
    background-color: #e6f7ee;
    color: #0d904b;
}

.status-inactive {
    background-color: #ffebee;
    color: #d32f2f;
}

.enable-btn {
    background-color: #0d904b;
}

.enable-btn:hover {
    background-color: #0a7a3f;
}

.disable-btn {
    background-color: #d32f2f;
}

.disable-btn:hover {
    background-color: #b71c1c;
}

.active-col {
    width: 15%;
}

/* Responsive Design */

/* Large Desktop */
@media (min-width: 1400px) {
  .services-container {
    margin: 30px;
  }

  .search-wrapper {
    margin-left: 30px;
    width: calc(100% - 60px);
  }
}

/* Desktop */
@media (max-width: 1200px) {
  .services-table th,
  .services-table td {
    padding: 12px;
    font-size: 13px;
  }

  .search-wrapper {
    margin-left: 15px;
    width: calc(100% - 30px);
  }

  .form-group {
    flex: 0 0 100%;
  }
  
  .description-cell {
    max-width: 200px;
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

  .services-container {
    margin: 15px;
  }

  .services-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 15px;
  }

  .add-service-btn {
    width: 100%;
    justify-content: center;
  }

  .filter-menu {
    width: 180px;
  }

  .modal-content {
    max-width: 500px;
  }

  .services-table th,
  .services-table td {
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
  
  .services-header h3 {
    font-size: 16px;
  }
  
  .search-wrapper {
    flex-direction: column;
    align-items: stretch;
    width: calc(100% - 20px);
    margin-left: 10px;
    gap: 15px;
  }
  
  .search-container {
    margin-right: 0;
  }
  
  .buttons {
    align-self: flex-end;
  }

  .filter-menu {
    width: 160px;
    right: 0;
  }

  .services-container {
    margin: 10px;
  }

  .services-header {
    padding: 15px;
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
  }

  .form-container {
    gap: 15px;
  }

  .modal-actions {
    flex-direction: column;
    width: 100%;
  }
  
  .cancel-btn,
  .submit-btn,
  .edit-btn {
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

  .services-container {
    margin: 8px;
  }

  .services-header {
    padding: 12px;
  }

  .services-header h3 {
    font-size: 15px;
  }

  .service-card {
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

  .modal-body {
    padding: 12px;
  }

  .form-container {
    gap: 12px;
  }

  .form-group label {
    font-size: 13px;
  }

  .modal-input,
  .modal-textarea {
    padding: 10px 12px;
    font-size: 13px;
  }

  .modal-footer {
    padding: 12px;
  }

  .cancel-btn,
  .submit-btn,
  .edit-btn {
    padding: 10px 16px;
    font-size: 14px;
  }
}

/* Landscape Mobile */
@media (max-height: 500px) and (orientation: landscape) {
  .modal-content {
    max-height: 95vh;
  }

  .modal-body {
    max-height: calc(95vh - 120px);
  }
}
</style>
