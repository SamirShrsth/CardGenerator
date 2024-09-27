<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/UserModel.php';


class AuthController {
    private $db;
    private $userModel;

    public function __construct() {
        $this->db = new Database();
        $this->userModel = new UserModel($this->db->getConnection());
    }

    public function register($first_name, $last_name, $password, $email, $phone, $address, $role, $profile_image) {
        if ($this->userModel->getUserByEmail($email)) {
            return "Email already exists. Please use a different email.";
        }
    
        // Handle file upload
        $profile_image_path = null;
    
        if (isset($profile_image) && $profile_image['error'] === UPLOAD_ERR_OK) {
            // Specify the directory where you want to save the file
            $upload_dir = '../../assets/img/profile_images/';
            $file_name = basename($profile_image['name']);
            $target_file = $upload_dir . $file_name;
    
            // Move the uploaded file to the specified directory
            if (move_uploaded_file($profile_image['tmp_name'], $target_file)) {
                $profile_image_path = $file_name; // Only store the file name or path relative to the upload directory
            } else {
                return "Failed to upload image.";
            }
        }
    
        // Create the user
        if ($this->userModel->createUser($first_name, $last_name, password_hash($password, PASSWORD_DEFAULT), $email, $phone, $address, $role, $profile_image_path)) {
            return true;
        } else {
            return "Failed to register user.";
        }
    }
    

    public function login($email, $password) {
        // Check if the email exists
        $user = $this->userModel->getUserByEmail($email);
    
        if ($user) {
            // Verify the password
            if (password_verify($password, $user['password_hash'])) {
                // Password is correct, set session variables
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['first_name'] = $user['first_name']; // Set first name in session
                $_SESSION['last_name'] = $user['last_name'];   // Make sure this is set
                $_SESSION['email'] = $user['email'];
                $_SESSION['phone'] = $user['phone'];
                $_SESSION['address'] = $user['address'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['profile_image'] = $user['profile_image']; // Set profile image in session
                return true;
            }
        }
        return false; // Invalid email or password
    }
    public function updateProfile($userId, $firstName, $lastName, $email, $phone, $address) {
        return $this->userModel->updateUser($userId, $firstName, $lastName, $email, $phone, $address);
    }
    
}
?>
