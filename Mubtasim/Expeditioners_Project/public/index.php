<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);
session_start();

try {
    $ROOT = dirname(__DIR__);

    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';

    $path = rtrim($path, '/');
    if ($path === '') $path = '/';

    if (str_starts_with($path, '/Expeditioners_Project/public')) {
        $path = substr($path, strlen('/Expeditioners_Project/public'));
        $path = rtrim($path, '/');
        if ($path === '') $path = '/';
    }


    if ($path === '/' || $path === '/home') {
        require_once $ROOT . '/app/controllers/HomeController.php';
        (new HomeController())->index();
        exit;
    }


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

    // 404
    http_response_code(404);
    echo "<h1>404 Not Found</h1>";
    exit;
} catch (Throwable $e) {
    http_response_code(500);
    echo "<h1>500 Server Error</h1>";
    echo "<pre>" . htmlspecialchars($e->getMessage()) . "\n\n" .
         htmlspecialchars($e->getTraceAsString()) . "</pre>";
    exit;
}