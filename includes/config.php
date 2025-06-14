<?php
// config.php - Database configuration

$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "santosh-portfolio";
$db_port = 3306; //default MySQL port

// Other global configurations can go here
$base_path = '/santosh-portfolio-site/';
// Add to portfolio-site/includes/config.php
// $mail_config = [
//     'host' => 'smtp.yourdomain.com',
//     'username' => 'noreply@yourdomain.com',
//     'password' => 'your_email_password',
//     'port' => 587,
//     'encryption' => 'tls',
//     'from_email' => 'noreply@yourdomain.com',
//     'from_name' => 'Portfolio Admin'
// ];

// Detect environment
$environment = 'development'; // Change to 'production' on live server
if (strpos($_SERVER['HTTP_HOST'], 'localhost') === false) {
    $environment = 'production';
}

$mail_config = [
    'host' => 'admin.gmail.com', // Or your email provider
    'username' => 'admin@gmail.com',
    'password' => 'admin',
    'port' => 587,
];