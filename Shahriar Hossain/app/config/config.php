<?php
// ✅ CHANGE ONLY THIS if your project is inside a folder
// Example: "/Expeditioners_Project/public"
define('BASE_URL', '/pawsome/public');

define('APP_ROOT', dirname(__DIR__));
define('PUBLIC_ROOT', dirname(__DIR__, 2) . '/public');

define('UPLOAD_DIR_SHELTERS', PUBLIC_ROOT . '/uploads/shelters/');
define('UPLOAD_DIR_PETS', PUBLIC_ROOT . '/uploads/pets/');

define('MAX_UPLOAD_MB', 5);
define('MAX_UPLOAD_BYTES', MAX_UPLOAD_MB * 1024 * 1024);

date_default_timezone_set('Asia/Dhaka');


