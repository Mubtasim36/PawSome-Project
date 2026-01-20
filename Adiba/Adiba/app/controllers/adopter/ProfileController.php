<?php
declare(strict_types=1);

class ProfileController
{
    public function index(): void
    {
        $user = require_role('adopter');

        // Refresh from DB so profile always displays the latest data
        require_once APP_PATH . '/models/UserModel.php';
        $um = new UserModel();
        $fresh = $um->findById((int)$user['user_id']);
        if ($fresh) {
            $_SESSION['user'] = $fresh;
            $user = $fresh;
        }
        view('adopter/profile.php', [
            'user' => $user,
            'csrf' => csrf_token(),
        ]);
    }

    /**
     * POST /adopter/profile/upload-picture
     * Upload adopter profile picture (same UX + rules as Admin profile)
     * - JPEG/PNG only
     * - Max size 5MB
     * - Stores in /public/Assets/images/adopters/
     */
    public function uploadPicture(): void
    {
        $user = require_role('adopter');

        if (!csrf_verify($_POST['csrf'] ?? null)) {
            $_SESSION['pic_err'] = 'Invalid request.';
            redirect('adopter/profile');
        }

        if (empty($_FILES['profile_picture']) || ($_FILES['profile_picture']['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            $_SESSION['pic_err'] = 'Please select an image.';
            redirect('adopter/profile');
        }

        $file = $_FILES['profile_picture'];

        // size check (5MB)
        if (($file['size'] ?? 0) > 5 * 1024 * 1024) {
            $_SESSION['pic_err'] = 'File too large. Max size is 5MB.';
            redirect('adopter/profile');
        }

        // mime check
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);
        $allowed = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
        ];
        if (!isset($allowed[$mime])) {
            $_SESSION['pic_err'] = 'Invalid format. Only JPEG/PNG allowed.';
            redirect('adopter/profile');
        }

        $ext = $allowed[$mime];

        // destination folder
        $destDir = BASE_PATH . '/public/Assets/images/adopters';
        if (!is_dir($destDir)) {
            mkdir($destDir, 0777, true);
        }

        $newName = 'adopter_' . (int)$user['user_id'] . '_' . time() . '.' . $ext;
        $destPath = $destDir . '/' . $newName;

        if (!move_uploaded_file($file['tmp_name'], $destPath)) {
            $_SESSION['pic_err'] = 'Upload failed. Try again.';
            redirect('adopter/profile');
        }

        // Update DB (if column exists). If not, show helpful message.
        try {
            require_once APP_PATH . '/models/UserModel.php';
            $um = new UserModel();
            $um->updateProfilePicture((int)$user['user_id'], $newName);

            // Refresh session user
            $fresh = $um->findById((int)$user['user_id']);
            if ($fresh) {
                $_SESSION['user'] = $fresh;
            }

            $_SESSION['pic_ok'] = 'Profile picture updated.';
        } catch (Throwable $e) {
            // rollback file if DB update failed
            @unlink($destPath);

            // common case: column missing
            if (str_contains((string)$e->getMessage(), 'Unknown column') || str_contains((string)$e->getMessage(), '42S22')) {
                $_SESSION['pic_err'] = "Database missing column profile_picture. Run: ALTER TABLE users ADD profile_picture VARCHAR(255) NULL;";
            } else {
                $_SESSION['pic_err'] = 'Failed to save picture. ' . $e->getMessage();
            }
        }

        redirect('adopter/profile');
    }
}
