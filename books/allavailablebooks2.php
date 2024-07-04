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

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Fetch all books when the page is first loaded
    $sql = 'SELECT * FROM book';
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

    header('Content-Type: application/json');
    echo json_encode($books);
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['category_id'])) {
        $category = $_POST['category_id'];
        $_SESSION['CategoryID'] = $category;

        $sql = 'SELECT * FROM book WHERE CategoryID = ?';
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Statement preparation failed: " . $conn->error);
        }

        $stmt->bind_param('i', $category);
        $stmt->execute();
        $result = $stmt->get_result();
        $books = [];
        while ($row = $result->fetch_assoc()) {
            $books[] = $row;
        }
        $stmt->close();
        $conn->close();

        header('Content-Type: application/json');
        echo json_encode($books);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Category ID not provided']);
    }
}
?>
