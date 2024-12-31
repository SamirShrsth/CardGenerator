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
            <li><a href="<?php echo $base_url; ?>views/pages/create_card.php" id="requestCardLink">Request Card</a></li>
            <li><a href="<?php echo $base_url; ?>views/pages/view_templates.php">View Templates</a></li>
            <li><a href="<?php echo $base_url; ?>views/pages/add_card_template.php" id="addTemplateLink">Add Template</a></li>
            <li><a href="<?php echo $base_url; ?>views/pages/contact.php">Contact</a></li>
        </ul>
    </nav>
    <nav class="user-nav">
        <?php
        if (isset($_SESSION['profile_image'])) {
            echo '<img class="user-icon" src="' . $base_url . 'assets/img/profile_images/' . htmlspecialchars($_SESSION['profile_image']) . '" alt="User   Profile Image">';
            echo '<a href="' . $base_url . 'views/pages/profile.php">' . htmlspecialchars($_SESSION['first_name']) . '</a>';
            echo '<span>|</span>';
            echo ' | <a href="' . $base_url . 'views/auth/logout.php">Logout</a>';
        } elseif (isset($_SESSION['logo'])) {
            echo '<img class="user-icon" src="' . $base_url . 'assets/img/organization_logos/' . htmlspecialchars($_SESSION['logo']) . '" alt="User   Profile Image">';
            echo '<a href="' . $base_url . 'views/pages/organization_profile.php">' . htmlspecialchars($_SESSION['org_name']) . '</a>';
            echo '<span>|</span>';
            echo ' | <a class="logout" href="' . $base_url . 'views/auth/logout.php">Logout</a>';
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

    // Add event listener for the "Request Card" link
    document.getElementById('requestCardLink').addEventListener('click', function(event) {
        <?php if (!isset($_SESSION['user_id']) && !isset($_SESSION['org_id'])): ?>
            event.preventDefault(); // Prevent the default link behavior
            alert("You need to log in to request a card."); // Show an alert message
            window.location.href = "<?php echo $base_url; ?>views/auth/login.php"; // Redirect to the login page
        <?php endif; ?>
    });

    // Add event listener for the "Add Template" link
    document.getElementById('addTemplateLink').addEventListener('click', function(event) {
        <?php if (!isset($_SESSION['user_id']) && !isset($_SESSION['org_id'])): ?>
            event.preventDefault(); // Prevent the default link behavior
            alert("You need to log in to add a template."); // Show an alert message
            window.location.href = "<?php echo $base_url; ?>views/auth/login.php"; // Redirect to the login page
        <?php endif; ?>
    });
</script>