<?php
// portfolio-site/includes/mailer.php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';

function sendResetEmail($to, $token) {
    global $mail_config, $base_path;
    
    $mail = new PHPMailer(true);
    $reset_link = "{$base_path}admin/login/reset-password.php?token=$token";
    
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = $mail_config['host'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $mail_config['username'];
        $mail->Password   = $mail_config['password'];
        $mail->SMTPSecure = $mail_config['encryption'];
        $mail->Port       = $mail_config['port'];
        
        // Recipients
        $mail->setFrom($mail_config['from_email'], $mail_config['from_name']);
        $mail->addAddress($to);
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Request';
        $mail->Body    = "
            <h2>Password Reset</h2>
            <p>You requested a password reset. Click the link below to set a new password:</p>
            <p><a href='$reset_link'>Reset Password</a></p>
            <p>This link will expire in 1 hour.</p>
        ";
        $mail->AltBody = "Reset your password: $reset_link (Expires in 1 hour)";
        
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}