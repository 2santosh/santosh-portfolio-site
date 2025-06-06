<?php
// config.php - Database configuration

$db_host = "sql113.infinityfree.com";
$db_user = "if0_37699110";
$db_pass = "oZ9hQi55krY";
$db_name = "if0_37699110_santos_portfolio";
$db_port = 3306; // default MySQL port

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
    'username' => 'admin@email.com',
    'password' => 'admin',
    'port' => 587,
];