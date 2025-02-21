<?php
session_start();
include '../../config/Database.php';

// Fetch profile image for the logged-in user

$profile_image = 'default_profile.png';
$first_name = '';
$last_name = '';

if (isset($_SESSION['user_id'])) {
    $database = new Database();
    $conn = $database->getConnection();

    $user_id = $_SESSION['user_id'];
    $query = "SELECT profile_image, first_name, last_name FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        $profile_image = $user['profile_image'] ?? 'default_profile.png';
        $first_name = $user['first_name'] ?? '';
        $last_name = $user['last_name'] ?? '';
    }
} elseif(isset($_SESSION['org_id'])){
    header('Location: http://localhost/CardGenerator/views/pages/org_dashboard.php?tab=create_card');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create ID Card</title>
    <link rel="stylesheet" href="/CardGenerator/assets/css/style.css">
    <link rel="stylesheet" href="/CardGenerator/assets/css/templates.css">
    <link rel="stylesheet" href="/CardGenerator/assets/css/create_card.css">
    <style>
         
    </style>
</head>
<body data-profile-image="<?php echo htmlspecialchars($profile_image, ENT_QUOTES, 'UTF-8'); ?>">
    <?php include '../components/header.php'; ?>

    <div class="container">
        <section class="create-card-section">   
            <h2>Request ID Card</h2>
            <form id="createCardForm">  
                <div class="form-group">
                    <label for="template">Select Template:</label>
                    <select name="template" id="template" required>
                        <?php
                        $templateId = $_GET['template'] ?? null;
                        $orgName = $_GET['org_name'] ?? null;

                        $query = "SELECT ct.template_id, ct.front_image, ct.back_image, ct.orientation, o.org_name, o.logo, o.address, o.phone, o.org_id 
                        FROM card_templates ct 
                        JOIN organizations o ON ct.creator_id = o.org_id 
                        WHERE ct.creator_type = 'organization'";
                        $result = $conn->query($query);

                        if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                        
                        $orgId = $row['org_id'];
                        $orgQuery = "SELECT org_name FROM organizations WHERE org_id = ?";
                        $orgStmt = $conn->prepare($orgQuery);
                        $orgStmt->bind_param("i", $orgId);
                        $orgStmt->execute();
                        $orgResult = $orgStmt->get_result();
                        $organization = $orgResult->fetch_assoc();
                        $creatorName = htmlspecialchars($organization['org_name']);

                        $orientationClass = htmlspecialchars($row['orientation']);
                        $frontImage = htmlspecialchars($row['front_image']);

                        $selected = ($row['template_id'] == $templateId) ? 'selected' : '';
                        echo '<option value="' . htmlspecialchars($row['template_id']) . '" ' . $selected . ' 
                            data-front-image="' . htmlspecialchars($row['front_image']) . '"
                            data-back-image="' . htmlspecialchars($row['back_image']) . '"
                            data-orientation="' . htmlspecialchars($row['orientation']) . '"
                            data-logo="' . htmlspecialchars($row['logo']) . '" 
                            data-address="' . htmlspecialchars($row['address']) . '" 
                            data-phone="' . htmlspecialchars($row['phone']) . '"
                            data-org-id="' . htmlspecialchars($row['org_id']) . '">'
                            . htmlspecialchars($row['org_name']) . '</option>';
                        }
                        } else {
                        echo '<option value="">No templates available</option>';
                        }
                        ?>
                    </select>

                </div>

                <img id="templatePreview" src="" alt="Template Preview" style="display:none;">

                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" placeholder="Enter your name" required value="<?php echo htmlspecialchars($first_name . ' ' . $last_name, ENT_QUOTES, 'UTF-8'); ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="idNumber">Roll No:</label>
                    <input type="text" id="idNumber" name="idNumber" placeholder="Enter your roll number" required>
                </div>

                <div class="form-group">
                    <label for="department">Department:</label>
                    <select id="department" name="department" required>
                        <option value="">Select your department</option>
                        <option value="BCA">BCA</option>
                        <option value="BBS">BBS</option>
                        <option value="CSIT">CSIT</option>
                        <option value="BIT">BIT</option>
                        <option value="BBM">BBM</option>
                    </select>
                </div>

                <button type="button" id="generateCardBtn" class="submit-btn">Generate Card</button>
            </form>

            <div id="cardDisplay" class="card-display" style="display:none;">
                <h3>Your ID Card</h3>
                <button id="requestCardBtn" class="submit-btn" style="display:none;">Request Card</button>
                <div class="flip-card">
                    <div class="flip-card-inner">
                        <div id="cardFront" class="flip-card-front"></div>
                        <div id="cardBack" class="flip-card-back"></div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="../../assets/js/createCard.js"></script>

    
</body>
</html>
