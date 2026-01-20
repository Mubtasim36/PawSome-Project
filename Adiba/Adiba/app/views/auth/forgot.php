<?php
$title = 'Reset password';
$css = ['Assets/css/auth/forgot.css'];
require APP_PATH . '/views/partials/header.php';
?>

<main class="AuthWrap">
  <section class="AuthCard">
    <h1 class="AuthTitle">Reset your password</h1>
    <p class="AuthSub">Enter your account email. This demo project will generate a reset link (shown below) instead of sending email.</p>

    <form id="forgotForm" class="AuthForm">
      <input type="hidden" name="csrf" value="<?= e($csrf) ?>" />
      <label class="FieldLabel" for="email">Email</label>
      <input class="FieldInput" id="email" name="email" type="email" placeholder="you@example.com" required />
      <button class="PrimaryBtn" type="submit">Generate reset link</button>
      <div id="msg" class="FormMessage" aria-live="polite"></div>
      <div id="linkBox" class="ResetLinkBox" hidden>
        <div class="ResetLinkTitle">Your reset link</div>
        <a id="resetLink" href="#" class="ResetLink" target="_self"></a>
      </div>
    </form>

    <div class="AuthLinks">
      <a href="<?= e(base_url('auth/login')) ?>">Back to login</a>
    </div>
  </section>
</main>

<script src="<?= e(base_url('Assets/js/auth/forgot.js')) ?>" defer></script>

<?php require APP_PATH . '/views/partials/footer.php'; ?>
