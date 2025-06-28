<?php
session_start();

if (!isset($_SESSION['reg_data'])) {
    // No registration data, redirect back to registration form
    header('Location: register-form.php'); // Adjust if your form file is named differently
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input_code = trim($_POST['verification_code']);

    if ($input_code == $_SESSION['reg_data']['verification_code']) {
        // Verification successful, insert data into DB
        include './db.php';

        $data = $_SESSION['reg_data'];
        $user_type = $data['user_type'];

        if ($user_type == 'client') {
            $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $data['email'], $data['password']);

            if ($stmt->execute()) {
                $user_id = $stmt->insert_id;
                $role = 'client';

                $stmt2 = $conn->prepare("INSERT INTO user_details (user_id, first_name, last_name, phone, user_role, profile_image) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt2->bind_param("isssss", $user_id, $data['first_name'], $data['last_name'], $data['phone'], $role, $data['profile_image']);
                $stmt2->execute();
                $stmt2->close();

                unset($_SESSION['reg_data']); // clear session data
                echo "<script>alert('Registration successful! You may now login.'); window.location.href='login-form.php';</script>";
                exit;
            } else {
                $error = "Database error: " . $stmt->error;
            }
            $stmt->close();

        } elseif ($user_type == 'mechanic') {
            $stmt4 = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
            $stmt4->bind_param("ss", $data['email'], $data['password']);

            if ($stmt4->execute()) {
                $user_id = $stmt4->insert_id;
                $role = 'mechanic';

                $stmt5 = $conn->prepare("INSERT INTO user_details (user_id, full_name, phone, address, service_category, experience, skills, hourly_rate, working_hours, latitude, longitude, user_role, profile_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt5->bind_param("issssissddsss",
                    $user_id,
                    $data['fullname'],
                    $data['phone'],
                    $data['service_area'],
                    $data['service_category'],
                    $data['experience'],
                    $data['skills'],
                    $data['hourly_rate'],
                    $data['working_hours'],
                    $data['latitude'],
                    $data['longitude'],
                    $role,
                    $data['profile_image']
                );
                $stmt5->execute();
                $stmt5->close();

                unset($_SESSION['reg_data']); // clear session data
                echo "<script>alert('Registration successful! You may now login.'); window.location.href='login-form.php';</script>";
                exit;
            } else {
                $error = "Database error: " . $stmt4->error;
            }
            $stmt4->close();
        }

        $conn->close();

    } else {
        $error = "Verification code is incorrect. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Email Verification</title>
</head>
<body>
    <h2>Enter Verification Code</h2>

    <?php if ($error): ?>
        <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="verification_code">Verification Code:</label>
        <input type="text" name="verification_code" id="verification_code" maxlength="6" required autofocus pattern="\d{6}" title="Enter 6-digit code">
        <button type="submit">Verify</button>
    </form>
</body>
</html>
