<template>
  <div class="reset-password-container">
    <div class="reset-password-card">
      <div class="card-header">
        <h1>Set a new password</h1>
        <div class="password-requirements">
          <p class="subtitle">Password requirements:</p>
          <ul class="requirements-list">
            <li>
              <i class='bx bx-check-circle requirement-icon'></i>
              At least 8 characters
            </li>
            <li>
              <i class='bx bx-check-circle requirement-icon'></i>
              One uppercase letter
            </li>
            <li>
              <i class='bx bx-check-circle requirement-icon'></i>
              One lowercase letter
            </li>
            <li>
              <i class='bx bx-check-circle requirement-icon'></i>
              One number
            </li>
            <li>
              <i class='bx bx-check-circle requirement-icon'></i>
              One special character
            </li>
          </ul>
        </div>
      </div>
      
      <form @submit.prevent="resetPassword">
        <div class="form-group">
          <label for="password">Password</label>
          <div class="input-wrapper">
            <input
              :type="showPassword ? 'text' : 'password'"
              v-model.trim="password"
              id="password"
              placeholder="Enter your new password"
              @input="validatePassword"
              @blur="validatePassword"
              :class="{ 'input-error': passwordError }"
            />
            <span class="toggle-password" @click="showPassword = !showPassword">
              <i v-if="showPassword" class='bx bx-hide'></i>
              <i v-else class='bx bx-show'></i>
            </span>
          </div>
          <small class="error-text" v-if="passwordError">
            <i class='bx bx-error-circle'></i>
            {{ passwordError }}
          </small>
        </div>
        
        <div class="form-group">
          <label for="password_confirmation">Confirm Password</label>
          <div class="input-wrapper">
            <input
              :type="showConfirmPassword ? 'text' : 'password'"
              v-model.trim="password_confirmation"
              id="password_confirmation"
              placeholder="Confirm your new password"
              @input="validatePasswordMatch"
              @blur="validatePasswordMatch"
              :class="{ 'input-error': passwordMatchError }"
            />
            <span class="toggle-password" @click="showConfirmPassword = !showConfirmPassword">
              <i v-if="showConfirmPassword" class='bx bx-hide'></i>
              <i v-else class='bx bx-show'></i>
            </span>
          </div>
          <small class="error-text" v-if="passwordMatchError">
            <i class='bx bx-error-circle'></i>
            {{ passwordMatchError }}
          </small>
        </div>
        
        <button
          type="submit"
          :disabled="isSubmitting || passwordError || passwordMatchError || !password || !password_confirmation"
          :class="{ 'disabled': isSubmitting || passwordError || passwordMatchError || !password || !password_confirmation }"
        >
          <i v-if="isSubmitting" class='bx bx-loader-alt bx-spin'></i>
          <span v-else>RESET PASSWORD</span>
        </button>
      </form>
      
      <div v-if="error" class="error-message">
        <i class='bx bx-error-circle'></i>
        {{ error }}
      </div>
      
      <div v-if="success" class="success-message">
        <i class='bx bx-check-circle'></i>
        {{ success }}
      </div>
      
      <div class="back-to-login-wrapper">
        <a href="/verify-pin" class="back-to-login">
          <span class="arrow-circle">
            <i class='bx bx-arrow-back'></i>
          </span>
          Back to Verify Pin
        </a>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "ResetPassword",
  props: {
    email: {
      type: String,
      required: true,
    },
    pin: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      password: "",
      password_confirmation: "",
      error: "",
      success: "",
      passwordError: "",
      passwordMatchError: "",
      isSubmitting: false,
      showPassword: false,
      showConfirmPassword: false,
    };
  },
  methods: {
    validatePassword() {
      this.passwordError = "";

      if (!this.password) {
        this.passwordError = "Password is required.";
        return;
      }

      if (this.password.length < 8) {
        this.passwordError = "Password must be at least 8 characters.";
        return;
      }

      const hasUpperCase = /[A-Z]/.test(this.password);
      const hasLowerCase = /[a-z]/.test(this.password);
      const hasNumber = /\d/.test(this.password);
      const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(this.password);

      if (!hasUpperCase || !hasLowerCase || !hasNumber || !hasSpecialChar) {
        this.passwordError = "Password must include at least one uppercase letter, lowercase letter, number, and special character.";
        return;
      }
    },

    validatePasswordMatch() {
      this.passwordMatchError = "";

      if (!this.password_confirmation) {
        this.passwordMatchError = "Confirm Password is required.";
        return;
      }

      if (this.password !== this.password_confirmation) {
        this.passwordMatchError = "Passwords do not match.";
        return;
      }
    },

    async resetPassword() {
      this.error = "";
      this.success = "";
      this.validatePassword();
      this.validatePasswordMatch();

      if (this.passwordError || this.passwordMatchError) {
        return;
      }

      this.isSubmitting = true;
      try {
        const response = await axios.post("/resetpassword", {
          email: this.email,
          pin: this.pin,
          password: this.password,
          password_confirmation: this.password_confirmation,
        });

        if (response.data.success) {
          this.success = response.data.message;
          setTimeout(() => {
            window.location.href = "/login";
          }, 3000);
        } else {
          this.error = response.data.message || "An error occurred.";
        }
      } catch (error) {
        if (error.response && error.response.data && error.response.data.message) {
          this.error = error.response.data.message;
        } else {
          this.error = "An error occurred. Please try again.";
        }
      } finally {
        this.isSubmitting = false;
      }
    },
  },
};
</script>

<style scoped>
/* Import Boxicons */
@import url('https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css');

.reset-password-container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  padding: 1rem;
}

.reset-password-card {
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
  margin-bottom: 1.5rem;
}

h1 {
  font-size: 1.75rem;
  font-weight: 700;
  color: #212529;
  margin-bottom: 1rem;
  letter-spacing: -0.5px;
}

.subtitle {
  font-size: 0.95rem;
  font-weight: 600;
  color: #495057;
  margin-bottom: 0.5rem;
}

.password-requirements {
  margin-bottom: 1rem;
}

.requirements-list {
  list-style: none;
  padding: 0;
  margin: 0;
}

.requirements-list li {
  display: flex;
  align-items: center;
  font-size: 0.85rem;
  color: #6c757d;
  margin-bottom: 0.35rem;
}

.requirements-list li .requirement-icon {
  color: #2E7D32;
  margin-right: 0.5rem;
  flex-shrink: 0;
  font-size: 1rem;
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
  padding-right: 2.5rem;
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

.toggle-password {
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

.toggle-password:hover {
  color: #495057;
}

.toggle-password i {
  font-size: 1.2rem;
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

button i {
  font-size: 1.2rem;
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

.error-message i {
  font-size: 1.1rem;
}

.success-message {
  background-color: rgba(76, 175, 80, 0.1);
  color: #2E7D32;
}

.success-message i {
  font-size: 1.1rem;
}

.error-text {
  color: #dc3545;
  font-size: 0.8rem;
  margin-top: 0.5rem;
  display: flex;
  align-items: center;
  gap: 0.3rem;
}

.error-text i {
  font-size: 0.9rem;
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
  .reset-password-card {
    padding: 1.5rem;
    border-radius: 10px;
  }
  
  h1 {
    font-size: 1.5rem;
  }
  
  .requirements-list li {
    font-size: 0.8rem;
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