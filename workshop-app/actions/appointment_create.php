<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/csrf.php';
require_once __DIR__ . '/../helpers/auth.php';
require_login();
verify_csrf();

$user = current_user();

$service_id = (int)($_POST['service_id'] ?? 0);
$appointment_date = $_POST['appointment_date'] ?? '';
$appointment_time = $_POST['appointment_time'] ?? '';
$vehicle_make  = trim($_POST['vehicle_make'] ?? '');
$vehicle_model = trim($_POST['vehicle_model'] ?? '');
$plate_no      = strtoupper(trim($_POST['plate_no'] ?? ''));
$notes         = trim($_POST['notes'] ?? '');

if (!$service_id || !$appointment_date || !$appointment_time || $vehicle_make==='' || $vehicle_model==='' || $plate_no==='') {
    exit('Missing required fields.');
}

try {
    // Prevent double booking: same date/time
    $chk = $pdo->prepare("SELECT COUNT(*) FROM appointments WHERE appointment_date=? AND appointment_time=? AND status IN ('pending','approved')");
    $chk->execute([$appointment_date, $appointment_time]);
    if ((int)$chk->fetchColumn() > 0) {
        exit('Selected slot is not available. Please choose a different time.');
    }

    $stmt = $pdo->prepare("INSERT INTO appointments
        (user_id, service_id, vehicle_make, vehicle_model, plate_no, appointment_date, appointment_time, notes)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $user['id'], $service_id, $vehicle_make, $vehicle_model, $plate_no, $appointment_date, $appointment_time, $notes
    ]);

    header('Location: /workshop-app/public/dashboard.php');
} catch (Throwable $e) {
    exit('Error creating appointment.');
}