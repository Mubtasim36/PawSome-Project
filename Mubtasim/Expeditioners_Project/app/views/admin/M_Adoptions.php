<!DOCTYPE html>
<html>
  <head>
    <title>PawSome</title>
    <meta charset="UTF-8" />
    <meta name="description" content="PawSome" />
    <meta name="author" content="Al Mubtasim" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />

    <link rel="stylesheet" href="/Expeditioners_Project/public/Assets/css/admin/M_Adoptions.css" />
    <script src="/Expeditioners_Project/public/Assets/js/admin/M_Adoptions.js" defer></script>

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
      <h1>Adoption Management</h1>
      <p>Manage All Adoption via One Page</p>
    </div>

    <div class="SideBar">
      <a class="Overview" href="/Expeditioners_Project/public/admin/dashboard">Overview</a>
      <a class="Manage_Users" href="/Expeditioners_Project/public/admin/users">Manage Users</a>
      <a class="Manage_Pets" href="/Expeditioners_Project/public/admin/pets">Manage Pets</a>
      <a class="Manage_Adoptions" href="/Expeditioners_Project/public/admin/adoptions">Manage Adoptions</a>
      <a class="Profile" href="/Expeditioners_Project/public/admin/profile">Profile</a>
    </div>

    <!----Manage Adoptions-->
    <div class="ManageAdoptions">
      <h2 class="ManageAdoptionsHeader">Manage Adoptions</h2>
      <p class="TSubHeader">Review and manage all adoption requests</p>

      <table class="ManageAdoptionsTable">
        <thead>
          <tr>
            <th>Adoption ID</th>
            <th>Pet Name</th>
            <th>Adopter</th>
            <th>Shelter</th>
            <th>Status</th>
            <th>Requested At</th>
            <th>Actions</th>
          </tr>
        </thead>

      <tbody id="adoptionsTableBody">
  <tr>
    <td colspan="7">Loading adoptions...</td>
  </tr>
</tbody>
      </table>

      <!-- PAGINATION FOOTER -->
     <div class="UsersTableFooter">
  <p id="adoptionsShowingText">Showing 0 out of 0</p>
  <div>
    <button id="prevBtn" class="prevBtn">Prev</button>
    <button id="nextBtn" class="nextBtn">Next</button>
  </div>
</div>
    </div>

  </body>
</html>