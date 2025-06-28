<?php

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page
    header("Location: login.php");
    exit();
}


include_once "../db.php";

$sql = "SELECT * FROM user_details WHERE user_id = {$_SESSION['user_id']}";
$result = mysqli_query($conn, $sql);
$row = $result->fetch_assoc();

// fectch the email
$qemail = "SELECT * FROM users WHERE id = {$_SESSION['user_id']}";
$eresult = mysqli_query($conn, $qemail);
$erow = $eresult->fetch_assoc();



$fullName = $row['first_name'] . " " . $row['last_name'];
$email = $erow['email'];
$phone = $row['phone'];
$profileImage = $row['profile_image']; 
$mobileVerified = true;
$emailVerified = true;
$address = $row['address'];
$preferences = "Prefers morning appointments"; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - Mechanic Connect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="client-profile.css">
    <style>
        body {
            
            color: #333;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
        }
        .profile-container {
            margin-top: 80px; /* Adjust for fixed navbar */
        }
        .profile-card {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            border-radius: 0.75rem;
            overflow: hidden;
            background-color: #fff;
        }
        .profile-header {
            background-color:#f7b40a;
            color: #fff;
            padding: 2rem;
            text-align: center;
        }
        .profile-avatar-lg {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 5px solid #fff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            margin-bottom: 1rem;
        }
        .profile-info {
            padding: 2rem;
        }
        .profile-info h3 {
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }
        .profile-info p {
            color: #777;
            margin-bottom: 1rem;
        }
        .form-label {
            font-weight: bold;
            color: #343a40;
        }
        .form-control {
            border-radius: 0.5rem;
            border: 1px solid #ced4da;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
        }
        .btn-primary {
            background-color: #28a745;
            border: none;
            border-radius: 0.5rem;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #1e7e34;
        }
        .btn-secondary {
            background-color: #6c757d;
            border: none;
            border-radius: 0.5rem;
            transition: background-color 0.3s ease;
        }
        .btn-secondary:hover {
            background-color: #545b62;
        }
        .account-status {
            padding: 2rem;
            background-color: #f8f9fa;
            border-top: 1px solid #eee;
        }
        .status-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.75rem;
        }
        .status-item .badge {
            border-radius: 0.5rem;
            font-weight: normal;
        }
        .verification-icon {
            color: #28a745; /* Green for verified */
            margin-left: 0.5rem;
        }
        .unverified-icon {
            color: #dc3545; /* Red for unverified */
            margin-left: 0.5rem;
        }
        .edit-section {
            display: none; /* Initially hidden */
            padding: 2rem;
            background-color: #f8f9fa;
            border-top: 1px solid #eee;
        }
        .edit-button-container {
            padding: 2rem;
            text-align: right;
        }
        .profile_image{
            width:300px;
            height:300px;
            border-radius: 50%;
        }
    </style>
</head>
<body style="background-color:#edeff2;">

<?php include_once "client-navbar.html"; ?>

<div class="container profile-container mt-5">
    <div class="card profile-card shadow">
        <div class="profile-header">
            <img src="./client-profile-images/<?php echo $row['profile_image']; ?>" class="profile_image">

            <h3 id="display-name"><?= htmlspecialchars($fullName) ?></h3>
            <p id="display-email"><i class="fas fa-envelope me-2"></i> <?= htmlspecialchars($email) ?></p>
        </div>
        <div class="profile-info">
            <h4 class="mb-3"><i class="fas fa-user me-2"></i> Personal Information</h4>
            <div id="display-info">
                <p><i class="fas fa-signature me-2"></i> <span id="display-full-name"><?= htmlspecialchars($fullName) ?></span></p>
                <p><i class="fas fa-phone me-2"></i> <span id="display-phone"><?= htmlspecialchars($phone) ?></span></p>
                <p><i class="fas fa-map-marker-alt me-2"></i> <span id="display-address"><?= htmlspecialchars($address) ?></span></p>
                <p><i class="fas fa-heart me-2"></i> <span id="display-preferences"><?= htmlspecialchars($preferences) ?></span></p>
            </div>
            <form id="edit-form" style="display: none;">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label"><i class="fas fa-signature me-2"></i> Full Name</label>
                        <input type="text" class="form-control" id="name" value="<?= htmlspecialchars($fullName) ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label"><i class="fas fa-envelope me-2"></i> Email</label>
                        <input type="email" class="form-control" id="email" value="<?= htmlspecialchars($email) ?>" disabled>
                    </div>
                    <div class="col-md-6">
                        <label for="phone" class="form-label"><i class="fas fa-phone me-2"></i> Phone</label>
                        <input type="text" class="form-control" id="phone" value="<?= htmlspecialchars($phone) ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="password" class="form-label"><i class="fas fa-lock me-2"></i> New Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Leave blank to keep current">
                    </div>
                    <div class="col-md-6">
                        <label for="address" class="form-label"><i class="fas fa-map-marker-alt me-2"></i> Address</label>
                        <input type="text" class="form-control" id="address" value="<?= htmlspecialchars($address) ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="preferences" class="form-label"><i class="fas fa-heart me-2"></i> Preferences</label>
                        <input type="text" class="form-control" id="preferences" placeholder="e.g., Morning appointments, specific instructions">
                    </div>
                </div>

                <div class="mt-4">
                    <button type="button" class="btn btn-primary" onclick="saveChanges()">
                        <i class="fas fa-save me-2"></i> Save Changes
                    </button>
                    <button type="button" class="btn btn-secondary ms-2" onclick="toggleEdit()">
                        <i class="fas fa-times me-2"></i> Cancel
                    </button>
                </div>
            </form>
        </div>
        <div class="account-status">
            <h4 class="mb-3"><i class="fas fa-check-circle me-2"></i> Account Status</h4>
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <i class="fas fa-mobile-alt me-2"></i> Mobile Verified
                    <?php if ($mobileVerified): ?>
                        <span class="badge bg-success"><i class="fas fa-check verification-icon"></i> Yes</span>
                    <?php else: ?>
                        <span class="badge bg-danger"><i class="fas fa-times unverified-icon"></i> No</span>
                    <?php endif; ?>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <i class="fas fa-envelope me-2"></i> Email Verified
                    <?php if ($emailVerified): ?>
                        <span class="badge bg-success"><i class="fas fa-check verification-icon"></i> Yes</span>
                    <?php else: ?>
                        <span class="badge bg-danger"><i class="fas fa-times unverified-icon"></i> No</span>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
        <div class="edit-button-container">
  <button type="button" class="btn btn-outline-primary" onclick="window.location.href='client-profile-updateform.php'">
    <i class="fas fa-edit me-2"></i> Edit Profile
  </button>
</div>

    </div>
</div>

<?php include_once 'footer.html' ?>


   

</body>
</html>