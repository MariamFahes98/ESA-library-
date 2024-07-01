<?php
session_start();
require_once 'connection.php';
$login_success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT email, password, role FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        error_log("User data: " . print_r($user, true));

        if (password_verify($password, $user['password'])) {
            $_SESSION['user-email'] = $email;
            $_SESSION['user-role'] = $user['role'];
            $login_success = true;

            if (isset($_POST['remember'])) {
                $token = bin2hex(random_bytes(16));
                store_token_for_user($email, $token);
                setcookie('remember_me', $token, time() + (30 * 24 * 60 * 60), '/', '', isset($_SERVER["HTTPS"]), true);
            }

            header('Location:./editInformatio.php');
            exit();
        } else {
            error_log("Password verification failed.");
            echo "<script>alert('Invalid email or password');
            window.location.href = './signin.html';</script>";
        }
    } else {
        error_log("No user found with email: $email");
        echo "<script>alert('No user found');
        window.location.href = './sigin.html';</script>";
    }

    $stmt->close();
}

$conn->close();

function store_token_for_user($email, $token) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO user_tokens (email, token) VALUES (?, ?) ON DUPLICATE KEY UPDATE token = VALUES(token)");
    $stmt->bind_param("ss", $email, $token);
    $stmt->execute();
    $stmt->close();
}

function get_user_by_token($token) {
    global $conn;
    $stmt = $conn->prepare("SELECT email FROM user_tokens WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        return $user['email'];
    } else {
        return false;
    }
}
?>


