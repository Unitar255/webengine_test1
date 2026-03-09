<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/csrf.php';
require_once __DIR__ . '/../helpers/auth.php';
require_admin();
verify_csrf();

$appt_id = (int)($_POST['id'] ?? 0);
$status  = $_POST['status'] ?? 'pending';
$valid   = ['pending','approved','completed','cancelled'];

if (!$appt_id || !in_array($status, $valid, true)) {
    exit('Invalid request.');
}
$stmt = $pdo->prepare("UPDATE appointments SET status=? WHERE id=?");
$stmt->execute([$status, $appt_id]);

header('Location: /workshop-app/admin/admin_dashboard.php');