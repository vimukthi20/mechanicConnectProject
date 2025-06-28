<?php
session_start();
require '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['booking_id'])) {
    $bookingId = $_POST['booking_id'];

    $sql = "UPDATE bookings SET status = 'rejected' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $bookingId);
    $stmt->execute();

    $_SESSION['message'] = "Booking rejected successfully.";
    header("Location: mechanic-booking.php");
    exit();
} else {
    header("Location: mechanic-bookings.php");
    exit();
}
