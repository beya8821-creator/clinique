<?php
declare(strict_types=1);

$currentPage = 'services';
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
  <title>services</title>
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
<body class="services-page">
<?php include dirname(__DIR__, 3) . '/includes/header.php'; ?>


  

  <main class="main">

   

    <!-- Services Section -->
    <section id="services" class="services section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="service-item">
              <div class="service-image">
                <img src="assets/img/health/cardiology-2.webp" alt="Cardiology Services" class="img-fluid">
                <div class="service-overlay">
                  <i class="fas fa-heartbeat"></i>
                </div>
              </div>
              <div class="service-content">
                <h3>Cardiology</h3>
                <p>Comprehensive heart care with advanced diagnostic tools and treatment options for cardiovascular
                  conditions.</p>
                <div class="service-features">
                  <span class="feature-item"><i class="fas fa-check"></i> ECG Testing</span>
                  <span class="feature-item"><i class="fas fa-check"></i> Heart Surgery</span>
                </div>
                <a href="service-details.html" class="service-btn">
                  <span>Learn More</span>
                  <i class="fas fa-arrow-right"></i>
                </a>
              </div>
            </div>
          </div><!-- End Service Item -->

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="250">
            <div class="service-item">
              <div class="service-image">
                <img src="assets/img/health/neurology-3.webp" alt="Neurology Services" class="img-fluid">
                <div class="service-overlay">
                  <i class="fas fa-brain"></i>
                </div>
              </div>
              <div class="service-content">
                <h3>Neurology</h3>
                <p>Expert neurological care for brain and nervous system disorders with state-of-the-art imaging
                  technology.</p>
                <div class="service-features">
                  <span class="feature-item"><i class="fas fa-check"></i> MRI Scans</span>
                  <span class="feature-item"><i class="fas fa-check"></i> Stroke Care</span>
                </div>
                <a href="service-details.html" class="service-btn">
                  <span>Learn More</span>
                  <i class="fas fa-arrow-right"></i>
                </a>
              </div>
            </div>
          </div><!-- End Service Item -->

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
            <div class="service-item">
              <div class="service-image">
                <img src="assets/img/health/orthopedics-1.webp" alt="Orthopedics Services" class="img-fluid">
                <div class="service-overlay">
                  <i class="fas fa-bone"></i>
                </div>
              </div>
              <div class="service-content">
                <h3>Orthopedics</h3>
                <p>Specialized bone and joint treatment including sports medicine and reconstructive surgery procedures.
                </p>
                <div class="service-features">
                  <span class="feature-item"><i class="fas fa-check"></i> Joint Replacement</span>
                  <span class="feature-item"><i class="fas fa-check"></i> Sports Medicine</span>
                </div>
                <a href="service-details.html" class="service-btn">
                  <span>Learn More</span>
                  <i class="fas fa-arrow-right"></i>
                </a>
              </div>
            </div>
          </div><!-- End Service Item -->

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="350">
            <div class="service-item">
              <div class="service-image">
                <img src="assets/img/health/pediatrics-4.webp" alt="Pediatrics Services" class="img-fluid">
                <div class="service-overlay">
                  <i class="fas fa-child"></i>
                </div>
              </div>
              <div class="service-content">
                <h3>Pediatrics</h3>
                <p>Dedicated healthcare for children from infancy through adolescence with specialized treatment
                  protocols.</p>
                <div class="service-features">
                  <span class="feature-item"><i class="fas fa-check"></i> Well-Child Visits</span>
                  <span class="feature-item"><i class="fas fa-check"></i> Immunizations</span>
                </div>
                <a href="service-details.html" class="service-btn">
                  <span>Learn More</span>
                  <i class="fas fa-arrow-right"></i>
                </a>
              </div>
            </div>
          </div><!-- End Service Item -->

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
            <div class="service-item">
              <div class="service-image">
                <img src="assets/img/health/emergency-2.webp" alt="Emergency Services" class="img-fluid">
                <div class="service-overlay">
                  <i class="fas fa-ambulance"></i>
                </div>
              </div>
              <div class="service-content">
                <h3>Emergency Care</h3>
                <p>24/7 emergency medical services with rapid response teams and critical care capabilities.</p>
                <div class="service-features">
                  <span class="feature-item"><i class="fas fa-check"></i> Trauma Center</span>
                  <span class="feature-item"><i class="fas fa-check"></i> Critical Care</span>
                </div>
                <a href="service-details.html" class="service-btn">
                  <span>Learn More</span>
                  <i class="fas fa-arrow-right"></i>
                </a>
              </div>
            </div>
          </div><!-- End Service Item -->

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="450">
            <div class="service-item">
              <div class="service-image">
                <img src="assets/img/health/laboratory-3.webp" alt="Laboratory Services" class="img-fluid">
                <div class="service-overlay">
                  <i class="fas fa-microscope"></i>
                </div>
              </div>
              <div class="service-content">
                <h3>Laboratory Testing</h3>
                <p>Advanced diagnostic laboratory services with comprehensive testing panels and rapid result delivery.
                </p>
                <div class="service-features">
                  <span class="feature-item"><i class="fas fa-check"></i> Blood Tests</span>
                  <span class="feature-item"><i class="fas fa-check"></i> Pathology</span>
                </div>
                <a href="service-details.html" class="service-btn">
                  <span>Learn More</span>
                  <i class="fas fa-arrow-right"></i>
                </a>
              </div>
            </div>
          </div><!-- End Service Item -->

        </div>

      </div>

    </section><!-- /Services Section -->

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
