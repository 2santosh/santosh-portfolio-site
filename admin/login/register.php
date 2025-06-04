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
require_once ROOT_PATH . '/admin/includes/admin-header.php';

require_once ROOT_PATH . '/db.php';
require_once ROOT_PATH . '/includes/functions.php';

// If user already exists, redirect to login
$userCheck = $mysqli->query("SELECT COUNT(*) as user_count FROM admin_users");
$userData = $userCheck->fetch_assoc();
if ((int)$userData['user_count'] > 0) {
    header("Location: " . BASE_URL . "/admin/login.php");
    exit();
}

$error = '';
$username = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } elseif ($password !== $confirmPassword) {
        $error = "Passwords do not match.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $mysqli->prepare("INSERT INTO admin_users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashedPassword);

        if ($stmt->execute()) {
            $_SESSION['user_id'] = $stmt->insert_id;
            header("Location: " . BASE_URL . "/admin/dashboard.php");
            exit();
        } else {
            $error = "Registration failed. Username or email may already be in use.";
        }
    }
}
?>

<section id="admin-register">
    <div class="admin-container">
        <div class="admin-login-card">
            <div class="admin-login-header">
                <h4><i class="fas fa-user-plus"></i> Admin Registration</h4>
            </div>
            <div class="admin-login-body">
                <?php if (!empty($error)): ?>
                    <div class="admin-alert alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="admin-form-group mb-3">
                        <label for="username" class="admin-form-label">Username</label>
                        <input type="text" class="admin-form-control form-control" id="username" name="username"
                            value="<?php echo htmlspecialchars($username); ?>" required>
                    </div>

                    <div class="admin-form-group mb-3">
                        <label for="email" class="admin-form-label">Email</label>
                        <input type="email" class="admin-form-control form-control" id="email" name="email"
                            value="<?php echo htmlspecialchars($email); ?>" required>
                    </div>

                    <div class="admin-form-group mb-3">
                        <label for="password" class="admin-form-label">Password</label>
                        <input type="password" class="admin-form-control form-control" id="password" name="password" required>
                    </div>

                    <div class="admin-form-group mb-3">
                        <label for="confirm_password" class="admin-form-label">Confirm Password</label>
                        <input type="password" class="admin-form-control form-control" id="confirm_password" name="confirm_password" required>
                    </div>

                    <div class="admin-btn-wrapper d-grid mb-3">
                        <button type="submit" class="btn btn-success admin-btn-register">
                            <i class="fas fa-user-plus"></i> Register
                        </button>
                    </div>

                    <div class="admin-login-link text-center">
                        <a href="login.php">Back to Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php require_once ROOT_PATH . '/admin/includes/admin-footer.php'; ?>
