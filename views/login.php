
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../assets//css//login.css">
</head>
<body>
    <h2>Login</h2>
    <form method="POST" action="../public/index.php?action=login">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button><br>
        <span>No account?
            <a href="register.php">Register now</a>
            </span>
    </form>
</body>
</html>
