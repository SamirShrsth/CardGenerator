<?php
session_start();
include '../config/Database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);
    $organization = htmlspecialchars($_POST['organization']);

    // Create a new database connection
    $database = new Database();
    $conn = $database->getConnection();

    $query = "INSERT INTO contacts (name, email, message, organization_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    $stmt->bind_param("ssss", $name, $email, $message, $organization);
    

    if ($stmt->execute()) {
        header('Location: http://localhost/CardGenerator?success=1');
        exit();
    } else {
        header('Location: http://localhost/CardGenerator?error=1');
        exit();
    }
}
?>
