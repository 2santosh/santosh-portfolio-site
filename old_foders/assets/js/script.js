<?php
// api.php - dynamic API endpoint
require_once __DIR__ . '/includes/config.php';

$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);
if ($mysqli->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => "DB connection failed: " . $mysqli->connect_error]);
    exit;
}
$mysqli->set_charset("utf8mb4");

// Your functions here (same as you posted) ...
// For brevity, I'm assuming all your functions (getSkills(), getProjects(), etc.) are defined here exactly as in your code.

// -- Now handle the API requests --

header('Content-Type: application/json');

$action = $_GET['action'] ?? null;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;

try {
    switch ($action) {
        case 'count':
            $table = $_GET['table'] ?? '';
            $condition = $_GET['condition'] ?? '';
            if (!$table) {
                throw new Exception('Table name is required for count');
            }
            $count = getCount($table, $condition);
            echo json_encode(['count' => $count]);
            break;

        case 'recent_activities':
            $activities = getRecentActivities($limit);
            echo json_encode($activities);
            break;

        case 'recent_messages':
            $messages = getRecentMessages($limit);
            echo json_encode($messages);
            break;

        case 'homepage':
            $homepageData = getHomepageContent();
            echo json_encode($homepageData);
            break;

        case 'about_me':
            $aboutMeData = getAboutMe();
            echo json_encode($aboutMeData);
            break;

        case 'skills':
            $skills = getSkills();
            echo json_encode($skills);
            break;

        case 'education':
            $education = getEducation();
            echo json_encode($education);
            break;

        case 'projects':
            $projects = getProjects();
            echo json_encode($projects);
            break;

        case 'experience':
            $experience = getExperience();
            echo json_encode($experience);
            break;

        default:
            http_response_code(400);
            echo json_encode(['error' => 'Invalid or missing action parameter']);
            break;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
