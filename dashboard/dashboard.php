<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
        integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />
    <title>Dashboard</title>
</head>

<body>
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
            <div class="imtop" >
                <div style="margin-right: 5px;"> <i class="fas fa-bell"></i></div>
                <div class="user">
                    <img src="images/admin.png" />

                </div>
            </div>
        </div> -->
        <?php include 'includes/sidebar.php'; ?>
        
        <div class="main2">
            <div class="myDIV">
                
                <div class="cards">
                    <div class="card card2">
                        <div class="card-content">
                            <div class="number">10</div>
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
                        <div class="image-box"><img src="images/return.jpg"></div>
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
                <div class="borrowers">
                    <h3 class="today">Today Dues</h3>
                    <div class="mydiv2">
                        <div class="item1">Book Name</div>
                        <div class="item1">Borrower Name</div>
                        <div class="item1">Date Borrow</div>
                        <div class="item1">Contact</div>

                    </div>

                </div>
                <div class="gray">
                    No Dues For Today
                </div>
                <div class="mydiv2">
                    <div class="item1">Book Name</div>
                    <div class="item1">Borrower Name</div>
                    <div class="item1">Date Borrow</div>
                    <div class="item1">Contact</div>

                </div>
                <div class="showing">
                    <div class="left">Showing 1 to 1 of entries</div>
                    <div class="right">
                        <div class="prev">
                            <div class="bttn"><button type="button" class="button">Previous</button></div>
                            <div class="num2">1</div>
                            <div class="bttn"><button type="button" class="button">Next</button></div>
                        </div>

                    </div>
                </div>
                <div class="gray2">

                </div>


            </div>


            <div class="chart1">
                <div class="borrower">
                    <div class="borrowers">
                        <h3 class="today2">Tomorrow Dues</h3>
                        <div class="mydiv3">
                            <div class="item1">Book Name</div>
                            <div class="item1">Borrower Name</div>
                            <div class="item1">Date Borrow</div>


                        </div>

                    </div>
                    <div class="gray3">
                        No Dues For Today
                    </div>
                    <div class="mydiv3">
                        <div class="item1">Book Name</div>
                        <div class="item1">Borrower Name</div>
                        <div class="item1">Date Borrow</div>


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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="chart1.js"></script>
</body>

</html>
