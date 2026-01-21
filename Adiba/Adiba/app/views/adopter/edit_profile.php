<?php
$title = 'Edit Profile';
$css = ['Assets/css/adopter/edit_profile.css', 'Assets/css/common/sidebar.css'];
require APP_PATH . '/views/partials/header.php';
$active = 'profile';
require APP_PATH . '/views/partials/sidebar_adopter.php';
?>

<main class="MainContent">
  <div class="PageHead">
    <h1 class="PageTitle">Edit Profile</h1>
    <p class="PageSub">Update your personal information.</p>
  </div>

  <section class="FormCard">
    <form id="profileForm" class="FormGrid">
      <input type="hidden" name="csrf" value="<?= e($csrf) ?>" />

      <label class="FieldLabel" for="full_name">Full name</label>
      <input class="FieldInput" id="full_name" name="full_name" type="text" value="<?= e((string)($user['full_name'] ?? '')) ?>" required />

      <label class="FieldLabel" for="username">Username</label>
      <input class="FieldInput" id="username" name="username" type="text" value="<?= e((string)($user['username'] ?? '')) ?>" required />

      <label class="FieldLabel" for="phone">Phone</label>
      <input class="FieldInput" id="phone" name="phone" type="text" value="<?= e((string)($user['phone'] ?? '')) ?>" required />

      <div class="FormActions">
        <a class="SecondaryBtn" href="<?= e(base_url('adopter/profile')) ?>">Cancel</a>
        <button class="PrimaryBtn" type="submit">Save changes</button>
      </div>

      <div id="msg" class="FormMessage" aria-live="polite"></div>
    </form>
  </section>
</main>

<script>
  window.__CSRF__ = <?= json_encode($csrf) ?>;
</script>
<script src="<?= e(base_url('Assets/js/adopter/edit_profile.js')) ?>" defer></script>

<?php require APP_PATH . '/views/partials/footer.php'; ?>
