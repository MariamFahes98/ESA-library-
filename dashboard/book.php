<?php

require 'amalcloud/cloud/vendor/autoload.php';
use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;
include 'includes/conn.php';
// session_start();
Configuration::instance([
    'cloud' => [
      'cloud_name' => 'kaw-ets', 
      'api_key' => '249339831696657', 
      'api_secret' => 'iCKWYDwB8HUdFPzSpYttcN6oI7E'],
    'url' => [
      'secure' => true]]);

      $title = "";
      $author = "";
      $price ="";
      $code = "";
      $qty = "";


      $edit_state = false;
      $id = 0;

      

      $folder = 'library';
      // $filename = 'id3';
   
  
      if (isset($_POST['addbook']) && isset($_FILES["filea"])) {
        $title = $_POST['title'];
      // $id=;
        $author = $_POST['author'];
        $price = $_POST['price'];
        $code = $_POST['code'];
        $qty = $_POST['qty'];
        $category = $_POST['category'];
        $sql=" INSERT INTO book (title, author, price, code, quantity, CategoryID) 
        VALUES ('$title','$author','$price','$code','$qty','$category')";

       
$resulta=mysqli_query($conn, $sql);


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
    'public_id' => $code 
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

    if (isset($_POST['update'])) {
      $id = $_POST['id'];
      $title = $_POST['title'];
      $code = $_POST['code'];
      $author = $_POST['author'];
      $price = $_POST['price'];
      $qty = $_POST['qty'];
      $category = $_POST['category'];
      if(isset($_FILES["filea"])){
        $file = $_FILES["filea"]["tmp_name"];
        $uploadApi = new UploadApi();

// Upload the image with the specified folder
$result = $uploadApi->upload($file, [
    'folder' => $folder,
    'public_id' => $code 
]);

      } 
    
    
      mysqli_query($conn, "UPDATE book SET title='$title',CategoryID='$category',author='$author',code='$code',quantity='$qty',price='$price' WHERE BookID=$id");
      $_SESSION['message'] = "Data Updated Successfully";
      header('location: book.php');
    }
// For deleteing records
if (isset($_GET['delete'])) {
	$id = $_GET['delete'];
	mysqli_query($conn, "DELETE FROM book WHERE BookID=$id");
	// $_SESSION['message'] = "Data Deleted Successfully";
	header('location:book.php');
}
?>
<?php
// include 'all_process.php';
if (isset($_GET['edit'])) {
		$id = $_GET['edit'];
		$edit_state = true;

		$record = mysqli_query($conn, "SELECT * FROM book LEFT JOIN category ON category.CategoryID=book.CategoryID WHERE BookID=$id");
$data = mysqli_fetch_array($record);
$title = $data['title'];
$author = $data['author'];
$price = $data['price'];
$code = $data['code'];
$qty = $data['quantity'];

$category = $data['cattitle'];	
$categoryid = $data['CategoryID'];	


	

	}
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
                            <div>
                            <input type="hidden" name="id" value="<?php echo $id; ?>">  
                            <input type="text" id="title" name="title" value="<?php echo $title; ?>" required
                                    placeholder="Enter book title" /></div>
                            <div> <input type="number" id="isbn" name="code" value="<?php echo $code; ?>" required
                                    placeholder="Enter book code" /></div>
                        </div>
                        <div class="addbook">
                            <div> <input type="text" id="author" name="author" value="<?php echo $author; ?>" required
                                    placeholder="Enter book author" /></div>
                                    <div> <input type="number" id="price" name="price" value="<?php echo $price; ?>" required
                                    placeholder="Enter book price" /></div>
                            <!-- <div> <input type="text" id="status" name="status" value="" required
                                    placeholder="Enter book status" /></div> -->
                        </div>
                        <div class="addbook">
                            <div> <input type="number" id="qty" name="qty" value="<?php echo $qty; ?>" required
                                    placeholder="Enter book quantity" /></div>
                                    <div>   
                                 <select name="category" id="category" >
                                <option value="<?php echo $category; ?>" selected="selected">-- Select --</option>
                               <?php
                               $sqlc="SELECT * FROM category";
                               $query=mysqli_query($conn,$sqlc); //    $query=$conn->query($sqlc);
                           
                           
                               while($crow=mysqli_fetch_assoc($query)){  //while($crow=$query->fetch_assoc()){
                                $selected = ($categoryid == $crow['CategoryID']) ? " selected" : "";
                                ?>
                             <option value='<?php echo $crow['CategoryID'] ?>'  <?php echo $selected; ?> > <?php echo $crow['cattitle'] ?></option>
                                <?php
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
                        <?php if ($edit_state == false): ?>
                            <div> <button type="submit" name="addbook">Add</button></div>
                            <?php else: ?>
                                <div> <button type="submit" name="update">Update</button></div>
                                
                            <?php endif ?>
                          
               
                         
                         
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
                  <!--  $where = 'WHERE books.category_id = '.$catid; -->
                  <!--  $sql = "SELECT *, books.id AS bookid FROM books LEFT JOIN category ON category.id=books.category_id $where"; -->
                <?php
                    $sql = "SELECT * FROM book LEFT JOIN category ON category.CategoryID=book.CategoryID";
                    $query = $conn->query($sql);
                    while($row = $query->fetch_assoc()){
                        ?>
                
                       
                    <div class="addbook3">
                        <!--                         <div class="rowaddbook3"  ><img src="https://console.cloudinary.com/console/c-010f4d1f2b87b0637973ea8ca38440/media_library/folders/c81da2f82b8932d3413a424a86e6434ddc?view_mode=list/zouatspb9pyiyqgcg8x4.jpg" > </div>
                       -->
                        <div class="rowaddbook3"  ><img src="https://res.cloudinary.com/kaw-ets/image/upload/v1718985359/library/<?php echo $row['code']; ?>.JPG" > </div>
                        <div class="rowaddbook3" ><label name=""><?php echo ucfirst($row['title']) ; ?></label></div>
                        <div class="rowaddbook3"><label name=""><?php echo ucfirst($row['author']) ; ?></label></div>
                        <div class="rowaddbook3"><label name=""><?php echo ucfirst($row['code']) ; ?></label></div>
                        <!-- <div class="rowaddbook3" ><label name="">Borrwed</label></div> -->
                        <div class="rowaddbook3" ><label name=""><?php echo ucfirst($row['cattitle']) ; ?></label></div>
                        <div class="rowaddbook3"> <label name=""> <?php echo ucfirst($row['price']) ; ?>$</label></div>

                        <div class="rowaddbook3"><label name=""><?php echo ucfirst($row['quantity']) ; ?></label></div>

                        
                        <div class="first" style="text-align:center;">
                            <!--  margin-right:20px; -->
                          
                            <div style="">
                            <a href="book.php?edit=<?php echo $row["BookID"]; ?>" class="editbtnf" 
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
                                <a href="book.php?delete=<?php echo $row["BookID"]; ?>" class="editbtnf" 
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
             <?php
   }
   ?>
             
                
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
