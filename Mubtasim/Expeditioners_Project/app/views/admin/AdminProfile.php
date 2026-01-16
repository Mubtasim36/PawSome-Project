<!DOCTYPE html>
<html>
  <head>
    <title>PawSome</title>
    <meta charset="UTF-8" />
    <meta name="description" content="PawSome" />
    <meta name="author" content="Al Mubtasim" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />

    <link rel="stylesheet" href="/Expeditioners_Project/public/Assets/css/admin/admin_profile.css" />
    <link
      rel="icon"
      type="image/x-icon"
      href="/Expeditioners_Project/public/Assets/images/Logo.png"
    />
    <script
  src="/Expeditioners_Project/public/Assets/js/admin/AdminProfile.js"
  defer
></script>
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

    

    <div class="SideBar">
      <a class="Overview" href="/Expeditioners_Project/public/admin/dashboard">Overview</a>
      <a class="Manage_Users" href="/Expeditioners_Project/public/admin/users">Manage Users</a>
      <a class="Manage_Pets" href="/Expeditioners_Project/public/admin/pets">Manage Pets</a>
      <a class="Manage_Adoptions" href="/Expeditioners_Project/public/admin/adoptions">Manage Adoptions</a>
      <a class="Profile" href="/Expeditioners_Project/public/admin/profile">Profile</a>
    </div>

    <div class="MainContent">
<div class="ProfileLayout">
  <!-- LEFT: Profile Picture -->
  <div class="ProfileLeft">
    <?php
      $pic = (!empty($adminProfilePicture)) ? $adminProfilePicture : 'default.jpg';
    ?>

    <img
      class="profile_pic"
      src="/Expeditioners_Project/public/Assets/images/admins/<?= htmlspecialchars($pic) ?>"
      alt="Admin Profile Picture"
      width="250"
      height="250"
    />

    <form
      action="/Expeditioners_Project/public/admin/profile/upload-picture"
      method="POST"
      enctype="multipart/form-data"
      class="uploadProfileForm"
    >
      <input
        type="file"
        id="profilePicInput"
        name="profile_picture"
        accept="image/jpeg,image/png"
        style="display:none;"
      />

      <button
        type="button"
        id="addProfilePicBtn"
        class="addProfilebtn"
      >
        Update Profile Picture
      </button>

      <p class="note">
        *Allowed: JPEG / PNG • Max size: 5MB*
      </p>
    </form>
  </div>

  <!-- RIGHT: Admin Info -->
  <div class="ProfileContainer">
    <h2 class="info">Admin Profile Information</h2>

    <div class="ProfileDetails">
      <div>
        <strong>Username:</strong>
        <?= htmlspecialchars($adminUsername ?? '') ?>
      </div>

      <div>
        <strong>Name:</strong>
        <?= htmlspecialchars($adminName ?? '') ?>
      </div>

      <div>
        <strong>Email:</strong>
        <?= htmlspecialchars($adminEmail ?? '') ?>
      </div>

      <div>
        <strong>Phone:</strong>
        <?= htmlspecialchars($adminPhone ?? '') ?>
      </div>

      <div>
        <strong>Password:</strong> ********
      </div>
    </div>

    <div class="editProfileButton">
      <button
        type="button"
        onclick="location.href='/Expeditioners_Project/public/admin/edit_profile';"
      >
        Edit Profile
      </button>
    </div>
  </div>
</div>

  </body>
</html>
