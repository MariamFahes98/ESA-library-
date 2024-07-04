function toggleMenu() {
    const nav = document.querySelector('.nav');
    nav.classList.toggle('active');
    
    if (nav.classList.contains('active')) {
        document.addEventListener('click', outsideClickListener);
    } else {
        document.removeEventListener('click', outsideClickListener);
    }
}

function outsideClickListener(event) {
    const nav = document.querySelector('.nav');
    if (!nav.contains(event.target) && !document.querySelector('.hamburger').contains(event.target)) {
        nav.classList.remove('active');
        document.removeEventListener('click', outsideClickListener);
    }
}

let btn = document.getElementById( 'btnscroll' );
window.onscroll = function() {
    if (scrollY >= 400){
        btn.style.display ='block';
    }
    else {
        btn.style.display ='none';
    }
}
btn.onclick = function(){
    scroll ({
        left:0,
        top:0,
        behavior : "smooth"
    })
}

document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (event) {
        event.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});


document.getElementById('search-book').addEventListener('input', displayRecentSearches);
document.getElementById('search-book').addEventListener('focus', displayRecentSearches);
document.getElementById('search-book').addEventListener('blur', hideRecentSearches);

function clearSearch() {
    const searchInput = document.getElementById('search-book');
    searchInput.value = '';
    document.getElementById('recent-searches').style.display = 'none';
}

function saveSearch() {
    const searchInput = document.getElementById('search-book').value;
    if (searchInput) {
        let searches = JSON.parse(localStorage.getItem('recentSearches')) || [];
        if (!searches.includes(searchInput)) {
            searches.push(searchInput);
            localStorage.setItem('recentSearches', JSON.stringify(searches));
        }
        displayRecentSearches();
    }
}

function displayRecentSearches() {
    const searchInput = document.getElementById('search-book').value;
    const recentSearches = document.getElementById('recent-searches');
    let searches = JSON.parse(localStorage.getItem('recentSearches')) || [];

    if (searchInput) {
        searches = searches.filter(search => search.toLowerCase().includes(searchInput.toLowerCase()));
        if (searches.length > 0) {
            recentSearches.style.display = 'block';
            recentSearches.innerHTML = searches.map(search => `<div>${search}</div>`).join('');
        } else {
            recentSearches.style.display = 'none';
        }
    } else {
        if (searches.length > 0) {
            recentSearches.style.display = 'block';
            recentSearches.innerHTML = searches.map(search => `<div>${search}</div>`).join('');
        } else {
            recentSearches.style.display = 'none';
        }
    }
}

function hideRecentSearches() {
    // Give some time to handle clicks on recent searches before hiding
    setTimeout(() => {
        document.getElementById('recent-searches').style.display = 'none';
    }, 100);
}

// Event delegation for selecting recent searches
document.getElementById('recent-searches').addEventListener('click', function(event) {
    if (event.target.tagName === 'DIV') {
        document.getElementById('search-book').value = event.target.textContent;
        document.getElementById('recent-searches').style.display = 'none';
    }
});



