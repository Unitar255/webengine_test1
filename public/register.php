<?php
$page_title = "Register";
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/csrf.php';
require_once __DIR__ . '/../partials/header.php';
require_once __DIR__ . '/../partials/nav.php';
?>
<div class="card">
  <h2>Create Account</h2>
  <form method="post" action="/workshop-app/actions/auth_register.php" data-validate="required">
    <?= csrf_field() ?>
    <label>Full Name</label>
    <input name="full_name" required>
    <label>Email</label>
    <input type="email" name="email" required>
    <label>Password</label>
    <input type="password" name="password" minlength="6" required>
    <p><button class="btn">Register</button></p>
  </form>
  <p>Already have an account? <a href="/workshop-app/public/login.php">Login</a></p>
</div>
<?php require_once __DIR__ . '/../partials/footer.php'; ?>
