<?php
include '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $action = $_POST['action'];

    // Validate input
    if (!in_array($action, ['active', 'reject'])) {
        die("Invalid action.");
    }

    // Prepare and execute the update query
    $stmt = $conn->prepare("UPDATE users SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $action, $user_id);

    if ($stmt->execute()) {
        // Redirect back to the approval page with a success message (optional)
        header("Location: mechanic-approvals.php?success=1");
        exit();
    } else {
        echo "Error updating status: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid request method.";
}

$conn->close();
?>
