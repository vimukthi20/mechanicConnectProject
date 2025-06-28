<?php
session_start();
require '../db.php';

// Make sure user is logged in and is a client
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'client') {
    header("Location: ../login-form.php");
    exit();
}

$clientId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    // === HANDLE PROFILE IMAGE UPLOAD ===
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profile_image']['tmp_name'];
        $fileName = $_FILES['profile_image']['name'];
        $fileSize = $_FILES['profile_image']['size'];
        $fileType = $_FILES['profile_image']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Allowed extensions
        $allowedfileExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($fileExtension, $allowedfileExtensions)) {
            // Directory to save uploaded images - ensure this exists and is writable
            $uploadFileDir = './client-profile-images/';
            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0755, true);
            }

            // Generate a unique file name
            $newFileName = $clientId . '_' . time() . '.' . $fileExtension;
            $dest_path = $uploadFileDir . $newFileName;

            if (!move_uploaded_file($fileTmpPath, $dest_path)) {
                $_SESSION['error'] = "There was an error moving the uploaded file.";
                header("Location: client-profile-edit.php");
                exit();
            }
        } else {
            $_SESSION['error'] = "Upload failed. Allowed file types: " . implode(", ", $allowedfileExtensions);
            header("Location: client-profile-edit.php");
            exit();
        }
    }

    // === HANDLE PROFILE DETAILS UPDATE ===
    $firstName = trim($_POST['first_name'] ?? '');
    $lastName = trim($_POST['last_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $location = trim($_POST['location'] ?? '');

    if (empty($firstName) || empty($lastName) || empty($phone)) {
        $_SESSION['error'] = "First name, last name, and phone are required.";
        header("Location: client-profile-edit.php");
        exit();
    }

    // Start building the SQL query dynamically to include profile_image if uploaded
    if (isset($newFileName)) {
        $stmt = $conn->prepare("UPDATE user_details SET first_name = ?, last_name = ?, phone = ?, address = ?, profile_image = ? WHERE user_id = ?");
        $stmt->bind_param("sssssi", $firstName, $lastName, $phone, $location, $newFileName, $clientId);
    } else {
        $stmt = $conn->prepare("UPDATE user_details SET first_name = ?, last_name = ?, phone = ?, address = ? WHERE user_id = ?");
        $stmt->bind_param("ssssi", $firstName, $lastName, $phone, $location, $clientId);
    }

    try {
        $stmt->execute();
        $_SESSION['success'] = "Profile updated successfully!";
        header("Location: client-profile.php");
        exit();
    } catch (Exception $e) {
        error_log("Update error: " . $e->getMessage());
        $_SESSION['error'] = "Something went wrong. Please try again.";
        header("Location: client-profile-edit.php");
        exit();
    }
} else {
    $_SESSION['error'] = "Invalid request method.";
    header("Location: client-profile-edit.php");
    exit();
}
