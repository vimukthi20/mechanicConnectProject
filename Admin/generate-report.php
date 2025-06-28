<?php
session_start();
include_once "../db.php";

// --- Fetch data from DB ---
 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Mechanic Reports - Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="../admin-dashboard.css">
</head>

<body style="background-color:#edeff2;">

    <?php include_once "admin-navbar.html"; ?>

    <div class="container mt-5 pt-4">
        <h3 class="mb-4 fw-bold"><i class="fas fa-chart-line me-2"></i>Reports Dashboard</h3>

        <div class="row g-4">

            <!-- Total Users -->
            <div class="col-md-4">
                <div class="card shadow rounded-4 border-0">
                    <div class="card-body text-center">
                        <i class="fas fa-users fa-2x mb-2 text-primary"></i>
                        <h5>Total Users</h5>
                        <h3 class="fw-bold"><?= $totalUsers ?? 15 ?></h3>
                        <button type="button" class="btn btn-outline-primary btn-sm mt-3 rounded-pill" data-bs-toggle="modal" data-bs-target="#userReportModal">
                            <i class="fas fa-eye me-1"></i> View Report
                        </button>
                    </div>
                </div>
            </div>

            <!-- Active Users -->
            <div class="col-md-4">
                <div class="card shadow rounded-4 border-0">
                    <div class="card-body text-center">
                        <i class="fas fa-user-check fa-2x mb-2 text-success"></i>
                        <h5>Active Users</h5>
                        <h3 class="fw-bold"><?= $activeUsers ?? 12 ?></h3>
                        <a href="report-active-users.php" class="btn btn-outline-success btn-sm mt-3 rounded-pill">
                            <i class="fas fa-eye me-1"></i> View Report
                        </a>
                    </div>
                </div>
            </div>

            <!-- Inactive Users -->
            <div class="col-md-4">
                <div class="card shadow rounded-4 border-0">
                    <div class="card-body text-center">
                        <i class="fas fa-user-slash fa-2x mb-2 text-danger"></i>
                        <h5>Inactive Users</h5>
                        <h3 class="fw-bold"><?= $inactiveUsers ?? 3 ?></h3>
                        <a href="report-inactive-users.php" class="btn btn-outline-danger btn-sm mt-3 rounded-pill">
                            <i class="fas fa-eye me-1"></i> View Report
                        </a>
                    </div>
                </div>
            </div>

            <!-- Total Payments -->
            <div class="col-md-6">
                <div class="card shadow rounded-4 border-0">
                    <div class="card-body text-center">
                        <i class="fas fa-wallet fa-2x mb-2 text-info"></i>
                        <h5>Total Payments</h5>
                        <h3 class="fw-bold">Rs. <?= number_format(124000, 2) ?></h3>
                        <a href="report-payments.php" class="btn btn-outline-info btn-sm mt-3 rounded-pill">
                            <i class="fas fa-eye me-1"></i> View Report
                        </a>
                    </div>
                </div>
            </div>

            <!-- Overdue Payments -->
            <div class="col-md-6">
                <div class="card shadow rounded-4 border-0">
                    <div class="card-body text-center">
                        <i class="fas fa-exclamation-circle fa-2x mb-2 text-warning"></i>
                        <h5>Overdue Payments</h5>
                        <h3 class="fw-bold">Rs. <?= 12500 ?></h3>
                        <a href="report-overdues.php" class="btn btn-outline-warning btn-sm mt-3 rounded-pill">
                            <i class="fas fa-eye me-1"></i> View Report
                        </a>
                    </div>
                </div>
            </div>

            <!-- Mechanic Count -->
            <div class="col-md-6">
                <div class="card shadow rounded-4 border-0">
                    <div class="card-body text-center">
                        <i class="fas fa-wrench fa-2x mb-2 text-dark"></i>
                        <h5>Total Mechanics</h5>
                        <h3 class="fw-bold"><?= $mechanicCount ?? 3 ?></h3>
                        <a href="report-mechanics.php" class="btn btn-outline-dark btn-sm mt-3 rounded-pill">
                            <i class="fas fa-eye me-1"></i> View Report
                        </a>
                    </div>
                </div>
            </div>

            <!-- P/L Reports -->
            <div class="col-md-6">
                <div class="card shadow rounded-4 border-0">
                    <div class="card-body text-center">
                    <!-- <i class="fa-solid fa-sack-dollar"></i> -->
                        <i class="fa-solid fa-sack-dollar fa-2x mb-2 text-dark"></i>
                        <h5>P/L Reports</h5>
                        <h3 class="fw-bold"><?= $mechanicCount ?? 3 ?></h3>
                        <a href="report-mechanics.php" class="btn btn-outline-dark btn-sm mt-3 rounded-pill">
                            <i class="fas fa-eye me-1"></i> View Report
                        </a>
                    </div>
                </div>
            </div>


        </div>
    </div>
<br>
<br>
    <?php include_once "footer.html"; ?>


    <!-- User Report Modal -->
    <div class="modal fade" id="userReportModal" tabindex="-1" aria-labelledby="userReportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="report-users.php" method="GET" class="modal-content rounded-4 shadow">
                <div class="modal-header">
                    <h5 class="modal-title" id="userReportModalLabel">
                        <i class="fas fa-users me-2"></i>Generate User Report
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- Status Filter -->
                    <div class="mb-3">
                        <label for="status" class="form-label">User Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="all">All</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>

                    <!-- Optional: Date Range -->
                    <div class="mb-3">
                        <label class="form-label">Registration Date (optional)</label>
                        <div class="d-flex gap-2">
                            <input type="date" name="from_date" class="form-control" placeholder="From">
                            <input type="date" name="to_date" class="form-control" placeholder="To">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <a href="report-user-pdf.php?status=all" target="_blank" class="btn btn-danger rounded-pill">
                        <i class="fas fa-file-pdf me-1"></i> Export PDF
                    </a>

                </div>
            </form>
        </div>
    </div>


</body>

</html>