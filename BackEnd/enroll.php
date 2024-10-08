<?php  
@include './config.php';  
session_start(); 

$user_id = $_SESSION['user_id']; 
$email = $_SESSION['user_email'];  

if (!isset($_SESSION['user_id'])) {     
    header('location: ../FrontEnd/Pages/Auth/Login.html');     
    exit();  
}  

if (isset($_GET['id'])) {     
    $course_id = intval($_GET['id']); 

    // Check if the course exists
    $sql = "SELECT * FROM courses WHERE id = $course_id";     
    $result = $conn->query($sql); 

    // Fetch user profile
    $sql1 = "SELECT * FROM user_profile WHERE user_id = $user_id";     
    $result1 = $conn->query($sql1); 

    if ($result->num_rows > 0) {         
        $course = $result->fetch_assoc();         
        $student = $result1->fetch_assoc(); 

        $student_id = intval($_SESSION['user_id']);         
        $student_name = $student['first_name'];         
        $student_phone = $student['phone_number']; 

        // Check if the user is already enrolled in the course
        $check_enrollment_sql = "SELECT * FROM enrollments WHERE student_id = $student_id AND course_id = $course_id"; 

        $check_result = $conn->query($check_enrollment_sql); 

        if ($check_result->num_rows > 0) {
            echo "<script>alert('You are already enrolled in this course.');</script>"; 
            header("Location: dashboard.php");
            exit(); 

        } else {
            $enrollment_date = date('Y-m-d H:i:s');         
            $payment_status = 'Paid';         
            $amount = $course['price'];         
            $course_title = $course['title'];         

            $enroll_sql = "INSERT INTO enrollments (student_id, student_name, student_email, student_phone, course_id, enrollment_date, payment_status, amount, course_title) VALUES ($student_id, '$student_name', '$email', '$student_phone', $course_id, '$enrollment_date', '$payment_status', $amount, '$course_title')"; 

            if ($conn->query($enroll_sql) === TRUE) {             
                header("Location: dashboard.php");             
                exit();         
            } else {             
                echo "Error enrolling in course: " . $conn->error;             
                exit();         
            } 
        } 
    } else {         
        echo "Course not found.";         
        exit();     
    } 
} else {     
    echo "Invalid request.";     
    exit(); 
}  
?>
