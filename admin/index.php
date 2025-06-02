<?php
// admin/index.php
include_once(__DIR__ . '/controllers/AdminController.php');

use Admin\AdminController;

$controller = new AdminController();
$data = $controller->getAdminData();

// Include other view files if needed
include 'views/header.php';
include 'views/dashboard.php';
include 'views/footer.php';
