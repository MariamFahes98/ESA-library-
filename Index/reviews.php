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

// Fetch books from the database
$stmt = $conn->prepare('SELECT title, BookID FROM book');
$stmt->execute();
$result = $stmt->get_result();
$books = [];
while ($row = $result->fetch_assoc()) {
    $books[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="reviews.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<div class="blurred-background">
    <div id="reviewSection" class="container mt-5">
        <h2>Submit Your Review</h2>
        <form id="reviewForm" action="reviews2.php" method="post">
            <div class="mb-3">
                <input type="text" id="name" name="name" class="form-control" placeholder="Your Name" required pattern="[A-Za-z\s]+" title="Name should only contain letters and spaces">
            </div>
            <div class="mb-3">
                <input type="email" id="email" name="email" class="form-control" placeholder="Your Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Please enter a valid email address">
            </div>
            <div class="mb-3">
                <select name="book" id="book" class="form-control" required>
                    <option value="" disabled selected>Choose the book</option>
                    <?php foreach ($books as $book): ?>
                        <option value="<?php echo $book['BookID']; ?>"><?php echo htmlspecialchars($book['title']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <textarea id="reviewText" name="reviewText" class="form-control" placeholder="Your Review" required></textarea>
            </div>
            <div class="mb-3">
                <select id="rating" name="rating" class="form-control" required>
                    <option value="" disabled selected>Rating</option>
                    <option value="1">1 Star</option>
                    <option value="2">2 Stars</option>
                    <option value="3">3 Stars</option>
                    <option value="4">4 Stars</option>
                    <option value="5">5 Stars</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit Review</button>
        </form>
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

