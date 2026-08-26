# Polyclinique Yetu PHP CMS

This is the converted PHP 8.3+ MVC CMS version of the Polyclinique Yetu template from `C:\xampp\htdocs\Polyclinique Yetu`.

The public frontend assets were copied without rewriting:

- `public/assets/css/main.css`
- `public/assets/js/main.js`
- `public/assets/vendor/`
- `public/assets/img/`
- existing fonts, icons, animations, Bootstrap, AOS, GLightbox, Swiper, and PureCounter files

The original HTML documents were moved into `app/Views/pages/` and are rendered by PHP. The renderer injects CSRF tokens into the existing contact and appointment forms and applies editable SEO metadata without changing the template CSS or JavaScript.

## Install With XAMPP

1. Copy this folder to `C:\xampp\htdocs\Polyclinique Yetu_CMS`.
2. In MySQL, create a database named `Polyclinique Yetu_cms`.
3. Copy `.env.example` to `.env`.
4. Update `.env` if your MySQL username or password is different.
5. Import `database/schema.sql`.
6. Import `database/seed.sql`.
7. Run this once from the project folder to load the original HTML into the database:

```bash
php database/import_templates.php
```

8. Open the site with the project `public` folder as the web root.

If the base schema is already installed, import `database/cms_migration.sql` to add the CMS content modules for Home, About, Services, Contact, and the media/contact settings without recreating the existing database.

For Apache virtual host setups, point the document root to:

```text
C:\xampp\htdocs\Polyclinique Yetu_CMS\public
```

## Admin Login

- URL with XAMPP subfolder: `http://localhost/Polyclinique Yetu_CMS/public/admin.php`
- Alternative URL: `http://localhost/Polyclinique Yetu_CMS/public/admin/`
- URL with a virtual host pointing to `public`: `/admin.php` or `/admin/`
- Email: `admin@example.com`
- Password: `password`

Change this password immediately after installation.

## CMS Features

- Custom PHP router
- PDO MySQL connection
- MVC-style application folders
- CSRF protection
- Secure session cookie settings
- Admin/editor roles
- Page HTML editor
- SEO and website settings
- Contact messages
- Appointment requests
- Newsletter table
- Media uploads with extension and size validation
- Activity logs
- Database schema and seed scripts

## Notes

The original `C:\xampp\htdocs\Polyclinique Yetu` folder was only read, not modified. Write access to XAMPP was not granted, so the completed package is delivered in the Codex workspace outputs.
