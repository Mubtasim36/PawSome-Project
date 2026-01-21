<!DOCTYPE html>
<html>
  <head>
    <title>PawSome</title>
    <meta charset="UTF-8" />
    <meta name="description" content="PawSome" />
    <meta name="author" content="Al Mubtasim" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />

    <link rel="stylesheet" href="/Expeditioners_Project/public/Assets/css/admin/M_Pets.css" />
    <script src="/Expeditioners_Project/public/Assets/js/admin/M_Pets.js" defer></script>

    <link rel="icon" type="image/x-icon" href="/Expeditioners_Project/public/Assets/images/Logo.png" />
  </head>

  <body class="Body">
    <header>
      <div class="header">
        <a href="/Expeditioners_Project/public/admin/dashboard" class="SiteName">
          <img
            src="/Expeditioners_Project/public/Assets/images/Logo.png"
            alt="Website Logo"
            width="100"
            height="100"
          />
          PawSome
        </a>

        <div class="nav_bar">
          <a class="Home" href="/Expeditioners_Project/public/admin/dashboard">Home</a>
          <a class="Logout" href="/Expeditioners_Project/public/logout">Logout</a>
        </div>
      </div>
    </header>

    <div class="headerAdmin">
      <h1>Pets Management</h1>
      <p>Manage All Pets via One Page</p>
    </div>

    <div class="SideBar">
      <a class="Overview" href="/Expeditioners_Project/public/admin/dashboard">Overview</a>
      <a class="Manage_Users" href="/Expeditioners_Project/public/admin/users">Manage Users</a>
      <a class="Manage_Pets" href="/Expeditioners_Project/public/admin/pets">Manage Pets</a>
      <a class="Manage_Adoptions" href="/Expeditioners_Project/public/admin/adoptions">Manage Adoptions</a>
      <a class="Profile" href="/Expeditioners_Project/public/admin/profile">Profile</a>

    </div>

    <div class="ManagePets">
      <h2 class="ManagePetsHeader">Manage Pets</h2>
      <p class="TSubHeader">Monitor and control all pets listed by shelters</p>

      <table class="ManagePetsTable">
        <thead>
          <tr>
            <th>Pet ID</th>
            <th>Name</th>
            <th>Species</th>
            <th>Breed</th>
            <th>Age</th>
            <th>Health</th>
            <th>Adoption Status</th>
            <th>Shelter ID</th>
            <th>Actions</th>
          </tr>
        </thead>

        <!-- AJAX WILL FILL THIS -->
        <tbody id="petsTableBody">
          <tr>
            <td colspan="9">Loading pets...</td>
          </tr>
        </tbody>
      </table>
      <!-- PAGINATION FOOTER -->
      <div class="UsersTableFooter">
<p id="petsShowingText">Showing 0 out of 0</p>

<button id="prevPetsBtn" class="prevBtn" type="button">Prev</button>
<button id="nextPetsBtn" class="nextBtn" type="button">Next</button>

    </div>
  </body>
</html>
