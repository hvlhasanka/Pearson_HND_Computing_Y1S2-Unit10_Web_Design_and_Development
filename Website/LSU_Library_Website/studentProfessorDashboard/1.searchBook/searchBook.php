<!-- Code Developed and Maintained by Hewa Vidanage Lahiru Hasanka -->

<?php
  // Starts the SESSION period
  session_start();

  // Checks if the SEESION variables are already assigned and if the membershipType is studet (65350001) or professor (65350002)
  if (!isset($_SESSION['username']) || !isset($_SESSION['membershipType']) || $_SESSION['membershipType'] == "65350003") {
    header("location: ../../logout.php");
  }

  $userUsername = $_SESSION['username'];

  // Retrieving code block for MySQL database connection
  include_once("../../LSULibraryDBConnection.php");

  // Retrieving code block to check if the book reserve time period has exceeded or not
  include_once("../../checkBookReserveTimePeriod.php");



  // Retrieving the UserID of the currently logged in account
  $userIDDBSQL = "SELECT UserID FROM User u
                  INNER JOIN Login l ON l.LoginID = u.lLoginID
                  WHERE l.Username = '$userUsername';";
  $userIDDBResult = mysqli_query($databaseConn, $userIDDBSQL);
  $userIDDBRow = mysqli_fetch_array($userIDDBResult);
  $userID = $userIDDBRow["UserID"];

  // Process of reserving a book
  if(isset($_GET['reserveisbn'])){

    $ISBN = $_GET['reserveisbn'];

    // Retrieving the current datetime
    date_default_timezone_set('Asia/Colombo');
    $currentDate = date('Y-m-d h:i:s', time());

    $reserveSQL = "UPDATE Book SET baAvailabilityID = 55240004, ReserveDateTime = '$currentDate',
                  uUserID_ReservedBy = '$userID' WHERE ISBN = '$ISBN';";
    mysqli_query($databaseConn, $reserveSQL);

    ?> <script>
      alert("Book has been reserved for 24 hours.\nEligible to borrow within next 24 hours");
    </script> <?php

    echo "<script> location.href='searchBook.php'; </script>";
  }

  // Process of borrowing a book
  if(isset($_GET['borrowisbn'])){

    $ISBN = $_GET['borrowisbn'];

    // Adding new record into BookBorrow Table
    $bookBorrowSQL = "INSERT INTO BookBorrow (ReturnDateTime) VALUES ('NULL');";
    mysqli_query($databaseConn, $bookBorrowSQL);

    // Retrieving the BorrowID of the newly added record
    $borrowIDSQL = "SELECT BorrowID FROM BookBorrow ORDER BY BorrowDateTime DESC LIMIT 1;";
    $borrowIDResult = mysqli_query($databaseConn, $borrowIDSQL);
    $borrowIDRow = mysqli_fetch_array($borrowIDResult);
    $borrowID = $borrowIDRow['BorrowID'];

    // Retrieving the UserID and UniversityNo from UniversityMember table
    $memberSQL = "SELECT um.uUserID, um.UniversityNo FROM UniversityMember um
                  INNER JOIN User u ON u.UserID = um.uUserID
                  INNER JOIN Login l ON l.LoginID = u.lLoginID
                  WHERE l.Username = '$userUsername';";
    $memberResult = mysqli_query($databaseConn, $memberSQL);
    $memberRow = mysqli_fetch_array($memberResult);
    $userID = $memberRow['uUserID'];
    $universityNo = $memberRow['UniversityNo'];

    // Inserting record into Borrow Table
    $borrowSQL = "INSERT INTO Borrow VALUES ('$userID', '$universityNo', '$ISBN', '$borrowID')";
    mysqli_query($databaseConn, $borrowSQL);

    // Updating Book Table
    $borrowBook = "UPDATE Book SET baAvailabilityID = 55240005, ReserveDateTime = NULL, uUserID_ReservedBy = NULL WHERE ISBN = '$ISBN';";
    mysqli_query($databaseConn, $borrowBook);

    ?> <script>
      alert("Book has been set to borrow. Borrow duration is 2 Weeks. After 2 weeks a fine will be charged daily.");
    </script> <?php

    echo "<script> location.href='searchBook.php'; </script>";
  }




?>

<!DOCTYPE html>
<html>
  <head>
    <title> LSU Library - Dashboard </title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/png" sizes="1500x1500" href="../../assets/images/LSULibraryLogo.png">

    <!-- Retrieving default layout style sheet -->
    <link rel="stylesheet" href="../../assets/css/defaultLayout.css">

    <!-- Retrieving font-awesome library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
    <script src="../../assets/bootstrap/js/jquery.min.js"></script>
    <script src="../../assets/bootstrap/js/popper.min.js"></script>
    <script src="../../assets/bootstrap/js/bootstrap.min.js"></script>

    <!-- jQuery to enable the popover implementation -->
    <script>
      $(document).ready(function(){
        $('[data-toggle="popover"]').popover();
      });
    </script>


  </head>
  <body>
    <!-- MAIN SECTION - Begin -->
        <!-- HEADER SECTION - Begin -->
        <div style="height: 140px; width: 100%;">
              <div id="logoSection">

                <a href="../studentProfessorDashboard.php">
                  <img src="../../assets/Images/LSULibraryLogo.png" alt="LSU Library Logo" id="lsuLibraryLogoIcon">
                </a>

                <h1 id="mainTitle"> LSU <span id="mainTitleSpan">Library</span> </h1>

                <p id="mainTitleSub">Lowa State University</p>

                <img src="../../assets/Images/LSUUniversityLogo.png" alt="LSU Logo" id="lsuLogoIcon">

              </div>

              <table id="navSection">
                <tr>
                  <td class="navItem" id="navItem1">
                    <a href="
                    <?php
                      if($_SESSION['membershipType'] == '65350001'){
                        echo "../3.accountDetails/studentAccountDetails.php";
                      }
                      else if($_SESSION['membershipType'] == '65350002'){
                        echo "../3.accountDetails/professorAccountDetails.php";
                      }
                    ?>
                    " data-toggle="popover" data-trigger="hover" data-placement="bottom" title="Options"
                    data-content="View Account Details" style="color: black;">
                      <?php echo $_SESSION['username']; ?> &nbsp
                      <i class="fa fa-bars" style="font-size: 32px;
                                                  color: #00B1D2FF;"></i> &nbsp
                    </a>
                  </td>

                  <td class="navItem" id="navItem2">
                    <a href="../../logout.php">Logout</a>
                  </td>
                </tr>
              </table>

        </div>

        <!-- HEADER SECTION - End -->


        <!-- BODY SECTION - Begin -->
          <!-- NavBar - Begin -->
            <div style="background-color: #004182;
                        width: 100%;
                        height: 160px;">
              <p style="font-size: 30px;
                        color: white;
                        text-align: center;
                        padding-top: 10px;"><?php
                                              if($_SESSION['membershipType'] == '65350001'){
                                                echo "Student";
                                              }
                                              else if($_SESSION['membershipType'] == '65350002'){
                                                echo "Professor";
                                              }
                                            ?> Dashboard</p>
              <!-- Spinner -->
              <div style="position: absolute;
                          left: 50%;
                          transform: translate(-50%,-0%);">
                <div class="spinner-grow text-light" style="height: 80px;
                                                            width: 80px;">
                </div>
              </div>
            </div>

            <nav class="navbar navbar-expand-sm bg-dark navbar-dark" style="height: 60px;">
              <ul class="navbar-nav" style="text-align: center;
                                            position: absolute;
                                            left: 50%;
                                            transform: translate(-50%,-0%);
                                            font-size: 20px;">
                <li class="nav-item">
                  <a class="nav-link" href="../studentProfessorDashboard.php">Home</a>
                </li>
                <li class="nav-item active">
                  <a class="nav-link" href="searchBook.php">Search Book</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="../2.returnBook/returnBook.php">Return Book</a>
                </li>
              </ul>
            </nav>

            <style>
              nav li{
                margin-left:30px;
                margin-right:30px;
                width: 160px;
              }
            </style>
          <!-- NavBar - End -->

          <!-- Outer Background -->
          <div style="width: 100%;
                      height: 940px;
                      background-color: #F6F6F6;">

            <div style="width: 70%;
                        height: 510px;
                        background-color: #FFFFFF;
                        border-radius: 10px;
                        position: relative;
                        left: 50%;
                        transform: translateX(-50%);
                        top: 20px;">

              <style>
                #container{
                  height: 1000px;
                  width: 80%;
                  position: absolute;
                  top: 125px;
                  left: 30%;
                  transition: translateX(-70%);
                }

                .formText{
                  font-size: 18px;
                }

                .formInput{
                  padding: 10px;
                  border-radius: 5px;
                  border: 1px solid #CCC;
                  width: 340px;
                }

                #searchBookSubmit{
                  padding: 5px;
                  border-radius: 5px;
                  background-color: #0081FF;
                  color: #FFFFFF;
                  width: 350px;
                  height: 50px;
                  border: 1px solid #0081FF;
                  font-size: 20px;
                  margin-left: 78px;
                  margin-top: 20px;
                }

                #viewBook{
                  padding: 7px;
                  border-radius: 5px;
                  background-color: #0081FF;
                  color: #FFFFFF;
                  width: 180px;
                  height: 50px;
                  border: 1px solid #0081FF;
                  font-size: 20px;
                  position: absolute;
                  top: 36px;
                  left: 550px;
                }

              </style>

              <!-- Main Container -->
              <div id="container">

                <p style="font-size: 24px;
                          position: absolute;
                          top: -80px;
                          left: -10px;"><b>Search for a book</b></p>

                <form method="POST" action="viewBook.php">

                  <p class="formText">Book ISBN:
                    <input type="text" name="bookISBN" placeholder="ISBN" class="formInput" style="margin-left: 58px;">
                  </p>

                  <p class="formText">Book Name:
                    <input type="text" name="bookName" placeholder="Name" class="formInput" style="margin-left: 48px;">
                  </p>

                  <p class="formText">Book Author:
                    <input type="text" name="bookAuthor" placeholder="Author" class="formInput" style="margin-left: 40px;">
                  </p>

                  <p class="formText">Book Category:
                    <select class="formInput" name="bookCategory" style="margin-left: 22px;">
                      <option value="NULL">Category</option>
                      <?php
                        $categorySQL = "SELECT * FROM BookCategory;";
                        $categoryResult = mysqli_query($databaseConn, $categorySQL);
                        while($categoryRow = mysqli_fetch_array($categoryResult)){
                          ?><option value="<?php echo $categoryRow['CategoryID']; ?>"><?php echo $categoryRow['Category']; ?></option>
                        <?php } ?>
                    </select>
                  </p>

                  <button type="submit" name="searchSubmit" id="searchBookSubmit">Search Book</button>


                </form>
              </div>


              <div style="width: 70%;
                          height: 120px;
                          background-color: #FFFFFF;
                          border-radius: 10px;
                          position: relative;
                          left: 50%;
                          transform: translateX(-50%);
                          top: 560px;">

                <p style="font-size: 24px;
                          position: absolute;
                          top: 40px;
                          left: 90px;"><b>View all Available and Reserved Books</b></p>

                <button type="button" name="viewAllBooks" id="viewBook" data-toggle="modal" data-target="#viewBooks">Click Here</button>


              </div>


          </div>


          <!-- View All Available and Reserved Books Modal -->
          <div class="modal fade" id="viewBooks">
            <div class="modal-dialog modal-dialog-scrollable" style="max-width: 95%;">
              <div class="modal-content">

                <!-- Modal - Header -->
                <div class="modal-header">
                  <h4 class="modal-title">All Available and Reserved Books</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal - Body -->
                <div class="modal-body">

                  <?php
                  // Retrieving loginID for this logged in user
                  $loginIDDBSQL = "SELECT LoginID FROM Login WHERE Username  = '$userUsername';";
                  $loginIDDBResult = mysqli_query($databaseConn, $loginIDDBSQL);
                  $loginIDDBRow = mysqli_fetch_array($loginIDDBResult);
                  $loginIDDB = $loginIDDBRow["LoginID"];

                  // Checking if the account status (member status) is active
                  $accountStatusSQL = "SELECT mms.MemberStatus FROM MemberMemberStatus mms
                                      INNER JOIN UniversityMember um ON um.mmsMemberStatusID = mms.MemberStatusID
                                      INNER JOIN User u ON u.UserID = um.uUserID
                                      WHERE u.lLoginID = '$loginIDDB';";
                  $accountStatusResult = mysqli_query($databaseConn, $accountStatusSQL);

                  $accountStatus = "";

                  while($accountStatusRow = mysqli_fetch_array($accountStatusResult)){
                    $accountStatus = $accountStatusRow["MemberStatus"];
                  }

                  // Checking if this logged in user is an authorized user (active) to check book availability, anf reserve a book
                  if($accountStatus == "Active"){





                    // Retrieving details of all available books
                    $bookSQL = "SELECT b.ISBN, b.Name, bc.Category, ba.Availability, b.ReserveDateTime, b.uUserID_ReservedBy, b.RegisteredDateTime FROM Book b
                                INNER JOIN BookAvailability ba ON ba.AvailabilityID = b.baAvailabilityID
                                INNER JOIN BookCategory bc ON bc.CategoryID = b.bcCategoryID
                                WHERE ba.Availability = 'Available' OR ba.Availability = 'Reserved' ORDER BY RegisteredDateTime DESC;";

                    $bookResult = mysqli_query($databaseConn, $bookSQL);
                  ?>


                  <table class="table table-hover fixed_header" style="border-radius: 10px;">
                    <thead>
                      <tr>
                        <th> ISBN </th>
                        <th> Name </th>
                        <th> Author Name </th>
                        <th> Category </th>
                        <th> Availability </th>
                        <th> Reserved Date Time </th>
                        <th> Action </th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php
                          while($bookRow = mysqli_fetch_array($bookResult)){
                            $ISBN = $bookRow["ISBN"];
                        ?>
                      <tr>
                        <td title="ISBN"><?php echo $ISBN ?></td>
                        <td title="Book Name"><?php echo $bookRow["Name"]; ?></td>

                          <?php
                            // Retrieving the author names of the book
                            $bookAuthorSQL = "SELECT Author FROM BookAuthor WHERE bISBN = '$ISBN';";
                            $bookAuthorResult = mysqli_query($databaseConn, $bookAuthorSQL);
                            $bookAuthorRowCount = mysqli_num_rows($bookAuthorResult);
                            // Implemention if there is only one author name
                            if($bookAuthorRowCount == 1){
                              while($bookAuthorRow = mysqli_fetch_array($bookAuthorResult)){
                                ?><td  title="Book Author"><?php echo $bookAuthorRow["Author"]; ?></td><?php
                              }
                            }
                            // Implemention if there are two author names
                            else if($bookAuthorRowCount == 2){
                              $bookAuthor = [];

                              while($bookAuthorRow = mysqli_fetch_array($bookAuthorResult)){
                                $bookAuthor[] = $bookAuthorRow["Author"];
                              }

                              ?><td  title="Book Author"><?php echo $bookAuthor[0]." & ".$bookAuthor[1]; ?></td><?php
                            }
                          ?>

                        <td title="Category"><?php echo $bookRow["Category"]; ?></td>

                        <td title="Availability"><?php echo $bookRow["Availability"]; ?></td>

                        <td title="Reserved Date Time"><?php echo $bookRow["ReserveDateTime"]; ?></td>

                        <td>
                            <?php
                              if($bookRow["Availability"] == "Available"){
                            ?>
                            <a href="viewBook.php?reserveisbn=<?php echo $ISBN ?>" onClick="return confirm('Are you sure you want to reserve this book? \n(Reserved Time Period 24 hours)')">Reserve</a>
                          | <a href="viewBook.php?borrowisbn=<?php echo $ISBN ?>" onClick="return confirm('Are you sure you want to borrow this book?')">Borrow</a>
                            <?php }
                              else if($bookRow["Availability"] == "Reserved" && $bookRow["uUserID_ReservedBy"] == $userID){
                            ?>
                              <a href="viewBook.php?borrowisbn=<?php echo $ISBN ?>" onClick="return confirm('Are you sure you want to borrow this book?')">Borrow</a>
                            <?php } ?>
                        </td>
                      </tr>
                        <?php } ?>
                    </tbody>
                  </table>

                  <?php
                    }
                    else{
                      echo "Account is currently $accountStatus, please contact librarian to resolve this and access these features.";
                    }
                  ?>

                </div>

              </div>
            </div>
          </div>




        </div>

        <!-- BODY SECTION - End -->


        <!-- FOOTER SECTION - Begin -->
          <div id="footer">

            <div id="footerLogoSection">

              <img src="../../assets/images/LSULibraryLogo.png" alt="LSU Library Logo" id="lsuLibraryLogoIcon">

              <h1 id="mainTitle"> LSU <span id="mainTitleSpan">Library</span> </h1>

              <p id="mainTitleSub">Lowa State University</p>

              <img src="../../assets/images/LSUUniversityLogo.png" alt="LSU Logo" id="lsuLogoIcon">

            </div>

            <p id="footerText1Main">LSU Library - <span id="footerText1Sub">Lowa State University</span> &copy; 2020</p>
          </div>
        <!-- FOOTER SECTION - End -->

    <!-- MAIN SECTION - End -->
  </body>
</html>
