<?php

declare(strict_types=1);

use App\Helpers\Security;
use App\Helpers\Url;

if (!function_exists('csrf_field')) {
    function csrf_field(): string
    {
        return Security::csrfField();
    }
}

if (!function_exists('e')) {
    function e(mixed $value): string
    {
        return Security::e($value);
    }
}

if (!function_exists('admin_url')) {
    function admin_url(string $query = ''): string
    {
        return Url::admin($query);
    }
}

if (!function_exists('asset_url')) {
    function asset_url(string $path): string
    {
        return Url::asset($path);
    }
}

if (!function_exists('current_admin_user')) {
    function current_admin_user(): ?array
    {
        return $_SESSION['admin_user'] ?? null;
    }
}
