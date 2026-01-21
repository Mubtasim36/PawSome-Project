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
      href="/Expeditioners_Project/public/Assets/css/admin/edit_adminprofile.css"
    />
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
          <a class="Home" href="/Expeditioners_Project/public/admin/dashboard"
            >Home</a
          >
          <a class="Logout" href="/Expeditioners_Project/public/logout"
            >Logout</a
          >
        </div>
      </div>
    </header>

    <div class="SideBar">
      <a class="Overview" href="/Expeditioners_Project/public/admin/dashboard"
        >Overview</a
      >
      <a class="Manage_Users" href="/Expeditioners_Project/public/admin/users"
        >Manage Users</a
      >
      <a class="Manage_Pets" href="/Expeditioners_Project/public/admin/pets"
        >Manage Pets</a
      >
      <a
        class="Manage_Adoptions"
        href="/Expeditioners_Project/public/admin/adoptions"
        >Manage Adoptions</a
      >
      <a class="Profile" href="/Expeditioners_Project/public/admin/profile"
        >Profile</a
      >
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
              hidden
            />

            <button
              type="button"
              id="addProfilePicBtn"
              class="addProfilebtn"
            >
              Update Profile Picture
            </button>

            <p class="note">
              *Allowed Format: JPEG / PNG <br />
              • Max size: 5MB*
            </p>
          </form>
        </div>

        <!-- RIGHT: EDIT PROFILE -->
        <div class="ProfileContainer">
          <h2 class="info">Edit Admin Profile</h2>


          <?php if (!empty($_GET['err'])): ?>
  <div class="formError">
    <?= htmlspecialchars($_GET['err']) ?>
  </div>
<?php endif; ?>

<?php if (!empty($_GET['ok'])): ?>
  <div class="formSuccess">
    Profile updated successfully!
  </div>

<?php endif; ?>


          <form
            method="POST"
            action="/Expeditioners_Project/public/admin/edit_profile"
          >
            <div class="ProfileDetails">
              <div class="DetailSmallBox">
                <strong>Username</strong>
                <input
                  type="text"
                  name="username"
                  value="<?= htmlspecialchars($adminUsername ?? '') ?>"
                  required
                  class="ProfileInput"
                />
              </div>

              <div class="DetailSmallBox">
                <strong>Name</strong>
                <input
                  type="text"
                  name="full_name"
                  value="<?= htmlspecialchars($adminName ?? '') ?>"
                  required
                   class="ProfileInput"
                />
              </div>

              <div class="DetailSmallBox">
                <strong>Email</strong>
                <input
                  type="email"
                  name="email"
                  value="<?= htmlspecialchars($adminEmail ?? '') ?>"
                  required
                   class="ProfileInput"
                />
              </div>

              <div class="DetailSmallBox">
                <strong>Phone</strong>
                <input
                  type="text"
                  name="phone"
                  value="<?= htmlspecialchars($adminPhone ?? '') ?>"
                   class="ProfileInput"
                />
              </div>

              <div class="DetailSmallBox">
                <strong>Old Password</strong>
                <input type="password" name="old_password"  class="ProfileInput"/>
              </div>

              <div class="DetailSmallBox">
                <strong>New Password</strong>
                <input type="password" name="new_password" class="ProfileInput"/>
              </div>

              <div class="DetailSmallBox">
                <strong>Confirm New Password</strong>
                <input type="password" name="confirm_password" class="ProfileInput"/>
              </div>

              <p class="note">
                Password rules:<br />
                • Minimum 6 characters<br />
                • Must include at least 1 number<br />
                • Cannot be same as previous password
              </p>
            </div>

            <div class="editProfileButton">
              <button type="submit" class="saveChangesBtn">Save Changes</button>
              <button
                type="button" class="CancelBtn"
                onclick="location.href='/Expeditioners_Project/public/admin/profile';"
                
              >
                Cancel
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>
