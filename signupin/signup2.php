<?php 
session_start();
$host = 'localhost';
$dbname = 'library';
$dbpass = '';
$dbuser = 'root';

$conn = new mysqli($host, $dbuser, $dbpass, $dbname);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

if (isset($_POST['submit'])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $userName = $firstName . " " . $lastName;
    $email = $_POST['email'];
    $password = $_POST['password'];

    $errors = [];

    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    }
    if (!preg_match('/[A-Z]/', $password)) {
        $errors[] = "Password must contain at least one uppercase letter.";
    }
    if (!preg_match('/[a-z]/', $password)) {
        $errors[] = "Password must contain at least one lowercase letter.";
    }
    if (!preg_match('/\d/', $password)) {
        $errors[] = "Password must contain at least one number.";
    }
    if (!preg_match('/[\W_]/', $password)) {
        $errors[] = "Password must contain at least one special character.";
    }
    if (count($errors) > 0) {
        echo json_encode(['success' => false, 'message' => implode(" ", $errors)]);
    } 

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    // Check if the email already exists in the database
    $stmt = $conn->prepare("SELECT email FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Email already exists
            $_SESSION['error'] = 'Email already registered. Please use a different email.';
            $_SESSION['form_data'] = $_POST;
    } else {
        // Email does not exist, insert new record
        $stmt->close();
        $stmt = $conn->prepare("INSERT INTO user (name, email, password, role) VALUES (?, ?, ?, 1)");
        $stmt->bind_param("sss", $userName, $email, $hashed_password);

        if ($stmt->execute()) {

            echo "<script>
                    alert('Your registration is complete. We\'re excited to have you join our community!');
                    window.location.href = './index.php';
                  </script>";
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    $stmt->close();
$conn->close();
header('Location: signup.php');
exit;
}
?>
