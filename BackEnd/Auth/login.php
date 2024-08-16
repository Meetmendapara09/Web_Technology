<?php

@include '../config.php';

session_start();
// Redirect if already logged in
if (isset($_SESSION['admin_name'])) {
   header('location:admin_page.php');
   exit();
}

if(isset($_POST['submit'])){

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = md5($_POST['password']);

   $select = " SELECT * FROM register WHERE email = '$email' && password = '$pass' ";

   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){

      $row = mysqli_fetch_array($result);
      $_SESSION['admin_name'] = $row['name'];
      header('location: admin_page.php');
      exit();

   }else{
      $error[] = 'incorrect email or password!';
   }
   
};
?>
