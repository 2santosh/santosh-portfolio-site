<?php
require_once __DIR__ . '/includes/config.php';

// Establish database connection
$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);

if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

$mysqli->set_charset("utf8mb4");

/**
 * Helper function for database queries
 * @param string $sql The SQL query with placeholders
 * @param array $params Parameters to bind
 * @return mysqli_stmt|false Returns statement object or false on failure
 */
function db_query($sql, $params = []) {
    global $mysqli;

    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        error_log("Prepare failed: " . $mysqli->error);
        return false;
    }

    if (!empty($params)) {
        $types = str_repeat('s', count($params));
        $stmt->bind_param($types, ...$params);
    }

    if (!$stmt->execute()) {
        error_log("Execute failed: " . $stmt->error);
        return false;
    }

    return $stmt;
}