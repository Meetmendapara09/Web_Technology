<?php
session_start();

include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('location: ../FrontEnd/Pages/Auth/Login.html');
    exit();
}

$student_id = $_SESSION['user_id'];

if (isset($_GET['id'])) {
    $course_id = intval($_GET['id']);

    $enroll_sql = "SELECT course_id, student_name FROM enrollments WHERE course_id = $course_id AND student_id = $student_id";

    $enroll_result = $conn->query($enroll_sql);
    $name = $enroll_result->fetch_assoc();

    if ($enroll_result->num_rows == 0) {
        header('location: ../FrontEnd/Pages/Courses/free-courses.html');
        exit();
    } else {
        $sql = "SELECT id, title, description, teacher_name ,content_file, likes FROM courses WHERE id = $course_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['id']) && $_GET['action'] == 'like') {
    $course_id = intval($_GET['id']);

    $sql = "SELECT likes FROM courses WHERE id = $course_id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $new_likes = $row['likes'] + 1;

        $update_sql = "UPDATE courses SET likes = $new_likes WHERE id = $course_id";
        mysqli_query($conn, $update_sql);
    }
}

$username = $_SESSION['user_name'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comment']) && isset($_GET['id'])) {

    $course_id = intval($_GET['id']);
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);

    $sql = "INSERT INTO comments (course_id, comment,Student_name) VALUES ($course_id, '$comment','$username')";
    mysqli_query($conn, $sql);
}

include '../FrontEnd/Pages/Video-Player/Video-Player.html';

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