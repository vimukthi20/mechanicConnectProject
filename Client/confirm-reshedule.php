<?php
session_start();
require '../db.php';

// Ensure client is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'client') {
    header("Location: ../login-form.php");
    exit();
}

$bookingId = $_GET['booking_id'] ?? null;

if (!$bookingId) {
    $_SESSION['error'] = "Invalid booking ID.";
    header("Location: client-notifications.php");
    exit();
}

// Fetch the booking
$sql = "SELECT * FROM bookings WHERE id = ? AND client_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $bookingId, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();

if (!$booking) {
    $_SESSION['error'] = "Booking not found.";
    header("Location: client-notifications.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Confirm Reschedule</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3>Reschedule Request</h3>
    <p><strong>Original Date:</strong> <?= htmlspecialchars($booking['requested_date']) ?></p>
    <p><strong>Original Time:</strong> <?= htmlspecialchars($booking['preferred_time']) ?></p>
    <hr>
    <p><strong>Proposed New Date:</strong> <?= htmlspecialchars($booking['proposed_date']) ?></p>
    <p><strong>Proposed New Time:</strong> <?= htmlspecialchars($booking['proposed_time']) ?></p>
    <p><strong>Reason:</strong> <?= nl2br(htmlspecialchars($booking['reschedule_reason'])) ?></p>

    <form method="post" action="process-reschedule.php" class="mt-4">
        <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">
        <button type="submit" name="decision" value="accept" class="btn btn-success">Confirm</button>
        <button type="submit" name="decision" value="reject" class="btn btn-danger">Reject</button>
    </form>
</div>
</body>
</html>
