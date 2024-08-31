<?php
@include './config.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header('location: ../FrontEnd/Pages/Auth/Login.html');
    exit();
}

$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['role'];
$user_name = $_SESSION['user_name'];
$user_email = $_SESSION['user_email'];

if ($user_role == "student") {
    echo "<script>window.location.href='dashboard.php';</script>";
    exit();
}

//profile
if (isset($_POST['upload_photo'])) {

    $profile_Image = $_FILES['profile_photo']['name'];
    $tempname = $_FILES['profile_photo']['tmp_name'];
    $folder = '../uploads/profile_photo/' . $profile_Image;

    $select = "SELECT * FROM teacher_profile WHERE user_id = $user_id";
    $result = $conn->query($select);

    if ($result->num_rows > 0) {

        $conn->query("UPDATE teacher_profile SET profile_image='$profile_Image' WHERE user_id='$user_id'");

        if (move_uploaded_file($tempname, $folder)) {
            echo "<script>alert('File Uploaded');</script>";
        } else {
            echo "<script>alert('File not Uploaded');</script>";
        }
    } else {

        $conn->query("INSERT INTO teacher_profile (profile_photo) 
                VALUES ('$profile_Image')");

        if (move_uploaded_file($tempname, $folder)) {
            echo "<script>alert('File Uploaded');</script>";
        } else {
            echo "<script>alert('File not Uploaded');</script>";
        }
    }
    header('location: dashboard-teacher.php');
    exit();
}

$fetch_photo = "SELECT profile_image FROM teacher_profile WHERE user_id = $user_id";
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

    $select = "SELECT * FROM teacher_profile WHERE user_id = $user_id";
    $result = $conn->query($select);

    if ($result->num_rows > 0) {

        $conn->query("UPDATE teacher_profile SET user_id='$user_id', first_name='$firstName', last_name='$lastName', phone_number='$phone', dob='$dob' WHERE user_id='$user_id'");
    } else {

        $conn->query("INSERT INTO teacher_profile (user_id, first_name, last_name, email, phone_number, dob) 
                VALUES ($user_id, '$firstName', '$lastName', '$user_email', '$phone', '$dob')");

    }
    header('location: dashboard-teacher.php');
    exit();
}

$firstName = '';
$lastName = '';
$phone = '';
$dob = '';

$fetch = "SELECT first_name, last_name, phone_number, dob FROM teacher_profile WHERE user_id = $user_id";
$profileResult = $conn->query($fetch);

if ($profileResult->num_rows > 0) {
    $profileData = $profileResult->fetch_assoc();
    $firstName = $profileData['first_name'];
    $lastName = $profileData['last_name'];
    $phone = $profileData['phone_number'];
    $dob = $profileData['dob'];
}


if (isset($_POST['submit_form2'])) {

    $course_title = $_POST['course_title'];
    $course_description = $_POST['course_description'];
    $course_category = $_POST['course_category'];
    $course_price = floatval($_POST['course_price']);
    $teacher_id = $_SESSION['user_id'];


    $course_videos = $_FILES['course_video']['name'];
    $tempnames = $_FILES['course_video']['tmp_name'];
    $folder = '../uploads/videos/' . $course_videos;


    $select = "SELECT * FROM teacher_profile WHERE user_id = $user_id";
    $result = $conn->query($select);
    

    if ($result->num_rows > 0) {

        $teacher_row = $result->fetch_assoc();
        $teacher_name = $teacher_row['first_name'] . ' ' . $teacher_row['last_name'];

        $conn->query("INSERT INTO courses (teacher_id, teacher_name, title, description, price, content_file) 
            VALUES ('$teacher_id', '$teacher_name' ,'$course_title', '$course_description', '$course_price', '$course_videos')");

        if (move_uploaded_file($tempnames, $folder)) {
            echo "<script>alert('File Uploaded');</script>";
        } else {
            echo "<script>alert('File not Uploaded. Please upload ');</script>";
        }
        echo "<script>alert('Course created successfully.');  window.location.href='dashboard-teacher.php';</script>";

        exit();
    } else {
        echo "<script>alert('Error creating course: " . $conn->error . "');</script>";
        exit();
    }
}


$sql = "SELECT * FROM courses WHERE teacher_id = '$user_id'";
$result = $conn->query($sql);

if (isset($_GET['delete'])) {
    $course_id = $_GET['delete'];
    $deleteQuery = "DELETE FROM courses WHERE id = '$course_id'";

    if ($conn->query($deleteQuery) === TRUE) {
        echo "<script>alert('Course deleted successfully.'); window.location.href='dashboard-teacher.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error deleting course: " . $conn->error . "');</script>";
    }
}

if (isset($_POST['submit_form3'])) {

    $currentPassword = md5($_POST['current_password']);
    $newPassword = md5($_POST['new_password']);
    $confirmPassword = md5($_POST['confirm_password']);

    // Fetch the current password from the database
    $select = "SELECT password FROM user_form WHERE user_id = $user_id";
    $result = $conn->query($select);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $dbPassword = $row['password'];

        // Verify the current password
        if ($currentPassword === $dbPassword) {
            // Check if the new password and confirm password match
            if ($newPassword === $confirmPassword) {
                // Update the password in the database
                $update = "UPDATE user_form SET password='$newPassword' WHERE user_id='$user_id'";
                if ($conn->query($update) === TRUE) {
                    echo "<script>alert('Password changed successfully.');</script>";
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
    header('location: dashboard-teacher.php');
    exit();
}

if (isset($_POST['close-account'])) {

    $deleteProfile = "DELETE FROM teacher_profile WHERE user_id = $user_id";
    $conn->query($deleteProfile);

    $deleteUser = "DELETE FROM user_form WHERE user_id = $user_id";

    if ($conn->query($deleteUser) === TRUE) {

        session_unset();
        session_destroy();

        echo '<script>alert("Your account has been closed successfully.");</script>';
        header('location: ../FrontEnd/Pages/Auth/Login.html');
        exit();
    } else {
        echo '<script>alert("Error closing your account. Please try again.");</script>';
    }
}

include '../FrontEnd/Pages/dashboard-teacher.html';
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