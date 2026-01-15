<?php
session_start();
require_once '../config/database.php';
require_once '../models/AdopterModel.php';

$db = (new Database())->connect();
$model = new AdopterModel($db);

$model->deleteProfile($_SESSION['user_id']);
session_destroy();

echo json_encode(['status'=>'success','message'=>'Profile deleted']);
