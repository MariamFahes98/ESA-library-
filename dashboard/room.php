<?php
session_start();
include 'includes/conn.php';
if (!isset($_SESSION["roles"])|| (isset($_SESSION["roles"]) && $_SESSION["roles"] != 2))
     header("Location: index.php");
// print_r($_SESSION);
// echo $_SESSION["roles"];
// $name = $_SESSION["name"]

// // print_r($_SESSION);
// require 'amalcloud/cloud/vendor/autoload.php';
// use Cloudinary\Configuration\Configuration;
// use Cloudinary\Api\Upload\UploadApi;
include 'includes/conn.php';
// 
// Configuration::instance([
//     'cloud' => [
//       'cloud_name' => 'kaw-ets', 
//       'api_key' => '249339831696657', 
//       'api_secret' => 'iCKWYDwB8HUdFPzSpYttcN6oI7E'],
//     'url' => [
//       'secure' => true]]);

      $location = "";
      $capacity = "";
      $price ="";
      $code = "";
     
    //   $availability="";


      $edit_state = false;
    //   $id = 0;

      
      $formError=array();
    //   $folder = 'room';
    //   $nameErr ="";
      // $filename = 'id3';
      if ($_SERVER['REQUEST_METHOD'] == 'POST' && isSet($_POST['addroom'])) {
      
        //location capacity availability price
        $location = $_POST['location'];
        // $id=;
          $capacity = $_POST['capacity'];
          $price = $_POST['price'];
        //   $code = $_POST['capacity'];
        //   $availability=$_POST['availability'];
       

          if (empty($_POST["location"])) {
            $formError[] = "Room location is required";
            }
          if (empty($_POST["capacity"])) {
            $formError[] = "Room capacity is required";
             }
        if (empty($_POST["price"])) {
            $formError[] = "Room price is required";
            }
      
            // if(isset($_FILES['image'])) {
            //     $image = $_FILES['filea'];}
     
            $file = $_FILES["filea"];
            if ($file['error'] !== UPLOAD_ERR_OK) {
                
            // if (empty($_FILES["filea"]) || $_FILES["filea"]=== "") {
                $formError[] = "Room image is required";
                }  

                if (isset($_FILES["filea"]) && $_FILES["filea"]["error"] == UPLOAD_ERR_OK && isset($_POST['location'])
                 && isset($_POST['capacity']) && isset($_POST['price'])  ) {
                    $checkQuery = mysqli_query($conn, "SELECT * FROM room
                     WHERE 
                    location='$location'
                    AND capacity='$capacity' 
                  
                    AND price='$price'
                    
              
                    ");
                 
                    if (mysqli_num_rows($checkQuery) > 0) {
                        $formError[]='That room data already exists.';
                    }else{
              
                    // $public_id = $_POST['code'];
                    // $user_id = 1;
                    try {
                   
                            $location = $_POST['location'];
                        
                            $capacity = $_POST['capacity'];
                            $price = $_POST['price'];
                     
                            $sql = "INSERT INTO room (location, capacity, price) 
                                  VALUES ('$location','$capacity','$price')";
                                    // -- VALUES ('$title','$author','$price','$code','$description','$qty','$category')";
                            
                            $result = mysqli_query($conn, $sql);
                            $lastid=mysqli_insert_id($conn);

                            // $image = $_FILES['filea'];

                            $file = $_FILES["filea"]["tmp_name"];
                            // $folderPath = "roomimage/";
                            $filePath = "roomimage/" . $lastid . ".jpg";
                            if (move_uploaded_file($file, $filePath)) {
                                echo "File uploaded successfully.";
                            } else {
                                echo "Sorry, there was an error uploading your file.";
                            }
                            
                            if ($result) {
                                // Redirect after successful insertion
                                header("Location: room.php");
                                exit();
                            } else {
                                echo "Error: " . mysqli_error($conn);
                            }
                     
                    } catch (Exception $e) {
                        echo "Error: " . $e->getMessage();
                    }
                }
                    
            } else {
                    echo "Error: No data uploaded ";
                }



  }
////location, capacity, price
    if (isset($_POST['update'])) {
      $id = $_POST['id'];
      $location = $_POST['location'];
      $capacity = $_POST['capacity'];

 
  
   
      $price = $_POST['price'];
   

      
// echo "Random number between 1 and 10: " . $randomNumber . "\n";

// $lastid=mysqli_insert_id($conn);
$image = $_FILES['filea'];

$file = $_FILES["filea"]["tmp_name"];
$folderPath = "roomimage/";
$filePath = $folderPath . $id . ".jpg";
if (move_uploaded_file($image['tmp_name'], $filePath)) {
    echo "File uploaded successfully.";
} else {
    echo "Sorry, there was an error uploading your file.";
}

  
    
    
      mysqli_query($conn, "UPDATE room SET location='$location',capacity='$capacity',price='$price' WHERE RoomID=$id");
      $formError[] = "Data Updated Successfully";
      header('location: room.php');
    }

  
  

// For deleteing records
if (isset($_GET['delete'])) {
	$id = $_GET['delete'];
  
	mysqli_query($conn, "DELETE FROM room WHERE RoomID=$id");
  
	echo "Data Deleted Successfully";
	header('location:room.php');
}

//location, capacity, price
if (isset($_GET['edit'])) {
		$id = $_GET['edit'];
		$edit_state = true;

		$record = mysqli_query($conn, "SELECT * FROM room  WHERE RoomID=$id");
$data = mysqli_fetch_assoc($record);

$location = $data['location'];
// $uppercaseName = strtoupper($title);
$capacity = $data['capacity'];

$price = $data['price'];


// $description = $data['description'];
// $sub=mb_substr($description, 0, 100);



	}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, minimum-scale=1">
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
        integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />
    <title>Room</title>
</head>

<body>
<form name="myForm" action="room.php" method="POST" enctype="multipart/form-data" onsubmit="validateForm()">
   
    <div class="container">
    <?php include 'includes/navbar.php'; ?>
       
        <?php include 'includes/sidebar.php'; ?>
               <div class="main">


            <div class="items1">
                <div class="add">
                    <div>
                        <h1>ADD NEW ROOM</h1>
                        <div class="addbook">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">  
                            <div> <input type="text" id="location" name="location" value="<?php echo $location; ?>"
                                    placeholder="Enter room location" /></div>
                            <div> <input type="number" id="price" name="price" value="<?php echo $price; ?>"
                                    placeholder="Enter room price" /></div>
                        </div>
                        <div class="addbook">
                            <div> <input type="text" id="capacity" name="capacity" value="<?php echo $capacity; ?>"
                                    placeholder="Enter room capacity" /></div>


                            <div> <input type="file" name="filea" id="filea" onchange="validateFileType()"/></div>
                        </div>
                        <!-- <div class="addbook">
                            <div> <input type="text" id="availability" name="availability" value="" required
                                    placeholder="Enter room availability" /></div>
                            <div> </div>
                        </div> -->
                    
                        <div class="addbook">
                                <?php if ($edit_state == false){ ?>
                                    <div> <button type="submit" name="addroom">Add Room</button></div>
                            <?php } else{ ?>
                                <div> <button type="submit" name="update">Update</button></div>
                                
                            <?php } ?>
                        <!-- <div> <button type="submit" name="addroom">Add Room</button></div> -->
                           
                         
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
            <div class="deleteupdate items2" style="margin-left:80px; margin-right: 80px;">
                <div class="showall">
                
                       
                        <div class="addbook2">
                            <div><label name="">Image</label></div>
                            <div><label name="">Location</label></div>
                            <div><label name="">Capacity</label></div>
                            <!-- <div><label name="">Availability</label></div> -->
                            <div><label name="">Price</label></div>
                       
                            <div style="margin-left:20px;"><label name="">Action</label></div>
                        </div>
                      
                       
                 
                    
                </div>
                <div class="showall2">
                <?php
                //ORDER BY category.cattitle DESC
                    $sql = "SELECT * FROM room ";
                    $result = mysqli_query($conn, $sql);
                     // Output data of each row
                        while ($row = mysqli_fetch_assoc($result)) {
                     
                        ?>
                       
                    <div class="addbook3" style="">
                        
                        <div class="rowaddbook3"  ><img src="roomimage/<?php echo $row['RoomID']; ?>.jpg" > </div>
                        <div class="rowaddbook3" ><label name=""><?php echo $row['location']; ?></label></div>
                        <div class="rowaddbook3"><label name=""><?php echo $row['capacity']; ?></label></div>
                        <!-- <div class="rowaddbook3"> <label name="">12 PM-2PM</label></div> -->
                        <div class="rowaddbook3"><label name=""><?php echo $row['price']; ?> $</label></div>
                        

                        
                        <div class="first" style="text-align:start;">
                            <!--  margin-right:20px; -->
                          
                            <div style="">
                            <a href="room.php?edit=<?php echo $row["RoomID"]; ?>" class="editbtnf" 
                                    style="
                                       margin-right: 5px; 
                                         box-sizing: border-box;
                                          border-radius: solid 1px #463610;
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
                                <a href="room.php?delete=<?php echo $row["RoomID"]; ?>" class="editbtnf editc" 
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
       //location price capacity availability
  let location = document.forms["myForm"]["location"].value;
  let price = document.forms["myForm"]["price"].value;
  let capacity = document.forms["myForm"]["capacity"].value;
  let availability = document.forms["myForm"]["availability"].value;

 


  if (location == "") {
    alert("location must be filled out");
    return false;
  }
  if (price == "") {
    alert("price must be filled out");
    return false;
  }

  if (capacity == "") {
    alert("capacity must be filled out");
    return false;
  }
  if (availability == "") {
    alert("availability must be filled out");
    return false;
  }
 

}
//     <div> <input type="file" id="fileUpload" onchange="validateFileType()"/></div>
function validateFileType() {
         var selectedFile = document.getElementById('fileUpload').files[0];
         var allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];

         if (!allowedTypes.includes(selectedFile.type)) {
            alert('Invalid file type. Please upload a JPEG, PNG, or PDF file.');
            document.getElementById('fileUpload').value = '';
         }
      }
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.editc').click(function(e) {
        // e.preventDefault();
        
        var deleteUrl = $(this).attr('href'); // Get the href attribute of the clicked element
        // console.log(deleteUrl); // Optional: Log the URL to verify
        
        // Display a confirmation dialog
        if (confirm("Are you sure you want to delete this room?")) {
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
