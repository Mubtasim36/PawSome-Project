<?php
session_start();

require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/config/database.php';

// autoload
spl_autoload_register(function($class){
  $paths = [
    __DIR__ . '/../app/core/' . $class . '.php',
    __DIR__ . '/../app/models/' . $class . '.php',
    __DIR__ . '/../app/controllers/' . $class . '.php',
  ];
  foreach ($paths as $p) if (file_exists($p)) { require_once $p; return; }
});

// ✅ DEMO AUTH (REMOVE if you already have login)
// If you already have login, just ensure $_SESSION['user'] has: user_id, role, full_name
if (!isset($_SESSION['user'])) {
  $_SESSION['user'] = [
    'user_id' => 3,
    'role' => 'shelter',
    'full_name' => 'Paw Rescue Bangladesh',
  ];
}

$route = $_GET['r'] ?? 'shelter/dashboard';

$map = [
  'shelter/dashboard' => [ShelterDashboardController::class, 'index'],

  'shelter/pets' => [ShelterPetsController::class, 'index'],
  'shelter/pets/list' => [ShelterPetsController::class, 'list'],
  'shelter/pets/create' => [ShelterPetsController::class, 'create'],
  'shelter/pets/update' => [ShelterPetsController::class, 'update'],
  'shelter/pets/delete' => [ShelterPetsController::class, 'delete'],

  'shelter/adoptions' => [ShelterAdoptionsController::class, 'index'],
  'shelter/adoptions/list' => [ShelterAdoptionsController::class, 'list'],
  'shelter/adoptions/update' => [ShelterAdoptionsController::class, 'updateStatus'],

  'shelter/daycare' => [ShelterDaycareController::class, 'index'],
  'shelter/daycare/slots' => [ShelterDaycareController::class, 'slots'],
  'shelter/daycare/slot/create' => [ShelterDaycareController::class, 'createSlot'],
  'shelter/daycare/slot/delete' => [ShelterDaycareController::class, 'deleteSlot'],
  'shelter/daycare/bookings' => [ShelterDaycareController::class, 'bookings'],
  'shelter/daycare/booking/status' => [ShelterDaycareController::class, 'bookingStatus'],
  'shelter/daycare/log/add' => [ShelterDaycareController::class, 'addLog'],
  'shelter/daycare/logs' => [ShelterDaycareController::class, 'logs'],

  'shelter/profile' => [ShelterProfileController::class, 'index'],
  'shelter/profile/update' => [ShelterProfileController::class, 'update'],
];

if (!isset($map[$route])) {
  http_response_code(404);
  echo "Route not found - index.php:59";
  exit;
}

[$cls, $method] = $map[$route];
$controller = new $cls();
$controller->$method();
