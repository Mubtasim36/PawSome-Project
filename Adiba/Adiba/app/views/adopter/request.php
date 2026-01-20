<?php
$title = 'Adoption Request';
$css = [
  'Assets/css/adopter/request.css',
  'Assets/css/common/sidebar.css',
  'Assets/css/common/cards.css'
];
require APP_PATH . '/views/partials/header.php';
$active = 'pets';
require APP_PATH . '/views/partials/sidebar_adopter.php';
?>

<main class="MainContent">
  <a class="BackLink" href="<?= e(base_url('adopter/petdetails')) ?>?pet_id=<?= (int)($pet['pet_id'] ?? 0) ?>">← Back to Pet Details</a>

  <section class="Card">
    <h1 class="PageTitle">Adoption Request</h1>
    <p class="PageSub">You are requesting to adopt <b><?= e((string)($pet['name'] ?? '')) ?></b>.</p>

    <?php if (!empty($_SESSION['error'])): ?>
      <div class="ErrorBox"><?= e((string)$_SESSION['error']); unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <form method="post" action="<?= e(base_url('adopter/request')) ?>?pet_id=<?= (int)($pet['pet_id'] ?? 0) ?>" class="Form">
      <input type="hidden" name="csrf" value="<?= e($csrf) ?>" />

      <label class="Label">Full Name <span class="Req">*</span></label>
      <input class="Input" type="text" name="full_name" required value="<?= e((string)($_POST['full_name'] ?? ($user['full_name'] ?? ''))) ?>" />

      <label class="Label">Address <span class="Req">*</span></label>
      <textarea class="TextArea" name="address" required rows="3"><?= e((string)($_POST['address'] ?? '')) ?></textarea>

      <label class="Label">Phone Number <span class="Req">*</span></label>
      <input class="Input" type="text" name="phone" required value="<?= e((string)($_POST['phone'] ?? ($user['phone'] ?? ''))) ?>" />

      <div class="BtnRow">
        <button class="PrimaryBtn" type="submit">Submit Request</button>
        <a class="SecondaryBtn" href="<?= e(base_url('adopter/requests')) ?>">Track my requests</a>
      </div>
    </form>
  </section>
</main>

<?php require APP_PATH . '/views/partials/footer.php'; ?>
