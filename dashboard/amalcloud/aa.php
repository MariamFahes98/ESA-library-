<?php
session_start();
include 'includes/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you have sanitized or validated these inputs before this point
    $title = $_POST['title'];
    $author = $_POST['author'];
    $price = $_POST['price'];
    $code = $_POST['code'];
    $qty = $_POST['qty'];
    $category = $_POST['category'];

    // Insert query with placeholders for prepared statement
    $sql = "INSERT INTO books (title, author, price, code, quantity, categories_id) 
            VALUES (?, ?, ?, ?, ?, ?)";

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisii", $title, $author, $price, $code, $qty, $category);

    // Execute the statement
    if ($stmt->execute()) {
        // Get the inserted BookId
        $bookId = $stmt->insert_id;

        // Redirect to book.php after successful insertion
        header("Location: book.php?bookId=" . $bookId);
        exit; // Ensure no further output is sent
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
<?php
if (isset($_GET['bookId'])) {
    $bookId = $_GET['bookId'];
    echo "Book ID: " . $bookId;
} else {
    echo "No Book ID found.";
}
?>