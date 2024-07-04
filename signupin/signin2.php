<?php
require_once 'connection.php';
$login_success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT UserID , email, password, role FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        error_log("User data: " . print_r($user, true));

        if (password_verify($password, $user['password'])) {
            $_SESSION['user-email'] = $email;
            $_SESSION['user-role'] = $user['role'];
            $_SESSION['UserID'] = $user['UserID'];
            $login_success = true;

            if (isset($_POST['remember'])) {
                $token = bin2hex(random_bytes(16));
                store_token_for_user($email, $token);
                setcookie('remember_me', $token, time() + (30 * 24 * 60 * 60), '/', '', isset($_SERVER["HTTPS"]), true);
            }

            header('Location: ../Index/index.php');
            exit();
        } else {
            $_SESSION['error'] = 'Wrong login/password';
            $_SESSION['form_data'] = $_POST;
        }
    } else {
        $_SESSION['error'] = 'User not found';
        $_SESSION['form_data'] = $_POST;
    }

    $stmt->close();
}

$conn->close();
header('Location: signin.php');

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