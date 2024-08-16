<?php

@include '../config.php';
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

        // Update user's password
        $conn->query("UPDATE user_form SET password='$new_password' WHERE email='$email'");

        // Delete the token
        $conn->query("DELETE FROM password_resets WHERE token='$token'");

        // Send email with successfully password reset
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
                    $mail->addAddress($email);
                    $mail->isHTML(true);

                    $mail->Subject = 'Password Reset Successful';
                    $mail->Body = "
                    <html>
                    <head>
                        <title>Password Reset Successful</title>
                    </head>
                    <body>
                        <p>Dear User,</p>
                        <p>Your password has been successfully reset. You can now log in with your new password.</p>
                        <p>If you did not perform this action, please contact our support team immediately.</p>
                        <p>Thank you,<br>zenVedasync</p>
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

