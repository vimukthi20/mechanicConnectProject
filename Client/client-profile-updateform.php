<?php
session_start();
require '../db.php';

// Show PHP errors for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check if client is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'client') {
    header("Location: ../login-form.php");
    exit();
}

$clientId = $_SESSION['user_id'];

// Get user details
$stmtDetails = $conn->prepare("SELECT * FROM user_details WHERE user_id = ?");
$stmtDetails->bind_param("i", $clientId);
$stmtDetails->execute();
$resultDetails = $stmtDetails->get_result();
$clientDetails = $resultDetails->fetch_assoc();

// Get email from users table
$stmtEmail = $conn->prepare("SELECT email FROM users WHERE id = ?");
$stmtEmail->bind_param("i", $clientId);
$stmtEmail->execute();
$resultEmail = $stmtEmail->get_result();
$clientEmail = $resultEmail->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3>Edit Your Profile</h3>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" action="client-profile-update.php">
  <!-- your inputs -->
  
  <div class="mb-3">
            <label>First Name</label>
            <input type="file" name="profile_image" accept="image/*" />
                 
        </div>
        <div class="mb-3">
            <label>First Name</label>
            <input type="text" name="first_name" class="form-control"
                   value="<?php echo htmlspecialchars($clientDetails['first_name']); ?>" required>
        </div>

        <div class="mb-3">
            <label>Last Name</label>
            <input type="text" name="last_name" class="form-control"
                   value="<?php echo htmlspecialchars($clientDetails['last_name']); ?>" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" class="form-control"
                   value="<?php echo htmlspecialchars($clientEmail['email']); ?>" readonly>
        </div>

        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control"
                   value="<?php echo htmlspecialchars($clientDetails['phone']); ?>" required>
        </div>

        <div class="mb-3">
            <label>Location</label>
            <input type="text" name="location" class="form-control"
                   value="<?php echo htmlspecialchars($clientDetails['address']); ?>">
        </div>

        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
</div>
</body>
</html>
