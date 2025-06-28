<?php
session_start();
include_once "../db.php"; // Make sure this connects to your DB

// Check login and role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'client') {
    header("Location: ../login-form.php");
    exit();
}

$client_id = $_SESSION['user_id'];
$mechanic_id = isset($_GET['mechanic_id']) ? intval($_GET['mechanic_id']) : 0;

if ($mechanic_id <= 0) {
    echo "Invalid mechanic selected.";
    exit();
}

// Fetch service types for the mechanic
$service_options = "";
$service_query = "SELECT service_name FROM mechanic_services WHERE mechanic_id = $mechanic_id";
$service_result = mysqli_query($conn, $service_query);

if ($service_result && mysqli_num_rows($service_result) > 0) {
    while ($row = mysqli_fetch_assoc($service_result)) {
        $service = htmlspecialchars($row['service_name']);
        $service_options .= "<option value=\"$service\">$service</option>";
    }
} else {
    $service_options = "<option disabled>No services found</option>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book a Mechanic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">Book a Mechanic</h2>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <form action="submit-booking.php" method="POST">
        <input type="hidden" name="mechanic_id" value="<?= htmlspecialchars($mechanic_id); ?>">

        <div class="mb-3">
            <label>Date</label>
            <input type="date" name="requested_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Preferred Time</label>
            <select name="preferred_time" class="form-control" required>
                <option value="">-- Select Time Window --</option>
                <option value="08:00-10:00">08:00 - 10:00</option>
                <option value="10:00-12:00">10:00 - 12:00</option>
                <option value="13:00-15:00">13:00 - 15:00</option>
                <option value="15:00-17:00">15:00 - 17:00</option>
                <option value="in the day">in the day</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Service Type</label>
            <select name="service_type" class="form-control" required>
                <option value="">-- Select Service --</option>
                <?= $service_options ?>
                <option value="Other">Other</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Job Description</label>
            <textarea name="job_description" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label>Phone Number</label>
            <input type="text" name="phone" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Service Location</label>
            <input type="text" name="location" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Is your selected time flexible?</label>
            <select name="time_flexibility" class="form-control" required>
                <option value="">-- Select --</option>
                <option value="yes">Yes, I'm flexible</option>
                <option value="no">No, I need this exact time</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Submit Booking</button>
    </form>
</div>
</body>
</html>
