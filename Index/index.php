<?php
session_start();
$dbhost = 'localhost';
$dbname = 'library';
$dbuser = 'root';
$dbpass = '';

$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book's-whispers</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="main">
            <div class="head">
                <div class="navbar">
                     <div class="hamburger" onclick="toggleMenu()">
                       <div></div>
                       <div></div>
                       <div></div>
                    </div>
                    <div class="logo"><img src="images/logo.png" alt="logo"></div>
                    <div class="nav" >
                        <ul>
                            <li><a href="index.php">Home</a></li>
                            <li><a href="aboutus.html">About Us</a></li>
                            <li><a href="../books/allavailablebook.php">Books</a></li>
                            <li><a href="../rooms/index.php">Rooms</a></li>
                            <li><a href="../signupin/signin.php">Login</a></li>
                        </ul>
                        <div class="signup">
                            <button onclick="location.href='../signupin/signup.php'" style="margin-left: 30px;">Sign Up</button>
                        </div>
                    </div>
                </div>
            <div class="head-content">
                <div class="head-content-left">
                    <h1>Your Gateway to knowledge and advanture</h1>
                    <p>Welcome to the heart of our community, where knowledge and imagination come together. Our library offers a vast collection of books, digital resources, and programs designed to inspire and educate visitors of all ages. Step into a world of endless possibilities and discover something new with every visit. Join us on this journey of learning and exploration!</p>
                    <form id="search-form" onsubmit="return false;">
                    <div class="search-container">
                    <i id="search-icon" class="bi bi-search-heart" data-bs-toggle="tooltip" title="Search for your favorite books" onclick="searchBook()"></i>
                    <input type="text" id="search-book" placeholder="Search for a book" name="searchValue">
                        <i class="bi bi-x-circle" id="clear-search" onclick="clearSearch()"></i>
                        <div id="recent-searches" class="recent-searches"></div>
                    </div>
                    </form>
                    <div class="buttons-container">
                    <button class="btn1" onclick="window.location.href='../books/allavailablebook.php'">Explore Books</button>
                        <button class="btn2">Explore Rooms</button>
                    </div>                    
                </div>
                <div class="head-content-right">
                    <div class="img1">
                        <img src="images/main.jpg" class="rounded" alt="...">
                    </div>
                </div>
            </div>
        </div>
        
            <div class="sub">
                <div class="sub1">
                    <i class="bi bi-search-heart"></i>
                    <h5>Book Discovery</h5>
                    <p>Discover new books then read based on your interests , and explore the recomendations of other users</p>
                </div>

                <div class="sub2">
                    <i class="bi bi-people-fill"></i>
                    <h5>Room Discovery</h5>
                    <p>Discover the available rooms , features , and capacity of each one.</p>
                </div>

                <div class="sub3">
                    <i class="bi bi-star-fill"></i>
                    <h5>Book Reviews</h5>
                    <p>you can write reviews of books that you've read and share your thoughts with other users </p>
                </div>
            </div>
<?php

$sql = "SELECT * FROM reviews";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $carouselIndicators = '';
    $carouselItems = '';
    $activeClass = ' active';
    $index = 0;

    while ($review = $result->fetch_assoc()) {
        $bookID = $review['BookID'];

        // Prepare the second query to get the book title
        $stmt = $conn->prepare("SELECT title FROM book WHERE BookID = ?");
        $stmt->bind_param("i", $bookID);  // 'i' specifies the variable type is integer
        $stmt->execute();
        $bookResult = $stmt->get_result();

        if ($bookResult->num_rows > 0) {
            $book = $bookResult->fetch_assoc();
            $bookTitle = htmlspecialchars($book['title']);
        } else {
            $bookTitle = "Unknown Book";
        }

        $stmt->close();

        $name = htmlspecialchars($review['name']);
        $reviewText = htmlspecialchars($review['review_text']);
        $rating = htmlspecialchars($review['rating']);
        
        $carouselIndicators .= '<li data-bs-target="#reviewCarousel" data-bs-slide-to="' . $index . '" class="' . $activeClass . '"></li>';
        $carouselItems .= '
            <div class="carousel-item' . $activeClass . '">
                <div class="card" style = "width : 500px ; height : 300px ;background-color : rgb(244, 241, 234) ">
                    <p class="name" style = "font-size : 40px ; ">' . $name . '</p>
                    <p class="book-title" style = " color : rgb(70, 54, 16) ;font-size : 20px ; " > Book  :   '  . $bookTitle . '</p>
                    <p style = " color : rgb(70, 54, 16) ;font-size : 20px ; ">' . $reviewText . '</p>
                     <div class="stars" ><p style = " font-size : 30px ">' . str_repeat('★', $rating) . str_repeat('☆', 5 - $rating) . '</p></div>
                    <i class="bi bi-patch-check"> <span>Verified Buyer</span></i>
                </div>
            </div>';
        
        $activeClass = '';
        $index++;
    }

    echo '
    <div id="reviewCarousel" class="carousel slide" data-bs-ride="carousel">
        <ol class="carousel-indicators">
            ' . $carouselIndicators . '
        </ol>
        <div class="carousel-inner">
            ' . $carouselItems . '
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#reviewCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden"><i class="bi bi-arrow-bar-left"></i></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#reviewCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden"><i class="bi bi-arrow-bar-right"></i></span>
        </button>
    </div>';
} else {
    echo 'No reviews found.';
}

$conn->close();
?>



                                
        </div>
         
        <button class="btnscroll" id="btnscroll">^</button>
        <footer>
            <div class="foot">
                <div class="f1">
                    <h1>Book's Whispers</h1>
                    <div class="imgf">
                        <img src="images/logo2.png" alt="img">
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

        <script>
  function searchBook() {
    var bookName = document.getElementById('search-book').value;

    $.ajax({
      url: 'search.php',
      type: 'GET',
      data: { bookName: bookName },
      dataType: 'json',
      success: function(response) {
        if (response.id) {
          window.location.href = '../books/bookdetail.php?id=' + response.id;
        } else {
          alert('Book not found');
        }
      },
      error: function(xhr, status, error) {
        console.error("AJAX Error: " + status + error);
      }
    });
  }
</script>

        
        <script src="index.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
