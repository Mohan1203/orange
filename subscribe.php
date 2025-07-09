<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // adjust if you’re not using Composer

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);

    $service = isset($_POST["service"]) ? strip_tags(trim($_POST["service"])) : "Not specified";

    
    $subject = "News latter subscription from $email";

    $email_content .= "Email: $email\n";
    $email_content .= "Message:\nNews latter subscription from $email\n";

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com';           
        $mail->SMTPAuth = true;
        $mail->Username = 'hitesh@orangeinfotech.co.in'; 
        $mail->Password = 'Hiteshmepani@123';    
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        // Recipients
        $mail->setFrom('hitesh@orangeinfotech.co.in', 'News latter subscription');
         $mail->addReplyTo($email);
        $mail->addAddress('hitesh@orangeinfotech.co.in');

        // Content
        $mail->Subject = $subject;
        $mail->Body    = $email_content;
        $mail->send();
        http_response_code(200);
        echo "You successfully subscribed to our newsletter!";
    } catch (Exception $e) {
        http_response_code(500);
        echo "Oops! Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
}
