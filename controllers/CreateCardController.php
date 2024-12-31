<?php
session_start();
include '../config/Database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['user_id'])) {
        echo "User not logged in.";
        exit;
    }

    $requiredFields = ['template', 'idNumber', 'department', 'org_id', 'orgName', 'orgLogo', 'orgAddress', 'orgPhone'];
    foreach ($requiredFields as $field) {
        if (!isset($_POST[$field])) {
            echo "Incomplete data provided.";
            exit;
        }
    }

    $database = new Database();
    $conn = $database->getConnection();

    $user_id = $_SESSION['user_id'];
    $template_id = $_POST['template'];
    $organization_id = $_POST['org_id'];
    $registration_number = $_POST['idNumber'];
    $department = $_POST['department'];
    $orgName = $_POST['orgName'];
    $orgLogo = $_POST['orgLogo'];
    $orgAddress = $_POST['orgAddress'];
    $orgPhone = $_POST['orgPhone'];

    $stmt = $conn->prepare("SELECT 1 FROM card_templates WHERE template_id = ?");
    $stmt->bind_param('i', $template_id);
    $stmt->execute();
    if ($stmt->get_result()->num_rows == 0) {
        echo "Template not found.";
        exit;
    }

    $stmt = $conn->prepare("SELECT 1 FROM card_requests WHERE user_id = ? AND organization_id = ?");
    $stmt->bind_param('ii', $user_id, $organization_id);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        echo "You have already requested an ID card from this organization.";
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO card_requests (user_id, template_id, organization_id) VALUES (?, ?, ?)");
    $stmt->bind_param('iii', $user_id, $template_id, $organization_id);
    if (!$stmt->execute()) {
        echo "Failed to submit the request.";
        exit;
    }

    $stmt = $conn->prepare("SELECT first_name, last_name, profile_image FROM users WHERE user_id = ?");
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if (!$user) {
        echo "User not found.";
        exit;
    }

    $profile_image = $user['profile_image'] ?? 'default_profile.png';
    $stmt = $conn->prepare(
        "INSERT INTO cards (user_id, template_id, first_name, last_name, registration_number, department, org_name, org_logo, org_address, org_phone, profile_image, card_status) 
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')"
    );
    $stmt->bind_param('iisssssssss', $user_id, $template_id, $user['first_name'], $user['last_name'], $registration_number, $department, $orgName, $orgLogo, $orgAddress, $orgPhone, $profile_image);

    echo $stmt->execute() ? "Card request submitted successfully." : "Error submitting card request: " . $stmt->error;
}
?>