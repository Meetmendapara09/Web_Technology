<?php
@include '../config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if (!isset($_SESSION['user_id'])) {
    header('location: ../../FrontEnd/Pages/Auth/Login.html');
    exit();
}

session_start();

if (isset($_GET['razorpay_payment_id'])) {
    $payment_id = $_GET['razorpay_payment_id'];
    $course_id = $_SESSION['course_id'];
    $student_id = $_SESSION['user_id'];

    $student_name = $_SESSION['user_name'];
    $student_email = $_SESSION['user_email'];
    $student_phone = $_SESSION['user_phone'] ?? 'N/A';

    $course_sql = "SELECT * FROM courses WHERE id = $course_id";
    $course_result = $conn->query($course_sql);

    if ($course_result->num_rows > 0) {
        $course = $course_result->fetch_assoc();
        $course_title = $course['title'];
        $amount = $course['price'];

        $enrollment_date = date('Y-m-d H:i:s');
        $payment_status = 'Paid';

        $enroll_sql = "INSERT INTO enrollments (
                            student_id, student_name, student_email, student_phone, 
                            course_id, course_title, amount, enrollment_date, 
                            payment_status, razorpay_payment_id
                        ) 
                        VALUES (
                            $student_id, '$student_name', '$student_email', '$student_phone',
                            $course_id, '$course_title', $amount, '$enrollment_date',
                            '$payment_status', '$payment_id'
                        )";

        if ($conn->query($enroll_sql) === TRUE) {
            echo "Enrollment successfull!";
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

                $mail->Subject = 'Enrollment Confirmation - ' . $course_title;
                $mail->Body = '
    <html>
    <head>
    <title>Enrollment Confirmation - ' . htmlspecialchars($course_title) . ' </title>
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
    <h2>Congratulations, $name!</h2>
            <p>You have successfully enrolled in <strong>$course_title</strong>.</p>
            <p><strong>Payment Details:</strong></p>
            <ul>
                <li>Amount: ₹' . htmlspecialchars($amount) . '</li>
                <li>Enrollment Date: ' . htmlspecialchars($enrollment_date) . '</li>
                <li>Payment ID: ' . htmlspecialchars($payment_id) . '</li>
            </ul>
            <p>Thank you for choosing our platform! We wish you the best of luck with your learning journey.</p>
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
                echo '<script>window.location.href = "../dashboard.php";</script>';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
            unset($_SESSION['razorpay_order_id'], $_SESSION['course_id'], $_SESSION['course_amount'], $_SESSION['user_phone']);
            exit();
        } else {
            echo "Error enrolling in course: " . $conn->error;
            unset($_SESSION['razorpay_order_id'], $_SESSION['course_id'], $_SESSION['course_amount'], $_SESSION['user_phone']);
            exit();
        }
    } else {
        echo "Course not found.";
        exit();
    }
} else {
    echo "Payment failed.";
    exit();
}
