<?php
/*
    name
    email
    message
    */
// Only process POST reqeusts.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form fields and remove whitespace.
    $name = strip_tags(trim($_POST["name"]));
    $name = str_replace(array("\r", "\n"), array(" ", " "), $name);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = trim($_POST["message"]);
    $service = isset($_POST["service"]) ? strip_tags(trim($_POST["service"])) : "Not specified";

    // Set the recipient email address.
    // FIXME: Update this to your desired email address.
    $recipient = "mohan.shreesoftech@gmail.com";

    // Define the email subject
    $subject = "New Contact Form Submission from $name";

    // Build the email content.
    $email_content = "Name $name\n";
    $email_content .= "Email \n$email\n";
    $email_content .= "Service Chosen: $service\n";
    $email_content .= "Message \n$message\n";

    // Build the email headers.
    $email_headers = "From: $name <$email>";

    // Send the email.
    if (mail($recipient, $subject, $email_content, $email_headers)) {
        // Set a 200 (okay) response code.
        http_response_code(200);
        echo "Thank You! Your message has been sent.";
    } else {
        // Set a 500 (internal server error) response code.
        http_response_code(500);
        echo "Oops! Something went wrong ande we couldn't send your message.";
    }
} else {
    // Not a POST request, set a 403 (forbidden) response code.
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
}
