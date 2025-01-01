<?php
session_start();
require_once '../../config/Database.php';

// Fetch card details for the logged-in user
$database = new Database();
$conn = $database->getConnection();

$query = "
    SELECT c.card_id, c.card_status, ct.front_image, ct.back_image, ct.orientation, 
           c.first_name, c.last_name, c.registration_number, c.department, 
           c.org_name, c.org_logo, c.org_address, c.org_phone, c.profile_image
    FROM cards c
    JOIN card_templates ct ON c.template_id = ct.template_id
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
    <link rel="stylesheet" href="/CardGenerator/assets/css/create_card.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
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
                            <!-- Front Side: User Information -->
                            <div id="cardFront<?php echo $row['card_id']; ?>" class="flip-card-front" style="background-image: url('/CardGenerator/controllers/<?php echo htmlspecialchars($row['front_image']); ?>');">
                                <div class="card <?php echo $row['orientation'] == 'portrait' ? 'portrait' : 'landscape'; ?>">
                                    <h2>ID CARD</h2>
                                    <div class="user-info">
                                        <img src="/CardGenerator/assets/img/profile_images/<?php echo htmlspecialchars($row['profile_image']); ?>" alt="Profile Image" class="user-image">
                                        <div class="user-data">
                                            <h4><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></h4>
                                            <p>Registration: <?php echo htmlspecialchars($row['registration_number']); ?></p>
                                            <p>Department: <?php echo htmlspecialchars($row['department']); ?></p>
                                        </div>
                                    </div>
                                    <div class="barcode">
                                        <img src="../../assets/img/logo/barcode.png" alt="">
                                    </div>
                                </div>
                            </div>

                            <!-- Back Side: Organization Information -->
                            <div id="cardBack<?php echo $row['card_id']; ?>" class="flip-card-back" style="background-image: url('/CardGenerator/controllers/<?php echo htmlspecialchars($row['back_image']); ?>');">
                                <div class="card <?php echo $row['orientation'] == 'portrait' ? 'portrait' : 'landscape'; ?>">
                                    <div class="note">
                                        <h2>Note</h2>
                                        <p>This card is the property of <?php echo htmlspecialchars($row['org_name']); ?>. The card holder has full responsibility of the card.</p>
                                        <h2>If this card is found, please return it to the respective organization.</h2>
                                    </div>
                                    <div class="org-info">
                                        <img src="/CardGenerator/assets/img/organization_logos/<?php echo htmlspecialchars($row['org_logo']); ?>" alt="Organization Logo" class="org-logo">
                                        <div class="org-data">
                                            <h4><?php echo htmlspecialchars($row['org_name']); ?></h4>
                                            <p>Address: <?php echo htmlspecialchars($row['org_address']); ?></p>
                                            <p>Phone: <?php echo htmlspecialchars($row['org_phone']); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p>Status: <?php echo htmlspecialchars($row['card_status']); ?></p>
                    <?php if ($row['card_status'] == 'pending'): ?>
                        <p style="color: blue;">Your card request is pending approval.</p>
                    <?php elseif ($row['card_status'] == 'rejected'): ?>
                        <p style="color:red;">Your card has been rejected by the organization.</p>
                    <?php elseif ($row['card_status'] == 'approved'): ?>
                        <p style="color: green;">Your card has been approved.</p>
                        <button class="download-button" onclick="downloadCard('<?php echo $row['card_id']; ?>', 'cardFront<?php echo $row['card_id']; ?>')">Download Front Side</button>
                        <button class="download-button" onclick="downloadCard('<?php echo $row['card_id']; ?>', 'cardBack<?php echo $row['card_id']; ?>')">Download Back Side</button>
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
        // Function to download a card side as an image
        function downloadCard(cardId, elementId) {
            const flipCard = document.querySelector(`#${elementId}`).closest('.flip-card');
            const flipCardInner = flipCard.querySelector('.flip-card-inner');

            // Flip the card to the back side if necessary
            if (elementId.includes('Back')) {
                flipCardInner.style.transform = 'rotateY(180deg)';
            } else {
                flipCardInner.style.transform = '';
            }

            // Wait for the flip animation to complete
            setTimeout(() => {
                const elementToDownload = document.querySelector(`#${elementId}`);
                // Add a CSS transform to flip the image back to its original state
                elementToDownload.style.transform = 'rotateY(0deg)';
                // Set the direction of the text to left to right
                elementToDownload.style.direction = 'ltr';
                html2canvas(elementToDownload).then(canvas => {
                    const link = document.createElement('a');
                    link.download = `${cardId}_${elementId}.png`;
                    link.href = canvas.toDataURL('image/png');
                    link.click();

                    // Flip the card back to its original state
                    if (elementId.includes('Back')) {
                        flipCardInner.style.transform = '';
                    } else {
                        flipCardInner.style.transform = 'rotateY(180deg)';
                    }
                    // Remove the CSS transform and direction
                    elementToDownload.style.transform = '';
                    elementToDownload.style.direction = '';
                });
            }, 600); // Wait for 600ms to allow the flip animation to complete
        }
    </script>

    <style>
        .download-button {
            padding: 10px 20px;
            margin: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .download-button:hover {
            background-color: #45a049;
        }
    </style>
</body>
</html>
