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

// Fetch categories from the database
$stmt = $conn->prepare('SELECT CategoryID, cattitle FROM category');
$stmt->execute();
$result = $stmt->get_result();
$categoryy = [];
while ($row = $result->fetch_assoc()) {
    $categoryy[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Featured Book</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="navbar">
        <div class="hamburger" onclick="toggleMenu()">
          <div></div>
          <div></div>
          <div></div>
       </div>
       <div class="logo"><img src="logo.png" alt="logo"></div>
       <div class="nav" >
           <ul>
               <li><a href="../Index/index.php">Home</a></li>
               <li><a href="../Index/aboutus.html">About Us</a></li>
               <li><a href="allavailablebook.php">Books</a></li>
               <li><a href="#">Rooms</a></li>
               <li><a href="../signupin/signin.php">Login</a></li>
               
           </ul>
           <div class="signup">
               <button onclick="location.href='../signupin/signup.php'" style="margin-left: 30px;">Sign Up</button>
           </div>
       </div>
   </div>
<div class="container">
    <div class="d-flex book-nav" id="header1" style="justify-content: space-between; padding-top: 10px;">
        <div>
            <a href="./allavailablebook.php" class="selected"><i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i> All available books </a>
        </div>
        <div class="lists">
            <ul class="d-flex listss">
                <!-- Links for all screen sizes -->
                <li class="d-none d-md-block"><a href="./popular.php" class="gray-text">Popular Products</a></li>
                <li class="d-none d-md-block"><a href="./mostsold.php" class="gray-text">Most Sold</a></li>
                <li class="d-none d-md-block"><a href="./newarivals.php" class="gray-text"> New Arivals</a></li>
                <!-- Category dropdown for all screen sizes -->
                <li class="dropdown">
                    <a href="#" class="category dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Categories 
                    </a>
                    <form id="form1" action="allavailablebook2.php" method="post">
    <ul class="dropdown-menu category" aria-labelledby="navbarDropdown">
        <?php foreach ($categoryy as $category): ?>
            <li>
                <button type="submit" name="category_id" value="<?php echo $category['CategoryID']; ?>" class="dropdown-item item-dropdown">
                    <?php echo htmlspecialchars($category['cattitle']); ?>
                </button>
            </li>
        <?php endforeach; ?>
    </ul>
</form>
                <!-- Links dropdown for small screens only -->
                <li class="dropdown d-block d-md-none">
                    <a href="#" class="gray-text dropdown-toggle" id="navbarDropdownLinks" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        More  
                    </a>
                    <ul class="dropdown-menu category" aria-labelledby="navbarDropdownLinks">
                        <li><a class="dropdown-item item-dropdown" href="./popular.php">Popular Products</a></li>
                        <li><a class="dropdown-item item-dropdown" href="./mostsold.php">Most Sold</a></li>
                        <li><a class="dropdown-item item-dropdown" href="./newarivals.php">New Arivals</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <h2 id="category-title"></h2>
    <div class="row" id="card-container"></div>
</div>
<div class="container2">
    <button id="myButton" class="btn d-block d-md-none" onclick="loadMoreBooks()">See More</button>
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
<script>
let booksData = []; // Array to hold fetched book data
let filteredBooks = []; // Array to hold filtered book data
let booksPerPage = window.innerWidth > 768 ? 10 : 6; // Determine books per page based on screen size
let currentPage = 1; // Current page number

// Fetch books data from PHP script
fetch('allavailablebooks2.php')
    .then(response => response.json())
    .then(data => {
        booksData = data; // Store the fetched data
        filteredBooks = booksData; // Initially, filteredBooks is the same as booksData
        displayBooks(filteredBooks, '', booksPerPage * currentPage); // Display initial set of books
    })
    .catch(error => console.error('Error fetching book details:', error));

// Function to display books
function displayBooks(books, category = '', limit = books.length) {
    const cardContainer = document.getElementById('card-container');
    const categoryTitle = document.getElementById('category-title');
    cardContainer.innerHTML = '';
    categoryTitle.innerText = category;

    if (books.length === 0) {
        cardContainer.innerHTML = `<div class="alert " role="alert">No books in this category!</div>'`;
        document.getElementById('myButton').style.display = 'none'; // Hide 'See More' button if no books
        return;
    }

    books.slice(0, limit).forEach((book, index) => {
        const card = `
            <div class="card book col-sm-6" style="width: 10rem; border: none;" data-index="${index}">
                <a class="book-container" href="bookdetail.php?id=${book.BookID}">
                    <div class="book">
                        <img src="https://res.cloudinary.com/kaw-ets/image/upload/v1718985359/library/${book.code}.JPG" alt="Image">
                    </div>
                </a>
            </div>`;
        cardContainer.innerHTML += card;
    });

    // Hide 'See More' button if all books are displayed
    if (limit >= books.length) {
        document.getElementById('myButton').style.display = 'none';
    } else {
        document.getElementById('myButton').style.display = 'block';
    }
}

// Event listener for category selection
document.querySelectorAll('.item-dropdown').forEach(item => {
    item.addEventListener('click', event => {
        const categoryId = event.target.getAttribute('data-category-id');
        filteredBooks = booksData.filter(book => book.category_id == categoryId); // Filter books by category
        currentPage = 1;
        displayBooks(filteredBooks, categoryId, booksPerPage * currentPage);

        // Change the dropdown button text to the selected category
        const dropdownButton = document.getElementById('navbarDropdown');
        dropdownButton.textContent = event.target.textContent;
    });
});

// Function to load more books
function loadMoreBooks() {
    currentPage++; // Increment the current page
    const category = document.getElementById('category-title').innerText.trim(); // Get current category
    const startIndex = (currentPage - 1) * booksPerPage; // Calculate start index based on current page
    const endIndex = startIndex + booksPerPage; // Calculate end index based on books per page

    // Display books from startIndex to endIndex
    displayBooks(filteredBooks, category, endIndex);

    // Hide the 'See More' button if all books are displayed
    if (endIndex >= filteredBooks.length) {
        document.getElementById('myButton').style.display = 'none';
    }
}

// Event listener for window resize
window.addEventListener('resize', () => {
    booksPerPage = window.innerWidth > 1024 ? 10 : (window.innerWidth > 768 ? 8 : 6);
    currentPage = 1;
    displayBooks(filteredBooks, document.getElementById('category-title').innerText, booksPerPage * currentPage);
});

// Function to toggle the menu
function toggleMenu() {
    const nav = document.querySelector('.nav');
    nav.classList.toggle('active');
    
    if (nav.classList.contains('active')) {
        document.addEventListener('click', outsideClickListener);
    } else {
        document.removeEventListener('click', outsideClickListener);
    }
}

// Function to close menu when clicking outside of it
function outsideClickListener(event) {
    const nav = document.querySelector('.nav');
    if (!nav.contains(event.target)) {
        nav.classList.remove('active');
        document.removeEventListener('click', outsideClickListener);
    }
}


//Display by category

    document.addEventListener('DOMContentLoaded', function () {
        // Add event listener to each category button
        document.querySelectorAll('.item-dropdown').forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault(); // Prevent default form submission

                const categoryId = this.value; // Get the category ID from button value
                const formData = new FormData();
                formData.append('category_id', categoryId); // Add category ID to form data

                fetch('allavailablebooks2.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    // Handle response data (assuming data is an array of books)
                    displayBooks(data); // Assuming you have a function to display books
                })
                .catch(error => {
                    console.error('Error fetching books:', error);
                    // Handle error
                });
            });
        });

        // Function to display books (example implementation)
        function displayBooks(books) {
            const cardContainer = document.getElementById('card-container');
            cardContainer.innerHTML = ''; // Clear previous content

            books.forEach(book => {
                const card = `
                    <div class="card">
                       <a class="book-container" href="bookdetail.php?id=${book.BookID}">
                    <div class="book">
                        <img src="https://res.cloudinary.com/kaw-ets/image/upload/v1718985359/library/${book.code}.JPG" alt="Image">
                    </div>
                </a>
                    </div>`;
                cardContainer.innerHTML += card;
            });
        }
    });
</script>


<!--<script src="./featured.js"></script>-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>  