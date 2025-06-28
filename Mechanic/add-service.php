<?php
session_start();
include_once "../db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'mechanic') {
    http_response_code(403);
    echo "Unauthorized";
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);
$service_name = trim($data['service_name']);

if ($service_name === "") {
    http_response_code(400);
    echo "Service name cannot be empty.";
    exit();
}

$mechanic_id = $_SESSION['user_id'];
$stmt = $conn->prepare("INSERT INTO mechanic_services (mechanic_id, service_name) VALUES (?, ?)");
$stmt->bind_param("is", $mechanic_id, $service_name);

if ($stmt->execute()) {
    echo "Service added successfully.";
} else {
    http_response_code(500);
    echo "Database error.";
}
?>
