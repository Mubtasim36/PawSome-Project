<?php
$title = 'Adopter Dashboard';
$css = ['Assets/css/adopter/dashboard.css', 'Assets/css/common/sidebar.css', 'Assets/css/common/cards.css'];
require APP_PATH . '/views/partials/header.php';
$active = 'dashboard';
require APP_PATH . '/views/partials/sidebar_adopter.php';
?>

<main class="MainContent">
  <div class="headerAdmin">
    <h1 class="PageTitle">Welcome, <?= e($user['full_name'] ?? 'Adopter') ?></h1>
    <p class="PageSub">Your personalized dashboard for browsing pets and tracking adoption requests.</p>
  </div>

  <section class="CountCard">
    <div class="UserCount">
      <h2><?= (int)($petsAdopted ?? 0) ?></h2>
      <p>Pets Adopted</p>
    </div>
    <div class="PetsCount">
      <h2><?= (int)($totalRequests ?? 0) ?></h2>
      <p>Adoption Requests</p>
    </div>
    <div class="AdoptionCount">
      <h2>✓</h2>
      <p>Track requests in real-time</p>
    </div>
  </section>

  <section class="CardGrid">
    <a class="ActionCard" href="<?= e(base_url('adopter/pets')) ?>">
      <h3>Browse Pets</h3>
      <p>View available pets and open details to request adoption.</p>
    </a>
    <a class="ActionCard" href="<?= e(base_url('adopter/requests')) ?>">
      <h3>Track Requests</h3>
      <p>See pending/approved/completed requests and update status.</p>
    </a>
    <a class="ActionCard" href="<?= e(base_url('adopter/profile')) ?>">
      <h3>Manage Profile</h3>
      <p>Edit profile information, change password, or delete account.</p>
    </a>
  </section>

  <section class="RecentBox">
    <div class="RecentHeader">
      <h2 class="SectionTitle">Recent Requests</h2>
      <a class="LinkBtn" href="<?= e(base_url('adopter/requests')) ?>">View all</a>
    </div>

    <div id="recentRequests" class="TableWrap">
      <div class="Loading">Loading…</div>
    </div>
  </section>
</main>

<script>
  window.__CSRF__ = <?= json_encode($csrf) ?>;
</script>
<script src="<?= e(base_url('Assets/js/adopter/dashboard.js')) ?>" defer></script>

<?php require APP_PATH . '/views/partials/footer.php'; ?>
