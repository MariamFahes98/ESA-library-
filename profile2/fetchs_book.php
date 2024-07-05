<?php
session_start();
require_once 'connection.php';

$status = $_GET['status'];
$userId = $_SESSION['user_id']; // Assumes the user ID is stored in the session

$sql = 'SELECT b.BookID AS id, b.title, b.author FROM book b JOIN user_books ub ON b.BookID = ub.book_id WHERE ub.user_id = ? AND ub.status = ?';
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die(json_encode(['success' => false, 'message' => 'Statement preparation failed: ' . $conn->error]));
}

$stmt->bind_param('is', $userId, $status);
$stmt->execute();
$result = $stmt->get_result();

$books = [];
while ($row = $result->fetch_assoc()) {
    $books[] = $row;
}

$stmt->close();
$conn->close();

echo json_encode(['success' => true, 'books' => $books]);
?>
