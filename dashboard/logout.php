<?php
session_start();
session_unset();
session_destroy();
header('Location: ../signupin/signin.php');
// header('location:loginamal.php');
exit();

?>