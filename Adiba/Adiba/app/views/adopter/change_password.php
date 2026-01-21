<?php
$title = 'Change Password';
$css = ['Assets/css/adopter/change_password.css', 'Assets/css/common/sidebar.css'];
require APP_PATH . '/views/partials/header.php';
$active = 'profile';
require APP_PATH . '/views/partials/sidebar_adopter.php';
?>

<main class="MainContent">
  <div class="PageHead">
    <h1 class="PageTitle">Change Password</h1>
    <p class="PageSub">Use a strong password (at least 6 characters). For better security, use 8+ and include numbers/symbols.</p>
  </div>

  <section class="FormCard">
    <form id="changePwForm" class="Form">
      <input type="hidden" name="csrf" value="<?= e($csrf) ?>" />

      <label class="FieldLabel" for="current_password">Current password</label>
      <input class="FieldInput" id="current_password" name="current_password" type="password" required />

      <label class="FieldLabel" for="new_password">New password</label>
      <input class="FieldInput" id="new_password" name="new_password" type="password" minlength="6" required />

      <label class="FieldLabel" for="confirm_password">Confirm new password</label>
      <input class="FieldInput" id="confirm_password" name="confirm_password" type="password" minlength="6" required />

      <button class="PrimaryBtn" type="submit">Update Password</button>
      <a class="SecondaryBtn" href="<?= e(base_url('adopter/profile')) ?>">Back</a>
      <div id="pwMsg" class="FormMessage" aria-live="polite"></div>
    </form>
  </section>
</main>

<script src="<?= e(base_url('Assets/js/adopter/change_password.js')) ?>" defer></script>

<?php require APP_PATH . '/views/partials/footer.php'; ?>
