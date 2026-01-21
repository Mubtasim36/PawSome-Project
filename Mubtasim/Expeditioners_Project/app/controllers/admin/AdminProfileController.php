<?php
require_once __DIR__ . '/../../models/AdminProfileModel.php';
require_once __DIR__ . '/../../models/ActivityLogModel.php';

class AdminProfileController
{
    private AdminProfileModel $model;
    private ActivityLogModel $logModel;

    public function __construct()
    {
        $this->model = new AdminProfileModel();
        $this->logModel = new ActivityLogModel();
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

        if ($file['size'] > 5 * 1024 * 1024) {
            header("Location: /Expeditioners_Project/public/admin/profile?pic_err=File%20must%20be%20under%205MB");
            exit;
        }

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

        $dir = __DIR__ . '/../../../public/Assets/images/admins/';
        if (!is_dir($dir)) {
            if (!mkdir($dir, 0777, true)) {
                header("Location: /Expeditioners_Project/public/admin/profile?pic_err=Upload%20folder%20create%20failed");
                exit;
            }
        }

        $newName = "admin_" . $userId . "." . $ext;
        $dest = $dir . $newName;

        $oldJpg = $dir . "admin_" . $userId . ".jpg";
        $oldPng = $dir . "admin_" . $userId . ".png";
        if ($ext === 'jpg' && file_exists($oldPng)) @unlink($oldPng);
        if ($ext === 'png' && file_exists($oldJpg)) @unlink($oldJpg);

        if (!move_uploaded_file($file['tmp_name'], $dest)) {
            header("Location: /Expeditioners_Project/public/admin/profile?pic_err=Could%20not%20save%20file");
            exit;
        }

        // Activity log
        $this->logModel->log('user', 'Admin updated profile picture', $userId);

        header("Location: /Expeditioners_Project/public/admin/profile?pic_ok=1");
        exit;
    }

    // GET /admin/edit_profile
    public function edit()
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

        require __DIR__ . '/../../views/admin/EditProfile.php';
    }

    // POST /admin/edit_profile
    public function updateProfile()
    {
        $userId = $this->requireAdmin();

        $fullName = trim($_POST['full_name'] ?? '');
        $username = trim($_POST['username'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $phone    = trim($_POST['phone'] ?? '');

        if ($fullName === '' || $username === '' || $email === '') {
            header("Location: /Expeditioners_Project/public/admin/edit_profile?err=Please%20fill%20required%20fields");
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: /Expeditioners_Project/public/admin/edit_profile?err=Invalid%20email");
            exit;
        }

        // Update basic info
        $this->model->updateAdminInfo($userId, $fullName, $username, $email, $phone);

        // Password change (plain text)
        $old = (string)($_POST['old_password'] ?? '');
        $new = (string)($_POST['new_password'] ?? '');
        $con = (string)($_POST['confirm_password'] ?? '');

        if ($old !== '' || $new !== '' || $con !== '') {

            if ($old === '' || $new === '' || $con === '') {
                header("Location: /Expeditioners_Project/public/admin/edit_profile?err=Fill%20all%20password%20fields");
                exit;
            }

            if ($new !== $con) {
                header("Location: /Expeditioners_Project/public/admin/edit_profile?err=Passwords%20do%20not%20match");
                exit;
            }

            if (strlen($new) < 6) {
                header("Location: /Expeditioners_Project/public/admin/edit_profile?err=Password%20must%20be%20at%20least%206%20characters");
                exit;
            }

            if (!preg_match('/\d/', $new)) {
                header("Location: /Expeditioners_Project/public/admin/edit_profile?err=Password%20must%20contain%20at%20least%201%20number");
                exit;
            }

            $currentPlain = $this->model->getPasswordPlain($userId);

            if ($currentPlain === null || $old !== $currentPlain) {
                header("Location: /Expeditioners_Project/public/admin/edit_profile?err=Old%20password%20incorrect");
                exit;
            }

            if ($new === $currentPlain) {
                header("Location: /Expeditioners_Project/public/admin/edit_profile?err=New%20password%20cannot%20be%20same%20as%20old%20password");
                exit;
            }

            $this->model->updatePasswordPlain($userId, $new);
        }

        // Activity log (profile edit)
        $this->logModel->log('user', 'Admin updated profile information', $userId);

        // Success on edit page (shows green + popup)
        header("Location: /Expeditioners_Project/public/admin/edit_profile?ok=1");
        exit;
    }


    //POST /admin/profile/delete
public function deleteAccount()
{
    $userId = $this->requireAdmin();

    //block if only 1 admin exists
    $adminCount = $this->model->countAdmins();
    if ($adminCount <= 1) {
        header("Location: /Expeditioners_Project/public/admin/profile?del_err=Cannot%20delete%20last%20admin%20account");
        exit;
    }

    //delete
    $ok = $this->model->deleteAdminById($userId);

    //activity log 
    if ($ok) {
        require_once dirname(__DIR__, 2) . '/models/ActivityLogModel.php';
        $log = new ActivityLogModel();
        $log->log(
            'system',
            "Admin account deleted (ID {$userId})",
            $userId
        );

        // logout after deleting self
        header("Location: /Expeditioners_Project/public/logout");
        exit;
    }

    header("Location: /Expeditioners_Project/public/admin/profile?del_err=Delete%20failed");
    exit;
}

}
