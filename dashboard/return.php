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
        <!-- <div class="topbar">
            <div class="logo">
                <h2>Open Library</h2>
            </div>
            <div class="search">
                <input type="text" id="search" aria-placeholder="search here">
                <label for="search"><i class="fas fa-search"></i></label>

            </div>
            <div class="imtop">
                <div style="margin-right: 5px;"> <i class="fas fa-bell"></i></div>
                <div class="user">
                    <img src="images/admin.png" />

                </div>
            </div>
        </div> -->
        <?php include 'includes/sidebar.php'; ?>
        <!-- <div class="sidebar">

            <div class="user2">
                <img class="user2admin" src="images/admin.png" />
                <div class="admin" >
                    <div class="admin2">Admin Admin</div>
                    <div class="admin2circle">
                        <div class="status-circle"></div>
                        <div class="online">Online</div>
                    </div>
                </div>
            </div>
            <ul>
                <li>
                    <a href="dashboard.html"><img src="images/home.png" />
                        <div>Home</div>
                    </a>
                </li>
                <li>
                    <a href="book.html"><img src="images/book2.png" />
                        <div>Books </div>
                    </a>
                </li>
                <li>
                    <a href="borrowbook.html"><img src="images/borrow2.png" />
                        <div>Borrow Book</div>
                    </a>
                </li>
                <li>
                    <a href="return.html"><img src="images/return.png" />
                        <div>Return</div>
                    </a>
                </li>
                <li>
                    <a href="room.html"><img src="images/room11.png" />
                        <div>Room</div>
                    </a>
                </li>

                <li>
                    <a href="categories.html"><img src="images/categories.png" />
                        <div>Categories</div>
                    </a>
                </li>
                <li>
                    <a href="student.html"><img src="images/student.png" />
                        <div>Student</div>
                    </a>
                </li>
            
              
            </ul>
        </div> -->
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
                            <div><label name="">ISBN</label></div>
                            <div><label name="">Title</label></div>
                       
                        </div>
                      
                       
                 
                    
                </div>
                <div class="showall2">
                
                       
                    <div class="addbook3">
                        
                        <div class="rowaddbook3"  >23/5/2024</div>
                        <div class="rowaddbook3" ><label name="">20</label></div>
                        <div class="rowaddbook3"><label name="">amal</label></div>
                        <div class="rowaddbook3"> <label name="">999999</label></div>
                        <div class="rowaddbook3"><label name="">Lovely Bones</label></div>
                        

                        
                        
                        
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
                
            </div>

                </div>
          

            <!-- </div> -->





        </div>
    </div>
</form>
<script>
    function validateForm() {
       
  let studentid = document.forms["myForm"]["studentid"].value;
  let name = document.forms["myForm"]["name"].value;
  let isbn = document.forms["myForm"]["isbn"].value;
  let title = document.forms["myForm"]["title"].value;

  let price = document.forms["myForm"]["price"].value;
  let stockLevel = document.forms["myForm"]["stockLevel"].value;

  if (studentid == "") {
    alert("studentid must be filled out");
    return false;
  }
  if (name == "") {
    alert("ISBN must be filled out");
    return false;
  }

  if (isbn == "") {
    alert("isbn must be filled out");
    return false;
  }
  if (title == "") {
    alert("title must be filled out");
    return false;
  }
 

}
</script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="chart1.js"></script>
</body>

</html>
