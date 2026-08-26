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
$subject = trim((string) ($_POST['subject'] ?? ''));
$message = trim((string) ($_POST['message'] ?? ''));
$honeypot = trim((string) ($_POST['website'] ?? ''));

if ($honeypot !== '' || $name === '' || $email === false || $subject === '' || $message === '') {
    http_response_code(422);
    exit('Please complete all required fields.');
}

$stmt = Database::pdo()->prepare(
    'INSERT INTO contact_messages (name, email, subject, message, ip_address, user_agent) VALUES (?, ?, ?, ?, ?, ?)'
);
$stmt->execute([$name, $email, $subject, $message, $_SERVER['REMOTE_ADDR'] ?? null, $_SERVER['HTTP_USER_AGENT'] ?? null]);

echo 'OK';
