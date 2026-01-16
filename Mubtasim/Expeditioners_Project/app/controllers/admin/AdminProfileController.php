<?php
require_once __DIR__ . '/../../models/AdminProfileModel.php';

class AdminProfileController
{
    private AdminProfileModel $model;

    public function __construct()
    {
        $this->model = new AdminProfileModel();
    }

    private function requireAdmin(): int
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
            header("Location: /Expeditioners_Project/public/login");
            exit;
        }

        return (int)($_SESSION['user']['user_id'] ?? 0);
    }

    private function getProfilePictureName(int $userId): string
    {
        $dir = __DIR__ . '/../../../public/Assets/images/admins/';
        $default = 'default.jpg';

        if (file_exists($dir . "admin_$userId.jpg")) return "admin_$userId.jpg";
        if (file_exists($dir . "admin_$userId.png")) return "admin_$userId.png";

        return $default;
    }

    // GET /admin/profile
    public function index()
    {
        $userId = $this->requireAdmin();

        $admin = $this->model->getAdminById($userId);
        if (!$admin) {
            header("Location: /Expeditioners_Project/public/logout");
            exit;
        }

        $adminUsername = $admin['username'] ?? '';
        $adminName     = $admin['full_name'] ?? '';
        $adminEmail    = $admin['email'] ?? '';
        $adminPhone    = $admin['phone'] ?? '';

        $adminProfilePicture = $this->getProfilePictureName($userId);

        require __DIR__ . '/../../views/admin/AdminProfile.php';
    }

    // POST /admin/profile/upload-picture
    public function uploadPicture()
    {
        $userId = $this->requireAdmin();

        if (!isset($_FILES['profile_picture'])) {
            header("Location: /Expeditioners_Project/public/admin/profile?pic_err=No%20file%20selected");
            exit;
        }

        $file = $_FILES['profile_picture'];

        if ($file['error'] !== UPLOAD_ERR_OK) {
            header("Location: /Expeditioners_Project/public/admin/profile?pic_err=Upload%20failed");
            exit;
        }

        // Max size: 5MB
        if ($file['size'] > 5 * 1024 * 1024) {
            header("Location: /Expeditioners_Project/public/admin/profile?pic_err=File%20must%20be%20under%205MB");
            exit;
        }

        // Validate MIME: JPEG/PNG only
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime  = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        $allowed = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
        ];

        if (!isset($allowed[$mime])) {
            header("Location: /Expeditioners_Project/public/admin/profile?pic_err=Only%20JPEG%20or%20PNG%20allowed");
            exit;
        }

        $ext = $allowed[$mime];

        // Ensure folder exists
        $dir = __DIR__ . '/../../../public/Assets/images/admins/';
        if (!is_dir($dir)) {
            if (!mkdir($dir, 0777, true)) {
                header("Location: /Expeditioners_Project/public/admin/profile?pic_err=Upload%20folder%20create%20failed");
                exit;
            }
        }

        // Stable file name: admin_{id}.ext
        $newName = "admin_" . $userId . "." . $ext;
        $dest = $dir . $newName;

        // remove other ext to avoid duplicates
        $oldJpg = $dir . "admin_" . $userId . ".jpg";
        $oldPng = $dir . "admin_" . $userId . ".png";
        if ($ext === 'jpg' && file_exists($oldPng)) @unlink($oldPng);
        if ($ext === 'png' && file_exists($oldJpg)) @unlink($oldJpg);

        if (!move_uploaded_file($file['tmp_name'], $dest)) {
            header("Location: /Expeditioners_Project/public/admin/profile?pic_err=Could%20not%20save%20file");
            exit;
        }

        header("Location: /Expeditioners_Project/public/admin/profile?pic_ok=1");
        exit;
    }
}
