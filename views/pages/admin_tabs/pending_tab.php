<?php
require_once '../../config/Database.php';

// Fetch card requests for the organization
$database = new Database();
$conn = $database->getConnection();

$query = "SELECT c.card_id, u.first_name, u.last_name, c.registration_number, c.department, c.card_status 
          FROM cards c 
          JOIN users u ON c.user_id = u.user_id 
          WHERE c.org_name = ? AND c.card_status = 'pending'";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $orgName);
$stmt->execute();
$result = $stmt->get_result();

?>

<table>
    <thead>
        <tr>
            <th>Card ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Registration Number</th>
            <th>Department</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if($result->num_rows >0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['card_id']); ?></td>
                <td><?php echo htmlspecialchars($row['first_name']); ?></td>
                <td><?php echo htmlspecialchars($row['last_name']); ?></td>
                <td><?php echo htmlspecialchars($row['registration_number']); ?></td>
                <td><?php echo htmlspecialchars($row['department']); ?></td>
                <td><?php echo htmlspecialchars($row['card_status']); ?></td>
                <td class="action-buttons">
                    <a href="/CardGenerator/controllers/admin/approve_request.php?id=<?php echo $row['card_id']; ?>" class="approve">Approve</a>
                    <a href="/CardGenerator/controllers/admin/reject_request.php?id=<?php echo $row['card_id']; ?>" class="reject">Reject</a>
                </td>
            </tr>
        <?php endwhile; ?>
        <?php else: echo '<tr><td colspan="7">No requests found.</td></tr>'; endif; ?>
    </tbody>
</table>