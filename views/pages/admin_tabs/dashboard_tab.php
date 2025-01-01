<?php
require_once '../../config/Database.php';

$database = new Database();
$conn = $database->getConnection();

// Fetch organization details
$orgName = $_SESSION['org_name'];
$orgEmail = $_SESSION['email'];
$orgAddress = $_SESSION['address'];
$orgPhone = $_SESSION['phone'];
$orgLogo = $_SESSION['logo'];

// Fetch pending card requests count
$pendingQuery = "SELECT COUNT(*) AS pending_count FROM cards WHERE org_name = ? AND card_status = 'pending'";
$pendingStmt = $conn->prepare($pendingQuery);
$pendingStmt->bind_param("s", $orgName);
$pendingStmt->execute();
$pendingResult = $pendingStmt->get_result();
$pendingCount = $pendingResult->fetch_assoc()['pending_count'];

// Fetch accepted cards count
$acceptedQuery = "SELECT COUNT(*) AS accepted_count FROM cards WHERE org_name = ? AND card_status = 'approved'";
$acceptedStmt = $conn->prepare($acceptedQuery);
$acceptedStmt->bind_param("s", $orgName);
$acceptedStmt->execute();
$acceptedResult = $acceptedStmt->get_result();
$acceptedCount = $acceptedResult->fetch_assoc()['accepted_count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/CardGenerator/assets/css/style.css">
    <style>
        .dashboard-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 10px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            height: 35vh;
        }

        .dashboard-card h3 {
            margin-bottom: 15px;
            color: #333;
            font-size: 1.5rem;
        }

        .dashboard-card p {
            color: #666;
            font-size: 1rem;
        }

        .stats-container {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }

        .stat-card {
            flex: 1;
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .stat-card h4 {
            font-size: 1.2rem;
            color: #333;
            margin-bottom: 10px;
        }

        .stat-card p {
            font-size: 1.5rem;
            color: #007BFF;
            font-weight: bold;
        }

        .org-details {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .org-logo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
        }

        .org-info {
            flex: 1;
        }

        .org-info h2 {
            font-size: 1.8rem;
            color: #333;
            margin-bottom: 10px;
        }

        .org-info p {
            color: #666;
            font-size: 1rem;
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="dashboard-card">
        <div class="org-details">
            <img src="/CardGenerator/assets/img/organization_logos/<?php echo htmlspecialchars($orgLogo); ?>" alt="Organization Logo" class="org-logo">
            <div class="org-info">
                <h2><?php echo htmlspecialchars($orgName); ?></h2>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($orgEmail); ?></p>
                <p><strong>Address:</strong> <?php echo htmlspecialchars($orgAddress); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($orgPhone); ?></p>
            </div>
        </div>
    </div>
    <!-- Statistics Section -->
    <div class="dashboard-card">
        <h3>Statistics</h3>
        <div class="stats-container">
            <div class="stat-card">
                <h4>Pending Requests</h4>
                <p><?php echo htmlspecialchars($pendingCount); ?></p>
            </div>
            <div class="stat-card">
                <h4>Accepted Cards</h4>
                <p><?php echo htmlspecialchars($acceptedCount); ?></p>
            </div>
        </div>
    </div>
</body>
</html>