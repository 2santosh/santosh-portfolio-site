<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start([
        'cookie_lifetime' => 86400,
        'read_and_close'  => false,
    ]);
}

$rootPath = realpath(dirname(__DIR__, 2));
define('ROOT_PATH', $rootPath);
define('BASE_URL', 'http://localhost/santosh-portfolio-site');

// require_once ROOT_PATH . '/admin/includes/admin-header.php';

require_once ROOT_PATH . '/db.php';
require_once ROOT_PATH . '/includes/functions.php';


$error = '';
$token = $_GET['token'] ?? '';
$update_stmt = null; // ✅ This prevents the undefined variable warning


// Verify token
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    if (empty($password) || $password !== $confirm_password) {
        $error = 'Passwords do not match or are empty';
    } else {
        // Check token validity
        $sql = "SELECT id FROM admin_users WHERE reset_token = ? AND reset_token_expiry > NOW()";
        $stmt = db_query($sql, [$token]);
        
        if ($stmt && $stmt->get_result()->num_rows === 1) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Update password and clear token
            $update_sql = "UPDATE admin_users SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE reset_token = ?";
            $update_stmt = db_query($update_sql, [$hashed_password, $token]);
            
            if ($update_stmt) {
                $_SESSION['reset_success'] = true;
                header("Location: login.php");
                exit();
            } else {
                $error = 'Error updating password';
            }
        } else {
            $error = 'Invalid or expired token';
        }
    }
} elseif (!empty($token)) {
    // Verify token exists and is valid (GET request)
    $sql = "SELECT id FROM admin_users WHERE reset_token = ? AND reset_token_expiry > NOW()";
    $stmt = db_query($sql, [$token]);
    
    if (!$stmt || $stmt->get_result()->num_rows !== 1) {
        $error = 'Invalid or expired token';
    }
} else {
    $error = 'No token provided';
}

// In forgot-password.php, after generating the token:

if ($update_stmt) {
    $reset_link = "{$base_path}admin/login/reset-password.php?token=$token";

    // In production environment
    if ($environment === 'production') {
        require_once __DIR__ . '/../../includes/mailer.php';

        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = $mail_config['host'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $mail_config['username'];
            $mail->Password   = $mail_config['password'];
            $mail->SMTPSecure = $mail_config['encryption'];
            $mail->Port       = $mail_config['port'];

            // Recipients
            $mail->setFrom($mail_config['from_email'], $mail_config['from_name']);
            $mail->addAddress($email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $mail->Body    = "Click this link to reset your password: <a href='$reset_link'>Reset Password</a>";
            $mail->AltBody = "Copy this link to reset your password: $reset_link";

            $mail->send();
            $success = "Password reset link has been sent to your email.";
        } catch (Exception $e) {
            error_log("Message could not be sent. Mailer Error: {$mail->getError()}");
            $success = "Password reset link has been generated. Development link: <a href='$reset_link'>$reset_link</a>";
        }
    } else {
        // Development environment
        $success = "Password reset link has been generated. Development link: <a href='$reset_link'>$reset_link</a>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; height: 100vh; display: flex; align-items: center; }
        .reset-card { max-width: 500px; margin: 0 auto; border-radius: 10px; box-shadow: 0 0 20px rgba(0,0,0,0.1); }
        .reset-header { background-color: #343a40; color: white; padding: 20px; border-radius: 10px 10px 0 0; }
        .reset-body { padding: 30px; background: white; border-radius: 0 0 10px 10px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="reset-card">
            <div class="reset-header text-center">
                <h4><i class="fas fa-key"></i> Reset Password</h4>
            </div>
            <div class="reset-body">
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <div class="text-center">
                        <a href="forgot-password.php">Request new reset link</a>
                    </div>
                <?php else: ?>
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
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Reset Password</button>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>