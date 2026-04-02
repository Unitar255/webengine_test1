<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/csrf.php';
verify_csrf();

$full_name = trim($_POST['full_name'] ?? '');
$email     = strtolower(trim($_POST['email'] ?? ''));
$pass      = $_POST['password'] ?? '';

if ($full_name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($pass) < 6) {
    $_SESSION['flash_error'] = 'Please fill all fields. Password must be at least 6 characters.';
    header('Location: /workshop-app/public/register.php');
    exit;
}

try {
    $hash = password_hash($pass, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password_hash) VALUES (?, ?, ?)");
    $stmt->execute([$full_name, $email, $hash]);

    // Auto-login
    $user_id = (int)$pdo->lastInsertId();
    $_SESSION['user'] = ['id'=>$user_id, 'full_name'=>$full_name, 'email'=>$email, 'role'=>'customer'];

    header('Location: /workshop-app/public/dashboard.php');
} catch (PDOException $e) {
    if ($e->errorInfo[1] == 1062) {
        $_SESSION['flash_error'] = 'That email is already registered.';
        header('Location: /workshop-app/public/register.php');
        exit;
    }
    $_SESSION['flash_error'] = 'Registration failed. Please try again.';
    header('Location: /workshop-app/public/register.php');
    exit;
}