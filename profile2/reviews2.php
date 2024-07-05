<?php 
session_start();
$dbhost = 'localhost';
$dbname = 'library';
$dbpass = '';
$dbuser = 'root';
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $book = $_POST['book'];
    $reviewText = $_POST['reviewText'];
    $rating = $_POST['rating'];
    $stmt = $conn->prepare('SELECT UserID FROM user WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        $userID = $row['UserID'];
        $stmt = $conn->prepare('SELECT BookID FROM book WHERE BookID = ?');
        $stmt->bind_param('i', $book);
        $stmt->execute();
        $result = $stmt->get_result();
        $bookExists = $result->fetch_assoc();

        if ($bookExists) {
            $stmt2 = $conn->prepare('INSERT INTO reviews (UserID, BookID, name, email, review_text, rating) VALUES (?, ?, ?, ?, ?, ?)');
            $stmt2->bind_param('iisssi', $userID, $book, $name, $email, $reviewText, $rating);

            if ($stmt2->execute()) {
                echo "<script>alert('Thanks for your review.');</script>";
            } else {
                echo "<script>alert('Error: " . $stmt2->error . "');</script>";
            }

            $stmt2->close();
        } else {
            echo "<script>alert('Error: Book not found.');</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Error: User not found.');</script>";
    }
}

$conn->close();
?>