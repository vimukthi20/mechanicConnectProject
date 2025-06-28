<?php
include_once "../db.php";
session_start();

// Only allow admins to access this page
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login-form.php");
    exit();
}

// Add category
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_category'])) {
    $category_name = trim($_POST['category_name']);
    if (!empty($category_name)) {
        $stmt = $conn->prepare("INSERT INTO service_categories (name) VALUES (?)");
        $stmt->bind_param("s", $category_name);
        $stmt->execute();
        $stmt->close();
    }
}

// Delete category
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM service_categories WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();
}

// Fetch categories
$categories = mysqli_query($conn, "SELECT * FROM service_categories ORDER BY name ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Service Categories</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
 <?php include_once 
 './admin-navbar.html' ?>
<div class="container mt-5">
  <h2 class="mb-4">Manage Service Categories</h2>

  <!-- Add New Category Form -->
  <form method="POST" class="row g-3 mb-4">
    <div class="col-md-6">
      <input type="text" name="category_name" class="form-control" placeholder="New Category Name" required>
    </div>
    <div class="col-md-2">
      <button type="submit" name="add_category" class="btn btn-primary w-100">Add</button>
    </div>
  </form>

  <!-- Category List -->
  <div class="card">
    <div class="card-header">
      Existing Categories
    </div>
    <div class="card-body">
      <?php if (mysqli_num_rows($categories) > 0): ?>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Category Name</th>
              <th width="100">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($cat = mysqli_fetch_assoc($categories)): ?>
              <tr>
                <td><?= htmlspecialchars($cat['name']) ?></td>
               

                <td>
                  <a href="?delete_id=<?= $cat['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this category?')">Delete</a>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      <?php else: ?>
        <p class="text-muted">No service categories found.</p>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php include_once "./footer.html" ?>
</body>
</html>
