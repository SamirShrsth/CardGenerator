<?php
$base_url = '/CardGenerator/';
?>
<header>
    <div class="logo">  
        <a href="<?php echo $base_url; ?>"><img src="<?php echo $base_url; ?>assets/img/logo/logo.png" alt=""></a>
    </div>
    <nav>
        <ul>
            <li><a href="<?php echo $base_url; ?>">Home</a></li>
            <li><a href="<?php echo $base_url; ?>">Create Card</a></li>
            <li><a href="<?php echo $base_url; ?>">My Cards</a></li>
            <li><a href="<?php echo $base_url; ?>views/pages/add_card_template.php">View Templates</a></li>
            <li><a href="<?php echo $base_url; ?>views/pages/contact.php">Contact</a></li>
        </ul>
    </nav>
    <nav>
        <?php
        if (isset($_SESSION['profile_image'])) {
            echo '<img class="user-icon" src="' . $base_url . 'assets/img/profile_images/' . htmlspecialchars($_SESSION['profile_image']) . '" alt="User Profile Image">';
            echo '<a href="' . $base_url . 'views/pages/profile.php">' . htmlspecialchars($_SESSION['first_name']) . '</a>';
            echo ' | <a href="' . $base_url . 'views/auth/logout.php">Logout</a>';
        } else {
            // If not logged in, display the "sign In" link
            echo '<a href="' . $base_url . 'views/auth/login.php">Sign In</a>';
        }
        ?>
    </nav>
</header>
