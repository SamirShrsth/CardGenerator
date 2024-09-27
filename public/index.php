<?php
session_start(); // Start a session to store user data

// Include the AuthController
require_once '../controllers/AuthController.php';

// Initialize the AuthController
$authController = new AuthController();

// Determine the action based on the query string
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Handle registration
if ($action == 'register' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collecting data from the registration form
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $role = $_POST['role'];
    $profile_image = $_FILES['profile_image']; // Handle file upload for profile image

    // Call the register method
    $registrationResult = $authController->register($first_name, $last_name, $password, $email, $phone, $address, $role, $profile_image);

    if ($registrationResult === true) {
        header("Location: login.php"); // Redirect to login page on success
        exit();
    } else {
        echo $registrationResult; // Display error message
    }
}

// Handle login
if ($action == 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collecting data from the login form
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($authController->login($email, $password)) {
        header('Location: dashboard.php'); // Redirect to the dashboard on successful login
        exit();
    } else {
        echo "Login failed. Please check your email and password.";
    }
}
?>
