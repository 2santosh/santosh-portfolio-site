<?php
// Start session
session_start();

// Set base path
$base_path = '/santosh-portfolio-site/';

// Check if admin is logged in
$is_logged_in = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;

// Redirect based on login status
if ($is_logged_in) {
    header("Location: {$base_path}admin/dashboard.php");
} else {
    header("Location: {$base_path}admin/login/login.php");
}

exit();
?>