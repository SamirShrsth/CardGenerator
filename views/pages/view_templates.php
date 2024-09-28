<?php session_start(); ?>
<?php
include '../../config/Database.php';

$database = new Database();
$conn = $database->getConnection();

$query = "SELECT orientation, front_image, back_image, created_by FROM card_templates";
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
                    echo '<div class="template-item">';
                    echo '<img src="http://localhost/CardGenerator/controllers/' . htmlspecialchars($row['front_image']) . '" alt="Template">';
                    echo '<h3>By ' . htmlspecialchars($row['created_by']) . '</h3>';
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
