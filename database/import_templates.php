<?php

declare(strict_types=1);

require dirname(__DIR__) . '/app/bootstrap.php';

use App\Core\Database;

$pageDir = dirname(__DIR__) . '/app/Views/pages';
$stmt = Database::pdo()->prepare('UPDATE pages SET html_content = ? WHERE slug = ?');

foreach (glob($pageDir . '/*.html') ?: [] as $file) {
    $slug = basename($file, '.html');
    $stmt->execute([file_get_contents($file), $slug]);
    echo "Imported {$slug}\n";
}
