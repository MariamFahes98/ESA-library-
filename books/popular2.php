<?php
require_once 'connection.php';

// Prepare SQL query to fetch books with a rating of 5
$sql = 'SELECT DISTINCT b.BookID , b.code
        FROM book b
        INNER JOIN reviews r ON b.BookID = r.BookID
        WHERE r.rating = 5';

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Statement preparation failed: " . $conn->error);
}

$stmt->execute();
$result = $stmt->get_result();

$books = [];
while ($row = $result->fetch_assoc()) {
    $books[] = $row;
}

$stmt->close();
$conn->close();

// Return books as JSON
header('Content-Type: application/json');
echo json_encode($books);
?>
