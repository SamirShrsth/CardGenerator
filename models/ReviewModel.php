<?php
require_once '../config/Database.php';

class ReviewModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getRandomHighRatingReviews($limit = 3) {
        $query = "SELECT name, description, rating FROM reviews WHERE rating > 3 ORDER BY RAND() LIMIT ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $limit);
        $stmt->execute();

        return $stmt->get_result();
    }
}
?>
