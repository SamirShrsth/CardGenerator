<?php session_start(); ?>
<?php
include '../../config/Database.php';

$database = new Database();
$conn = $database->getConnection();

$query = "SELECT orientation, front_image, back_image, creator_type, creator_id FROM card_templates";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Templates</title>
    <link rel="stylesheet" href="/CardGenerator/assets/css/style.css">
</head>
<body>
    <?php include '../components/header.php'; ?>

    <div class="templates-section">
        <h2>All Templates</h2>
        <p>Here are all the templates available:</p>
        <div class="templates-container">

            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Fetch the creator's name based on the role
                    if ($row['creator_type'] == 'user') {
                        // Fetch user name
                        $userId = $row['creator_id'];
                        $userQuery = "SELECT first_name, last_name FROM users WHERE user_id = ?";
                        $userStmt = $conn->prepare($userQuery);
                        $userStmt->bind_param("i", $userId);
                        $userStmt->execute();
                        $userResult = $userStmt->get_result();
                        $user = $userResult->fetch_assoc();
                        $creatorName = htmlspecialchars($user['first_name'] . ' ' . $user['last_name']);
                    } else {
                        // Fetch organization name
                        $orgId = $row['creator_id'];
                        $orgQuery = "SELECT org_name FROM organizations WHERE org_id = ?";
                        $orgStmt = $conn->prepare($orgQuery);
                        $orgStmt->bind_param("i", $orgId);
                        $orgStmt->execute();
                        $orgResult = $orgStmt->get_result();
                        $organization = $orgResult->fetch_assoc();
                        $creatorName = htmlspecialchars($organization['org_name']);
                    }

                    echo '<div class="template-item">';
                    echo '<img src="http://localhost/CardGenerator/controllers/' . htmlspecialchars($row['front_image']) . '" alt="Template">';
                    echo '<h3>By ' . $creatorName . '</h3>'; // Display creator's name
                    echo '</div>';
                }
            } else {
                echo '<p>No templates found.</p>';
            }
            ?>
        </div>
    </div>
</body>
</html>