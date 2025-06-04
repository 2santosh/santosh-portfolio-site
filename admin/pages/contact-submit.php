<?php
session_start();
require_once __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $mysqli->real_escape_string($_POST['name']);
    $email = $mysqli->real_escape_string($_POST['email']);
    $phone = $mysqli->real_escape_string($_POST['phone'] ?? '');
    $message = $mysqli->real_escape_string($_POST['message']);

    $sql = "INSERT INTO contact_messages (name, email, phone, message) VALUES ('$name', '$email', '$phone', '$message')";
    if ($mysqli->query($sql)) {
        $_SESSION['contact_success'] = "Thank you for your message!";
    } else {
        $_SESSION['contact_error'] = "Failed to submit message. Please try again.";
    }
    header("Location: /#contact");
    exit();
}
?>
