<template>
  <section class="loginPage">
    <div class="formBox">
      <form @submit.prevent="submitLogin">
        <div class="logo">
          <img class="img1" src="@/components/Images/ATDC_Logo5.png" alt="">
          <img class="img2" src="@/components/Images/ATDC_Logo3.png" alt="">
        </div>
        
        <!-- Error or success message -->
        <div v-if="status" class="alert">
          {{ status }}
        </div>

        <div v-if="errors.length" class="error-messages" :key="errorKey">
          <ul>
            <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
          </ul>
        </div>
        
        <!-- Username -->
        <div class="input-field">
          <input class="itext" v-model="formData.Username" type="text" id="Username" placeholder="Username" required>
        </div>

        <br><br>

        <!-- Password -->
        <div class="input-field password-field">
          <input 
            class="itext" 
            v-model="formData.Password" 
            :type="showPassword ? 'text' : 'password'" 
            id="Password" 
            placeholder="Password" 
            required
          >
          <div class="eye-icon-container" @click="togglePasswordVisibility">
            <!-- Show different eye icon based on password visibility state -->
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

        <div class="option">
          <div class="rememberMe">
            <input type="checkbox" id="rememberMe">
            <label for="rememberMe"> Remember Me</label>
          </div>

          <div class="fPass">
            <a href="/forgotpassword" class="forgotPassword">Forgot Password?</a>
          </div>
        </div>

        <!-- Submit Button -->
        <div>
          <button type="submit">LOG IN</button>
        </div>

        <div class="sUp">
          <p>Don't have an account yet? <a href="/signup" class="signUp">Sign Up</a></p>
        </div>
      </form>
    </div>
  </section>
</template>

<script>
import axios from "axios";

export default {
  name: "Login",
  data() {
    return {
      formData: {
        Username: "",
        Password: "",
      },
      status: null,
      errors: [],
      errorKey: 0, // Add a key to force re-render of error messages
      showPassword: false, // Add this for password visibility toggle
    };
  },
  methods: {
    async submitLogin() {
      try {
        const response = await axios.post('/login', this.formData);

        // Log the entire response for debugging
        console.log("Backend Response:", response.data);

        this.status = response.data.status;
        this.errors = []; // Clear any previous errors

        const redirectUrl = response.data.redirectUrl;
        console.log("Redirect URL from backend:", redirectUrl); // Debugging

        if (redirectUrl) {
          console.log("Attempting to redirect to:", redirectUrl); // Debugging
          window.location.href = redirectUrl; // Redirect to the correct URL
        } else {
          console.error("No redirect URL received from backend.");
          this.errorKey++; // Increment key to force animation replay
          this.errors = ["An unexpected error occurred. Please try again later."];
        }
      } catch (error) {
        console.error("Login error:", error);
        if (error.response) {
          if (error.response.status === 422) {
            this.errorKey++; // Increment key to force animation replay
            this.errors = Object.values(error.response.data.errors).flat();
          } else if (error.response.status === 401) {
            this.errorKey++; // Increment key to force animation replay
            this.errors = error.response.data.errors || ["Invalid username or password"];
          } else {
            this.errorKey++; // Increment key to force animation replay
            this.errors = ["An unexpected error occurred. Please try again later."];
          }
        }
        this.status = null;
      }
    },
    // Add this method for password visibility toggle
    togglePasswordVisibility() {
      this.showPassword = !this.showPassword;
    }
  },
};
</script>

<style scoped>
* {
  margin: 0 auto;
  padding: 0 auto;
}

.loginPage {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 20px;
  box-sizing: border-box;
}

.logo {
  margin-bottom: 20px;
}

.logo img {
  display: block;
}

.logo .img1 {
  max-width: 20%;
  margin-bottom: -20px;
}

.logo .img2 {
  width: 65%;
}

.formBox {
  text-align: center;
  background-color: #F9F9F9;
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
  padding: 40px 50px 50px 50px;
  width: 100%;
  max-width: 450px;
  border-radius: 10px;
  margin: 0;
  box-sizing: border-box;
}

.formBox button {
  background-color: #06693A;
  color: white;
  border: none;
  border-radius: 10px;
  width: 87%;
  height: 45px;
  margin-top: 20px;
  cursor: pointer;
  font-size: 16px;
  font-weight: 700;
  transition: background-color 0.3s ease;
}

.formBox button:hover {
  background-color: #054d2a;
}

.forgotPassword {
  color: black;
  text-decoration: none;
  font-size: 14px;
}

.forgotPassword:hover {
  text-decoration: underline;
}

.fPass {
  margin-top: 20px;
}

.signUp {
  color: #497E2E;
  text-decoration: none;
}

.signUp:hover {
  text-decoration: underline;
}

.sUp {
  margin-top: 10px;
  font-size: 14px;
}

/* Common input field styling */
.input-field {
  position: relative;
  display: inline-block;
  width: 88%;
}

.itext {
  border-radius: 5px;
  border: 1px solid #A39F9F;
  padding: 12px;
  font-size: 15px;
  width: 100%;
  box-sizing: border-box;
  transition: border-color 0.3s ease;
}

.itext:focus {
  outline: none;
  border-color: #06693A;
}

.itext::placeholder {
  color: #A39F9F;
}

/* Password field specific styling */
.password-field .itext {
  padding-right: 40px;
}

/* Eye icon container */
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
  padding: 5px;
}

.eye-icon {
  color: #666;
  transition: color 0.3s ease;
}

.eye-icon-container:hover .eye-icon {
  color: #06693A;
}

.option {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin: 0px 0 15px 0;
  flex-wrap: wrap;
  gap: 10px;
}

.rememberMe {
  margin-top: 20px;
  display: flex;
  align-items: center;
  font-size: 14px;
}

.rememberMe input[type="checkbox"] {
  margin-right: 8px;
}

/* Error messages styling */
.error-messages {
  margin-bottom: 15px;
  background-color: #FEF2F2;
  border-left: 4px solid #EF4444;
  border-radius: 5px;
  padding: 12px;
  text-align: left;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  animation: shakeAndBounce 0.6s cubic-bezier(0.36, 0.07, 0.19, 0.97) both;
}

.error-messages ul {
  margin: 0;
  padding-left: 0;
  list-style-type: none;
}

.error-messages li {
  color: #B91C1C;
  font-size: 14px;
  margin-bottom: 4px;
}

.error-messages li:last-child {
  margin-bottom: 0;
}

/* Success message styling */
.alert {
  margin-bottom: 15px;
  background-color: #ECFDF5;
  border-left: 4px solid #10B981;
  border-radius: 5px;
  padding: 12px;
  color: #065F46;
  font-size: 14px;
  text-align: left;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  animation: fadeIn 0.3s ease-out forwards;
}

/* Animation for error messages */
@keyframes shakeAndBounce {
  0%, 100% {
    transform: translateX(0);
  }
  10%, 30%, 50%, 70% {
    transform: translateX(-5px);
  }
  20%, 40%, 60% {
    transform: translateX(5px);
  }
  80% {
    transform: translateX(2px);
  }
  90% {
    transform: translateX(-2px);
  }
}

/* Animation for success messages */
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Tablet styles */
@media (max-width: 768px) {
  .formBox {
    padding: 30px 40px 40px 40px;
    max-width: 400px;
  }
  
  .logo .img1 {
    max-width: 25%;
  }
  
  .logo .img2 {
    width: 70%;
  }
  
  .option {
    flex-direction: column;
    align-items: flex-start;
    gap: 15px;
  }
  
  .fPass {
    margin-top: 0;
  }
  
  .formBox button {
    width: 90%;
    height: 48px;
    font-size: 16px;
  }
}

/* Mobile styles */
@media (max-width: 480px) {
  .loginPage {
    padding: 15px;
  }
  
  .formBox {
    padding: 25px 20px 30px 20px;
    max-width: 100%;
    margin: 0;
  }
  
  .logo {
    margin-bottom: 25px;
  }
  
  .logo .img1 {
    max-width: 30%;
    margin-bottom: -15px;
  }
  
  .logo .img2 {
    width: 75%;
  }
  
  .input-field {
    width: 100%;
  }
  
  .itext {
    padding: 14px;
    font-size: 16px; /* Prevents zoom on iOS */
  }
  
  .formBox button {
    width: 100%;
    height: 50px;
    font-size: 16px;
    margin-top: 25px;
  }
  
  .option {
    flex-direction: column;
    align-items: flex-start;
    gap: 15px;
    margin: 10px 0 20px 0;
  }
  
  .rememberMe {
    margin-top: 15px;
    font-size: 14px;
  }
  
  .forgotPassword {
    font-size: 14px;
  }
  
  .sUp {
    font-size: 13px;
    margin-top: 15px;
  }
  
  .error-messages,
  .alert {
    font-size: 13px;
    padding: 10px;
  }
  
  .eye-icon-container {
    right: 12px;
    padding: 8px;
  }
}

/* Large desktop styles */
@media (min-width: 1200px) {
  .formBox {
    max-width: 500px;
    padding: 50px 60px 60px 60px;
  }
  
  .logo .img1 {
    max-width: 18%;
  }
  
  .logo .img2 {
    width: 60%;
  }
  
  .itext {
    font-size: 16px;
    padding: 14px;
  }
  
  .formBox button {
    height: 48px;
    font-size: 17px;
  }
}

/* Landscape mobile orientation */
@media (max-height: 500px) and (orientation: landscape) {
  .loginPage {
    padding: 10px;
  }
  
  .formBox {
    padding: 20px;
    margin: 10px 0;
  }
  
  .logo {
    margin-bottom: 15px;
  }
  
  .logo .img1 {
    margin-bottom: -10px;
  }
  
  br {
    display: none;
  }
  
  .input-field {
    margin-bottom: 15px;
  }
  
  .option {
    margin: 10px 0;
  }
  
  .rememberMe {
    margin-top: 10px;
  }
}
</style>