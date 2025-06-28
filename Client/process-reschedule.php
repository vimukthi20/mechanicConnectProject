<?php
session_start();
require '../db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'client') {
    header("Location: ../login-form.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bookingId = $_POST['booking_id'];
    $decision = $_POST['decision'];

    if ($decision === 'accept') {
        // Update booking with new date/time
        $sql = "UPDATE bookings SET 
                    requested_date = proposed_date,
                    preferred_time = proposed_time,
                    proposed_date = NULL,
                    proposed_time = NULL,
                    reschedule_reason = NULL,
                    reschedule_requested_at = NULL,
                    status = 'confirmed'
                WHERE id = ? AND client_id = ?";
    } else {
        // Reject reschedule – cancel booking
        $sql = "UPDATE bookings SET 
                    status = 'cancelled',
                    proposed_date = NULL,
                    proposed_time = NULL,
                    reschedule_reason = NULL,
                    reschedule_requested_at = NULL
                WHERE id = ? AND client_id = ?";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $bookingId, $_SESSION['user_id']);

    if ($stmt->execute()) {
        $_SESSION['message'] = $decision === 'accept' ? "Reschedule confirmed." : "Booking cancelled.";
    } else {
        $_SESSION['error'] = "Failed to process your decision.";
    }

    header("Location: client-notification.php");
    exit();
}
?>
