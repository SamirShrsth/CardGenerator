<?php
class OrganizationModel {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function createOrganization($org_name, $email, $address, $phone, $password_hash, $logo) {
        $query = "INSERT INTO organizations (org_name, email, address, phone, password_hash, logo) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssss", $org_name, $email, $address, $phone, $password_hash, $logo);
        
        return $stmt->execute();
    }

    public function getOrganizationByEmail($email) {
        $query = "SELECT * FROM organizations WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc(); // Returns organization data as an associative array
    }
    public function updateOrganization ($orgId, $orgName, $orgEmail, $orgAddress, $orgPhone) {
        $query = "UPDATE users SET first_name = ?, last_name = ?, email = ? WHERE user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssi", $orgName, $orgEmail, $orgAddress, $orgPhone, $orgId);
        
        return $stmt->execute();
    }
}
?>