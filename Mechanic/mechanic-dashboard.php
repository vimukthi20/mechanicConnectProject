<?php
include_once "../db.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login-form.php");
    exit();
}

if ($_SESSION['role'] !== 'mechanic') {
    header("Location: ../login-form.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Mechanic Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
  <style>
    html, body {
      height: 100%;
    }
    body {
      display: flex;
      flex-direction: column;
      padding-top: 70px;
    }
    .container {
      flex: 1 0 auto;
    }
    footer {
      flex-shrink: 0;
    }
    .card {
      border-radius: 12px;
    }
    .profile-img {
      width: 80px;
      height: 80px;
      object-fit: cover;
    }
    .availability-text {
      font-weight: bold;
    }
    .star {
      color: gold;
    }
  </style>
</head>
<body style="background-color:#edeff2;">

<!-- 🌐 Navbar -->
<?php include_once "mechanic-navbar.html"; ?>

<?php 
$sql = "SELECT * FROM user_details WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
?>

<!-- 🔧 Dashboard Content -->
<div class="container-fluid mt-4">
  <h2 class="mb-4">Mechanic Dashboard</h2>

  <div class="row g-4">
    <!-- Profile & Stats -->
    <div class="col-lg-4">
      <div class="card shadow-sm text-center p-3">
        <img src="./mechanic-profile-images/<?= htmlspecialchars($row['profile_image']) ?>" class="rounded-circle profile-img mx-auto mb-3" alt="Profile Image">
        <h5><?= htmlspecialchars($row['full_name']) ?></h5>
        <p class="text-muted mb-1"><?= htmlspecialchars($row['service_category']) . " - " .  htmlspecialchars($row['experience']) . " years Experience" ?></p>
        <p class="text-muted"><i class="bi bi-geo-alt"></i> <?= htmlspecialchars($row['address']) ?></p>

        <div class="form-check form-switch d-flex justify-content-center align-items-center gap-2">
          <input class="form-check-input" type="checkbox" id="availabilitySwitch">
          <label class="form-check-label availability-text text-danger" id="availabilityLabel">Not Available</label>
        </div>

        <div class="d-grid mt-3">
          <button class="btn btn-outline-primary mb-2" onclick="window.location.href='update-profile-form.php'">Edit Profile</button>
          <button class="btn btn-outline-secondary">Add New Service</button>
        </div>
      </div>

      <!-- Stats -->
      <div class="row text-center mt-4">
        <div class="col-4">
          <div class="card shadow-sm p-3">
            <h5>27</h5>
            <small class="text-muted">Jobs</small>
          </div>
        </div>
        <div class="col-4">
          <div class="card shadow-sm p-3">
            <h5>Rs. 75k</h5>
            <small class="text-muted">Earnings</small>
          </div>
        </div>
        <div class="col-4">
          <div class="card shadow-sm p-3">
            <h5>4.8</h5>
            <small class="text-muted">Rating</small>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Panel -->
    <div class="col-lg-8">
      <!-- Bookings Table -->
      <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
          Upcoming Bookings
        </div>
        <div class="card-body">
        <?php
        $mechanicId = $_SESSION['user_id'];
        $bsql = "SELECT b.*, u.first_name AS client_name 
                FROM bookings b
                JOIN user_details u ON b.client_id = u.user_id
                WHERE b.mechanic_id = ? AND b.status IN ('pending', 'confirmed')
                ORDER BY b.created_at DESC";

        $stmt = $conn->prepare($bsql);
        $stmt->bind_param("i", $mechanicId);
        $stmt->execute();
        $result = $stmt->get_result();

        $bookings = [];
        while ($brow = $result->fetch_assoc()) {
            $bookings[] = $brow;
        }
        ?>

        <?php if (count($bookings) > 0): ?>
            <div class="table-responsive">
              <table class="table table-bordered bg-white">
                <thead class="table-secondary">
                  <tr>
                    <th>Client</th>
                    <th>Service Type</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach ($bookings as $brow): ?>
                  <tr>
                    <td><?= htmlspecialchars($brow['client_name']) ?></td>
                    <td><?= htmlspecialchars($brow['service_type']) ?></td>
                    <td><?= htmlspecialchars($brow['requested_date']) ?></td>
                    <td><?= htmlspecialchars($brow['preferred_time']) ?></td>
                    <td>
                      <span class="badge bg-<?= $brow['status'] === 'pending' ? 'warning' : 'success' ?>">
                        <?= ucfirst($brow['status']) ?>
                      </span>
                    </td>
                    <td class="d-flex flex-wrap gap-1">
                      <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailsModal<?= $brow['id'] ?>">Details</button>
                    </td>
                  </tr>
                <?php endforeach; ?>
                </tbody>
              </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info">No upcoming bookings at the moment.</div>
        <?php endif; ?>
        </div>
      </div>

      <!-- Job History -->
      <div class="card shadow-sm mb-4">
        <div class="card-header bg-success text-white">
          Completed Jobs
        </div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item">Rewiring Apartment - April 15</li>
          <li class="list-group-item">Switchboard Fix - April 12</li>
        </ul>
      </div>

      <!-- Ratings -->
      <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
          Reviews
        </div>
        <div class="card-body">
          <p><strong>“Great job on time!”</strong><br />
            <span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star grey">★</span>
            <br /><small class="text-muted">- Malik, April 10</small>
          </p>
          <hr />
          <p><strong>“Very helpful and polite.”</strong><br />
            <span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span>
            <br /><small class="text-muted">- Shani, April 5</small>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once 'mechanic-footer.html'; ?>

<!-- Availability Toggle -->
<script>
  const switchToggle = document.getElementById("availabilitySwitch");
  const label = document.getElementById("availabilityLabel");

  switchToggle.addEventListener("change", function () {
    if (this.checked) {
      label.textContent = "Available";
      label.classList.remove("text-danger");
      label.classList.add("text-success");
    } else {
      label.textContent = "Not Available";
      label.classList.remove("text-success");
      label.classList.add("text-danger");
    }
  });
</script>

<!-- Modals -->
<?php foreach ($bookings as $brow): ?>
<div class="modal fade" id="detailsModal<?= $brow['id'] ?>" tabindex="-1" aria-labelledby="detailsLabel<?= $brow['id'] ?>" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailsLabel<?= $brow['id'] ?>">Booking Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p><strong>Client:</strong> <?= htmlspecialchars($brow['client_name']) ?></p>
        <p><strong>Service Type:</strong> <?= htmlspecialchars($brow['service_type']) ?></p>
        <p><strong>Job Description:</strong> <?= nl2br(htmlspecialchars($brow['job_description'])) ?></p>
        <p><strong>Phone:</strong> <?= htmlspecialchars($brow['phone']) ?></p>
        <p><strong>Location:</strong> <?= htmlspecialchars($brow['location']) ?></p>
        <p><strong>Requested Date:</strong> <?= htmlspecialchars($brow['requested_date']) ?></p>
        <p><strong>Preferred Time:</strong> <?= htmlspecialchars($brow['preferred_time']) ?></p>
        <p><strong>Flexible Timing:</strong> <?= htmlspecialchars($brow['time_flexibility']) ?></p>
        <p><strong>Status:</strong> <?= ucfirst($brow['status']) ?></p>
        <p><strong>Submitted At:</strong> <?= date('F j, Y, g:i A', strtotime($brow['created_at'])) ?></p>
      </div>
    </div>
  </div>
</div>
<?php endforeach; ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
