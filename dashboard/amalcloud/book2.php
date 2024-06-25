<?php

require 'amalcloud/cloud/vendor/autoload.php';
use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;
// include 'includes/conn.php';
// session_start();
Configuration::instance([
    'cloud' => [
      'cloud_name' => 'kaw-ets', 
      'api_key' => '249339831696657', 
      'api_secret' => 'iCKWYDwB8HUdFPzSpYttcN6oI7E'],
    'url' => [
      'secure' => true]]);

      

      $folder = 'library';
      // $filename = 'id3';
      $conn = new mysqli('localhost', 'root', '', 'library');

      if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
      }
  
      if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["filea"])) {
        $title = $_POST['title'];
    
        $author = $_POST['author'];
        $price = $_POST['price'];
        $code = $_POST['code'];
        $qty = $_POST['qty'];
        $category = $_POST['category'];
        $sql=" INSERT INTO books (title, author, price, code, quantity, categories_id) 
        VALUES ('$title','$author','$price','$code','$qty','$category')";

       
$resulta=mysqli_query($conn, $sql);

// if ($resulta) {
//     // Get the ID of the last inserted row
//     $last_insert_id = mysqli_insert_id($conn);

//     // Display the ID of the last inserted row
//     echo $last_insert_id;
//     echo "<p>ID of the last inserted row: " . $last_insert_id. "</p>";
// } else {
//     echo "Error inserting record: " . mysqli_error($conn);
// }

// $row=mysqli_fetch_row($resulta);
// echo $row[0];
// if ($row) {
//     // Output the first column value (id)
//     echo "ID: " . $row[0];
// } else {
//     echo "No rows found";
// }
if ($resulta) {
    // $_SESSION['message'] = "Data Saved Successfully";
       header("Location: book.php");
    } else {
       mysqli_close($conn);
    }

        // Upload image to Cloudinary
        $file = $_FILES["filea"]["tmp_name"];
        $uploadApi = new UploadApi();

// Upload the image with the specified folder
$result = $uploadApi->upload($file, [
    'folder' => $folder,
    // 'public_id' => $filename 
]);
       

    
        // Check if upload was successful
        if ($result && isset($result["secure_url"])) {
            $image_url = $result["secure_url"];
            echo "Image uploaded successfully. URL: " . $image_url;
            // Here you can save $image_url to your database or use it as needed
        } else {
            echo "Failed to upload image.";
        }
    }







// =====

//       if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["fileUpload"])) {
//         // Upload image to Cloudinary
//         $file = $_FILES["fileUpload"]["tmp_name"];
//         $uploadApi = new UploadApi();

// // Upload the image with the specified folder
// // $result = $uploadApi->upload($file, [
// //     'folder' => $folder,
// //     // 'public_id' => $filename 
// // ]);
// $result = $uploadApi->upload($file, [
//     'folder' => $folder
//     // 'public_id' => $filename 
// ]);

//         if ($result && isset($result["secure_url"])) {
//             $image_url = $result["secure_url"];
//             echo "Image uploaded successfully. URL: " . $image_url;
//             // Here you can save $image_url to your database or use it as needed
//         } else {
//             echo "Failed to upload image.";
//         }
//     }

// $name = "";

// $id = 0;
// $edit_state = false;
// if (isset($_POST['addbook'])) {
// 	$title = $_POST['title'];
    
//     $author = $_POST['author'];
//     $price = $_POST['price'];
//     $code = $_POST['code'];
//     $qty = $_POST['qty'];
//     $category = $_POST['category'];
//     $sql=" INSERT INTO books (title, author, price, code, quantity, categories_id) 
//     VALUES ('$title','$author','$price','$code','$qty','$category')";
          // $folder = 'library';
      // $filename = 'id3';



// $sql->insert_id;
// if($conn->query($sql)){
//     header("Location: book.php");
// }
// else {
//     echo "Error: " . $conn->error;
//     	 }
//  mysqli_insert_id($sql);
//  if (mysqli_query($conn, $sql)) {
//  	// $_SESSION['message'] = "Data Saved Successfully";
// 		header("Location: book.php");
// 	 } else {
// 		mysqli_close($conn);
// 	 }

// }
// For updating records
// if (isset($_POST['update'])) {
// 	$id = $_POST['id'];
// 	$name = $_POST['categoriname'];


// 	mysqli_query($conn, "UPDATE category SET namecategory='$name' WHERE categories_id=$id");
// 	$_SESSION['message'] = "Data Updated Successfully";
// 	header('location: categories.php');
// }
// For deleteing records
// if (isset($_GET['delete'])) {
// 	$id = $_GET['delete'];
// 	mysqli_query($conn, "DELETE FROM category WHERE categories_id=$id");
// 	$_SESSION['message'] = "Data Deleted Successfully";
// 	header('location:categories.php');
// }
?>


<?php

//       $folder = 'library';
//       $filename = 'id3';

//       if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["fileUpload"])) {
//         // Upload image to Cloudinary
//         $file = $_FILES["fileUpload"]["tmp_name"];
//         $uploadApi = new UploadApi();

// // Upload the image with the specified folder
// $result = $uploadApi->upload($file, [
//     'folder' => $folder,
//     'public_id' => $filename 
// ]);
//         // $result = \Cloudinary\Uploader::upload($file);
    
//         // Check if upload was successful
//         if ($result && isset($result["secure_url"])) {
//             $image_url = $result["secure_url"];
//             echo "Image uploaded successfully. URL: " . $image_url;
//             // Here you can save $image_url to your database or use it as needed
//         } else {
//             echo "Failed to upload image.";
//         }
//     }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
        integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />
    <title>Book</title>
</head>

<body>

    <form name="myForm" action="book.php" method="POST" enctype="multipart/form-data">
    <div class="container">
        <?php include 'includes/navbar.php'; ?>
  
        <?php include 'includes/sidebar.php'; ?>
        
        <div class="main">


            <div class="items1">
                <div class="add">
                    <div>
                        <h1>ADD NEW BOOK</h1>
                        <div class="addbook">
                            <div> <input type="text" id="title" name="title" value="" required
                                    placeholder="Enter book title" /></div>
                            <div> <input type="number" id="isbn" name="code" value="" required
                                    placeholder="Enter book code" /></div>
                        </div>
                        <div class="addbook">
                            <div> <input type="text" id="author" name="author" value="" required
                                    placeholder="Enter book author" /></div>
                                    <div> <input type="number" id="price" name="price" value="" required
                                    placeholder="Enter book price" /></div>
                            <!-- <div> <input type="text" id="status" name="status" value="" required
                                    placeholder="Enter book status" /></div> -->
                        </div>
                        <div class="addbook">
                            <div> <input type="number" id="qty" name="qty" value="" required
                                    placeholder="Enter book quantity" /></div>
                                    <div>   
                                 <select name="category" id="category" >
                                <option value="" selected="selected">-- Select --</option>
                               <?php
                               $sqlc="SELECT * FROM category";
                               $query=$conn->query($sqlc);
                               while($crow=$query->fetch_assoc()){
                                echo " <option value='".$crow['categories_id']."' > ".$crow['namecategory']."</option>";
                               }
                               ?>
                                
                              </select>
                            </div>
                            <!-- <div> <input type="text" id="stockLevel" name="stockLevel" value="" required
                                    placeholder="Enter book stockLevel" /></div> -->
                        </div>
                        <div class="addbook">
                        <div> <input type="file" id="filea" name="filea"  accept="image/*" /></div>
                          
                            <div></div>
                        </div>
                        <div class="addbook">
                        <div> <button type="submit" name="addbook">Add</button></div>
                         
                         
                        </div>
                    </div>
                </div>
            </div>
            <div class="deleteupdate items2">
                <div class="showall">
                
                       
                        <div class="addbook2">
                            <div><label name="">Image</label></div>
                            <div><label name="">Title</label></div>
                            <div><label name="">Author</label></div>
                          
                            <div><label name="">CODE</label></div>
                            <div><label name="">Categories</label></div>
                            <div><label name="">Price</label></div>
                            <!-- <div><label name="">Status</label></div> -->
                           
                            <div><label name="">Quantity</label></div>
                            <div style="text-align:center;" ><label name="">Action</label></div>
                        </div>
                      
                   
                </div>
                <div class="showall2">
                
                       
                    <div class="addbook3">
                        <!--                         <div class="rowaddbook3"  ><img src="https://console.cloudinary.com/console/c-010f4d1f2b87b0637973ea8ca38440/media_library/folders/c81da2f82b8932d3413a424a86e6434ddc?view_mode=list/zouatspb9pyiyqgcg8x4.jpg" > </div>
                       -->
                        <div class="rowaddbook3"  ><img src="https://res.cloudinary.com/kaw-ets/image/upload/v1718985359/library/qf1zu8dpmhe4xjlmlh7t.jpg" > </div>
                        <div class="rowaddbook3" ><label name="">Lovely Bones</label></div>
                        <div class="rowaddbook3"><label name="">Alice Sebold</label></div>
                        <div class="rowaddbook3"><label name="">9781600248429</label></div>
                        <!-- <div class="rowaddbook3" ><label name="">Borrwed</label></div> -->
                        <div class="rowaddbook3" ><label name="">History</label></div>
                        <div class="rowaddbook3"> <label name="">25$</label></div>

                        <div class="rowaddbook3"><label name="">5</label></div>

                        
                        <div class="first" style="text-align:center;">
                            <!--  margin-right:20px; -->
                          
                            <div style="">
                            <a href="book.php?edit=<?php ?>" class="editbtnf" 
                                    style="
                                       margin-right: 5px; 
                                         box-sizing: border-box; border-radius: solid 1px green;
                                         margin-top:0;
                                            margin-bottom:3px;
                                        background-color: green;
                                        border: none;
                                        color: white;
                                        height:25px;
                                         padding: 4px 25px;
                                        text-align: center;
                                        text-decoration: none;
                                        display: inline-block;
                                        font-size: 14px;
                                    
                                    
                                    "> <i class='fa fa-edit'></i> Edit</a>

                                <!-- <button class="firstbtn" type="button" >Edit</button> -->
                                                                
                                <br> 
                                <a href="book.php?delete" class="editbtnf" 
                                    style=" margin-right: 5px; 
                                  box-sizing: border-box; border-radius: solid 1px red;
                                  
                                background-color: red;
                                border: none;
                                color: white;
                                height:25px;
                                padding: 4px 18px;
                                text-align: center;
                                text-decoration: none;
                                display: inline-block;
                                font-size: 14px;
      
                                    
                                    "> <i class='fa fa-trash'></i></i> Delete</a>
                                <!-- <button class="secondbtn" type="button" >Delete</button> -->
                            </div>
                         
                            
                        </div>
                        
                  
                       
                    </div>
                  
                   
             <hr>
            
                
            </div>

            </div>





        </div>
    </div>
</form>
<script>
    function validateForm() {
  let title = document.forms["myForm"]["title"].value;
  let isbn = document.forms["myForm"]["isbn"].value;
  let author = document.forms["myForm"]["author"].value;
  let status = document.forms["myForm"]["status"].value;
  let price = document.forms["myForm"]["price"].value;
  let stockLevel = document.forms["myForm"]["stockLevel"].value;
  if (title == "") {
    alert("title must be filled out");
    return false;
  }
  if (isbn == "") {
    alert("ISBN must be filled out");
    return false;
  }
  if (author == "") {
    alert("author must be filled out");
    return false;
  }
  if (status == "") {
    alert("status must be filled out");
    return false;
  }
  if (price == "") {
    alert("price must be filled out");
    return false;
  }
  if (stockLevel == "") {
    alert("stockLevel must be filled out");
    return false;
  }
  //// status price stockLevel
}
</script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="chart1.js"></script>
</body>

</html>
