<?php
declare(strict_types=1);

session_start();

// Set your timezone (Malaysia)
date_default_timezone_set('Asia/Kuala_Lumpur');

// Database credentials
$DB_HOST = '127.0.0.1';
$DB_NAME = 'workshop_db';
$DB_USER = 'root';        // XAMPP default
$DB_PASS = '';            // XAMPP default empty; change if needed
$DB_CHARSET = 'utf8mb4';

$dsn = "mysql:host=$DB_HOST;dbname=$DB_NAME;charset=$DB_CHARSET";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $DB_USER, $DB_PASS, $options);
} catch (PDOException $e) {
    exit('Database connection failed: ' . htmlspecialchars($e->getMessage()));
}