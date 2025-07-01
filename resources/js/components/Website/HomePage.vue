<template>
  <!-- Responsive Navbar -->
  <nav>
    <a href="/" class="logo-link"><img src="../Images/ATDC_logo.png" alt="Dental Clinic Logo"/></a>
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

  <a href="#top" class="gtp" :class="{ 'show': showGoToTop }"><img src="../Images/Go to top.png" alt="Go to top"></a>

  <!-- Hero Section -->
  <section class="top-header" id="top">
    <div class="text-box">
      <h1>Your Smile, <br> Our Passion</h1>
      <p>Aguila-Titular Dental Clinic is a trusted provider of high-quality dental care, offering a wide range of services to meet the oral health needs of its patients. With a focus on patient comfort and advanced treatment techniques, the clinic is dedicated to delivering exceptional care in a welcoming and professional environment.</p>
      <a href="/login" class="appointment-btn"><b>Make An Appointment</b></a>
    </div>
  </section>

  <!-- Brighter Smiles Section - Improved for Responsiveness -->
  <section class="next-line1">
    <h1 class="section-title">A solution for brighter smiles</h1>
    <div class="inline">
      <div class="teeth-container">
        <img src="../Images/Teeth.png" alt="Teeth" class="teeth">
      </div>
      <div class="text-container">
        <p>We believe that a bright smile can change more than looks. It can enhance one's self-confidence and elevate quality of life. Allow us to assist you in obtaining the smile you've always desired and see how it can positively influence you. Our commitment to excellence and patient satisfaction has earned us the loyalty of our community, and we look forward to continuing to serve you.</p>
      </div>
    </div>
  </section>

  <!-- Why Choose Section -->
  <section class="next-line3">
    <h1>WHY CHOOSE <br> AGUILA-TITULAR DENTAL CLINIC</h1>

    <div class="row">
      <div class="why-col">
        <img src="../Images/Front Desk.png" alt="Front Desk">
        <h3>Friendly Staffs</h3>
        <p>Our front desk team is not only welcoming but friendly and efficient, ensuring that every visit starts off with a warm welcome and smooth check-in process. They are always ready to assist you with scheduling, answering questions.</p>
      </div>

      <div class="why-col">
        <img src="../Images/Interaction.png" alt="Interaction">
        <h3>Provide Comfort</h3>
        <p>At Aguila-Titular Dental Clinic, we place a high priority on your comfort. From the moment you enter, our team ensures that out patients is at ease, and we use different approach to minimize discomfort and make your visit as pleasant as possible.</p>
      </div>

      <div class="why-col">
        <img src="../Images/Dental Chair.png" alt="Dental Chair">
        <h3>Clean Facility</h3>
        <p>Our clinic is maintained to meet the standards of cleanliness and hygiene. We understand how important a safe environment, and we take every precaution to ensure that all equipment and treatment areas are properly sanitized.</p>
      </div>

      <div class="why-col">
        <img src="../Images/Dentist.png" alt="Dentist">
        <h3>Experienced Dentists</h3>
        <p>Our team of dentists has years of experience and a passion for providing high-quality dental care. They utilize the different advancements in dentistry to offer personalized treatments that meet the patient's specific needs.</p>
      </div>
    </div>
  </section>

  <!-- Values Section -->
  <section class="next-line5">
    <div class="row">
      <div class="what-col" style="background: #F5F5F5;">
        <img src="../Images/heart.png" alt="Heart">
        <p>At Aguila-Titular Dental Clinic, we understand that dental visits can be stressful. Our compassionate team is here to ensure you feel at ease and provide gentle care to make your experience as stress-free as possible.</p>
      </div>

      <div class="what-col" style="background: #3CB54C; color:white">
        <img src="../Images/crowd.png" alt="Crowd">
        <p>We embrace diversity and treat each patient with respect and understanding. Our team is committed to providing personalized care that meets the unique needs of individuals from all walks of life.</p>
      </div>

      <div class="what-col" style="background: #06693A; color: white;">
        <img src="../Images/toothheart.png" alt="Tooth Heart">
        <p>Top-tier care is at the heart of everything we do and is our priority. Our team provides personalized treatment in a professional, comfortable setting, ensuring your complete satisfaction.</p>
      </div>
    </div>
  </section>

  <!-- Accredited HMO Section - Improved for Responsiveness -->
  <section class="accredited-section">
    <h1 class="accredited-hmo">ACCREDITED HMO FOR AGUILA-TITULAR DENTAL CLINIC</h1>
    <div class="accredited-row">
      <div class="accredited-col">
        <img src="../Images/medicard.png" alt="Medicard">
      </div>
      <div class="accredited-col">
        <img src="../Images/maxicare.png" alt="Maxicare">
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
              <img src="../Images/ATDC_Logo.png" alt="Aguila-Titular Dental Clinic Logo" class="footer-logo">
              <img src="../Images/ATDC_Logo3.png" alt="Aguila-Titular Dental Clinic Logo" class="footer-logo-text">
            </div>
            <div class="location-info">
              <div class="info-item">
                <i class="fa-solid fa-map-location"></i>
                <span>203-205 J&F Building 1, Marcos Highway, Barangay Mayamot, Antipolo, Philippines</span>
              </div>
              <div class="info-item">
                <i class="fa-solid fa-envelope"></i>
                <span>aguilatitular.dental@gmail.com</span>
              </div>
              <div class="info-item">
                <i class="fa-solid fa-phone"></i>
                <span>+63 908 863 0882</span>
              </div>
            </div>
          </div>

          <!-- Quick Links -->
          <div class="footer-col footer-links">
            <h3 class="footer-title">QUICK LINKS</h3>
            <ul>
              <li><a href="/">Home</a></li>
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
            <p>Monday - Sunday</p>
            <p>9:00 AM - 5:00 PM</p>
          </div>

          <!-- Payment Methods -->
          <div class="footer-col footer-payment">
            <h3 class="footer-title">WE ACCEPT</h3>
            <p>CASH</p>
            <div class="payment-icons">
              <img src="../Images/mastercard.png" alt="Mastercard">
              <img src="../Images/visa.png" alt="Visa">
              <img src="../Images/unionpay.png" alt="Unionpay">
              <img src="../Images/bancnet.png" alt="Bancnet">
              <img src="../Images/shopeepay.png" alt="ShopeePay">
              <img src="../Images/grabpay.png" alt="GrabPay">
              <img src="../Images/wechatpay.png" alt="WeChatPay">
              <img src="../Images/medicard.png" alt="Medicard">
              <img src="../Images/maxicare.png" alt="Maxicare">
            </div>
          </div>
          
          <!-- Social Media -->
          <div class="footer-col footer-social">
            <h3 class="footer-title">FOLLOW US</h3>
            <div class="social-icons">
              <a target="_blank" href="https://www.facebook.com/aguilatitulardental" rel="noreferrer">
                <i class="fab fa-facebook"></i>
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
  name: "HomePage",
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
  margin: 0;
  padding: 0;
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

/* Responsive Navbar */
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
  margin: 0 5px; /* Add horizontal spacing between items */
}

.nav-links ul li a {
  color: var(--white-color);
  text-decoration: none;
  font-size: 15px;
  transition: 0.3s;
  position: relative;
  padding: 5px 0; /* Add padding for the underline effect */
}

/* Create underline effect on hover */
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

/* Remove the color change on hover */
.nav-links ul li a:hover {
  color: var(--white-color); /* Keep the text color white */
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

.menu-btn, .close-btn {
  display: none;
  color: var(--white-color);
  font-size: 24px;
  cursor: pointer;
  z-index: 1002;
  transition: all 0.3s ease;
}

.menu-btn:hover, .close-btn:hover {
  transform: scale(1.1);
  opacity: 0.8;
}

/* Hero Section */
.top-header {
  min-height: 100vh;
  width: 100%;
  background-image: linear-gradient(rgba(4,9,30,0.3), rgba(4,9,30,0.3)), url(../Images/ATDC_pic1.png);
  background-position: center;
  background-size: cover;
  position: relative;
  display: flex;
  align-items: center;
}

.text-box {
  width: 90%;
  color: var(--white-color);
  margin-left: 5%;
}

.text-box h1 {
  font-size: 62px;
  margin-bottom: 20px;
}

.text-box p {
  margin: 10px 0 40px;
  font-size: 16px;
  line-height: 1.6;
  max-width: 800px;
}

.appointment-btn {
  display: inline-block;
  text-decoration: none;
  color: var(--white-color);
  border: 1px solid var(--white-color);
  padding: 12px 34px;
  font-size: 16px;
  background: transparent;
  position: relative;
  cursor: pointer;
  transition: all 0.3s ease;
}

.appointment-btn:hover {
  border: 1px solid var(--secondary-color);
  background: var(--secondary-color);
}

/* Brighter Smiles Section - Improved for Responsiveness */
.next-line1 {
  width: 100%;
  padding: 80px 20px;
  background-color: var(--primary-color);
  color: var(--white-color);
}

.section-title {
  color: var(--white-color);
  font-size: 40px;
  margin-bottom: 40px;
  padding-left: 20px;
  border-left: 10px solid var(--secondary-color);
  max-width: 800px; /* Increased from 600px to fit title on one line */
  margin-left: auto;
  margin-right: auto;
  text-align: left;
  white-space: nowrap; /* Ensures title stays on one line */
}

.inline {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  max-width: 1200px;
  margin: 0 auto;
  gap: 30px;
}

.teeth-container {
  flex: 0 0 120px;
  display: flex;
  justify-content: center;
}

.teeth {
  filter: invert(1) brightness(100%) contrast(100%);
  width: 100%;
  max-width: 100px;
}

.text-container {
  flex: 1;
  min-width: 300px;
}

.next-line1 p {
  font-size: 16px;
  line-height: 1.6;
  color: var(--white-color);
  text-align: justify;
}

/* Why Choose Section */
.next-line3 {
  width: 100%;
  margin: 0 auto;
  padding: 80px 60px;
  text-align: center;
}

.next-line3 h1 {
  font-size: 40px;
  margin-bottom: 50px;
}

.row {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 40px;
  margin-top: 40px;
}

.why-col {
  flex: 1;
  min-width: 250px;
  max-width: 350px;
  padding: 30px;
  border-radius: 5px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.06);
  transition: transform 0.3s ease;
}

.why-col:hover {
  transform: translateY(-10px);
}

.why-col img {
  width: 40%;
  margin-bottom: 20px;
}

.why-col h3 {
  margin-bottom: 15px;
  font-size: 22px;
}

.why-col p {
  font-size: 15px;
  line-height: 1.6;
}

/* Values Section */
.next-line5 {
  width: 90%;
  max-width: 1200px;
  margin: 0 auto;
  padding: 40px 0 80px;
}

.what-col {
  flex: 1;
  min-width: 250px;
  padding: 30px;
  border-radius: 10px;
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
}

.what-col img {
  width: 100px;
  margin-bottom: 20px;
}

.what-col p {
  font-size: 15px;
  line-height: 1.6;
}

/* Accredited HMO Section - Improved for Responsiveness */
.accredited-section {
  padding: 60px 20px;
  background-color: #f8f8f8;
}

.accredited-hmo {
  text-align: center;
  font-size: 40px;
  margin-bottom: 40px;
}

.accredited-row {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  align-items: center;
  gap: 30px;
  max-width: 1200px;
  margin: 0 auto;
}

.accredited-col {
  flex: 0 0 auto;
  text-align: center;
}

.accredited-col img {
  max-width: 100%;
  height: auto;
  width: 300px;
}

/* Responsive Footer */
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
  gap: 40px; /* Increased from 30px for more vertical spacing */
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
}

.footer-col {
  margin-bottom: 40px; /* Increased from 30px for more vertical spacing */
}

.footer-info {
  grid-column: span 2;
}

.logo-container {
  display: flex;
  align-items: center;
  margin-bottom: 25px; /* Increased from 20px for more vertical spacing */
}

.footer-logo {
  width: 70px;
  height: auto;
}

.footer-logo-text {
  width: 180px;
  height: auto;
  margin-left: 5px;
}

.location-info {
  display: flex;
  flex-direction: column;
  gap: 20px; /* Increased from 15px for more vertical spacing */
}

.info-item {
  display: flex;
  align-items: flex-start;
  gap: 15px;
}

.info-item i {
  font-size: 18px;
  color: var(--primary-color);
  min-width: 20px;
}

.info-item span {
  font-size: 14px;
  line-height: 1.5;
}

.footer-title {
  font-size: 18px;
  font-weight: 600;
  margin-bottom: 25px; /* Increased from 20px for more vertical spacing */
  color: var(--primary-color);
}

.footer-links ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.footer-links li {
  margin-bottom: 15px; /* Increased from 10px for more vertical spacing */
}

.footer-links a {
  text-decoration: none;
  color: var(--text-color);
  font-size: 14px;
  transition: color 0.3s ease;
}

.footer-links a:hover {
  color: var(--primary-color);
}

.footer-hours p {
  font-size: 14px;
  margin: 8px 0; /* Increased from 5px for more vertical spacing */
  line-height: 1.5;
}

.footer-payment p {
  font-size: 14px;
  margin-bottom: 20px; /* Increased from 15px for more vertical spacing */
}

.payment-icons {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 15px; /* Increased from 10px for more vertical spacing */
}

.payment-icons img {
  width: 50px;
  height: 30px;
  object-fit: contain;
}

.social-icons {
  display: flex;
  gap: 20px; /* Increased from 15px for more vertical spacing */
}

.social-icons a {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 40px;
  height: 40px;
  background-color: var(--primary-color);
  color: var(--white-color);
  border-radius: 50%;
  transition: all 0.3s ease;
  text-decoration: none;
}

.social-icons a:hover {
  background-color: var(--secondary-color);
  transform: translateY(-3px);
}

.social-icons i {
  font-size: 20px;
}

.footer-bottom {
  background-color: var(--footer-bottom-background);
  text-align: center;
  padding: 15px 0;
  margin-top: 30px; /* Increased from 20px for more vertical spacing */
}

.footer-bottom p {
  font-size: 14px;
  margin: 0;
}

/* Media Queries for Responsiveness */
@media (max-width: 992px) {
  .text-box h1 {
    font-size: 62px;
  }
  
  .section-title {
    font-size: 36px;
    width: 80%;
  }
  
  .footer-info {
    grid-column: span 1;
  }
  
  .accredited-col img {
    width: 250px;
  }
}

/* Fixed mid-size screen navigation */
@media (max-width: 1200px) and (min-width: 769px) {
  .nav-links ul {
    gap: 5px; /* Add gap between items */
  }
  
  .nav-links ul li {
    padding: 10px 8px; /* Reduced horizontal padding */
  }
  
  .nav-links ul li a {
    font-size: 14px; /* Slightly smaller font */
    padding: 10px 6px; /* Reduced horizontal padding */

  }
  
  .login-btn-container {
    margin-left: 10px; /* Add some space before the login button */
  }
  
  .nav-links button {
    padding: 6px 15px;
    font-size: 14px;
  }
}

@media (max-width: 992px) {
  .nav-links ul li a {
    font-size: 14px;
  }
}

/* Further optimization for smaller mid-size screens */
@media (max-width: 992px) and (min-width: 769px) {
  .nav-links ul li {
    padding: 10px 0px; /* Even smaller padding */
  }
  
  .nav-links ul li a {
    font-size: 12px; /* Even smaller font */
  }
}

@media (max-width: 992px) {
  .nav-links ul li a {
    font-size: 14px;
  }
}

@media (max-width: 768px) {
  /* Navbar Mobile Styling */
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
    box-shadow: -5px 0 15px rgba(0,0,0,0.3);
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
  }
  
  .login-btn-container {
    margin-top: 20px;
  }
  
  .menu-btn, .close-btn {
    display: block;
  }
  
  .close-btn {
    position: absolute;
    top: 15px;
    right: 20px;
    font-size: 28px;
    background: none;
    border: none;
    padding: 5px;
  }
  
  .menu-btn {
    position: relative;
    z-index: 999;
    padding: 5px;
  }
  
  /* Hero Section */
  .text-box h1 {
    font-size: 52px;
  }
  
  .text-box p {
    font-size: 14px;
  }
  
  /* Brighter Smiles Section */
  .section-title {
    font-size: 40px;
    width: 90%;
    white-space: normal; /* Allow wrapping on smaller screens */
  }
  
  .inline {
    flex-direction: column;
    text-align: center;
  }
  
  .teeth-container {
    margin-bottom: 20px;
  }
  
  /* Footer */
  .footer-container {
    grid-template-columns: repeat(2, 1fr);
  }
  
  .footer-info {
    grid-column: span 2;
  }
  
  .logo-container {
    justify-content: center;
  }
  
  .info-item {
    justify-content: center;
    text-align: center;
  }
  
  .footer-title {
    text-align: center;
  }
  
  .footer-links ul {
    text-align: center;
  }
  
  .footer-hours, .footer-payment {
    text-align: center;
  }
  
  .payment-icons {
    justify-content: center;
    margin: 0 auto;
    max-width: 200px;
  }
  
  .social-icons {
    justify-content: center;
  }
  
  /* Accredited HMO Section */
  .accredited-hmo {
    font-size: 30px;
  }
  
  .accredited-row {
    flex-direction: column;
  }

  .nav-links ul li a:hover::after {
    width: 100%;
  }
  
  .nav-links ul li {
    padding: 12px 0; /* Increase vertical padding in mobile menu */
    margin: 5px 0; /* Add more vertical spacing between items */
  }
}

@media (max-width: 576px) {
  nav img {
    width: 70px;
  }
  
  .text-box h1 {
    font-size: 42px;
  }
  
  .appointment-btn {
    padding: 10px 20px;
    font-size: 14px;
  }
  
  .section-title {
    font-size: 40px;
    padding-left: 20px;
    border-left-width: 5px;
  }
  
  .why-col, .what-col {
    min-width: 100%;
  }
  
  .accredited-hmo {
    font-size: 24px;
  }
  
  .accredited-col img {
    width: 200px;
  }
  
  .footer-container {
    grid-template-columns: 1fr;
  }
  
  .footer-info {
    grid-column: span 1;
  }
  
  .info-item {
    flex-direction: column;
    align-items: center;
    gap: 5px;
  }
  
  .info-item i {
    margin-bottom: 5px;
  }
  
  .gtp {
    width: 40px;
    height: 40px;
    bottom: 15px;
    right: 15px;
  }
}

@media (min-width: 1200px) {
  .footer-container {
    display: flex;
    flex-wrap: nowrap;
    justify-content: space-between;
    gap: 30px; /* Increased spacing between footer columns */
  }
  
  .footer-info {
    flex: 0 0 30%;
    grid-column: span 1;
  }
  
  .footer-col {
    flex: 0 0 15%;
    padding: 0 10px; /* Added padding for better spacing */
  }
}
</style>
