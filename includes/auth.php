<?php
// auth.php - Authentication functions

// Verify database connection exists
if (!isset($mysqli) || !($mysqli instanceof mysqli)) {
    die("Database connection not established. Please check your db.php file.");
}

/**
 * Authenticate an admin user
 * @param string $username
 * @param string $password
 * @return array|false Returns user data (without password) or false on failure
 */
function adminLogin($username, $password) {
    try {
        $sql = "SELECT id, username, password, created_at FROM admin_users WHERE username = ? LIMIT 1";
        $stmt = db_query($sql, [$username]);
        
        if (!$stmt) {
            error_log("Database query failed");
            return false;
        }
        
        // Rest of your function...
    } catch (Exception $e) {
        error_log("Login error: " . $e->getMessage());
        return false;
    }
}

// Other authentication functions...