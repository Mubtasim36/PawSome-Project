<!DOCTYPE html>
<html>
  <head>
    <title>PawSome</title>
    <meta charset="UTF-8" />
    <meta name="description" content="PawSome" />
    <meta name="author" content="Al Mubtasim" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />

    <link
      rel="stylesheet"
      href="/Expeditioners_Project/public/Assets/css/admin/AdminDashboard.css"
    />
    <script
      src="/Expeditioners_Project/public/Assets/js/admin/AdminDashboard.js"
      defer
    ></script>

    <link
      rel="icon"
      type="image/x-icon"
      href="/Expeditioners_Project/public/Assets/images/Logo.png"
    />
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
      <h1>Admin Dashboard</h1>
      <p>Monitor platform activity and keep everything running smoothly.</p>
    </div>

    <div class="CountCard">
      <div class="UserCount">
        <h3>Total Registered Users</h3>
        <h2 class="Count1"><?= (int)($totalUsers ?? 0) ?></h2>
        <p>Adopters, Shelters & Admins</p>
      </div>

      <div class="PetsCount">
        <h3>Total Registered Pets</h3>
        <h2 class="Count2"><?= (int)($totalPets ?? 0) ?></h2>
        <p>Pets Rescued And Registered</p>
      </div>

      <div class="AdoptionCount">
        <h3>Total Adoptions</h3>
        <h2 class="Count3"><?= (int)($totalAdoptions ?? 0) ?></h2>
        <p>Pets Found Home</p>
      </div>
    </div>

    <div class="SideBar">
      <a class="Overview" href="/Expeditioners_Project/public/admin/dashboard">Overview</a>
      <a class="Manage_Users" href="/Expeditioners_Project/public/admin/users">Manage Users</a>
      <a class="Manage_Pets" href="/Expeditioners_Project/public/admin/pets">Manage Pets</a>
      <a class="Manage_Adoptions" href="/Expeditioners_Project/public/admin/adoptions">Manage Adoptions</a>
      <a class="Profile" href="/Expeditioners_Project/public/admin/profile">Profile</a>

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

  <?php if (!empty($logs)): ?>
    <?php foreach ($logs as $log): ?>
      <tr>
        <td><?= htmlspecialchars($log['log_id']) ?></td>
        <td><?= htmlspecialchars(ucfirst($log['category'])) ?></td>
        <td><?= htmlspecialchars($log['description']) ?></td>
        <td><?= htmlspecialchars($log['performed_by'] ?? 'System') ?></td>
        <td><?= htmlspecialchars($log['created_at']) ?></td>
      </tr>
    <?php endforeach; ?>
  <?php else: ?>
    <tr>
      <td colspan="5">No activity found.</td>
    </tr>
  <?php endif; ?>
</table>
    </div>
  </body>
</html>
