<?php
session_start();
?>

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
        <?php
        // Check if the user is logged in
        if (isset($_SESSION['profile_image'])) {
            // Display the user's profile image
            echo '<img class="user-icon" src="./assets/img/profile_images/' . htmlspecialchars($_SESSION['profile_image']) . '" alt="User Profile Image">';
            echo '<a href="./views/profile.php">' . htmlspecialchars($_SESSION['first_name']) . '</a>';
            echo ' | <a href="./views/logout.php">Logout</a>';
        } else {
            // If not logged in, display the "Sign In" link
            echo '<a href="./views/login.php">Sign In</a>';
        }
        ?>
    </nav>
</header>
