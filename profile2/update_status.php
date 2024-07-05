<?php
session_start();
require_once 'connection.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit();
}

$userId = $_SESSION['user_id'];
$input = json_decode(file_get_contents('php://input'), true);
$bookId = $input['bookId'];
$status = $input['status'];

$sql = 'INSERT INTO user_books (user_id, book_id, status) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE status = VALUES(status)';
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die(json_encode(['success' => false, 'message' => 'Statement preparation failed: ' . $conn->error]));
}

$stmt->bind_param('iis', $userId, $bookId, $status);
$success = $stmt->execute();
$stmt->close();
$conn->close();

echo json_encode(['success' => $success]);
?>
