<?php
$page_title = "Login";
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/csrf.php';
require_once __DIR__ . '/../partials/header.php';
require_once __DIR__ . '/../partials/nav.php';
?>
<div class="grid-2">
  <div class="card">
    <h2>Login</h2>
    <form method="post" action="/workshop-app/actions/auth_login.php" data-validate="required">
      <?= csrf_field() ?>
      <label>Email</label>
      <input type="email" name="email" required>
      <label>Password</label>
      <input type="password" name="password" required>
      <p><button class="btn">Login</button></p>
    </form>
    <p>New here? <a href="/workshop-app/public/register.php">Create an account</a></p>
  </div>
  <div class="card">
    <h3>Benefits of registering</h3>
    <ul>
      <li>Manage your appointments</li>
      <li>Faster booking next time</li>
      <li>View status updates</li>
    </ul>
  </div>
</div>
<?php require_once __DIR__ . '/../partials/footer.php'; ?>