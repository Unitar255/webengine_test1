<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/csrf.php';
verify_csrf();

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($name==='' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $subject==='' || $message==='') {
  exit('Please complete all fields correctly.');
}
$stmt = $pdo->prepare("INSERT INTO contacts (name,email,subject,message) VALUES (?,?,?,?)");
$stmt->execute([$name,$email,$subject,$message]);

header('Location: /workshop-app/public/contact.php');