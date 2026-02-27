<?php
$page_title = "Services";
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../partials/header.php';
require_once __DIR__ . '/../partials/nav.php';

$stmt = $pdo->prepare("SELECT id, name, price, duration_minutes FROM services WHERE active=1 ORDER BY name");
$stmt->execute();
$services = $stmt->fetchAll();
?>
<div class="card">
  <h2>Our Services</h2>
  <div class="grid-3">
    <?php foreach ($services as $s): ?>
      <div class="card">
        <h3><?= htmlspecialchars($s['name']) ?></h3>
        <p><strong>RM <?= number_format((float)$s['price'], 2) ?></strong> · <?= (int)$s['duration_minutes'] ?> mins</p>
        <p><a class="btn" href="/workshop-app/public/book.php?service=<?= (int)$s['id'] ?>">Book</a></p>
      </div>
    <?php endforeach; ?>
  </div>
</div>
<?php require_once __DIR__ . '/../partials/footer.php'; ?>