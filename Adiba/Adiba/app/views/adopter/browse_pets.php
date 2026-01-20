<?php
$title = 'Browse Pets';
$css = [
  'Assets/css/adopter/browse_pets.css',
  'Assets/css/common/sidebar.css',
  'Assets/css/common/cards.css'
];
require APP_PATH . '/views/partials/header.php';
$active = 'pets';
require APP_PATH . '/views/partials/sidebar_adopter.php';
?>

<main class="MainContent">

  <div class="PageHead">
    <h1 class="PageTitle">Browse Pets</h1>
    <p class="PageSub">Search and open details to request adoption.</p>
  </div>

  <section class="SearchBar">
    <form method="get" action="<?= e(base_url('adopter/pets')) ?>" class="SearchForm">
      <input
        type="text"
        name="q"
        value="<?= e($q ?? '') ?>"
        placeholder="Search by name, species, breed, or location…"
        class="SearchInput"
      />
      <button class="PrimaryBtn" type="submit">Search</button>
      <?php if (!empty($q)) : ?>
        <a class="GhostBtn" href="<?= e(base_url('adopter/pets')) ?>">Clear</a>
      <?php endif; ?>
    </form>
  </section>

  <section class="Grid">
    <?php if (empty($pets)) : ?>
      <div class="EmptyState">No pets found.</div>
    <?php else : ?>
      <?php foreach ($pets as $p) : ?>

        <?php
          $pid = (int)($p['pet_id'] ?? 0);

          $imgRel = "Assets/images/pets/pet_{$pid}.jpg";
          $imgAbs = BASE_PATH . "/public/" . $imgRel;

          if ($pid <= 0 || !file_exists($imgAbs)) {
            $imgRel = "Assets/images/pets/default.jpg";
          }
        ?>

        <article class="PetCard">

          <img
            class="PetImage"
            src="/Adiba/public/<?= e($imgRel) ?>"
            alt="<?= e($p['name']) ?>"
            onerror="this.onerror=null;this.src='/Adiba/public/Assets/images/pets/default.jpg';"
          >

          <div class="PetTop">
            <h3 class="PetName"><?= e($p['name']) ?></h3>
            <span class="Badge">Available</span>
          </div>

          <div class="PetMeta">
            <div><span class="MetaLabel">Species:</span> <?= e($p['species']) ?></div>
            <div><span class="MetaLabel">Breed:</span> <?= e($p['breed']) ?></div>
            <div><span class="MetaLabel">Age:</span> <?= e((string)$p['age_years']) ?> yrs</div>
            <div><span class="MetaLabel">Gender:</span> <?= e($p['gender']) ?></div>
            <div><span class="MetaLabel">Location:</span> <?= e($p['location']) ?></div>
            <div><span class="MetaLabel">Shelter:</span> <?= e((string)($p['rescued_by'] ?? '-')) ?></div>
          </div>

          <div class="PetBottom">
            <span class="Fee">৳<?= e(number_format((float)$p['adoption_fee'], 2)) ?></span>
            <a
              class="PrimaryBtn"
              href="<?= e(base_url('adopter/petdetails')) ?>?pet_id=<?= (int)$p['pet_id'] ?>"
            >
              View Details
            </a>
          </div>

        </article>

      <?php endforeach; ?>
    <?php endif; ?>
  </section>

</main>

<?php require APP_PATH . '/views/partials/footer.php'; ?>
