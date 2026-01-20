<?php
$title = 'Request Submitted';
$css = [
  'Assets/css/adopter/request_submitted.css',
  'Assets/css/common/sidebar.css',
  'Assets/css/common/cards.css'
];
require APP_PATH . '/views/partials/header.php';
$active = 'requests';
require APP_PATH . '/views/partials/sidebar_adopter.php';
?>

<main class="MainContent">
  <section class="Card">
    <h1 class="PageTitle">Request Submitted</h1>
    <div class="SuccessBox">Request Sent, wait for approval</div>
    <?php if (!empty($pet_name)): ?>
      <p class="InfoLine">Pet: <b><?= e((string)$pet_name) ?></b></p>
    <?php endif; ?>
    <p class="InfoLine">Status: <b><?= e((string)$status) ?></b></p>

    <div class="BtnRow">
      <a class="PrimaryBtn" href="<?= e(base_url('adopter/requests')) ?>">View My Adoption Requests</a>
      <a class="SecondaryBtn" href="<?= e(base_url('adopter/pets')) ?>">Browse Pets</a>
    </div>
  </section>
</main>

<?php require APP_PATH . '/views/partials/footer.php'; ?>
