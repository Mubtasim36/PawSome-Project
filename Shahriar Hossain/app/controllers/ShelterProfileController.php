<?php
class ShelterProfileController extends Controller {

  public function index(): void {
    Auth::requireRole('shelter');

    $db = Database::conn();
    $stmt = $db->prepare("
      SELECT user_id, full_name, username, email, phone
      FROM users
      WHERE user_id=? AND role='shelter'
    ");
    $stmt->execute([Auth::userId()]);
    $user = $stmt->fetch();

    if (!$user) {
      http_response_code(404);
      echo "Shelter not found";
      exit;
    }

    $this->view('shelter/profile', ['user' => $user]);
  }

  private function saveShelterImage(): array {
    // returns: ['ok'=>bool, 'message'=>string|null]
    if (!isset($_FILES['shelter_image']) || $_FILES['shelter_image']['error'] === UPLOAD_ERR_NO_FILE) {
      return ['ok' => true, 'message' => null]; // no upload is fine
    }

    $f = $_FILES['shelter_image'];

    if ($f['error'] !== UPLOAD_ERR_OK) {
      return ['ok' => false, 'message' => 'Upload failed'];
    }

    if ($f['size'] > MAX_UPLOAD_BYTES) {
      return ['ok' => false, 'message' => 'Image too large (max 5MB)'];
    }

    $info = getimagesize($f['tmp_name']);
    if ($info === false) {
      return ['ok' => false, 'message' => 'Invalid image file'];
    }

    $mime = $info['mime'] ?? '';
    if (!in_array($mime, ['image/jpeg', 'image/png'], true)) {
      return ['ok' => false, 'message' => 'Only JPG or PNG allowed'];
    }

    if (!is_dir(UPLOAD_DIR_SHELTERS)) {
      mkdir(UPLOAD_DIR_SHELTERS, 0777, true);
    }

    $ext = ($mime === 'image/png') ? 'png' : 'jpg';
    $target = UPLOAD_DIR_SHELTERS . "shelter_" . Auth::userId() . "." . $ext;

    if (!move_uploaded_file($f['tmp_name'], $target)) {
      return ['ok' => false, 'message' => 'Failed to save image'];
    }

    return ['ok' => true, 'message' => null];
  }

  public function update(): void {
    Auth::requireRole('shelter');

    $full = trim($_POST['full_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    // Backend validation
    if ($full === '' || strlen($full) < 3) $this->jsonFail("Full name invalid");
    if ($phone !== '' && strlen($phone) < 6) $this->jsonFail("Phone invalid");

    // Save image (optional)
    $imgRes = $this->saveShelterImage();
    if (!$imgRes['ok']) {
      $this->jsonFail($imgRes['message'] ?? 'Invalid image');
    }

    // Update ONLY text fields in DB
    $db = Database::conn();
    $stmt = $db->prepare("
      UPDATE users
      SET full_name=?, phone=?
      WHERE user_id=? AND role='shelter'
    ");
    $stmt->execute([$full, $phone, Auth::userId()]);

    // Refresh session
    $_SESSION['user']['full_name'] = $full;

    ActivityLog::add('user', "Shelter updated profile information", Auth::userId());
    $this->jsonOk();
  }
}
