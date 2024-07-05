<?php
require_once 'connection.php';

// Handle remove action if book ID is provided
if (isset($_GET['remove_book_id'])) {
    $bookIdToRemove = $_GET['remove_book_id'];
    $deleteSql = "DELETE FROM wishlist WHERE BookID = ?";
    $stmt = $conn->prepare($deleteSql);
    $stmt->bind_param("i", $bookIdToRemove);
    if ($stmt->execute()) {
        // Deletion successful
        header("Location: wishlist.php");
        exit();
    } else {
        // Handle deletion error
        die("Error deleting book: " . $conn->error);
    }
}

$sql = "SELECT * FROM wishlist JOIN book ON wishlist.BookID = book.BookID";
$result = $conn->query($sql);

if ($result === false) {
    die("Error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>

.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 50px;
    margin-top: 10px;
    margin-bottom: 20px;
    height: 100px;
    background-color: rgb(244, 241, 234);
    box-shadow: 0 2px 4px rgba(70, 54, 16, 0.3);
    position: relative;
    z-index: 1000;
}

.navbar .logo img {
    width: 150px;
    height: auto;
}

.nav {
    display: flex;
    align-items: center;
}

.nav ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
    display: flex;
    align-items: center;
}

.nav ul li {
    margin-left: 30px;
}

.nav ul li a {
    text-decoration: none;
    color: rgb(70, 54, 16);
    font-size: 1.5rem;
    transition: transform 0.3s ease, color 0.3s ease;
    display: inline-block;
}

.nav ul li a:hover {
    transform: scale(1.05);
    cursor: pointer;
    color: rgb(100, 80, 40);
}

.nav .signup button {
    width: 120px;
    height: 40px;
    border-radius: 20px;
    color: rgb(244, 241, 234);
    background-color: rgb(70, 54, 16);
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease, color 0.3s ease, box-shadow 0.3s ease;
    margin-right: 20px;
}

.nav .signup button:hover {
    color: rgb(70, 54, 16);
    background-color: whitesmoke;
    box-shadow: 0 2px 4px rgba(70, 54, 16, 0.3);
}

.hamburger {
    display: none;
    flex-direction: column;
    cursor: pointer;
}

.hamburger div {
    width: 25px;
    height: 3px;
    background-color: rgb(70, 54, 16);
    margin: 5px 0;
    transition: all 0.3s ease;
}

.navbar.active .nav {
    display: block;
}
        .card {
            margin-bottom: 20px;
        }
        .card-img-top {
            max-height: 300px;
            object-fit: cover;
        }
        .card-title, .card-subtitle {
            text-transform: uppercase;
        }

        .card-body {
            height: 250px; /* Adjust the height of the card body */
            overflow: auto; /* Allow scrolling if content exceeds the height */
        }

        .card-text {
            max-height: 100px; /* Limit the height of the description */
            overflow: hidden; /* Hide overflow text */
        }
        .remove{
            background-color: rgb(70, 54, 16);
            color: rgb(244, 241, 234);
        }
        .remove:hover{
            background-color: rgb(244, 241, 234);
            color: rgb(70, 54, 16);
        }
        footer {
    height: 60vh;
}

.foot {
    height: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color:rgb(244, 241, 234 );
    padding: 80px 50px;
    color: rgb(70, 54, 16);
}

.imgf img {
    width: 150px;
    height: auto;
}

 .f1,.f2,.f3,.f4{
   height: 100%;
    
}

.foot ul li {
    font-size: 1.5em;
    list-style: none;
    padding-bottom: 10px;
}

.foot h4{
    font-size: 2em;
    padding-left: 30px;
    padding-bottom: 20px;
}
    </style>
</head>
<body style="background-image: url(./assets/oldpaper.jpg); background-position: center; background-size: cover;">
   
<div class="navbar">
                     <div class="hamburger" onclick="toggleMenu()">
                       <div></div>
                       <div></div>
                       <div></div>
                    </div>
                    <div class="logo"><img src="logo.png" alt="logo"></div>
                    <div class="nav" >
                        <ul>
                            <li><a href="index.php">Home</a></li>
                            <li><a href="aboutus.html">About Us</a></li>
                            <li><a href="../books/allavailablebook.php">Books</a></li>
                            <li><a href="#">Rooms</a></li>
                            <li><a href="../signupin/signin.php">Login</a></li>
                        </ul>
                        <div class="signup">
                            <button onclick="location.href='../signupin/signup.php'" style="margin-left: 30px;">Sign Up</button>
                        </div>
                    </div>
                </div>

<div class="container mt-5">
        <h1 class="mb-4">My Wishlist</h1>
        <div class="row">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Trim description to 100 characters and add ellipsis if longer
                    $trimmedDescription = strlen($row['description']) > 100 ? substr($row['description'], 0, 100) . '...' : $row['description'];
                    
                    echo "
                    <div class='col-md-3'>
                        <div class='card shadow-sm'>
                            <img src='https://res.cloudinary.com/kaw-ets/image/upload/v1718985359/library/{$row['code']}.JPG' class='card-img-top' alt='Book Cover'>
                            <div class='card-body'>
                                <h5 class='card-title'>{$row['title']}</h5>
                                <h6 class='card-subtitle mb-2 text-muted'>{$row['author']}</h6>
                                <p class='card-text'>{$trimmedDescription}</p>
                                <div class='d-flex justify-content-between align-items-center'>
                                    <span class=' fw-bold' style='color: rgb(70, 54, 16);'>\${$row['price']}</span>
                                    <a href='wishlist.php?remove_book_id={$row['BookID']}' class='btn remove btn-sm'><i class='fas fa-trash'></i> Remove</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    ";
                }
            } else {
                echo "<div class='col-12'><p class='text-center'>No books found in your wishlist.</p></div>";
            }
            ?>
        </div>
    </div>
    <footer>
            <div class="foot">
                <div class="f1">
                    <h1>Book's Whispers</h1>
                    <div class="imgf">
                        <img src="logo2.png" alt="img">
                    </div>
                    <p><i class="bi bi-at">Book's Whispering</i><br></p>
                    <p><i class="bi bi-geo-alt">Lebanon , Nabtieh</i> </p> 
                </div>
                <div class="f2">
                    <h4>Quick Links</h4>
                    <ul>
                        <li>Main</li>
                        <li>Books</li>
                        <li>Rooms</li>
                        <li>Sign-up</li>
                        <li>Log in</li>
                    </ul>
                </div>
                <div class="f3">
                    <h4>Follow Us</h4>
                    <ul>
                        <li><i class="bi bi-facebook me-2"></i>Facebook</li>
                        <li><i class="bi bi-instagram me-2"></i>Instagram</li>
                        <li><i class="bi bi-youtube me-2"></i>LinkedIn</li>
                        <li><i class="bi bi-linkedin me-2"></i>YouTube</li>
                    </ul>
                </div>
                <div class="f4">
                    <h4>contact Us</h4>
                    <ul>
                        <li>@bookswispers.com</li>
                        <li>70-11-22-33</li>
                    </ul>
                </div>
            </div>
        </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
