<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StreamCard</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <script src="./assets//js//slideshow.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Akatab:wght@400;500;600;700;800;900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Akatab:wght@400;500;600;700;800;900&family=IBM+Plex+Mono:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap');
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div class="logo">
                <a href="#"><img src="./assets/img/logo/logo.png" alt=""></a>
            </div>
            <nav>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Create Card</a></li>
                    <li><a href="#">My Cards</a></li>
                    <li><a href="#">View Templates</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </nav>
            <nav>
                <img class="user-icon" src="./assets/img/icons/user.png" alt="User Not Found">
                <?php
                // Check if the session is already started
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }

                // Check if the user is logged in
                if (isset($_SESSION['username'])) {
                    // If logged in, display the username and a logout link
                    echo '<a href="#">' . $_SESSION['username'] . '</a>';
                    echo ' | <a href="./views/logout.php">Logout</a>';
                } else {
                    // If not logged in, display the "Sign In" link
                    echo '<a href="./views/login.php">Sign In</a>';
                }
                ?>
            </nav>
        </header>

        <section class="main-content">
    <div class="left-content">
        <h1>Create Your Card</h1>
        <p>Create professional and high-quality cards in a matter of minutes! Whether you need business or ID cards, our system lets you design and generate the perfect card quickly and easily. You can also request an official ID card from your institution!</p>
        <div class="home-button">
            <a href="#" class="create-card-btn">Create a Card</a>
            <a href="#" class="create-card-btn">View Templates</a>
        </div>
    </div>

    <!-- Slideshow (Right Content) -->
    <div class="right-content">
        <div class="slideshow-container">
            <div class="slide fade">
                <img src="./assets/img/templates/template1.jpg" alt="Template 1">
            </div>
            <div class="slide fade">
                <img src="./assets/img/templates/template2.jpg" alt="Template 2">
            </div>
            <div class="slide fade">
                <img src="./assets/img/templates/template3.jpg" alt="Template 3">
            </div>
            <div class="slide fade">
                <img src="./assets/img/templates/template4.jpg" alt="Template 4">
            </div>
            
            <div class="navigation-buttons">
                <!-- Next/Prev buttons below the images -->
                <a class="prev" onclick="changeSlide(-1)">&#10094;</a>
                <!-- Dots for navigation -->
                <div class="dots-container">
                    <span class="dot" onclick="setCurrentSlide(1)"></span>
                    <span class="dot" onclick="setCurrentSlide(2)"></span>
                    <span class="dot" onclick="setCurrentSlide(3)"></span>
                    <span class="dot" onclick="setCurrentSlide(4)"></span>
                </div>
                <a class="next" onclick="changeSlide(1)">&#10095;</a>
            </div>
        </div>
    </div>
</section>

        <section class="benefits-section">
            <h2>Why Choose StreamCard?</h2>
            <div class="benefits-container">
                <div class="benefit-item">
                    <img src="./assets/img/icons/icon-easy.png" alt="Easy to Use">
                    <h3>Easy to Use</h3>
                    <p>Create high-quality cards with an intuitive and user-friendly interface. No design experience needed!</p>
                </div>
                <div class="benefit-item">
                    <img src="./assets/img/icons/icon-templates.png" alt="Customizable Templates">
                    <h3>Customizable Templates</h3>
                    <p>Choose from a wide variety of professionally designed templates that are fully customizable to fit your needs.</p>
                </div>
                <div class="benefit-item">
                    <img src="./assets/img/icons/icon-fast.png" alt="Fast and Efficient">
                    <h3>Fast and Efficient</h3>
                    <p>Create your cards in minutes, whether it’s for business, personal use, or official IDs.</p>
                </div>
                <div class="benefit-item">
                    <img src="./assets/img/icons/icon-quality.png" alt="High-Quality Output">
                    <h3>High-Quality Output</h3>
                    <p>Download cards in print-ready formats with high resolution, perfect for professional use.</p>
                </div>
            </div>
        </section>

    </div>
</body>
</html>
