<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);
session_start();

/* =========================
   TEMP ADMIN SESSION (REMOVE LATER)
   ========================= */
$_SESSION['user'] = [
    'user_id' => 1,
    'username' => 'admin',
    'role' => 'admin'
];

$ROOT = dirname(__DIR__);

/* =========================
   PATH NORMALIZATION
   ========================= */
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';

// normalize slashes + ensure leading slash
$path = '/' . ltrim($path, '/');
$path = preg_replace('#/+#', '/', $path);

// remove trailing slash (except root)
$path = rtrim($path, '/');
if ($path === '') $path = '/';

// Remove project prefix so routes remain clean: /admin/users instead of /Expeditioners_Project/public/admin/users
$prefix = '/Expeditioners_Project/public';
if (strpos($path, $prefix) === 0) {
    $path = substr($path, strlen($prefix));
    $path = '/' . ltrim($path, '/');
    $path = rtrim($path, '/');
    if ($path === '') $path = '/';
}

// extra safety: in case URL is /Expeditioners_Project/api/... (without /public)
$prefix2 = '/Expeditioners_Project';
if (strpos($path, $prefix2) === 0) {
    $path = substr($path, strlen($prefix2));
    $path = '/' . ltrim($path, '/');
    $path = rtrim($path, '/');
    if ($path === '') $path = '/';
}

try {

    /* =========================
       API ROUTES (JSON)
       ========================= */
    if (strpos($path, '/api/') === 0) {

        // GET /api/admin/stats
        if ($path === '/api/admin/stats') {
            require_once $ROOT . '/app/controllers/api/admin/AdminStatsApiController.php';
            (new AdminStatsApiController())->index();
            exit;
        }

        // GET /api/admin/users?page=1&limit=10
        if ($path === '/api/admin/users') {
            require_once $ROOT . '/app/controllers/api/admin/UsersApiController.php';
            (new UsersApiController())->index();
            exit;
        }
// GET /api/admin/pets?page=1&limit=10
if ($path === '/api/admin/pets') {
    require_once $ROOT . '/app/controllers/api/admin/PetsApiController.php';
    (new PetsApiController())->index();
    exit;
}
// GET /api/admin/adoptions?page=1&limit=10
if ($path === '/api/admin/adoptions') {
    require_once $ROOT . '/app/controllers/api/admin/AdoptionsApiController.php';
    (new AdoptionsApiController())->index();
    exit;
}
        http_response_code(404);
        header("Content-Type: application/json; charset=utf-8");
        echo json_encode(['error' => 'API not found']);
        exit;
    }

    /* =========================
       TEMP: Redirect root to admin dashboard (REMOVE LATER)
       ========================= */
    if ($path === '/' || $path === '/home') {
        require_once $ROOT . '/app/controllers/admin/AdminDashboardController.php';
        (new AdminDashboardController())->index();
        exit;
    }

    // Public Routes
    if ($path === '/pets') {
        require_once $ROOT . '/app/controllers/BrowsePetsController.php';
        (new BrowsePetsController())->index();
        exit;
    }

    if ($path === '/pets/view') {
        require_once $ROOT . '/app/controllers/PetDetailsController.php';
        (new PetDetailsController())->index();
        exit;
    }

    // Authentication Routes
    if ($path === '/login') {
        require_once $ROOT . '/app/controllers/AuthController.php';
        $auth = new AuthController();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth->authenticate();
        } else {
            $auth->login();
        }
        exit;
    }

    if ($path === '/signup') {
        require_once $ROOT . '/app/controllers/AuthController.php';
        $auth = new AuthController();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth->storeSignup();
        } else {
            $auth->signup();
        }
        exit;
    }

    if ($path === '/logout') {
        require_once $ROOT . '/app/controllers/AuthController.php';
        (new AuthController())->logout();
        exit;
    }

    //admin routes
    if ($path === '/admin' || $path === '/admin/dashboard') {
        require_once $ROOT . '/app/controllers/admin/AdminDashboardController.php';
        (new AdminDashboardController())->index();
        exit;
    }

    if ($path === '/admin/users') {
        require_once $ROOT . '/app/controllers/admin/M_UsersController.php';
        (new M_UsersController())->index();
        exit;
    }

    if ($path === '/admin/users/role' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once $ROOT . '/app/controllers/admin/M_UsersController.php';
        (new M_UsersController())->updateRole();
        exit;
    }

    if ($path === '/admin/users/delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once $ROOT . '/app/controllers/admin/M_UsersController.php';
        (new M_UsersController())->delete();
        exit;
    }
    if ($path === '/admin/pets/delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once $ROOT . '/app/controllers/admin/M_PetsController.php';
    (new M_PetsController())->delete();
    exit;
    }
    

    if ($path === '/admin/pets') {
        require_once $ROOT . '/app/controllers/admin/M_PetsController.php';
        (new M_PetsController())->index();
        exit;
    }

    if ($path === '/admin/adoptions') {
        require_once $ROOT . '/app/controllers/admin/M_AdoptionsController.php';
        (new M_AdoptionsController())->index();
        exit;
    }
if ($path === '/admin/adoptions/status' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once $ROOT . '/app/controllers/admin/M_AdoptionsController.php';
    (new M_AdoptionsController())->updateStatus();
    exit;
}

if ($path === '/admin/adoptions/delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once $ROOT . '/app/controllers/admin/M_AdoptionsController.php';
    (new M_AdoptionsController())->delete();
    exit;
}
// Admin Profile Page
if ($path === '/admin/profile') {
    require_once $ROOT . '/app/controllers/admin/AdminProfileController.php';
    (new AdminProfileController())->index();
    exit;
}

// Upload Profile Picture
if ($path === '/admin/profile/upload-picture' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once $ROOT . '/app/controllers/admin/AdminProfileController.php';
    (new AdminProfileController())->uploadPicture();
    exit;
}
    //404 Not Found
    http_response_code(404);
    echo "<h1>404 Not Found</h1>";
    echo "<p>Route: " . htmlspecialchars($path) . "</p>";
    exit;

} catch (Throwable $e) {
    http_response_code(500);
    echo "<h1>500 Server Error</h1>";
    echo "<pre>" . htmlspecialchars($e->getMessage()) . "\n\n" .
        htmlspecialchars($e->getTraceAsString()) . "</pre>";
    exit;
}
