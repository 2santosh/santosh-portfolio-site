<?php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/db.php';

// Fetch all necessary data
$dataHomepage = getHomepageContent();
$dataAbout = getAboutMe();

$homepage = $dataHomepage['content'] ?? [];
$social_links = $dataHomepage['social_links'] ?? [];

$about = $dataAbout['content'] ?? [];
$about_links = $dataAbout['links'] ?? [];

$skills = getSkills();
$educationList = getEducation();
$projects = getProjects();
$experienceList = getExperience();

// Pass variables to pages
$pageData = [
    'homepage' => $homepage,
    'social_links' => $social_links,
    'about' => $about,
    'about_links' => $about_links,
    'skills' => $skills,
    'educationList' => $educationList,
    'projects' => $projects,
    'experienceList' => $experienceList
];

// Include all page sections
$sections = ['home', 'about', 'skill', 'project', 'education', 'contact'];
foreach ($sections as $section) {
    $file = __DIR__ . "/pages/{$section}.php";
    if (file_exists($file)) {
        require $file;
    } else {
        echo "<!-- Missing file: {$section}.php -->";
    }
}

require_once __DIR__ . '/includes/footer.php';
?>
