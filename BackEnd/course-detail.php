<?php
@include './config.php';

if (isset($_GET['id'])) {
    $course_id = intval($_GET['id']);

    $sql = "SELECT c.id, c.teacher_name, c.title, c.description, c.image_path, c.price, c.updated_at, COUNT(e.student_id) AS enrollment_count FROM courses c JOIN  enrollments e ON c.id = e.course_id WHERE c.id=$course_id";
    
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }
}
$conn->close();

include '../FrontEnd/Pages/Courses/course-details.html';
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