<template>
  <section class="signUpPage">
    <div class="signUpBox">
      <div class="logo">
        <img class="img1" src="@/components/Images/ATDC_Logo5.png" alt="">
        <img class="img2" src="@/components/Images/ATDC_Logo3.png" alt="">
      </div>
      <h1>Create an account</h1>
      <p class="subtitle">Please register by completing the form below to sign up</p>
      <hr class="divider">

      <form @submit.prevent="submitForm" enctype="multipart/form-data" novalidate>
        <div class="form-row">
          <div class="form-group">
            <label for="LastName">Last Name <span>*</span></label>
            <input v-model="formData.LastName" type="text" id="LastName" required>
            <div v-if="formSubmitted && !formData.LastName" class="invalid-feedback">
              Last Name is required
            </div>
          </div>

          <div class="form-group">
            <label for="FirstName">First Name <span>*</span></label>
            <input v-model="formData.FirstName" type="text" id="FirstName" required>
            <div v-if="formSubmitted && !formData.FirstName" class="invalid-feedback">
              First Name is required
            </div>
          </div>

          <div class="form-group">
            <label for="MiddleName">Middle Name</label>
            <input v-model="formData.MiddleName" type="text" id="MiddleName">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="ContactNumber">Contact Number <span>*</span> <span class="hint-text">+63 XXX XXX XXXX</span></label>
            <input v-model="formData.ContactNumber" type="tel" id="ContactNumber" placeholder="+63" required @focus="prefixContactNumber" maxlength="13" pattern="^\+63\d{10}$">
            <div v-if="formSubmitted && (!formData.ContactNumber || !formData.ContactNumber.match(/^\+63\d{10}$/))" class="invalid-feedback">
              Please enter a valid contact number (+63 followed by 10 digits)
            </div>
          </div>

          <div class="form-group">
            <label for="Email">Email Address <span>*</span> <span class="hint-text">example@domain.com</span></label>
            <input 
              v-model="formData.Email" 
              type="email" 
              id="Email" 
              required 
              @input="checkEmailAvailability" 
              @blur="checkEmailAvailability" 
              :class="{ 'is-invalid': emailInvalid }"
            >
            <div v-if="emailInvalid" class="invalid-feedback">
              {{ emailErrorMessage }}
            </div>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="Gender">Gender <span>*</span></label>
            <select v-model="formData.Gender" id="Gender" required>
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
            <label for="BirthDate">Birth date <span>*</span></label>
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

          <!-- <div class="form-group">
            <label for="Age">Age <span>*</span></label>
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
          </div> -->

          <div class="form-group">
            <label for="Age">Age <span>*</span></label>
            <input 
              v-model="formData.Age" 
              type="text" 
              id="Age" 
              readonly
              :class="{ 'is-invalid': birthDateInvalid || ageInvalid || (formSubmitted && !formData.Age) }"
            >
            <div v-if="formSubmitted && !formData.Age" class="invalid-feedback">
              Age is required
            </div>
            <div v-else-if="birthDateInvalid" class="invalid-feedback">
              You must be at least 6 months old to register
            </div>
            <div v-else-if="ageInvalid" class="invalid-feedback">
              Age must not exceed 100 years
            </div>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="Religion">Religion <span>*</span></label>
            <select v-model="formData.Religion" id="Religion" required>
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
            <label for="Nationality">Nationality <span>*</span></label>
            <select v-model="formData.Nationality" id="Nationality" required>
              <option value="" disabled selected>Select</option>
              <option value="afghan">Afghan</option>
              <option value="albanian">Albanian</option>
              <option value="algerian">Algerian</option>
              <option value="american">American</option>
              <option value="andorran">Andorran</option>
              <option value="angolan">Angolan</option>
              <option value="antiguans">Antiguans</option>
              <option value="argentinean">Argentinean</option>
              <option value="armenian">Armenian</option>
              <option value="australian">Australian</option>
              <option value="austrian">Austrian</option>
              <option value="azerbaijani">Azerbaijani</option>
              <option value="bahamian">Bahamian</option>
              <option value="bahraini">Bahraini</option>
              <option value="bangladeshi">Bangladeshi</option>
              <option value="barbadian">Barbadian</option>
              <option value="barbudans">Barbudans</option>
              <option value="batswana">Batswana</option>
              <option value="belarusian">Belarusian</option>
              <option value="belgian">Belgian</option>
              <option value="belizean">Belizean</option>
              <option value="beninese">Beninese</option>
              <option value="bhutanese">Bhutanese</option>
              <option value="bolivian">Bolivian</option>
              <option value="bosnian">Bosnian</option>
              <option value="brazilian">Brazilian</option>
              <option value="british">British</option>
              <option value="bruneian">Bruneian</option>
              <option value="bulgarian">Bulgarian</option>
              <option value="burkinabe">Burkinabe</option>
              <option value="burmese">Burmese</option>
              <option value="burundian">Burundian</option>
              <option value="cambodian">Cambodian</option>
              <option value="cameroonian">Cameroonian</option>
              <option value="canadian">Canadian</option>
              <option value="cape verdean">Cape Verdean</option>
              <option value="central african">Central African</option>
              <option value="chadian">Chadian</option>
              <option value="chilean">Chilean</option>
              <option value="chinese">Chinese</option>
              <option value="colombian">Colombian</option>
              <option value="comoran">Comoran</option>
              <option value="congolese">Congolese</option>
              <option value="costa rican">Costa Rican</option>
              <option value="croatian">Croatian</option>
              <option value="cuban">Cuban</option>
              <option value="cypriot">Cypriot</option>
              <option value="czech">Czech</option>
              <option value="danish">Danish</option>
              <option value="djibouti">Djibouti</option>
              <option value="dominican">Dominican</option>
              <option value="dutch">Dutch</option>
              <option value="east timorese">East Timorese</option>
              <option value="ecuadorean">Ecuadorean</option>
              <option value="egyptian">Egyptian</option>
              <option value="emirian">Emirian</option>
              <option value="equatorial guinean">Equatorial Guinean</option>
              <option value="eritrean">Eritrean</option>
              <option value="estonian">Estonian</option>
              <option value="ethiopian">Ethiopian</option>
              <option value="fijian">Fijian</option>
              <option value="filipino">Filipino</option>
              <option value="finnish">Finnish</option>
              <option value="french">French</option>
              <option value="gabonese">Gabonese</option>
              <option value="gambian">Gambian</option>
              <option value="georgian">Georgian</option>
              <option value="german">German</option>
              <option value="ghanaian">Ghanaian</option>
              <option value="greek">Greek</option>
              <option value="grenadian">Grenadian</option>
              <option value="guatemalan">Guatemalan</option>
              <option value="guinea-bissauan">Guinea-Bissauan</option>
              <option value="guinean">Guinean</option>
              <option value="guyanese">Guyanese</option>
              <option value="haitian">Haitian</option>
              <option value="herzegovinian">Herzegovinian</option>
              <option value="honduran">Honduran</option>
              <option value="hungarian">Hungarian</option>
              <option value="icelander">Icelander</option>
              <option value="indian">Indian</option>
              <option value="indonesian">Indonesian</option>
              <option value="iranian">Iranian</option>
              <option value="iraqi">Iraqi</option>
              <option value="irish">Irish</option>
              <option value="israeli">Israeli</option>
              <option value="italian">Italian</option>
              <option value="ivorian">Ivorian</option>
              <option value="jamaican">Jamaican</option>
              <option value="japanese">Japanese</option>
              <option value="jordanian">Jordanian</option>
              <option value="kazakhstani">Kazakhstani</option>
              <option value="kenyan">Kenyan</option>
              <option value="kittian and nevisian">Kittian and Nevisian</option>
              <option value="kuwaiti">Kuwaiti</option>
              <option value="kyrgyz">Kyrgyz</option>
              <option value="laotian">Laotian</option>
              <option value="latvian">Latvian</option>
              <option value="lebanese">Lebanese</option>
              <option value="liberian">Liberian</option>
              <option value="libyan">Libyan</option>
              <option value="liechtensteiner">Liechtensteiner</option>
              <option value="lithuanian">Lithuanian</option>
              <option value="luxembourger">Luxembourger</option>
              <option value="macedonian">Macedonian</option>
              <option value="malagasy">Malagasy</option>
              <option value="malawian">Malawian</option>
              <option value="malaysian">Malaysian</option>
              <option value="maldivan">Maldivan</option>
              <option value="malian">Malian</option>
              <option value="maltese">Maltese</option>
              <option value="marshallese">Marshallese</option>
              <option value="mauritanian">Mauritanian</option>
              <option value="mauritian">Mauritian</option>
              <option value="mexican">Mexican</option>
              <option value="micronesian">Micronesian</option>
              <option value="moldovan">Moldovan</option>
              <option value="monacan">Monacan</option>
              <option value="mongolian">Mongolian</option>
              <option value="moroccan">Moroccan</option>
              <option value="mosotho">Mosotho</option>
              <option value="motswana">Motswana</option>
              <option value="mozambican">Mozambican</option>
              <option value="namibian">Namibian</option>
              <option value="nauruan">Nauruan</option>
              <option value="nepalese">Nepalese</option>
              <option value="new zealander">New Zealander</option>
              <option value="ni-vanuatu">Ni-Vanuatu</option>
              <option value="nicaraguan">Nicaraguan</option>
              <option value="nigerien">Nigerien</option>
              <option value="north korean">North Korean</option>
              <option value="northern irish">Northern Irish</option>
              <option value="norwegian">Norwegian</option>
              <option value="omani">Omani</option>
              <option value="pakistani">Pakistani</option>
              <option value="palauan">Palauan</option>
              <option value="panamanian">Panamanian</option>
              <option value="papua new guinean">Papua New Guinean</option>
              <option value="paraguayan">Paraguayan</option>
              <option value="peruvian">Peruvian</option>
              <option value="polish">Polish</option>
              <option value="portuguese">Portuguese</option>
              <option value="qatari">Qatari</option>
              <option value="romanian">Romanian</option>
              <option value="russian">Russian</option>
              <option value="rwandan">Rwandan</option>
              <option value="saint lucian">Saint Lucian</option>
              <option value="salvadoran">Salvadoran</option>
              <option value="samoan">Samoan</option>
              <option value="san marinese">San Marinese</option>
              <option value="sao tomean">Sao Tomean</option>
              <option value="saudi">Saudi</option>
              <option value="scottish">Scottish</option>
              <option value="senegalese">Senegalese</option>
              <option value="serbian">Serbian</option>
              <option value="seychellois">Seychellois</option>
              <option value="sierra leonean">Sierra Leonean</option>
              <option value="singaporean">Singaporean</option>
              <option value="slovakian">Slovakian</option>
              <option value="slovenian">Slovenian</option>
              <option value="solomon islander">Solomon Islander</option>
              <option value="somali">Somali</option>
              <option value="south african">South African</option>
              <option value="south korean">South Korean</option>
              <option value="spanish">Spanish</option>
              <option value="sri lankan">Sri Lankan</option>
              <option value="sudanese">Sudanese</option>
              <option value="surinamer">Surinamer</option>
              <option value="swazi">Swazi</option>
              <option value="swedish">Swedish</option>
              <option value="swiss">Swiss</option>
              <option value="syrian">Syrian</option>
              <option value="taiwanese">Taiwanese</option>
              <option value="tajik">Tajik</option>
              <option value="tanzanian">Tanzanian</option>
              <option value="thai">Thai</option>
              <option value="togolese">Togolese</option>
              <option value="tongan">Tongan</option>
              <option value="trinidadian or tobagonian">Trinidadian or Tobagonian</option>
              <option value="tunisian">Tunisian</option>
              <option value="turkish">Turkish</option>
              <option value="tuvaluan">Tuvaluan</option>
              <option value="ugandan">Ugandan</option>
              <option value="ukrainian">Ukrainian</option>
              <option value="uruguayan">Uruguayan</option>
              <option value="uzbekistani">Uzbekistani</option>
              <option value="venezuelan">Venezuelan</option>
              <option value="vietnamese">Vietnamese</option>
              <option value="welsh">Welsh</option>
              <option value="yemenite">Yemenite</option>
              <option value="zambian">Zambian</option>
              <option value="zimbabwean">Zimbabwean</option>
            </select>
            <div v-if="formSubmitted && !formData.Nationality" class="invalid-feedback">
              Nationality is required
            </div>
          </div>

          <div class="form-group">
            <label for="MaritalStatus">Marital Status <span>*</span></label>
            <select v-model="formData.MaritalStatus" id="MaritalStatus" required>
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
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="HomeTelephoneNumber">Home Tel. No. <span class="hint-text">02 XXXX XXXX</span></label>
            <input 
              v-model="formData.HomeTelephoneNumber" 
              type="tel" 
              id="HomeTelephoneNumber" 
              placeholder="02" 
              maxlength="10" 
              pattern="^02\d{8}$"
            >
            <div 
              v-if="formSubmitted && formData.HomeTelephoneNumber && !formData.HomeTelephoneNumber.match(/^02\d{8}$/)" 
              class="invalid-feedback"
            >
              Please enter a valid home telephone number (02 followed by 8 digits)
            </div>
          </div>

          <div class="form-group">
            <label for="OfficeNumber">Office No. <span class="hint-text">02 XXXX XXXX</span></label>
            <input 
              v-model="formData.OfficeNumber" 
              type="tel" 
              id="OfficeNumber" 
              placeholder="02" 
              maxlength="10" 
              pattern="^02\d{8}$"
            >
            <div 
              v-if="formSubmitted && formData.OfficeNumber && !formData.OfficeNumber.match(/^02\d{8}$/)" 
              class="invalid-feedback"
            >
              Please enter a valid office number (02 followed by 8 digits)
            </div>
          </div>

          <div class="form-group">
            <label for="Occupation">Occupation <span>*</span></label>
            <input v-model="formData.Occupation" type="text" id="Occupation" required>
            <div v-if="formSubmitted && !formData.Occupation" class="invalid-feedback">
              Occupation is required
            </div>
          </div>
        </div>

        <div class="form-full">
          <label for="HomeAddress">Home Address <span>*</span></label>
          <input v-model="formData.HomeAddress" type="text" id="HomeAddress" required>
          <div v-if="formSubmitted && !formData.HomeAddress" class="invalid-feedback">
            Home Address is required
          </div>
        </div>

        <div class="form-full">
          <label for="ReferredBy">Referred by</label>
          <input v-model="formData.ReferredBy" type="text" id="ReferredBy">
        </div>

        <div class="form-full">
          <label for="GovernmentID">Upload Government ID <span>*</span> <span class="hint-text">jpg/png, max 10MB</span></label>
          <input type="file" id="GovernmentID" @change="handleFileUpload" required accept="image/jpeg,image/png" ref="governmentIDInput">
          <div v-if="formSubmitted && !formData.GovernmentID" class="invalid-feedback">
            Please upload a valid government ID (JPG or PNG)
          </div>
        </div>

        <div v-if="imagePreview" class="image-preview">
          <p class="preview">Preview:</p>
          <img :src="imagePreview" alt="Government ID Preview" width="300" height="auto" style="margin-bottom: 20px;"/>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="Username">Username <span>*</span></label>
            <input 
              v-model="formData.Username" 
              type="text" 
              id="Username" 
              required 
              @input="checkUsernameAvailability" 
              @blur="checkUsernameAvailability" 
              :class="{ 'is-invalid': usernameInvalid }"
            >
            <div v-if="usernameInvalid" class="invalid-feedback">
              {{ usernameErrorMessage }}
            </div>
          </div>

          <div class="form-group">
            <label for="Password">Password <span>*</span> <span class="hint-text"><b>Must</b> include A-Z, a-z, 0-9 and symbol.</span></label>
            <div class="password-field">
              <input 
                v-model="formData.Password" 
                :type="showPassword ? 'text' : 'password'" 
                id="Password" 
                required 
                pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$"
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
        </div>

        <div class="form-full">
          <label for="Password_confirmation">Confirm Password <span>*</span> <span class="hint-text">Min. of 8 characters and <b>Must</b> include A-Z, a-z, 0-9 and symbol.</span></label>
          <div class="password-field">
            <input 
              v-model="formData.Password_confirmation" 
              :type="showConfirmPassword ? 'text' : 'password'" 
              id="Password_confirmation" 
              required 
              pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$"
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
          <div v-if="formSubmitted && (!formData.Password_confirmation || formData.Password !== formData.Password_confirmation)" class="invalid-feedback"> {{ !formData.Password_confirmation ? 'Please confirm your password' : 'Passwords do not match' }}
          </div>
        </div>

        <div class="terms-agreement">
          <p>By clicking Sign Up, you agree to <a href="#" class="terms-link">ATDC's User Agreement</a>, <a href="#" class="terms-link">Privacy Policy</a>, and <a href="#" class="terms-link">Cookie Policy</a>.</p>
        </div>

        <div class="submit-button">
          <button type="submit">SIGN UP</button>
        </div>
        
        <div class="login-link">
          <p>Already have an account? <a href="/login"><u>Log in</u></a></p>
        </div>
      </form>
    </div>
  </section>
</template>

<script>
import axios from "axios";
import Swal from 'sweetalert2';

export default {
  name: "SignUp",
  data() {
    return {
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
      },
      imagePreview: null,
      errors: [],
      formSubmitted: false,
      emailTaken: false,
      usernameTaken: false,
      usernameInvalid: false,
      usernameErrorMessage: '',
      emailInvalid: false,
      emailErrorMessage: '',
      birthDateInvalid: false,
      ageInvalid: false, // New flag for age limit validation
      maxDate: '',
      showPassword: false,
      showConfirmPassword: false,
    };
  },
  methods: {
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

        const maxSize = 10 * 1024 * 1024;
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
    scrollToFirstError() {
      const firstInvalid = this.$el.querySelector('.was-validated :invalid, .form-group .invalid-feedback:not(:empty)');
      if (firstInvalid) {
        firstInvalid.scrollIntoView({ 
          behavior: 'smooth', 
          block: 'center' 
        });
      }
    },
    async submitForm() {
      this.formSubmitted = true;
      this.errors = [];

      const form = this.$el.querySelector('form');
      form.classList.add('was-validated');

      await this.checkEmailAvailability();
      await this.checkUsernameAvailability();
      this.validateBirthDate();

      if (this.birthDateInvalid || this.ageInvalid) {
        if (this.birthDateInvalid) {
          this.errors.push('You must be at least 6 months old to register');
        }
        if (this.ageInvalid) {
          this.errors.push('Age must not exceed 100 years');
        }
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
      if (!this.formData.GovernmentID) {
        this.errors.push('Please upload a valid government ID');
      }
      if (this.emailTaken) {
        this.errors.push('This email is already in use');
      }
      if (this.usernameTaken) {
        this.errors.push('This username is already in use');
      }
      if (this.formData.HomeTelephoneNumber && !this.formData.HomeTelephoneNumber.match(/^02\d{8}$/)) {
        this.errors.push('Please enter a valid home telephone number (02 followed by 8 digits)');
      }
      if (this.formData.OfficeNumber && !this.formData.OfficeNumber.match(/^02\d{8}$/)) {
        this.errors.push('Please enter a valid office number (02 followed by 8 digits)');
      }

      if (!form.checkValidity() || this.errors.length) {
        console.log('Form errors:', this.errors);
        this.$nextTick(() => this.scrollToFirstError());
        return;
      }

      const formData = new FormData();
      for (const key in this.formData) {
        console.log(`Appending form field: ${key}`, this.formData[key]);
        formData.append(key, this.formData[key] || '');
      }
      console.log('Form data being sent:', Object.fromEntries(formData));

      try {
        const response = await axios.post('/users', formData, {
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        });

        console.log('Signup response:', response.data);
        
        await Swal.fire({
          icon: 'success',
          title: 'Account has been created',
          showConfirmButton: false,
          timer: 2000
        });

        const redirectUrl = response.data.redirectUrl || '/';
        window.location.href = redirectUrl;
        this.errors = [];
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
    validateBirthDate() {
      const birthdate = new Date(this.formData.BirthDate);
      const today = new Date();

      if (!this.formData.BirthDate || isNaN(birthdate)) {
        this.formData.Age = "";
        this.birthDateInvalid = false;
        this.ageInvalid = false;
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
      this.ageInvalid = age > 100; // New check for age limit of 100

      // Clear or set errors based on validation
      this.errors = this.errors.filter(e => e !== 'You must be at least 6 months old to register' && e !== 'Age must not exceed 100 years');
      if (this.birthDateInvalid) {
        this.errors.push('You must be at least 6 months old to register');
      }
      if (this.ageInvalid) {
        this.errors.push('Age must not exceed 100 years');
      }
    },
    calculateAge() {
      this.validateBirthDate();
    },
    prefixContactNumber() {
      if (!this.formData.ContactNumber || !this.formData.ContactNumber.startsWith('+63')) {
        this.formData.ContactNumber = '+63';
      }
    },
    setMaxDate() {
      const today = new Date();
      // Set max date to today to prevent future dates
      this.maxDate = today.toISOString().split('T')[0];
    },
    togglePasswordVisibility() {
      this.showPassword = !this.showPassword;
    },
    toggleConfirmPasswordVisibility() {
      this.showConfirmPassword = !this.showConfirmPassword;
    }
  },
  created() {
    this.setMaxDate();
  },
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
  font-family: 'Poppins', sans-serif;
}

.signUpPage {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background-color: #EDF1F7;
  padding: 20px;
}

.signUpBox {
  width: 100%;
  max-width: 800px;
  background-color: #F9F9F9;
  border-radius: 10px;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  padding: 40px;
  text-align: center;
}

.logo {
  text-align: center;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.logo .img1 {
  max-width: 5%;
  margin-bottom: -10px;
}

.logo .img2 {
  width: 25%;
}

h1 {
  font-size: 24px;
  font-weight: 600;
  margin-bottom: 8px;
  color: #222;
}

.subtitle {
  color: black;
  margin-bottom: 20px;
  font-size: 14px;
  font-weight: 400;
}

.divider {
  border: none;
  border-top: 1px solid #333;
  margin: 15px 0 25px;
}

form {
  text-align: left;
}

.form-row {
  display: flex;
  flex-wrap: wrap;
  gap: 15px;
  margin-bottom: 25px;
}

.form-group {
  flex: 1;
  min-width: 200px;
}

.form-full {
  width: 100%;
  margin-bottom: 25px;
}

label {
  display: block;
  font-size: 14px;
  margin-bottom: 5px;
  color: #333;
  font-weight: 500;
}

.preview {
  display: block;
  font-size: 14px;
  margin-bottom: 5px;
  color: #333;
  font-weight: 500;
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

input, select {
  width: 100%;
  padding: 10px;
  border: 1px solid #979494;
  border-radius: 5px;
  font-size: 14px;
  color: #333;
  background-color: #FFFDFB;
}

select {
  appearance: none;
  background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
  background-repeat: no-repeat;
  background-position: right 10px center;
  background-size: 15px;
  padding-right: 30px;
}

.file-input {
  padding: 8px;
  background-color: #FFFDFB;
}

.terms-agreement {
  font-size: 15px;
  color: #666;
  margin: 40px 0 -5px 0;
  text-align: center;
}

.terms-link {
  color: #06693A;
  text-decoration: none;
}

.submit-button {
  text-align: center;
  margin: 15px 0 15px;
}

button {
  background-color: #06693A;
  color: white;
  border: none;
  border-radius: 5px;
  padding: 12px 0;
  width: 100%;
  max-width: 400px;
  font-size: 16px;
  font-weight: 600;
  cursor: pointer;
  transition: background-color 0.2s;
}

button:hover {
  background-color: #055a31;
}

.login-link {
  text-align: center;
  font-size: 16px;
  margin-top: 15px;
}

.login-link a {
  color: #06693A;
  text-decoration: none;
  font-weight: 500;
}

.error-messages {
  margin-top: 20px;
  color: red;
  font-size: 14px;
}

.error-messages ul {
  list-style-type: none;
}

.password-field {
  position: relative;
  display: flex;
  align-items: center;
}

.password-field input {
  width: 100%;
  padding-right: 40px;
}

.eye-icon-container {
  position: absolute;
  right: 10px;
  top: 50%;
  transform: translateY(-50%);
  cursor: pointer;
  color: #666;
  display: flex;
  align-items: center;
  justify-content: center;
  pointer-events: auto;
}

.eye-icon {
  color: #666;
}

@media (max-width: 768px) {
  .signUpBox {
    padding: 30px 20px;
  }
  
  .form-group {
    flex: 100%;
    min-width: 100%;
  }
  
  .form-row {
    flex-direction: column;
    gap: 10px;
  }
  
  label span.hint-text {
    display: block;
    margin-left: 0;
    margin-top: 2px;
  }

  .logo .img1 {
    max-width: 10%;
  }
  
  .logo .img2 {
    width: 40%;
  }
}

@media (max-width: 480px) {
  .signUpBox {
    padding: 20px 15px;
  }
  
  h1 {
    font-size: 20px;
  }
  
  .subtitle {
    font-size: 12px;
  }
  
  input, select {
    padding: 8px;
    font-size: 13px;
  }
  
  .logo .img1 {
    max-width: 12%;
  }
  
  .logo .img2 {
    width: 50%;
  }
}

.was-validated input:invalid,
.was-validated select:invalid,
.was-validated input[type="file"]:invalid,
input.is-invalid {
  border-color: red;
  background-color: #fff1f1;
}

.was-validated input:invalid:focus,
.was-validated select:invalid:focus,
.was-validated input[type="file"]:invalid:focus,
input.is-invalid:focus {
  border-color: red;
  box-shadow: 0 0 3px rgba(255, 0, 0, 0.5);
}

.invalid-feedback {
  color: red;
  font-size: 12px;
  margin-top: 5px;
}

input,
select,
input[type="file"] {
  border: 1px solid #979494;
  background-color: #FFFDFB;
}
</style>
