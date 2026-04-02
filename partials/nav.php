<?php $user = $_SESSION['user'] ?? null; ?>
<header class="site-header">
  <div class="container nav">
    <a class="logo" href="/workshop-app/public/index.php">🚗 Workshop</a>
    <nav>
      <a href="/workshop-app/public/about.php">About</a>
      <a href="/workshop-app/public/services.php">Services</a>
      <a href="/workshop-app/public/book.php">Book</a>
      <a href="/workshop-app/public/contact.php">Contact</a>
      <?php if ($user): ?>
        <a href="/workshop-app/public/dashboard.php">Dashboard</a>
        <a href="/workshop-app/public/logout.php">Logout</a>
      <?php else: ?>
        <a href="/workshop-app/public/login.php">Login</a>
        <a href="/workshop-app/public/register.php">Register</a>
      <?php endif; ?>
    </nav>
  </div>
</header>
<main class="container">
<?php if (!empty($_SESSION['flash_error'])): ?>
  <div class="alert error"><?= htmlspecialchars($_SESSION['flash_error']) ?></div>
  <?php unset($_SESSION['flash_error']); ?>
<?php endif; ?>
<?php if (!empty($_SESSION['flash_success'])): ?>
  <div class="alert success"><?= htmlspecialchars($_SESSION['flash_success']) ?></div>
  <?php unset($_SESSION['flash_success']); ?>
<?php endif; ?>