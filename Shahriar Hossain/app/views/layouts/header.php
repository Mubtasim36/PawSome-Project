<?php
$user = $_SESSION['user'] ?? null;
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <title>PawSome - Shelter</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>/Assets/css/base.css" />
</head>
<body class="Body">
<header>
  <div class="header">
    <a href="<?= BASE_URL ?>/index.php?r=shelter/dashboard" class="SiteName">
      <img src="<?= BASE_URL ?>/Assets/images/Logo.png" alt="PawSome" class="LogoImg" />
      PawSome
    </a>

    <div class="nav_bar">
      <a class="Home" href="<?= BASE_URL ?>/index.php?r=shelter/dashboard">Dashboard</a>
      <a class="About" href="<?= BASE_URL ?>/index.php?r=shelter/pets">Manage Pets</a>
      <a class="About" href="<?= BASE_URL ?>/index.php?r=shelter/adoptions">Adoption Requests</a>
      <a class="About" href="<?= BASE_URL ?>/index.php?r=shelter/daycare">Daycare</a>
      <a class="Signup" href="<?= BASE_URL ?>/index.php?r=shelter/profile">Profile</a>
    </div>
  </div>
</header>
