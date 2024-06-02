<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../assets/vendor/autoload.php'; // Adjust path if needed

// Replace contact@example.com with your real receiving email address
$receiving_email_address = 'leosglasswindowsdoors@gmail.com';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
  $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
  $phone = htmlspecialchars($_POST['phone'], ENT_QUOTES, 'UTF-8');
  $message = htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8');

  // Validate inputs
  if (empty($name) || !$email || empty($phone) || empty($message)) {
    die('Please fill all the fields with valid data.');
  }

  $mail = new PHPMailer(true);

  try {
    // SMTP configuration
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'leosglasswindowsdoors@gmail.com'; // SMTP username
    $mail->Password = 'nhzj pvas atgx pejk'; // App password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587; // TCP port to connect to

    // Recipients
    $mail->setFrom($email, $name);
    $mail->addAddress($receiving_email_address); // Add a recipient

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Request for a quote';
    $mail->Body    = "Name: $name<br>Email: $email<br>Phone: $phone<br>Message: " . nl2br($message);
    $mail->AltBody = "Name: $name\nEmail: $email\nPhone: $phone\nMessage: $message";

    $mail->send();
    echo 'OK'; // Return 'OK' on success
  } catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }
}
?>
