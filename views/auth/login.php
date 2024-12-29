<?php
session_start();
require_once '../../controllers/AuthController.php';

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $authController = new AuthController();
    $loginSuccess = $authController->login($email, $password);

    if ($loginSuccess) {
        header("Location: http://localhost/CardGenerator/");
        exit;
    } else {
        $error_message = "Invalid email or password.";
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
    <title>Login</title>
    <style>
        .container{
            max-width: 600px;
            margin-top: 100px;
        }
    </style>
</head>
<body>
    <?php include '../components/header.php'; ?>
    <div class="container">
        <h2>Login</h2>
        <?php if (!empty($error_message)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="email">Email:</label>
            <input type="email" name="email" required><br>
            <label for="password">Password:</label>
            <input type="password" name="password" required><br>
            <div class="registerGroup">
                <button type="submit">Login</button>
            </div>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</body>
</html>
