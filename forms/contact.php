<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../assets/vendor/autoload.php'; // Adjust path if needed

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
  $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
  $subject = htmlspecialchars($_POST['subject'], ENT_QUOTES, 'UTF-8');
  $message = htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8');

  // Validate inputs
  if (empty($name) || !$email || empty($subject) || empty($message)) {
    die('Please fill all the fields with valid data.');
  }

  $mail = new PHPMailer(true);

  try {
    // SMTP configuration
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'leosglasswindowsdoors@gmail.com'; // SMTP username
    $mail->Password = 'nhzj pvas atgx pejk'; // SMTP password (consider using an App Password)
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587; // TCP port to connect to

    // Recipients
    $mail->setFrom($email, $name);
    $mail->addAddress('leosglasswindowsdoors@gmail.com'); // Add a recipient

    // Content
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body    = nl2br($message);
    $mail->AltBody = $message;

    $mail->send();

    // Send confirmation email to user
    $confirmationMail = new PHPMailer(true);
    $confirmationMail->isSMTP();
    $confirmationMail->Host = 'smtp.gmail.com';
    $confirmationMail->SMTPAuth = true;
    $confirmationMail->Username = 'leosglasswindowsdoors@gmail.com';
    $confirmationMail->Password = 'nhzj pvas atgx pejk';
    $confirmationMail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $confirmationMail->Port = 587;
    
    $confirmationMail->setFrom('leosglasswindowsdoors@gmail.com', 'Leo\'s Glass Windows & Doors');
    $confirmationMail->addAddress($email, $name); // Send to user's email
    
    $confirmationMail->isHTML(true);
    $confirmationMail->Subject = 'Confirmation: We have received your message';
    $confirmationMail->Body    = 'Dear ' . $name . ',<br><br>Thank you for reaching out to us. We have received your message and will get back to you shortly.<br><br>Best regards,<br>Leo\'s Glass Windows & Doors';
    $confirmationMail->AltBody = 'Dear ' . $name . ',\n\nThank you for reaching out to us. We have received your message and will get back to you shortly.\n\nBest regards,\nLeo\'s Glass Windows & Doors';

    $confirmationMail->send();
    
    echo 'OK'; // This should be 'OK' for the JS to recognize success
  } catch (Exception $e) {
    error_log("Mailer Error: {$mail->ErrorInfo}");
    echo "Message could not be sent. Please try again later.";
  }
}
?>
