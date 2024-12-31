<?php
session_start();
require_once '../../config/Database.php';

// Fetch profile image for the logged-in user
$database = new Database();
$conn = $database->getConnection();

$query = "SELECT c.card_id, c.card_status, c.card_front_image, c.card_back_image 
          FROM cards c 
          WHERE c.user_id = ? AND c.card_status != 'pending_request'";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cards</title>
    <link rel="stylesheet" href="/CardGenerator/assets/css/style.css">
    <link rel="stylesheet" href="/CardGenerator/assets/css/my_cards.css">
</head>
<body>
    <?php include '../components/header.php'; ?>
    <div class="container">
        <h2>My Cards</h2>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="card-container">
                    <div class="flip-card">
                        <div class="flip-card-inner">
                            <div class="flip-card-front">
                                <!-- Display the card front image -->
                                <img src="data:image/png;base64,<?php echo $row['card_front_image']; ?>" alt="Card Front">
                            </div>
                            <div class="flip-card-back">
                                <!-- Display the card back image -->
                                <img src="data:image/png;base64,<?php echo $row['card_back_image']; ?>" alt="Card Back">
                            </div>
                        </div>
                    </div>
                    <p>Status: <?php echo htmlspecialchars($row['card_status']); ?></p>
                    <?php if ($row['card_status'] == 'pending'): ?>
                        <p>Pending approval from the organization.</p>
                    <?php elseif ($row['card_status'] == 'rejected'): ?>
                        <p>Rejected by the organization.</p>
                    <?php elseif ($row['card_status'] == 'approved'): ?>
                        <a href="/CardGenerator/controllers/download_card.php?card_id=<?php echo htmlspecialchars($row['card_id']); ?>" class="download-button">Download Card</a>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No cards found.</p>
        <?php endif; ?>
    </div>

    <script>
        // Add flipping functionality
        const flipCards = document.querySelectorAll('.flip-card');
        flipCards.forEach(card => {
            card.addEventListener('click', function() {
                const inner = this.querySelector('.flip-card-inner');
                inner.style.transform = inner.style.transform === 'rotateY(180deg)' ? '' : 'rotateY(180deg)';
            });
        });
    </script>
</body>
</html>