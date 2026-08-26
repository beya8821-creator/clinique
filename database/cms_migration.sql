CREATE TABLE IF NOT EXISTS cms_sections (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  page_slug VARCHAR(80) NOT NULL,
  section_key VARCHAR(80) NOT NULL,
  label VARCHAR(120) NOT NULL,
  title VARCHAR(255) NULL,
  subtitle TEXT NULL,
  body MEDIUMTEXT NULL,
  button_text VARCHAR(120) NULL,
  button_url VARCHAR(255) NULL,
  image_path VARCHAR(255) NULL,
  video_url VARCHAR(255) NULL,
  extra_json JSON NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY cms_sections_page_section_unique (page_slug, section_key)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS cms_services (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(190) NOT NULL,
  slug VARCHAR(190) NOT NULL UNIQUE,
  description TEXT NOT NULL,
  image_path VARCHAR(255) NOT NULL,
  icon_class VARCHAR(120) NOT NULL,
  button_text VARCHAR(120) DEFAULT 'Learn More',
  button_url VARCHAR(255) DEFAULT 'service-details.html',
  features_text TEXT NULL,
  sort_order INT DEFAULT 0,
  is_active TINYINT(1) DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS cms_contact_settings (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `key` VARCHAR(120) NOT NULL UNIQUE,
  `value` TEXT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS hero_slider (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  image VARCHAR(255) NOT NULL,
  title VARCHAR(190) NULL,
  subtitle VARCHAR(255) NULL,
  button_text VARCHAR(120) NULL,
  button_link VARCHAR(255) NULL,
  display_order INT DEFAULT 0,
  status TINYINT(1) DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO hero_slider (image, title, display_order, status)
SELECT ml.path, ml.original_name, base.max_order + ordered.row_number, 1
FROM (
  SELECT id, path, original_name, ROW_NUMBER() OVER (ORDER BY id) AS row_number
  FROM media_library
  WHERE mime_type LIKE 'image/%'
) ordered
JOIN media_library ml ON ml.id = ordered.id
CROSS JOIN (SELECT COALESCE(MAX(display_order), 0) AS max_order FROM hero_slider) base
WHERE NOT EXISTS (SELECT 1 FROM hero_slider existing WHERE existing.image = ml.path);

INSERT INTO cms_sections (page_slug, section_key, label, title, subtitle, body, button_text, button_url, image_path, video_url) VALUES
('home', 'hero', 'Hero', 'Excellence en Soins de santé Donné avec plus compassions', '', 'une clinique humanitaire d''inspiration qui place la dignité humaine au cœur de son engagement. Elle offre des soins de santé accessibles, de qualité et empreints de compassion, avec une attention particulière portée aux personnes vulnérables et aux communautés les plus démunies.', 'Prendre rendez-vous', 'appointment.html', 'assets/img/health/staff-10.webp', 'https://'),
('home', 'about', 'Home About', 'Soins Bienveillants,', 'Depuis un an, nous nous engageons à fournir des soins de santé exceptionnels qui Allie technologie médicale de pointe avec la touche personnelle que nos patients méritent.', 'Notre équipe multidisciplinaire de spécialistes travaille en collaboration pour garantir que chaque patient reçoit des soins complets adaptés à leurs besoins spécifiques.', 'Apprendre plus sur nous', 'about.html', 'assets/img/health/facilities-9.webp', ''),
('home', 'cta', 'CTA', 'L''excellence dans les soins, quotidien', '', 'Choisir notre établissement, c''est confier votre santé à une équipe de professionnels passionnés, guidés par la bienveillance, l''éthique et l''excellence médicale.', 'Programmer une consultation', 'contact.php', 'assets/img/health/facilities-9.webp', ''),
('about', 'intro', 'Intro', 'Compassionate Care for Every Family', 'For over two decades, we have been dedicated to providing exceptional healthcare services to our community.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', '', '', 'assets/img/health/facilities-6.webp', ''),
('about', 'values', 'Mission / Vision / Values', 'Our Core Values', '', 'These principles guide everything we do in our commitment to exceptional healthcare', '', '', '', '')
ON DUPLICATE KEY UPDATE
label = VALUES(label),
title = VALUES(title),
subtitle = VALUES(subtitle),
body = VALUES(body),
button_text = VALUES(button_text),
button_url = VALUES(button_url),
image_path = VALUES(image_path),
video_url = VALUES(video_url);

INSERT INTO cms_services (title, slug, description, image_path, icon_class, button_text, button_url, features_text, sort_order, is_active) VALUES
('Cardiology', 'cardiology', 'Comprehensive heart care with advanced diagnostic tools and treatment options for cardiovascular conditions.', 'assets/img/health/cardiology-2.webp', 'fas fa-heartbeat', 'Learn More', 'service-details.html', 'ECG Testing\nHeart Surgery', 10, 1),
('Neurology', 'neurology', 'Expert neurological care for brain and nervous system disorders with state-of-the-art imaging technology.', 'assets/img/health/neurology-3.webp', 'fas fa-brain', 'Learn More', 'service-details.html', 'MRI Scans\nStroke Care', 20, 1),
('Orthopedics', 'orthopedics', 'Specialized bone and joint treatment including sports medicine and reconstructive surgery procedures.', 'assets/img/health/orthopedics-1.webp', 'fas fa-bone', 'Learn More', 'service-details.html', 'Joint Replacement\nSports Medicine', 30, 1),
('Pediatrics', 'pediatrics', 'Dedicated healthcare for children from infancy through adolescence with specialized treatment protocols.', 'assets/img/health/pediatrics-4.webp', 'fas fa-child', 'Learn More', 'service-details.html', 'Well-Child Visits\nImmunizations', 40, 1),
('Emergency Care', 'emergency-care', '24/7 emergency medical services with rapid response teams and critical care capabilities.', 'assets/img/health/emergency-2.webp', 'fas fa-ambulance', 'Learn More', 'service-details.html', 'Trauma Center\nCritical Care', 50, 1),
('Laboratory Testing', 'laboratory-testing', 'Advanced diagnostic laboratory services with comprehensive testing panels and rapid result delivery.', 'assets/img/health/laboratory-3.webp', 'fas fa-microscope', 'Learn More', 'service-details.html', 'Blood Tests\nPathology', 60, 1)
ON DUPLICATE KEY UPDATE
title = VALUES(title),
description = VALUES(description),
image_path = VALUES(image_path),
icon_class = VALUES(icon_class),
button_text = VALUES(button_text),
button_url = VALUES(button_url),
features_text = VALUES(features_text),
sort_order = VALUES(sort_order),
is_active = VALUES(is_active);

INSERT INTO cms_contact_settings (`key`, `value`) VALUES
('address_title', 'Our Address'),
('address', '1842 Maple Avenue, Portland, Oregon 97204'),
('phone', '+243 970 220 803'),
('email_title', 'Email Address'),
('email_primary', 'info@example.com'),
('email_secondary', 'contact@example.com'),
('hours_title', 'Hours of Operation'),
('hours_primary', 'Sunday-Fri: 9 AM - 6 PM'),
('hours_secondary', 'Saturday: 9 AM - 4 PM'),
('form_title', 'Send us a Message'),
('form_intro', 'Have questions or want to learn more? Reach out to us and our team will get back to you shortly.'),
('map_embed_url', 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d48389.78314118045!2d-74.006138!3d40.710059!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25a22a3bda30d%3A0xb89d1fe6bc499443!2sDowntown%20Conference%20Center!5e0!3m2!1sen!2sus'),
('facebook_url', ''),
('instagram_url', ''),
('linkedin_url', ''),
('whatsapp_url', '')
ON DUPLICATE KEY UPDATE `value` = VALUES(`value`);
