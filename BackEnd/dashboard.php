<?php
@include './config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

session_start();

if (!isset($_SESSION['user_id'])) {
   header('location: ../FrontEnd/Pages/Auth/Login.html');
   exit();
}

$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['role'];
$user_name = $_SESSION['user_name'];
$user_email = $_SESSION['user_email'];

if ($user_role == "teacher") {
    echo "<script>window.location.href='dashboard-teacher.php';</script>";
    exit();
}

//profile
if (isset($_POST['upload_photo'])) {
    
    $profile_Image = $_FILES['profile_photo']['name'];
    $tempname = $_FILES['profile_photo']['tmp_name'];
    $folder = '../uploads/profile_photo/'. $profile_Image;

    $select = "SELECT * FROM user_profile WHERE user_id = $user_id";
    $result = $conn->query($select);

    if ($result->num_rows > 0) {

        $conn->query("UPDATE user_profile SET profile_image='$profile_Image' WHERE user_id='$user_id'");

        if (move_uploaded_file($tempname, $folder)) {
            echo "<script>alert('File Uploaded');</script>";
        } else {
            echo "<script>alert('File not Uploaded');</script>";
        }
    } else {

        $conn->query("INSERT INTO user_profile (profile_image) 
                VALUES ('$profile_Image')");

        if (move_uploaded_file($tempname, $folder)) {
            echo "<script>alert('File Uploaded'); </script>";
        } else {
            echo "<script>alert('File not Uploaded');</script>";
        }
    }
    header('location: dashboard.php');
    exit();

}

$fetch_photo = "SELECT profile_image FROM user_profile WHERE user_id = $user_id";
$photoResult = $conn->query($fetch_photo);

if ($photoResult->num_rows > 0) {
    $profileData = $photoResult->fetch_assoc();
    $photo = $profileData['profile_image'];
} else {
    $photo = 'default_profile.jpg'; 
}


if (isset($_POST['submit_form1'])) {

    $firstName = $_POST['firstname'];
    $lastName = $_POST['lastname'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $institute = $_POST['institute'];

    $select = "SELECT * FROM user_profile WHERE user_id = $user_id";
    $result = $conn->query($select);

    if ($result->num_rows > 0) {

        $conn->query("UPDATE user_profile SET user_id='$user_id', first_name='$firstName', last_name='$lastName', phone_number='$phone', dob='$dob', institute='$institute' WHERE user_id='$user_id'");

    } else {
        // Insert new profile
        $conn->query("INSERT INTO user_profile (user_id, first_name, last_name, phone_number, dob, institute) 
                VALUES ($user_id, '$firstName', '$lastName', '$phone', '$dob', '$institute')");
    }
    header('location: dashboard.php');
    exit();
}

$firstName = '';
$lastName = '';
$phone = '';
$dob = '';
$institute = '';

$fetch = "SELECT first_name, last_name, phone_number, dob,institute FROM user_profile WHERE user_id = $user_id";
$profileResult = $conn->query($fetch);

if ($profileResult->num_rows > 0) {
    $profileData = $profileResult->fetch_assoc();
    $firstName = $profileData['first_name'];
    $lastName = $profileData['last_name'];
    $phone = $profileData['phone_number'];
    $dob = $profileData['dob'];
    $institute = $profileData['institute'];
}

if (isset($_POST['submit_form2'])) {
    // Get the form data
    $currentPassword = md5($_POST['current_password']);
    $newPassword = md5($_POST['new_password']);
    $confirmPassword = md5($_POST['confirm_password']);

    $select = "SELECT password FROM user_form WHERE user_id = $user_id";
    $result = $conn->query($select);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $dbPassword = $row['password'];

        if ($currentPassword === $dbPassword) {
            if ($newPassword === $confirmPassword) {
                // Update the password in the database
                $update = "UPDATE user_form SET password='$newPassword' WHERE user_id='$user_id'";
                if ($conn->query($update) === TRUE) {
                    echo '<script>alert("Password changed successfully.")</script>';
                } else {
                    echo '<script>alert("Error updating password.")</script>';
                }
            } else {
                echo '<script>alert("New password and confirm password do not match.")</script>';
            }
        } else {
            echo '<script>alert("Current password is incorrect.")</script>';
        }
    } else {
        echo '<script>alert("User not found.")</script>';
    }
    header('location: dashboard.php');
    exit();
}

$payment_fetch = "SELECT * FROM enrollments WHERE student_id = $user_id";
$payment = $conn->query($payment_fetch);


if (isset($_POST['close-account'])) {

    $deleteProfile = "DELETE FROM user_profile WHERE user_id = $user_id";

    $conn->query($deleteProfile);

    $deleteUser = "DELETE FROM user_form WHERE user_id = $user_id";
    
    if ($conn->query($deleteUser) === TRUE) {
        
        session_unset();
        session_destroy();

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

            $mail->Subject = 'Closed Account successfully.';
            $mail->Body = '
<html>
<head>
    <title>Closed Account successfully.</title>
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
    <p>Dear ' . htmlspecialchars($user_name) . ',</p>
    <p>Your Account Successfully</p>
<p>We regret to inform you that your account with ZenVedasync has been successfully closed as per your request.</p>
    <p>If you did not request this action or believe this was done in error, please contact our support team immediately.</p>
    <p>We hope to serve you again in the future. Thank you for being a valued member of our community.</p>
    <p>Best Regards,<br>ZenVedasync Team</p>
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
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
        
        echo '<script>alert("Your account has been closed successfully.");</script>';
        header('location: ../FrontEnd/Pages/Auth/Login.html');
        exit();
    } else {
        echo '<script>alert("Error closing your account. Please try again.");</script>';
    }
}

include '../FrontEnd/Pages/dashboard.html';
?>


<script>
    document.addEventListener('DOMContentLoaded', () => {
        fetch('../FrontEnd/header.html')
            .then(response => response.text())
            .then(data => {
                document.getElementById('dashboard-header').innerHTML = data;
                header_change();
            })
            .catch(error => console.error('Error loading header:', error));
    });

    document.addEventListener('DOMContentLoaded', () => {
        fetch('../FrontEnd/footer.html')
            .then(response => response.text())
            .then(data => {
                document.getElementById('dashboard-footer').innerHTML = data;
            })
            .catch(error => console.error('Error loading footer:', error));
    });
</script>