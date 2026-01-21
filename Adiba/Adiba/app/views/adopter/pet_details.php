<?php
$title = 'Pet Details';
$css = ['Assets/css/adopter/pet_details.css', 'Assets/css/common/sidebar.css', 'Assets/css/common/cards.css'];
require APP_PATH . '/views/partials/header.php';
$active = 'pets';
require APP_PATH . '/views/partials/sidebar_adopter.php';
?>

<main class="MainContent">
  <a class="BackLink" href="<?= e(base_url('adopter/pets')) ?>">← Back to Browse</a>

  <section class="PetDetailsCard">
    <div class="PetDetailsTop">
      <div>
        <h1 class="PetName"><?= e($pet['name'] ?? '') ?></h1>
        <p class="PetMeta"><?= e(($pet['species'] ?? '') . ' • ' . ($pet['breed'] ?? '')) ?> • <?= (int)($pet['age_years'] ?? 0) ?> year(s)</p>
      </div>
      <span class="StatusPill StatusAvailable"><?= e($pet['adoption_status'] ?? '') ?></span>
    </div>

    <div class="PetGrid">
      <div class="InfoGroup">
        <h3>Basic Info</h3>
        <p><strong>Gender:</strong> <?= e($pet['gender'] ?? '-') ?></p>
        <p><strong>Location:</strong> <?= e($pet['location'] ?? '-') ?></p>
        <p><strong>Rescued on:</strong> <?= e($pet['rescued_on'] ?? '-') ?></p>
      </div>

      <div class="InfoGroup">
        <h3>Personality</h3>
        <p><?= e($pet['personality'] ?? '-') ?></p>
      </div>

      <div class="InfoGroup">
        <h3>Health & Fee</h3>
        <p><strong>Health status:</strong> <?= e($pet['health_status'] ?? '-') ?></p>
        <p><strong>Adoption fee:</strong> ৳<?= e((string)($pet['adoption_fee'] ?? '0')) ?></p>
      </div>
    </div>

    <div class="RequestBox">
      <h2 class="SectionTitle">Send Adoption Request</h2>
      <p class="Help">Click “Send Request” to fill the required details (Full name, Address, Phone). Status will be Pending.</p>
      <div class="BtnRow">
        <a class="PrimaryBtn" href="<?= e(base_url('adopter/request')) ?>?pet_id=<?= (int)($pet['pet_id'] ?? 0) ?>">Send Request</a>
        <a class="SecondaryBtn" href="<?= e(base_url('adopter/requests')) ?>">Track my requests</a>
      </div>
    </div>
  </section>
</main>

<?php require APP_PATH . '/views/partials/footer.php'; ?>
