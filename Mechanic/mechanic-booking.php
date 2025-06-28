<?php
session_start();
require '../db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'mechanic') {
    header("Location: ../login-form.php");
    exit();
}

$mechanicId = $_SESSION['user_id'];

$sql = "SELECT b.*, u.first_name AS first_name  , u.last_name AS last_name
        FROM bookings b
        JOIN user_details u ON b.client_id = u.user_id
        WHERE b.mechanic_id = ?
        ORDER BY b.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $mechanicId);
$stmt->execute();
$result = $stmt->get_result();

$bookings = [];
while ($row = $result->fetch_assoc()) {
    $bookings[] = $row;
}
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
    <?php include_once "mechanic-navbar.html"; ?>

    <h2 class="mb-4">My Bookings</h2>

    <?php if (count($bookings) > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered bg-white">
                <thead class="table-secondary">
                <tr>
                    <th>Client</th>
                    <th>Service Type</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($bookings as $row): ?>
                    <?php
                    $status = $row['status'];
                    $showAcceptReject = $status === 'pending';
                    $showReschedule = in_array($status, ['pending', 'confirmed']);
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($row['first_name'] . " " . $row['last_name']) ?></td>
                        <td><?= htmlspecialchars($row['service_type']) ?></td>
                        <td><?= htmlspecialchars($row['requested_date']) ?></td>
                        <td><?= htmlspecialchars($row['preferred_time']) ?></td>
                        <td>
                            <span class="badge bg-<?= $status === 'pending' ? 'warning' : ($status === 'confirmed' ? 'success' : ($status === 'completed' ? 'primary' : 'secondary')) ?>">
                                <?= ucfirst($status) ?>
                            </span>
                        </td>
                        <td class="d-flex flex-wrap gap-1">
                            <?php if ($showAcceptReject): ?>
                                <!-- Accept Button -->
                                <form action="booking-accept.php" method="post">
                                    <input type="hidden" name="booking_id" value="<?= $row['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-success">Accept</button>
                                </form>

                                <!-- Reject Button -->
                                <form action="booking-reject.php" method="post">
                                    <input type="hidden" name="booking_id" value="<?= $row['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger">Reject</button>
                                </form>
                            <?php endif; ?>

                            <?php if ($showReschedule): ?>
                                <!-- Reschedule Button -->
                                <button class="btn btn-sm btn-warning"
                                        data-bs-toggle="modal" data-bs-target="#rescheduleModal<?= $row['id'] ?>">
                                    Reschedule
                                </button>
                            <?php endif; ?>

                            <!-- Details Button (always visible) -->
                            <button class="btn btn-sm btn-info"
                                    data-bs-toggle="modal" data-bs-target="#detailsModal<?= $row['id'] ?>">
                                Details
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">You have not made any bookings yet.</div>
    <?php endif; ?>
</div>

<!-- Modals -->
<?php foreach ($bookings as $row): ?>
    <!-- Details Modal -->
    <div class="modal fade" id="detailsModal<?= $row['id'] ?>" tabindex="-1" aria-labelledby="detailsLabel<?= $row['id'] ?>" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailsLabel<?= $row['id'] ?>">Booking Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Client:</strong> <?= htmlspecialchars($row['first_name']. "  " . $row['last_name']) ?></p>
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

    <!-- Reschedule Modal -->
    <div class="modal fade" id="rescheduleModal<?= $row['id'] ?>" tabindex="-1" aria-labelledby="rescheduleLabel<?= $row['id'] ?>" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" method="post" action="booking-reshedule.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="rescheduleLabel<?= $row['id'] ?>">Reschedule Booking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="booking_id" value="<?= $row['id'] ?>">
                    <div class="mb-3">
                        <label for="new_date<?= $row['id'] ?>" class="form-label">New Date</label>
                        <input type="date" class="form-control" name="new_date" id="new_date<?= $row['id'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_time<?= $row['id'] ?>" class="form-label">New Time</label>
                        <input type="time" class="form-control" name="new_time" id="new_time<?= $row['id'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="reschedule_reason<?= $row['id'] ?>" class="form-label">Reason (optional)</label>
                        <textarea class="form-control" name="reschedule_reason" id="reschedule_reason<?= $row['id'] ?>"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
<?php endforeach; ?>

<?php include_once "mechanic-footer.html"; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
