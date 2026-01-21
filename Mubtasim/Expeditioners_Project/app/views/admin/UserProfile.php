<!DOCTYPE html>
<html>
  <head>
    <title>PawSome</title>
    <meta charset="UTF-8" />
    <meta name="description" content="PawSome" />
    <meta name="author" content="Al Mubtasim" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />

    <!-- REUSE SAME CSS AS ADMIN PROFILE -->
    <link rel="stylesheet" href="/Expeditioners_Project/public/Assets/css/admin/admin_profile.css" />

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
            // picture file name comes from controller
            $pic = !empty($userProfilePicture) ? $userProfilePicture : 'default.jpg';
          ?>

          <img
            class="profile_pic"
            src="/Expeditioners_Project/public/Assets/images/users/<?= htmlspecialchars($pic) ?>"
            alt="User Profile Picture"
            width="250"
            height="250"
          />

          <p class="note">
            This is a view-only profile page.
          </p>
        </div>

        <!-- RIGHT: User Info -->
        <div class="ProfileContainer">
          <h2 class="info">User Profile Information</h2>

          <?php if (!empty($viewError)): ?>
            <div class="formError"><?= htmlspecialchars($viewError) ?></div>
          <?php endif; ?>

          <div class="ProfileDetails">
            <div>
              <strong>User ID:</strong>
              <?= htmlspecialchars((string)($userId ?? '')) ?>
            </div>

            <div>
              <strong>Username:</strong>
              <?= htmlspecialchars($username ?? '') ?>
            </div>

            <div>
              <strong>Name:</strong>
              <?= htmlspecialchars($fullName ?? '') ?>
            </div>

            <div>
              <strong>Email:</strong>
              <?= htmlspecialchars($email ?? '') ?>
            </div>

            <div>
              <strong>Phone:</strong>
              <?= htmlspecialchars($phone ?? '') ?>
            </div>

            <div>
              <strong>Role:</strong>
              <?= htmlspecialchars(ucfirst($role ?? '')) ?>
            </div>

            <div>
              <strong>Joined on:</strong>
              <?= htmlspecialchars($joinedOn ?? '') ?>
            </div>

            <div>
              <strong>Password:</strong> ********
            </div>
          </div>


          <div class="userActions">
<?php if (!empty($_GET['err'])): ?>
  <div class="formError"><?= htmlspecialchars($_GET['err']) ?></div>
<?php endif; ?>

<?php if (!empty($_GET['ok'])): ?>
  <div class="formSuccess"><?= htmlspecialchars($_GET['ok']) ?></div>
<?php endif; ?>

<?php if (($role ?? '') !== 'admin' && empty($viewError)): ?>
  <form method="POST" action="/Expeditioners_Project/public/admin/users/make-admin" style="margin-top:12px;">
    <input type="hidden" name="user_id" value="<?= (int)($userId ?? 0) ?>">
    <button
      type="submit"
      class="MakeBtn"
      onclick="return confirm('Make this user an Admin?')"
    >
      Make Admin
    </button>
  </form>
<?php endif; ?>

          <div>
            <button
              type="button"
              onclick="location.href='/Expeditioners_Project/public/admin/users';"
               class="editProfileButton"
            >
              Back to Manage Users
            </button>
          </div>
</div>
        </div>
      </div>
    </div>
  </body>
</html>
