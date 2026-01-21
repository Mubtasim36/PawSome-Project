<?php
$title = 'My Adoption Requests';
$css = ['Assets/css/adopter/my_requests.css', 'Assets/css/common/sidebar.css'];
require APP_PATH . '/views/partials/header.php';
$active = 'requests';
require APP_PATH . '/views/partials/sidebar_adopter.php';
?>

<main class="MainContent">
  <div class="PageHead">
    <h1 class="PageTitle">My Adoption Requests</h1>
    <p class="PageSub">Track your requests and see their current status.</p>
  </div>

  <section class="TableBox">
    <div class="TableActions">
      <button id="reloadBtn" class="SecondaryBtn" type="button">Reload</button>
      <a class="LinkBtn" href="<?= e(base_url('adopter/pets')) ?>">Browse Pets</a>
    </div>

    <div id="requestsWrap" class="TableWrap">
      <div class="Loading">Loading…</div>
    </div>
  </section>
</main>


<script>
  window.__CSRF__ = <?= json_encode($csrf) ?>;
</script>
<script src="<?= e(base_url('Assets/js/adopter/requests.js')) ?>" defer></script>

<?php require APP_PATH . '/views/partials/footer.php'; ?>
