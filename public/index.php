<?php
require_once '../controllers/AuthController.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

$authController = new AuthController();

if ($action == 'register' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $authController->register($_POST['username'], $_POST['email'], $_POST['password']);
}

if ($action == 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $authController->login($_POST['email'], $_POST['password']);
}
?>
