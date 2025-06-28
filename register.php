<?php
session_start();
include './db.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['user_type'])) {
        $userType = $_POST['user_type'];

        if ($userType == 'client') {
            // Client Registration
            $first_name = $_POST['fname'];
            $last_name = $_POST['lname'];
            $email = $_POST['cemail'];
            $phone = $_POST['cphone'];
            $password = password_hash($_POST['cpassword'], PASSWORD_DEFAULT);
            $token = bin2hex(random_bytes(32));
            $status = "active";
            $province = $_POST['cprovince'];
            $district = $_POST['cdistrict'];
            $city = $_POST['city'];
            $address = $_POST['address'];
            $user_role = "client";

            $imageName = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $file_tmp = $_FILES['image']['tmp_name'];
                $file_name = basename($_FILES['image']['name']);
                $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
                $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

                if (in_array(strtolower($file_ext), $allowed_types)) {
                    $new_name = uniqid('img_', true) . '.' . $file_ext;
                    $target_dir = "client/client-profile-images/";
                    $target_file = $target_dir . $new_name;

                    if (!is_dir($target_dir)) {
                        mkdir($target_dir, 0755, true);
                    }

                    if (move_uploaded_file($file_tmp, $target_file)) {
                        $imageName = $new_name;
                    } else {
                        echo "Failed to move uploaded file.";
                        exit;
                    }
                } else {
                    echo "Invalid file type.";
                    exit;
                }
            }

            // Check for duplicate email
            $checkStmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
            $checkStmt->bind_param("s", $email);
            $checkStmt->execute();
            $checkStmt->store_result();
            if ($checkStmt->num_rows > 0) {
                echo "Email already exists.";
                exit;
            }
            $checkStmt->close();

            // Insert user
            $stmt = $conn->prepare("INSERT INTO users (email, password, verification_token, status) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $email, $password, $token, $status);

            if ($stmt->execute()) {
                $user_id = $stmt->insert_id;

                $stmt2 = $conn->prepare("INSERT INTO user_details (user_id, first_name, last_name, phone, user_role, profile_image, province, district, city, address) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt2->bind_param("isssssssss", $user_id, $first_name, $last_name, $phone, $user_role, $imageName, $province, $district, $city, $address);
                $stmt2->execute();
                $stmt2->close();

                // Send verification email
                try {
                    $verifyLink = "http://localhost/myphp/PROJECT%20NEW/verify-email.php?email=" . urlencode($email) . "&token=" . urlencode($token);
                    $mail = new PHPMailer(true);
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'easyfix.lk123@gmail.com';
                    $mail->Password   = 'lehq clql shhs ocei';
                    $mail->SMTPSecure = 'tls';
                    $mail->Port       = 587;
                    $mail->setFrom('easyfix.lk123@gmail.com', 'Vimukthi');
                    $mail->addAddress($email, $first_name . ' ' . $last_name);
                    $mail->isHTML(true);
                    $mail->Subject = 'Please verify your email address';
                    $mail->Body    = "Hi $first_name,<br>Click to verify your email: <a href='$verifyLink'>Verify Email</a>";
                    $mail->send();
                } catch (Exception $e) {
                    error_log("Email error: " . $mail->ErrorInfo);
                }

                // Auto login and redirect
                session_regenerate_id(true);
                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_role'] = 'client';
                $_SESSION['user_name'] = $first_name . ' ' . $last_name;
                header("Location: client/client-dashboard.php");
                exit;
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();

        } elseif ($userType == 'mechanic') {
            // Mechanic Registration
            $fullname = $_POST['mname'];
            $email = $_POST['memail'];
            $phone = $_POST['mphone'];
            $password = password_hash($_POST['mpassword'], PASSWORD_DEFAULT);
            $serviceCategory = $_POST['service_category'];
            $experience = $_POST['mexperience'];
            $skills = $_POST['mskills'];
            $hourlyRate = floatval($_POST['mrate']);
            $address = $_POST['address'];
            $province = $_POST['mprovince'];
            $district = $_POST['mdistrict'];
            $city = $_POST['mcity'];
            $user_role = "mechanic";

            $imageName = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $file_tmp = $_FILES['image']['tmp_name'];
                $file_name = basename($_FILES['image']['name']);
                $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
                $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

                if (in_array(strtolower($file_ext), $allowed_types)) {
                    $new_name = uniqid('img_', true) . '.' . $file_ext;
                    $target_dir = "mechanic/mechanic-profile-images/";
                    $target_file = $target_dir . $new_name;

                    if (!is_dir($target_dir)) {
                        mkdir($target_dir, 0755, true);
                    }

                    if (move_uploaded_file($file_tmp, $target_file)) {
                        $imageName = $new_name;
                    } else {
                        echo "Failed to move uploaded file.";
                        exit;
                    }
                } else {
                    echo "Invalid file type.";
                    exit;
                }
            }

            // Check duplicate email
            $checkStmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
            $checkStmt->bind_param("s", $email);
            $checkStmt->execute();
            $checkStmt->store_result();
            if ($checkStmt->num_rows > 0) {
                echo "Email already exists.";
                exit;
            }
            $checkStmt->close();

            $stmt4 = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
            $stmt4->bind_param("ss", $email, $password);

            if ($stmt4->execute()) {
                $user_id = $stmt4->insert_id;

                $stmt5 = $conn->prepare("INSERT INTO user_details (user_id, full_name, phone, address, service_category, experience, skills, hourly_rate, user_role, profile_image, province, district, city) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt5->bind_param("issssssdsssss", $user_id, $fullname, $phone, $address, $serviceCategory, $experience, $skills, $hourlyRate, $user_role, $imageName, $province, $district, $city);
                $stmt5->execute();
                $stmt5->close();

                // Auto login and redirect
                session_regenerate_id(true);
                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_role'] = 'mechanic';
                $_SESSION['user_name'] = $fullname;
                header("Location: mechanic/mechanic-dashboard.php");
                exit;
            } else {
                echo "Error: " . $stmt4->error;
            }
            $stmt4->close();
        }
    }
}

$conn->close();
?>
