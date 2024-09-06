<?php
// Display errors for debugging (remove in production)
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input data
    $guestName = htmlspecialchars(trim($_POST['guestName']));
    $guestLast = htmlspecialchars(trim($_POST['guestLast']));
    $phoneNumber = htmlspecialchars(trim($_POST['phoneNumber']));
    $emailAddress = filter_var(trim($_POST['emailAddress']), FILTER_SANITIZE_EMAIL);
    $notes = htmlspecialchars(trim($_POST['notes']));

    // Basic email validation with injection protection
    if (!filter_var($emailAddress, FILTER_VALIDATE_EMAIL) || preg_match("/[\r\n]/", $emailAddress)) {
        echo "Invalid email address.<br>";
        exit;
    }

    // Validate phone number (assuming 10-digit format)
    if (!preg_match("/^[0-9]{10}$/", $phoneNumber)) {
        echo "Invalid phone number.<br>";
        exit;
    }

    // Email details
    $to = "shobaky202@gmail.com"; // Replace with your email address
    $subject = "New Contact Form Submission";
    $message = "Name: $guestName $guestLast\nPhone: $phoneNumber\nEmail: $emailAddress\nNotes: $notes";
    $headers = "From: no-reply@yourdomain.com\r\n"; // Use your domain's no-reply email address
    $headers .= "Reply-To: $emailAddress\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Send email and check for success/failure
    if (mail($to, $subject, $message, $headers)) {
        header("Location: thank_you.html");
        exit;
    } else {
        echo "Failed to send message.<br>";
    }
} else {
    echo "Invalid request method.<br>";
    exit;
}
?>
