<?php
session_start();
$_SESSION = []; // Optional: Clear session variables
session_destroy(); // Destroy the session
header("Location: login-form.php"); // Redirect to login page
exit();
?>
