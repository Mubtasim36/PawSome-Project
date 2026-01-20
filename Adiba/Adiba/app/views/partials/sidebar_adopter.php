<?php
// Expected: $active string
?>
<aside class="SideBar">
  <a href="<?= e(base_url('adopter/dashboard')) ?>" class="<?= ($active ?? '') === 'dashboard' ? 'Overview' : '' ?>">Overview</a>
  <a href="<?= e(base_url('adopter/pets')) ?>" class="<?= ($active ?? '') === 'pets' ? 'Overview' : '' ?>">Browse Pets</a>
  <a href="<?= e(base_url('adopter/requests')) ?>" class="<?= ($active ?? '') === 'requests' ? 'Overview' : '' ?>">My Adoption Requests</a>
  <a href="<?= e(base_url('adopter/profile')) ?>" class="<?= ($active ?? '') === 'profile' ? 'Overview' : '' ?>">Profile</a>
</aside>
