<!DOCTYPE html>
<html>
  <head>
    <title>PawSome</title>
    <meta charset="UTF-8" />
    <meta name="description" content="PawSome" />
    <meta name="author" content="Al Mubtasim" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <link rel="stylesheet" href="AdminDashboard.css" />
    <script src="AdminDashboard.js"></script>
    <link rel="icon" type="image/x-icon" href="Images/Logo.png" />
  </head>

  <body class="Body">
    <!-- Top Header with Navigation Bar and Registration Links -->
    <header>
      <div class="header">
        <a href="home.html" class="SiteName">
          <img
            src="Images/Logo.png"
            alt="Website Logo"
            width="100"
            height="100"
          />
          PawSome
        </a>

        <div class="nav_bar">
          <a class="Home" href="home.html">Home</a>
          <a class="Logout" href="home.html">Logout</a>
        </div>
      </div>
    </header>

    <div class="headerAdmin">
      <h1>Admin Dashboard</h1>
      <p>Monitor platform activity and keep everything running smoothly.</p>
    </div>

    <div class="CountCard">
      <div class="UserCount">
        <h3>Total Registered Users</h3>
        <h2 class="Count1"><?= htmlspecialchars($totalUsers) ?></h2>
        <p>Adopters, Shelters & Admins</p>
      </div>

      <div class="PetsCount">
        <h3>Total Registered Pets</h3>
        <h2 class="Count2"><?= htmlspecialchars($totalPets) ?></h2>
        <p>Pets Rescued And Registered</p>
      </div>

      <div class="AdoptionCount">
        <h3>Total Adoptions</h3>
        <h2 class="Count3"><?= htmlspecialchars($totalAdoptions) ?></h2>
        <p>Pets Found Home</p>
      </div>
    </div>

    <div class="SideBar">
      <a class="Overview" href="AdminDashboard.html">Overview</a>
      <a class="Manage_Users" href="M_Users.html">Manage Users</a>
      <a class="Manage_Pets" href="M_Pets.html">Manage Pets</a>
      <a class="Manage_Adoptions" href="M_Adoptions.html">Manage Adoptions</a>
    </div>

    <div class="AdminActivity">
      <h2 class="AdminActivityHeader">System Activity Log</h2>
      <p>Recent actions performed on the platform</p>

      <table class="AdminActivityTable">
        <tr>
          <th>Log ID</th>
          <th>Category</th>
          <th>Description</th>
          <th>Performed By</th>
          <th>Date & Time</th>
        </tr>

        <tr>
          <td>1</td>
          <td>User</td>
          <td>User John Doe disabled</td>
          <td>Admin User</td>
          <td>2025-12-29 21:10</td>
        </tr>

        <tr>
          <td>2</td>
          <td>Adoption</td>
          <td>Adoption A301 approved</td>
          <td>Admin User</td>
          <td>2025-12-29 21:25</td>
        </tr>

        <tr>
          <td>3</td>
          <td>System</td>
          <td>New shelter Paw Rescue Bangladesh registered</td>
          <td>System</td>
          <td>2025-12-29 21:40</td>
        </tr>

        <tr>
          <td>4</td>
          <td>User</td>
          <td>User Jane Smith created</td>
          <td>Admin User</td>
          <td>2025-12-29 22:05</td>
        </tr>

        <tr>
          <td>5</td>
          <td>Adoption</td>
          <td>Adoption A302 rejected</td>
          <td>Admin User</td>
          <td>2025-12-29 22:20</td>
        </tr>

        <tr>
          <td>6</td>
          <td>System</td>
          <td>System maintenance completed</td>
          <td>System</td>
          <td>2025-12-29 22:45</td>
        </tr>
      </table>
    </div>
  </body>
</html>
