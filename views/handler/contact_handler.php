<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Here you would typically send this data to a database or send an email.
    // For now, we'll just redirect to the contact page with a success message.
    
    header('Location: contact.php?success=1');
    exit();
}
?>
