
<?php

require_once 'connection.php';

// Check if user is logged in
if (isset($_SESSION['user-email'])) {
    $userEmail = $_SESSION['user-email'];



    // Prepare and execute query
    $sql = "SELECT * FROM user WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $userEmail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $fullName = $row['name'];
        $email = $row['email'];
        $bio=$row['bio'];
        $mob=$row['Phonenumber'];
        $password=$row['password'];

        // Split full name into first name and last name
        $nameParts = explode(" ", $fullName);
        $firstName = $nameParts[0];
        $lastName = $nameParts[1];
        // Add more fields as needed

        // Close statement and connection
        $stmt->close();
       
    } else {
        echo "User not found in database.";
        // Handle error or redirect
        exit;
    }
} else {
    // Redirect user if not logged in
    header("Location: ../signupin/signin.php");
    exit;
}
?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>

    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="profile.css" />
    
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body>

    <div class="container">

        <div class="c2">
          <button class="navbar-toggler" type="button" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
      <aside>
        <div class="sidebar-collapse">
        <div class="navbar">
          <div class="user-logo"><img src="logoprofile.png"/></div>
          <nav>
            <ul class="nav-link">
                      <!-- Search Input -->
         <div class="search-input">
            <input type="text" class="form-control" placeholder="&#xf002;Search For book " >
           
          
           
          </div>
              <li  href="../index/index.php" ><a href="../index/index.php" style="font-style: none;"><i style="font-size:24px" class="fa mx-2">&#xf015;</i></a><a href="../index/index.php" style="font-style: none;">Home</a></li>
              <li  class="selectedLink" name="profile"><i style='font-size:24px' class='fas mx-2'>&#xf2b9;</i>
                Profile</li>
              <li name="books" ><a href="../books/allavailablebook.php"><i style="font-size:24px " class="fa mx-2">&#xf02d;</i>Books</a></li>
              <li  name="review"><i style='font-size:24px ;margin-right: 10px;' class='fas'>&#xf075;</i>Reviews</li>
              <li  name="wishlist"><a href="wishlist.php"><i style="font-size:24px ;margin-right: 10px;" class="fa">&#xf08a;</i>wish list</li>
              <li  name="bought"><a href="bought.php"><i style="font-size:24px ;margin-right: 10px;" class="fa">&#xf07a;</i>Bought</li>
              <li  name="logout" ><a href="logout.php" style="font-style: none;"><i style="font-size:24px" class="fa mx-2">&#xf08b;</i></a><a href="logout.php" style="font-style: none;">logout</a></li>
            </ul>
          </nav>
        </div>
      </div>
      </aside>
      <main>
        
          <!--profile page start-->

          <div class="card profile  active" data-profile>
        <div class="profile-full">
            <div class="card-form-form">
                <form class="form-card" action="update_profile.php" method="POST" onsubmit="return validateForm()" enctype="multipart/form-data">
                    <div class="profile-container">
                    <?php
    // Display profile image, either user uploaded or default
    if (!empty($row['image'])) {
        echo '<img src="' . $row['image'] . '" alt="profileimg" class="profileimg-edit" id="profileImage" name="image">';
    } else {
        echo '<img src="uploads/default-profile-photo.jpg" alt="default-profile" class="profileimg-edit" id="profileImage" name="image">';
    }
    ?>

                        <input type="file" id="imageInput" name="image" style="display: none;">
                        <div class="mx-2">
                            <h3 class="username" id="usernameDisplay"><?php echo $fullName; ?></h3>
                            <p class="bio mx-2" id="bioDisplay"><?php echo $bio; ?></p>
                        </div>
                        <!-- Edit icon -->
                        <button id="editButton" class="fas fa-edit editButton"></button>
                    </div>
                    <!-- Display Bootstrap alerts for errors -->
                    <div class="row justify-content-between text-left">
                        <div class="form-group col-sm-6 flex-column d-flex">
                            <label for="fname" class="form-control-label text-start">First name<span class="text-danger"> *</span></label>
                            <input type="text" id="fname" name="fname" class="px-1" placeholder="Enter your first name" value="<?php echo $firstName; ?>">
                        </div>
                        <div class="form-group col-sm-6 flex-column d-flex">
                            <label for="lname" class="form-control-label text-start">Last name<span class="text-danger"> *</span></label>
                            <input type="text" id="lname" name="lname" class="px-1" placeholder="Enter your last name" value="<?php echo $lastName; ?>">
                        </div>
                    </div>
                    <div class="row justify-content-between text-left">
                        <div class="form-group col-sm-6 flex-column d-flex">
                            <label for="email" class="form-control-label text-start">Email<span class="text-danger"> *</span></label>
                            <input type="email" id="email" name="email" class="px-1" placeholder="Email" value="<?php echo $email; ?>">
                        </div>
                        <div class="form-group col-sm-6 flex-column d-flex">
                            <label class="form-control-label text-start">Phone number</label>
                            <input type="tel" id="mob" name="mob" class="px-1" placeholder="Phone Number" value="<?php echo $mob; ?>">
                        </div>
                    </div>
                    <div class="row justify-content-between text-left">
                        <div class="form-group col-sm-6 flex-column d-flex">
                            <label for="password" class="form-control-label text-start">Password<span class="text-danger"> *</span></label>
                            <input type="password" id="password" name="password" class="px-1" placeholder="Password" value="<?php echo $password; ?>">
                        </div>
                        <div class="form-group col-sm-6 flex-column d-flex">
                            <label for="confirmpassword" class="form-control-label text-start">Confirm Password<span class="text-danger"> *</span></label>
                            <input type="password" id="confirmpassword" name="confirmpassword" class="px-1" placeholder="Confirm Password" onblur="validate(5)" value="<?php echo $password; ?>">
                        </div>
                    </div>
                    <div class="row justify-content-between text-left">
                        <div class="form-group col-12 flex-column d-flex">
                            <label class="form-control-label text-start">Add your Bio here.</label>
                            <input type="text" id="bio" name="bio" placeholder="Add your bio" value="<?php echo $bio; ?>">
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="form-group col-sm-6">
                            <button type="submit" class="btn-block save-btn">Save edit</button>
                        </div>
                    </div>
                </form>
            </div>
            <div>
                <img src="./animatedimg.gif" class="animatedimg">
            </div>
        </div>
    </div>
        <!--profile page end-->

        <!--review page start-->


        <?php include 'review.php'; ?>
         <!--review page end-->
         
            
        
        

  

        <!-- books start-->
        <div class="card books" data-books>
            <div class="top-container">
                <div class="img-bio-container">
                <?php
    // Display profile image, either user uploaded or default
    if (!empty($row['image'])) {
        echo '<img src="' . $row['image'] . '" alt="profileimg" class="profileimg-edit" id="profileImage" name="image">';
    } else {
        echo '<img src="uploads/default-profile-photo.jpg" alt="default-profile" class="profileimg-edit" id="profileImage" name="image">';
    }
    ?>
                    <div >
                    <h2 class="username" id="userName" style="margin-left: 5px;"><?php echo $firstName ." ". $lastName; ?></h2>
                    <p class="bio" id="bioBook"><?php echo $bio ?></p>
                   </div>
                </div>
                <div>
                    <button type="submit" class="btn btn-light edit-profile" id="editProfileButton">Edit profile</button>
                </div>
            </div>
            <div class="under-div">
                <div class="d-flex justify-content-between align-items-center">
                    <ul class="books-title">
                        <li id="reading">Reading</li>
                        <li id="planToRead">Plan to read</li>
                        <li id="Completed">Completed</li>
                   
                    </ul>
                    <li class="align-items-center">                <!-- Search Input -->
                          
                      <input type="text" class="form-control searchInput" id="bookSearchInput" placeholder="&#xf002;Search For book " >
                     
                    
                     
                 </li>
                    

                </div>
                <hr>
                <div id="bookscontainer"   class="d-none">
                </div>
                <div id="plan" class="d-none">
                </div>
                <div id="done" class="d-none">
                </div>
                
            </div>
            
            
            
            
        <!-- books end-->
       </div>
      </main>
      </div>
    </div>



    
    <script>
$(document).ready(function() {
    $('form').on('submit', function(e) {
        e.preventDefault();
        
        // Serialize form data
        const formData = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: 'update_profile.php',
            data: formData,
            success: function(response) {
                // Parse JSON response (if applicable)
                try {
                    const jsonResponse = JSON.parse(response);
                    if (jsonResponse.success) {
                        alert('Profile updated successfully!');
                        location.reload(); // Reload to reflect changes
                    } else {
                        alert('Error: ' + jsonResponse.error);
                    }
                } catch (e) {
                    alert('Profile updated successfully!');
                    location.reload(); // Reload to reflect changes
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error: ', status, error);
                alert('Error updating profile.');
            }
        });
    });
});


function validateForm() {
            const firstName = document.getElementById('fname').value.trim();
            const lastName = document.getElementById('lname').value.trim();
            const email = document.getElementById('email').value.trim();
            const phoneNumber = document.getElementById('mob').value.trim();
            const password = document.getElementById('password').value.trim();
            const confirmPassword = document.getElementById('confirmpassword').value.trim();
            const bio = document.getElementById('bio').value.trim();

            if (!firstName || !lastName || !email || !phoneNumber || !password || !confirmPassword || !bio) {
                alert("All fields are required.");
                return false;
            }

            const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            if (!emailPattern.test(email)) {
                alert("Invalid email format.");
                return false;
            }

            const phonePattern = /^[0-9]+$/;
            if (!phonePattern.test(phoneNumber)) {
                alert("Invalid phone number.");
                return false;
            }

            if (password !== confirmPassword) {
                alert("Passwords do not match.");
                return false;
            }

            if (password.length < 8) {
                alert("Password must be at least 8 characters long.");
                return false;
            }

            return true;}
</script>
    <script src="profile.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

  </body>
</html>
