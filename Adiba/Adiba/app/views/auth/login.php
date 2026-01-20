<?php
$title = 'Login';
$css = ['Assets/css/auth/login.css'];
require APP_PATH . '/views/partials/header.php';
?>

<main class="AuthWrap">
  <section class="AuthCard">
    <h1 class="AuthTitle">Welcome back</h1>
    <p class="AuthSub">Login to access your personalized dashboard and manage adoption requests.</p>

    <form id="loginForm" class="AuthForm">
      <input type="hidden" name="csrf" value="<?= e($csrf) ?>" />

      <label class="FieldLabel" for="email">Email</label>
      <input class="FieldInput" id="email" name="email" type="email" placeholder="you@example.com" required />

      <label class="FieldLabel" for="password">Password</label>
      <input class="FieldInput" id="password" name="password" type="password" placeholder="••••••••" required />

      <button class="PrimaryBtn" type="submit">Login</button>

      <div id="msg" class="FormMessage" aria-live="polite"></div>
    </form>

    <div class="AuthLinks">
      <a href="<?= e(base_url('auth/forgot')) ?>">Forgot password?</a>
      <span>•</span>
      <a href="<?= e(base_url('auth/register')) ?>">Create account</a>
    </div>
  </section>
</main>

<script src="<?= e(base_url('Assets/js/auth/login.js')) ?>" defer></script>

<?php require APP_PATH . '/views/partials/footer.php'; ?>
