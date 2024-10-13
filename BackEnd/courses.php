<?php
@include './config.php';

$sql = "SELECT id, teacher_name, title, image_path FROM courses ORDER BY created_at DESC";
$result = $conn->query($sql);

$courses = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $courses[] = $row;
    }
}

$sqls = "
    SELECT 
        c.id, 
        c.teacher_name, 
        c.title, 
        c.image_path, 
        COUNT(e.student_id) AS enrollment_count
    FROM 
        courses c
    LEFT JOIN 
        enrollments e ON c.id = e.course_id
    GROUP BY 
        c.id, c.teacher_name, c.title, c.image_path
    ORDER BY 
        enrollment_count DESC
    LIMIT 10";

$results = $conn->query($sqls);

$coursespop = [];

if ($results->num_rows > 0) {
    while($row = $results->fetch_assoc()) {
        $coursespop[] = $row;
    }
}

$response = [
    'latest_courses' => $courses,
    'popular_courses' => $coursespop
];

echo json_encode($response);
$conn->close();
?>