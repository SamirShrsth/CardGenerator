<?php
class Database {
    private $host = "localhost";
    private $db_name = "CardStream"; // Change this to your database name
    private $username = "root"; // Change this to your database username
    private $password = ""; // Change this to your database password
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);
            if ($this->conn->connect_error) {
                throw new Exception("Connection failed: " . $this->conn->connect_error);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $this->conn;
    }
}
?>
