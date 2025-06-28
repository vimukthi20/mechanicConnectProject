<?php
session_start();
include_once "../db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login-form.php");
    exit();
}

if ($_SESSION['role'] !== 'client') {
    header("Location: ../login-form.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Find Services</title>
  <link rel="stylesheet" href="find-services.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    main {
      flex: 1;
    }
    footer {
      background-color: #f8f9fa;
      text-align: center;
      padding: 10px 0;
    }
    .card:hover {
      transform: scale(1.03);
      transition: transform 0.3s ease;
      box-shadow: 0 0 15px rgba(0,0,0,0.2);
    }
  </style>
</head>
<body>

<?php include_once "client-navbar.html"; ?>

<main class="container-fluid mt-4">
  <h1 class="mb-4 text-center">Find a Service Provider</h1>

  <?php
  $category_query = "SELECT id, name FROM service_categories ORDER BY name ASC";
  $category_result = mysqli_query($conn, $category_query);
  ?>

  <div class="filter-section">
    <form class="row g-3" method="GET" action="">
      <div class="col-md-4">
        <label for="service_category" class="form-label">Select Service Category</label>
        <select name="service_category" id="service_category" class="form-select">
          <option value="">-- Select Category --</option>
          <?php while ($row = mysqli_fetch_assoc($category_result)): ?>
            <option value="<?= htmlspecialchars($row['name']); ?>" <?= (isset($_GET['service_category']) && $_GET['service_category'] === $row['name']) ? 'selected' : ''; ?>>
              <?= htmlspecialchars($row['name']); ?>
            </option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="col-md-4">
        <label for="location" class="form-label">Location (Province / District / City)</label>
        <input 
          type="text" 
          id="location" 
          name="location" 
          class="form-control" 
          placeholder="e.g., Western, Gampaha, Colombo" 
          value="<?= isset($_GET['location']) ? htmlspecialchars($_GET['location']) : ''; ?>"
        />
      </div>
      <div class="col-md-4 align-self-end">
        <button type="submit" class="btn btn-primary w-100">Search</button>
      </div>
    </form>
  </div>

<?php
$category = $_GET['service_category'] ?? '';
$location = $_GET['location'] ?? '';

$limit = 6;
$page = isset($_GET['page']) ? max((int)$_GET['page'], 1) : 1;
$offset = ($page - 1) * $limit;

// Base query with JOIN
$sql = "
  SELECT user_details.* 
  FROM user_details
  INNER JOIN users ON user_details.user_id = users.id
  WHERE user_details.user_role = 'mechanic' AND users.status = 'active'
";

// Add filters
$filters = "";

if (!empty($category)) {
    $safe_category = mysqli_real_escape_string($conn, $category);
    $filters .= " AND user_details.service_category = '$safe_category'";
}

if (!empty($location)) {
    $safe_location = mysqli_real_escape_string($conn, $location);
    $filters .= " AND (user_details.province LIKE '%$safe_location%' OR user_details.district LIKE '%$safe_location%' OR user_details.city LIKE '%$safe_location%')";
}

$sql .= $filters;

// Count total matching records
$count_sql = "
  SELECT COUNT(*) as total 
  FROM user_details 
  INNER JOIN users ON user_details.user_id = users.id
  WHERE user_details.user_role = 'mechanic' AND users.status = 'active' $filters
";

$count_result = mysqli_query($conn, $count_sql);
$count_row = mysqli_fetch_assoc($count_result);
$total_records = $count_row['total'];
$total_pages = ceil($total_records / $limit);

// Fetch paginated results
$sql .= " LIMIT $offset, $limit";
$result = mysqli_query($conn, $sql);
?>

<div>
  <h2 class="mb-3">Recommended Mechanics</h2>
  <div class="row recommended">
    <?php if ($result && mysqli_num_rows($result) > 0): ?>
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="col-md-3 mb-4">
          <div class="card shadow h-100">
            <img src="../Mechanic/mechanic-profile-images/<?= htmlspecialchars($row['profile_image']); ?>" alt="Mechanic" class="card-img-top" style="height: 250px; object-fit: cover;">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title text-center mb-2"><?= htmlspecialchars($row['full_name']); ?></h5>
              <p class="card-text text-center text-muted mb-3"><?= htmlspecialchars($row['service_category'] . " - " . $row['city']); ?></p>
              <a href="booking-form.php?mechanic_id=<?= $row['user_id']; ?>" class="btn btn-primary mb-2">Book Now</a>
              <a href="view-mechanic-profile.php?mechanic_id=<?= $row['user_id']; ?>" class="btn btn-outline-secondary">View Profile</a>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p class="text-muted">No recommended mechanics found.</p>
    <?php endif; ?>
  </div>

  <?php if ($total_pages > 1): ?>
    <nav aria-label="Page navigation">
      <ul class="pagination justify-content-center mt-4">
        <?php if ($page > 1): ?>
          <li class="page-item">
            <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $page - 1])); ?>">Previous</a>
          </li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
          <li class="page-item <?= ($i == $page) ? 'active' : ''; ?>">
            <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $i])); ?>"><?= $i; ?></a>
          </li>
        <?php endfor; ?>

        <?php if ($page < $total_pages): ?>
          <li class="page-item">
            <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $page + 1])); ?>">Next</a>
          </li>
        <?php endif; ?>
      </ul>
    </nav>
  <?php endif; ?>
</div>
</main>

<footer>
  <?php include_once "./footer.html" ?>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
