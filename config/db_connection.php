<?php
$host = "localhost";
$db = "santosh-portfolio";
$user = "root";
$pass = "";
$charset = "utf8mb4";

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully"; // Optional
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
