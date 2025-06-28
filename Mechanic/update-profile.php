<?php
include '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $full_name = $_POST['full_name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $service_category = $_POST['service_category'];
    $experience = $_POST['experience'];
    $skills = $_POST['skills'];
    $hourly_rate = $_POST['hourly_rate'];
    

    // Handle profile image if uploaded
    $imageName = null;
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        $file_tmp = $_FILES['profile_image']['tmp_name'];
        $file_name = basename($_FILES['profile_image']['name']);
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (in_array(strtolower($file_ext), $allowed)) {
            $new_name = uniqid('img_', true) . '.' . $file_ext;
            $upload_dir = './mechanic-profile-images/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);

            $target_file = $upload_dir . $new_name;
            if (move_uploaded_file($file_tmp, $target_file)) {
                $imageName = $new_name;
            }
        }
    }

    // Update the database
    if ($imageName) {
        $stmt = $conn->prepare("UPDATE user_details SET full_name=?, phone=?, address=?, service_category=?, experience=?, skills=?, hourly_rate=?,  profile_image=? WHERE user_id=?");
        $stmt->bind_param("ssssisssi", $full_name, $phone, $address, $service_category, $experience, $skills, $hourly_rate,  $imageName, $user_id);
    } else {
        $stmt = $conn->prepare("UPDATE user_details SET full_name=?, phone=?, address=?, service_category=?, experience=?, skills=?, hourly_rate=?,  WHERE user_id=?");
        $stmt->bind_param("ssssissi", $full_name, $phone, $address, $service_category, $experience, $skills, $hourly_rate,  $user_id);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Profile Updated Successfully!'); window.location.href='mechanic-profile.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
