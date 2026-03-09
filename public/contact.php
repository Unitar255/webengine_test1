<?php
$page_title = "Contact";
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/csrf.php';
require_once __DIR__ . '/../partials/header.php';
require_once __DIR__ . '/../partials/nav.php';
?>
<div class="card">
  <h2>Contact Us</h2>
  <form method="post" action="/workshop-app/actions/contact_submit.php" data-validate="required">
    <?= csrf_field() ?>
    <label>Name</label>
    <input name="name" required>
    <label>Email</label>
    <input type="email" name="email" required>
    <label>Subject</label>
    <input name="subject" required>
    <label>Message</label>
    <textarea name="message" rows="5" required></textarea>
    <p><button class="btn">Send</button></p>
  </form>
</div>
<?php require_once __DIR__ . '/../partials/footer.php'; ?>
