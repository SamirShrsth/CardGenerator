<?php
session_start();
require_once '../../config/Database.php';

if (!isset($_SESSION['org_id'])) {
    header('Location: login.php');
    exit();
}

$database = new Database();
$conn = $database->getConnection();

$cardId = $_GET['id'];

$query = "UPDATE cards SET card_status = 'rejected' WHERE card_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $cardId);
$stmt->execute();

header("Location: /CardGenerator/views/pages/org_dashboard.php?tab=pending_requests");
exit();
?>