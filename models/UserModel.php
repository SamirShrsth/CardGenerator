<?php
class UserModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function createUser($first_name, $last_name, $password_hash, $email, $phone, $address, $role, $profile_image) {
        $query = "INSERT INTO users (first_name, last_name, password_hash, email, phone, address, role, profile_image) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssssss", $first_name, $last_name, $password_hash, $email, $phone, $address, $role, $profile_image);

        return $stmt->execute();
    }

    public function getUserByEmail($email) {
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
    
        return $result->fetch_assoc(); // Fetch the user data
    }
}
?>
