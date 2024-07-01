document.getElementById('reviewForm').addEventListener('submit', async function(event) {
    event.preventDefault();
    const formData = new FormData(event.target);
    const data = Object.fromEntries(formData.entries());

    const response = await fetch('/api/reviews', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    });

    if (response.ok) {
        alert('Thanks for your Review!');
        event.target.reset();
    } else {
        alert('Failed to submit review.');
    }
});

async function loadReviews() {
    const response = await fetch('/api/reviews');
    const reviews = await response.json();

    const reviewContainer = document.getElementById('reviewContainer');
    reviewContainer.innerHTML = '';

    reviews.forEach(review => {
        const reviewElement = document.createElement('div');
        reviewElement.classList.add('review');
        reviewElement.innerHTML = `
            <div class="card">
                <p class="name">${review.name}</p>
                <p>${review.book_title}</p>
                <p>${review.review_text}</p>
                
                <div class="stars">${'★'.repeat(review.rating)}</div>
                <p>${new Date(review.timestamp).toLocaleDateString()}</p>
            </div>
        `;
        reviewContainer.appendChild(reviewElement);
    });
}

document.addEventListener('DOMContentLoaded', loadReviews);
