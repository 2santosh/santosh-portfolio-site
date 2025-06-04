<?php
session_start();

$rootPath = realpath(dirname(__DIR__, 2));
define('ROOT_PATH', $rootPath);

require_once ROOT_PATH . '/db.php';
require_once ROOT_PATH . '/includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: " . ROOT_PATH . "/login/login.php");
    exit();
}

// Helper to convert "YYYY-MM" string to DATE format for SQL
function convertToDate($str) {
    // Input like "2024-07"
    return $str ? $str . '-01' : null; // first day of month as date
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $mysqli->real_escape_string($_POST['title']);
    $company = $mysqli->real_escape_string($_POST['company']);
    $location = $mysqli->real_escape_string($_POST['location']);
    $start_date = convertToDate($_POST['start_date']);
    $end_date = convertToDate($_POST['end_date']);
    $description = $mysqli->real_escape_string($_POST['description']);

    if (isset($_POST['add_experience'])) {
        $sql = "INSERT INTO experience (title, company, location, start_date, end_date, description) 
                VALUES ('$title', '$company', '$location', '$start_date', '$end_date', '$description')";
        $mysqli->query($sql);
        $_SESSION['message'] = "Experience added!";
        header("Location: experience.php");
        exit();
    }

    if (isset($_POST['update_experience'])) {
        $id = (int)$_POST['experience_id'];
        $sql = "UPDATE experience SET title='$title', company='$company', location='$location', start_date='$start_date', end_date='$end_date', description='$description' WHERE id=$id";
        $mysqli->query($sql);
        $_SESSION['message'] = "Experience updated!";
        header("Location: experience.php");
        exit();
    }
}

if (isset($_GET['delete_experience'])) {
    $id = (int)$_GET['delete_experience'];
    $mysqli->query("DELETE FROM experience WHERE id=$id");
    $_SESSION['message'] = "Experience deleted!";
    header("Location: experience.php");
    exit();
}

$editingExperience = null;
if (isset($_GET['edit_experience'])) {
    $id = (int)$_GET['edit_experience'];
    $res = $mysqli->query("SELECT * FROM experience WHERE id=$id");
    $editingExperience = $res->fetch_assoc();
}

$experiences = [];
$res = $mysqli->query("SELECT * FROM experience ORDER BY start_date DESC");
if ($res) $experiences = $res->fetch_all(MYSQLI_ASSOC);

require_once ROOT_PATH . '/admin/includes/admin-header.php';
?>

<div class="container py-4">
    <h2>Manage Experience</h2>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_SESSION['message']) ?></div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <form method="POST" class="mb-4">
        <?php if ($editingExperience): ?>
            <input type="hidden" name="experience_id" value="<?= $editingExperience['id'] ?>">
        <?php endif; ?>

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Title / Position</label>
                <input type="text" name="title" class="form-control" required value="<?= htmlspecialchars($editingExperience['title'] ?? '') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Company</label>
                <input type="text" name="company" class="form-control" required value="<?= htmlspecialchars($editingExperience['company'] ?? '') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Location</label>
                <input type="text" name="location" class="form-control" value="<?= htmlspecialchars($editingExperience['location'] ?? '') ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Start Date (YYYY-MM)</label>
                <input type="month" name="start_date" class="form-control" required
                    value="<?= !empty($editingExperience['start_date']) ? date('Y-m', strtotime($editingExperience['start_date'])) : '' ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">End Date (YYYY-MM)</label>
                <input type="month" name="end_date" class="form-control"
                    value="<?= !empty($editingExperience['end_date']) ? date('Y-m', strtotime($editingExperience['end_date'])) : '' ?>">
            </div>
            <div class="col-md-12">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($editingExperience['description'] ?? '') ?></textarea>
            </div>

            <div class="col-md-12">
                <?php if ($editingExperience): ?>
                    <button type="submit" name="update_experience" class="btn btn-warning">Update</button>
                    <a href="experience.php" class="btn btn-secondary">Cancel</a>
                <?php else: ?>
                    <button type="submit" name="add_experience" class="btn btn-success">Add Experience</button>
                <?php endif; ?>
            </div>
        </div>
    </form>

    <hr>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Company & Location</th>
                <th>Duration</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($experiences as $exp): ?>
                <tr>
                    <td><?= htmlspecialchars($exp['title']) ?></td>
                    <td>
                        <?= htmlspecialchars($exp['company']) ?><br>
                        <small><?= htmlspecialchars($exp['location']) ?></small>
                    </td>
                    <td>
                        <?= date('M, Y', strtotime($exp['start_date'])) ?> -
                        <?= $exp['end_date'] ? date('M, Y', strtotime($exp['end_date'])) : 'Present' ?>
                    </td>
                    <td><?= nl2br(htmlspecialchars($exp['description'])) ?></td>
                    <td>
                        <a href="?edit_experience=<?= $exp['id'] ?>" class="btn btn-sm btn-info">Edit</a>
                        <a href="?delete_experience=<?= $exp['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this experience?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>

            <?php if (empty($experiences)): ?>
                <tr><td colspan="5" class="text-center">No experience records found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once ROOT_PATH . '/admin/includes/admin-footer.php'; ?>
