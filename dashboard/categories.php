
<?php
session_start();
include 'includes/conn.php';
$name = "";

$id = 0;
$edit_state = false;

$nameErr ="";
  $formError=array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isSet($_POST['add'])) {
	$name = $_POST['categoriname'];
    if (empty($_POST["categoriname"])) {
        $nameErr = "Name is required";
      }
  
      
    if (isSet($_POST['categoriname']) && $_POST['categoriname'] != '') {
		$user = $_POST['categoriname'];
		$checkQuery = mysqli_query($conn, "SELECT * FROM `category` WHERE `cattitle`='$name'");
        
        //
        // if($_POST['categoriname'] ==''){
        //     $formError[]='Enter the name for category';
            
        //     }
		if (mysqli_num_rows($checkQuery) > 0) {
			$formError[]='That username already exists.';
		}else{
			$insertQuery = mysqli_query($conn, "INSERT INTO category (cattitle) VALUES ('$name')");
			if ($insertQuery) {
                $formError[] = "Data Saved Successfully";
                header("Location: categories.php");
			}
            // else
				// echo 'Failed to insert username although no rows previously existed...';
		}
	}
    // else
		// echo 'No username input found. No post sent...';



//  $sql = "INSERT INTO category (cattitle) VALUES ('$name')";
//  if (mysqli_query($conn, $sql)) {
//  	$_SESSION['message'] = "Data Saved Successfully";
// 		header("Location: categories.php");
// 	 } else {
// 		mysqli_close($conn);
// 	 }

}
// For updating records
if (isset($_POST['update'])) {
	$id = $_POST['id'];
	$name = $_POST['categoriname'];


	mysqli_query($conn, "UPDATE category SET cattitle='$name' WHERE CategoryID=$id");
	$_SESSION['message'] = "Data Updated Successfully";
	header('location: categories.php');
}
// For deleteing records
if (isset($_GET['delete'])) {
	$id = $_GET['delete'];
	mysqli_query($conn, "DELETE FROM category WHERE CategoryID=$id");
	$_SESSION['message'] = "Data Deleted Successfully";
	header('location:categories.php');
}
?>
<?php
// include 'all_process.php';
if (isset($_GET['edit'])) {
		$id = $_GET['edit'];
		$edit_state = true;

		$record = mysqli_query($conn, "SELECT * FROM category WHERE CategoryID=$id");
$data = mysqli_fetch_array($record);
			$name = $data['cattitle'];
	

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
    <title>Categories Books</title>
</head>

<body>
    <form name="myForm" action="categories.php"  method="POST" onsubmit="validateForm()">
    <div class="container">
    <?php include 'includes/navbar.php'; 
  
    ?>
       
        <?php include 'includes/sidebar.php'; ?>


     
 


        
        <div class="main">
    

            <div class="items1">
            <div style="background-color:white; text-align: center; margin-left:290px; margin-top:20px;
    width: 60%;padding-top:10px; color:red;
    /* height: 10%;"> 
   
                    <?php if(!empty($formError)){
					foreach($formError as $error){
				?>
                 <div class="col-sm-12 alert alert-danger text-center">
                <?php
				 echo $error;
				 ?>
             </div>
                <?php  } } else{echo "";}
				?>
                  
                </div>
       
                <div class="add2">
                    <div>
                        <h1>Categories</h1>
                        <div class="addbook">
                           
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                       

                            <div> <input type="text" id="categoriname" name="categoriname" 
                                    placeholder="Enter category name" value="<?php echo $name; ?>" />
                                    <span class="error"> <?php echo "*". $nameErr;?></span>
                                </div>
                                    
                        </div>
                      
                      
                    
                        <div class="addbook">
                        <?php if ($edit_state == false): ?>
                            <div> <button type="submit" name="add">Add</button></div>
                            <?php else: ?>
                                <div> <button type="submit" name="update">Update</button></div>
                                <!-- <button class="btn" type="submit" name="update" >Update</button> -->
                            <?php endif ?>
                          
                         
                        </div>
                    </div>
                </div>
               
            </div>

            <div class="deleteupdate items2">
                <div class="" style="width: 60%;
                /* margin-top: 5%; */
                 margin: auto; 
                text-align:start;
              
                height: 10%;
                background-color: #F4F1EA;">
                
                       
                        <div class="addbook2">
                            <div><label name="">Category</label></div>
                            <div style="margin-left: 20px;"><label name="">Action</label></div>
                           
                       
                        </div>
                      
                       
                 
                    
                </div>


                <!--  -->
                <div class="showall2">

                <?php
                    $sql = "SELECT * FROM category";
                    $query = $conn->query($sql);
                    while($row = $query->fetch_assoc()){
                        ?>
                  
                    <div class="addbook3" style="
                   border-bottom: 1px solid #cbcbcb;
                                margin:10px  auto; 
                            text-align:justify;
                            width: 60%;
                            height: 40px;
                            background-color: #ffff;">

                              <div class="rowaddbook3"><?php echo ucfirst($row['cattitle']) ; ?> </div>
                        



                                <div class="first">
                                
                                    <div style="padding-top:3px;">
                                    <a href="categories.php?edit=<?php echo $row["CategoryID"]; ?>" class="editbtnf" 
                                    style="
                                       margin-right: 5px; 
                                         box-sizing: border-box; border-radius: solid 1px green;

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
                                  
                                        <!-- <button class="firstbtn editf" type="button" id="
                                         <?php 
                                        //  echo $row['categories_id'];
                                         ?>
                                         " ><i class='fa fa-edit'></i> Edit</button>
                                                                         -->
                          <a href="categories.php?delete=<?php echo $row["CategoryID"]; ?>" class="editbtnf" 
                                    style="
                                                            margin-right: 5px; 
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

                                      <!-- <button class="secondbtn" type="button" id="
                                       " style=""><i class='fa fa-trash'></i> Delete</button> -->
                                    </div>
                                    
                                
                                    
                                </div>
                           

                   
                    </div>

<?php
   }
   ?>
                  

                </div>
                    <!--  -->
                    <!-- <hr class="hr" style=""> -->
            </div>





        </div>
    </div>
</form>
<script>
    function validateForm() {
       //location price capacity availability
  let categoriname = document.forms["myForm"]["categoriname"].value;


 


  if (categoriname == "") {
    alert("categoriname must be filled out");
    return false;
  }

 

}

        </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="chart1.js"></script>
</body>

</html>
