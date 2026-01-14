
<!DOCTYPE html>
<html>
  <head>
    <title>PawSome</title>
    <meta charset="UTF-8" />
    <meta name="description" content="PawSome" />
    <meta name="author" content="Al Mubtasim" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <link rel="stylesheet" href="M_Adoptions.css" />
    <script src="M_Adoptions.js"></script>
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
      <h1>Adoption Management</h1>
      <p>Manage All Adoption via One Page</p>
    </div>

    <div class="SideBar">
      <a class="Overview" href="AdminDashboard.html">Overview</a>
      <a class="Manage_Users" href="M_Users.html">Manage Users</a>
      <a class="Manage_Pets" href="M_Pets.html">Manage Pets</a>
      <a class="Manage_Adoptions" href="M_Adoptions.html">Manage Adoptions</a>
    </div>
    
    <!----Manage Adoptions-->
    <div class="ManageAdoptions">
      <h2 class="ManageAdoptionsHeader">Manage Adoptions</h2>
      <p>Review and manage all adoption requests</p>

      <table class="ManageAdoptionsTable">
        <tr>
          <th>Adoption ID</th>
          <th>Pet Name</th>
          <th>Adopter</th>
          <th>Shelter</th>
          <th>Status</th>
          <th>Requested At</th>
          <th>Actions</th>
        </tr>

        <tr>
          <td>A001</td>
          <td>Buddy</td>
          <td>John Doe</td>
          <td>Paw Rescue Bangladesh</td>
          <td class="StatusPending">Pending</td>
          <td>2025-12-30 10:15</td>
          <td class="ActionButtons">
            <button class="ApproveBtn">Approve</button>
            <button class="RejectBtn">Reject</button>
            <button class="ViewBtn">View</button>
          </td>
        </tr>

        <tr>
          <td>A002</td>
          <td>Buddy</td>
          <td>John Doe</td>
          <td>Paw Rescue Bangladesh</td>
          <td class="StatusApproved">Approved</td>
          <td>2025-12-29 14:30</td>
          <td class="ActionButtons">
            <button class="ViewBtn">View</button>
          </td>
        </tr>

        <tr>
          <td>A003</td>
          <td>Luna</td>
          <td>John Doe</td>
          <td>Paw Rescue Bangladesh</td>
          <td class="StatusCompleted">Completed</td>
          <td>2025-12-28 11:00</td>
          <td class="ActionButtons">
            <button class="ViewBtn">View</button>
          </td>
        </tr>

        <tr>
          <td>A004</td>
          <td>Luna</td>
          <td>John Doe</td>
          <td>Paw Rescue Bangladesh</td>
          <td class="StatusRejected">Rejected</td>
          <td>2025-12-27 16:45</td>
          <td class="ActionButtons">
            <button class="ViewBtn">View</button>
          </td>
        </tr>
      </table>
    </div>

  </body>
</html>
