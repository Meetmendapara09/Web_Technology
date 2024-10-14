<?php  
@include './config.php';  
require __DIR__ . '/../vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

use Razorpay\Api\Api;

session_start(); 

if (!isset($_SESSION['user_id'])) {     
    header('location: ../FrontEnd/Pages/Auth/Login.html');     
    exit();  
}

$user_id = $_SESSION['user_id']; 
$email = $_SESSION['user_email'];  

if (isset($_GET['id'])) {     
    $course_id = intval($_GET['id']); 

    // Fetch course details
    $course_sql = "SELECT * FROM courses WHERE id = $course_id";     
    $course_result = $conn->query($course_sql); 

    $profile_sql = "SELECT * FROM user_profile WHERE user_id = $user_id";     
    $profile_result = $conn->query($profile_sql); 

    if ($course_result->num_rows > 0 && $profile_result->num_rows > 0) {         
        $course = $course_result->fetch_assoc();         
        $student = $profile_result->fetch_assoc(); 

        $student_name = $student['first_name'];         
        $student_phone = $student['phone_number']; 
        $amount = $course['price'] * 100;

        $_SESSION['course_amount'] = $amount;

        try {
            // Initialize Razorpay API
            $api = new Api($_ENV['API_KEY'], $_ENV['API_SECRET']);

            // Create Razorpay order
            $order = $api->order->create([
                'receipt'   => 'order_rcptid_' . $course_id,
                'amount'    => $amount,
                'currency'  => 'INR'
            ]);

            // Store order ID and course ID in session
            $_SESSION['razorpay_order_id'] = $order['id'];
            $_SESSION['course_id'] = $course_id;

            // Redirect to payment page
            header('Location: payment/payment.php');
            exit();
        } catch (Exception $e) {
            echo 'Razorpay Error: ' . $e->getMessage();
            exit();
        }
    } else {
        echo "Course or user not found.";         
        exit();     
    }
} else {
    echo "Invalid request.";     
    exit();
}
?>
