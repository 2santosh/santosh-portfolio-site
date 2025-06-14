<?php
require_once __DIR__ . '/includes/config.php';

$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);

if ($mysqli->connect_error) {
    // Instead of echo, set response and exit
    $response = ['status' => 'error', 'message' => 'Database connection failed: ' . $mysqli->connect_error];
    header('Content-Type: application/json');
    // echo json_encode($response);
    exit;
}

$mysqli->set_charset("utf8mb4");
header('Content-Type: application/json');

$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name && $email && $subject && $message) {
        $stmt = $mysqli->prepare("INSERT INTO contact_messages (name, email, subject, phone, message) VALUES (?, ?, ?, ?, ?)");
        if (!$stmt) {
            $response = ['status' => 'error', 'message' => 'Database prepare error: ' . $mysqli->error];
        } else {
            $stmt->bind_param("sssss", $name, $email, $subject, $phone, $message);

            if ($stmt->execute()) {
                $response = ['status' => 'success', 'message' => 'Message submitted successfully.'];
            } else {
                $response = ['status' => 'error', 'message' => 'Database execute error: ' . $stmt->error];
            }
            $stmt->close();
        }
    } else {
        $response = ['status' => 'error', 'message' => 'Required fields missing.'];
    }
    $mysqli->close();
} else {
    $response = ['status' => 'error', 'message' => 'Invalid request method.'];
}

echo json_encode($response);
