<?php
@include 'config.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if (isset($_POST['submit'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = md5($_POST['password']);
    $cpass = md5($_POST['confirm_password']);

    $select = "SELECT * FROM user_form WHERE email = '$email'";
    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {
        $error[] = 'User already exists!';
    } else {
        if ($pass != $cpass) {
            $error[] = 'Passwords do not match!';
        } else {
            $insert = "INSERT INTO user_form(name, email, password) VALUES('$name','$email','$pass')";
            if (mysqli_query($conn, $insert)) {
                
                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host = '';
                    $mail->SMTPAuth = true;
                    $mail->Username = '' // SMTP username
                    $mail->Password = '';
                    $mail->SMTPSecure = ;
                    $mail->Port = ;

                    $mail->setFrom('noreply@zenvedasync.com', 'ZenVedasync');
                    $mail->addAddress($email, $name);

                    $mail->isHTML(true);
                    $mail->Subject = 'Welcome to ZenVedasync!';
                    $mail->Body = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
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
    <p>Hi ' . htmlspecialchars($name) . ',</p>
    <p>Thank you for signing up with ZenVedasync!</p>
    <p>To get started, please verify your email by clicking the link below:</p>
    <p><a href="http://your-domain.com/verify.php?email=' . urlencode($email) . '">Verify Email</a></p>
    <p>If you have any questions, feel free to contact us at support@example.com.</p>
    <p>Welcome aboard!</p>
    <p>ZenVedasync</p>
    
    <div class="footer">
        <div class="social-icons">
            <a href="https://www.facebook.com/yourprofile" target="_blank" title="Facebook">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/ff/Facebook_logo_36x36.svg/1200px-Facebook_logo_36x36.svg.png" alt="Facebook">
            </a>
            <a href="https://www.twitter.com/yourprofile" target="_blank" title="Twitter">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/ce/X_logo_2023.svg/100px-X_logo_2023.svg.png">
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
        Business City, BC 12345<br>
        <a href="mailto:support@example.com">support@example.com</a> | <a href="http://your-domain.com">www.your-domain.com</a></p>
        <p>&copy; ' . date("Y") . ' ZenVedasync. All rights reserved.</p>
    </div>
</body>
</html>
';

                    $mail->send();
                    header('Location: login.html');
                    exit();
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            }
        }
    }
}
?>
