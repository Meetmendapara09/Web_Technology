<?php
@include '../config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $token = bin2hex(random_bytes(50));

    $select = "SELECT * FROM user_form WHERE email = '$email'";
    $result = $conn->query($select);

    if ($result->num_rows > 0) {

        $conn->query("INSERT INTO password_resets (email, token) VALUES ('$email', '$token')");

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

            $mail->addAddress($email);
            $mail->isHTML(true);

            $mail->Subject = 'Password Reset';
            $mail->Body = '
<html>
<head>
    <title>Password Reset Request</title>
    <style>
        .footer {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #666;
            text-align: center;
            margin-top: 20px;
        }
        .footer a {
            color: #007bff;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
        .social-icons {
            margin: 10px 0;
        }
        .social-icons a {
            display: inline-block;
            margin: 0 5px;
        }
        .social-icons img {
            width: 24px;
            height: 24px;
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <p>Dear User,</p>
    <p>We received a request to reset your password. Please click the link below to reset your password:</p>
    <p><a href="http://localhost/Web_Technology/BackEnd/Auth/reset_process.php?token=' . $token . '">Reset Password</a></p>
    <p>If you did not request a password reset, please ignore this email or contact support if you have questions.</p>
    <p>Thank you,<br>ZenVedasync</p>
    <div class="footer">
        <div class="social-icons">
            <a href="https://www.facebook.com/yourprofile" target="_blank" title="Facebook">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/ff/Facebook_logo_36x36.svg/1200px-Facebook_logo_36x36.svg.png" alt="Facebook">
            </a>
            <a href="https://www.twitter.com/yourprofile" target="_blank" title="Twitter">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/ce/X_logo_2023.svg/100px-X_logo_2023.svg.png" alt="Twitter">
            </a>
            <a href="https://www.linkedin.com/in/yourprofile" target="_blank" title="LinkedIn">
                <img src="https://upload.wikimedia.org/wikipedia/commons/c/ca/LinkedIn_logo_initials.png" alt="LinkedIn">
            </a>
            <a href="https://www.instagram.com/yourprofile" target="_blank" title="Instagram">
                <img src="https://upload.wikimedia.org/wikipedia/commons/a/a5/Instagram_icon.png" alt="Instagram">
            </a>
        </div>
        <p>ZenVedasync<br>
        123 Business St,<br>
        Business City, Ahmedabad 380001<br>
        <a href="mailto:zenvedasync.info@gmail.com">zenvedasync.info@gmail.com</a> | <a href="https://zenvedasync.com">www.zenvedasync.com</a></p>
        <p>&copy; ' . date("Y") . ' ZenVedasync. All rights reserved.</p>
    </div>
</body>
</html>';
            $mail->send();
            echo '<script>window.alert("Password reset link send on your email address."); window.location.href = "../../FrontEnd/Pages/Auth/Login.html";</script>';
            exit();
            
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        $error[] = 'No user found with that email address.';
            echo '<script>localStorage.setItem("error", 
      "No user found with that email address."); window.location.href = "../../FrontEnd/Pages/Auth/SignUp.html";</script>';
    }
}
