<?php
include '../config/Database.php';

$database = new Database();
$conn = $database->getConnection();

$query = "SELECT orientation, front_image, back_image, created_by FROM card_templates LIMIT 4";
$result = $conn->query($query);
?>

<div class="templates-section">
    <h2>View Templates</h2>
    <p>View a variety of templates made by us and other users like you!</p>
    <div class="templates-container">

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="template-item">';
                echo '<img src="controllers/' . htmlspecialchars($row['front_image']) . '" alt="Template">';
                echo '<h3>By ' . htmlspecialchars($row['created_by']) . '</h3>';
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
    background-color: #007BFF;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-size: 1rem;
    transition: background-color 0.3s;
}

.view-all-btn:hover {
    background-color: #0056b3;
}
</style>
