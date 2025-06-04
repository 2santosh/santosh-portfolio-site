<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login/login.php");
    exit();
}
?>
