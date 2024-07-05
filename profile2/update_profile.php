<?php
session_start();
require_once 'connection.php';

if (isset($_SESSION['user-email'])) {
    $userEmail = $_SESSION['user-email'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Sanitize and validate inputs
        $firstName = trim($_POST['fname']);
        $lastName = trim($_POST['lname']);
        $email = trim($_POST['email']);
        $mob = trim($_POST['mob']);
        $password = $_POST['password'];
        $confirmpassword = $_POST['confirmpassword'];
        $bio = trim($_POST['bio']);

        $errors = [];

        // Check if all fields are filled
        if (empty($firstName) || empty($lastName) || empty($email) || empty($password) || empty($confirmpassword)) {
            $errors[] = "Please fill all the required fields.";
        }

        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format.";
        }

        // Validate phone number (simple check for digits only)
        if (!preg_match('/^[0-9]+$/', $mob)) {
            $errors[] = "Invalid phone number.";
        }

        // Check if passwords match
        if ($password !== $confirmpassword) {
            $errors[] = "Passwords do not match.";
        }

        // Additional password complexity checks (e.g., length, characters)
        if (strlen($password) < 8) {
            $errors[] = "Password must be at least 8 characters long.";
        }

        // Handle file upload if an image is selected
        if (!empty($_FILES['image']['name'])) {
            $image = $_FILES['image'];
            $imageFileName = $image['name'];
            $imageTempName = $image['tmp_name'];
            $imageError = $image['error'];

            if ($imageError === UPLOAD_ERR_OK) {
                $imagePath = 'uploads/' . $imageFileName; // Adjust as per your directory structure
                move_uploaded_file($imageTempName, $imagePath);
            } else {
                $errors[] = "Error uploading image.";
            }
        }

        // Proceed if no errors
        if (empty($errors)) {
            // Hash password
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);
            $fullName = $firstName . " " . $lastName;

            // Update user record in database
            $sql = "UPDATE user SET name = ?, email = ?, Phonenumber = ?, password = ?, bio = ?";
            if (!empty($imagePath)) {
                $sql .= ", image = ?";
            }
            $sql .= " WHERE email = ?";
            
            $stmt = $conn->prepare($sql);
            
            if (!empty($imagePath)) {
                $stmt->bind_param("sssssss", $fullName, $email, $mob, $passwordHash, $bio, $imagePath, $userEmail);
            } else {
                $stmt->bind_param("ssssss", $fullName, $email, $mob, $passwordHash, $bio, $userEmail);
            }

            if ($stmt->execute()) {
                // Update session email if changed
                if ($userEmail != $email) {
                    $_SESSION['user-email'] = $email;
                }
                header("Location: profile.php");
                exit();
            } else {
                echo "Error updating record: " . $conn->error;
            }

            $stmt->close();
        } else {
            // Display errors
            foreach ($errors as $error) {
                echo "<p>$error</p>";
            }
        }
    } else {
        echo "Invalid request method.";
    }
} else {
    // Redirect user if not logged in
    header("Location: ../signupin/signin.php");
    exit();
}
?>
