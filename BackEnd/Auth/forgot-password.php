<?php

@include '../config.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $token = bin2hex(random_bytes(50));

    $select = "SELECT * FROM user_form WHERE email = '$email'";
    $result = mysqli_query($conn, $select);

    if ($result->num_rows > 0) {
        // Insert token into password_resets table
        $conn->query("INSERT INTO password_resets (email, token) VALUES ('$email', '$token')");

        // Send email with reset link using PHPMailer
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
                    $mail->Host = getenv('SMTP_HOST');
                    $mail->SMTPAuth = true;
                    $mail->Username = getenv('SMTP_USERNAME');
                    $mail->Password = getenv('SMTP_PASSWORD');
                    $mail->SMTPSecure = getenv('SMTP_SECURE');
                    $mail->Port = getenv('SMTP_PORT');

                    $mail->setFrom('noreply@zenvedasync.com', 'ZenVedasync');
                    $mail->addAddress($email, $name);
                    $mail->isHTML(true);

            $mail->Subject = 'Password Reset';
            $mail->Body = "
<html>
<head>
    <title>Password Reset Request</title>
</head>
<body>
    <p>Dear User,</p>
    <p>We received a request to reset your password. Please click the link below to reset your password:</p>
    <p><a href='http://localhost/Web_Technology/BackEnd/Auth/reset_process.php?token=$token'>Reset Password</a></p>
    <p>If you did not request a password reset, please ignore this email or contact support if you have questions.</p>
    <p>Thank you,<br>zenVedasync</p>
</body>
</html>
";
            $mail->send();
            echo 'Password reset link has been sent to your email.';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "No user found with that email address.";
    }
}
?>