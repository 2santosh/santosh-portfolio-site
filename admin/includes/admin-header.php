<?php
// Start session (required for auth check)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// Set base path dynamically
$base_path = '/santosh-portfolio-site/';

// Set default page title if not defined
if (!isset($pageTitle)) {
    $pageTitle = 'Admin Panel';
}

// Get current page filename
$current_page = basename($_SERVER['PHP_SELF']);

// Function to check if menu item is active
function isActive($page_name, $current_page) {
    return ($page_name === $current_page) ? 'class="active"' : '';
}

// Check if user is logged in (using session)
$isLoggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Portfolio Admin Panel">
    <meta name="keywords" content="Portfolio, Admin, Dashboard">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin | <?php echo htmlspecialchars($pageTitle); ?></title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Play:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="<?php echo $base_path; ?>admin/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $base_path; ?>admin/assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo $base_path; ?>admin/assets/css/elegant-icons.css">
    <link rel="stylesheet" href="<?php echo $base_path; ?>admin/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo $base_path; ?>admin/assets/css/magnific-popup.css">
    <link rel="stylesheet" href="<?php echo $base_path; ?>admin/assets/css/slicknav.min.css">
    <link rel="stylesheet" href="<?php echo $base_path; ?>admin/assets/css/admin.css">
    <link rel="stylesheet" href="<?php echo $base_path; ?>admin/assets/css/style.css">
    <link rel="stylesheet" href="<?php echo $base_path; ?>admin/assets/css/admin-header.css">

</head>

<body>
    <!-- Page Preloder -->
    <!-- <div id="preloder">
        <div class="loader"></div>
    </div> -->

    <!-- Admin Header Section -->
    <header class="header admin-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-2">
                    <div class="header__logo">
                        <a href="<?php echo $isLoggedIn ? $base_path.'admin/dashboard.php' : $base_path.'index.php'; ?>">
                            <img src="<?php echo $base_path; ?>assets/images/logos.png" alt="Admin Logo">
                        </a>
                    </div>
                </div>
                <div class="col-lg-10">
                    <div class="header__nav__option">
                        <nav class="header__nav__menu mobile-menu">
                            <ul>
                                <?php if ($isLoggedIn): ?>
                                <!-- Admin Navigation -->
                                <li <?php echo isActive('dashboard.php', $current_page); ?>>
                                    <a href="<?php echo $base_path; ?>admin/pages/dashboard.php">
                                        <i class="fa fa-home"></i> Dashboard
                                    </a>
                                </li>
                                <li <?php echo isActive('home.php', $current_page); ?>>
                                    <a href="<?php echo $base_path; ?>admin/pages/home.php">
                                        <i class="fa fa-building"></i> Home
                                    </a>
                                </li>
                                <li <?php echo isActive('about.php', $current_page); ?>>
                                    <a href="<?php echo $base_path; ?>admin/pages/about.php">
                                        <i class="fa fa-user"></i> About
                                    </a>
                                </li>
                                <li <?php echo isActive('skills.php', $current_page); ?>>
                                    <a href="<?php echo $base_path; ?>admin/pages/skills.php">
                                        <i class="fa fa-wrench"></i> Skills
                                    </a>
                                </li>
                                <li <?php echo isActive('skills.php', $current_page); ?>>
                                    <a href="<?php echo $base_path; ?>admin/pages/education.php">
                                        <i class="fa fa-wrench"></i> Education
                                    </a>
                                </li>
                                <li <?php echo isActive('work.php', $current_page); ?>>
                                    <a href="<?php echo $base_path; ?>admin/pages/work.php">
                                        <i class="fa fa-briefcase"></i> Work
                                    </a>
                                </li>
                                <li <?php echo isActive('experience.php', $current_page); ?>>
                                    <a href="<?php echo $base_path; ?>admin/pages/experience.php">
                                        <i class="fa fa-line-chart"></i> Experience
                                    </a>
                                </li>
                                <?php else: ?>
                                <!-- Public Navigation -->
                                <li <?php echo isActive('index.php', $current_page); ?>>
                                    <a href="<?php echo $base_path; ?>index.php">Home</a>
                                </li>
                                <li <?php echo isActive('about.php', $current_page); ?>>
                                    <a href="<?php echo $base_path; ?>about.php">About</a>
                                </li>
                                <li <?php echo isActive('projects.php', $current_page); ?>>
                                    <a href="<?php echo $base_path; ?>projects.php">Projects</a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                        <div class="header__nav__social">
                            <?php if ($isLoggedIn): ?>
                            <a href="<?php echo $base_path; ?>admin/logout.php">
                                <i class="fa fa-sign-out"></i> Logout
                            </a>
                            <?php else: ?>
                            <a href="<?php echo $base_path; ?>admin/login/login.php">
                                <i class="fa fa-sign-in"></i> Admin Login
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div id="mobile-menu-wrap"></div>
        </div>
    </header>
    <!-- Admin Header End -->