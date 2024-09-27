<?php
session_start();
include '../../config/Database.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Create a new database connection
$database = new Database();
$conn = $database->getConnection();

if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: http://localhost/CardGenerator/login.php");
    exit();
}

$firstName = $_SESSION['first_name'] ?? ''; // Assuming first name is stored in session
$lastName = $_SESSION['last_name'] ?? ''; // Assuming last name is stored in session

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $orientation = $_POST['orientation'];
    $frontImage = $_FILES['front_image'];
    $backImage = $_FILES['back_image'];

    // Validate the uploaded images
    $valid = true;

    // Check orientation and image dimensions
    if ($orientation == 'portrait' && ($frontImage['size'] > 0 && $backImage['size'] > 0)) {
        list($widthFront, $heightFront) = getimagesize($frontImage['tmp_name']);
        list($widthBack, $heightBack) = getimagesize($backImage['tmp_name']);
        
        if ($orientation == 'portrait' && ($frontImage['size'] > 0 && $backImage['size'] > 0)) {
            list($widthFront, $heightFront) = getimagesize($frontImage['tmp_name']);
            list($widthBack, $heightBack) = getimagesize($backImage['tmp_name']);
            
            // Change dimensions to 306x486 for portrait
            if ($widthFront != 306 || $heightFront != 486 || $widthBack != 306 || $heightBack != 486) {
                $valid = false;
                echo "<script>alert('Front and back images must be 306x486 pixels for portrait orientation.'); window.location.href='http://localhost/CardGenerator/views/pages/add_card_template.php';</script>";
                exit();
            }
        } elseif ($orientation == 'landscape' && ($frontImage['size'] > 0 && $backImage['size'] > 0)) {
            list($widthFront, $heightFront) = getimagesize($frontImage['tmp_name']);
            list($widthBack, $heightBack) = getimagesize($backImage['tmp_name']);
            
            // Change dimensions to 486x306 for landscape
            if ($widthFront != 486 || $heightFront != 306 || $widthBack != 486 || $heightBack != 306) {
                $valid = false;
                echo "<script>alert('Front and back images must be 486x306 pixels for landscape orientation.'); window.location.href='http://localhost/CardGenerator/views/pages/add_card_template.php';</script>";
                exit();
            }
        }
        
    }

    // Proceed to upload if valid
    if ($valid) {
        $frontImagePath = 'uploads/' . basename($frontImage['name']);
        $backImagePath = 'uploads/' . basename($backImage['name']);
        
        // Move the uploaded files to the desired directory
        if (move_uploaded_file($frontImage['tmp_name'], $frontImagePath) && move_uploaded_file($backImage['tmp_name'], $backImagePath)) {
            // Combine first and last name for created_by
            $createdBy = $firstName . ' ' . $lastName;

            // Save the paths and user info to the database
            $query = "INSERT INTO card_templates (orientation, front_image, back_image, created_by) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssss", $orientation, $frontImagePath, $backImagePath, $createdBy);
            $stmt->execute();

            // Redirect to the main page after successful upload
            header("Location: http://localhost/CardGenerator/");
            exit();
        } else {
            echo "<script>alert('Error uploading images.'); window.location.href='http://localhost/CardGenerator/views/pages/add_card_template.php';</script>";
            exit();
        }
    }
}
?>
