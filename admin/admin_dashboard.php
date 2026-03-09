<?php
$page_title = "Admin Dashboard";
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/csrf.php';
require_once __DIR__ . '/../helpers/auth.php';
require_staff(); // admins AND mechanics can view

// Fetch all appointments with customer + service info
$sql = "SELECT a.id, u.full_name, u.email, s.name AS service_name,
               a.vehicle_make, a.vehicle_model, a.plate_no,
               a.appointment_date, a.appointment_time, a.status
        FROM appointments a
        JOIN users u ON u.id = a.user_id
        JOIN services s ON s.id = a.service_id
        ORDER BY a.appointment_date ASC, a.appointment_time ASC";
$appts = $pdo->query($sql)->fetchAll();

require_once __DIR__ . '/../partials/header.php';
require_once __DIR__ . '/../partials/nav.php';
?>
<div class="card">
  <h2>Admin Dashboard</h2>
  <p>Logged in as: <strong><?= htmlspecialchars(current_user()['full_name']) ?></strong>
     &nbsp;<span class="badge <?= htmlspecialchars(current_user()['role']) ?>"><?= ucfirst(htmlspecialchars(current_user()['role'])) ?></span>
  </p>
</div>
<div class="card">
  <h3>All Appointments (<?= count($appts) ?>)</h3>
  <?php if (!$appts): ?>
    <p>No appointments yet.</p>
  <?php else: ?>
  <table class="table">
    <thead>
      <tr>
        <th>#</th>
        <th>Customer</th>
        <th>Service</th>
        <th>Vehicle</th>
        <th>Plate</th>
        <th>Date</th>
        <th>Time</th>
        <th>Status</th>
        <?php if (is_admin()): ?><th>Action</th><?php endif; ?>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($appts as $a): ?>
      <tr>
        <td><?= (int)$a['id'] ?></td>
        <td>
          <?= htmlspecialchars($a['full_name']) ?><br>
          <small style="color:var(--muted)"><?= htmlspecialchars($a['email']) ?></small>
        </td>
        <td><?= htmlspecialchars($a['service_name']) ?></td>
        <td><?= htmlspecialchars($a['vehicle_make'].' '.$a['vehicle_model']) ?></td>
        <td><?= htmlspecialchars($a['plate_no']) ?></td>
        <td><?= htmlspecialchars($a['appointment_date']) ?></td>
        <td><?= htmlspecialchars(substr($a['appointment_time'], 0, 5)) ?></td>
        <td><span class="badge <?= htmlspecialchars($a['status']) ?>"><?= ucfirst(htmlspecialchars($a['status'])) ?></span></td>
        <?php if (is_admin()): ?>
        <td>
          <form method="post" action="/workshop-app/actions/appointment_update.php" style="display:flex;gap:.4rem;align-items:center">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= (int)$a['id'] ?>">
            <select name="status" style="padding:.3rem .5rem;font-size:.82rem;width:auto">
              <?php foreach (['pending','approved','completed','cancelled'] as $st): ?>
                <option value="<?= $st ?>" <?= $st === $a['status'] ? 'selected' : '' ?>><?= ucfirst($st) ?></option>
              <?php endforeach; ?>
            </select>
            <button class="btn" style="padding:.3rem .7rem;font-size:.82rem">Save</button>
          </form>
        </td>
        <?php endif; ?>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?php endif; ?>
</div>
<?php require_once __DIR__ . '/../partials/footer.php'; ?>
