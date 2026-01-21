<?php
$title = 'Set new password';
$css = ['Assets/css/auth/reset.css'];
require APP_PATH . '/views/partials/header.php';
?>

<main class="AuthWrap">
  <section class="AuthCard">
    <h1 class="AuthTitle">Set a new password</h1>
    <p class="AuthSub">Create a new password for your account.</p>

    <form id="resetForm" class="AuthForm">
      <input type="hidden" name="csrf" value="<?= e($csrf) ?>" />
      <label class="FieldLabel" for="email">Email</label>
      <input class="FieldInput" id="email" name="email" type="email" placeholder="you@example.com" value="<?= e($email ?? '') ?>" required />

      <label class="FieldLabel" for="token">Reset Token</label>
      <input class="FieldInput" id="token" name="token" type="text" placeholder="Paste token" value="<?= e($token ?? '') ?>" required />

      <label class="FieldLabel" for="password">New Password</label>
      <input class="FieldInput" id="password" name="password" type="password" placeholder="At least 6 characters" required />

      <button class="PrimaryBtn" type="submit">Update Password</button>
      <div id="msg" class="FormMessage" aria-live="polite"></div>
    </form>

    <div class="AuthLinks">
      <a href="<?= e(base_url('auth/login')) ?>">Back to login</a>
    </div>
  </section>
</main>

<script src="<?= e(base_url('Assets/js/auth/reset.js')) ?>" defer></script>

<?php require APP_PATH . '/views/partials/footer.php'; ?>
