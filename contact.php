<?php
header('Content-Type: application/json; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed.']);
    exit;
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

$to = 'hello@rohankarki2.com.np';

if ($name === '' || $email === '' || $subject === '' || strlen($message) < 10) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Please fill in all required fields.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid email address.']);
    exit;
}

$body = "Name: {$name}\n";
$body .= "Email: {$email}\n\n";
$body .= "Message:\n{$message}\n";

$headers = "From: {$name} <{$email}>\r\n";
$headers .= "Reply-To: {$email}\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

$mailSent = mail($to, $subject, $body, $headers);

if ($mailSent) {
    echo json_encode(['status' => 'ok', 'message' => 'Message sent successfully.']);
    exit;
}

http_response_code(500);
echo json_encode(['status' => 'error', 'message' => 'Email could not be sent. Please verify your domain mailbox is configured on rohankarki2.com.np.']);
