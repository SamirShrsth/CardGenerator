<?php
require_once '../../config/Database.php';

// Ensure the user is logged in and is an organization
if (!isset($_SESSION['org_id'])) {
    header('Location: ../auth/login.php');
    exit();
}

$org_id = $_SESSION['org_id'];

// Fetch organization name
$database = new Database();
$conn = $database->getConnection();
$query = "SELECT org_name FROM organizations WHERE org_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $org_id);
$stmt->execute();
$stmt->bind_result($org_name);
$stmt->fetch();
$stmt->close();

// Fetch contact information for the organization
$query = "SELECT name, email, message FROM contacts WHERE organization_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $org_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="contacts-tab">
    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['message']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No contact information found.</p>
    <?php endif; ?>
</div>

<?php
$stmt->close();
$conn->close();
?>