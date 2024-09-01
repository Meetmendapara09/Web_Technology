<?php

@include '../config.php';

require __DIR__ . '/../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);

    $select = "SELECT * FROM password_resets WHERE token='$token'";
    $result = mysqli_query($conn, $select);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $email = $row['email'];

        $conn->query("UPDATE user_form SET password='$new_password' WHERE email='$email'");

        $conn->query("DELETE FROM password_resets WHERE token='$token'");

        // Send email with successfully password reset
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

            $mail->Subject = 'Password Reset Successful';
            $mail->Body = "
<html>
<head>
    <title>Password Reset Successful</title>
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
    <p>Your password has been successfully reset. You can now log in with your new password.</p>
    <p>If you did not perform this action, please contact our support team immediately.</p>
    <p>Thank you,<br>ZenVedasync</p>
    <div class='footer'>
        <div class='social-icons'>
            <a href='https://www.facebook.com/yourprofile' target='_blank' title='Facebook'>
                <img src='https://upload.wikimedia.org/wikipedia/commons/thumb/f/ff/Facebook_logo_36x36.svg/1200px-Facebook_logo_36x36.svg.png' alt='Facebook'>
            </a>
            <a href='https://www.twitter.com/yourprofile' target='_blank' title='Twitter'>
                <img src='https://upload.wikimedia.org/wikipedia/commons/thumb/c/ce/X_logo_2023.svg/100px-X_logo_2023.svg.png' alt='Twitter'>
            </a>
            <a href='https://www.linkedin.com/in/yourprofile' target='_blank' title='LinkedIn'>
                <img src='https://upload.wikimedia.org/wikipedia/commons/c/ca/LinkedIn_logo_initials.png' alt='LinkedIn'>
            </a>
            <a href='https://www.instagram.com/yourprofile' target='_blank' title='Instagram'>
                <img src='https://upload.wikimedia.org/wikipedia/commons/a/a5/Instagram_icon.png' alt='Instagram'>
            </a>
        </div>
        <p>ZenVedasync<br>
        123 Business St,<br>
        Business City, Ahmedabad 380001<br>
        <a href='mailto:zenvedasync.info@gmail.com'>zenvedasync.info@gmail.com</a> | <a href='https://zenvedasync.com'>www.zenvedasync.com</a></p>
        <p>&copy; " . date('Y') . " ZenVedasync. All rights reserved.</p>
    </div>
</body>
</html>
";

            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Invalid token.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white rounded-lg shadow-lg max-w-sm w-full p-8">
        <h1 class="text-2xl font-bold text-blue-900 mb-6 text-center">Reset Password</h1>
        <form action="" method="POST">
            <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                <input type="password" id="password" name="password" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <button type="submit" name="submit"
                class="w-full bg-blue-900 text-white py-2 px-4 rounded-md hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Reset Password
            </button>
        </form>
    </div>
</body>

</html>