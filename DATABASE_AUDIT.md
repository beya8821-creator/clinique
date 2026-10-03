# DATABASE AUDIT

Date : 2026-09-06
Projet : `C:\xampp\htdocs\clinic-php-cms`
Mission : MISSION-02 - Audit et conception de la base de donnees

Statut important : MYSQL DATABASE ACCESS UNAVAILABLE.

La connexion reelle a MySQL a ete tentee en lecture seule via la configuration locale du projet. Le serveur MySQL a refuse la connexion sur `127.0.0.1:3306`. L'audit ci-dessous s'appuie donc sur les dumps SQL presents dans `database/` et sur les requetes trouvees dans le code PHP. Le schema est fiable au niveau fichiers, mais les volumes reels, donnees orphelines et contenus `pages.html_content` reels restent UNKNOWN - A VERIFIER.

## 1. Source MySQL

Sources analysees :

- `database/clinic_db.sql`
- `database/cms_migration.sql`
- `database/seed.sql`
- `app/Core/Database.php`
- `app/Core/TemplateRenderer.php`
- `app/Repositories/CmsContentRepository.php`
- `admin/index.php`
- `public/forms/contact.php`
- `public/forms/appointment.php`
- vues admin dans `app/Views/admin/`

Fichiers SQL detectes :

| Fichier | Role | Taille | Observation |
| --- | --- | ---: | --- |
| `database/clinic_db.sql` | Schema principal complet | 8839 octets | 32 `CREATE TABLE` detectes |
| `database/cms_migration.sql` | Ajout/seed CMS partiel | 7897 octets | CMS sections, services, contact, hero slider |
| `database/seed.sql` | Donnees initiales | 7361 octets | roles, user admin seed, pages, settings, SEO, menu |

## 2. Connexion

Configuration effective lue dans `.env` et le code :

```text
HOST : 127.0.0.1
DATABASE : clinic_db
USER : root
PORT : 3306
DRIVER : PDO MySQL
CHARSET : utf8mb4
PASSWORD : SECRET FOUND - valeur masquee
```

Fichier de connexion : `app/Core/Database.php`

Options PDO :

- `PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION`
- `PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC`
- `PDO::ATTR_EMULATE_PREPARES => false`

Ecart detecte :

- `README.md` indique PHP 8.3+.
- PHP CLI XAMPP detecte : PHP 8.2.12.
- `.env.example` indique `DB_DATABASE=Polyclinique Yetu_cms`.
- `.env` local indique `DB_DATABASE=clinic_db`.

## 3. Tables

Schema MySQL detecte : 32 tables.

Tables actives dans le code :

- `roles`
- `users`
- `pages`
- `contact_messages`
- `appointments`
- `newsletter`
- `settings`
- `seo`
- `media_library`
- `activity_logs`
- `cms_sections`
- `cms_services`
- `cms_contact_settings`
- `hero_slider`

Tables presentes mais sans usage PHP detecte :

- `sections`
- `menus`
- `sliders`
- `hero`
- `about`
- `services`
- `projects`
- `portfolio`
- `gallery`
- `testimonials`
- `team`
- `partners`
- `faq`
- `blog_categories`
- `blog`
- `blog_comments`
- `social_links`
- `site_statistics`

### Fiches tables

TABLE : `roles`
DESCRIPTION : roles administratifs.
UTILISATION : login admin, creation utilisateur, jointure avec `users`.
NOMBRE DE COLONNES : 3
PRIMARY KEY : `id`
FOREIGN KEYS : aucune
UNIQUE : `name`
INDEX : primary key, unique `name`
TRIGGERS : aucun dans dump
UTILISEE PAR : `admin/index.php`, `app/Views/admin/users.php`, `seed.sql`
IMPORTANCE : CRITICAL
SENSIBILITE : INTERNAL

TABLE : `users`
DESCRIPTION : comptes administrateurs/editeurs PHP.
UTILISATION : authentification admin, creation utilisateur, reference uploads/logs.
NOMBRE DE COLONNES : 8
PRIMARY KEY : `id`
FOREIGN KEYS : `role_id -> roles.id`
UNIQUE : `email`
INDEX : primary key, unique `email`, FK `role_id`
TRIGGERS : aucun dans dump
UTILISEE PAR : login, users admin, media, activity logs
IMPORTANCE : CRITICAL
SENSIBILITE : SENSITIVE

TABLE : `pages`
DESCRIPTION : pages publiques CMS, y compris HTML brut optionnel.
UTILISATION : rendu public, edition admin, SEO indirect.
NOMBRE DE COLONNES : 8
PRIMARY KEY : `id`
FOREIGN KEYS : aucune
UNIQUE : `slug`
INDEX : primary key, unique `slug`
TRIGGERS : aucun dans dump
UTILISEE PAR : `TemplateRenderer`, `pages.php`, dashboard
IMPORTANCE : CRITICAL
SENSIBILITE : ADMIN

TABLE : `sections`
DESCRIPTION : modele generique ancien pour sections CMS.
UTILISATION : base de tables `CREATE TABLE ... LIKE sections`; usage PHP non detecte.
NOMBRE DE COLONNES : 11
PRIMARY KEY : `id`
FOREIGN KEYS : `page_id -> pages.id ON DELETE CASCADE`
UNIQUE : aucune
INDEX : primary key, FK `page_id`
TRIGGERS : aucun
UTILISEE PAR : dump uniquement
IMPORTANCE : LOW
SENSIBILITE : INTERNAL

TABLE : `menus`
DESCRIPTION : navigation dynamique potentielle.
UTILISATION : seed seulement; navbar actuelle hardcodee.
NOMBRE DE COLONNES : 6
PRIMARY KEY : `id`
FOREIGN KEYS : aucune
UNIQUE : aucune
INDEX : primary key
TRIGGERS : aucun
UTILISEE PAR : `seed.sql`
IMPORTANCE : MEDIUM
SENSIBILITE : PUBLIC

TABLES : `sliders`, `hero`, `about`, `services`, `projects`, `portfolio`, `gallery`, `testimonials`, `team`, `partners`, `faq`
DESCRIPTION : tables clones de `sections` via `CREATE TABLE ... LIKE sections`.
UTILISATION : aucun usage PHP detecte.
NOMBRE DE COLONNES : herite de `sections` dans MySQL, mais les FK ne sont pas toujours copiees par `CREATE TABLE LIKE`; a verifier sur base reelle.
PRIMARY KEY : probablement `id`
FOREIGN KEYS : UNKNOWN - A VERIFIER sur base reelle
UNIQUE : UNKNOWN - A VERIFIER
INDEX : UNKNOWN - A VERIFIER
TRIGGERS : aucun dans dump
UTILISEE PAR : non detecte
IMPORTANCE : LOW
SENSIBILITE : PUBLIC/INTERNAL selon contenu reel

TABLE : `blog_categories`
DESCRIPTION : categories blog dormantes.
UTILISATION : non detectee dans code PHP.
NOMBRE DE COLONNES : 3
PRIMARY KEY : `id`
FOREIGN KEYS : aucune
UNIQUE : `slug`
INDEX : primary key, unique `slug`
TRIGGERS : aucun
IMPORTANCE : LOW
SENSIBILITE : PUBLIC

TABLE : `blog`
DESCRIPTION : articles blog dormants.
UTILISATION : non detectee dans code PHP.
NOMBRE DE COLONNES : 9
PRIMARY KEY : `id`
FOREIGN KEYS : `category_id -> blog_categories.id ON DELETE SET NULL`
UNIQUE : `slug`
INDEX : primary key, unique `slug`, FK `category_id`
TRIGGERS : aucun
IMPORTANCE : LOW
SENSIBILITE : PUBLIC/ADMIN

TABLE : `blog_comments`
DESCRIPTION : commentaires blog dormants.
UTILISATION : non detectee dans code PHP.
NOMBRE DE COLONNES : 7
PRIMARY KEY : `id`
FOREIGN KEYS : `blog_id -> blog.id ON DELETE CASCADE`
UNIQUE : aucune
INDEX : primary key, FK `blog_id`
TRIGGERS : aucun
IMPORTANCE : LOW
SENSIBILITE : SENSITIVE

TABLE : `contact_messages`
DESCRIPTION : messages envoyes depuis le formulaire public.
UTILISATION : creation publique, lecture admin.
NOMBRE DE COLONNES : 9
PRIMARY KEY : `id`
FOREIGN KEYS : aucune
UNIQUE : aucune
INDEX : primary key
TRIGGERS : aucun
UTILISEE PAR : `public/forms/contact.php`, `messages.php`, dashboard
IMPORTANCE : HIGH
SENSIBILITE : SENSITIVE

TABLE : `appointments`
DESCRIPTION : demandes de rendez-vous.
UTILISATION : creation publique, lecture admin.
NOMBRE DE COLONNES : 12
PRIMARY KEY : `id`
FOREIGN KEYS : aucune
UNIQUE : aucune
INDEX : primary key
TRIGGERS : aucun
UTILISEE PAR : `public/forms/appointment.php`, `appointments.php`, dashboard
IMPORTANCE : HIGH
SENSIBILITE : SENSITIVE

TABLE : `newsletter`
DESCRIPTION : emails newsletter.
UTILISATION : lecture admin; formulaire public non detecte.
NOMBRE DE COLONNES : 5
PRIMARY KEY : `id`
FOREIGN KEYS : aucune
UNIQUE : `email`
INDEX : primary key, unique `email`
TRIGGERS : aucun
IMPORTANCE : MEDIUM
SENSIBILITE : SENSITIVE

TABLE : `settings`
DESCRIPTION : parametres globaux key/value.
UTILISATION : rendu public et admin settings.
NOMBRE DE COLONNES : 4
PRIMARY KEY : `id`
FOREIGN KEYS : aucune
UNIQUE : `key`
INDEX : primary key, unique `key`
TRIGGERS : aucun
IMPORTANCE : HIGH
SENSIBILITE : INTERNAL

TABLE : `seo`
DESCRIPTION : metadonnees SEO par page.
UTILISATION : `TemplateRenderer`, admin settings.
NOMBRE DE COLONNES : 7
PRIMARY KEY : `id`
FOREIGN KEYS : aucune
UNIQUE : `page_slug`
INDEX : primary key, unique `page_slug`
TRIGGERS : aucun
IMPORTANCE : HIGH
SENSIBILITE : PUBLIC/INTERNAL

TABLE : `social_links`
DESCRIPTION : liens sociaux generiques.
UTILISATION : non detectee; les liens sociaux actifs semblent dans `cms_contact_settings`.
NOMBRE DE COLONNES : 6
PRIMARY KEY : `id`
FOREIGN KEYS : aucune
UNIQUE : aucune
INDEX : primary key
TRIGGERS : aucun
IMPORTANCE : LOW
SENSIBILITE : PUBLIC

TABLE : `media_library`
DESCRIPTION : metadonnees de fichiers uploades.
UTILISATION : upload admin, galerie admin, references images CMS.
NOMBRE DE COLONNES : 9
PRIMARY KEY : `id`
FOREIGN KEYS : `uploaded_by -> users.id ON DELETE SET NULL`
UNIQUE : aucune
INDEX : primary key, FK `uploaded_by`
TRIGGERS : aucun
IMPORTANCE : HIGH
SENSIBILITE : SENSITIVE

TABLE : `site_statistics`
DESCRIPTION : traces de visites potentielles.
UTILISATION : non detectee dans code PHP.
NOMBRE DE COLONNES : 5
PRIMARY KEY : `id`
FOREIGN KEYS : aucune
UNIQUE : aucune
INDEX : primary key
TRIGGERS : aucun
IMPORTANCE : LOW
SENSIBILITE : SENSITIVE

TABLE : `activity_logs`
DESCRIPTION : historique actions admin.
UTILISATION : `log_activity()`, vue activity.
NOMBRE DE COLONNES : 6
PRIMARY KEY : `id`
FOREIGN KEYS : `user_id -> users.id ON DELETE SET NULL`
UNIQUE : aucune
INDEX : primary key, FK `user_id`
TRIGGERS : aucun
IMPORTANCE : MEDIUM
SENSIBILITE : SENSITIVE

TABLE : `cms_sections`
DESCRIPTION : contenu structure home/about.
UTILISATION : admin CMS, rendu public.
NOMBRE DE COLONNES : 14
PRIMARY KEY : `id`
FOREIGN KEYS : aucune
UNIQUE : `(page_slug, section_key)`
INDEX : primary key, unique composite
TRIGGERS : aucun
IMPORTANCE : HIGH
SENSIBILITE : INTERNAL/PUBLIC

TABLE : `cms_services`
DESCRIPTION : services medicaux affiches publiquement.
UTILISATION : admin CRUD, page services.
NOMBRE DE COLONNES : 12
PRIMARY KEY : `id`
FOREIGN KEYS : aucune
UNIQUE : `slug`
INDEX : primary key, unique `slug`
TRIGGERS : aucun
IMPORTANCE : HIGH
SENSIBILITE : PUBLIC

TABLE : `cms_contact_settings`
DESCRIPTION : coordonnees et liens contact key/value.
UTILISATION : page contact, header/telephone, admin contact.
NOMBRE DE COLONNES : 4
PRIMARY KEY : `id`
FOREIGN KEYS : aucune
UNIQUE : `key`
INDEX : primary key, unique `key`
TRIGGERS : aucun
IMPORTANCE : HIGH
SENSIBILITE : PUBLIC/INTERNAL

TABLE : `hero_slider`
DESCRIPTION : slides hero de la page d'accueil.
UTILISATION : rendu public et admin hero slider.
NOMBRE DE COLONNES : 10
PRIMARY KEY : `id`
FOREIGN KEYS : aucune
UNIQUE : aucune
INDEX : primary key
TRIGGERS : aucun
IMPORTANCE : HIGH
SENSIBILITE : PUBLIC

## 4. Colonnes

### Colonnes par table et equivalent PostgreSQL

`roles`

| Colonne | Type MySQL | Nullable | Default | Cles | Code | Description | PostgreSQL |
| --- | --- | --- | --- | --- | --- | --- | --- |
| id | INT UNSIGNED AUTO_INCREMENT | non | auto | PK | oui | identifiant role | integer generated by default as identity |
| name | VARCHAR(50) | non | aucun | UNIQUE | oui | nom role | varchar(50) |
| created_at | TIMESTAMP | oui | CURRENT_TIMESTAMP | non | seed | creation | timestamptz default now() |

`users`

| Colonne | Type MySQL | Nullable | Default | Cles | Code | Description | PostgreSQL |
| --- | --- | --- | --- | --- | --- | --- | --- |
| id | INT UNSIGNED AUTO_INCREMENT | non | auto | PK | oui | id legacy user | integer ou uuid via profiles |
| role_id | INT UNSIGNED | non | aucun | FK | oui | role admin/editor | integer ou FK roles |
| name | VARCHAR(120) | non | aucun | non | oui | nom affichage | varchar(120) |
| email | VARCHAR(190) | non | aucun | UNIQUE | oui | login email | citext ou varchar(190) unique |
| password_hash | VARCHAR(255) | non | aucun | non | oui | hash PHP | ne pas conserver dans auth.users |
| remember_token | VARCHAR(120) | oui | NULL | non | non detecte | token dormant | text nullable ou deprecate |
| created_at | TIMESTAMP | oui | CURRENT_TIMESTAMP | non | oui | creation | timestamptz default now() |
| updated_at | TIMESTAMP | oui | ON UPDATE | non | oui | mise a jour | timestamptz + trigger |

`pages`

| Colonne | Type MySQL | Nullable | Default | Cles | Code | Description | PostgreSQL |
| --- | --- | --- | --- | --- | --- | --- | --- |
| id | INT UNSIGNED AUTO_INCREMENT | non | auto | PK | oui | id page | integer identity |
| title | VARCHAR(190) | non | aucun | non | oui | titre admin | varchar(190) |
| slug | VARCHAR(190) | non | aucun | UNIQUE | oui | route page | varchar(190) unique |
| template_file | VARCHAR(190) | non | aucun | non | seed | fichier template | varchar(190) |
| html_content | MEDIUMTEXT | oui | NULL | non | oui | HTML brut CMS | text |
| is_active | TINYINT(1) | oui | 1 | index conseille | oui | publication | boolean default true |
| created_at | TIMESTAMP | oui | CURRENT_TIMESTAMP | non | oui | creation | timestamptz default now() |
| updated_at | TIMESTAMP | oui | ON UPDATE | non | oui | update | timestamptz + trigger |

`sections` et tables clones

| Colonne | Type MySQL | Nullable | Default | Cles | Code | Description | PostgreSQL |
| --- | --- | --- | --- | --- | --- | --- | --- |
| id | INT UNSIGNED AUTO_INCREMENT | non | auto | PK | non detecte | id section | integer identity |
| page_id | INT UNSIGNED | oui | NULL | FK dans `sections` | non detecte | page rattachee | integer nullable |
| slug | VARCHAR(190) | non | aucun | index conseille | non detecte | identifiant section | varchar(190) |
| title | VARCHAR(190) | oui | NULL | non | non detecte | titre | varchar(190) |
| subtitle | VARCHAR(255) | oui | NULL | non | non detecte | sous-titre | varchar(255) |
| body_html | MEDIUMTEXT | oui | NULL | non | non detecte | HTML section | text |
| image | VARCHAR(255) | oui | NULL | non | non detecte | image | text |
| button_text | VARCHAR(120) | oui | NULL | non | non detecte | libelle bouton | varchar(120) |
| button_url | VARCHAR(255) | oui | NULL | non | non detecte | URL bouton | text |
| sort_order | INT | oui | 0 | index conseille | non detecte | tri | integer default 0 |
| is_active | TINYINT(1) | oui | 1 | index conseille | non detecte | actif | boolean default true |

`contact_messages`

| Colonne | Type MySQL | Nullable | Default | Cles | Code | Description | PostgreSQL |
| --- | --- | --- | --- | --- | --- | --- | --- |
| id | INT UNSIGNED AUTO_INCREMENT | non | auto | PK | oui | id message | bigint identity |
| name | VARCHAR(120) | non | aucun | non | oui | nom expediteur | varchar(120) |
| email | VARCHAR(190) | non | aucun | index conseille | oui | email | citext ou varchar(190) |
| subject | VARCHAR(190) | oui | NULL | non | oui | sujet | varchar(190) |
| message | TEXT | non | aucun | non | oui | contenu | text |
| ip_address | VARCHAR(64) | oui | NULL | non | oui | IP | inet ou varchar(64) |
| user_agent | VARCHAR(255) | oui | NULL | non | oui | navigateur | text |
| is_read | TINYINT(1) | oui | 0 | index conseille | admin | lu/non lu | boolean default false |
| created_at | TIMESTAMP | oui | CURRENT_TIMESTAMP | index conseille | oui | creation | timestamptz default now() |

`appointments`

| Colonne | Type MySQL | Nullable | Default | Cles | Code | Description | PostgreSQL |
| --- | --- | --- | --- | --- | --- | --- | --- |
| id | INT UNSIGNED AUTO_INCREMENT | non | auto | PK | oui | id RDV | bigint identity |
| name | VARCHAR(120) | non | aucun | non | oui | nom patient | varchar(120) |
| email | VARCHAR(190) | non | aucun | index conseille | oui | email | citext ou varchar(190) |
| phone | VARCHAR(80) | non | aucun | non | oui | telephone | varchar(80) |
| appointment_date | VARCHAR(80) | oui | NULL | index conseille | oui | date demandee | date ou text pendant migration |
| appointment_time | VARCHAR(80) | oui | NULL | non | oui | heure demandee | time ou text pendant migration |
| department | VARCHAR(120) | oui | NULL | index conseille | oui | departement | varchar(120) |
| doctor | VARCHAR(120) | oui | NULL | non | oui | medecin | varchar(120) |
| message | TEXT | oui | NULL | non | oui | message | text |
| status | VARCHAR(40) | oui | new | index conseille | admin | statut | text + CHECK |
| ip_address | VARCHAR(64) | oui | NULL | non | oui | IP | inet ou varchar(64) |
| created_at | TIMESTAMP | oui | CURRENT_TIMESTAMP | index conseille | oui | creation | timestamptz default now() |

`newsletter`, `settings`, `seo`, `cms_contact_settings`

| Table | Colonnes | Conversions principales |
| --- | --- | --- |
| newsletter | id, email, ip_address, is_active, created_at | id identity, email citext unique, is_active boolean, created_at timestamptz |
| settings | id, key, value, updated_at | renommer `key` en `setting_key`, value text, updated_at timestamptz |
| seo | id, page_slug, meta_title, meta_description, keywords, open_graph_image, twitter_card, robots | page_slug unique, textes conserves, FK logique vers pages.slug conseillee |
| cms_contact_settings | id, key, value, updated_at | renommer `key` en `setting_key`, value text, updated_at timestamptz |

`media_library`, `activity_logs`, `cms_sections`, `cms_services`, `hero_slider`

| Table | Colonnes | Conversions principales |
| --- | --- | --- |
| media_library | id, filename, original_name, path, mime_type, size_bytes, alt_text, uploaded_by, created_at | id identity, uploaded_by uuid vers profiles, path vers Supabase Storage, size_bytes bigint |
| activity_logs | id, user_id, action, description, ip_address, created_at | id bigint identity, user_id uuid vers profiles, ip_address inet/text |
| cms_sections | id, page_slug, section_key, label, title, subtitle, body, button_text, button_url, image_path, video_url, extra_json, created_at, updated_at | JSON -> jsonb, boolean non requis, unique page/section, timestamps |
| cms_services | id, title, slug, description, image_path, icon_class, button_text, button_url, features_text, sort_order, is_active, created_at, updated_at | slug unique, is_active boolean, features_text peut rester text ou devenir text[] |
| hero_slider | id, image, title, subtitle, button_text, button_link, display_order, status, created_at, updated_at | status boolean, image path Storage, display_order index |

## 5. Relations

Relations MySQL declarees :

```text
roles
   |
   `-- users.role_id -> roles.id

pages
   |
   `-- sections.page_id -> pages.id ON DELETE CASCADE

blog_categories
   |
   `-- blog.category_id -> blog_categories.id ON DELETE SET NULL

blog
   |
   `-- blog_comments.blog_id -> blog.id ON DELETE CASCADE

users
   |
   |-- media_library.uploaded_by -> users.id ON DELETE SET NULL
   `-- activity_logs.user_id -> users.id ON DELETE SET NULL
```

Fiches relations :

| Source | Colonne | Cible | Colonne | Type | ON DELETE | ON UPDATE | Utilisation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| users | role_id | roles | id | N -> 1 | default/restrict | default | active login/users |
| sections | page_id | pages | id | N -> 1 | CASCADE | default | non detecte dans code |
| blog | category_id | blog_categories | id | N -> 1 | SET NULL | default | dormant |
| blog_comments | blog_id | blog | id | N -> 1 | CASCADE | default | dormant |
| media_library | uploaded_by | users | id | N -> 1 | SET NULL | default | active uploads |
| activity_logs | user_id | users | id | N -> 1 | SET NULL | default | active logs |

Relations logiques non declarees en FK :

- `seo.page_slug` -> `pages.slug`
- `cms_sections.page_slug` -> page logique `home`, `about`
- `hero_slider.image` -> `media_library.path` ou fichier public
- `cms_services.image_path` -> `media_library.path` ou asset public
- `cms_sections.image_path` -> `media_library.path` ou asset public
- `cms_contact_settings.key` -> cle fonctionnelle utilisee par le code
- `settings.key` -> cle fonctionnelle utilisee par le renderer/admin

Relations 1 -> N :

- `roles` 1 -> N `users`
- `pages` 1 -> N `sections`
- `blog_categories` 1 -> N `blog`
- `blog` 1 -> N `blog_comments`
- `users` 1 -> N `media_library`
- `users` 1 -> N `activity_logs`

Relations N -> N :

- Aucune relation N -> N declaree.

## 6. Requetes SQL

Nombre de lignes de requetes detectees par recherche : 52.

Principales requetes READ :

| Fichier | Fonction | Tables | Operation | Parametres | Resultat | Utilisateur | Role | Sensibilite |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
| `TemplateRenderer.php` | `storedHtml` | pages | READ | slug | html_content | public | aucun | ADMIN/PUBLIC |
| `TemplateRenderer.php` | `settings` | settings | READ | aucun | settings key/value | public | aucun | INTERNAL |
| `TemplateRenderer.php` | `seo` | seo | READ dynamique champ | slug, field | metadata | public | aucun | PUBLIC |
| `CmsContentRepository.php` | `section` | cms_sections | READ | page_slug, section_key | section | public/admin | aucun/admin | PUBLIC |
| `CmsContentRepository.php` | `services` | cms_services | READ | activeOnly | liste services | public/admin | aucun/admin | PUBLIC |
| `CmsContentRepository.php` | `heroSlides` | hero_slider | READ | activeOnly | slides | public/admin | aucun/admin | PUBLIC |
| `CmsContentRepository.php` | `contact` | cms_contact_settings | READ | aucun | contact settings | public/admin | aucun/admin | PUBLIC |
| `app/Views/admin/*.php` | vues listes | messages/appointments/media/newsletter/activity | READ | aucun | listes admin | admin | admin/editor | SENSITIVE |

Principales requetes CREATE :

| Fichier | Fonction | Tables | Operation | Parametres | Resultat | Utilisateur | Role | Sensibilite |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
| `public/forms/contact.php` | formulaire contact | contact_messages | CREATE | name,email,subject,message,ip,user_agent | message cree | public | aucun | SENSITIVE |
| `public/forms/appointment.php` | formulaire RDV | appointments | CREATE | name,email,phone,date,time,department,doctor,message,ip | RDV cree | public | aucun | SENSITIVE |
| `admin/index.php` | `log_activity` | activity_logs | CREATE | user_id, action, description, ip | log cree | admin | admin/editor | SENSITIVE |
| `admin/index.php` | upload media | media_library | CREATE | filename, original, path, mime, size, user | media cree | admin | admin/editor | SENSITIVE |
| `admin/index.php` | save user | users | CREATE | role,name,email,password_hash | user cree | admin | admin | SENSITIVE |
| `CmsContentRepository.php` | save section/service/slide/contact/text | cms_* | CREATE/UPSERT | formulaires admin | contenu cree | admin | admin/editor | INTERNAL |

Principales requetes UPDATE :

| Fichier | Fonction | Tables | Operation | Parametres | Sensibilite |
| --- | --- | --- | --- | --- | --- |
| `admin/index.php` | save-page | pages | UPDATE | html_content, slug | CRITICAL |
| `admin/index.php` | save-settings | settings, seo | UPSERT | settings[], seo[] | HIGH |
| `CmsContentRepository.php` | saveService | cms_services | UPDATE | service fields | HIGH |
| `CmsContentRepository.php` | saveHeroSlide | hero_slider | UPDATE | slide fields | HIGH |
| `CmsContentRepository.php` | reorderHeroSlides | hero_slider | UPDATE | orders[] | MEDIUM |
| `CmsContentRepository.php` | saveContact | cms_contact_settings | UPSERT | key/value | MEDIUM |

Principales requetes DELETE :

| Fichier | Fonction | Tables | Operation | Parametres | Role | Sensibilite |
| --- | --- | --- | --- | --- | --- | --- |
| `admin/index.php` | delete-media | media_library | DELETE | id | admin | HIGH |
| `CmsContentRepository.php` | deleteService | cms_services | DELETE | id | admin | HIGH |
| `CmsContentRepository.php` | deleteHeroSlide | hero_slider | DELETE | id | admin | HIGH |
| `CmsContentRepository.php` | saveTextReplacements | cms_text_replacements | DELETE | page_slug, hash | admin/editor | MEDIUM |

Risques requetes :

- `TemplateRenderer::seo()` construit `SELECT {$field}` dynamiquement. L'appel actuel utilise des champs internes fixes, mais la pratique reste a encadrer en migration.
- Plusieurs requetes `SELECT *` exposent trop de colonnes en admin.
- Recherche services faite en PHP apres chargement complet de tous les services, pas en SQL.
- Pagination services faite en memoire, pas en base.
- `ON DUPLICATE KEY UPDATE` devra devenir `ON CONFLICT`.
- Table `cms_text_replacements` est utilisee par code mais absente de `clinic_db.sql` et `cms_migration.sql` analyses. C'est une incoherence a verifier.

## 7. Utilisateurs

Structure actuelle :

```text
TABLE : users
ID : id INT UNSIGNED AUTO_INCREMENT
EMAIL : email VARCHAR(190) UNIQUE
USERNAME : aucun
PASSWORD : password_hash VARCHAR(255)
ROLE : role_id -> roles.id
STATUS : aucun champ status
CREATED_AT : created_at
UPDATED_AT : updated_at
LAST_LOGIN : aucun champ last_login
AUTRES : remember_token present mais non utilise
```

Roles :

- `admin` : peut acceder a l'admin et effectuer les suppressions/creation utilisateur protegees par `require_admin('admin')`.
- `editor` : peut acceder a l'admin et modifier contenus/settings/services/slides, sauf suppressions explicitement reservees `admin`.

Permissions code :

- Acces admin global : tout utilisateur avec `$_SESSION['admin_user']`.
- Actions reservees admin :
  - `delete-media`
  - `delete-hero-slide`
  - `delete-service`
  - `save-user`
- Actions admin/editor :
  - save page
  - save settings
  - upload media
  - save CMS section
  - save hero slide
  - reorder hero slides
  - save service
  - save contact
  - lecture messages/appointments/newsletter/activity/media

## 8. Roles

Table : `roles`

Seed :

- id 1 : `admin`
- id 2 : `editor`

Strategie cible recommandee :

- Utiliser Supabase Auth pour l'identite.
- Conserver une table applicative `profiles`.
- Conserver une table `roles` simple ou une enum `app_role`.
- Stocker le role dans `profiles.role`.
- Proteger les donnees par RLS en s'appuyant sur `auth.uid()` et des fonctions SQL `is_admin()` / `is_editor_or_admin()`.

## 9. Donnees sensibles

| Table | Classification | Pourquoi | Acces public | Acces authentifie | Acces admin |
| --- | --- | --- | --- | --- | --- |
| roles | INTERNAL | permissions | non | lecture restreinte | oui |
| users | SENSITIVE | email/hash/role | non | profil propre uniquement si conserve | oui |
| profiles cible | SENSITIVE | identite/role | non | profil propre | oui |
| pages | ADMIN/PUBLIC | HTML public mais edition admin | lecture active publique | selon admin | oui |
| cms_sections | PUBLIC | contenu public | lecture active publique | non | oui |
| cms_services | PUBLIC | services publics | lecture active publique | non | oui |
| cms_contact_settings | PUBLIC/INTERNAL | coordonnees publiques | lecture publique pour cles publiques | non | oui |
| hero_slider | PUBLIC | images/titres publics | lecture active publique | non | oui |
| media_library | SENSITIVE | fichiers et metadata upload | lecture selon public/private | non | oui |
| contact_messages | SENSITIVE | messages visiteurs/IP | insertion publique controlee | non | oui |
| appointments | SENSITIVE | donnees RDV potentiellement medicales | insertion publique controlee | non | oui |
| newsletter | SENSITIVE | emails | insertion publique si formulaire | non | oui |
| settings | INTERNAL | config site | lecture publique seulement cles exposees | non | oui |
| seo | PUBLIC | metadata pages | lecture publique | non | oui |
| activity_logs | SENSITIVE | actions admin/IP | non | non | oui |
| site_statistics | SENSITIVE | IP/user agent | non | non | oui |
| blog/blog_categories | PUBLIC/ADMIN | contenu public dormant | si active | non | oui |
| blog_comments | SENSITIVE | email/commentaires | insertion publique si active | non | oui |
| tables clones sections | UNKNOWN - A VERIFIER | contenu inconnu | UNKNOWN | UNKNOWN | oui |

## 10. Contenu CMS

Contenus stockes dans MySQL selon dumps/code :

| Route | Source | Table | Colonne | Type | HTML ou texte | Dynamique | Modifiable admin |
| --- | --- | --- | --- | --- | --- | --- | --- |
| `/`, `/index.php` | renderer | pages | html_content | page | HTML | oui | oui |
| `/about.php` | renderer | pages | html_content | page | HTML | oui | oui |
| `/services.php` | renderer | pages | html_content | page | HTML | oui | oui |
| `/contact.php` | renderer | pages | html_content | page | HTML | oui | oui |
| toutes pages seed | renderer | pages | title, slug, template_file, is_active | metadata | texte | oui | oui |
| home | CMS sections | cms_sections | title, subtitle, body, buttons, image_path | section | texte + chemins | oui | oui |
| about | CMS sections | cms_sections | title, subtitle, body, image_path | section | texte + chemins | oui | oui |
| services | CMS services | cms_services | title, slug, description, image_path, icon_class | listing | texte + chemins | oui | oui |
| contact | CMS contact | cms_contact_settings | key/value | coordonnees | texte | oui | oui |
| home hero | hero slider | hero_slider | image, title, subtitle, button_* | slider | texte + chemins | oui | oui |
| toutes pages | SEO | seo | meta_title, meta_description, keywords, robots | SEO | texte | oui | oui |
| global | settings | settings | key/value | configuration | texte | oui | oui |
| navigation | seed | menus | label, url | menu potentiel | texte | non dans code actuel | oui si futur |

Explication des pages sans fichier PHP :

- Le routeur autorise 16 slugs.
- Le seed cree 16 lignes dans `pages`.
- Le renderer tente d'abord un fichier `app/Views/pages/{slug}.php` ou `.html`.
- Ensuite, si `pages.html_content` existe en DB pour le slug actif, ce HTML remplace le template fichier.
- Comme MySQL est inaccessible, il est impossible de confirmer si les 10 pages sans fichier existent en `pages.html_content`.

## 11. Index

Index/uniques actuels :

- Toutes les PK `id`.
- `roles.name` unique.
- `users.email` unique.
- `pages.slug` unique.
- `blog_categories.slug` unique.
- `blog.slug` unique.
- `newsletter.email` unique.
- `settings.key` unique.
- `seo.page_slug` unique.
- `cms_sections(page_slug, section_key)` unique.
- `cms_services.slug` unique.
- `cms_contact_settings.key` unique.
- Index implicites FK MySQL sur relations.

Index PostgreSQL recommandes :

- `profiles(role)`
- `pages(slug) unique`
- `pages(is_active)`
- `seo(page_slug) unique`
- `cms_sections(page_slug, section_key) unique`
- `cms_services(slug) unique`
- `cms_services(is_active, sort_order)`
- `hero_slider(status, display_order)`
- `media_library(uploaded_by, created_at desc)`
- `contact_messages(created_at desc)`
- `contact_messages(is_read, created_at desc)`
- `appointments(status, created_at desc)`
- `appointments(appointment_date)`
- `newsletter(email) unique`
- `activity_logs(user_id, created_at desc)`
- `settings(setting_key) unique`
- `cms_contact_settings(setting_key) unique`

## 12. Problemes

- MySQL local inaccessible pendant l'audit.
- Table `cms_text_replacements` referencee dans `CmsContentRepository` mais absente du schema SQL analyse.
- 16 pages seed/routees, seulement 6 fichiers page PHP locaux.
- Tables dormantes nombreuses, probablement issues d'un generateur CMS.
- `CREATE TABLE ... LIKE sections` non portable vers PostgreSQL.
- `password_hash` PHP ne migre pas directement dans Supabase Auth.
- `appointment_date` et `appointment_time` sont en `VARCHAR(80)` et non en types date/time.
- `status` de rendez-vous en texte libre sans contrainte.
- Upload SVG autorise.
- HTML brut editable en base.

## 13. Incoherences

Controle possible seulement sur fichiers/dumps, pas sur donnees reelles.

Incoherences fichier/code :

- `cms_text_replacements` utilisee par code mais absente du schema.
- `menus` seede mais navbar hardcodee dans `includes/navbar.php`.
- `social_links` existe mais le contact admin utilise `cms_contact_settings`.
- `services` table clone existe en plus de `cms_services`.
- `hero` table clone existe en plus de `hero_slider`.
- README mentionne `database/schema.sql`, mais le fichier present est `database/clinic_db.sql`.
- PHP requis README 8.3+, PHP XAMPP CLI detecte 8.2.12.

Incoherences donnees reelles :

- DATA VOLUME - UNKNOWN
- FK invalides - UNKNOWN
- doublons - UNKNOWN
- fichiers sans enregistrement - UNKNOWN
- enregistrements media sans fichier - UNKNOWN
- pages sans contenu - UNKNOWN

## 14. Architecture Supabase proposee

Representation cible :

```text
auth.users
   |
   `-- public.profiles
          |
          |-- public.media_library
          `-- public.activity_logs

public.pages
   |-- public.seo
   `-- public.cms_sections

public.cms_services
public.cms_contact_settings
public.hero_slider
public.settings
public.contact_messages
public.appointments
public.newsletter

storage.objects
   |
   `-- bucket: media
```

Principes :

- `auth.users` gere email, mot de passe, reset password, sessions.
- `profiles` garde nom, role, statut, timestamps et reference legacy.
- Les tables de contenu public restent lisibles publiquement si actives.
- Les donnees sensibles ne sont jamais lisibles publiquement.
- Les insertions publiques sont limitees aux formulaires contact/RDV/newsletter via policies strictes ou Server Actions avec service role.
- Les uploads passent par Supabase Storage.

## 15. Mapping MySQL -> PostgreSQL

| MySQL | PostgreSQL/Supabase | Action | Risque | Priorite | Justification |
| --- | --- | --- | --- | --- | --- |
| roles | roles ou enum app_role | TRANSFORM | MEDIUM | HIGH | role simple admin/editor |
| users | auth.users + profiles | REPLACE/SPLIT | CRITICAL | HIGH | Supabase Auth remplace hash/session PHP |
| pages | pages | MIGRATE | HIGH | HIGH | contenu CMS critique |
| sections | legacy_sections | DEPRECATE ou MIGRATE si donnees | MEDIUM | LOW | usage code non detecte |
| menus | navigation_items | TRANSFORM | LOW | MEDIUM | utile pour navbar dynamique future |
| sliders/hero/about/services/projects/portfolio/gallery/testimonials/team/partners/faq | legacy_* ou archive | DEPRECATE | MEDIUM | LOW | tables clones non utilisees |
| blog_categories | blog_categories | KEEP si blog voulu | LOW | LOW | dormant |
| blog | blog_posts | TRANSFORM | MEDIUM | LOW | dormant, nom plus clair |
| blog_comments | blog_comments | KEEP si blog voulu | HIGH | LOW | donnees personnelles |
| contact_messages | contact_messages | MIGRATE | HIGH | HIGH | donnees sensibles actives |
| appointments | appointments | TRANSFORM | CRITICAL | HIGH | types date/time/status a corriger |
| newsletter | newsletter_subscribers | TRANSFORM | HIGH | MEDIUM | email sensible |
| settings | settings | TRANSFORM | MEDIUM | HIGH | renommer key -> setting_key |
| seo | seo | TRANSFORM | LOW | HIGH | FK logique vers pages.slug |
| social_links | social_links | DEPRECATE ou MERGE | LOW | LOW | redondant avec contact settings |
| media_library | media_library + storage.objects | TRANSFORM | HIGH | HIGH | Storage Supabase |
| site_statistics | site_statistics | DEPRECATE ou MIGRATE | HIGH | LOW | IP/user-agent, usage non detecte |
| activity_logs | activity_logs | TRANSFORM | MEDIUM | MEDIUM | user_id uuid |
| cms_sections | cms_sections | MIGRATE | HIGH | HIGH | contenu CMS actif |
| cms_services | cms_services | MIGRATE | HIGH | HIGH | page services active |
| cms_contact_settings | cms_contact_settings | TRANSFORM | MEDIUM | HIGH | renommer key |
| hero_slider | hero_slider | TRANSFORM | HIGH | HIGH | status boolean + Storage |

## 16. RLS proposee

| Table | RLS enabled | SELECT public | SELECT authenticated | INSERT | UPDATE | DELETE | Admin | Editor | Notes |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| profiles | oui | non | self | system/admin | self limited/admin | admin | full | self limited | role visible via fonction securisee |
| roles | oui | non | oui limite | admin | admin | admin | full | read | roles tres stables |
| pages | oui | active only | admin/editor all | admin/editor | admin/editor | admin | full | no delete | HTML brut a surveiller |
| seo | oui | oui | admin/editor all | admin/editor | admin/editor | admin | full | no delete | metadata publique |
| settings | oui | cles publiques seulement | admin/editor all | admin | admin/editor | admin | full | update limite | separer public/internal idealement |
| cms_sections | oui | oui | admin/editor all | admin/editor | admin/editor | admin | full | no delete | contenu public |
| cms_services | oui | is_active true | admin/editor all | admin/editor | admin/editor | admin | full | no delete | services publics |
| cms_contact_settings | oui | cles publiques | admin/editor all | admin/editor | admin/editor | admin | full | update | coordonnees publiques |
| hero_slider | oui | status true | admin/editor all | admin/editor | admin/editor | admin | full | no delete | slider public |
| media_library | oui | fichiers publics approuves | admin/editor all | admin/editor | admin/editor own/admin | admin | full | create/update | public/private a decider |
| contact_messages | oui | non | admin/editor | public insert via server | admin/editor | admin | full | read/update | insertion anonyme stricte |
| appointments | oui | non | admin/editor | public insert via server | admin/editor | admin | full | read/update | donnees sensibles |
| newsletter_subscribers | oui | non | admin/editor | public insert | admin/editor | admin | full | read/update | email unique |
| activity_logs | oui | non | admin/editor | service/admin | non ou service | admin | full | read | append-only ideal |
| site_statistics | oui | non | admin | service insert | non | admin | full | no | optionnel |
| blog* | oui si garde | published only | admin/editor all | admin/editor | admin/editor | admin | full | no delete | dormant |

Fonctions RLS recommandees :

- `is_admin()`
- `is_editor_or_admin()`
- `current_user_role()`

## 17. Strategie de migration

Ne pas executer maintenant.

Ordre propose :

```text
MYSQL
  -> BACKUP complet SQL + public/uploads
  -> STAGING local
  -> verification schema et volumes
  -> transformation SQL
  -> Supabase PostgreSQL staging
  -> validation compteurs
  -> validation relations
  -> validation fichiers Storage
  -> reconciliation
  -> production apres validation
```

Ordre technique conseille :

1. Exporter la base MySQL reelle avec donnees.
2. Exporter `public/uploads`.
3. Mesurer volumes et checksums par table.
4. Creer schema Supabase en staging.
5. Migrer tables de reference : roles/settings/pages/seo.
6. Migrer contenu CMS : cms_sections, cms_services, cms_contact_settings, hero_slider.
7. Migrer medias vers Storage puis `media_library`.
8. Migrer formulaires : contact_messages, appointments, newsletter.
9. Migrer logs : activity_logs, site_statistics si conserve.
10. Migrer utilisateurs vers Supabase Auth par invitation/reset password, pas par copie brute des hashes.
11. Valider compteurs et echantillons.
12. Valider rendu Next.js contre PHP.
13. Preparer rollback : garder MySQL intact et dump horodate.

Validation :

- Nombre de lignes par table.
- Nombre de medias en base vs fichiers Storage.
- Unicite emails/slugs/keys.
- Correspondance pages routees.
- Verification que les 16 pages publiques ont contenu ou composant.
- Verification roles admin/editor.
- Tests insert contact/RDV.

Rollback :

- Ne jamais supprimer MySQL en phase beta.
- Garder PHP en production jusqu'a validation.
- DNS/route rollback vers PHP.

## 18. Risques

| Risque | Niveau | Detail |
| --- | --- | --- |
| Donnees reelles non accessibles pendant audit | CRITICAL | volume, orphelins et contenu HTML non confirmes |
| Auth Supabase | CRITICAL | hash PHP non importable directement comme login Supabase standard |
| Donnees de rendez-vous | CRITICAL | potentiel donnees medicales/personnelles |
| HTML brut CMS | CRITICAL | XSS et rendu React dangereux |
| Pages manquantes localement | HIGH | dependent peut-etre de `pages.html_content` |
| Uploads publics/SVG | HIGH | securite Storage a definir |
| SQL MySQL non portable | HIGH | `ON DUPLICATE`, `AUTO_INCREMENT`, `UNSIGNED`, `LIKE`, `ON UPDATE` |
| Tables dormantes | MEDIUM | migration inutile ou omission accidentelle |
| Types date/heure en texte | MEDIUM | transformation peut casser donnees invalides |
| Index insuffisants | MEDIUM | listes admin peuvent ralentir avec volume |

## 19. Points a valider

- Demarrer MySQL local ou fournir un dump complet de production/staging.
- Confirmer si les 10 pages sans fichier PHP doivent exister dans le futur Next.js.
- Decider si les tables dormantes doivent etre migrees, archivees ou ignorees.
- Decider si `pages.html_content` reste autorise ou si on migre vers sections structurees.
- Confirmer la strategie Supabase Auth : invitation utilisateurs ou reset password obligatoire.
- Confirmer le niveau de confidentialite des uploads.
- Confirmer si les messages/RDV doivent declencher emails ou rester uniquement en base.
- Corriger ou ajouter la table manquante `cms_text_replacements` si la fonctionnalite est voulue.
