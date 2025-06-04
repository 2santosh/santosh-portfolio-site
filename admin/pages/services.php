<?php
// Set the root path correctly
$rootPath = realpath(dirname(__DIR__)); // Goes up 1 level to /portfolio-site/admin/
define('ADMIN_ROOT', $rootPath);

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once ADMIN_ROOT . '/includes/admin-header.php';
require_once dirname(ADMIN_ROOT) . '/db.php'; // This should contain your $pdo connection
// require_once dirname(ADMIN_ROOT) . '/includes/functions.php';

// Verify $pdo connection exists
if (!isset($pdo) || !($pdo instanceof PDO)) {
    die("Database connection not properly initialized");
}
function createSlug($string) {
    $slug = preg_replace('/[^a-z0-9]+/', '-', strtolower($string));
    $slug = trim($slug, '-');
    return $slug;
}

// Configuration
$uploadDir = dirname(ADMIN_ROOT) . '/uploads/services/';
$webUploadDir = '/uploads/services/';
$allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
$maxSize = 5 * 1024 * 1024; // 5MB

// Create upload directory if needed
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validate inputs
        $title = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING));
        $slug = createSlug($title);
        $shortDescription = trim(filter_input(INPUT_POST, 'short_description', FILTER_SANITIZE_STRING));
        $fullDescription = trim(filter_input(INPUT_POST, 'full_description', FILTER_SANITIZE_STRING));
        $category = trim(filter_input(INPUT_POST, 'category', FILTER_SANITIZE_STRING));
        $priceRange = trim(filter_input(INPUT_POST, 'price_range', FILTER_SANITIZE_STRING));
        $deliveryTime = trim(filter_input(INPUT_POST, 'estimated_delivery', FILTER_SANITIZE_STRING));
        $metaTitle = trim(filter_input(INPUT_POST, 'meta_title', FILTER_SANITIZE_STRING));
        $metaDescription = trim(filter_input(INPUT_POST, 'meta_description', FILTER_SANITIZE_STRING));
        $displayOrder = intval(filter_input(INPUT_POST, 'display_order', FILTER_SANITIZE_NUMBER_INT));
        $isFeatured = isset($_POST['is_featured']) ? 1 : 0;

        // Validate required fields
        if (empty($title) || empty($shortDescription)) {
            throw new Exception('Title and short description are required');
        }

        // Process file uploads
        $iconFilename = processUploadedFile('icon_image', true);
        $coverFilename = processUploadedFile('cover_image', false);

        // Insert into database
        $stmt = $pdo->prepare("
            INSERT INTO services (
                title, slug, short_description, full_description, 
                icon_filename, cover_image, image_path, display_order, 
                is_featured, service_category, price_range, estimated_delivery,
                meta_title, meta_description, created_at, updated_at
            ) VALUES (
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW()
            )
        ");
        
        $stmt->execute([
            $title, $slug, $shortDescription, $fullDescription,
            $iconFilename, $coverFilename, $webUploadDir, $displayOrder,
            $isFeatured, $category, $priceRange, $deliveryTime,
            $metaTitle, $metaDescription
        ]);

        $_SESSION['success_message'] = "Service added successfully!";
        header("Location: services-list.php");
        exit();

    } catch (PDOException $e) {
        $error = "Database error: " . $e->getMessage();
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

/**
 * Processes uploaded file
 */
function processUploadedFile($fieldName, $isRequired = false) {
    global $uploadDir, $allowedTypes, $maxSize;

    if ($isRequired && empty($_FILES[$fieldName]['name'])) {
        throw new Exception(ucfirst($fieldName) . ' is required');
    }

    if (!empty($_FILES[$fieldName]['name'])) {
        $file = $_FILES[$fieldName];
        
        // Verify error code
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('File upload error: ' . $file['error']);
        }

        // Verify MIME type
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);
        
        if (!in_array($mime, $allowedTypes)) {
            throw new Exception('Invalid file type. Allowed: ' . implode(', ', $allowedTypes));
        }

        // Verify file size
        if ($file['size'] > $maxSize) {
            throw new Exception('File too large. Max size: ' . formatBytes($maxSize));
        }

        // Generate safe filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = sprintf('%s-%s.%s',
            $fieldName,
            bin2hex(random_bytes(8)),
            $extension
        );

        // Move uploaded file
        if (!move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
            throw new Exception('Failed to move uploaded file');
        }

        return $filename;
    }

    return null;
}

/**
 * Format bytes to human-readable format
 */
function formatBytes($bytes, $precision = 2) {
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= pow(1024, $pow);
    return round($bytes, $precision) . ' ' . $units[$pow];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Service</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 2rem;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .required-field::after {
            content: " *";
            color: red;
        }
    </style>
</head>
<body>
    <?php 
    if (file_exists(ADMIN_ROOT . '/includes/admin-navbar.php')) {
        include ADMIN_ROOT . '/includes/admin-navbar.php';
    }
    ?>
    
    <div class="container-fluid">
        <div class="row">
            <?php 
            if (file_exists(ADMIN_ROOT . '/includes/admin-sidebar.php')) {
                include ADMIN_ROOT . '/includes/admin-sidebar.php';
            }
            ?>
            
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="form-container">
                    <h2 class="mb-4">Add New Service</h2>
                    
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>
                    
                    <form method="POST" enctype="multipart/form-data">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label required-field">Service Title</label>
                                    <input type="text" name="title" class="form-control" required
                                           value="<?= htmlspecialchars($_POST['title'] ?? '') ?>">
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label required-field">Short Description</label>
                                    <textarea name="short_description" class="form-control" rows="3" required><?= 
                                        htmlspecialchars($_POST['short_description'] ?? '') 
                                    ?></textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Full Description</label>
                                    <textarea name="full_description" class="form-control" rows="5"><?= 
                                        htmlspecialchars($_POST['full_description'] ?? '') 
                                    ?></textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Category</label>
                                    <input type="text" name="category" class="form-control"
                                           value="<?= htmlspecialchars($_POST['category'] ?? '') ?>">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label required-field">Icon Image</label>
                                    <input type="file" name="icon_image" class="form-control" accept="image/*" required>
                                    <small class="text-muted">Max <?= formatBytes($maxSize) ?> (JPEG, PNG, GIF, WEBP)</small>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Cover Image</label>
                                    <input type="file" name="cover_image" class="form-control" accept="image/*">
                                    <small class="text-muted">Optional - Max <?= formatBytes($maxSize) ?></small>
                                </div>
                                
                                <div class="row g-2">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Price Range</label>
                                        <input type="text" name="price_range" class="form-control" 
                                               value="<?= htmlspecialchars($_POST['price_range'] ?? '') ?>"
                                               placeholder="e.g., $100-$500">
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Estimated Delivery</label>
                                        <input type="text" name="estimated_delivery" class="form-control"
                                               value="<?= htmlspecialchars($_POST['estimated_delivery'] ?? '') ?>"
                                               placeholder="e.g., 2-4 weeks">
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Display Order</label>
                                    <input type="number" name="display_order" class="form-control" 
                                           value="<?= htmlspecialchars($_POST['display_order'] ?? 0) ?>">
                                </div>
                                
                                <div class="mb-3 form-check form-switch">
                                    <input type="checkbox" name="is_featured" class="form-check-input" id="featuredCheck"
                                        <?= isset($_POST['is_featured']) ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="featuredCheck">Featured Service</label>
                                </div>
                            </div>
                        </div>
                        
                        <hr class="my-4">
                        
                        <h5 class="mb-3">SEO Settings</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Meta Title</label>
                                    <input type="text" name="meta_title" class="form-control" maxlength="100"
                                           value="<?= htmlspecialchars($_POST['meta_title'] ?? '') ?>">
                                    <small class="text-muted">Max 100 characters</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Meta Description</label>
                                    <textarea name="meta_description" class="form-control" maxlength="255" rows="2"><?= 
                                        htmlspecialchars($_POST['meta_description'] ?? '') 
                                    ?></textarea>
                                    <small class="text-muted">Max 255 characters</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <a href="services-list.php" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save Service</button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>

    <?php 
    if (file_exists(ADMIN_ROOT . '/includes/admin-footer.php')) {
        require_once ADMIN_ROOT . '/includes/admin-footer.php';
    }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>