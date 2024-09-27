<?php
session_start();
session_unset(); // Remove all session variables
session_destroy(); // Destroy the session
header("Location: http://localhost/CardGenerator/"); // Redirect to the main page
exit();
?>
