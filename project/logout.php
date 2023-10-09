<?php
session_start();

// Check if the user is already logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page or any other appropriate action
    header("Location: login.php");
    exit();
} else {
    // User is logged in, proceed with logging out
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session

    // Redirect to the login page or any other appropriate action
    header("Location: login.php");
    exit();
}
?>
