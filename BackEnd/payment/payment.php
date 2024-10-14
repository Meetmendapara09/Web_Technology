<?php
session_start();

@include './config.php';
require __DIR__ . '/../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['razorpay_order_id']) || !isset($_SESSION['course_id'])) {
    header('location: ../../FrontEnd/Pages/Auth/Login.html');
    exit();
}

$order_id = $_SESSION['razorpay_order_id'];
$course_id = $_SESSION['course_id'];
$user_email = $_SESSION['user_email'];
$user_name = $_SESSION['user_name'];

$amount = $_SESSION['course_amount'];

include '../../FrontEnd/Pages/Payment.html';
?>

<script>
    var options = {
        "key": "<?php echo $_ENV['API_KEY']; ?>",
        "amount": "<?php echo $amount; ?>",
        "currency": "INR",
        "name": "<?php echo $user_name; ?>",
        "description": "Payment for Course Enrollment",
        "order_id": "<?php echo $order_id; ?>",
        "handler": function(response) {
            window.location.href = "payment-success.php?razorpay_payment_id=" + response.razorpay_payment_id;
        },
        "prefill": {
            "name": "<?php echo $user_name; ?>",
            "email": "<?php echo $user_email; ?>"
        },
        "theme": {
            "color": "#3399cc"
        }
    };

    var rzp = new Razorpay(options);
    document.getElementById('pay-button').onclick = function(e) {
        rzp.open();
        e.preventDefault();
    };
</script>