<?php

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
// Check if user is logged in
if (isset($_SESSION['user-email'])) {
    $userEmail = $_SESSION['user-email'];



    // Prepare and execute query
    $sql = "SELECT * FROM user WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $userEmail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $fullName = $row['name'];
        $email = $row['email'];
        $bio=$row['bio'];
        $mob=$row['Phonenumber'];
        $password=$row['password'];

        // Split full name into first name and last name
        $nameParts = explode(" ", $fullName);
        $firstName = $nameParts[0];
        $lastName = $nameParts[1];
        // Add more fields as needed

        // Close statement and connection
        $stmt->close();
        $conn->close();
    } else {
        echo "User not found in database.";
        // Handle error or redirect
        exit;
    }
} else {
    // Redirect user if not logged in
    header("Location: ../signupin/signin.php");
    exit;
}

?>
  

<div class="card review " id="reviewSection"  data-review>
<div class="blurred-background" style="display: flex;">
    <div id="reviewSection" class="container review-1 mt-5">
        <h2>Submit Your Review</h2>
        <form id="reviewForm" action="reviews2.php" method="post">
            <div class="mb-3">
                <input type="text" id="name" name="name" class="form-control" value="<?php echo $fullName; ?>" placeholder="Your Name" required pattern="[A-Za-z\s]+" title="Name should only contain letters and spaces">
            </div>
            <div class="mb-3">
                <input type="email" id="email" name="email" class="form-control"value="<?php echo $email; ?>" placeholder="Your Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Please enter a valid email address">
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
            <button type="submit" class="btn btn-primary submit-review-button"  >Submit Review</button>
           
                  
        </form>
    </div>
    <div>
                <img src="./reviewanimate.gif" class="animatedimg" style="width: 370px;">
            </div>
    </div>
</div>

