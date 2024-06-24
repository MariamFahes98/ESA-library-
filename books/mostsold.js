let booksData = []; // Assume this is populated elsewhere in your application
let filteredBooks = [];
let booksPerPage = window.innerWidth > 768 ? 10 : 6; // Show 10 books on larger screens and 6 on smaller screens
let currentPage = 1;

// Fetch booksData from JSON (Assume it's fetched and populated)
fetch('mostsold.json')
    .then(response => response.json())
    .then(data => {
        booksData = data; // Store the fetched data
        filteredBooks = booksData; // Initially, filteredBooks is the same as booksData
        displayBooks(filteredBooks, '', booksPerPage * currentPage); // Display initial set of books
    })
    .catch(error => console.error('Error fetching book details:', error));

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
                <a class="book-container" href="bookdetail.html?id=${book.id}">
                    <div class="book">
                        <img src="${book.image}" class="card-img-top mb-0" alt="${book.title}">
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

document.querySelectorAll('.item-dropdown').forEach(item => {
    item.addEventListener('click', event => {
        const category = event.target.getAttribute('data-category');
        filteredBooks = booksData.filter(book => book.category === category);
        currentPage = 1;
        displayBooks(filteredBooks, category, booksPerPage * currentPage);

        // Change the dropdown button text to the selected category
        const dropdownButton = document.getElementById('navbarDropdown');
        dropdownButton.textContent = category;
    });
});

function loadMoreBooks() {
    currentPage++; // Increment the current page

    const category = document.getElementById('category-title').innerText.trim(); // Get current category
    const startIndex = (currentPage - 1) * booksPerPage; // Calculate start index based on current page
    const endIndex = startIndex + booksPerPage; // Calculate end index based on books per page

    // Check if filteredBooks is empty before attempting to display more books
    if (filteredBooks.length === 0) {
        console.log('No books to display.'); // Optionally log or handle this case
        return;
    }

    // Display books from startIndex to endIndex
    displayBooks(filteredBooks, category, endIndex);

    // Check if all books are displayed, then hide the 'See More' button
    if (endIndex >= filteredBooks.length) {
        document.getElementById('myButton').style.display = 'none';
    }
}

window.addEventListener('resize', () => {
    booksPerPage = window.innerWidth > 1024 ? 10 : (window.innerWidth > 768 ? 8 : 6);
    currentPage = 1;
    displayBooks(filteredBooks, document.getElementById('category-title').innerText, booksPerPage * currentPage);
});


function toggleMenu() {
    const nav = document.querySelector('.nav');
    nav.classList.toggle('active');
    
    if (nav.classList.contains('active')) {
        document.addEventListener('click', outsideClickListener);
    } else {
        document.removeEventListener('click', outsideClickListener);
    }
}