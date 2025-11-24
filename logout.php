<?php
session_start();
session_destroy(); 
header("Location: signup.php"); // Redirect to the login page
exit();
?>
