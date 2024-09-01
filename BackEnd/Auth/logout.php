<?php
session_start();

session_unset();
session_destroy();

echo "<script> 

localStorage.removeItem('isLoggedIn'); 
localStorage.removeItem('profileImage');
alert('Logout Successfully'); 
window.location.href='../../FrontEnd/Pages/Auth/Login.html';

</script>";

exit();
