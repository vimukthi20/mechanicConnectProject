<?php
session_start();
include_once "../db.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Management - Admin Dashboard</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

  <!-- Custom Styles -->
  <link rel="stylesheet" href="../admin-dashboard.css">
  <link rel="stylesheet" href="../admin-navbar.css">
</head>

<body style="background-color:#edeff2;">

  <?php include_once "admin-navbar.html"; ?>

  <div class="container mt-5 pt-4">
    <div class="card shadow-sm border-0 rounded-4">
      <div class="card-header bg-success text-white rounded-top-4">
        <h4 class="mb-0">User Management</h4>
      </div>
      <div class="card-body">
        <table id="userTable" class="table table-striped table-hover table-bordered">
          <thead class="table-light">
            <tr>
              <th>User ID</th>
              <th>User Name</th>
              <th>Email</th>
              <th>User Role</th>
              <th>Status</th>
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $sql = "SELECT users.id, user_details.full_name AS name, email, user_details.user_role, status 
        FROM users 
        INNER JOIN user_details ON users.id = user_details.user_id";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
              while ($user = $result->fetch_assoc()) {
                // Optional: color-coded badge for status
                $statusBadge = $user['status'] === 'Active'
                  ? "<span class='badge bg-success'>Active</span>"
                  : "<span class='badge bg-secondary'>Inactive</span>";

                echo "<tr>
                        <td>{$user['id']}</td>
                        <td>{$user['name']}</td>
                        <td>{$user['email']}</td>
                        <td>{$user['user_role']}</td>
                        <td>{$statusBadge}</td>
                        <td class='text-center'>
                          <a href='edit-user.php?id={$user['id']}' class='btn btn-sm btn-outline-primary rounded-pill me-1'>
                            <i class='fas fa-edit'></i> Edit
                          </a>
                          <a href='delete-user.php?id={$user['id']}' class='btn btn-sm btn-outline-danger rounded-pill' onclick=\"return confirm('Are you sure?');\">
                            <i class='fas fa-trash'></i> Delete
                          </a>
                        </td>
                      </tr>";
              }
            } else {
              echo "<tr><td colspan='5' class='text-center'>No users found.</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
<br>
<br>
  <?php include_once "footer.html"; ?>

  <script>
    $(document).ready(function () {
      $('#userTable').DataTable({
        language: {
          search: "Search users:",
          lengthMenu: "Show _MENU_ entries per page",
          zeroRecords: "No matching records found",
          info: "Showing _START_ to _END_ of _TOTAL_ users",
          infoEmpty: "No users available",
          infoFiltered: "(filtered from _MAX_ total users)"
        }
      });
    });
  </script>
</body>

</html>
