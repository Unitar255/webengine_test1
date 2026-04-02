<?php
$page_title = "Book Appointment";
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/csrf.php';
require_once __DIR__ . '/../helpers/auth.php';

require_login();

// Fetch services
$stmt = $pdo->query("SELECT id, name FROM services WHERE active=1 ORDER BY name");
$services = $stmt->fetchAll();

$selected = isset($_GET['service']) ? (int)$_GET['service'] : 0;

require_once __DIR__ . '/../partials/header.php';
require_once __DIR__ . '/../partials/nav.php';
?>
<div class="card">
  <h2>Book an Appointment</h2>

  <form action="/workshop-app/actions/appointment_create.php" method="post">
    <?= csrf_field() ?>
    <div class="grid-2">
      <div>
        <label>Service</label>
        <select name="service_id" required>
          <option value="">-- Select Service --</option>
          <?php foreach ($services as $s): ?>
            <option value="<?= (int)$s['id'] ?>" <?= $selected === (int)$s['id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($s['name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div>
        <label>Appointment Date</label>
        <input type="date" name="appointment_date" min="<?= date('Y-m-d') ?>" required>
      </div>

      <div>
        <label>Appointment Time</label>
        <input type="time" name="appointment_time" required>
      </div>

      <div>
        <label>Vehicle Make</label>
        <input name="vehicle_make" required>
      </div>

      <div>
        <label>Vehicle Model</label>
        <input name="vehicle_model" required>
      </div>

      <div>
        <label>Plate No</label>
        <input name="plate_no" required>
      </div>
    </div>

    <label>Notes (optional)</label>
    <textarea name="notes" rows="4"></textarea>

    <p><button class="btn">Submit Booking</button></p>
  </form>
</div>
<?php require_once __DIR__ . '/../partials/footer.php'; ?>