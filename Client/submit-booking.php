<?php
session_start();
require '../db.php'; // Adjust if needed

// Ensure user is logged in and is a client
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'client') {
    header("Location: ../login-form.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clientId = $_SESSION['user_id'];
    $mechanicId = intval($_POST['mechanic_id']);
    $serviceType = trim($_POST['service_type']);
    $phone = trim($_POST['phone']);
    $location = trim($_POST['location']);
    $preferredTime = trim($_POST['preferred_time']);
    $requestedDate = trim($_POST['requested_date']);
    $jobDescription = trim($_POST['job_description']);
    $timeFlexibility = $_POST['time_flexibility'];
    $status = "pending";
    $created_at = date('Y-m-d H:i:s');  // format for MySQL DATETIME

    if ($mechanicId <= 0 || empty($serviceType) || empty($phone) || empty($location) || empty($preferredTime) || empty($requestedDate) || empty($timeFlexibility)) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: booking-form.php?mechanic_id=$mechanicId");
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO bookings (client_id, mechanic_id, service_type, job_description, phone, location, preferred_time, requested_date, time_flexibility, status, created_at) VALUES (?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iisssssssss", $clientId, $mechanicId, $serviceType, $jobDescription, $phone, $location, $preferredTime, $requestedDate, $timeFlexibility ,$status, $created_at);

    try {
        $stmt->execute();
        $_SESSION['success'] = "Booking request submitted successfully!";
        header("Location: my-bookings.php");
        exit();
    } catch (Exception $e) {
        error_log("Booking error: " . $e->getMessage());
        $_SESSION['error'] = "Something went wrong. Please try again.";
        header("Location: booking-form.php?mechanic_id=$mechanicId");
        exit();
    }
} else {
    header("Location: ../client-dashboard.php");
    exit();
}
