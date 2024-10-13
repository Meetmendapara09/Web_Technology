<?php
include './config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $email_send = "zenvedasync.info@gmail.com";
    $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = $_ENV['SMTP_HOST'];
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['SMTP_USERNAME'];
            $mail->Password = $_ENV['SMTP_PASSWORD'];
            $mail->SMTPSecure = $_ENV['SMTP_SECURE'];
            $mail->Port = $_ENV['SMTP_PORT'];

            $mail->setFrom($_ENV['SMTP_USERNAME'], 'Zenvedasync');

            $mail->addAddress($email_send,$name);
            $mail->isHTML(true);

        $mail->Subject = "New message from $name";
        $mail->Body    = nl2br("Name: $name<br>Email: $email<br>Message: $message");

        $mail->send();
        header("Location: ../FrontEnd/Pages/contact-us.html");
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Invalid request.";
}
?>
