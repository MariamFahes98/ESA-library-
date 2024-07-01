<?php
session_start();
require_once 'connection.php';

if (!isset($_SESSION['user-email'])) {
    header('Location: signin.php');
    exit();
}

$user_email = $_SESSION['user-email'];

function get_user_by_email($email) {
    global $conn;
    $stmt = $conn->prepare("SELECT  name,email, password, phonenumber, bio FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
    return $user;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $new_email = $_POST['email'];
    $mob = $_POST['mob'];
    $bio = $_POST['bio'];
    $password = $_POST['password'];
    $name = $fname . $lname ;

    if ($password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE user SET name = ?,  email = ?, phonenumber = ?, bio = ?, password = ? WHERE email = ?");
        $stmt->bind_param("sssssss", $name , $new_email, $mob, $bio, $hashed_password, $user_email);
    } else {
        $stmt = $conn->prepare("UPDATE user SET name = ?, email = ?, phonenumber = ?, bio = ? WHERE email = ?");
        $stmt->bind_param("ssssss", $name , $new_email, $mob, $bio, $user_email);
    }
    $stmt->execute();
    $stmt->close();

    $_SESSION['user-email'] = $new_email; // Update session if email changes
    echo "<script>alert('Profile updated successfully'); window.location.href = './profile.html';</script>";
    exit();
}

$user = get_user_by_email($user_email);

$conn->close();
?>