<?php
require_once '../models/ReviewModel.php';

$reviewModel = new ReviewModel();
$reviews = $reviewModel->getRandomHighRatingReviews(); 
?>
<style>
    .user-rating {
        color: gold;
    }

    .star {
        color: gold;
        font-size: 24px;
    }

    .empty-star {
        color: lightgray;
        font-size: 24px;
    }
</style>
<div class="testimonials-section">
    <h2>What Our Users Say</h2>
    <div class="testimonials-container">
        <?php if ($reviews->num_rows > 0): ?>
            <?php while ($row = $reviews->fetch_assoc()): ?>
                <div class="testimonial-item">
                    <img src="./assets/img/icons/icon-user.png" alt="User" class="user-icon">
                    <p><?php echo htmlspecialchars($row['description']); ?></p>
                    <h3>- <?php echo htmlspecialchars($row['name']); ?></h3>
                    <div class="user-rating">
                        <?php 
                        $rating = (int)$row['rating'];
                        for ($i = 1; $i <= 5; $i++):
                            if ($i <= $rating):
                                echo '<span class="star">★</span>';
                            else:
                                echo '<span class="empty-star">★</span>';
                            endif;
                        endfor; 
                        ?>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No reviews available at this time.</p>
        <?php endif; ?>
    </div>
</div>
