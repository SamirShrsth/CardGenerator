<?php
session_start();


require_once '../config/Database.php';


$database = new Database();
$conn = $database->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $description = $_POST['description'];
    $rating = $_POST['rating'];

    $query = "INSERT INTO reviews (name, email, description, rating) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssd", $name, $email, $description, $rating);

    if ($stmt->execute()) {
        header('Location: http://localhost/CardGenerator/?success=1');
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
