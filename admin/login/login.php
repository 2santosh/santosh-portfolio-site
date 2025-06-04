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

// Check if users exist in the database
$userCheck = $mysqli->query("SELECT COUNT(*) as user_count FROM admin_users");
$userData = $userCheck->fetch_assoc();

if ((int)$userData['user_count'] === 0) {
    // Redirect to registration if no users exist
    header("Location: " . BASE_URL . "/admin/login/register.php");
    exit();
}

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: " . BASE_URL . "/admin/dashboard.php");
    exit();
}

$error = '';
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $mysqli->prepare("SELECT id, username, password FROM admin_users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: " . BASE_URL . "/admin/dashboard.php");
            exit();
        } else {
            error_log("Password incorrect for user: $username");
        }
    }

    $error = "Invalid username or password.";
}
?>


<section id="admin-header">
    <div class="admin-container">
        <div class="admin-login-card">
            <div class="admin-login-header">
                <h4><i class="fas fa-lock"></i> Admin Login</h4>
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
                        <label for="password" class="admin-form-label">Password</label>
                        <input type="password" class="admin-form-control form-control" id="password" name="password" required>
                    </div>

                    <div class="admin-btn-wrapper d-grid mb-3">
                        <button type="submit" class="btn btn-primary admin-btn-login">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </button>
                    </div>

                    <div class="admin-forgot text-center">
                        <a href="adv-reset-password.php">Forgot Password?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>


<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php require_once ROOT_PATH . '/admin/includes/admin-footer.php'; ?>
