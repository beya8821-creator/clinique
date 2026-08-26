<?php

declare(strict_types=1);

use App\Core\Database;
use App\Helpers\Security;

require dirname(__DIR__, 2) . '/app/bootstrap.php';

header('Content-Type: text/plain; charset=utf-8');

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST' || !Security::verifyCsrf()) {
    http_response_code(419);
    exit('Invalid security token.');
}

$name = trim((string) ($_POST['name'] ?? ''));
$email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
$phone = trim((string) ($_POST['phone'] ?? ''));
$message = trim((string) ($_POST['message'] ?? ''));

if ($name === '' || $email === false || $phone === '') {
    http_response_code(422);
    exit('Please complete all required fields.');
}

$stmt = Database::pdo()->prepare(
    'INSERT INTO appointments (name, email, phone, appointment_date, appointment_time, department, doctor, message, ip_address) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
);
$stmt->execute([
    $name,
    $email,
    $phone,
    $_POST['date'] ?? null,
    $_POST['time'] ?? null,
    $_POST['department'] ?? null,
    $_POST['doctor'] ?? null,
    $message,
    $_SERVER['REMOTE_ADDR'] ?? null,
]);

echo 'OK';
