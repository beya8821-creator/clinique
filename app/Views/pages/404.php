<?php
declare(strict_types=1);

$currentPage = '404';
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
<body class="page-404">
<?php include dirname(__DIR__, 3) . '/includes/header.php'; ?>


  

  <main class="main">

    

    <!-- Error 404 Section -->
    <section id="error-404" class="error-404 section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row justify-content-center">
          <div class="col-lg-8 text-center">

            <div class="error-number" data-aos="zoom-in" data-aos-delay="200">
              404
            </div>

            <h1 class="error-title" data-aos="fade-up" data-aos-delay="300">
              Page Not Found
            </h1>

            <p class="error-description" data-aos="fade-up" data-aos-delay="400">
              The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.
              Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore.
            </p>

            <div class="error-actions" data-aos="fade-up" data-aos-delay="500">
              <a href="index.php" class="btn-primary">
                <i class="bi bi-house"></i>
                Back to Home
              </a>
              <a href="#!" class="btn-secondary">
                <i class="bi bi-search"></i>
                Search Site
              </a>
            </div>

          </div>
        </div>

        <div class="row justify-content-center mt-5">
          <div class="col-lg-10">

            <div class="helpful-links" data-aos="fade-up" data-aos-delay="600">
              <h3>You might be looking for:</h3>
              <div class="links-grid">
                <a href="#!" class="link-item">
                  <i class="bi bi-info-circle"></i>
                  <span>About Us</span>
                </a>
                <a href="#!" class="link-item">
                  <i class="bi bi-telephone"></i>
                  <span>Contact</span>
                </a>
                <a href="#!" class="link-item">
                  <i class="bi bi-grid-3x3-gap"></i>
                  <span>Services</span>
                </a>
                <a href="#!" class="link-item">
                  <i class="bi bi-journal-text"></i>
                  <span>Blog</span>
                </a>
                <a href="#!" class="link-item">
                  <i class="bi bi-question-circle"></i>
                  <span>Support</span>
                </a>
                <a href="#!" class="link-item">
                  <i class="bi bi-shield-check"></i>
                  <span>Privacy Policy</span>
                </a>
              </div>
            </div>

          </div>
        </div>

      </div>

    </section><!-- /Error 404 Section -->

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
