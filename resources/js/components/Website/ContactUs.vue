<template>
  <!-- Responsive Navbar -->
  <nav>
    <a href="/" class="logo-link"><img src="@/components/Images/ATDC_logo.png" alt="Dental Clinic Logo"/></a>
    <div class="nav-links" :style="{ right: isMenuOpen ? '0' : '-250px' }">
      <i class="fas fa-times close-btn" @click="hideMenu"></i>
      <ul>
        <li><a href="/">Home</a></li>
        <li><a href="/about">About Us</a></li>
        <li><a href="/services">Services</a></li>
        <li><a href="/smilegallery">Smile Gallery</a></li>
        <li><a href="/faqs">FAQs</a></li>
        <li><a href="/contact">Contact Us</a></li>
        <li class="login-btn-container">
          <a href="/login"><button>Log In</button></a>
        </li>
      </ul>
    </div>
    <i class="fas fa-bars menu-btn" @click="showMenu"></i>
  </nav>

  <a href="#top" class="gtp" :class="{ 'show': showGoToTop }"><img src="@/components/Images/Go to top.png" alt="Go to top"></a>

  <section class="top-header" id="top">
    <div class="row">
      <div class="contact-us-col">
        <img src="@/components/Images/ATDC_pic7.png" alt="">
      </div>
      <div class="contact-us-col">
        <div class="contact">
          <h2>Get in touch with us!</h2>
          <div class="contact-form">
            <form method="post" action="#">
              <div class="name-fields">
                <div class="input-field">
                  <label for="fname">First Name</label> <br>
                  <input type="text" id="fname" name="firstname">
                </div>
                <div class="input-field">
                  <label for="lname">Last Name</label> <br>
                  <input type="text" id="lname" name="lastname">
                </div>
              </div>
              <br>
              <label for="email">Email Address</label> <br>
              <input type="text" id="email" name="emailadd" class="full-width-input">
              <br><br>
              <label for="number">Phone Number</label> <br>
              <input type="text" id="number" name="phonenumber" class="full-width-input">
              <br><br>
              <label for="message">Message</label> <br>
              <textarea id="message" name="message" class="full-width-textarea"></textarea>
              <br><br>
              <button type="submit" class="submit-btn">Send Message</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="next-line">
    <h2>We'd love to hear from you!</h2>
    <p>Got questions or need assistance? We're here to help! Reach out anytime...</p>
  </section>

  <section class="next-line1">
    <div class="row">
      <div class="three-col">
        <img src="@/components/Images/Time.png" alt="">
        <h2>Open Hours</h2>
        <p>Mondays to Sundays<br> 09:00 AM - 05:00 PM</p>
      </div>

      <div class="three-col">
        <img src="@/components/Images/Location.png" alt="">
        <h2>Address</h2>
        <p>203-205 J& F Building 1, Marcos Highway, Barangay Mayamot, Antipolo, Philippines</p>
      </div>

      <div class="three-col">
        <img src="@/components/Images/Get in touch.png" alt="">
        <h2>Get in touch</h2>
        <p>Aguila-Titular Dental Clinic Staffs</p>
      </div>
    </div>
  </section>

  <!-- Responsive Footer -->
  <section class="footer-section">
    <div class="footer-clean">
      <footer>
        <div class="footer-container">
          <!-- Logo & Clinic Info -->
          <div class="footer-col footer-info">
            <div class="logo-container">
              <img src="@/components/Images/ATDC_logo.png" alt="Aguila-Titular Dental Clinic Logo" class="footer-logo">
              <div class="logo-three">
                <img src="@/components/Images/ATDC_Logo3.png" alt="Aguila-Titular Dental Clinic Logo" class="footer-logo-text">
              </div>
            </div>
            <div class="location-info">
              <div class="info-item">
                <i class="fa-solid fa-map-location"></i>
                <span>203-205 J&F Building 1, Marcos Highway, Barangay Mayamot, Antipolo, Philippines</span>
              </div>
              <div class="info-item">
                <i class="fas fa-envelope"></i>
                <span>aguilatitular.dental@gmail.com</span>
              </div>
              <div class="info-item icon-phone">
                <i class="fas fa-phone"></i>
                <span>+63 908 863 0882</span>
              </div>
            </div>
          </div>

          <!-- Quick Links -->
          <div class="footer-col footer-links">
            <h3 class="footer-title">QUICK LINKS</h3>
            <ul>
              <li><a href="#">Home</a></li>
              <li><a href="/about">About Us</a></li>
              <li><a href="/services">Services</a></li>
              <li><a href="/smilegallery">Smile Gallery</a></li>
              <li><a href="/faqs">FAQs</a></li>
              <li><a href="/contact">Contact Us</a></li>
            </ul>
          </div>

          <!-- Clinic Hours -->
          <div class="footer-col footer-hours">
            <h3 class="footer-title">CLINIC HOURS</h3>
            <p style="margin-bottom: 10px;">Monday - Sunday</p>
            <p>9:00 AM - 5:00 PM</p>
          </div>

          <!-- Payment Methods -->
          <div class="footer-col footer-payment">
            <h3 class="footer-title">WE ACCEPT</h3>
            <p>CASH</p>
            <div class="payment-icons">
              <img src="@/components/Images/mastercard.png" alt="Mastercard">
              <img src="@/components/Images/visa.png" alt="Visa">
              <img src="@/components/Images/unionpay.png" alt="Unionpay">
              <img src="@/components/Images/bancnet.png" alt="Bancnet">
              <img src="@/components/Images/shopeepay.png" alt="ShopeePay">
              <img src="@/components/Images/grabpay.png" alt="GrabPay">
              <img src="@/components/Images/wechatpay.png" alt="WeChatPay">
              <img src="@/components/Images/medicard.png" alt="Medicard">
              <img src="@/components/Images/maxicare.png" alt="Maxicare">
            </div>
          </div>
          
          <!-- Social Media -->
          <div class="footer-col footer-social">
            <h3 class="footer-title">FOLLOW US</h3>
            <div class="social-icons">
              <a target="_blank" href="https://www.facebook.com/aguilatitulardental" rel="noreferrer">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a target="_blank" href="https://www.instagram.com/aguilatitulardent/" rel="noreferrer">
                <i class="fab fa-instagram"></i>
              </a>
            </div>
          </div>
        </div>

        <!-- Copyright Section -->
        <div class="footer-bottom">
          <p>© 2024 Aguila-Titular Dental Clinic. All Rights Reserved.</p>
        </div>
      </footer>
    </div>
  </section>
</template>

<script>
export default {
  name: "ContactUs",
  data() {
    return {
      isMenuOpen: false,
      showGoToTop: false
    };
  },
  mounted() {
    window.addEventListener('scroll', this.handleScroll);
  },
  beforeUnmount() {
    window.removeEventListener('scroll', this.handleScroll);
  },
  methods: {
    showMenu() {
      this.isMenuOpen = true; 
    },
    hideMenu() {
      this.isMenuOpen = false; 
    },
    handleScroll() {
      // Show button when user scrolls down 300px from the top
      this.showGoToTop = window.scrollY > 300;
    }
  }
};
</script>

<style>
/* Global styles for imports and variables */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap');
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css');

:root {
  --primary-color: #06693A;
  --secondary-color: #3CB54C;
  --text-color: #333;
  --white-color: #fff;
  --footer-background: #F0EDE3;
  --footer-bottom-background: #E0DACD;
}

html, body {
  margin: 0;
  padding: 0;
  width: 100%;
  height: 100%;
  font-family: 'Poppins', sans-serif;
  scroll-behavior: smooth;
  box-sizing: border-box;
}
</style>

<style scoped>
* {
  font-family: 'Poppins', sans-serif;
  scroll-behavior: smooth;
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

/* Go to top button */
.gtp {
  width: 50px;
  height: 50px;
  position: fixed;
  bottom: 20px;
  right: 20px;
  z-index: 99;
  cursor: pointer;
  opacity: 0;
  visibility: hidden;
  transform: translateY(20px);
  transition: all 0.3s ease;
}

.gtp.show {
  opacity: 1;
  visibility: visible;
  transform: translateY(0);
}

.gtp img {
  width: 100%;
  height: 100%;
  object-fit: contain;
}

.gtp:hover {
  animation: bounce 0.4s ease-in-out infinite alternate;
}

@keyframes bounce {
  from {
    transform: scale(1); 
  }
  to {
    transform: scale(1.2); 
  }
}

/* Responsive Navbar - Matching Homepage */
nav {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px 4%;
  background-color: var(--primary-color);
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  position: sticky;
  top: 0;
  z-index: 1000;
  width: 100%;
}

.logo-link {
  display: block;
}

nav img {
  width: 90px;
  height: auto;
  display: block;
}

.nav-links {
  flex: 1;
  text-align: right;
  transition: 0.5s;
}

.nav-links ul {
  display: flex;
  justify-content: flex-end;
  align-items: center;
  list-style: none;
}

.nav-links ul li {
  display: inline-block;
  padding: 10px 15px;
  position: relative;
  margin: 0 5px;
}

.nav-links ul li a {
  color: var(--white-color);
  text-decoration: none;
  font-size: 15px;
  transition: 0.3s;
  position: relative;
  padding: 5px 0;
}

/* Create underline effect on hover - Matching Homepage */
.nav-links ul li a::after {
  content: '';
  position: absolute;
  width: 0;
  height: 2px;
  background: var(--white-color);
  left: 0;
  bottom: 0;
  transition: width 0.3s ease;
}

.nav-links ul li a:hover::after {
  width: 100%;
}

/* Keep the text color white on hover - Matching Homepage */
.nav-links ul li a:hover {
  color: var(--white-color);
}

.nav-links button {
  background-color: var(--white-color);
  border-radius: 5px;
  border: none;
  font-size: 15px;
  padding: 8px 23px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.nav-links button:hover {
  background-color: #f0f0f0;
}

/* Fixed: Enhanced menu button styles to ensure icons display */
.menu-btn, .close-btn {
  display: none;
  color: var(--white-color);
  font-size: 24px;
  cursor: pointer;
  font-family: "Font Awesome 6 Free" !important;
  font-weight: 900 !important;
  -webkit-font-smoothing: antialiased !important;
  -moz-osx-font-smoothing: grayscale !important;
}

/* Contact Page Styles */
.top-header {
  width: 95%;
  margin: auto;
  text-align: center;
  padding: 50px 20px;
}

form {
  text-align: left;
  border: 2px solid #e4e4e4;
  border-radius: 10px;
  padding: 30px;
  max-width: 100%;
}

/* FIXED: Responsive input styling */
input {
  background-color: #e4e4e4;
  border-radius: 5px;
  border: none;
  width: 100%;
  height: 40px;
  padding: 0 10px;
  font-size: 14px;
  box-sizing: border-box;
}

.full-width-input {
  width: 100%;
}

textarea {
  background-color: #e4e4e4;
  border-radius: 5px;
  border: none;
  padding: 10px;
  font-size: 14px;
  font-family: 'Poppins', sans-serif;
}

.full-width-textarea {
  height: 200px;
  width: 100%;
  resize: vertical;
}

.submit-btn {
  background-color: var(--primary-color);
  color: var(--white-color);
  border: none;
  border-radius: 5px;
  padding: 12px 30px;
  font-size: 16px;
  cursor: pointer;
  transition: background-color 0.3s ease;
  width: 100%;
  max-width: 200px;
}

.submit-btn:hover {
  background-color: var(--secondary-color);
}

.row {
  display: flex;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 20px;
}

.contact-us-col {
  border-radius: 10px;
  padding: 20px 12px;
  box-sizing: border-box;
  transition: 0.5s;
  flex: 1;
  min-width: 300px;
}

.contact-us-col img {
  width: 100%;
  max-width: 500px;
  display: block;
  margin: 30px auto 0;
}

.contact h2 {
  text-align: left;
  padding-bottom: 20px;
  font-size: 40px;
}

.contact {
  margin-top: -20px;
}

/* FIXED: Responsive name fields */
.name-fields {
  display: flex;
  justify-content: space-between;
  gap: 15px;
  flex-wrap: wrap;
}

.input-field {
  flex: 1;
  min-width: 0;
}

/* next-line */
.next-line {
  width: 95%;
  margin: auto;
  padding: 50px 20px 20px;
  text-align: center;
}

.next-line h2 {
  font-size: 40px;
}

.next-line p {
  color: grey;
  font-size: 16px;
  line-height: 1.6;
}

/* next-line1 */
.next-line1 {
  width: 100%;
  margin: auto;
  padding: 50px 20px;
  background: var(--primary-color);
  color: white;
}

.three-col {
  flex: 1;
  min-width: 250px;
  border-radius: 10px;
  padding: 20px 12px;
  box-sizing: border-box;
  transition: 0.5s;
  text-align: center;
}

.three-col img {
  width: 80px;
  display: block;
  margin: 0 auto 20px;
}

.three-col h2 {
  text-align: center;
  margin-bottom: 20px;
  font-size: 24px;
}

.three-col p {
  text-align: center;
  font-size: 14px;
  line-height: 1.6;
}

/* Responsive Footer - Fixed for smaller screens */
.footer-section {
  background: var(--footer-background);
}

.footer-clean {
  font-family: 'Poppins', sans-serif;
  color: var(--text-color);
  padding-top: 40px;
}

.footer-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 40px;
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
}

.footer-col {
  margin-bottom: 40px;
}

.footer-info {
  grid-column: span 2;
}

.logo-container {
  display: flex;
  align-items: center;
  margin-bottom: 25px;
  gap: 5px;
}

.footer-logo {
  width: 70px;
  height: auto;
}

.logo-three img, .footer-logo-text {
  width: 180px;
  height: auto;
  margin-left: 5px;
}

.location-info {
  display: flex;
  flex-direction: column;
  gap: 20px;
  margin-left: 30px;
  margin-top: 15px;
  margin-bottom: 35px;
}

.info-item {
  display: flex;
  align-items: flex-start;
  gap: 15px;
}

/* Fixed: Changed icon color to match navbar green */
.info-item i {
  font-size: 18px !important;
  color: var(--primary-color) !important;
  min-width: 20px;
  flex-shrink: 0;
  font-family: "Font Awesome 6 Free" !important;
  font-weight: 900 !important;
  display: inline-block !important;
}

.info-item span {
  font-size: 14px;
  line-height: 1.5;
}

.icon-phone {
  margin-left: 0px;
}

.footer-title {
  font-size: 18px;
  font-weight: 600;
  margin-bottom: 25px;
  color: var(--primary-color);
}

.footer-links ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.footer-links li {
  margin-bottom: 15px;
  margin-left: 10px;
}

.footer-links a {
  text-decoration: none;
  color: var(--text-color);
  font-size: 14px;
  transition: color 0.3s ease;
}

.footer-links a:hover {
  color: #7e685a;
  text-decoration: underline;
}

.footer-hours p, .footer-payment p {
  font-size: 14px;
  margin: 8px 0;
  line-height: 1.5;
}

/* Fixed Payment Icons Grid - 3x3 Layout */
.payment-icons {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 8px;
  margin-top: 15px;
  justify-items: center;
}

.payment-icons img {
  width: 55px;
  height: 35px;
  object-fit: contain;
}

/* Fixed Social Icons */
.social-icons {
  display: flex;
  gap: 15px;
}

.social-icons a {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 40px;
  height: 40px;
  background-color: var(--primary-color);
  color: var(--white-color);
  border-radius: 50%;
  transition: all 0.3s ease;
  text-decoration: none;
  font-size: 20px;
}

.social-icons a:hover {
  background-color: var(--secondary-color);
  transform: translateY(-3px);
}

.social-icons i {
  font-size: 18px !important;
  font-family: "Font Awesome 6 Brands" !important;
  font-weight: 400 !important;
  display: inline-block !important;
}

.footer-bottom {
  background-color: var(--footer-bottom-background);
  text-align: center;
  padding: 15px 0px;
  margin-top: 30px;
}

.footer-bottom p {
  font-size: 14px;
  margin: 0;
}

/* Media Queries for Responsiveness - Matching Homepage */
@media (max-width: 1200px) and (min-width: 769px) {
  .nav-links ul {
    gap: 5px;
  }
  
  .nav-links ul li {
    padding: 10px 8px;
  }
  
  .nav-links ul li a {
    font-size: 14px;
    padding: 10px 6px;
  }
  
  .login-btn-container {
    margin-left: 10px;
  }
  
  .nav-links button {
    padding: 6px 15px;
    font-size: 14px;
  }
}

@media (max-width: 992px) and (min-width: 769px) {
  .nav-links ul li {
    padding: 10px 0px;
  }
  
  .nav-links ul li a {
    font-size: 12px;
  }
}

@media (max-width: 992px) {
  .footer-info {
    grid-column: span 1;
  }
  
  .contact h2 {
    font-size: 32px;
  }
  
  .next-line h2 {
    font-size: 32px;
  }
  
  .nav-links ul li a {
    font-size: 14px;
  }
}

@media (max-width: 768px) {
  /* Navbar Mobile Styling - Matching Homepage */
  .nav-links {
    position: fixed;
    background: var(--primary-color);
    height: 100vh;
    width: 250px;
    top: 0;
    right: -250px;
    text-align: left;
    z-index: 1001;
    transition: 0.5s;
    padding-top: 60px;
  }
  
  .nav-links ul {
    flex-direction: column;
    align-items: flex-start;
    padding: 0 30px;
  }
  
  .nav-links ul li {
    display: block;
    margin: 10px 0;
    width: 100%;
    padding: 12px 0;
    margin: 5px 0;
  }
  
  .login-btn-container {
    margin-top: 20px;
  }
  
  .menu-btn, .close-btn {
    display: block;
  }
  
  .close-btn {
    position: absolute;
    top: 20px;
    right: 20px;
  }
  
  /* Ensure hover effect works in mobile menu */
  .nav-links ul li a:hover::after {
    width: 100%;
  }
  
  /* Contact Page Mobile */
  .row {
    flex-direction: column;
  }
  
  .contact-us-col {
    min-width: 100%;
    margin-bottom: 20px;
  }
  
  .contact h2 {
    font-size: 28px;
    text-align: center;
  }
  
  /* FIXED: Mobile responsive name fields */
  .name-fields {
    flex-direction: column;
    gap: 15px;
  }
  
  .input-field {
    min-width: 100%;
    width: 100%;
  }
  
  .input-field input {
    width: 100%;
    min-width: 0;
  }
  
  .next-line h2 {
    font-size: 28px;
  }
  
  .three-col {
    min-width: 100%;
    margin-bottom: 20px;
  }
  
  /* Footer Mobile - Fixed Layout */
  .footer-container {
    grid-template-columns: 1fr;
    gap: 30px;
    padding: 0 15px;
  }
  
  .footer-info {
    grid-column: span 1;
    text-align: center;
  }
  
  .logo-container {
    justify-content: center;
  }
  
  .location-info {
    margin-left: 0;
    align-items: center;
    text-align: center;
  }
  
  .info-item {
    justify-content: center;
    text-align: center;
    flex-direction: column;
    gap: 8px;
    align-items: center;
  }
  
  .info-item i {
    margin-bottom: 5px;
    text-align: center;
    align-self: center;
  }
  
  .info-item span {
    text-align: center;
    display: block;
    width: 100%;
  }
  
  .footer-title {
    text-align: center;
  }
  
  .footer-links ul {
    text-align: center;
  }
  
  .footer-links li {
    margin-left: 0;
  }
  
  .footer-hours, .footer-payment {
    text-align: center;
  }
  
  /* Mobile Payment Icons - Smaller 3x3 Grid */
  .payment-icons {
    grid-template-columns: repeat(3, 1fr);
    gap: 5px;
    max-width: 180px;
    margin: 15px auto 0;
  }
  
  .payment-icons img {
    width: 45px;
    height: 30px;
  }
  
  .social-icons {
    justify-content: center;
  }
}

/* FIXED: Additional responsive breakpoint for very small screens */
@media (max-width: 576px) {
  nav img {
    width: 70px;
  }
  
  .top-header {
    padding: 30px 10px;
  }
  
  .contact h2 {
    font-size: 24px;
  }
  
  .next-line h2 {
    font-size: 24px;
  }
  
  .next-line, .top-header {
    width: 100%;
    padding-left: 15px;
    padding-right: 15px;
  }
  
  form {
    padding: 20px;
  }
  
  /* FIXED: Better spacing for name fields on very small screens */
  .name-fields {
    gap: 12px;
  }
  
  .gtp {
    width: 40px;
    height: 40px;
    bottom: 15px;
    right: 15px;
  }
  
  /* Extra small screens - Even smaller payment icons */
  .payment-icons {
    max-width: 150px;
    gap: 3px;
  }
  
  .payment-icons img {
    width: 40px;
    height: 25px;
  }
  
  .location-info {
    gap: 15px;
  }
  
  .footer-col {
    margin-bottom: 25px;
  }
}

/* FIXED: Additional responsive breakpoint for very small screens */
@media (max-width: 480px) {
  .name-fields {
    gap: 12px;
  }
  
  form {
    padding: 15px;
  }
  
  .input-field input {
    font-size: 14px;
    height: 38px;
  }
}

@media (min-width: 1200px) {
  .footer-container {
    display: flex;
    flex-wrap: nowrap;
    justify-content: space-between;
    gap: 30px;
  }
  
  .footer-info {
    flex: 0 0 30%;
    grid-column: span 1;
  }
  
  .footer-col {
    flex: 0 0 15%;
    padding: 0 10px;
  }
}
</style>
