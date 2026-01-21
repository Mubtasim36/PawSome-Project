<!DOCTYPE html>
<html>
  <head>
    <title>PawSome</title>
    <meta charset="UTF-8" />
    <meta name="description" content="PawSome" />
    <meta name="author" content="Al Mubtasim" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />

    <link rel="stylesheet" href="/Expeditioners_Project/public/Assets/css/admin/M_Users.css" />
    <script src="/Expeditioners_Project/public/Assets/js/admin/M_Users.js" defer></script>

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
          <a class="Home" href="/Expeditioners_Project/public/home">Home</a>
          <a class="Logout" href="/Expeditioners_Project/public/logout">Logout</a>
        </div>
      </div>
    </header>

    <div class="headerAdmin">
      <h1>User Management</h1>
      <p>Manage All Users via One Page</p>
    </div>

    <div class="SideBar">
      <a class="Overview" href="/Expeditioners_Project/public/admin/dashboard">Overview</a>
      <a class="Manage_Users" href="/Expeditioners_Project/public/admin/users">Manage Users</a>
      <a class="Manage_Pets" href="/Expeditioners_Project/public/admin/pets">Manage Pets</a>
      <a class="Manage_Adoptions" href="/Expeditioners_Project/public/admin/adoptions">Manage Adoptions</a>
      <a class="Profile" href="/Expeditioners_Project/public/admin/profile">Profile</a>

    </div>

      <div class="ManageUsers">
      <h2 class="ManageUsersHeader">Manage Users</h2>
      <p class="TSubHeader">View and manage adopter and shelter accounts</p>

      <table class="ManageUsersTable">
  <thead>
    <tr>
      <th>User ID</th>
      <th>Name</th>
      <th>Email</th>
      <th>Role</th>
      <th>Join Date</th>
      <th>Actions</th>
    </tr>
  </thead>

  <!-- AJAX WILL FILL THIS -->
  <tbody id="usersTableBody">
    <tr>
      <td colspan="6">Loading users...</td>
    </tr>
  </tbody>
</table>

<!-- PAGINATION FOOTER -->
<div class="UsersTableFooter">

  <p id="usersShowingText">Showing 0 out of 0</p>

  <div class="PaginationButtons">
    <button id="prevBtn" class="prevBtn" type="button">Prev</button>
    <button id="nextBtn" class="nextBtn" type="button">Next</button>
  </div>
</div>

    </div>
  </body>
</html>
