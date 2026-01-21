<?php
$title = 'Create account';
$css = ['Assets/css/auth/register.css'];
require APP_PATH . '/views/partials/header.php';
?>

<main class="AuthWrap">
  <section class="AuthCard">
    <h1 class="AuthTitle">Create your adopter account</h1>
    <p class="AuthSub">Browse pets, request adoption, and track your requests in one place.</p>

    <form id="registerForm" class="AuthForm" novalidate>
      <input type="hidden" name="csrf" value="<?= e($csrf) ?>" />

      <div class="Grid2">
        <div>
          <label class="FieldLabel" for="full_name">Full name</label>
          <input class="FieldInput" id="full_name" name="full_name" type="text" placeholder="Your name" required />
        </div>
        <div>
          <label class="FieldLabel" for="username">Username</label>
          <input class="FieldInput" id="username" name="username" type="text" placeholder="unique username" required />
        </div>
      </div>

      <label class="FieldLabel" for="email">Email</label>
      <input class="FieldInput" id="email" name="email" type="email" placeholder="you@example.com" required />

      <label class="FieldLabel" for="phone">Phone</label>
      <input class="FieldInput" id="phone" name="phone" type="tel" placeholder="01XXXXXXXXX" required />

      <label class="FieldLabel" for="password">Password</label>
      <input class="FieldInput" id="password" name="password" type="password" placeholder="min 6 characters" required />

      <button class="PrimaryBtn" type="submit">Create account</button>
      <div id="msg" class="FormMessage" aria-live="polite"></div>
    </form>

    <div class="AuthLinks">
      <a href="<?= e(base_url('auth/login')) ?>">Already have an account?</a>
    </div>
  </section>
</main>

<script src="<?= e(base_url('Assets/js/auth/register.js')) ?>" defer></script>

<?php require APP_PATH . '/views/partials/footer.php'; ?>
