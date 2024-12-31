<?php
session_start();
require_once '../../controllers/AuthController.php';

if (!isset($_SESSION['org_name'])) {
    header('Location: login.php'); 
    exit();
}

$orgName = htmlspecialchars($_SESSION['org_name']);
$orgEmail = isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : 'N/A';
$orgAddress = isset($_SESSION['address']) ? htmlspecialchars($_SESSION['address']) : 'N/A';
$orgPhone = isset($_SESSION['phone']) ? htmlspecialchars($_SESSION['phone']) : 'N/A';
$orgId = $_SESSION['org_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $authController = new AuthController();

    $_SESSION['org_name'] = $_POST['org_name'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['address'] = $_POST['org_address'];
    $_SESSION['phone'] = $_POST['org_phone'];

    $updateSuccess = $authController->updateOrganizationProfile($orgId, $_SESSION['org_name'], $_SESSION['email'], $_SESSION['address'], $_SESSION['phone']);

    if ($updateSuccess) {
        header('Location: organization_profile.php');
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
    <title>Edit Organization Profile</title>
    <link rel="stylesheet" href="/CardGenerator/assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/profile.css">
</head>
<body>
    <div class="container">
        <section class="edit-profile-content">
            <h2>Edit Organization Profile Information</h2>
            <?php if (isset($error_message)): ?>
                <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
            <?php endif; ?>
            <form method="POST" action="">
                <label for="org_name">Organization Name:</label>
                <input type="text" name="org_name" value="<?php echo $orgName; ?>" required>

                <label for="email">Email:</label>
                <input type="email" name="email" value="<?php echo $orgEmail; ?>" required>

                <label for="org_address">Address:</label>
                <input type="text" name="org_address" value="<?php echo $orgAddress; ?>" required>

                <label for="org_phone">Phone:</label>
                <input type="text" name="org_phone" value="<?php echo $orgPhone; ?>" required>

                <button type="submit">Update Profile</button>
            </form>
        </section>
    </div>
</body>
</html>