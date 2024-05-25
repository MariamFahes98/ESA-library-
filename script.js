   // JavaScript to toggle display of search input
   document.getElementById('searchLink').addEventListener('click', function() {
    var searchInput = document.querySelector('.search-input');
    searchInput.style.display = (searchInput.style.display === 'none' || searchInput.style.display === '') ? 'block' : 'none';
  });