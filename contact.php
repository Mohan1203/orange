<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // adjust if you’re not using Composer

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = strip_tags(trim($_POST["name"]));
    $name = str_replace(array("\r", "\n"), array(" ", " "), $name);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = trim($_POST["message"]);
    $service = isset($_POST["service"]) ? strip_tags(trim($_POST["service"])) : "Not specified";

    
    $subject = "New Contact Form Submission from $name";
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n";
    $email_content .= "Service Chosen: $service\n";
    $email_content .= "Message:\n$message\n";

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = ADD_YOUR_YOUR_SMTP;           // Replace with your SMTP host
        $mail->SMTPAuth = true;
        $mail->Username = ''; // Replace with your SMTP username
        $mail->Password = '';    // Use App Password for Gmail (not your normal password)
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        // Recipients
        $mail->setFrom('', $name);
        $mail->addReplyTo($email, $name);
        $mail->addAddress('');

        // Content
        $mail->Subject = $subject;
        $mail->Body    = $email_content;

        $mail->send();
        http_response_code(200);
        echo "Thank You! Your message has been sent.";
    } catch (Exception $e) {
        http_response_code(500);
        echo "Oops! Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
}
