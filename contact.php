<?php
header('Content-Type: text/plain');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo 'error';
    exit;
}

$name    = htmlspecialchars(strip_tags(trim($_POST['name'] ?? '')));
$email   = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$subject = htmlspecialchars(strip_tags(trim($_POST['subject'] ?? '')));
$message = htmlspecialchars(strip_tags(trim($_POST['message'] ?? '')));

// Validation
if (!$name || !filter_var($email, FILTER_VALIDATE_EMAIL) || !$message) {
    echo 'error';
    exit;
}

$to      = 'sabiqanas10@gmail.com';
$headers = implode("\r\n", [
    "From: Portfolio Contact <$email>",
    "Reply-To: $email",
    "MIME-Version: 1.0",
    "Content-Type: text/plain; charset=UTF-8"
]);

$body = "New message from your portfolio:\n\n";
$body .= "Name:    $name\n";
$body .= "Email:   $email\n";
$body .= "Subject: $subject\n\n";
$body .= "Message:\n$message\n";

$sent = mail($to, "Portfolio: $subject", $body, $headers);

echo $sent ? 'success' : 'error';
