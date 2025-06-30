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
    <a href="/logout">
      <li>
        <div class="profile-details">
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
    </a>
  </ul>
</div>
<section class="home-section">
  <div class="home-content">
    <div class="header">
      <i class="bx bx-menu"></i>
      <div class="text">
          <h3>Patient Billings</h3>
          <div class="breadcrumbs">
            <a class="none" href=""><p>Home / </p></a>
            <a class="current" href="/hrpatientbillings"><p>  Patient Billings</p></a>
          </div>
      </div>
    </div>
    <hr color="#06693a">
    <div class="search-wrapper">
      <div class="search-container">
        <input 
          v-model="searchQuery" 
          placeholder="Search by patient or procedure" 
          @keyup.enter="filterBillings" 
          class="search-input"
          :class="{ 'has-reset': searchQuery && isSearchActive }"
        />
        <i class="bx bx-search search-icon" @click="filterBillings"></i>
        <button 
          v-if="isSearchActive" 
          @click="resetSearch" 
          class="reset-button"
          title="Reset search"
        >
          <i class='bx bx-x'></i>
        </button>
      </div>
    </div>

    <!-- Add Payment Modal -->
    <Teleport to="body">
      <transition name="modal-fade">
        <div v-if="showAddPaymentModal" class="modal-overlay" @click.self="closeAddPaymentModal">
          <div class="modal-content">
            <div class="modal-header">
              <h3>Add Payment</h3>
              <button class="close-btn" @click="closeAddPaymentModal">
                <i class='bx bx-x'></i>
              </button>
            </div>
            
            <div class="modal-body">
              <!-- Patient Information Section -->
              <div class="section-header">
                <i class='bx bx-user-circle'></i>
                <h4>Patient Information</h4>
              </div>
              <div class="form-section">
                <div class="form-row">
                  <div class="form-group">
                    <label>Patient</label>
                    <select v-model="newPayment.PatientID" @change="updatePatientBalance" :disabled="isLoadingPatients">
                        <option value="" disabled>Select a patient</option>
                        <option v-if="isLoadingPatients" disabled>Loading patients...</option>
                        <option v-else-if="patientsWithBalances.length === 0" disabled>No patients with balances found</option>
                        <option v-for="patient in patientsWithBalances" :key="patient.PatientID" :value="patient.PatientID">
                            {{ patient.FullName }} (Balance: ₱{{ formatNumber(patient.Balance) }})
                        </option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Current Balance</label>
                    <div class="input-with-icon">
                      <span class="currency-symbol">₱</span>
                      <input v-model.number="newPayment.CurrentBalance" readonly class="readonly-field" />
                    </div>
                  </div>
                </div>
              </div>

              <!-- Payment Details Section -->
              <div class="section-header">
                <i class='bx bx-credit-card'></i>
                <h4>Payment Details</h4>
              </div>
              <div class="form-section">
                <div class="form-row">
                  <div class="form-group">
                    <label>Payment Method</label>
                    <select 
                      v-model="newPayment.PaymentMethod" 
                      @change="updateNewPaymentReferenceAndChangeVisibility"
                    >
                      <option value="" disabled>Select a payment method</option>
                      <option v-for="method in paymentMethods" :key="method.MethodName" :value="method.MethodName">
                        {{ method.MethodName }}
                      </option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Amount Paid</label>
                    <div class="input-with-icon">
                      <span class="currency-symbol">₱</span>
                      <input 
                        v-model.number="newPayment.AmountPaid" 
                        type="number" 
                        min="0" 
                        step="0.01" 
                        @input="handleNewPaymentAmountInput"
                      />
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group" v-if="showNewPaymentReferenceInput">
                    <label>Reference ID</label>
                    <input 
                      v-model="newPayment.ReferenceID" 
                      type="text" 
                      :placeholder="newPaymentReferenceIdPlaceholder" 
                      @input="validateNewPaymentReferenceID" 
                      :maxlength="newPaymentReferenceIdMaxLength"
                    />
                  </div>
                  <div class="form-group" v-else></div>
                  <div class="form-group" v-if="showNewPaymentChangeInput && newPayment.PaymentMethod === 'Cash'">
                    <label>Change</label>
                    <div class="input-with-icon">
                      <span class="currency-symbol">₱</span>
                      <input 
                        v-model.number="newPayment.Change" 
                        type="number" 
                        step="0.01" 
                        readonly 
                        class="readonly-field" 
                      />
                    </div>
                  </div>
                  <div class="form-group" v-else></div>
                </div>
              </div>
            </div>
            
            <div class="modal-footer">
              <button class="cancel-btn" @click="closeAddPaymentModal">
                <i class='bx bx-x'></i> Cancel
              </button>
              <button 
                class="update-btn" 
                @click="addPayment" 
                :disabled="!isNewPaymentFormValid || isSubmittingPayment"
                :class="{ 'disabled-button': !isNewPaymentFormValid || isSubmittingPayment }"
              >
                <i v-if="isSubmittingPayment" class='bx bx-loader-alt bx-spin'></i>
                <i v-else class='bx bx-check'></i> Add Payment
              </button>
            </div>
          </div>
        </div>
      </transition>
    </Teleport>

    <!-- Payment Successful Modal -->
    <Teleport to="body">
      <transition name="modal-fade">
        <div v-if="showSuccessModal" class="modal-overlay" @click.self="closeSuccessModal">
          <div class="modal-content success-modal">
            <div class="modal-header">
              <h3>Payment Successful</h3>
              <button class="close-btn" @click="closeSuccessModal">
                <i class='bx bx-x'></i>
              </button>
            </div>
            <div class="modal-body">
              <div class="success-message">
                <i class='bx bx-check-circle success-icon'></i>
                <p>The payment has been successfully recorded.</p>
              </div>
            </div>
            <div class="modal-footer">
              <button class="update-btn" @click="closeSuccessModal">
                <i class='bx bx-check'></i> OK
              </button>
            </div>
          </div>
        </div>
      </transition>
    </Teleport>

    <!-- Insurance Approval Modal -->
    <Teleport to="body">
      <transition name="modal-fade">
        <div v-if="showApprovalModal" class="modal-overlay" @click.self="closeApprovalModal">
          <div class="modal-content">
            <div class="modal-header">
              <h3>Enter Insurance Approval Details</h3>
              <button class="close-btn" @click="closeApprovalModal">
                <i class='bx bx-x'></i>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-section">
                <div class="form-row">
                  <div class="form-group full-width">
                    <label>Approval Code</label>
                    <input
                      v-model="approvalDetails.ApprovalCode"
                      type="text"
                      :placeholder="approvalCodePlaceholder"
                      @input="validateApprovalCode"
                      :maxlength="approvalCodeMaxLength"
                    />
                    <span v-if="approvalCodeError" class="error-text">{{ approvalCodeError }}</span>
                  </div>
                </div>
                <div class="form-row" v-if="requiresLOE">
                  <div class="form-group full-width">
                    <label>LOE #</label>
                    <input
                      v-model="approvalDetails.LOE"
                      type="text"
                      placeholder="Enter LOE # (e.g., 987654321)"
                      @input="validateLOE"
                      maxlength="9"
                    />
                    <span v-if="loeError" class="error-text">{{ loeError }}</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button class="cancel-btn" @click="closeApprovalModal">
                <i class='bx bx-x'></i> Cancel
              </button>
              <button
                class="update-btn"
                @click="submitApproval"
                :disabled="!isApprovalFormValid"
                :class="{ 'disabled-button': !isApprovalFormValid }"
              >
                <i class='bx bx-check'></i> Submit
              </button>
            </div>
          </div>
        </div>
      </transition>
    </Teleport>
    
    <!-- Warning Modal for Negative Price -->
    <Teleport to="body">
      <transition name="modal-fade">
        <div v-if="showNegativePriceModal" class="modal-overlay negative-price-modal-overlay" @click.self="showNegativePriceModal = false">
          <div class="modal-content success-modal">
            <div class="modal-header">
              <h3>Invalid Price</h3>
              <button class="close-btn" @click="showNegativePriceModal = false">
                <i class='bx bx-x'></i>
              </button>
            </div>
            <div class="modal-body">
              <div class="success-message">
                <i class='bx bx-error-circle success-icon' style="color: #e74c3c;"></i>
                <p>Price cannot be negative. Please enter a positive number.</p>
              </div>
            </div>
            <div class="modal-footer">
              <button class="update-btn" @click="showNegativePriceModal = false">
                <i class='bx bx-check'></i> OK
              </button>
            </div>
          </div>
        </div>
      </transition>
    </Teleport>

    <!-- Reference ID Error Modal -->
    <Teleport to="body">
      <transition name="modal-fade">
        <div v-if="showReferenceIdErrorModal" class="modal-overlay reference-id-error-modal-overlay" @click.self="closeReferenceIdErrorModal">
          <div class="modal-content success-modal">
            <div class="modal-header">
              <h3>Invalid Reference ID</h3>
              <button class="close-btn" @click="closeReferenceIdErrorModal">
                <i class='bx bx-x'></i>
              </button>
            </div>
            <div class="modal-body">
              <div class="success-message">
                <i class='bx bx-error-circle success-icon' style="color: #e74c3c;"></i>
                <p>{{ referenceIdErrorMessage }}</p>
              </div>
            </div>
            <div class="modal-footer">
              <button class="update-btn" @click="closeReferenceIdErrorModal">
                <i class='bx bx-check'></i> OK
              </button>
            </div>
          </div>
        </div>
      </transition>
    </Teleport>

    <!-- Generic Error Modal -->
    <Teleport to="body">
      <transition name="modal-fade">
        <div v-if="showGenericErrorModal" class="modal-overlay generic-error-modal-overlay" @click.self="closeGenericErrorModal">
          <div class="modal-content success-modal">
            <div class="modal-header">
              <h3>Error</h3>
              <button class="close-btn" @click="closeGenericErrorModal">
                <i class='bx bx-x'></i>
              </button>
            </div>
            <div class="modal-body">
              <div class="success-message">
                <i class='bx bx-error-circle success-icon' style="color: #e74c3c;"></i>
                <p>{{ genericErrorMessage }}</p>
              </div>
            </div>
            <div class="modal-footer">
              <button class="update-btn" @click="closeGenericErrorModal">
                <i class='bx bx-check'></i> OK
              </button>
            </div>
          </div>
        </div>
      </transition>
    </Teleport>

    <!-- Toggle buttons for Unpaid/Paid -->
    <div class="toggle-buttons">
      <button 
        class="toggle-btn" 
        :class="{ 'active': activeTab === 'unpaid' }" 
        @click="activeTab = 'unpaid'"
      >
        <i class='bx bx-time'></i> Unpaid
      </button>
      <button 
        class="toggle-btn" 
        :class="{ 'active': activeTab === 'paid' }" 
        @click="activeTab = 'paid'"
      >
        <i class='bx bx-check-circle'></i> Paid
      </button>
      <button 
        class="toggle-btn" 
        :class="{ 'active': activeTab === 'insurance' }" 
        @click="activeTab = 'insurance'"
      >
        <i class='bx bx-wallet'></i> Insurance
      </button>
    </div>
    
    <!-- Unpaid Section -->
    <div class="billing-container" v-show="activeTab === 'unpaid'">
      <div class="billing">
        <h3>UNPAID BILLS</h3>
        <button class="add-payment-btn" @click="openAddPaymentModal">
          <i class='bx bx-plus'></i> Add Payment
        </button>
      </div>
      <div class="table-wrapper">
        <!-- Desktop Table -->
        <table class="billing-table desktop-table unpaid-table">
          <thead>
            <tr>
              <th style="padding-left: 25px;">Patient Name</th>
              <th>Appointment Date/Time</th>
              <th>Procedure</th>
              <th>Amount</th>
              <th class="actions-header">Actions</th>
            </tr>
          </thead>
          <tbody class="container-billing">
            <tr 
              v-for="billing in recentBillings" 
              :key="billing.BillingID"
              @click="openEditModal(billing)"
              class="billing-row"
            >
              <td style="padding-left: 25px;">{{ billing.PatientName }}</td>
              <td>{{ formatDateTime(billing.AppointmentDateTime) }}</td>
              <td>{{ billing.Procedure }}</td>
              <td>{{ formatNumber(billing.Balance) }}</td>
              <td class="actions-cell" @click.stop>
                <button 
                  class="edit-button" 
                  @click="openEditModal(billing)"
                >
                  <i class='bx bx-edit-alt'></i> Edit
                </button>
              </td>
            </tr>
            <tr v-if="recentBillings.length === 0">
              <td colspan="5" class="no-data">No Unpaid Bills...</td>
            </tr>
          </tbody>
        </table>
        <!-- Mobile Cards (unchanged) -->
        <div class="mobile-cards">
          <div 
            v-for="billing in recentBillings" 
            :key="billing.BillingID"
            class="billing-card"
            @click="openEditModal(billing)"
          >
            <div class="card-header">
              <h4>{{ billing.Procedure }}</h4>
              <div class="card-actions" @click.stop>
                <button 
                  class="edit-button-mobile" 
                  @click="openEditModal(billing)"
                >
                  <i class='bx bx-edit-alt'></i> Edit
                </button>
              </div>
            </div>
            <div class="card-content">
              <div class="card-row">
                <span class="card-label">Patient Name:</span>
                <span>{{ billing.PatientName }}</span>
              </div>
              <div class="card-row">
                <span class="card-label">Appointment Date/Time:</span>
                <span>{{ formatDateTime(billing.AppointmentDateTime) }}</span>
              </div>
              <div class="card-row">
                <span class="card-label">Amount:</span>
                <span>{{ formatNumber(billing.Balance) }}</span>
              </div>
            </div>
          </div>
          <div v-if="recentBillings.length === 0" class="no-data-mobile">
            No Unpaid Bills
          </div>
        </div>
      </div>
    </div>

    <!-- Redesigned Edit Billing Modal -->
    <Teleport to="body">
    <div v-if="showModal" class="modal-overlay" @click.self="closeModal">
      <div class="modal-content">
        <div class="modal-header">
          <h3>{{ isViewOnly ? 'View Billing Information' : 'Billing Information' }}</h3>
          <button class="close-btn" @click="closeModal">
            <i class='bx bx-x'></i>
          </button>
        </div>
        
        <div class="modal-body">
          <!-- Appointment Information Section -->
          <div class="section-header">
            <i class='bx bx-calendar'></i>
            <h4>Appointment Information</h4>
          </div>
          <div class="form-section">
            <div class="form-row">
              <div class="form-group">
                <label>Patient's Name</label>
                <input v-model="selectedBilling.PatientName" readonly class="readonly-field" />
              </div>
              <div class="form-group">
                <label>Patient ID</label>
                <input v-model="selectedBilling.PatientID" readonly class="readonly-field" />
              </div>
            </div>
            <div class="form-row">
              <div class="form-group">
                <label>Appointment Date</label>
                <input :value="formatDateTime(selectedBilling.AppointmentDateTime)" readonly class="readonly-field" />
              </div>
              <div class="form-group">
                <label>Assigned Dentist</label>
                <input v-model="selectedBilling.AssignedDentist" readonly class="readonly-field" />
              </div>
            </div>
            <div class="form-row">
              <div class="form-group">
                <label>Procedure</label>
                <input v-model="selectedBilling.Procedure" readonly class="readonly-field" />
              </div>
              <div class="form-group">
              </div>
            </div>
          </div>

          <!-- Services Section (Hidden for Insurance Billings or in View-Only Mode) -->
          <div v-if="!isViewOnly && !isInsuranceBilling">
            <div class="section-header">
              <i class='bx bx-clipboard'></i>
              <h4>Services</h4>
            </div>
            <div class="form-section">
              <div v-if="selectedBilling.services && selectedBilling.services.length > 0">
                <div v-for="(service, index) in selectedBilling.services" :key="index" class="service-detail">
                  <div class="service-header">
                    <div class="service-name">{{ service.ServiceName }}</div>
                  </div>
                  <div class="service-controls">
                    <div class="form-group">
  <label>Price</label>
  <div class="input-with-icon">
    <span class="currency-symbol">₱</span>
    <input
      v-model.number="selectedBilling.TotalAmount"
      type="number"
      min="0"
      step="0.01"
      @input="setServicePrice(service, $event.target.value)"
      :disabled="isViewOnly || service.PaymentStatus === 'Paid'"
    />
  </div>
  <div v-if="isInsuranceMethod(service) && !hasCostChanged(service)" class="cost-change-warning">
    <span class="warning-text">Price must be changed for insurance payment.</span>
  </div>
                      <!-- <div class="form-group">
                        <label>Discount</label>
                        <div class="input-with-icon">
                          <span class="currency-symbol">₱</span>
                          <input
                            v-model.number="service.Discount"
                            type="number"
                            step="0.01"
                            min="0"
                            placeholder="Enter discount"
                            :disabled="isViewOnly || service.PaymentStatus === 'Paid'"
                            @input="updateTotalAmount"
                          />
                        </div>
                      </div> -->
                      <br>
                    </div>
                    <div class="form-row">
                      <div class="form-group">
                        <label>Payment Method</label>
                        <select 
                          v-model="service.PaymentMethod" 
                          @change="updateServicePaymentMethod(service)"
                          :disabled="isViewOnly"
                        >
                          <option value="">Select payment method</option>
                          <option 
                            v-for="method in getAvailablePaymentMethods(service, index)" 
                            :key="method.MethodName" 
                            :value="method.MethodName"
                          >
                            {{ method.MethodName }}
                          </option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Amount Paid</label>
                        <div class="input-with-icon">
                          <span class="currency-symbol">₱</span>
                          <input 
                            v-model.number="service.AmountPaid" 
                            type="number" 
                            min="0" 
                            step="0.01" 
                            @input="handleServiceAmountPaidInput(service)"
                            :readonly="isViewOnly || isInsuranceMethod(service)"
                            :class="{ 'readonly-field': isInsuranceMethod(service) }"
                          />
                        </div>
                      </div>
                    </div>
                    <!-- Show individual Reference ID field only if payment methods differ -->
                    <div class="form-row" v-if="shouldShowIndividualReferenceInput(service, index)">
                      <div class="form-group">
                        <label>Reference ID</label>
                        <input 
                          v-model="service.ReferenceID" 
                          type="text" 
                          :placeholder="getServiceReferenceIdPlaceholder(service.PaymentMethod)"
                          @input="validateServiceReferenceID(service)"
                          :maxlength="getServiceReferenceIdMaxLength(service.PaymentMethod)"
                          :readonly="isViewOnly"
                          :disabled="isReferenceIdDisabled(service, index)"
                        />
                      </div>
                      <div class="form-group" v-if="service.PaymentMethod === 'Cash' && (Number(service.AmountPaid) || 0) > (Number(service.Cost) - (Number(service.Discount) || 0))">
                        <label>Change</label>
                        <div class="input-with-icon">
                          <span class="currency-symbol">₱</span>
                          <input 
                            v-model.number="service.Change" 
                            type="number" 
                            step="0.01" 
                            readonly 
                            class="readonly-field" 
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Shared Reference ID field when payment methods are the same -->
                <div class="form-row" v-if="shouldShowSharedReferenceInput">
                  <div class="form-group full-width">
                    <label>Reference ID</label>
                    <input 
                      v-model="sharedReferenceID" 
                      type="text" 
                      :placeholder="getServiceReferenceIdPlaceholder(selectedBilling.services[0].PaymentMethod)"
                      @input="updateSharedReferenceID"
                      :maxlength="getServiceReferenceIdMaxLength(selectedBilling.services[0].PaymentMethod)"
                      :readonly="isViewOnly"
                    />
                  </div>
                </div>

                <!-- Add Remarks and Status Section -->
                <div class="form-row">
                  <div class="form-group full-width">
                    <label>Remarks (Optional)</label>
                    <textarea
                      v-model="selectedBilling.Remarks"
                      placeholder="e.g., Price Approved by Dr."
                      rows="3"
                    ></textarea>
                  </div>
                  <div class="form-group">
                    <label>Status</label>
                    <div class="status-display">
                      <span class="status-badge unpaid">Unpaid</span>
                      <span class="status-message">This billing has not been paid</span>
                    </div>
                  </div>
                </div>
              </div>
              <div v-else class="no-services">No services available</div>
            </div>
          </div>

          <!-- Payment Summary Section (for Paid tab) -->
          <div v-if="isFromPaidTab">
            <div class="section-header">
              <i class='bx bx-credit-card'></i>
              <h4>Payment Summary</h4>
            </div>
            <div class="form-section">
              <div v-if="selectedBilling.services && selectedBilling.services.length > 0">
                <div v-for="(service, index) in selectedBilling.services" :key="index" class="service-payment-detail">
                  <div class="service-header">
                    <div class="service-name">{{ service.ServiceName }}</div>
                  </div>
                  <div class="form-row">
                    <div class="form-group">
                      <label>Price</label>
                      <div class="input-with-icon">
                        <span class="currency-symbol">₱</span>
                        <input 
                          :value="formatNumber(calculatedTotalAmount)"  
                          readonly 
                          class="readonly-field" 
                        />
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Amount Paid</label>
                      <div class="input-with-icon">
                        <span class="currency-symbol">₱</span>
                        <input 
                          :value="formatNumber(service.AmountPaid)" 
                          readonly 
                          class="readonly-field" 
                        />
                      </div>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group">
                      <label>Payment Method</label>
                      <input 
                        :value="service.PaymentMethod || 'N/A'" 
                        readonly 
                        class="readonly-field" 
                      />
                    </div>
                    <div class="form-group" v-if="shouldShowServiceReferenceInput(service)">
                      <label>Reference ID</label>
                      <input 
                        :value="service.ReferenceID || 'N/A'" 
                        readonly 
                        class="readonly-field" 
                      />
                    </div>
                    <div class="form-group" v-else></div>
                  </div>
                  <div class="form-row" v-if="service.Change > 0">
                    <div class="form-group">
                      <label>Change</label>
                      <div class="input-with-icon">
                        <span class="currency-symbol">₱</span>
                        <input 
                          :value="formatNumber(service.Change)" 
                          readonly 
                          class="readonly-field" 
                        />
                      </div>
                    </div>
                    <div class="form-group"></div>
                  </div>
                </div>
                <div class="payment-summary-total">
                  <!-- <div class="form-row">
                    <div class="form-group">
                      <label>Total Amount</label>
                      <div class="input-with-icon">
                        <span class="currency-symbol">₱</span>
                        <input 
                          :value="formatNumber(selectedBilling.TotalAmount)" 
                          readonly 
                          class="readonly-field" 
                        />
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Total Amount Paid</label>
                      <div class="input-with-icon">
                        <span class="currency-symbol">₱</span>
                        <input 
                          :value="formatNumber(selectedBilling.AmountPaid)" 
                          readonly 
                          class="readonly-field" 
                        />
                      </div>
                    </div>
                  </div> -->
                </div>
              </div>
              <div v-else class="no-services">No payment details available</div>

              <!-- Status and Remarks -->
              <div class="form-row">
                <div class="form-group full-width">
                  <label>Remarks (Optional)</label>
                  <textarea
                    v-model="selectedBilling.Remarks"
                    placeholder="e.g., Price Approved by Dr."
                    rows="3"
                    readonly
                    class="readonly-field"
                  ></textarea>
                </div>
                <div class="form-group">
                  <label>Status</label>
                  <div class="status-display">
                    <span class="status-badge paid">Paid</span>
                    <span class="status-message">This billing has been paid</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Payment Summary Section (for Insurance Billings) -->
          <div v-if="isInsuranceBilling">
            <div class="section-header">
              <i class='bx bx-credit-card'></i>
              <h4>Payment Summary</h4>
            </div>
            <div class="form-section">
              <div class="form-row">
                <!-- Payment Method -->
                <div class="form-group">
                  <label>Payment Method</label>
                  <input
                    :value="selectedBilling.PaymentMethod || 'N/A'"
                    readonly
                    class="readonly-field"
                  />
                </div>
                <!-- Price (Total Amount) -->
                <div class="form-group">
                  <label>Price</label>
                  <div class="input-with-icon">
                    <span class="currency-symbol">₱</span>
                    <input
                      :value="formatNumber(selectedBilling.TotalAmount)"
                      readonly
                      class="readonly-field"
                    />
                  </div>
                </div>
              </div>
              <div class="form-row">
                <!-- Approval Code -->
                <div class="form-group">
                  <label>Approval Code</label>
                  <div class="input-with-icon">
                    <input
                      v-model="selectedBilling.ApprovalCode"
                      type="text"
                      :placeholder="selectedApprovalCodePlaceholder"
                      :readonly="isViewOnly"
                      @input="validateSelectedApprovalCode"
                      :class="{ 'readonly-field': isViewOnly }"
                      :maxlength="selectedApprovalCodeMaxLength"
                    />
                  </div>
                  <span v-if="selectedApprovalCodeError" class="error-text">{{ selectedApprovalCodeError }}</span>
                </div>
                <!-- LOE # (for Maxicare only) -->
                <div class="form-group" v-if="selectedBilling.PaymentMethod === 'Maxicare'">
                  <label>LOE #</label>
                  <div class="input-with-icon">
                    <input
                      v-model="selectedBilling.LOE"
                      type="text"
                      placeholder="Enter LOE # (e.g., 987654321)"
                      :readonly="isViewOnly"
                      @input="validateSelectedLOE"
                      :class="{ 'readonly-field': isViewOnly }"
                      maxlength="9"
                    />
                  </div>
                  <span v-if="selectedLOEError" class="error-text">{{ selectedLOEError }}</span>
                </div>
                <div class="form-group" v-else></div>
              </div>
            </div>
          </div>
        </div>
        
        <div class="modal-footer">
          <button class="cancel-btn" @click="closeModal">
            <i class='bx bx-x'></i> Cancel
          </button>
          <button 
            v-if="isInsuranceBilling && !isInitiallyPaid && !isViewOnly && selectedBilling.BillingStatus !== 'Paid'" 
            class="decline-btn" 
            @click="declineInsurance"
            :disabled="selectedBilling.BillingStatus === 'Paid'"
            :class="{ 'disabled-button': selectedBilling.BillingStatus === 'Paid' }"
          >
            <i class='bx bx-x-circle'></i> Decline Insurance
          </button>
          <button 
            v-if="!isViewOnly"
            class="update-btn" 
            @click="updateBilling" 
            :disabled="isInitiallyPaid || !isSelectedInsuranceFormValid || shouldDisableUpdateForUnpaidInsurance"
            :class="{ 'disabled-button': isInitiallyPaid || !isSelectedInsuranceFormValid || shouldDisableUpdateForUnpaidInsurance }"
          >
            <i class='bx bx-check'></i> Update
          </button>
      </div>
    </div>
  </div>
</Teleport>

    <!-- Paid Section -->
<div class="billing-container" v-show="activeTab === 'paid'">
  <div class="billing">
    <h3>PAID BILLS</h3>
  </div>
  <div class="table-wrapper">
    <!-- Desktop Table -->
    <table class="billing-table desktop-table paid-table">
      <thead>
        <tr>
          <th style="padding-left: 25px;">Patient Name</th>
          <th>Appointment Date/Time</th>
          <th>Procedure</th>
          <th>Amount Paid</th>
          <th>Remaining Balance</th>
          <th class="actions-header">Actions</th>
        </tr>
      </thead>
      <tbody class="container-billing">
        <tr 
          v-for="billing in previousBillings" 
          :key="billing.BillingID"
          @click="openViewModal(billing)"
          class="billing-row"
        >
          <td style="padding-left: 25px;">{{ billing.PatientName }}</td>
          <td>
            {{ billing.IsStandalonePayment && !billing.AppointmentDateTime ? 'Payment without Appointment' : (billing.AppointmentDateTime ? formatDateTime(billing.AppointmentDateTime) : 'N/A') }}
          </td>
          <td>{{ billing.Procedure }}</td>
          <td>{{ formatNumber(billing.AmountPaid) }}</td>
          <td>{{ formatNumber(billing.Balance) }}</td>
          <td class="actions-cell" @click.stop>
            <button 
              class="view-button" 
              @click="openViewModal(billing)"
            >
              <i class='bx bx-show'></i> View
            </button>
          </td>
        </tr>
        <tr v-if="previousBillings.length === 0">
          <td colspan="6" class="no-data">No Paid Bills...</td>
        </tr>
      </tbody>
    </table>
    <!-- Mobile Cards -->
    <div class="mobile-cards">
      <div 
        v-for="billing in previousBillings" 
        :key="billing.BillingID"
        class="billing-card"
        @click="openViewModal(billing)"
      >
        <div class="card-header">
          <h4>{{ billing.Procedure }}</h4>
          <div class="card-actions" @click.stop>
            <button 
              class="view-button-mobile" 
              @click="openViewModal(billing)"
            >
              <i class='bx bx-show'></i> View
            </button>
          </div>
        </div>
        <div class="card-content">
          <div class="card-row">
            <span class="card-label">Patient Name:</span>
            <span>{{ billing.PatientName }}</span>
          </div>
          <div class="card-row">
            <span class="card-label">Appointment Date/Time:</span>
            <span>
              {{ billing.IsStandalonePayment && !billing.AppointmentDateTime ? 'Payment without Appointment' : (billing.AppointmentDateTime ? formatDateTime(billing.AppointmentDateTime) : 'N/A') }}
            </span>
          </div>
          <div class="card-row">
            <span class="card-label">Price:</span>
            <span>{{ formatNumber(billing.TotalAmount) }}</span>
          </div>
          <div class="card-row">
            <span class="card-label">Remaining Balance:</span>
            <span>{{ formatNumber(billing.Balance) }}</span>
          </div>
        </div>
      </div>
      <div v-if="previousBillings.length === 0" class="no-data-mobile">
        No Paid Bills
      </div>
    </div>
  </div>
</div>

    <!-- Insurance Payout Section -->
<div class="billing-container" v-show="activeTab === 'insurance'">
  <div class="billing">
    <h3>INSURANCE BILLS</h3>
  </div>
  <div class="table-wrapper">
    <!-- Desktop Table -->
    <table class="billing-table desktop-table insurance-table">
      <thead>
        <tr>
          <th style="padding-left: 25px;">Patient Name</th>
          <th>Appointment Date/Time</th>
          <th>Procedure</th>
          <th>Amount</th>
          <th>Insurance</th>
          <th>Status</th>
          <th class="actions-header">Actions</th>
        </tr>
      </thead>
      <tbody class="container-billing">
        <tr 
          v-for="billing in insuranceBillings" 
          :key="billing.BillingID"
          @click="openEditModal(billing)"
          class="billing-row"
          :class="{ 'paid-row': billing.BillingStatus === 'Paid' }"
        >
          <td style="padding-left: 25px;">{{ billing.PatientName }}</td>
          <td>{{ formatDateTime(billing.AppointmentDateTime) }}</td>
          <td>{{ billing.Procedure }}</td>
          <td>{{ formatNumber(billing.TotalAmount) }}</td>
          <td>{{ billing.PaymentMethod }}</td>
          <td>
            <span class="status-badge" :class="getStatusClass(billing.BillingStatus)">
              {{ billing.BillingStatus }}
            </span>
          </td>
          <td class="actions-cell" @click.stop>
            <button 
              class="edit-button" 
              @click="openEditModal(billing)"
              :disabled="billing.BillingStatus === 'Paid'"
              :class="{ 'disabled-button': billing.BillingStatus === 'Paid' }"
            >
              <i class='bx bx-edit-alt'></i> Edit
            </button>
          </td>
        </tr>
        <tr v-if="insuranceBillings.length === 0">
          <td colspan="7" class="no-data">No Insurance Payouts...</td>
        </tr>
      </tbody>
    </table>
    <!-- Mobile Cards -->
    <div class="mobile-cards">
      <div 
        v-for="billing in insuranceBillings" 
        :key="billing.BillingID"
        class="billing-card"
        :class="{ 'paid-card': billing.BillingStatus === 'Paid' }"
        @click="openEditModal(billing)"
      >
        <div class="card-header">
          <h4>{{ billing.Procedure }}</h4>
          <div class="card-actions" @click.stop>
            <button 
              class="edit-button-mobile" 
              @click="openEditModal(billing)"
              :disabled="billing.BillingStatus === 'Paid'"
              :class="{ 'disabled-button': billing.BillingStatus === 'Paid' }"
            >
              <i class='bx bx-edit-alt'></i> Edit
            </button>
          </div>
        </div>
        <div class="card-content">
          <div class="card-row">
            <span class="card-label">Patient Name:</span>
            <span>{{ billing.PatientName }}</span>
          </div>
          <div class="card-row">
            <span class="card-label">Appointment Date/Time:</span>
            <span>{{ formatDateTime(billing.AppointmentDateTime) }}</span>
          </div>
          <div class="card-row">
            <span class="card-label">Amount:</span>
            <span>{{ formatNumber(billing.TotalAmount) }}</span>
          </div>
          <div class="card-row">
            <span class="card-label">Insurance:</span>
            <span>{{ billing.PaymentMethod }}</span>
          </div>
          <div class="card-row">
            <span class="card-label">Status:</span>
            <span class="status-badge" :class="getStatusClass(billing.BillingStatus)">
              {{ billing.BillingStatus }}
            </span>
          </div>
        </div>
      </div>
      <div v-if="insuranceBillings.length === 0" class="no-data-mobile">
        No Insurance Payouts
      </div>
    </div>
    <!-- Total Insurance Payout -->
    <div style="padding-left: 25px; padding-right: 25px;" class="total-insurance-payout">
      <span class="total-label">Total Insurance Amount Paid:</span>
      <span class="total-amount">₱{{ totalInsurancePayout }}</span>
    </div>
  </div>
</div>
    <br>
  </div>
</section>
</template>

<script>
import axios from 'axios';

export default {
  name: "HRPatientBillings",
  props: {
    firstName: { type: String, required: true },
    lastName: { type: String, required: true },
  },
  data() {
    return {
      isSearchActive: false,
      searchQuery: '',
      allBillings: [],
      paymentMethods: [],
      insuranceProviders: [],
      showModal: false,
      showReferenceInput: false,
      showChangeInput: false,
      activeTab: 'unpaid',
      originalStatus: '',
      isInitiallyPaid: false,
      isViewOnly: false,
      isFromPaidTab: false,
      isReferenceEditable: true,
      selectedBilling: {
        BillingID: null,
        AppointmentID: null,
        PatientName: '',
        PatientID: '',
        AppointmentDateTime: '',
        AssignedDentist: '',
        Procedure: '',
        TotalAmount: 0,
        TotalPaid: 0,
        PaymentMethod: null,
        AmountPaid: 0,
        Balance: 0,
        BillingStatus: 'Unpaid',
        Discount: 0,
        ReferenceID: '',
        Change: 0,
        Remarks: '',
        services: [],
        originalServices: [],
      },
      sharedReferenceID: '',
      showAddPaymentModal: false,
      showSuccessModal: false,
      patientsWithBalances: [],
      showNewPaymentReferenceInput: false,
      showNewPaymentChangeInput: false,
      newPayment: {
        PatientID: '',
        CurrentBalance: 0,
        AmountPaid: 0,
        PaymentMethod: '',
        ReferenceID: '',
        Change: 0,
      },
      isLoadingPatients: false,
      showApprovalModal: false,
      approvalDetails: {
        ApprovalCode: '',
        LOE: '',
      },
      approvalCodeError: '',
      loeError: '',
      pendingApprovalAction: null,
      pendingBillingIds: [],
      selectedApprovalCodeError: '',
      selectedLOEError: '',
      isSubmittingPayment: false,
      showNegativePriceModal: false,
      showReferenceIdErrorModal: false,
      referenceIdErrorMessage: '',
      showGenericErrorModal: false,
      genericErrorMessage: '',
    };
  },
  computed: {
    calculatedTotalAmount() {
      // Calculate total amount as RemainingBalance + AmountPaid
      return (this.selectedBilling.Balance || 0) + (this.selectedBilling.AmountPaid || 0);
    },
    fullName() {
      return `${this.firstName} ${this.lastName}`;
    },
    shouldDisableUpdateForUnpaidInsurance() {
      // Only apply this logic in the Unpaid tab
      if (this.activeTab !== 'unpaid') return false;

      // Check if any service has an insurance payment method
      const hasInsuranceService = this.selectedBilling.services.some(service => this.isInsuranceMethod(service));

      // If there’s no insurance service, don’t disable the button
      if (!hasInsuranceService) return false;

      // If there are insurance services, disable the button unless ALL insurance services have their prices changed
      const allInsuranceServicesCostChanged = this.selectedBilling.services
        .filter(service => this.isInsuranceMethod(service))
        .every(service => this.hasCostChanged(service));

      return !allInsuranceServicesCostChanged;
    },
    recentBillings() {
  return this.filteredBillings
    .filter(billing => {
      const billingIdStr = String(billing.BillingID);
      // Only include non-insurance billings
      if (!billingIdStr.endsWith('_nonInsurance')) return false;
      // Exclude standalone payments
      if (billing.IsStandalonePayment) return false;
      // Exclude billings with any insurance services
      const hasInsuranceService = billing.services.some(service => {
        const paymentMethod = service.PaymentMethod?.toLowerCase() || 'n/a';
        return this.insuranceProviders.some(p => p.MethodName.toLowerCase() === paymentMethod);
      });
      if (hasInsuranceService) return false;
      // Only include unpaid billings
      return billing.BillingStatus === 'Unpaid';
    })
    .sort((a, b) => {
      const dateA = a.PaymentDate ? new Date(a.PaymentDate) : new Date(a.AppointmentDateTime || a.CreatedAt || '1970-01-01');
      const dateB = b.PaymentDate ? new Date(b.PaymentDate) : new Date(b.AppointmentDateTime || b.CreatedAt || '1970-01-01');
      return dateB - dateA;
    });
},
previousBillings() {
  const paidBillingsMap = new Map();
  const seenServiceKeys = new Set();

  this.filteredBillings.forEach(billing => {
    const billingIdStr = String(billing.BillingID);
    if (!billingIdStr.endsWith('_nonInsurance')) return;

    const isStandalonePayment = billing.IsStandalonePayment || false;
    const totalPaidForBilling = Number(billing.TotalPaid) || 0;
    if (totalPaidForBilling <= 0) return;

    const baseBillingID = billingIdStr.replace('_nonInsurance', '');
    if (!paidBillingsMap.has(baseBillingID)) {
      paidBillingsMap.set(baseBillingID, {
        ...billing,
        BillingID: baseBillingID,
        services: [],
        TotalPaid: 0,
        TotalAmount: Number(billing.TotalAmount) || 0,
        Discount: Number(billing.Discount) || 0,
        Balance: Number(billing.Balance) || 0,
        TableCategory: 'paid',
      });
    }

    const existingBilling = paidBillingsMap.get(baseBillingID);

    billing.services.forEach((service, index) => {
      const isInsuranceService = this.insuranceProviders.some(
        p => p.MethodName.toLowerCase() === (service.PaymentMethod || 'N/A').toLowerCase()
      );
      if (isInsuranceService) return;

      const serviceKey = `${billing.BillingID}_${service.ServiceAvailedID || service.ServiceName}_${index}`;
      if (seenServiceKeys.has(serviceKey)) return;
      seenServiceKeys.add(serviceKey);

      const serviceCost = Number(service.Cost) || 0;
      const serviceAmountPaid = Number(service.AmountPaid) || 0;
      const serviceDiscount = Number(service.Discount) || 0;
      const serviceBalance = Number(service.Balance) || Math.max(0, serviceCost - serviceAmountPaid - serviceDiscount);

      existingBilling.services.push({
        ...service,
        AmountPaid: serviceAmountPaid,
        PaymentMethod: service.PaymentMethod || 'N/A',
        ReferenceID: service.ReferenceID || null,
        Balance: serviceBalance,
        Change: Number(service.Change) || 0,
      });

      existingBilling.TotalPaid += serviceAmountPaid;
      existingBilling.Discount += serviceDiscount;
      existingBilling.Balance = Number(billing.Balance) || existingBilling.Balance;
    });

    if (existingBilling.services.length === 0) {
      paidBillingsMap.delete(baseBillingID);
    } else {
      existingBilling.Procedure = existingBilling.IsStandalonePayment
        ? 'Payment without Appointment'
        : existingBilling.services.map(service => service.ServiceName).join(', ');
      existingBilling.PaymentDate = billing.PaymentDate || billing.CreatedAt || billing.AppointmentDateTime;
    }
  });

  return Array.from(paidBillingsMap.values()).sort((a, b) => {
    const dateA = a.PaymentDate ? new Date(a.PaymentDate) : new Date(a.AppointmentDateTime || '1970-01-01');
    const dateB = b.PaymentDate ? new Date(b.PaymentDate) : new Date(b.AppointmentDateTime || '1970-01-01');
    return dateB - dateA;
  });
},
insuranceBillings() {
  return this.filteredBillings
    .filter(billing => {
      // Always include billings marked as IsInsuranceBilling
      if (billing.IsInsuranceBilling) return true;

      const billingIdStr = String(billing.BillingID);
      if (billingIdStr.endsWith('_insurance')) return true;

      const hasInsuranceService = billing.services.some(service => {
        const paymentMethod = service.PaymentMethod?.toLowerCase() || 'n/a';
        const isExplicitInsurance = this.insuranceProviders.some(p => 
          p.MethodName.toLowerCase() === paymentMethod
        );
        const isPotentialInsurance = paymentMethod === 'n/a' && 
                                      billing.ApprovalCode && 
                                      billing.ApprovalCode.trim() !== '' &&
                                      (service.AmountPaid || 0) < (service.UpdatedPrice || service.Cost);
        return isExplicitInsurance || isPotentialInsurance;
      });
      
      return hasInsuranceService;
    })
    .map(billing => {
      const insuranceServices = billing.services.filter(service => {
        const paymentMethod = service.PaymentMethod?.toLowerCase() || 'n/a';
        const isExplicitInsurance = this.insuranceProviders.some(p => 
          p.MethodName.toLowerCase() === paymentMethod
        );
        const isPotentialInsurance = paymentMethod === 'n/a' && 
                                      billing.ApprovalCode && 
                                      billing.ApprovalCode.trim() !== '' &&
                                      (service.AmountPaid || 0) < (service.UpdatedPrice || service.Cost);
        const isFullyPaidNonInsurance = (service.AmountPaid || 0) >= (service.UpdatedPrice || service.Cost) && 
                                        !this.insuranceProviders.some(p => p.MethodName.toLowerCase() === paymentMethod);

        return (isExplicitInsurance || isPotentialInsurance) && !isFullyPaidNonInsurance;
      });

      if (insuranceServices.length === 0) return null;

      const totalAmount = insuranceServices.reduce((sum, service) => {
        const price = service.UpdatedPrice !== null ? Number(service.UpdatedPrice) : Number(service.Cost);
        return sum + price;
      }, 0);

      const totalPaid = insuranceServices.reduce((sum, service) => sum + (Number(service.AmountPaid) || 0), 0);
      const discount = insuranceServices.reduce((sum, service) => sum + (Number(service.Discount) || 0), 0);
      const balance = totalAmount - totalPaid - discount;

      const primaryPaymentMethod = insuranceServices[0]?.PaymentMethod !== 'N/A' 
        ? (insuranceServices[0]?.PaymentMethod || 'N/A')
        : this.insuranceProviders[0]?.MethodName || 'N/A';

      return {
        ...billing,
        Procedure: insuranceServices.map(s => s.ServiceName).join(', '),
        TotalAmount: totalAmount,
        AmountPaid: totalPaid,
        Discount: discount,
        Balance: balance,
        PaymentMethod: primaryPaymentMethod,
        BillingStatus: billing.BillingStatus, // Preserve the original BillingStatus
        services: insuranceServices.map(service => {
          const serviceTotal = service.UpdatedPrice !== null ? Number(service.UpdatedPrice) : Number(service.Cost);
          const servicePaid = Number(service.AmountPaid) || 0;
          const serviceDiscount = Number(service.Discount) || 0;
          const serviceBalance = serviceTotal - servicePaid - serviceDiscount;
          const hasApprovalCode = billing.ApprovalCode && billing.ApprovalCode.trim() !== '';
          return {
            ...service,
            PaymentMethod: service.PaymentMethod === 'N/A' ? primaryPaymentMethod : (service.PaymentMethod || 'N/A'),
            Balance: serviceBalance,
            PaymentStatus: hasApprovalCode ? 'Paid' : (serviceBalance <= 0 ? 'Paid' : (servicePaid > 0 ? 'Partially Paid' : 'Unpaid')),
          };
        }),
      };
    })
    .filter(billing => billing !== null)
    .sort((a, b) => {
      const dateA = new Date(a.AppointmentDateTime || a.CreatedAt || '1970-01-01');
      const dateB = new Date(b.AppointmentDateTime || b.CreatedAt || '1970-01-01');
      return dateB - dateA;
    });
},
    referenceIdPlaceholder() {
      if (!this.selectedBilling.PaymentMethod) return 'Enter Reference ID';
      const method = this.paymentMethods.find(m => m.MethodName === this.selectedBilling.PaymentMethod);
      if (!method) return 'Enter Reference ID';
      switch (method.MethodName) {
        case 'GCash':
          return 'Enter 13-digit Reference ID (e.g., 1234567890123)';
        case 'Shopee Pay':
          return 'Enter 12-16 character Reference ID (e.g., SHP1234567890)';
        case 'Grab Pay':
          return 'Enter 10-15 character Reference ID (e.g., GRB9876543210)';
        case 'WeChat Pay':
          return 'Enter 20-32 character Reference ID (e.g., WCP1234567890abcdef)';
        default:
          return 'Enter 6-12 character Reference ID (e.g., AUTH123456)';
      }
    },
    referenceIdMaxLength() {
      if (!this.selectedBilling.PaymentMethod) return 32;
      const method = this.paymentMethods.find(m => m.MethodName === this.selectedBilling.PaymentMethod);
      if (!method) return 32;
      switch (method.MethodName) {
        case 'GCash':
          return 13;
        case 'Shopee Pay':
          return 16;
        case 'Grab Pay':
          return 15;
        case 'WeChat Pay':
          return 32;
        default:
          return 12; // Bank Payments
      }
    },
    totalInsurancePayout() {
      return this.insuranceBillings
        .reduce((sum, billing) => {
          // If the billing has an ApprovalCode, use TotalAmount - Discount as the paid amount
          const hasApprovalCode = billing.ApprovalCode && billing.ApprovalCode.trim() !== '';
          if (hasApprovalCode) {
            return sum + (Number(billing.TotalAmount) || 0) - (Number(billing.Discount) || 0);
          }
          // Otherwise, use the AmountPaid
          return sum + (Number(billing.AmountPaid) || 0);
        }, 0)
        .toFixed(2);
    },
    isInsuranceBilling() {
      return (
        this.selectedBilling &&
        this.selectedBilling.services.some(service =>
          this.insuranceProviders.some(p => p.MethodName === service.PaymentMethod)
        ) &&
        this.activeTab === 'insurance'
      );
    },
    newPaymentReferenceIdPlaceholder() {
      if (!this.newPayment.PaymentMethod) return 'Enter Reference ID';
      const method = this.paymentMethods.find(m => m.MethodName === this.newPayment.PaymentMethod);
      if (!method) return 'Enter Reference ID';
      const methodType = method.MethodType;
      if (methodType === 'E-Wallet' || methodType === 'Bank Payment') {
        return 'Enter 12-13 character Reference ID (e.g., REF1234567890)';
      }
      return 'Enter Reference ID';
    },
    newPaymentReferenceIdMaxLength() {
      if (!this.newPayment.PaymentMethod) return 13;
      const method = this.paymentMethods.find(m => m.MethodName === this.newPayment.PaymentMethod);
      if (!method) return 13;
      const methodType = method.MethodType;
      if (methodType === 'E-Wallet' || methodType === 'Bank Payment') {
        return 13;
      }
      return 13;
    },
    isNewPaymentFormValid() {
      const method = this.paymentMethods.find(m => m.MethodName === this.newPayment.PaymentMethod);
      const methodType = method ? method.MethodType : 'Cash';
      return (
        this.newPayment.PatientID &&
        this.newPayment.AmountPaid >= 0 &&
        this.newPayment.PaymentMethod &&
        (this.showNewPaymentReferenceInput ? this.newPayment.ReferenceID : true) &&
        (methodType === 'Cash' ? this.newPayment.Change >= 0 : true)
      );
    },
    isPaid() {
      return this.selectedBilling.BillingStatus === 'Paid';
    },
    isFormValid() {
      if (!this.selectedBilling.services || this.selectedBilling.services.length === 0) {
        return true;
      }
      return this.selectedBilling.services.every(service => {
        if (!service.PaymentMethod || service.PaymentStatus === 'Paid') {
          return true;
        }
        const method = this.paymentMethods.find(m => m.MethodName === service.PaymentMethod);
        if (!method) return true;
        const methodType = method.MethodType;
        if ((methodType === 'E-Wallet' || methodType === 'Bank Payment') && !service.ReferenceID) {
          return false;
        }
        return true;
      });
    },
    requiresLOE() {
      // Check if any selected billing uses Maxicare
      const billingsToApprove = this.insuranceBillings.filter(b =>
        this.pendingBillingIds.includes(b.BillingID)
      );
      return billingsToApprove.some(billing =>
        billing.services.some(service => service.PaymentMethod === 'Maxicare')
      );
    },
    isApprovalFormValid() {
      if (!this.approvalDetails.ApprovalCode) return false;
      if (this.approvalCodeError || this.loeError) return false;
      if (this.requiresLOE && !this.approvalDetails.LOE) return false;
      return true;
    },
    isSelectedInsuranceFormValid() {
      if (!this.isInsuranceBilling) return true;
      if (!this.selectedBilling.ApprovalCode) return false;
      if (this.selectedApprovalCodeError || this.selectedLOEError) return false;
      if (this.selectedBilling.PaymentMethod === 'Maxicare' && !this.selectedBilling.LOE) return false;
      return true;
    },
    filteredBillings() {
      let billings = [...this.allBillings];

      if (this.searchQuery) {
        const query = this.searchQuery.toLowerCase();
        billings = billings.filter(billing =>
          (billing.PatientName?.toLowerCase().includes(query) ||
          billing.Procedure?.toLowerCase().includes(query) ||
          billing.BillingID?.toString().toLowerCase().includes(query) ||
          billing.AssignedDentist?.toLowerCase().includes(query))
        );
      }

      if (this.dateRange && this.dateRange.length === 2) {
        const [startDate, endDate] = this.dateRange.map(date => new Date(date));
        billings = billings.filter(billing => {
          const billingDate = new Date(billing.AppointmentDateTime || billing.CreatedAt);
          return billingDate >= startDate && billingDate <= endDate;
        });
      }

      return billings;
    },

    approvalCodePlaceholder() {
      const billingsToApprove = this.insuranceBillings.filter(b =>
        this.pendingBillingIds.includes(b.BillingID)
      );
      const hasMedicard = billingsToApprove.some(billing =>
        billing.services.some(service => service.PaymentMethod === 'Medicard')
      );
      const hasMaxicare = billingsToApprove.some(billing =>
        billing.services.some(service => service.PaymentMethod === 'Maxicare')
      );

      if (hasMedicard) {
        return 'Enter Approval Code (e.g., AB 12345)';
      } else if (hasMaxicare) {
        return 'Enter Approval Code (e.g., 123456789)';
      }
      return 'Enter Approval Code';
    },
    approvalCodeMaxLength() {
      const billingsToApprove = this.insuranceBillings.filter(b =>
        this.pendingBillingIds.includes(b.BillingID)
      );
      const hasMedicard = billingsToApprove.some(billing =>
        billing.services.some(service => service.PaymentMethod === 'Medicard')
      );
      const hasMaxicare = billingsToApprove.some(billing =>
        billing.services.some(service => service.PaymentMethod === 'Maxicare')
      );

      if (hasMedicard) {
        return 10; // 2 letters + space + 7 digits
      } else if (hasMaxicare) {
        return 9; // 8-9 digits
      }
      return 10;
    },
    selectedApprovalCodePlaceholder() {
      if (this.selectedBilling.PaymentMethod === 'Medicard') {
        return 'Enter Approval Code (e.g., AB 12345)';
      } else if (this.selectedBilling.PaymentMethod === 'Maxicare') {
        return 'Enter Approval Code (e.g., 123456789)';
      }
      return 'Enter Approval Code';
    },
    selectedApprovalCodeMaxLength() {
      if (this.selectedBilling.PaymentMethod === 'Medicard') {
        return 10; // 2 letters + space + 7 digits
      } else if (this.selectedBilling.PaymentMethod === 'Maxicare') {
        return 9; // 8-9 digits
      }
      return 10;
    },
    getAvailablePaymentMethods() {
      return (service, serviceIndex) => {
        // Return all payment methods without any restrictions
        return this.paymentMethods;
      };
    },
    shouldShowSharedReferenceInput() {
    if (!this.selectedBilling.services || this.selectedBilling.services.length === 0) return false;
    
    // Get the payment method of the first service
    const firstPaymentMethod = this.selectedBilling.services[0].PaymentMethod;
    
    // Check if first payment method is valid (not empty or 'N/A')
    if (!firstPaymentMethod || firstPaymentMethod === 'N/A') return false;
    
    // Check if all services have the same payment method as the first one
    return this.selectedBilling.services.every(service => 
      service.PaymentMethod === firstPaymentMethod && service.PaymentMethod !== 'N/A'
    );
  },

  shouldShowIndividualReferenceInput() {
    return (service) => {
      if (this.shouldShowSharedReferenceInput) return false; // Hide individual fields if shared field is shown
      const method = this.paymentMethods.find(m => m.MethodName === service.PaymentMethod);
      if (!method) return false;
      const methodType = method.MethodType;
      return methodType === 'E-Wallet' || methodType === 'Bank Payment';
    };
  },
    

  },
  mounted() {
    this.fetchBillings();
    this.fetchPaymentMethods();
    this.fetchPatientsWithBalances();
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
    });
  },
  methods: {
    getCombinedServiceNames(services) {
      if (!services || services.length === 0) return 'No services';
      
      const serviceNames = services.map(service => service.ServiceName);
      
      if (serviceNames.length === 1) {
        return serviceNames[0];
      } else if (serviceNames.length === 2) {
        return serviceNames.join(' and ');
      } else {
        return serviceNames.slice(0, -1).join(', ') + ' and ' + serviceNames[serviceNames.length - 1];
      }
    },
    async declineInsurance() {
  try {
    // Calculate TotalAmount inline to avoid undefined method error
    const totalAmount = this.selectedBilling.services.reduce((sum, service) => {
      return sum + (Number(service.Cost) - (Number(service.Discount) || 0));
    }, 0);

    const payload = {
      BillingID: this.selectedBilling.BillingID,
      BillingStatus: 'Unpaid',
      PaymentMethod: null,
      PaymentMethodID: null, // Explicitly set to NULL
      ApprovalCode: null,
      LOE: null,
      services: this.selectedBilling.services.map(service => ({
        BillingServiceID: service.BillingServiceID,
        ServiceID: service.ServiceID,
        Cost: Number(service.Cost),
        Discount: Number(service.Discount) || 0,
        AmountPaid: 0,
        PaymentMethod: null,
        ReferenceID: null,
        Change: 0,
        PaymentStatus: 'Unpaid',
      })),
      Remarks: this.selectedBilling.Remarks || '',
      TotalAmount: totalAmount,
      AmountPaid: 0,
      Balance: totalAmount,
    };

    await axios.put(`/hr/billings/${this.selectedBilling.BillingID}/decline-insurance`, payload, {
      headers: { Authorization: `Bearer ${localStorage.getItem('token')}` },
    });

    await this.fetchBillings();
    this.closeModal();
  } catch (error) {
    console.error('Error declining insurance:', error);
    this.showGenericErrorModal = true;
    this.genericErrorMessage = 'Failed to decline insurance. Please try again.';
  }
},
    handleTotalAmountInput() {
      const totalAmount = Number(this.selectedBilling.TotalAmount);
      if (!Number.isInteger(totalAmount) || totalAmount < 0) {
        this.openGenericErrorModal('The Total Amount must be a whole number (e.g., 1000, 5000).');
        this.selectedBilling.TotalAmount = Math.floor(totalAmount) || 0;
        return;
      }

      if (this.isInsuranceBilling && this.selectedBilling.BillingStatus !== 'Paid') {
        const discount = Number(this.selectedBilling.Discount) || 0;
        this.selectedBilling.TotalPaid = totalAmount - discount; // Amount Paid matches changed Total Amount minus Discount
        this.selectedBilling.Balance = 0; // Remaining Balance is 0
        this.selectedBilling.services.forEach(service => {
          if (this.isInsuranceMethod(service)) {
            service.Cost = totalAmount / this.selectedBilling.services.length; // Distribute evenly (adjust logic if needed)
            service.AmountPaid = service.Cost; // Amount Paid matches Cost
            service.Balance = 0; // Balance is 0
            service.PaymentStatus = 'Paid'; // Status is Paid
          }
        });
      } else {
        this.calculateTotalBalanceAndStatus();
      }
    },
    openApprovalModal(action, billingIds) {
      this.pendingApprovalAction = action;
      this.pendingBillingIds = billingIds;
      this.approvalDetails = {
        ApprovalCode: '',
        LOE: '',
      };
      this.approvalCodeError = '';
      this.loeError = '';
      this.showApprovalModal = true;
    },
    closeApprovalModal() {
      this.showApprovalModal = false;
      this.pendingApprovalAction = null;
      this.pendingBillingIds = [];
    },
    validateApprovalCode() {
      const billingsToApprove = this.insuranceBillings.filter(b =>
        this.pendingBillingIds.includes(b.BillingID)
      );
      const hasMedicard = billingsToApprove.some(billing =>
        billing.services.some(service => service.PaymentMethod === 'Medicard')
      );
      const hasMaxicare = billingsToApprove.some(billing =>
        billing.services.some(service => service.PaymentMethod === 'Maxicare')
      );

      const value = this.approvalDetails.ApprovalCode || '';
      let isValid = true;
      let errorMessage = '';

      if (hasMedicard) {
        // Medicard: 2 letters, space, 5-7 digits (e.g., "AB 12345")
        const medicardRegex = /^[A-Z]{2}\s\d{5,7}$/;
        if (!medicardRegex.test(value)) {
          isValid = false;
          errorMessage = 'Approval Code for Medicard must be 2 letters, a space, then 5-7 digits (e.g., AB 12345)';
        }
      }
      if (hasMaxicare) {
        // Maxicare: 8-9 digits (e.g., "123456789")
        const maxicareRegex = /^\d{8,9}$/;
        if (!maxicareRegex.test(value)) {
          isValid = false;
          errorMessage = 'Approval Code for Maxicare must be 8-9 digits (e.g., 123456789)';
        }
      }

      this.approvalCodeError = isValid ? '' : errorMessage;
    },
    validateLOE() {
      const value = this.approvalDetails.LOE || '';
      const maxicareRegex = /^\d{8,9}$/;
      if (!maxicareRegex.test(value)) {
        this.loeError = 'LOE # for Maxicare must be 8-9 digits (e.g., 987654321)';
      } else {
        this.loeError = '';
      }
    },
    async submitApproval() {
  if (!this.isApprovalFormValid) {
    this.openGenericErrorModal('Please correct the errors in the form before submitting.');
    return;
  }

  try {
    const payload = {
      billingIds: this.pendingBillingIds,
      ApprovalCode: this.approvalDetails.ApprovalCode,
      LOE: this.requiresLOE ? this.approvalDetails.LOE : null,
    };
    const response = await axios.post('/hr/billings/approve-insurance', payload, { withCredentials: true });
    alert(`${response.data.count} billings approved. Total: ₱${this.formatNumber(response.data.totalApprovedAmount)}`);

    // Update the frontend state for the approved billings
    this.allBillings = this.allBillings.map(billing => {
      if (this.pendingBillingIds.includes(String(billing.BillingID))) {
        const updatedServices = billing.services.map(service => {
          if (this.insuranceProviders.some(p => p.MethodName === service.PaymentMethod)) {
            const serviceCost = service.UpdatedPrice !== null ? Number(service.UpdatedPrice) : Number(service.Cost);
            const serviceDiscount = Number(service.Discount) || 0;
            return {
              ...service,
              AmountPaid: serviceCost - serviceDiscount, // Set AmountPaid to the full cost minus discount
              Balance: 0,
              PaymentStatus: 'Paid',
            };
          }
          return service;
        });

        const totalPaid = updatedServices.reduce((sum, service) => sum + (Number(service.AmountPaid) || 0), 0);
        const totalDiscount = updatedServices.reduce((sum, service) => sum + (Number(service.Discount) || 0), 0);
        const totalAmount = updatedServices.reduce((sum, service) => {
          const price = service.UpdatedPrice !== null ? Number(service.UpdatedPrice) : Number(service.Cost);
          return sum + price;
        }, 0);

        return {
          ...billing,
          ApprovalCode: this.approvalDetails.ApprovalCode,
          LOE: this.requiresLOE ? this.approvalDetails.LOE : null,
          BillingStatus: 'Paid',
          TotalPaid: totalPaid,
          Discount: totalDiscount,
          Balance: totalAmount - totalPaid - totalDiscount,
          services: updatedServices,
        };
      }
      return billing;
    });

    this.selectedBillings = [];
    this.selectAll = false;
    this.closeApprovalModal();
  } catch (error) {
    console.error("Error approving billings:", error);
    alert('Failed to approve billings: ' + (error.response?.data?.message || error.message));
  }
},
    async approveSelected() {
      if (this.selectedBillings.length === 0) {
        this.openGenericErrorModal('Please select at least one billing to approve.');
        return;
      }
      if (confirm(`Approve ${this.selectedBillings.length} selected insurance billing(s)?`)) {
        this.openApprovalModal('selected', this.selectedBillings);
      }
    },
    async approveAll() {
      const unpaidInsuranceBillings = this.insuranceBillings.filter(b => b.BillingStatus === 'Unpaid');
      const unpaidInsuranceCount = unpaidInsuranceBillings.length;
      if (unpaidInsuranceCount === 0) {
        this.openGenericErrorModal('No unpaid insurance billings to approve.');
        return;
      }
      if (confirm(`Approve all ${unpaidInsuranceCount} unpaid insurance billing(s)?`)) {
        const billingIds = unpaidInsuranceBillings.map(b => b.BillingID);
        this.openApprovalModal('all', billingIds);
      }
    },
    isInsuranceMethod(service) {
      if (!service.PaymentMethod) return false;
      return this.insuranceProviders.some(p => p.MethodName === service.PaymentMethod);
    },
    hasCostChanged(service) {
      const originalService = this.selectedBilling.originalServices.find(
        s => s.ServiceAvailedID === service.ServiceAvailedID && s.ServiceName === service.ServiceName
      );
      if (!originalService) return true;
      const currentPrice = service.UpdatedPrice !== null ? Number(service.UpdatedPrice) : Number(service.Cost);
      return Math.abs(currentPrice - Number(originalService.Cost)) > 0.01; // Allow for small floating-point differences
    },
    shouldShowReferenceID() {
      if (!this.selectedBilling.PaymentMethod) return false;
      const method = this.paymentMethods.find(m => m.MethodName === this.selectedBilling.PaymentMethod);
      if (!method) return false;
      const methodType = method.MethodType;
      return methodType === 'E-Wallet' || methodType === 'Bank Payment';
    },
    formatDateTime(dateTime) {
      if (!dateTime || dateTime === 'N/A') return 'N/A';
      const date = new Date(dateTime);
      if (isNaN(date)) return 'Invalid Date';
      const datePart = new Intl.DateTimeFormat('en-US', {
        month: 'long',
        day: 'numeric',
        year: 'numeric',
      }).format(date);
      const timePart = new Intl.DateTimeFormat('en-US', {
        hour: 'numeric',
        minute: '2-digit',
        hour12: true,
      }).format(date);
      return `${datePart} ${timePart}`;
    },
    updateTotalAmount() {
      // Validate that costs are whole numbers for services with insurance payment methods
      for (const service of this.selectedBilling.services) {
        if (this.isInsuranceMethod(service)) {
          const cost = Number(service.Cost);
          if (!Number.isInteger(cost) || cost < 0) {
            this.openGenericErrorModal(`The cost for ${service.ServiceName} must be a whole number (e.g., 100, 2500).`);
            service.Cost = Math.floor(cost) || 0;
            return;
          }
        }
        // Validate discount
        if (service.Discount < 0) {
          this.openGenericErrorModal(`The discount for ${service.ServiceName} cannot be negative.`);
          service.Discount = 0;
        }
        if (service.Discount > service.Cost) {
          this.openGenericErrorModal(`The discount for ${service.ServiceName} cannot exceed the price.`);
          service.Discount = service.Cost;
        }
      }

      this.selectedBilling.TotalAmount = this.selectedBilling.services.reduce(
        (sum, service) => sum + (Number(service.Cost) || 0),
        0
      );

      // Validate that TotalAmount is a whole number
      const totalAmount = Number(this.selectedBilling.TotalAmount);
      if (!Number.isInteger(totalAmount) || totalAmount < 0) {
        this.openGenericErrorModal('The Total Amount must be a whole number (e.g., 1000, 5000).');
        this.selectedBilling.TotalAmount = Math.floor(totalAmount) || 0;
      }

      // Update total discount from service discounts
      this.selectedBilling.Discount = this.selectedBilling.services.reduce(
        (sum, service) => sum + (Number(service.Discount) || 0),
        0
      );

      // Handle insurance-specific logic
      if (this.isInsuranceBilling && this.selectedBilling.BillingStatus !== 'Paid') {
        const discount = Number(this.selectedBilling.Discount) || 0;
        this.selectedBilling.TotalPaid = totalAmount - discount; // Amount Paid matches Total Amount minus Discount
        this.selectedBilling.Balance = 0; // Remaining Balance is 0
        this.selectedBilling.services.forEach(service => {
          if (this.isInsuranceMethod(service)) {
            service.AmountPaid = service.Cost - (service.Discount || 0); // Service Amount Paid matches its Cost minus Discount
            service.Balance = 0; // Service Balance is 0
            service.PaymentStatus = 'Paid'; // Service status is Paid
          }
        });
      } else {
        // Recalculate Balance for non-insurance billings
        const totalPaid = this.selectedBilling.services.reduce(
          (sum, service) => sum + (Number(service.AmountPaid) || 0),
          0
        );
        this.selectedBilling.TotalPaid = totalPaid;
        this.selectedBilling.Balance = Math.max(0, this.selectedBilling.TotalAmount - this.selectedBilling.Discount - totalPaid);
      }
    },
    async fetchBillings() {
  try {
    const response = await axios.get('/hr/billings', { withCredentials: true });
    const billingsMap = new Map();

    response.data.forEach(billing => {
      const isStandalonePayment = billing.IsStandalonePayment || false;
      const totalAmount = Number(billing.TotalAmount) || 0;
      const totalPaid = Number(billing.AmountPaid) || 0;
      const discount = Number(billing.Discount) || 0;
      const balance = Number(billing.Balance) || 0;

      const procedure = billing.Procedure;

      const services = Array.isArray(billing.services) ? billing.services : [];

      const mappedServices = services.map((service, index) => {
        let serviceCost = service.UpdatedPrice !== null ? Number(service.UpdatedPrice) : Number(service.Cost) || 0;
        const serviceAmountPaid = Number(service.AmountPaid) || 0;
        const serviceDiscount = Number(service.Discount) || 0;

        const calculatedBalance = serviceCost - serviceAmountPaid - serviceDiscount;

        return {
          ...service,
          Cost: serviceCost,
          AmountPaid: serviceAmountPaid,
          Balance: Number(service.Balance) || calculatedBalance,
          PaymentStatus: service.PaymentStatus || (serviceAmountPaid >= (serviceCost - serviceDiscount) ? 'Paid' : (serviceAmountPaid > 0 ? 'Partially Paid' : 'Unpaid')),
          PaymentMethod: service.PaymentMethod || 'N/A',
          ReferenceID: service.ReferenceID || '',
          Change: Number(service.Change) || 0,
          TableCategory: service.PaymentStatus === 'Paid' ? 'paid' : (this.insuranceProviders.some(p => p.MethodName === service.PaymentMethod) ? 'insurance' : 'unpaid'),
        };
      });

      const billingIdStr = String(billing.BillingID);
      const baseBillingID = billingIdStr.includes('_S_') ? billingIdStr.split('_S_')[0] : billingIdStr;

      const serviceGroups = { insurance: [], nonInsurance: [] };
      let hasInsuranceService = false;
      mappedServices.forEach(service => {
        const paymentMethod = service.PaymentMethod?.toLowerCase() || 'n/a';
        const isExplicitInsurance = this.insuranceProviders.some(p => p.MethodName.toLowerCase() === paymentMethod);
        const isPotentialInsurance = paymentMethod === 'n/a' && 
                                    billing.ApprovalCode && 
                                    billing.ApprovalCode.trim() !== '' && 
                                    (service.AmountPaid || 0) < (service.UpdatedPrice || service.Cost);

        if (isExplicitInsurance || isPotentialInsurance) {
          serviceGroups.insurance.push(service);
          hasInsuranceService = true;
        } else {
          serviceGroups.nonInsurance.push(service);
        }
      });

      // Add IsInsuranceBilling flag for use in insuranceBillings
      const isInsuranceBilling = hasInsuranceService || billingIdStr.includes('_PM_') || (billing.ApprovalCode && billing.ApprovalCode.trim() !== '');

      if (serviceGroups.insurance.length > 0) {
        const insuranceBillingId = billingIdStr.includes('_PM_') ? `${billingIdStr}_insurance` : `${baseBillingID}_insurance`;
        const insuranceTotalAmount = serviceGroups.insurance.reduce((sum, s) => {
          return sum + (s.UpdatedPrice !== null ? Number(s.UpdatedPrice) : Number(s.Cost));
        }, 0);
        const insuranceTotalPaid = serviceGroups.insurance.reduce((sum, s) => sum + Number(s.AmountPaid), 0);
        const insuranceDiscount = serviceGroups.insurance.reduce((sum, s) => sum + Number(s.Discount), 0);
        const insuranceBalance = insuranceTotalAmount - insuranceTotalPaid - insuranceDiscount;

        billingsMap.set(insuranceBillingId, {
          ...billing,
          BillingID: insuranceBillingId,
          IsStandalonePayment: isStandalonePayment,
          TotalAmount: insuranceTotalAmount,
          TotalPaid: insuranceTotalPaid,
          Discount: insuranceDiscount,
          Balance: insuranceBalance,
          BillingStatus: billing.BillingStatus || (insuranceBalance <= 0 ? 'Paid' : (insuranceTotalPaid > 0 ? 'Partially Paid' : 'Unpaid')),
          ApprovalCode: billing.ApprovalCode || null,
          LOE: billing.LOE || null,
          Procedure: serviceGroups.insurance.map(s => s.ServiceName).join(', '),
          services: serviceGroups.insurance,
          PaymentDate: billing.PaymentDate || billing.CreatedAt || billing.AppointmentDateTime,
          IsInsuranceBilling: true // Add flag
        });
      }

      if (serviceGroups.nonInsurance.length > 0) {
  const nonInsuranceBillingId = `${baseBillingID}_nonInsurance`;
  const nonInsuranceTotalAmount = serviceGroups.nonInsurance.reduce((sum, s) => {
    return sum + (s.UpdatedPrice !== null ? Number(s.UpdatedPrice) : Number(s.Cost));
  }, 0);
  const nonInsuranceTotalPaid = serviceGroups.nonInsurance.reduce((sum, s) => sum + Number(s.AmountPaid), 0);
  const nonInsuranceDiscount = serviceGroups.nonInsurance.reduce((sum, s) => sum + Number(s.Discount), 0);
  const nonInsuranceBalance = nonInsuranceTotalAmount - nonInsuranceTotalPaid - nonInsuranceDiscount;

  billingsMap.set(nonInsuranceBillingId, {
    ...billing,
    BillingID: nonInsuranceBillingId,
    IsStandalonePayment: isStandalonePayment,
    TotalAmount: billing.TotalAmount || nonInsuranceTotalAmount, // Prioritize API TotalAmount
    TotalPaid: billing.TotalPaid || nonInsuranceTotalPaid,
    Discount: billing.Discount || nonInsuranceDiscount,
    Balance: billing.Balance || nonInsuranceBalance, // Prioritize API Balance
    BillingStatus: billing.BillingStatus || (nonInsuranceBalance <= 0 ? 'Paid' : (nonInsuranceTotalPaid > 0 ? 'Partially Paid' : 'Unpaid')),
    ApprovalCode: billing.ApprovalCode || null,
    LOE: billing.LOE || null,
    Procedure: serviceGroups.nonInsurance.map(s => s.ServiceName).join(', '),
    services: serviceGroups.nonInsurance,
    PaymentDate: billing.PaymentDate || billing.CreatedAt || billing.AppointmentDateTime,
    IsInsuranceBilling: false
  });
}
    });

    this.allBillings = Array.from(billingsMap.values());

  } catch (error) {
    console.error("Error fetching billings:", error);
    this.allBillings = [];
    this.openGenericErrorModal('Failed to fetch billings: ' + (error.response?.data?.message || error.message));
  }
},
    createServicesFromProcedure(billing) {
      if (!billing.Procedure) return [];
      const services = billing.Procedure.split(',').map(proc => {
        const trimmedProc = proc.trim();
        return {
          ServiceID: null,
          ServiceName: trimmedProc,
          Cost: billing.Amount,
        };
      });
      return services;
    },
    async fetchPaymentMethods() {
  try {
    const response = await axios.get('/hr/payment-methods', { withCredentials: true });
    this.paymentMethods = [{ MethodName: 'N/A', MethodType: 'Cash' }, ...response.data];
    this.insuranceProviders = response.data.filter(method => method.MethodType === 'Insurance');
  } catch (error) {
    console.error("Error fetching payment methods:", error);
    this.paymentMethods = [{ MethodName: 'N/A', MethodType: 'Cash' }];
    this.insuranceProviders = [];
  }
},
    filterBillings() {
      if (!this.searchQuery.trim()) {
        this.isSearchActive = false;
      } else {
        this.isSearchActive = true;
      }
    },
    resetSearch() {
      this.searchQuery = '';
      this.isSearchActive = false;
    },
    activateSearch() {
      this.isSearchActive = true;
    },
    deactivateSearch() {
      if (!this.searchQuery) {
        this.isSearchActive = false;
      }
    },
    resetSearch() {
      this.searchQuery = '';
      this.isSearchActive = false;
      this.filteredBillings = [...this.allBillings];
    },
    formatNumber(value) {
      return typeof value === 'number' && !isNaN(value) ? value.toFixed(2) : '0.00';
    },
    getStatusClass(status) {
      if (!status) return '';
      switch (status.toLowerCase()) {
        case 'paid':
          return 'paid';
        case 'partially paid':
          return 'partial';
        case 'unpaid':
          return 'unpaid';
        default:
          return '';
      }
    },
    updateReferenceAndChangeVisibility() {
      const method = this.paymentMethods.find(m => m.MethodName === this.selectedBilling.PaymentMethod);
      const methodType = method ? method.MethodType : 'Cash';
      const methodName = method ? method.MethodName : this.selectedBilling.PaymentMethod;
      this.showReferenceInput = methodType === 'E-Wallet' || methodType === 'Bank Payment';
      this.showChangeInput = methodType === 'Cash' && methodName === 'Cash';
      if (methodType === 'Insurance' && this.insuranceProviders.some(p => p.MethodName === this.selectedBilling.PaymentMethod)) {
        this.selectedBilling.AmountPaid = 0;
        this.selectedBilling.BillingStatus = 'Unpaid';
      }
      if (!this.showReferenceInput) {
        this.selectedBilling.ReferenceID = '';
      }
      if (!this.showChangeInput) {
        this.selectedBilling.Change = 0;
      }
      this.calculateTotalBalanceAndStatus();
    },
    validateReferenceID() {
      if (!this.selectedBilling.PaymentMethod) return;
      const method = this.paymentMethods.find(m => m.MethodName === this.selectedBilling.PaymentMethod);
      if (!method) return;
      let value = this.selectedBilling.ReferenceID || '';
      switch (method.MethodName) {
        case 'GCash':
          value = value.replace(/[^0-9]/g, '').slice(0, 13);
          break;
        case 'Shopee Pay':
          value = value.replace(/[^A-Za-z0-9]/g, '').slice(0, 16);
          break;
        case 'Grab Pay':
          value = value.replace(/[^A-Za-z0-9]/g, '').slice(0, 15);
          break;
        case 'WeChat Pay':
          value = value.replace(/[^A-Za-z0-9]/g, '').slice(0, 32);
          break;
        default:
          value = value.replace(/[^A-Za-z0-9]/g, '').slice(0, 12);
          break;
      }
      this.selectedBilling.ReferenceID = value;
    },
    updateSharedReferenceID() {
    if (this.shouldShowSharedReferenceInput) {
      this.selectedBilling.services.forEach(service => {
        if (service.PaymentMethod && service.PaymentMethod !== 'N/A') {
          service.ReferenceID = this.sharedReferenceID;
        }
      });
    }
  },
  openEditModal(billing) {
  this.isViewOnly = false;
  this.isFromPaidTab = this.activeTab === 'paid';

  const billingIdStr = String(billing.BillingID);
  const baseBillingID = billingIdStr.includes('_insurance') || billingIdStr.includes('_nonInsurance')
    ? billingIdStr.replace(/_insurance|_nonInsurance/, '')
    : billingIdStr;

  const existingBilling = this.allBillings.find(b => String(b.BillingID) === String(billing.BillingID));
  if (!existingBilling) {
    console.error(`Billing with ID ${billing.BillingID} not found in allBillings`);
    alert('Error: Billing not found. Please try refreshing the page.');
    return;
  }

  if (!Array.isArray(existingBilling.services)) {
    console.warn(`Billing ${billing.BillingID} has invalid services:`, existingBilling.services);
    existingBilling.services = [];
  }

  let targetPaymentMethod = null;
  if (this.activeTab === 'insurance') {
    targetPaymentMethod = billing.PaymentMethod !== 'N/A' 
      ? billing.PaymentMethod 
      : this.insuranceProviders[0]?.MethodName || 'N/A';
  }

  let restrictedMethodType = null;
  let restrictedMethodName = null;
  if (this.activeTab === 'unpaid') {
    for (const service of existingBilling.services) {
      if (service.PaymentMethod && service.PaymentMethod !== 'N/A') {
        const method = this.paymentMethods.find(m => m.MethodName === service.PaymentMethod);
        if (method && (method.MethodType === 'E-Wallet' || method.MethodType === 'Bank Payment')) {
          restrictedMethodType = method.MethodType;
          restrictedMethodName = method.MethodName;
          break;
        }
      }
    }
  }

  const updatedServices = existingBilling.services.map(service => {
  const serviceDiscount = Number(service.Discount) || 0;
  let serviceAmountPaid = Number(service.AmountPaid) || 0;
  let adjustedPaymentMethod = service.PaymentMethod || 'N/A';

  if (this.activeTab === 'unpaid' && restrictedMethodType && adjustedPaymentMethod !== 'N/A') {
    const method = this.paymentMethods.find(m => m.MethodName === adjustedPaymentMethod);
    const methodType = method ? method.MethodType : null;
    if (
      (restrictedMethodType === 'E-Wallet' || restrictedMethodType === 'Bank Payment') &&
      methodType &&
      methodType !== 'Cash' &&
      methodType !== 'Insurance' &&
      adjustedPaymentMethod !== restrictedMethodName
    ) {
      adjustedPaymentMethod = 'N/A';
      serviceAmountPaid = 0;
      service.ReferenceID = '';
      service.Change = 0;
    }
  }

  if (targetPaymentMethod && adjustedPaymentMethod !== targetPaymentMethod) {
    serviceAmountPaid = 0;
  }

  // Use the billing's balance as the service cost if there's a remaining balance
  let serviceCost;
  if (billing.Balance > 0 && billing.Balance !== billing.TotalAmount) {
    // If there's a remaining balance that's different from total amount, use the balance
    serviceCost = billing.Balance;
  } else {
    // Otherwise use the service's updated price or original cost
    serviceCost = service.UpdatedPrice !== null ? Number(service.UpdatedPrice) : Number(service.Cost);
  }

  const effectiveCost = serviceCost - serviceDiscount;
  let serviceChange = Number(service.Change) || 0;
  const method = this.paymentMethods.find(m => m.MethodName === adjustedPaymentMethod);
  if (method && method.MethodType === 'Cash' && method.MethodName === 'Cash') {
    serviceChange = serviceAmountPaid > effectiveCost ? serviceAmountPaid - effectiveCost : 0;
  }

  return {
    ...service,
    Cost: serviceCost, // Use the calculated service cost (which may be the remaining balance)
    BasePrice: Number(service.Cost), // Store original cost from database
    UpdatedPrice: service.UpdatedPrice !== null ? Number(service.UpdatedPrice) : null,
    AmountPaid: serviceAmountPaid,
    Discount: serviceDiscount,
    Change: serviceChange,
    Balance: effectiveCost - serviceAmountPaid,
    PaymentStatus: serviceAmountPaid >= effectiveCost ? 'Paid' : (serviceAmountPaid > 0 ? 'Partially Paid' : 'Unpaid'),
    PaymentMethod: adjustedPaymentMethod,
    ReferenceID: service.ReferenceID || '',
  };
});

  const displayServices = targetPaymentMethod
    ? updatedServices.filter(s => s.PaymentMethod === targetPaymentMethod)
    : updatedServices;

  // Use Balance from backend as the initial TotalAmount for payment
const computedTotalAmount = billing.Balance > 0 ? billing.Balance : displayServices.reduce((sum, s) => {
  const price = s.UpdatedPrice !== null ? Number(s.UpdatedPrice) : Number(s.Cost);
  return sum + price;
}, 0);

// Combine all services into a single service entry for display
const combinedService = {
  ServiceAvailedID: displayServices.map(s => s.ServiceAvailedID).join(','),
  ServiceName: this.getCombinedServiceNames(displayServices),
  Cost: computedTotalAmount,
  BasePrice: computedTotalAmount,
  UpdatedPrice: null,
  AmountPaid: displayServices.reduce((sum, s) => sum + (Number(s.AmountPaid) || 0), 0),
  Discount: displayServices.reduce((sum, s) => sum + (Number(s.Discount) || 0), 0),
  Change: displayServices.reduce((sum, s) => sum + (Number(s.Change) || 0), 0),
  Balance: billing.Balance || 0,
  PaymentStatus: billing.BillingStatus === 'Paid' ? 'Paid' : (billing.BillingStatus === 'Partially Paid' ? 'Partially Paid' : 'Unpaid'),
  PaymentMethod: targetPaymentMethod || billing.PaymentMethod || 'N/A',
  ReferenceID: billing.ReferenceID || '',
};

  this.selectedBilling = JSON.parse(JSON.stringify({
  ...billing,
  BillingID: baseBillingID,
  TotalAmount: billing.Balance > 0 ? billing.Balance : billing.TotalAmount, // Use balance if available, otherwise original amount
  TotalPaid: displayServices.reduce((sum, s) => sum + (Number(s.AmountPaid) || 0), 0),
  Discount: displayServices.reduce((sum, service) => sum + (Number(service.Discount) || 0), 0),
  Balance: billing.Balance || (billing.TotalAmount - 
            displayServices.reduce((sum, s) => sum + (Number(s.AmountPaid) || 0), 0) - 
            displayServices.reduce((sum, s) => sum + (Number(s.Discount) || 0), 0)),
  BillingStatus: billing.BillingStatus || 'Unpaid',
  PaymentMethod: targetPaymentMethod || billing.PaymentMethod || 'N/A',
  ReferenceID: billing.ReferenceID || '',
  ApprovalCode: billing.ApprovalCode || '',
  LOE: billing.LOE || '',
  Change: displayServices.reduce((sum, s) => sum + (Number(s.Change) || 0), 0),
  Remarks: billing.Remarks || '',
  services: [combinedService], // Use single combined service instead of multiple services
  originalServices: updatedServices.map(service => ({
    ServiceAvailedID: service.ServiceAvailedID,
    ServiceName: service.ServiceName,
    Cost: service.Cost,
    Discount: service.Discount || 0,
    UpdatedPrice: service.UpdatedPrice,
  })),
}));

  if (this.shouldShowSharedReferenceInput) {
    const firstReferenceID = this.selectedBilling.services.find(
      service => service.ReferenceID && service.ReferenceID.trim() !== ''
    )?.ReferenceID || '';
    this.sharedReferenceID = firstReferenceID;
  }

  this.initializeReferenceIds();

  this.isInitiallyPaid = billing.BillingStatus === 'Paid';
  this.originalStatus = this.selectedBilling.BillingStatus;
  this.isReferenceEditable = !this.selectedBilling.ReferenceID;
  this.showModal = true;
},

openViewModal(billing) {
  this.isViewOnly = true;
  this.isFromPaidTab = this.activeTab === 'paid';

  // Map services while preserving all properties from the backend
  const updatedServices = billing.services.map(service => ({
    ...service,
    Cost: Number(service.Cost) || 0,
    BasePrice: Number(service.Cost) || 0,
    AmountPaid: Number(service.AmountPaid) || 0,
    Discount: Number(service.Discount) || 0,
    Change: Number(service.Change) || 0,
    Balance: Number(service.Balance) || 0,
    PaymentStatus: service.AmountPaid >= (service.Cost - (service.Discount || 0)) ? 'Paid' : (service.AmountPaid > 0 ? 'Partially Paid' : 'Unpaid'),
    PaymentMethod: service.PaymentMethod || 'N/A', // Ensure PaymentMethod is preserved
    ReferenceID: service.ReferenceID || '', // Ensure ReferenceID is preserved
  }));

  // Populate selectedBilling with the mapped services
  this.selectedBilling = JSON.parse(JSON.stringify({
    ...billing,
    TotalAmount: billing.IsStandalonePayment
      ? billing.TotalPaid
      : updatedServices.reduce((sum, service) => sum + (Number(service.Cost) || 0), 0),
    TotalPaid: updatedServices.reduce((sum, service) => sum + (Number(service.AmountPaid) || 0), 0),
    AmountPaid: billing.AmountPaid || 0, // Use AmountPaid directly from billing
    Discount: updatedServices.reduce((sum, service) => sum + (Number(service.Discount) || 0), 0),
    Balance: Number(billing.Balance) || 0,
    BillingStatus: billing.BillingStatus || 'Paid',
    PaymentMethod: billing.PaymentMethod || 'N/A', // Top-level PaymentMethod (e.g., "Multiple")
    ReferenceID: billing.ReferenceID || '',
    ApprovalCode: billing.ApprovalCode || '',
    LOE: billing.LOE || '',
    Change: updatedServices.reduce((sum, service) => sum + (Number(service.Change) || 0), 0),
    Remarks: billing.Remarks || '',
    services: billing.IsStandalonePayment
      ? [{
          ServiceName: 'Standalone Payment',
          Cost: billing.TotalPaid,
          BasePrice: billing.TotalPaid,
          AmountPaid: billing.TotalPaid,
          Discount: 0,
          Balance: 0,
          PaymentStatus: 'Paid',
          PaymentMethod: billing.PaymentMethod || 'N/A',
          ReferenceID: billing.ReferenceID || '',
          Change: billing.Change || 0,
        }]
      : updatedServices,
    originalServices: updatedServices.map(service => ({
      ServiceAvailedID: service.ServiceAvailedID,
      ServiceName: service.ServiceName,
      Cost: service.Cost,
      Discount: service.Discount || 0,
    })),
    AppointmentDateTime: billing.IsStandalonePayment ? null : billing.AppointmentDateTime,
  }));

  this.isInitiallyPaid = true;
  this.originalStatus = this.selectedBilling.BillingStatus;
  this.isReferenceEditable = !this.selectedBilling.ReferenceID;
  this.showModal = true;
},
    calculateTotalPaid(billing) {
      if (billing.services && billing.services.length > 0) {
        return billing.services.reduce((total, service) => total + (Number(service.AmountPaid) || 0), 0);
      }
      return 0;
    },
    closeModal() {
      this.showModal = false;
      this.isInitiallyPaid = false;
      this.selectedBilling = {
        BillingID: null,
        AppointmentID: null,
        PatientName: '',
        PatientID: '',
        AppointmentDateTime: '',
        AssignedDentist: '',
        Procedure: '',
        TotalAmount: 0,
        TotalPaid: 0,
        PaymentMethod: null,
        AmountPaid: 0,
        Balance: 0,
        BillingStatus: 'Unpaid',
        Discount: 0,
        ReferenceID: '',
        Change: 0,
        Remarks: '',
        services: [],
      };
      this.sharedReferenceID = '';
    },
    calculateTotalBalanceAndStatus() {
      const totalPaid = this.selectedBilling.services.reduce(
        (sum, service) => sum + (Number(service.AmountPaid) || 0),
        0
      );
      this.selectedBilling.TotalPaid = totalPaid;
      const totalAmount = Number(this.selectedBilling.TotalAmount) || 0;
      const discount = this.selectedBilling.services.reduce(
        (sum, service) => sum + (Number(service.Discount) || 0),
        0
      );
      this.selectedBilling.Discount = discount;
      const payableAmount = Math.max(0, totalAmount - discount);
      this.selectedBilling.Balance = Math.max(0, payableAmount - totalPaid);

      const paidService = this.selectedBilling.services
        .filter(s => s.AmountPaid > 0)
        .sort((a, b) => b.AmountPaid - a.AmountPaid)[0];
      const paymentMethod = paidService ? paidService.PaymentMethod : (this.selectedBilling.PaymentMethod || 'N/A');
      const method = this.paymentMethods.find(m => m.MethodName === paymentMethod);
      const methodType = method ? method.MethodType : null;

      // Calculate total Change by summing per-service Change for Cash payments
      const totalChange = this.selectedBilling.services.reduce(
        (sum, service) => sum + (Number(service.Change) || 0),
        0
      );
      this.selectedBilling.Change = totalChange;

      this.selectedBilling.services.forEach(service => {
        const serviceCost = Number(service.Cost) || 0;
        const serviceDiscount = Number(service.Discount) || 0;
        const serviceAmountPaid = Number(service.AmountPaid) || 0;
        const effectiveCost = serviceCost - serviceDiscount;
        if (serviceAmountPaid >= effectiveCost && serviceAmountPaid > 0) {
          service.PaymentStatus = 'Paid';
          service.Balance = 0;
        } else if (serviceAmountPaid > 0) {
          service.PaymentStatus = 'Partially Paid';
          service.Balance = Math.max(0, effectiveCost - serviceAmountPaid);
        } else {
          service.PaymentStatus = 'Unpaid';
          service.Balance = effectiveCost;
        }
      });

      if (this.selectedBilling.Balance > 0) {
        this.selectedBilling.BillingStatus = totalPaid > 0 ? 'Partially Paid' : 'Unpaid';
      } else {
        this.selectedBilling.BillingStatus = 'Paid';
      }
    },
    initializeReferenceIds() {
      this.selectedBilling.services.forEach((service, index) => {
        const method = this.paymentMethods.find(m => m.MethodName === service.PaymentMethod);
        if (!method) {
          return;
        }

        const requiresReferenceId = ['E-Wallet', 'Bank Payment'].includes(method.MethodType);
        if (!requiresReferenceId) {
          return;
        }

        // Find the first previous service with the same payment method and a non-empty Reference ID
        const firstMatchingService = this.selectedBilling.services.find((s, i) => {
          const sMethod = this.paymentMethods.find(m => m.MethodName === s.PaymentMethod);
          return sMethod && sMethod.MethodName === method.MethodName && i < index && s.ReferenceID;
        });

        if (firstMatchingService) {
          service.ReferenceID = firstMatchingService.ReferenceID;
        } else {

        }
      });
    },

    isReferenceIdDisabled(service, currentIndex) {
      if (this.isViewOnly) return true;

      const method = this.paymentMethods.find(m => m.MethodName === service.PaymentMethod);
      if (!method) {    
        return false;
      }

      const requiresReferenceId = ['E-Wallet', 'Bank Payment'].includes(method.MethodType);
      if (!requiresReferenceId) {
        return false;
      }

      // Find a previous service with the same payment method and a non-empty Reference ID
      const firstMatchingService = this.selectedBilling.services.find((s, index) => {
        const sMethod = this.paymentMethods.find(m => m.MethodName === s.PaymentMethod);
        return sMethod && sMethod.MethodName === method.MethodName && index < currentIndex && s.ReferenceID;
      });

      const isDisabled = !!firstMatchingService;
      return isDisabled;
    },

    updateServicePaymentMethod(service) {
      const method = this.paymentMethods.find(m => m.MethodName === service.PaymentMethod);
      if (!method) {
        service.PaymentMethod = '';
        service.ReferenceID = '';
        service.Change = 0;
        service.AmountPaid = 0;
        service.PaymentStatus = 'Unpaid';
        this.calculateServiceBalanceAndChange(service);
        this.calculateTotalBalanceAndStatus();
        return;
      }
      const methodType = method.MethodType;

      // If the payment method requires a Reference ID, check for a previous service with the same method
      const requiresReferenceId = ['E-Wallet', 'Bank Payment'].includes(methodType);
      if (requiresReferenceId) {
        const currentIndex = this.selectedBilling.services.indexOf(service);
        const firstMatchingService = this.selectedBilling.services.find((s, index) => {
          const sMethod = this.paymentMethods.find(m => m.MethodName === s.PaymentMethod);
          return sMethod && sMethod.MethodName === method.MethodName && index < currentIndex;
        });

        if (firstMatchingService) {
          // Copy the Reference ID from the first matching service
          service.ReferenceID = firstMatchingService.ReferenceID;
        }
      }

      // Reset fields if the payment method doesn't require them
      if (!requiresReferenceId) {
        service.ReferenceID = '';
      }
      if (methodType !== 'Cash' || method.MethodName !== 'Cash') {
        service.Change = 0;
      }
      if (methodType === 'Insurance') {
        service.AmountPaid = 0;
        service.PaymentStatus = 'Unpaid';
      }
      this.calculateServiceBalanceAndChange(service);
      this.calculateTotalBalanceAndStatus();
    },
    handleServiceAmountPaidInput(service) {
      if (!service.PaymentMethod || service.PaymentMethod === 'N/A') {
        service.AmountPaid = 0;
        this.openGenericErrorModal('Please select a valid payment method before entering an amount paid.');
        return;
      }

      const method = this.paymentMethods.find(m => m.MethodName === service.PaymentMethod);
      const methodType = method ? method.MethodType : 'Cash';
      const serviceCost = Number(service.Cost) || 0; // Ensure this uses the updated Cost
      const serviceDiscount = Number(service.Discount) || 0;
      const effectiveCost = serviceCost - serviceDiscount;
      let amountPaid = Number(service.AmountPaid) || 0;

      // Validation for E-Wallet and Bank Payment methods
      if (methodType === 'E-Wallet' || methodType === 'Bank Payment') {
        if (amountPaid > effectiveCost) {
          service.AmountPaid = effectiveCost;
          this.openGenericErrorModal(`Amount Paid cannot exceed the Price for ${methodType} methods.`);
          amountPaid = effectiveCost; // Update amountPaid to the capped value
        }
      }

      // Ensure Amount Paid is not negative
      if (amountPaid < 0) {
        service.AmountPaid = 0;
        amountPaid = 0;
      }

      this.calculateServiceBalanceAndChange(service);
      this.calculateTotalBalanceAndStatus();
    },
    calculateServiceBalanceAndChange(service) {
      const serviceCost = Number(service.Cost) || 0;
      const serviceDiscount = Number(service.Discount) || 0;
      const amountPaid = Number(service.AmountPaid) || 0;
      const effectiveCost = serviceCost - serviceDiscount;
      service.Balance = Math.max(0, effectiveCost - amountPaid);
      const method = this.paymentMethods.find(m => m.MethodName === service.PaymentMethod);
      if (method && method.MethodType === 'Cash' && method.MethodName === 'Cash') {
        service.Change = amountPaid > effectiveCost ? amountPaid - effectiveCost : 0;
      } else {
        service.Change = 0;
      }
      if (amountPaid >= effectiveCost && amountPaid > 0) {
        service.PaymentStatus = 'Paid';
      } else if (amountPaid > 0) {
        service.PaymentStatus = 'Partially Paid';
      } else {
        service.PaymentStatus = 'Unpaid';
      }
    },
    shouldShowServiceReferenceInput(service) {
      if (!service.PaymentMethod) return false;
      const method = this.paymentMethods.find(m => m.MethodName === service.PaymentMethod);
      if (!method) return false;
      const methodType = method.MethodType;
      return methodType === 'E-Wallet' || methodType === 'Bank Payment';
    },
    shouldShowServiceChangeInput(service) {
      if (!service.PaymentMethod) return false;
      const method = this.paymentMethods.find(m => m.MethodName === service.PaymentMethod);
      if (!method) return false;
      return method.MethodType === 'Cash' && method.MethodName === 'Cash';
    },
    getServiceReferenceIdPlaceholder(methodName) {
      if (!methodName) return 'Enter Reference ID';
      const method = this.paymentMethods.find(m => m.MethodName === methodName);
      if (!method) return 'Enter Reference ID';
      const methodType = method.MethodType;
      if (methodType === 'E-Wallet' || methodType === 'Bank Payment') {
        return 'Enter 12-13 character Reference ID (e.g., REF1234567890)';
      }
      return 'Enter Reference ID';
    },
    getServiceReferenceIdMaxLength(methodName) {
      if (!methodName) return 13;
      const method = this.paymentMethods.find(m => m.MethodName === methodName);
      if (!method) return 13;
      const methodType = method.MethodType;
      if (methodType === 'E-Wallet' || methodType === 'Bank Payment') {
        return 13;
      }
      return 13;
    },
    validateServiceReferenceID(service) {
      if (!service.PaymentMethod) return;
      const method = this.paymentMethods.find(m => m.MethodName === service.PaymentMethod);
      if (!method) return;
      let value = service.ReferenceID || '';
      const methodType = method.MethodType;

      if (['E-Wallet', 'Bank Payment'].includes(methodType)) {
        value = value.replace(/[^A-Za-z0-9]/g, '').slice(0, 13);
      }
      service.ReferenceID = value;

      // If this payment method requires a Reference ID, update all subsequent services with the same method
      const requiresReferenceId = ['E-Wallet', 'Bank Payment'].includes(methodType);
      if (requiresReferenceId) {
        const currentIndex = this.selectedBilling.services.indexOf(service);
        this.selectedBilling.services.forEach((s, index) => {
          const sMethod = this.paymentMethods.find(m => m.MethodName === s.PaymentMethod);
          if (index > currentIndex && sMethod && sMethod.MethodName === method.MethodName) {
            s.ReferenceID = value;
          }
        });
      }
    },

    validateSelectedApprovalCode() {
  const value = this.selectedBilling.ApprovalCode || '';
  let isValid = true;
  let errorMessage = '';

  if (this.selectedBilling.PaymentMethod === 'Medicard') {
    // Medicard: 2 letters, space, 5-7 digits (e.g., "AB 12345")
    const medicardRegex = /^[A-Z]{2}\s\d{5,7}$/;
    if (!medicardRegex.test(value)) {
      isValid = false;
      errorMessage = 'Approval Code for Medicard must be 2 letters, a space, then 5-7 digits (e.g., AB 12345)';
    }
  } else if (this.selectedBilling.PaymentMethod === 'Maxicare') {
    // Maxicare: 8-9 digits (e.g., "123456789")
    const maxicareRegex = /^\d{8,9}$/;
    if (!maxicareRegex.test(value)) {
      isValid = false;
      errorMessage = 'Approval Code for Maxicare must be 8-9 digits (e.g., 123456789)';
    }
  }

  this.selectedApprovalCodeError = isValid ? '' : errorMessage;

  // If the ApprovalCode is valid and LOE (if required) is valid, set status to Paid
  if (isValid && (this.selectedBilling.PaymentMethod !== 'Maxicare' || (this.selectedBilling.PaymentMethod === 'Maxicare' && !this.selectedLOEError && this.selectedBilling.LOE))) {
    this.selectedBilling.BillingStatus = 'Paid';
    this.selectedBilling.TotalPaid = this.selectedBilling.TotalAmount - (Number(this.selectedBilling.Discount) || 0);
    this.selectedBilling.Balance = 0;
    this.selectedBilling.services.forEach(service => {
      if (this.insuranceProviders.some(p => p.MethodName === service.PaymentMethod)) {
        // Distribute TotalAmount across services (adjust logic if multiple services)
        service.AmountPaid = this.selectedBilling.TotalAmount / this.selectedBilling.services.length;
        service.Balance = 0;
        service.PaymentStatus = 'Paid';
      }
    });
  } else {
    // If ApprovalCode is invalid or removed, revert to Unpaid
    this.selectedBilling.BillingStatus = 'Unpaid';
    this.selectedBilling.TotalPaid = 0;
    this.selectedBilling.Balance = this.selectedBilling.TotalAmount - (Number(this.selectedBilling.Discount) || 0);
    this.selectedBilling.services.forEach(service => {
      if (this.insuranceProviders.some(p => p.MethodName === service.PaymentMethod)) {
        service.AmountPaid = 0;
        service.Balance = service.Cost - (Number(service.Discount) || 0);
        service.PaymentStatus = 'Unpaid';
      }
    });
  }
},

validateSelectedLOE() {
  const value = this.selectedBilling.LOE || '';
  const maxicareRegex = /^\d{8,9}$/;
  if (!maxicareRegex.test(value)) {
    this.selectedLOEError = 'LOE # for Maxicare must be 8-9 digits (e.g., 987654321)';
  } else {
    this.selectedLOEError = '';
  }

  // If the LOE is valid and ApprovalCode is valid, set status to Paid
  if (!this.selectedLOEError && this.selectedBilling.ApprovalCode && !this.selectedApprovalCodeError) {
    this.selectedBilling.BillingStatus = 'Paid';
    this.selectedBilling.TotalPaid = this.selectedBilling.TotalAmount - (Number(this.selectedBilling.Discount) || 0);
    this.selectedBilling.Balance = 0;
    this.selectedBilling.services.forEach(service => {
      if (this.insuranceProviders.some(p => p.MethodName === service.PaymentMethod)) {
        service.AmountPaid = this.selectedBilling.TotalAmount / this.selectedBilling.services.length;
        service.Balance = 0;
        service.PaymentStatus = 'Paid';
      }
    });
  } else {
    // If LOE is invalid, revert to Unpaid
    this.selectedBilling.BillingStatus = 'Unpaid';
    this.selectedBilling.TotalPaid = 0;
    this.selectedBilling.Balance = this.selectedBilling.TotalAmount - (Number(this.selectedBilling.Discount) || 0);
    this.selectedBilling.services.forEach(service => {
      if (this.insuranceProviders.some(p => p.MethodName === service.PaymentMethod)) {
        service.AmountPaid = 0;
        service.Balance = service.Cost - (Number(service.Discount) || 0);
        service.PaymentStatus = 'Unpaid';
      }
    });
  }
},

async updateBilling() {
  try {
    this.isUpdating = true;

    const hasNegativePrice = this.selectedBilling.services.some(service => {
      const price = service.UpdatedPrice !== null ? Number(service.UpdatedPrice) : Number(service.Cost);
      return price < 0;
    });

    if (hasNegativePrice) {
      this.showNegativePriceModal = true;
      this.selectedBilling.services.forEach(service => {
        const price = service.UpdatedPrice !== null ? Number(service.UpdatedPrice) : Number(service.Cost);
        if (price < 0) {
          service.Cost = service.BasePrice;
          service.UpdatedPrice = null;
          this.$nextTick(() => {
            const input = document.querySelector(`input[value="${price}"]`);
            if (input) input.value = service.BasePrice.toString();
          });
        }
      });
      this.updateTotalAmount();
      return;
    }

    const totalAmount = Number(this.selectedBilling.TotalAmount);
    if (!Number.isInteger(totalAmount) || totalAmount < 0) {
      this.referenceIdErrorMessage = 'The Total Amount must be a whole number (e.g., 1000, 5000).';
      this.showReferenceIdErrorModal = true;
      return;
    }

    const hasInsuranceService = this.selectedBilling.services.some(service =>
      this.insuranceProviders.some(p => p.MethodName === service.PaymentMethod)
    );

    let totalAmountPaid = 0;
    let approvalCode = null;
    let loe = null;
    const isInsuranceTab = this.activeTab === 'insurance';

    this.selectedBilling.services.forEach(service => {
      const serviceCost = Number(service.Cost) || 0;
      const serviceDiscount = Number(service.Discount) || 0;
      const serviceAmountPaid = Number(service.AmountPaid) || 0;
      const effectiveCost = serviceCost - serviceDiscount;

      if (serviceAmountPaid >= effectiveCost && serviceAmountPaid > 0) {
        service.PaymentStatus = 'Paid';
        service.Balance = 0;
      } else if (serviceAmountPaid > 0) {
        service.PaymentStatus = 'Partially Paid';
        service.Balance = effectiveCost - serviceAmountPaid;
      } else {
        service.PaymentStatus = 'Unpaid';
        service.Balance = effectiveCost;
      }

      totalAmountPaid += serviceAmountPaid;
    });

    if (this.shouldShowSharedReferenceInput) {
      this.selectedBilling.services.forEach(service => {
        service.ReferenceID = this.sharedReferenceID;
      });
    }

    const paidServices = this.selectedBilling.services.filter(service => service.AmountPaid > 0);
    for (const service of paidServices) {
      const method = this.paymentMethods.find(m => m.MethodName === service.PaymentMethod);
      const methodType = method ? method.MethodType : 'Cash';
      if ((methodType === 'E-Wallet' || methodType === 'Bank Payment') && !service.ReferenceID) {
        this.referenceIdErrorMessage = 'Please enter a Reference ID for this payment method.';
        this.showReferenceIdErrorModal = true;
        return;
      }
      if (methodType === 'E-Wallet' || methodType === 'Bank Payment') {
        const isValidReferenceID = /^[A-Za-z0-9]{12,13}$/.test(service.ReferenceID);
        if (!isValidReferenceID) {
          this.referenceIdErrorMessage = 'Please enter a valid 12-13 character alphanumeric Reference ID.';
          this.showReferenceIdErrorModal = true;
          return;
        }
      }
    }

    if (isInsuranceTab) {
      const requiresInsuranceValidation = this.selectedBilling.services.some(service =>
        this.insuranceProviders.some(p => p.MethodName === service.PaymentMethod) && service.PaymentStatus === 'Paid'
      );

      if (hasInsuranceService && requiresInsuranceValidation) {
        if (!this.isSelectedInsuranceFormValid) {
          this.referenceIdErrorMessage = 'Please correct the errors in the insurance reference inputs before updating.';
          this.showReferenceIdErrorModal = true;
          return;
        }

        const insuranceServiceBeingPaid = this.selectedBilling.services.find(service =>
          this.insuranceProviders.some(p => p.MethodName === service.PaymentMethod) && service.PaymentStatus === 'Paid'
        );

        if (insuranceServiceBeingPaid) {
          approvalCode = this.selectedBilling.ApprovalCode || null;
          loe = insuranceServiceBeingPaid.PaymentMethod === 'Maxicare' ? this.selectedBilling.LOE || null : null;

          if (!approvalCode) {
            this.referenceIdErrorMessage = 'Approval Code is required for insurance payments when marking as paid.';
            this.showReferenceIdErrorModal = true;
            return;
          }
        }
      }
    }

    const allServicesPaid = this.selectedBilling.services.every(service => service.PaymentStatus === 'Paid');
    const anyServicePaid = this.selectedBilling.services.some(service => service.PaymentStatus === 'Paid' || service.PaymentStatus === 'Partially Paid');
    this.selectedBilling.BillingStatus = allServicesPaid ? 'Paid' : (anyServicePaid ? 'Partially Paid' : 'Unpaid');

    const billingIdStr = String(this.selectedBilling.BillingID);
    let baseBillingID = billingIdStr;
    let suffix = '';
    if (billingIdStr.includes('_insurance')) {
      suffix = '_insurance';
      baseBillingID = billingIdStr.replace('_insurance', '');
    } else if (billingIdStr.includes('_nonInsurance')) {
      suffix = '_nonInsurance';
      baseBillingID = billingIdStr.replace('_nonInsurance', '');
    } else if (billingIdStr.includes('_PM_') || billingIdStr.includes('_S_')) {
      baseBillingID = billingIdStr.split(/_PM_|_S_/)[0];
    }

    const serviceGroups = {};
    this.selectedBilling.services.forEach((service, index) => {
      const paymentMethod = service.PaymentMethod || 'N/A';
      const isInsurance = this.insuranceProviders.some(p => p.MethodName === paymentMethod);
      const groupKey = isInsurance ? paymentMethod : 'non-insurance';
      if (!serviceGroups[groupKey]) {
        serviceGroups[groupKey] = [];
      }
      serviceGroups[groupKey].push({ ...service, Index: index });
    });

    const updatedBillings = [];
    let groupIndex = 0;

    for (const [groupKey, groupServices] of Object.entries(serviceGroups)) {
      const isInsuranceGroup = groupKey !== 'non-insurance';
      const newBillingID = groupIndex === 0 ? `${baseBillingID}${suffix}` : `${baseBillingID}_S_${groupIndex}`;
      groupIndex++;

      // Use Balance as the reference total for payment updates
      const groupTotalAmount = this.selectedBilling.Balance > 0 ? this.selectedBilling.Balance : groupServices.reduce((sum, s) => sum + Number(s.Cost), 0);
      const groupTotalPaid = groupServices.reduce((sum, s) => sum + Number(s.AmountPaid), 0);
      const groupDiscount = groupServices.reduce((sum, s) => sum + Number(s.Discount), 0);
      const groupBalance = this.selectedBilling.Balance || (groupTotalAmount - groupTotalPaid - groupDiscount);

      const primaryPaymentMethod = groupServices[0].PaymentMethod;
      const primaryReferenceID = groupServices[0].ReferenceID || null;

      const groupApprovalCode = isInsuranceGroup ? this.selectedBilling.ApprovalCode : null;
      const groupLOE = isInsuranceGroup && primaryPaymentMethod === 'Maxicare' ? this.selectedBilling.LOE : null;

      const payload = {
    TotalAmount: this.selectedBilling.TotalAmount, // Original 9k
    Discount: this.selectedBilling.Discount,
    AmountPaid: groupTotalPaid,
    Balance: groupBalance,
    PaymentMethod: primaryPaymentMethod,
    ReferenceID: primaryReferenceID,
    ApprovalCode: groupApprovalCode,
    LOE: groupLOE,
    Change: groupServices.reduce((sum, s) => sum + (Number(s.Change) || 0), 0),
    Remarks: this.selectedBilling.Remarks || null,
    activeTab: isInsuranceGroup ? 'insurance' : this.activeTab,
    services: groupServices.map(service => {
  // Handle combined services (multiple ServiceAvailedIDs)
  const serviceAvailedIds = service.ServiceAvailedID.toString().includes(',') 
    ? service.ServiceAvailedID.toString().split(',')
    : [service.ServiceAvailedID];
  
  return serviceAvailedIds.map(id => ({
    ServiceAvailedID: id.trim(),
    ServiceName: service.ServiceName,
    Cost: Number(service.Cost) / serviceAvailedIds.length, // Distribute cost evenly
    UpdatedPrice: service.UpdatedPrice !== null ? Number(service.UpdatedPrice) / serviceAvailedIds.length : null,
    Discount: (Number(service.Discount) || 0) / serviceAvailedIds.length,
    AmountPaid: (Number(service.AmountPaid) || 0) / serviceAvailedIds.length,
    PaymentMethod: service.PaymentMethod,
    ReferenceID: service.ReferenceID || null,
    Balance: service.Balance / serviceAvailedIds.length,
    PaymentStatus: service.PaymentStatus,
    Change: (Number(service.Change) || 0) / serviceAvailedIds.length,
  }));
}).flat(),
      };

      const response = await axios.put(`/hr/billings/${newBillingID}`, payload, { withCredentials: true });

      if (response.status === 200) {
        const updatedBilling = {
          ...response.data.billing,
          BillingID: String(response.data.billing.BillingID) + suffix,
          PatientName: this.selectedBilling.PatientName,
          AppointmentDateTime: this.selectedBilling.AppointmentDateTime,
          Procedure: response.data.billing.Procedure || groupServices.map(s => s.ServiceName).join(', '),
          Amount: groupTotalAmount,
          TotalAmount: groupTotalAmount,
          TotalPaid: groupTotalPaid,
          Balance: groupBalance,
          BillingStatus: response.data.billing.BillingStatus,
          services: response.data.billing.services,
          IsStandalonePayment: false,
        };
        updatedBillings.push(updatedBilling);
      }
    }

    this.allBillings = this.allBillings.filter(b => String(b.BillingID) !== `${baseBillingID}${suffix}`);
    this.allBillings.push(...updatedBillings);

    this.showModal = false;
    this.$emit('billing-updated');

    if (hasInsuranceService) {
      this.activeTab = 'insurance';
    } else if (allServicesPaid) {
      this.activeTab = 'paid';
    }
  } catch (error) {
    console.error('Error updating billing:', error);
    this.referenceIdErrorMessage = 'Failed to update billing: ' + (error.response?.data?.message || error.message);
    this.showReferenceIdErrorModal = true;
  } finally {
    this.isUpdating = false;
  }
},
    async fetchPatientsWithBalances() {
      this.isLoadingPatients = true;
      try {
        const response = await axios.get('/hr/patients-with-balances', {
          withCredentials: true,
          params: { _t: new Date().getTime() },
        });
        this.patientsWithBalances = response.data;
      } catch (error) {
        console.error("Error fetching patients with balances:", error);
        this.patientsWithBalances = [];
        const errorMessage = error.response?.data?.message || error.message || 'Failed to fetch patients with balances. Please try again later.';
        this.openGenericErrorModal(errorMessage);
      } finally {
        this.isLoadingPatients = false;
      }
    },
    openAddPaymentModal() {
      this.newPayment = {
        PatientID: '',
        CurrentBalance: 0,
        AmountPaid: 0,
        PaymentMethod: '',
        ReferenceID: '',
        Change: 0,
      };
      this.showNewPaymentReferenceInput = false;
      this.showNewPaymentChangeInput = false;
      this.showAddPaymentModal = true;
      this.fetchPatientsWithBalances();
    },
    closeAddPaymentModal() {
      this.showAddPaymentModal = false;
      this.newPayment = {
        PatientID: '',
        CurrentBalance: 0,
        AmountPaid: 0,
        PaymentMethod: '',
        ReferenceID: '',
        Change: 0,
      };
    },
    updatePatientBalance() {
      const patient = this.patientsWithBalances.find(p => p.PatientID === this.newPayment.PatientID);
      this.newPayment.CurrentBalance = patient ? patient.Balance : 0;
      this.calculateNewPaymentChange();
    },
    updateNewPaymentReferenceAndChangeVisibility() {
      const method = this.paymentMethods.find(m => m.MethodName === this.newPayment.PaymentMethod);
      const methodType = method ? method.MethodType : 'Cash';
      const methodName = method ? method.MethodName : this.newPayment.PaymentMethod;
      this.showNewPaymentReferenceInput = methodType === 'E-Wallet' || methodType === 'Bank Payment';
      this.showNewPaymentChangeInput = methodType === 'Cash' && methodName === 'Cash';
      if (methodType === 'Insurance' && this.insuranceProviders.some(p => p.MethodName === this.newPayment.PaymentMethod)) {
        this.newPayment.AmountPaid = 0;
      }
      if (!this.showNewPaymentReferenceInput) {
        this.newPayment.ReferenceID = '';
      }
      if (!this.showNewPaymentChangeInput) {
        this.newPayment.Change = 0;
      }
      this.calculateNewPaymentChange();
    },
    validateNewPaymentReferenceID() {
      if (!this.newPayment.PaymentMethod) return;
      const method = this.paymentMethods.find(m => m.MethodName === this.newPayment.PaymentMethod);
      if (!method) return;
      let value = this.newPayment.ReferenceID || '';
      const methodType = method.MethodType;
      if (methodType === 'E-Wallet' || methodType === 'Bank Payment') {
        value = value.replace(/[^A-Za-z0-9]/g, '').slice(0, 13);
      }
      this.newPayment.ReferenceID = value;
    },
    handleNewPaymentAmountInput() {
      if (!this.newPayment.PaymentMethod || this.newPayment.PaymentMethod === 'N/A') {
        this.newPayment.AmountPaid = 0;
        this.openGenericErrorModal('Please select a valid payment method before entering an amount paid.');
      }
      if (this.newPayment.AmountPaid < 0) {
        this.newPayment.AmountPaid = 0;
      }
      if (this.newPayment.AmountPaid > this.newPayment.CurrentBalance && !this.showNewPaymentChangeInput) {
        this.newPayment.AmountPaid = this.newPayment.CurrentBalance;
        this.openGenericErrorModal('Amount Paid cannot exceed the current balance unless using Cash payment.');
      }
      this.calculateNewPaymentChange();
    },
    async addPayment() {
  this.isSubmittingPayment = true;
  const method = this.paymentMethods.find(m => m.MethodName === this.newPayment.PaymentMethod);
  const methodType = method ? method.MethodType : 'Cash';
  const patient = this.patientsWithBalances.find(p => p.PatientID === this.newPayment.PatientID);
  const currentBalance = patient ? patient.Balance : 0;
  const isCashPayment = methodType === 'Cash';

  // Validate payment amount
  if (this.newPayment.AmountPaid > currentBalance && !isCashPayment) {
    this.referenceIdErrorMessage = 'Payment amount cannot exceed the current balance unless using Cash payment.';
    this.showReferenceIdErrorModal = true;
    this.isSubmittingPayment = false;
    return;
  }

  // Validate payment method and reference ID
  if (this.newPayment.AmountPaid > 0) {
    if (!this.newPayment.PaymentMethod || this.newPayment.PaymentMethod === 'N/A') {
      this.referenceIdErrorMessage = 'Please select a valid payment method.';
      this.showReferenceIdErrorModal = true;
      this.isSubmittingPayment = false;
      return;
    }
    if (methodType === 'E-Wallet' || methodType === 'Bank Payment') {
      if (!this.newPayment.ReferenceID) {
        this.referenceIdErrorMessage = 'Please enter a Reference ID for this payment method.';
        this.showReferenceIdErrorModal = true;
        this.isSubmittingPayment = false;
        return;
      }
      const isValidReferenceID = /^[A-Za-z0-9]{12,13}$/.test(this.newPayment.ReferenceID);
      if (!isValidReferenceID) {
        this.referenceIdErrorMessage = 'Please enter a valid 12-13 character alphanumeric Reference ID.';
        this.showReferenceIdErrorModal = true;
        this.isSubmittingPayment = false;
        return;
      }
    }
  }

  try {
    const response = await axios.post(
      '/hr/billings/add-payment-without-appointment',
      {
        PatientID: this.newPayment.PatientID,
        AmountPaid: this.newPayment.AmountPaid,
        PaymentMethod: this.newPayment.PaymentMethod,
        ReferenceID: this.newPayment.ReferenceID || null,
        Change: this.newPayment.Change || 0,
      },
      { withCredentials: true }
    );

    // Update the existing billing in allBillings with the updated data
    const updatedBilling = response.data.billing;
    const billingIdStr = String(updatedBilling.BillingID);
    const index = this.allBillings.findIndex(b => String(b.BillingID) === billingIdStr);

    if (index !== -1) {
      // Update the existing billing
      this.allBillings[index] = {
        ...this.allBillings[index],
        ...updatedBilling,
        PatientName: patient ? patient.FullName : this.allBillings[index].PatientName,
        TotalAmount: Number(updatedBilling.TotalAmount) || 0,
        AmountPaid: Number(updatedBilling.AmountPaid) || 0,
        Balance: Number(updatedBilling.Balance) || 0,
        BillingStatus: updatedBilling.BillingStatus,
        services: updatedBilling.services.map(service => ({
          ...service,
          Cost: Number(service.Cost) || 0,
          AmountPaid: Number(service.AmountPaid) || 0,
          Discount: Number(service.Discount) || 0,
          Balance: Number(service.Balance) || 0,
          PaymentStatus: service.PaymentStatus || (service.AmountPaid >= (service.Cost - (service.Discount || 0)) ? 'Paid' : (service.AmountPaid > 0 ? 'Partially Paid' : 'Unpaid')),
          PaymentMethod: service.PaymentMethod || 'N/A',
          ReferenceID: service.ReferenceID || '',
          Change: Number(service.Change) || 0,
        })),
        PaymentDate: updatedBilling.PaymentDate || this.allBillings[index].PaymentDate,
      };
    } else {
      // If the billing isn't in allBillings, fetch all billings to ensure consistency
      await this.fetchBillings();
    }

    // Switch tabs based on the updated billing status
    if (updatedBilling.BillingStatus === 'Paid' || updatedBilling.BillingStatus === 'Partially Paid') {
      this.activeTab = 'paid';
    }

    this.showSuccessModal = true;
    this.closeAddPaymentModal();
    await this.fetchPatientsWithBalances();
  } catch (error) {
    console.error('Error adding payment:', error);
    let errorMessage = 'Failed to add payment';
    if (error.response?.data?.message) {
      if (error.response.data.message.includes('The Reference ID has already been used')) {
        errorMessage = 'The Reference ID has already been used. Please use a unique Reference ID.';
      } else if (error.response.data.message.includes('Payment amount cannot exceed')) {
        errorMessage = 'Payment amount cannot exceed the current balance unless using Cash payment.';
      } else if (error.response.data.message.includes('Invalid patient ID')) {
        errorMessage = 'Invalid patient selected. Please select a valid patient.';
      } else if (error.response.data.message.includes('No unpaid billing found')) {
        errorMessage = 'No unpaid billing found to apply this payment to.';
      } else {
        errorMessage = `Failed to add payment: ${error.response.data.message}`;
      }
    } else {
      errorMessage = `Failed to add payment: ${error.message}`;
    }
    this.openGenericErrorModal(errorMessage);
  } finally {
    this.isSubmittingPayment = false;
  }
},
    calculateNewPaymentChange() {
      const currentBalance = Number(this.newPayment.CurrentBalance) || 0;
      const amountPaid = Number(this.newPayment.AmountPaid) || 0;
      if (this.showNewPaymentChangeInput) {
        this.newPayment.Change = amountPaid > currentBalance ? amountPaid - currentBalance : 0;
      } else {
        this.newPayment.Change = 0;
      }
    },
    closeSuccessModal() {
      this.showSuccessModal = false;
      this.fetchBillings();
    },
    closeReferenceIdErrorModal() {
      this.showReferenceIdErrorModal = false;
      this.referenceIdErrorMessage = '';
    },
    openGenericErrorModal(message) {
      this.genericErrorMessage = message;
      this.showGenericErrorModal = true;
    },
    closeGenericErrorModal() {
      this.showGenericErrorModal = false;
      this.genericErrorMessage = '';
    },
    handleServiceCostChange(service) {
      if (service.Cost < 0) {
        service.Cost = 0;
      }
      this.selectedBilling.TotalAmount = this.selectedBilling.services.reduce(
        (sum, s) => sum + (Number(s.Cost) || 0),
        0
      );
      this.calculateServiceBalanceAndChange(service);
      this.calculateTotalBalanceAndStatus();
    },
    getServicePrice(service) {
      // Return UpdatedPrice if it exists, otherwise fall back to Cost
      return service.UpdatedPrice !== null && service.UpdatedPrice !== undefined
        ? Number(service.UpdatedPrice)
        : Number(service.Cost);
    },

    setServicePrice(service, value) {
  let newPrice = Number(value);
  
  if (newPrice < 0) {
    this.showNegativePriceModal = true;
    service.Cost = service.BasePrice;
    service.UpdatedPrice = null;
    this.$nextTick(() => {
      const input = document.querySelector(`input[value="${value}"]`);
      if (input) {
        input.value = service.BasePrice.toString();
      }
    });
  } else {
    const originalCost = Number(service.BasePrice);
    if (Math.abs(newPrice - originalCost) > 0.01) {
      service.UpdatedPrice = newPrice;
    } else {
      service.UpdatedPrice = null;
    }
    service.Cost = newPrice;
  }

  this.calculateServiceBalanceAndChange(service);
  this.updateTotalAmount();
},
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
}

.sidebar.close .profile-details {
  background: none;
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

/* New styles for service-based payment */
.service-detail {
  background-color: #f9f9f9;
  border-radius: 8px;
  padding: 15px;
  margin-bottom: 15px;
  border: 1px solid #e0e0e0;
  transition: all 0.2s ease;
}

.service-detail:hover {
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.service-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 12px;
  flex-wrap: wrap;
  gap: 10px;
}

.service-name {
  font-weight: 600;
  color: #333;
  font-size: 16px;
  flex: 1;
}

.service-cost {
  font-weight: 500;
  color: #06693a;
  margin-right: 10px;
  display: flex;
  align-items: center;
}

.service-controls {
  margin-top: 15px;
}

.service-payment-row {
  display: flex;
  gap: 15px;
  margin-bottom: 12px;
  flex-wrap: wrap;
}

.service-payment-method,
.service-amount-paid,
.service-reference,
.service-balance,
.service-change {
  flex: 1;
  min-width: 200px;
}

.service-payment-row label {
  display: block;
  font-weight: 500;
  color: #555;
  font-size: 14px;
  margin-bottom: 5px;
}

.service-payment-row select,
.service-payment-row input {
  width: 100%;
  padding: 8px 12px;
  border: 1px solid #e0e0e0;
  border-radius: 6px;
  font-size: 14px;
  transition: all 0.2s ease;
}

.service-payment-row select:focus,
.service-payment-row input:focus {
  border-color: #06693A;
  outline: none;
  box-shadow: 0 0 0 2px rgba(6, 105, 58, 0.1);
}

.no-services {
  text-align: center;
  padding: 20px;
  color: #666;
  font-style: italic;
  background-color: #f5f5f5;
  border-radius: 6px;
}

/* Responsive adjustments for service payment */
@media (max-width: 768px) {
  .service-payment-row {
    flex-direction: column;
    gap: 10px;
  }
  
  .service-payment-method,
  .service-amount-paid,
  .service-reference,
  .service-balance,
  .service-change {
    min-width: 100%;
  }
  
  .service-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 5px;
  }
  
  .service-cost {
    margin-right: 0;
  }
}

/* Toggle Buttons */
.toggle-buttons {
  display: flex;
  gap: 15px;
  margin: 20px;
  justify-content: center;
}

.toggle-btn {
  padding: 10px 20px;
  background-color: white;
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  cursor: pointer;
  font-size: 14px;
  font-weight: 500;
  display: flex;
  align-items: center;
  gap: 8px;
  transition: all 0.3s ease;
  color: #555;
}

.toggle-btn i {
  color: #06693A;
  font-size: 16px;
}

.toggle-btn.active {
  background-color: #06693A;
  color: white;
  border-color: #06693A;
}

.toggle-btn.active i {
  color: white;
}

.toggle-btn:hover:not(.active) {
  background-color: #f5f5f5;
}

/* Billing Tables and Cards */
.billing-container {
  margin: 20px;
  background-color: white;
  border-radius: 12px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
  overflow: hidden;
}

.billing {
  padding: 20px 25px 0;
  border-bottom: 1px solid #f0f0f0;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.billing h3 {
  font-size: 18px;
  color: #333;
  font-weight: 600;
  margin: 0;
  padding-bottom: 15px;
}

.table-wrapper {
  padding: 0;
}

.billing-table {
  width: 100%;
  border-collapse: collapse;
  background-color: white;
}

.billing-table th,
.billing-table td {
  padding: 12px 10px; /* Reduced from 16px to 12px vertical, 10px horizontal for better fit */
  text-align: left;
  border-bottom: 1px solid #f5f5f5;
  color: #333;
  font-size: 14px;
}

.billing-table th {
  color: #06693A;
  font-weight: 600;
  font-size: 14px;
  background-color: #f9f9f9;
}

/* Widths for Paid Table (6 columns) */
.billing-table.paid-table th:nth-child(1),
.billing-table.paid-table td:nth-child(1) {
  width: 20%; /* Patient Name */
}

.billing-table.paid-table th:nth-child(2),
.billing-table.paid-table td:nth-child(2) {
  width: 20%; /* Appointment Date/Time */
}

.billing-table.paid-table th:nth-child(3),
.billing-table.paid-table td:nth-child(3) {
  width: 17%; /* Procedure */
}

.billing-table.paid-table th:nth-child(4),
.billing-table.paid-table td:nth-child(4) {
  width: 13%; /* Amount Paid */
}

.billing-table.paid-table th:nth-child(5),
.billing-table.paid-table td:nth-child(5) {
  width: 16%; /* Remaining Balance */
}

.billing-table.paid-table th:nth-child(6),
.billing-table.paid-table td:nth-child(6) {
  width: 14%; /* Actions */
}

/* Widths for Unpaid and Paid Tables (5 columns) */
.billing-table.unpaid-table th:nth-child(1),
.billing-table.unpaid-table td:nth-child(1){
  width: 20%; /* Patient Name */
}

.billing-table.unpaid-table th:nth-child(2),
.billing-table.unpaid-table td:nth-child(2) {
  width: 25%; /* Appointment Date/Time */
}

.billing-table.unpaid-table th:nth-child(3),
.billing-table.unpaid-table td:nth-child(3) {
  width: 25%; /* Procedure */
}

.billing-table.unpaid-table th:nth-child(4),
.billing-table.unpaid-table td:nth-child(4) {
  width: 15%; /* Amount */
}

.billing-table.unpaid-table th:nth-child(5),
.billing-table.unpaid-table td:nth-child(5) {
  width: 15%; /* Actions */
}

/* Widths for Insurance Payout Table (7 columns) */
.billing-table.insurance-table th:nth-child(1),
.billing-table.insurance-table td:nth-child(1) {
  width: 15%; /* Checkbox - made narrower */
}

.billing-table.insurance-table th:nth-child(2),
.billing-table.insurance-table td:nth-child(2) {
  width: 15%; /* Patient Name - adjusted to fit after the narrow checkbox */
}

.billing-table.insurance-table th:nth-child(3),
.billing-table.insurance-table td:nth-child(3) {
  width: 15%; /* Appointment Date/Time - increased for more space */
}

.billing-table.insurance-table th:nth-child(4),
.billing-table.insurance-table td:nth-child(4) {
  width: 10%; /* Procedure - increased for more space */
}

.billing-table.insurance-table th:nth-child(5),
.billing-table.insurance-table td:nth-child(5) {
  width: 10%; /* Amount - slightly increased */
}

.billing-table.insurance-table th:nth-child(6),
.billing-table.insurance-table td:nth-child(6) {
  width: 10%; /* Insurance - slightly increased */
}

.billing-table.insurance-table th:nth-child(7),
.billing-table.insurance-table td:nth-child(7) {
  width: 10%; /* Status - slightly increased */
}

.billing-table.insurance-table th:nth-child(8),
.billing-table.insurance-table td:nth-child(8) {
  width: 10%; /* Actions - reduced to balance the total width */
}

.billing-row {
  cursor: pointer;
  transition: background-color 0.2s;
}

.billing-row:hover {
  background-color: #f9f9f9;
}

.paid-row {
  background-color: #f0f7f3;
  cursor: default;
}

.paid-row:hover {
  background-color: #e8f5ed;
}

.billing-table tr:last-child td {
  border-bottom: none;
}

.no-data {
  text-align: center;
  color: #757575;
  padding: 30px !important;
}

/* Status Badges */
.status-badge {
  display: inline-block;
  padding: 4px 10px;
  border-radius: 20px;
  font-size: 12px;
  font-weight: 500;
  text-align: center;
  min-width: 80px;
}

.status-badge.paid {
  background-color: #e6f7ee;
  color: #0d904b;
}

.status-badge.partial {
  background-color: #fff8e6;
  color: #e6a700;
}

.status-badge.unpaid {
  background-color: #ffebee;
  color: #d32f2f;
}

.status-badge-container {
  display: flex;
  align-items: center;
}

/* Mobile Cards */
.mobile-cards {
  display: none;
  padding: 15px;
}

.billing-card {
  background-color: white;
  border-radius: 12px;
  border: 1px solid #e0e0e0;
  margin-bottom: 16px;
  overflow: hidden;
  cursor: pointer;
  transition: transform 0.2s, box-shadow 0.2s;
}

.billing-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.paid-card {
  background-color: #f0f7f3;
  cursor: default;
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

.card-actions {
  display: flex;
  gap: 8px;
}

.card-content {
  padding: 16px;
}

.card-row {
  margin-bottom: 12px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.card-label {
  font-weight: 500;
  color: #666;
  font-size: 14px;
}

.edit-button {
  background-color: #06693A;
  border: none;
  padding: 6px 12px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 14px;
  color: white;
  width: auto;
  min-width: 60px;
  display: flex;
  align-items: center;
  gap: 5px;
  justify-content: center;
}

.edit-button:hover {
  background-color: #055a32;
}

.edit-button-mobile {
  background-color: #06693A;
  border: none;
  padding: 6px 12px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 13px;
  color: white;
  display: flex;
  align-items: center;
  gap: 5px;
}

.edit-button-mobile:hover {
  background-color: #055a32;
}

.edit-button-mobile i {
  font-size: 14px;
}

.no-data-mobile {
  text-align: center;
  color: #757575;
  padding: 30px;
  background-color: white;
  border-radius: 12px;
  border: 1px solid #e0e0e0;
}

/* Search and Filter */
.search-wrapper {
  width: 97%;
  margin-left: 20px;
  display: flex;
  align-items: center;
  margin-top: 20px;
}

.search-container {
  position: relative;
  width: 100%;
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

.negative-price-modal-overlay {
  z-index: 1050 !important; /* Higher than the default modal-overlay z-index (assumed to be 1000) */
}

.reference-id-error-modal-overlay {
  z-index: 1050 !important; /* Higher than the default modal-overlay z-index (assumed to be 1000) */
}

.generic-error-modal-overlay {
  z-index: 1050 !important; /* Matches negative-price-modal-overlay and reference-id-error-modal-overlay */
}

/* Redesigned Modal */
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

.modal-content {
  background: white;
  width: 90%;
  max-width: 800px;
  border-radius: 12px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
  overflow: hidden;
  animation: modalFadeIn 0.3s ease;
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
  padding: 25px;
  max-height: 70vh;
  overflow-y: auto;
}

.section-header {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 15px;
  color: #06693A;
}

.section-header i {
  font-size: 22px;
}

.section-header h4 {
  font-size: 18px;
  font-weight: 600;
  margin: 0;
}

.form-section {
  margin-bottom: 40px; /* Increased from 30px to 40px for more space between sections */
  background-color: #f9f9f9;
  padding: 25px; /* Increased from 20px to 25px for more internal spacing */
  border-radius: 8px;
}

/* Increase spacing between rows in the form */
.form-row {
  display: flex;
  gap: 25px; /* Increased from 20px to 25px for more horizontal spacing between form groups */
  margin-bottom: 20px; /* Increased from 15px to 20px for more vertical spacing between rows */
}

.form-row:last-child {
  margin-bottom: 0;
}

.form-group {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 10px; /* Increased from 8px to 10px for more space between label and input */
}

.form-group label {
  font-weight: 500;
  color: #555;
  font-size: 14px;
  margin-bottom: 8px; /* Increased from default (or none) to 8px for better spacing below labels */
}

.form-group input,
.form-group select {
  padding: 10px 12px;
  border: 1px solid #e0e0e0;
  border-radius: 6px;
  font-size: 14px;
  transition: border-color 0.2s, box-shadow 0.2s;
}

.form-group input:focus,
.form-group select:focus {
  border-color: #06693A;
  box-shadow: 0 0 0 2px rgba(6, 105, 58, 0.1);
  outline: none;
}

.readonly-field {
  background-color: #f5f5f5;
  cursor: not-allowed;
  opacity: 0.8;
}

.input-with-icon {
  position: relative;
  display: flex;
  align-items: center;
}

.currency-symbol {
  position: absolute;
  left: 12px;
  color: #666;
  font-weight: 500;
}

.input-with-icon input {
  padding-left: 25px;
  width: 100%;
  box-sizing: border-box;
}

.status-display {
  display: flex;
  align-items: center;
  gap: 10px;
}

.status-message {
  font-size: 13px;
  color: #666;
  font-style: italic;
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
  width: auto;
}

.cancel-btn:hover {
  background: #e0e0e0;
}

.update-btn {
  padding: 10px 20px;
  background: #06693a;
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
  width: auto;
}

.update-btn:hover {
  background: #055a32;
}

.disabled-button {
  opacity: 0.6;
  cursor: not-allowed;
}

.disabled-button:hover {
  background: #06693a;
}

/* Responsive Styles */
@media (max-width: 1024px) {
  .form-row {
    flex-direction: column;
    gap: 15px;
  }
  
  .modal-content {
    width: 95%;
    max-height: 90vh;
  }
  
  .toggle-buttons {
    flex-direction: row;
    gap: 10px;
  }
  
  .toggle-btn {
    padding: 8px 15px;
    font-size: 13px;
  }
}

@media (max-width: 768px) {
  .desktop-table {
    display: none;
  }
  
  .mobile-cards {
    display: block;
  }
  
  .billing h3 {
    font-size: 16px;
  }
  
  .search-wrapper {
    width: 95%;
    margin-left: 15px;
  }
  
  .search-container {
    margin: 15px 0;
  }
  
  .modal-body {
    padding: 15px;
  }
  
  .section-header h4 {
    font-size: 16px;
  }
  
  .form-section {
    padding: 15px;
  }
  
  .toggle-buttons {
    margin: 15px 10px;
  }
}

@media (max-width: 480px) {
  .billing-container {
    margin: 10px;
  }
  
  .billing h3 {
    font-size: 15px;
    padding: 10px 0;
  }
  
  .modal-header h3 {
    font-size: 18px;
  }
  
  .modal-footer {
    padding: 15px;
  }
  
  .cancel-btn, .update-btn {
    padding: 8px 15px;
    font-size: 13px;
  }
  
  .toggle-buttons {
    flex-direction: column;
    gap: 8px;
    margin: 15px 10px;
  }
  
  .toggle-btn {
    width: 100%;
    justify-content: center;
  }
}

.action-buttons {
  margin-bottom: 10px;
  display: flex;
  gap: 10px;
}

.approve-btn {
  background-color: #06693a;
  color: white;
  padding: 8px 16px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 5px;
}

.approve-btn:disabled,
.approve-btn.disabled-button {
  background-color: #cccccc;
  cursor: not-allowed;
}

.total-insurance-payout {
  margin-top: 20px;
  padding: 10px;
  background-color: #f8f9fa;
  border-radius: 5px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-size: 16px;
  font-weight: bold;
  color: #06693a; /* Match your theme color */
}

.total-label {
  font-weight: 600;
}

.total-amount {
  font-size: 18px;
  color: #06693a; /* Match your theme color */
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .total-insurance-payout {
    flex-direction: column;
    text-align: center;
    padding: 15px;
  }

  .total-amount {
    margin-top: 5px;
    font-size: 16px;
  }
}

.decline-btn {
  background-color: #ff4444;
  color: white;
  border: none;
  padding: 8px 16px;
  border-radius: 4px;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 5px;
}

.decline-btn:hover {
  background-color: #cc0000;
}

.add-payment-btn {
  background-color: #06693A;
  color: white;
  padding: 8px 16px;
  margin-bottom: 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 5px;
  font-size: 14px;
  font-weight: 500;
  transition: background-color 0.2s;
}

.add-payment-btn:hover {
  background-color: #055a32;
}

.add-payment-btn i {
  font-size: 16px;
}

.modal-fade-enter-active,
.modal-fade-leave-active {
  transition: opacity 0.3s ease;
}

.modal-fade-enter-from,
.modal-fade-leave-to {
  opacity: 0;
}

.success-modal {
  max-width: 400px; /* Smaller width for the success modal */
  text-align: center;
}

.success-message {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 10px;
  padding: 20px 0;
}

.success-icon {
  font-size: 48px;
  color: #28a745; /* Green color for success */
}

.success-message p {
  margin: 0;
  font-size: 16px;
  color: #333;
}

/* Add CSS for the cost input */
.service-cost {
  display: flex;
  align-items: center;
  margin-right: 10px;
}

.cost-input {
  width: 100px;
  padding: 4px 8px 4px 20px;
  border: 1px solid #e0e0e0;
  border-radius: 6px;
  font-size: 14px;
  font-weight: 500;
  color: #06693a;
  transition: all 0.2s ease;
}

.cost-input:focus {
  border-color: #06693A;
  outline: none;
  box-shadow: 0 0 0 2px rgba(6, 105, 58, 0.1);
}

.cost-input:disabled {
  background-color: #f5f5f5;
  cursor: not-allowed;
}

.service-cost .input-with-icon {
  position: relative;
}

.service-cost .currency-symbol {
  position: absolute;
  left: 8px;
  top: 50%;
  transform: translateY(-50%);
  color: #06693a;
  font-weight: 500;
}

.form-group.full-width {
  width: 100%;
}

textarea {
  width: 100%;
  padding: 8px;
  border: 1px solid #e0e0e0;
  border-radius: 6px;
  resize: none;
  font-family: inherit;
  font-size: 14px;
  transition: border-color 0.2s, box-shadow 0.2s;
}

textarea:focus {
  border-color: #06693A;
  box-shadow: 0 0 0 2px rgba(6, 105, 58, 0.1);
  outline: none;
}

textarea:disabled {
  background-color: #f5f5f5;
  cursor: not-allowed;
  opacity: 0.8;
}

.view-button {
  background-color: #06693A;
  border: none;
  padding: 6px 12px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 14px;
  color: white;
  width: auto;
  min-width: 60px;
  display: flex;
  align-items: center;
  gap: 5px;
  justify-content: center;
}

.view-button:hover {
  background-color: #055a32;
}

.view-button-mobile {
  background-color: #06693A;
  border: none;
  padding: 6px 12px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 13px;
  color: white;
  display: flex;
  align-items: center;
  gap: 5px;
}

.view-button-mobile:hover {
  background-color: #055a32;
}

.view-button-mobile i {
  font-size: 14px;
}

.input-with-icon input.readonly-field {
  width: 100%;
  box-sizing: border-box;
}

.cost-change-warning {
  margin-top: 5px;
  color: #e74c3c; /* Red color for warning */
  font-size: 12px;
}

.warning-text {
  font-style: italic;
}

.error-text {
  color: #e74c3c;
  font-size: 0.9em;
  margin-top: 5px;
  display: block;
}

.service-payment-detail {
  margin-bottom: 25px; /* Add margin to separate each service block */
  padding: 15px; /* Add padding inside each service block for better spacing */
  background-color: #fff; /* Optional: slight background color to distinguish sections */
  border-radius: 6px; /* Optional: rounded corners for a cleaner look */
  border: 1px solid #e0e0e0; /* Optional: subtle border to define the section */
}

.payment-summary-total {
  margin-top: 25px; /* Add space above the total row */
  padding-top: 15px; /* Add padding to separate from the service details */
  border-top: 1px solid #e0e0e0; /* Optional: add a separator line above the total */
}

.status-display,
.form-group.full-width {
  margin-top: 20px; /* Add space above the status and remarks section */
}

@media (max-width: 1024px) {
  .form-row {
    flex-direction: column;
    gap: 20px; /* Slightly reduced gap for smaller screens, but still more than original 15px */
    margin-bottom: 15px; /* Adjust margin for smaller screens */
  }

  .form-group {
    gap: 8px; /* Slightly reduced gap for smaller screens, but still more than original 8px */
  }

  .service-payment-detail {
    margin-bottom: 20px; /* Slightly reduced margin for smaller screens */
    padding: 12px; /* Slightly reduced padding for smaller screens */
  }
}

@media (max-width: 768px) {
  .form-section {
    padding: 20px; /* Slightly reduced padding for smaller screens */
    margin-bottom: 30px; /* Slightly reduced margin for smaller screens */
  }

  .form-row {
    gap: 15px; /* Further reduced gap for smaller screens */
    margin-bottom: 12px; /* Further reduced margin for smaller screens */
  }

  .form-group label {
    margin-bottom: 6px; /* Slightly reduced margin for smaller screens */
  }

  .service-payment-detail {
    margin-bottom: 15px; /* Further reduced margin for smaller screens */
    padding: 10px; /* Further reduced padding for smaller screens */
  }

  .payment-summary-total {
    margin-top: 20px; /* Slightly reduced margin for smaller screens */
    padding-top: 10px; /* Slightly reduced padding for smaller screens */
  }
}

</style>