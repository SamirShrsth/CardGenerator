<?php
require_once '../../config/Database.php';

// Fetch card requests for the organization
$database = new Database();
$conn = $database->getConnection();

$query = "SELECT c.card_id, u.first_name, u.last_name, c.registration_number, c.department, c.card_status 
          FROM cards c 
          JOIN users u ON c.user_id = u.user_id 
          WHERE c.org_name = ? AND c.card_status = 'approved'";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $_SESSION['org_name']);
$stmt->execute();
$result = $stmt->get_result();
?>

<style>
    .status-approved {
        color: green;
        text-transform: capitalize;
    }
</style>

<table>
    <thead>
        <tr>
            <th>Card ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Registration Number</th>
            <th>Department</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php if($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['card_id']); ?></td>
                <td><?php echo htmlspecialchars($row['first_name']); ?></td>
                <td><?php echo htmlspecialchars($row['last_name']); ?></td>
                <td><?php echo htmlspecialchars($row['registration_number']); ?></td>
                <td><?php echo htmlspecialchars($row['department']); ?></td>
                <td class="status-approved"><?php echo ucfirst(htmlspecialchars($row['card_status'])); ?></td>
            </tr>
        <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="6">No approved cards found.</td></tr>
        <?php endif; ?>
    </tbody>
</table>