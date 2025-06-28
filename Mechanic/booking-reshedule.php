<?php
session_start();
require '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bookingId = $_POST['booking_id'];
    $newDate = $_POST['new_date'];
    $newTime = $_POST['new_time'];
    $reason = $_POST['reschedule_reason'] ?? null;

    // Fetch client ID
    $clientId = null;
    $getClient = $conn->prepare("SELECT client_id FROM bookings WHERE id = ?");
    $getClient->bind_param("i", $bookingId);
    $getClient->execute();
    $getClient->bind_result($clientId);
    $getClient->fetch();
    $getClient->close();

    // Update booking with proposed date/time
    $sql = "UPDATE bookings 
            SET proposed_date = ?, proposed_time = ?, status = 'reschedule_pending', reschedule_reason = ?, reschedule_requested_at = NOW()
            WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $newDate, $newTime, $reason, $bookingId);

    if ($stmt->execute()) {
        // Insert notification for client
        $msg = "Your mechanic proposed a new time for your booking. Please confirm or reject.";
        $notif = $conn->prepare("INSERT INTO notifications (user_id, related_booking_id, type, message) VALUES (?, ?, 'reschedule_request', ?)");
        $notif->bind_param("iis", $clientId, $bookingId, $msg);
        $notif->execute();
        $notif->close();

        $_SESSION['message'] = "Reschedule request sent. Awaiting client's confirmation.";
    } else {
        $_SESSION['error'] = "Failed to send reschedule request.";
    }

    header("Location: mechanic-booking.php");
    exit();
}
