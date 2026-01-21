<?php
class Controller {
  protected function view(string $path, array $data = []): void {
    extract($data);
    require APP_ROOT . '/views/layouts/header.php';
    require APP_ROOT . '/views/' . $path . '.php';
    require APP_ROOT . '/views/layouts/footer.php';
  }

  protected function jsonOk(array $payload = []): void {
    Response::json(['ok' => true] + $payload);
  }

  protected function jsonFail(string $message, int $code = 400, array $extra = []): void {
    Response::json(['ok' => false, 'message' => $message] + $extra, $code);
  }
}
