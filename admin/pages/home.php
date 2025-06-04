<?php
session_start();

$rootPath = realpath(dirname(__DIR__, 2)); // Adjust as needed
define('ROOT_PATH', $rootPath);

require_once ROOT_PATH . '/db.php';
require_once ROOT_PATH . '/includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: " . ROOT_PATH . "/login/login.php");
    exit();
}

// We only have one homepage_content row - load it or create it
$result = $mysqli->query("SELECT * FROM homepage_content LIMIT 1");
$homepageContent = $result ? $result->fetch_assoc() : null;

// If no homepage content yet, create default row
if (!$homepageContent) {
    $mysqli->query("INSERT INTO homepage_content (greeting, name, intro_text, image_path) VALUES ('Hello', 'Your Name', 'Welcome to my portfolio site!', 'assets/images/default.jpg')");
    $result = $mysqli->query("SELECT * FROM homepage_content LIMIT 1");
    $homepageContent = $result->fetch_assoc();
}

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update homepage content
    if (isset($_POST['update_homepage'])) {
        $greeting = $mysqli->real_escape_string($_POST['greeting']);
        $name = $mysqli->real_escape_string($_POST['name']);
        $intro_text = $mysqli->real_escape_string($_POST['intro_text']);
        $image_path = $mysqli->real_escape_string($_POST['image_path']);

        $id = (int)$_POST['homepage_content_id'];

        $sql = "UPDATE homepage_content SET greeting='$greeting', name='$name', intro_text='$intro_text', image_path='$image_path' WHERE id=$id";
        if ($mysqli->query($sql)) {
            $_SESSION['message'] = "Homepage content updated successfully!";
        } else {
            $_SESSION['error'] = "Error updating homepage content: " . $mysqli->error;
        }
        header("Location: home.php");
        exit();
    }

    // Add new social link
    if (isset($_POST['add_social_link'])) {
        $platform_name = $mysqli->real_escape_string($_POST['platform_name']);
        $url = $mysqli->real_escape_string($_POST['url']);
        $icon_class = $mysqli->real_escape_string($_POST['icon_class']);
        $homepage_content_id = (int)$_POST['homepage_content_id'];

        $sql = "INSERT INTO social_links (homepage_content_id, platform_name, url, icon_class) VALUES ($homepage_content_id, '$platform_name', '$url', '$icon_class')";
        if ($mysqli->query($sql)) {
            $_SESSION['message'] = "Social link added successfully!";
        } else {
            $_SESSION['error'] = "Error adding social link: " . $mysqli->error;
        }
        header("Location: home.php");
        exit();
    }

    // Update social link
    if (isset($_POST['update_social_link'])) {
        $id = (int)$_POST['social_link_id'];
        $platform_name = $mysqli->real_escape_string($_POST['platform_name']);
        $url = $mysqli->real_escape_string($_POST['url']);
        $icon_class = $mysqli->real_escape_string($_POST['icon_class']);

        $sql = "UPDATE social_links SET platform_name='$platform_name', url='$url', icon_class='$icon_class' WHERE id=$id";
        if ($mysqli->query($sql)) {
            $_SESSION['message'] = "Social link updated successfully!";
        } else {
            $_SESSION['error'] = "Error updating social link: " . $mysqli->error;
        }
        header("Location: home.php");
        exit();
    }
}

// Handle delete social link
if (isset($_GET['delete_social_link'])) {
    $id = (int)$_GET['delete_social_link'];
    if ($mysqli->query("DELETE FROM social_links WHERE id=$id")) {
        $_SESSION['message'] = "Social link deleted successfully!";
    } else {
        $_SESSION['error'] = "Error deleting social link: " . $mysqli->error;
    }
    header("Location: home.php");
    exit();
}

// Fetch updated homepage content again (after possible update)
$result = $mysqli->query("SELECT * FROM homepage_content LIMIT 1");
$homepageContent = $result ? $result->fetch_assoc() : null;

// Fetch social links related to homepage content
$socialLinks = [];
$result = $mysqli->query("SELECT * FROM social_links WHERE homepage_content_id = " . (int)$homepageContent['id'] . " ORDER BY id DESC");
if ($result) {
    $socialLinks = $result->fetch_all(MYSQLI_ASSOC);
    $result->free();
}

// Check if editing social link
$editingSocialLink = null;
if (isset($_GET['edit_social_link'])) {
    $id = (int)$_GET['edit_social_link'];
    $stmt = $mysqli->prepare("SELECT * FROM social_links WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $editingSocialLink = $res->fetch_assoc();
    $stmt->close();
}

require_once ROOT_PATH . '/admin/includes/admin-header.php';
?>

<div class="container py-4">
    <h2>Edit Homepage Content</h2>
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
        <input type="hidden" name="homepage_content_id" value="<?= $homepageContent['id'] ?>">
        <div class="mb-3">
            <label class="form-label">Greeting</label>
            <input type="text" name="greeting" class="form-control" required value="<?= htmlspecialchars($homepageContent['greeting']) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($homepageContent['name']) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Intro Text</label>
            <textarea name="intro_text" class="form-control" rows="4" required><?= htmlspecialchars($homepageContent['intro_text']) ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Image Path</label>
            <input type="text" name="image_path" class="form-control" required value="<?= htmlspecialchars($homepageContent['image_path']) ?>">
            <small class="form-text text-muted">Example: assets/images/homepage.jpg</small>
        </div>
        <button type="submit" name="update_homepage" class="btn btn-primary">Update Homepage Content</button>
    </form>

    <hr>

    <h2>Manage Social Links</h2>

    <!-- Social Link Add/Edit Form -->
    <form method="POST" class="mb-4">
        <?php if ($editingSocialLink): ?>
            <input type="hidden" name="social_link_id" value="<?= $editingSocialLink['id'] ?>">
        <?php endif; ?>
        <input type="hidden" name="homepage_content_id" value="<?= $homepageContent['id'] ?>">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Platform Name</label>
                <input type="text" name="platform_name" class="form-control" required
                    value="<?= $editingSocialLink ? htmlspecialchars($editingSocialLink['platform_name']) : '' ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">URL</label>
                <input type="url" name="url" class="form-control" required
                    value="<?= $editingSocialLink ? htmlspecialchars($editingSocialLink['url']) : '' ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Icon Class</label>
                <input type="text" name="icon_class" class="form-control" required
                    value="<?= $editingSocialLink ? htmlspecialchars($editingSocialLink['icon_class']) : '' ?>">
                <small class="form-text text-muted">Example: fab fa-facebook</small>
            </div>
            <div class="col-md-2">
                <?php if ($editingSocialLink): ?>
                    <button type="submit" name="update_social_link" class="btn btn-warning">Update Link</button>
                    <a href="home.php" class="btn btn-secondary">Cancel</a>
                <?php else: ?>
                    <button type="submit" name="add_social_link" class="btn btn-success">Add Link</button>
                <?php endif; ?>
            </div>
        </div>
    </form>

    <!-- Social Links Table -->
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Platform</th>
                <th>URL</th>
                <th>Icon</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($socialLinks as $link): ?>
                <tr>
                    <td><?= $link['id'] ?></td>
                    <td><?= htmlspecialchars($link['platform_name']) ?></td>
                    <td><a href="<?= htmlspecialchars($link['url']) ?>" target="_blank"><?= htmlspecialchars($link['url']) ?></a></td>
                    <td><i class="<?= htmlspecialchars($link['icon_class']) ?>"></i> <?= htmlspecialchars($link['icon_class']) ?></td>
                    <td>
                        <a href="?edit_social_link=<?= $link['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                        <a href="?delete_social_link=<?= $link['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this social link?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($socialLinks)): ?>
                <tr><td colspan="5" class="text-center">No social links found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once ROOT_PATH . '/admin/includes/admin-footer.php'; ?>
