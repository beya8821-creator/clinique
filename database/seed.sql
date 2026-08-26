INSERT INTO roles (id, name) VALUES (1, 'admin'), (2, 'editor');

INSERT INTO users (role_id, name, email, password_hash)
VALUES (1, 'Administrator', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi');

INSERT INTO pages (title, slug, template_file) VALUES
('Home', 'index', 'index.html'),
('About', 'about', 'about.html'),
('Appointment', 'appointment', 'appointment.html'),
('Contact', 'contact', 'contact.html'),
('Department Details', 'department-details', 'department-details.html'),
('Departments', 'departments', 'departments.html'),
('Doctors', 'doctors', 'doctors.html'),
('FAQ', 'faq', 'faq.html'),
('Gallery', 'gallery', 'gallery.html'),
('Privacy', 'privacy', 'privacy.html'),
('Service Details', 'service-details', 'service-details.html'),
('Services', 'services', 'services.html'),
('Starter Page', 'starter-page', 'starter-page.html'),
('Terms', 'terms', 'terms.html'),
('Testimonials', 'testimonials', 'testimonials.html'),
('404', '404', '404.html');

INSERT INTO settings (`key`, `value`) VALUES
('site_name', 'Polyclinique Yetu'),
('contact_email', 'contact@example.com'),
('contact_phone', '+1 5589 55488 55'),
('address', '1842 Maple Avenue, Portland, Oregon 97204'),
('footer_text', 'Polyclinique Yetu. All rights reserved.'),
('meta_title', 'Polyclinique Yetu'),
('meta_description', 'Healthcare Polyclinique Yetu website powered by PHP CMS.'),
('meta_keywords', 'Polyclinique Yetu, healthcare, doctors, appointments');

INSERT INTO seo (page_slug, meta_title, meta_description, keywords, robots)
SELECT slug, CONCAT(title, ' - Polyclinique Yetu'), 'Healthcare Polyclinique Yetu website powered by PHP CMS.', 'Polyclinique Yetu, healthcare, doctors', 'index,follow'
FROM pages;

INSERT INTO menus (location, label, url, sort_order) VALUES
('main', 'Home', 'index.html', 1),
('main', 'About', 'about.html', 2),
('main', 'Departments', 'departments.html', 3),
('main', 'Services', 'services.html', 4),
('main', 'Doctors', 'doctors.html', 5),
('main', 'Contact', 'contact.html', 6);

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
('map_embed_url', 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d48389.78314118045!2d-74.006138!3d40.710059!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25a22a3bda30d%3A0xb89d1fe6bc499443!2sDowntown%20Conference%20Center!5e0!3m2!1sen!2sus!4v1676961268712!5m2!1sen!2sus'),
('facebook_url', ''),
('instagram_url', ''),
('linkedin_url', ''),
('whatsapp_url', '')
ON DUPLICATE KEY UPDATE `value` = VALUES(`value`);
