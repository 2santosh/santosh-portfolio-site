<?php
require_once './db.php';

$homepageData = getHomepageContent();
$homepage = $homepageData['content'];
$social_links = $homepageData['social_links'];

$aboutData = getAboutMe();
$about = $aboutData['content'];
$about_links = $aboutData['links'];

$skills = getSkills();
$educationList = getEducation();
$projects = getProjects();
$experienceList = getExperience();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow">
    <meta name="description"
        content="Welcome to Santosh's Portfolio. Full-Stack Web Developer specializing in modern web technologies and innovative applications.">
    <meta name="keywords"
        content="santosh adhikari, portfolio, full stack developer, web developer, Android developer, CodeHiveSantosh, santosh web developer, santosh website developer, santoshadhikari123">
    <meta property="og:title" content="Portfolio | Santosh Adhikari | CodeHiveSantosh">
    <meta property="og:description"
        content="Welcome to Santosh's Portfolio. Full-Stack Web Developer specializing in modern web technologies and innovative applications.">
    <meta property="og:image" content="http://santoshadhikari123.com.np/assets/images/hero.jpg">
    <meta property="og:url" content="http://santoshadhikari123.com.np/">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Portfolio | Santosh Adhikari | CodeHiveSantosh">
    <meta name="twitter:description"
        content="Welcome to Santosh's Portfolio. Full-Stack Web Developer specializing in modern web technologies and innovative applications.">
    <meta name="twitter:image" content="http://santoshadhikari123.com.np/assets/images/hero.jpg">
    <link rel="canonical" href="http://santoshadhikari123.com.np/" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="./assets/css/style.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Favicon -->
    <link id='favicon' rel="shortcut icon" href="./assets/images/logo.png"
        onerror="this.src='./assets/images/logo.png';" type="image/x-png">
    <title>Portfolio | Santosh Adhikari | CodeHiveSantosh</title>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Person",
        "name": "Santosh Adhikari",
        "jobTitle": "Full-Stack Web Developer",
        "url": "http://santoshadhikari123.com.np/",
        "sameAs": [
            "https://www.linkedin.com/in/santosh-adhikari-79a783233/",
            "https://github.com/2santosh",
            "https://twitter.com/aslicecode"
        ],
        "alumniOf": {
            "@type": "EducationalOrganization",
            "name": "College of Information Technology and Engineering"
        },
        "knowsAbout": ["Web Development", "JavaScript", "PHP", "Python", "Java", "MySQL"],
        "worksFor": {
            "@type": "Organization",
            "name": "RWS (p2h)"
        }
    }
    </script>
</head>

<body oncontextmenu="return false">

    <!-- pre loader -->
    <!-- <div class="loader-container">
    <img draggable="false" src="./assets/images/preloader.gif" alt="Loading...">
  </div> -->

    <!-- navbar starts -->
    <header>
        <a href="/" class="logo" style="position: relative; display: inline-block; width: 50px; height: 50px;">
            <img src="./assets/images/logo.png" onerror="this.src='./assets/images/logo.png';" alt="Santosh Logo"
                style="width: 36px; height: auto; display: block; position: relative; z-index: 1;" />
            <span style="
          content: '';
          position: absolute;
          top: 50%;
          left: 50%;
          width: 50px;
          height: 50px;
          background-color: rgba(0, 0, 0, 0.1);
          border-radius: 50%;
          transform: translate(-50%, -50%) scale(0);
          transition: transform 0.3s ease;
          z-index: 0;
        "></span>
        </a>

        <div id="menu" class="fas fa-bars"></div>
        <nav class="navbar">
            <ul>
                <li><a class="active" href="#home">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#skills">Skills</a></li>
                <li><a href="#education">Education</a></li>
                <li><a href="#work">Work</a></li>
                <li><a href="#experience">Experience</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>
    </header>
    <!-- navbar ends -->