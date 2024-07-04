
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign-up</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="signup.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

  <div class="main">
    <div class="picdiv"><img src="./pic.jpg" class="pic"></div>
    <div class="txtContainer">

      <div class="text">
        <p class="title" id="hello">Sign Up</p>
        <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                    </div>
                    <script>
                        // Clear input fields if there is an error
                        document.addEventListener('DOMContentLoaded', (event) => {
                            document.getElementById('formI').reset();
                        });
                    </script>
                <?php endif; ?>

                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', (event) => {
                            document.getElementById('formI').reset();
                        });
                    </script>
                <?php endif; ?>

        <div class="undtitle">
          <form class="row g-5" id="formI" action="signup2.php" method="POST">
            <div class="col-md-6">
      
              <!-- <label for="fname" class="form-label">First Name</label> -->
              <input type="text" class="form-control buttons" id="fname" placeholder="First Name" name="firstName" ><div class="empty">Please fill the first name</div>
            </div>
            <div class="col-md-6">
              <!-- <label for="lname" class="form-label">Last Name</label> -->
              <input type="text" class="form-control buttons" id="lname" placeholder="Last Name" name="lastName"><div class="empty">Please fill the last name</div>
            </div>
            <div class="col-12">
              <!-- <label for="email" class="form-label">Email</label> -->
              <input type="email" class="form-control buttons" id="email" placeholder="Email" name="email"><div class="empty">Please fill the Email</div>
              <div class="email" id="divEmail"></div>
            </div>
            <div class="col-12">
              <!-- <label for="password" class="form-label">Password</label> -->
              <input type="password" class="form-control buttons" id="password" placeholder="Password" name="password"><div class="empty">Please fill the password</div>
            </div>
            
            <span id="error-message" class="error"></span><br><br>

            <div class="checkcontain">
              <div class="checkbox-wrapper-43">
                <input type="checkbox" id="cbx-43" class="checkbox" >
                <label for="cbx-43" class="check">
                  <svg width="18px" height="18px" viewBox="0 0 18 18">
                    <path
                      d="M1,9 L1,3.5 C1,2 2,1 3.5,1 L14.5,1 C16,1 17,2 17,3.5 L17,14.5 C17,16 16,17 14.5,17 L3.5,17 C2,17 1,16 1,14.5 L1,9 Z">
                    </path>
                    <polyline points="1 9 7 14 15 4"></polyline>
                  </svg>

                </label>
              </div>
              <div class="confirm">I agree to the <a class="terms">terms and conditions</a></div>
              
            </div>
            <div class="checkboxEmpty">Please fill the blanck checkbox</div>
            <button type="submit" name="submit" class="acc" id="submit">SIGN UP</button>
          </form>
        </div>
        <div class="signin">Already have an account? <a class="terms" href="./signin.php">Sign in</a></div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="./signup.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  </body>

</html>