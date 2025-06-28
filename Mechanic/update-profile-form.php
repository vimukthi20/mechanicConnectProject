<?php
session_start();
require '../db.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login-form.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch current profile data
$query = $conn->prepare("SELECT * FROM user_details WHERE user_id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
$profile = $result->fetch_assoc();
$query->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Mechanic Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow p-4">
        <h2 class="mb-4">Update Profile</h2>
        <form action="update-profile.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="user_id" value="<?= htmlspecialchars($user_id) ?>">

            <div class="mb-3">
                <label for="full_name" class="form-label">Full Name</label>
                <input type="text" class="form-control" name="full_name" id="full_name"
                       value="<?= htmlspecialchars($profile['full_name'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" name="phone" id="phone"
                       value="<?= htmlspecialchars($profile['phone'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control" name="address" id="address" rows="2" required><?= htmlspecialchars($profile['address'] ?? '') ?></textarea>
            </div>

            <div class="mb-3">
                <label for="service_category" class="form-label">Service Category</label>
                <input type="text" class="form-control" name="service_category" id="service_category"
                       value="<?= htmlspecialchars($profile['service_category'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label for="experience" class="form-label">Experience (years)</label>
                <input type="number" class="form-control" name="experience" id="experience"
                       value="<?= htmlspecialchars($profile['experience'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label for="skills" class="form-label">Skills</label>
                <textarea class="form-control" name="skills" id="skills" rows="3" required><?= htmlspecialchars($profile['skills'] ?? '') ?></textarea>
            </div>

            <div class="mb-3">
                <label for="hourly_rate" class="form-label">Hourly Rate ($)</label>
                <input type="number" class="form-control" name="hourly_rate" id="hourly_rate"
                       value="<?= htmlspecialchars($profile['hourly_rate'] ?? '') ?>" required>
            </div>

            

            <div class="mb-3">
                <label for="profile_image" class="form-label">Profile Image</label><br>
                <?php if (!empty($profile['profile_image'])): ?>
                    <img src="uploads/<?= htmlspecialchars($profile['profile_image']) ?>" alt="Profile Image" width="100" class="mb-2 rounded">
                <?php endif; ?>
                <input type="file" class="form-control" name="profile_image" id="profile_image" accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
    </div>
</div>

</body>
</html>
