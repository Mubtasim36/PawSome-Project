<?php
declare(strict_types=1);

/**
 * Core helpers for a simple academic MVC project.
 */

function base_url(string $path = ''): string
{
    // Works whether the project is in /public or a subfolder.
    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
    $base = rtrim(str_replace('/index.php', '', $scriptName), '/');
    $path = ltrim($path, '/');
    return $base . ($path ? '/' . $path : '');
}

function redirect(string $path): void
{
    header('Location: ' . base_url($path));
    exit;
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function json_response(array $data, int $status = 200): void
{
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);
    exit;
}

function view(string $viewPath, array $data = []): void
{
    $fullPath = APP_PATH . '/views/' . ltrim($viewPath, '/');
    if (!file_exists($fullPath)) {
        http_response_code(500);
        echo 'View not found: ' . e($viewPath);
        exit;
    }
    extract($data);
    require $fullPath;
}

function db(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) return $pdo;

    $cfg = require APP_PATH . '/config/database.php';
    $dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s', $cfg['host'], $cfg['db'], $cfg['charset'] ?? 'utf8mb4');

    $pdo = new PDO($dsn, $cfg['user'], $cfg['pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    return $pdo;
}

function csrf_token(): string
{
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(16));
    }
    return (string)$_SESSION['csrf_token'];
}

function csrf_verify(?string $token): bool
{
    return isset($_SESSION['csrf_token']) && is_string($token) && hash_equals($_SESSION['csrf_token'], $token);
}

function is_logged_in(): bool
{
    return isset($_SESSION['user']) && is_array($_SESSION['user']);
}

function current_user(): ?array
{
    return is_logged_in() ? $_SESSION['user'] : null;
}

function require_login(): array
{
    if (!is_logged_in()) {
        redirect('auth/login');
    }
    return $_SESSION['user'];
}

function require_role(string $role): array
{
    $user = require_login();

    // Normalize role comparison (DBs sometimes store different casing or spaces)
    $want = strtolower(trim($role));
    $have = strtolower(trim((string)($user['role'] ?? '')));

    if ($have !== $want) {
        // Prevent redirect loops: clear session before redirecting.
        $_SESSION = [];
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
        redirect('auth/login');
    }

    return $user;
}
