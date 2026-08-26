<?php

declare(strict_types=1);

namespace App\Helpers;

final class Url
{
    public static function publicBase(): string
    {
        $script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
        $publicPos = strpos($script, '/public/');

        if ($publicPos !== false) {
            return substr($script, 0, $publicPos + strlen('/public'));
        }

        return rtrim(str_replace(['/admin.php', '/index.php'], '', $script), '/');
    }

    public static function admin(string $query = ''): string
    {
        $url = self::publicBase() . '/admin.php';
        return $query === '' ? $url : $url . '?' . ltrim($query, '?');
    }

    public static function asset(string $path): string
    {
        return self::publicBase() . '/' . ltrim($path, '/');
    }
}
