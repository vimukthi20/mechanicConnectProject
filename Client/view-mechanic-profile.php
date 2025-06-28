<?php
session_start();
include_once "../db.php";

if (!isset($_GET['mechanic_id'])) {
    echo "Mechanic not found.";
    exit;
}

$mechanic_id = (int)$_GET['mechanic_id'];
$query = "SELECT * FROM user_details WHERE user_id = $mechanic_id AND user_role = 'mechanic'";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    echo "Mechanic not found.";
    exit;
}

$mechanic = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Mechanic Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <div class="card">
    <div class="row g-0">
      <div class="col-md-4">
        <img src="../Mechanic/mechanic-profile-images/<?= htmlspecialchars($mechanic['profile_image']); ?>" class="img-fluid rounded-start" alt="Profile Image">
      </div>
      <div class="col-md-8">
        <div class="card-body">
          <h3 class="card-title"><?= htmlspecialchars($mechanic['full_name']); ?></h3>
          <p class="card-text"><strong>Service:</strong> <?= htmlspecialchars($mechanic['service_category']); ?></p>
          <p class="card-text"><strong>Skills:</strong> <?= htmlspecialchars($mechanic['skills']); ?></p>
          <p class="card-text"><strong>Experience:</strong> <?= htmlspecialchars($mechanic['experience']); ?></p>
          <p class="card-text"><strong>Rate:</strong> Rs.<?= htmlspecialchars($mechanic['hourly_rate']); ?> / hour</p>
          <p class="card-text"><strong>Phone:</strong> <?= htmlspecialchars($mechanic['phone']); ?></p>
          <p class="card-text"><strong>Address:</strong> <?= htmlspecialchars($mechanic['address']); ?>, <?= htmlspecialchars($mechanic['city']); ?>, <?= htmlspecialchars($mechanic['district']); ?>, <?= htmlspecialchars($mechanic['province']); ?></p>
          <a href="booking-form.php?mechanic_id=<?= $mechanic['user_id']; ?>" class="btn btn-success mt-2">Book This Mechanic</a>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
