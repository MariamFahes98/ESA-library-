<?php
$servername = "";
$username = "your_username";
$password = "your_password";
$dbname = "your_database_name";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $bookId = intval($_GET['id']);

    $sql = "SELECT * FROM books WHERE id = $bookId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();
    } else {
        echo "Book not found.";
        exit;
    }
} else {
    echo "No book ID provided.";
    exit;
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Details</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="book-details">
        <div class="book-container">
            <div class="book-cover">
                <img src="<?php echo $book['image']; ?>" alt="Book Cover">
            </div>
        </div>
        <div class="book-info">
            <h2><?php echo $book['title']; ?></h2>
            <h4 class="text-muted"><?php echo $book['author']; ?></h4>
            <p><span class="bold-text">Category:</span> <?php echo $book['category']; ?></p>
            <p class="<?php echo strtolower($book['available']) === 'available' ? 'available' : 'unavailable'; ?>"><?php echo $book['available']; ?></p>
            <p><?php echo $book['description']; ?></p>
            <div class="rate">
                <i class="fa fa-star checked" style="font-size: 12px; color: orange;"></i>
                <span style="font-size: 12px;"><?php echo $book['rating']; ?></span>
            </div>
            <h5>$<?php echo $book['price']; ?></h5>
            <div class="wishlist-container"></div>
            <?php if (strtolower($book['available']) === 'available') { ?>
                <button class="btn btn-primary buy">Buy <i class="fas fa-cart-plus add-to-cart-icon"></i></button>
                <button class="btn btn-primary borrow">Borrow <i class="fas fa-cart-plus add-to-cart-icon"></i></button>
            <?php } else { ?>
                <button class="btn btn-secondary wishlist">Add to Wishlist</button>
            <?php } ?>
        </div>
    </div>
</body>
</html>
