<?php

session_start();
include 'includes/conn.php';
// $nonav='';// 3ashan ma tezhar lnavbar [heik 7attin bi malaf l init.php]
// if(isset($_SESSION['email']))
// {
// 	header("Location:index.php");
// }
// include 'init.php';

if($_SERVER['REQUEST_METHOD']=='POST'){//law ltalab l server jeyi 3an tari2 l post,fina n7ot if(isset($_POST['s']))
	$email= $_POST['email'] ;
	 $pass=$_POST['pass'];
	 
   

     $sql = "SELECT UserID,name, email , role
      FROM user
   WHERE email='$_POST[email]' and password='$_POST[pass]';";
     // WHERE borrowing.ReturnDate IS NOT NULL
     $result = mysqli_query($conn, $sql);
     
     if (mysqli_num_rows($result) > 0) {

     	  while ($row = mysqli_fetch_assoc($result)) {
       
		 $_SESSION['email']=$row['email'];

         $_SESSION["name"] = $row['name'];
         $_SESSION["roles"] = $row['role'];
		 $_SESSION['uid']=$row['UserID'];
      
            if($row['role'] == 1 )
        {
            // echo $row['role'];
            header("Location: dashboard.php");
        }else {
        
            header("Location: index.php");
        }
       
		//  header('location:dashboard.php');
     }
    } else {
      echo "error";
    }
    
    mysqli_close($conn);    
    //      if ($result->num_rows > 0) {
    //     $row = $result->fetch_assoc();
    //     session_start();
    //     $_SESSION["userName"] = $row['userName'];
    //     $_SESSION["roles"] = $row['roles'];

    //     $row['roles'] === 1 ?
    //         header("Location: ./admin/index.php") :
    //         header("Location: ./index.php");
    // } else {
    //     echo "the user name doesn't exist";
    //     // header("Location: ./index.php");
    // }




    //      // Output data of each row
    //      while ($row = mysqli_fetch_assoc($result)) {
    //          // $retuneddate = $row['borreturn'];	
    //          // $returded = ($retuneddate == NULL) ? " notreturned" : $retuneddate;
           
	//  $count=$stmt->rowCount();
	//  if($count >0){
	// 	 $_SESSION['email']=$email;
	// 	 $_SESSION['uid']=$get['user_id'];
	// 	 header('location:index.php');
	//  }
}

?>
<section class="login-page">
<div class="container">
	<div class="col-sm-offset-3 col-sm-6"><!--  ya3ni 3 mn l shmal masa7et 3 w 6 masa7et el div -->
    	<div class="login-form">
        	<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" class="form-horizontal"><!--fina n7ot action="login.php" -->
            	<div class="form-group">
                 <label>email</label>
                 <input class="form-control" type="text" name="email" placeholder="type your email"/>
                </div>
             	<div class="form-group">
                <label>password</label>
              <input class="form-control" type="password" name="pass" placeholder="type your password" />
                </div>
                <div class="form-group">
              <button class="form-control login-btn" name="s" type="submit"> Login</button>
            	</div>
            </form>
            <div class="form-group">
            <a style="text-decoration:none;" class="sign-up-link" href="sign-up.php">انشاء حساب جديد</a>
            </div>
        </div>
    
    </div>

</div>
</section>