<?php
$page_title = "Admin Dashboard";
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/csrf.php';
require_once __DIR__ . '/../helpers/auth.php';
require_admin();

// Fetch all appointments
$sql = "SELECT a.id, u.full_name, u.email, s.name AS service_name, a.vehicle_make, a.vehicle_model, a.plate_no,
               a.appointment_date, a.appointment_time, a.status
        FROM appointments a
        JOIN users u ON u.id=a.user_id
        JOIN services s ON s.id=a.service_id
        ORDER BY a.appointment_date DESC, a.appointment_time DESC";
$appts = $pdo->query($sql)->fetchAll();

require_once __DIR__ . '/../partials/header.php';
require_once __DIR__ . '/../partials/nav.php';
?>
<div class="card">
  <h2>Admin Dashboard</h2>
  <p>Manage all customer appointments below.</p>
</div>
<div class="card">
  <table class="table">
    <thead>
      <tr>
        <th>#</th><th>Customer</th><th>Email</th><th>Service</th><th>Vehicle</th><th>Plate</th><th>Date</th><th>Time</th><th>Status</th><th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($appts as $a): ?>
      <tr>
        <td><?= (int)$a['id'] ?></td>
        <td><?= htmlspecialchars($a['full_name']) ?></td>
        <td><?= htmlspecialchars($a['email']) ?></td>
        <td><?= htmlspecialchars($a['service_name']) ?></td>
        <td><?= htmlspecialchars($a['vehicle_make'].' '.$a['vehicle_model']) ?></td>
        <td><?= htmlspecialchars($a['plate_no']) ?></td>
        <td><?= htmlspecialchars($a['appointment_date']) ?></td>
        <td><?= htmlspecialchars(substr($a['appointment_time'],0,5)) ?></td>
        <td><span class="badge <?= htmlspecialchars($a['status']) ?>"><?= htmlspecialchars(ucfirst($a['status'])) ?></span></td>
        <td>
          <form method="post" action="/workshop-app/actions/appointment_update.php">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= (int)$a['id'] ?>">
            <select name="status">
              <?php foreach (['pending','approved','completed','cancelled'] as $st): ?>
                <option value="<?= $st ?>" <?= $st===$a['status']?'selected':'' ?>><?= ucfirst($st) ?></option>
              <?php endforeach; ?>
            </select>
            <button class="btn">Save</button>
          </form>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php require_once __DIR__ . '/../partials/footer.php'; ?>