<?php
class Auth {
  public static function requireLogin(): void {
    if (empty($_SESSION['user'])) {
      header('Location: ' . BASE_URL . '/index.php?r=auth/login');
      exit;
    }
  }

  public static function requireRole(string $role): void {
    self::requireLogin();
    if (($_SESSION['user']['role'] ?? '') !== $role) {
      http_response_code(403);
      echo "Forbidden - Auth.php:14";
      exit;
    }
  }

  public static function userId(): int {
    return (int)($_SESSION['user']['user_id'] ?? 0);
  }
}
