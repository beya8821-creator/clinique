<?php
declare(strict_types=1);

$currentPage = 'index';
$headerLogoHtml = <<<HTML
<!-- Uncomment the line below if you also wish to use an image logo -->
          <img src="assets/img/logos.webp" alt=""> 
          <h1 class="sitename">Polyclinique Yetu</h1>
HTML;

?>

<body class="index-page">
<?php include dirname(__DIR__, 3) . '/includes/header.php'; ?>


  

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row align-items-center">
          <div class="col-lg-6">
            <div class="hero-content">
              <div class="trust-badges mb-4" data-aos="fade-right" data-aos-delay="200">
                <div class="badge-item">
                  <i class="bi bi-shield-check"></i>
                  <span>Accredited</span>
                </div>
                <div class="badge-item">
                  <i class="bi bi-clock"></i>
                  <span>24/7 Emergency</span>
                </div>
                <div class="badge-item">
                  <i class="bi bi-star-fill"></i>
                  <span>4.9/5 Rating</span>
                </div>
              </div>

              <h1 data-aos="fade-right" data-aos-delay="300">
                Excellence en <span class="highlight">Soins de santé</span> Donné avec plus <span class="highlight"> compassions</span>

              <p class="hero-description" data-aos="fade-right" data-aos-delay="400">
                une clinique humanitaire d'inspiration qui place la dignité humaine au cœur de son engagement. 
                Elle offre des soins de santé accessibles, de qualité et empreints de compassion, 
                avec une attention particulière portée aux personnes vulnérables et aux communautés les plus démunies.
                Notre positionnement repose sur l'alliance entre l'excellence médicale, les valeurs chrétiennes et la solidarité sociale.
              </p>

              <div class="hero-stats mb-4" data-aos="fade-right" data-aos-delay="500">
                <div class="stat-item">
                  <h3><span data-purecounter-start="0" data-purecounter-end="1" data-purecounter-duration="2"
                      class="purecounter"></span>+</h3>
                  <p>Année d'expérience</p>
                </div>
                <div class="stat-item">
                  <h3><span data-purecounter-start="0" data-purecounter-end="130" data-purecounter-duration="2"
                      class="purecounter"></span>+</h3>
                  <p>Patients Traités</p>
                </div>
                <div class="stat-item">
                  <h3><span data-purecounter-start="0" data-purecounter-end="15" data-purecounter-duration="2"
                      class="purecounter"></span>+</h3>
                  <p>Experts personnels soignants</p>
                </div>
              </div>

              <div class="hero-actions" data-aos="fade-right" data-aos-delay="600">
                <a href="appointment.html" class="btn btn-primary">Prendre rendez-vous</a>
                <a href="https://" class="btn btn-outline glightbox">
                  <i class="bi bi-play-circle me-2"></i>
                  Ce que nous faisons
                </a>
              </div>

              <div class="emergency-contact" data-aos="fade-right" data-aos-delay="700">
                <div class="emergency-icon">
                  <i class="bi bi-telephone-fill"></i>
                </div>
                <div class="emergency-info">
                  <small>Numéro d'urgence</small>
                  <strong>+243 970 22 0803</strong>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="hero-visual" data-aos="fade-left" data-aos-delay="400">
              <div class="main-image">
                <img src="assets/img/health/staff-10.webp" alt="Modern Healthcare Facility" class="img-fluid">
                <div class="floating-card appointment-card">
                  <div class="card-icon">
                    <i class="bi bi-calendar-check"></i>
                  </div>
                  <div class="card-content">
                    <h6>heures de visites</h6>
                    <p>Matin 6:00-7:30  <br>
                      Midi 12:00-13:00 <br>
                      Soir 16:00-18:00 
                    </p>
                    <small></small>
                  </div>
                </div>
                <div class="floating-card rating-card">
                  <div class="card-content">
                    <div class="rating-stars">
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-fill"></i>
                    </div>
                    <h6>4.9/5</h6>
                    <small>1,234 Reviews</small>
                  </div>
                </div>
              </div>
              <div class="background-elements">
                <div class="element element-1"></div>
                <div class="element element-2"></div>
                <div class="element element-3"></div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </section><!-- /Hero Section -->

    <!-- Home About Section -->
    <section id="home-about" class="home-about section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row align-items-center">
          <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right" data-aos-delay="200">
            <div class="about-content">
              <h2 class="section-heading">Soins Bienveillants, </h2>
              <p class="lead-text">Depuis un an, nous nous engageons à fournir des soins de santé exceptionnels qui Allie 
                technologie médicale de pointe avec la touche personnelle que nos patients méritent.</p>

              <p>Notre équipe multidisciplinaire de spécialistes travaille en collaboration pour garantir que chaque 
                patient reçoit des soins complets adaptés à leurs besoins spécifiques. Des services préventifs aux 
                procédures complexes, nous maintenir les plus hauts standards dexcellence médicale tout en favorisant un environnement de confiance et guérison.</p>

              <div class="stats-grid">
                <div class="stat-item">
                  <div class="stat-number purecounter" data-purecounter-start="0" data-purecounter-end="130"
                    data-purecounter-duration="1"></div>
                  <div class="stat-label">Patients Servis</div>
                </div>
                <div class="stat-item">
                  <div class="stat-number purecounter" data-purecounter-start="0" data-purecounter-end="1"
                    data-purecounter-duration="1"></div>
                  <div class="stat-label">Années d'Excellence</div>
                </div>
                <div class="stat-item">
                  <div class="stat-number purecounter" data-purecounter-start="0" data-purecounter-end="15"
                    data-purecounter-duration="1"></div>
                  <div class="stat-label">Specialistes</div>
                </div>
              </div>

              <div class="cta-section">
                <a href="about.html" class="btn-primary">Apprendre plus sur nous</a>
              </div>
            </div>
          </div>

          <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
            <div class="about-visual">
              <div class="main-image">
                <img src="assets/img/health/facilities-9.webp" alt="Modern medical facility" class="img-fluid">
              </div>
              <div class="floating-card">
                <div class="card-content">
                  <div class="icon">
                    <i class="bi bi-heart-pulse"></i>
                  </div>
                  <div class="card-text">
                    <h4>Soins d’urgence 24/7</h4>
                    <p>Toujours là quand tu as le plus besoin de nous</p>
                  </div>
                </div>
              </div>
              <div class="experience-badge">
                <div class="badge-content">
                  <span class="years">1+</span>
                  <span class="text">une année de soins de confiance</span>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </section><!-- /Home About Section -->

    <!-- Featured Departments Section -->
    <section id="featured-departments" class="featured-departments section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>services</h2>
        <p>À l'écoute de votre santé, notre hôpital vous propose une offre 
          de soins complète, humaine et d'excellence. De la prévention aux 
          traitements spécialisés, nos équipes d'experts et nos plateaux 
          techniques de pointe se mobilisent chaque jour pour vous offrir 
          une prise en charge personnalisée et sécurisée, à chaque étape de votre vie.</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row g-5">

          

          

          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
            <div class="department-highlight">
              <div class="highlight-icon">
                <i class="bi bi-shield-plus"></i>
              </div>
              <h4>Médecine interne</h4>
              <p>Prise en charge globale, diagnostique et thérapeutique des 
                maladies aiguës et chroniques de l'adulte.</p>
              <ul class="highlight-list">
                <li>Suivi des pathologies complexes 
                  (diabète, hypertension, etc.)</li>
                <li>Bilans de santé complets</li>
                
              </ul>
              <a href="department-details.html" class="highlight-cta">En savoir plus</a>
            </div>
          </div><!-- End Department Highlight -->

          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
            <div class="department-highlight">
              <div class="highlight-icon">
                <i class="bi bi-people"></i>
              </div>
              <h4>Pédiatrie </h4>
              <p>Des soins attentionnés pour le bien-être
                 et la santé de vos enfants, de la naissance jusqu’à l’adolescence.</p>
              <ul class="highlight-list">
                <li>Suivi du développement et vaccinations</li>
                <li>Prise en charge des urgences pédiatriques</li>
                
              </ul>
              <a href="department-details.html" class="highlight-cta">En savoir plus</a>
            </div>
          </div><!-- End Department Highlight -->

          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
            <div class="department-highlight">
              <div class="highlight-icon">
                <i class="bi bi-activity"></i>
              </div>
              <h4>Gynécologie</h4>
              <p>Un accompagnement personnalisé dédié
                 à la santé globale de la femme à toutes les étapes de sa vie.</p>
              <ul class="highlight-list">
                <li>Dépistages et suivis gynécologiques de routine</li>
                <li>Prise en charge des troubles hormonaux et de la ménopause</li>
                
              </ul>
              <a href="department-details.html" class="highlight-cta">En savoir plus</a>
            </div>
          </div><!-- End Department Highlight -->

        </div>

        <div class="emergency-banner" data-aos="fade-up" data-aos-delay="400">
          <div class="row align-items-center">
            <div class="col-lg-8">
              <div class="emergency-content">
                <h3>la ligne d'urgence 24/7</h3>
                <p>Une équipe médicale dédiée est prête à 
                  vous prendre en charge à tout moment, de jour comme de nuit.</p>
              </div>
            </div>
            <div class="col-lg-4 text-lg-end">
              <a href="tel:+243 970 220 803" class="emergency-btn">
                <i class="bi bi-telephone-fill"></i>
                Urgence: +243 970 220 803
              </a>
            </div>
          </div>
        </div>

      </div>

    </section><!-- /Featured Departments Section -->

   
    <
    <section id="call-to-action" class="call-to-action section light-background">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="hero-content">
          <div class="row align-items-center">

            <div class="col-lg-6">
              <div class="content-wrapper" data-aos="fade-up" data-aos-delay="200">
                <h1>L'excellence dans les soins, quotidien</h1>
                <p>Choisir notre établissement, c'est confier votre santé à une 
                  équipe de professionnels passionnés, guidés par la bienveillance, 
                  l'éthique et l'excellence médicale. Nous mettons tout en œuvre pour 
                  vous offrir un environnement sûr, chaleureux et des soins adaptés à 
                  vos besoins uniques. Vous êtes entre de bonnes mains.</p>

                <div class="cta-wrapper">
                  <a href="contact.php" class="primary-cta">
                    <span>Programmer une consultation</span>
                    <i class="bi bi-arrow-right"></i>
                  </a>
                  <a href="services.html" class="secondary-cta">
                    <span>Explore Services</span>
                    <i class="bi bi-arrow-right"></i>
                  </a>
                </div>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="image-container" data-aos="fade-left" data-aos-delay="300">
                <img src="assets/img/health/facilities-9.webp" alt="Medical Excellence" class="img-fluid">
              </div>
            </div>

          </div>
        </div>

        <div class="features-section">

          <div class="row g-0">

            <div class="col-lg-4">
              <div class="feature-block" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-icon">
                  <i class="bi bi-shield-check"></i>
                </div>
                <h3>Technologie Avancée</h3>
                <p>Des équipements de pointe pour des diagnostics d'une précision maximale.</p>
              </div>
            </div>

            <div class="col-lg-4">
              <div class="feature-block" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-icon">
                  <i class="bi bi-clock"></i>
                </div>
                <h3>Disponibilité 24/7</h3>
                <p>Une présence médicale continue pour répondre à vos besoins à tout moment.</p>
              </div>
            </div>

            <div class="col-lg-4">
              <div class="feature-block" data-aos="fade-up" data-aos-delay="400">
                <div class="feature-icon">
                  <i class="bi bi-people"></i>
                </div>
                <h3>Équipe d'Experts</h3>
                <p>Des professionnels hautement qualifiés et dévoués à votre santé.</p>
              </div>
            </div>

          </div>

        </div>

        <div class="contact-block">
          <div class="row">

            <div class="col-lg-8">
              <div class="contact-content" data-aos="fade-up" data-aos-delay="200">
                <h2>Besoin d'une aide médicale immédiate?</h2>
                <p>Notre équipe de réponse aux urgences est disponible en continu pour fournir un support médical immédiat lorsque
                  vous en avez le plus besoin.</p>
              </div>
            </div>

            <div class="col-lg-4">
              <div class="contact-actions" data-aos="fade-up" data-aos-delay="300">
                <a href="tel:+243 970 220 803" class="emergency-call">
                  <i class="bi bi-telephone"></i>
                  <span>+243 970 220 803</span>
                </a>
                <a href="contact.php" class="contact-link">Find Location</a>
              </div>
            </div>

          </div>
        </div>

      </div>

    </section><!-- /Call To Action Section -->

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
