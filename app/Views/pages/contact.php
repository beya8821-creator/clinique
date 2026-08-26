<?php
declare(strict_types=1);

$currentPage = 'contact';
$headerLogoHtml = <<<HTML
<!-- Uncomment the line below if you also wish to use an image logo -->
          <img src="assets/img/logos.webp" alt=""> 
          <h1 class="sitename">Polyclinique Yetu</h1>
HTML;

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>contact</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/logos.webp" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap"
    rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Polyclinique Yetu
  * Template URL: https://bootstrapmade.com/Polyclinique Yetu-bootstrap-template/
  * Updated: Jul 23 2025 with Bootstrap v5.3.7
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>
<body class="contact-page">
<?php include dirname(__DIR__, 3) . '/includes/header.php'; ?>


  

  <main class="main">

    <!-- Page Title -->
    

    <!-- Contact Section -->
    <section id="contact" class="contact section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row g-5">
          <div class="col-lg-5">
            <div class="contact-info-wrapper">
              <div class="contact-info-item" data-aos="fade-up" data-aos-delay="100">
                <div class="info-icon">
                  <i class="bi bi-geo-alt"></i>
                </div>
                <div class="info-content">
                  <h3>Our Address</h3>
                  <p>1842 Maple Avenue, Portland, Oregon 97204</p>
                </div>
              </div>

              <div class="contact-info-item" data-aos="fade-up" data-aos-delay="200">
                <div class="info-icon">
                  <i class="bi bi-envelope"></i>
                </div>
                <div class="info-content">
                  <h3>Email Address</h3>
                  <p>info@example.com</p>
                  <p>contact@example.com</p>
                </div>
              </div>

              <div class="contact-info-item" data-aos="fade-up" data-aos-delay="300">
                <div class="info-icon">
                  <i class="bi bi-headset"></i>
                </div>
                <div class="info-content">
                  <h3>Hours of Operation</h3>
                  <p>Sunday-Fri: 9 AM - 6 PM</p>
                  <p>Saturday: 9 AM - 4 PM</p>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-7">
            <div class="contact-form-card" data-aos="fade-up" data-aos-delay="200">
              <h2>Send us a Message</h2>
              <p class="mb-4">Have questions or want to learn more? Reach out to us and our team will get back to you
                shortly.</p>

              <form action="forms/contact.php" method="post" class="php-email-form">
                <div class="row g-4">
                  <div class="col-md-6">
                    <input type="text" class="form-control" name="name" id="name" placeholder="Votre Nom" required="">
                  </div>

                  <div class="col-md-6">
                    <input type="email" class="form-control" name="email" id="email" placeholder="Votre Email"
                      required="">
                  </div>

                  <div class="col-12">
                    <input type="text" class="form-control" name="subject" id="subject" placeholder="Suject"
                      required="">
                  </div>

                  <div class="col-12">
                    <textarea class="form-control" name="message" id="message" placeholder="Votre Message" rows="6"
                      required=""></textarea>
                  </div>

                  <div class="col-12">
                    <div class="loading">Loading</div>
                    <div class="error-message"></div>
                    <div class="sent-message">Your message has been sent. Thank you!</div>
                  </div>

                  <div class="col-12">
                    <button type="submit" class="btn btn-submit">Send Message</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <div class="container-fluid map-container" data-aos="fade-up" data-aos-delay="200">
        <div class="map-overlay"></div>
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d48389.78314118045!2d-74.006138!3d40.710059!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25a22a3bda30d%3A0xb89d1fe6bc499443!2sDowntown%20Conference%20Center!5e0!3m2!1sen!2sus!4v1676961268712!5m2!1sen!2sus"
          width="100%" height="500" style="border:0;" allowfullscreen="" loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>

    </section><!-- /Contact Section -->

  </main>

  

  <!-- Scroll Top -->
  <a href="#!" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>


<?php include dirname(__DIR__, 3) . '/includes/footer.php'; ?>
</body>
</html>
