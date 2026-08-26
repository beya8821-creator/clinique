<?php

declare(strict_types=1);

use App\Core\Database;
use App\Helpers\Security;
use App\Helpers\Url;
use App\Repositories\CmsContentRepository;

require_once dirname(__DIR__) . '/config/config.php';

$action = $_GET['action'] ?? 'dashboard';

function admin_user(): ?array
{
    return $_SESSION['admin_user'] ?? null;
}

function require_admin(?string $role = null): void
{
    $user = admin_user();
    if (!$user) {
        header('Location: ' . Url::admin('action=login'));
        exit;
    }
    if ($role !== null && ($user['role'] ?? '') !== $role) {
        http_response_code(403);
        exit('Forbidden');
    }
}

function admin_view(string $title, string $body): void
{
    $user = admin_user();
    require dirname(__DIR__) . '/app/Views/admin/layout.php';
}

function log_activity(string $action, string $description): void
{
    try {
        $stmt = Database::pdo()->prepare('INSERT INTO activity_logs (user_id, action, description, ip_address) VALUES (?, ?, ?, ?)');
        $stmt->execute([admin_user()['id'] ?? null, $action, $description, $_SERVER['REMOTE_ADDR'] ?? null]);
    } catch (Throwable) {
    }
}

function store_uploaded_media(string $fieldName, array $allowed = ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp']): ?string
{
    $file = $_FILES[$fieldName] ?? null;
    if (!is_array($file) || ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
        return null;
    }

    $extension = strtolower(pathinfo((string) ($file['name'] ?? ''), PATHINFO_EXTENSION));
    $maxSize = 25 * 1024 * 1024;
    if (!in_array($extension, $allowed, true) || (int) ($file['size'] ?? 0) > $maxSize) {
        return null;
    }

    $filename = bin2hex(random_bytes(12)) . '.' . $extension;
    $relativePath = 'uploads/' . $filename;
    $target = dirname(__DIR__) . '/public/' . $relativePath;
    if (!is_dir(dirname($target))) {
        mkdir(dirname($target), 0775, true);
    }
    if (!move_uploaded_file((string) $file['tmp_name'], $target)) {
        return null;
    }

    $stmt = Database::pdo()->prepare('INSERT INTO media_library (filename, original_name, path, mime_type, size_bytes, uploaded_by) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([
        $filename,
        $file['name'] ?? $filename,
        $relativePath,
        $file['type'] ?? 'application/octet-stream',
        (int) ($file['size'] ?? 0),
        admin_user()['id'] ?? null,
    ]);

    return $relativePath;
}

if ($action === 'login' && ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    if (!Security::verifyCsrf()) {
        exit('Invalid security token.');
    }
    $stmt = Database::pdo()->prepare('SELECT users.*, roles.name role_name FROM users JOIN roles ON roles.id = users.role_id WHERE email = ? LIMIT 1');
    $stmt->execute([$_POST['email'] ?? '']);
    $user = $stmt->fetch();
    if (!$user || !password_verify((string) ($_POST['password'] ?? ''), (string) $user['password_hash'])) {
        $_SESSION['flash'] = 'Invalid login details.';
        header('Location: ' . Url::admin('action=login'));
        exit;
    }
    session_regenerate_id(true);
    $_SESSION['admin_user'] = ['id' => $user['id'], 'name' => $user['name'], 'role' => $user['role_name']];
    log_activity('login', 'Signed in');
    header('Location: ' . Url::admin());
    exit;
}

if ($action === 'logout') {
    if (Security::verifyCsrf()) {
        unset($_SESSION['admin_user']);
    }
    header('Location: ' . Url::admin('action=login'));
    exit;
}

if ($action === 'login') {
    require dirname(__DIR__) . '/app/Views/admin/login.php';
    exit;
}

require_admin();
$db = Database::pdo();

if ($action === 'save-page' && ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    if (!Security::verifyCsrf()) {
        exit('Invalid security token.');
    }
    $stmt = $db->prepare('UPDATE pages SET html_content = ?, updated_at = NOW() WHERE slug = ?');
    $stmt->execute([$_POST['html_content'] ?? '', $_POST['slug'] ?? 'index']);
    log_activity('page.update', 'Updated page ' . ($_POST['slug'] ?? ''));
    header('Location: ' . Url::admin('action=pages&slug=' . urlencode((string) ($_POST['slug'] ?? 'index'))));
    exit;
}

if ($action === 'save-settings' && ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    if (!Security::verifyCsrf()) {
        exit('Invalid security token.');
    }
    foreach ($_POST['settings'] ?? [] as $key => $value) {
        $stmt = $db->prepare('INSERT INTO settings (`key`, `value`) VALUES (?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`)');
        $stmt->execute([(string) $key, (string) $value]);
    }
    foreach ($_POST['seo'] ?? [] as $slug => $fields) {
        $stmt = $db->prepare('INSERT INTO seo (page_slug, meta_title, meta_description, keywords, robots) VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE meta_title = VALUES(meta_title), meta_description = VALUES(meta_description), keywords = VALUES(keywords), robots = VALUES(robots)');
        $stmt->execute([$slug, $fields['meta_title'] ?? '', $fields['meta_description'] ?? '', $fields['keywords'] ?? '', $fields['robots'] ?? 'index,follow']);
    }
    log_activity('settings.update', 'Updated settings');
    header('Location: ' . Url::admin('action=settings'));
    exit;
}

if ($action === 'upload-media' && ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    if (!Security::verifyCsrf()) {
        exit('Invalid security token.');
    }
    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp', 'pdf', 'mp4', 'webm', 'mov'];
    $maxSize = 25 * 1024 * 1024;
    $addToHeroSlider = isset($_POST['add_to_hero_slider']);
    $files = $_FILES['media'] ?? null;
    if (is_array($files) && is_array($files['name'])) {
        foreach ($files['name'] as $i => $name) {
            $extension = strtolower(pathinfo((string) $name, PATHINFO_EXTENSION));
            if (!in_array($extension, $allowed, true) || (int) $files['size'][$i] > $maxSize) {
                continue;
            }
            $filename = bin2hex(random_bytes(12)) . '.' . $extension;
            $target = dirname(__DIR__) . '/public/uploads/' . $filename;
            if (!is_dir(dirname($target))) {
                mkdir(dirname($target), 0775, true);
            }
            if (move_uploaded_file($files['tmp_name'][$i], $target)) {
                $stmt = $db->prepare('INSERT INTO media_library (filename, original_name, path, mime_type, size_bytes, uploaded_by) VALUES (?, ?, ?, ?, ?, ?)');
                $stmt->execute([$filename, $name, 'uploads/' . $filename, $files['type'][$i], $files['size'][$i], admin_user()['id'] ?? null]);
                if ($addToHeroSlider && str_starts_with((string) $files['type'][$i], 'image/')) {
                    $order = (int) $db->query('SELECT COALESCE(MAX(display_order), 0) + 1 FROM hero_slider')->fetchColumn();
                    CmsContentRepository::saveHeroSlide([
                        'image' => 'uploads/' . $filename,
                        'title' => pathinfo((string) $name, PATHINFO_FILENAME),
                        'display_order' => $order,
                        'status' => 1,
                    ]);
                }
            }
        }
    }
    header('Location: ' . Url::admin('action=media'));
    exit;
}

if ($action === 'delete-media' && ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    require_admin('admin');
    if (!Security::verifyCsrf()) {
        exit('Invalid security token.');
    }
    $stmt = $db->prepare('SELECT * FROM media_library WHERE id = ?');
    $stmt->execute([(int) ($_POST['id'] ?? 0)]);
    $media = $stmt->fetch();
    if ($media) {
        @unlink(dirname(__DIR__) . '/public/' . $media['path']);
        $db->prepare('DELETE FROM media_library WHERE id = ?')->execute([$media['id']]);
    }
    header('Location: ' . Url::admin('action=media'));
    exit;
}

if ($action === 'save-cms-section' && ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    if (!Security::verifyCsrf()) {
        exit('Invalid security token.');
    }
    $uploadedImage = store_uploaded_media('image_file');
    $uploadedVideo = store_uploaded_media('video_file', ['mp4', 'webm', 'mov']);
    CmsContentRepository::saveSection([
        'page_slug' => $_POST['page_slug'] ?? '',
        'section_key' => $_POST['section_key'] ?? '',
        'label' => $_POST['label'] ?? '',
        'title' => $_POST['title'] ?? '',
        'subtitle' => $_POST['subtitle'] ?? '',
        'body' => $_POST['body'] ?? '',
        'button_text' => $_POST['button_text'] ?? '',
        'button_url' => $_POST['button_url'] ?? '',
        'image_path' => $uploadedImage ?? ($_POST['image_path'] ?? ''),
        'video_url' => $uploadedVideo ?? ($_POST['video_url'] ?? ''),
        'extra_json' => $_POST['extra_json'] ?? null,
    ]);
    log_activity('cms.section.update', 'Updated ' . ($_POST['page_slug'] ?? '') . ' / ' . ($_POST['section_key'] ?? ''));
    header('Location: ' . Url::admin('action=cms-' . urlencode((string) ($_POST['page_slug'] ?? 'home'))));
    exit;
}

if ($action === 'save-hero-slide' && ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    if (!Security::verifyCsrf()) {
        exit('Invalid security token.');
    }
    $id = (int) ($_POST['id'] ?? 0);
    $current = $id > 0 ? CmsContentRepository::heroSlide($id) : null;
    $uploadedImage = store_uploaded_media('image_file');
    $image = $uploadedImage ?? ($_POST['image'] ?? ($current['image'] ?? ''));

    if (trim((string) $image) === '') {
        $_SESSION['flash'] = 'Please upload an image for the hero slide.';
        header('Location: ' . Url::admin('action=hero-slider' . ($id > 0 ? '&id=' . $id : '')));
        exit;
    }

    CmsContentRepository::saveHeroSlide([
        'id' => $id,
        'image' => $image,
        'title' => $_POST['title'] ?? '',
        'subtitle' => $_POST['subtitle'] ?? '',
        'button_text' => $_POST['button_text'] ?? '',
        'button_link' => $_POST['button_link'] ?? '',
        'display_order' => (int) ($_POST['display_order'] ?? 0),
        'status' => isset($_POST['status']) ? 1 : 0,
    ]);
    log_activity('hero.slide.update', 'Saved hero slide');
    header('Location: ' . Url::admin('action=hero-slider'));
    exit;
}

if ($action === 'delete-hero-slide' && ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    require_admin('admin');
    if (!Security::verifyCsrf()) {
        exit('Invalid security token.');
    }
    CmsContentRepository::deleteHeroSlide((int) ($_POST['id'] ?? 0));
    log_activity('hero.slide.delete', 'Deleted hero slide #' . ($_POST['id'] ?? ''));
    header('Location: ' . Url::admin('action=hero-slider'));
    exit;
}

if ($action === 'reorder-hero-slides' && ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    if (!Security::verifyCsrf()) {
        exit('Invalid security token.');
    }
    CmsContentRepository::reorderHeroSlides($_POST['orders'] ?? []);
    log_activity('hero.slide.reorder', 'Reordered hero slides');
    header('Location: ' . Url::admin('action=hero-slider'));
    exit;
}

if ($action === 'save-service' && ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    if (!Security::verifyCsrf()) {
        exit('Invalid security token.');
    }
    $title = trim((string) ($_POST['title'] ?? ''));
    $uploadedImage = store_uploaded_media('image_file');
    CmsContentRepository::saveService([
        'id' => (int) ($_POST['id'] ?? 0),
        'title' => $title,
        'slug' => trim((string) ($_POST['slug'] ?? '')) ?: strtolower(preg_replace('/[^a-z0-9]+/i', '-', $title) ?? ''),
        'description' => $_POST['description'] ?? '',
        'image_path' => $uploadedImage ?? ($_POST['image_path'] ?? ''),
        'icon_class' => $_POST['icon_class'] ?? 'fas fa-heartbeat',
        'button_text' => $_POST['button_text'] ?? 'Learn More',
        'button_url' => $_POST['button_url'] ?? 'service-details.html',
        'features_text' => $_POST['features_text'] ?? '',
        'sort_order' => (int) ($_POST['sort_order'] ?? 0),
        'is_active' => isset($_POST['is_active']) ? 1 : 0,
    ]);
    log_activity('cms.service.update', 'Saved service ' . $title);
    header('Location: ' . Url::admin('action=cms-services'));
    exit;
}

if ($action === 'delete-service' && ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    require_admin('admin');
    if (!Security::verifyCsrf()) {
        exit('Invalid security token.');
    }
    CmsContentRepository::deleteService((int) ($_POST['id'] ?? 0));
    log_activity('cms.service.delete', 'Deleted service #' . ($_POST['id'] ?? ''));
    header('Location: ' . Url::admin('action=cms-services'));
    exit;
}

if ($action === 'save-contact' && ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    if (!Security::verifyCsrf()) {
        exit('Invalid security token.');
    }
    CmsContentRepository::saveContact($_POST['contact'] ?? []);
    log_activity('cms.contact.update', 'Updated contact content');
    header('Location: ' . Url::admin('action=cms-contact'));
    exit;
}

if ($action === 'save-user' && ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    require_admin('admin');
    if (!Security::verifyCsrf()) {
        exit('Invalid security token.');
    }
    $stmt = $db->prepare('INSERT INTO users (role_id, name, email, password_hash) VALUES (?, ?, ?, ?)');
    $stmt->execute([(int) $_POST['role_id'], $_POST['name'], $_POST['email'], password_hash((string) $_POST['password'], PASSWORD_DEFAULT)]);
    header('Location: ' . Url::admin('action=users'));
    exit;
}

ob_start();
match ($action) {
    'cms-home' => require dirname(__DIR__) . '/app/Views/admin/cms_home.php',
    'hero-slider' => require dirname(__DIR__) . '/app/Views/admin/hero_slider.php',
    'cms-about' => require dirname(__DIR__) . '/app/Views/admin/cms_about.php',
    'cms-services' => require dirname(__DIR__) . '/app/Views/admin/cms_services.php',
    'cms-contact' => require dirname(__DIR__) . '/app/Views/admin/cms_contact.php',
    'pages' => require dirname(__DIR__) . '/app/Views/admin/pages.php',
    'settings' => require dirname(__DIR__) . '/app/Views/admin/settings.php',
    'media' => require dirname(__DIR__) . '/app/Views/admin/media.php',
    'messages' => require dirname(__DIR__) . '/app/Views/admin/messages.php',
    'appointments' => require dirname(__DIR__) . '/app/Views/admin/appointments.php',
    'newsletter' => require dirname(__DIR__) . '/app/Views/admin/newsletter.php',
    'users' => require dirname(__DIR__) . '/app/Views/admin/users.php',
    'activity' => require dirname(__DIR__) . '/app/Views/admin/activity.php',
    default => require dirname(__DIR__) . '/app/Views/admin/dashboard.php',
};
$body = ob_get_clean() ?: '';
admin_view(ucfirst((string) $action), $body);
