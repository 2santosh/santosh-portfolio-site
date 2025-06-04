<?php
require_once __DIR__ . '/../../db.php';// Adjust path as needed

// Check if table is empty
$result = $mysqli->query("SELECT COUNT(*) as count FROM admin_users");
$row = $result->fetch_assoc();
$isEmpty = ($row['count'] == 0);

if ($isEmpty && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process form submission
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    // Validate inputs
    if (empty($username) || empty($email) || empty($password)) {
        die("All fields are required");
    }
    
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert admin
    $stmt = $mysqli->prepare("INSERT INTO admin_users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashed_password);
    
    if ($stmt->execute()) {
        header("Location: login.php?setup=complete");
        exit();
    } else {
        die("Error creating admin: " . $mysqli->error);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Setup Admin Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php if ($isEmpty): ?>
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h4>Create First Admin Account</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                <div class="mb-3">
                                    <label class="form-label">Username</label>
                                    <input type="text" name="username" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Create Admin</button>
                            </form>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        Admin account already exists. <a href="login.php">Go to login</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>