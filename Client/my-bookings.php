<?php
session_start();
require '../db.php';

// Ensure user is logged in and is a client
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'client') {
    header("Location: ../login-form.php");
    exit();
}

$clientId = $_SESSION['user_id'];

// Use JOIN to fetch mechanic name along with booking details
$sql = "SELECT 
            b.*, 
            u.full_name AS mechanic_name 
        FROM 
            bookings b
        JOIN 
            user_details u ON b.mechanic_id = u.user_id
        WHERE 
            b.client_id = ?
        ORDER BY 
            b.created_at DESC";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $clientId);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Bookings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <?php include_once "client-navbar.html"; ?>
    
    <h2 class="mb-4">My Bookings</h2>

    <?php if ($result->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered bg-white">
                <thead class="table-secondary">
                    <tr>
                        <th>Mechanic</th>
                        <th>Service Type</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['mechanic_name']) ?></td>
                        <td><?= htmlspecialchars($row['service_type']) ?></td>
                        <td><?= htmlspecialchars($row['requested_date']) ?></td>
                        <td><?= htmlspecialchars($row['preferred_time']) ?></td>
                        <td>
                            <span class="badge bg-<?= $row['status'] === 'pending' ? 'warning' : ($row['status'] === 'confirmed' ? 'success' : 'secondary') ?>">
                                <?= ucfirst($row['status']) ?>
                            </span>
                        </td>
                        <td>
                            <!-- Button to trigger modal -->
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailsModal<?= $row['id'] ?>">View Details</button>
                        </td>
                    </tr>

                    <!-- Modal for booking details -->
                    <div class="modal fade" id="detailsModal<?= $row['id'] ?>" tabindex="-1" aria-labelledby="detailsLabel<?= $row['id'] ?>" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="detailsLabel<?= $row['id'] ?>">Booking Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Mechanic:</strong> <?= htmlspecialchars($row['mechanic_name']) ?></p>
                                    <p><strong>Service Type:</strong> <?= htmlspecialchars($row['service_type']) ?></p>
                                    <p><strong>Job Description:</strong> <?= nl2br(htmlspecialchars($row['job_description'])) ?></p>
                                    <p><strong>Phone:</strong> <?= htmlspecialchars($row['phone']) ?></p>
                                    <p><strong>Location:</strong> <?= htmlspecialchars($row['location']) ?></p>
                                    <p><strong>Requested Date:</strong> <?= htmlspecialchars($row['requested_date']) ?></p>
                                    <p><strong>Preferred Time:</strong> <?= htmlspecialchars($row['preferred_time']) ?></p>
                                    <p><strong>Flexible Timing:</strong> <?= htmlspecialchars($row['time_flexibility']) ?></p>
                                    <p><strong>Status:</strong> <?= ucfirst($row['status']) ?></p>
                                    <p><strong>Submitted At:</strong> <?= date('F j, Y, g:i A', strtotime($row['created_at'])) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">You have not made any bookings yet.</div>
    <?php endif; ?>
</div>

<?php include_once "footer.html"; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
