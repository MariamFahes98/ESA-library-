<?php
session_start();
include 'includes/conn.php';
if (!isset($_SESSION["roles"])|| (isset($_SESSION["roles"]) && $_SESSION["roles"] != 2))
     header("Location: index.php");
// print_r($_SESSION);
// echo $_SESSION["roles"];
// $name = $_SESSION["name"]

// print_r($_SESSION);
require 'amalcloud/cloud/vendor/autoload.php';
use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;
include 'includes/conn.php';
// 
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
      $description="";
      $salecount="";


      $edit_state = false;
      $id = 0;

      
      $formError=array();
      $folder = 'library';
      $nameErr ="";
      // $filename = 'id3';
      if ($_SERVER['REQUEST_METHOD'] == 'POST' && isSet($_POST['addbook'])) {
        // $name = $_POST['title'];
        $title = $_POST['title'];
        // $id=;
          $author = $_POST['author'];
          $price = $_POST['price'];
          $code = $_POST['code'];
          $description=$_POST['description'];
          $qty = $_POST['qty'];
          $category = $_POST['category'];
          $salecount = $_POST['salecount'];
          

          if (empty($_POST["title"])) {
            $formError[] = "Book title is required";
            }
          if (empty($_POST["author"])) {
            $formError[] = "Book author is required";
             }
        if (empty($_POST["price"])) {
            $formError[] = "Book price is required";
            }
        if (empty($_POST["code"])) {
            $formError[] = "Book code is required";
            }
            if (empty($_POST["description"])) {
                $formError[] = "Book description is required";
                }
                
            //
        if (empty($_POST["qty"])) {
            $formError[] = "Book qty is required";
            }
            //  if (empty($country) || $country == "") {
                if (empty($_POST["category"]) || $_POST["category"] === "") {
            $formError[] = "Book category is required";
            }  
            $file = $_FILES["filea"];
            if ($file['error'] !== UPLOAD_ERR_OK) {
            // if (empty($_FILES["filea"]) || $_FILES["filea"]=== "") {
                $formError[] = "Book image is required";
                } 
                if (empty($_POST["salecount"])) {
                    $formError[] = "Book salecount is required";
                    }     
//salecount
                if (isset($_FILES["filea"]) && $_FILES["filea"]["error"] == UPLOAD_ERR_OK && isset($_POST['title'])
                 && isset($_POST['author']) && isset($_POST['price']) && isset($_POST['code']) && isset($_POST['description']) && isset($_POST['qty'])
                 && isset($_POST['category']) && isset($_POST['salecount'])) {
                    $checkQuery = mysqli_query($conn, "SELECT * FROM `book`
                     WHERE 
                    title='$title'
                    AND `author`='$author' 
                    AND `title`='$title'
                    AND `price`='$price'
                    AND `code`='$code'
                    AND `description`='$description'
                    AND `quantity`='$qty'
                    AND `CategoryID`='$category'
                    AND `sales_count`='$salecount'
                    ");
                    //AND   `price`='$price' AND `code`='$code' AND `descript`='$description' AND `quantity`='$qty' AND `CategoryID`='$category'
                    // author, price, code,descript,quantity, CategoryID
                  
                    // $file = $_FILES["filea"]["type"];
                    if (mysqli_num_rows($checkQuery) > 0) {
                        $formError[]='That databook already exists.';
                    }else{
              
                    $public_id = $_POST['code'];
               
                    try {
                        $file = $_FILES["filea"]["tmp_name"];
                        $uploadApi = new UploadApi();

                        $result = $uploadApi->upload($file, [
                                    'folder' => $folder,
                                    'public_id' => $code ,
                                    'format' => "jpg",
                                    // 'size'=>'',
                                    'transformation' => array(
                                        array("width" => 500, "height" => 500, "crop" => "scale")
                                    )
                                ]);

                     
                            $title = $_POST['title'];
                            $titleescape = mysqli_real_escape_string($conn,$title);
                            $author = $_POST['author'];
                            $authorescape = mysqli_real_escape_string($conn,$author);
                            $price = $_POST['price'];
                            $code = $_POST['code'];
 
                            $description = $_POST['description'];
                            $desc = mysqli_real_escape_string($conn,$description);
                            $qty = $_POST['qty'];
                            $category = $_POST['category'];
                            $salecount=$_POST['salecount'];
                       
                            $sql = "INSERT INTO book (title, author, price, code,description,quantity, CategoryID,sales_count) 
                                  VALUES ('$titleescape','$authorescape','$price','$code','" .$desc ."','$qty','$category','$salecount')";
                                    // -- VALUES ('$title','$author','$price','$code','$description','$qty','$category')";
                            
                            $result = mysqli_query($conn, $sql);
                            
                            if ($result) {
                                // Redirect after successful insertion
                                header("Location: book.php");
                                exit();
                            } else {
                                echo "Error: " . mysqli_error($conn);
                            }
                     
                    } catch (Exception $e) {
                        echo "Error: " . $e->getMessage();
                    }
                }
                    
                } else {
                    echo "Error: No file uploaded or upload error occurred.";
                }



  }

    if (isset($_POST['update'])) {
      $id = $_POST['id'];
      $title = $_POST['title'];
      $code = $_POST['code'];

 
      $description = $_POST['description'];
      $desc = mysqli_real_escape_string($conn,$description);
      $author = $_POST['author'];
      $price = $_POST['price'];
      $qty = $_POST['qty'];
      $category = $_POST['category'];
      $salecount=$_POST['salecount'];
      $randomNumber = rand();



      if(isset($_FILES["filea"])){
        $file = $_FILES["filea"]["tmp_name"];
        $uploadApi = new UploadApi();

// Upload the image with the specified folder
$result = $uploadApi->upload($file, [
    'folder' => $folder,
    'public_id' => $code,
    'format' => "jpg",
    'transformation' => array(
        array("width" => 500, "height" => 500, "crop" => "scale")
    ) 
]);

      } 
    
    
      mysqli_query($conn, "UPDATE book SET title='$title',CategoryID='$category',author='$author',code='$code',description='$desc',quantity='$qty',price='$price',sales_count='$salecount' WHERE BookID=$id");
      $formError[] = "Data Updated Successfully";
      header('location: book.php');
    }

  
  


if (isset($_GET['delete'])) {
	$id = $_GET['delete'];
  
	mysqli_query($conn, "DELETE FROM book WHERE BookID=$id");
  
	echo "Data Deleted Successfully";
	header('location:book.php');
}
?>
<?php

if (isset($_GET['edit'])) {
		$id = $_GET['edit'];
		$edit_state = true;

		$record = mysqli_query($conn, "SELECT * FROM book INNER JOIN category ON category.CategoryID=book.CategoryID WHERE BookID=$id");
$data = mysqli_fetch_assoc($record);

$title = $data['title'];
$uppercaseName = strtoupper($title);
$author = $data['author'];

$price = $data['price'];
$code = $data['code'];

$description = $data['description'];
// $sub=mb_substr($description, 0, 100);

$desc = mysqli_real_escape_string($conn,$description);
$qty = $data['quantity'];

$category = $data['cattitle'];	
$categoryid = $data['CategoryID'];	
$salecount=$data['sales_count'];


	

	}
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

    <form name="myForm" action="book.php" method="POST" enctype="multipart/form-data" onsubmit="validateForm()">
    <div class="container">
        <?php include 'includes/navbar.php'; ?>
  
        <?php include 'includes/sidebar.php'; ?>
        
        <div class="main" style="grid-template-rows: repeat(1, 1fr); padding-bottom: 20px;">


            <div class="items1" style="  height:auto;">
        
                <div class="add" style="height: 83%;">
                    <div>
                        <h1>ADD NEW BOOK</h1>
                        <div class="addbook">
                            <div>
                            <input type="hidden" name="id" value="<?php echo $id; ?>">  
                            <input type="text" id="title" name="title" value="<?php echo $title; ?>" 
                                    placeholder="Enter book title" /> 
                                   </div>
                            <div> <input type="number" id="isbn" name="code" value="<?php echo $code; ?>" 
                                    placeholder="Enter book code" /></div>
                        </div>
                        <div class="addbook">
                            <div> <input type="text" id="author" name="author" value="<?php echo $author; ?>" 
                                    placeholder="Enter book author" /></div>
                                    <div> <input type="number" id="price" name="price" value="<?php echo $price; ?>" 
                                    placeholder="Enter book price" /></div>
                            <!-- <div> <input type="text" id="status" name="status" value="" required
                                    placeholder="Enter book status" /></div> -->
                        </div>
                        <div class="addbook">
                            <div> <input type="number" id="qty" name="qty" value="<?php echo $qty; ?>" 
                                    placeholder="Enter book quantity" /></div>
                                    <div>   
                                 <select name="category" id="category" >
                                <option value="0" selected="selected">-- Select --</option>
                               <?php
                               $sqlc="SELECT * FROM category ORDER BY cattitle ";
                               $query=mysqli_query($conn,$sqlc); //  
                           
                           
                               while($crow=mysqli_fetch_assoc($query)){  
                                $selected = ($categoryid == $crow['CategoryID']) ? " selected" : "";
                                ?>
                             <option value='<?php echo $crow['CategoryID'] ?>'  <?php echo $selected; ?> > <?php echo $crow['cattitle']; ?></option>
                                <?php
                               }
                               ?>
                                

                                
                              </select>
                            </div>
                        
                        </div>
                   
                        <div class="addbook">
                             <div> <input type="file" id="filea" name="filea"  accept="image/*" /></div>
                             <div><input type="text" id="description" name="description" value="<?php echo $description; ?>" placeholder="Enter book description" />
                             </div> 
               
                          <!-- <div><textarea id="description" name="description" maxlength="1000"></textarea></div> -->
                      
                        </div>
                        <div class="addbook">
                            <div> <input type="number" id="salecount" name="salecount" value="<?php echo $salecount; ?>" 
                                    placeholder="Enter book salecount" /></div>
                                    <div> </div>
                            <!-- <div> <input type="text" id="status" name="status" value="" required
                                    placeholder="Enter book status" /></div> -->
                        </div>
                        <div class="addbook">
                        <?php if ($edit_state == false): ?>
                            <div> <button type="submit" name="addbook">Add</button></div>
                            <?php else: ?>
                                <div> <button type="submit" name="update">Update</button></div>
                                
                            <?php endif ?>
                          
               
                         
                         
                        </div>
                    </div>
                        <div style="margin-left:40px; margin-top:20px;
                            width: 30%;padding-top:10px; color:red;
                            text-align:start;
                            /* height: 10%;"> 
        
                                    <?php if(!empty($formError)){
                                    foreach($formError as $error){
                                ?>
                                <span class="" >
                                        <?php
                                        echo $error ."<br>";
                                        ?>
                                </span>
                                <?php  } } else{echo "";}
                                ?>
                  
                      </div>
                      <div></div>
                </div>
                
            </div>
            <div class="deleteupdate items2" style="">
                <div class="showall">
                
                       
                        <div class="addbook2">
                            <div><label name="">Image</label></div>
                            <div><label name="">Title</label></div>
                            <div><label name="">Author</label></div>
                          
                            <div><label name="">CODE</label></div>
                            <div><label name="">DESCRIPTION</label></div>
                            <div><label name="">Categories</label></div>
                            <div><label name="">Price</label></div>
                            <!-- <div><label name="">Status</label></div> -->
                            <div><label name="">SalesCount</label></div>
                            <div><label name="">Quantity</label></div>
                           
                            <div style="text-align:center;" ><label name="">Action</label></div>
                        </div>
                      
                   
                </div>
                <div class="showall2">
               
                <?php
                //ORDER BY category.cattitle DESC
                    $sql = "SELECT * FROM book
                     INNER JOIN category ON category.CategoryID=book.CategoryID";
                    $result = mysqli_query($conn, $sql);
                     // Output data of each row
                        while ($row = mysqli_fetch_assoc($result)) {
                     
                        ?>
          
                    <div class="addbook3">
                        <!--                         <div class="rowaddbook3"  ><img src="https://console.cloudinary.com/console/c-010f4d1f2b87b0637973ea8ca38440/media_library/folders/c81da2f82b8932d3413a424a86e6434ddc?view_mode=list/zouatspb9pyiyqgcg8x4.jpg" > </div>
                       -->
                        <div class="rowaddbook3"  ><img src="https://res.cloudinary.com/kaw-ets/image/upload/v1718985359/library/<?php echo $row['code']; ?>.JPG?cache_bust=<?php echo time(); ?>" alt="Image"> </div>
                        <div class="rowaddbook3"  style="padding-right: 10px;"><label name=""><?php echo  mysqli_real_escape_string($conn,$row['title']); ?></label></div>
                        <div class="rowaddbook3"><label name=""><?php echo ucfirst($row['author']) ; ?></label></div>
                        <div class="rowaddbook3"><label name=""><?php echo ucfirst($row['code']) ; ?></label></div>
                        <div class="rowaddbook3" style="padding-right: 10px;"><label name=""><?php echo mb_substr($row['description'],0,55) ."..." ; ?></label></div>
                        <!-- <div class="rowaddbook3" ><label name="">Borrwed</label></div> -->
                        <div class="rowaddbook3" ><label name=""><?php echo $row['cattitle'] ; ?></label></div>
                        <div class="rowaddbook3"> <label name=""> <?php echo ucfirst($row['price']) ; ?>$</label></div>
                        <div class="rowaddbook3"> <label name=""> <?php echo ucfirst($row['sales_count']) ; ?></label></div>
                        <div class="rowaddbook3"><label name=""><?php echo ucfirst($row['quantity']) ; ?></label></div>

                        
                        <div class="first" style="text-align:center;">
                            <!--  margin-right:20px; -->
                          
                            <div style="">
                            <a href="book.php?edit=<?php echo $row["BookID"]; ?>" class="editbtnf" 
                                    style="
                                       margin-right: 5px; 
                                         box-sizing: border-box; border-radius: solid 1px #463610;
                                         margin-top:0;
                                            margin-bottom:3px;
                                        background-color: #463610;
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
                                <a href="book.php?delete=<?php echo $row["BookID"]; ?>" class="editbtnf editc" 
                                    style=" margin-right: 5px; 
                                  box-sizing: border-box; border-radius: solid 1px #867548;
                                  
                                background-color: #867548;
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
   const errorMessage = document.getElementById('errorMessage');
  let title = document.forms["myForm"]["title"].value;
  let code = document.forms["myForm"]["code"].value;
  let author = document.forms["myForm"]["author"].value;
  let status = document.forms["myForm"]["status"].value;
  let price = document.forms["myForm"]["price"].value;
  let qty = document.forms["myForm"]["qty"].value;
  if (title == "") {

    errorMessage.textContent = 'Book title is required';
    return false;
  }
//   errorMessage.textContent = '';
//   return true;

 
  if (code == "") {
    errorMessage.textContent = 'code must be filled out';
    return false;
  }
  if (author == "") {
    errorMessage.textContent = 'author must be filled out';
    return false;
  }
  if (status == "") {
    errorMessage.textContent = 'status must be filled out';
  
    return false;
  }
  if (price == "") {
    errorMessage.textContent = 'price must be filled out';
  
    return false;
  }
  if (qty == "") {
    errorMessage.textContent = 'quantity must be filled out';
  
    return false;
  }

            if ($_FILES["filea"]=="") {
            // if (empty($_FILES["filea"]) || $_FILES["filea"]=== "") {
                errorMessage.textContent = "image must be filled out";
                }  

}
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.editc').click(function(e) {
        e.preventDefault();
        
        var deleteUrl = $(this).attr('href'); // Get the href attribute of the clicked element
        console.log(deleteUrl); // Optional: Log the URL to verify
        
        // Display a confirmation dialog
        if (confirm("Are you sure you want to delete this book?")) {
            // Redirect to the delete URL if confirmed
            window.location.href = deleteUrl;
        } else {
            // Do something else if not confirmed (optional)
        }
    });
});
</script>


</body>

</html>
