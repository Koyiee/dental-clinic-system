<template>
  <!-- Responsive Navbar -->
  <nav>
    <a href="/" class="logo-link"><img src="../Images/ATDC_logo.png" alt="Dental Clinic Logo"/></a>
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

  <a href="#top" class="gtp" :class="{ 'show': showGoToTop }"><img src="../Images/Go to top.png" alt="Go to top"></a>

  <!-- Full-width edge-to-edge top-header section -->
  <section class="top-header" id="top">
    <div class="header-content">
      <h1>SMILE GALLERY</h1>
      
      <div class="services-navigation">
        <div class="nav-buttons">
          <a href="#general-dentistry" class="nav-button">
            <span>General Dentistry</span>
          </a>
          <a href="#periodontics" class="nav-button">
            <span>Periodontics</span>
          </a>
          <a href="#prosthodontics" class="nav-button">
            <span>Prosthodontics</span>
          </a>
          <a href="#cosmetic-dentistry" class="nav-button">
            <span>Cosmetic Dentistry</span>
          </a>
          <a href="#orthodontics" class="nav-button">
            <span>Orthodontics</span>
          </a>
          <a href="#endodontics" class="nav-button">
            <span>Endodontics</span>
          </a>
          <a href="#oral-surgery" class="nav-button">
            <span>Maxillofacial Surgery</span>
          </a>
        </div>
      </div>
      
      <div class="hero-content">
        <h2>SEE THE DIFFERENCE IN EVERY SMILE</h2>
        <p>Take a look at our Smile Gallery, where we proudly showcase the transformative results of our dental services at Aguila-Titular Dental Clinic. Here, you'll find before-and-after images of our patients, highlighting the incredible difference that our expert care and attention can make for a healthier, more confident smile.</p>
      </div>
    </div>
  </section>

  <!-- Redesigned service sections -->
  <div class="service-sections">
    <!-- General Dentistry Section -->
    <section class="service-section" id="general-dentistry">
      <div class="service-header">
        <h2>GENERAL DENTISTRY</h2>
      </div>
      <div class="service-content">
        <div class="procedures-grid">
          <div class="procedure-card">
            <div class="before-after-container">
              <div class="before-after-wrapper">
                <div class="before-image" :style="{ clipPath: `inset(0 ${100 - generalSlider1}% 0 0)` }">
                  <div class="label">Before</div>
                  <img src="../Images/ATDC_pic1.png" alt="Before Image">
                </div>
                <div class="after-image">
                  <div class="label">After</div>
                  <img src="../Images/ATDC_pic2.png" alt="After Image">
                </div>
                <input type="range" class="slider" min="0" max="100" v-model="generalSlider1">
                <div class="slider-divider" :style="{ left: generalSlider1 + '%' }">
                  <div class="slider-handle"></div>
                </div>
              </div>
              <div class="procedure-title">Oral Prophylaxis</div>
            </div>
          </div>
          
          <div class="procedure-card">
            <div class="before-after-container">
              <div class="before-after-wrapper">
                <div class="before-image" :style="{ clipPath: `inset(0 ${100 - generalSlider2}% 0 0)` }">
                  <div class="label">Before</div>
                  <img src="../Images/ATDC_pic1.png" alt="Before Image">
                </div>
                <div class="after-image">
                  <div class="label">After</div>
                  <img src="../Images/ATDC_pic2.png" alt="After Image">
                </div>
                <input type="range" class="slider" min="0" max="100" v-model="generalSlider2">
                <div class="slider-divider" :style="{ left: generalSlider2 + '%' }">
                  <div class="slider-handle"></div>
                </div>
              </div>
              <div class="procedure-title">Dental Filling</div>
            </div>
          </div>
          
          <div class="procedure-card">
            <div class="before-after-container">
              <div class="before-after-wrapper">
                <div class="before-image" :style="{ clipPath: `inset(0 ${100 - generalSlider3}% 0 0)` }">
                  <div class="label">Before</div>
                  <img src="../Images/ATDC_pic1.png" alt="Before Image">
                </div>
                <div class="after-image">
                  <div class="label">After</div>
                  <img src="../Images/ATDC_pic2.png" alt="After Image">
                </div>
                <input type="range" class="slider" min="0" max="100" v-model="generalSlider3">
                <div class="slider-divider" :style="{ left: generalSlider3 + '%' }">
                  <div class="slider-handle"></div>
                </div>
              </div>
              <div class="procedure-title">Tooth Extraction</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Periodontics Section -->
    <section class="service-section" id="periodontics">
      <div class="service-header">
        <h2>PERIODONTICS</h2>
      </div>
      <div class="service-content">
        <div class="procedures-grid">
          <div class="procedure-card">
            <div class="before-after-container">
              <div class="before-after-wrapper">
                <div class="before-image" :style="{ clipPath: `inset(0 ${100 - perioSlider1}% 0 0)` }">
                  <div class="label">Before</div>
                  <img src="../Images/ATDC_pic1.png" alt="Before Image">
                </div>
                <div class="after-image">
                  <div class="label">After</div>
                  <img src="../Images/ATDC_pic2.png" alt="After Image">
                </div>
                <input type="range" class="slider" min="0" max="100" v-model="perioSlider1">
                <div class="slider-divider" :style="{ left: perioSlider1 + '%' }">
                  <div class="slider-handle"></div>
                </div>
              </div>
              <div class="procedure-title">Scaling and Root Planing</div>
            </div>
          </div>
          
          <div class="procedure-card">
            <div class="before-after-container">
              <div class="before-after-wrapper">
                <div class="before-image" :style="{ clipPath: `inset(0 ${100 - perioSlider2}% 0 0)` }">
                  <div class="label">Before</div>
                  <img src="../Images/ATDC_pic1.png" alt="Before Image">
                </div>
                <div class="after-image">
                  <div class="label">After</div>
                  <img src="../Images/ATDC_pic2.png" alt="After Image">
                </div>
                <input type="range" class="slider" min="0" max="100" v-model="perioSlider2">
                <div class="slider-divider" :style="{ left: perioSlider2 + '%' }">
                  <div class="slider-handle"></div>
                </div>
              </div>
              <div class="procedure-title">Gum Grafting</div>
            </div>
          </div>
          
          <div class="procedure-card">
            <div class="before-after-container">
              <div class="before-after-wrapper">
                <div class="before-image" :style="{ clipPath: `inset(0 ${100 - perioSlider3}% 0 0)` }">
                  <div class="label">Before</div>
                  <img src="../Images/ATDC_pic1.png" alt="Before Image">
                </div>
                <div class="after-image">
                  <div class="label">After</div>
                  <img src="../Images/ATDC_pic2.png" alt="After Image">
                </div>
                <input type="range" class="slider" min="0" max="100" v-model="perioSlider3">
                <div class="slider-divider" :style="{ left: perioSlider3 + '%' }">
                  <div class="slider-handle"></div>
                </div>
              </div>
              <div class="procedure-title">Periodontal Surgery</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Prosthodontics Section -->
    <section class="service-section" id="prosthodontics">
      <div class="service-header">
        <h2>PROSTHODONTICS</h2>
      </div>
      <div class="service-content">
        <div class="procedures-grid">
          <div class="procedure-card">
            <div class="before-after-container">
              <div class="before-after-wrapper">
                <div class="before-image" :style="{ clipPath: `inset(0 ${100 - prosthoSlider1}% 0 0)` }">
                  <div class="label">Before</div>
                  <img src="../Images/ATDC_pic1.png" alt="Before Image">
                </div>
                <div class="after-image">
                  <div class="label">After</div>
                  <img src="../Images/ATDC_pic2.png" alt="After Image">
                </div>
                <input type="range" class="slider" min="0" max="100" v-model="prosthoSlider1">
                <div class="slider-divider" :style="{ left: prosthoSlider1 + '%' }">
                  <div class="slider-handle"></div>
                </div>
              </div>
              <div class="procedure-title">Dental Crowns</div>
            </div>
          </div>
          
          <div class="procedure-card">
            <div class="before-after-container">
              <div class="before-after-wrapper">
                <div class="before-image" :style="{ clipPath: `inset(0 ${100 - prosthoSlider2}% 0 0)` }">
                  <div class="label">Before</div>
                  <img src="../Images/ATDC_pic1.png" alt="Before Image">
                </div>
                <div class="after-image">
                  <div class="label">After</div>
                  <img src="../Images/ATDC_pic2.png" alt="After Image">
                </div>
                <input type="range" class="slider" min="0" max="100" v-model="prosthoSlider2">
                <div class="slider-divider" :style="{ left: prosthoSlider2 + '%' }">
                  <div class="slider-handle"></div>
                </div>
              </div>
              <div class="procedure-title">Dental Bridges</div>
            </div>
          </div>
          
          <div class="procedure-card">
            <div class="before-after-container">
              <div class="before-after-wrapper">
                <div class="before-image" :style="{ clipPath: `inset(0 ${100 - prosthoSlider3}% 0 0)` }">
                  <div class="label">Before</div>
                  <img src="../Images/ATDC_pic1.png" alt="Before Image">
                </div>
                <div class="after-image">
                  <div class="label">After</div>
                  <img src="../Images/ATDC_pic2.png" alt="After Image">
                </div>
                <input type="range" class="slider" min="0" max="100" v-model="prosthoSlider3">
                <div class="slider-divider" :style="{ left: prosthoSlider3 + '%' }">
                  <div class="slider-handle"></div>
                </div>
              </div>
              <div class="procedure-title">Complete Dentures</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Cosmetic Dentistry Section -->
    <section class="service-section" id="cosmetic-dentistry">
      <div class="service-header">
        <h2>COSMETIC DENTISTRY</h2>
      </div>
      <div class="service-content">
        <div class="procedures-grid">
          <div class="procedure-card">
            <div class="before-after-container">
              <div class="before-after-wrapper">
                <div class="before-image" :style="{ clipPath: `inset(0 ${100 - cosmeticSlider1}% 0 0)` }">
                  <div class="label">Before</div>
                  <img src="../Images/ATDC_pic1.png" alt="Before Image">
                </div>
                <div class="after-image">
                  <div class="label">After</div>
                  <img src="../Images/ATDC_pic2.png" alt="After Image">
                </div>
                <input type="range" class="slider" min="0" max="100" v-model="cosmeticSlider1">
                <div class="slider-divider" :style="{ left: cosmeticSlider1 + '%' }">
                  <div class="slider-handle"></div>
                </div>
              </div>
              <div class="procedure-title">Teeth Whitening</div>
            </div>
          </div>
          
          <div class="procedure-card">
            <div class="before-after-container">
              <div class="before-after-wrapper">
                <div class="before-image" :style="{ clipPath: `inset(0 ${100 - cosmeticSlider2}% 0 0)` }">
                  <div class="label">Before</div>
                  <img src="../Images/ATDC_pic1.png" alt="Before Image">
                </div>
                <div class="after-image">
                  <div class="label">After</div>
                  <img src="../Images/ATDC_pic2.png" alt="After Image">
                </div>
                <input type="range" class="slider" min="0" max="100" v-model="cosmeticSlider2">
                <div class="slider-divider" :style="{ left: cosmeticSlider2 + '%' }">
                  <div class="slider-handle"></div>
                </div>
              </div>
              <div class="procedure-title">Dental Veneers</div>
            </div>
          </div>
          
          <div class="procedure-card">
            <div class="before-after-container">
              <div class="before-after-wrapper">
                <div class="before-image" :style="{ clipPath: `inset(0 ${100 - cosmeticSlider3}% 0 0)` }">
                  <div class="label">Before</div>
                  <img src="../Images/ATDC_pic1.png" alt="Before Image">
                </div>
                <div class="after-image">
                  <div class="label">After</div>
                  <img src="../Images/ATDC_pic2.png" alt="After Image">
                </div>
                <input type="range" class="slider" min="0" max="100" v-model="cosmeticSlider3">
                <div class="slider-divider" :style="{ left: cosmeticSlider3 + '%' }">
                  <div class="slider-handle"></div>
                </div>
              </div>
              <div class="procedure-title">Smile Makeover</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Orthodontics Section -->
    <section class="service-section" id="orthodontics">
      <div class="service-header">
        <h2>ORTHODONTICS</h2>
      </div>
      <div class="service-content">
        <div class="procedures-grid">
          <div class="procedure-card">
            <div class="before-after-container">
              <div class="before-after-wrapper">
                <div class="before-image" :style="{ clipPath: `inset(0 ${100 - orthodonticsSlider1}% 0 0)` }">
                  <div class="label">Before</div>
                  <img src="../Images/ATDC_pic1.png" alt="Before Image">
                </div>
                <div class="after-image">
                  <div class="label">After</div>
                  <img src="../Images/ATDC_pic2.png" alt="After Image">
                </div>
                <input type="range" class="slider" min="0" max="100" v-model="orthodonticsSlider1">
                <div class="slider-divider" :style="{ left: orthodonticsSlider1 + '%' }">
                  <div class="slider-handle"></div>
                </div>
              </div>
              <div class="procedure-title">Metal Braces</div>
            </div>
          </div>
          
          <div class="procedure-card">
            <div class="before-after-container">
              <div class="before-after-wrapper">
                <div class="before-image" :style="{ clipPath: `inset(0 ${100 - orthodonticsSlider2}% 0 0)` }">
                  <div class="label">Before</div>
                  <img src="../Images/ATDC_pic1.png" alt="Before Image">
                </div>
                <div class="after-image">
                  <div class="label">After</div>
                  <img src="../Images/ATDC_pic2.png" alt="After Image">
                </div>
                <input type="range" class="slider" min="0" max="100" v-model="orthodonticsSlider2">
                <div class="slider-divider" :style="{ left: orthodonticsSlider2 + '%' }">
                  <div class="slider-handle"></div>
                </div>
              </div>
              <div class="procedure-title">Clear Aligners</div>
            </div>
          </div>
          
          <div class="procedure-card">
            <div class="before-after-container">
              <div class="before-after-wrapper">
                <div class="before-image" :style="{ clipPath: `inset(0 ${100 - orthodonticsSlider3}% 0 0)` }">
                  <div class="label">Before</div>
                  <img src="../Images/ATDC_pic1.png" alt="Before Image">
                </div>
                <div class="after-image">
                  <div class="label">After</div>
                  <img src="../Images/ATDC_pic2.png" alt="After Image">
                </div>
                <input type="range" class="slider" min="0" max="100" v-model="orthodonticsSlider3">
                <div class="slider-divider" :style="{ left: orthodonticsSlider3 + '%' }">
                  <div class="slider-handle"></div>
                </div>
              </div>
              <div class="procedure-title">Retainers</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Endodontics Section -->
    <section class="service-section" id="endodontics">
      <div class="service-header">
        <h2>ENDODONTICS</h2>
      </div>
      <div class="service-content">
        <div class="procedures-grid">
          <div class="procedure-card">
            <div class="before-after-container">
              <div class="before-after-wrapper">
                <div class="before-image" :style="{ clipPath: `inset(0 ${100 - endoSlider1}% 0 0)` }">
                  <div class="label">Before</div>
                  <img src="../Images/ATDC_pic1.png" alt="Before Image">
                </div>
                <div class="after-image">
                  <div class="label">After</div>
                  <img src="../Images/ATDC_pic2.png" alt="After Image">
                </div>
                <input type="range" class="slider" min="0" max="100" v-model="endoSlider1">
                <div class="slider-divider" :style="{ left: endoSlider1 + '%' }">
                  <div class="slider-handle"></div>
                </div>
              </div>
              <div class="procedure-title">Root Canal Therapy</div>
            </div>
          </div>
          
          <div class="procedure-card">
            <div class="before-after-container">
              <div class="before-after-wrapper">
                <div class="before-image" :style="{ clipPath: `inset(0 ${100 - endoSlider2}% 0 0)` }">
                  <div class="label">Before</div>
                  <img src="../Images/ATDC_pic1.png" alt="Before Image">
                </div>
                <div class="after-image">
                  <div class="label">After</div>
                  <img src="../Images/ATDC_pic2.png" alt="After Image">
                </div>
                <input type="range" class="slider" min="0" max="100" v-model="endoSlider2">
                <div class="slider-divider" :style="{ left: endoSlider2 + '%' }">
                  <div class="slider-handle"></div>
                </div>
              </div>
              <div class="procedure-title">Apicoectomy</div>
            </div>
          </div>
          
          <div class="procedure-card">
            <div class="before-after-container">
              <div class="before-after-wrapper">
                <div class="before-image" :style="{ clipPath: `inset(0 ${100 - endoSlider3}% 0 0)` }">
                  <div class="label">Before</div>
                  <img src="../Images/ATDC_pic1.png" alt="Before Image">
                </div>
                <div class="after-image">
                  <div class="label">After</div>
                  <img src="../Images/ATDC_pic2.png" alt="After Image">
                </div>
                <input type="range" class="slider" min="0" max="100" v-model="endoSlider3">
                <div class="slider-divider" :style="{ left: endoSlider3 + '%' }">
                  <div class="slider-handle"></div>
                </div>
              </div>
              <div class="procedure-title">Pulpotomy</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Maxillofacial Surgery Section -->
    <section class="service-section" id="oral-surgery">
      <div class="service-header">
        <h2>MAXILLOFACIAL SURGERY</h2>
      </div>
      <div class="service-content">
        <div class="procedures-grid">
          <div class="procedure-card">
            <div class="before-after-container">
              <div class="before-after-wrapper">
                <div class="before-image" :style="{ clipPath: `inset(0 ${100 - surgerySlider1}% 0 0)` }">
                  <div class="label">Before</div>
                  <img src="../Images/ATDC_pic1.png" alt="Before Image">
                </div>
                <div class="after-image">
                  <div class="label">After</div>
                  <img src="../Images/ATDC_pic2.png" alt="After Image">
                </div>
                <input type="range" class="slider" min="0" max="100" v-model="surgerySlider1">
                <div class="slider-divider" :style="{ left: surgerySlider1 + '%' }">
                  <div class="slider-handle"></div>
                </div>
              </div>
              <div class="procedure-title">Wisdom Tooth Extraction</div>
            </div>
          </div>
          
          <div class="procedure-card">
            <div class="before-after-container">
              <div class="before-after-wrapper">
                <div class="before-image" :style="{ clipPath: `inset(0 ${100 - surgerySlider2}% 0 0)` }">
                  <div class="label">Before</div>
                  <img src="../Images/ATDC_pic1.png" alt="Before Image">
                </div>
                <div class="after-image">
                  <div class="label">After</div>
                  <img src="../Images/ATDC_pic2.png" alt="After Image">
                </div>
                <input type="range" class="slider" min="0" max="100" v-model="surgerySlider2">
                <div class="slider-divider" :style="{ left: surgerySlider2 + '%' }">
                  <div class="slider-handle"></div>
                </div>
              </div>
              <div class="procedure-title">Dental Implants</div>
            </div>
          </div>
          
          <div class="procedure-card">
            <div class="before-after-container">
              <div class="before-after-wrapper">
                <div class="before-image" :style="{ clipPath: `inset(0 ${100 - surgerySlider3}% 0 0)` }">
                  <div class="label">Before</div>
                  <img src="../Images/ATDC_pic1.png" alt="Before Image">
                </div>
                <div class="after-image">
                  <div class="label">After</div>
                  <img src="../Images/ATDC_pic2.png" alt="After Image">
                </div>
                <input type="range" class="slider" min="0" max="100" v-model="surgerySlider3">
                <div class="slider-divider" :style="{ left: surgerySlider3 + '%' }">
                  <div class="slider-handle"></div>
                </div>
              </div>
              <div class="procedure-title">Jaw Reconstruction</div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

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
  name: "SmileGallery",
  data() {
    return {
      isMenuOpen: false,
      showGoToTop: false,
      // General Dentistry sliders
      generalSlider1: 50,
      generalSlider2: 50,
      generalSlider3: 50,
      // Periodontics sliders
      perioSlider1: 50,
      perioSlider2: 50,
      perioSlider3: 50,
      // Prosthodontics sliders
      prosthoSlider1: 50,
      prosthoSlider2: 50,
      prosthoSlider3: 50,
      // Cosmetic Dentistry sliders
      cosmeticSlider1: 50,
      cosmeticSlider2: 50,
      cosmeticSlider3: 50,
      // Orthodontics sliders
      orthodonticsSlider1: 50,
      orthodonticsSlider2: 50,
      orthodonticsSlider3: 50,
      // Endodontics sliders
      endoSlider1: 50,
      endoSlider2: 50,
      endoSlider3: 50,
      // Maxillofacial Surgery sliders
      surgerySlider1: 50,
      surgerySlider2: 50,
      surgerySlider3: 50
    };
  },
  mounted() {
    // Load Font Awesome dynamically
    this.loadFontAwesome();
    
    // Add scroll listener for go-to-top button
    window.addEventListener('scroll', this.handleScroll);
  },
  beforeUnmount() {
    window.removeEventListener('scroll', this.handleScroll);
  },
  methods: {
    loadFontAwesome() {
      // Check if Font Awesome is already loaded
      if (!document.querySelector('link[href*="font-awesome"]')) {
        const link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css';
        link.crossOrigin = 'anonymous';
        document.head.appendChild(link);
      }
    },
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
}

/* Full-width edge-to-edge top header */
.top-header {
  width: 100%;
  margin-bottom: 50px;
  background: linear-gradient(135deg, #3CB54C 0%, #06693A 100%);
  position: relative;
  overflow: hidden;
}

.header-content {
  max-width: 100%;
  margin: 0 auto;
  text-align: center;
  position: relative;
  z-index: 2;
}

.top-header h1 {
  font-size: 48px;
  font-weight: 700;
  color: white;
  margin-bottom: 50px;
  text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.services-navigation {
  margin-bottom: 50px;
}

.nav-buttons {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 15px;
  margin-bottom: 40px;
}

.nav-button {
  background-color: white;
  color: #333;
  padding: 16px 24px;
  border-radius: 12px;
  text-decoration: none;
  font-weight: 600;
  font-size: 14px;
  transition: all 0.3s ease;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  border: 2px solid transparent;
  min-width: 160px;
  text-align: center;
}

.nav-button:hover {
  background-color: #06693A;
  color: white;
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
  border-color: white;
}

.nav-button span {
  display: block;
  line-height: 1.3;
}

.hero-content {
  background-color: rgba(6, 105, 58, 0.9);
  padding: 40px 30px;
  border-radius: 20px;
  backdrop-filter: blur(10px);
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

.hero-content h2 {
  font-size: 36px;
  font-weight: 700;
  color: white;
  margin-bottom: 20px;
  line-height: 1.2;
}

.hero-content p {
  font-size: 18px;
  color: white;
  line-height: 1.6;
  max-width: 900px;
  margin: 0 auto;
  opacity: 0.95;
}

/* Service sections styles */
.service-sections {
  max-width: 1400px;
  margin: 0 auto;
  padding: 0 20px;
}

.service-section {
  margin-bottom: 80px;
}

.service-header {
  background: linear-gradient(90deg, #06693A 0%, #3CB54C 100%);
  border-radius: 10px;
  padding: 20px 30px;
  margin-bottom: 40px;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  position: relative;
  overflow: hidden;
}

.service-header::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(45deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0) 100%);
  z-index: 1;
}

.service-header h2 {
  color: white;
  font-size: 28px;
  font-weight: 700;
  margin: 0;
  position: relative;
  z-index: 2;
}

.service-content {
  background-color: #f9f9f9;
  border-radius: 20px;
  padding: 40px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
}

.procedures-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 30px;
}

.procedure-card {
  background-color: white;
  border-radius: 15px;
  overflow: hidden;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.procedure-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
}

.before-after-container {
  position: relative;
}

.before-after-wrapper {
  position: relative;
  height: 350px;
  overflow: hidden;
}

.before-image,
.after-image {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}

.before-image {
  z-index: 2;
}

.after-image {
  z-index: 1;
}

.before-image img,
.after-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.label {
  position: absolute;
  top: 15px;
  padding: 5px 12px;
  background-color: rgba(255, 255, 255, 0.9);
  border-radius: 20px;
  font-size: 14px;
  font-weight: 600;
  color: #333;
  z-index: 3;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.before-image .label {
  left: 15px;
}

.after-image .label {
  right: 15px;
}

.slider {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  appearance: none;
  background: transparent;
  outline: none;
  z-index: 5;
  cursor: pointer;
  opacity: 0;
  margin: 0;
}

.slider-divider {
  position: absolute;
  top: 0;
  bottom: 0;
  width: 3px;
  background-color: white;
  z-index: 4;
  transition: left 0.1s ease;
  pointer-events: none;
}

.slider-handle {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 30px;
  height: 30px;
  background-color: white;
  border-radius: 50%;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
  display: flex;
  align-items: center;
  justify-content: center;
  pointer-events: none;
}

.slider-handle::before,
.slider-handle::after {
  content: '';
  position: absolute;
  background-color: #06693A;
  width: 2px;
  height: 10px;
}

.slider-handle::before {
  left: 10px;
}

.slider-handle::after {
  right: 10px;
}

.procedure-title {
  background: linear-gradient(to right, #06693A, #3CB54C);
  color: white;
  padding: 15px;
  font-size: 18px;
  font-weight: 600;
  text-align: center;
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
@media (max-width: 1200px) {
  .procedures-grid {
    grid-template-columns: repeat(2, 1fr);
  }
  
  .service-header h2 {
    font-size: 24px;
  }

  .nav-buttons {
    gap: 12px;
  }
  
  .nav-button {
    min-width: 140px;
    padding: 14px 20px;
    font-size: 13px;
  }

  .footer-info {
    grid-column: span 1;
  }

  /* Fixed mid-size screen navigation */
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
  .header-content {
    padding: 60px 15px 50px 15px;
  }
  
  .top-header h1 {
    font-size: 42px;
    margin-bottom: 40px;
  }
  
  .nav-buttons {
    gap: 10px;
  }
  
  .nav-button {
    min-width: 120px;
    padding: 12px 16px;
    font-size: 12px;
  }
  
  .hero-content {
    padding: 35px 25px;
  }
  
  .hero-content h2 {
    font-size: 32px;
  }
  
  .hero-content p {
    font-size: 16px;
  }

  .nav-links ul li a {
    font-size: 14px;
  }

  /* Further optimization for smaller mid-size screens */
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
    top: 20px;
    right: 20px;
  }

  .header-content {
    padding: 50px 15px 40px 15px;
  }
  
  .top-header h1 {
    font-size: 36px;
    margin-bottom: 35px;
  }
  
  .nav-buttons {
    gap: 8px;
  }
  
  .nav-button {
    flex: 1 1 calc(50% - 8px);
    min-width: 140px;
    max-width: 180px;
    padding: 12px 14px;
    font-size: 12px;
  }
  
  .hero-content {
    padding: 30px 20px;
    border-radius: 15px;
  }
  
  .hero-content h2 {
    font-size: 28px;
    margin-bottom: 15px;
  }
  
  .hero-content p {
    font-size: 15px;
    text-align: left;
  }

  .procedures-grid {
    grid-template-columns: 1fr;
    gap: 25px;
  }
  
  .service-content {
    padding: 25px;
  }
  
  .before-after-wrapper {
    height: 300px;
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

  .nav-links ul li a:hover::after {
    width: 100%;
  }
  
  .nav-links ul li {
    padding: 12px 0; /* Increase vertical padding in mobile menu */
    margin: 5px 0; /* Add more vertical spacing between items */
  }
}

@media (max-width: 576px) {
  .header-content {
    padding: 40px 10px 30px 10px;
  }
  
  .top-header h1 {
    font-size: 30px;
    margin-bottom: 30px;
  }
  
  .nav-buttons {
    gap: 6px;
    flex-direction: column;
    align-items: center;
  }
  
  .nav-button {
    flex: none;
    width: 90%;
    max-width: 280px;
    padding: 12px 16px;
    font-size: 13px;
  }
  
  .hero-content {
    padding: 25px 15px;
    border-radius: 12px;
  }
  
  .hero-content h2 {
    font-size: 24px;
    margin-bottom: 12px;
  }
  
  .hero-content p {
    font-size: 14px;
    line-height: 1.5;
  }

  .service-header {
    padding: 15px 20px;
  }
  
  .service-header h2 {
    font-size: 20px;
  }
  
  .before-after-wrapper {
    height: 250px;
  }
  
  .procedure-title {
    font-size: 16px;
    padding: 12px;
  }
  
  .label {
    font-size: 12px;
    padding: 4px 10px;
  }

  nav img {
    width: 70px;
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

@media (max-width: 480px) {
  .header-content {
    padding: 35px 8px 25px 8px;
  }
  
  .top-header h1 {
    font-size: 26px;
  }
  
  .nav-button {
    width: 95%;
    padding: 10px 14px;
    font-size: 12px;
  }
  
  .hero-content h2 {
    font-size: 22px;
  }
  
  .hero-content p {
    font-size: 13px;
  }
}

@media (max-width: 360px) {
  .header-content {
    padding: 30px 5px 20px 5px;
  }
  
  .top-header h1 {
    font-size: 24px;
  }
  
  .hero-content {
    padding: 20px 12px;
  }
  
  .hero-content h2 {
    font-size: 20px;
  }
  
  .hero-content p {
    font-size: 12px;
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

/* Prevent excessive spreading on very wide screens */
@media (min-width: 1400px) {
  .header-content {
    max-width: 1200px;
    padding: 80px 40px 60px 40px;
  }
}
</style>