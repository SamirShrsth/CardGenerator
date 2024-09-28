
<?php
session_start();
require_once '../../controllers/AuthController.php';


if (!isset($_SESSION['first_name'])) {
    header('Location: login.php');
    exit();
}

$firstName = htmlspecialchars($_SESSION['first_name']);
$lastName = isset($_SESSION['last_name']) ? htmlspecialchars($_SESSION['last_name']) : 'N/A';
$email = isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : 'N/A';
$phone = isset($_SESSION['phone']) ? htmlspecialchars($_SESSION['phone']) : 'N/A';
$address = isset($_SESSION['address']) ? htmlspecialchars($_SESSION['address']) : 'N/A';
$userId = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $authController = new AuthController();

    $_SESSION['first_name'] = $_POST['first_name'];
    $_SESSION['last_name'] = $_POST['last_name'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['phone'] = $_POST['phone'];
    $_SESSION['address'] = $_POST['address'];

    $updateSuccess = $authController->updateProfile($userId, $_SESSION['first_name'], $_SESSION['last_name'], $_SESSION['email'], $_SESSION['phone'], $_SESSION['address']);

    if ($updateSuccess) {
        header('Location: profile.php');
        exit();
    } else {
        $error_message = "Failed to update profile. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="/CardGenerator/assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/profile.css">
</head>
<body>
    <div class="container">
        <section class="edit-profile-content">
            <h2>Edit Profile Information</h2>
            <?php if (isset($error_message)): ?>
                <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
            <?php endif; ?>
            <form method="POST" action="">
                <label for="first_name">First Name:</label>
                <input type="text" name="first_name" value="<?php echo $firstName; ?>" required>

                <label for="last_name">Last Name:</label>
                <input type="text" name="last_name" value="<?php echo $lastName; ?>" required>

                <label for="email">Email:</label>
                <input type="email" name="email" value="<?php echo $email; ?>" required>

                <label for="phone">Phone:</label>
                <input type="text" name="phone" value="<?php echo $phone; ?>" required>

                <label for="address">Address:</label>
                <input type="text" name="address" value="<?php echo $address; ?>" required>

                <button type="submit">Update Profile</button>
            </form>
        </section>
    </div>
</body>
</html>
