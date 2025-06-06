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

// Fetch editing skill if applicable
$editingSkill = null;
if (isset($_GET['edit_skill'])) {
    $id = (int)$_GET['edit_skill'];
    $res = $mysqli->query("SELECT * FROM skills WHERE id=$id LIMIT 1");
    if ($res) {
        $editingSkill = $res->fetch_assoc();
    }
}

// Handle add/update skill
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $mysqli->real_escape_string($_POST['name']);
    $alt_text = $mysqli->real_escape_string($_POST['alt_text']);
    $image_url = '';

    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = ROOT_PATH . '/assets/images/skills/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $fileName = time() . '_' . basename($_FILES['image_file']['name']);
        $targetFile = $uploadDir . $fileName;
        $relativePath = '/assets/images/skills/' . $fileName; // make sure this matches your public folder

        if (move_uploaded_file($_FILES['image_file']['tmp_name'], $targetFile)) {
            $image_url = $mysqli->real_escape_string($relativePath);
        } else {
            $_SESSION['error'] = "Failed to upload image.";
            header("Location: skills.php");
            exit();
        }
    } elseif (isset($_POST['update_skill']) && $editingSkill) {
        $image_url = $mysqli->real_escape_string($editingSkill['image_url']);
    }

    if (isset($_POST['add_skill'])) {
        $sql = "INSERT INTO skills (name, image_url, alt_text) VALUES ('$name', '$image_url', '$alt_text')";
        if ($mysqli->query($sql)) {
            $_SESSION['message'] = "Skill added successfully!";
        } else {
            $_SESSION['error'] = "Error: " . $mysqli->error;
        }
        header("Location: skills.php");
        exit();
    }

    if (isset($_POST['update_skill'])) {
        $id = (int)$_POST['skill_id'];
        $sql = "UPDATE skills SET name='$name', image_url='$image_url', alt_text='$alt_text' WHERE id=$id";
        if ($mysqli->query($sql)) {
            $_SESSION['message'] = "Skill updated successfully!";
        } else {
            $_SESSION['error'] = "Error: " . $mysqli->error;
        }
        header("Location: skills.php");
        exit();
    }
}

// Handle delete
if (isset($_GET['delete_skill'])) {
    $id = (int)$_GET['delete_skill'];
    if ($mysqli->query("DELETE FROM skills WHERE id=$id")) {
        $_SESSION['message'] = "Skill deleted.";
    } else {
        $_SESSION['error'] = "Error deleting skill.";
    }
    header("Location: skills.php");
    exit();
}

// Fetch all skills
$skills = [];
$result = $mysqli->query("SELECT * FROM skills ORDER BY id DESC");
if ($result) {
    $skills = $result->fetch_all(MYSQLI_ASSOC);
}

require_once ROOT_PATH . '/admin/includes/admin-header.php';
?>

<div class="container py-4">
    <h2>Manage Skills</h2>

    <?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-success"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php elseif (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <form method="POST" class="mb-4" enctype="multipart/form-data">
        <?php if ($editingSkill): ?>
        <input type="hidden" name="skill_id" value="<?= $editingSkill['id'] ?>">
        <?php endif; ?>
        <div class="row g-3">
            <div class="col-md-4">
                <input type="text" name="name" class="form-control" placeholder="Skill name"
                    value="<?= $editingSkill ? htmlspecialchars($editingSkill['name']) : '' ?>" required>
            </div>
            <div class="col-md-4">
                <input type="file" name="image_file" class="form-control" <?= $editingSkill ? '' : 'required' ?>>
                <?php if ($editingSkill && !empty($editingSkill['image_url'])): ?>
                <small>Current image:
                    <img src="<?= htmlspecialchars($editingSkill['image_url']) ?>" alt="" height="32">
                </small>
                <?php endif; ?>
            </div>
            <div class="col-md-4">
                <input type="text" name="alt_text" class="form-control" placeholder="Alt text"
                    value="<?= $editingSkill ? htmlspecialchars($editingSkill['alt_text']) : '' ?>">
            </div>
        </div>
        <div class="mt-3">
            <?php if ($editingSkill): ?>
            <button type="submit" name="update_skill" class="btn btn-warning">Update Skill</button>
            <a href="skills.php" class="btn btn-secondary">Cancel</a>
            <?php else: ?>
            <button type="submit" name="add_skill" class="btn btn-success">Add Skill</button>
            <?php endif; ?>
        </div>
    </form>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Skill</th>
                <th>Logo</th>
                <th>Alt</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($skills as $skill): ?>
            <tr>
                <td><?= $skill['id'] ?></td>
                <td><?= htmlspecialchars($skill['name']) ?></td>
                <td>
                    <?php if (!empty($skill['image_url'])): ?>
                    <img src="/santosh-portfolio-site/<?= htmlspecialchars($skill['image_url']) ?>"
                        alt="<?= htmlspecialchars($skill['alt_text']) ?>" style="max-height: 100px;">
                    <?php else: ?>
                    No image
                    <?php endif; ?>
                </td>

                <td><?= htmlspecialchars($skill['alt_text']) ?></td>
                <td>
                    <a href="?edit_skill=<?= $skill['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                    <a href="?delete_skill=<?= $skill['id'] ?>" class="btn btn-sm btn-danger"
                        onclick="return confirm('Delete this skill?');">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($skills)): ?>
            <tr>
                <td colspan="5" class="text-center">No skills added yet.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once ROOT_PATH . '/admin/includes/admin-footer.php'; ?>