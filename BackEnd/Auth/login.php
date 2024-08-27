<?php

@include '../config.php';

session_start();
// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
   header('location: ../dashboard.php');
   exit();
}

if(isset($_POST['submit'])){

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = md5($_POST['password']);

   $select = "SELECT * FROM user_form WHERE email = '$email' && password = '$pass' ";

   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){

      $row = mysqli_fetch_array($result);
      $_SESSION['user_id'] = $row['user_id'];
      $_SESSION['user_name'] = $row['name'];
      $_SESSION['user_email'] = $row['email'];
      header('location: ../dashboard.php');
      exit();

   }else{
      $error[] = 'incorrect email or password!';
      header('location: ../../FrontEnd/Pages/Auth/Login.html');
   }
   
};
?>
