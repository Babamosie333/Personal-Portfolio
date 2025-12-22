<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';



// Only handle POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'Error: Invalid request method.';
    exit;
}

$name    = htmlspecialchars($_POST['name'] ?? '');
$email   = htmlspecialchars($_POST['email'] ?? '');
$subject = htmlspecialchars($_POST['subject'] ?? '');
$message = htmlspecialchars($_POST['message'] ?? '');

if (!$name || !$email || !$message) {
    echo 'Error: Please fill in all required fields.';
    exit;
}

$mail = new PHPMailer(true);

try {
    // SMTP config (Gmail)
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'vikramsingh14052006@gmail.com';
    $mail->Password   = 'kgps jkwc gbpn bdiz';   // 16‑char app password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // From / To
    $mail->setFrom('vikramsingh14052006@gmail.com', 'VikramPortfolio');
    $mail->addAddress('vikramsingh14052006@gmail.com', 'Vikram Singh');
    $mail->addReplyTo($email, $name);

    // Content
    $mail->isHTML(false);
    $mail->Subject = 'Portfolio Contact: ' . $subject;
    $mail->Body    =
        "Name: $name\n" .
        "Email: $email\n\n" .
        "Message:\n$message\n";

    $mail->send();
    echo 'OK';
} catch (Exception $e) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}
