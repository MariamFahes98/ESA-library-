<?php
session_start();
include 'includes/conn.php';
// if (isset($_SESSION["roles"])|| (isset($_SESSION["roles"]) && $_SESSION["roles"] === 1))
    // header("Location: dashboard.php");
print_r($_SESSION);
$em= $_SESSION['email'];
// echo $_SESSION["roles"];
// $name = $_SESSION["name"]
?>

<div class="sidebar">

<div class="user2">
    <img class="user2admin" src="images/admin.png" />
    <div class="admin" >
        <?php 

$sql = "SELECT user.UserID,user.name, user.email AS useremail
FROM user
-- INNER JOIN role ON user.role = role.ID
    WHERE user.email='$_SESSION[email]';";

       
      
            $result = mysqli_query($conn, $sql);
 
            // Output data of each row
            while ($row = mysqli_fetch_assoc($result)) {
        ?> 
        <div class="admin2"><?php echo $row['name']; ?></div>
        <?php } ?>
        <div class="admin2circle">
            <div class="status-circle"></div>
            <div class="online">Online</div>
        </div>
    </div>
</div>
<ul>
    <li>
        <a href="../dashboard3/dashboard.php">
        <i class="fas fa-home home-icon" style=" padding-right: 15px; padding-left: 8px; font-size: 25px;"></i>    
        <!-- <img src="images/home.png" /> -->
            <div>Home</div>
        </a>
    </li>
    <li>
      
        <a href="../dashboard3/book.php">
        <!-- <i class="fa-solid fa-book" style=""></i> -->
        <!-- <i class="far fa-book book-icon"></i> -->
        <img src="images/book2.png" />
            <div>Books </div>
        </a>
    </li>
    <!-- <li>
        <a href="../dashboard3/borrowbook.php"><img src="images/borrow2.png" />
            <div>Borrow Book</div>
        </a>
    </li> -->
    <li>
        <a href="../dashboard3/return.php"><img src="images/ret1.png" style="height:55px;" />
            <div>Return</div>
        </a>
    </li>
    <li>
        <a href="../dashboard3/room.php"><img src="images/room1.png"  style="height:28px;  padding-right: 18px;  padding-left: 10px;" />
            <div style="padding-left: -6px;">Room</div>
        </a>
    </li>

    <li>
        <a href="../dashboard3/categories.php">
            
            
        <!-- <i class="fa fa-list-alt" style="font-size:22px"></i>     -->
        <img src="images/cat2.png" style="height:20px;  padding-right: 15px;  padding-left: 10px;" />
            <div style="padding-left: 4px;">Categories</div>
        </a>
    </li>
    <li>
        <a href="../dashboard3/user.php">
        <i class="fa fa-graduation-cap" style=" padding-right: 15px; padding-left: 8px; "></i>   
        <!-- <img src="images/student.png" /> -->
            <div style=" margin-left: -6px; ">Users</div>
        </a>
    </li>
    <li>
        <a href="../dashboard3/logout.php">
        <i class="fas fa-sign-out-alt" style=" padding-right: 15px; padding-left: 8px; "></i>
        <!-- <i class="fa fa-sign-out" aria-hidden="false"></i> -->
            <!-- <img src="images/borrow2.png" /> -->
            <div style=" margin-left: -6px; ">Logout</div>
        </a>
    </li>
  
</ul>
</div>