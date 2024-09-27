<?php
include '../config/Database.php';

// Create a new database connection
$database = new Database();
$conn = $database->getConnection();

// Query to fetch card templates
$query = "SELECT orientation, front_image, back_image, created_by FROM card_templates";
$result = $conn->query($query);
?>

<div class="templates-section">
    <h2>View Templates</h2>
    <p>View a variety of templates made by us and other users like you!</p>
    <div class="templates-container">

        <?php
        // Check if there are templates available
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo '<div class="template-item">';
                // Adjust the image source to point to the correct uploads directory
                echo '<img src="views/handler/' . htmlspecialchars($row['front_image']) . '" alt="Template">';
                echo '<h3>By ' . htmlspecialchars($row['created_by']) . '</h3>';
                echo '</div>';
            }
        } else {
            echo '<p>No templates found.</p>';
        }
        ?>
    </div>
</div>

<script>
    function toggleTemplates() {
        const hiddenTemplates = document.querySelectorAll('.template-item.hidden');
        hiddenTemplates.forEach(template => {
            template.classList.toggle('hidden');
        });
    }
</script>
