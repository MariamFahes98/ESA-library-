document.addEventListener('DOMContentLoaded', (event) => {
  reading();
  document.getElementById('reading').classList.add('active');
});

document.addEventListener("DOMContentLoaded", function() {
  const navbarToggler = document.querySelector('.navbar-toggler');
  const sidebarCollapse = document.querySelector('.sidebar-collapse');

  navbarToggler.addEventListener('click', function() {
      sidebarCollapse.classList.toggle('show');
  });

  const menuItems = document.querySelectorAll('aside li, .sidebar-collapse li');
  const cards = document.querySelectorAll('.card');

  menuItems.forEach(item => {
      item.addEventListener('click', () => {
          const name = item.getAttribute('name');
          cards.forEach(card => {
              if (card.dataset[name] !== undefined) {
                  card.classList.add('active');
              } else {
                  card.classList.remove('active');
              }
          });
          if (window.innerWidth <= 768) {
              sidebarCollapse.classList.remove('show');
          }
      });
  });
});

const links = document.querySelectorAll(".navbar > nav > ul > li");
const cards = document.querySelectorAll(".card");

[...links].map((link, index) => {
  link.addEventListener("click", () => onLinkClick(link, index), false);
});

const onLinkClick = (link, currentIndex) => {
  const selectedItem = link.getAttribute("name");
  cards.forEach((card) => {
      card.classList.remove("active");
  });

  const currentCard = [...cards].find((card) =>
      Object.keys(card.dataset).includes(selectedItem)
  );
  currentCard.classList.add("active");
  highLightSelectedLink(currentIndex);
};

const highLightSelectedLink = (currentIndex) => {
  links.forEach((link) => {
      link.classList.remove("selectedLink");
  });
  links[currentIndex].classList.add("selectedLink");
};

const items = document.querySelectorAll('.books-title li');

items.forEach(function(item) {
  item.addEventListener('click', function() {
      items.forEach(function(item) {
          item.classList.remove('active');
      });
      this.classList.add('active');
  });
});

function updateUserName() {
  var fname = document.getElementById("fname").value;
  var lname = document.getElementById("lname").value;
  var userNameElement = document.querySelector(".username");

  userNameElement.textContent = fname + " " + lname;
}

function validateForm() {
  var fname = document.getElementById("fname").value;
  var lname = document.getElementById("lname").value;
  var email = document.getElementById("email").value;
  var password = document.getElementById("password").value;
  var confirmpassword = document.getElementById("confirmpassword").value;

  if (fname === "" || lname === "" || email === "" || password === "" || confirmpassword === "" ) {
      alert("Please fill all required fields");
      return false;
  }

  var emailRegex = /^\S+@\S+\.\S+$/;
  if (!emailRegex.test(email)) {
      alert("Please enter a valid email address");
      return false;
  }

  if (password !== confirmpassword) {
      alert("Passwords do not match");
      return false;
  }

  return true;
}

const profileImage = document.getElementById('profileImage');
const editButton = document.getElementById('editButton');
const imageInput = document.getElementById('imageInput');
const fnameInput = document.getElementById('fname');
const lnameInput = document.getElementById('lname');
const usernameDisplay = document.getElementById('usernameDisplay');
const bioDisplay = document.getElementById('bioDisplay');
const bio = document.getElementById('bio');

function triggerFileInput() {
  imageInput.click();
}

function handleFileInputChange(event) {
  const file = event.target.files[0];
  if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
          profileImage.src = e.target.result;
      };
      reader.readAsDataURL(file);
  }
}

function updateUsername() {
  const fname = fnameInput.value;
  const lname = lnameInput.value;
  usernameDisplay.textContent = `${fname} ${lname}`;
}

function updateBio() {
  const bioText = bio.value;
  bioDisplay.textContent = bioText;
}

imageInput.addEventListener('change', handleFileInputChange);
fnameInput.addEventListener('input', updateUsername);
lnameInput.addEventListener('input', updateUsername);
bio.addEventListener('input', updateBio);

function updateCompletedJson(bookId) {
  // Placeholder function to update the completed books JSON or backend storage
  // Replace with your actual implementation
  console.log(`Book with ID ${bookId} marked as completed.`);
}

function markAsDone(bookId) {
  updateReadingStatus(bookId, 'Completed');

  // Find the book card
  const bookCard = document.querySelector(`.eachbook[data-id='${bookId}']`);

  // Move the book card to the completed section
  if (bookCard) {
      const completedContainer = document.getElementById('done');
      completedContainer.appendChild(bookCard);

      // Optionally, update your JSON or backend storage
      updateCompletedJson(bookId);
  }
}

function updateReadingStatus(bookId, status) {
  fetch('update_reading_status.php', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/json'
      },
      body: JSON.stringify({
          bookId: bookId,
          status: status
      })
  })
  .then(response => response.json())
  .then(data => {
      if (data.success) {
          console.log('Book status updated successfully!');
      } else {
          console.error('Failed to update book status.');
      }
  })
  .catch(error => console.error('Error:', error));
}

function reading() {
  fetchBooks('reading');
}

function fetchBooks(status) {
  fetch(`fetch_books.php?status=${status}`)
      .then(response => response.json())
      .then(data => {
          const container = document.getElementById(status === 'reading' ? 'bookscontainer' : status === 'planToRead' ? 'plan' : 'done');
          container.innerHTML = ''; // Clear existing books
          data.books.forEach(book => {
              const bookElement = createBookElement(book);
              container.appendChild(bookElement);
          });
          container.classList.remove('d-none');
      })
      .catch(error => console.error('Error:', error));
}

function createBookElement(book) {
  const div = document.createElement('div');
  div.classList.add('eachbook');
  div.setAttribute('data-id', book.id);
  div.innerHTML = `
      <h3>${book.title}</h3>
      <p>${book.author}</p>
  `;
  return div;
}


