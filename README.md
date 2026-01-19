<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PawSome – Pet Adoption Platform</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f4f6f8;
      color: #2c3e50;
      line-height: 1.6;
    }
    .container {
      max-width: 1000px;
      margin: 40px auto;
      background: #ffffff;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }
    h1 {
      text-align: center;
      font-size: 3rem;
      margin-bottom: 5px;
    }
    h2 {
      margin-top: 40px;
      border-left: 6px solid #ff914d;
      padding-left: 12px;
      color: #1f2d3d;
    }
    h3 {
      margin-top: 25px;
      color: #34495e;
    }
    p {
      margin-top: 10px;
      font-size: 1rem;
    }
    .subtitle {
      text-align: center;
      font-size: 1.1rem;
      color: #6c757d;
      margin-bottom: 30px;
    }
    .badges {
      text-align: center;
      margin-bottom: 30px;
    }
    .badge {
      display: inline-block;
      background: #eef1f4;
      padding: 8px 14px;
      border-radius: 20px;
      font-size: 0.85rem;
      margin: 4px;
      font-weight: 600;
    }
    ul {
      margin-left: 20px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }
    table th,
    table td {
      border: 1px solid #dee2e6;
      padding: 12px;
      text-align: left;
    }
    table th {
      background-color: #f1f3f5;
    }
    code {
      background: #f1f3f5;
      padding: 4px 8px;
      border-radius: 6px;
      font-size: 0.9rem;
    }
    pre {
      background: #1f2933;
      color: #f8f9fa;
      padding: 16px;
      border-radius: 10px;
      overflow-x: auto;
      margin-top: 15px;
    }
    .footer {
      text-align: center;
      margin-top: 50px;
      font-size: 0.9rem;
      color: #6c757d;
    }
    .highlight {
      background: #fff4ec;
      padding: 12px 16px;
      border-left: 4px solid #ff914d;
      border-radius: 6px;
      margin-top: 15px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>🐾 PawSome</h1>
    <p class="subtitle">A Role-Based Pet Adoption Web Platform</p>

```
<div class="badges">
  <span class="badge">Academic Project</span>
  <span class="badge">Web Technologies</span>
  <span class="badge">PHP · MySQL · JavaScript</span>
</div>

<h2>📌 Project Overview</h2>
<p>
  <strong>PawSome</strong> is a full-stack pet adoption web application that connects
  adopters, animal shelters, and administrators through a structured and secure
  role-based system. Each user type has a dedicated dashboard, ensuring a smooth
  and transparent adoption process.
</p>

<h2>🎯 Objectives</h2>
<ul>
  <li>Simplify and organize the pet adoption workflow</li>
  <li>Implement role-based dashboards and permissions</li>
  <li>Ensure secure authentication and data handling</li>
  <li>Apply core web development concepts learned in the course</li>
</ul>

<h2>👥 User Roles</h2>
<table>
  <tr>
    <th>Role</th>
    <th>Description</th>
  </tr>
  <tr>
    <td>Admin</td>
    <td>Manages users, pets, and adoption data</td>
  </tr>
  <tr>
    <td>Adopter</td>
    <td>Browses pets and submits adoption requests</td>
  </tr>
  <tr>
    <td>Shelter</td>
    <td>Manages pets and handles adoption requests</td>
  </tr>
</table>

<h2>⚙️ Features</h2>

<h3>Common Features</h3>
<ul>
  <li>User registration, login, and logout</li>
  <li>Profile management (view, edit, delete)</li>
  <li>Password change and reset</li>
  <li>Personalized dashboard</li>
</ul>

<h3>Admin Features</h3>
<ul>
  <li>View user and system statistics</li>
  <li>Manage user accounts</li>
  <li>Manage adoption records</li>
</ul>

<h3>Adopter Features</h3>
<ul>
  <li>Browse available pets</li>
  <li>View detailed pet profiles</li>
  <li>Send and track adoption requests</li>
</ul>

<h3>Shelter Features</h3>
<ul>
  <li>Add, update, and delete pets (CRUD)</li>
  <li>Approve or reject adoption requests</li>
  <li>Manage daycare system</li>
</ul>

<div class="highlight">
  Each user role contains at least <strong>three unique features</strong>, fulfilling
  the project requirements.
</div>

<h2>🧰 Technology Stack</h2>
<ul>
  <li><strong>Frontend:</strong> HTML5, CSS3, JavaScript</li>
  <li><strong>Backend:</strong> PHP</li>
  <li><strong>Database:</strong> MySQL</li>
  <li><strong>Tools:</strong> XAMPP, phpMyAdmin, GitHub</li>
</ul>

<h2>🗄 Database Design</h2>
<ul>
  <li><code>users</code> – stores user credentials and roles</li>
  <li><code>pets</code> – stores pet details linked to shelters</li>
  <li><code>adoptions</code> – manages adoption requests and statuses</li>
</ul>

<h2>⚙️ Installation & Setup</h2>
<pre>
```

1. Clone the repository
   git clone <repository-url>

2. Move the project to htdocs (XAMPP)

3. Import the SQL database using phpMyAdmin

4. Configure database credentials in PHP

5. Start Apache and MySQL

6. Open in browser: [http://localhost/PawSome](http://localhost/PawSome) </pre>

    <h2>👨‍💻 Team Members</h2>
    <table>
      <tr>
        <th>Student ID</th>
        <th>Name</th>
      </tr>
      <tr>
        <td>22-48990-3</td>
        <td>Shahriar Hossain</td>
      </tr>
      <tr>
        <td>22-49002-3</td>
        <td>Al Mubtasim</td>
      </tr>
      <tr>
        <td>22-49012-3</td>
        <td>Adiba Tanzila</td>
      </tr>
    </table>

    <h2>📄 License</h2>
    <p>This project is developed strictly for academic purposes.</p>

    <div class="footer">
      🐾 PawSome — Building bridges between pets and people
    </div>

  </div>
</body>
</html>
