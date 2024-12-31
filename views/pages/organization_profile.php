<?php
session_start();

if (!isset($_SESSION['org_name'])) {
    header('Location: login.php'); 
    exit();
}

$orgName = htmlspecialchars($_SESSION['org_name']);
$orgEmail = isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : 'N/A';
$orgAddress = isset($_SESSION['address']) ? htmlspecialchars($_SESSION['address']) : 'N/A';
$orgPhone = isset($_SESSION['phone']) ? htmlspecialchars($_SESSION['phone']) : 'N/A';
$orgLogo = htmlspecialchars($_SESSION['logo']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organization Profile</title>
    <link rel="stylesheet" href="/CardGenerator/assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/profile.css">
    <link rel="stylesheet" href="../../assets/css/templates.css">
    <style>
        .dashboard{
            display: flex;
            justify-content: center;
        }
        .dashboard a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .dashboard a:hover {
            background-color: #0056b3;
        }
        header .nav-list{
            display: none;
        }
    </style>
</head>
<body>
    <?php include '../components/header.php'; ?>
    <div class="container">
        <section class="profile-content">
            <h2>Organization Profile Information</h2>
            <div class="profile-info">
                <div class="profile-image">
                    <img src="../../assets/img/organization_logos/<?php echo $orgLogo; ?>" alt="Organization Logo" class="profile-image-img">
                    <a href="edit_org_profile.php" class="edit-button">Edit Profile</a>
                    <div class="dashboard">
                        <a href="org_dashboard.php">Go to Dashboard</a>
                    </div>
                </div>
                <div class="profile-details">
                    <div class="info-segment">
                        <strong>Organization Name:</strong> <?php echo $orgName; ?>
                    </div>
                    <div class="info-segment">
                        <strong>Email:</strong> <?php echo $orgEmail; ?>
                    </div>
                    <div class="info-segment">
                        <strong>Address:</strong> <?php echo $orgAddress; ?>
                    </div>
                    <div class="info-segment">
                        <strong>Phone:</strong> <?php echo $orgPhone; ?>
                    </div>
                </div>
            </div>
            
        </section>
    </div>
</body>
</html>