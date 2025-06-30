<template>
  <nav>
    <a href=""><img src="@/components/Images/ATDC_logo.png" alt=""></a>
    <div class="nav-links" :style="{ right: isMenuOpen ? '0' : '-200px' }">
      <i class="fa fa-times" @click="hideMenu"></i>
      <ul>
        <!-- <a href="/signup">SignUp</a> -->
        <li><a href="/">Home</a></li>
        <li><a href="/about">About Us</a></li>
        <li><a href="/services">Services</a></li>
        <li><a href="/smilegallery">Smile Gallery</a></li>
        <li><a href="/announcements">Announcements</a></li>
        <li><a href="/faqs">FAQs</a></li>
        <li><a href="/contact">Contact Us</a></li>
        <a href="/login"> <button>Log In</button></a>
      </ul>
    </div>
    <i class="fa fa-bars" @click="showMenu"></i>
  </nav>

  <a href=""><img src="@/components/Images/Go to top.png" alt="" class="gtp"></a>
  
  <section class="top-header">
    <h1>ANNOUNCEMENTS</h1>
  </section>

  <!-- 2 line announcement -->
  <section class="next-line">
    <div class="row">
      <div class="two-announcement-col">
        <img src="@/components/Images/Rectangle_2.png" alt="" class="announcement-img">
        <div class="inline">
          <img src="@/components/Images/Announcement.png" alt="">
          <h3>Lorem ipsum dolor sit amet, consectetuer adipiscing elit</h3>
        </div>
        <div class="edited-note-col">
          <div class="row">
            <div class="note">
              <i class="fa fa-edit"></i> &nbsp;&nbsp;<p>Nov 1, 2024 10:05 P.M.</p>
            </div>

            <div class="note">
              <i class="fa fa-user"></i> &nbsp;&nbsp;<p>Owner</p>
            </div>

            <div class="note">
              <i class="fa fa-bullhorn"></i> &nbsp;&nbsp;<p>Promotion</p>
            </div>
          </div>
        </div>
      </div>

      <div class="two-announcement-col">
        <img src="@/components/Images/Rectangle_2.png" alt="" class="announcement-img">
        <div class="inline">
          <img src="@/components/Images/Announcement.png" alt="">
          <h3>Lorem ipsum dolor sit amet, consectetuer adipiscing elit</h3>
        </div>
        <div class="edited-note-col">
          <div class="row">
            <div class="note">
              <i class="fa fa-edit"></i> &nbsp;&nbsp;<p>Nov 1, 2024 10:05 P.M.</p>
            </div>

            <div class="note">
              <i class="fa fa-user"></i> &nbsp;&nbsp;<p>Owner</p>
            </div>

            <div class="note">
              <i class="fa fa-bullhorn"></i> &nbsp;&nbsp;<p>Promotion</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="next-line">
    <div class="row">
      <div class="two-announcement-col">
        <img src="@/components/Images/Rectangle_2.png" alt="" class="announcement-img">
        <div class="inline">
          <img src="@/components/Images/Announcement.png" alt="">
          <h3>Lorem ipsum dolor sit amet, consectetuer adipiscing elit</h3>
        </div>
        <div class="edited-note-col">
          <div class="row">
            <div class="note">
              <i class="fa fa-edit"></i> &nbsp;&nbsp;<p>Nov 1, 2024 10:05 P.M.</p>
            </div>

            <div class="note">
              <i class="fa fa-user"></i> &nbsp;&nbsp;<p>Owner</p>
            </div>

            <div class="note">
              <i class="fa fa-bullhorn"></i> &nbsp;&nbsp;<p>Promotion</p>
            </div>
          </div>
        </div>
      </div>

      <div class="two-announcement-col">
        <img src="@/components/Images/Rectangle_2.png" alt="" class="announcement-img">
        <div class="inline">
          <img src="@/components/Images/Announcement.png" alt="">
          <h3>Lorem ipsum dolor sit amet, consectetuer adipiscing elit</h3>
        </div>
        <div class="edited-note-col">
          <div class="row">
            <div class="note">
              <i class="fa fa-edit"></i> &nbsp;&nbsp;<p>Nov 1, 2024 10:05 P.M.</p>
            </div>

            <div class="note">
              <i class="fa fa-user"></i> &nbsp;&nbsp;<p>Owner</p>
            </div>

            <div class="note">
              <i class="fa fa-bullhorn"></i> &nbsp;&nbsp;<p>Promotion</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- 1-line-announcment -->
   <section class="next-line1">
    <div class="one-announcement-col">
      <img src="@/components/Images/Rectangle_3.png" alt="" class="announcement-img">
      <div class="inline-one">
        <img src="@/components/Images/Announcement.png" alt="">
        <h3>Lorem ipsum dolor sit amet, consectetuer adipiscing elit!</h3>
      </div>
        <div class="edited-one-note-col">
          <div class="row">
            <div class="note">
              <i class="fa fa-user"></i> &nbsp;&nbsp;<p>Nov 1, 2024 10:05 P.M.</p>
            </div>

            <div class="note">
              <i class="fa fa-user"></i> &nbsp;&nbsp;<p>Owner</p>
            </div>

            <div class="note">
              <i class="fa fa-bullhorn"></i> &nbsp;&nbsp;<p>Promotion</p>
           </div>
        </div>
      </div>
    <p class="paragraph">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.  Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.  Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. </p>

    <p class="paragraph">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.  Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. </p>

    <div class="links">
      <a href="#"><i class="fab fa-facebook-square"></i> &nbsp; &nbsp;FACEBOOK POST LINK: https://www.facebook.com/share/p/1DMqGH8edu/</a>
      <br>
      <a href="#"><i class="fab fa-instagram"></i> &nbsp; &nbsp;INSTAGRAM POST LINK: https://www.instagram.com/share/p/1DMqGH8edu/</a>
    </div>
    </div>
   </section>

   <section>
  <div class="footer-clean">
    <footer>
      <div class="footer-row">
        <!-- Logo & Clinic Info -->
        <div class="col-for-footer-1">
          <div class="logo-container">
            <img src="@/components/Images/ATDC_logo.png" alt="Aguila-Titular Dental Clinic Logo">
            <div class="logo-three">
            <img src="@/components/Images/ATDC_Logo3.png" alt="Aguila-Titular Dental Clinic Logo">
          </div>
          </div>
          <div class="location-info">
            <div><i class="fa-solid fa-map-location"></i> 203-205 J&F Building 1, Marcos Highway, Barangay Mayamot, Antipolo, Philippines</div>
            <div><i class="fa-solid fa-envelope"></i> aguilatitular.dental@gmail.com</div>
            <div class="icon-phone"><i class="fa-solid fa-phone"></i> +63 908 863 0882</div>
          </div>
        </div>

        <!-- Quick Links -->
        <div class="col-for-footer-2 footer-links">
          <p class="footer-title">QUICK LINKS</p>
          <ul>
            <li><a href="#">Home</a></li>
            <li><a href="/about">About Us</a></li>
            <li><a href="/services">Services</a></li>
            <li><a href="/smilegallery">Smile Gallery</a></li>
            <li><a href="/announcements">Announcements</a></li>
            <li><a href="/faqs">FAQs</a></li>
            <li><a href="/contact">Contact Us</a></li>
          </ul>
        </div>

        <!-- Clinic Hours -->
        <div class="col-for-footer-3">
          <p class="footer-title">CLINIC HOURS</p>
          <p>Monday - Sunday</p>
          <p>9:00 AM - 5:00 PM</p>
        </div>

        <!-- Payment Methods -->
        <div class="col-for-footer-4">
          <p class="footer-title">WE ACCEPT</p>
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
        <div class="col-for-footer-5">
          <p class="footer-title">FOLLOW US</p>
          <div class="social-icons">
            <a target="_blank" href="https://www.facebook.com/aguilatitulardental"><i class="fab fa-facebook"></i></a>
            <a  target="_blank" href="https://www.instagram.com/aguilatitulardent/"><i class="fab fa-instagram"></i></a>
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
name: "Announcements",
data() {
  return {
    isMenuOpen: false 
  };
},
methods: {
  showMenu() {
    this.isMenuOpen = true; 
  },
  hideMenu() {
    this.isMenuOpen = false; 
  }
}
};
</script>

<style scoped>
* {
  margin: 0 auto;
  padding: 0 auto;
}
/* top header */
.top-header {
  width: 100%;
  margin: auto;
  text-align: center;
  padding-top: 100px;
}

.top-header h1 {
  font-size: 45px;
  font-weight: 600;
  margin-top: -10px;
}

/* two-announcement-col */
.row {
  margin-top: 5%;
  display: flex;
  justify-content: space-between;
}

.inline {
  display: flex;
  width: 90%;
  margin-top: 20px;
  margin-left: -5px;
}

.next-line {
  width: 90%;
  margin: auto;
  text-align: center;
  margin-top: -20px;
}

.two-announcement-col {
  flex-basis: 49%; 
  border-radius: 10px;
  padding: 20px 12px;
  box-sizing: border-box;
  transition: 0.5s;
  margin-bottom: -3%;
}

.announcement-img {
  box-shadow: 5px 5px rgb(212, 212, 212);
}

.two-announcement-col img {
  width: 100%;
  display: block;
  border-radius: 10px;
}

.inline img {
  width: 15%;
}

.inline h3 {
  text-align: justify;
  margin-left: 10px;
}

.note {
  color: grey;
  font-size: 10pt;
  display: flex;
  margin-top: -5%;
}

.edited-note-col {
  width: 85%;
  margin-left: 50px;
}

/* 1-line-announcement */
.next-line1 {
  width: 90%;
  margin-top: 5%;
  text-align: center;
  
}

.next-line1 img {
  border-radius: 10px;
}

.one-announcement-col {
  padding: 20px 12px;
  box-sizing: border-box;
  transition: 0.5s;
}

.one-announcement-col img {
  width: 100%;
  display: block;
  border-radius: 10px;
}

.paragraph {
  font-size: 15px;
  text-align: justify;
  margin-top: 20px;
}

.links {
  font-size: 15px;
  text-align: justify;
  color: grey;
  margin-top: 20px;
}

.links a {
  color: grey;
  text-decoration: none;
}

.inline-one img {
  width: 7%;
}

.inline-one {
  display: flex;
  width: 90%;
  margin-top: 20px;
  margin-left: -220px;
}

.inline-one h3 {
  text-align: justify;
  margin-left: -200px;
}

.edited-one-note-col {
  width: 50%;
  margin-left: 40px;
  margin-top: -2%;
}

.footer-clean {
    background: #F0EDE3;
    padding-top: 30px;
    font-family: 'Arial', sans-serif;
    color: #333;
    font-size: 14px;
}

.footer-row {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    max-width: 1600px;
    margin: 0 auto;
    gap: 100px;
}

.col-for-footer-1,
.col-for-footer-2,
.col-for-footer-3,
.col-for-footer-4,
.col-for-footer-5 {
    flex: 1;
    min-width: 10px;
    text-align: left;
}

.col-for-footer-1 {
    flex: 1.5;
    min-width: 280px;
    text-align: left;
    margin-right: 30px;
}

.logo-container {
    display: flex;
    align-items: center;
    gap: 5px !important;
}

.logo-three img {
    width: 180px !important;
    height: auto;
}

.logo-container img {
    width: 70px;
    height: auto;
}

.clinic-name {
    font-size: 30px;
    font-weight: bold;
    line-height: 100%;
    color: #333;
    font-family: 'Poppins', sans-serif;
    white-space: nowrap;
}

.location-info {
    font-size: 18px;
    line-height: 1.6;
    max-width: 350px;
    display: flex;
    flex-direction: column;
    gap: 25px;
    text-align: left;
    margin-left: 30px;
    margin-top: 15px;
    margin-bottom: 35px;
}

.location-info div {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 30px;
}

.location-info i {
    font-size: 20px;
    color: #7e685a;
    min-width: 20px;
    text-align: right;
}

.icon-phone {
  margin-left: 0px;
}

.logo-container {
    display: flex;
    align-items: center;
    gap: 15px;
}

.logo-container img {
    width: 80px;
    height: auto;
}

.footer-title {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 10px;
    margin-left: 0px;
}

.footer-links ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-links ul li {
    margin-bottom: 6px;
    margin-left: 10px;
}

.footer-links ul li a {
    text-decoration: none;
    color: #333;
    transition: 0.3s;
    font-size: 18px;
    
}

.footer-links ul li a:hover {
    color: #7e685a;
    text-decoration: underline;
}

.col-for-footer-3 p, .col-for-footer-4 p {
    font-size: 18px !important;
}

.payment-icons {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 5px;
    margin-top: 15px;
}

.payment-icons img {
    width: 60px;
    height: 40px;
    object-fit: contain;
    margin-left: 5px;
}

.social-icons a {
    font-size: 35px;
    color: #333;
    margin-right: 10px;
    transition: 0.3s;
    margin-left: 15px;
}

.social-icons a:hover {
    color: #7e685a;
}

.footer-bottom, .footer-bottom p {
    padding: 12px 50px;
    background: #E0DACD;
    font-size: 18px !important;
}


</style>
