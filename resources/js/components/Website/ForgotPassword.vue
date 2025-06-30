<template>
  <div class="forgot-password-container">
    <div class="forgot-password-card">
      <div class="card-header">
        <h1>Forgot Password?</h1>
        <p class="subtitle">Please enter your email to receive a password reset link</p>
      </div>
      
      <form @submit.prevent="submitForm">
        <div class="form-group">
          <label for="email">
            Email Address <span class="required">*</span>
          </label>
          <div class="input-wrapper">
            <input
              type="email"
              v-model.trim="email"
              id="email"
              placeholder="Enter your email address"
              @input="validateEmail"
              @blur="validateEmail"
              :class="{ 'input-error': emailError }"
            />
            <span v-if="email" class="input-icon" @click="email = ''">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
            </span>
          </div>
          <small class="error-text" v-if="emailError">{{ emailError }}</small>
        </div>
        
        <button
          type="submit"
          :disabled="isSubmitting || emailError || !email"
          :class="{ 'disabled': isSubmitting || emailError || !email }"
        >
          <span v-if="isSubmitting" class="spinner"></span>
          <span v-else>RESET PASSWORD</span>
        </button>
      </form>
      
      <div v-if="error" class="error-message">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
        {{ error }}
      </div>
      
      <div v-if="success" class="success-message">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
        {{ success }}
      </div>
      
      <div class="back-to-login-wrapper">
        <a href="/login" class="back-to-login">
          <span class="arrow-circle">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
          </span>
          Back to login
        </a>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "ForgotPassword",
  data() {
    return {
      email: "",
      error: "",
      success: "",
      emailError: "",
      isSubmitting: false,
    };
  },
  methods: {
    validateEmail() {
      this.emailError = "";

      if (!this.email) {
        this.emailError = "Email is required.";
        return;
      }

      if (!this.validateEmailFormat(this.email)) {
        this.emailError = "Please enter a valid email address.";
        return;
      }
    },

    validateEmailFormat(email) {
      const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return re.test(email);
    },

    async submitForm() {
      this.error = "";
      this.success = "";
      this.validateEmail();

      if (this.emailError) {
        return;
      }

      this.isSubmitting = true;
      try {
        const response = await axios.post("/forgotpassword", {
          email: this.email,
        });

        if (response.data.success) {
          this.success = response.data.message;
          setTimeout(() => {
            window.location.href = `/verify-pin?email=${encodeURIComponent(this.email)}`;
          }, 3000);
        } else {
          this.error = response.data.message || "An error occurred.";
          if (response.data.message.includes("exists")) {
            this.error = "Email not found. Please use a registered email address.";
          }
        }
      } catch (error) {
        this.error = "An error occurred. Please try again.";
      } finally {
        this.isSubmitting = false;
      }
    },
  },
};
</script>

<style scoped>
.forgot-password-container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  padding: 1rem;
}

.forgot-password-card {
  background-color: #ffffff;
  padding: 2rem;
  border-radius: 12px;
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
  width: 100%;
  max-width: 420px;
  text-align: left;
  transition: all 0.3s ease;
}

.card-header {
  margin-bottom: 2rem;
}

h1 {
  font-size: 1.75rem;
  font-weight: 700;
  color: #212529;
  margin-bottom: 0.75rem;
  letter-spacing: -0.5px;
}

.subtitle {
  font-size: 0.95rem;
  color: #6c757d;
  line-height: 1.5;
}

.form-group {
  margin-bottom: 1.5rem;
}

.form-group label {
  display: block;
  font-size: 0.9rem;
  font-weight: 500;
  color: #495057;
  margin-bottom: 0.5rem;
}

.form-group label .required {
  color: #dc3545;
  margin-left: 2px;
}

.input-wrapper {
  position: relative;
}

.input-wrapper input {
  width: 100%;
  padding: 0.75rem 1rem;
  border: 1.5px solid #e9ecef;
  border-radius: 8px;
  font-size: 1rem;
  box-sizing: border-box;
  transition: all 0.2s ease;
  background-color: #f8f9fa;
}

.input-wrapper input::placeholder {
  color: #adb5bd;
}

.input-wrapper input:focus {
  outline: none;
  border-color: #4CAF50;
  background-color: #fff;
  box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.15);
}

.input-wrapper .input-error {
  border-color: #dc3545;
  background-color: #fff;
}

.input-wrapper .input-error:focus {
  box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.15);
}

.input-icon {
  position: absolute;
  right: 1rem;
  top: 50%;
  transform: translateY(-50%);
  color: #6c757d;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
}

.input-icon:hover {
  color: #495057;
}

button {
  background-color: #06693A;
  color: white;
  padding: 0.875rem 1rem;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-size: 0.9rem;
  font-weight: 600;
  width: 100%;
  transition: all 0.2s ease;
  display: flex;
  justify-content: center;
  align-items: center;
  letter-spacing: 0.5px;
}

button:hover {
  background-color: #1b5e20;
  transform: translateY(-1px);
  box-shadow: 0 4px 8px rgba(46, 125, 50, 0.2);
}

button:active {
  transform: translateY(0);
  box-shadow: none;
}

button.disabled {
  background-color: #adb5bd;
  cursor: not-allowed;
  transform: none;
  box-shadow: none;
}

.spinner {
  display: inline-block;
  width: 1rem;
  height: 1rem;
  border: 2px solid rgba(255, 255, 255, 0.3);
  border-radius: 50%;
  border-top-color: #fff;
  animation: spin 0.8s linear infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

.error-message, .success-message {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  margin-top: 1rem;
  padding: 0.75rem 1rem;
  border-radius: 8px;
  font-size: 0.9rem;
}

.error-message {
  background-color: rgba(220, 53, 69, 0.1);
  color: #dc3545;
}

.success-message {
  background-color: rgba(76, 175, 80, 0.1);
  color: #2E7D32;
}

.error-text {
  color: #dc3545;
  font-size: 0.8rem;
  margin-top: 0.5rem;
  display: block;
}

.back-to-login-wrapper {
  text-align: center;
  margin-top: 1.5rem;
}

.back-to-login {
  display: inline-flex;
  align-items: center;
  font-size: 0.9rem;
  color: #497E2E;
  text-decoration: none;
  transition: all 0.2s ease;
  font-weight: 500;
}

.back-to-login .arrow-circle {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 24px;
  height: 24px;
  background-color: rgba(76, 175, 80, 0.1);
  color: #4CAF50;
  border-radius: 50%;
  margin-right: 0.5rem;
  transition: all 0.2s ease;
}

.back-to-login:hover {
  color: #1b5e20;
}

.back-to-login:hover .arrow-circle {
  background-color: rgba(76, 175, 80, 0.2);
  transform: translateX(-3px);
}

/* Responsive styles for mobile */
@media (max-width: 480px) {
  .forgot-password-card {
    padding: 1.5rem;
    border-radius: 10px;
  }
  
  h1 {
    font-size: 1.5rem;
  }
  
  .subtitle {
    font-size: 0.85rem;
  }
  
  .input-wrapper input {
    padding: 0.7rem 0.9rem;
    font-size: 0.95rem;
  }
  
  button {
    padding: 0.8rem;
  }
}
</style>