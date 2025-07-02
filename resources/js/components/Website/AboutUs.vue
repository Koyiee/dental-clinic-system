<template>
  <!-- Responsive Navbar - Updated to match Homepage -->
  <nav>
    <a href="/" class="logo-link"><img src="@/components/Images/ATDC_Logo.png" alt="Dental Clinic Logo"/></a>
    <div class="nav-links" :style="{ right: isMenuOpen ? '0' : '-250px' }">
      <i class="fa fa-times close-btn" @click="hideMenu"></i>
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
    <i class="fa fa-bars menu-btn" @click="showMenu"></i>
  </nav>

  <a href="#top" class="gtp" :class="{ 'show': showGoToTop }"><img src="@/components/Images/Go to top.png" alt="Go to top"></a>

  <!-- top-header -->
  <section class="top-header" id="top">
    <div class="text-box">
      <h1>WHERE THE <br>SMILES BEGIN</h1>
      <p>What started as a small practice has expanded over time into a reliable name in the community, helping generations of families. The journey of Aguila-Titular Dental Clinic is grounded in a committed to innovation and personalizes care, evolving with progress in dentistry while preserving the warmth and commitment of its modest humble beginnings.</p>
      <a href="#history" class="learn-more-btn"> <i class="fa fa-arrow-right"></i> &nbsp;<b>Learn More</b></a>
    </div>
  </section>

  <!-- history - FIXED SECTION -->
  <section class="next-line" id="history">
    <div class="history-container">
      <h1>HISTORY</h1>
      
      <div class="history-content">
        <div class="history-text">
          <p>Aguila-Titular Dental Clinic was founded in the year 1997 by a husband-and-wife, Jesus Archimedes V. Aguila and Marlyn T. Aguila, with a shared vision of providing compassionate and high-quality dental care to their community. They worked to build trust and create a welcoming environment for every patient. Through their commitment, the clinic steadily grew, earning a reputation for excellence.</p>
        </div>
        <div class="history-image">
          <img src="@/components/Images/History.png" alt="Clinic History">
        </div>
      </div>
      
      <div class="history-button">
        <a href="/services" class="see-more-btn"><i class="fa fa-arrow-right"></i> &nbsp;<b>See More</b></a>
      </div>
    </div>
  </section>

  <!-- Clinic Images Section -->
  <section class="next-line1">
    <div class="images-container">
      <div class="image-grid">
        <div class="picture-col">
          <img src="@/components/Images/ATDC_pic4.png" alt="Clinic Interior 1">
        </div>
        <div class="picture-col">
          <img src="@/components/Images/ATDC_pic5.png" alt="Clinic Interior 2">
        </div>
        <div class="picture-col">
          <img src="@/components/Images/ATDC_pic6.png" alt="Clinic Interior 3">
        </div>
      </div>
    </div>
  </section>

  <!-- Continuation Text Section -->
  <section class="next-line2">
    <div class="continuation-container">
      <div class="continuation-grid">
        <div class="two-col">
          <p>The clinic is now under the management of the founders' children, who have taken up the mantle of continuing their parents' tradition of excellence in dental care. With extensive knowledge in the advancements in dentistry and a commitment to patient well-being, Aguila-Titular Dental Clinic strive to uphold the high standards of care established by their predecessors.</p>
        </div>
        <div class="two-col">
          <p>Guided by their vision to preserve and enhance smiles for generations to come, they are still dedicated to maintaining a patient-centered approach. At Aguila-Titular Dental Clinic, every smile tells a story—of confidence restored and lives transformed—continuing a legacy built on excellence, compassion, and innovation.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- mission and vision -->
  <section class="next-line3">
    <div class="mission-vision-container">
      <h1>OUR MISSION AND VISION</h1>
      <div class="mission-vision-grid">
        <div class="mission-card">
          <div class="card-content">
            <h2>MISSION</h2>
            <p>To promote excellent dental health in society and to educate each patient about dental health. To provide quality service to each individual's need.</p>
          </div>
        </div>
        <div class="vision-card">
          <div class="card-content">
            <h2>VISION</h2>
            <p>To offer a complete range of oral care services of the highest quality in order to ensure lifelong dental health and a beautiful smile.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- meet our doctors -->
  <section class="next-line4">
    <div class="doctors-container">
      <h1>MEET OUR DOCTORS</h1>
      <div class="green-bg">
        <div class="doctors-grid">
          <div class="dr-col">
            <img src="@/components/Images/Dentist_1.png" alt="Dr. Marlyn Aguila">
            <h4>Dr. Marlyn Aguila</h4>
            <div class="doctor-info">
              <p>Qualifications:</p>
              <p>Specialization:</p>
              <p>Year of Experience:</p>
            </div>
            <a href="#marlyn-aguila" class="know-btn"> <i class="fa fa-plus"></i>&nbsp;Know more</a>
          </div>

          <div class="dr-col">
            <img src="@/components/Images/Dentist_1.png" alt="Dr. Archie Aguila">
            <h4>Dr.Archie Aguila</h4>
            <div class="doctor-info">
              <p>Qualifications:</p>
              <p>Specialization:</p>
              <p>Year of Experience:</p>
            </div>
            <a href="#archie-aguila" class="know-btn"> <i class="fa fa-plus"></i>&nbsp;Know more</a>
          </div>

          <div class="dr-col">
            <img src="@/components/Images/Dentist_1.png" alt="Dr. Joshua Aguila">
            <h4>Dr. Joshua Aguila</h4>
            <div class="doctor-info">
              <p>Qualifications:</p>
              <p>Specialization:</p>
              <p>Year of Experience:</p>
            </div>
            <a href="#joshua-aguila" class="know-btn"> <i class="fa fa-plus"></i>&nbsp;Know more</a>
          </div>

          <div class="dr-col">
            <img src="@/components/Images/Dentist_1.png" alt="Dr. Johara Aguila">
            <h4>Dr. Johara Aguila</h4>
            <div class="doctor-info">
              <p>Qualifications:</p>
              <p>Specialization:</p>
              <p>Year of Experience:</p>
            </div>
            <a href="#johara-aguila" class="know-btn"> <i class="fa fa-plus"></i>&nbsp;Know more</a>
          </div>

          <div class="dr-col">
            <img src="@/components/Images/Dentist_1.png" alt="Dr. Cassandra Fernandez">
            <h4>Dr. Cassandra Fernandez</h4>
            <div class="doctor-info">
              <p>Qualifications:</p>
              <p>Specialization:</p>
              <p>Year of Experience:</p>
            </div>
            <a href="#cass-fernandez" class="know-btn"> <i class="fa fa-plus"></i>&nbsp;Know more</a>
          </div>

          <div class="dr-col">
            <img src="@/components/Images/Dentist_1.png" alt="Dr. Emilyn Solarte">
            <h4>Dr. Emilyn Solarte</h4>
            <div class="doctor-info">
              <p>Qualifications:</p>
              <p>Specialization:</p>
              <p>Year of Experience:</p>
            </div>
            <a href="#emilyn-solarte" class="know-btn"> <i class="fa fa-plus"></i>&nbsp;Know more</a>
          </div>

          <div class="dr-col">
            <img src="@/components/Images/Dentist_1.png" alt="Dr. John Paul Gumogda">
            <h4>Dr. John Paul Gumogda</h4>
            <div class="doctor-info">
              <p>Qualifications:</p>
              <p>Specialization:</p>
              <p>Year of Experience:</p>
            </div>
            <a href="#paul-gumogda" class="know-btn"> <i class="fa fa-plus"></i>&nbsp;Know more</a>
          </div>

          <div class="dr-col">
            <img src="@/components/Images/Dentist_1.png" alt="Dr. Juan Dela Cruz">
            <h4>Dr. Juan Dela Cruz</h4>
            <div class="doctor-info">
              <p>Qualifications:</p>
              <p>Specialization:</p>
              <p>Year of Experience:</p>
            </div>
            <a href="#juan-delacruz" class="know-btn"> <i class="fa fa-plus"></i>&nbsp;Know more</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Doctor Profile Cards -->
  <section>
    <div id="marlyn-aguila" class="card">
      <div class="content">
        <div class="photo-container">
          <div class="photo-frame">
            <img src="@/components/Images/Rectangle_2.png" alt="Dr. Marlyn Aguila" class="photo">
          </div>
          <div class="doctor-name">Dr. Marlyn Aguila</div>
        </div>
        <div class="info">
          <p class="bio">
            Lorem ipsum dolor sit amet, consectetuer adipiscing elit. 
            Aenean commodo ligula eget dolor. Aenean massa. Cum 
            sociis natoque penatibus et magnis dis parturient 
            montes, nascetur ridiculus mus. Donec quam felis, 
            ultricies nec, pellentesque eu, pretium quis, sem. Nulla 
            consequat massa quis enim.
          </p>
          <h2 class="education-title">EDUCATION</h2>
          <ul class="education-list">
            <li>Lorem ipsum dolor sit amet - aenean massa</li>
            <li>Lorem ipsum dolor sit amet - aenean massa</li>
            <li>Lorem ipsum dolor sit amet - aenean massa</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div id="archie-aguila" class="profile-wrapper">
      <div class="profile-card">
        <div class="profile-layout">
          <div class="doctor-image-section">
            <div class="image-container">
              <img src="@/components/Images/Rectangle_2.png" alt="Dr. Archie Aguila" class="photo">
            </div>
            <div class="doctor-title">Dr. Archie Aguila</div>
          </div>
          <div class="doctor-details">
            <p class="doctor-biography">
              Lorem ipsum dolor sit amet, consectetuer adipiscing elit. 
              Aenean commodo ligula eget dolor. Aenean massa. Cum 
              sociis natoque penatibus et magnis dis parturient 
              montes, nascetur ridiculus mus. Donec quam felis, 
              ultricies nec, pellentesque eu, pretium quis, sem. Nulla 
              consequat massa quis enim.
            </p>
            <h2 class="education-header">EDUCATION</h2>
            <ul class="education-items">
              <li class="education-entry">Lorem ipsum dolor sit amet - aenean massa</li>
              <li class="education-entry">Lorem ipsum dolor sit amet - aenean massa</li>
              <li class="education-entry">Lorem ipsum dolor sit amet - aenean massa</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

    <section>
    <div id="joshua-aguila" class="card">
      <div class="content">
        <div class="photo-container">
          <div class="photo-frame">
            <img src="@/components/Images/Rectangle_2.png" alt="Dr. Joshua Aguila" class="photo">
          </div>
          <div class="doctor-name">Dr. Joshua Aguila</div>
        </div>
        <div class="info">
          <p class="bio">
            Lorem ipsum dolor sit amet, consectetuer adipiscing elit. 
            Aenean commodo ligula eget dolor. Aenean massa. Cum 
            sociis natoque penatibus et magnis dis parturient 
            montes, nascetur ridiculus mus. Donec quam felis, 
            ultricies nec, pellentesque eu, pretium quis, sem. Nulla 
            consequat massa quis enim.
          </p>
          <h2 class="education-title">EDUCATION</h2>
          <ul class="education-list">
            <li>Lorem ipsum dolor sit amet - aenean massa</li>
            <li>Lorem ipsum dolor sit amet - aenean massa</li>
            <li>Lorem ipsum dolor sit amet - aenean massa</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div id="johara-aguila" class="profile-wrapper">
      <div class="profile-card">
        <div class="profile-layout">
          <div class="doctor-image-section">
            <div class="image-container">
              <img src="@/components/Images/Rectangle_2.png" alt="Dr. Johara Aguila" class="photo">
            </div>
            <div class="doctor-title">Dr. Johara Aguila</div>
          </div>
          <div class="doctor-details">
            <p class="doctor-biography">
              Lorem ipsum dolor sit amet, consectetuer adipiscing elit. 
              Aenean commodo ligula eget dolor. Aenean massa. Cum 
              sociis natoque penatibus et magnis dis parturient 
              montes, nascetur ridiculus mus. Donec quam felis, 
              ultricies nec, pellentesque eu, pretium quis, sem. Nulla 
              consequat massa quis enim.
            </p>
            <h2 class="education-header">EDUCATION</h2>
            <ul class="education-items">
              <li class="education-entry">Lorem ipsum dolor sit amet - aenean massa</li>
              <li class="education-entry">Lorem ipsum dolor sit amet - aenean massa</li>
              <li class="education-entry">Lorem ipsum dolor sit amet - aenean massa</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

    <section>
    <div id="cass-fernandez" class="card">
      <div class="content">
        <div class="photo-container">
          <div class="photo-frame">
            <img src="@/components/Images/Rectangle_2.png" alt="Dr. Cassandra Fernandez" class="photo">
          </div>
          <div class="doctor-name">Dr. Cassandra Fernandez</div>
        </div>
        <div class="info">
          <p class="bio">
            Lorem ipsum dolor sit amet, consectetuer adipiscing elit. 
            Aenean commodo ligula eget dolor. Aenean massa. Cum 
            sociis natoque penatibus et magnis dis parturient 
            montes, nascetur ridiculus mus. Donec quam felis, 
            ultricies nec, pellentesque eu, pretium quis, sem. Nulla 
            consequat massa quis enim.
          </p>
          <h2 class="education-title">EDUCATION</h2>
          <ul class="education-list">
            <li>Lorem ipsum dolor sit amet - aenean massa</li>
            <li>Lorem ipsum dolor sit amet - aenean massa</li>
            <li>Lorem ipsum dolor sit amet - aenean massa</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div id="emilyn-solarte" class="profile-wrapper">
      <div class="profile-card">
        <div class="profile-layout">
          <div class="doctor-image-section">
            <div class="image-container">
              <img src="@/components/Images/Rectangle_2.png" alt="Dr. Emilyn Solarte" class="photo">
            </div>
            <div class="doctor-title">Dr. Emilyn Solarte</div>
          </div>
          <div class="doctor-details">
            <p class="doctor-biography">
              Lorem ipsum dolor sit amet, consectetuer adipiscing elit. 
              Aenean commodo ligula eget dolor. Aenean massa. Cum 
              sociis natoque penatibus et magnis dis parturient 
              montes, nascetur ridiculus mus. Donec quam felis, 
              ultricies nec, pellentesque eu, pretium quis, sem. Nulla 
              consequat massa quis enim.
            </p>
            <h2 class="education-header">EDUCATION</h2>
            <ul class="education-items">
              <li class="education-entry">Lorem ipsum dolor sit amet - aenean massa</li>
              <li class="education-entry">Lorem ipsum dolor sit amet - aenean massa</li>
              <li class="education-entry">Lorem ipsum dolor sit amet - aenean massa</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

    <section>
    <div id="paul-gumogda" class="card">
      <div class="content">
        <div class="photo-container">
          <div class="photo-frame">
            <img src="@/components/Images/Rectangle_2.png" alt="Dr. John Paul Gumogda" class="photo">
          </div>
          <div class="doctor-name">Dr. John Paul Gumogda</div>
        </div>
        <div class="info">
          <p class="bio">
            Lorem ipsum dolor sit amet, consectetuer adipiscing elit. 
            Aenean commodo ligula eget dolor. Aenean massa. Cum 
            sociis natoque penatibus et magnis dis parturient 
            montes, nascetur ridiculus mus. Donec quam felis, 
            ultricies nec, pellentesque eu, pretium quis, sem. Nulla 
            consequat massa quis enim.
          </p>
          <h2 class="education-title">EDUCATION</h2>
          <ul class="education-list">
            <li>Lorem ipsum dolor sit amet - aenean massa</li>
            <li>Lorem ipsum dolor sit amet - aenean massa</li>
            <li>Lorem ipsum dolor sit amet - aenean massa</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div id="juan-delacruz" class="profile-wrapper">
      <div class="profile-card">
        <div class="profile-layout">
          <div class="doctor-image-section">
            <div class="image-container">
              <img src="@/components/Images/Rectangle_2.png" alt="Dr. Juan Dela Cruz" class="photo">
            </div>
            <div class="doctor-title">Dr. Juan Dela Cruz</div>
          </div>
          <div class="doctor-details">
            <p class="doctor-biography">
              Lorem ipsum dolor sit amet, consectetuer adipiscing elit. 
              Aenean commodo ligula eget dolor. Aenean massa. Cum 
              sociis natoque penatibus et magnis dis parturient 
              montes, nascetur ridiculus mus. Donec quam felis, 
              ultricies nec, pellentesque eu, pretium quis, sem. Nulla 
              consequat massa quis enim.
            </p>
            <h2 class="education-header">EDUCATION</h2>
            <ul class="education-items">
              <li class="education-entry">Lorem ipsum dolor sit amet - aenean massa</li>
              <li class="education-entry">Lorem ipsum dolor sit amet - aenean massa</li>
              <li class="education-entry">Lorem ipsum dolor sit amet - aenean massa</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- our clinic -->
  <section class="our-clinic">
    <div class="clinic-container">
      <h1 class="clinic-title">OUR CLINIC</h1>
      
      <div class="link-row">
        <a href="#facility-section" class="clinic-link">Facility</a>
        <a href="#reception-section" class="clinic-link">Reception</a>
        <a href="#xray-section" class="clinic-link">X-ray Room</a>
      </div>

      <div id="facility-section" class="facility-section">
        <div class="facility-title">FACILITY</div>
        <div class="facility-content">
          <div class="facility-col">
            <div class="facility-box">
              <img src="@/components/Images/Rectangle_1.png" alt="Facility 1">
            </div>
            <p class="facility-label">Lorem Ipsum</p>
          </div>
          <div class="facility-col">
            <div class="facility-box">
              <img src="@/components/Images/Rectangle_1.png" alt="Facility 2">
            </div>
            <p class="facility-label">Lorem Ipsum</p>
          </div>
          <div class="facility-col">
            <div class="facility-box">
              <img src="@/components/Images/Rectangle_1.png" alt="Facility 3">
            </div>
            <p class="facility-label">Lorem Ipsum</p>
          </div>
        </div>
      </div>

      <div id="reception-section" class="reception-section">
        <div class="reception-title">RECEPTION</div>
        <div class="reception-content">
          <div class="reception-col">
            <div class="reception-box">
              <img src="@/components/Images/Rectangle_1.png" alt="Reception 1">
            </div>
            <p class="reception-label">Lorem Ipsum</p>
          </div>
          <div class="reception-col">
            <div class="reception-box">
              <img src="@/components/Images/Rectangle_1.png" alt="Reception 2">
            </div>
            <p class="reception-label">Lorem Ipsum</p>
          </div>
          <div class="reception-col">
            <div class="reception-box">
              <img src="@/components/Images/Rectangle_1.png" alt="Reception 3">
            </div>
            <p class="reception-label">Lorem Ipsum</p>
          </div>
        </div>
      </div>

      <div id="xray-section" class="xray-section">
        <div class="xray-title">X-RAY ROOM</div>
        <div class="xray-content">
          <div class="xray-col">
            <div class="xray-box">
              <img src="@/components/Images/Rectangle_1.png" alt="X-ray Room 1">
            </div>
            <p class="xray-label">Lorem Ipsum</p>
          </div>
          <div class="xray-col">
            <div class="xray-box">
              <img src="@/components/Images/Rectangle_1.png" alt="X-ray Room 2">
            </div>
            <p class="xray-label">Lorem Ipsum</p>
          </div>
          <div class="xray-col">
            <div class="xray-box">
              <img src="@/components/Images/Rectangle_1.png" alt="X-ray Room 3">
            </div>
            <p class="xray-label">Lorem Ipsum</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Visit Us Section -->
  <section class="visit-us-section">
    <h1 class="clinic-title">VISIT US</h1>
    <div class="location-section">
      <div class="map-container">
        <iframe 
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3860.5468520524573!2d121.12051897510665!3d14.624871085864354!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397b856689952e7%3A0xb9dc691e763db062!2sAguila-Titular%20Dental%20Clinic!5e0!3m2!1sen!2sph!4v1741963443206!5m2!1sen!2sph" 
          width="600" 
          height="450" 
          style="border:0;" 
          allowfullscreen="" 
          loading="lazy" 
          referrerpolicy="no-referrer-when-downgrade">
        </iframe>
      </div>
      <div class="contact-info">
        <h2 class="section-title">LOCATION</h2>
        <p class="address">203-205 J&F Building 1, Marcos Highway, Barangay Mayamot, Antipolo, Philippines</p>
        
        <h2 class="section-title">GET IN TOUCH WITH US</h2>
        <div class="social-section">
          <a href="https://www.facebook.com/aguilatitulardental" class="social-link" target="_blank">• Facebook - Aguila-Titular Dental Clinic</a>
          <a href="https://www.instagram.com/aguilatitulardent/" class="social-link" target="_blank">• Instagram - @aguilatitulardent</a>
        </div>
      </div>
    </div>
  </section>

  <!-- Responsive Footer - Updated to match Homepage -->
  <section class="footer-section">
    <div class="footer-clean">
      <footer>
        <div class="footer-container">
          <!-- Logo & Clinic Info -->
          <div class="footer-col footer-info">
            <div class="logo-container">
              <img src="@/components/Images/ATDC_Logo.png" alt="Aguila-Titular Dental Clinic Logo" class="footer-logo">
              <img src="@/components/Images/ATDC_Logo3.png" alt="Aguila-Titular Dental Clinic Logo" class="footer-logo-text">
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
  name: "AboutUs",
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

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}
</style>

<style scoped>
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
  from { transform: scale(1); }
  to { transform: scale(1.2); }
}

/* Responsive Navbar - Updated to match Homepage */
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
  margin: 0;
  padding: 0;
}

.nav-links ul li {
  display: inline-block;
  padding: 10px 14px;
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

.login-btn-container a::after {
  display: none !important;
}

.login-btn-container a {
  text-decoration: none !important;
}

.login-btn-container a:hover {
  text-decoration: none !important;
}

.nav-links ul li a:hover::after {
  width: 100%;
}

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
  font-family: 'Poppins', sans-serif;
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
  background-image: linear-gradient(rgba(4,9,30,0.3), rgba(4,9,30,0.3)), url(@/components/Images/ATDC-sample.jpg);
  background-position: center;
  background-size: cover;
  position: relative;
  display: flex;
  align-items: center;
}

.text-box {
  width: 90%;
  color: white;
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

.learn-more-btn {
  display: inline-block;
  text-decoration: none;
  color: white;
  border: 1px solid white;
  padding: 12px 34px;
  font-size: 16px;
  background: transparent;
  position: relative;
  cursor: pointer;
  transition: all 0.3s ease;
}

.learn-more-btn:hover {
  border: 1px solid var(--secondary-color);
  background: var(--secondary-color);
}

/* History Section */
.next-line {
  width: 100%;
  background-color: var(--primary-color);
  padding: 80px 0;
}

.history-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
}

.history-container h1 {
  font-size: 45px;
  font-weight: 600;
  color: white;
  text-align: center;
  margin-bottom: 50px;
}

.history-content {
  display: flex;
  align-items: center;
  gap: 40px;
  margin-bottom: 40px;
}

.history-text {
  flex: 2;
}

.history-text p {
  font-size: 16px;
  color: white;
  line-height: 1.6;
  text-align: justify;
}

.history-image {
  flex: 1;
  display: flex;
  justify-content: center;
}

.history-image img {
  max-width: 100%;
  height: auto;
  border-radius: 10px;
}

.history-button {
  text-align: left;
}

.see-more-btn {
  display: inline-block;
  text-decoration: none;
  color: white;
  border: 1px solid white;
  padding: 12px 34px;
  font-size: 16px;
  background: transparent;
  position: relative;
  cursor: pointer;
  transition: all 0.3s ease;
}

.see-more-btn:hover {
  border: 1px solid var(--secondary-color);
  background: var(--secondary-color);
}

/* Clinic Images Section */
.next-line1 {
  width: 100%;
  background-color: var(--primary-color);
  padding: 40px 0;
}

.images-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
}

.image-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 30px;
}

.picture-col img {
  width: 100%;
  height: auto;
  border-radius: 10px;
  transition: transform 0.3s ease;
}

.picture-col img:hover {
  transform: scale(1.05);
}

/* Continuation Text Section */
.next-line2 {
  width: 100%;
  background-color: var(--primary-color);
  padding: 40px 0 80px;
}

.continuation-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
}

.continuation-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
  gap: 40px;
}

.two-col p {
  font-size: 16px;
  color: white;
  line-height: 1.6;
  text-align: justify;
}

/* Mission and Vision Section */
.next-line3 {
  width: 100%;
  padding: 80px 0;
}

.mission-vision-container {
  max-width: 1000px;
  margin: 0 auto;
  padding: 0 20px;
  text-align: center;
}

.mission-vision-container h1 {
  font-size: 45px;
  font-weight: 600;
  margin-bottom: 50px;
}

.mission-vision-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
  gap: 40px;
}

.mission-card, .vision-card {
  border-radius: 10px;
  box-shadow: 0px 10px 20px rgba(136, 136, 136, 0.5);
  overflow: hidden;
}

.mission-card {
  background: var(--primary-color);
  color: white;
}

.vision-card {
  background: white;
  color: var(--text-color);
}

.card-content {
  padding: 40px;
}

.card-content h2 {
  font-size: 24px;
  margin-bottom: 20px;
}

.card-content p {
  font-size: 16px;
  line-height: 1.6;
  text-align: justify;
}

/* Meet Our Doctors Section */
.next-line4 {
  width: 100%;
  padding: 80px 0;
}

.doctors-container {
  width: 100%;
  margin: 0;
  padding: 0;
  text-align: center;
}

.doctors-container h1 {
  font-size: 45px;
  font-weight: 600;
  margin-bottom: 50px;
  padding: 0 20px;
}

.green-bg {
  background-color: var(--primary-color);
  border-radius: 0;
  padding: 40px 0;
  width: 100%;
}

.doctors-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 0;
  width: 100%;
}

.dr-col {
  padding: 30px 20px;
  border-right: 1px solid white;
  transition: transform 0.3s ease;
  position: relative;
}

.dr-col:nth-child(4n) {
  border-right: none;
}

.dr-col:hover {
  transform: translateY(-5px);
}

.dr-col img {
  width: 60%;
  max-width: 150px;
  height: auto;
  border-radius: 50%;
  margin-bottom: 20px;
}

.dr-col h4 {
  color: white;
  font-size: 20px;
  margin-bottom: 15px;
}

.doctor-info p {
  font-size: 14px;
  color: white;
  margin: 8px 0;
  text-align: left;
  margin-left: 20px;
}

.know-btn {
  display: inline-block;
  text-decoration: none;
  color: white;
  padding: 12px 30px;
  font-size: 14px;
  background: var(--secondary-color);
  border-radius: 10px;
  margin-top: 20px;
  transition: all 0.3s ease;
  width: 80%;
  max-width: 200px;
}

.know-btn:hover {
  background: #2a9d32;
  box-shadow: 0 5px 15px rgba(0,0,0,0.2);
  transform: translateY(-2px);
}

/* Doctor Profile Cards */
.card {
  width: 70%;
  max-width: none;
  background-color: #006837;
  color: white;
  border-radius: 0 100px 100px 0;
  display: flex;
  flex-direction: column;
  padding: 40px;
  margin: 30px 0;
  overflow: hidden;
}

.content {
  display: flex;
  flex-direction: row;
  gap: 40px;
  align-items: flex-start;
}

.photo-container {
  flex-shrink: 0;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.photo-frame {
  width: 250px;
  height: 250px;
  background-color: white;
  padding: 10px;
  border-radius: 8px;
  margin-bottom: 15px;
}

.photo {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.doctor-name {
  font-size: 22px;
  font-weight: bold;
  margin-top: 10px;
  text-align: center;
}

.info {
  flex-grow: 1;
  max-width: 600px;
}

.bio {
  line-height: 1.6;
  margin-bottom: 30px;
  font-size: 16px;
}

.education-title {
  font-weight: bold;
  margin-bottom: 20px;
  font-size: 20px;
}

.education-list {
  list-style-type: disc;
  padding-left: 20px;
}

.education-list li {
  margin-bottom: 12px;
  font-size: 16px;
}

.profile-wrapper {
  width: 100%;
  display: flex;
  justify-content: flex-end;
  margin-top: 30px;
}

.profile-card {
  width: 70%;
  max-width: none;
  background-color: #006837;
  color: white;
  border-radius: 100px 0 0 100px;
  padding: 40px 20px 40px 40px;
  overflow: hidden;
}

.profile-layout {
  display: flex;
  flex-direction: row-reverse;
  gap: 40px;
  align-items: flex-start;
}

.doctor-image-section {
  flex-shrink: 0;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.image-container {
  width: 250px;
  height: 250px;
  background-color: white;
  padding: 10px;
  border-radius: 8px;
  margin-bottom: 15px;
}

.doctor-title {
  font-size: 22px;
  font-weight: bold;
  margin-top: 10px;
  text-align: center;
}

.doctor-details {
  flex-grow: 1;
  max-width: none;
  text-align: left;
  padding-right: 0;
  width: 100%;
}

.doctor-biography {
  line-height: 1.6;
  margin-bottom: 30px;
  font-size: 16px;
}

.education-header {
  font-weight: bold;
  margin-bottom: 20px;
  font-size: 20px;
}

.education-items {
  list-style-type: disc;
  padding-left: 20px;
}

.education-entry {
  margin-bottom: 12px;
  font-size: 16px;
}

/* Our Clinic Section */
.our-clinic {
  padding: 80px 0;
}

.clinic-container {
  width: 100%;
  margin: 0;
  padding: 0;
  text-align: center;
}

.clinic-title {
  font-size: 45px;
  font-weight: bold;
  color: #000;
  margin-bottom: 50px;
  padding: 0 20px;
}

.link-row {
  display: flex;
  justify-content: center;
  gap: 20px;
  margin-bottom: 70px;
  flex-wrap: wrap;
}

.clinic-link {
  text-decoration: none;
  padding: 20px 40px;
  font-size: 18px;
  font-weight: bold;
  border-radius: 8px;
  color: white;
  background: #5DBB63;
  transition: all 0.3s ease;
}

.clinic-link:hover {
  background-color: var(--primary-color);
  transform: translateY(-3px);
}

.facility-section, .reception-section, .xray-section {
  margin-bottom: 80px;
  width: 100%;
  text-align: left;
}

.facility-title, .reception-title, .xray-title {
  background: #0B6835;
  color: white;
  font-weight: bold;
  font-size: 24px;
  padding: 20px 40px;
  border-radius: 0 25px 25px 0;
  display: inline-block;
  margin-bottom: 40px;
  margin-left: 0;
  position: relative;
  left: 0;
  text-align: left;
}

.facility-content, .reception-content, .xray-content {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 30px;
  max-width: 1000px;
  margin: 0 auto;
}

.facility-col, .reception-col, .xray-col {
  text-align: center;
}

.facility-box img, .reception-box img, .xray-box img {
  width: 100%;
  max-width: 350px;
  height: auto;
  border-radius: 10px;
  transition: transform 0.3s ease;
}

.facility-box img:hover, .reception-box img:hover, .xray-box img:hover {
  transform: scale(1.05);
}

.facility-label, .reception-label, .xray-label {
  font-size: 16px;
  font-weight: bold;
  margin-top: 15px;
}

/* Visit Us Section */
.visit-us-section {
  padding: 80px 0;
  text-align: center;
}

.visit-us-section .clinic-title {
  margin-bottom: 50px;
  padding: 0 20px;
}

.location-section {
  display: flex;
  width: 100%;
  max-width: none;
  margin: 0;
  border-radius: 0;
  overflow: hidden;
  box-shadow: 0 10px 30px rgba(0,0,0,0.1);
  min-height: 500px;
}

.map-container {
  flex: 1;
  min-height: 500px;
  width: 50%;
}

.map-container iframe {
  width: 100%;
  height: 100%;
  min-height: 500px;
  border: none;
}

.contact-info {
  flex: 1;
  background-color: var(--primary-color);
  color: white;
  padding: 40px;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.section-title {
  font-size: 24px;
  font-weight: bold;
  margin-bottom: 20px;
}

.address {
  font-size: 16px;
  line-height: 1.6;
  margin-bottom: 40px;
}

.social-section {
  margin-top: 20px;
}

.social-link {
  color: white;
  text-decoration: none;
  display: block;
  margin-bottom: 15px;
  font-size: 16px;
  transition: color 0.3s ease;
}

.social-link:hover {
  color: #ccc;
}

/* Footer - Updated to match Homepage */
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
  gap: 20px;
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
  margin: 8px 0;
  line-height: 1.5;
}

.footer-payment p {
  font-size: 14px;
  margin-bottom: 20px;
}

.payment-icons {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 15px;
}

.payment-icons img {
  width: 50px;
  height: 30px;
  object-fit: contain;
}

.social-icons {
  display: flex;
  gap: 20px;
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
  margin-top: 30px;
}

.footer-bottom p {
  font-size: 14px;
  margin: 0;
}

/* Responsive Design */
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
  .history-content {
    flex-direction: column; 
    text-align: center;
  }
  
  .history-image {
    order: -1;
    margin-bottom: 30px;
  }
  
  .continuation-grid {
    grid-template-columns: 1fr;
  }
  
  .mission-vision-grid {
    grid-template-columns: 1fr;
  }
  
  .card {
    padding: 30px;
    border-radius: 0 60px 60px 0;
  }
  
  .content {
    gap: 30px;
  }
  
  .photo-frame {
    width: 200px;
    height: 200px;
  }
  
  .profile-card {
    padding: 30px 15px 30px 30px;
    border-radius: 60px 0 0 60px;
  }
  
  .profile-layout {
    gap: 30px;
  }
  
  .image-container {
    width: 200px;
    height: 200px;
  }
  
  .footer-info {
    grid-column: span 1;
  }
}

@media (max-width: 992px) {
  .nav-links ul li a {
    font-size: 14px;
  }
}

@media (max-width: 768px) {
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
    padding: 12px 0;
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

  .text-box h1 {
    font-size: 42px;
  }
  
  .text-box p {
    font-size: 14px;
  }

  .history-container h1 {
    font-size: 36px;
  }
  
  .history-button {
    text-align: center;
  }

  .image-grid {
    grid-template-columns: 1fr;
    gap: 20px;
  }

  .mission-vision-container h1 {
    font-size: 36px;
  }

  .doctors-container h1 {
    font-size: 36px;
  }
  
  .doctors-grid {
    grid-template-columns: repeat(2, 1fr);
    gap: 0;
  }
  
  .dr-col {
    border-right: 1px solid white;
    border-bottom: 1px solid white;
    padding-bottom: 30px;
  }
  
  .dr-col:nth-child(2n) {
    border-right: none;
  }
  
  .dr-col:nth-child(n+7) {
    border-bottom: none;
  }

  .card, .profile-card {
    width: 95%;
    margin: 20px auto;
    padding: 25px 20px;
  }

  .content {
    flex-direction: column;
    gap: 20px;
    align-items: center;
    text-align: center;
  }

  .photo-container {
    order: -1;
    width: 100%;
  }

  .photo-frame {
    width: 180px;
    height: 180px;
    margin: 0 auto 15px;
  }

  .doctor-name {
    font-size: 20px;
    margin-top: 10px;
  }

  .info {
    max-width: 100%;
    text-align: left;
  }

  .bio {
    font-size: 15px;
    margin-bottom: 25px;
  }

  .education-title {
    font-size: 18px;
    margin-bottom: 15px;
  }

  .education-list li {
    font-size: 15px;
    margin-bottom: 10px;
  }

  .profile-wrapper {
    justify-content: flex-start;
  }

  .profile-card {
    border-radius: 30px 0 0 30px;
    padding: 25px 20px;
  }

  .profile-layout {
    flex-direction: column;
    gap: 20px;
    align-items: center;
    text-align: center;
  }

  .doctor-image-section {
    order: -1;
    width: 100%;
  }

  .image-container {
    width: 180px;
    height: 180px;
    margin: 0 auto 15px;
  }

  .doctor-title {
    font-size: 20px;
    margin-top: 10px;
  }

  .doctor-details {
    max-width: 100%;
    text-align: left;
  }

  .doctor-biography {
    font-size: 15px;
    margin-bottom: 25px;
  }

  .education-header {
    font-size: 18px;
    margin-bottom: 15px;
  }

  .education-entry {
    font-size: 15px;
    margin-bottom: 10px;
  }

  .facility-title, .reception-title, .xray-title {
    padding: 15px 40px;
    border-radius: 0 25px 25px 0;
    font-size: 20px;
  }

  .location-section {
    flex-direction: column;
    min-height: auto;
  }

  .map-container {
    min-height: 350px;
    width: 100%;
    order: 1;
  }

  .contact-info {
    order: 2;
    min-height: 300px;
  }

  .footer-container {
    grid-template-columns: repeat(2, 1fr);
    gap: 30px;
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
}

@media (max-width: 576px) {
  nav img {
    width: 70px;
  }
  
  .text-box h1 {
    font-size: 32px;
  }
  
  .history-container h1,
  .mission-vision-container h1,
  .doctors-container h1,
  .clinic-title {
    font-size: 28px;
  }
  
  .doctors-grid {
    grid-template-columns: 1fr;
  }
  
  .dr-col {
    border-right: none;
    border-bottom: 1px solid white;
  }
  
  .dr-col:last-child {
    border-bottom: none;
  }

  .card, .profile-card {
    width: 100%;
    margin: 15px 0;
    padding: 20px 15px;
  }

  .photo-frame, .image-container {
    width: 150px;
    height: 150px;
  }

  .doctor-name, .doctor-title {
    font-size: 18px;
  }

  .bio, .doctor-biography {
    font-size: 14px;
  }

  .education-title, .education-header {
    font-size: 16px;
  }

  .education-list li, .education-entry {
    font-size: 14px;
  }
  
  .facility-content, .reception-content, .xray-content {
    grid-template-columns: 1fr;
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
  
  .gtp {
    width: 40px;
    height: 40px;
    bottom: 15px;
    right: 15px;
  }

  .map-container {
    min-height: 300px;
  }

  .facility-title, .reception-title, .xray-title {
    padding: 12px 30px;
    border-radius: 0 20px 20px 0;
    font-size: 18px;
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
  }
  
  .footer-col {
    flex: 0 0 15%;
    padding: 0 10px;
  }
}
</style>
