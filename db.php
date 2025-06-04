<?php
// db.php
require_once __DIR__ . '/includes/config.php';

$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);

if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

$mysqli->set_charset("utf8mb4");

function getCount(string $table, string $condition = ''): int {
    global $mysqli;
    $sql = "SELECT COUNT(*) as cnt FROM $table";
    if ($condition) {
        $sql .= " WHERE $condition";
    }
    $result = $mysqli->query($sql);
    if ($result) {
        $row = $result->fetch_assoc();
        return (int)$row['cnt'];
    }
    return 0;
}

function getRecentActivities(int $limit = 5): array {
    global $mysqli;
    $sql = "
        (SELECT 'Project' as type, title, updated_at as date, 'fa-file-text' as icon, CONCAT('Updated project: ', title) as description FROM projects ORDER BY updated_at DESC LIMIT $limit)
        UNION
        (SELECT 'Skill' as type, name as title, updated_at as date, 'fa-code' as icon, CONCAT('Updated skill: ', name) as description FROM skills ORDER BY updated_at DESC LIMIT $limit)
        UNION
        (SELECT 'Experience' as type, title as title, updated_at as date, 'fa-briefcase' as icon, CONCAT('Updated experience: ', title) as description FROM experience ORDER BY updated_at DESC LIMIT $limit)
        ORDER BY date DESC
        LIMIT $limit
    ";
    $result = $mysqli->query($sql);
    $activities = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $activities[] = $row;
        }
    }
    return $activities;
}

function getRecentMessages(int $limit = 5): array {
    global $mysqli;
    $sql = "SELECT id, name, email, message, replied, is_read FROM contact_messages ORDER BY replied DESC LIMIT $limit";
    $result = $mysqli->query($sql);
    $messages = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $messages[] = $row;
        }
    }
    return $messages;
}

// Fetch homepage content and its social links
function getHomepageContent(): array {
    global $mysqli;
    $homepage = null;
    $social_links = [];

    $sql = "SELECT * FROM homepage_content ORDER BY id DESC LIMIT 1";
    $result = $mysqli->query($sql);
    if ($result && $row = $result->fetch_assoc()) {
        $homepage = $row;

        $homepage_id = $row['id'];
        $sql_social = "SELECT * FROM social_links WHERE homepage_content_id = $homepage_id ORDER BY id";
        $result_social = $mysqli->query($sql_social);
        while ($social = $result_social->fetch_assoc()) {
            $social_links[] = $social;
        }
    }

    return ['content' => $homepage, 'social_links' => $social_links];
}

// Fetch about me content and links
function getAboutMe(): array {
    global $mysqli;
    $about = null;
    $about_links = [];

    $sql = "SELECT * FROM about_me_content ORDER BY id DESC LIMIT 1";
    $result = $mysqli->query($sql);
    if ($result && $row = $result->fetch_assoc()) {
        $about = $row;

        $about_id = $row['id'];
        $sql_links = "SELECT * FROM about_me_links WHERE about_me_content_id = $about_id ORDER BY id";
        $result_links = $mysqli->query($sql_links);
        while ($link = $result_links->fetch_assoc()) {
            $about_links[] = $link;
        }
    }

    return ['content' => $about, 'links' => $about_links];
}

// Fetch skills
function getSkills(): array {
    global $mysqli;
    $skills = [];
    $sql = "SELECT * FROM skills ORDER BY id ASC";
    $result = $mysqli->query($sql);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $skills[] = $row;
        }
    }
    return $skills;
}

// Fetch education
function getEducation(): array {
    global $mysqli;
    $education = [];
    $sql = "SELECT * FROM education ORDER BY id ASC";
    $result = $mysqli->query($sql);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $education[] = $row;
        }
    }
    return $education;
}

// Fetch projects
function getProjects(): array {
    global $mysqli;
    $projects = [];
    $sql = "SELECT * FROM projects ORDER BY updated_at DESC";
    $result = $mysqli->query($sql);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $projects[] = $row;
        }
    }
    return $projects;
}

// Fetch experience
function getExperience(): array {
    global $mysqli;
    $experience = [];
    $sql = "SELECT * FROM experience ORDER BY position_order ASC, start_date DESC";
    $result = $mysqli->query($sql);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $experience[] = $row;
        }
    }
    return $experience;
}
