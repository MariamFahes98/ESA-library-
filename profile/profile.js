
document.addEventListener('DOMContentLoaded', (event) => {
  // Show the "Reading" section by default
  reading();

  // Also highlight the "Reading" tab by default
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
  // const currentCard = [...cards].find((card) =>
  //   card.classList.contains(selectedItem)
  // );

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

// Get all the list items
var items = document.querySelectorAll('.books-title li');

// Add click event listener to each item
items.forEach(function(item) {
    item.addEventListener('click', function() {
        // Remove the 'active' class from all items
        items.forEach(function(item) {
            item.classList.remove('active');
        });
        // Add the 'active' class to the clicked item
        this.classList.add('active');
    });
});
function updateUserName() {
  var fname = document.getElementById("fname").value;
  var lname = document.getElementById("lname").value;
  var userNameElement = document.querySelector(".username");

  // Update the user name element with the combined first name and last name
  userNameElement.textContent = fname + " " + lname;
}
function validateForm() {
  var fname = document.getElementById("fname").value;
  var lname = document.getElementById("lname").value;
  var email = document.getElementById("email").value;
  var mob = document.getElementById("mob").value;
  var password = document.getElementById("password").value;
  var confirmpassword = document.getElementById("confirmpassword").value;
  var bio = document.getElementById("ans").value;

  // Validation for required fields
  if (fname === "" || lname === "" || email === "" || mob === "" || password === "" || confirmpassword === "" || bio === "") {
      alert("All fields are required");
      return false;
  }

  // Validation for email format
  var emailRegex = /^\S+@\S+\.\S+$/;
  if (!emailRegex.test(email)) {
      alert("Please enter a valid email address");
      return false;
  }

  // Validation for password match
  if (password !== confirmpassword) {
      alert("Passwords do not match");
      return false;
  }



  return true; // Form is valid
}

// Get references to the DOM elements
const profileImage = document.getElementById('profileImage');
const editButton = document.getElementById('editButton');
const imageInput = document.getElementById('imageInput');
const fnameInput = document.getElementById('fname');
const lnameInput = document.getElementById('lname');
const usernameDisplay = document.getElementById('usernameDisplay');
const   bioDisplay = document.getElementById('bioDisplay');
const bio = document.getElementById('bio')
// Function to trigger the file input click event
function triggerFileInput() {
    imageInput.click();
}

// Function to handle the file input change event
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
  const bioo = bio.value;
  bioDisplay.textContent = `${bioo}`;
}




// Add event listeners
profileImage.addEventListener('click', triggerFileInput);
editButton.addEventListener('click', triggerFileInput);
imageInput.addEventListener('change', handleFileInputChange);
fnameInput.addEventListener('input', updateUsername);
lnameInput.addEventListener('input', updateUsername);
bio.addEventListener('input',updateBio);



let read=document.getElementById('reading');
let plan=document.getElementById('planToRead');
let complete=document.getElementById('Completed');

function hideAllSections() {
  document.getElementById('bookscontainer').classList.add('d-none');
  document.getElementById('plan').classList.add('d-none');
  document.getElementById('done').classList.add('d-none');
}



function reading() {
  hideAllSections();
  fetch('books.json')
    .then(response => response.json())
    .then(data => {
      const cardContainer = document.getElementById('bookscontainer');
      cardContainer.innerHTML = '';
      document.getElementById('bookscontainer').classList.remove('d-none');
      data.forEach(book => {
        // Generate star icons HTML
        let starsHTML = '';
        book.stars.forEach(star => {
          starsHTML += `<i class="${star.class}"></i>`;
        });

        // Generate card HTML
        const card = `
          <div class="eachbook" data-id="${book.id}">
            <div class="content">
              <img class="bookimg" src="${book.image}" alt="img-book">
            </div>
            <div class="details">
              <div class="title-rating">
                <div><h5>${book.title}</h5></div>
                <div class="rating">${starsHTML}</div>
              </div>
              <p class="description">${book.about}</p>
              <button class="btn btn-success done-btn" onclick="markAsDone('${book.id}')">Done</button>
            </div>
          </div>
          <hr>`;
        
        // Append card HTML to container
        cardContainer.innerHTML += card;
      });
    });
}

function markAsDone(bookId) {
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

function updateCompletedJson(bookId) {
  // Fetch the book data from books.json
  fetch('books.json')
    .then(response => response.json())
    .then(booksData => {
      // Find the book to move
      const book = booksData.find(book => book.id === bookId);
      
      if (book) {
        // Remove the book from books.json
        const updatedBooks = booksData.filter(book => book.id !== bookId);
        
        // Add the book to completed.json
        fetch('completed.json')
          .then(response => response.json())
          .then(completedData => {
            completedData.push(book);

            // Save the updated data back to the JSON files
            saveJson('books.json', updatedBooks);
            saveJson('completed.json', completedData);
          });
      }
    });
}

function saveJson(fileName, data) {
  // This is a placeholder function. In a real application, 
  // you would need to send this data to your server to save it.
  // Here we're just logging it to the console for demonstration purposes.
  console.log(`Saving data to ${fileName}:`, JSON.stringify(data));
}



  function planToRead(){
    hideAllSections();
    fetch('plantoread.json')
    .then(response => response.json())
    .then(data => {
        const cardContainer = document.getElementById('plan');
        cardContainer.innerHTML = '';
        document.getElementById('plan').classList.remove('d-none');
        data.forEach(book => {
            // Generate star icons HTML
            let starsHTML = '';
            book.stars.forEach(star => {
                starsHTML += `<i class="${star.class}"></i>`;
            });

            // Generate card HTML
            const card = `
            <div class="eachbook">
                <div class="content">
                    <img class="bookimg" src="${book.image}" alt="img-book">
                </div>
                <div class="details">
                    <div class="title-rating">
                        <div><h5>${book.title}</h5></div>
                        <div class="rating">${starsHTML}</div>
                    </div>
                    <p class="description">${book.about}</p>
                </div>
                </div>
                <hr>`;
            
            // Append card HTML to container
            cardContainer.innerHTML += card;
        });
    });

  }
  function completed() {
    hideAllSections();
    fetch('completed.json')
      .then(response => response.json())
      .then(data => {
        const cardContainer = document.getElementById('done');
        cardContainer.innerHTML = '';
        document.getElementById('done').classList.remove('d-none');
  
        data.forEach(book => {
          // Generate star icons HTML
          let starsHTML = '';
          book.stars.forEach(star => {
            starsHTML += `<i class="${star.class}"></i>`;
          });
  
          // Generate card HTML
          const card = `
            <div class="eachbook">
              <div class="content">
                <img class="bookimg" src="${book.image}" alt="img-book">
              </div>
              <div class="details">
                <div class="title-rating">
                  <div><h5>${book.title}</h5></div>
                  <div class="rating">${starsHTML}</div>
                </div>
                <p class="description">${book.about}</p>
              </div>
            </div>
            <hr>`;
          
          // Append card HTML to container
          cardContainer.innerHTML += card;
        });
      });
  }
  
  read.addEventListener("click", reading);
  plan.addEventListener("click", planToRead);
  complete.addEventListener("click", completed);





// Add event listener to the "Edit profile" button
const editProfileButton = document.getElementById("editProfileButton");
const imgpp = document.getElementById("imgpp");
const userName = document.getElementById("userName");
const bioBook = document.getElementById("bioBook");





const editbuttontoProfile = () => {
  const profileLink = document.querySelector('li[name="profile"]');
  const profileLinkIndex = [...links].indexOf(profileLink);
  onLinkClick(profileLink, profileLinkIndex);
};
// Add event listener to the search input
document.getElementById('bookSearchInput').addEventListener('input', searchBooks);

function searchBooks() {
    const searchTerm = document.getElementById('bookSearchInput').value.toLowerCase();
    const cards = document.querySelectorAll('.eachbook');

    cards.forEach(card => {
        const title = card.querySelector('h5').textContent.toLowerCase();
        const description = card.querySelector('.description').textContent.toLowerCase();
        if (title.includes(searchTerm) || description.includes(searchTerm)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}

editProfileButton.addEventListener("click", editbuttontoProfile);
imgpp.addEventListener("click", editbuttontoProfile);
bioBook.addEventListener("click", editbuttontoProfile);
userName.addEventListener("click", editbuttontoProfile);
