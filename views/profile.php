<!-- views/profile.php -->
<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['first_name'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}

// Assuming user information is stored in session variables
$firstName = htmlspecialchars($_SESSION['first_name']);
$lastName = isset($_SESSION['last_name']) ? htmlspecialchars($_SESSION['last_name']) : 'N/A';
$email = isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : 'N/A';
$profileImage = htmlspecialchars($_SESSION['profile_image']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/profile.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>User Profile</h1>
            <nav>
                <a href="../index.php">Home</a>
                <a href="logout.php">Logout</a>
            </nav>
        </header>
        <section class="profile-content">
            <h2>Profile Information</h2>
            <img src="../assets/img/profile_images/<?php echo $profileImage; ?>" alt="Profile Image" class="profile-image">
            <div class="user-info">
                <p><strong>First Name:</strong> <?php echo $firstName; ?></p>
                <p><strong>Last Name:</strong> <?php echo $lastName; ?></p>
                <p><strong>Email:</strong> <?php echo $email; ?></p>
            </div>
        </section>
    </div>
</body>
</html>
