<?php
include_once "../db.php";
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'client') {
    header("Location: ../login-form.php");
    exit();
}

// Fetch client details
$sql = "SELECT * FROM user_details WHERE user_id = {$_SESSION['user_id']}";
$result = mysqli_query($conn, $sql);
$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Client Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="client-dashboard.css">
</head>
<body style="background-color:#edeff2;">

<?php include_once "client-navbar.html"; ?>
<p><br><br></p>

<div class="dashboard-welcome text-white text-center mb-4">
  <h1>Welcome back, <strong><?= htmlspecialchars($row['first_name'] . " " . $row['last_name']); ?></strong></h1>
  <p>Let us help you find the best home service professionals!</p>
</div>

<div class="container-fluid mt-4">

<?php 
$client_id = $_SESSION['user_id'];
$sql_booking_counts = "
    SELECT 
        COUNT(*) AS total_bookings,
        COUNT(CASE WHEN status IN ('pending', 'confirmed') THEN 1 END) AS pending_bookings,
        COUNT(CASE WHEN status = 'completed' THEN 1 END) AS completed_bookings
    FROM bookings 
    WHERE client_id = $client_id
";


$result_counts = mysqli_query($conn, $sql_booking_counts);

if ($result_counts && mysqli_num_rows($result_counts) > 0) {
    $counts = mysqli_fetch_assoc($result_counts);
?>

  <!-- Quick Stats -->
  <div class="row text-center mb-4" >
    <div class="col-md-3">
      <div class="card p-3 shadow">
        <i class="fas fa-clipboard-list card-icon"></i>
        <h5>Total Bookings</h5>
        <p class="fw-bold"><?= $counts['total_bookings'] ?></p>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card p-3 shadow">
        <i class="fas fa-calendar-alt card-icon"></i>
        <h5>Upcoming</h5>
        <p class="fw-bold"><?= $counts['pending_bookings'] ?></p>
      </div>
    </div>
 
    <div class="col-md-3">
      <div class="card p-3 shadow">
        <i class="fas fa-check-circle card-icon"></i>
        <h5>Completed</h5>
        <p class="fw-bold"><?= $counts['completed_bookings'] ?></p>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card p-3 shadow">
        <i class="fas fa-bell card-icon"></i>
        <h5>Notifications</h5>
        <p class="fw-bold">1</p>
      </div>
    </div>
  </div>
<?php } ?>

<!-- Upcoming Bookings -->
<?php
$usql = "SELECT 
            b.*, 
            u.full_name AS mechanic_name 
        FROM 
            bookings b
        JOIN 
            user_details u ON b.mechanic_id = u.user_id
        WHERE 
            b.client_id = ?
        ORDER BY 
            b.created_at DESC";

$stmt = $conn->prepare($usql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $client_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="mb-5">
  <h2 class="mb-3">Upcoming Bookings</h2>
  <?php if ($result->num_rows > 0): ?>
    <div class="table-responsive">
      <table class="table table-bordered bg-white">
        <thead class="table-secondary">
          <tr>
            <th>Mechanic</th>
            <th>Service Type</th>
            <th>Date</th>
            <th>Time</th>
            <th>Status</th>
           
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($row['mechanic_name']) ?></td>
              <td><?= htmlspecialchars($row['service_type']) ?></td>
              <td><?= htmlspecialchars($row['requested_date']) ?></td>
              <td><?= htmlspecialchars($row['preferred_time']) ?></td>
              <td>
                <span class="badge bg-<?= $row['status'] === 'pending' ? 'warning' : ($row['status'] === 'confirmed' ? 'success' : 'secondary') ?>">
                  <?= ucfirst($row['status']) ?>
                </span>
              </td>
             
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <p class="text-muted">No upcoming bookings found.</p>
  <?php endif; ?>
</div>

<!-- Recommended Mechanics -->
<?php
$recommended_mechanic_sql = "SELECT * FROM user_details WHERE user_role = 'mechanic' LIMIT 8";
$mechanic_result = mysqli_query($conn, $recommended_mechanic_sql);
?>

<div>
  <h2 class="mb-3">Recommended Mechanics</h2>
  <div class="row recommended">
    <?php if ($mechanic_result && mysqli_num_rows($mechanic_result) > 0): ?>
      <?php while ($row_mechanic = mysqli_fetch_assoc($mechanic_result)): ?>
        <div class="col-sm-6 col-md-3 mb-4">
          <div class="card mechanic-card shadow-sm border-0 h-100">
            <img src="../mechanic/mechanic-profile-images/<?= htmlspecialchars($row_mechanic['profile_image'] ?? 'default.jpg'); ?>" class="card-img-top mechanic-img" alt="Mechanic Image">
            <div class="card-body text-center">
              <h5 class="card-title mb-1"><?= htmlspecialchars($row_mechanic['full_name']); ?></h5>
              <p class="text-muted mb-2"><?= htmlspecialchars($row_mechanic['service_category']); ?></p>
              <a href="booking-form.php?mechanic_id=<?= $row_mechanic['user_id']; ?>" class="btn btn-outline-primary btn-sm">Book Now</a>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p class="text-muted">No recommended mechanics found.</p>
    <?php endif; ?>
  </div>
</div>


<?php include_once 'footer.html'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
