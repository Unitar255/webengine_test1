<?php
$page_title = "Dashboard";
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../helpers/auth.php';
require_login();

$user = current_user();

if (is_staff()) {
  header('Location: /workshop-app/admin/admin_dashboard.php');
  exit;
}

// Fetch user appointments
$stmt = $pdo->prepare("SELECT a.id, s.name AS service_name, a.vehicle_make, a.vehicle_model, a.plate_no,
                              a.appointment_date, a.appointment_time, a.status
                       FROM appointments a
                       JOIN services s ON s.id = a.service_id
                       WHERE a.user_id = ?
                       ORDER BY a.appointment_date DESC, a.appointment_time DESC");
$stmt->execute([$user['id']]);
$appts = $stmt->fetchAll();

require_once __DIR__ . '/../partials/header.php';
require_once __DIR__ . '/../partials/nav.php';
?>
<div class="card">
  <h2>Welcome, <?= htmlspecialchars($user['full_name']) ?></h2>
  <p><a class="btn" href="/workshop-app/public/book.php">Make New Booking</a></p>
</div>

<div class="card">
  <h3>Your Appointments</h3>
  <?php if (!$appts): ?>
    <p>No appointments yet.</p>
  <?php else: ?>
  <table class="table">
    <thead>
      <tr>
        <th>Service</th><th>Vehicle</th><th>Plate</th><th>Date</th><th>Time</th><th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($appts as $a): ?>
      <tr>
        <td><?= htmlspecialchars($a['service_name']) ?></td>
        <td><?= htmlspecialchars($a['vehicle_make'].' '.$a['vehicle_model']) ?></td>
        <td><?= htmlspecialchars($a['plate_no']) ?></td>
        <td><?= htmlspecialchars($a['appointment_date']) ?></td>
        <td><?= htmlspecialchars(substr($a['appointment_time'],0,5)) ?></td>
        <td><span class="badge <?= htmlspecialchars($a['status']) ?>"><?= htmlspecialchars(ucfirst($a['status'])) ?></span></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?php endif; ?>
</div>
<?php require_once __DIR__ . '/../partials/footer.php'; ?>