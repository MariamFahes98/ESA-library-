<?php


// Check if wishlist is set in session and not empty
if (isset($_SESSION['wishlist']) && !empty($_SESSION['wishlist'])) {
    // Connect to database to fetch details of books in wishlist
    require_once 'connection.php';

    echo '<h2>Your Wishlist</h2>';
    echo '<ul>';
    foreach ($_SESSION['wishlist'] as $bookId) {
        // Fetch book details from database using $bookId
        $sql = 'SELECT * FROM book WHERE BookID = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $bookId);
        $stmt->execute();
        $result = $stmt->get_result();
        $book = $result->fetch_assoc();

        echo '<li>' . $book['title'] . ' by ' . $book['author'] . '</li>';
    }
    echo '</ul>';
} else {
    echo '<p>Your wishlist is empty.</p>';
}
?>
