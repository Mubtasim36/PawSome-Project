<!DOCTYPE html>
<html>
  <head>
    <title>PawSome</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <link rel="stylesheet" href="/Expeditioners_Project/public/Assets/css/public/browsepets.css" />
    <link rel="icon" type="image/x-icon" href="/Assets/images/Logo.png" />
  </head>

  <body class="Body">
    <div class="header">
       <a href="/Expeditioners_Project/public/home" class="SiteName">
          <img
            src="/Expeditioners_Project/public/Assets/images/Logo.png"
            alt="Website Logo"
            width="100"
            height="100"
          />
          PawSome
        </a>

      <div class="nav_bar">
        <a class="Home" href="/Expeditioners_Project/public/">Home</a>
<a class="About" href="/Expeditioners_Project/public/home#features">About</a>
<a class="Login" href="/Expeditioners_Project/public/login">Login</a>
<a class="Signup" href="/Expeditioners_Project/public/signup">Signup</a>
      </div>
    </div>

    <div class="ManagePets">
  <h2 class="ManagePetsHeader">Available Pets</h2>
<div class="PetCount"> <?php echo "Number of Pets Available :" . (isset($pets) ? count($pets) : 'pets not set'); ?> </div>

  <table class="ManagePetsTable">
    <thead>
      <tr>
        <th>Name</th>
        <th>Species</th>
        <th>Breed</th>
        <th>Age</th>
        <th>Gender</th>
        <th>Location</th>
        <th>Action</th>
      </tr>
    </thead>

    <tbody>
      
      <?php if (!empty($pets)): ?>
        <?php foreach ($pets as $p): ?>
          
          <tr>
            <td><?= htmlspecialchars($p['name'] ?? '') ?></td>
            <td><?= htmlspecialchars($p['species'] ?? '') ?></td>
            <td><?= htmlspecialchars($p['breed'] ?? '') ?></td>
            <td><?= htmlspecialchars(($p['age_years'] ?? '') . ' Years') ?></td>
            <td><?= htmlspecialchars($p['gender'] ?? '') ?></td>
            <td><?= htmlspecialchars($p['location'] ?? '') ?></td>
            <td class="ActionButtons">
              <a
                class="ViewBtn"
                href="/pets/view?id=<?= urlencode($p['pet_id']) ?>"
              >
                View
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="7">No pets found.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
  
</div>
  </body>
</html>