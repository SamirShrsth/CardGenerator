<?php
session_start();
if (!isset($_SESSION['org_id'])) {
    header('Location: login.php');
    exit();
}

// Organization details
$orgName = htmlspecialchars($_SESSION['org_name']);
$orgAddress = htmlspecialchars($_SESSION['address']);
$orgPhone = htmlspecialchars($_SESSION['phone']);
$orgLogo = htmlspecialchars($_SESSION['logo']);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organization Dashboard</title>
    <link rel="stylesheet" href="/CardGenerator/assets/css/style.css">
    <link rel="stylesheet" href="/CardGenerator/assets/css/org_dashboard.css">
    <link rel="stylesheet" href="/CardGenerator/assets/css/templates.css">
</head>
<body>
    <?php include '../components/header.php'; ?>

    <div class="dashboard-container">
        <?php
        // Get the current tab from the query string, default to 'dashboard'
        $current_tab = isset($_GET['tab']) ? $_GET['tab'] : 'dashboard';
        ?>
        <div class="sidebar">
            <a href="?tab=dashboard" class="<?php echo $current_tab === 'dashboard' ? 'active' : ''; ?>">
                <img src="../../assets/img/icons/icon-dashboard.png" alt="Dashboard Icon" class="sidebar-icon">
                Dashboard 
            </a>
            <a href="?tab=pending_requests" class="<?php echo $current_tab === 'pending_requests' ? 'active' : ''; ?>">
                <img src="../../assets/img/icons/icon-requests.png" alt="View Requests Icon" class="sidebar-icon">
                Pending Requests
            </a>
            <a href="?tab=accepted_cards" class="<?php echo $current_tab === 'accepted_cards' ? 'active' : ''; ?>">
                <img src="../../assets/img/icons/icon-accepted.png" alt="Accepted Cards Icon" class="sidebar-icon">
                Accepted Cards
            </a>
            <a href="?tab=create_card" class="<?php echo $current_tab === 'create_card' ? 'active' : ''; ?>">
                <img src="../../assets/img/icons/icon-create.png" alt="Create Card Icon" class="sidebar-icon">
                Create Card
            </a>
            <a href="../auth/logout.php" class="<?php echo $current_tab === 'logout' ? 'active' : ''; ?>" onclick="return confirmLogout();">
                <img src="../../assets/img/icons/icon-logout.png" alt="Logout Icon" class="sidebar-icon">
                Logout
            </a>
        </div>

        <div class="main-dashboard">
            <?php
            // Default tab
            $tab = isset($_GET['tab']) ? $_GET['tab'] : 'dashboard';

            switch ($tab) {
                case 'dashboard':
                    echo '<h1>Dashboard</h1>';
                    // Fetch and display dashboard here
                    break;
                case 'pending_requests':
                    echo '<h1>Pending Requests</h1>';

                    include './admin_tabs/pending_tab.php';

                    break;
                case 'accepted_cards':
                    echo '<h1>Accepted Cards</h1>';
                    
                    include './admin_tabs/accepted_tab.php';
                    
                    break;
                case 'create_card':
                    echo '<h1>Create Organization Card</h1>';

                    include './admin_tabs/create_tab.php';

                    break;
                default:
                    echo '<h1>Dashboard</h1>';
                    break;
            }
            ?>
        </div>
    </div>
    <script>
        function confirmLogout() {
            return confirm("Are you sure you want to logout?");
        }
    </script>
</body>
</html>