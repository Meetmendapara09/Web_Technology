<?php
@include '../config.php';

session_start();

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
   if ($_SESSION['user_role'] === 'teacher') {
      header('location: ../dashboard-teacher.php');
   } else {
      header('location: ../dashboard.php');
   }
   exit();
}

if (isset($_POST['submit'])) {

   $email = $_POST['email'];
   $pass = md5($_POST['password']);

   $select = "SELECT * FROM user_form WHERE email = '$email' && password = '$pass'";
   $result = $conn->query($select);

   if ($result->num_rows > 0) {

      $row = $result->fetch_assoc();
      $_SESSION['user_id'] = $row['user_id'];
      $_SESSION['user_name'] = $row['username'];
      $_SESSION['user_email'] = $row['email'];
      $_SESSION['role'] = $row['role'];

      $_SESSION['isLoggedIn'] = true;

      // Redirect based on user role
      if ($row['role'] === 'teacher') {
         $user_id = $_SESSION['user_id'];
         $fetch_photo = "SELECT profile_image FROM teacher_profile WHERE user_id = $user_id";
         $photoResult = $conn->query($fetch_photo);

         if ($photoResult->num_rows > 0) {
            $profileData = $photoResult->fetch_assoc();
            $profileImage = $profileData['profile_image'];
         } else {
            $profileImage = 'profile_photo';
         }

         echo "<script>
        localStorage.setItem('isLoggedIn', 'true');
        localStorage.setItem('profileImage', '" . addslashes($profileImage) . "');
        window.location.href = '../dashboard-teacher.php';
    </script>";
      } 
      else {
         $user_id = $_SESSION['user_id'];
         $fetch_photo = "SELECT profile_image FROM user_profile WHERE user_id = $user_id";
         $photoResult = $conn->query($fetch_photo);

         if ($photoResult->num_rows > 0) {
            $profileData = $photoResult->fetch_assoc();
            $profileImage = $profileData['profile_image'];
         } else {
            $profileImage = 'profile_photo';
         }
         
         echo "<script>
        localStorage.setItem('isLoggedIn', 'true');
        localStorage.setItem('profileImage', '" . addslashes($profileImage) . "');
        window.location.href = '../dashboard.php';
    </script>";
      }
      exit();
   } else {
      $error[] = 'Incorrect email or password!';
      echo '<script>localStorage.setItem("error", 
      "Incorrect email or password!"); window.location.href = "../../FrontEnd/Pages/Auth/Login.html";</script>';
      exit();
   }
}
