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
$_SESSION['BookID'] = $book['BookID'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style> 
 
#popup {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0,0,0);
    background-color: rgba(0,0,0,0.4);
}

.popup-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 600px;
    position: relative;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    border-radius: 10px;
}

.close-btn {
    color: rgb(70, 54, 16);
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close-btn:hover,
.close-btn:focus {
    color: rgb(70, 54, 16);
    text-decoration: none;
    cursor: pointer;
}

form {
    display: flex;
    flex-direction: column;
    color = rgb(70, 54, 16);
}

form label {
    margin: 10px 0 5px;
    font-weight: bold;
}

form input[type="text"],
form input[type="number"] {
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

form button {
    padding: 10px;
    background-color: #007BFF;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

form button:hover {
    background-color: #0056b3;
}
    </style>
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
                        <p class="card-text mt-3">
    <span style="font-weight: bold;">Category:</span>
    <?php 

   $dbhost = 'localhost';
   $dbname = 'library';
   $dbpass = '';
   $dbuser = 'root';
   $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
   if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
   }   
    $categoryID = $book['CategoryID'];
    $sql = 'SELECT cattitle FROM category WHERE CategoryID = ?';
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Statement preparation failed: " . $conn->error);
    }
    $stmt->bind_param('i', $categoryID);
    $stmt->execute();
    
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo htmlspecialchars($row['cattitle']);
    } else {
        echo "Category not found";
    }
    
    ?>
</p>
                        <?php if ($book['quantity'] > 0): ?>
                            <p class="card-text"><span style="font-weight: bold;">Availability:</span> Available</p>
                        <?php else: ?>
                            <p class="card-text"><span style="font-weight: bold;">Availability:</span> Unavailable</p>
                        <?php endif; ?>
                        <p class="card-text"><span style="font-weight: bold;">Description:</span> <?php echo $book['description']; ?></p>
                        <h5 class="card-text">Price: $<?php echo $book['price']; ?></h5>
                        <?php if ($book['quantity'] > 0): ?>
                            <?php if (isset($_SESSION['UserID'])): ?>
                           <button class="btn btn-primary mt-3" id="openPopup">Buy <i class="fas fa-cart-plus ms-2"></i></button>
                           <?php else: ?>
                          <button class="btn btn-primary mt-3" id="redirectToSignIn">Buy <i class="fas fa-cart-plus ms-2"></i></button>
                          <?php endif; ?>
                           
                        <?php else: ?>
                            <button class="btn btn-secondary mt-3">Add to Wishlist</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="popup" class="popup">
    <div class="popup-content">
        <span class="close-btn" id="closePopup">&times;</span>
        
        <form action="buyBook.php" method="GET">
        <h2 class="card-title" style=""><?php echo $book['title']; ?></h2>
        <div class="col-md-4 text-center">
                    <img src="https://res.cloudinary.com/kaw-ets/image/upload/v1718985359/library/<?php echo $book['code']; ?>.JPG" alt="Book Cover" class="img-fluid rounded-start" style="max-height: 1500px; width: 1500px; margin-top: 20px;">
                </div>
                <h5 class="card-text">Price: $<?php echo $book['price']; ?></h5>
            <button type="submit" name="submit">Confirm</button>
        </form>
    </div>
    <?php 
        $stmt->close();
        $conn->close();
    ?>
</div>

 
    <script>  
document.addEventListener('DOMContentLoaded', function() {
    var openPopupBtn = document.getElementById('openPopup');
    var closePopupBtn = document.getElementById('closePopup');
    var popup = document.getElementById('popup');

    if (openPopupBtn) {
        openPopupBtn.addEventListener('click', function() {
            popup.style.display = 'block';
        });
    }

    if (closePopupBtn) {
        closePopupBtn.addEventListener('click', function() {
            popup.style.display = 'none';
        });
    }

    window.addEventListener('click', function(event) {
        if (event.target === popup) {
            popup.style.display = 'none';
        }
    });

    var redirectToSignInBtn = document.getElementById('redirectToSignIn');
    if (redirectToSignInBtn) {
        redirectToSignInBtn.addEventListener('click', function() {
            window.location.href = '../signupin/signin.php';
        });
    }
});



        </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
