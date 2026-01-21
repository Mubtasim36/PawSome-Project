<?php
// Expected variables: $title (string), $user (array|null)
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <title><?= e($title ?? 'PawSome') ?></title>
  <!-- Using system font stack; CSS uses "Poppins" as primary if available -->
  <link rel="icon" type="image/x-icon" href="<?= e(base_url('Assets/images/Logo.png')) ?>" />
  <link rel="stylesheet" href="<?= e(base_url('Assets/css/common/base.css')) ?>" />
  <link rel="stylesheet" href="<?= e(base_url('Assets/css/common/header.css')) ?>" />
  <?php if (!empty($css)) : ?>
    <?php foreach ((array)$css as $cssFile) : ?>
      <link rel="stylesheet" href="<?= e(base_url($cssFile)) ?>" />
    <?php endforeach; ?>
  <?php endif; ?>
</head>
<body>

<script>
  window.__BASE__ = <?= json_encode(base_url('')) ?>;
</script>

<header>
  <div class="header">
    <a href="<?= e(base_url(is_logged_in() ? 'adopter/dashboard' : 'auth/login')) ?>" class="SiteName">
      PawSome
    </a>
    <div class="nav_bar">
      <?php if (!empty($user)) : ?>
        <a href="<?= e(base_url('adopter/dashboard')) ?>" class="Home">Home</a>
        <a href="<?= e(base_url('auth/logout')) ?>" class="Logout">Logout</a>
      <?php else : ?>
        <a href="<?= e(base_url('auth/login')) ?>" class="Home">Login</a>
        <a href="<?= e(base_url('auth/register')) ?>" class="Logout">Create account</a>
      <?php endif; ?>
    </div>
  </div>
</header>
