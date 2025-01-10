<?php
require 'mailer/src/Exception.php';
require 'mailer/src/PHPMailer.php';
require 'mailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Collect form data
$to = ["education@rsrglobal.org"];
// $to = ["solomonjenish@gmail.com"];
$from = $_POST['email'];
$name = $_POST['name'];
$contact_number = $_POST['contact_number'];
$qualification = $_POST['qualification'];
$city = $_POST['city'];
$country = $_POST['country'];
$program = $_POST['program'];
$destination = $_POST['destination'];
$message = $_POST['message'];
$sub = 'Education Enquiry';
$sub1 = 'Education Enquiry';

$message = "
<b>Name:</b> $name<br>
<b>Contact Number:</b> $contact_number<br>
<b>Email Id:</b> $from<br>
<b>qualification:</b> $qualification<br>
<b>city:</b> $city<br>
<b>country:</b> $country<br>
<b>program:</b> $program<br>
<b>destination:</b> $destination<br>
<b>Message:</b> $message
";

try {
    $mail = new PHPMailer(true);

    // Server settings
    // $mail->SMTPDebug = 2; // For detailed debugging info
    $mail->isSMTP();                                   // Set mailer to use SMTP
    $mail->Host       = 'smtp.office365.com';         // Specify main SMTP server
    $mail->SMTPAuth   = true;                         // Enable SMTP authentication
    $mail->Username   = 'noreply@rsrglobal.org';      // SMTP username
    $mail->Password   = 'RSRGlobal@2023';             // SMTP password (use an App Password if 2FA is enabled)
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
    $mail->Port       = 587;                          // TCP port to connect to

    // Send email to recipients
    $mail->setFrom('noreply@rsrglobal.org', 'RSR Global');
    foreach ($to as $recipient) {
        $mail->addAddress($recipient); // Add recipient
    }
    $mail->addReplyTo('contact@rsrglobal.org', 'RSR Global');
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $sub;
    $mail->Body    = $message;
    $mail->AltBody = strip_tags($message);

    $mail->send();

    // Send confirmation email
    $confirmation_message = "
    <p>Dear $name,</p>
    <p>Thank you for your enquiry. We will review your information and get back to you shortly.</p>
    <p>Best regards,<br>RSR Global Education</p>
    ";

    $mail->clearAddresses(); // Clear previous recipients
    $mail->addAddress($from); // Add the sender as recipient
    $mail->Subject = $sub1;
    $mail->Body    = $confirmation_message;
    $mail->AltBody = strip_tags($confirmation_message);

    $mail->send();
    echo 'ok';

} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
