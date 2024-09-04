<?php
include 'config.php';

$select = "SELECT title, description, image_path FROM courses WHERE type='free'";
$result = $conn->query($select);

if ($result->num_rows > 0) {

    $courses = [];
    while($row = $result->fetch_assoc()) {
        $courses[] = $row;
    }
    
    echo json_encode($courses);
} else {
    echo json_encode([]);
}

$conn->close();
?>
