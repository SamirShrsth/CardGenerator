<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StreamCard</title>
    <link rel="stylesheet" href="/CardGenerator/assets/css/style.css">
    <script src="./assets//js//slideshow.js"></script>
    <script src="./assets/js/viewMore.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Akatab:wght@400;500;600;700;800;900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Akatab:wght@400;500;600;700;800;900&family=IBM+Plex+Mono:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap');
    </style>
</head>
<body>
    <div class="container">
        <?php include './components/header.php'; ?>
        <?php include './components/main-content.php'; ?>
        <?php include './components/templates.php'; ?>
        <?php include './components/benefits.php'; ?>
        <?php include './components/testimonials.php'; ?>
        <?php include './components/review.php'; ?>
        <?php include './components/footer.php'; ?>
    </div>
</body>
</html>
