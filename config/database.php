<?php

declare(strict_types=1);

use App\Core\Database;
use PDO;

if (!function_exists('db')) {
    function db(): PDO
    {
        return Database::pdo();
    }
}
