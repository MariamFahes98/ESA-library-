<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Arrivals Book</title>
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
               <li><a href="../index.html">Home</a></li>
               <li><a href="../aboutus.html">About Us</a></li>
               <li><a href="#">Category</a></li>
               <li><a href="#">Books</a></li>
               <li><a href="#">Rooms</a></li>
               <li><a href="../signupin/signin.html">Login</a></li>
               
           </ul>
           <div class="signup">
               <button onclick="location.href='../signupin/signup.html'" style="margin-left: 30px;">Sign Up</button>
           </div>
       </div>
   </div>
<div class="container">
  



    <div class="d-flex book-nav" id="header1" style="justify-content: space-between; padding-top: 10px;">
        
        <div>
            <a href="./newarivals.html" class="selected"><i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i> New Arrivals</a>
        </div>
        <div class="lists">
            <ul class="d-flex listss">
                <!-- Links for all screen sizes -->
                <li class="d-none d-md-block"><a href="./popular.php" class="gray-text">Popular Products</a></li>
                <li class="d-none d-md-block"><a href="./mostsold.php" class="gray-text">Most Sold</a></li>
                <li class="d-none d-md-block"><a href="./allavailablebook.php" class="gray-text">Featured Products</a></li>
                <!-- Category dropdown for all screen sizes -->
                <li class="dropdown">
                    <a href="#" class="category dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Categories 
                    </a>
                    <ul class="dropdown-menu category" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item item-dropdown" href="#" data-category="Action">Action</a></li>
                        <li><a class="dropdown-item item-dropdown" href="#" data-category="Fantasy">Fantasy</a></li>
                        <li><a class="dropdown-item item-dropdown" href="#" data-category="Crime">Crime</a></li>
                        <li><a class="dropdown-item item-dropdown" href="#" data-category="Fiction">Fiction</a></li>
                        <li><a class="dropdown-item item-dropdown" href="#" data-category="Horror">Horror</a></li>
                        <li><a class="dropdown-item item-dropdown" href="#" data-category="Adventure">Adventure</a></li>
                        <li><a class="dropdown-item item-dropdown" href="#" data-category="Novel">Novel</a></li>
                    </ul>
                </li>
                <!-- Links dropdown for small screens only -->
                <li class="dropdown d-block d-md-none">
                    <a href="#" class="gray-text dropdown-toggle" id="navbarDropdownLinks" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        More  
                    </a>
                    <ul class="dropdown-menu category" aria-labelledby="navbarDropdownLinks">
                        <li><a class="dropdown-item item-dropdown" href="./popular.html">Popular Products</a></li>
                        <li><a class="dropdown-item item-dropdown" href="./mostsold.html">Most Sold</a></li>
                        <li><a class="dropdown-item item-dropdown" href="./featured.html">Featured Products</a></li>
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
    fetch('newarrivals2.php')
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
    </script>
<!--<script src="./newarivals.js"></script>-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>                                                                                                                                           
