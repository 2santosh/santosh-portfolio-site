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

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Add education
    if (isset($_POST['add_education'])) {
        $title = $mysqli->real_escape_string($_POST['title']);
        $institution = $mysqli->real_escape_string($_POST['institution']);
        $location = $mysqli->real_escape_string($_POST['location']);
        $image = $mysqli->real_escape_string($_POST['image']);
        $timeline = $mysqli->real_escape_string($_POST['timeline']);
        $status = $mysqli->real_escape_string($_POST['status']);

        $sql = "INSERT INTO education (title, institution, location, image, timeline, status)
                VALUES ('$title', '$institution', '$location', '$image', '$timeline', '$status')";

        if ($mysqli->query($sql)) {
            $_SESSION['message'] = "Education record added successfully!";
        } else {
            $_SESSION['error'] = "Error adding education: " . $mysqli->error;
        }
        header("Location: education.php");
        exit();
    }

    // Update education
    if (isset($_POST['update_education'])) {
        $id = (int)$_POST['education_id'];
        $title = $mysqli->real_escape_string($_POST['title']);
        $institution = $mysqli->real_escape_string($_POST['institution']);
        $location = $mysqli->real_escape_string($_POST['location']);
        $image = $mysqli->real_escape_string($_POST['image']);
        $timeline = $mysqli->real_escape_string($_POST['timeline']);
        $status = $mysqli->real_escape_string($_POST['status']);

        $sql = "UPDATE education SET title='$title', institution='$institution', location='$location',
                image='$image', timeline='$timeline', status='$status' WHERE id=$id";

        if ($mysqli->query($sql)) {
            $_SESSION['message'] = "Education record updated successfully!";
        } else {
            $_SESSION['error'] = "Error updating education: " . $mysqli->error;
        }
        header("Location: education.php");
        exit();
    }
}

// Delete education
if (isset($_GET['delete_education'])) {
    $id = (int)$_GET['delete_education'];
    if ($mysqli->query("DELETE FROM education WHERE id=$id")) {
        $_SESSION['message'] = "Education record deleted successfully!";
    } else {
        $_SESSION['error'] = "Error deleting education: " . $mysqli->error;
    }
    header("Location: education.php");
    exit();
}

// Fetch all education records
$educationEntries = [];
$result = $mysqli->query("SELECT * FROM education ORDER BY id DESC");
if ($result) {
    $educationEntries = $result->fetch_all(MYSQLI_ASSOC);
    $result->free();
}

// Editing entry
$editingEducation = null;
if (isset($_GET['edit_education'])) {
    $id = (int)$_GET['edit_education'];
    $stmt = $mysqli->prepare("SELECT * FROM education WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $editingEducation = $res->fetch_assoc();
    $stmt->close();
}

require_once ROOT_PATH . '/admin/includes/admin-header.php';
?>

<div class="container py-4">
    <h2>Manage Education Section</h2>
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success"> <?= htmlspecialchars($_SESSION['message']) ?> </div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"> <?= htmlspecialchars($_SESSION['error']) ?> </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <!-- Add/Edit Form -->
    <form method="POST">
        <?php if ($editingEducation): ?>
            <input type="hidden" name="education_id" value="<?= $editingEducation['id'] ?>">
        <?php endif; ?>
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" required value="<?= $editingEducation ? htmlspecialchars($editingEducation['title']) : '' ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Institution</label>
            <input type="text" name="institution" class="form-control" required value="<?= $editingEducation ? htmlspecialchars($editingEducation['institution']) : '' ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Location</label>
            <input type="text" name="location" class="form-control" value="<?= $editingEducation ? htmlspecialchars($editingEducation['location']) : '' ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Image Path</label>
            <input type="text" name="image" class="form-control" value="<?= $editingEducation ? htmlspecialchars($editingEducation['image']) : '' ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Timeline</label>
            <input type="text" name="timeline" class="form-control" value="<?= $editingEducation ? htmlspecialchars($editingEducation['timeline']) : '' ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Status</label>
            <input type="text" name="status" class="form-control" value="<?= $editingEducation ? htmlspecialchars($editingEducation['status']) : '' ?>">
        </div>
        <button type="submit" name="<?= $editingEducation ? 'update_education' : 'add_education' ?>" class="btn btn-<?= $editingEducation ? 'warning' : 'success' ?>">
            <?= $editingEducation ? 'Update' : 'Add' ?> Education
        </button>
        <?php if ($editingEducation): ?>
            <a href="education.php" class="btn btn-secondary">Cancel</a>
        <?php endif; ?>
    </form>

    <!-- Display Table -->
    <hr>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Institution</th>
                <th>Location</th>
                <th>Image</th>
                <th>Timeline</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($educationEntries as $entry): ?>
                <tr>
                    <td><?= $entry['id'] ?></td>
                    <td><?= htmlspecialchars($entry['title']) ?></td>
                    <td><?= htmlspecialchars($entry['institution']) ?></td>
                    <td><?= htmlspecialchars($entry['location']) ?></td>
                    <td><img src="<?= htmlspecialchars($entry['image']) ?>" alt="" height="50"></td>
                    <td><?= htmlspecialchars($entry['timeline']) ?></td>
                    <td><?= htmlspecialchars($entry['status']) ?></td>
                    <td>
                        <a href="?edit_education=<?= $entry['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                        <a href="?delete_education=<?= $entry['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this education entry?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($educationEntries)): ?>
                <tr><td colspan="8" class="text-center">No education records found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once ROOT_PATH . '/admin/includes/admin-footer.php'; ?>