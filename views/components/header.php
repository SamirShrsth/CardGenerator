<?php
$base_url = '/CardGenerator/';
?>
<header>
    <div class="logo">  
        <a href="<?php echo $base_url; ?>"><img src="<?php echo $base_url; ?>assets/img/logo/logo.png" alt=""></a>
    </div>
    <div class="menu-toggle" id="mobile-menu">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
    </div>
    <nav>
        <ul class="nav-list">
            <li><a href="<?php echo $base_url; ?>">Home</a></li>
            <li><a href="<?php echo $base_url; ?>">Create Card</a></li>
            <li><a href="<?php echo $base_url; ?>">My Cards</a></li>

            <li class="dropdown">
                <a href="javascript:void(0)" class="dropbtn">Templates</a>
                <div class="dropdown-content">
                    <a href="<?php echo $base_url; ?>views/pages/view_templates.php">View Templates</a>
                    <a href="<?php echo $base_url; ?>views/pages/add_card_template.php">Add Template</a>
                </div>
            </li>

            <li><a href="<?php echo $base_url; ?>views/pages/contact.php">Contact</a></li>
        </ul>
    </nav>
    <nav class="user-nav">
        <?php
        if (isset($_SESSION['profile_image'])) {
            echo '<img class="user-icon" src="' . $base_url . 'assets/img/profile_images/' . htmlspecialchars($_SESSION['profile_image']) . '" alt="User Profile Image">';
            echo '<a href="' . $base_url . 'views/pages/profile.php">' . htmlspecialchars($_SESSION['first_name']) . '</a>';
            echo '<span>|</span>';
            echo ' | <a href="' . $base_url . 'views/auth/logout.php">Logout</a>';
        } else {
            echo '<a href="' . $base_url . 'views/auth/login.php">Sign In</a>';
        }
        ?>
    </nav>
</header>
<script>
    const mobileMenu = document.getElementById('mobile-menu');
    const nav = document.querySelector('nav');

    mobileMenu.addEventListener('click', () => {
        nav.classList.toggle('active');
    });
</script>

