<?php
session_start();
include '../config/Database.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$database = new Database();
$conn = $database->getConnection();

if (!isset($_SESSION['user_id'])) {
    header("Location: http://localhost/CardGenerator/views/auth/login.php");
    exit();
}

$firstName = $_SESSION['first_name'] ?? '';
$lastName = $_SESSION['last_name'] ?? '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $orientation = $_POST['orientation'];
    $frontImage = $_FILES['front_image'];
    $backImage = $_FILES['back_image'];

    $valid = true;

    if ($orientation == 'portrait' && ($frontImage['size'] > 0 && $backImage['size'] > 0)) {
        list($widthFront, $heightFront) = getimagesize($frontImage['tmp_name']);
        list($widthBack, $heightBack) = getimagesize($backImage['tmp_name']);
        

        if ($widthFront != 306 || $heightFront != 486 || $widthBack != 306 || $heightBack != 486) {
            $valid = false;
            echo "<script>alert('Front and back images must be 306x486 pixels for portrait orientation.'); window.location.href='http://localhost/CardGenerator/views/pages/add_card_template.php';</script>";
            exit();
        }
    } elseif ($orientation == 'landscape' && ($frontImage['size'] > 0 && $backImage['size'] > 0)) {
        list($widthFront, $heightFront) = getimagesize($frontImage['tmp_name']);
        list($widthBack, $heightBack) = getimagesize($backImage['tmp_name']);

        if ($widthFront != 486 || $heightFront != 306 || $widthBack != 486 || $heightBack != 306) {
            $valid = false;
            echo "<script>alert('Front and back images must be 486x306 pixels for landscape orientation.'); window.location.href='http://localhost/CardGenerator/views/pages/add_card_template.php';</script>";
            exit();
        }
    }
    if ($valid) {
        $frontImagePath = 'uploads/' . basename($frontImage['name']);
        $backImagePath = 'uploads/' . basename($backImage['name']);
        

        if (move_uploaded_file($frontImage['tmp_name'], $frontImagePath) && move_uploaded_file($backImage['tmp_name'], $backImagePath)) {
            $createdBy = $firstName . ' ' . $lastName;
            $query = "INSERT INTO card_templates (orientation, front_image, back_image, created_by) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssss", $orientation, $frontImagePath, $backImagePath, $createdBy);
            $stmt->execute();

            echo "<script>
                    alert('Template added successfully!');
                    window.location.href = 'http://localhost/CardGenerator/views/pages/add_card_template.php';
                  </script>";
            exit();
        } else {
            echo "<script>alert('Error uploading images.'); window.location.href='http://localhost/CardGenerator/views/pages/add_card_template.php';</script>";
            exit();
        }
    }
}
?>
