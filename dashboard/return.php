
<?php
session_start();
include 'includes/conn.php';

if (!isset($_SESSION["roles"])|| (isset($_SESSION["roles"]) && $_SESSION["roles"] != 1))
header("Location: index.php");
?>


<!-- // SQL query
// SELECT Products.ProductID, Products.ProductName, Categories.CategoryName
// FROM Products
// JOIN Categories ON Products.CategoryID = Categories.CategoryID; -->

<?php
// $sql = "SELECT *, user.UserID AS userid, book.BookID AS bookid 
//         FROM borrowing
//         LEFT JOIN user ON user.UserID = borrowing.UserID
//         LEFT JOIN book ON book.BookID  = borrowing.BookID
//         ORDER BY ReturnDate";

      
// //  WHERE b.returndate IS NOT NULL
// $result = mysqli_query($conn, $sql);

// // if (mysqli_num_rows($result) > 0) {
//     // Output data of each row
//     while ($row = mysqli_fetch_assoc($result)) {
//        $pr="User ID: " . $row["UserID"]. " - Name: " . $row["name"]."code:" .$row["code"]."<br>";

//     }
// } else {
//     echo "0 results";
// }

// mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
        integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />
    <title>Return Books</title>
</head>

<body>
    <form name="myForm" action="#" onsubmit="validateForm()">
    <div class="container">
    <?php include 'includes/navbar.php'; ?>
   
        <?php include 'includes/sidebar.php'; ?>
      
        <div class="mainr" style="    position: absolute;
                    top: 60px;
                    width: calc(100% - 260px);
                    left: 260px;
                    min-height: calc(100vh - 60px);
                    background:white;
                    display: grid;
                    grid-template-rows: repeat(2 , 1fr);">
           
                <div>
                    
                <div style=" margin: 5% auto 5% auto;
                        /* margin-top: 5%; */
                        /* margin: auto; */
                        text-align: center;
                        width: 60%;
                        height: 15%;
                        padding:10px;
                        background-color: #F4F1EA;">
                <h1>RETURN BOOK</h1>
                </div>
                <div class="deleteupdate items2">
                <div class="showall">
                
                       
                        <div class="addbook2">
                            <div><label name="">Date</label></div>
                            <div><label name="">User ID</label></div>
                            <div><label name="">User Name</label></div>
                            <div><label name="">CODE</label></div>
                            <div><label name="">Title</label></div>
                            <!-- <div><label name="">Action</label></div> -->
                       
                        </div>
                      
                       
                 
                    
                </div>
                <div class="showall2">
                <?php

$sql = "SELECT user.UserID,user.name, borrowing.BookID AS boruserid,borrowing.ReturnDate AS borreturn,book.code,book.title
        FROM user
INNER JOIN borrowing ON user.UserID = borrowing.UserID
INNER JOIN book ON book.BookID  = borrowing.BookID;";
// WHERE borrowing.ReturnDate IS NOT NULL
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {

    

    // Output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        $retuneddate = $row['borreturn'];	
        $returded = ($retuneddate == NULL) ? " notreturned" : $retuneddate;
        ?>
        
                       
                    <div class="addbook3" style="
                   border-bottom: 1px solid #cbcbcb;
                    text-align:start;
                            ">
                        
                        <div class="rowaddbook3" style="" ><?php echo $returded; ?></div>
                        <div class="rowaddbook3" ><label name=""><?php echo $row["UserID"];  ?></label></div>
                        <div class="rowaddbook3"><label name=""><?php echo $row['name']; ?></label></div>
                        <div class="rowaddbook3"> <label name=""><?php echo $row['code']; ?></label></div>
                        <div class="rowaddbook3"><label name=""><?php echo $row['title']; ?></label></div>
                        <!-- <div class="rowaddbook3"><label name=""><?php echo $returded; ?></label></div> -->
                        

                        
                        
                        
                        <!-- <div style="display: grid; grid-template-rows: repeat(2 , 1fr);   gap: 2px; height: 60px; background-color: red;">
                           
                                <div class="" style="gap: 5px;"><button type="button" class="edit">Edit</button></div>
                                <div class=""><button type="button" class="delete">Delete</button></div>
                       -->

                                <!-- <div style="display: flex; margin-top: 5px;">
                                    <div  style="background:purple;">1</div>
                                    <div  style="background:green;">1</div>
                                </div> -->


                            <!-- <div ><button type="button" class="edit">Edit</button></div>
                            <div><button type="button" class="delete">Delete</button></div> -->
                        <!-- </div> -->
                    </div>
                  
                    <?php
        // echo "User ID: " . $row["UserID"].' '. $row['name'].' '. $row['boruserid'].' ' .$row['code'].' ' .$row['title']."<br>";
    }
} else {
    echo "0 results";
}

mysqli_close($conn);
?>

         
                
            </div>

                </div>
          

            <!-- </div> -->





        </div>
    </div>
</form>
<script>
   
</script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="chart1.js"></script>
</body>

</html>
