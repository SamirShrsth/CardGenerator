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
        .container {
            margin-top: 100px;
        }
        .error-message {
            color: red;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <?php include '../components/header.php'; ?>
    <div class="container">
        <h2>Login</h2>
        <form method="POST" action="" id="loginForm">
            <?php if (!empty($error_message)): ?>
                <div class="error-message" id="loginError"><?php echo htmlspecialchars($error_message); ?></div>
            <?php endif; ?>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" name="email" id="email">
                <span class="error-message" id="emailError"></span>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password">
                <span class="error-message" id="passwordError"></span>
            </div>
            <button type="submit">Login</button>
        </form>

        <script>
            document.getElementById('loginForm').addEventListener('submit', function(event) {
                let valid = true;
                const email = document.getElementById('email').value;

                const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

                // Reset error messages
                document.getElementById('emailError').textContent = '';
                document.getElementById('passwordError').textContent = '';
                document.getElementById('loginError').textContent = ''; // Clear login error message

                if (!emailRegex.test(email)) {
                    document.getElementById('emailError').textContent = "Please enter a valid email address.";
                    valid = false;
                }

                if (!valid) {
                    event.preventDefault(); // Prevent form submission
                }
            });

            // Clear the login error message when user starts typing
            document.getElementById('email').addEventListener('input', function() {
                document.getElementById('loginError').textContent = '';
            });

            document.getElementById('password').addEventListener('input', function() {
                document.getElementById('loginError').textContent = '';
            });
        </script>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</body>
</html>