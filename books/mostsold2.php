<?php
require_once 'connection.php';

// Prepare SQL query to fetch the top 5 most sold books
$sql = 'SELECT * FROM book ORDER BY sales_count DESC LIMIT 5';
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
