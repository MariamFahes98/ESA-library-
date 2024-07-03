<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
        integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />
    <title>Borrow Books</title>
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
           
            <div class="main">


                <div class="items1">
                    <div class="add">
                        <div>
                            <h1>ADD BORROW BOOK</h1>
                            <div class="addbook">
                                <div> <input type="text" id="studentid" name="studentid" value="" required
                                        placeholder="Enter student ID" /></div>
                                <div> <input type="text" id="name" name="name" value="" required
                                        placeholder="Enter student name" /></div>
                            </div>
                            <div class="addbook">
                                <div> <input type="number" id="isbn" name="isbn" value="" required
                                        placeholder="Enter ISBN" /></div>
                                <div> <input type="text" id="title" name="title" value="" required
                                        placeholder="Enter book title" /></div>
                            </div>


                            <div class="addbook">
                                <div> <button type="submit">Borrow Book</button></div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="deleteupdate items2">
                    <div class="showall">


                        <div class="addbook2">
                            <div><label name="">Date</label></div>
                            <div><label name="">Student ID</label></div>
                            <div><label name="">Student Name</label></div>
                            <div><label name="">ISBN</label></div>
                            <div><label name="">Title</label></div>

                            <div><label name="">Status</label></div>
                        </div>





                    </div>
                    <div class="showall2">


                        <div class="addbook3">

                            <div class="rowaddbook3">23/5/2024</div>
                            <div class="rowaddbook3"><label name="">20</label></div>
                            <div class="rowaddbook3"><label name="">amal</label></div>
                            <div class="rowaddbook3"> <label name="">999999</label></div>
                            <div class="rowaddbook3"><label name="">Lovely Bones</label></div>



                            <div class="first" >

                                <div>
                                    <button type="button" class="first2" style="">returned</button>


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

                    </div>

                </div>





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
 
</body>

</html>
