<?php
session_start();
// remove all session variables
session_unset();

// destroy the session
session_destroy();
// print_r($_SESSION);
// echo "Successfully Logout";
header("Location: ../index/index.php");
exit();
?>