<?php
session_start();
require_once '../config/database.php';
require_once '../models/AdopterModel.php';

$db = (new Database())->connect();
$model = new AdopterModel($db);

$model->updateProfile($_SESSION['user_id'], $_POST);
echo json_encode(['status'=>'success','message'=>'Profile updated']);
