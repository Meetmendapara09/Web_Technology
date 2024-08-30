<?php

include 'config.php';

if (isset($_GET['id'])) {
    $course_id = intval($_GET['id']);

    $sql = "SELECT * FROM courses WHERE id = $course_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $course = $result->fetch_assoc();
    } else {
        echo "Course not found.";
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}


if (isset($_POST['update_course'])) {
    $title = $_POST['course_title'];
    $description = $_POST['course_description'];
    $price = floatval($_POST['course_price']);


    $select = "SELECT * FROM teacher_profile WHERE user_id = $user_id";
    $result = $conn->query($select);

    if ($result->num_rows > 0) {
        $conn->query("UPDATE courses SET title='$title', description='$description', price='$price' WHERE id=$course_id");

        echo "<script>alert('Course updated successfully.'); window.alert('dashboard-teacher.php');</script>";
        exit();
    } else {
        echo "<script>alert('Error updating course: " . $conn->error . "');</script>";
    }
}

include '../FrontEnd/Pages/edit-course.html';
?>
