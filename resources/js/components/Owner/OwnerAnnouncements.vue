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
        <i class="bx bx-menu"></i>
        <div class="text">
            <h3>Announcements</h3>
            <div class="breadcrumbs">
              <a class="none" href=""><p>Home / </p></a>
              <a class="current" href="/ownerannouncements"><p>  Announcements</p></a>
            </div>
        </div>
        </div>
      </div>
      <hr color="#06693a">

    <!-- Search and Create Post -->
    <div class="search-wrapper">
      <div class="search-container">
  <input 
    v-model="searchQuery" 
    placeholder="Search announcements" 
    @keyup.enter="filterAnnouncements" 
    class="search-input"
    :class="{ 'has-reset': searchQuery && isSearchActive }"
  />
  <i class="bx bx-search search-icon" @click="filterAnnouncements"></i>
  <button 
    v-if="isSearchActive" 
    @click="resetSearch" 
    class="reset-button"
    title="Reset search"
  >
    <i class='bx bx-x'></i>
  </button>
</div>
      <button class="create-post-btn" @click="showModal = true">
        <i class='bx bx-plus'></i> Create Post
      </button>
    </div>
    
    <!-- Toggle buttons for Published/Unpublished/Past/Deleted -->
    <div class="filter-buttons">
      <button 
        class="filter-button" 
        :class="{ 'active': activeTab === 'published' }" 
        @click="activeTab = 'published'"
      >
        <i class='bx bx-broadcast'></i> Published
      </button>
      <button 
        class="filter-button" 
        :class="{ 'active': activeTab === 'unpublished' }" 
        @click="activeTab = 'unpublished'"
      >
        <i class='bx bx-time'></i> Unpublished
      </button>
      <button 
        class="filter-button" 
        :class="{ 'active': activeTab === 'past' }" 
        @click="activeTab = 'past'"
      >
        <i class='bx bx-history'></i> Past
      </button>
      <button 
        class="filter-button" 
        :class="{ 'active': activeTab === 'deleted' }" 
        @click="activeTab = 'deleted'"
      >
        <i class='bx bx-trash'></i> Deleted
      </button>
    </div>

    <!-- Announcements Container -->
    <div class="announcements-container">
      <!-- Published Announcements Section -->
      <div v-show="activeTab === 'published'" class="tab-content">
        <div class="section-header">
          <i class='bx bx-broadcast'></i>
          <h2>Published Announcements</h2>
        </div>

        <div v-if="isLoading" class="loading-container">
          <div class="loading-spinner"></div>
          <p>Loading announcements...</p>
        </div>

        <div v-else-if="displayedPublished.length" class="announcements-list">
          <div 
            v-for="(announcement, index) in displayedPublished" 
            :key="index"
            class="announcement-card"
            @click="openDetailModal(announcement)"
          >
            <div class="announcement-header">
              <div class="announcement-title-area">
                <div class="announcement-icon">
                  <i class='bx bx-news'></i>
                </div>
                <h3 class="announcement-title">{{ announcement.title }}</h3>
              </div>
              <div class="announcement-actions">
                <button class="action-button" @click.stop="openEditModal(announcement)">
                  <i class='bx bx-edit'></i>
                </button>
                <button class="action-button" @click.stop="openDeleteConfirmModal(announcement)">
                  <i class='bx bx-trash'></i>
                </button>
              </div>
            </div>
            
            <div class="announcement-content">
              <div class="announcement-meta">
                <div class="meta-item">
                  <i class='bx bx-calendar'></i>
                  <span>Added: {{ formatDate(announcement.createdAt) }}</span>
                </div>
                <div class="meta-item">
                  <i class='bx bx-calendar-check'></i>
                  <span>Active until: {{ formatDate(announcement.endDate) }}</span>
                </div>
                <div class="meta-item">
                  <i class='bx bx-group'></i>
                  <span>Audience: {{ announcement.targetUser }}</span>
                </div>
                <div class="meta-item">
                  <span class="status-badge active">
                    <i class='bx bx-check-circle'></i> Active
                  </span>
                </div>
              </div>
              
              <p class="announcement-description">{{ announcement.description }}</p>
              
              <div v-if="announcement.image" class="announcement-image-container">
                <img 
                  :src="getImageUrl(announcement.image)" 
                  alt="Announcement Image" 
                  class="announcement-image" 
                  @error="handleImageError"
                />
              </div>
            </div>
            
            <div class="announcement-footer">
              <div class="announcement-author">
                <i class='bx bx-user'></i>
                <span>{{ announcement.createdBy }}</span>
              </div>
              <button class="read-more-button" @click.stop="openDetailModal(announcement)">
                View details <i class='bx bx-right-arrow-alt'></i>
              </button>
            </div>
          </div>

          <div class="pagination-container">
            <button class="pagination-button">
              <i class='bx bx-chevron-left'></i>
            </button>
            <span class="pagination-info">Page 1 of 1</span>
            <button class="pagination-button">
              <i class='bx bx-chevron-right'></i>
            </button>
          </div>
        </div>

        <div v-else class="empty-state">
          <div class="empty-icon">
            <i class='bx bx-news'></i>
          </div>
          <h3>No Published Announcements</h3>
          <p>No published announcements match your search criteria.</p>
        </div>
      </div>

      <!-- Unpublished Announcements Section -->
      <div v-show="activeTab === 'unpublished'" class="tab-content">
        <div class="section-header">
          <i class='bx bx-time'></i>
          <h2>Unpublished Announcements</h2>
        </div>

        <div v-if="isLoading" class="loading-container">
          <div class="loading-spinner"></div>
          <p>Loading announcements...</p>
        </div>

        <div v-else-if="displayedUnpublished.length" class="announcements-list">
          <div 
            v-for="(announcement, index) in displayedUnpublished" 
            :key="index"
            class="announcement-card"
            @click="openDetailModal(announcement)"
          >
            <div class="announcement-header">
              <div class="announcement-title-area">
                <div class="announcement-icon">
                  <i class='bx bx-hourglass'></i>
                </div>
                <h3 class="announcement-title">{{ announcement.title }}</h3>
              </div>
              <div class="announcement-actions">
                <button class="action-button" @click.stop="openEditModal(announcement)">
                  <i class='bx bx-edit'></i>
                </button>
                <button class="action-button" @click.stop="openDeleteConfirmModal(announcement)">
                  <i class='bx bx-trash'></i>
                </button>
              </div>
            </div>
            
            <div class="announcement-content">
              <div class="announcement-meta">
                <div class="meta-item">
                  <i class='bx bx-calendar'></i>
                  <span>Added: {{ formatDate(announcement.createdAt) }}</span>
                </div>
                <div class="meta-item">
                  <i class='bx bx-calendar-event'></i>
                  <span>Publishes on: {{ formatDate(announcement.startDate) }}</span>
                </div>
                <div class="meta-item">
                  <i class='bx bx-group'></i>
                  <span>Audience: {{ announcement.targetUser }}</span>
                </div>
                <div class="meta-item">
                  <span class="status-badge pending">
                    <i class='bx bx-time'></i> Pending
                  </span>
                </div>
              </div>
              
              <p class="announcement-description">{{ announcement.description }}</p>
              
              <div v-if="announcement.image" class="announcement-image-container">
                <img 
                  :src="getImageUrl(announcement.image)" 
                  alt="Announcement Image" 
                  class="announcement-image" 
                  @error="handleImageError"
                />
              </div>
            </div>
            
            <div class="announcement-footer">
              <div class="announcement-author">
                <i class='bx bx-user'></i>
                <span>{{ announcement.createdBy }}</span>
              </div>
              <button class="read-more-button" @click.stop="openDetailModal(announcement)">
                View details <i class='bx bx-right-arrow-alt'></i>
              </button>
            </div>
          </div>

          <div class="pagination-container">
            <button class="pagination-button">
              <i class='bx bx-chevron-left'></i>
            </button>
            <span class="pagination-info">Page 1 of 1</span>
            <button class="pagination-button">
              <i class='bx bx-chevron-right'></i>
            </button>
          </div>
        </div>

        <div v-else class="empty-state">
          <div class="empty-icon">
            <i class='bx bx-news'></i>
          </div>
          <h3>No Unpublished Announcements</h3>
          <p>No unpublished announcements match your search criteria.</p>
        </div>
      </div>

      <!-- Past Announcements Section -->
      <div v-show="activeTab === 'past'" class="tab-content">
        <div class="section-header">
          <i class='bx bx-history'></i>
          <h2>Past Announcements</h2>
        </div>

        <div v-if="isLoading" class="loading-container">
          <div class="loading-spinner"></div>
          <p>Loading announcements...</p>
        </div>

        <div v-else-if="displayedPast.length" class="announcements-list">
          <div 
            v-for="(announcement, index) in displayedPast" 
            :key="index"
            class="announcement-card past-card"
            @click="openDetailModal(announcement)"
          >
            <div class="announcement-header">
              <div class="announcement-title-area">
                <div class="announcement-icon">
                  <i class='bx bx-time-five'></i>
                </div>
                <h3 class="announcement-title">{{ announcement.title }}</h3>
              </div>
              <div class="announcement-actions">
                <button class="action-button" @click.stop>
                  <i class='bx bx-dots-vertical-rounded'></i>
                </button>
              </div>
            </div>
            
            <div class="announcement-content">
              <div class="announcement-meta">
                <div class="meta-item">
                  <i class='bx bx-calendar'></i>
                  <span>Added: {{ formatDate(announcement.createdAt) }}</span>
                </div>
                <div class="meta-item">
                  <i class='bx bx-calendar-x'></i>
                  <span>Expired on: {{ formatDate(announcement.endDate) }}</span>
                </div>
                <div class="meta-item">
                  <i class='bx bx-group'></i>
                  <span>Audience: {{ announcement.targetUser }}</span>
                </div>
                <div class="meta-item">
                  <span class="status-badge expired">
                    <i class='bx bx-x-circle'></i> Expired
                  </span>
                </div>
              </div>
              
              <p class="announcement-description">{{ announcement.description }}</p>
              
              <div v-if="announcement.image" class="announcement-image-container">
                <img 
                  :src="getImageUrl(announcement.image)" 
                  alt="Announcement Image" 
                  class="announcement-image" 
                  @error="handleImageError"
                />
              </div>
            </div>
            
            <div class="announcement-footer">
              <div class="announcement-author">
                <i class='bx bx-user'></i>
                <span>Owner</span>
              </div>
              <button class="read-more-button" @click.stop="openDetailModal(announcement)">
                View details <i class='bx bx-right-arrow-alt'></i>
              </button>
            </div>
          </div>

          <div class="pagination-container">
            <button class="pagination-button">
              <i class='bx bx-chevron-left'></i>
            </button>
            <span class="pagination-info">Page 1 of 1</span>
            <button class="pagination-button">
              <i class='bx bx-chevron-right'></i>
            </button>
          </div>
        </div>

        <div v-else class="empty-state">
          <div class="empty-icon">
            <i class='bx bx-news'></i>
          </div>
          <h3>No Past Announcements</h3>
          <p>No past announcements match your search criteria.</p>
        </div>
      </div>

      <!-- Deleted Announcements Section -->
      <div v-show="activeTab === 'deleted'" class="tab-content">
        <div class="section-header">
          <i class='bx bx-trash'></i>
          <h2>Deleted Announcements</h2>
        </div>

        <div v-if="isLoading" class="loading-container">
          <div class="loading-spinner"></div>
          <p>Loading announcements...</p>
        </div>

        <div v-else-if="displayedDeleted.length" class="announcements-list">
          <div 
            v-for="(announcement, index) in displayedDeleted" 
            :key="index"
            class="announcement-card deleted-card"
            @click="openDetailModal(announcement)"
          >
            <div class="announcement-header">
              <div class="announcement-title-area">
                <div class="announcement-icon">
                  <i class='bx bx-trash'></i>
                </div>
                <h3 class="announcement-title">{{ announcement.title }}</h3>
              </div>
              <div class="announcement-actions">
                <button class="action-button" @click.stop>
                  <i class='bx bx-dots-vertical-rounded'></i>
                </button>
              </div>
            </div>
            
            <div class="announcement-content">
              <div class="announcement-meta">
                <div class="meta-item">
                  <i class='bx bx-calendar'></i>
                  <span>Added: {{ formatDate(announcement.createdAt) }}</span>
                </div>
                <div class="meta-item">
                  <i class='bx bx-calendar-x'></i>
                  <span>Deleted on: {{ formatDate(announcement.deletedAt) }}</span>
                </div>
                <div class="meta-item">
                  <i class='bx bx-group'></i>
                  <span>Audience: {{ announcement.targetUser }}</span>
                </div>
                <div class="meta-item">
                  <span class="status-badge deleted">
                    <i class='bx bx-trash'></i> Deleted
                  </span>
                </div>
              </div>
              
              <p class="announcement-description">{{ announcement.description }}</p>
              
              <div v-if="announcement.image" class="announcement-image-container">
                <img 
                  :src="getImageUrl(announcement.image)" 
                  alt="Announcement Image" 
                  class="announcement-image" 
                  @error="handleImageError"
                />
              </div>
            </div>
            
            <div class="announcement-footer">
              <div class="announcement-author">
                <i class='bx bx-user'></i>
                <span>{{ announcement.createdBy }}</span>
              </div>
              <button class="read-more-button" @click.stop="openDetailModal(announcement)">
                View details <i class='bx bx-right-arrow-alt'></i>
              </button>
            </div>
          </div>

          <div class="pagination-container">
            <button class="pagination-button">
              <i class='bx bx-chevron-left'></i>
            </button>
            <span class="pagination-info">Page 1 of 1</span>
            <button class="pagination-button">
              <i class='bx bx-chevron-right'></i>
            </button>
          </div>
        </div>

        <div v-else class="empty-state">
          <div class="empty-icon">
            <i class='bx bx-news'></i>
          </div>
          <h3>No Deleted Announcements</h3>
          <p>No deleted announcements match your search criteria.</p>
        </div>
      </div>
    </div>

    <!-- Create Post Modal -->
    <div v-if="showModal" class="modal-overlay">
      <div class="modal-content" @click.stop>
        <div class="modal-header">
          <h3>Create Announcement</h3>
          <button class="close-button" @click="cancelCreateModal">
            <i class='bx bx-x'></i>
          </button>
        </div>
        
        <form class="modal-body" @submit.prevent="confirmPublish">
          <div class="form-group">
            <label for="A-title">Title</label>
            <input type="text" id="A-title" v-model="title" required placeholder="Enter announcement title" />
          </div>

          <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" v-model="description" required placeholder="Enter announcement details"></textarea>
          </div>

          <div class="form-group">
            <label for="attachment">Image</label>
            <div class="file-input-wrapper">
              <input type="file" id="attachment" @change="handleFileUpload" accept="image/png, image/jpeg" />
            </div>
          </div>

          <div class="form-row">
            <div class="form-group half-width">
              <label for="target-user">Target Audience</label>
              <div class="select-wrapper">
                <select id="target-user" v-model="targetUser" required>
                  <option value="">Select audience</option>
                  <option value="patients">Patients</option>
                  <option value="Dentist">Dentist</option>
                  <option value="All">All</option>
                </select>
                <i class="bx bx-chevron-down select-icon"></i>
              </div>
            </div>

            <div class="form-group half-width">
              <label for="priority">Priority Level</label>
              <div class="select-wrapper">
                <select v-model="priority" required>
                  <option value="" disabled selected>Select Priority</option>
                  <option value="Urgent">Urgent</option>
                  <option value="Moderate">Moderate</option>
                  <option value="Not Urgent">Not Urgent</option>
                </select>
                <i class="bx bx-chevron-down select-icon"></i>
              </div>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group half-width">
              <label for="startDate">Start Date & Time</label>
              <input type="datetime-local" id="startDate" v-model="startDate" required />
            </div>

            <div class="form-group half-width">
              <label for="endDate">End Date & Time</label>
              <input type="datetime-local" id="endDate" v-model="endDate" required />
            </div>
          </div>

          <div class="modal-footer">
            <button type="submit" class="publish-btn">
              <i class='bx bx-check'></i> Publish
            </button>
            <button type="button" class="cancel-btn" @click="cancelCreateModal">
              <i class='bx bx-x'></i> Cancel
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Announcement Detail Modal -->
    <div v-if="showDetailModal" class="modal-overlay" @click="closeDetailModal">
      <div class="modal-content detail-modal" @click.stop>
        <div class="modal-header">
          <h3>Announcement Details</h3>
          <button class="close-button" @click="closeDetailModal">
            <i class='bx bx-x'></i>
          </button>
        </div>
        
        <div class="modal-body" v-if="selectedAnnouncement">
          <div class="detail-status-banner" :class="getStatusClass(selectedAnnouncement)">
            <span class="status-icon">
              <i class='bx bx-check-circle' v-if="getAnnouncementStatus(selectedAnnouncement) === 'active'"></i>
              <i class='bx bx-time' v-else-if="getAnnouncementStatus(selectedAnnouncement) === 'pending'"></i>
              <i class='bx bx-x-circle' v-else-if="getAnnouncementStatus(selectedAnnouncement) === 'expired'"></i>
              <i class='bx bx-trash' v-else-if="getAnnouncementStatus(selectedAnnouncement) === 'deleted'"></i>
            </span>
            <span class="status-text">{{ getAnnouncementStatusText(selectedAnnouncement) }}</span>
          </div>
          
          <div class="detail-title-section">
            <h2>{{ selectedAnnouncement.title }}</h2>
            <div class="detail-meta">
              <div class="detail-meta-item">
                <i class='bx bx-calendar'></i>
                <span>Posted: {{ formatDate(selectedAnnouncement.createdAt) }}</span>
              </div>
              <div class="detail-meta-item">
                <i class='bx bx-user'></i>
                <span>By: Owner</span>
              </div>
            </div>
          </div>
          
          <div class="detail-section">
            <div class="detail-section-header">
              <i class='bx bx-info-circle'></i>
              <h4>Details</h4>
            </div>
            <div class="detail-section-content">
              <div class="detail-info-row">
                <div class="detail-info-group">
                  <label>Target Audience</label>
                  <div class="detail-info-value">
                    <i class='bx bx-group'></i>
                    {{ selectedAnnouncement.targetUser }}
                  </div>
                </div>
                <div class="detail-info-group">
                  <label>Priority</label>
                  <div class="detail-info-value">
                    <i class='bx bx-flag'></i>
                    <span v-if="selectedAnnouncement.priority === '1'">High</span>
                    <span v-else-if="selectedAnnouncement.priority === '2'">Medium</span>
                    <span v-else-if="selectedAnnouncement.priority === '3'">Low</span>
                    <span v-else>{{ selectedAnnouncement.priority }}</span>
                  </div>
                </div>
              </div>
              <div class="detail-info-row">
                <div class="detail-info-group">
                  <label>Start Date</label>
                  <div class="detail-info-value">
                    <i class='bx bx-calendar-plus'></i>
                    {{ formatDate(selectedAnnouncement.startDate) }}
                  </div>
                </div>
                <div class="detail-info-group">
                  <label>End Date</label>
                  <div class="detail-info-value">
                    <i class='bx bx-calendar-x'></i>
                    {{ formatDate(selectedAnnouncement.endDate) }}
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="detail-section">
            <div class="detail-section-header">
              <i class='bx bx-message-square-detail'></i>
              <h4>Announcement Content</h4>
            </div>
            <div class="detail-section-content">
              <div class="detail-description">
                {{ selectedAnnouncement.description }}
              </div>
              
              <div v-if="selectedAnnouncement.image" class="detail-image-container">
                <img 
                  :src="getImageUrl(selectedAnnouncement.image)" 
                  alt="Announcement Image" 
                  class="detail-image" 
                  @error="handleImageError"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Edit Announcement Modal -->
    <div v-if="showEditModal" class="modal-overlay">
      <div class="modal-content" @click.stop>
        <div class="modal-header">
          <h3>Edit Announcement</h3>
          <button class="close-button" @click="closeEditModal">
            <i class='bx bx-x'></i>
          </button>
        </div>
        
        <form class="modal-body" @submit.prevent="updateAnnouncement">
          <div class="form-group">
            <label for="edit-title">Title</label>
            <input type="text" id="edit-title" v-model="editForm.title" required placeholder="Enter announcement title" />
          </div>

          <div class="form-group">
            <label for="edit-description">Description</label>
            <textarea id="edit-description" v-model="editForm.description" required placeholder="Enter announcement details"></textarea>
          </div>

          <div class="form-group">
            <label for="edit-attachment">Image</label>
            <div v-if="editForm.image" class="announcement-image-container">
              <img 
                :src="getImageUrl(editForm.image)" 
                alt="Current Announcement Image" 
                class="announcement-image" 
                @error="handleImageError"
              />
            </div>
            <div class="file-input-wrapper">
              <input type="file" id="edit-attachment" @change="handleEditFileUpload" accept="image/png, image/jpeg" />
              <p v-if="editForm.image">Replace current image (optional)</p>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group half-width">
              <label for="edit-target-user">Target Audience</label>
              <div class="select-wrapper">
                <select id="edit-target-user" v-model="editForm.targetUser" required>
                  <option value="">Select audience</option>
                  <option value="patients">Patients</option>
                  <option value="Dentist">Dentist</option>
                  <option value="All">All</option>
                </select>
                <i class="bx bx-chevron-down select-icon"></i>
              </div>
            </div>

            <div class="form-group half-width">
              <label for="edit-priority">Priority Level</label>
              <div class="select-wrapper">
                <select v-model="editForm.priority" required>
                  <option value="" disabled>Select Priority</option>
                  <option value="Urgent">Urgent</option>
                  <option value="Moderate">Moderate</option>
                  <option value="Not Urgent">Not Urgent</option>
                </select>
                <i class="bx bx-chevron-down select-icon"></i>
              </div>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group half-width">
              <label for="edit-startDate">Start Date & Time</label>
              <input type="datetime-local" id="edit-startDate" v-model="editForm.startDate" required />
            </div>

            <div class="form-group half-width">
              <label for="edit-endDate">End Date & Time</label>
              <input type="datetime-local" id="edit-endDate" v-model="editForm.endDate" required />
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="cancel-btn" @click="closeEditModal">
              <i class='bx bx-x'></i> Cancel
            </button>
            <button type="submit" class="publish-btn">
              <i class='bx bx-check'></i> Save
            </button>
          </div>
        </form>
      </div>
    </div>
  </section>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
  name: "OwnerAnnouncements",
  props: {
    firstName: { type: String, required: true },
    lastName: { type: String, required: true },
  },
  data() {
    return {
      showModal: false,
      showSuccessModal: false,
      showDetailModal: false,
      showEditModal: false,
      announcementToDelete: null,
      selectedAnnouncement: null,
      editForm: {
        id: null,
        title: "",
        description: "",
        attachment: null,
        targetUser: "",
        priority: "",
        startDate: "",
        endDate: "",
        image: null,
        createdBy: "Owner",
      },
      title: "",
      description: "",
      attachment: null,
      targetUser: "",
      priority: "",
      startDate: "",
      endDate: "",
      searchQuery: "",
      isSearchActive: false,
      publishedAnnouncements: [],
      unpublishedAnnouncements: [],
      pastAnnouncements: [],
      deletedAnnouncements: [],
      displayedPublished: [],
      displayedUnpublished: [],
      displayedPast: [],
      displayedDeleted: [],
      isLoading: false,
      endTimeInterval: null,
      activeTab: 'published',
    };
  },
  computed: {
    fullName() {
      return `${this.firstName} ${this.lastName}`;
    },
    activeAnnouncements() {
      const now = new Date();
      return this.publishedAnnouncements.filter(announcement => {
        const endDate = new Date(announcement.endDate);
        return endDate >= now && announcement.status === 'active';
      });
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
    closeMobileSidebar() {
      const sidebar = document.querySelector(".sidebar");
      const overlay = document.querySelector(".mobile-overlay");
      if (window.innerWidth <= 768) {
        sidebar.classList.add("close");
        overlay.classList.remove("active");
      }
    },
    filterAnnouncements() {
      if (!this.searchQuery.trim()) {
        this.displayedPublished = this.publishedAnnouncements;
        this.displayedUnpublished = this.unpublishedAnnouncements;
        this.displayedPast = this.pastAnnouncements;
        this.displayedDeleted = this.deletedAnnouncements;
        this.isSearchActive = false;
        return;
      }
      const query = this.searchQuery.toLowerCase().trim();
      this.displayedPublished = this.publishedAnnouncements.filter(announcement => 
        announcement.title?.toLowerCase().includes(query) ||
        announcement.description?.toLowerCase().includes(query) ||
        announcement.targetUser?.toLowerCase().includes(query)
      );
      this.displayedUnpublished = this.unpublishedAnnouncements.filter(announcement => 
        announcement.title?.toLowerCase().includes(query) ||
        announcement.description?.toLowerCase().includes(query) ||
        announcement.targetUser?.toLowerCase().includes(query)
      );
      this.displayedPast = this.pastAnnouncements.filter(announcement => 
        announcement.title?.toLowerCase().includes(query) ||
        announcement.description?.toLowerCase().includes(query) ||
        announcement.targetUser?.toLowerCase().includes(query)
      );
      this.displayedDeleted = this.deletedAnnouncements.filter(announcement => 
        announcement.title?.toLowerCase().includes(query) ||
        announcement.description?.toLowerCase().includes(query) ||
        announcement.targetUser?.toLowerCase().includes(query)
      );
      this.isSearchActive = true;
    },
    resetSearch() {
      this.searchQuery = '';
      this.displayedPublished = this.publishedAnnouncements;
      this.displayedUnpublished = this.unpublishedAnnouncements;
      this.displayedPast = this.pastAnnouncements;
      this.displayedDeleted = this.deletedAnnouncements;
      this.isSearchActive = false;
    },
    formatDate(date) {
      if (!date) return "N/A";
      const parsedDate = new Date(date);
      return isNaN(parsedDate.getTime()) ? "N/A" : parsedDate.toLocaleString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      });
    },
    formatDateForInput(date) {
      if (!date) return "";
      const parsedDate = new Date(date);
      if (isNaN(parsedDate.getTime())) return "";
      const offset = parsedDate.getTimezoneOffset();
      const adjustedDate = new Date(parsedDate.getTime() - (offset * 60 * 1000));
      return adjustedDate.toISOString().slice(0, 16);
    },
    handleFileUpload(event) {
      this.attachment = event.target.files[0];
    },
    handleEditFileUpload(event) {
      this.editForm.attachment = event.target.files[0];
    },
    getImageUrl(imagePath) {
      if (!imagePath) return null;
      if (!imagePath.startsWith("data:") && !imagePath.startsWith("http")) {
        return `/storage/${imagePath}`;
      }
      return imagePath;
    },
    handleImageError(event) {
      event.target.style.display = 'none';
    },
    openDetailModal(announcement) {
      this.selectedAnnouncement = announcement;
      this.showDetailModal = true;
      document.body.style.overflow = 'hidden';
    },
    closeDetailModal() {
      this.showDetailModal = false;
      document.body.style.overflow = 'auto';
      setTimeout(() => {
        this.selectedAnnouncement = null;
      }, 300);
    },
    closeEditModal() {
      Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to cancel editing this announcement?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#06693A',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, cancel',
        cancelButtonText: 'No, keep editing'
      }).then((result) => {
        if (result.isConfirmed) {
          this.showEditModal = false;
          document.body.style.overflow = 'auto';
          this.resetEditForm();
        }
      });
    },
    openEditModal(announcement) {
      console.log('Opening edit modal with announcement:', announcement);
      this.editForm = {
        id: announcement.id || announcement.AnnouncementId,
        title: announcement.title || "",
        description: announcement.description || "",
        targetUser: announcement.targetUser || "",
        priority: announcement.priority || "",
        startDate: this.formatDateForInput(announcement.startDate) || "",
        endDate: this.formatDateForInput(announcement.endDate) || "",
        image: announcement.image || null,
        attachment: null,
        createdBy: announcement.createdBy || "Owner"
      };
      console.log('editForm after setting values:', this.editForm);
      this.showEditModal = true;
      document.body.style.overflow = 'hidden';
    },
    resetEditForm() {
      this.editForm = {
        id: null,
        title: "",
        description: "",
        attachment: null,
        targetUser: "",
        priority: "",
        startDate: "",
        endDate: "",
        image: null,
        createdBy: "Owner"
      };
    },
    getAnnouncementStatus(announcement) {
      if (announcement.deletedAt) return 'deleted';
      if (announcement.status === 'expired') return 'expired';
      const now = new Date();
      const startDate = new Date(announcement.startDate);
      const endDate = new Date(announcement.endDate);
      if (startDate > now) return 'pending';
      if (endDate < now) return 'expired';
      return 'active';
    },
    getAnnouncementStatusText(announcement) {
      const status = this.getAnnouncementStatus(announcement);
      switch(status) {
        case 'active': return 'Active';
        case 'pending': return 'Pending';
        case 'expired': return 'Expired';
        case 'deleted': return 'Deleted';
        default: return 'Unknown';
      }
    },
    getStatusClass(announcement) {
      const status = this.getAnnouncementStatus(announcement);
      switch(status) {
        case 'active': return 'status-active';
        case 'pending': return 'status-pending';
        case 'expired': return 'status-expired';
        case 'deleted': return 'status-deleted';
        default: return '';
      }
    },
    canEditAnnouncement(announcement) {
      if (!announcement) return false;
      const status = this.getAnnouncementStatus(announcement);
      return status !== 'expired' && status !== 'deleted';
    },
    async createPost() {
      const now = new Date();
      const endDate = new Date(this.endDate);
      if (endDate <= now) {
        Swal.fire({
          icon: 'error',
          title: 'Invalid Date',
          text: 'End Date must be in the future.',
          confirmButtonColor: '#06693A'
        });
        return;
      }
      this.title = this.title.replace(/[^\x00-\x7F]/g, '');
      this.description = this.description.replace(/[^\x00-\x7F]/g, '');
      const formData = new FormData();
      formData.append("AnnouncementTitle", this.title);
      formData.append("AnnouncementDescription", this.description);
      formData.append("TargetUser", this.targetUser);
      formData.append("Priority", this.priority);
      formData.append("StartDate", this.startDate);
      formData.append("EndDate", this.endDate);
      formData.append("CreatedBy", "Owner");
      if (this.attachment) {
        formData.append("AnnouncementPicture", this.attachment);
      }
      try {
        const response = await axios.post("/announcements/store/owner", formData, {
          headers: { 
            "Content-Type": "multipart/form-data",
            "Accept": "application/json"
          },
        });
        this.showModal = false;
        this.showSuccessModal = true;
        setTimeout(() => {
          this.showSuccessModal = false;
        }, 3000);
        this.title = "";
        this.description = "";
        this.attachment = null;
        this.targetUser = "";
        this.priority = "";
        this.startDate = "";
        this.endDate = "";
        this.fetchAnnouncements();
        Swal.fire({
          icon: 'success',
          title: 'Success!',
          text: 'Announcement published successfully.',
          showConfirmButton: false,
          timer: 2000
        });
      } catch (error) {
        console.error("Error creating post:", error.response ? error.response.data : error.message);
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: error.response?.data?.message || "Failed to create post: Network error",
          confirmButtonColor: '#06693A'
        });
      }
    },
    async confirmPublish() {
      Swal.fire({
        title: 'Are you sure?',
        text: `This announcement will be visible from ${this.formatDate(this.startDate)} until ${this.formatDate(this.endDate)}.`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#06693A',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, publish',
        cancelButtonText: 'No, cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          this.createPost();
        }
      });
    },
    cancelCreateModal() {
      Swal.fire({
        title: 'Are you sure?',
        text: "Are you sure you don't want to continue publishing this announcement?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#06693A',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, cancel',
        cancelButtonText: 'No, keep editing'
      }).then((result) => {
        if (result.isConfirmed) {
          this.showModal = false;
          this.title = "";
          this.description = "";
          this.attachment = null;
          this.targetUser = "";
          this.priority = "";
          this.startDate = "";
          this.endDate = "";
        }
      });
    },
    async updateAnnouncement() {
      const now = new Date();
      const endDate = new Date(this.editForm.endDate);
      if (endDate <= now) {
        Swal.fire({
          icon: 'error',
          title: 'Invalid Date',
          text: 'End Date must be in the future.',
          confirmButtonColor: '#06693A'
        });
        return;
      }
      if (!this.editForm.id) {
        console.error('Announcement ID is missing:', this.editForm);
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Announcement ID is missing. Please try again.',
          confirmButtonColor: '#06693A'
        });
        return;
      }
      Swal.fire({
        title: 'Are you sure?',
        text: "Are you sure you want to save changes to this announcement?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#06693A',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, save',
        cancelButtonText: 'No, cancel'
      }).then(async (result) => {
        if (result.isConfirmed) {
          const formData = new FormData();
          formData.append("AnnouncementTitle", this.editForm.title.trim().replace(/[^\x00-\x7F]/g, ''));
          formData.append("AnnouncementDescription", this.editForm.description.trim().replace(/[^\x00-\x7F]/g, ''));
          formData.append("TargetUser", this.editForm.targetUser.trim());
          formData.append("Priority", this.editForm.priority.trim());
          formData.append("StartDate", this.editForm.startDate.trim());
          formData.append("EndDate", this.editForm.endDate.trim());
          formData.append("CreatedBy", this.editForm.createdBy.trim());
          if (this.editForm.attachment) {
            formData.append("AnnouncementPicture", this.editForm.attachment);
          }
          formData.append("_method", "PUT");
          try {
            const response = await axios.post(
              `/announcements/update/${this.editForm.id}`,
              formData,
              {
                headers: {
                  "Content-Type": "multipart/form-data",
                  "Accept": "application/json"
                }
              }
            );
            console.log('Update response:', response.data);
            this.showEditModal = false;
            this.showSuccessModal = true;
            setTimeout(() => {
              this.showSuccessModal = false;
            }, 3000);
            this.resetEditForm();
            this.fetchAnnouncements();
            Swal.fire({
              icon: 'success',
              title: 'Success!',
              text: 'Announcement updated successfully.',
              showConfirmButton: false,
              timer: 2000
            });
          } catch (error) {
            console.error("Error updating announcement:", error.response ? error.response.data : error.message);
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: error.response?.data?.message || "Failed to update announcement. Please try again.",
              confirmButtonColor: '#06693A'
            });
          }
        }
      });
    },
    async fetchAnnouncements() {
      try {
        this.isLoading = true;
        const response = await axios.get("/announcements?createdBy=Owner");
        console.log('Fetched announcements from backend:', response.data);
        const currentTime = new Date();
        const priorityOrder = {
          Urgent: 1,
          Moderate: 2,
          "Not Urgent": 3
        };
        const sortByPriorityAndDate = (a, b) => {
          const priorityA = priorityOrder[a.priority] || 999;
          const priorityB = priorityOrder[b.priority] || 999;
          if (priorityA !== priorityB) {
            return priorityA - priorityB;
          }
          return new Date(b.createdAt) - new Date(a.createdAt);
        };
        const mapAnnouncement = (announcement) => {
          const mappedAnnouncement = {
            id: announcement.AnnouncementId || announcement.AnnouncementID || announcement.id || null,
            title: announcement.AnnouncementTitle || '',
            description: announcement.AnnouncementDescription || '',
            startDate: announcement.StartDate || '',
            endDate: announcement.EndDate || '',
            createdAt: announcement.created_at || '',
            deletedAt: announcement.deleted_at || null,
            image: announcement.AnnouncementPicture || null,
            targetUser: announcement.TargetUser || '',
            priority: announcement.Priority || "N/A",
            status: announcement.Status || '',
            createdBy: announcement.CreatedBy || ''
          };
          console.log('Mapped announcement:', mappedAnnouncement);
          if (!mappedAnnouncement.id) {
            console.error('Announcement missing ID:', announcement);
          }
          return mappedAnnouncement;
        };
        this.unpublishedAnnouncements = response.data
          .filter(ann => {
            const startDate = new Date(ann.StartDate);
            return startDate > currentTime && !ann.deleted_at;
          })
          .map(mapAnnouncement)
          .sort(sortByPriorityAndDate);
        this.publishedAnnouncements = response.data
          .filter(ann => {
            const startDate = new Date(ann.StartDate);
            const endDate = new Date(ann.EndDate);
            const isActive = startDate <= currentTime && endDate >= currentTime && ann.Status === 'active' && !ann.deleted_at;
            return isActive;
          })
          .map(mapAnnouncement)
          .sort(sortByPriorityAndDate);
        this.pastAnnouncements = response.data
          .filter(ann => {
            return ann.Status === 'expired' && !ann.deleted_at;
          })
          .map(mapAnnouncement)
          .sort(sortByPriorityAndDate);
        this.deletedAnnouncements = response.data
          .filter(ann => ann.deleted_at)
          .map(mapAnnouncement)
          .sort((a, b) => new Date(b.deletedAt) - new Date(a.deletedAt));
        console.log('Deleted announcements after fetch:', this.deletedAnnouncements);
        if (!this.isSearchActive) {
          this.displayedPublished = this.publishedAnnouncements;
          this.displayedUnpublished = this.unpublishedAnnouncements;
          this.displayedPast = this.pastAnnouncements;
          this.displayedDeleted = this.deletedAnnouncements;
        }
      } catch (error) {
        console.error("Error fetching announcements:", error);
      } finally {
        this.isLoading = false;
      }
    },
    openDeleteConfirmModal(announcement) {
      console.log('Opening delete confirmation for announcement:', announcement);
      this.announcementToDelete = {
        id: announcement.id || announcement.AnnouncementId,
        title: announcement.title || '',
        description: announcement.description || '',
        startDate: announcement.startDate || '',
        endDate: announcement.endDate || '',
        createdAt: announcement.createdAt || '',
        image: announcement.image || null,
        targetUser: announcement.targetUser || '',
        priority: announcement.priority || '',
        status: announcement.status || '',
        createdBy: announcement.createdBy || ''
      };
      console.log('announcementToDelete set to:', this.announcementToDelete);
      Swal.fire({
        title: 'Are you sure?',
        text: `Are you sure you want to delete "${this.announcementToDelete.title}"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#06693A',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'No, cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          this.deleteAnnouncement();
        } else {
          this.announcementToDelete = null;
        }
      });
    },
    async deleteAnnouncement() {
      if (!this.announcementToDelete || !this.announcementToDelete.id) {
        console.error('No announcement ID to delete:', this.announcementToDelete);
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Cannot delete: Announcement ID is missing.',
          confirmButtonColor: '#06693A'
        });
        this.announcementToDelete = null;
        return;
      }
      const announcementId = this.announcementToDelete.id;
      const deletedAnnouncement = { ...this.announcementToDelete, deletedAt: new Date().toISOString(), status: 'deleted' };
      try {
        console.log('Deleting announcement with ID:', announcementId);
        const response = await axios.delete(`/announcements/${announcementId}`);
        console.log('Delete response:', response.data);
        this.deletedAnnouncements = [deletedAnnouncement, ...this.deletedAnnouncements]
          .sort((a, b) => new Date(b.deletedAt) - new Date(a.deletedAt));
        this.publishedAnnouncements = this.publishedAnnouncements.filter(
          ann => ann.id !== announcementId
        );
        this.unpublishedAnnouncements = this.unpublishedAnnouncements.filter(
          ann => ann.id !== announcementId
        );
        this.pastAnnouncements = this.pastAnnouncements.filter(
          ann => ann.id !== announcementId
        );
        this.displayedPublished = this.displayedPublished.filter(
          ann => ann.id !== announcementId
        );
        this.displayedUnpublished = this.displayedUnpublished.filter(
          ann => ann.id !== announcementId
        );
        this.displayedPast = this.displayedPast.filter(
          ann => ann.id !== announcementId
        );
        this.displayedDeleted = [deletedAnnouncement, ...this.displayedDeleted]
          .sort((a, b) => new Date(b.deletedAt) - new Date(a.deletedAt));
        this.announcementToDelete = null;
        this.showSuccessModal = true;
        setTimeout(() => {
          this.showSuccessModal = false;
        }, 3000);
        await this.fetchAnnouncements();
        Swal.fire({
          icon: 'success',
          title: 'Success!',
          text: 'Announcement deleted successfully.',
          showConfirmButton: false,
          timer: 2000
        });
      } catch (error) {
        console.error('Error deleting announcement:', error.response ? error.response.data : error.message);
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: error.response?.data?.message || 'Failed to delete announcement: Network error',
          confirmButtonColor: '#06693A'
        });
        this.announcementToDelete = null;
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
    this.fetchAnnouncements();
    this.endTimeInterval = setInterval(() => {
      const now = new Date();
      const readyToPublish = this.unpublishedAnnouncements.filter(announcement => {
        const startDate = new Date(announcement.startDate);
        return startDate <= now;
      });
      this.unpublishedAnnouncements = this.unpublishedAnnouncements.filter(announcement => {
        const startDate = new Date(announcement.startDate);
        return startDate > now;
      });
      this.publishedAnnouncements = [...this.publishedAnnouncements, ...readyToPublish];
      this.displayedUnpublished = this.displayedUnpublished.filter(announcement => {
        const startDate = new Date(announcement.startDate);
        return startDate > now;
      });
      this.displayedPublished = [...this.displayedPublished, ...readyToPublish.filter(ann => 
        this.displayedUnpublished.some(d => d.id === ann.id)
      )];
      const expired = this.publishedAnnouncements.filter(announcement => {
        const endDate = new Date(announcement.endDate);
        return endDate < now || announcement.status === 'expired';
      });
      this.publishedAnnouncements = this.publishedAnnouncements.filter(announcement => {
        const endDate = new Date(announcement.endDate);
        return endDate >= now && announcement.status === 'active';
      });
      this.pastAnnouncements = [...this.pastAnnouncements, ...expired];
      this.displayedPublished = this.displayedPublished.filter(announcement => {
        const endDate = new Date(announcement.endDate);
        return endDate >= now && announcement.status === 'active';
      });
      this.displayedPast = [...this.displayedPast, ...expired.filter(ann => 
        this.displayedPublished.some(d => d.id === ann.id)
      )];
      if (this.isSearchActive) {
        this.filterAnnouncements();
      }
    }, 1000);
  },
  beforeUnmount() {
    if (this.endTimeInterval) {
      clearInterval(this.endTimeInterval);
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

/* Search and Create Post */
.search-wrapper {
  width: 97%;
  margin: 25px 20px 15px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 15px;
}

.search-container {
  position: relative;
  flex: 1;
}

.search-input {
  width: 100%;
  height: 48px;
  padding: 0 45px 0 15px;
  border: none;
  border-radius: 8px;
  background-color: white;
  font-size: 15px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
  transition: all 0.3s ease;
}

.search-input.has-reset {
  padding-right: 80px;
}

.search-input:focus {
  outline: none;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
}

.search-icon {
  position: absolute;
  right: 15px;
  top: 50%;
  transform: translateY(-50%);
  font-size: 20px;
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

.create-post-btn {
  padding: 12px 20px;
  background-color: white;
  color: #333;
  border: none;
  border-radius: 8px;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 8px;
  transition: background-color 0.2s;
  white-space: nowrap;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
}

.create-post-btn:hover {
  background-color: #f5f5f5;
}

.create-post-btn i {
  font-size: 16px;
}

/* Filter Buttons */
.filter-buttons {
  display: flex;
  gap: 15px;
  margin: 20px;
  justify-content: center;
}

.filter-button {
  padding: 10px 20px;
  background-color: white;
  border: 1px solid #e0e0e0;
  border-radius: 20px;
  cursor: pointer;
  font-size: 14px;
  font-weight: 500;
  display: flex;
  align-items: center;
  gap: 8px;
  transition: all 0.3s ease;
  color: #555;
  min-width: 140px;
  justify-content: center;
}

.filter-button i {
  color: #06693A;
  font-size: 16px;
}

.filter-button.active {
  background-color: #06693A;
  color: white;
  border-color: #06693A;
}

.filter-button.active i {
  color: white;
}

.filter-button:hover:not(.active) {
  background-color: #f5f5f5;
}

/* Announcements Container */
.announcements-container {
  margin: 20px;
  padding: 0;
}

.section-header {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 20px;
  padding: 0 5px;
}

.section-header i {
  font-size: 24px;
  color: #06693A;
}

.section-header h2 {
  font-size: 22px;
  font-weight: 600;
  color: #333;
  margin: 0;
}

.announcements-list {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.announcement-card {
  background-color: white;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  cursor: pointer;
}

.announcement-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
}

.past-card {
  border-left: 3px solid #999;
}

.deleted-card {
  border-left: 3px solid #ff4d4f;
  opacity: 0.8;
}

.announcement-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  padding: 20px 20px 15px;
  border-bottom: 1px solid #f0f0f0;
}

.announcement-title-area {
  display: flex;
  align-items: center;
  gap: 12px;
  flex: 1;
}

.announcement-icon {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 40px;
  height: 40px;
  background-color: rgba(6, 105, 58, 0.1);
  border-radius: 8px;
  color: #06693A;
  flex-shrink: 0;
}

.announcement-icon i {
  font-size: 20px;
}

.announcement-title {
  font-size: 18px;
  font-weight: 600;
  color: #333;
  margin: 0;
  word-break: break-word;
}

.announcement-actions {
  display: flex;
  gap: 5px;
  flex-shrink: 0;
}

.action-button {
  background: none;
  border: none;
  cursor: pointer;
  color: #666;
  width: 32px;
  height: 32px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background-color 0.2s;
}

.action-button:hover {
  background-color: rgba(0, 0, 0, 0.05);
}

.action-button i {
  font-size: 18px;
}

.announcement-content {
  padding: 20px;
}

.announcement-meta {
  display: flex;
  flex-wrap: wrap;
  gap: 16px;
  margin-bottom: 15px;
  font-size: 13px;
  color: #666;
}

.meta-item {
  display: flex;
  align-items: center;
  gap: 6px;
}

.meta-item i {
  font-size: 16px;
  color: #06693A;
  flex-shrink: 0;
}

.status-badge {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  padding: 4px 10px;
  border-radius: 20px;
  font-size: 12px;
  font-weight: 500;
}

.status-badge.active {
  background-color: #e6f7ee;
  color: #0d904b;
}

.status-badge.pending {
  background-color: #fff8e6;
  color: #e6a700;
}

.status-badge.expired {
  background-color: #f5f5f5;
  color: #777;
}

.status-badge.deleted {
  background-color: #ff4d4f;
  color: white;
}

.announcement-description {
  margin: 0 0 16px 0;
  font-size: 15px;
  color: #444;
  line-height: 1.6;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
}

.announcement-image-container {
  width: 100%;
  height: 200px;
  overflow: hidden;
  border-radius: 8px;
}

.announcement-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.5s ease;
}

.announcement-card:hover .announcement-image {
  transform: scale(1.05);
}

.announcement-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px 20px;
  border-top: 1px solid #f0f0f0;
  background-color: #f9f9f9;
}

.announcement-author {
  display: flex;
  align-items: center;
  gap: 6px;
  color: #666;
  font-size: 14px;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.announcement-author i {
  font-size: 16px;
  color: #06693A;
  flex-shrink: 0;
}

.announcement-author span {
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.read-more-button {
  display: flex;
  align-items: center;
  gap: 5px;
  background: none;
  border: none;
  color: #06693A;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  padding: 6px 10px;
  border-radius: 4px;
  transition: background-color 0.2s ease;
  white-space: nowrap;
  flex-shrink: 0;
}

.read-more-button:hover {
  background-color: rgba(6, 105, 58, 0.1);
}

.read-more-button i {
  font-size: 18px;
  transition: transform 0.2s ease;
}

.read-more-button:hover i {
  transform: translateX(3px);
}

.pagination-container {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 15px;
  margin-top: 10px;
}

.pagination-button {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: white;
  border: 1px solid #e0e0e0;
  cursor: pointer;
  transition: all 0.2s ease;
}

.pagination-button:hover {
  background-color: #f0f0f0;
}

.pagination-button i {
  font-size: 18px;
  color: #06693A;
}

.pagination-info {
  font-size: 14px;
  color: #666;
}

.loading-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 60px 0;
  background-color: white;
  border-radius: 12px;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
}

.loading-spinner {
  width: 40px;
  height: 40px;
  border: 3px solid rgba(6, 105, 58, 0.1);
  border-radius: 50%;
  border-top-color: #06693A;
  animation: spin 1s linear infinite;
  margin-bottom: 15px;
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}

.loading-container p {
  color: #666;
  font-size: 16px;
}

.empty-state {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 60px 0;
  background-color: white;
  border-radius: 12px;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
  text-align: center;
}

.empty-icon {
  width: 70px;
  height: 70px;
  border-radius: 50%;
  background-color: rgba(6, 105, 58, 0.1);
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 20px;
}

.empty-icon i {
  font-size: 28px;
  color: #06693A;
}

.empty-state h3 {
  font-size: 18px;
  font-weight: 600;
  color: #333;
  margin: 0 0 10px;
}

.empty-state p {
  font-size: 14px;
  color: #666;
  max-width: 300px;
  margin: 0;
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
  backdrop-filter: blur(3px);
}

.modal-content {
  width: 90%;
  max-width: 800px;
  max-height: 90vh;
  background-color: white;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
  animation: modalFadeIn 0.3s ease;
}

.confirm-modal {
  max-width: 500px;
}

.detail-modal {
  max-width: 900px;
}

@keyframes modalFadeIn {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.confirm-header {
  display: flex;
  align-items: center;
  gap: 10px;
}

.confirm-icon {
  font-size: 24px;
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
  word-break: break-word;
}

.close-button {
  background: none;
  border: none;
  font-size: 24px;
  color: #777;
  cursor: pointer;
  transition: color 0.3s ease;
  flex-shrink: 0;
}

.close-button:hover {
  color: #333;
}

.close-button i {
  font-size: 20px;
}

.modal-body {
  padding: 25px;
  overflow-y: auto;
  max-height: calc(90vh - 140px);
}

.confirm-body {
  text-align: center;
  padding: 30px 25px;
}

.confirm-body p {
  font-size: 16px;
  color: #333;
  line-height: 1.5;
}

.form-group {
  margin-bottom: 20px;
}

.form-group label {
  display: block;
  margin-bottom: 8px;
  font-weight: 500;
  color: #444;
  font-size: 14px;
}

.form-row {
  display: flex;
  gap: 20px;
  margin-bottom: 20px;
}

.half-width {
  flex: 1;
}

input, textarea, select {
  width: 100%;
  padding: 10px 12px;
  border: 1px solid #ddd;
  border-radius: 8px;
  font-size: 14px;
  transition: border-color 0.2s, box-shadow 0.2s;
}

input:focus, textarea:focus, select:focus {
  border-color: #06693A;
  box-shadow: 0 0 0 2px rgba(6, 105, 58, 0.1);
  outline: none;
}

textarea {
  resize: none;
  min-height: 120px;
}

.file-input-wrapper {
  border: 1px dashed #ddd;
  border-radius: 8px;
  padding: 15px;
  text-align: center;
  transition: border-color 0.2s;
}

.file-input-wrapper:hover {
  border-color: #06693A;
}

.select-wrapper {
  position: relative;
}

.select-icon {
  position: absolute;
  right: 12px;
  top: 50%;
  transform: translateY(-50%);
  color: #666;
  pointer-events: none;
}

select {
  appearance: none;
  padding-right: 30px;
  background-color: white;
}

.modal-footer {
  display: flex;
  justify-content: flex-end;
  gap: 15px;
  padding: 20px 25px;
  border-top: 1px solid #f0f0f0;
  background-color: #f9f9f9;
}

.cancel-btn {
  padding: 10px 20px;
  background: #f0f0f0;
  color: #333;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-size: 14px;
  font-weight: 500;
  display: flex;
  align-items: center;
  gap: 5px;
  transition: background-color 0.2s;
}

.cancel-btn:hover {
  background: #e0e0e0;
}

.publish-btn {
  padding: 10px 20px;
  background: #06693A;
  color: white;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-size: 14px;
  font-weight: 500;
  display: flex;
  align-items: center;
  gap: 5px;
  transition: background-color 0.2s;
}

.publish-btn:hover {
  background: #055a32;
}

/* Success Modal */
.success-modal {
  background: white;
  width: 90%;
  max-width: 400px;
  border-radius: 12px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
  padding: 30px;
  text-align: center;
  animation: successPop 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

@keyframes successPop {
  from {
    opacity: 0;
    transform: scale(0.8);
  }
  to {
    opacity: 1;
    transform: scale(1);
  }
}

.success-icon {
  display: flex;
  justify-content: center;
  margin-bottom: 20px;
}

.success-icon i {
  font-size: 60px;
  color: #06693A;
}

.success-modal h3 {
  margin: 0 0 10px 0;
  font-size: 24px;
  font-weight: 600;
  color: #333;
}

.success-modal p {
  margin: 0;
  font-size: 16px;
  color: #555;
}

/* Detail Modal Styles */
.detail-status-banner {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 15px;
  border-radius: 8px;
  margin-bottom: 25px;
}

.detail-status-banner.status-active {
  background-color: #e6f7ee;
  color: #0d904b;
}

.detail-status-banner.status-pending {
  background-color: #fff8e6;
  color: #e6a700;
}

.detail-status-banner.status-expired {
  background-color: #f5f5f5;
  color: #777;
}

.detail-status-banner.status-deleted {
  background-color: #ff4d4f;
  color: white;
}

.status-icon i {
  font-size: 20px;
}

.status-text {
  font-weight: 600;
  font-size: 16px;
}

.detail-title-section {
  margin-bottom: 25px;
}

.detail-title-section h2 {
  font-size: 24px;
  font-weight: 600;
  color: #333;
  margin: 0 0 15px 0;
}

.detail-meta {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  font-size: 14px;
  color: #666;
}

.detail-meta-item {
  display: flex;
  align-items: center;
  gap: 8px;
}

.detail-meta-item i {
  font-size: 16px;
  color: #06693A;
}

.detail-section {
  margin-bottom: 30px;
}

.detail-section-header {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 15px;
  color: #06693A;
}

.detail-section-header i {
  font-size: 20px;
}

.detail-section-header h4 {
  font-size: 18px;
  font-weight: 600;
  margin: 0;
}

.detail-section-content {
  background-color: #f9f9f9;
  padding: 20px;
  border-radius: 8px;
}

.detail-info-row {
  display: flex;
  gap: 20px;
  margin-bottom: 15px;
}

.detail-info-row:last-child {
  margin-bottom: 0;
}

.detail-info-group {
  flex: 1;
}

.detail-info-group label {
  display: block;
  font-size: 14px;
  font-weight: 500;
  color: #555;
  margin-bottom: 8px;
}

.detail-info-value {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 12px;
  background-color: white;
  border-radius: 6px;
  border: 1px solid #e0e0e0;
  font-size: 15px;
  color: #333;
}

.detail-info-value i {
  font-size: 16px;
  color: #06693A;
}

.detail-description {
  padding: 15px;
  background-color: white;
  border-radius: 6px;
  border: 1px solid #e0e0e0;
  font-size: 15px;
  color: #333;
  line-height: 1.6;
  margin-bottom: 20px;
  white-space: pre-wrap;
}

.detail-image-container {
  width: 100%;
  max-height: 400px;
  overflow: hidden;
  border-radius: 8px;
  margin-top: 20px;
}

.detail-image {
  width: 100%;
  height: 100%;
  object-fit: contain;
}

/* Responsive Design */

/* Large Desktop */
@media (min-width: 1400px) {
  .announcements-container {
    margin: 30px;
  }
  
  .announcement-image-container {
    height: 240px;
  }
}

/* Desktop */
@media (max-width: 1200px) {
  .announcement-header {
    flex-direction: column;
    gap: 10px;
    align-items: flex-start;
  }
  
  .announcement-actions {
    align-self: flex-end;
  }
  
  .announcement-image-container {
    height: 180px;
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
    margin: 20px 15px 10px;
    flex-direction: column;
    align-items: stretch;
    gap: 10px;
  }
  
  .create-post-btn {
    width: 100%;
    justify-content: center;
  }
  
  .filter-buttons {
    flex-wrap: wrap;
    gap: 10px;
  }
  
  .filter-button {
    flex: 1;
    min-width: 120px;
  }
  
  .announcements-container {
    margin: 15px;
  }
  
  .section-header {
    margin-bottom: 15px;
  }
  
  .section-header h2 {
    font-size: 20px;
  }
  
  .announcement-card {
    border-radius: 10px;
  }
  
  .announcement-header {
    padding: 15px 15px 12px;
  }
  
  .announcement-icon {
    width: 36px;
    height: 36px;
  }
  
  .announcement-title {
    font-size: 16px;
  }
  
  .announcement-content {
    padding: 15px;
  }
  
  .announcement-description {
    font-size: 14px;
    margin-bottom: 15px;
  }
  
  .announcement-footer {
    padding: 12px 15px;
  }
  
  .form-row {
    flex-direction: column;
    gap: 15px;
  }
  
  .modal-content {
    max-width: 700px;
  }
  
  .modal-header {
    padding: 18px 20px;
  }
  
  .modal-body {
    padding: 20px;
  }
  
  .modal-description {
    font-size: 15px;
  }
  
  .detail-info-row {
    flex-direction: column;
    gap: 15px;
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
  
  .create-post-btn {
    width: 100%;
    justify-content: center;
  }
  
  .filter-buttons {
    flex-direction: row;
    flex-wrap: nowrap;
    overflow-x: auto;
    padding-bottom: 5px;
    margin: 15px 10px;
    gap: 10px;
  }
  
  .filter-button {
    flex: 0 0 auto;
    min-width: 120px;
    padding: 8px 16px;
    font-size: 13px;
  }
  
  .announcements-container {
    margin: 10px;
  }
  
  .section-header {
    margin-bottom: 15px;
  }
  
  .section-header h2 {
    font-size: 18px;
  }
  
  .announcement-card {
    border-radius: 8px;
  }
  
  .announcement-header {
    padding: 15px 15px 12px;
    flex-direction: column;
    gap: 10px;
    align-items: flex-start;
  }
  
  .announcement-actions {
    align-self: flex-end;
  }
  
  .announcement-title-area {
    gap: 10px;
  }
  
  .announcement-icon {
    width: 32px;
    height: 32px;
  }
  
  .announcement-icon i {
    font-size: 16px;
  }
  
  .announcement-title {
    font-size: 16px;
  }
  
  .announcement-content {
    padding: 15px;
  }
  
  .announcement-meta {
    flex-direction: column;
    gap: 8px;
  }
  
  .meta-item {
    font-size: 12px;
  }
  
  .announcement-description {
    font-size: 14px;
    margin-bottom: 15px;
    -webkit-line-clamp: 2;
  }
  
  .announcement-image-container {
    height: 160px;
  }
  
  .announcement-footer {
    padding: 12px 15px;
    flex-direction: column;
    align-items: flex-start;
    gap: 10px;
  }
  
  .read-more-button {
    align-self: flex-end;
    margin-top: -30px;
  }
  
  .modal-content, 
  .confirm-modal, 
  .success-modal,
  .detail-modal {
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
    max-height: calc(85vh - 60px);
  }
  
  .modal-footer {
    padding: 15px;
    flex-direction: column;
    gap: 10px;
  }
  
  .cancel-btn, 
  .publish-btn {
    width: 100%;
    justify-content: center;
  }
  
  .detail-meta {
    flex-direction: column;
    gap: 10px;
    margin-bottom: 20px;
  }
  
  .detail-description {
    font-size: 14px;
    margin-bottom: 20px;
  }
  
  .detail-image {
    max-height: 400px;
  }
  
  .empty-icon {
    width: 60px;
    height: 60px;
  }
  
  .empty-icon i {
    font-size: 24px;
  }
  
  .empty-state h3 {
    font-size: 16px;
  }
  
  .empty-state p {
    font-size: 13px;
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
    font-size: 18px;
  }
  
  .reset-button {
    right: 40px;
    width: 24px;
    height: 24px;
  }
  
  .reset-button i {
    font-size: 16px;
  }
  
  .filter-buttons {
    margin: 12px 8px;
  }
  
  .filter-button {
    padding: 6px 12px;
    font-size: 12px;
    min-width: 100px;
  }
  
  .announcements-container {
    margin: 8px;
  }
  
  .section-header {
    margin-bottom: 12px;
  }
  
  .section-header h2 {
    font-size: 16px;
  }
  
  .announcement-card {
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
  }
  
  .announcement-header {
    padding: 12px 12px 10px;
  }
  
  .announcement-title-area {
    gap: 8px;
  }
  
  .announcement-icon {
    width: 28px;
    height: 28px;
  }
  
  .announcement-icon i {
    font-size: 14px;
  }
  
  .announcement-title {
    font-size: 15px;
  }
  
  .announcement-content {
    padding: 12px;
  }
  
  .meta-item {
    font-size: 11px;
  }
  
  .meta-item i {
    font-size: 14px;
  }
  
  .announcement-description {
    font-size: 13px;
    line-height: 1.5;
    margin-bottom: 12px;
  }
  
  .announcement-image-container {
    height: 140px;
  }
  
  .announcement-footer {
    padding: 10px 12px;
  }
  
  .announcement-author {
    font-size: 12px;
  }
  
  .announcement-author i {
    font-size: 14px;
  }
  
  .read-more-button {
    font-size: 12px;
    padding: 5px 8px;
  }
  
  .read-more-button i {
    font-size: 16px;
  }
  
  .pagination-container {
    gap: 10px;
  }
  
  .pagination-button {
    width: 32px;
    height: 32px;
  }
  
  .pagination-button i {
    font-size: 16px;
  }
  
  .pagination-info {
    font-size: 12px;
  }
  
  .modal-content {
    width: 95%;
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
  
  .modal-body {
    padding: 12px;
  }
  
  .modal-footer {
    padding: 12px;
  }
  
  .success-modal {
    padding: 20px;
  }
  
  .success-icon i {
    font-size: 50px;
  }
  
  .success-modal h3 {
    font-size: 20px;
  }
  
  .success-modal p {
    font-size: 14px;
  }
  
  .detail-title-section h2 {
    font-size: 20px;
  }
  
  .detail-section-header h4 {
    font-size: 16px;
  }
  
  .detail-meta {
    gap: 8px;
    margin-bottom: 15px;
  }
  
  .detail-meta-item {
    font-size: 12px;
  }
  
  .detail-meta-item i {
    font-size: 14px;
  }
  
  .detail-description {
    font-size: 13px;
    line-height: 1.6;
    margin-bottom: 15px;
  }
  
  .detail-image {
    max-height: 300px;
  }
}

/* Landscape Mobile */
@media (max-height: 500px) and (orientation: landscape) {
  .modal-content {
    max-height: 95vh;
  }
  
  .modal-body {
    max-height: calc(95vh - 60px);
  }
  
  .detail-image {
    max-height: 200px;
  }
  
  .announcement-image-container {
    height: 120px;
  }
}

.nav-link {
  margin-top: -30px;
}

/* Add styles for the delete button and status */
.delete-btn {
  background-color: #ff4d4f;
  color: white;
  border: none;
  padding: 8px 16px;
  border-radius: 4px;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 5px;
}

.delete-btn:hover {
  background-color: #ff7875;
}

.status-deleted {
  background-color: #ff4d4f;
  color: white;
}

.status-badge.deleted {
  background-color: #ff4d4f;
  color: white;
}

.deleted-card {
  opacity: 0.8;
}
</style>