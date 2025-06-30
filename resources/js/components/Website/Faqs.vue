<template>
  <!-- Responsive Navbar -->
  <nav>
    <a href="/" class="logo-link"><img src="@/components/Images/ATDC_logo.png" alt="Dental Clinic Logo"/></a>
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
  
  <div class="faqs-page">
    <!-- Hero Section -->
    <section class="hero-section">
      <div class="container">
        <h1>Frequently Asked Questions</h1>
        <p>Find answers to common questions about our dental services, procedures, and policies.</p>
        
        <!-- Search Bar -->
        <div class="search-container">
          <div class="search-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
          </div>
          <input 
            type="text"
            placeholder="Search for answers..."
            v-model="searchQuery"
          />
        </div>
      </div>
    </section>

    <!-- Quick Contact Info -->
    <section class="quick-contact">
      <div class="container">
        <div class="contact-grid">
          <div class="contact-item">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
            <span>+63 908 863 0882</span>
          </div>
          <div class="contact-item">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
            <span>aguilatitular.dental@gmail.com</span>
          </div>
          <div class="contact-item">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            <span>Mon-Sun: 9:00 AM - 5:00 PM</span>
          </div>
          <div class="contact-item">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
            <span>Marcos Highway, Antipolo</span>
          </div>
        </div>
      </div>
    </section>

    <!-- FAQ Content -->
    <section class="faq-content">
      <div class="container">
        <div v-if="searchQuery" class="search-results">
          <h2>Search Results</h2>
          <div v-if="filteredCategories.length > 0">
            <div v-for="(category, categoryIndex) in filteredCategories" :key="categoryIndex" class="category-section">
              <h3 class="category-title">
                <span v-html="category.icon"></span>
                <span>{{ category.name }}</span>
              </h3>
              <div class="faq-list">
                <div v-for="(faq, faqIndex) in category.questions" :key="faqIndex" class="faq-item">
                  <div 
                    class="faq-question" 
                    @click="toggleFaq(categoryIndex, faqIndex)"
                    :class="{ 'active': isOpen(categoryIndex, faqIndex) }"
                  >
                    <h4>{{ faq.question }}</h4>
                    <div class="toggle-icon">
                      <svg v-if="isOpen(categoryIndex, faqIndex)" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                      <svg v-else xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    </div>
                  </div>
                  <div class="faq-answer" :class="{ 'open': isOpen(categoryIndex, faqIndex) }">
                    <p>{{ faq.answer }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div v-else class="no-results">
            <div class="no-results-icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            </div>
            <h3>No results found</h3>
            <p>We couldn't find any FAQs matching your search. Please try different keywords or browse our categories.</p>
          </div>
        </div>
        <div v-else class="tabs-container">
          <!-- Category Slider -->
          <div class="category-slider-container">
            <button class="slider-arrow prev" @click="scrollLeft" :disabled="cannotScrollLeft">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
            </button>
            
            <div class="tabs-header" ref="tabsHeader">
              <div 
                v-for="(category, index) in faqCategories" 
                :key="index" 
                class="tab" 
                :class="{ 'active': activeTab === category.id }"
                @click="activeTab = category.id"
              >
                <span v-html="category.icon"></span>
                <span>{{ category.name }}</span>
              </div>
            </div>
            
            <button class="slider-arrow next" @click="scrollRight" :disabled="cannotScrollRight">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </button>
          </div>
          
          <div class="tabs-content">
            <div v-for="(category, categoryIndex) in faqCategories" :key="categoryIndex" class="tab-panel" v-show="activeTab === category.id">
              <div class="faq-list">
                <div v-for="(faq, faqIndex) in category.questions" :key="faqIndex" class="faq-item">
                  <div 
                    class="faq-question" 
                    @click="toggleFaq(categoryIndex, faqIndex)"
                    :class="{ 'active': isOpen(categoryIndex, faqIndex) }"
                  >
                    <h4>{{ faq.question }}</h4>
                    <div class="toggle-icon">
                      <svg v-if="isOpen(categoryIndex, faqIndex)" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                      <svg v-else xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    </div>
                  </div>
                  <div class="faq-answer" :class="{ 'open': isOpen(categoryIndex, faqIndex) }">
                    <p>{{ faq.answer }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Still Have Questions -->
    <section class="questions-cta">
      <div class="container">
        <h2>Still Have Questions?</h2>
        <p>Can't find the answer you're looking for? Please contact our friendly team.</p>
        <div class="cta-buttons">
          <a href="/contact" class="btn btn-primary">
            Contact Us
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
          </a>
          <a href="tel:+639088630882" class="btn btn-outline">
            Call Us: +63 908 863 0882
          </a>
        </div>
      </div>
    </section>

    <!-- Dental Care Tips -->
    <section class="dental-tips">
      <div class="container">
        <h2>Dental Care Tips</h2>
        <div class="tips-grid">
          <div class="tip-card">
            <div class="tip-icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 22c-4.2 0-7-1.4-7-4V6c0-2.6 2.8-4 7-4s7 1.4 7 4v12c0 2.6-2.8 4-7 4Z"/>
                <path d="M5 14h14"/>
                <path d="M5 10h14"/>
                <path d="M12 6v16"/>
              </svg>
            </div>
            <h3>Proper Brushing Technique</h3>
            <p>
              Brush your teeth at least twice a day using a soft-bristled toothbrush and fluoride toothpaste. Hold your brush at a 45-degree angle to your gums and use gentle, circular motions.
            </p>
          </div>
          
          <div class="tip-card">
            <div class="tip-icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 2v20"/>
                <path d="M8 2v20"/>
                <path d="M3 8h18"/>
                <path d="M3 16h18"/>
              </svg>
            </div>
            <h3>Daily Flossing</h3>
            <p>
              Floss at least once a day to remove plaque and food particles from between your teeth where your toothbrush can't reach. Gently curve the floss around each tooth in a C-shape.
            </p>
          </div>
          
          <div class="tip-card">
            <div class="tip-icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/>
              </svg>
            </div>
            <h3>Regular Dental Check-ups</h3>
            <p>
              Visit your dentist every six months for professional cleanings and check-ups. Regular dental visits help catch problems early when they're easier and less expensive to treat.
            </p>
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
  name: 'FAQsPage',
  data() {
    return {
      searchQuery: '',
      activeTab: 'general',
      openFaqs: {},
      isMenuOpen: false,
      showGoToTop: false,
      cannotScrollLeft: true,
      cannotScrollRight: false,
      faqCategories: [
        {
          id: "general",
          name: "General Questions",
          icon: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/></svg>`,
          questions: [
            {
              question: "What services does Aguila-Titular Dental Clinic offer?",
              answer: "Our clinic offers a comprehensive range of dental services including general dentistry, orthodontics, periodontics, prosthodontics, endodontics, maxillofacial surgery, and cosmetic dentistry. Our team of experienced dentists provides everything from routine check-ups to complex dental procedures."
            },
            {
              question: "What are your clinic hours?",
              answer: "Our clinic is open Monday through Sunday from 9:00 AM to 5:00 PM. We offer extended hours by appointment for emergency cases."
            },
            {
              question: "Do I need to schedule an appointment or can I walk in?",
              answer: "While we do accept walk-ins based on availability, we strongly recommend scheduling an appointment to ensure you can be seen promptly by your preferred dentist. You can book appointments through our website, by phone, or in person."
            },
            {
              question: "How often should I visit the dentist?",
              answer: "For optimal oral health, we recommend visiting the dentist every six months for a check-up and professional cleaning. However, patients with specific dental conditions may require more frequent visits as advised by their dentist."
            }
          ]
        },
        {
          id: "treatments",
          name: "Treatments & Procedures",
          icon: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 7h20"/><path d="M12 22V7"/><path d="M17 22V7"/><path d="M7 22V7"/><path d="M17 2h-5a2 2 0 0 0-2 2v3"/><path d="M2 17h20"/></svg>`,
          questions: [
            {
              question: "How long does a dental cleaning take?",
              answer: "A standard dental cleaning (oral prophylaxis) typically takes between 30 to 60 minutes, depending on the amount of plaque and tartar buildup. Your appointment may take longer if it includes a comprehensive dental exam or additional procedures."
            },
            {
              question: "Is teeth whitening safe?",
              answer: "Yes, professional teeth whitening performed by our dental professionals is safe. We use high-quality whitening products and customize the treatment to your specific needs. Some patients may experience temporary tooth sensitivity, which typically resolves shortly after treatment."
            },
            {
              question: "How long do dental implants last?",
              answer: "With proper care and maintenance, dental implants can last a lifetime. The success rate of dental implants is approximately 95-98%. Regular dental check-ups, good oral hygiene, and avoiding harmful habits like smoking can significantly extend the lifespan of your implants."
            },
            {
              question: "What is the difference between traditional braces and clear aligners?",
              answer: "Traditional braces use metal brackets and wires to gradually move teeth into alignment, while clear aligners are transparent, removable trays that accomplish the same goal. Clear aligners are less noticeable and can be removed for eating and cleaning, but may not be suitable for complex orthodontic cases. During your consultation, our orthodontist will recommend the best option based on your specific needs."
            }
          ]
        },
        {
          id: "payment",
          name: "Payment & Insurance",
          icon: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>`,
          questions: [
            {
              question: "What payment methods do you accept?",
              answer: "We accept various payment methods including cash, credit/debit cards (Mastercard, Visa, UnionPay, BancNet), and digital payment platforms (ShopeePay, GrabPay, WeChatPay). We also work with healthcare financing options to make dental care more accessible."
            },
            {
              question: "Do you accept dental insurance?",
              answer: "Yes, we accept most major dental insurance plans including Medicard and Maxicare. We recommend contacting our office before your appointment to verify your coverage and benefits. Our staff will help you maximize your insurance benefits and process your claims."
            },
            {
              question: "Do you offer payment plans for more expensive treatments?",
              answer: "Yes, we offer flexible payment plans for more extensive dental treatments. Our administrative team will work with you to create a payment schedule that fits your budget. Please inquire at our front desk for more information about our financing options."
            }
          ]
        },
        {
          id: "emergency",
          name: "Dental Emergencies",
          icon: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8.7 3A6 6 0 0 0 2 9a6 6 0 0 0 9 5.3 6 6 0 0 0 11-5.3 6 6 0 0 0-6.7-6"/><path d="M12 9h.01"/><path d="M12 13h.01"/></svg>`,
          questions: [
            {
              question: "What should I do if I have a severe toothache?",
              answer: "For a severe toothache, rinse your mouth with warm water, use dental floss to remove any food trapped between teeth, and take over-the-counter pain relievers as directed. Apply a cold compress to the outside of your cheek if there's swelling. Contact our office immediately for an emergency appointment, as toothaches often indicate infections or other serious conditions that require prompt treatment."
            },
            {
              question: "What should I do if I knock out a tooth?",
              answer: "If you knock out a tooth, retrieve it by the crown (not the root), rinse it gently without scrubbing, and try to reinsert it into the socket if possible. If reinsertion isn't possible, place the tooth in milk or a tooth preservation product. Contact our office immediately, as a knocked-out tooth has the best chance of being saved if treated within 30-60 minutes."
            },
            {
              question: "Do you offer emergency dental services?",
              answer: "Yes, we provide emergency dental services for both existing and new patients. If you experience a dental emergency during office hours, call us immediately and we'll make arrangements to see you as soon as possible. For after-hours emergencies, call our main number for instructions on reaching our on-call dentist."
            }
          ]
        },
        {
          id: "appointment",
          name: "Appointment Scheduling",
          icon: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>`,
          questions: [
            {
              question: "How can I schedule an appointment?",
              answer: "You can schedule an appointment by calling our clinic at +63 908 863 0882, using our online booking system on our website, or visiting our clinic in person. We recommend booking at least a week in advance for routine check-ups and cleanings."
            },
            {
              question: "What is your cancellation policy?",
              answer: "We understand that emergencies happen. We kindly ask that you notify us at least 24 hours in advance if you need to cancel or reschedule your appointment. This allows us to offer the time slot to other patients who may need urgent care."
            },
            {
              question: "How long should I expect my dental appointment to last?",
              answer: "The duration of your appointment depends on the type of treatment. A routine check-up and cleaning typically takes 45-60 minutes, while more complex procedures like root canals or crown placements may take 1-2 hours. We'll provide you with an estimated timeframe when you schedule your appointment."
            },
            {
              question: "Can I request a specific dentist for my appointment?",
              answer: "Yes, you can request to see a specific dentist when scheduling your appointment. We'll do our best to accommodate your preference based on the dentist's availability. If you're a new patient, we're happy to help match you with a dentist based on your specific dental needs."
            }
          ]
        },
        {
          id: "newpatients",
          name: "For New Patients",
          icon: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>`,
          questions: [
            {
              question: "What should I bring to my first appointment?",
              answer: "For your first visit, please bring your ID, insurance card (if applicable), a list of any medications you're currently taking, and your complete medical and dental history. If you have recent dental X-rays from a previous dentist, bringing those can be helpful and may prevent the need for new images."
            },
            {
              question: "Do I need to arrive early for my first appointment?",
              answer: "Yes, we recommend arriving 15-20 minutes before your scheduled appointment time. This allows you to complete any necessary paperwork and become familiar with our office. You can also download and complete our new patient forms from our website in advance to save time."
            },
            {
              question: "What can I expect during my first dental visit?",
              answer: "Your first visit typically includes a comprehensive oral examination, professional cleaning, necessary X-rays, and a discussion about your dental health goals. Our dentist will evaluate your oral health, check for signs of decay or gum disease, perform an oral cancer screening, and develop a personalized treatment plan if needed."
            },
            {
              question: "Is there anything special I should do before my first appointment?",
              answer: "We recommend brushing and flossing before your appointment, but avoid heavy meals right before your visit. If you experience dental anxiety, let us know in advance so we can take extra steps to ensure your comfort. Also, prepare a list of any questions or concerns you'd like to discuss with your dentist."
            }
          ]
        },
        {
          id: "patientsafety",
          name: "Patient Safety",
          icon: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>`,
          questions: [
            {
              question: "What safety protocols does your clinic follow?",
              answer: "Our clinic adheres to strict safety protocols that meet or exceed guidelines from health authorities. We use hospital-grade sterilization for all instruments, disposable materials when appropriate, and maintain a clean environment with regular disinfection. Our staff undergoes continuous training on infection control and safety procedures."
            },
            {
              question: "How do you ensure patient safety during dental procedures?",
              answer: "We ensure patient safety through comprehensive pre-procedure assessments, use of appropriate personal protective equipment, adherence to sterilization protocols, and careful monitoring during procedures. We also maintain detailed records of your medical history and any allergies to prevent adverse reactions to medications or materials."
            },
            {
              question: "What measures do you take to prevent cross-contamination?",
              answer: "We prevent cross-contamination through strict protocols including the use of disposable barriers on equipment, sterilization of all reusable instruments using autoclaves, regular disinfection of treatment areas between patients, and proper hand hygiene. Our dental team also wears fresh personal protective equipment for each patient."
            },
            {
              question: "How do you handle medical emergencies in the clinic?",
              answer: "Our entire team is trained in basic life support and emergency response. We have emergency medical equipment on-site and established protocols for various emergency situations. We also maintain relationships with nearby medical facilities for rapid referral if necessary."
            }
          ]
        },
        {
          id: "transformation",
          name: "Smile Transformation",
          icon: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a10 10 0 1 0 10 10H12V2z"></path><path d="M12 2a10 10 0 0 1 10 10h-10V2z"></path><path d="M12 12l9 3-3 1"></path><path d="M12 12l-9 3 3 1"></path></svg>`,
          questions: [
            {
              question: "What smile transformation options do you offer?",
              answer: "We offer a comprehensive range of smile transformation options including professional teeth whitening, dental veneers, dental bonding, orthodontic treatments (traditional braces and clear aligners), dental implants, crowns, and complete smile makeovers. During your consultation, we'll discuss which options are best suited to achieve your desired results."
            },
            {
              question: "How long does a typical smile makeover take?",
              answer: "The timeline for a smile makeover varies depending on the specific treatments involved. Simple procedures like professional whitening can be completed in a single visit, while more comprehensive transformations involving orthodontics or implants may take several months. We'll provide you with a detailed timeline during your consultation."
            },
            {
              question: "Are smile transformations painful?",
              answer: "We prioritize your comfort during all procedures. Most patients experience minimal discomfort during smile transformations. We use local anesthesia when necessary and can provide sedation options for anxious patients. Any post-procedure discomfort is typically mild and can be managed with over-the-counter pain relievers."
            },
            {
              question: "How do I maintain my new smile after treatment?",
              answer: "Maintaining your transformed smile involves regular dental check-ups and cleanings, diligent at-home oral hygiene, and following any specific care instructions for your treatments. For certain procedures like whitening, occasional touch-up treatments may be recommended. We'll provide you with detailed aftercare instructions specific to your treatment plan."
            }
          ]
        }
      ]
    }
  },
  computed: {
    filteredCategories() {
      return this.faqCategories.map(category => {
        return {
          ...category,
          questions: category.questions.filter(faq => 
            faq.question.toLowerCase().includes(this.searchQuery.toLowerCase()) || 
            faq.answer.toLowerCase().includes(this.searchQuery.toLowerCase())
          )
        }
      }).filter(category => category.questions.length > 0)
    }
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
    toggleFaq(categoryIndex, faqIndex) {
      const key = `${categoryIndex}-${faqIndex}`;
      this.openFaqs[key] = !this.openFaqs[key];
      this.$forceUpdate(); // Force update to ensure reactivity
    },
    isOpen(categoryIndex, faqIndex) {
      const key = `${categoryIndex}-${faqIndex}`;
      return !!this.openFaqs[key];
    },
    scrollLeft() {
      if (!this.$refs.tabsHeader) return;
      const scrollAmount = 200;
      this.$refs.tabsHeader.scrollBy({
        left: -scrollAmount,
        behavior: 'smooth'
      });
      this.updateScrollButtons();
    },
    scrollRight() {
      if (!this.$refs.tabsHeader) return;
      const scrollAmount = 200;
      this.$refs.tabsHeader.scrollBy({
        left: scrollAmount,
        behavior: 'smooth'
      });
      this.updateScrollButtons();
    },
    updateScrollButtons() {
      if (!this.$refs.tabsHeader) return;
      
      // Use setTimeout to allow the scroll to complete
      setTimeout(() => {
        const { scrollLeft, scrollWidth, clientWidth } = this.$refs.tabsHeader;
        this.cannotScrollLeft = scrollLeft <= 0;
        this.cannotScrollRight = scrollLeft + clientWidth >= scrollWidth - 10; // 10px buffer
      }, 100);
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
  },
  mounted() {
    // Load Font Awesome dynamically
    this.loadFontAwesome();

    // Initialize scroll buttons state
    this.$nextTick(() => {
      this.updateScrollButtons();
      
      // Add scroll event listener
      if (this.$refs.tabsHeader) {
        this.$refs.tabsHeader.addEventListener('scroll', this.updateScrollButtons);
      }
      
      // Add resize event listener to update buttons when window is resized
      window.addEventListener('resize', this.updateScrollButtons);
    });

    // Add scroll listener for go-to-top button
    window.addEventListener('scroll', this.handleScroll);
  },
  beforeDestroy() {
    // Clean up event listeners
    if (this.$refs.tabsHeader) {
      this.$refs.tabsHeader.removeEventListener('scroll', this.updateScrollButtons);
    }
    window.removeEventListener('resize', this.updateScrollButtons);
    window.removeEventListener('scroll', this.handleScroll);
  }
}
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

/* Responsive Navbar - EXACT COPY FROM HOMEPAGE */
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

/* Base Styles */
body {
  font-family: 'Arial', sans-serif;
  line-height: 1.6;
  color: #333;
  background-color: #f8f9fa;
}

.container {
  width: 100%;
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
}

h1, h2, h3, h4 {
  font-weight: 700;
  line-height: 1.2;
}

/* Hero Section */
.hero-section {
  background: linear-gradient(to right, #06693A, #3CB54C);
  color: white;
  padding: 60px 20px;
  text-align: center;
  position: relative;
  overflow: hidden;
}

.hero-section::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
  opacity: 0.1;
  z-index: 0;
}

.hero-section h1 {
  font-size: 2.5rem;
  margin-bottom: 20px;
  position: relative;
  z-index: 1;
}

.hero-section p {
  font-size: 1.2rem;
  margin-bottom: 30px;
  max-width: 700px;
  margin-left: auto;
  margin-right: auto;
  opacity: 0.9;
  position: relative;
  z-index: 1;
}

/* Search Bar */
.search-container {
  position: relative;
  max-width: 600px;
  margin: 0 auto;
  z-index: 1;
}

.search-icon {
  position: absolute;
  left: 20px;
  top: 55%;
  transform: translateY(-50%);
  color: rgba(255, 255, 255, 0.7);
}

.search-container input {
  width: 100%;
  padding: 15px 15px 15px 45px;
  border-radius: 50px;
  border: 1px solid rgba(255, 255, 255, 0.3);
  background-color: rgba(255, 255, 255, 0.2);
  color: white;
  font-size: 1rem;
  transition: all 0.3s ease;
}

.search-container input::placeholder {
  color: rgba(255, 255, 255, 0.7);
}

.search-container input:focus {
  outline: none;
  box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.5);
  background-color: rgba(255, 255, 255, 0.25);
}

/* Quick Contact */
.quick-contact {
  background-color: white;
  padding: 15px 0;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.contact-grid {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
}

.contact-item {
  display: flex;
  align-items: center;
  padding: 10px;
  color: #333;
}

.contact-item svg {
  margin-right: 10px;
  color: #06693A;
}

/* FAQ Content */
.faq-content {
  padding: 60px 0;
}

.search-results h2,
.tabs-container h2 {
  font-size: 1.8rem;
  margin-bottom: 30px;
}

/* Category Slider */
.category-slider-container {
  position: relative;
  margin-bottom: 30px;
  display: flex;
  align-items: center;
}

.slider-arrow {
  background-color: #fff;
  border: 1px solid #e0e0e0;
  border-radius: 50%;
  width: 40px;
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  z-index: 2;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
}

.slider-arrow:hover {
  background-color: #f5f5f5;
}

.slider-arrow:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.slider-arrow.prev {
  margin-right: 10px;
}

.slider-arrow.next {
  margin-left: 10px;
}

/* Tabs */
.tabs-header {
  display: flex;
  flex-wrap: nowrap;
  background-color: #f0f0f0;
  border-radius: 8px;
  overflow-x: auto;
  padding: 5px;
  flex: 1;
  scrollbar-width: none; /* Firefox */
  -ms-overflow-style: none; /* IE and Edge */
  scroll-behavior: smooth;
}

.tabs-header::-webkit-scrollbar {
  display: none; /* Chrome, Safari, Opera */
}

.tab {
  padding: 12px 20px;
  cursor: pointer;
  display: flex;
  align-items: center;
  color: #666;
  font-weight: 600;
  border-radius: 6px;
  margin: 2px 8px; /* Increased horizontal margin from 2px to 8px */
  white-space: nowrap;
  transition: all 0.3s ease;
  flex: 0 0 auto;
}

.tab svg {
  margin-right: 8px;
  color: #06693A;
  position: relative;
  top: 2px; /* This will move the icon down by 2px */
}

.tab:hover {
  background-color: #e8e8e8;
  transform: translateY(-1px);
}

.tab.active {
  background-color: white;
  color: #06693A;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  transform: scale(1.05);
}

.tabs-content {
  background-color: white;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

/* FAQ Items */
.faq-list {
  margin-top: 20px;
}

.faq-item {
  margin-bottom: 15px;
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  overflow: hidden;
  transition: all 0.3s ease;
}

.faq-item:hover {
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
}

.faq-question {
  padding: 15px 20px;
  background-color: white;
  cursor: pointer;
  display: flex;
  justify-content: space-between;
  align-items: center;
  transition: background-color 0.3s ease;
}

.faq-question h4 {
  font-size: 1.1rem;
  font-weight: 500;
  margin: 0;
}

.toggle-icon {
  color: #06693A;
}

.faq-question.active {
  background-color: #f9f9f9;
}

.faq-answer {
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.3s ease, padding 0.3s ease;
  background-color: #f9f9f9;
  border-top: 0 solid #e0e0e0;
}

.faq-answer.open {
  max-height: 500px;
  padding: 15px 20px;
  border-top-width: 1px;
}

.faq-answer p {
  margin: 0;
  color: #555;
}

/* Category Section */
.category-section {
  margin-bottom: 40px;
}

.category-title {
  display: flex;
  align-items: center;
  font-size: 1.4rem;
  color: #06693A;
  margin-bottom: 15px;
}

.category-title svg {
  margin-right: 10px;
}

/* No Results */
.no-results {
  text-align: center;
  padding: 40px 20px;
}

.no-results-icon {
  background-color: #f0f0f0;
  width: 80px;
  height: 80px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 20px;
}

.no-results-icon svg {
  color: #999;
}

.no-results h3 {
  font-size: 1.4rem;
  margin-bottom: 10px;
}

.no-results p {
  color: #666;
  max-width: 500px;
  margin: 0 auto;
}

/* CTA Section */
.questions-cta {
  background-color: #F0EDE3;
  padding: 60px 20px;
  text-align: center;
}

.questions-cta h2 {
  font-size: 2rem;
  margin-bottom: 15px;
}

.questions-cta p {
  font-size: 1.1rem;
  color: #555;
  max-width: 700px;
  margin: 0 auto 30px;
}

.cta-buttons {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 15px;
}

.btn {
  display: inline-flex;
  align-items: center;
  padding: 12px 24px;
  border-radius: 8px;
  font-weight: 600;
  font-size: 1rem;
  cursor: pointer;
  transition: all 0.3s ease;
  text-decoration: none;
}

.btn svg {
  margin-left: 8px;
}

.btn-primary {
  background-color: #06693A;
  color: white;
  border: none;
}

.btn-primary:hover {
  background-color: #055a31;
  transform: translateY(-2px);
}

.btn-outline {
  background-color: transparent;
  color: #06693A;
  border: 1px solid #06693A;
}

.btn-outline:hover {
  background-color: rgba(6, 105, 58, 0.1);
  transform: translateY(-2px);
}

/* Dental Tips Section */
.dental-tips {
  padding: 60px 20px;
}

.dental-tips h2 {
  font-size: 2rem;
  text-align: center;
  margin-bottom: 40px;
}

.tips-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 30px;
}

.tip-card {
  background-color: white;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
  transition: all 0.3s ease;
}

.tip-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.tip-icon {
  height: 180px;
  background-color: rgba(6, 105, 58, 0.1);
  display: flex;
  align-items: center;
  justify-content: center;
}

.tip-icon svg {
  color: #06693A;
}

.tip-card h3 {
  font-size: 1.3rem;
  padding: 20px 20px 10px;
}

.tip-card p {
  padding: 0 20px 20px;
  color: #555;
}

/* Responsive Footer - EXACT COPY FROM HOMEPAGE */
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
  .hero-section h1 {
    font-size: 2rem;
  }
  
  .hero-section p {
    font-size: 1rem;
  }
  
  .contact-grid {
    flex-direction: column;
  }
  
  .contact-item {
    justify-content: center;
  }
  
  .tabs-header {
    justify-content: flex-start;
    overflow-x: auto;
  }
  
  .tab {
    padding: 10px 15px;
    font-size: 0.9rem;
  }
  
  .cta-buttons {
    flex-direction: column;
    align-items: center;
  }
  
  .btn {
    width: 100%;
    justify-content: center;
  }
  
  .tips-grid {
    grid-template-columns: 1fr;
  }

  .footer-info {
    grid-column: span 1;
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
  nav img {
    width: 70px;
  }
  
  .hero-section {
    padding: 40px 15px;
  }
  
  .hero-section h1 {
    font-size: 1.8rem;
  }
  
  .search-container input {
    padding: 12px 12px 12px 40px;
  }
  
  .faq-question h4 {
    font-size: 1rem;
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
