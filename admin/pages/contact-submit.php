<?php
session_start();

$rootPath = realpath(dirname(__DIR__, 2));
define('ROOT_PATH', $rootPath);

require_once ROOT_PATH . '/db.php';
require_once ROOT_PATH . '/includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: " . ROOT_PATH . "/login/login.php");
    exit();
}

// Send reply email and mark as replied
if (isset($_GET['reply_message'])) {
    $id = (int)$_GET['reply_message'];
    $res = $mysqli->query("SELECT * FROM contact_messages WHERE id=$id");
    $msg = $res->fetch_assoc();

    if ($msg) {
        // Sample email reply logic (ensure these variables are defined properly)
        $to = $msg['email'];
        $subject = "Reply to your message";
        $reply_body = "Dear " . htmlspecialchars($msg['name']) . ",\n\nThank you for your message. We will get back to you shortly.\n\nRegards,\nSantosh";
        $headers = "From: your-email@example.com\r\nReply-To: your-email@example.com";

        if (mail($to, $subject, $reply_body, $headers)) {
            $mysqli->query("UPDATE contact_messages SET replied=1 WHERE id=$id");
            $_SESSION['message'] = "Reply sent to " . htmlspecialchars($msg['email']);
        } else {
            $_SESSION['message'] = "Failed to send reply email.";
        }
    }
    header("Location: contact-messages.php");
    exit();
}

// Fetch all messages
$messages = [];
$res = $mysqli->query("SELECT * FROM contact_messages ORDER BY submitted_at DESC");
if ($res) $messages = $res->fetch_all(MYSQLI_ASSOC);
require_once ROOT_PATH . '/admin/includes/admin-header.php';
?>

<div class="container py-4">
    <h2>Contact Messages</h2>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-info"><?= htmlspecialchars($_SESSION['message']) ?></div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Submitted At</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Message</th>
                <th>Replied</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($messages as $msg): ?>
                <tr>
                    <td><?= date('Y-m-d H:i', strtotime($msg['submitted_at'])) ?></td>
                    <td><?= htmlspecialchars($msg['name']) ?></td>
                    <td><?= htmlspecialchars($msg['email']) ?></td>
                    <td><?= htmlspecialchars($msg['phone']) ?></td>
                    <td><?= nl2br(htmlspecialchars($msg['message'])) ?></td>
                    <td><?= $msg['replied'] ? 'Yes' : 'No' ?></td>
                    <td>
                        <?php if (!$msg['replied']): ?>
                            <a href="?reply_message=<?= $msg['id'] ?>" class="btn btn-sm btn-primary" onclick="return confirm('Send reply email?');">Reply</a>
                        <?php else: ?>
                            <button class="btn btn-sm btn-secondary" disabled>Replied</button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>

            <?php if (empty($messages)): ?>
                <tr><td colspan="7" class="text-center">No messages found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once ROOT_PATH . '/admin/includes/admin-footer.php'; ?>
