<?php
// app/views/shelter/profile.php
?>
<link rel="stylesheet" href="<?= BASE_URL ?>/Assets/css/shelter/profile.css" />

<div class="pageWrap">
  <h2 class="pageTitle">Shelter Profile</h2>

  <div class="grid2">

    <!-- LEFT: Profile Image -->
    <div class="card centerCard">
      <?php
        $sid = (int)($user['user_id'] ?? 0);

        // ✅ relative paths from /public
        $relJpg = "/uploads/shelters/shelter_{$sid}.jpg";
        $relPng = "/uploads/shelters/shelter_{$sid}.png";
        $relDefault = "/uploads/shelters/default.png";

        // ✅ absolute filesystem path to /public (works on XAMPP)
        $publicFs = rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . BASE_URL;

        // choose existing file
        $imgRel = $relDefault;
        if ($sid > 0) {
          if (file_exists($publicFs . $relJpg)) $imgRel = $relJpg;
          else if (file_exists($publicFs . $relPng)) $imgRel = $relPng;
        }

        // ✅ final browser URL must include BASE_URL
        $imgUrl = BASE_URL . $imgRel;
      ?>

      <img class="avatar" src="<?= $imgUrl ?>" alt="Shelter Profile" />
      <p class="small">Upload JPG/PNG (max 5MB)</p>

      <div style="margin-top:10px;">
        <p class="small" style="margin:0;">
          Current File:
          <span style="color:#373c41;">
            <?= htmlspecialchars($imgRel) ?>
          </span>
        </p>
      </div>
    </div>

    <!-- RIGHT: Form -->
    <div class="card">
      <h3 style="margin-top:0;">Update Info</h3>

      <form id="profileForm" enctype="multipart/form-data">
        <label>Full Name *</label>
        <input
          name="full_name"
          id="full_name"
          type="text"
          value="<?= htmlspecialchars($user['full_name'] ?? '') ?>"
          required
        />

        <label>Phone</label>
        <input
          name="phone"
          id="phone"
          type="text"
          value="<?= htmlspecialchars($user['phone'] ?? '') ?>"
          placeholder="01XXXXXXXXX"
        />

        <label>Shelter Profile Image</label>
        <input
          name="shelter_image"
          id="shelter_image"
          type="file"
          accept=".jpg,.jpeg,.png"
        />

        <div class="btnRow">
          <button class="Browse" type="submit">Save</button>
          <button class="Get_Started" type="button" id="reloadBtn">Reload</button>
        </div>

        <p class="msg" id="pmsg"></p>
      </form>

      <div style="margin-top:14px;">
        <p class="small" style="margin:0;">
          Image will be saved as:
          <b>public/uploads/shelters/shelter_<?= (int)($user['user_id'] ?? 0) ?>.jpg/png</b>
        </p>
      </div>
    </div>

  </div>
</div>

<script>
  const BASE_URL = "<?= BASE_URL ?>";

  // simple reload button
  document.getElementById("reloadBtn").addEventListener("click", () => {
    window.location.reload();
  });
</script>
<script src="<?= BASE_URL ?>/Assets/js/shelter/profile.js"></script>
