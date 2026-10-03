# AUDIT MIGRATION PHP -> NEXT.JS + SUPABASE

Date de l'audit : 2026-09-06
Projet audite : `C:\xampp\htdocs\clinic-php-cms`
Mission : MISSION-01 - Audit complet du site PHP
Regle appliquee : aucune migration, aucune suppression, aucune modification fonctionnelle.

## 1. Resume du projet

Le projet est un CMS PHP pour le site "Polyclinique Yetu". Il s'agit d'une application PHP 8.3+ avec architecture MVC maison, routeur custom, vues PHP, connexion PDO MySQL, espace d'administration, formulaires publics, gestion de contenu CMS, medias, messages de contact, demandes de rendez-vous, newsletter, SEO et logs d'activite.

Framework detecte : aucun framework PHP majeur detecte. Le projet utilise un bootstrap PHP maison, autoload PSR-like pour le namespace `App\`, et des helpers internes.

Objectif de migration cible : reproduire progressivement l'application dans Next.js avec Supabase PostgreSQL, Supabase Auth si necessaire, et Supabase Storage pour les fichiers uploades.

Points majeurs :

- Front public base sur des templates BootstrapMade convertis en vues PHP.
- Admin centralise dans `admin/index.php`.
- Base MySQL via PDO dans `app/Core/Database.php`.
- Sessions PHP pour l'admin.
- CSRF maison via `App\Helpers\Security`.
- Roles identifies : `admin`, `editor`.
- Uploads stockes dans `public/uploads/`.
- Aucun Composer detecte.
- Aucun `package.json` detecte.
- Aucune migration Next.js commencee.

## 2. Architecture actuelle

Architecture actuelle observee :

```text
clinic-php-cms/
|-- admin/
|   |-- index.php
|   `-- assets/
|       |-- admin.css
|       `-- hms-style.css
|-- app/
|   |-- bootstrap.php
|   |-- Core/
|   |   |-- Database.php
|   |   `-- TemplateRenderer.php
|   |-- Helpers/
|   |   |-- Security.php
|   |   `-- Url.php
|   |-- Repositories/
|   |   `-- CmsContentRepository.php
|   `-- Views/
|       |-- admin/
|       `-- pages/
|-- config/
|   |-- config.php
|   |-- database.php
|   `-- functions.php
|-- database/
|   |-- clinic_db.sql
|   |-- cms_migration.sql
|   |-- import_templates.php
|   `-- seed.sql
|-- includes/
|   |-- footer.php
|   |-- header.php
|   `-- navbar.php
|-- public/
|   |-- admin.php
|   |-- index.php
|   |-- forms/
|   |   |-- appointment.php
|   |   `-- contact.php
|   |-- uploads/
|   `-- assets/
|       |-- css/
|       |-- js/
|       |-- img/
|       |-- scss/
|       `-- vendor/
|-- storage/
|-- .env
|-- .env.example
|-- Dockerfile.txt
|-- README.md
`-- temp_generate_php_pages.php
```

Entrees principales :

- Public : `public/index.php`
- Admin : `public/admin.php`, `public/admin/index.php`, `admin/index.php`
- Formulaire contact : `public/forms/contact.php`
- Formulaire rendez-vous : `public/forms/appointment.php`

## 3. Arborescence

Pages publiques actuellement presentes dans `app/Views/pages/` :

- `404.php`
- `about.php`
- `contact.php`
- `index.php`
- `service-details.php`
- `services.php`

Pages routees/autorisées par `public/index.php` :

- `index`
- `about`
- `appointment`
- `contact`
- `department-details`
- `departments`
- `doctors`
- `faq`
- `gallery`
- `privacy`
- `service-details`
- `services`
- `starter-page`
- `terms`
- `testimonials`
- `404`

Observation importante : 16 slugs sont autorises par le routeur et seedes dans la table `pages`, mais seulement 6 fichiers PHP existent dans `app/Views/pages/`. Les pages manquantes peuvent fonctionner uniquement si `pages.html_content` contient du HTML en base. Sinon, `TemplateRenderer` charge le template 404.

Includes reutilisables :

- `includes/header.php`
- `includes/navbar.php`
- `includes/footer.php`

Composants/classes backend :

- `App\Core\Database`
- `App\Core\TemplateRenderer`
- `App\Helpers\Security`
- `App\Helpers\Url`
- `App\Repositories\CmsContentRepository`

CSS :

- `public/assets/css/main.css`
- `public/admin/assets/admin.css`
- `public/admin/assets/hms-style.css`
- `admin/assets/admin.css`
- `admin/assets/hms-style.css`
- `public/assets/vendor/...`

JavaScript :

- `public/assets/js/main.js`
- `public/assets/vendor/php-email-form/validate.js`
- `public/assets/vendor/bootstrap/...`
- `public/assets/vendor/aos/...`
- `public/assets/vendor/glightbox/...`
- `public/assets/vendor/purecounter/...`
- `public/assets/vendor/swiper/...`

Images/assets :

- 61 images dans `public/assets/img/`.
- Dossiers images : `bg`, `clients`, `gallery`, `health`, `person`.
- Fichiers racine : `favicon.png`, `logo.webp`, `logos.webp`, `apple-touch-icon.png`.

Uploads :

- 6 fichiers detectes dans `public/uploads/`.
- Extensions observees : `.png`, `.webp`.

Configuration :

- `.env`
- `.env.example`
- `config/config.php`
- `config/database.php`
- `app/bootstrap.php`

SQL :

- `database/clinic_db.sql`
- `database/cms_migration.sql`
- `database/seed.sql`

## 4. Pages

### PUBLIC

PAGE : Accueil
ROUTE : `/`, `/index.php`
FICHIER : `app/Views/pages/index.php`
TYPE : page publique CMS
ACCESSIBILITE : publique
AUTHENTIFICATION REQUISE : non
ROLE REQUIS : aucun
FONCTIONNALITES : hero, statistiques, contenu about, departements, CTA, contact, telephone
COMPOSANTS UTILISES : header, navbar, footer, AOS, PureCounter
FORMULAIRES : aucun detecte sur le fichier observe
BASE DE DONNEES : `pages`, `settings`, `seo`, `cms_sections`, `cms_contact_settings`, `hero_slider`
API/AJAX : non detecte directement
UPLOAD : non
NOTIFICATIONS : non
DEPENDANCES : Bootstrap, AOS, GLightbox, PureCounter, Swiper, Font Awesome, Bootstrap Icons, Google Fonts

PAGE : About
ROUTE : `/about.php`
FICHIER : `app/Views/pages/about.php`
TYPE : page publique CMS
ACCESSIBILITE : publique
AUTHENTIFICATION REQUISE : non
ROLE REQUIS : aucun
FONCTIONNALITES : presentation, statistiques, valeurs, certifications
COMPOSANTS UTILISES : header, navbar, footer, AOS, PureCounter
FORMULAIRES : aucun
BASE DE DONNEES : `pages`, `settings`, `seo`, `cms_sections`, `cms_contact_settings`
API/AJAX : non detecte
UPLOAD : non
NOTIFICATIONS : non
DEPENDANCES : Bootstrap, AOS, PureCounter, Google Fonts

PAGE : Services
ROUTE : `/services.php`
FICHIER : `app/Views/pages/services.php`
TYPE : page publique CMS
ACCESSIBILITE : publique
AUTHENTIFICATION REQUISE : non
ROLE REQUIS : aucun
FONCTIONNALITES : liste de services, cartes, images, icones, liens details
COMPOSANTS UTILISES : header, navbar, footer, cartes service
FORMULAIRES : aucun
BASE DE DONNEES : `pages`, `settings`, `seo`, `cms_services`, `cms_contact_settings`
API/AJAX : non detecte
UPLOAD : non
NOTIFICATIONS : non
DEPENDANCES : Bootstrap, AOS, Font Awesome

PAGE : Service details
ROUTE : `/service-details.php`
FICHIER : `app/Views/pages/service-details.php`
TYPE : page publique statique/CMS partiel
ACCESSIBILITE : publique
AUTHENTIFICATION REQUISE : non
ROLE REQUIS : aucun
FONCTIONNALITES : details service, appels a action, telephone
COMPOSANTS UTILISES : header, navbar, footer
FORMULAIRES : aucun
BASE DE DONNEES : `pages`, `settings`, `seo`, `cms_contact_settings`
API/AJAX : non detecte
UPLOAD : non
NOTIFICATIONS : non
DEPENDANCES : Bootstrap, AOS, Font Awesome

PAGE : Contact
ROUTE : `/contact.php`
FICHIER : `app/Views/pages/contact.php`
TYPE : page publique avec formulaire
ACCESSIBILITE : publique
AUTHENTIFICATION REQUISE : non
ROLE REQUIS : aucun
FONCTIONNALITES : informations de contact, formulaire contact, iframe Google Maps
COMPOSANTS UTILISES : header, navbar, footer, php-email-form
FORMULAIRES : contact
BASE DE DONNEES : `pages`, `settings`, `seo`, `cms_contact_settings`, `contact_messages`
API/AJAX : `public/forms/contact.php` via `fetch()`
UPLOAD : non
NOTIFICATIONS : non
DEPENDANCES : Bootstrap, AOS, validate.js, Google Maps iframe

PAGE : 404
ROUTE : routes non trouvees / slug 404
FICHIER : `app/Views/pages/404.php`
TYPE : erreur publique
ACCESSIBILITE : publique
AUTHENTIFICATION REQUISE : non
ROLE REQUIS : aucun
FONCTIONNALITES : page erreur, liens utiles
COMPOSANTS UTILISES : header/footer non confirmes selon contenu
FORMULAIRES : aucun
BASE DE DONNEES : `pages`, `settings`, `seo`
API/AJAX : non detecte
UPLOAD : non
NOTIFICATIONS : non
DEPENDANCES : Bootstrap, AOS

PAGE : Appointment
ROUTE : `/appointment.php` ou `/appointment.html` selon liens
FICHIER : UNKNOWN - A VERIFIER, absent de `app/Views/pages/`
TYPE : page publique attendue
ACCESSIBILITE : publique
AUTHENTIFICATION REQUISE : non detecte
ROLE REQUIS : aucun
FONCTIONNALITES : prise de rendez-vous attendue
COMPOSANTS UTILISES : UNKNOWN - A VERIFIER
FORMULAIRES : rendez-vous attendu
BASE DE DONNEES : `appointments`
API/AJAX : `public/forms/appointment.php`
UPLOAD : non detecte
NOTIFICATIONS : non detecte
DEPENDANCES : UNKNOWN - A VERIFIER

PAGE : Department details / Departments / Doctors / FAQ / Gallery / Privacy / Starter page / Terms / Testimonials
ROUTE : slugs autorises par `public/index.php`
FICHIER : UNKNOWN - A VERIFIER, fichiers absents de `app/Views/pages/`
TYPE : pages publiques attendues
ACCESSIBILITE : publique
AUTHENTIFICATION REQUISE : non detecte
ROLE REQUIS : aucun
FONCTIONNALITES : UNKNOWN - A VERIFIER
COMPOSANTS UTILISES : UNKNOWN - A VERIFIER
FORMULAIRES : UNKNOWN - A VERIFIER
BASE DE DONNEES : `pages`, `seo`, contenu HTML en base possible
API/AJAX : UNKNOWN - A VERIFIER
UPLOAD : non detecte
NOTIFICATIONS : non detecte
DEPENDANCES : UNKNOWN - A VERIFIER

### AUTHENTIFICATION

PAGE : Admin login
ROUTE : `/admin.php?action=login`
FICHIER : `app/Views/admin/login.php`
TYPE : authentification admin
ACCESSIBILITE : publique mais redirige apres login
AUTHENTIFICATION REQUISE : non
ROLE REQUIS : aucun
FONCTIONNALITÉS : connexion admin/editor
COMPOSANTS UTILISES : Bootstrap admin, formulaire login
FORMULAIRES : email, password, CSRF
BASE DE DONNEES : `users`, `roles`, `activity_logs`
API/AJAX : non
UPLOAD : non
NOTIFICATIONS : flash session
DEPENDANCES : sessions PHP, `password_verify`

PAGE : Logout
ROUTE : `/admin.php?action=logout`
FICHIER : `admin/index.php`
TYPE : action POST
ACCESSIBILITE : admin connecte
AUTHENTIFICATION REQUISE : oui
ROLE REQUIS : admin ou editor
FONCTIONNALITES : suppression de `$_SESSION['admin_user']`
COMPOSANTS UTILISES : formulaire dans `app/Views/admin/layout.php`
FORMULAIRES : CSRF
BASE DE DONNEES : non
API/AJAX : non
UPLOAD : non
NOTIFICATIONS : non
DEPENDANCES : session PHP

Register / forgot password / reset password : UNKNOWN - A VERIFIER. Aucun flux dedie detecte dans le code observe.

### UTILISATEUR

Aucun espace utilisateur public/patient detecte. UNKNOWN - A VERIFIER si contenu stocke en base ou fichier zip contient une ancienne version.

### ADMIN

PAGE : Dashboard
ROUTE : `/admin.php`
FICHIER : `app/Views/admin/dashboard.php`
TYPE : admin
AUTHENTIFICATION REQUISE : oui
ROLE REQUIS : admin ou editor
FONCTIONNALITES : compte pages, messages, rendez-vous, medias, actions rapides
BASE DE DONNEES : `pages`, `contact_messages`, `appointments`, `media_library`

PAGE : CMS Home
ROUTE : `/admin.php?action=cms-home`
FICHIER : `app/Views/admin/cms_home.php`
TYPE : admin CMS
AUTHENTIFICATION REQUISE : oui
ROLE REQUIS : admin ou editor
FONCTIONNALITES : edition sections home `hero`, `about`, `cta`
FORMULAIRES : sections CMS, image/video upload possibles
BASE DE DONNEES : `cms_sections`, `media_library`
UPLOAD : image/video via `store_uploaded_media`

PAGE : Hero Slider
ROUTE : `/admin.php?action=hero-slider`
FICHIER : `app/Views/admin/hero_slider.php`
TYPE : admin CMS media
AUTHENTIFICATION REQUISE : oui
ROLE REQUIS : admin ou editor pour save/reorder, admin pour delete
FONCTIONNALITES : ajout/modification/suppression/reordering slides hero
BASE DE DONNEES : `hero_slider`, `media_library`, `activity_logs`
UPLOAD : image
JS : drag/drop inline pour reordering

PAGE : CMS About
ROUTE : `/admin.php?action=cms-about`
FICHIER : `app/Views/admin/cms_about.php`
TYPE : admin CMS
AUTHENTIFICATION REQUISE : oui
ROLE REQUIS : admin ou editor
FONCTIONNALITES : edition intro et values
BASE DE DONNEES : `cms_sections`, `media_library`
UPLOAD : image/video possible selon formulaire section

PAGE : CMS Services
ROUTE : `/admin.php?action=cms-services`
FICHIER : `app/Views/admin/cms_services.php`
TYPE : admin CMS
AUTHENTIFICATION REQUISE : oui
ROLE REQUIS : admin ou editor pour save, admin pour delete
FONCTIONNALITES : CRUD services, recherche, pagination
BASE DE DONNEES : `cms_services`, `media_library`, `activity_logs`
UPLOAD : image service

PAGE : CMS Contact
ROUTE : `/admin.php?action=cms-contact`
FICHIER : `app/Views/admin/cms_contact.php`
TYPE : admin CMS
AUTHENTIFICATION REQUISE : oui
ROLE REQUIS : admin ou editor
FONCTIONNALITES : edition adresse, email, horaires, telephone, iframe maps, reseaux sociaux
BASE DE DONNEES : `cms_contact_settings`

PAGE : Pages
ROUTE : `/admin.php?action=pages`
FICHIER : `app/Views/admin/pages.php`
TYPE : admin CMS brut
AUTHENTIFICATION REQUISE : oui
ROLE REQUIS : admin ou editor
FONCTIONNALITES : edition HTML brut des pages stockees
BASE DE DONNEES : `pages`

PAGE : Settings
ROUTE : `/admin.php?action=settings`
FICHIER : `app/Views/admin/settings.php`
TYPE : admin configuration
AUTHENTIFICATION REQUISE : oui
ROLE REQUIS : admin ou editor
FONCTIONNALITES : settings globaux et SEO
BASE DE DONNEES : `settings`, `seo`

PAGE : Media
ROUTE : `/admin.php?action=media`
FICHIER : `app/Views/admin/media.php`
TYPE : admin media
AUTHENTIFICATION REQUISE : oui
ROLE REQUIS : admin ou editor pour upload, admin pour delete
FONCTIONNALITES : upload multiple, galerie, suppression
BASE DE DONNEES : `media_library`, `hero_slider` optionnel
UPLOAD : jpg, jpeg, png, gif, svg, webp, pdf, mp4, webm, mov; max 25 MB

PAGE : Messages
ROUTE : `/admin.php?action=messages`
FICHIER : `app/Views/admin/messages.php`
TYPE : admin lecture
AUTHENTIFICATION REQUISE : oui
ROLE REQUIS : admin ou editor
FONCTIONNALITES : liste messages contact
BASE DE DONNEES : `contact_messages`

PAGE : Appointments
ROUTE : `/admin.php?action=appointments`
FICHIER : `app/Views/admin/appointments.php`
TYPE : admin lecture
AUTHENTIFICATION REQUISE : oui
ROLE REQUIS : admin ou editor
FONCTIONNALITES : liste rendez-vous
BASE DE DONNEES : `appointments`

PAGE : Newsletter
ROUTE : `/admin.php?action=newsletter`
FICHIER : `app/Views/admin/newsletter.php`
TYPE : admin lecture
AUTHENTIFICATION REQUISE : oui
ROLE REQUIS : admin ou editor
FONCTIONNALITES : liste emails newsletter
BASE DE DONNEES : `newsletter`

PAGE : Users
ROUTE : `/admin.php?action=users`
FICHIER : `app/Views/admin/users.php`
TYPE : admin utilisateurs
AUTHENTIFICATION REQUISE : oui
ROLE REQUIS : admin pour creation via `save-user`; vue accessible apres `require_admin()` global
FONCTIONNALITES : creation utilisateur admin/editor, liste utilisateurs
BASE DE DONNEES : `users`, `roles`

PAGE : Activity
ROUTE : `/admin.php?action=activity`
FICHIER : `app/Views/admin/activity.php`
TYPE : admin audit
AUTHENTIFICATION REQUISE : oui
ROLE REQUIS : admin ou editor
FONCTIONNALITES : liste activites
BASE DE DONNEES : `activity_logs`

## 5. Fonctionnalites

| ID | Nom | Page | Fichier principal | Donnees | Tables DB | Entrees utilisateur | Sorties | Permissions | Impact migration | Difficulte | Priorite |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| F01 | Routage public | Public | `public/index.php` | slug URL | `pages` indirect | URL | HTML page | publique | Reproduire routes historiques | MEDIUM | HIGH |
| F02 | Rendu templates CMS | Public | `app/Core/TemplateRenderer.php` | HTML template + contenu DB | `pages`, `settings`, `seo` | URL | HTML final | publique | Convertir en composants React/Server Components | HIGH | HIGH |
| F03 | Injection contenu Home | Accueil | `TemplateRenderer.php` | sections home | `cms_sections`, `hero_slider` | aucun | HTML modifie | publique | Eviter les remplacements regex en Next.js | HIGH | HIGH |
| F04 | Liste services CMS | Services | `CmsContentRepository.php` | services | `cms_services` | aucun | cartes services | publique | Mapper en rendu data-driven | MEDIUM | HIGH |
| F05 | Contact public | Contact | `public/forms/contact.php` | message contact | `contact_messages` | nom, email, sujet, message, honeypot | OK/erreur texte | publique + CSRF | Server Action/API + validation Supabase | MEDIUM | HIGH |
| F06 | Rendez-vous public | Appointment | `public/forms/appointment.php` | demande RDV | `appointments` | nom, email, telephone, date, heure, departement, docteur, message | OK/erreur texte | publique + CSRF | Server Action/API + validation Supabase | MEDIUM | HIGH |
| F07 | Login admin | Admin login | `admin/index.php` | compte admin | `users`, `roles` | email/password | session admin | publique | Supabase Auth ou auth custom a choisir | CRITICAL | HIGH |
| F08 | Sessions admin | Admin | `app/bootstrap.php` | session PHP | session filesystem PHP | cookie session | etat connecte | admin/editor | Remplacer par cookies Supabase/Next middleware | HIGH | HIGH |
| F09 | Roles admin/editor | Admin | `admin/index.php` | role utilisateur | `roles`, `users` | aucun | autorisations | admin/editor | Mapper en claims/profiles/RLS | HIGH | HIGH |
| F10 | Edition HTML pages | Admin pages | `pages.php` | HTML brut | `pages` | slug, html_content | page mise a jour | admin/editor | Risque XSS et rendu React dangereux | CRITICAL | MEDIUM |
| F11 | Settings + SEO | Admin settings | `settings.php` | configuration | `settings`, `seo` | champs settings/seo | meta pages | admin/editor | Mapper metadata Next.js | MEDIUM | HIGH |
| F12 | Media library | Admin media | `admin/index.php` | fichiers | `media_library`, filesystem | fichiers multiples | fichiers publics | admin/editor, delete admin | Supabase Storage + table media | HIGH | HIGH |
| F13 | Hero slider | Admin hero | `hero_slider.php` | slides | `hero_slider`, `media_library` | image, titre, ordre, statut | slider public | admin/editor, delete admin | Composant React + Storage | HIGH | HIGH |
| F14 | CMS sections | Admin CMS | `cms_home.php`, `cms_about.php` | contenu sections | `cms_sections` | textes, boutons, images | sections publiques | admin/editor | Modele Supabase a conserver | MEDIUM | HIGH |
| F15 | CMS services CRUD | Admin services | `cms_services.php` | services | `cms_services` | formulaire service | liste publique/admin | admin/editor, delete admin | CRUD Supabase + RLS | MEDIUM | HIGH |
| F16 | Contact settings | Admin contact | `cms_contact.php` | coordonnees | `cms_contact_settings` | adresse, email, social, maps | contact public | admin/editor | Table key/value ou table structuree | MEDIUM | MEDIUM |
| F17 | Activity logs | Admin activity | `log_activity()` | evenement admin | `activity_logs` | actions admin | audit trail | admin/editor | Trigger/application logs | MEDIUM | MEDIUM |
| F18 | Newsletter | Admin newsletter | `newsletter.php` | emails newsletter | `newsletter` | UNKNOWN - A VERIFIER pour formulaire public | liste admin | admin/editor | Verifier collecte avant migration | LOW | LOW |
| F19 | Statistiques site | Schema SQL | UNKNOWN - A VERIFIER | visites | `site_statistics` | path/IP/user agent | statistiques | UNKNOWN | Table existe mais usage non detecte | LOW | LOW |
| F20 | Blog/commentaires | Schema SQL | UNKNOWN - A VERIFIER | articles/commentaires | `blog`, `blog_categories`, `blog_comments` | UNKNOWN | UNKNOWN | UNKNOWN | Tables existent mais usage non detecte | LOW | LOW |

## 6. Authentification

Connexion :

- Route POST : `/admin.php?action=login`
- Fichier : `admin/index.php`
- Vue : `app/Views/admin/login.php`
- Requete : `SELECT users.*, roles.name role_name FROM users JOIN roles ON roles.id = users.role_id WHERE email = ? LIMIT 1`
- Verification mot de passe : `password_verify(...)`
- Hash creation utilisateur : `password_hash(..., PASSWORD_DEFAULT)`
- Session apres login : `$_SESSION['admin_user'] = ['id', 'name', 'role']`
- Protection fixation session : `session_regenerate_id(true)`

Sessions :

- Demarrage dans `app/bootstrap.php`.
- Cookies avec `httponly => true`.
- `secure` active seulement si HTTPS detecte.
- `samesite => Lax`.
- Stockage de session : stockage PHP par defaut, emplacement exact UNKNOWN - A VERIFIER selon configuration PHP/XAMPP.

CSRF :

- Token stocke en session `$_SESSION['_csrf']`.
- Champ `_csrf` ajoute via `Security::csrfField()`.
- Verification via `hash_equals`.

Roles :

- `admin`
- `editor`

Permissions :

- Toute action admin apres login passe par `require_admin()`.
- Suppressions medias, services, hero slides et creation utilisateur exigent `require_admin('admin')`.
- Plusieurs pages admin sont visibles pour tout utilisateur connecte, meme si certaines actions POST sensibles sont restreintes.

Mot de passe oublie :

- UNKNOWN - A VERIFIER. Aucun fichier ou route detecte.

Tokens remember me :

- Colonne `users.remember_token` presente.
- Usage dans le code : non detecte.
- Statut : UNKNOWN - A VERIFIER / probablement non utilise.

Faiblesses de securite detectees :

- Compte seed `admin@example.com` avec mot de passe `password` documente dans le README.
- Edition HTML brut dans `pages.html_content`, risque XSS si un compte admin/editor est compromis ou si role editor non fiable.
- Upload autorise `svg`, ce qui peut poser un risque XSS si servi directement sans nettoyage.
- Uploads publics dans `public/uploads/`, sans controle d'acces.
- Type MIME utilise depuis `$_FILES['type']`, valeur fournie par le client; validation serveur par extension seulement.
- Pas de limitation de tentatives login detectee.
- Pas de reset password detecte.
- Pas de verification anti-CSRF sur logout si token invalide : l'action redirige quand meme, mais ne deconnecte pas.

## 7. Base de donnees

Connexion DB :

- Driver : PDO MySQL
- Fichier : `app/Core/Database.php`
- DSN : `mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4`
- Defaults : host `127.0.0.1`, port `3306`, database `clinic_db`
- `.env.example` indique database `Polyclinique Yetu_cms`
- Options : exceptions, fetch assoc, prepares emules desactives

Fichiers SQL :

- `database/clinic_db.sql` : schema principal
- `database/cms_migration.sql` : ajout CMS
- `database/seed.sql` : donnees initiales

Tables inventoriees :

| Table | Colonnes principales | Primary key | Foreign keys | Index/unique | Utilisee par | Sensible | Observations |
| --- | --- | --- | --- | --- | --- | --- | --- |
| `roles` | id, name, created_at | id | non | name unique | login/users | oui | roles admin/editor |
| `users` | id, role_id, name, email, password_hash, remember_token | id | role_id -> roles.id | email unique | login, users, media/logs | oui | a mapper avec Supabase Auth ou table profiles |
| `pages` | id, title, slug, template_file, html_content, is_active | id | non | slug unique | public render, admin pages | oui | HTML brut stocke |
| `sections` | id, page_id, slug, title, body_html, image | id | page_id -> pages.id cascade | non | non detecte | non | base pour tables LIKE |
| `menus` | id, location, label, url, sort_order, is_active | id | non | non | seed seulement detecte | non | navbar actuelle hardcodee dans include |
| `sliders` | LIKE sections | id herite | UNKNOWN - A VERIFIER | UNKNOWN | non detecte | non | MySQL `CREATE TABLE LIKE` a convertir |
| `hero` | LIKE sections | id herite | UNKNOWN - A VERIFIER | UNKNOWN | non detecte | non | probablement ancien modele |
| `about` | LIKE sections | id herite | UNKNOWN - A VERIFIER | UNKNOWN | non detecte | non | probablement ancien modele |
| `services` | LIKE sections | id herite | UNKNOWN - A VERIFIER | UNKNOWN | non detecte | non | attention conflit conceptuel avec `cms_services` |
| `projects` | LIKE sections | id herite | UNKNOWN - A VERIFIER | UNKNOWN | non detecte | non | non utilise actuellement |
| `portfolio` | LIKE sections | id herite | UNKNOWN - A VERIFIER | UNKNOWN | non detecte | non | non utilise actuellement |
| `gallery` | LIKE sections | id herite | UNKNOWN - A VERIFIER | UNKNOWN | non detecte | non | non utilise actuellement |
| `testimonials` | LIKE sections | id herite | UNKNOWN - A VERIFIER | UNKNOWN | non detecte | non | non utilise actuellement |
| `team` | LIKE sections | id herite | UNKNOWN - A VERIFIER | UNKNOWN | non detecte | non | non utilise actuellement |
| `partners` | LIKE sections | id herite | UNKNOWN - A VERIFIER | UNKNOWN | non detecte | non | non utilise actuellement |
| `faq` | LIKE sections | id herite | UNKNOWN - A VERIFIER | UNKNOWN | non detecte | non | non utilise actuellement |
| `blog_categories` | id, name, slug | id | non | slug unique | non detecte | non | feature dormante |
| `blog` | id, category_id, title, slug, excerpt, body_html | id | category_id -> blog_categories.id set null | slug unique | non detecte | potentiel | feature dormante |
| `blog_comments` | id, blog_id, name, email, comment | id | blog_id -> blog.id cascade | non | non detecte | oui | donnees personnelles |
| `contact_messages` | id, name, email, subject, message, ip_address, user_agent | id | non | non | contact/admin messages | oui | formulaire public actif |
| `appointments` | id, name, email, phone, date/time, department, doctor, status | id | non | non | appointment/admin | oui | donnees potentiellement medicales |
| `newsletter` | id, email, ip_address, is_active | id | non | email unique | admin newsletter | oui | collecte publique non detectee |
| `settings` | id, key, value, updated_at | id | non | key unique | renderer/settings | non | key/value |
| `seo` | id, page_slug, meta_title, description, keywords | id | non | page_slug unique | renderer/settings | non | meta dynamique |
| `social_links` | id, label, url, icon, sort_order | id | non | non | non detecte | non | settings sociaux reels dans `cms_contact_settings` |
| `media_library` | id, filename, original_name, path, mime_type, size_bytes | id | uploaded_by -> users.id set null | non | media/uploads/CMS | oui | fichiers publics |
| `site_statistics` | id, path, ip_address, user_agent | id | non | non | non detecte | oui | IP/user agent |
| `activity_logs` | id, user_id, action, description, ip_address | id | user_id -> users.id set null | non | log_activity/admin activity | oui | audit trail |
| `cms_sections` | id, page_slug, section_key, title, body, image_path | id | non | (page_slug, section_key) unique | CMS home/about | non | modele actif |
| `cms_services` | id, title, slug, description, image_path, icon_class | id | non | slug unique | services/admin | non | modele actif |
| `cms_contact_settings` | id, key, value | id | non | key unique | contact/admin contact | non | key/value |
| `hero_slider` | id, image, title, subtitle, order, status | id | non | non | hero slider/admin | non | modele actif |

Incompatibilites MySQL -> PostgreSQL/Supabase a prevoir :

- `AUTO_INCREMENT` -> `identity` ou `serial`.
- `INT UNSIGNED` / `BIGINT UNSIGNED` -> types PostgreSQL sans unsigned.
- `TINYINT(1)` -> `boolean`.
- `MEDIUMTEXT` -> `text`.
- `ON UPDATE CURRENT_TIMESTAMP` -> trigger PostgreSQL `updated_at`.
- Backticks MySQL autour de `key`/`value` -> guillemets ou renommage.
- `ON DUPLICATE KEY UPDATE` -> `INSERT ... ON CONFLICT`.
- `CREATE TABLE ... LIKE sections` -> non portable tel quel.
- `ROW_NUMBER()` existe en PostgreSQL, mais syntaxe globale du script a adapter.

## 8. UI/UX

Le front public provient du template BootstrapMade "Polyclinique Yetu", mis a jour le 23 juillet 2025 avec Bootstrap 5.3.7 selon `public/assets/js/main.js`.

Systeme visuel public :

- Framework : Bootstrap 5.3.7.
- Fonts : Roboto, Montserrat, Lato via Google Fonts.
- Couleur de fond principale : `#ffffff`.
- Couleur texte : `#3c4049`.
- Couleur titres : `#112344`.
- Couleur accent : `#14b11ffd`.
- Couleur section alternative : `#f4f8ff`.
- Footer sombre : `#021418`.
- Layout : header fixed-top, topbar possible, navbar responsive, sections pleine largeur avec containers Bootstrap.
- Composants : hero, cartes services, badges, compteurs, CTA, footer, formulaires, iframe map, boutons arrondis selon Bootstrap/template.
- Animations : AOS, PureCounter, transitions header/nav, slider hero CMS injecte.
- Responsive : breakpoints Bootstrap; nav desktop a partir de 1200px, mobile sous 1199px; ajustements specifiques sous 575px et 991px.

Systeme visuel admin :

- CSS principal admin : `public/admin/assets/admin.css`.
- Couleurs : fond `#f6f8fb`, panneau `#fff`, texte `#152033`, primaire `#1977cc`, danger `#be3434`.
- Layout : sidebar fixe 250px, contenu avec `main` marge gauche, responsive sous 760px.
- Composants : cards, panels, tables, formulaires, media grid, login card.
- Un autre fichier `hms-style.css` contient une UI type register avec gradient bleu/violet; usage actuel precis UNKNOWN - A VERIFIER.

Objectif migration UI :

- Reproduire d'abord Bootstrap/template et CSS existants.
- Eviter tout redesign pendant la phase migration.
- Extraire header/navbar/footer et sections en composants React seulement apres capture du comportement visuel actuel.

## 9. CSS/SCSS

Fichiers CSS/SCSS detectes :

- `public/assets/css/main.css` : 139972 octets, CSS principal public.
- `public/assets/scss/Readme.txt` : pas de SCSS applicatif detecte.
- `public/admin/assets/admin.css` : CSS admin actif probable.
- `public/admin/assets/hms-style.css` : CSS admin/ancien style.
- Duplicats dans `admin/assets/`.
- Vendor CSS : Bootstrap, Bootstrap Icons, Font Awesome, AOS, GLightbox, Swiper.

Variables CSS publiques :

- `--default-font`
- `--heading-font`
- `--nav-font`
- `--background-color`
- `--default-color`
- `--heading-color`
- `--accent-color`
- `--surface-color`
- `--contrast-color`
- `--nav-color`
- `--nav-hover-color`
- `--nav-mobile-background-color`
- `--nav-dropdown-background-color`
- `--nav-dropdown-color`
- `--nav-dropdown-hover-color`

Framework CSS :

- Bootstrap detecte.
- Tailwind : non detecte.
- Material UI : non detecte.
- CSS proprietaire : oui, `main.css` et `admin.css`.

## 10. JavaScript

Fichiers JS principaux :

- `public/assets/js/main.js`
- `public/assets/vendor/php-email-form/validate.js`
- Vendor : Bootstrap, AOS, GLightbox, PureCounter, Swiper

Interactions detectees dans `main.js` :

- Ajout/retrait de la classe `scrolled` au body selon scroll.
- Toggle menu mobile via `.mobile-nav-toggle`.
- Fermeture nav mobile au clic sur lien.
- Toggle dropdown mobile.
- Suppression du preloader au chargement.
- Bouton scroll top avec scroll smooth.
- Initialisation AOS.
- Initialisation GLightbox.
- Initialisation PureCounter.
- Initialisation Swiper a partir de `.init-swiper` et JSON `.swiper-config`.
- Toggle FAQ.

AJAX/fetch :

- `public/assets/vendor/php-email-form/validate.js` intercepte les formulaires `.php-email-form`.
- Envoie `fetch(action, { method: 'POST', body: FormData, headers: {'X-Requested-With': 'XMLHttpRequest'} })`.
- Attend une reponse texte `OK`.
- Affiche loading/error/sent message selon resultat.

JS inline detecte :

- `TemplateRenderer::injectHeroSliderAssets()` injecte CSS + JS inline pour slider hero CMS si plusieurs slides.
- `app/Views/admin/hero_slider.php` contient un JS inline pour drag/drop et reordering des slides.

jQuery :

- Non detecte dans les fichiers inspectes.

## 11. Uploads

Emplacements :

- Stockage physique : `public/uploads/`.
- Metadata : table `media_library`.
- Fonction upload partagee : `store_uploaded_media()` dans `admin/index.php`.

Types detectes :

| Type | Emplacement actuel | Nommage | Validation | Taille max | Extensions | Permissions | Utilisation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| Image CMS section | `public/uploads/` | `bin2hex(random_bytes(12)).ext` | extension + erreur upload | 25 MB | jpg, jpeg, png, gif, svg, webp | admin/editor | sections home/about/services |
| Video CMS section | `public/uploads/` | random hex | extension + erreur upload | 25 MB | mp4, webm, mov | admin/editor | champ video_url CMS |
| Media library | `public/uploads/` | random hex | extension + taille | 25 MB | jpg, jpeg, png, gif, svg, webp, pdf, mp4, webm, mov | admin/editor upload, admin delete | galerie admin, option hero slider |
| Hero slider image | `public/uploads/` | random hex | extension image via helper | 25 MB | jpg, jpeg, png, gif, svg, webp | admin/editor save, admin delete | hero public |

Fichiers uploades observes :

- 6 fichiers dans `public/uploads/`.
- Extensions observees : PNG et WEBP.

Risques upload :

- `svg` autorise.
- Fichiers servis publiquement.
- Pas de scan antivirus detecte.
- Pas de validation MIME serveur fiable detectee.
- Suppression physique par `@unlink`.

Migration cible :

- Supabase Storage bucket public ou prive selon usage.
- Table `media_library` conservee/adaptee.
- Politiques RLS strictes pour upload/delete.
- Validation extension + MIME cote serveur.

## 12. Emails/notifications

Emails sortants :

- `mail()` : non detecte.
- PHPMailer : non detecte.
- SMTP : non detecte.
- Service email externe : non detecte.

Notifications internes :

- Flash session admin : login invalide, hero slide sans image.
- Messages de formulaire public : reponse texte `OK`, erreurs 419/422.
- Table `contact_messages` pour demandes contact.
- Table `appointments` pour demandes de rendez-vous.
- Table `newsletter` existe mais formulaire public de souscription non detecte.

SMS/WhatsApp :

- Champs sociaux dans `cms_contact_settings`, dont `whatsapp_url`.
- Envoi SMS/WhatsApp : non detecte.

Statut : pas de notification sortante active trouvee. UNKNOWN - A VERIFIER pour besoins metier hors code.

## 13. Dependances

PHP :

- README indique PHP 8.3+.
- Extensions PHP requises probables : PDO, pdo_mysql, mbstring, fileinfo conseillé pour migration upload; exactes UNKNOWN - A VERIFIER.

Composer :

- Aucun `composer.json` detecte.

Node/package :

- Aucun `package.json` detecte.

Librairies frontend locales :

- Bootstrap 5.3.7
- Bootstrap Icons
- Font Awesome Free
- AOS
- GLightbox
- PureCounter
- Swiper
- BootstrapMade PHP Email Form Validation

CDN/APIs externes :

- Google Fonts.
- Google Maps iframe.
- BootstrapMade template/licence mentionnee.

Autres fichiers :

- `Hospital-Management-System-master.zip` present a la racine, contenu non audite car archive non extraite pendant cette mission.
- `Dockerfile.txt` present.

## 14. Risques

| Risque | Niveau | Detail | Mitigation proposee |
| --- | --- | --- | --- |
| Perte de contenu HTML stocke en DB | CRITICAL | Plusieurs pages routees n'ont pas de fichier PHP local visible. | Export complet MySQL avant toute migration. |
| Incompatibilite MySQL/PostgreSQL | HIGH | `AUTO_INCREMENT`, `UNSIGNED`, `TINYINT`, `ON UPDATE`, `ON DUPLICATE KEY`, `CREATE TABLE LIKE`. | Migration SQL manuelle et tests d'import. |
| Auth admin | CRITICAL | Sessions PHP et roles custom a remplacer ou adapter avec Supabase Auth. | Decider Supabase Auth + table profiles/roles avant implementation. |
| Edition HTML brut | CRITICAL | Risque XSS et probleme de rendu React si `dangerouslySetInnerHTML`. | Sanitization, permissions strictes, eventuellement migration en blocs CMS. |
| Upload SVG public | HIGH | SVG peut contenir scripts. | Interdire SVG ou sanitizer strictement. |
| Donnees sensibles medicales | CRITICAL | Rendez-vous, messages, IP, user agents. | RLS, chiffrement logique si besoin, politiques retention, acces admin strict. |
| Routes historiques | HIGH | Liens `.html` et `.php` melanges. | Redirections Next.js exactes et inventaire SEO. |
| UI/UX casse | HIGH | CSS template volumineux et comportements JS multiples. | Snapshot visuel avant migration, migration composant par composant. |
| Contenu en base non visible dans fichiers | HIGH | `pages.html_content` peut remplacer les fichiers. | Dump data obligatoire avant conception finale. |
| Absence de tests automatises | MEDIUM | Aucun test detecte. | Ajouter checklist regression et tests Playwright pendant migration. |
| Mot de passe admin seed | HIGH | Identifiant par defaut documente. | Changement obligatoire avant production. |
| Pas de rate limit login | MEDIUM | Brute force possible. | Rate limiting Next middleware/API. |
| Emails non implementes | MEDIUM | Contact/RDV stockes seulement en DB. | Decider notification email en phase planification. |
| URLs assets relatives | MEDIUM | Templates utilisent `assets/...`, `uploads/...`. | Strategie `public/` Next.js ou Supabase Storage. |
| Tables dormantes | MEDIUM | Blog, comments, stats, sections-like non utilisees. | Valider avec metier avant suppression ou migration. |

## 15. Architecture cible proposee

| Element PHP | Equivalent Next.js | Equivalent Supabase | Priorite | Difficulte |
| --- | --- | --- | --- | --- |
| `public/index.php` routeur | App Router + redirects | n/a | HIGH | MEDIUM |
| `app/Views/pages/*.php` | `app/(public)/.../page.tsx` | tables CMS pour contenu | HIGH | HIGH |
| `includes/header.php` | `components/site/Header.tsx` | `menus` ou config CMS si dynamique | HIGH | MEDIUM |
| `includes/navbar.php` | `components/site/Navbar.tsx` | `menus` si active | HIGH | MEDIUM |
| `includes/footer.php` | `components/site/Footer.tsx` | `settings`, `cms_contact_settings` | HIGH | MEDIUM |
| `TemplateRenderer` | Server Components + data fetchers | `pages`, `seo`, `settings` | HIGH | HIGH |
| `CmsContentRepository` | `lib/db/cms.ts` + Server Actions | `cms_sections`, `cms_services`, `hero_slider` | HIGH | MEDIUM |
| `public/forms/contact.php` | Server Action/API Route | `contact_messages` | HIGH | MEDIUM |
| `public/forms/appointment.php` | Server Action/API Route | `appointments` | HIGH | MEDIUM |
| PHP sessions | Supabase Auth cookies/middleware | `auth.users`, `profiles`, `roles` | HIGH | CRITICAL |
| `users`/`roles` | Admin profile/role model | Supabase Auth + `profiles`/`roles` | HIGH | CRITICAL |
| `media_library` + filesystem | Upload actions + media admin | Supabase Storage + `media_library` | HIGH | HIGH |
| `settings`/`seo` | Metadata API + admin forms | `settings`, `seo` | HIGH | MEDIUM |
| `activity_logs` | logging service/server action | `activity_logs` | MEDIUM | MEDIUM |
| `main.css` | conserve dans `app/globals.css` ou imported CSS | n/a | HIGH | MEDIUM |
| Vendor JS | React equivalents ou client components | n/a | HIGH | HIGH |

## 16. Plan de migration

Ne pas commencer cette phase sans validation.

Plan recommande :

1. Export complet MySQL et dossier `public/uploads`.
2. Valider la liste des pages réellement utilisees, surtout les 10 slugs sans fichier PHP local.
3. Concevoir le schema Supabase PostgreSQL a partir des tables actives et dormantes.
4. Decider l'authentification : Supabase Auth complet ou conservation temporaire des users custom.
5. Creer un projet Next.js separe, sans toucher au PHP.
6. Importer d'abord les assets CSS/images existants pour reproduire le rendu.
7. Migrer header/navbar/footer en composants React fideles.
8. Migrer les pages publiques existantes une par une.
9. Migrer formulaires contact/rendez-vous vers Server Actions/API.
10. Migrer admin login et permissions.
11. Migrer CRUD CMS : settings, pages, sections, services, hero slider, media.
12. Migrer uploads vers Supabase Storage.
13. Mettre en place tests visuels et fonctionnels.
14. Preparer redirects `.html` et `.php`.
15. Basculer en beta, puis production apres validation.

## 17. Elements inconnus

- Contenu reel de la base MySQL actuelle non lu directement depuis le serveur MySQL.
- Valeur exacte de `.env` non documentee ici pour eviter d'exposer des secrets.
- Pages routees mais absentes du dossier `app/Views/pages` : contenu en base a verifier.
- Formulaire newsletter public non detecte.
- Usage reel de `site_statistics`, `blog`, `blog_comments`, `menus`, `social_links`, tables `LIKE sections` a confirmer.
- Contenu de `Hospital-Management-System-master.zip` non audite.
- Version PHP installee localement UNKNOWN - A VERIFIER par execution `php -v`.
- Configuration Apache/XAMPP exacte UNKNOWN - A VERIFIER.
- Presence de donnees personnelles/medicales reelles dans la base UNKNOWN - A VERIFIER.
- Politique de conservation des donnees UNKNOWN - A VERIFIER.

## 18. Recommandations

Recommandation principale : faire la migration comme un remplacement progressif controle, pas comme une reecriture massive.

Decisions a prendre avant MISSION-02 :

- Migrer toutes les tables, y compris dormantes, ou seulement les tables actives ?
- Utiliser Supabase Auth pour les admins des maintenant ?
- Garder l'edition HTML brut des pages ou transformer progressivement en blocs CMS ?
- Rendre les uploads publics ou prives dans Supabase Storage ?
- Conserver les URLs `.php`/`.html` avec redirects permanents ?
- Ajouter des notifications email pour contact/rendez-vous pendant la migration ou rester iso-fonctionnel ?

Priorites immediates :

- Dump MySQL complet.
- Export `public/uploads`.
- Verification du contenu `pages.html_content`.
- Validation des pages publiques manquantes.
- Conception PostgreSQL/Supabase avec RLS.

