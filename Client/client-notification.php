<?php
session_start();
require '../db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'client') {
    header("Location: ../login-form.php");
    exit();
}

include_once "client-navbar.html";
$clientId = $_SESSION['user_id'];

// Fetch notifications for this client
$sql = "SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $clientId);
$stmt->execute();
$result = $stmt->get_result();

// Mark all unread notifications as read
$updateSql = "UPDATE notifications SET is_read = 1 WHERE user_id = ? AND is_read = 0";
$updateStmt = $conn->prepare($updateSql);
$updateStmt->bind_param("i", $clientId);
$updateStmt->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Notifications</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">Your Notifications</h2>

    <?php if ($result->num_rows > 0): ?>
        <ul class="list-group">
            <?php while ($row = $result->fetch_assoc()): ?>
                <li class="list-group-item d-flex justify-content-between align-items-start <?= !$row['is_read'] ? 'list-group-item-warning' : '' ?>">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold"><?= htmlspecialchars($row['type']) ?></div>
                        <?= htmlspecialchars($row['message']) ?>
                        <div class="text-muted small"><?= date('F j, Y, g:i A', strtotime($row['created_at'])) ?></div>
                    </div>
                    <?php if ($row['type'] === 'reschedule_request'): ?>
                        <a href="confirm-reshedule.php?booking_id=<?= $row['related_booking_id'] ?>" class="btn btn-sm btn-primary">Review</a>
                    <?php endif; ?>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <div class="alert alert-info">No notifications yet.</div>
    <?php endif; ?>
</div>

<?php include_once "footer.html"; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
