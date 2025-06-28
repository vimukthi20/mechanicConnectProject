<?php
session_start();



if (!isset($_SESSION['user_id'])) {
    // Not logged in, redirect to login
    header("Location: ../login-form.php"); // use correct relative path
    exit();
}

// Optional: check if the role matches (for extra protection)
if ($_SESSION['role'] !== 'mechanic') {
    header("Location: ../login-form.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Notifications</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body style="background-color:#edeff2;">
<?php  include_once"mechanic-navbar.html"?>
<div class="container mt-5">
  <h2 class="mb-4 text-center">Notifications</h2>

  <div class="list-group">
    <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-start">
      <div class="ms-2 me-auto">
        <div class="fw-bold">Booking Confirmed</div>
        Your booking with <strong>CoolTech AC Services</strong> is confirmed for <strong>April 20, 2025 at 10:00 AM</strong>.
      </div>
      <span class="badge bg-success rounded-pill"><i class="fas fa-check"></i></span>
    </div>

    <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-start">
      <div class="ms-2 me-auto">
        <div class="fw-bold">New Message</div>
        You have received a message from <strong>Ravi Electricals</strong>.
      </div>
      <span class="badge bg-primary rounded-pill"><i class="fas fa-envelope"></i></span>
    </div>

    <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-start">
      <div class="ms-2 me-auto">
        <div class="fw-bold">Booking Reminder</div>
        Reminder: Your plumbing service with <strong>Dinesh Plumbing Co.</strong> is tomorrow at <strong>9:00 AM</strong>.
      </div>
      <span class="badge bg-warning text-dark rounded-pill"><i class="fas fa-clock"></i></span>
    </div>

    <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-start">
      <div class="ms-2 me-auto">
        <div class="fw-bold">Cancelled Booking</div>
        Your booking with <strong>Sameera Repairs</strong> has been cancelled.
      </div>
      <span class="badge bg-danger rounded-pill"><i class="fas fa-times"></i></span>
    </div>
  </div>
</div>
<?php 
include_once "mechanic-footer.html";
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
