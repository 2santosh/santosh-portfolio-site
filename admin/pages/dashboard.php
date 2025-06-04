<?php
session_start();

$rootPath = realpath(dirname(__DIR__, 2)); // Adjust as needed
define('ROOT_PATH', $rootPath);

require_once ROOT_PATH . '/db.php';
require_once ROOT_PATH . '/includes/functions.php';

if (!isset($mysqli)) {
    die("Database connection not initialized. Check db.php");
}

if (!isset($_SESSION['user_id'])) {
    header("Location: " . ROOT_PATH . "/login/login.php");
    exit();
}

$projectCount = getCount('projects');
$skillCount = getCount('skills');
$experienceCount = getCount('experience');
$messageCount = getCount('contact_messages', 'is_read = 0');

$recentActivities = getRecentActivities();
$recentMessages = getRecentMessages();

// Include admin header AFTER session and DB queries (to prevent header errors)
require_once __DIR__ . '/../includes/admin-header.php';

?>

<!-- Dashboard Content -->
<div class="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1><i class="fa fa-tachometer"></i> Dashboard</h1>
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="addNewDropdown" data-bs-toggle="dropdown">
                            <i class="fa fa-plus"></i> Add New
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="<?= $base_path ?>admin/pages/add-project.php">
                                <i class="fa fa-file"></i> Project
                            </a>
                            <a class="dropdown-item" href="<?= $base_path ?>admin/pages/add-skill.php">
                                <i class="fa fa-code"></i> Skill
                            </a>
                            <a class="dropdown-item" href="<?= $base_path ?>admin/pages/add-experience.php">
                                <i class="fa fa-briefcase"></i> Experience
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h5 class="card-title">Projects</h5>
                                        <h2 class="mb-0"><?= $projectCount ?></h2>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
                                </div>
                                <a href="<?= $base_path ?>admin/pages/work.php" class="btn btn-sm btn-link mt-2">View All</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h5 class="card-title">Skills</h5>
                                        <h2 class="mb-0"><?= $skillCount ?></h2>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fa fa-code"></i>
                                    </div>
                                </div>
                                <a href="<?= $base_path ?>admin/pages/skills.php" class="btn btn-sm btn-link mt-2">View All</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h5 class="card-title">Experience</h5>
                                        <h2 class="mb-0"><?= $experienceCount ?></h2>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fa fa-briefcase"></i>
                                    </div>
                                </div>
                                <a href="<?= $base_path ?>admin/pages/experience.php" class="btn btn-sm btn-link mt-2">View All</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h5 class="card-title">Messages</h5>
                                        <h2 class="mb-0"><?= $messageCount ?></h2>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fa fa-envelope"></i>
                                    </div>
                                </div>
                                <a href="<?= $base_path ?>admin/pages/messages.php" class="btn btn-sm btn-link mt-2">View All</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h4><i class="fa fa-history"></i> Recent Activity</h4>
                    </div>
                    <div class="card-body">
                        <?php if (count($recentActivities) > 0): ?>
                            <ul class="list-group list-group-flush">
                                <?php foreach ($recentActivities as $activity): ?>
                                    <li class="list-group-item">
                                        <i class="fa <?= htmlspecialchars($activity['icon']) ?> text-info"></i> 
                                        <?= htmlspecialchars($activity['description']) ?> - 
                                        <small class="text-muted"><?= date('M d, Y H:i', strtotime($activity['date'])) ?></small>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p>No recent activity found.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Recent Messages -->
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fa fa-envelope"></i> Recent Messages</h4>
                    </div>
                    <div class="card-body">
                        <?php if (count($recentMessages) > 0): ?>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Received At</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recentMessages as $msg): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($msg['name']) ?></td>
                                            <td><?= htmlspecialchars($msg['email']) ?></td>
                                            <td><?= date('M d, Y H:i', strtotime($msg['replied'])) ?></td>
                                            <td>
                                                <?php if ($msg['is_read'] == 0): ?>
                                                    <span class="badge bg-danger">Unread</span>
                                                <?php else: ?>
                                                    <span class="badge bg-success">Read</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="<?= $base_path ?>admin/pages/contact-messages.php?view=<?= $msg['id'] ?>" class="btn btn-sm btn-primary">
                                                    View
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p>No recent messages.</p>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Include footer -->
<?php require_once __DIR__ . '/../includes/admin-footer.php'; ?>

<!-- Dashboard specific JS -->
<script src="<?= $base_path ?>assets/js/bootstrap.bundle.min.js"></script>
<script src="<?= $base_path ?>assets/js/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $('.dropdown-toggle').dropdown();
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script>
