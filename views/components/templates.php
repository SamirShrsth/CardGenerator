<?php
include '../config/Database.php';

$database = new Database();
$conn = $database->getConnection();

$query = "SELECT orientation, front_image, back_image, creator_type, creator_id FROM card_templates LIMIT 4";
$result = $conn->query($query);
?>

<div class="templates-section">
    <h2>View Templates</h2>
    <p>View a variety of templates made by us and other users like you!</p>
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
    
    <div class="view-all-container" style="text-align: center; margin-top: 20px;">
        <a href="http://localhost/CardGenerator/views/pages/view_templates.php" class="view-all-btn">View All Templates</a>
    </div>
</div>

<style>
.view-all-btn {
    display: inline-block;
    margin-top: 20px;
    padding: 10px 20px;
    background-color: black;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-size: 1rem;
    transition: background-color 0.3s;
}

.view-all-btn:hover {
    background-color: #007BFF;
}
</style>
