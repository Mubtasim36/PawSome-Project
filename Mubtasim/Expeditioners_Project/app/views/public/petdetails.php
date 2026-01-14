<!DOCTYPE html>
<html>
  <head>
    <title>PawSome</title>
    <meta charset="UTF-8" />
    <meta name="description" content="PawSome" />
    <meta name="author" content="Al Mubtasim" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />

    <!-- FIXED PATHS -->
<link rel="stylesheet" href="/Expeditioners_Project/public/Assets/css/public/petDetails.css" />
    <script src="/Expeditioners_Project/public/Assets/js/public/petdetails.js" defer></script>
    <link rel="icon" type="image/x-icon" href="/Expeditioners_Project/public/Assets/images/Logo.png" />
  </head>

  <body class="Body">
    <header>
      <div class="header">
        <a href="/" class="SiteName">
          <img
            src="/Assets/images/Logo.png"
            alt="Website Logo"
            width="100"
            height="100"
          />
          PawSome
        </a>

        <div class="nav_bar">
          <a class="Home" href="/">Home</a>
          <a class="About" href="/home#features">About</a>
          <a class="Login" href="/login">Login</a>
          <a class="Signup" href="/signup">Signup</a>
        </div>
      </div>
    </header>

    <div class="pet-profile-container">
      <div class="gallery-section">
         <img class="Petimg" src="/Assets/images/img1.jpg" alt="Pet Image" />
        <img class="Petimg" src="/Assets/images/thumb1.jpg" alt="Thumbnail 1" />
      </div>

      <div class="info-section">
         <div class="info-header">
          <h2><?= htmlspecialchars($pet['name'] ?? 'Pet') ?></h2>
        </div>

        <hr class="line" />

        <div class="info-details">
          <p><span>Species</span><?= htmlspecialchars($pet['species'] ?? 'N/A') ?></p>
          <p><span>Breed</span><?= htmlspecialchars($pet['breed'] ?? 'N/A') ?></p>
          <p><span>Age</span><?= htmlspecialchars(($pet['age_years'] ?? 'N/A') . ' Years') ?></p>
          <p><span>Gender</span><?= htmlspecialchars($pet['gender'] ?? 'N/A') ?></p>
          <p><span>Location</span><?= htmlspecialchars($pet['location'] ?? 'N/A') ?></p>

           <?php if (!empty($pet['personality'])): ?>
            <p><span>Personality</span><?= htmlspecialchars($pet['personality']) ?></p>
          <?php endif; ?>

          <?php if (!empty($pet['rescued_on'])): ?>
            <p><span>Rescued On</span><?= htmlspecialchars($pet['rescued_on']) ?></p>
          <?php endif; ?>

          <?php if (!empty($pet['rescued_by'])): ?>
            <p><span>Rescued By</span><?= htmlspecialchars($pet['rescued_by']) ?></p>
          <?php endif; ?>

          <?php if (!empty($pet['health_status'])): ?>
            <p><span>Health Status</span><?= htmlspecialchars($pet['health_status']) ?></p>
          <?php endif; ?>

          <?php if (!empty($pet['adoption_fee'])): ?>
            <p><span>Adoption Fee</span><?= htmlspecialchars($pet['adoption_fee']) ?></p>
          <?php endif; ?>
        </div>

        <div class="info-description">
          <h3>Description</h3>
          <p>
            <?= nl2br(htmlspecialchars($pet['description'] ?? 'No description available.')) ?>
          </p>
        </div>

        <div class="btnDiv">
           <a class="applybtn" href="/signup"> Apply for Adoption </a>
        </div>
      </div>
    </div>

    <footer class="Footer">
      <p class="footer-text">&copy; 2025 PawSome. All rights reserved.</p>
    </footer>
  </body>
</html>
