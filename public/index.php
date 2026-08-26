<?php

declare(strict_types=1);

use App\Core\TemplateRenderer;

require dirname(__DIR__) . '/config/config.php';

$path = trim(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/', '/');
$base = basename($path);
if ($base === '') {
    $slug = 'index';
} elseif (!preg_match('/\.php$/', $base)) {
    $slug = '404';
    http_response_code(404);
} else {
    $slug = preg_replace('/\.php$/', '', $base);
}
$allowed = [
    'index', 'about', 'appointment', 'contact', 'department-details', 'departments',
    'doctors', 'faq', 'gallery', 'privacy', 'service-details', 'services',
    'starter-page', 'terms', 'testimonials', '404',
];

if ($base === 'admin' || $base === 'admin.php' || str_contains($path, '/admin')) {
    require dirname(__DIR__) . '/admin/index.php';
    exit;
}

if (!in_array($slug, $allowed, true)) {
    $slug = '404';
    http_response_code(404);
}

echo (new TemplateRenderer())->render($slug);
