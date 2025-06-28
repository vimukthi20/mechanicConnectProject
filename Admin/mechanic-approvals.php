<?php
include '../db.php';

// Enable error reporting during development
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Fetch pending mechanic registrations
$sql = "
    SELECT users.*, user_details.full_name, user_details.phone, user_details.address, 
           user_details.service_category, user_details.profile_image 
    FROM users
    JOIN user_details ON users.id = user_details.user_id
    WHERE users.status = 'pending' AND user_details.user_role = 'mechanic'
";
$result = $conn->query($sql);

if (!$result) {
    die("SQL Error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pending Mechanic Registrations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        .card-buttons .btn {
            flex: 1;
            margin: 0 3px;
        }
    </style>
</head>
<body class="bg-light d-flex flex-column min-vh-100">

<?php include_once "./admin-navbar.html" ?>

<div class="container mt-5 flex-grow-1">
    <h2 class="mb-4 text-center">Pending Mechanic Registrations</h2>

    <div class="row">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow h-100">
                        <?php if (!empty($row['profile_image'])): ?>
                            <img src="../Mechanic/mechanic-profile-images/<?php echo $row['profile_image']; ?>" class="card-img-top" alt="Profile Image">
                        <?php else: ?>
                            <img src="https://via.placeholder.com/300x200?text=No+Image" class="card-img-top" alt="No Image">
                        <?php endif; ?>

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['full_name']); ?></h5>
                            <p class="card-text">
                                <strong>Email:</strong> <?php echo $row['email']; ?><br>
                                <strong>Phone:</strong> <?php echo $row['phone']; ?><br>
                                <strong>Address:</strong> <?php echo $row['address']; ?><br>
                                <strong>Service:</strong> <?php echo $row['service_category']; ?>
                            </p>
                        </div>

                        <div class="card-footer bg-white border-top-0">
                            <form method="post" action="update-status.php" class="d-flex card-buttons">
                                <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="action" value="active" class="btn btn-success btn-sm">Approve</button>
                                <button type="submit" name="action" value="reject" class="btn btn-danger btn-sm">Reject</button>
                                <a href="view-mechanic.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">View More</a>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info text-center">No pending mechanic registrations found.</div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Sticky footer -->
<footer class="bg-dark text-white text-center py-3 mt-auto">
    <p class="mb-0">© 2025 Mechanic Connect. All rights reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>
