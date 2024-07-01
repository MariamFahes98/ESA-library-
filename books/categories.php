<?php
require_once 'connection.php';
$login_success = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category = $_POST['category'];
    $_SESSION['category'] = $category;
}

?>
