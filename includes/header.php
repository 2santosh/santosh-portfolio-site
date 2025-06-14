<?php
// Fallbacks
$pageTitle = $pageTitle ?? 'Santosh - Personal Portfolio';
$siteName = $siteName ?? 'Santosh';
$currentSection = $currentSection ?? 'home';
$basePath = '/santosh-portfolio-site/client/'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- Favicon -->
    <link href="<?= $basePath ?>assets/img/favicon.ico" rel="icon">

    <!-- Google Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries -->
    <link href="<?= $basePath ?>assets/lib/animate/animate.min.css" rel="stylesheet">
    <link href="<?= $basePath ?>assets/lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link href="<?= $basePath ?>assets/lib/owlcarousel/owl.carousel.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?= $basePath ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= $basePath ?>assets/css/style.css" rel="stylesheet">
</head>

<body data-bs-spy="scroll" data-bs-target=".navbar" data-bs-offset="51">

<!-- Spinner Start -->
<div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>
<!-- Spinner End -->

<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg bg-white navbar-light fixed-top shadow py-lg-0 px-4 px-lg-5 wow fadeIn" data-wow-delay="0.1s">
    <a href="<?= $basePath ?>../" class="navbar-brand d-block d-lg-none">
        <h1 class="text-primary fw-bold m-0"><?= htmlspecialchars($siteName) ?></h1>
    </a>
    <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-between py-4 py-lg-0" id="navbarCollapse">
        <div class="navbar-nav ms-auto py-0">
            <a href="#home" class="nav-item nav-link <?= $currentSection == 'home' ? 'active' : '' ?>">Home</a>
            <a href="#about" class="nav-item nav-link <?= $currentSection == 'about' ? 'active' : '' ?>">About</a>
            <a href="#skill" class="nav-item nav-link <?= $currentSection == 'skill' ? 'active' : '' ?>">Skills</a>
            <a href="#service" class="nav-item nav-link <?= $currentSection == 'service' ? 'active' : '' ?>">Services</a>
        </div>
        <a href="<?= $basePath ?>../" class="navbar-brand bg-secondary py-3 px-4 mx-3 d-none d-lg-block">
            <h1 class="text-primary fw-bold m-0"><?= htmlspecialchars($siteName) ?></h1>
        </a>
        <div class="navbar-nav me-auto py-0">
            <a href="#project" class="nav-item nav-link <?= $currentSection == 'project' ? 'active' : '' ?>">Projects</a>
            <a href="#team" class="nav-item nav-link <?= $currentSection == 'team' ? 'active' : '' ?>">Team</a>
            <a href="#testimonial" class="nav-item nav-link <?= $currentSection == 'testimonial' ? 'active' : '' ?>">Testimonial</a>
            <a href="#contact" class="nav-item nav-link <?= $currentSection == 'contact' ? 'active' : '' ?>">Contact</a>
        </div>
    </div>
</nav>
<!-- Navbar End -->
