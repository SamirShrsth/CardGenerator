<?php
session_start();

if (!isset($_SESSION['first_name'])) {
    header('Location: login.php'); 
    exit();
}
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
    <link rel="stylesheet" href="/CardGenerator/assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/profile.css">
</head>
<body>
    <?php include '../components/header.php'; ?>
    <div class="container">
        <section class="profile-content">
            <h2>Profile Information</h2>
            <div class="profile-info">
                <div class="profile-image">
                    <img src="../../assets/img/profile_images/<?php echo $profileImage; ?>" alt="Profile Image" class="profile-image-img">
                    <a href="edit_profile.php" class="edit-button">Edit Profile</a>
                    <a href="my_cards.php" class="edit-button">View My Cards</a>
                </div>
                <div class="profile-details">
                    <div class="info-segment">
                        <strong>First Name:</strong> <?php echo $firstName; ?>
                    </div>
                    <div class="info-segment">
                        <strong>Last Name:</strong> <?php echo $lastName; ?>
                    </div>
                    <div class="info-segment">
                        <strong>Email:</strong> <?php echo $email; ?>
                    </div>
                    </div>
                </div>
            </div>
            
        </section>
    </div>
</body>
</html>
