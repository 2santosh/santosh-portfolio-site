<?php
// Set base path dynamically
$base_path = '/portfolio-site/';

// Set default page title if not defined
if (!isset($pageTitle)) {
    $pageTitle = 'Template';
}

// Get current page filename
$current_page = basename($_SERVER['PHP_SELF']);

// Function to check if menu item is active
function isActive($page_name, $current_page) {
    return ($page_name === $current_page) ? 'class="active"' : '';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Videograph Template">
    <meta name="keywords" content="Videograph, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Videograph | <?php echo htmlspecialchars($pageTitle); ?></title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Play:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="<?php echo $base_path; ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $base_path; ?>assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo $base_path; ?>assets/css/elegant-icons.css">
    <link rel="stylesheet" href="<?php echo $base_path; ?>assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo $base_path; ?>assets/css/magnific-popup.css">
    <link rel="stylesheet" href="<?php echo $base_path; ?>assets/css/slicknav.min.css">
    <link rel="stylesheet" href="<?php echo $base_path; ?>assets/css/style.css">
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Header Section Begin -->
    <header class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-2">
                    <div class="header__logo">
                        <a href="<?php echo $base_path; ?>index.php">
                            <img src="<?php echo $base_path; ?>assets/images/logo.png" alt="Company Logo"
                                class="header-logo">
                        </a>
                    </div>
                </div>
                <div class="col-lg-10">
                    <div class="header__nav__option">
                        <nav class="header__nav__menu mobile-menu">
                            <ul>
                                <li <?php echo isActive('index.php', $current_page); ?>>
                                    <a href="<?php echo $base_path; ?>index.php">Home</a>
                                </li>
                                <li <?php echo isActive('about.php', $current_page); ?>>
                                    <a href="<?php echo $base_path; ?>about.php">About</a>
                                </li>
                                <li <?php echo isActive('projects.php', $current_page); ?>>
                                    <a href="<?php echo $base_path; ?>projects.php">Projects</a>
                                </li>
                                <li <?php echo isActive('services.php', $current_page); ?>>
                                    <a href="<?php echo $base_path; ?>services.php">Services</a>
                                </li>
                                <li>
                                    <a href="#">Pages</a>
                                    <ul class="dropdown">
                                        <li><a href="<?php echo $base_path; ?>about.php">About</a></li>
                                        <li><a href="<?php echo $base_path; ?>projects.php">Projects</a></li>
                                        <li><a href="<?php echo $base_path; ?>blog.php">Blog</a></li>
                                        <li><a href="<?php echo $base_path; ?>blog-details.php">Blog Details</a></li>
                                    </ul>
                                </li>
                                <li <?php echo isActive('contact.php', $current_page); ?>>
                                    <a href="<?php echo $base_path; ?>contact.php">Contact</a>
                                </li>
                            </ul>
                        </nav>
                        <div class="header__nav__social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-dribbble"></i></a>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                            <a href="#"><i class="fa fa-youtube-play"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="mobile-menu-wrap"></div>
        </div>
    </header>
    <!-- Header End -->