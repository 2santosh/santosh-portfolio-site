<?php
session_start();

// Unset all session variables to log the user out
session_unset();

// Destroy the session
session_destroy();

// Redirect to login page
header("Location: login/login.php");
exit;
?>
