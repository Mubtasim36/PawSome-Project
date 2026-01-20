<?php
declare(strict_types=1);

session_start();

$_SESSION['user'] = [
    'user_id' => 2,
    'username' => 'john',
    'role' => 'adopter',
];


define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

require_once APP_PATH . '/core/helpers.php';

// -------------------------
// Router
// -------------------------
// WEB: /<role>/<page>
// API: /api/<role>/<action>

$url = $_GET['url'] ?? '';
$url = trim((string)$url, "/ \t\n\r\0\x0B");

// Default route
if ($url === '') {
    if (is_logged_in()) {
        $role = (string)($_SESSION['user']['role'] ?? '');
        if ($role === 'adopter') {
            redirect('adopter/dashboard');
        }
        // fall back to login
        redirect('auth/login');
    }
    redirect('auth/login');
}

$parts = explode('/', $url);
$first  = $parts[0] ?? '';
$second = $parts[1] ?? '';
$third  = $parts[2] ?? '';

try {
    // -------------------------
    // API routes
    // -------------------------
    if ($first === 'api') {
        $role = $second;
        $action = $third;

        if ($role === '' || $action === '') {
            json_response(['success' => false, 'message' => 'Invalid API route'], 404);
        }

        $controllerClass = ucfirst($role) . 'ApiController';
        $controllerFile = APP_PATH . "/controllers/api/$role/{$controllerClass}.php";

        if (!file_exists($controllerFile)) {
            json_response(['success' => false, 'message' => 'API controller not found'], 404);
        }

        require_once $controllerFile;
        if (!class_exists($controllerClass)) {
            json_response(['success' => false, 'message' => 'API controller class missing'], 500);
        }

        $controller = new $controllerClass();
        if (!method_exists($controller, $action)) {
            json_response(['success' => false, 'message' => 'API action not found'], 404);
        }

        $controller->$action();
        exit;
    }

    // -------------------------
    // Web routes
    // -------------------------
    // Supported patterns:
    //   /<role>/<page>                 => <Page>Controller::index()
    //   /<role>/<page>/<action>        => <Page>Controller::<action>()
    // where <action> may contain dashes (e.g., upload-picture => uploadPicture)
    $role = $first;
    $page = $second !== '' ? $second : 'login';

    $controllerClass = ucfirst($page) . 'Controller';
    $controllerFile = APP_PATH . "/controllers/$role/{$controllerClass}.php";

    if (!file_exists($controllerFile)) {
        http_response_code(404);
        echo 'Controller not found';
        exit;
    }

    require_once $controllerFile;
    if (!class_exists($controllerClass)) {
        http_response_code(500);
        echo 'Controller class missing';
        exit;
    }

    $controller = new $controllerClass();

    // Resolve method/action
    $method = 'index';
    if ($third !== '') {
        // dash-case => camelCase (upload-picture => uploadPicture)
        $parts = array_filter(explode('-', $third), fn($x) => $x !== '');
        $method = array_shift($parts) ?: 'index';
        foreach ($parts as $p) {
            $method .= ucfirst($p);
        }
    }

    if (!method_exists($controller, $method)) {
        http_response_code(404);
        echo 'Action not found';
        exit;
    }

    $controller->$method();

} catch (Throwable $e) {
    // If this was an API call, always return JSON so frontend fetch() can handle it.
    $isApi = str_starts_with((string)($url ?? ''), 'api/');
    if ($isApi) {
        json_response(['success' => false, 'message' => 'Server error: ' . $e->getMessage()], 500);
    }

    http_response_code(500);
    echo 'Server error: ' . e($e->getMessage());
}
