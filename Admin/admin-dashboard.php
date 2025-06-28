<?php
session_start();
include_once "../db.php";
//include_once "../common/middleware/auth.php"; 

// Fetch client details safely
/* $sql = "SELECT * FROM user_details WHERE user_id = {$_SESSION['user_id']}";
$result = mysqli_query($conn, $sql);
$row = $result ? mysqli_fetch_assoc($result) : null; */
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="admin-dashboard.css">
</head>
<body style="background-color:#edeff2;">

<?php include_once "admin-navbar.html"; ?>

<!-- Admin Dashboard -->
<div class="container mt-5 pt-4">
  <h1 class="mb-4 text-center">Admin Dashboard</h1>
  <div class="row g-4">

    <!-- Reports -->
    <div class="col-md-4">
      <div class="card shadow border-0 h-100">
        <div class="card-body text-center">
          <i class="bi bi-bar-chart-line-fill display-4 text-primary"></i>
          <h5 class="card-title mt-3">Reports</h5>
          <p class="card-text">View service reports, financial summaries, and analytics.</p>
          <a href="generate-report.php" class="btn btn-outline-primary">View Reports</a>
        </div>
      </div>
    </div>

    <!-- Users -->
    <div class="col-md-4">
      <div class="card shadow border-0 h-100">
        <div class="card-body text-center">
          <i class="bi bi-people-fill display-4 text-success"></i>
          <h5 class="card-title mt-3">Users</h5>
          <p class="card-text">Manage client accounts and access levels.</p>
          <a href="user-list.php" class="btn btn-outline-success">Manage Users</a>
        </div>
      </div>
    </div>

    <!-- Mechanic Registrations -->
    <div class="col-md-4">
      <div class="card shadow border-0 h-100">
        <div class="card-body text-center">
          <i class="bi bi-wrench-adjustable-circle-fill display-4 text-warning"></i>
          <h5 class="card-title mt-3">Mechanic Registrations</h5>
          <p class="card-text">Approve or reject new mechanic registrations.</p>
          <a href="mechanic-approvals.php" class="btn btn-outline-warning">Review Mechanics</a>
        </div>
      </div>
    </div>

    <!-- Payments -->
    <div class="col-md-4">
      <div class="card shadow border-0 h-100">
        <div class="card-body text-center">
          <i class="bi bi-credit-card-2-front-fill display-4 text-danger"></i>
          <h5 class="card-title mt-3">Payments</h5>
          <p class="card-text">View and manage payment transactions.</p>
          <a href="payments.php" class="btn btn-outline-danger">Manage Payments</a>
        </div>
      </div>
    </div>

    <!-- Notifications -->
    <div class="col-md-4">
      <div class="card shadow border-0 h-100">
        <div class="card-body text-center">
          <i class="bi bi-bell-fill display-4 text-info"></i>
          <h5 class="card-title mt-3">Notifications</h5>
          <p class="card-text">Send or review system notifications to users.</p>
          <a href="notifications.php" class="btn btn-outline-info">View Notifications</a>
        </div>
      </div>
    </div>


<!-- Service categories -->
<div class="col-md-4">
  <div class="card shadow border-0 h-100">
    <div class="card-body text-center">
      <i class="bi bi-gear-fill display-4 text-muted"></i>
      <h5 class="card-title mt-3">Service Categories</h5>
      <p class="card-text">Manage and organize different service categories.</p>
      <a href="manege-service-category.php" class="btn btn-outline-dark">Manage Services</a>
    </div>
  </div>
</div>



  </div>
</div>
<br>
<br>
<?php include_once "footer.html"; ?>

</body>
</html>
