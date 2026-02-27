<?php
require_once __DIR__ . '/../config/config.php';

function is_logged_in(): bool {
    return !empty($_SESSION['user']);
}
function current_user(): ?array {
    return $_SESSION['user'] ?? null;
}
function require_login(): void {
    if (!is_logged_in()) {
        header('Location: /workshop-app/public/login.php');
        exit;
    }
}
function is_admin(): bool {
    return is_logged_in() && ($_SESSION['user']['role'] === 'admin');
}
function require_admin(): void {
    if (!is_admin()) {
        http_response_code(403);
        exit('Forbidden');
    }
}