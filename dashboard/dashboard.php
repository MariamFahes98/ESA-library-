
<?php
session_start();
include 'includes/conn.php';
if (!isset($_SESSION["roles"]) || (isset($_SESSION["roles"]) && $_SESSION["roles"] != 1))
     header("Location: index.php");
     
print_r($_SESSION);
echo $_SESSION["roles"];
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
                            <div class="number">15</div>
                            <div class="card-name">Borrowed Books</div>

                        </div>
                        <div class="image-box"><img src="images/borrowed.png"></div>
                    </div>
                    <div class="moreinfo more2">More Info <i class="fas fa-chevron-right"></i></div>
                </div>
                <div class="cards">
                    <div class="card card4">
                        <div class="card-content">
                            <div class="number">Return</div>
                            <div class="card-name">Books</div>

                        </div>
                        <div class="image-box"><img src="images/return.png"></div>
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
                    <h3 class="today">Today Dues</h3>
                    <div class="mydiv2">
                        <div class="item1">Book Name</div>
                        <div class="item1">Borrower Name</div>
                        <div class="item1">Date Borrow</div>
                        <div class="item1">Contact</div>

                    </div>

                </div>
                <div class="gray" style=" height: 8px;">
                    <!-- No Dues For Today -->
                </div>
                <div class="mydiv2">
                <?php



// Pagination parameters
$recordsPerPage = 1; // Number of records to display per page
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1; // Current page number, default is 1
$startFrom = ($currentPage - 1) * $recordsPerPage; // Calculate starting point for SQL query

// SQL query to count total books
$countSql = "SELECT COUNT(*) AS totalBooks FROM borrowing
WHERE DATE(borrowing.DueDate) = CURDATE() AND borrowing.ReturnDate IS NULL
";
$countResult = mysqli_query($conn, $countSql);
$rowCount = mysqli_fetch_assoc($countResult)['totalBooks'];

// Calculate total number of pages
$totalPages = ceil($rowCount / $recordsPerPage);

// SQL query to fetch books with pagination
$sql = "SELECT user.UserID,user.name,user.email, borrowing.BookID AS boruserid,borrowing.BorrowDate AS borrwinddate,borrowing.DueDate AS duedate ,book.code,book.title
FROM user 
INNER JOIN borrowing ON user.UserID = borrowing.UserID
INNER JOIN book ON book.BookID  = borrowing.BookID
WHERE DATE(borrowing.DueDate) = CURDATE() AND borrowing.ReturnDate IS NULL
LIMIT $startFrom, $recordsPerPage ;";

// $sql = "SELECT username, name, title FROM test LIMIT $startFrom, $recordsPerPage";
$result = mysqli_query($conn, $sql);

if ($result) {
    // Display fetched books
    while ($row = mysqli_fetch_assoc($result)) {
        ?>
      
       

  
                    <div class="item1"><?php echo  $row["title"]; ?></div>
                    <div class="item1"><?php echo  $row["name"]; ?></div>
                    <div class="item1"><?php echo  $row["borrwinddate"]; ?></div>
                    <div class="item1"><?php echo  $row["email"]; ?></div>
                    <?php
       
 
   }
} else {
   echo "Error: " . mysqli_error($conn);
}

// Close connection
// mysqli_close($conn);
?>
                </div>
                <br>
                <div class="showing">
                    <!-- <div class="left">Showing 1 to 1 of entries</div> -->
                    <div class="left">
                        <div class="prev">
                        <div class="pagination">
                    <?php if ($currentPage > 1): ?>
                        <a href="?page=<?php echo ($currentPage - 1);?>" class="back">Previous</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?php echo $i; ?>" <?php if ($i == $currentPage) echo 'class="active"'; ?>><?php echo $i; ?></a>
                    <?php endfor; ?>

                    <?php if ($currentPage < $totalPages): ?>
                        <a href="?page=<?php echo ($currentPage + 1); ?>">Next</a>
                    <?php endif; ?>
                    </div>
                            
                 </div>

                    </div>
                </div>
                <div class="gray2">

                </div>


            </div>


            <div class="chart1">
                <div class="borrower">
                    <div class="borrowers"  style="font-weight: bold;">
                        <h3 class="today2">Tomorrow Dues</h3>
                        <div class="mydiv3" style=" grid-template-columns: repeat(4, 1fr);">
                            <div class="item1">Book Name</div>
                            <div class="item1">Borrower Name</div>
                            <div class="item1">Date Borrow</div>
                            <div class="item1">Due Date</div>


                        </div>

                    </div>
                    <div class="gray3" style=" height: 8px;">
                        <!-- No Dues For Today -->
                    </div>
                    <div class="mydiv3" style="  grid-template-columns: repeat(4, 1fr);">
                    <?php



// Pagination parameters
$recordsPerPage = 1; // Number of records to display per page
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1; // Current page number, default is 1
$startFrom = ($currentPage - 1) * $recordsPerPage; // Calculate starting point for SQL query

// SQL query to count total books
$countSql = "SELECT COUNT(*) AS totalBooks FROM borrowing
WHERE DATE(borrowing.DueDate) = DATE_ADD(CURDATE(), INTERVAL 1 DAY) AND borrowing.ReturnDate IS NULL
";
$countResult = mysqli_query($conn, $countSql);
$rowCount = mysqli_fetch_assoc($countResult)['totalBooks'];

// Calculate total number of pages
$totalPages = ceil($rowCount / $recordsPerPage);

// SQL query to fetch books with pagination
$sql = "SELECT user.UserID,user.name,user.email, borrowing.BookID AS boruserid,borrowing.BorrowDate AS borrwinddate,borrowing.DueDate AS duedate ,book.code,book.title
FROM user 
INNER JOIN borrowing ON user.UserID = borrowing.UserID
INNER JOIN book ON book.BookID  = borrowing.BookID
WHERE DATE(borrowing.DueDate) = DATE_ADD(CURDATE(), INTERVAL 1 DAY)
AND borrowing.ReturnDate IS NULL
LIMIT $startFrom, $recordsPerPage ;";

// $sql = "SELECT username, name, title FROM test LIMIT $startFrom, $recordsPerPage";
$result = mysqli_query($conn, $sql);

if ($result) {
    // Display fetched books
    while ($row = mysqli_fetch_assoc($result)) {
        ?>
      
       
                  <div class="item1"><?php echo  $row["title"]; ?></div>
                    <div class="item1"><?php echo  $row["name"]; ?></div>
                    <div class="item1"><?php echo  $row["borrwinddate"]; ?></div>
                    <div class="item1"><?php echo  $row["duedate"]; ?></div>
                        <?php
       
       //    echo "Code: " . $row["name"] . "<br>";
       //    echo "Title: " . $row["code"] . "<br><br>";
          // echo $rowCount;
      }
   } else {
      echo "Error: " . mysqli_error($conn);
   }
   
   // Close connection
   // mysqli_close($conn);
   ?>

                    </div>
                    <br>
                <div class="showing">
                    <!-- <div class="left">Showing 1 to 1 of entries</div> -->
                    <div class="left">
                        <div class="prev">
                        <div class="pagination">
                    <?php if ($currentPage > 1): ?>
                        <a href="?page=<?php echo ($currentPage - 1);?>" class="back">Previous</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?php echo $i; ?>" <?php if ($i == $currentPage) echo 'class="active"'; ?>><?php echo $i; ?></a>
                    <?php endfor; ?>

                    <?php if ($currentPage < $totalPages): ?>
                        <a href="?page=<?php echo ($currentPage + 1); ?>">Next</a>
                    <?php endif; ?>
                    </div>
                            
                 </div>

                    </div>
                </div>

                    <div class="gray2">

                    </div>


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
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="chart1.js"></script>
    <script>
$(document).ready(function() {
    $('.more1').click(function() {
        // Redirect to book.php
        window.location.href = 'book.php';
    });
});
$(document).ready(function() {
    $('.more3').click(function() {
        // Redirect to book.php
        window.location.href = 'return.php';
    });
});
$(document).ready(function() {
    $('.more4').click(function() {
        // Redirect to book.php
        window.location.href = 'user.php';
    });
});

</script>
</body>

</html>
