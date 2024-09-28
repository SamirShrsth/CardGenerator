<?php
session_start();
require_once '../../controllers/AuthController.php';

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $role = $_POST['role'];
    $profile_image = $_FILES['profile_image'];

    $authController = new AuthController();
    $registrationResult = $authController->register($first_name, $last_name, $password, $email, $phone, $address, $role, $profile_image);

    if ($registrationResult === true) {
        header("Location: login.php");
        exit;
    } else {
        $error_message = $registrationResult;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/login.css">
    <title>Register</title>
</head>
<body>
    <?php include '../components/header.php' ?>
    <div class="container">
        <h2>Register</h2>
        <?php if (!empty($error_message)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>
        <form method="POST" action="" enctype="multipart/form-data">
            <input type="text" name="first_name" placeholder="First Name" required><br>
            <input type="text" name="last_name" placeholder="Last Name" required><br>
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <input type="text" name="phone" placeholder="Phone Number"><br>
            <textarea name="address" placeholder="Address"></textarea><br>
            <select name="role" required>
                <option value="user">User</option>
                <option value="org">Organization</option>
            </select><br>
            <input type="file" name="profile_image"><br>
            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>
