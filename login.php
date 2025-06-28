<?php
session_start();
include('db.php'); // Make sure DB connection works

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Please enter both email and password.";
        header("Location: login-form.php");
        exit();
    }

    //   Check for hardcoded admin
    if ($email === 'admin@gmail.com' && $password === 'admin123!') {
        $_SESSION['user_id'] = 0; // You can use 0 or any static ID for admin
        $_SESSION['email'] = $email;
        $_SESSION['role'] = 'admin';
        header("Location: Admin/admin-dashboard.php");
        exit();
    }

    //  Continue with regular user login
    $email = mysqli_real_escape_string($conn, $email);
    $query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {
            $user_id = $user['id'];

            $roleQuery = "SELECT user_role FROM user_details WHERE user_id = $user_id LIMIT 1";
            $roleResult = mysqli_query($conn, $roleQuery);

            if ($roleResult && mysqli_num_rows($roleResult) > 0) {
                $role = mysqli_fetch_assoc($roleResult)['user_role'];

                $_SESSION['user_id'] = $user_id;
                $_SESSION['email'] = $email;
                $_SESSION['role'] = $role;

                switch ($role) {
                    case 'client':
                        header("Location: Client/client-dashboard.php");
                        break;
                    case 'mechanic':
                        header("Location: Mechanic/mechanic-dashboard.php");
                        break;
                    default:
                        $_SESSION['error'] = "Unknown user role.";
                        header("Location: login-form.php");
                        break;
                }
                exit();
            } else {
                $_SESSION['error'] = "User role not found.";
                header("Location: login-form.php");
                exit();
            }
        } else {
            $_SESSION['error'] = "Incorrect password.";
            header("Location: login-form.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Email not registered.";
        header("Location: login-form.php");
        exit();
    }
} else {
    header("Location: login-form.php");
    exit();
}
