<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign-in</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.2/semantic.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="signin.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
  
  <div class="main">

    <div class="txtContainer">

      <div class="text">
        <p class="title">Sign In</p>
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
        <div class="undtitle">
          <form class="row g-5" id="formI" action="signin2.php" method="POST" >

            <div class="col-12 flex">
              <!-- <label for="email" class="form-label">Email</label> -->
              <input type="email" name="email"  class="form-control buttons" id="email" placeholder="Email">
              <svg
                xmlns="http://www.w3.org/2000/svg" width="25" height="23" fill="currentColor"
                class="bi bi-person-fill icons" viewBox="0 0 16 16" >
                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
              </svg>
            </div>
            <div class="empty">Please fill the Email</div>
            <div class="email" id="divEmail"></div>

            <div class="col-12 flex">
              <!-- <label for="password" class="form-label">Password</label> -->
              <input type="password" name="password" class="form-control buttons" id="password" placeholder="Password"><svg
                xmlns="http://www.w3.org/2000/svg" width="25" height="23" fill="currentColor"
                class="bi bi-lock-fill icons" viewBox="0 0 16 16" id="iconP">
                <path
                  d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2" />
              </svg>
            </div>
            <div class="empty">Please fill the Password</div>
            

            <div class="checkcontain">
              <div class="checkbox-wrapper-43">
                <input type="checkbox" id="cbx-43">
                <label for="cbx-43" class="check">
                  <svg width="18px" height="18px" viewBox="0 0 18 18">
                    <path
                      d="M1,9 L1,3.5 C1,2 2,1 3.5,1 L14.5,1 C16,1 17,2 17,3.5 L17,14.5 C17,16 16,17 14.5,17 L3.5,17 C2,17 1,16 1,14.5 L1,9 Z">
                    </path>
                    <polyline points="1 9 7 14 15 4"></polyline>
                  </svg>

                </label>
              </div>
              <div class="remember">Remember Me</div>
            </div>
            <button class="acc" id="submit" type="submit" name="submit" >SIGN IN</button>
          </form>
        </div>
        <div class="forgotps"><a class="fps" href="./forgetpassword.php">Forgot Password?</a></div>
        <div class="signup">Don't have an account? <a class="asignup" href="./signup.php">Sign Up</a></div>
      </div>
    </div>
    <div class="picdiv"><img src="./imgin.jpg" class="pic"></div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="./signin.js"></script>
</body>
</html>