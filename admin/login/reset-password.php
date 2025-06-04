<?php
session_start();
require_once __DIR__ . '/../../db.php';

$error = '';
$success = '';
$show_form = true;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    if ($password !== $confirm_password) {
        $error = 'Passwords do not match';
    } else {
        // Verify token is valid and not expired
        $stmt = $mysqli->prepare("SELECT id FROM admin_users WHERE reset_token = ? AND reset_token_expiry > NOW()");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows === 1) {
            // Update password and clear token
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $update = $mysqli->prepare("UPDATE admin_users SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE reset_token = ?");
            $update->bind_param("ss", $hashed_password, $token);
            
            if ($update->execute()) {
                $success = 'Password updated successfully!';
                $show_form = false;
            } else {
                $error = 'Error updating password';
            }
        } else {
            $error = 'Invalid or expired token';
        }
    }
} else {
    $token = $_GET['token'] ?? '';
    if (empty($token)) {
        $error = 'No token provided';
        $show_form = false;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; padding: 20px; }
        .reset-container { max-width: 500px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <div class="reset-container">
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <div class="text-center mt-3">
                <a href="forgot-password.php" class="btn btn-secondary">Try Again</a>
            </div>
        <?php elseif ($success): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <div class="text-center mt-3">
                <a href="login.php" class="btn btn-primary">Login Now</a>
            </div>
        <?php elseif ($show_form): ?>
            <h2 class="text-center mb-4">Reset Your Password</h2>
            <form method="POST">
                <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                <div class="mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Reset Password</button>
                </div>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>