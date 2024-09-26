<?php
require_once '../config/Database.php';
require_once '../models/UserModel.php';

class AuthController {
    private $db;
    private $userModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->userModel = new UserModel($this->db);
    }

    // Handle registration
    public function register($username, $email, $password) {
        $this->userModel->username = $username;
        $this->userModel->email = $email;
        $this->userModel->password = $password;

        if ($this->userModel->register()) {
            header("Location: ../views/login.php");
        } else {
            echo "Registration failed!";
        }
    }

    // Handle login
    public function login($email, $password) {
        $this->userModel->email = $email;
        $this->userModel->password = $password;

        $user = $this->userModel->login();
        session_start();

        if ($user) {
            $_SESSION['username'] = $user['username']; // Set the username in the session
            header("Location: ../index.php"); // Redirect to the home page
            exit();
        } else {
            echo "Login failed!";
        }
    }
}
?>
