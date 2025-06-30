<template>
  <div class="verify-pin-container">
    <div class="verify-pin-card">
      <div class="card-header">
        <h1>Verify PIN</h1>
        <p class="subtitle">
          <i class='bx bx-pulse icon-pulse'></i>
          We sent a verification code to
        </p>
        <p class="email-display">{{ email }}</p>
        
        <div class="countdown-wrapper" :class="{ 'expiring': remainingSeconds <= 60 }">
          <i class='bx bx-time-five'></i>
          <span>Code expires in {{ formattedTime }}</span>
        </div>
      </div>
      
      <form @submit.prevent="submitForm">
        <div class="pin-inputs">
          <input
            v-for="(digit, index) in pinDigits"
            :key="index"
            type="text"
            inputmode="numeric"
            pattern="[0-9]*"
            maxlength="1"
            v-model="pinDigits[index]"
            @input="handleInput(index, $event)"
            @keydown="handleKeydown(index, $event)"
            class="pin-box"
            :class="{ 'filled': pinDigits[index] !== '' }"
            ref="pinInputs"
            autocomplete="one-time-code"
          />
        </div>
        
        <button
          type="submit"
          :disabled="isSubmitting || !isPinComplete"
          :class="{ 'disabled': isSubmitting || !isPinComplete }"
        >
          <i v-if="isSubmitting" class='bx bx-loader-alt bx-spin'></i>
          <span v-else>VERIFY PIN</span>
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
        <a href="/forgotpassword" class="back-to-login">
          <span class="arrow-circle">
            <i class='bx bx-arrow-back'></i>
          </span>
          Back to Forgot Password
        </a>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "VerifyPin",
  props: {
    email: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      pinDigits: Array(6).fill(""), // Array to hold 6 digits
      error: "",
      success: "",
      isSubmitting: false,
      remainingSeconds: 300, // 5 minutes in seconds
      countdownInterval: null,
    };
  },
  computed: {
    isPinComplete() {
      return this.pinDigits.every(digit => digit !== "");
    },
    enteredPin() {
      return this.pinDigits.join("");
    },
    formattedTime() {
      const minutes = Math.floor(this.remainingSeconds / 60);
      const seconds = this.remainingSeconds % 60;
      return `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
    }
  },
  methods: {
    handleInput(index, event) {
      const value = event.target.value;
      if (value && !/^\d$/.test(value)) {
        this.pinDigits[index] = "";
        return;
      }

      if (value && index < 5) {
        this.$refs.pinInputs[index + 1].focus();
      }
    },
    handleKeydown(index, event) {
      if (event.key === "Backspace" && !this.pinDigits[index] && index > 0) {
        this.$refs.pinInputs[index - 1].focus();
      }
    },
    async submitForm() {
      this.error = "";
      this.success = "";
      this.isSubmitting = true;

      try {
        const response = await axios.post("/verify-pin", {
          email: this.email,
          pin: this.enteredPin,
        });

        if (response.data.success) {
          this.success = response.data.message;
          console.log("PIN verified successfully, redirecting in 3 seconds...");
          setTimeout(() => {
            console.log("Redirecting to /resetpassword with email:", this.email, "and pin:", this.enteredPin);
            window.location.href = `/resetpassword?email=${encodeURIComponent(this.email)}&pin=${encodeURIComponent(this.enteredPin)}`;
          }, 3000);
        } else {
          this.error = response.data.message || "Invalid PIN";
        }
      } catch (error) {
        console.error("Error during PIN verification:", error);
        this.error = "An error occurred. Please try again.";
      } finally {
        this.isSubmitting = false;
      }
    },
    startCountdown() {
      this.countdownInterval = setInterval(() => {
        if (this.remainingSeconds > 0) {
          this.remainingSeconds--;
        } else {
          clearInterval(this.countdownInterval);
          // Optionally handle PIN expiration here
          this.error = "Verification code has expired. Please request a new one.";
        }
      }, 1000);
    }
  },
  mounted() {
    // Focus on the first input when the component is mounted
    if (this.$refs.pinInputs && this.$refs.pinInputs.length > 0) {
      this.$refs.pinInputs[0].focus();
    }
    
    // Start the countdown
    this.startCountdown();
  },
  beforeDestroy() {
    // Clear the interval when the component is destroyed
    if (this.countdownInterval) {
      clearInterval(this.countdownInterval);
    }
  }
};
</script>

<style scoped>
/* Import Boxicons */
@import url('https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css');

.verify-pin-container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  padding: 1rem;
}

.verify-pin-card {
  background-color: #ffffff;
  padding: 2rem;
  border-radius: 12px;
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
  width: 100%;
  max-width: 420px;
  text-align: center;
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
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.95rem;
  color: #6c757d;
  margin-bottom: 0.5rem;
}

.subtitle .icon-pulse {
  margin-right: 0.5rem;
  color: #2E7D32;
  font-size: 1.1rem;
}

.email-display {
  font-size: 1rem;
  font-weight: 600;
  color: #212529;
  margin-bottom: 1rem;
}

.countdown-wrapper {
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.9rem;
  color: #6c757d;
  background-color: #f8f9fa;
  padding: 0.5rem 1rem;
  border-radius: 50px;
  margin: 0 auto;
  width: fit-content;
  transition: all 0.3s ease;
}

.countdown-wrapper i {
  margin-right: 0.5rem;
  color: #2E7D32;
  font-size: 1rem;
}

.countdown-wrapper.expiring {
  color: #dc3545;
  background-color: rgba(220, 53, 69, 0.1);
}

.countdown-wrapper.expiring i {
  color: #dc3545;
}

.pin-inputs {
  display: flex;
  justify-content: center;
  gap: 0.75rem;
  margin-bottom: 1.5rem;
}

.pin-box {
  width: 3rem;
  height: 3.5rem;
  text-align: center;
  border: 1.5px solid #e9ecef;
  border-radius: 8px;
  font-size: 1.25rem;
  font-weight: 600;
  box-sizing: border-box;
  transition: all 0.2s ease;
  background-color: #f8f9fa;
  color: #212529;
}

.pin-box:focus {
  outline: none;
  border-color: #4CAF50;
  background-color: #fff;
  box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.15);
}

.pin-box.filled {
  background-color: #fff;
  border-color: #4CAF50;
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
  margin-bottom: 1rem;
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
  justify-content: center;
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
  .verify-pin-card {
    padding: 1.5rem;
    border-radius: 10px;
  }
  
  h1 {
    font-size: 1.5rem;
  }
  
  .pin-inputs {
    gap: 0.5rem;
  }
  
  .pin-box {
    width: 2.5rem;
    height: 3rem;
    font-size: 1.1rem;
  }
  
  button {
    padding: 0.8rem;
  }
  
  .countdown-wrapper {
    font-size: 0.8rem;
    padding: 0.4rem 0.8rem;
  }
}
</style>