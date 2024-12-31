<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/OrganizationModel.php'; // Assuming you have an OrganizationModel

class AuthController {
    private $db;
    private $userModel;
    private $organizationModel;

    public function __construct() {
        $this->db = new Database();
        $this->userModel = new UserModel($this->db->getConnection());
        $this->organizationModel = new OrganizationModel($this->db->getConnection()); // Initialize OrganizationModel
    }

    public function registerUser ($first_name, $last_name, $email, $password, $profile_image) {
        if ($this->userModel->getUserByEmail($email)) {
            return "Email already exists. Please use a different email.";
        }

        // Handle file upload for profile image
        $profile_image_path = null;

        if (isset($profile_image) && $profile_image['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../../assets/img/profile_images/';
            $file_name = basename($profile_image['name']);
            $target_file = $upload_dir . $file_name;

            // Move the uploaded file to the specified directory
            if (move_uploaded_file($profile_image['tmp_name'], $target_file)) {
                $profile_image_path = $file_name;
            } else {
                return "Failed to upload image.";
            }
        }

        // Create the user
        if ($this->userModel->createUser ($first_name, $last_name, password_hash($password, PASSWORD_DEFAULT), $email, $profile_image_path)) {
            return true;
        } else {
            return "Failed to register user.";
        }
    }

    public function registerOrganization($org_name, $email, $address, $phone, $logo, $password) {
        if ($this->organizationModel->getOrganizationByEmail($email)) {
            return "Email already exists. Please use a different email.";
        }

        // Handle file upload for organization logo
        $logo_path = null;

        if (isset($logo) && $logo['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../../assets/img/organization_logos/';
            $file_name = basename($logo['name']);
            $target_file = $upload_dir . $file_name;

            // Move the uploaded file to the specified directory
            if (move_uploaded_file($logo['tmp_name'], $target_file)) {
                $logo_path = $file_name;
            } else {
                return "Failed to upload logo.";
            }
        }

        // Create the organization
        if ($this->organizationModel->createOrganization($org_name, $email, $address, $phone, password_hash($password, PASSWORD_DEFAULT), $logo_path)) {
            return true;
        } else {
            return "Failed to register organization.";
        }
    }

    public function login($email, $password) {
        // Check if the email belongs to a user
        $user = $this->userModel->getUserByEmail($email);
        if ($user) {
            // Verify the password for user
            if (password_verify($password, $user['password_hash'])) {
                // Password is correct, set session variables for user
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['first_name'] = $user['first_name'];
                $_SESSION['last_name'] = $user['last_name'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['profile_image'] = $user['profile_image'];
                header('Location: http://localhost/CardGenerator/');
                exit();
            }
        }
    
        // Check if the email belongs to an organization
        $organization = $this->organizationModel->getOrganizationByEmail($email);
        if ($organization) {
            // Verify the password for organization
            if (password_verify($password, $organization['password_hash'])) {
                // Password is correct, set session variables for organization
                $_SESSION['org_id'] = $organization['org_id'];
                $_SESSION['org_name'] = $organization['org_name'];
                $_SESSION['email'] = $organization['email'];
                $_SESSION['address'] = $organization['address'];
                $_SESSION['phone'] = $organization['phone'];
                $_SESSION['logo'] = $organization['logo'];
                header('Location: http://localhost/CardGenerator/views/pages/org_dashboard.php'); // Redirect to organization dashboard
                exit();
            }
        }
    
        return false; // If login fails for both user and organization
    }

    public function updateProfile($userId, $firstName, $lastName, $email, $phone, $address) {
        return $this->userModel->updateUser ($userId, $firstName, $lastName, $email, $phone, $address);
    }
    public function updateOrganizationProfile($orgId, $orgName, $email, $address, $phone) {
        return $this->userModel->updateUser ($orgId, $orgName, $email, $address, $phone);
    }

}
?>