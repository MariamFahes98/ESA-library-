<?php
if (isset($_GET['bookName'])) {
    $bookName = $_GET['bookName'];

    $dbhost = 'localhost';
    $dbname = 'library';
    $dbuser = 'root';
    $dbpass = '';

    $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT BookID FROM book WHERE title = ?");
    $stmt->bind_param("s", $bookName);
    $stmt->execute();
    $stmt->bind_result($bookID);
    $stmt->fetch();

    if ($bookID) {
        echo json_encode(['id' => $bookID]);
    } else {
        echo json_encode(['id' => null]);
    }

    $stmt->close();
    $conn->close();
}
?>

