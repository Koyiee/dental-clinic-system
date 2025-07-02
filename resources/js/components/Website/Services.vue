<template>
  <!-- Responsive Navbar -->
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
  
  <!-- Services section -->
  <div class="services-container">
    <h1 class="services-title">SERVICES</h1>
    
    <!-- Main tabs -->
    <div class="tabs-container">
      <div class="tab-navigation">
        <button class="nav-arrow" @click="scrollTabs('left')">&lsaquo;</button>
        <div class="tabs-list" ref="tabsList">
          <button 
            v-for="(category, index) in categories" 
            :key="index" 
            class="tab-button" 
            :class="{ active: activeCategory === index }"
            @click="setActiveCategory(index)"
          >
            {{ category.name }}
          </button>
        </div>
        <button class="nav-arrow" @click="scrollTabs('right')">&rsaquo;</button>
      </div>
    </div>

    <!-- Services grid -->
    <div class="services-grid">
      <button class="nav-arrow left-arrow" @click="scrollServices('left')">&lsaquo;</button>
      
      <div class="services-row" ref="servicesRow">
        <div 
          v-for="(service, index) in categories[activeCategory].services" 
          :key="index" 
          class="service-item"
          @click="setActiveService(service)"
        >
          <div class="service-icon">
            <img src="@/components/Images/Oral Prophylaxis.png" :alt="service.name">
          </div>
          <div class="service-name" v-html="service.name"></div>
        </div>
      </div>
      
      <button class="nav-arrow right-arrow" @click="scrollServices('right')">&rsaquo;</button>
    </div>

    <!-- Service Content -->
    <div v-if="activeService" class="service-content" :class="{ active: activeService }">
      <h2>{{ activeService.name }}</h2>
      <p>{{ activeService.description }}</p>
      
      <div v-if="activeService.whoNeeds" class="service-section">
        <h3>Who Needs This Service?</h3>
        <p>{{ activeService.whoNeeds }}</p>
      </div>
      
      <div v-if="activeService.benefits && activeService.benefits.length > 0" class="service-section">
        <h3>Benefits</h3>
        <ul>
          <li v-for="(benefit, index) in activeService.benefits" :key="index">{{ benefit }}</li>
        </ul>
      </div>
      
      <div v-if="activeService.advantages && activeService.advantages.length > 0" class="service-section">
        <h3>Advantages</h3>
        <ul>
          <li v-for="(advantage, index) in activeService.advantages" :key="index">{{ advantage }}</li>
        </ul>
      </div>
      
      <div v-if="activeService.disadvantages && activeService.disadvantages.length > 0" class="service-section">
        <h3>Considerations</h3>
        <ul>
          <li v-for="(disadvantage, index) in activeService.disadvantages" :key="index">{{ disadvantage }}</li>
        </ul>
      </div>
      
      <div v-if="activeService.types && activeService.types.length > 0" class="service-section">
        <h3>Types</h3>
        <div v-for="(type, index) in activeService.types" :key="index" class="service-type">
          <h4>{{ type.name }}</h4>
          <p>{{ type.description }}</p>
        </div>
      </div>
      
      <div v-if="activeService.procedure" class="service-section">
        <h3>Procedure</h3>
        <p>{{ activeService.procedure }}</p>
      </div>
      
      <div v-if="activeService.aftercare" class="service-section">
        <h3>Aftercare</h3>
        <p>{{ activeService.aftercare }}</p>
      </div>
    </div>
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
  data() {
    return {
      isMenuOpen: false,
      showGoToTop: false,
      activeCategory: 0,
      activeService: null,
      categories: [
        {
          name: 'General Dentistry',
          services: [
            {
              name: 'Dental Exam/ Dental Check-up',
              description: 'A comprehensive evaluation of your oral health, including examination of teeth, gums, and mouth tissues to detect any issues early.',
              whoNeeds: 'Everyone should have regular dental check-ups, typically every 6 months. More frequent visits may be recommended for patients with specific dental issues, gum disease, or medical conditions like diabetes.',
              benefits: [
                'Early detection of dental problems before they become serious',
                'Professional cleaning to remove plaque and tartar',
                'Screening for oral cancer and other diseases',
                'Personalized advice on oral hygiene practices',
                'Prevention of future dental issues'
              ],
              advantages: [
                'Non-invasive and painless procedure',
                'Saves money in the long run by preventing costly treatments',
                'Maintains overall oral health'
              ],
              disadvantages: [
                'May require time commitment for regular visits',
                'Some insurance plans may limit coverage for preventive care'
              ],
              procedure: 'During a dental exam, the dentist will review your dental and medical history, examine your teeth for decay, check your gums for disease, assess your bite and jaw alignment, and may take X-rays to detect hidden problems. The exam is usually followed by professional cleaning.'
            },
            {
              name: 'Oral Prophylaxis',
              description: 'Professional dental cleaning that involves removing plaque, calculus, and stains from teeth. This preventive procedure helps maintain oral health and prevent gum disease.',
              whoNeeds: 'Everyone should have regular professional cleanings, typically every 6 months. Patients with gum disease, heavy plaque buildup, or certain medical conditions may need more frequent cleanings.',
              benefits: [
                'Removes plaque and tartar that cannot be eliminated by regular brushing and flossing',
                'Prevents gum disease and tooth decay',
                'Freshens breath by removing bacteria',
                'Brightens smile by removing surface stains',
                'Allows dentist to identify potential problems early'
              ],
              advantages: [
                'Non-invasive procedure with minimal discomfort',
                'Typically completed in one visit',
                'Covered by most dental insurance plans',
                'Helps maintain overall oral health'
              ],
              disadvantages: [
                'May cause temporary sensitivity in some patients',
                'Requires regular appointments to maintain benefits'
              ],
              procedure: 'The dental hygienist or dentist uses specialized instruments to gently remove plaque and tartar from tooth surfaces, including below the gumline. This is followed by polishing the teeth to remove stains and smooth the tooth surface, making it more difficult for plaque to accumulate.',
              types: [
                {
                  name: 'Regular Prophylaxis',
                  description: 'Standard cleaning for patients with good oral health, performed every 6 months.'
                },
                {
                  name: 'Deep Cleaning (Scaling and Root Planing)',
                  description: 'More intensive cleaning for patients with signs of gum disease, reaching deeper below the gumline.'
                }
              ]
            },
            {
              name: 'Fluoride Treatment',
              description: 'A preventive treatment that applies a high concentration of fluoride to the teeth to strengthen enamel and prevent tooth decay.',
              whoNeeds: 'Children and adults at high risk for tooth decay, including those with dry mouth, gum recession, history of frequent cavities, or orthodontic appliances.',
              benefits: [
                'Strengthens tooth enamel and makes it more resistant to acid attacks',
                'Reverses early signs of tooth decay',
                'Prevents the growth of harmful oral bacteria',
                'Reduces sensitivity in exposed root surfaces',
                'Provides long-lasting protection between dental visits'
              ],
              advantages: [
                'Quick and painless procedure (takes only a few minutes)',
                'Provides protection that regular toothpaste cannot match',
                'Safe when applied professionally'
              ],
              disadvantages: [
                'May leave a temporary aftertaste',
                'Should not eat or drink for 30 minutes after treatment',
                'Requires regular reapplication for maximum benefit'
              ],
              procedure: 'The dentist applies fluoride gel, foam, or varnish to clean, dry teeth using a brush, swab, tray, or mouthwash. The fluoride treatment typically takes a few minutes to apply and may require avoiding eating or drinking for 30 minutes afterward to allow the fluoride to fully absorb.',
              types: [
                {
                  name: 'Fluoride Gel or Foam',
                  description: 'Applied using trays that fit over the teeth for 1-4 minutes.'
                },
                {
                  name: 'Fluoride Varnish',
                  description: 'Painted directly onto tooth surfaces and hardens when it comes in contact with saliva.'
                },
                {
                  name: 'Fluoride Rinse',
                  description: 'Swished around the mouth for about one minute before spitting out.'
                }
              ]
            },
            {
              name: 'Dental X-rays',
              description: 'Diagnostic imaging that allows dentists to see structures not visible during a regular dental examination, including areas between teeth, below the gumline, and inside the tooth.',
              whoNeeds: 'New patients typically need a full set of dental X-rays to establish a baseline. Existing patients may need periodic X-rays based on age, risk for disease, and signs of dental problems.',
              benefits: [
                'Detects cavities between teeth that cannot be seen visually',
                'Identifies bone loss associated with gum disease',
                'Shows impacted teeth, including wisdom teeth',
                'Reveals abscesses, cysts, tumors, and other abnormalities',
                'Helps plan treatments like implants, braces, and extractions'
              ],
              advantages: [
                'Low radiation exposure with modern digital X-rays',
                'Provides crucial information for accurate diagnosis',
                'Allows early intervention for hidden problems'
              ],
              disadvantages: [
                'Minimal radiation exposure (though significantly reduced with digital X-rays)',
                'May be uncomfortable for patients with strong gag reflexes',
                'Some insurance plans limit frequency of coverage'
              ],
              procedure: 'The dental professional places a small sensor or film in your mouth and positions the X-ray machine to capture images of specific areas. You\'ll wear a lead apron to protect other parts of your body. The process is quick and painless, taking just seconds per image.',
              types: [
                {
                  name: 'Bitewing X-rays',
                  description: 'Show the upper and lower back teeth in a single view, used to detect decay between teeth.'
                },
                {
                  name: 'Periapical X-rays',
                  description: 'Show the entire tooth from crown to root, used to detect root problems and surrounding bone structure.'
                },
                {
                  name: 'Panoramic X-rays',
                  description: 'Show a broad view of the entire mouth, including all teeth, jaws, sinuses, and temporomandibular joints.'
                }
              ]
            },
            {
              name: 'Cavity Fillings',
              description: 'Procedure to restore damaged or decayed teeth using materials like composite resin, amalgam, or porcelain to fill cavities and prevent further decay.',
              whoNeeds: 'Anyone with tooth decay or small to moderate damage to tooth structure. Fillings are one of the most common dental procedures.',
              benefits: [
                'Stops the progression of tooth decay',
                'Restores tooth function and strength',
                'Prevents further damage to the tooth',
                'Eliminates pain associated with cavities',
                'Preserves natural tooth structure'
              ],
              advantages: [
                'Relatively quick procedure (usually completed in one visit)',
                'Long-lasting results (5-15 years depending on material)',
                'Prevents need for more extensive treatments like crowns or root canals'
              ],
              disadvantages: [
                'May cause temporary sensitivity to hot and cold',
                'Some materials may discolor over time',
                'Large fillings may weaken the tooth structure over time'
              ],
              procedure: 'The dentist numbs the area, removes the decayed portion of the tooth, cleans the cavity, and fills it with the chosen material. The filling is then shaped to match your bite and polished. The entire process typically takes 30-60 minutes per tooth.',
              types: [
                {
                  name: 'Composite Resin (Tooth-Colored)',
                  description: 'Made of plastic and fine glass particles, these fillings match your natural tooth color and bond directly to the tooth structure.'
                },
                {
                  name: 'Amalgam (Silver)',
                  description: 'Made of a mixture of metals including silver, tin, copper, and mercury, these fillings are durable and cost-effective but more noticeable.'
                },
                {
                  name: 'Glass Ionomer',
                  description: 'Made of acrylic and glass materials that release fluoride, these are often used for fillings below the gumline or in primary teeth.'
                },
                {
                  name: 'Porcelain/Ceramic',
                  description: 'Custom-made in a lab, these tooth-colored fillings are resistant to staining and very durable but more expensive.'
                }
              ],
              aftercare: 'After getting a filling, avoid eating until the numbness wears off to prevent biting your cheek or tongue. You may experience sensitivity to hot and cold for a few days. Maintain good oral hygiene and regular dental check-ups to ensure the longevity of your fillings.'
            },
            {
              name: 'Tooth Extractions',
              description: 'Removal of a tooth that cannot be saved due to decay, infection, or crowding, performed under local anesthesia for patient comfort.',
              whoNeeds: 'Patients with severely decayed or damaged teeth that cannot be restored, impacted wisdom teeth, overcrowded teeth prior to orthodontic treatment, or teeth with severe periodontal disease.',
              benefits: [
                'Eliminates pain from severely damaged or infected teeth',
                'Prevents spread of infection to other teeth and body',
                'Creates space for orthodontic treatment in overcrowded mouths',
                'Removes problematic wisdom teeth that could cause complications'
              ],
              advantages: [
                'Resolves dental problems that cannot be fixed with other treatments',
                'Typically a quick procedure (simple extractions)',
                'Prevents more serious health complications'
              ],
              disadvantages: [
                'Loss of natural tooth structure',
                'May require replacement with implant, bridge, or denture',
                'Healing period required (typically 7-10 days)',
                'Risk of dry socket or infection if aftercare instructions aren\'t followed'
              ],
              procedure: 'After administering local anesthesia, the dentist loosens the tooth with an instrument called an elevator, then uses forceps to remove it. For impacted or complicated extractions, the dentist may need to make an incision in the gum and remove bone around the tooth or section the tooth into pieces for removal.',
              types: [
                {
                  name: 'Simple Extraction',
                  description: 'Removal of a visible tooth that can be grasped with forceps, typically performed under local anesthesia.'
                },
                {
                  name: 'Surgical Extraction',
                  description: 'More complex procedure for teeth that are broken, impacted, or below the gumline, often requiring an incision and removal of bone.'
                },
                {
                  name: 'Wisdom Tooth Extraction',
                  description: 'Removal of third molars, which often become impacted or cause crowding, sometimes performed by oral surgeons.'
                }
              ],
              aftercare: 'After an extraction, bite on gauze to control bleeding, apply ice to reduce swelling, take prescribed pain medications, avoid rinsing or spitting for 24 hours, stick to soft foods, and avoid smoking and using straws. Complete healing typically takes 1-2 weeks.'
            }
          ]
        },
        {
          name: 'Periodontics',
          services: [
            {
              name: 'Scaling and Root Planing',
              description: 'A deep cleaning procedure that removes plaque and tartar from below the gumline and smooths the tooth roots to help gums reattach to teeth, treating gum disease.',
              whoNeeds: 'Patients with gingivitis (early gum disease) or periodontitis (advanced gum disease) showing symptoms like bleeding gums, gum recession, deep periodontal pockets, or bone loss.',
              benefits: [
                'Removes bacteria and toxins that cause gum inflammation',
                'Stops the progression of gum disease',
                'Reduces pocket depth between teeth and gums',
                'Prevents bone loss around teeth',
                'Helps save teeth that might otherwise be lost to gum disease'
              ],
              advantages: [
                'Less invasive than periodontal surgery',
                'Can be effective in controlling early to moderate gum disease',
                'Improves gum health and reduces bad breath'
              ],
              disadvantages: [
                'May cause temporary discomfort and sensitivity',
                'Often requires multiple appointments (typically one quadrant per visit)',
                'May not be sufficient for advanced periodontal disease'
              ],
              procedure: 'After numbing the area with local anesthesia, the dental professional uses specialized instruments to remove plaque and tartar from tooth surfaces below the gumline and within periodontal pockets. The root surfaces are then smoothed (planed) to remove bacterial toxins and help the gums reattach to the teeth.',
              aftercare: 'After scaling and root planing, you may experience sensitivity and minor discomfort for a few days. Follow your dentist\'s instructions for pain management, rinse with warm salt water, maintain excellent oral hygiene, and attend follow-up appointments to monitor healing.'
            },
            {
              name: 'Bacterial Reduction',
              description: 'Treatment aimed at reducing harmful bacteria in the mouth through various techniques and medications to improve oral health and treat gum disease.',
              whoNeeds: 'Patients with active gum disease, recurring infections, compromised immune systems, or before certain dental procedures to reduce the risk of complications.',
              benefits: [
                'Reduces bacterial load that causes gum inflammation and disease',
                'Enhances the effectiveness of other periodontal treatments',
                'Helps control bad breath caused by bacteria',
                'Prevents spread of oral bacteria to other parts of the body',
                'Improves overall oral health'
              ],
              advantages: [
                'Non-invasive treatment option',
                'Can be performed alongside other dental procedures',
                'Helps manage chronic periodontal conditions'
              ],
              disadvantages: [
                'May require repeated applications for maximum effectiveness',
                'Some antimicrobial agents may cause temporary taste alterations',
                'Not a standalone treatment for advanced gum disease'
              ],
              procedure: 'The dentist applies antimicrobial agents directly to the gums and periodontal pockets, either as a rinse, gel, or controlled-release medication. In some cases, laser therapy may be used to target and eliminate bacteria in periodontal pockets.',
              types: [
                {
                  name: 'Antimicrobial Rinses',
                  description: 'Prescription-strength mouth rinses containing chlorhexidine or other antimicrobials used at home or in-office.'
                },
                {
                  name: 'Local Antibiotic Delivery',
                  description: 'Placement of antibiotic gels, fibers, or microspheres directly into periodontal pockets to target bacteria.'
                },
                {
                  name: 'Laser Bacterial Reduction',
                  description: 'Use of specific wavelengths of laser light to eliminate bacteria in periodontal pockets without damaging surrounding tissues.'
                }
              ]
            },
            {
              name: 'Mouth Deteriment',
              description: 'Comprehensive examination and cleaning of the mouth to remove harmful substances and maintain oral hygiene, particularly focusing on areas affected by periodontal disease.',
              whoNeeds: 'Patients with moderate to severe gum disease, heavy plaque and tartar buildup, or those preparing for periodontal surgery or other dental procedures.',
              benefits: [
                'Thoroughly removes plaque, tartar, and bacterial biofilm',
                'Creates a cleaner environment for gum healing',
                'Reduces inflammation and bleeding of gums',
                'Prepares the mouth for other dental treatments',
                'Helps control chronic periodontal conditions'
              ],
              advantages: [
                'More thorough than standard cleaning',
                'Can reach areas that home care cannot address',
                'Improves overall oral health and comfort'
              ],
              disadvantages: [
                'May require longer appointment time',
                'Can cause temporary sensitivity',
                'May need to be repeated periodically for maintenance'
              ],
              procedure: 'The dental professional performs a thorough cleaning of all oral surfaces, including teeth, gums, tongue, and cheeks. This may include scaling to remove tartar, irrigation with antimicrobial solutions, and removal of diseased tissue. The procedure is typically performed under local anesthesia for patient comfort.',
              aftercare: 'After treatment, follow your dentist\'s instructions for oral hygiene, which may include special rinses, more frequent brushing and flossing, and possibly the use of an oral irrigator. Attend all recommended follow-up appointments to monitor healing and prevent recurrence.'
            }
          ]
        },
        {
          name: 'Prosthodontics',
          services: [
            {
              name: 'Dental Crowns',
              description: 'Custom-fitted caps that cover damaged or decayed teeth to restore their shape, size, strength, and appearance.',
              whoNeeds: 'Patients with large cavities that cannot be filled, cracked or weakened teeth, severely worn down teeth, discolored or misshapen teeth, or teeth that have had root canal treatment.',
              benefits: [
                'Restores full function to damaged teeth',
                'Protects weak teeth from breaking',
                'Covers severely discolored or misshapen teeth',
                'Holds dental bridges in place',
                'Provides long-lasting durability (typically 5-15 years)'
              ],
              advantages: [
                'Looks and functions like a natural tooth',
                'Strengthens tooth structure',
                'Can improve appearance of smile'
              ],
              disadvantages: [
                'Requires removal of some natural tooth structure',
                'More expensive than fillings',
                'May cause temporary sensitivity',
                'Eventually needs replacement'
              ],
              procedure: 'The dentist prepares the tooth by removing decay and shaping it to fit the crown. An impression is taken and sent to a dental lab where the crown is custom-made. A temporary crown is placed while the permanent one is being created. In a second appointment, the temporary crown is removed, and the permanent crown is cemented in place.',
              types: [
                {
                  name: 'Porcelain-Fused-to-Metal (PFM)',
                  description: 'Combines the strength of metal with the aesthetics of porcelain, suitable for front and back teeth.'
                },
                {
                  name: 'All-Porcelain or All-Ceramic',
                  description: 'Provides the best natural appearance, ideal for front teeth but can be less durable for molars.'
                },
                {
                  name: 'All-Metal (Gold or Silver Alloy)',
                  description: 'Extremely durable and requires less tooth reduction, but more noticeable and typically used for back teeth.'
                },
                {
                  name: 'Zirconia',
                  description: 'Combines strength and aesthetics, resistant to chipping and cracking, suitable for any location in the mouth.'
                }
              ],
              aftercare: 'After getting a crown, avoid sticky or hard foods for 24 hours. Maintain good oral hygiene by brushing and flossing around the crown. Regular dental check-ups are essential to monitor the crown and ensure its longevity.'
            },
            {
              name: 'Dental Bridges',
              description: 'Fixed dental restorations that replace one or more missing teeth by joining an artificial tooth to adjacent teeth or dental implants.',
              whoNeeds: 'Patients with one or more missing teeth who want a fixed (non-removable) replacement option. Ideal candidates have healthy teeth on either side of the gap to support the bridge.',
              benefits: [
                'Restores ability to chew and speak properly',
                'Maintains face shape by preventing bone loss',
                'Prevents remaining teeth from drifting out of position',
                'Distributes bite forces properly',
                'Improves appearance of smile'
              ],
              advantages: [
                'Fixed in place (not removable like dentures)',
                'Looks and functions like natural teeth',
                'Usually completed in just two dental visits',
                'Typically lasts 5-15 years with proper care'
              ],
              disadvantages: [
                'Requires reduction of adjacent healthy teeth (for traditional bridges)',
                'Cannot be placed if adjacent teeth are unhealthy',
                'More expensive than partial dentures',
                'May be difficult to clean under the pontic (artificial tooth)'
              ],
              procedure: 'The dentist prepares the adjacent teeth (abutments) by removing a portion of enamel. Impressions are taken and sent to a dental lab to create the custom bridge. A temporary bridge is placed while the permanent one is being made. In a second appointment, the temporary bridge is removed, and the permanent bridge is cemented in place.',
              types: [
                {
                  name: 'Traditional Bridge',
                  description: 'Most common type, consists of one or more artificial teeth held in place by dental crowns cemented to the adjacent teeth.'
                },
                {
                  name: 'Cantilever Bridge',
                  description: 'Used when there are healthy teeth on only one side of the gap, with the artificial tooth anchored by one or more crowns on one side.'
                },
                {
                  name: 'Maryland Bridge',
                  description: 'Conservative option that uses metal or porcelain wings bonded to the backs of adjacent teeth, requiring minimal tooth preparation.'
                },
                {
                  name: 'Implant-Supported Bridge',
                  description: 'Anchored by dental implants rather than natural teeth, providing superior stability without affecting adjacent healthy teeth.'
                }
              ],
              aftercare: 'After getting a bridge, maintain excellent oral hygiene by brushing twice daily and flossing carefully around and under the bridge using floss threaders or water flossers. Avoid chewing hard foods with the bridge, and attend regular dental check-ups to ensure its longevity.'
            },
            {
              name: 'Dentures',
              description: 'Removable replacements for missing teeth and surrounding tissues that can be complete or partial depending on how many teeth are missing.',
              whoNeeds: 'Patients who have lost multiple teeth or all teeth due to decay, gum disease, or injury. Dentures are particularly beneficial for those who cannot undergo implant surgery or prefer a less invasive, more affordable option.',
              benefits: [
                'Restores ability to eat and speak',
                'Supports facial muscles to prevent sagging',
                'Improves appearance and self-confidence',
                'Can be removed for cleaning and while sleeping',
                'More affordable than implants or fixed bridges'
              ],
              advantages: [
                'Non-invasive solution requiring no surgery',
                'Can replace many teeth at once',
                'Easily repaired or adjusted if damaged',
                'Can be relined as jaw shape changes over time'
              ],
              disadvantages: [
                'Less stable than fixed options like implants',
                'May affect taste and speech initially',
                'Requires adjustment period',
                'Needs to be removed and cleaned daily',
                'May cause sore spots or discomfort until properly adjusted'
              ],
              procedure: 'The process begins with taking impressions of your mouth. For complete dentures, any remaining teeth are extracted and the gums are allowed to heal before final impressions. The dentist creates wax models to check fit and appearance before the final dentures are fabricated. Multiple appointments are typically needed for adjustments to ensure proper fit and comfort.',
              types: [
                {
                  name: 'Complete Dentures',
                  description: 'Replace all teeth in the upper or lower jaw, resting directly on the gums.'
                },
                {
                  name: 'Partial Dentures',
                  description: 'Replace some missing teeth while using clasps to attach to remaining natural teeth for support.'
                },
                {
                  name: 'Immediate Dentures',
                  description: 'Placed immediately after tooth extraction, allowing you to have teeth while your gums heal, but requiring relining as gums shrink.'
                },
                {
                  name: 'Implant-Supported Dentures',
                  description: 'Attach to dental implants placed in the jawbone, providing greater stability and preventing bone loss.'
                }
              ],
              aftercare: 'Remove and clean dentures daily using a soft brush and denture cleaner (not regular toothpaste). Soak dentures overnight in a denture solution. Clean your gums, tongue, and palate before reinserting dentures. Visit your dentist regularly for adjustments and to check oral tissues.'
            },
            {
              name: 'Veneers',
              description: 'Thin, custom-made shells designed to cover the front surface of teeth to improve their appearance, made from porcelain or composite resin materials.',
              whoNeeds: 'Patients with discolored teeth resistant to whitening, chipped or worn teeth, misaligned or irregularly shaped teeth, gaps between teeth, or those seeking a cosmetic improvement to their smile.',
              benefits: [
                'Provides a natural-looking, beautiful smile',
                'Resistant to stains (especially porcelain veneers)',
                'Conserves more tooth structure than crowns',
                'Can address multiple cosmetic issues simultaneously',
                'Long-lasting with proper care (10-15 years for porcelain)'
              ],
              advantages: [
                'Minimally invasive compared to crowns',
                'Dramatic improvement in appearance',
                'Color can be selected to brighten teeth',
                'Strong and durable when properly cared for'
              ],
              disadvantages: [
                'Irreversible process as some enamel must be removed',
                'More expensive than bonding or whitening',
                'May cause increased sensitivity initially',
                'Can chip or crack and may need replacement eventually',
                'Not suitable for severely damaged teeth or those with significant decay'
              ],
              procedure: 'The dentist removes a small amount of enamel from the front of the teeth (about 0.5mm). An impression is taken and sent to a dental lab where custom veneers are created. Temporary veneers may be placed while waiting. In a second appointment, the teeth are cleaned, etched, and the veneers are bonded using special cement activated by a curing light.',
              types: [
                {
                  name: 'Porcelain Veneers',
                  description: 'Custom-made in a lab, these are more stain-resistant and natural-looking but more expensive and require more tooth preparation.'
                },
                {
                  name: 'Composite Resin Veneers',
                  description: 'Applied directly to teeth in one visit, less expensive but less durable and more prone to staining than porcelain.'
                },
                {
                  name: 'No-Prep or Minimal-Prep Veneers',
                  description: 'Require little to no removal of tooth enamel, making them reversible in some cases, but may look bulkier than traditional veneers.'
                }
              ],
              aftercare: 'Avoid biting hard objects (like pens or fingernails) and chewing very hard foods with veneered teeth. Wear a nightguard if you grind your teeth. Maintain good oral hygiene and regular dental check-ups to ensure the longevity of your veneers.'
            }
          ]
        },
        {
          name: 'Cosmetic Dentistry',
          services: [
            {
              name: 'Teeth Whitening',
              description: 'Procedure to lighten teeth and remove stains and discoloration, resulting in a brighter smile.',
              whoNeeds: 'Patients with teeth stained from food, drinks, smoking, aging, or medications. Ideal candidates have healthy teeth without restorations on front teeth, as whitening doesn\'t affect crowns, fillings, or veneers.',
              benefits: [
                'Enhances smile appearance quickly',
                'Boosts self-confidence',
                'Removes years of stains and discoloration',
                'Non-invasive procedure with no structural changes to teeth',
                'Can be performed in-office or at home'
              ],
              advantages: [
                'Quick results (especially with in-office treatments)',
                'Relatively affordable cosmetic procedure',
                'Customizable levels of whitening',
                'No recovery time needed'
              ],
              disadvantages: [
                'May cause temporary tooth sensitivity',
                'Results are not permanent and require maintenance',
                'Not effective on all types of discoloration',
                'Doesn\'t work on dental restorations (crowns, fillings, etc.)'
              ],
              procedure: 'For in-office whitening, the dentist applies a protective gel to gums and a hydrogen peroxide-based whitening agent to teeth, often activated with a special light. The process takes about 60-90 minutes. For at-home whitening, custom trays are created, and you apply a lower-concentration whitening gel for a specified period each day over 1-2 weeks.',
            },
            {
              name: 'Cosmetic Bonding',
              description: 'Procedure that uses tooth-colored composite resin to repair chipped, cracked, or discolored teeth, close gaps, or change the shape of teeth.',
              whoNeeds: 'Patients with minor cosmetic dental issues like small chips, gaps between teeth, slightly misshapen teeth, or discoloration that doesn\'t respond to whitening. Ideal for those seeking affordable cosmetic improvements.',
              benefits: [
                'Improves appearance of teeth with minimal intervention',
                'Preserves most of the natural tooth structure',
                'Can be completed in a single visit',
                'Less expensive than veneers or crowns',
                'Reversible procedure that doesn\'t permanently alter teeth'
              ],
              advantages: [
                'No anesthesia usually required',
                'Quick procedure (30-60 minutes per tooth)',
                'Can be repaired easily if damaged',
                'Natural-looking results'
              ],
              disadvantages: [
                'Not as durable as veneers or crowns (typically lasts 3-7 years)',
                'May stain over time',
                'Not suitable for extensive damage or decay',
                'May chip or break with excessive force'
              ],
              procedure: 'The dentist selects a composite resin color that matches your natural teeth. The tooth surface is lightly etched and coated with a conditioning liquid to help the bonding material adhere. The putty-like resin is applied, molded, and smoothed to the desired shape. A special light hardens the material, which is then trimmed, shaped, and polished to match surrounding teeth.',
              aftercare: 'Avoid biting hard foods or objects with bonded teeth. Maintain good oral hygiene and avoid staining substances like coffee, tea, and tobacco. Regular dental check-ups will help monitor the condition of the bonding material.'
            }
          ]
        },
        {
          name: 'Orthodontics',
          services: [
            {
              name: 'Braces',
              description: 'Dental appliances used to align and straighten teeth and help position them with regard to a person\'s bite.',
              whoNeeds: 'Patients with crooked teeth, overcrowded teeth, gaps between teeth, or bite problems (overbite, underbite, crossbite, open bite). While often associated with children and teenagers, adults can also benefit from braces.',
              benefits: [
                'Aligns teeth for improved appearance',
                'Corrects bite issues that can cause jaw pain or TMJ disorders',
                'Makes teeth easier to clean, reducing risk of decay and gum disease',
                'Improves speech problems caused by misaligned teeth',
                'Provides long-lasting, permanent results'
              ],
              advantages: [
                'Effective for complex alignment and bite issues',
                'Works continuously (24/7) to move teeth',
                'Various options available to suit aesthetic preferences',
                'Predictable results under professional supervision'
              ],
              disadvantages: [
                'More visible than clear aligners (traditional metal braces)',
                'Requires dietary restrictions (avoiding hard, sticky foods)',
                'More challenging to clean around brackets and wires',
                'May cause discomfort, especially after adjustments',
                'Treatment typically takes 18-24 months'
              ],
              procedure: 'The orthodontist bonds brackets to the teeth and connects them with wires that apply gentle pressure to move teeth into position. Regular adjustments (typically every 4-8 weeks) tighten the wires to continue the alignment process. After braces are removed, retainers are worn to maintain the new position of the teeth.',
              types: [
                {
                  name: 'Traditional Metal Braces',
                  description: 'Stainless steel brackets and wires, the most common and economical option.'
                },
                {
                  name: 'Ceramic Braces',
                  description: 'Function like metal braces but use clear or tooth-colored brackets for a less noticeable appearance.'
                },
                {
                  name: 'Lingual Braces',
                  description: 'Attached to the back (tongue side) of teeth, making them invisible from the front but more difficult to clean.'
                },
                {
                  name: 'Self-Ligating Braces',
                  description: 'Use a specialized clip instead of elastic bands to hold the wire, potentially reducing appointment time and discomfort.'
                }
              ],
              aftercare: 'Brush and floss carefully around brackets and wires. Use special tools like interdental brushes or water flossers if needed. Avoid hard, sticky, and chewy foods that could damage braces. Wear a mouthguard during sports. Attend all adjustment appointments. After braces are removed, wear retainers as directed to maintain results.'
            },
            {
              name: 'Clear Aligners',
              description: 'Transparent, plastic form of dental braces used to adjust teeth, offering a nearly invisible alternative to traditional metal braces.',
              whoNeeds: 'Patients with mild to moderate orthodontic issues who prefer a less visible treatment option. Ideal candidates have good oral hygiene and the discipline to wear aligners 20-22 hours per day.',
              benefits: [
                'Nearly invisible appearance',
                'Removable for eating, drinking, and cleaning',
                'No food restrictions',
                'Easier to maintain oral hygiene than with traditional braces',
                'Often more comfortable than metal braces'
              ],
              advantages: [
                'Aesthetically pleasing option for adults and teens',
                'Fewer office visits (typically every 6-8 weeks)',
                'No emergency visits for broken brackets or wires',
                'Digital planning allows visualization of expected results'
              ],
              disadvantages: [
                'Not as effective for complex orthodontic issues',
                'Requires strict compliance (20-22 hours of wear daily)',
                'May cause slight speech impediment initially',
                'More expensive than traditional braces in some cases',
                'Can be lost or damaged if not properly stored when removed'
              ],
              procedure: 'The orthodontist takes digital scans or impressions of your teeth to create a 3D model. A series of custom aligners is created, each making slight adjustments to tooth position. You wear each set of aligners for 1-2 weeks before progressing to the next set. Regular check-ups ensure treatment is progressing as planned.',
              types: [
                {
                  name: 'Full Treatment Clear Aligners',
                  description: 'Complete series of aligners designed to address comprehensive orthodontic issues, typically taking 12-18 months.'
                },
                {
                  name: 'Express or Lite Treatment',
                  description: 'Shorter series of aligners for minor corrections, often completed in 6 months or less.'
                },
                {
                  name: 'Hybrid Treatment',
                  description: 'Combines clear aligners with traditional braces for certain phases of treatment to address complex issues.'
                }
              ],
              aftercare: 'Clean aligners daily with a soft toothbrush and clear soap (not toothpaste, which can scratch them). Remove aligners when eating or drinking anything besides water. Brush and floss before reinserting aligners. Wear retainers as directed after treatment is complete.'
            },
            {
              name: 'Retainers',
              description: 'Custom-made devices that hold teeth in their new positions after orthodontic treatment, preventing them from shifting back to their original positions.',
              whoNeeds: 'Anyone who has completed orthodontic treatment with braces or clear aligners. Retainers are essential for maintaining the results of orthodontic treatment long-term.',
              benefits: [
                'Maintains the results of orthodontic treatment',
                'Prevents teeth from shifting back to previous positions',
                'Allows bone and gums to stabilize around newly positioned teeth',
                'Some types can address minor tooth movement if worn consistently',
                'Less expensive than retreatment if teeth shift back'
              ],
              advantages: [
                'Removable options available for comfort and convenience',
                'Fixed retainers provide continuous protection without relying on patient compliance',
                'Clear retainers are less noticeable than metal options',
                'Can last several years with proper care'
              ],
              disadvantages: [
                'Removable retainers require discipline to wear as directed',
                'Can be lost or damaged if not properly stored',
                'May affect speech initially',
                'Fixed retainers make flossing more challenging',
                'Eventually need replacement (typically every 2-10 years depending on type)'
              ],
              procedure: 'For removable retainers, the orthodontist takes impressions or digital scans of your teeth after braces are removed. Custom retainers are created to fit your newly aligned teeth. For fixed retainers, a thin wire is bonded to the back of the front teeth. The orthodontist will provide specific instructions on how long to wear your retainer (typically full-time initially, then nights only).',
              types: [
                {
                  name: 'Hawley Retainers',
                  description: 'Traditional removable retainers with a plastic base and metal wire that wraps around teeth, adjustable and durable.'
                },
                {
                  name: 'Clear Plastic Retainers',
                  description: 'Transparent, custom-molded trays that fit over the entire arch of teeth, less visible but may wear out faster.'
                },
                {
                  name: 'Fixed/Bonded Retainers',
                  description: 'Thin metal wires permanently attached to the back of front teeth, providing continuous retention without relying on patient compliance.'
                }
              ],
              aftercare: 'For removable retainers, clean them daily with a soft toothbrush and mild soap or retainer cleaner. Store in a protective case when not in use. Avoid hot water, which can warp plastic retainers. For fixed retainers, use floss threaders or water flossers to clean underneath the wire. Attend regular dental check-ups to ensure retainers are functioning properly.'
            }
          ]
        },
        {
          name: 'Endodontics',
          services: [
            {
              name: 'Root Canal',
              description: 'Treatment to repair and save a badly damaged or infected tooth instead of removing it, by removing the infected pulp, cleaning the canals, and sealing them.',
              whoNeeds: 'Patients with severe tooth decay reaching the pulp, cracked or broken teeth exposing the pulp, repeated dental procedures on a tooth, or symptoms of pulp infection or inflammation (severe pain, prolonged sensitivity, swelling, or abscess).',
              benefits: [
                'Saves natural tooth from extraction',
                'Eliminates infection and prevents its spread',
                'Relieves pain from infected or inflamed pulp',
                'Restores normal biting force and sensation',
                'Maintains natural appearance'
              ],
              advantages: [
                'High success rate (over 95% when properly performed)',
                'Usually completed in 1-2 appointments',
                'Less expensive than tooth replacement options',
                'Prevents jawbone deterioration that occurs after tooth loss'
              ],
              disadvantages: [
                'Treated teeth may become more brittle over time',
                'Usually requires a crown after treatment for protection',
                'May cause temporary discomfort during recovery',
                'Small risk of failure requiring retreatment or extraction'
              ],
              procedure: 'After numbing the area, the endodontist creates an opening in the crown of the tooth to access the pulp chamber. The infected or inflamed pulp is removed, and the canals are cleaned, shaped, and disinfected. The space is filled with a rubber-like material called gutta-percha and sealed with adhesive cement. A temporary or permanent filling is placed, and often a crown is recommended to protect the tooth.',
              aftercare: 'You may experience mild discomfort for a few days after treatment, manageable with over-the-counter pain medications. Avoid chewing on the treated tooth until restoration is complete. Maintain good oral hygiene and regular dental check-ups. Complete any recommended restorative work (such as a crown) to protect the treated tooth.'
            },
            {
              name: 'Endodontic Retreatment',
              description: 'Procedure to treat a tooth that has already had root canal therapy but is experiencing new problems, by removing the previous filling material, cleaning the canals again, and placing new filling material.',
              whoNeeds: 'Patients who have had a previous root canal that has failed to heal properly or has developed new problems. Signs include pain, swelling, or infection months or years after the initial treatment.',
              benefits: [
                'Gives a second chance to save the natural tooth',
                'Addresses complications from previous treatment',
                'Treats new infections or inflammation',
                'Prevents need for extraction and replacement',
                'Relieves pain and discomfort'
              ],
              advantages: [
                'Less invasive than extraction and implant placement',
                'Preserves natural tooth structure and function',
                'High success rate when performed by specialists',
                'More cost-effective than replacement options'
              ],
              disadvantages: [
                'More complex than initial root canal treatment',
                'May require multiple appointments',
                'Higher cost than initial treatment',
                'May not be successful in all cases'
              ],
              procedure: 'The endodontist reopens the tooth and removes the previous filling material. Using specialized equipment, they clean the canals and carefully examine for additional canals, cracks, or unusual anatomy that might have been missed in the first procedure. After cleaning and disinfecting, the canals are refilled and sealed, and a new restoration is placed.',
              aftercare: 'Follow post-treatment instructions carefully, including taking any prescribed antibiotics. Avoid chewing on the treated tooth until the final restoration is placed. Maintain excellent oral hygiene and attend all follow-up appointments to monitor healing.'
            }
          ]
        },
        {
          name: 'Maxillofacial Surgery',
          services: [
            {
              name: 'Wisdom Teeth Extraction',
              description: 'Surgical removal of third molars (wisdom teeth) that are impacted, causing pain, or creating potential dental problems.',
              whoNeeds: 'Patients with impacted wisdom teeth, wisdom teeth causing pain or infection, teeth that cannot erupt properly due to lack of space, or as a preventive measure to avoid future complications.',
              benefits: [
                'Prevents pain, infection, and damage to adjacent teeth',
                'Eliminates potential for cysts or tumors to develop around impacted teeth',
                'Prevents crowding and misalignment of other teeth',
                'Reduces risk of gum disease and decay in hard-to-clean areas',
                'Resolves existing symptoms like pain, swelling, or bad breath'
              ],
              advantages: [
                'Often performed as a preventive measure before problems develop',
                'Usually a one-time procedure with permanent results',
                'Can be performed under various levels of sedation for comfort',
                'Recovery is typically straightforward for most patients'
              ],
              disadvantages: [
                'Surgical procedure with associated risks (bleeding, infection, nerve damage)',
                'Recovery period of typically 3-7 days with swelling and discomfort',
                'Potential for dry socket (painful healing complication)',
                'Cost may not be fully covered by insurance if extraction is preventive'
              ],
              procedure: 'After administering appropriate anesthesia (local, sedation, or general), the oral surgeon makes an incision in the gum tissue to expose the tooth and bone. Any bone blocking access to the tooth root is removed. The tooth may be divided into sections for easier removal. The site is cleaned of debris, and the wound is closed with stitches if necessary. Gauze is placed over the extraction site to control bleeding and aid clot formation.',
              aftercare: 'Follow the surgeon\'s instructions carefully. Apply ice packs to reduce swelling, take prescribed pain medications, avoid rinsing or spitting forcefully for 24 hours, eat soft foods, and keep the extraction sites clean. Avoid smoking, using straws, or vigorous physical activity during the initial healing period.'
            },
            {
              name: 'Dental Implants Placement',
              description: 'Surgical procedure to replace missing teeth by placing titanium posts in the jawbone that serve as artificial tooth roots to support replacement teeth.',
              whoNeeds: 'Patients with one or more missing teeth who have adequate bone density and good overall health. Ideal candidates have healthy gums, are non-smokers, and are committed to excellent oral hygiene and regular dental visits.',
              benefits: [
                'Provides the most natural-looking and functioning tooth replacement',
                'Preserves jawbone by preventing bone loss',
                'Doesn\'t require altering adjacent healthy teeth',
                'Extremely durable and can last a lifetime with proper care',
                'Restores full chewing ability and speech'
              ],
              advantages: [
                'Success rate of over 95% in healthy individuals',
                'Feels and functions like natural teeth',
                'Prevents the sunken facial appearance associated with tooth loss',
                'No risk of cavities in the implant itself'
              ],
              disadvantages: [
                'More expensive initial investment than other tooth replacement options',
                'Requires surgery and healing time (3-6 months for complete integration)',
                'Not suitable for patients with certain medical conditions or insufficient bone',
                'Requires meticulous oral hygiene to prevent peri-implantitis (implant gum disease)'
              ],
              procedure: 'The procedure typically involves multiple stages: First, the damaged tooth is removed if still present. Bone grafting may be necessary if bone density is insufficient. After healing, the implant post is surgically placed in the jawbone. A healing period of 3-6 months allows the implant to integrate with the bone (osseointegration). Then, an abutment is attached to the implant, and finally, a custom crown is placed on the abutment.',
              types: [
                {
                  name: 'Endosteal Implants',
                  description: 'Most common type, placed directly into the jawbone, typically shaped like small screws, cylinders, or plates.'
                },
                {
                  name: 'Subperiosteal Implants',
                  description: 'Placed under the gum but on or above the jawbone, used for patients who don\'t have enough healthy jawbone and cannot or do not want to undergo bone augmentation.'
                }
              ],
              aftercare: 'After implant surgery, follow all post-operative instructions carefully. Take prescribed antibiotics and pain medications as directed. Apply ice to reduce swelling. Eat soft foods and avoid chewing on the implant site. Maintain excellent oral hygiene but clean gently around the surgical area. Attend all follow-up appointments to monitor healing.'
            },
            { 
              name: 'Temporomandibular Joint (TMJ) Treatment',
              description: 'Diagnosis and treatment of disorders affecting the temporomandibular joint (TMJ), which connects the jawbone to the skull and allows movement for talking, chewing, and yawning.',
              whoNeeds: 'Patients experiencing jaw pain, clicking or popping sounds when opening or closing the mouth, limited jaw movement, facial pain, headaches, earaches, or difficulty chewing. TMJ disorders can result from injury, arthritis, teeth grinding, or stress.',
              benefits: [
                'Relieves pain and discomfort in the jaw and surrounding areas',
                'Improves jaw function and range of motion',
                'Reduces headaches and facial pain associated with TMJ disorders',
                'Prevents further damage to the joint and teeth',
                'Improves quality of life and daily functioning'
              ],
              advantages: [
                'Many TMJ treatments are non-surgical and reversible',
                'Customized approach based on individual symptoms and causes',
                'Can address both symptoms and underlying causes',
                'Often combines multiple therapeutic approaches for best results'
              ],
              disadvantages: [
                'May require long-term management rather than a permanent cure',
                'Surgical interventions carry risks and longer recovery periods',
                'Some treatments require consistent patient compliance',
                'Insurance coverage for TMJ treatments varies widely'
              ],
              procedure: 'Treatment begins with a comprehensive evaluation including medical history, physical examination, and possibly imaging studies (X-rays, CT scans, or MRIs). Treatment approaches range from conservative (self-care, physical therapy, medications, oral appliances) to minimally invasive procedures (injections, arthrocentesis) to surgery for severe cases that don\'t respond to other treatments.',
              types: [
                {
                  name: 'Conservative Treatments',
                  description: 'Non-invasive approaches including oral splints/night guards, physical therapy, medications, and lifestyle modifications to reduce jaw strain.'
                },
                {
                  name: 'Minimally Invasive Procedures',
                  description: 'Includes corticosteroid injections, botulinum toxin injections, or arthrocentesis (joint washing) to reduce inflammation and improve function.'
                },
                {
                  name: 'Surgical Interventions',
                  description: 'For severe cases, may include arthroscopy, open joint surgery, or joint replacement to repair or reconstruct the damaged joint.'
                }
              ],
              aftercare: 'Follow your provider\'s recommendations for jaw exercises, stress management, and avoiding hard or chewy foods. Use heat or ice as directed for pain relief. Wear any prescribed oral appliances consistently. Attend all follow-up appointments to monitor progress and adjust treatment as needed.'
            }
          ]
        }
      ]
    };
  },
  mounted() {
    // Set the first service as active by default
    if (this.categories[0].services.length > 0) {
      this.activeService = this.categories[0].services[0];
    }
    window.addEventListener('scroll', this.handleScroll);
    
    // Load Font Awesome dynamically
    this.loadFontAwesome();
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
    },
    setActiveCategory(index) {
      this.activeCategory = index;
      // Reset active service to the first one in the new category
      if (this.categories[index].services.length > 0) {
        this.activeService = this.categories[index].services[0];
      } else {
        this.activeService = null;
      }
    },
    setActiveService(service) {
      this.activeService = service;
    },
    scrollTabs(direction) {
      const scrollAmount = 300; // Increased scroll amount
      if (direction === 'left') {
        this.$refs.tabsList.scrollLeft -= scrollAmount;
      } else {
        this.$refs.tabsList.scrollLeft += scrollAmount;
      }
    },
    scrollServices(direction) {
      const scrollAmount = 300; // Increased scroll amount
      if (direction === 'left') {
        this.$refs.servicesRow.scrollLeft -= scrollAmount;
      } else {
        this.$refs.servicesRow.scrollLeft += scrollAmount;
      }
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

/* Services container styles */
.services-container {
  max-width: 1400px;
  margin: 60px auto;
  padding: 0 30px;
}

.services-title {
  text-align: center;
  font-size: 42px;
  font-weight: bold;
  margin-bottom: 50px;
  color: #000000;
}

/* Main tabs styling */
.tabs-container {
  position: relative;
  background: #f5f5f5;
  border-radius: 12px;
  padding: 15px;
  margin-bottom: 50px;
}

.tab-navigation {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 15px;
}

.nav-arrow {
  background: none;
  border: none;
  font-size: 32px;
  cursor: pointer;
  color: #333;
  padding: 0 15px;
  transition: all 0.3s ease;
}

.nav-arrow:hover {
  color: #006837;
}

.tabs-list {
  display: flex;
  gap: 15px;
  flex: 1;
  overflow-x: auto;
  scrollbar-width: none;
  -ms-overflow-style: none;
  scroll-behavior: smooth;
  padding: 5px 0;
}

.tabs-list::-webkit-scrollbar {
  display: none;
}

.tab-button {
  padding: 15px 30px;
  border: none;
  background: none;
  cursor: pointer;
  font-size: 18px;
  white-space: nowrap;
  border-radius: 6px;
  transition: all 0.3s ease;
  font-weight: 500;
}

.tab-button.active {
  background: #006837;
  color: white;
  font-weight: bold;
}

.tab-button:hover:not(.active) {
  background: #e0e0e0;
}

/* Services grid styling */
.services-grid {
  position: relative;
  padding: 30px 60px;
}

.left-arrow, .right-arrow {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  z-index: 10;
  font-size: 32px;
  background: rgba(255, 255, 255, 0.8);
  border-radius: 50%;
  width: 50px;
  height: 50px;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.left-arrow {
  left: 10px;
}

.right-arrow {
  right: 10px;
}

.services-row {
  display: flex;
  gap: 30px;
  overflow-x: auto;
  scrollbar-width: none;
  -ms-overflow-style: none;
  scroll-behavior: smooth;
  padding: 10px 0;
}

.services-row::-webkit-scrollbar {
  display: none;
}

.service-item {
  min-width: 220px;
  text-align: center;
  cursor: pointer;
  padding: 30px;
  background: #f8f8f8;
  border-radius: 12px;
  transition: all 0.3s ease;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.01);
}

.service-item:hover {
  background: #e8e8e8;
  transform: translateY(-5px);
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.service-icon {
  width: 90px;
  height: 90px;
  margin: 0 auto 20px;
  background: #006837;
  border-radius: 12px;
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: center;
}

.service-icon img {
  width: 70%;
  height: 70%;
  object-fit: contain;
  filter: brightness(0) invert(1);
}

.service-name {
  font-size: 18px;
  line-height: 1.4;
  font-weight: 500;
  margin-top: 10px;
}

/* Service content styling */
.service-content {
  padding: 40px;
  background: #f8f8f8;
  border-radius: 12px;
  margin-top: 30px;
  display: none;
  box-shadow: 0 3px 15px rgba(0, 0, 0, 0.01);
}

.service-content.active {
  display: block;
}

.service-content h2 {
  color: #006837;
  margin-bottom: 20px;
  font-size: 28px;
}

.service-content h3 {
  color: #006837;
  margin: 25px 0 15px;
  font-size: 22px;
}

.service-content h4 {
  font-size: 18px;
  margin: 15px 0 10px;
  color: #333;
}

.service-content p {
  line-height: 1.8;
  color: #333;
  font-size: 16px;
  margin-bottom: 15px;
}

.service-section {
  margin-top: 25px;
}

.service-section ul {
  padding-left: 20px;
  margin-bottom: 20px;
}

.service-section li {
  margin-bottom: 10px;
  line-height: 1.6;
}

.service-type {
  background: #f0f0f0;
  padding: 15px;
  border-radius: 8px;
  margin-bottom: 15px;
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
  .services-title {
    font-size: 36px;
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

  /* Services */
  .services-container {
    padding: 0 15px;
  }

  .services-title {
    font-size: 32px;
  }

  .services-grid {
    padding: 20px 40px;
  }

  .services-row {
    gap: 15px;
  }

  .service-item {
    min-width: 180px;
    padding: 20px;
  }

  .service-icon {
    width: 70px;
    height: 70px;
  }

  .service-name {
    font-size: 16px;
  }

  .service-content {
    padding: 25px;
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

  .services-title {
    font-size: 28px;
  }

  .services-grid {
    padding: 15px 20px;
  }

  .service-item {
    min-width: 160px;
    padding: 15px;
  }

  .service-icon {
    width: 60px;
    height: 60px;
  }

  .service-name {
    font-size: 14px;
  }

  .service-content {
    padding: 20px;
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
