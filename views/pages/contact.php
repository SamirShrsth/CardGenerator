<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="/CardGenerator/assets/css/style.css"> 
    <link rel="stylesheet" href="/CardGenerator/assets/css/contact.css"> 
</head>
<body>
    <?php include '../components/header.php'; ?>

    <section class="contact-section">
        <h2>Contact Us</h2>
        <p>If you have any questions, feel free to reach out to us by filling out the form below.</p>

        <?php if (isset($_GET['success'])): ?>
            <p class="success-message">Your message has been sent successfully!</p>
        <?php elseif (isset($_GET['error'])): ?>
            <p class="error-message">There was an error sending your message. Please try again.</p>
        <?php endif; ?>

        <div class="contact-form-container">
            <div class="form-left">
            </div>
            <div class="form-right">
                <form class="contact-form" method="POST" action="../../controllers/ContactController.php">
                    <div class="form-group">
                        <label for="name">Your Name</label>
                        <input type="text" id="name" name="name" placeholder="Enter your name" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Your Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email" required>
                    </div>

                    <div class="form-group">
                        <label for="message">Your Message</label>
                        <textarea id="message" name="message" rows="6" placeholder="Write your message" required></textarea>
                    </div>

                    <button type="submit" class="contact-submit-btn">Send Message</button>
                </form>
            </div>
        </div>
    </section>
</body>
</html>
