<?php session_start(); ?>
<?php
include '../../config/Database.php';

$database = new Database();
$conn = $database->getConnection();

$query = "SELECT orientation, front_image, back_image, creator_type, creator_id FROM card_templates WHERE creator_type = 'organization'";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Templates</title>
    <link rel="stylesheet" href="/CardGenerator/assets/css/style.css">
    <link rel="stylesheet" href="/CardGenerator/assets/css/view_templates.css">
</head>
<body>
    <?php include '../components/header.php'; ?>

    <div class="templates-section">
        <!-- Search Bar -->
        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Search by organization name..." />
        </div>

        <!-- Filter Buttons -->
        <div class="filters">
            <button class="filter-btn" data-filter="all">All Templates</button>
            <button class="filter-btn" data-filter="portrait">Portrait Templates</button>
            <button class="filter-btn" data-filter="landscape">Landscape Templates</button>
        </div>

        <!-- Template Display -->
        <div class="templates-container">
            <?php
                // Fetch templates and organization names from the database
                $query = "SELECT ct.template_id, ct.front_image,ct.creator_id, ct.back_image, ct.orientation, o.org_name, o.logo, o.address, o.phone 
                FROM card_templates ct 
                JOIN organizations o ON ct.creator_id = o.org_id 
                WHERE ct.creator_type = 'organization'";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                // Fetch organization name
                $orgId = $row['creator_id'];
                $orgQuery = "SELECT org_name FROM organizations WHERE org_id = ?";
                $orgStmt = $conn->prepare($orgQuery);
                $orgStmt->bind_param("i", $orgId);
                $orgStmt->execute();
                $orgResult = $orgStmt->get_result();
                $organization = $orgResult->fetch_assoc();
                $creatorName = htmlspecialchars($organization['org_name']);

                // Determine the template orientation class
                $orientationClass = htmlspecialchars($row['orientation']);
                $frontImage = htmlspecialchars($row['front_image']);

                echo '<div class="template-item ' . $orientationClass . '" data-orientation="' . $orientationClass . '" data-org="' . strtolower($creatorName) . '">';
                echo '<a href="create_card.php?template=' . urlencode($row['template_id']) . '&org_name=' . urlencode($creatorName) . '">';
                echo '<img src="http://localhost/CardGenerator/controllers/' . $frontImage . '" alt="Template">';
                echo '<h3>By ' . $creatorName . '</h3>';
                echo '</a>';
                echo '</div>';
                }
                } else {
                echo '<option value="">No templates available</option>';
                }
            ?>
        </div>
    </div>

    <script>
        // Filter functionality
        document.querySelectorAll('.filter-btn').forEach(button => {
            button.addEventListener('click', function() {
                const filter = this.getAttribute('data-filter');
                const templateItems = document.querySelectorAll('.template-item');

                templateItems.forEach(item => {
                    if (filter === 'all' || item.getAttribute('data-orientation') === filter) {
                        item.style.display = 'block'; // Show the template
                    } else {
                        item.style.display = 'none'; // Hide the template
                    }
                });
            });
        });

        // Default to "all" templates on page load
        document.querySelector('.filter-btn[data-filter="all"]').click();

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchValue = this.value.toLowerCase();
            const templateItems = document.querySelectorAll('.template-item');

            templateItems.forEach(item => {
                const orgName = item.getAttribute('data-org');
                if (orgName.includes(searchValue)) {
                    item.style.display = 'block'; // Show matching templates
                } else {
                    item.style.display = 'none'; // Hide non-matching templates
                }
            });
        });
    </script>
</body>
</html>
