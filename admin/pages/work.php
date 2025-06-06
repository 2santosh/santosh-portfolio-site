<?php
session_start();

$maxUploadSize = 256 * 1024 * 1024; // 256 MB limit

// Pre-check to stop processing if POST content size exceeds limit
if (isset($_SERVER['CONTENT_LENGTH']) && $_SERVER['CONTENT_LENGTH'] > $maxUploadSize) {
    $_SESSION['message'] = "Uploaded file is too large. Maximum allowed size is 256 MB.";
    header("Location: work.php");
    exit();
}

$rootPath = realpath(dirname(__DIR__, 2));
define('ROOT_PATH', $rootPath);
define('BASE_URL', '/');

require_once ROOT_PATH . '/db.php';
require_once ROOT_PATH . '/includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: " . BASE_URL . "login/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_project'])) {
        $title = $mysqli->real_escape_string($_POST['title']);
        $description = $mysqli->real_escape_string($_POST['description']);
        $code_url = $mysqli->real_escape_string($_POST['code_url']);

        $imagePath = 'assets/images/projects/default.png';

        if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['image_file']['tmp_name'];
            $fileMimeType = mime_content_type($fileTmpPath);
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

            if (in_array($fileMimeType, $allowedTypes)) {
                $imageName = basename($_FILES['image_file']['name']);
                $targetDir = ROOT_PATH . '/assets/images/projects/';
                $imageName = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $imageName);
                $targetFile = $targetDir . $imageName;

                if (move_uploaded_file($fileTmpPath, $targetFile)) {
                    $imagePath = 'assets/images/projects/' . $imageName;
                } else {
                    $_SESSION['message'] = "Error moving uploaded file.";
                    header("Location: work.php");
                    exit();
                }
            } else {
                $_SESSION['message'] = "Invalid image type. Allowed types: JPG, PNG, GIF.";
                header("Location: work.php");
                exit();
            }
        }

        $sql = "INSERT INTO projects (title, description, image, view_url, code_url) 
                VALUES ('$title', '$description', '$imagePath', '', '$code_url')";
        $mysqli->query($sql);

        $_SESSION['message'] = "Project added!";
        header("Location: work.php");
        exit();
    }

    if (isset($_POST['update_project'])) {
        $id = (int)$_POST['project_id'];
        $title = $mysqli->real_escape_string($_POST['title']);
        $description = $mysqli->real_escape_string($_POST['description']);
        $code_url = $mysqli->real_escape_string($_POST['code_url']);

        $imageUpdate = "";

        if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['image_file']['tmp_name'];
            $fileMimeType = mime_content_type($fileTmpPath);
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

            if (in_array($fileMimeType, $allowedTypes)) {
                $imageName = basename($_FILES['image_file']['name']);
                $targetDir = ROOT_PATH . '/assets/images/projects/';
                $imageName = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $imageName);
                $targetFile = $targetDir . $imageName;

                if (move_uploaded_file($fileTmpPath, $targetFile)) {
                    $imagePath = 'assets/images/projects/' . $imageName;
                    $imageUpdate = ", image='$imagePath'";
                } else {
                    $_SESSION['message'] = "Error moving uploaded file.";
                    header("Location: work.php");
                    exit();
                }
            } else {
                $_SESSION['message'] = "Invalid image type. Allowed types: JPG, PNG, GIF.";
                header("Location: work.php");
                exit();
            }
        }

        $sql = "UPDATE projects SET title='$title', description='$description', code_url='$code_url' $imageUpdate WHERE id=$id";
        $mysqli->query($sql);

        $_SESSION['message'] = "Project updated!";
        header("Location: work.php");
        exit();
    }
}

if (isset($_GET['delete_project'])) {
    $id = (int)$_GET['delete_project'];
    $mysqli->query("DELETE FROM projects WHERE id=$id");
    $_SESSION['message'] = "Project deleted!";
    header("Location: work.php");
    exit();
}

$editingProject = null;
if (isset($_GET['edit_project'])) {
    $id = (int)$_GET['edit_project'];
    $res = $mysqli->query("SELECT * FROM projects WHERE id=$id");
    $editingProject = $res->fetch_assoc();
}

$projects = [];
$res = $mysqli->query("SELECT * FROM projects ORDER BY id DESC");
if ($res) $projects = $res->fetch_all(MYSQLI_ASSOC);

require_once ROOT_PATH . '/admin/includes/admin-header.php';
?>

<div class="container py-4">
    <h2>Manage Projects</h2>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_SESSION['message']) ?></div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <form method="POST" class="mb-4" enctype="multipart/form-data">
        <?php if ($editingProject): ?>
            <input type="hidden" name="project_id" value="<?= (int)$editingProject['id'] ?>">
        <?php endif; ?>
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" required value="<?= htmlspecialchars($editingProject['title'] ?? '') ?>">
            </div>
            <div class="col-md-8">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="2"><?= htmlspecialchars($editingProject['description'] ?? '') ?></textarea>
            </div>
            <div class="col-md-4">
                <label class="form-label">Image Upload <?= $editingProject ? '(leave blank to keep current image)' : '' ?></label>
                <input type="file" name="image_file" class="form-control" <?= $editingProject ? '' : 'required' ?>>
                <?php if ($editingProject && !empty($editingProject['image'])): ?>
                    <img src="<?= BASE_URL . htmlspecialchars($editingProject['image']) ?>" alt="<?= htmlspecialchars($editingProject['title']) ?>" onerror="this.src='<?= BASE_URL ?>assets/images/logo.png';" width="100" class="mt-2">
                <?php endif; ?>
            </div>
            <div class="col-md-4">
                <label class="form-label">Code URL</label>
                <input type="url" name="code_url" class="form-control" value="<?= htmlspecialchars($editingProject['code_url'] ?? '') ?>">
            </div>
            <div class="col-md-12">
                <?php if ($editingProject): ?>
                    <button type="submit" name="update_project" class="btn btn-warning">Update</button>
                    <a href="work.php" class="btn btn-secondary">Cancel</a>
                <?php else: ?>
                    <button type="submit" name="add_project" class="btn btn-success">Add Project</button>
                <?php endif; ?>
            </div>
        </div>
    </form>

    <hr>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Image</th>
                <th>Title & Description</th>
                <th>Code</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($projects as $project): ?>
            <tr>
                <td>
                    <?php if (!empty($project['image'])): ?>
                    <img src="/santosh-portfolio-site/<?= BASE_URL . htmlspecialchars($project['image']) ?>"
                        alt="<?= htmlspecialchars($project['title']) ?>" style="max-height: 100px;">
                    <?php else: ?>
                    No image
                    <?php endif; ?>
                </td>
                <td>
                    <strong><?= htmlspecialchars($project['title']) ?></strong><br>
                    <small><?= htmlspecialchars($project['description']) ?></small>
                </td>
                <td>
                    <a href="<?= htmlspecialchars($project['code_url']) ?>" target="_blank" class="btn btn-sm btn-secondary">Code</a>
                </td>
                <td>
                    <a href="?edit_project=<?= (int)$project['id'] ?>" class="btn btn-sm btn-info">Edit</a>
                    <a href="?delete_project=<?= (int)$project['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this project?');">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if (empty($projects)): ?>
            <tr><td colspan="4" class="text-center">No projects found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once ROOT_PATH . '/admin/includes/admin-footer.php'; ?>
