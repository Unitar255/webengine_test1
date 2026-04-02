<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/csrf.php';
verify_csrf();

$email = strtolower(trim($_POST['email'] ?? ''));
$pass  = $_POST['password'] ?? '';

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $pass === '') {
    $_SESSION['flash_error'] = 'Please enter a valid email and password.';
    header('Location: /workshop-app/public/login.php');
    exit;
}

$stmt = $pdo->prepare("SELECT id, full_name, email, password_hash, role FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if ($user && password_verify($pass, $user['password_hash'])) {
    session_regenerate_id(true);
    $_SESSION['user'] = [
        'id' => (int)$user['id'],
        'full_name' => $user['full_name'],
        'email' => $user['email'],
        'role' => $user['role']
    ];
    header('Location: /workshop-app/public/dashboard.php');
} else {
    $_SESSION['flash_error'] = 'Invalid email or password.';
    header('Location: /workshop-app/public/login.php');
}
exit;