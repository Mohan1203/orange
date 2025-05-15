<?php
// Handle newsletter subscription
// Only process POST requests.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form field and remove whitespace.
    // Sanitize the email input.
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);

    // Validate email
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Set a 400 (bad request) response code and exit.
        http_response_code(400);
        echo "Oops! Please provide a valid email address.";
        exit;
    }

    // Set the recipient email address.
    // FIXME: Update this to your desired email address to receive subscription notifications.
    $recipient = "wrteam.sumit@gmail.com"; // Example: your admin email

    // Set the email subject.
    $subject = "New Newsletter Subscription";

    // Build the email content.
    $email_content = "New newsletter subscription:";
    $email_content .= "Email: $email";

    // Build the email headers.
    // It's good practice to set a "From" address that belongs to your domain.
    // Some servers might block emails otherwise.
    $email_headers = "From: Orange InfoTech Newsletter <noreply@orangeinfotech.co.in>"; // Using your actual domain

    // Send the email.
    if (mail($recipient, $subject, $email_content, $email_headers)) {
        // Set a 200 (okay) response code.
        http_response_code(200);
        echo "Thank You! You have successfully subscribed to our newsletter.";
    } else {
        // Set a 500 (internal server error) response code.
        http_response_code(500);
        echo "Oops! Something went wrong and we couldn\'t process your subscription.";
    }
} else {
    // Not a POST request, set a 403 (forbidden) response code.
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
}
