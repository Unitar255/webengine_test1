<?php
$page_title = "Home";
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../partials/header.php';
require_once __DIR__ . '/../partials/nav.php';
?>
<section class="hero">
  <div>
    <h1>Book Your Car Service Online</h1>
    <p>Fast, reliable, and transparent. Reserve your slot for servicing, diagnostics, or repairs.</p>
    <p>
      <a class="btn" href="/workshop-app/public/book.php">Book an Appointment</a>
      <a class="btn-outline" href="/workshop-app/public/services.php">View Services</a>
    </p>
  </div>
  <div class="card">
    <h3>Why choose us?</h3>
    <ul>
      <li>Certified mechanics</li>
      <li>Transparent pricing</li>
      <li>Online scheduling &amp; reminders</li>
    </ul>
  </div>
</section>
<?php require_once __DIR__ . '/../partials/footer.php'; ?>