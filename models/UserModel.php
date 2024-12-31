<?php
class UserModel {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function createUser ($first_name, $last_name, $password_hash, $email, $profile_image) {
        $query = "INSERT INTO users (first_name, last_name, password_hash, email, profile_image) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssss", $first_name, $last_name, $password_hash, $email, $profile_image);
        
        return $stmt->execute();
    }

    public function getUserByEmail($email) {
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc(); // Returns user data as an associative array
    }

    public function updateUser ($userId, $firstName, $lastName, $email) {
        $query = "UPDATE users SET first_name = ?, last_name = ?, email = ? WHERE user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssi", $firstName, $lastName, $email, $userId);
        
        return $stmt->execute();
    }
}
?>