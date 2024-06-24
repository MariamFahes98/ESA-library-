document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const bookId = urlParams.get('id');

    // Function to load books based on JSON file
    function loadBooks(jsonFile) {
        fetch(jsonFile)
            .then(response => response.json())
            .then(books => {
                const carouselInner = document.getElementById('carousel-books');
                const actionModal = new bootstrap.Modal(document.getElementById('actionModal'));

                carouselInner.innerHTML = ''; // Clear previous books

                books.forEach((book, index) => {
                    const carouselItem = document.createElement('div');
                    carouselItem.className = `carousel-item${book.id === bookId ? ' active' : ''}`;
                    carouselItem.innerHTML = `
                        <div class="book-details">
                            <div class="book-container">
                                <div class="book-cover">
                                    <img src="${book.image}" alt="Book Cover" class="book-cover-img" id="book-cover-${index}">
                                </div>
                            </div>
                            <div class="book-info">
                                <h2 id="book-title-${index}">${book.title}</h2>
                                <h4 id="book-author-${index}" class="text-muted">${book.author}</h4>
                                <p id="category-${index}"><span class="bold-text" style="font-weight: bold;">Category:</span> ${book.category}</p>
                                <p id="available-${index}" class="${book.available.toLowerCase() === 'available' ? 'available' : 'unavailable'}">${book.available}</p>
                                <p id="book-description-${index}">${book.description}</p>
                                <div class="rate">
                                    <i style="font-size: 12px; color: orange;" class="fa fa-star checked"></i>
                                    <span style="font-size: 12px;" id="book-rating-${index}">${book.rating}</span>
                                </div>
                                <h5 id="book-price-${index}">$${book.price}</h5>
                                <div class="wishlist-container" id="wishlist-container-${index}"></div>
                                ${book.available.toLowerCase() === 'available' ? `
                                    <button class="btn btn-primary buy" id="buy-${index}">Buy <i class="fas fa-cart-plus add-to-cart-icon"></i></button>
                                    <button class="btn btn-primary borrow" id="borrow-${index}">Borrow <i class="fas fa-cart-plus add-to-cart-icon"></i></button>
                                ` : `
                                    <button class="btn btn-secondary wishlist" id="wishlist-${index}">Add to Wishlist</button>
                                `}
                            </div>
                        </div>
                    `;
                    carouselInner.appendChild(carouselItem);

                    // Event listeners for buttons
                    if (book.available.toLowerCase() === 'available') {
                        document.getElementById(`buy-${index}`).addEventListener('click', () => {
                            document.getElementById('actionModalBody').innerText = `You have bought the book: ${book.title}`;
                            actionModal.show();
                        });
                        document.getElementById(`borrow-${index}`).addEventListener('click', () => {
                            document.getElementById('actionModalBody').innerText = `You have borrowed the book: ${book.title}`;
                            actionModal.show();
                        });
                    } else {
                        document.getElementById(`wishlist-${index}`).addEventListener('click', () => {
                            document.getElementById('actionModalBody').innerText = `The book: ${book.title} has been added to the wishlist.`;
                            actionModal.show();
                        });
                    }
                });

                // Activate the carousel
                const bookCarousel = new bootstrap.Carousel(document.getElementById('bookCarousel'), {
                    interval: false  // Set interval to false to stop auto-sliding
                });
            })
            .catch(error => console.error('Error fetching book details:', error));
    }

    // Example: Load books based on click event
    document.querySelectorAll('[data-json]').forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            const jsonFile = event.target.getAttribute('data-json');
            loadBooks(jsonFile);
        });
    });

    // Initial load of books based on default JSON file
    const defaultJson = 'newarival.json'; // Replace with your default JSON file
    loadBooks(defaultJson);
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