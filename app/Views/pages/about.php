<?php
declare(strict_types=1);

$currentPage = 'about';
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
  <title>Index - Polyclinique Yetu Bootstrap Template</title>
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
<body class="about-page">
<?php include dirname(__DIR__, 3) . '/includes/header.php'; ?>


  

  <main class="main">

    

    <!-- About Section -->
    <section id="about" class="about section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row align-items-center">
          <div class="col-lg-6" data-aos="fade-right" data-aos-delay="100">
            <div class="about-content">
              <h2>Compassionate Care for Every Family</h2>
              <p class="lead">For over two decades, we have been dedicated to providing exceptional healthcare services
                to our community. Our commitment goes beyond medical treatment—we believe in building lasting
                relationships with our patients and their families.</p>

              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                ex ea commodo consequat.</p>

              <div class="stats-grid">
                <div class="stat-item">
                  <span class="stat-number" data-purecounter-start="0" data-purecounter-end="15000"
                    data-purecounter-duration="2">15000</span>
                  <span class="stat-label">Patients Treated</span>
                </div>
                <div class="stat-item">
                  <span class="stat-number" data-purecounter-start="0" data-purecounter-end="25"
                    data-purecounter-duration="2">25</span>
                  <span class="stat-label">Years Experience</span>
                </div>
                <div class="stat-item">
                  <span class="stat-number" data-purecounter-start="0" data-purecounter-end="50"
                    data-purecounter-duration="2">50</span>
                  <span class="stat-label">Medical Specialists</span>
                </div>
              </div><!-- End Stats Grid -->
            </div><!-- End About Content -->
          </div>

          <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
            <div class="image-wrapper">
              <img src="assets/img/health/facilities-6.webp" class="img-fluid main-image" alt="Healthcare facility">
              <div class="floating-image" data-aos="zoom-in" data-aos-delay="400">
                <img src="assets/img/health/staff-8.webp" class="img-fluid" alt="Medical team">
              </div>
            </div><!-- End Image Wrapper -->
          </div>
        </div>

        <div class="values-section" data-aos="fade-up" data-aos-delay="300">
          <div class="row">
            <div class="col-lg-12 text-center">
              <h3>Our Core Values</h3>
              <p class="section-description">These principles guide everything we do in our commitment to exceptional
                healthcare</p>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
              <div class="value-item">
                <div class="value-icon">
                  <i class="bi bi-heart-pulse"></i>
                </div>
                <h4>Compassion</h4>
                <p>Providing care with empathy and understanding for every patient's unique needs and circumstances.</p>
              </div>
            </div>

            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
              <div class="value-item">
                <div class="value-icon">
                  <i class="bi bi-shield-check"></i>
                </div>
                <h4>Excellence</h4>
                <p>Maintaining the highest standards of medical care through continuous learning and innovation.</p>
              </div>
            </div>

            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
              <div class="value-item">
                <div class="value-icon">
                  <i class="bi bi-people"></i>
                </div>
                <h4>Integrity</h4>
                <p>Building trust through honest communication and ethical practices in all our interactions.</p>
              </div>
            </div>

            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
              <div class="value-item">
                <div class="value-icon">
                  <i class="bi bi-lightbulb"></i>
                </div>
                <h4>Innovation</h4>
                <p>Embracing cutting-edge technology and treatments to improve patient outcomes.</p>
              </div>
            </div>
          </div><!-- End Values Row -->
        </div><!-- End Values Section -->

        <div class="certifications-section" data-aos="fade-up" data-aos-delay="400">
          <div class="row">
            <div class="col-lg-12 text-center">
              <h3>Accreditations &amp; Certifications</h3>
              <p class="section-description">Recognized by leading healthcare organizations for our commitment to
                quality care</p>
            </div>
          </div>

          <div class="row justify-content-center">
            <div class="col-lg-2 col-md-3 col-sm-4 col-6" data-aos="zoom-in" data-aos-delay="100">
              <div class="certification-item">
                <img src="assets/img/clients/clients-1.webp" class="img-fluid" alt="Healthcare certification">
              </div>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 col-6" data-aos="zoom-in" data-aos-delay="200">
              <div class="certification-item">
                <img src="assets/img/clients/clients-2.webp" class="img-fluid" alt="Medical accreditation">
              </div>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 col-6" data-aos="zoom-in" data-aos-delay="300">
              <div class="certification-item">
                <img src="assets/img/clients/clients-3.webp" class="img-fluid" alt="Healthcare certification">
              </div>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 col-6" data-aos="zoom-in" data-aos-delay="400">
              <div class="certification-item">
                <img src="assets/img/clients/clients-4.webp" class="img-fluid" alt="Medical certification">
              </div>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 col-6" data-aos="zoom-in" data-aos-delay="500">
              <div class="certification-item">
                <img src="assets/img/clients/clients-5.webp" class="img-fluid" alt="Healthcare accreditation">
              </div>
            </div>
          </div><!-- End Certifications Row -->
        </div><!-- End Certifications Section -->

      </div>

    </section><!-- /About Section -->

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
