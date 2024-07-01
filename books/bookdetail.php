<?php
require_once 'connection.php';

// Get the book ID from the URL query parameter
$bookId = $_GET['id'];

// Prepare SQL query to fetch book details by ID
$sql = 'SELECT * FROM book WHERE BookID = ?';
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Statement preparation failed: " . $conn->error);
}

$stmt->bind_param('i', $bookId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die('Book not found.');
}

$book = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body style = "background-image: url(./assets/oldpaper.jpg); background-position : center ; background-size : cover ">
    <div class="container mt-5">
        <div  class="card shadow-lg p-3 mb-5 bg-white rounded">
            <div class="row g-0">
                <div class="col-md-4 text-center">
                    <img src="https://res.cloudinary.com/kaw-ets/image/upload/v1718985359/library/<?php echo $book['code']; ?>.JPG" alt="Book Cover" class="img-fluid rounded-start" style="max-height: 300px; width: 300px; margin-top: 20px;">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h2 class="card-title" style="text-transform: uppercase;"><?php echo $book['title']; ?></h2>
                        <h4 class="card-subtitle text-muted" style="text-transform: uppercase;">Author: <?php echo $book['author']; ?></h4>
                        <p class="card-text mt-3"><span style="font-weight: bold;">Category:</span> <?php echo $book['CategoryID']; ?></p>
                        <?php if ($book['quantity'] > 0): ?>
                            <p class="card-text"><span style="font-weight: bold;">Availability:</span> Available</p>
                        <?php else: ?>
                            <p class="card-text"><span style="font-weight: bold;">Availability:</span> Unavailable</p>
                        <?php endif; ?>
                        <p class="card-text"><span style="font-weight: bold;">Description:</span> <?php echo $book['description']; ?></p>
                        <h5 class="card-text">Price: $<?php echo $book['price']; ?></h5>
                        <?php if ($book['quantity'] > 0): ?>
                            <button class="btn btn-primary mt-3">Buy <i class="fas fa-cart-plus ms-2"></i></button>
                        <?php else: ?>
                            <button class="btn btn-secondary mt-3">Add to Wishlist</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
