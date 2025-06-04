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

// Fetch or create default about_me_content
$result = $mysqli->query("SELECT * FROM about_me_content LIMIT 1");
$aboutMeContent = $result ? $result->fetch_assoc() : null;

if (!$aboutMeContent) {
    $mysqli->query("INSERT INTO about_me_content (name, role, description, image_path, email, location)
                   VALUES ('Your Name', 'Your Role', 'A short description...', 'assets/images/imgg.avif', 'example@email.com', 'Your Location')");
    $result = $mysqli->query("SELECT * FROM about_me_content LIMIT 1");
    $aboutMeContent = $result->fetch_assoc();
}

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update about_me_content
    if (isset($_POST['update_about_me'])) {
        $name = $mysqli->real_escape_string($_POST['name']);
        $role = $mysqli->real_escape_string($_POST['role']);
        $description = $mysqli->real_escape_string($_POST['description']);
        $image_path = $mysqli->real_escape_string($_POST['image_path']);
        $email = $mysqli->real_escape_string($_POST['email']);
        $location = $mysqli->real_escape_string($_POST['location']);

        $id = (int)$_POST['about_me_content_id'];

        $sql = "UPDATE about_me_content SET name='$name', role='$role', description='$description',
                image_path='$image_path', email='$email', location='$location' WHERE id=$id";

        if ($mysqli->query($sql)) {
            $_SESSION['message'] = "About Me content updated successfully!";
        } else {
            $_SESSION['error'] = "Error updating About Me content: " . $mysqli->error;
        }
        header("Location: about.php");
        exit();
    }

    // Add or update about_me_link
    if (isset($_POST['add_about_link']) || isset($_POST['update_about_link'])) {
        $link_text = $mysqli->real_escape_string($_POST['link_text']);
        $url = $mysqli->real_escape_string($_POST['url']);
        $icon_class = $mysqli->real_escape_string($_POST['icon_class']);
        $about_me_content_id = (int)$_POST['about_me_content_id'];

        if (isset($_POST['update_about_link'])) {
            $id = (int)$_POST['about_link_id'];
            $sql = "UPDATE about_me_links SET link_text='$link_text', url='$url', icon_class='$icon_class' WHERE id=$id";
        } else {
            $sql = "INSERT INTO about_me_links (about_me_content_id, link_text, url, icon_class)
                    VALUES ($about_me_content_id, '$link_text', '$url', '$icon_class')";
        }

        if ($mysqli->query($sql)) {
            $_SESSION['message'] = isset($_POST['update_about_link']) ? "Link updated successfully!" : "Link added successfully!";
        } else {
            $_SESSION['error'] = "Error saving link: " . $mysqli->error;
        }
        header("Location: about.php");
        exit();
    }
}

// Handle delete link
if (isset($_GET['delete_about_link'])) {
    $id = (int)$_GET['delete_about_link'];
    if ($mysqli->query("DELETE FROM about_me_links WHERE id=$id")) {
        $_SESSION['message'] = "Link deleted successfully!";
    } else {
        $_SESSION['error'] = "Error deleting link: " . $mysqli->error;
    }
    header("Location: about.php");
    exit();
}

// Fetch links
$aboutLinks = [];
$result = $mysqli->query("SELECT * FROM about_me_links WHERE about_me_content_id = " . (int)$aboutMeContent['id'] . " ORDER BY id DESC");
if ($result) {
    $aboutLinks = $result->fetch_all(MYSQLI_ASSOC);
    $result->free();
}

// Fetch for editing
$editingLink = null;
if (isset($_GET['edit_about_link'])) {
    $id = (int)$_GET['edit_about_link'];
    $stmt = $mysqli->prepare("SELECT * FROM about_me_links WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $editingLink = $res->fetch_assoc();
    $stmt->close();
}

require_once ROOT_PATH . '/admin/includes/admin-header.php';
?>

<div class="container py-4">
    <h2>Edit About Me Section</h2>
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_SESSION['message']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_SESSION['error']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form method="POST" class="mb-5">
        <input type="hidden" name="about_me_content_id" value="<?= $aboutMeContent['id'] ?>">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($aboutMeContent['name']) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Role</label>
            <input type="text" name="role" class="form-control" required value="<?= htmlspecialchars($aboutMeContent['role']) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4" required><?= htmlspecialchars($aboutMeContent['description']) ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Image Path</label>
            <input type="text" name="image_path" class="form-control" required value="<?= htmlspecialchars($aboutMeContent['image_path']) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($aboutMeContent['email']) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Location</label>
            <input type="text" name="location" class="form-control" required value="<?= htmlspecialchars($aboutMeContent['location']) ?>">
        </div>
        <button type="submit" name="update_about_me" class="btn btn-primary">Update</button>
    </form>

    <hr>
    <h3>Manage About Me Links</h3>
    <form method="POST" class="mb-4">
        <?php if ($editingLink): ?>
            <input type="hidden" name="about_link_id" value="<?= $editingLink['id'] ?>">
        <?php endif; ?>
        <input type="hidden" name="about_me_content_id" value="<?= $aboutMeContent['id'] ?>">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Link Text</label>
                <input type="text" name="link_text" class="form-control" required value="<?= $editingLink ? htmlspecialchars($editingLink['link_text']) : '' ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">URL</label>
                <input type="url" name="url" class="form-control" required value="<?= $editingLink ? htmlspecialchars($editingLink['url']) : '' ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Icon Class</label>
                <input type="text" name="icon_class" class="form-control" required value="<?= $editingLink ? htmlspecialchars($editingLink['icon_class']) : '' ?>">
            </div>
            <div class="col-md-2">
                <?php if ($editingLink): ?>
                    <button type="submit" name="update_about_link" class="btn btn-warning">Update</button>
                    <a href="about.php" class="btn btn-secondary">Cancel</a>
                <?php else: ?>
                    <button type="submit" name="add_about_link" class="btn btn-success">Add</button>
                <?php endif; ?>
            </div>
        </div>
    </form>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Text</th>
                <th>URL</th>
                <th>Icon</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($aboutLinks as $link): ?>
                <tr>
                    <td><?= $link['id'] ?></td>
                    <td><?= htmlspecialchars($link['link_text']) ?></td>
                    <td><a href="<?= htmlspecialchars($link['url']) ?>" target="_blank"><?= htmlspecialchars($link['url']) ?></a></td>
                    <td><i class="<?= htmlspecialchars($link['icon_class']) ?>"></i> <?= htmlspecialchars($link['icon_class']) ?></td>
                    <td>
                        <a href="?edit_about_link=<?= $link['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                        <a href="?delete_about_link=<?= $link['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this link?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($aboutLinks)): ?>
                <tr><td colspan="5" class="text-center">No links found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once ROOT_PATH . '/admin/includes/admin-footer.php'; ?>
