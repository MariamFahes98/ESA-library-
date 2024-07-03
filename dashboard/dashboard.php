
<?php
// ob_start();
session_start();
include 'includes/conn.php';
if (!isset($_SESSION["roles"]) || (isset($_SESSION["roles"]) && $_SESSION["roles"] != 2))
      header("Location: ../index/index.php");
    //  echo $_SESSION["roles"];


// print_r($_SESSION);

// $name = $_SESSION["name"]
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="dashboard.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
     integrity="sha512-Nfyzfl1P1OEiuJkFfO61kzSE2XYu1xqtdn3GMJvO8/1yP5bXPOXjifRZ9ZGj9jLBY5STeXuP2gCprn6f7n3uVw==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
 
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
        integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />
        <!-- <style>
        .book-icon {
            font-size: 24px; /* Adjust size as needed */
            color: black; /* Adjust color as needed */
        }
    </style> -->
    <title>Dashboard</title>
</head>

<body>
    <div class="container">
    <?php include 'includes/navbar.php'; ?>

        <?php include 'includes/sidebar.php'; ?>
        
        <div class="main2">
            <div class="myDIV">
                
                <div class="cards">
                    <div class="card card2">
                        <div class="card-content">
                        <?php







$sql = "SELECT book.BookID from book";

if ($result = mysqli_query($conn, $sql)) {

    if (mysqli_num_rows($result) > 0) {


        $rowcount = mysqli_num_rows( $result );

    ?>


                            <div class="number"><?php echo $rowcount; ?></div>
                            <?php
                                    
                                }
                               }
                               
                  
                            ?>
                            <div class="card-name">Books</div>

                        </div>
                        <div class="image-box"><img src="images/library2.webp"></div>
                    </div>
                    <div class="moreinfo more1">More Info <i class="fas fa-chevron-right"></i></div>
                </div>
                <div class="cards">
                    <div class="card card3">
                        <div class="card-content">
                        <?php







$sql = "SELECT room.RoomID from room";

if ($result = mysqli_query($conn, $sql)) {

    if (mysqli_num_rows($result) > 0) {


        $rowcountr = mysqli_num_rows( $result );

    ?>


                            <div class="number"><?php echo $rowcountr; ?></div>
                            <?php
                                    
                                }
                               }
                               
                  
                            ?>
                            <!-- <div class="number">15</div> -->
                            <div class="card-name">Room</div>

                        </div>
                        <div class="image-box"><img src="images/room43.png"></div>
                    </div>
                    <div class="moreinfo more2">More Info <i class="fas fa-chevron-right"></i></div>
                </div>
                <div class="cards">
                    <div class="card card4">
                        <div class="card-content">
                            <div class="number">Buying</div>
                            <div class="card-name">Books</div>

                        </div>
                        <div class="image-box"><img src="images/return55.png"></div>
                    </div>
                    <div class="moreinfo more3">More Info <i class="fas fa-chevron-right"></i></div>
                </div>
                <div class="cards">
                    <div class="card card5">
                        <div class="card-content">
                            <div class="number">Users</div>
                            <!-- <div class="card-name">Books</div> -->

                        </div>
                        <div class="image-box img2"><img src="images/issue.png"></div>
                    </div>
                    <div class="moreinfo more4">More Info <i class="fas fa-chevron-right"></i></div>
                </div>
            </div>
            <div class="borrower">
                <div class="borrowers" style="font-weight: bold;">
                    <h3 class="today">Today Buying</h3>
                    <div class="mydiv2" style="margin-bottom:15px;  padding: 20px 20px;  grid-template-columns: repeat(6, 1fr);">
                        <div class="item1">Buing Id</div>
                        <div class="item1">Buing Name</div>
                       
                        <div class="item1">Code</div>
                        <div class="item1">Title</div>
                        <div class="item1">Price</div>
                        <div class="item1">Date Buying</div>

                    </div>

                </div>
                <div class="gray" style=" height: 8px;">
                    <!-- No Dues For Today -->
                </div>
                <div class="mydiv2" style="height: 200px;
    width: 100%;
   
    display: grid;
   
    /* grid-template-columns: repeat(5, 1fr); */
     grid-template-columns: repeat(6, 1fr);
    grid-template-rows: 30px; 
  
    gap: 5px;
  
    padding: 20px 20px;
    /* grid-column-gap: 10px; */
    ">
                <?php



$sql = "SELECT user.UserID,user.name,buying.BuyingID, buying.BookID AS buyuserid,buying.price AS buyprice,buying.PurchaseDate AS buyingpurchase,book.code,book.title
        FROM user
INNER JOIN buying ON user.UserID = buying.UserID
INNER JOIN book ON book.BookID  = buying.BookID
WHERE DATE(buying.PurchaseDate) = CURDATE() ;";
// -- LIMIT $startFrom, $recordsPerPage 
// -- WHERE borrowing.ReturnDate IS NULL





$result = mysqli_query($conn, $sql);

if ($result) {
    // Display fetched books
    while ($row = mysqli_fetch_assoc($result)) {
        ?>
      
       
                      <div class="item1" style=" padding-left: 10px;"><?php echo  $row["BuyingID"]; ?></div>
                     <div class="item1" style="padding-left: 10px;"><?php echo  $row["name"]; ?></div>
                   
                   
                    <div class="item1" style="padding-left: 10px;"><?php echo  $row["code"]; ?></div>
                    <div class="item1" style="padding-left: 10px;"><?php echo  $row["title"]; ?></div>
                    <div class="item1" style="padding-left: 20px;"><?php echo  $row["buyprice"] ."$"; ?></div>
                    
                    <div class="item1" style="padding-left: 25px;"><?php echo  $row["buyingpurchase"]; ?></div>

                    <?php
       
 
   }
} else {
   echo "Error: " . mysqli_error($conn);
}


?>
                </div>
                <br>
                <!-- <div class="showing">
                 
                    <div class="left">
                        <div class="prev">
                        <div class="pagination">
                    
                    </div>
                            
                 </div>

                    </div>
                </div> -->
                <div class="gray2">

                </div>


            </div>




            <!-- <div class="chmydiv">
                <div class="ch3">
                    <div class="chart2">
                      
                       
                       
                        <div class="donut instalment1">
                <div class="donut-default"></div>
                <div class="donut-line"></div>
                <div class="donut-text">   <span>check</span>   </div>
                <div class="donut-case"></div>
                    </div>
                       

                    </div>

                </div>


            </div> -->


            <!-- chart -->
            <div class="charts">
                <div class="chart">
             
                    <canvas id="linechart"></canvas>
                </div>
                <div class="chartt" id="dought-chart">

                    <div class="donut instalment1">
                        <div class="donut-default"></div>
                        <div class="donut-line"></div>
                        <div class="donut-text">
                            <span style="margin-left: 5px;"> Books Issued till Date &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                &nbsp; &nbsp; &nbsp; &nbsp; <span class="sp">26</span> </span>


                        </div>
                        <div class="donut-case"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="chart.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
$(document).ready(function() {
    $('.more1').click(function() {
        // Redirect to book.php
        window.location.href = '../dashboard/book.php';
    });
});
$(document).ready(function() {
    $('.more3').click(function() {
        // Redirect to book.php
        window.location.href = '../dashboard/return.php';
    });
});
$(document).ready(function() {
    $('.more4').click(function() {
        // Redirect to book.php
        window.location.href = '../dashboard/user.php';
    });
});
$(document).ready(function() {
    $('.more2').click(function() {
        // Redirect to book.php
        window.location.href = '../dashboard/room.php';
    });
});


</script>
</body>

</html>
