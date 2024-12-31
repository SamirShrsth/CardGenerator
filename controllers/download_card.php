<?php
session_start();
require_once '../../config/Database.php';

$database = new Database();
$conn = $database->getConnection();

$cardId = $_GET['card_id'];

$query = "SELECT front_image, back_image FROM cards WHERE card_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $cardId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $frontImage = $row['front_image'];
    $backImage = $row['back_image'];

    // Set headers for download
    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="card_' . $cardId . '.zip"');

    // Create a zip file
    $zip = new ZipArchive();
    $zipFileName = tempnam(sys_get_temp_dir(), 'card_') . '.zip';

    if ($zip->open($zipFileName, ZipArchive::CREATE) === TRUE) {
        $zip->addFile('../../controllers/' . $frontImage, 'front_image.jpg');
        $zip->addFile('../../controllers/' . $backImage, 'back_image.jpg');
        $zip->close();

        // Read the zip file and output it to the browser
        readfile($zipFileName);
        unlink($zipFileName); // Delete the temp file
    } else {
        echo 'Failed to create zip file.';
    }
} else {
    echo 'Card not found.';
}
?>