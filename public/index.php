<?php
session_start();

require_once '../controllers/AuthController.php';

$authController = new AuthController();

$action = isset($_GET['action']) ? $_GET['action'] : '';

// Handle registration
if ($action == 'register' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $role = $_POST['role'];
    $profile_image = $_FILES['profile_image'];

    $registrationResult = $authController->register($first_name, $last_name, $password, $email, $phone, $address, $role, $profile_image);

    if ($registrationResult === true) {
        header("Location: login.php");
        exit();
    } else {
        echo $registrationResult;
    }
}

if ($action == 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($authController->login($email, $password)) {
        header('Location: dashboard.php');
        exit();
    } else {
        echo "Login failed. Please check your email and password.";
    }
}
?>
