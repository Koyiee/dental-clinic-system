<template>
  <div class="sidebar close">
    <!-- Sidebar Navigation -->
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
        <i class="bx bx-menu" @click="toggleSidebar"></i>
        <div class="text">
          <h3>Schedule an Appointment</h3>
          <div class="breadcrumbs">
            <a class="none" href=""><p>Home / </p></a>
            <a class="none" href="/patientappointments"><p> Appointment / </p></a>
            <a class="current" href="/patientscheduleanappointment"><p> Schedule An Appointment</p></a>
          </div>
        </div>
      </div>
      <hr color="#06693a">

      <!-- Step 1: Informed Consent Form -->
      <div v-if="currentFormStep === 'consent'" class="dental-consent-container">
        <h1 class="dental-consent-title">INFORMED CONSENT</h1>
        
        <div class="dental-consent-section">
            <div class="dental-consent-section-title">TREATMENT TO BE DONE:</div>
            <div class="dental-consent-section-content">I understand and consent to have any treatment done by the dentist after the procedure, the risks and benefits & cost have been fully explained. These treatments include, but are not limited to: fillings, cleanings, periodontal maintenance, extractions, root canals, crowns, bridges, implants, and/or dentures.</div>
        </div>
        
        <div class="dental-consent-section">
            <div class="dental-consent-section-title">DRUGS AND MEDICATIONS:</div>
            <div class="dental-consent-section-content">I understand that antibiotics, analgesics and other medications can cause allergic reactions like redness and swelling of tissues, pain, itching, vomiting, and/or anaphylactic shock (severe allergic reaction).</div>
        </div>
        
        <div class="dental-consent-section">
            <div class="dental-consent-section-title">CHANGES IN TREATMENT PLAN:</div>
            <div class="dental-consent-section-content">I understand that during treatment it might be necessary to change/add procedures because of conditions found while working on the teeth that may not be discovered until after treatment has begun. For example, root canal therapy may be needed during routine restorative procedures. I give my permission to the dentist to make any/all changes and additions as necessary with my responsibility to pay all the costs signed.</div>
        </div>
        
        <div class="dental-consent-section">
            <div class="dental-consent-section-title">ANESTHESIA:</div>
            <div class="dental-consent-section-content">I understand that all forms of anesthesia are necessary as part of diagnostic aids, and/or treatment and come up with relative disposition of my dental problem to make a good treatment plan, but this will not give me in the treatment itself. I understand that all forms of treatment involve some risk to anesthesia that includes but is not limited to swelling, bruising, and/or hematoma and that my responsibility to inform the dentist of any previous experience.</div>
        </div>
        
        <div class="dental-consent-section">
            <div class="dental-consent-section-title">PERIODONTAL DISEASE:</div>
            <div class="dental-consent-section-content">I understand that periodontal disease is a serious condition causing gum and bone inflammation and/or loss and that can lead eventually to the loss of my teeth. I understand the alternative treatment plans to correct periodontal disease, including non-surgical cleaning, gum surgery, tooth extraction with or without replacement. I understand that including their risk and benefits prior to authorizing the dentist to remove teeth and any other structures necessary for reasons above. I understand that removing teeth does not always remove all the infection, if present, and it might be necessary to have further treatment. I understand that the success of any dental treatment depends in part on my efforts to brush and floss daily, receive regular cleaning as directed, follow a healthy diet, avoid tobacco products and follow other recommendations. I understand that I am to assist in treatment by decreasing alcohol and tobacco use. I understand that serious complications may result from the extraction of teeth which may involve pain, swelling, infection, dry socket, loss of feeling in my teeth, lips, tongue, and surrounding tissue (paresthesia) that can last for an indefinite period of time or fractured jaw. I understand that I may need further treatment by a specialist if complications arise during or following treatment, for which I am financially responsible.</div>
        </div>
        
        <div class="dental-consent-section">
            <div class="dental-consent-section-title">CROWN (CAP) & BRIDGES:</div>
            <div class="dental-consent-section-content">I understand that sometimes it is not possible to match the color of natural teeth exactly with artificial teeth. I further understand that I may be wearing temporary crowns, which may come off easily and that I must be careful to ensure that they are kept on until the permanent crowns are delivered. I realize that the final opportunity to make changes in my new crown, bridge, or cap (including shape, fit, size, placement, and color) will be done before cementation. It is also my responsibility to return for permanent cementation within 20 days from tooth preparation. Excessive delays may allow for tooth movement, necessitating a remake of the crown, bridge, or cap. I understand there will be additional charges for remakes due to my delaying of permanent cementation, and I realize that final cementation may inhibit the ability to make modifications or changes in the new crown, bridge, or cap. I understand that the dental crown procedure may require removing the top of the crown, reducing the tooth structure to allow for the new restorative material to be placed. I understand that sometimes after the crown is cemented, the tooth may require root canal therapy, which may require removing the crown and remaking it after the root canal is completed. I understand that a crown may require removal in order to access to work.</div>
        </div>
        
        <div class="dental-consent-section">
            <div class="dental-consent-section-title">ENDODONTICS (ROOT CANAL):</div>
            <div class="dental-consent-section-content">I understand there is no guarantee that a root canal treatment will save a tooth and can cause from the treatment and will sometimes not cured filing (root canal) through the tooth can also help not necessarily affect the outcome of the treatment. I understand that occasionally additional surgical procedures may be necessary following root canal treatment (apicoectomy). I understand that the tooth may be lost in spite of all efforts to save it. I understand that instruments may separate during the root canal, that may require referral to an endodontist. I understand that a crown may be necessary following root canal treatment and I agree that I am responsible for any additional costs for treatment performed by the endodontist. I understand that a crown may require removal in order to access to work.</div>
        </div>
        
        <div class="dental-consent-section">
            <div class="dental-consent-section-title">PERIODONTAL DISEASE:</div>
            <div class="dental-consent-section-content">I understand that periodontal disease is a serious condition causing gum and bone inflammation and/or loss and that can lead eventually to the loss of my teeth. I understand the alternative treatment plans to correct periodontal disease, including non-surgical cleaning, gum surgery, tooth extraction with or without replacement. I understand that undertaking any dental procedure may have a future adverse effect on my periodontal condition.</div>
        </div>
        
        <div class="dental-consent-section">
            <div class="dental-consent-section-title">FILLINGS:</div>
            <div class="dental-consent-section-content">I understand that care must be exercised in chewing on fillings, especially during the first 24 hours to avoid breakage. I understand that a more extensive filling than originally diagnosed may be required due to additional decay. I understand that significant sensitivity is a common after-effect of a newly placed filling. I further understand that filling large cavities may irritate the tooth nerves which may require root canal therapy or even lead to future tooth extraction.</div>
        </div>
        
        <div class="dental-consent-section">
            <div class="dental-consent-section-title">DENTURES:</div>
            <div class="dental-consent-section-content">I understand that wearing dentures can be difficult. Sore spots, altered speech, and difficulty in eating are common problems. Immediate dentures (placement of dentures immediately after extractions) maybe painful. Immediate dentures may require considerable adjusting and several relines. I understand that it is my responsibility to return for delivery of dentures. I understand that failure to keep my delivery appointment may result in poorly fitted dentures. If a remake is required due to my delays of more than 30 days, there will be additional charges. I understand that all adjustment or revision of any kind after initial placement is subject to charges. I understand that dentistry is not an exact science and that therefore, reputable practitioners cannot guarantee results. I acknowledge that no guarantee or assurance has been made by anyone regarding the dental treatment that I have requested and authorized.</div>
        </div>

        <div class="dental-consent-signature-line">
            <div class="dental-consent-checkbox-container">
                <input type="checkbox" id="patient_acknowledge_inexact_science" name="patient_acknowledge_inexact_science" v-model="consentCheckboxes.inexactScience" />
                <label for="patient_acknowledge_inexact_science">I understand that dentistry is not an exact science and that no dentist can properly guarantee accurate results all the time.</label>
            </div>
        </div>
        
        <div class="dental-consent-signature-line">
            <div class="dental-consent-checkbox-container">
                <input type="checkbox" id="patient_authorize_treatment" name="patient_authorize_treatment" v-model="consentCheckboxes.authorizeDoctor" />
                <label for="patient_authorize_treatment">I hereby authorize any of the doctors/staff/assistants to proceed with and perform the dental restoration and treatments as explained to me. I understand that this is only an estimate and subject to modification depending on unforeseen or undiagnosable circumstances that may arise during the course of treatment. I understand that regardless of any dental insurance coverage I may have, I am responsible for payment of dental fees. I agree to pay any attorney's fees, collection fees, or court costs that may be incurred to satisfy this obligation. I understand that treatment fees are payable at the time service is provided. I understand that refusal to proceed with the recommended treatment may result in further complications and it is my view as sufficient patient refusal to accept the treatment plan.</label>
            </div>
        </div>
        
        <div class="dental-consent-signature-line">
            <div class="dental-consent-checkbox-container">
                <input type="checkbox" id="patient_consent_to_treatment" name="patient_consent_to_treatment" v-model="consentCheckboxes.consentToTreatment" />
                <label for="patient_consent_to_treatment">I acknowledge that I have read and understand the informed consent information provided to me regarding my treatment. I consent to proceed with the recommended procedures as outlined in my treatment plan.</label>
            </div>
        </div>
        
        <div class="dental-consent-buttons">
            <button class="dental-consent-button" @click="cancelAppointment">Cancel</button>
            <button class="dental-consent-button dental-consent-agree-button" 
                   @click="proceedToQuestionnaire" 
                   :disabled="!allConsentCheckboxesChecked">I agree</button>
        </div>
      </div>

      <!-- Step 2: Patient Health Questionnaire -->
      <div v-if="currentFormStep === 'questionnaire'" class="patient-questionnaire-container">
        <h1 class="questionnaire-title">Patient Health Questionnaires</h1>
        
        <!-- Required fields notice -->
        <div class="required-fields-notice">
          <p><i><strong class="note">Note:</strong> Fields marked with <span class="required-asterisk">*</span> are required</i></p>
        </div>
        
        <div class="questionnaire-form">
          <div class="question-row">
            <div class="question-number">1.</div>
            <div class="question-text">
              Are you in good health? <span class="required-asterisk">*</span>
            </div>
            <div class="question-options">
              <label class="radio-option">
                <input type="radio" name="good_health" value="yes" v-model="questionnaire.goodHealth" required>
                <span>YES</span>
              </label>
              <label class="radio-option">
                <input type="radio" name="good_health" value="no" v-model="questionnaire.goodHealth" required>
                <span>NO</span>
              </label>
            </div>
          </div>
          <div v-if="validationErrors.goodHealth" class="validation-error">
            This field is required
          </div>

          <div class="question-row">
            <div class="question-number">2.</div>
            <div class="question-text">
              Are you under medical treatment now? <span class="required-asterisk">*</span>
            </div>
            <div class="question-options">
              <label class="radio-option">
                <input type="radio" name="medical_treatment" value="yes" v-model="questionnaire.medicalTreatment" required>
                <span>YES</span>
              </label>
              <label class="radio-option">
                <input type="radio" name="medical_treatment" value="no" v-model="questionnaire.medicalTreatment" required>
                <span>NO</span>
              </label>
            </div>
          </div>
          <div v-if="validationErrors.medicalTreatment" class="validation-error">
            This field is required
          </div>

          <div v-if="questionnaire.medicalTreatment === 'yes'" class="conditional-field">
            <div class="conditional-text">If so, what is the condition being treated? <span class="required-asterisk">*</span></div>
            <div class="conditional-input">
              <input type="text" v-model="questionnaire.medicalTreatmentDetails" 
                     :class="['text-input', {'invalid-input': questionnaire.medicalTreatment === 'yes' && validationErrors.medicalTreatmentDetails}]" 
                     required>
            </div>
            <div v-if="questionnaire.medicalTreatment === 'yes' && validationErrors.medicalTreatmentDetails" class="validation-error">
              This field is required
            </div>
          </div>

          <div class="question-row">
            <div class="question-number">3.</div>
            <div class="question-text">
              Have you ever had a serious illness or surgical operation? <span class="required-asterisk">*</span>
            </div>
            <div class="question-options">
              <label class="radio-option">
                <input type="radio" name="serious_illness" value="yes" v-model="questionnaire.seriousIllness" required>
                <span>YES</span>
              </label>
              <label class="radio-option">
                <input type="radio" name="serious_illness" value="no" v-model="questionnaire.seriousIllness" required>
                <span>NO</span>
              </label>
            </div>
          </div>
          <div v-if="validationErrors.seriousIllness" class="validation-error">
            This field is required
          </div>

          <!-- Conditional field for question 3 -->
          <div v-if="questionnaire.seriousIllness === 'yes'" class="conditional-field">
            <div class="conditional-text">If so, what illness or operation? <span class="required-asterisk">*</span></div>
            <div class="conditional-input">
              <input type="text" v-model="questionnaire.seriousIllnessDetails" 
                     :class="['text-input', {'invalid-input': questionnaire.seriousIllness === 'yes' && validationErrors.seriousIllnessDetails}]" 
                     required>
            </div>
            <div v-if="questionnaire.seriousIllness === 'yes' && validationErrors.seriousIllnessDetails" class="validation-error">
              This field is required
            </div>
          </div>

          <div class="question-row">
            <div class="question-number">4.</div>
            <div class="question-text">
              Have you ever been hospitalized? <span class="required-asterisk">*</span>
            </div>
            <div class="question-options">
              <label class="radio-option">
                <input type="radio" name="hospitalized" value="yes" v-model="questionnaire.hospitalized" required>
                <span>YES</span>
              </label>
              <label class="radio-option">
                <input type="radio" name="hospitalized" value="no" v-model="questionnaire.hospitalized" required>
                <span>NO</span>
              </label>
            </div>
          </div>
          <div v-if="validationErrors.hospitalized" class="validation-error">
            This field is required
          </div>

          <!-- Conditional field for question 4 -->
          <div v-if="questionnaire.hospitalized === 'yes'" class="conditional-field">
            <div class="conditional-text">If so, when and why? <span class="required-asterisk">*</span></div>
            <div class="conditional-input">
              <input type="text" v-model="questionnaire.hospitalizedDetails" 
                     :class="['text-input', {'invalid-input': questionnaire.hospitalized === 'yes' && validationErrors.hospitalizedDetails}]" 
                     required>
            </div>
            <div v-if="questionnaire.hospitalized === 'yes' && validationErrors.hospitalizedDetails" class="validation-error">
              This field is required
            </div>
          </div>

          <div class="question-row">
            <div class="question-number">5.</div>
            <div class="question-text">
              Are you taking any prescription/non-prescription medication? <span class="required-asterisk">*</span>
            </div>
            <div class="question-options">
              <label class="radio-option">
                <input type="radio" name="medication" value="yes" v-model="questionnaire.medication" required>
                <span>YES</span>
              </label>
              <label class="radio-option">
                <input type="radio" name="medication" value="no" v-model="questionnaire.medication" required>
                <span>NO</span>
              </label>
            </div>
          </div>
          <div v-if="validationErrors.medication" class="validation-error">
            This field is required
          </div>

          <!-- Conditional field for question 5 -->
          <div v-if="questionnaire.medication === 'yes'" class="conditional-field">
            <div class="conditional-text">If so, please specify: <span class="required-asterisk">*</span></div>
            <div class="conditional-input">
              <input type="text" v-model="questionnaire.medicationDetails" 
                     :class="['text-input', {'invalid-input': questionnaire.medication === 'yes' && validationErrors.medicationDetails}]" 
                     required>
            </div>
            <div v-if="questionnaire.medication === 'yes' && validationErrors.medicationDetails" class="validation-error">
              This field is required
            </div>
          </div>

          <div class="question-row">
            <div class="question-number">6.</div>
            <div class="question-text">
              Do you use tobacco products? <span class="required-asterisk">*</span>
            </div>
            <div class="question-options">
              <label class="radio-option">
                <input type="radio" name="tobacco" value="yes" v-model="questionnaire.tobacco" required>
                <span>YES</span>
              </label>
              <label class="radio-option">
                <input type="radio" name="tobacco" value="no" v-model="questionnaire.tobacco" required>
                <span>NO</span>
              </label>
            </div>
          </div>
          <div v-if="validationErrors.tobacco" class="validation-error">
            This field is required
          </div>

          <div class="question-row">
            <div class="question-number">7.</div>
            <div class="question-text">
              Do you use alcohol, cocaine, or other dangerous drugs? <span class="required-asterisk">*</span>
            </div>
            <div class="question-options">
              <label class="radio-option">
                <input type="radio" name="drugs" value="yes" v-model="questionnaire.drugs" required>
                <span>YES</span>
              </label>
              <label class="radio-option">
                <input type="radio" name="drugs" value="no" v-model="questionnaire.drugs" required>
                <span>NO</span>
              </label>
            </div>
          </div>
          <div v-if="validationErrors.drugs" class="validation-error">
            This field is required
          </div>

          <div class="question-row">
            <div class="question-number">8.</div>
            <div class="question-text">Are you allergic to any of the following:</div>
          </div>

          <div class="allergies-container">
            <div class="allergies-grid">
              <div class="allergy-option">
                <input type="checkbox" id="allergy_anesthetic" v-model="questionnaire.allergies.anesthetic">
                <label for="allergy_anesthetic">Local Anesthetic</label>
              </div>
              <div class="allergy-option">
                <input type="checkbox" id="allergy_penicillin" v-model="questionnaire.allergies.penicillin">
                <label for="allergy_penicillin">Penicillin Antibiotics</label>
              </div>
              <div class="allergy-option">
                <input type="checkbox" id="allergy_latex" v-model="questionnaire.allergies.latex">
                <label for="allergy_latex">Latex</label>
              </div>
              <div class="allergy-option">
                <input type="checkbox" id="allergy_sulfa" v-model="questionnaire.allergies.sulfa">
                <label for="allergy_sulfa">Sulfa Drugs</label>
              </div>
              <div class="allergy-option">
                <input type="checkbox" id="allergy_aspirin" v-model="questionnaire.allergies.aspirin">
                <label for="allergy_aspirin">Aspirin</label>
              </div>
              <div class="allergy-option">
                <input type="checkbox" id="allergy_others" v-model="questionnaire.allergies.others">
                <label for="allergy_others">Others</label>
              </div>
            </div>
          </div>

          <div class="question-row">
            <div class="question-number">9.</div>
            <div class="question-text">
              Bleeding Time (For Women Only: Menstruation Duration) <span class="optional-text">(Optional)</span>
              <p class="question-hint">Please enter the typical duration of your menstrual period (e.g., 3-7 days or up to 30 days if irregular).</p>
            </div>
            <div class="question-input">
              <input type="text" v-model="questionnaire.bleedingTime" 
                    class="text-input"
                    placeholder="e.g., 3-7 days or up to 30 days"
                    @input="restrictBleedingTime"
                    :class="{ 'invalid-input': validationErrors.bleedingTime }">
            </div>
            <div v-if="validationErrors.bleedingTime" class="validation-error">
              Please enter a number between 1 and 30.
            </div>
          </div>
          
          <div class="question-row">
            <div class="question-number">10.</div>
            <div class="question-text">For Women only</div>
          </div>

          <div class="sub-questions">
            <div class="question-row sub-question">
              <div class="question-text">
                Are you pregnant?
              </div>
              <div class="question-options">
                <label class="radio-option">
                  <input type="radio" name="pregnant" value="yes" v-model="questionnaire.pregnant">
                  <span>YES</span>
                </label>
                <label class="radio-option">
                  <input type="radio" name="pregnant" value="no" v-model="questionnaire.pregnant">
                  <span>NO</span>
                </label>
              </div>
            </div>
            
            <div class="question-row sub-question">
              <div class="question-text">
                Are you nursing?
              </div>
              <div class="question-options">
                <label class="radio-option">
                  <input type="radio" name="nursing" value="yes" v-model="questionnaire.nursing">
                  <span>YES</span>
                </label>
                <label class="radio-option">
                  <input type="radio" name="nursing" value="no" v-model="questionnaire.nursing">
                  <span>NO</span>
                </label>
              </div>
            </div>
            
            <div class="question-row sub-question">
              <div class="question-text">
                Are you taking birth control pills?
              </div>
              <div class="question-options">
                <label class="radio-option">
                  <input type="radio" name="birthcontrol" value="yes" v-model="questionnaire.birthControl">
                  <span>YES</span>
                </label>
                <label class="radio-option">
                  <input type="radio" name="birthcontrol" value="no" v-model="questionnaire.birthControl">
                  <span>NO</span>
                </label>
              </div>
            </div>
          </div>

          <div class="question-row">
            <div class="question-number">11.</div>
            <div class="question-text">
              Blood Type
            </div>
            <div v-if="validationErrors.bloodType" class="validation-error">
              Please select a valid blood type.
            </div>
            <div class="question-input">
              <select v-model="questionnaire.bloodType" class="text-input" :class="{ 'invalid-input': validationErrors.bloodType }">
                <option value="" disabled selected>Select Blood Type</option>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
              </select>
            </div>
          </div>

          <div class="question-row">
            <div class="question-number">12.</div>
            <div class="question-text">
              Blood Pressure
            </div>
            <div v-if="validationErrors.bloodPressure" class="validation-error">
              Please enter a number between 30 and 300.
            </div>
            <div class="question-input">
              <input type="text" v-model="questionnaire.bloodPressure" 
                    class="text-input"
                    placeholder="e.g., 120"
                    @input="restrictBloodPressure"
                    :class="{ 'invalid-input': validationErrors.bloodPressure }">
            </div>
          </div>

          <div class="question-row">
            <div class="question-number">13.</div>
            <div class="question-text">Do you have or have you had any of the following? Check which apply</div>
          </div>

          <div class="medical-conditions-container">
            <div class="medical-conditions-grid">
              <!-- Column 1 -->
              <div class="condition-option">
                <input type="checkbox" id="condition_high_bp" v-model="questionnaire.conditions.highBP">
                <label for="condition_high_bp">High Blood Pressure</label>
              </div>
              <div class="condition-option">
                <input type="checkbox" id="condition_fainting" v-model="questionnaire.conditions.fainting">
                <label for="condition_fainting">Fainting Seizure</label>
              </div>
              <div class="condition-option">
                <input type="checkbox" id="condition_thyroid" v-model="questionnaire.conditions.thyroid">
                <label for="condition_thyroid">Thyroid Problem</label>
              </div>
              <div class="condition-option">
                <input type="checkbox" id="condition_respiratory" v-model="questionnaire.conditions.respiratory">
                <label for="condition_respiratory">Respiratory Problems</label>
              </div>
              <div class="condition-option">
                <input type="checkbox" id="condition_chest_pain" v-model="questionnaire.conditions.chestPain">
                <label for="condition_chest_pain">Chest Pain</label>
              </div>
              <div class="condition-option">
                <input type="checkbox" id="condition_emphysema" v-model="questionnaire.conditions.emphysema">
                <label for="condition_emphysema">Emphysema</label>
              </div>
              
              <!-- Column 2 -->
              <div class="condition-option">
                <input type="checkbox" id="condition_low_bp" v-model="questionnaire.conditions.lowBP">
                <label for="condition_low_bp">Low Blood Pressure</label>
              </div>
              <div class="condition-option">
                <input type="checkbox" id="condition_weight_loss" v-model="questionnaire.conditions.weightLoss">
                <label for="condition_weight_loss">Rapid Weight Loss</label>
              </div>
              <div class="condition-option">
                <input type="checkbox" id="condition_heart_disease" v-model="questionnaire.conditions.heartDisease">
                <label for="condition_heart_disease">Heart Disease</label>
              </div>
              <div class="condition-option">
                <input type="checkbox" id="condition_hepatitis" v-model="questionnaire.conditions.hepatitis">
                <label for="condition_hepatitis">Hepatitis/Jaundice</label>
              </div>
              <div class="condition-option">
                <input type="checkbox" id="condition_stroke" v-model="questionnaire.conditions.stroke">
                <label for="condition_stroke">Stroke</label>
              </div>
              <div class="condition-option">
                <input type="checkbox" id="condition_bleeding_problems" v-model="questionnaire.conditions.bleedingProblems">
                <label for="condition_bleeding_problems">Bleeding Problems</label>
              </div>
              
              <!-- Column 3 -->
              <div class="condition-option">
                <input type="checkbox" id="condition_epilepsy" v-model="questionnaire.conditions.epilepsy">
                <label for="condition_epilepsy">Epilepsy/Convulsions</label>
              </div>
              <div class="condition-option">
                <input type="checkbox" id="condition_radiation_therapy" v-model="questionnaire.conditions.radiationTherapy">
                <label for="condition_radiation_therapy">Radiation Therapy</label>
              </div>
              <div class="condition-option">
                <input type="checkbox" id="condition_heart_murmur" v-model="questionnaire.conditions.heartMurmur">
                <label for="condition_heart_murmur">Heart Murmur</label>
              </div>
              <div class="condition-option">
                <input type="checkbox" id="condition_tubercolosis" v-model="questionnaire.conditions.tubercolosis">
                <label for="condition_tubercolosis">Tubercolosis</label>
              </div>
              <div class="condition-option">
                <input type="checkbox" id="condition_cancer" v-model="questionnaire.conditions.cancer">
                <label for="condition_cancer">Cancer/Tumor</label>
              </div>
              <div class="condition-option">
                <input type="checkbox" id="condition_blood_disease" v-model="questionnaire.conditions.bloodeDisease">
                <label for="condition_blood_disease">Blood Diseases</label>
              </div>
              
              <!-- Column 4 -->
              <div class="condition-option">
                <input type="checkbox" id="condition_aids" v-model="questionnaire.conditions.aids">
                <label for="condition_aids">AIDS/HIV Infection</label>
              </div>
              <div class="condition-option">
                <input type="checkbox" id="condition_joint_replacement" v-model="questionnaire.conditions.jointReplacement">
                <label for="condition_joint_replacement">Joint Replacement/Implant</label>
              </div>
              <div class="condition-option">
                <input type="checkbox" id="condition_liver_disease" v-model="questionnaire.conditions.liverDisease">
                <label for="condition_liver_disease">Hepatitis/Liver Disease</label>
              </div>
              <div class="condition-option">
                <input type="checkbox" id="condition_swollen_ankles" v-model="questionnaire.conditions.swollenAnkles">
                <label for="condition_swollen_ankles">Swollen Ankles</label>
              </div>
              <div class="condition-option">
                <input type="checkbox" id="condition_anemia" v-model="questionnaire.conditions.anemia">
                <label for="condition_anemia">Anemia</label>
              </div>
              <div class="condition-option">
                <input type="checkbox" id="condition_head_injuries" v-model="questionnaire.conditions.headInjuries">
                <label for="condition_head_injuries">Head Injuries</label>
              </div>
              
              <!-- Column 5 -->
              <div class="condition-option">
                <input type="checkbox" id="condition_std" v-model="questionnaire.conditions.std">
                <label for="condition_std">Sexually Transmitted Disease</label>
              </div>
              <div class="condition-option">
                <input type="checkbox" id="condition_heart_surgery" v-model="questionnaire.conditions.heartSurgery">
                <label for="condition_stroke">Heart Surgery</label>
              </div>
              <div class="condition-option">
                <input type="checkbox" id="condition_rheumatic_fever" v-model="questionnaire.conditions.rheumaticFever">
                <label for="condition_rheumatic_fever">Rheumatic Fever</label>
              </div>
              <div class="condition-option">
                <input type="checkbox" id="condition_kidney_disease" v-model="questionnaire.conditions.kidneyDisease">
                <label for="condition_kidney_disease">Kidney Disease</label>
              </div>
              <div class="condition-option">
                <input type="checkbox" id="condition_angina" v-model="questionnaire.conditions.angina">
                <label for="condition_angina">Angina</label>
              </div>
              <div class="condition-option">
                <input type="checkbox" id="condition_arthritis" v-model="questionnaire.conditions.arthritis">
                <label for="condition_arthritis">Arthritis/Rheumatism</label>
              </div>
              
              <!-- Column 6 -->
              <div class="condition-option">
                <input type="checkbox" id="condition_stomach_trouble" v-model="questionnaire.conditions.stomachTrouble">
                <label for="condition_stomach_trouble">Stomach Trouble/Ulcers</label>
              </div>
              <div class="condition-option">
                <input type="checkbox" id="condition_heart_attack" v-model="questionnaire.conditions.heartAttack">
                <label for="condition_heart_attack">Heart Attack</label>
              </div>
              <div class="condition-option">
                <input type="checkbox" id="condition_hay_fever" v-model="questionnaire.conditions.hayFever">
                <label for="condition_hayFever">Hay Fever/Allergies</label>
              </div>
              <div class="condition-option">
                <input type="checkbox" id="condition_diabetes" v-model="questionnaire.conditions.diabetes">
                <label for="condition_diabetes">Diabetes</label>
              </div>
              <div class="condition-option">
                <input type="checkbox" id="condition_asthma" v-model="questionnaire.conditions.asthma">
                <label for="condition_asthma">Asthma</label>
              </div>
              <div class="condition-option">
                <input type="checkbox" id="condition_others" v-model="questionnaire.conditions.others">
                <label for="condition_others">Others</label>
              </div>
            </div>
          </div>
          
          <div class="questionnaire-buttons">
            <button class="questionnaire-button cancel-button" @click="backToConsent">Back</button>
            <button class="questionnaire-button save-button" @click="validateAndProceed">Save</button>
          </div>
        </div>
      </div>

      <!-- Hidden Container for PDF Generation -->
      <div v-show="false" id="pdf-content">
        <!-- Informed Consent Section -->
        
      </div>

      <!-- Info Modal -->
      <div v-if="isInfoModalOpen" class="modal-overlay">
        <div class="modal info-modal">
          <div class="modal-header">
            <h3>Information</h3>
            <button class="close-icon" @click="closeInfoModal">
              <i class='bx bx-x'></i>
            </button>
          </div>
          <div class="modal-content">
            <div class="info-message-container">
              <i class='bx bx-info-circle info-icon'></i>
              <p>{{ infoMessage }}</p>
            </div>
          </div>
          <div class="modal-footer">
            <button class="modal-btn primary-btn centered-btn" @click="closeInfoModal">OK</button>
          </div>
        </div>
      </div>

      <div v-if="currentFormStep === 'scheduling' && !isSuccessMessageVisible">
        <!-- Improved Progress Bar -->
        <div class="booking-progress">
          <div v-for="(step, index) in steps" :key="index" 
               :class="['booking-step', { active: currentStep === index + 1, completed: currentStep > index + 1 }]" 
               @click="setCurrentStep(index + 1)">
            <div class="step-indicator">
              <span v-if="currentStep <= index + 1">{{ index + 1 }}</span>
              <i v-else class='bx bx-check'></i>
            </div>
            <div class="step-label">{{ step }}</div>
          </div>
        </div>

        <div v-if="currentStep === 1">
          <!-- Improved Date/Time Selection Tabs -->
          <div class="date-time-tabs">
            <button :class="['date-time-tab', { active: subStep === 'date' }]" @click="setSubStep('date')">
              <i class='bx bx-calendar'></i>
              <span>DATE</span>
            </button>
            <button :class="['date-time-tab', { active: subStep === 'time' }]" @click="setSubStep('time')" :disabled="!form.AppointmentDate">
              <i class='bx bx-time'></i>
              <span>TIME</span>
            </button>
          </div>

          <!-- Time Selection -->
          <div class="container-time">
            <div v-if="subStep === 'time'" class="time-container">
              <h3 class="time-heading">Select Appointment Time for {{ formatDate(form.AppointmentDate) }}</h3>
              <div class="time-buttons">
                <button v-for="slot in availableTimes" :key="slot.time" 
                        :class="['time-button', { 
                            'selected': form.AppointmentTime === slot.time, 
                            'unavailable': !slot.is_available
                        }]" 
                        @click="selectTime(slot.time)"
                        :disabled="!slot.is_available">
                  <i class='bx bx-time'></i>
                  <span>{{ formatTimeDisplay(slot.time) }}</span>
                  <span v-if="!slot.is_available" class="unavailable-label"></span>
                </button>
              </div>
            </div>
          </div>

          <!-- Navigation Buttons -->
          <div class="navigation-buttons">
            <button class="cancel-button" style="margin-bottom: 20px;" @click="cancelAppointment">
              <i class='bx bx-x'></i>
              <span>Cancel</span>
            </button>
            <button style="margin-top: 5px; margin-bottom: 15px;" class="next-button" v-if="subStep === 'time' && form.AppointmentTime" @click="proceedToNextStep">
              <span>Next</span>
              <i class='bx bx-chevron-right'></i>
            </button>
          </div>
        </div>

        <div v-if="currentStep === 2">
          <div class="service-selection">
            <!-- Redesigned Service Selection -->
            <div class="service-header">
              <h3>Select Services</h3>
              <p class="service-subtitle">Choose up to 3 services</p>
            </div>
            
            <div class="services-grid">
  <div 
    v-for="service in availableServices" 
    :key="service.ServiceID" 
    class="service-card" 
    :class="{ selected: selectedServices.includes(service.ServiceName) }" 
    @click="toggleService(service.ServiceName)"
  >
    <div class="service-card-content">
      <div class="service-icon">
        <i class='bx bx-plus-medical'></i>
      </div>
      <div class="service-info">
        <h4>{{ service.ServiceName }}</h4>
        <!-- <p class="service-price">₱{{ getServiceCost(service.ServiceName) }}</p> -->
      </div>
      <div class="service-check" v-if="selectedServices.includes(service.ServiceName)">
        <i class='bx bx-check'></i>
      </div>
    </div>
  </div>
  <!-- Add fallback message -->
  <div v-if="availableServices.length === 0" class="no-services-message">
    No active services available at this time.
  </div>
</div>

            <!-- Cost Summary -->
            <div class="cost-summary" v-if="selectedServices.length > 0">
              <div class="summary-header">
                <h3>Summary</h3>
              </div>
              <div class="summary-content">
                <div class="summary-items">
                  <div v-for="(service, index) in selectedServices" :key="index" class="summary-item">
                    <span class="item-name">{{ service }}</span>
                    <!-- <span class="item-price">₱{{ getServiceCost(service) }}</span> -->
                  </div>
                </div>
                <div class="summary-divider"></div>
                <div class="summary-total">
                  <!-- <span>Total</span> -->
                  <!-- <span class="total-price">₱{{ totalCost }}</span> -->
                </div>
                <!-- <p class="summary-disclaimer"><b>Prices may vary based on additional factors</b></p> -->
              </div>
            </div>

            <!-- Patient Note -->
            <div class="note-section">
              <h3>Additional Notes</h3>
              <textarea 
                v-model="form.PatientNote" 
                placeholder="Enter any additional notes or requests here..."
                rows="3"
              ></textarea>
            </div>
          </div>

          <!-- Navigation Buttons -->
          <div class="navigation-buttons">
            <button class="back-button" @click="goBack">
              <i class='bx bx-chevron-left'></i>
              <span>Back</span>
            </button>
            <button class="next-button" @click="proceedToNextStep" :disabled="selectedServices.length === 0">
              <span>Next</span>
              <i class='bx bx-chevron-right'></i>
            </button>
          </div>
        </div>

        <div v-if="currentStep === 3">
          <div class="dentist-container">
            <h2 class="dentist-title">Choose a Dentist</h2>
            
            <div class="dentist-options">
              <!-- Any Dentist option -->
              <div 
                class="dentist-option" 
                :class="{ selected: form.DentistID === 'any' }"
                @click="selectDentist('any')"
              >
                <div class="radio-circle">
                  <div class="radio-dot" v-if="form.DentistID === 'any'"></div>
                </div>
                <span class="dentist-name">Any Dentist</span>
              </div>
              
              <!-- Dentist options from the dentists array -->
              <div 
                v-for="dentist in dentists" 
                :key="dentist.DentistID" 
                class="dentist-option" 
                :class="{ 
                    'selected': form.DentistID === dentist.DentistID,
                    'disabled': dentist.isUnavailable 
                }"
                @click="selectDentist(dentist.DentistID)"
            >
                <div class="radio-circle">
                    <div class="radio-dot" v-if="form.DentistID === dentist.DentistID"></div>
                </div>
                <span class="dentist-name" :class="{ 'disabled-text': dentist.isUnavailable }">
                    {{ dentist.Name }}
                </span>
              </div>
            </div>
          </div>

          <div class="navigation-buttons">
            <button class="back-button" @click="goBack">
              <i class='bx bx-chevron-left'></i>
              <span>Back</span>
            </button>
            <button 
              class="next-button"
              :disabled="!form.DentistID" 
              @click="proceedToNextStep"
            >
              <span>Next</span>
              <i class='bx bx-chevron-right'></i>
            </button>
          </div>
        </div>

        <div v-if="currentStep === 4">
          <div class="confirmation-container">
            <div class="confirmation-header">
              <h2>APPOINTMENT CONFIRMATION</h2>
            </div>
            
            <div class="confirmation-section">
              <h3 class="section-title">SERVICE DETAILS</h3>
              <div class="section-content">
                <div class="service-detail">
                  <i class="bx bx-smile tooth-icon"></i>
                  <span>{{ form.selectedServices.length > 0 ? form.selectedServices.join(", ") : 'N/A' }}</span>
                </div>
                <div class="service-detail">
                  <i class="bx bx-calendar"></i>
                  <span>{{ form.AppointmentDate }} | {{ form.AppointmentTime }}</span>
                </div>
                <div class="service-detail">
                  <i class="bx bx-user"></i>
                  <span>{{ form.DentistID === "any" || form.DentistID === null ? "Any Dentist" : getDentistName(form.DentistID) }}</span>
                </div>
              </div>
            </div>
            
            <div class="confirmation-section">
              <h3 class="section-title">PATIENT'S NOTE</h3>
              <div class="section-content">
                <p>{{ form.PatientNote || 'No notes provided.' }}</p>
              </div>
            </div>
            
            <!-- <div class="confirmation-section">
              <h3 class="section-title">PAYMENT DETAILS</h3>
              <div class="section-content">
                <div class="payment-row">
                  <span>SUBTOTAL : </span>
                  <span>₱ {{ totalCost.toFixed(2) }}</span>
                </div>
              </div>
            </div> -->

            <!-- <div class="note-message">
              <i class="bx bx-error">
                <span> Prices may vary based on actual conditions.</span>
              </i>
            </div> -->
            
            <div class="secure-message">
              <i class="bx bx-shield-quarter"></i>
              <span>All your transactions are secure and safe.</span>
            </div>
            
          </div>
          <div class="navigation-buttons">
            <button class="back-button" @click="goBack">
              <i class='bx bx-chevron-left'></i>
              <span>Back</span>
            </button>
            <button class="next-button confirm-button" @click="openConfirmModal">
              <span>Book Appointment</span>
              <i class='bx bx-check'></i>
            </button>
          </div>
        </div>
        
      </div>


      <!-- Confirmation Modal -->
      <div v-if="isConfirmModalOpen" class="modal-overlay">
        <div class="modal">
          <div class="modal-header">
            <h3>Confirm Your Booking</h3>
            <button class="close-icon" @click="closeConfirmModal">
              <i class='bx bx-x'></i>
            </button>
          </div>
          <div class="modal-content">
            <div class="confirm-message-container">
              <i class='bx bx-check-circle confirm-icon'></i>
              <p>
                Clicking <b>'BOOK'</b> will finalize your appointment. Please review your details—changes may not be allowed after this.
              </p>
            </div>
          </div>
          <div class="modal-footer">
            <button class="modal-btn primary-btn" @click="finalizeBooking">BOOK</button>
            <button class="modal-btn secondary-btn" @click="closeConfirmModal">Cancel</button>
          </div>
        </div>
      </div>

      <!-- Enhanced Success Message -->
      <div v-if="isSuccessMessageVisible" class="success-card-container">
        <div class="success-card">
          <div class="success-icon">
            <svg width="100" height="100" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
              <circle cx="50" cy="50" r="45" stroke="#26C281" stroke-width="10" />
              <path d="M30 50L45 65L70 35" stroke="#26C281" stroke-width="10" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </div>
          
          <h1 class="success-title">YOU'RE BOOKED!</h1>
          <p class="success-message">Thank you for booking an appointment. Please wait for your appointment confirmation.</p>
          
          <button class="back-to-appointments-btn" @click="goToAppointments">
            Back to Appointments
          </button>
        </div>
      </div>

      <!-- FullCalendar -->
      <div v-if="currentFormStep === 'scheduling' && subStep === 'date'" class="calendar-container">
        <FullCalendar
          :events="events"
          :options="calendarOptions"
          :key="calendarKey"
        />
      </div>
    </div>
  </section>
</template>

<script>
import { jsPDF } from 'jspdf';
import { defineComponent, ref } from 'vue';
import FullCalendar from '@fullcalendar/vue3';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';
import axios from 'axios';
import Swal from 'sweetalert2';

export default defineComponent({
  name: "PatientScheduleAnAppointment",
  components: {
    FullCalendar,
  },
  data() {
    return {
      calendarKey: 0,
      profilePicture: sessionStorage.getItem('user_profile_picture') || this.profilePicture,
      currentFormStep: 'consent',
      consentSections: [
        {
          title: "TREATMENT TO BE DONE",
          content: "I understand and consent to have any treatment done by the dentist after the procedure, the risks and benefits & cost have been fully explained. These treatments include, but are not limited to: fillings, cleanings, periodontal maintenance, extractions, root canals, crowns, bridges, implants, and/or dentures."
        },
        {
          title: "DRUGS AND MEDICATIONS",
          content: "I understand that antibiotics, analgesics and other medications can cause allergic reactions like redness and swelling of tissues, pain, itching, vomiting, and/or anaphylactic shock (severe allergic reaction)."
        },
        {
          title: "CHANGES IN TREATMENT PLAN",
          content: "I understand that during treatment it might be necessary to change/add procedures because of conditions found while working on the teeth that may not be discovered until after treatment has begun. For example, root canal therapy may be needed during routine restorative procedures. I give my permission to the dentist to make any/all changes and additions as necessary with my responsibility to pay all the costs signed."
        },
        {
          title: "ANESTHESIA",
          content: "I understand that all forms of anesthesia are necessary as part of diagnostic aids, and/or treatment and come up with relative disposition of my dental problem to make a good treatment plan, but this will not give me in the treatment itself. I understand that all forms of treatment involve some risk to anesthesia that includes but is not limited to swelling, bruising, and/or hematoma and that my responsibility to inform the dentist of any previous experience."
        },
        {
          title: "PERIODONTAL DISEASE",
          content: "I understand that periodontal disease is a serious condition causing gum and bone inflammation and/or loss and that can lead eventually to the loss of my teeth. I understand the alternative treatment plans to correct periodontal disease, including non-surgical cleaning, gum surgery, tooth extraction with or without replacement. I understand that including their risk and benefits prior to authorizing the dentist to remove teeth and any other structures necessary for reasons above. I understand that removing teeth does not always remove all the infection, if present, and it might be necessary to have further treatment. I understand that the success of any dental treatment depends in part on my efforts to brush and floss daily, receive regular cleaning as directed, follow a healthy diet, avoid tobacco products and follow other recommendations. I understand that I am to assist in treatment by decreasing alcohol and tobacco use. I understand that serious complications may result from the extraction of teeth which may involve pain, swelling, infection, dry socket, loss of feeling in my teeth, lips, tongue, and surrounding tissue (paresthesia) that can last for an indefinite period of time or fractured jaw. I understand that I may need further treatment by a specialist if complications arise during or following treatment, for which I am financially responsible."
        },
        {
          title: "CROWN (CAP) & BRIDGES",
          content: "I understand that sometimes it is not possible to match the color of natural teeth exactly with artificial teeth. I further understand that I may be wearing temporary crowns, which may come off easily and that I must be careful to ensure that they are kept on until the permanent crowns are delivered. I realize that the final opportunity to make changes in my new crown, bridge, or cap (including shape, fit, size, placement, and color) will be done before cementation. It is also my responsibility to return for permanent cementation within 20 days from tooth preparation. Excessive delays may allow for tooth movement, necessitating a remake of the crown, bridge, or cap. I understand there will be additional charges for remakes due to my delaying of permanent cementation, and I realize that final cementation may inhibit the ability to make modifications or changes in the new crown, bridge, or cap. I understand that the dental crown procedure may require removing the top of the crown, reducing the tooth structure to allow for the new restorative material to be placed. I understand that sometimes after the crown is cemented, the tooth may require root canal therapy, which may require removing the crown and remaking it after the root canal is completed. I understand that a crown may require removal in order to access to work."
        },
        {
          title: "ENDODONTICS (ROOT CANAL)",
          content: "I understand there is no guarantee that a root canal treatment will save a tooth and can cause from the treatment and will sometimes not cured filing (root canal) through the tooth can also help not necessarily affect the outcome of the treatment. I understand that occasionally additional surgical procedures may be necessary following root canal treatment (apicoectomy). I understand that the tooth may be lost in spite of all efforts to save it. I understand that instruments may separate during the root canal, that may require referral to an endodontist. I understand that a crown may be necessary following root canal treatment and I agree that I am responsible for any additional costs for treatment performed by the endodontist. I understand that a crown may require removal in order to access to work."
        },
        {
          title: "PERIODONTAL DISEASE (REPEATED SECTION)",
          content: "I understand that periodontal disease is a serious condition causing gum and bone inflammation and/or loss and that can lead eventually to the loss of my teeth. I understand the alternative treatment plans to correct periodontal disease, including non-surgical cleaning, gum surgery, tooth extraction with or without replacement. I understand that undertaking any dental procedure may have a future adverse effect on my periodontal condition."
        },
        {
          title: "FILLINGS",
          content: "I understand that care must be exercised in chewing on fillings, especially during the first 24 hours to avoid breakage. I understand that a more extensive filling than originally diagnosed may be required due to additional decay. I understand that significant sensitivity is a common after-effect of a newly placed filling. I further understand that filling large cavities may irritate the tooth nerves which may require root canal therapy or even lead to future tooth extraction."
        },
        {
          title: "DENTURES",
          content: "I understand that wearing dentures can be difficult. Sore spots, altered speech, and difficulty in eating are common problems. Immediate dentures (placement of dentures immediately after extractions) maybe painful. Immediate dentures may require considerable adjusting and several relines. I understand that it is my responsibility to return for delivery of dentures. I understand that failure to keep my delivery appointment may result in poorly fitted dentures. If a remake is required due to my delays of more than 30 days, there will be additional charges. I understand that all adjustment or revision of any kind after initial placement is subject to charges. I understand that dentistry is not an exact science and that therefore, reputable practitioners cannot guarantee results. I acknowledge that no guarantee or assurance has been made by anyone regarding the dental treatment that I have requested and authorized."
        }
      ],
      checkAllConsent: false,
      consentCheckboxes: {
        inexactScience: false,
        authorizeDoctor: false,
        consentToTreatment: false
      },
      questionnaire: {
        goodHealth: null,
        medicalTreatment: null,
        medicalTreatmentDetails: '',
        seriousIllness: null,
        seriousIllnessDetails: '',
        hospitalized: null,
        hospitalizedDetails: '',
        medication: null,
        medicationDetails: '',
        tobacco: null,
        drugs: null,
        allergies: {
          anesthetic: false,
          penicillin: false,
          latex: false,
          sulfa: false,
          aspirin: false,
          others: false
        },
        bleedingTime: '',
        pregnant: null,
        nursing: null,
        birthControl: null,
        bloodType: '',
        bloodPressure: '',
        conditions: {
          highBP: false,
          lowBP: false,
          epilepsy: false,
          aidsHiv: false,
          std: false,
          stomach: false,
          fainting: false,
          weightLoss: false,
          radiation: false,
          joint: false,
          heartSurgery: false,
          heartAttack: false,
          thyroid: false,
          heartDisease: false,
          heartMurmur: false,
          liver: false,
          rheumatic: false,
          hayFever: false,
          respiratory: false,
          hepatitis: false,
          tuberculosis: false,
          swollenAnkles: false,
          kidney: false,
          diabetes: false,
          chestPain: false,
          stroke: false,
          cancer: false,
          anemia: false,
          angina: false,
          asthma: false,
          emphysema: false,
          bleedingProblems: false,
          bloodDiseases: false,
          headInjuries: false,
          arthritis: false,
          others: false
        }
      },
      validationErrors: {
        goodHealth: false,
        medicalTreatment: false,
        medicalTreatmentDetails: false,
        seriousIllness: false,
        seriousIllnessDetails: false,
        hospitalized: false,
        hospitalizedDetails: false,
        medication: false,
        medicationDetails: false,
        tobacco: false,
        drugs: false,
        bleedingTime: false,
        pregnant: false,
        nursing: false,
        birthControl: false,
        bloodType: false,
        bloodPressure: false
      },
      currentStep: 1,
      steps: [
        "Choose Date and Time",
        "Choose Service",
        "Choose Dentist",
        "Confirmation"
      ],
      isConfirmModalOpen: false,
      isSuccessMessageVisible: false,
      isDateModalOpen: false,
      subStep: 'date',
      availableDates: [],
      availableTimes: [],
      bookedTimes: [],
      isModalOpen: false,
      isSuccessModalOpen: false,
      isInfoModalOpen: false,
      infoMessage: "",
      selectedServices: [],
      services: [],
      availableServices: [],
      form: {
        AppointmentDate: '',
        AppointmentTime: '',
        selectedServices: [],
        DentistID: '',
        PatientID: '',
        PatientNote: '',
      },
      events: ref([]),
      unavailableDentistIDs: [],
      dentists: [],
      error: '',
      successMessage: '',
      successDetails: {},
      calendarOptions: {
        events: [],
        selectable: true,
        dateClick: this.handleDateClick.bind(this),
      },
      appointmentId: null,
      blockedDates: [],
      blockedDateReasons: {},
    };
  },
  mounted() {
    this.setupSidebar();
    this.fetchDentists();
    this.fetchServices();
    this.calendarOptions.events = this.events.value;
    this.calendarOptions.dateClick = this.handleDateClick;
  },
  props: {
    firstName: {
      type: String,
      required: true,
    },
    lastName: {
      type: String,
      required: true,
    },
    profilePicture: {
      type: String,
      default: null,
    },
  },
  computed: {
    fullName() {
      return `${this.firstName} ${this.lastName}`;
    },
    totalCost() {
      return this.selectedServices.reduce((total, service) => {
        const serviceData = this.services.find(s => s.ServiceName === service);
        return total + (serviceData ? parseFloat(serviceData.Cost) : 0);
      }, 0);
    },
    allConsentCheckboxesChecked() {
      return this.consentCheckboxes.inexactScience && 
             this.consentCheckboxes.authorizeDoctor && 
             this.consentCheckboxes.consentToTreatment;
    }
  },
  async created() {
    await this.fetchDentists();
    await this.fetchPatientID();
    await this.fetchBlockedDates();
  },
  methods: {
      async fetchPatientData() {
    try {
      const response = await axios.get('/api/patient-data');
      if (response.data.success) {
        this.profilePicture = response.data.patient.profilePicture;
        //console.log('Fetched Profile Picture:', this.profilePicture);
      } else {
        //console.error('Failed to fetch patient data:', response.data.message);
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
      //console.error('Error fetching patient data:', error);
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
    setupSidebar() {
      const arrows = document.querySelectorAll(".arrow");
      arrows.forEach((arrow) => {
        arrow.addEventListener("click", (e) => {
          const arrowParent = e.target.closest("li");
          if (arrowParent) {
            arrowParent.classList.toggle("showMenu");
          }
        });
      });
    },
    toggleSidebar() {
      let sidebar = document.querySelector(".sidebar");
      sidebar.classList.toggle("close");
      // Handle mobile overlay
      const overlay = document.querySelector(".mobile-overlay");
      if (window.innerWidth <= 768) {
        overlay.classList.toggle("active");
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
    async fetchBlockedDates() {
  try {
    const response = await axios.get('/appointments/blocked-dates', {
      withCredentials: true,
    });
    
    // console.log("Raw blocked dates from backend:", response.data);
    
    // Process each date with proper timezone handling for Asia/Manila
    this.blockedDates = response.data.map(date => {
      // console.log("Processing date:", date.Date);
      
      // Handle different possible date formats from backend
      let processedDate;
      
      if (date.Date.includes('T')) {
        // If it's a full datetime string like '2024-01-27T00:00:00.000Z'
        const utcDate = new Date(date.Date);
        console.log("UTC Date object:", utcDate);
        console.log("UTC ISO String:", utcDate.toISOString());
        
        // Convert to Asia/Manila timezone
        const manilaDate = new Date(utcDate.toLocaleString("en-US", {timeZone: "Asia/Manila"}));
        console.log("Manila Date object:", manilaDate);
        
        // Format as YYYY-MM-DD
        const year = manilaDate.getFullYear();
        const month = String(manilaDate.getMonth() + 1).padStart(2, '0');
        const day = String(manilaDate.getDate()).padStart(2, '0');
        processedDate = `${year}-${month}-${day}`;
      } else {
        // If it's already in YYYY-MM-DD format
        processedDate = date.Date;
      }
      
      // console.log("Processed date:", processedDate);
      return processedDate;
    });
    
    this.blockedDateReasons = response.data.reduce((acc, date, index) => {
      const processedDate = this.blockedDates[index];
      acc[processedDate] = date.Reason || 'Date is blocked';
      return acc;
    }, {});
    
    //console.log("Final Blocked Dates:", this.blockedDates);
    //console.log("Final Blocked Date Reasons:", this.blockedDateReasons);
    this.calendarKey = (this.calendarKey || 0) + 1;
  } catch (error) {
    console.error("Error fetching blocked dates:", error);
    this.openInfoModal("Failed to fetch blocked dates. Some dates may be unavailable.");
  }
},
    formatTimeDisplay(time) {
      if (!time) return '';
      const [hours, minutes] = time.split(':');
      const hour = parseInt(hours);
      const ampm = hour >= 12 ? 'PM' : 'AM';
      const formattedHour = hour % 12 || 12;
      return `${formattedHour}:${minutes} ${ampm}`;
    },
    formatDate(dateStr) {
      if (!dateStr) return '';
      const date = new Date(dateStr);
      const options = { year: 'numeric', month: 'long', day: 'numeric' };
      return date.toLocaleDateString('en-US', options);
    },
    toggleAllConsent() {
      if (this.checkAllConsent) {
        this.consentCheckboxes.inexactScience = true;
        this.consentCheckboxes.authorizeDoctor = true;
        this.consentCheckboxes.consentToTreatment = true;
      } else {
        this.consentCheckboxes.inexactScience = false;
        this.consentCheckboxes.authorizeDoctor = false;
        this.consentCheckboxes.consentToTreatment = false;
      }
    },

    restrictBleedingTime(event) {
      let value = event.target.value.replace(/\D/g, ''); // Remove non-digits
      if (value.length > 2) {
        value = value.slice(0, 2); // Limit to two digits (up to 30)
      }
      if (value && (parseInt(value) < 1 || parseInt(value) > 30)) {
        value = ''; // Clear if outside 1-30 range
      }
      this.questionnaire.bleedingTime = value;
      this.validateBleedingTime(); // Update validation state
    },

    validateBleedingTime() {
      const value = this.questionnaire.bleedingTime;
      this.validationErrors.bleedingTime = value !== '' && (parseInt(value) < 1 || parseInt(value) > 30 || isNaN(parseInt(value)));
    },

    validateBloodType() {
      const validBloodTypes = ["A+", "A-", "B+", "B-", "AB+", "AB-", "O+", "O-"];
      const value = this.questionnaire.bloodType;
      this.validationErrors.bloodType = value !== '' && !validBloodTypes.includes(value);
    },

    restrictBloodPressure(event) {
      let value = event.target.value.replace(/\D/g, ''); // Remove non-digits
      if (value.length > 3) {
        value = value.slice(0, 3); // Limit to 3 digits (up to 300)
      }
      this.questionnaire.bloodPressure = value; // Allow input without immediate validation
    },

    validateBloodPressure() {
      const value = this.questionnaire.bloodPressure;
      this.validationErrors.bloodPressure = value !== '' && (parseInt(value) < 30 || parseInt(value) > 300 || isNaN(parseInt(value)) || value.length < 2);
    },

    validateAndProceed() {
  Object.keys(this.validationErrors).forEach(key => {
    this.validationErrors[key] = false;
  });
  let isValid = true;

  // Existing validations
  if (!this.questionnaire.goodHealth) {
    this.validationErrors.goodHealth = true;
    isValid = false;
  }
  if (!this.questionnaire.medicalTreatment) {
    this.validationErrors.medicalTreatment = true;
    isValid = false;
  } else if (this.questionnaire.medicalTreatment === 'yes' && !this.questionnaire.medicalTreatmentDetails) {
    this.validationErrors.medicalTreatmentDetails = true;
    isValid = false;
  }
  if (!this.questionnaire.seriousIllness) {
    this.validationErrors.seriousIllness = true;
    isValid = false;
  } else if (this.questionnaire.seriousIllness === 'yes' && !this.questionnaire.seriousIllnessDetails) {
    this.validationErrors.seriousIllnessDetails = true;
    isValid = false;
  }
  if (!this.questionnaire.hospitalized) {
    this.validationErrors.hospitalized = true;
    isValid = false;
  } else if (this.questionnaire.hospitalized === 'yes' && !this.questionnaire.hospitalizedDetails) {
    this.validationErrors.hospitalizedDetails = true;
    isValid = false;
  }
  if (!this.questionnaire.medication) {
    this.validationErrors.medication = true;
    isValid = false;
  } else if (this.questionnaire.medication === 'yes' && !this.questionnaire.medicationDetails) {
    this.validationErrors.medicationDetails = true;
    isValid = false;
  }
  if (!this.questionnaire.tobacco) {
    this.validationErrors.tobacco = true;
    isValid = false;
  }
  if (!this.questionnaire.drugs) {
    this.validationErrors.drugs = true;
    isValid = false;
  }

  // New validations for additional fields
  this.validateBleedingTime();
  if (this.validationErrors.bleedingTime) isValid = false;

  this.validateBloodPressure();
  if (this.validationErrors.bloodPressure) isValid = false;

  this.validateBloodType();
  // No additional check for isValid here since it's not required

  if (isValid) {
    this.proceedToScheduling();
  } else {
    this.$nextTick(() => {
      const firstError = document.querySelector('.validation-error');
      if (firstError) {
        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
      }
    });
  }
},
    proceedToQuestionnaire() {
      if (this.allConsentCheckboxesChecked) {
        this.currentFormStep = 'questionnaire';
        // Scroll to the top of the page or the home-section
        this.$nextTick(() => {
          window.scrollTo({ top: 0, behavior: 'smooth' });
        });
      } else {
        this.openInfoModal("Please check all consent boxes before proceeding.");
      }
    },
    backToConsent() {
      this.currentFormStep = 'consent';
    },
    proceedToScheduling() {
      this.currentFormStep = 'scheduling';
      this.currentStep = 1;
      this.subStep = 'date';
    },
    cancelAppointment() {
      window.location.href = '/patientappointments';
    },
    async fetchServices() {
      try {
        const response = await axios.get('/services/list?active_only=true');
        //console.log("Services Response:", response.data);
        this.services = response.data;
        this.availableServices = [...this.services];
        //console.log("Available Services:", this.availableServices);
        if (this.availableServices.length === 0) {
          this.openInfoModal("No active services are available at this time.");
        }
      } catch (error) {
        //console.error("Error fetching services:", error);
        this.openInfoModal("Failed to fetch services. Please try again.");
      }
    },
    async fetchDentists() {
      try {
        const response = await axios.get('/get-dentists');
        //console.log("Raw /get-dentists response:", response.data);
        this.dentists = response.data.map(dentist => ({
          DentistID: dentist.DentistID,
          Name: dentist.Name,
          isUnavailable: false
        }));
        //console.log("Processed Dentists:", this.dentists);
      } catch (error) {
        //console.error('Error fetching dentists:', error);
        this.error = 'Failed to fetch dentists. Please try again later.';
      }
    },
    async fetchPatientID() {
      try {
        const response = await axios.get('/get-patient-id');
        this.form.PatientID = response.data.patient_id;
      } catch (error) {
        //console.error('Error fetching patient ID:', error);
        this.error = 'Failed to fetch patient ID. Please log in again.';
      }
    },
    toggleService(serviceName) {
      const index = this.selectedServices.indexOf(serviceName);
      if (index === -1) {
        if (this.selectedServices.length >= 3) {
          this.openInfoModal("You can only select up to 3 services.");
          return;
        }
        this.selectedServices.push(serviceName);
      } else {
        this.selectedServices.splice(index, 1);
      }
      this.form.selectedServices = [...this.selectedServices];
    },
    openConfirmModal() {
      this.isConfirmModalOpen = true;
    },
    closeConfirmModal() {
      this.isConfirmModalOpen = false;
    },
    closeModal() {
      this.isModalOpen = false;
    },
    openSuccessModal() {
      this.isSuccessModalOpen = true;
    },
    closeSuccessModal() {
      this.isSuccessModalOpen = false;
    },
    goToAppointments() {
      window.location.href = '/patientappointments';
    },
    async finalizeBooking() {
    try {
        // Normalize AppointmentTime to H:i format
        let normalizedTime = this.form.AppointmentTime;
        if (normalizedTime) {
            // If time is in 12-hour format (e.g., "9:00 AM"), convert to 24-hour
            if (normalizedTime.includes(' ')) {
                const [time, period] = normalizedTime.split(' ');
                let [hours, minutes] = time.split(':');
                hours = parseInt(hours);
                if (period.toUpperCase() === 'PM' && hours !== 12) {
                    hours += 12;
                } else if (period.toUpperCase() === 'AM' && hours === 12) {
                    hours = 0;
                }
                normalizedTime = `${hours.toString().padStart(2, '0')}:${minutes}`;
            } else {
                // Ensure time is in H:i format (e.g., pad single-digit hours)
                const [hours, minutes] = normalizedTime.split(':');
                normalizedTime = `${hours.padStart(2, '0')}:${minutes.padStart(2, '0')}`;
            }
        }

        const appointmentData = {
            AppointmentDate: this.form.AppointmentDate,
            AppointmentTime: normalizedTime,
            services: this.selectedServices,
            DentistID: this.form.DentistID === 'any' ? null : this.form.DentistID,
            PatientID: this.form.PatientID,
            PatientNote: this.form.PatientNote,
        };

        console.log('Sending appointment data:', appointmentData);

        const response = await axios.post('/patientappointments', appointmentData, {
            headers: { 'Content-Type': 'application/json' },
            withCredentials: true,
        });

        if (response.status === 200 || response.status === 201) {
            this.appointmentId = response.data.appointment?.AppointmentID;
            if (!this.appointmentId) {
                throw new Error('AppointmentID not found in response');
            }
            await this.generateAndSavePDF(this.appointmentId);
            this.successMessage = 'Appointment booked successfully! Check your email for confirmation details.';
            this.isSuccessMessageVisible = true;
            this.isConfirmModalOpen = false;
            this.resetForm();
        }
    } catch (error) {
        console.error('Error saving appointment:', error.response?.data || error.message);
        this.openInfoModal(error.response?.data?.message || 'An error occurred while confirming the appointment.');
        this.isConfirmModalOpen = false;
    }
},
    async generateAndSavePDF(appointmentId) {
      try {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF({
          orientation: 'portrait',
          unit: 'mm',
          format: 'a4'
        });
        let yPos = 20;
        const pageWidth = doc.internal.pageSize.width;
        const margin = 20;
        const contentWidth = pageWidth - (margin * 2);
        const addNewPage = () => {
          doc.addPage();
          yPos = 20;
        };
        const checkForNewPage = (heightNeeded) => {
          if (yPos + heightNeeded > 270) {
            addNewPage();
            return true;
          }
          return false;
        };
        const addWrappedText = (text, x, y, maxWidth, lineHeight = 4) => {
          const lines = doc.splitTextToSize(text, maxWidth);
          doc.text(lines, x, y);
          return y + (lines.length * lineHeight);
        };
        const addSectionTitle = (title) => {
          checkForNewPage(8);
          doc.setFont(undefined, 'bold');
          doc.setFontSize(12);
          doc.text(title, margin, yPos);
          yPos += 5;
          doc.setFont(undefined, 'normal');
          doc.setFontSize(10);
        };
        const addSection = (title, content) => {
          checkForNewPage(15);
          addSectionTitle(title);
          yPos = addWrappedText(content, margin, yPos, contentWidth);
          yPos += 3;
        };
        doc.setFont(undefined, 'bold');
        doc.setFontSize(14);
        doc.text("APPOINTMENT DETAILS", margin, yPos);
        yPos += 8;
        doc.setFont(undefined, 'normal');
        doc.setFontSize(10);
        doc.text(`Date: ${this.form.AppointmentDate || 'N/A'}`, margin, yPos);
        yPos += 5;
        doc.text(`Time: ${this.formatTimeDisplay(this.form.AppointmentTime) || 'N/A'}`, margin, yPos);
        yPos += 5;
        doc.text(`Patient: ${this.fullName}`, margin, yPos);
        yPos += 10;
        doc.setFont(undefined, 'bold');
        doc.setFontSize(14);
        doc.text("INFORMED CONSENT", pageWidth / 2, yPos, { align: 'center' });
        yPos += 8;
        doc.setFont(undefined, 'normal');
        doc.setFontSize(8);
        for (const section of this.consentSections) {
          const estimatedHeight = 5 + (section.content.length / 80) * 4;
          checkForNewPage(estimatedHeight);
          doc.setFont(undefined, 'bold');
          doc.text(section.title, margin, yPos);
          yPos += 4;
          doc.setFont(undefined, 'normal');
          yPos = addWrappedText(section.content, margin, yPos, contentWidth, 4);
          yPos += 3;
        }
        checkForNewPage(25);
        doc.setFont(undefined, 'bold');
        doc.setFontSize(10);
        doc.text("PATIENT CONSENT:", margin, yPos);
        yPos += 6;
        doc.setFont(undefined, 'normal');
        doc.setFontSize(9);
        doc.text(`I understand that dentistry is not an exact science : ${this.consentCheckboxes.inexactScience ? 'Yes' : 'No'}`, margin, yPos);
        yPos += 5;
        doc.text(`I hereby authorize any of the doctors/staff/assistants to proceed with and perform : ${this.consentCheckboxes.authorizeDoctor ? 'Yes' : 'No'}`, margin, yPos);
        yPos += 5;
        doc.text(`I acknowledge that I have read and understand the informed consent information : ${this.consentCheckboxes.consentToTreatment ? 'Yes' : 'No'}`, margin, yPos);
        yPos += 8;
        addNewPage();
        doc.setFont(undefined, 'bold');
        doc.setFontSize(16);
        doc.text("Patient Health Questionnaires", pageWidth / 2, yPos, { align: 'center' });
        yPos += 15;
        const addQuestionWithRadios = (number, question, answer) => {
          checkForNewPage(8);
          doc.setFont(undefined, 'normal');
          doc.setFontSize(10);
          doc.text(`${number}. ${question}`, margin, yPos);
          const yesX = pageWidth - margin - 60;
          doc.setDrawColor(100, 100, 100);
          doc.setFillColor(255, 255, 255);
          doc.circle(yesX, yPos - 1, 2, 'FD');
          if (answer === 'yes') {
            doc.setFillColor(150, 150, 150);
            doc.circle(yesX, yPos - 1, 1, 'F');
          }
          doc.text("YES", yesX + 5, yPos);
          const noX = pageWidth - margin - 30;
          doc.setDrawColor(100, 100, 100);
          doc.setFillColor(255, 255, 255);
          doc.circle(noX, yPos - 1, 2, 'FD');
          if (answer === 'no') {
            doc.setFillColor(150, 150, 150);
            doc.circle(noX, yPos - 1, 1, 'F');
          }
          doc.text("NO", noX + 5, yPos);
          yPos += 7;
          return yPos;
        };
        addQuestionWithRadios("1", "Are you in good health?", this.questionnaire.goodHealth);
        addQuestionWithRadios("2", "Are you under medical treatment now?", this.questionnaire.medicalTreatment);
        addQuestionWithRadios("3", "Have you ever had a serious illness or surgical operation?", this.questionnaire.seriousIllness);
        addQuestionWithRadios("4", "Have you ever been hospitalized?", this.questionnaire.hospitalized);
        addQuestionWithRadios("5", "Are you taking any prescription/non-prescription medication?", this.questionnaire.medication);
        addQuestionWithRadios("6", "Do you use tobacco products?", this.questionnaire.tobacco);
        addQuestionWithRadios("7", "Do you use alcohol, cocaine, or other dangerous drugs?", this.questionnaire.drugs);
        yPos += 3;
        doc.setFont(undefined, 'bold');
        doc.text("8. Are you allergic to any of the following:", margin, yPos);
        yPos += 8;
        const allergies = [
          { name: "Local Anesthetic (ex. lidocaine)", value: this.questionnaire.allergies.anesthetic },
          { name: "Penicillin/Antibiotics", value: this.questionnaire.allergies.penicillin },
          { name: "Latex", value: this.questionnaire.allergies.latex },
          { name: "Sulfa Drugs", value: this.questionnaire.allergies.sulfa },
          { name: "Aspirin", value: this.questionnaire.allergies.aspirin },
          { name: "Others", value: this.questionnaire.allergies.others }
        ];
        let rowY = yPos;
        let colX = margin;
        for (let i = 0; i < allergies.length; i++) {
          doc.setDrawColor(100, 100, 100);
          doc.setFillColor(allergies[i].value ? 200 : 255, allergies[i].value ? 200 : 255, allergies[i].value ? 200 : 255);
          doc.rect(colX, rowY - 3, 3, 3, 'FD');
          doc.setFont(undefined, 'normal');
          doc.text(allergies[i].name, colX + 5, rowY);
          if (i % 2 === 0) {
            colX = pageWidth / 2;
          } else {
            colX = margin;
            rowY += 7;
          }
        }
        yPos = rowY + 8;
        doc.setFont(undefined, 'bold');
        doc.text("9. Bleeding Time:", margin, yPos);
        doc.setFont(undefined, 'normal');
        doc.text(this.questionnaire.bleedingTime || 'N/A', margin + 40, yPos);
        yPos += 7;
        doc.setFont(undefined, 'bold');
        doc.text("10. For Women only:", margin, yPos);
        yPos += 7;
        doc.setFont(undefined, 'normal');
        doc.text("Are you pregnant?", margin + 10, yPos);
        const pregYesX = margin + 80;
        doc.setDrawColor(100, 100, 100);
        doc.setFillColor(255, 255, 255);
        doc.circle(pregYesX, yPos - 1, 2, 'FD');
        if (this.questionnaire.pregnant === 'yes') {
          doc.setFillColor(150, 150, 150);
          doc.circle(pregYesX, yPos - 1, 1, 'F');
        }
        doc.text("YES", pregYesX + 5, yPos);
        const pregNoX = margin + 110;
        doc.setDrawColor(100, 100, 100);
        doc.setFillColor(255, 255, 255);
        doc.circle(pregNoX, yPos - 1, 2, 'FD');
        if (this.questionnaire.pregnant === 'no') {
          doc.setFillColor(150, 150, 150);
          doc.circle(pregNoX, yPos - 1, 1, 'F');
        }
        doc.text("NO", pregNoX + 5, yPos);
        yPos += 7;
        doc.text("Are you nursing?", margin + 10, yPos);
        const nurseYesX = margin + 80;
        doc.setDrawColor(100, 100, 100);
        doc.setFillColor(255, 255, 255);
        doc.circle(nurseYesX, yPos - 1, 2, 'FD');
        if (this.questionnaire.nursing === 'yes') {
          doc.setFillColor(150, 150, 150);
          doc.circle(nurseYesX, yPos - 1, 1, 'F');
        }
        doc.text("YES", nurseYesX + 5, yPos);
        const nurseNoX = margin + 110;
        doc.setDrawColor(100, 100, 100);
        doc.setFillColor(255, 255, 255);
        doc.circle(nurseNoX, yPos - 1, 2, 'FD');
        if (this.questionnaire.nursing === 'no') {
          doc.setFillColor(150, 150, 150);
          doc.circle(nurseNoX, yPos - 1, 1, 'F');
        }
        doc.text("NO", nurseNoX + 5, yPos);
        yPos += 7;
        doc.text("Are you taking birth control pills?", margin + 10, yPos);
        const bcYesX = margin + 80;
        doc.setDrawColor(100, 100, 100);
        doc.setFillColor(255, 255, 255);
        doc.circle(bcYesX, yPos - 1, 2, 'FD');
        if (this.questionnaire.birthControl === 'yes') {
          doc.setFillColor(150, 150, 150);
          doc.circle(bcYesX, yPos - 1, 1, 'F');
        }
        doc.text("YES", bcYesX + 5, yPos);
        const bcNoX = margin + 110;
        doc.setDrawColor(100, 100, 100);
        doc.setFillColor(255, 255, 255);
        doc.circle(bcNoX, yPos - 1, 2, 'FD');
        if (this.questionnaire.birthControl === 'no') {
          doc.setFillColor(150, 150, 150);
          doc.circle(bcNoX, yPos - 1, 1, 'F');
        }
        doc.text("NO", bcNoX + 5, yPos);
        yPos += 8;
        doc.setFont(undefined, 'bold');
        doc.text("11. Blood Type:", margin, yPos);
        doc.setFont(undefined, 'normal');
        doc.text(this.questionnaire.bloodType || 'N/A', margin + 40, yPos);
        yPos += 7;
        doc.setFont(undefined, 'bold');
        doc.text("12. Blood Pressure:", margin, yPos);
        doc.setFont(undefined, 'normal');
        doc.text(this.questionnaire.bloodPressure || 'N/A', margin + 50, yPos);
        yPos += 8;
        doc.setFont(undefined, 'bold');
        doc.text("13. Do you have or have you had any of the following? (Check what apply)", margin, yPos);
        yPos += 8;
        const conditions = [
          { name: "High Blood Pressure", value: this.questionnaire.conditions.highBP },
          { name: "Low Blood Pressure", value: this.questionnaire.conditions.lowBP },
          { name: "Epilepsy/Convulsions", value: this.questionnaire.conditions.epilepsy },
          { name: "AIDS/HIV Infection", value: this.questionnaire.conditions.aids },
          { name: "Sexually Transmitted Disease", value: this.questionnaire.conditions.std },
          { name: "Stomach Troubles/Ulcers", value: this.questionnaire.conditions.stomachTrouble },
          { name: "Fainting Seizures", value: this.questionnaire.conditions.fainting },
          { name: "Rapid Weight Loss", value: this.questionnaire.conditions.weightLoss },
          { name: "Radiation Therapy", value: this.questionnaire.conditions.radiationTherapy },
          { name: "Joint Replacement/Implant", value: this.questionnaire.conditions.jointReplacement },
          { name: "Heart Surgery", value: this.questionnaire.conditions.heartSurgery },
          { name: "Heart Attack", value: this.questionnaire.conditions.heartAttack },
          { name: "Thyroid Problem", value: this.questionnaire.conditions.thyroid },
          { name: "Heart Disease", value: this.questionnaire.conditions.heartDisease },
          { name: "Heart Murmur", value: this.questionnaire.conditions.heartMurmur },
          { name: "Hepatitis/Liver Disease", value: this.questionnaire.conditions.hepatitis },
          { name: "Rheumatic Fever", value: this.questionnaire.conditions.rheumaticFever },
          { name: "Hay Fever/Allergies", value: this.questionnaire.conditions.hayFever },
          { name: "Respiratory Problems", value: this.questionnaire.conditions.respiratory },
          { name: "Hepatitis/Jaundice", value: this.questionnaire.conditions.hepatitis },
          { name: "Tuberculosis", value: this.questionnaire.conditions.tubercolosis },
          { name: "Swollen Ankles", value: this.questionnaire.conditions.swollenAnkles },
          { name: "Kidney Disease", value: this.questionnaire.conditions.kidneyDisease },
          { name: "Diabetes", value: this.questionnaire.conditions.diabetes },
          { name: "Chest Pain", value: this.questionnaire.conditions.chestPain },
          { name: "Stroke", value: this.questionnaire.conditions.stroke },
          { name: "Cancer/Tumor", value: this.questionnaire.conditions.cancer },
          { name: "Anemia", value: this.questionnaire.conditions.anemia },
          { name: "Angina", value: this.questionnaire.conditions.angina },
          { name: "Asthma", value: this.questionnaire.conditions.asthma },
          { name: "Emphysema", value: this.questionnaire.conditions.emphysema },
          { name: "Bleeding Problems", value: this.questionnaire.conditions.bleedingProblems },
          { name: "Blood Diseases", value: this.questionnaire.conditions.bloodeDisease },
          { name: "Head Injuries", value: this.questionnaire.conditions.headInjuries },
          { name: "Arthritis/Rheumatism", value: this.questionnaire.conditions.arthritis },
          { name: "Others", value: this.questionnaire.conditions.others }
        ];
        const colCount = 4;
        const colWidth = (pageWidth - (margin * 2)) / colCount;
        let currentCol = 0;
        let currentRow = yPos;
        for (let i = 0; i < conditions.length; i++) {
          const xPosition = margin + (currentCol * colWidth);
          doc.setDrawColor(100, 100, 100);
          doc.setFillColor(conditions[i].value ? 200 : 255, conditions[i].value ? 200 : 255, conditions[i].value ? 200 : 255);
          doc.rect(xPosition, currentRow - 3, 3, 3, 'FD');
          doc.setFont(undefined, 'normal');
          doc.setFontSize(8);
          doc.text(conditions[i].name, xPosition + 5, currentRow);
          currentCol++;
          if (currentCol >= colCount) {
            currentCol = 0;
            currentRow += 6;
            if (currentRow > 270) {
              addNewPage();
              currentRow = yPos;
            }
          }
        }
        const pdfBlob = doc.output('blob');
        //console.log('PDF Blob created:', pdfBlob);
        const formData = new FormData();
        formData.append('PatientID', this.form.PatientID);
        formData.append('AppointmentID', appointmentId);
        formData.append('FileName', 'Consent Form');
        formData.append('FileType', 'application/pdf');
        formData.append('FileContent', pdfBlob, `consent_form_${appointmentId}.pdf`);
        const uploadResponse = await axios.post('/save-dental-form', formData, {
          headers: { 'Content-Type': 'multipart/form-data' },
          withCredentials: true,
        });
        //console.log('PDF saved successfully:', uploadResponse.data);
        return true;
      } catch (error) {
        //console.error('Error generating or saving PDF:', error);
        const errorMessage = error.response?.data?.message || error.message || 'Failed to generate or save the consent form and questionnaire PDF.';
        // console.log("PDF error details:", {
        //   status: error.response?.status,
        //   data: error.response?.data,
        //   message: errorMessage,
        // });
        this.openInfoModal(errorMessage);
        throw error;
      }
    },
    resetForm() {
      this.form = {
        AppointmentDate: '',
        AppointmentTime: '',
        selectedServices: [],
        DentistID: '',
        PatientNote: '',
        PatientID: this.form.PatientID,
      };
      this.selectedServices = [];
    },
    async handleDateClick(info) {
      const clickedDate = new Date(info.dateStr);
      const today = new Date();
      const tomorrow = new Date(today);
      tomorrow.setDate(today.getDate() + 1);
      const dateString = info.dateStr;

      // Check if the selected date is a Sunday
      if (clickedDate.getDay() === 0) {
        this.openInfoModal("The clinic is closed on Sundays. Please select a different date.");
        return;
      }

      // Check for past dates, today, or tomorrow
      if (
        clickedDate < today ||
        clickedDate.toDateString() === today.toDateString() ||
        clickedDate.toDateString() === tomorrow.toDateString()
      ) {
        this.openInfoModal("Bookings must be made 2 days in advance. Please select a different date.");
        return;
      }

      // Check for blocked dates
      if (this.blockedDates.includes(dateString)) {
        const reason = this.blockedDateReasons[dateString];
        const message = reason ? `This date is blocked because ${reason}` : "This date is blocked and unavailable for booking.";
        this.openInfoModal(message);
        return;
      }

      try {
        // Check if the patient already has an appointment on the selected date
        const response = await axios.get('/check-appointment-date', {
          params: { date: info.dateStr },
          withCredentials: true,
        });
        if (response.data.hasAppointment) {
          this.openInfoModal(response.data.message);
          return;
        }

        // Fetch dentist availability
        const availabilityResponse = await axios.get(`/dentist-availability/${info.dateStr}`, {
          withCredentials: true,
        });
        this.unavailableDentistIDs = availabilityResponse.data.unavailable_dentists;
        //console.log("Date Selected:", info.dateStr);
        //console.log("Unavailable Dentists (DentistIDs):", this.unavailableDentistIDs);

        // Update dentist availability
        this.dentists.forEach(dentist => {
          dentist.isUnavailable = this.unavailableDentistIDs.includes(dentist.DentistID);
          //console.log(`Dentist: ${dentist.Name}, DentistID: ${dentist.DentistID}, isUnavailable: ${dentist.isUnavailable}`);
        });

        // Proceed to time selection
        this.selectDate(info.dateStr);
      } catch (error) {
        //console.error("Error checking date or dentist availability:", error);
        this.openInfoModal("Failed to check date availability. Please try again.");
      }
    },
    openInfoModal(message) {
      this.infoMessage = message;
      this.isInfoModalOpen = true;
    },
    closeInfoModal() {
      this.isInfoModalOpen = false;
    },
    isDateDisabled(date) {
      const today = new Date();
      const clickedDate = new Date(date);
      return clickedDate < today;
    },
    setCurrentStep(step) {
      if (this.isStepClickable(step)) {
        this.currentStep = step;
        if (step === 1) {
          this.subStep = 'date';
        }
      }
    },
    isStepClickable(step) {
      return step <= this.currentStep;
    },
    selectDate(date) {
      this.form.AppointmentDate = date;
      this.subStep = 'time';
      //console.log("subStep:", this.subStep);
      this.generateAvailableTimes();
    },
    setSubStep(step) {
      this.subStep = step;
    },
    generateAvailableTimes() {
      //console.log("Generating available times for date:", this.form.AppointmentDate);
      const times = [];
      let startTime = 9;
      const endTime = 16;
      for (let hour = startTime; hour <= endTime; hour++) {
        const formattedTime = `${hour}:00`;
        times.push({ time: formattedTime, is_available: true });
      }
      this.availableTimes = times;
      //console.log("Generated times:", this.availableTimes);
      this.filterTimesFromBackend();
    },
    async filterTimesFromBackend() {
      //console.log("Filtering available times for date:", this.form.AppointmentDate);
      try {
        const payload = {
          date: this.form.AppointmentDate,
          times: this.availableTimes.map(slot => slot.time),
        };
        //console.log("Request payload:", payload);
        const response = await axios.post('/filter-available-times', payload, {
          withCredentials: true,
        });
        const timeSlots = response.data.time_slots;
        this.availableTimes = this.availableTimes.map(slot => {
          const updatedSlot = timeSlots.find(ts => ts.time === slot.time);
          return {
            time: slot.time,
            is_available: updatedSlot ? updatedSlot.is_available : false,
          };
        });
        //console.log("Updated time slots:", this.availableTimes);
      } catch (error) {
        //console.error("Error filtering available times:", error.response?.data || error.message);
        this.openInfoModal("Failed to filter available times. Showing all times as a fallback.");
        this.availableTimes = this.availableTimes.map(slot => ({
          time: slot.time,
          is_available: true,
        }));
      }
    },
    selectTime(time) {
      const slot = this.availableTimes.find(slot => slot.time === time);
      if (slot && slot.is_available) {
        this.form.AppointmentTime = time;
      }
    },
    getServiceCost(serviceName) {
      const service = this.services.find(s => s.ServiceName === serviceName);
      return service ? parseFloat(service.Cost) : 0;
    },
    async proceedToNextStep() {
      if (this.currentStep === 2) {
        if (this.selectedServices.length === 0) {
          this.openInfoModal("Please select at least one service.");
          return;
        }
        this.form.selectedServices = [...this.selectedServices];
        try {
          for (let dentist of this.dentists) {
            if (dentist.isUnavailable) continue;
            const response = await axios.get('/check-dentist-availability', {
              params: {
                dentist_id: dentist.DentistID,
                date: this.form.AppointmentDate,
                time: this.form.AppointmentTime,
                service_count: this.selectedServices.length,
              },
              withCredentials: true,
            });
            dentist.isUnavailable = !response.data.is_available;
            //console.log(`Dentist ${dentist.Name} (ID: ${dentist.DentistID}) isUnavailable: ${dentist.isUnavailable}`);
          }
        } catch (error) {
          //console.error("Error checking dentist availability:", error);
          this.openInfoModal("Failed to check dentist availability. Please try again.");
          return;
        }
      }
      if (this.currentStep < this.steps.length) {
        this.currentStep++;
      }
    },
    goBack() {
      if (this.currentStep > 1) {
        this.currentStep--;
        if (this.currentStep <= 2) {
          this.dentists.forEach(dentist => {
            dentist.isUnavailable = false;
          });
          this.form.DentistID = '';
        }
      }
    },
    getDentistName(DentistID) {
      if (!DentistID) {
        return "Unknown Dentist";
      }
      const dentist = this.dentists.find(dentist => dentist.DentistID === DentistID);
      return dentist ? dentist.Name : "Unknown Dentist";
    },
    async selectDentist(dentistId) {
      if (dentistId === 'any') {
        this.form.DentistID = dentistId;
        return;
      }
      const dentist = this.dentists.find(d => d.DentistID === dentistId);
      if (dentist.isUnavailable) {
        this.openInfoModal(`${dentist.Name} is unavailable on ${this.form.AppointmentDate}.`);
        return;
      }
      try {
        const response = await axios.get('/check-dentist-availability', {
          params: {
            dentist_id: dentistId,
            date: this.form.AppointmentDate,
            time: this.form.AppointmentTime,
            service_count: this.selectedServices.length,
          },
          withCredentials: true,
        });
        if (response.data.is_available) {
          this.form.DentistID = dentistId;
          //console.log(`Selected Dentist: ${dentist.Name}, DentistID: ${dentistId}`);
        } else {
          dentist.isUnavailable = true;
          this.openInfoModal(`${dentist.Name} is unavailable for the selected time and duration.`);
        }
      } catch (error) {
        //console.error("Error checking dentist availability:", error);
        this.openInfoModal("Failed to check dentist availability. Please try again.");
      }
    },
  },
  setup(props, { expose }) {
  const blockedDates = ref([]);
  const blockedDateReasons = ref({});

  const calendarOptions = ref({
    plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
    initialView: 'dayGridMonth',
    height: 'auto',
    headerToolbar: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,timeGridWeek,timeGridDay',
    },
    buttonText: {
      today: 'Today',
      month: 'Month',
      week: 'Week',
      day: 'Day',
    },
    dateClick: null, // Bound in mounted()
    eventClick: (info) => {
      alert('Event clicked: ' + info.event.title);
    },
    dayCellDidMount: (arg) => {
      // Ensure consistent date formatting - use local date
      const year = arg.date.getFullYear();
      const month = String(arg.date.getMonth() + 1).padStart(2, '0');
      const day = String(arg.date.getDate()).padStart(2, '0');
      const dateString = `${year}-${month}-${day}`;
      
      const today = new Date();
      const tomorrow = new Date(today);
      tomorrow.setDate(today.getDate() + 1);
      const clickedDate = new Date(arg.date);

      // Apply disabled-date class for past dates, today, or tomorrow
      if (
        clickedDate < today ||
        clickedDate.toDateString() === today.toDateString() ||
        clickedDate.toDateString() === tomorrow.toDateString()
      ) {
        arg.el.classList.add('disabled-date');
      }

      // Apply sunday-blocked class for Sundays
      if (clickedDate.getDay() === 0) {
        arg.el.classList.add('sunday-blocked');
      }

      // Apply fc-day-blocked class and tooltip for blocked dates
      if (blockedDates.value.includes(dateString)) {
        arg.el.classList.add('fc-day-blocked');
        const reason = blockedDateReasons.value[dateString] || 'Date is blocked';
        
        // Create tooltip element
        const tooltip = document.createElement('div');
        tooltip.className = 'blocked-date-tooltip';
        tooltip.textContent = reason;
        tooltip.style.display = 'none';
        arg.el.appendChild(tooltip);

        // Show tooltip on hover
        arg.el.addEventListener('mouseenter', () => {
          const rect = arg.el.getBoundingClientRect();
          tooltip.style.display = 'block';
          tooltip.style.top = `${rect.top - 40}px`;
          tooltip.style.left = `${rect.left + rect.width / 2}px`;
          tooltip.style.transform = 'translateX(-50%)';
        });

        arg.el.addEventListener('mouseleave', () => {
          tooltip.style.display = 'none';
        });
      }
    },
  });

  expose({ blockedDates, blockedDateReasons });

  return {
    calendarOptions,
    blockedDates,
    blockedDateReasons,
  };
},
});
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
  background: #F2F2F2;
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

/* Consent form styles */
.dental-consent-container {
  background-color: white;
  border: 1px solid #e0e0e0;
  border-radius: 15px;
  padding: 30px;
  margin: 20px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}

.dental-consent-title {
  text-align: center;
  font-size: 28px;
  font-weight: bold;
  margin-bottom: 30px;
  margin-top: 15px;
  color: #06693A;
}

.dental-consent-section {
  margin-bottom: 20px;
  padding: 15px;
  background: #f8f9fa;
  border-radius: 8px;
  border-left: 4px solid #06693A;
}

.dental-consent-section-title {
  font-size: 16px;
  font-weight: bold;
  margin-bottom: 10px;
  text-transform: uppercase;
  color: #06693A;
}

.dental-consent-section-content {
  font-size: 14px;
  line-height: 1.6;
  text-align: justify;
  color: #333;
}

.dental-consent-buttons {
  display: flex;
  justify-content: flex-end;
  gap: 15px;
  margin-top: 30px;
}

.dental-consent-button {
  padding: 12px 24px;
  border: 1px solid #ccc;
  background-color: #f5f5f5;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 500;
  transition: all 0.3s ease;
}

.dental-consent-button:hover {
  background-color: #e8e8e8;
}

.dental-consent-agree-button {
  background-color: #06693a;
  color: white;
  border-color: #06693a;
}

.dental-consent-agree-button:hover {
  background-color: #055d34;
}

.dental-consent-agree-button:disabled {
  background-color: #cccccc;
  color: #666666;
  cursor: not-allowed;
  border-color: #cccccc;
}

.dental-consent-signature-line {
  font-size: 14px;
  margin-top: 25px;
  border-top: 1px solid #e0e0e0;
  padding-top: 20px;
}

.dental-consent-checkbox-container {
  display: flex;
  align-items: flex-start;
  gap: 12px;
  margin-bottom: 15px;
}

.dental-consent-checkbox-container input[type="checkbox"] {
  margin-top: 2px;
  flex-shrink: 0;
}

.dental-consent-checkbox-container label {
  font-size: 14px;
  line-height: 1.6;
  text-align: justify;
  color: #333;
}

/* Questionnaire styles */
.patient-questionnaire-container {
  background-color: white;
  border: 1px solid #e0e0e0;
  border-radius: 15px;
  padding: 30px;
  margin: 20px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}

.questionnaire-title {
  text-align: center;
  font-size: 28px;
  font-weight: bold;
  margin-top: 15px;
  margin-bottom: 30px;
  color: #06693A;
}

.required-fields-notice {
  margin-bottom: 25px;
  padding: 15px;
  background: #f0f7f4;
  border-radius: 8px;
  border-left: 4px solid #06693A;
}

.required-fields-notice p {
  color: #666;
  margin: 0;
}

.note {
  color: #06693A;
  font-weight: 600;
}

.required-asterisk {
  color: #e74c3c;
  font-weight: bold;
  margin-left: 3px;
}

.questionnaire-form {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.question-row {
  display: flex;
  align-items: flex-start;
  padding: 15px 0;
  border-bottom: 1px solid #f0f0f0;
}

.question-number {
  width: 40px;
  font-weight: bold;
  color: #06693A;
  flex-shrink: 0;
}

.question-text {
  flex: 1;
  margin-right: 20px;
  font-weight: 500;
  color: #333;
}

.question-hint {
  font-size: 0.85em;
  color: #666;
  font-style: italic;
  margin-top: 5px;
}

.optional-text {
  font-size: 0.9em;
  color: #666;
  margin-left: 5px;
}

.question-options {
  display: flex;
  gap: 20px;
  flex-shrink: 0;
}

.radio-option {
  display: flex;
  align-items: center;
  gap: 8px;
  cursor: pointer;
}

.question-input {
  min-width: 200px;
  flex-shrink: 0;
}

.text-input {
  width: 100%;
  padding: 8px 12px;
  border: 1px solid #ddd;
  border-radius: 6px;
  font-size: 14px;
  transition: border-color 0.2s;
}

.text-input:focus {
  outline: none;
  border-color: #06693A;
  box-shadow: 0 0 0 2px rgba(6, 105, 58, 0.1);
}

.invalid-input {
  border-color: #e74c3c !important;
  background-color: rgba(231, 76, 60, 0.05) !important;
  box-shadow: 0 0 0 2px rgba(231, 76, 60, 0.1) !important;
}

.validation-error {
  color: #e74c3c;
  font-size: 12px;
  margin-left: 40px;
  margin-top: 5px;
  animation: fadeIn 0.3s ease-in-out;
}

.conditional-field {
  display: flex;
  align-items: flex-start;
  margin-left: 40px;
  margin-top: 10px;
  padding: 10px;
  background: #f8f9fa;
  border-radius: 6px;
  animation: fadeIn 0.3s ease-in-out;
}

.conditional-text {
  min-width: 250px;
  font-style: italic;
  color: #06693a;
  margin-right: 15px;
}

.conditional-input {
  flex: 1;
}

.allergies-container {
  margin-left: 40px;
  margin-top: 15px;
}

.allergies-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 15px;
}

.allergy-option {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 8px;
  background: #f8f9fa;
  border-radius: 6px;
}

.medical-conditions-container {
  margin-left: 40px;
  margin-top: 15px;
}

.medical-conditions-grid {
  display: grid;
  grid-template-columns: repeat(6, 1fr);
  gap: 10px;
}

.condition-option {
  display: flex;
  align-items: flex-start;
  gap: 8px;
  padding: 8px;
  background: #f8f9fa;
  border-radius: 6px;
  margin-bottom: 5px;
}

.condition-option input[type="checkbox"] {
  margin-top: 2px;
  flex-shrink: 0;
}

.condition-option label {
  font-size: 13px;
  line-height: 1.4;
}

.sub-questions {
  margin-left: 40px;
  margin-top: 15px;
}

.sub-question {
  margin-bottom: 15px;
  padding: 10px;
  background: #f8f9fa;
  border-radius: 6px;
}

.questionnaire-buttons {
  display: flex;
  justify-content: flex-end;
  gap: 15px;
  margin-top: 30px;
}

.questionnaire-button {
  padding: 12px 24px;
  border: 1px solid #ccc;
  background-color: #f5f5f5;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 500;
  transition: all 0.3s ease;
}

.cancel-button:hover {
  background-color: #e8e8e8;
}

.save-button {
  background-color: #06693a;
  color: white;
  border-color: #06693a;
}

.save-button:hover {
  background-color: #055d34;
}

/* Custom checkbox and radio styling */
input[type="checkbox"] {
  appearance: none;
  -webkit-appearance: none;
  width: 20px;
  height: 20px;
  border: 2px solid #06693a;
  border-radius: 4px;
  outline: none;
  cursor: pointer;
  position: relative;
  background-color: white;
  margin-right: 8px;
}

input[type="checkbox"]:checked {
  background-color: #06693a;
}

input[type="checkbox"]:checked::after {
  content: '✓';
  position: absolute;
  color: white;
  font-size: 14px;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  font-weight: bold;
}

input[type="radio"] {
  appearance: none;
  -webkit-appearance: none;
  width: 20px;
  height: 20px;
  border: 2px solid #06693a;
  border-radius: 50%;
  outline: none;
  cursor: pointer;
  position: relative;
  background-color: white;
  margin-right: 8px;
}

input[type="radio"]:checked {
  border: 2px solid #06693a;
}

input[type="radio"]:checked::after {
  content: '';
  position: absolute;
  width: 10px;
  height: 10px;
  background-color: #06693a;
  border-radius: 50%;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

/* Calendar and scheduling styles */
.calendar-container {
  margin: 20px;
  padding: 25px;
  border: 1px solid #ddd;
  background-color: #FFFFFF;
  border-radius: 15px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}

/* Improved Date/Time Selection Tabs */
.date-time-tabs {
  display: flex;
  justify-content: center;
  gap: 20px;
  margin: 30px 20px;
}

.date-time-tab {
  flex: 1;
  max-width: 300px;
  padding: 15px;
  font-size: 16px;
  border: none;
  background-color: #f0f0f0;
  cursor: pointer;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  font-weight: 500;
  transition: all 0.3s ease;
  color: #555;
  box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.date-time-tab i {
  font-size: 20px;
}

.date-time-tab.active {
  background-color: #06693a;
  color: white;
  box-shadow: 0 4px 8px rgba(6, 105, 58, 0.2);
}

.date-time-tab:hover:not(.active):not(:disabled) {
  background-color: #e0e0e0;
  transform: translateY(-2px);
}

.date-time-tab:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.container-time {
  margin: 0 20px;
}

.time-container {
  background-color: white;
  border-radius: 15px;
  padding: 25px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}

.time-heading {
  font-size: 18px;
  color: #06693a;
  margin-bottom: 20px;
  text-align: center;
  font-weight: 600;
}

.time-buttons {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
  gap: 15px;
  padding: 10px 0;
}

.time-button {
  padding: 15px;
  border: 1px solid #ddd;
  background-color: #f9f9f9;
  border-radius: 10px;
  cursor: pointer;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 8px;
  transition: all 0.3s ease;
  font-weight: 500;
}

.time-button i {
  font-size: 20px;
  color: #06693a;
}

.time-button:hover:not(.unavailable) {
  background-color: #f0f0f0;
  transform: translateY(-3px);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.time-button.selected {
  background-color: #06693a;
  color: white;
  border-color: #06693a;
}

.time-button.selected i {
  color: white;
}

.time-button.unavailable {
  background-color: #e0e0e0;
  border-color: #bbb;
  color: #666;
  cursor: not-allowed;
}

.time-button.unavailable i {
  color: #666;
}

.time-button.unavailable:hover {
  background-color: #e0e0e0;
  transform: none;
}

/* Improved Booking Progress Steps */
.booking-progress {
  display: flex;
  justify-content: space-between;
  margin: 30px 20px;
  position: relative;
}

.booking-progress::before {
  content: '';
  position: absolute;
  top: 25px;
  left: 0;
  width: 100%;
  height: 3px;
  background-color: #e0e0e0;
  z-index: 1;
}

.booking-step {
  display: flex;
  flex-direction: column;
  align-items: center;
  position: relative;
  z-index: 2;
  cursor: pointer;
  width: 25%;
}

.step-indicator {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  background-color: #f0f0f0;
  border: 3px solid #e0e0e0;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 600;
  font-size: 18px;
  color: #666;
  margin-bottom: 10px;
  transition: all 0.3s ease;
}

.booking-step.active .step-indicator {
  background-color: #06693a;
  border-color: #06693a;
  color: white;
  box-shadow: 0 4px 8px rgba(6, 105, 58, 0.2);
}

.booking-step.completed .step-indicator {
  background-color: #06693a;
  border-color: #06693a;
  color: white;
}

.step-label {
  font-size: 14px;
  font-weight: 500;
  color: #666;
  text-align: center;
  transition: all 0.3s ease;
}

.booking-step.active .step-label {
  color: #06693a;
  font-weight: 600;
}

/* Navigation Buttons */
.navigation-buttons {
  display: flex;
  justify-content: space-between;
  margin: 30px 20px;
}

.back-button, .next-button, .cancel-button {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 12px 24px;
  border-radius: 10px;
  font-weight: 500;
  font-size: 16px;
  cursor: pointer;
  transition: all 0.3s ease;
}

.back-button {
  background-color: #f5f5f5;
  color: #333;
  border: 1px solid #ddd;
}

.back-button:hover {
  background-color: #e8e8e8;
  transform: translateY(-2px);
}

.next-button {
  background-color: #06693A;
  color: white;
  border: none;
  box-shadow: 0 2px 5px rgba(6, 105, 58, 0.2);
}

.next-button:hover {
  background-color: #055d34;
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(6, 105, 58, 0.3);
}

.cancel-button {
  background-color: #f8f8f8;
  color: #666;
  border: 1px solid #ddd;
}

.cancel-button:hover {
  background-color: #f0f0f0;
  color: #e74c3c;
}

.next-button:disabled {
  background-color: #a0a0a0;
  cursor: not-allowed;
  transform: none;
  box-shadow: none;
  opacity: 0.7;
}

.confirm-button {
  background-color: #06693A;
}

/* Service selection styles */
.service-selection {
  margin: 0 20px 20px;
  background-color: #fff;
  border-radius: 15px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
  padding: 25px;
}

.service-header {
  margin-bottom: 25px;
}

.service-header h3 {
  font-size: 22px;
  font-weight: 600;
  color: #333;
  margin-bottom: 5px;
}

.service-subtitle {
  color: #666;
  font-size: 14px;
}

/* Services Grid */
.services-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 15px;
  margin-bottom: 30px;
}

.service-card {
  border: 1px solid #e0e0e0;
  border-radius: 10px;
  overflow: hidden;
  transition: all 0.2s ease;
  cursor: pointer;
  position: relative;
}

.service-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  border-color: #06693a;
}

.service-card.selected {
  border-color: #06693a;
  background-color: rgba(6, 105, 58, 0.05);
}

.service-card-content {
  padding: 16px;
  display: flex;
  align-items: center;
}

.service-icon {
  width: 40px;
  height: 40px;
  background-color: rgba(6, 105, 58, 0.1);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-right: 15px;
  color: #06693a;
  font-size: 20px;
}

.service-info {
  flex: 1;
}

.service-info h4 {
  font-size: 16px;
  font-weight: 500;
  margin-bottom: 5px;
  color: #333;
}

.service-price {
  font-size: 14px;
  color: #06693a;
  font-weight: 500;
}

.service-check {
  width: 24px;
  height: 24px;
  background-color: #06693a;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-size: 16px;
}

.no-services-message {
  text-align: center;
  color: #666;
  font-size: 16px;
  margin: 20px 0;
  grid-column: 1 / -1;
}

/* Cost Summary */
.cost-summary {
  background-color: #f9f9f9;
  border-radius: 10px;
  overflow: hidden;
  margin-bottom: 30px;
}

.summary-header {
  background-color: #06693a;
  color: white;
  padding: 15px 20px;
}

.summary-header h3 {
  font-size: 16px;
  font-weight: 500;
  margin: 0;
}

.summary-content {
  padding: 20px;
}

.summary-items {
  margin-bottom: 15px;
}

.summary-item {
  display: flex;
  justify-content: space-between;
  margin-bottom: 10px;
  color: #555;
}

.summary-divider {
  height: 1px;
  background-color: #e0e0e0;
  margin: 15px 0;
}

.summary-total {
  display: flex;
  justify-content: space-between;
  font-weight: 600;
  font-size: 16px;
  color: #333;
}

.total-price {
  color: #06693a;
}

.summary-disclaimer {
  margin-top: 10px;
  font-size: 14px;
  color: #e74c3c;
  text-align: left;
}

/* Note Section */
.note-section {
  margin-top: 20px;
}

.note-section h3 {
  font-size: 18px;
  font-weight: 500;
  color: #333;
  margin-bottom: 10px;
}

.note-section textarea {
  width: 100%;
  padding: 12px 15px;
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  font-size: 14px;
  resize: none;
  transition: border-color 0.2s;
  background-color: #f9f9f9;
}

.note-section textarea:focus {
  outline: none;
  border-color: #06693a;
}

/* Dentist Selection Styles */
.dentist-container {
  margin: 20px;
  padding: 25px;
  border: 1px solid #ddd;
  background-color: #fff;
  border-radius: 15px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}

.dentist-title {
  color: #333;
  margin-bottom: 20px;
  font-size: 22px;
  font-weight: 600;
}

.dentist-options {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.dentist-option {
  display: flex;
  align-items: center;
  padding: 20px 25px;
  border: 1px solid #e0e0e0;
  border-radius: 10px;
  cursor: pointer;
  transition: all 0.2s ease;
}

.dentist-option:hover:not(.disabled) {
  background-color: #f0f8f4;
  border-color: #06693a;
}

.dentist-option.selected {
  background-color: #d4edda;
  border-color: #06693a;
}

.dentist-option.disabled {
  opacity: 0.6;
  cursor: not-allowed;
  background-color: #f5f5f5;
}

.radio-circle {
  width: 20px;
  height: 20px;
  border: 2px solid #06693a;
  border-radius: 50%;
  margin-right: 15px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.radio-dot {
  width: 10px;
  height: 10px;
  background-color: #06693a;
  border-radius: 50%;
}

.dentist-name {
  color: #333;
  font-weight: 500;
}

.dentist-name.disabled-text {
  color: #999;
  font-style: italic;
}

/* Confirmation Container */
.confirmation-container {
  margin: 20px;
  background: white;
  border-radius: 15px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
  padding: 25px;
}

.confirmation-header {
  margin-bottom: 25px;
  text-align: center;
}

.confirmation-header h2 {
  font-size: 28px;
  font-weight: bold;
  margin-bottom: 10px;
  color: #06693A;
}

.confirmation-section {
  margin-bottom: 25px;
  border-top: 1px solid #f0f0f0;
  padding-top: 20px;
}

.section-title {
  font-size: 14px;
  color: #666;
  font-weight: 500;
  margin-bottom: 15px;
  text-transform: uppercase;
}

.section-content {
  background-color: #f8f9fa;
  border-radius: 8px;
  padding: 15px;
}

.service-detail {
  display: flex;
  align-items: center;
  font-size: 14px;
  color: #666;
  margin-bottom: 10px;
}

.tooth-icon, .service-detail i {
  margin-right: 10px;
  font-size: 18px;
  min-width: 20px;
  color: #06693A;
}

.payment-row {
  display: flex;
  justify-content: space-between;
  font-size: 16px;
  font-weight: 500;
}

.note-message {
  color: #e74c3c;
  font-size: 14px;
  margin: 15px 0;
  display: flex;
  align-items: center;
  gap: 8px;
}

.note-message i {
  color: #e74c3c;
}

.secure-message {
  color: #06693A;
  font-size: 14px;
  margin: 15px 0;
  display: flex;
  align-items: center;
  gap: 8px;
}

.secure-message i {
  color: #06693A;
}

/* Modal styles */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.6);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
  backdrop-filter: blur(3px);
}

.modal {
  background: white;
  border-radius: 15px;
  width: 450px;
  max-width: 90%;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
  overflow: hidden;
  animation: modalFadeIn 0.3s ease-out;
}

@keyframes modalFadeIn {
  from {
    opacity: 0;
    transform: translateY(-20px);
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
  padding: 20px;
  border-bottom: 1px solid #f0f0f0;
}

.modal-header h3 {
  margin: 0;
  font-size: 18px;
  font-weight: 500;
  color: #333;
}

.close-icon {
  background: transparent;
  border: none;
  color: #777;
  cursor: pointer;
  font-size: 25px;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: color 0.2s;
}

.close-icon:hover {
  color: #333;
}

.modal-content {
  padding: 20px;
}

.info-message-container, .confirm-message-container {
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  gap: 15px;
  text-align: left;
}

.info-icon, .confirm-icon {
  font-size: 40px;
  color: #06693a;
  margin-top: 2px;
  flex-shrink: 0;
}

.modal-content p {
  margin: 0;
  font-size: 15px;
  line-height: 1.5;
  color: #444;
  text-align: justify;
}

.modal-footer {
  display: flex;
  justify-content: flex-end;
  padding: 20px;
  border-top: 1px solid #f0f0f0;
  gap: 12px;
}

.modal-btn {
  padding: 10px 20px;
  border: none;
  border-radius: 8px;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  transition: background-color 0.2s;
}

.centered-btn {
  margin: 0 auto;
}

.primary-btn {
  background-color: #06693a;
  color: white;
}

.primary-btn:hover {
  background-color: #055d34;
}

.secondary-btn {
  background-color: #f2f2f2;
  color: #333;
}

.secondary-btn:hover {
  background-color: #e0e0e0;
}

/* Success Card */
.success-card-container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 80vh;
  padding: 20px;
}

.success-card {
  background: white;
  border-radius: 15px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
  padding: 40px;
  width: 100%;
  max-width: 600px;
  text-align: center;
}

.success-icon {
  margin: 0 auto 24px;
  width: 100px;
  height: 100px;
}

.success-title {
  font-size: 32px;
  font-weight: 700;
  color: #333;
  margin-bottom: 16px;
}

.success-message {
  font-size: 18px;
  color: #666;
  margin-bottom: 32px;
}

.back-to-appointments-btn {
  background-color: #06693a;
  color: white;
  border: none;
  border-radius: 8px;
  padding: 14px 32px;
  font-size: 16px;
  font-weight: 500;
  cursor: pointer;
  transition: background-color 0.3s;
  width: 100%;
}

.back-to-appointments-btn:hover {
  background-color: #055d34;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(-5px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Responsive Design */

/* Large Desktop */
@media (min-width: 1400px) {
  .dental-consent-container,
  .patient-questionnaire-container {
    max-width: 1400px;
    margin: 20px auto;
  }
}

/* Desktop */
@media (max-width: 1200px) {
  .medical-conditions-grid {
    grid-template-columns: repeat(4, 1fr);
  }
  
  .allergies-grid {
    grid-template-columns: repeat(2, 1fr);
  }
  
  .services-grid {
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
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
  
  .dental-consent-container,
  .patient-questionnaire-container {
    padding: 25px;
    margin: 15px;
  }
  
  .question-row {
    flex-direction: column;
    align-items: flex-start;
    gap: 10px;
  }
  
  .question-number {
    width: auto;
  }
  
  .question-options {
    margin-left: 0;
  }
  
  .question-input {
    min-width: auto;
    width: 100%;
  }
  
  .conditional-field {
    flex-direction: column;
    margin-left: 20px;
  }
  
  .conditional-text {
    min-width: auto;
    margin-right: 0;
    margin-bottom: 10px;
  }
  
  .medical-conditions-grid {
    grid-template-columns: repeat(3, 1fr);
  }
  
  .allergies-grid {
    grid-template-columns: repeat(2, 1fr);
  }
  
  .booking-step .step-label {
    font-size: 12px;
  }
  
  .step-indicator {
    width: 40px;
    height: 40px;
    font-size: 16px;
  }
  
  .time-buttons {
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 10px;
  }
  
  .services-grid {
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
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
  
  .dental-consent-container,
  .patient-questionnaire-container {
    padding: 20px;
    margin: 10px;
  }
  
  .dental-consent-title,
  .questionnaire-title {
    font-size: 24px;
  }
  
  .dental-consent-section {
    padding: 12px;
  }
  
  .dental-consent-section-title {
    font-size: 14px;
  }
  
  .dental-consent-section-content {
    font-size: 13px;
  }
  
  .dental-consent-buttons,
  .questionnaire-buttons {
    flex-direction: column;
    gap: 10px;
  }
  
  .dental-consent-button,
  .questionnaire-button {
    width: 100%;
    padding: 12px;
  }
  
  .question-row {
    padding: 10px 0;
  }
  
  .question-text {
    font-size: 14px;
    margin-right: 0;
    margin-bottom: 10px;
  }
  
  .question-options {
    flex-direction: column;
    gap: 10px;
  }
  
  .conditional-field {
    margin-left: 10px;
    padding: 8px;
  }
  
  .medical-conditions-grid {
    grid-template-columns: repeat(2, 1fr);
    gap: 8px;
  }
  
  .allergies-grid {
    grid-template-columns: 1fr;
    gap: 8px;
  }
  
  .condition-option,
  .allergy-option {
    padding: 6px;
  }
  
  .condition-option label,
  .allergy-option label {
    font-size: 12px;
  }
  
  .validation-error {
    margin-left: 20px;
  }
  
  .booking-progress {
    margin: 20px 10px;
  }
  
  .booking-step .step-label {
    font-size: 10px;
  }
  
  .step-indicator {
    width: 35px;
    height: 35px;
    font-size: 14px;
  }
  
  .date-time-tabs {
    margin: 15px 10px;
    gap: 10px;
  }
  
  .date-time-tab {
    padding: 12px;
    font-size: 14px;
  }
  
  .time-buttons {
    grid-template-columns: repeat(2, 1fr);
    gap: 8px;
  }
  
  .time-button {
    padding: 12px 8px;
    font-size: 12px;
  }
  
  .services-grid {
    grid-template-columns: 1fr;
    gap: 10px;
  }
  
  .service-card-content {
    padding: 12px;
  }
  
  .service-info h4 {
    font-size: 14px;
  }
  
  .service-price {
    font-size: 12px;
  }
  
  .navigation-buttons {
    margin: 15px 10px;
    flex-direction: column;
    gap: 10px;
  }
  
  .back-button, .next-button, .cancel-button {
    width: 100%;
    justify-content: center;
    padding: 12px;
    font-size: 14px;
  }
  
  .dentist-container,
  .confirmation-container,
  .service-selection {
    margin: 10px;
    padding: 20px;
  }
  
  .dentist-option {
    padding: 15px;
  }
  
  .modal {
    width: 95%;
    max-height: 85vh;
  }
  
  .modal-header {
    padding: 15px;
  }
  
  .modal-content {
    padding: 15px;
  }
  
  .modal-footer {
    padding: 15px;
    flex-direction: column;
    gap: 8px;
  }
  
  .modal-btn {
    width: 100%;
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
  
  .dental-consent-container,
  .patient-questionnaire-container {
    padding: 15px;
    margin: 8px;
  }
  
  .dental-consent-title,
  .questionnaire-title {
    font-size: 20px;
  }
  
  .dental-consent-section-content {
    font-size: 12px;
  }
  
  .question-text {
    font-size: 13px;
  }
  
  .medical-conditions-grid {
    grid-template-columns: 1fr;
  }
  
  .condition-option label,
  .allergy-option label {
    font-size: 11px;
  }
  
  .time-buttons {
    grid-template-columns: 1fr;
  }
  
  .booking-step .step-label {
    font-size: 9px;
  }
  
  .step-indicator {
    width: 30px;
    height: 30px;
    font-size: 12px;
  }
  
  .date-time-tab {
    padding: 10px;
    font-size: 12px;
  }
  
  .service-header h3 {
    font-size: 18px;
  }
  
  .dentist-title {
    font-size: 18px;
  }
  
  .confirmation-header h2 {
    font-size: 22px;
  }
}

/* Landscape Mobile */
@media (max-height: 500px) and (orientation: landscape) {
  .dental-consent-container,
  .patient-questionnaire-container {
    padding: 15px;
  }
  
  .dental-consent-title,
  .questionnaire-title {
    font-size: 20px;
    margin-bottom: 15px;
  }
  
  .dental-consent-section {
    margin-bottom: 10px;
    padding: 10px;
  }
  
  .question-row {
    padding: 8px 0;
  }
  
  .modal-content {
    max-height: 70vh;
    overflow-y: auto;
  }
}

/* .fc-day-blocked {
  background-color: #e8e8e8 !important;
  pointer-events: none;
  color: #999 !important;
  opacity: 0.6;
  position: relative;
} */

/* .fc-day-blocked::after {
  content: "Blocked";
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  font-size: 10px;
  color: white;
  font-weight: 500;
  padding: 2px 5px;
  border-radius: 3px;
  background-color: #dc3545;
} */

</style>

<style>
/* Disabled (past) dates */
.fc .fc-daygrid-day.disabled-date {
  background-color: #f0f0f0 !important;
  pointer-events: none;
  color: black;
  opacity: 0.6;
}

/* Today */
.fc .fc-daygrid-day.fc-day-today {
  background-color: rgba(6, 105, 58, 0.15) !important;
  pointer-events: auto !important;
  opacity: 1;
}

/* Hover effect for available dates */
.fc .fc-daygrid-day:not(.disabled-date):hover {
  background-color: rgba(6, 105, 58, 0.05) !important;
  cursor: pointer;
}

/* Selected date */
.fc .fc-daygrid-day.fc-day-selected {
  background-color: rgba(6, 105, 58, 0.2) !important;
  border: 2px solid #06693a !important;
}

/* Blocked dates */
.fc .fc-daygrid-day.fc-day-blocked {
  background-color: #e8e8e8 !important;
  pointer-events: none;
  color: #999 !important;
  opacity: 0.6;
  position: relative;
}

.fc .fc-daygrid-day.fc-day-blocked::after {
  content: "Blocked";
  position: absolute;
  top: 5px;
  right: 5px;
  background-color: #e74c3c !important; /* Red for visibility */
  color: white;
  padding: 2px 5px;
  border-radius: 3px;
  font-size: 12px;
}

/* Sundays */
.fc .fc-daygrid-day.sunday-blocked {
  background-color: #e8e8e8 !important;
  pointer-events: none;
  color: #999 !important;
  opacity: 0.6;
  position: relative;
}

.fc .fc-daygrid-day.sunday-blocked::after {
  content: "Closed";
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background-color: #06693a !important; /* Green to match theme */
  color: white;
  padding: 2px 5px;
  border-radius: 3px;
  font-size: 12px;
}

/* Blocked date tooltip */
.fc .blocked-date-tooltip {
  background-color: #f0f0f0 !important; /* Matches disabled-date background */
  border-left: 4px solid #e74c3c; /* Red border for blocked dates */
  border-radius: 4px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
  color: #333;
  font-size: 14px;
  max-width: 250px;
  padding: 10px 12px;
  z-index: 1000;
}

/* Calendar header styling */
.fc .fc-col-header-cell {
  background-color: #06693a !important;
  color: white !important;
}

.fc .fc-col-header-cell-cushion {
  color: white !important;
  font-weight: 500 !important;
  padding: 10px 0 !important;
}

/* Day number styling */
.fc .fc-daygrid-day-number {
  color: #333 !important;
  font-weight: 500 !important;
  padding: 8px !important;
}

/* FullCalendar responsive */
.fc {
  width: 100% !important;
  max-width: 100% !important;
  font-family: 'Poppins', sans-serif;
}

.fc-col-header-cell {
  width: 160px !important;
}

/* Customize FullCalendar buttons */
.fc-button {
  background-color: #06693A !important;
  color: white !important;
  border: none !important;
  border-radius: 6px !important;
  padding: 10px 16px !important;
  font-weight: 500 !important;
  box-shadow: 0 2px 5px rgba(6, 105, 58, 0.2) !important;
  transition: all 0.2s ease !important;
}

.fc-button:hover {
  background-color: #055d34 !important;
  transform: translateY(-1px) !important;
}

.fc-button:active,
.fc-button:focus {
  background-color: #044f2a !important;
  box-shadow: 0 1px 3px rgba(6, 105, 58, 0.3) !important;
}

/* Customize the title */
.fc-toolbar-title {
  color: #06693A !important;
  font-weight: bold !important;
  font-size: 20px !important;
}

/* Improve calendar responsiveness */
@media (max-width: 768px) {
  .fc .fc-toolbar {
    flex-direction: column !important;
    gap: 10px !important;
  }
  
  .fc .fc-toolbar-title {
    font-size: 16px !important;
  }
  
  .fc .fc-button {
    padding: 6px 10px !important;
    font-size: 12px !important;
  }
  
  .fc-col-header-cell {
    width: auto !important;
  }

  .fc .fc-daygrid-day.fc-day-blocked::after,
  .fc .fc-daygrid-day.sunday-blocked::after {
    font-size: 10px !important; /* Adjust label size for mobile */
  }
}
</style>
