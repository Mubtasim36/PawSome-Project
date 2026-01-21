<?php
$title = 'My Profile';
$css = [
  'Assets/css/adopter/profile.css',
  'Assets/css/common/sidebar.css',
  'Assets/css/common/cards.css'
];
require APP_PATH . '/views/partials/header.php';
$active = 'profile';
require APP_PATH . '/views/partials/sidebar_adopter.php';

$pic = !empty($user['profile_picture']) ? (string)$user['profile_picture'] : 'default.jpg';
$imgUrl = base_url('Assets/images/adopters/' . $pic);
$defaultUrl = base_url('Assets/images/adopters/default.jpg');
?>

<main class="MainContent">
  <div class="PageHead">
    <h1 class="PageTitle">Profile</h1>
    <p class="PageSub">View and manage your account information.</p>
  </div>

  <section class="ProfileLayout">

    <!-- LEFT: Profile Picture -->
    <div class="ProfileLeft">
      <img
        class="profile_pic"
        src="<?= e($imgUrl) ?>"
        alt="Adopter Profile Picture"
        width="250"
        height="250"
        onerror="this.onerror=null;this.src='<?= e($defaultUrl) ?>';"
      />

      <form
        action="<?= e(base_url('adopter/profile/upload-picture')) ?>"
        method="POST"
        enctype="multipart/form-data"
        class="uploadProfileForm"
      >
        <input type="hidden" name="csrf" value="<?= e($csrf) ?>" />

        <input
          type="file"
          id="profilePicInput"
          name="profile_picture"
          accept="image/jpeg,image/png"
          style="display:none;"
        />

        <button type="button" id="addProfilePicBtn" class="addProfilebtn">
          Update Profile Picture
        </button>

        <p class="note">
          *Allowed Format: JPEG / PNG <br>
          • Max size: 5MB*
        </p>

        <?php if (!empty($_SESSION['pic_err'])): ?>
          <div class="formError"><?= e((string)$_SESSION['pic_err']); unset($_SESSION['pic_err']); ?></div>
        <?php endif; ?>

        <?php if (!empty($_SESSION['pic_ok'])): ?>
          <div class="formSuccess"><?= e((string)$_SESSION['pic_ok']); unset($_SESSION['pic_ok']); ?></div>
        <?php endif; ?>
      </form>
    </div>

    <!-- RIGHT: User Info -->
    <div class="ProfileContainer">
      <h2 class="info">Adopter Profile Information</h2>

      <div class="ProfileDetails">
        <div><strong>Full Name:</strong> <?= e((string)($user['full_name'] ?? '')) ?></div>
        <div><strong>Username:</strong> <?= e((string)($user['username'] ?? '')) ?></div>
        <div><strong>Email:</strong> <?= e((string)($user['email'] ?? '')) ?></div>
        <div><strong>Phone:</strong> <?= e((string)($user['phone'] ?? '')) ?></div>
        <div><strong>Password:</strong> ********</div>
      </div>

      <div class="userActions">
        <a class="EditBtn" href="<?= e(base_url('adopter/editprofile')) ?>">Edit Profile</a>
        <a class="ViewBtn" href="<?= e(base_url('adopter/changepassword')) ?>">Change Password</a>
        <button id="deleteBtn" class="DelBtn" type="button">Delete Account</button>
        <div id="msg" class="FormMessage" aria-live="polite"></div>
      </div>
    </div>

  </section>
</main>

<script>
  window.__CSRF__ = <?= json_encode($csrf) ?>;
</script>
<script src="<?= e(base_url('Assets/js/adopter/profile.js')) ?>" defer></script>

<?php require APP_PATH . '/views/partials/footer.php'; ?>
