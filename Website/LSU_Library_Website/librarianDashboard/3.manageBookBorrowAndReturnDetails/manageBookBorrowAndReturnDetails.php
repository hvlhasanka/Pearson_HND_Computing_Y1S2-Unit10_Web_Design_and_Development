<?php
  // Starts the SESSION period
  session_start();

  // Checks if the SEESION variables are already assigned and if the membershipType is Librarian (65350003)
  if (!isset($_SESSION['username']) || !isset($_SESSION['membershipType']) || $_SESSION['membershipType'] != "65350003") {
    header("location: ../../logout.php");
  }

  include_once("../../LSULibraryDBConnection.php");

  // Add New Book Process
  if(isset($_POST['addBookSubmit'])){

    $ISBN = $_POST['isbn'];
    $Name = $_POST['name'];
    $author1 = $_POST['author1'];
    $author2 = $_POST['author2'];
    $bookCategoryType = $_POST['bookCategorySelect'];
    $bookAvailabilityType = $_POST['bookAvailabilitySelect'];

    if (empty($ISBN) || empty($Name) || empty($author1) || $bookCategoryType == "NULL" || $bookAvailabilityType == "NULL"){
      if(empty($ISBN)){
        ?> <script>
          alert("ERROR: ISBN field is not filled.");
        </script> <?php
      }
      if(empty($Name)){
        ?> <script>
          alert("ERROR: Book Name field is not filled.");
        </script> <?php
      }
      if(empty($author1)){
        ?> <script>
          alert("ERROR: First Author Name field is not filled.");
        </script> <?php
      }
      if($bookCategoryType == "NULL"){
        ?> <script>
          alert("ERROR: Book category was not selected");
        </script> <?php
      }
      if($bookAvailabilityType == "NULL"){
        ?> <script>
          alert("ERROR: Book availability was not selected");
        </script> <?php
      }
    }
    else{
      // Checking if this book is already available in the database
      $bookISBNSQL = "SELECT * FROM Book WHERE ISBN = '$ISBN'";

      $bookISBNResult = mysqli_query($databaseConn, $bookISBNSQL);

      $bookISBNCount = mysqli_num_rows($bookISBNResult);

      if($bookISBNCount == 0){

        // Adding record into Book table
        $bookSQL = "INSERT INTO Book (ISBN, Name, bcCategoryID, baAvailabilityID) VALUES
                    ('$ISBN', '$Name', '$bookCategoryType', '$bookAvailabilityType');";

        $bookResult = mysqli_query($databaseConn, $bookSQL);

        if(empty($author2)){
          // Adding (first author) record into BookAuthor table
          $bookAuthor1SQL = "INSERT INTO BookAuthor VALUES ('$ISBN', '$author1');";

          $bookAuthor1Result = mysqli_query($databaseConn, $bookAuthor1SQL);
        }
        else if(!empty($author2)){
          // Adding (first author) record into BookAuthor table
          $bookAuthor1SQL = "INSERT INTO BookAuthor VALUES ('$ISBN', '$author1');";

          $bookAuthor1Result = mysqli_query($databaseConn, $bookAuthor1SQL);

          // Adding (second author) record into BookAuthor table
          $bookAuthor2SQL = "INSERT INTO BookAuthor VALUES ('$ISBN', '$author2');";

          $bookAuthor2Result = mysqli_query($databaseConn, $bookAuthor2SQL);
        }

        ?> <script>
          alert("Book has been successfully added.");
        </script> <?php

        echo "<script> location.href='manageBooks.php'; </script>";

      }

      else{
        ?> <script>
          alert("Book is already added");
        </script> <?php
      }

    }
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

                <img src="../../assets/Images/LSULibraryLogo.png" alt="LSU Library Logo" id="lsuLibraryLogoIcon">

                <h1 id="mainTitle"> LSU <span id="mainTitleSpan">Library</span> </h1>

                <p id="mainTitleSub">Lowa State University</p>

                <img src="../../assets/Images/LSUUniversityLogo.png" alt="LSU Logo" id="lsuLogoIcon">

              </div>

              <table id="navSection">
                <tr>
                  <td class="navItem" id="navItem1">
                    <a href="" data-toggle="popover" data-trigger="hover" data-placement="bottom" title="Options"
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
            <div style="background-color: #3498DB;
                        width: 100%;
                        height: 160px;">
              <p style="font-size: 30px;
                        color: white;
                        text-align: center;
                        padding-top: 10px;">Librarian Dashboard</p>
              <!-- Spinner -->
              <div style="position: absolute;
                          left: 50%;
                          transform: translate(-50%,-0%);">
                <div class="spinner-grow text-light" style="height: 80px;
                                                            width: 80px;">
                </div>
              </div>
            </div>


            <nav class="navbar navbar-expand-sm bg-dark navbar-dark" style="height: 100px;">
              <ul class="navbar-nav" style="text-align: center;
                                            position: absolute;
                                            left: 50%;
                                            transform: translate(-50%,-0%);
                                            font-size: 20px;">
                <li class="nav-item">
                  <a class="nav-link" href="../librarianDashboard.php">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="../1.manageBooks/manageBooks.php">Manage Books</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="../2.manageBookCatalog/manageBookCatalog.php">Manage Book Catalogs</a>
                </li>
                <li class="nav-item active">
                  <a class="nav-link" href="manageBookBorrowAndReturnDetails.php">Manage Borrow and Returning Details</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">Manage Member Details</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">Calculate Late Fine</a>
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
                      height: 1600px;
                      background-color: #F6F6F6;">

            <!-- Book Borrow Details Section -->
            <div style="width: 85%;
                        height: 700px;
                        background-color: #FFFFFF;
                        border-radius: 10px;
                        position: relative;
                        left: 50%;
                        transform: translateX(-50%);
                        top: 20px;">

              <p style="font-size: 20px;
                        padding-left: 30px;
                        padding-top: 20px;"><b>Book Borrow Details</b></p>

              <div style="width: 95%;
                          height: 600px;
                          background-color: white;
                          position: absolute;
                          left: 50%;
                          transform: translateX(-50%);
                          overflow-y: scroll;">

                <!-- Retrieving details of the existing books from the database -->
                <?php
                  $bookDetailsSQL = "SELECT l.Username, u.FirstName, u.LastName, b.ISBN, bb.BorrowDateTime, mms.MemberStatus, mmt.MembershipType FROM Login l
                                    INNER JOIN User u ON u.lLoginID = l.LoginID
                                    INNER JOIN UniversityMember um ON um.uUserID = u.UserID
                                    INNER JOIN MemberMemberStatus mms ON mms.MemberStatusID = um.mmsMemberStatusID
                                    INNER JOIN MemberMembershipType mmt ON mmt.MembershipTypeID = um.mmtMembershipTypeID
                                    INNER JOIN Borrow br ON br.umUserID = um.uUserID
                                    INNER JOIN BookBorrow bb ON bb.BorrowID = br.bbBorrowID
                                    INNER JOIN Book b ON b.ISBN = br.bISBN
                                    INNER JOIN BookAvailability ba ON ba.AvailabilityID = b.baAvailabilityID
                                    WHERE ba.Availability = 'Borrowed';";

                  $bookDetailsResult = mysqli_query($databaseConn, $bookDetailsSQL);

                ?>

                <table class="table table-hover fixed_header" style="border-radius: 10px;">
                  <thead>
                    <tr>
                      <th> Username </th>
                      <th> First Name </th>
                      <th> Last Name </th>
                      <th> Membership Type </th>
                      <th> Member Status </th>
                      <th> Book ISBN </th>
                      <th> Borrow DateTime </th>
                      <th> Expected Return DateTime </th>
                      <th> Modification </th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                        while($bookDetailsRow = mysqli_fetch_array($bookDetailsResult)){

                      ?>
                    <tr>
                      <td title="Username"><?php echo $bookDetailsRow["Username"]; ?></td>
                      <td title="First Name"><?php echo $bookDetailsRow["FirstName"]; ?></td>
                      <td title="Last Name"><?php echo $bookDetailsRow["LastName"]; ?></td>
                      <td title="Membership Type"><?php echo $bookDetailsRow["MembershipType"]; ?></td>
                      <td title="Member Status"><?php echo $bookDetailsRow["MemberStatus"]; ?></td>
                      <td title="Book ISBN"><?php echo $bookDetailsRow["ISBN"]; ?></td>

                      <?php $borrowDateTime = $bookDetailsRow["BorrowDateTime"]; ?>

                      <td title="Borrow DateTime"><?php echo $borrowDateTime ?></td>

                      <?php
                      $bookReturnDuration = strtotime("+14 day", strtotime($borrowDateTime));

                      $expectedBookReturnDateTime = date("Y-m-d h:i:s", $bookReturnDuration);
                      ?>

                      <td title="Expected Return DateTime"><?php echo $expectedBookReturnDateTime ?></td>






                      <td>
                          <a href="updateBookDetails.php?isbn=<?php echo $ISBN ?>"> Edit </a>
						            | <a href="deleteBook.php?isbn=<?php echo $ISBN ?>"
                          onClick="return confirm('This book and along with connections to this book will be removed.\nAre you such you want to continue?')">
                          Remove
                        </a>
                      </td>
                    </tr>
                      <?php } ?>
                  </tbody>
                </table>
              </div>

            </div>




            <!-- Book Return Details Section -->
            <div style="width: 85%;
                        height: 700px;
                        background-color: #FFFFFF;
                        border-radius: 10px;
                        position: relative;
                        left: 50%;
                        transform: translateX(-50%);
                        top: 50px;">

              <p style="font-size: 20px;
                        padding-left: 30px;
                        padding-top: 20px;"><b>Book Return Details</b></p>

              <div style="width: 95%;
                          height: 600px;
                          background-color: white;
                          position: absolute;
                          left: 50%;
                          transform: translateX(-50%);
                          overflow-y: scroll;">

                <!-- Retrieving details of the existing books from the database -->
                <?php
                  $bookDetailsSQL = "SELECT l.Username, u.FirstName, u.LastName, b.ISBN, bb.BorrowDateTime, bb.ReturnDateTime, mms.MemberStatus, mmt.MembershipType FROM Login l
                                    INNER JOIN User u ON u.lLoginID = l.LoginID
                                    INNER JOIN UniversityMember um ON um.uUserID = u.UserID
                                    INNER JOIN MemberMemberStatus mms ON mms.MemberStatusID = um.mmsMemberStatusID
                                    INNER JOIN MemberMembershipType mmt ON mmt.MembershipTypeID = um.mmtMembershipTypeID
                                    INNER JOIN Borrow br ON br.umUserID = um.uUserID
                                    INNER JOIN BookBorrow bb ON bb.BorrowID = br.bbBorrowID
                                    INNER JOIN Book b ON b.ISBN = br.bISBN
                                    INNER JOIN BookAvailability ba ON ba.AvailabilityID = b.baAvailabilityID
                                    WHERE ba.Availability != 'Borrowed';";

                  $bookDetailsResult = mysqli_query($databaseConn, $bookDetailsSQL);

                ?>

                <table class="table table-hover fixed_header" style="border-radius: 10px;">
                  <thead>
                    <tr>
                      <th> Username </th>
                      <th> First Name </th>
                      <th> Last Name </th>
                      <th> Membership Type </th>
                      <th> Member Status </th>
                      <th> Book ISBN </th>
                      <th> Borrow DateTime </th>
                      <th> Return DateTime </th>
                      <th> Borrow Duration </th>
                      <th> Modification </th>
                      <th> Calculate Late Fine </th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                        while($bookDetailsRow = mysqli_fetch_array($bookDetailsResult)){
                          $ISBN = $bookDetailsRow["ISBN"];
                      ?>
                    <tr>
                      <td title="Username"><?php echo $bookDetailsRow["Username"]; ?></td>
                      <td title="First Name"><?php echo $bookDetailsRow["FirstName"]; ?></td>
                      <td title="Last Name"><?php echo $bookDetailsRow["LastName"]; ?></td>
                      <td title="Membership Type"><?php echo $bookDetailsRow["MembershipType"]; ?></td>
                      <td title="Member Status"><?php echo $bookDetailsRow["MemberStatus"]; ?></td>
                      <td title="Book ISBN"><?php echo $ISBN ?></td>
                      <td title="Borrow DateTime"><?php echo $bookDetailsRow["BorrowDateTime"]; ?></td>
                      <td title="Return DateTime"><?php echo $bookDetailsRow["ReturnDateTime"]; ?></td>

                      <?php

                        $borrowDateTime = strtotime($bookDetailsRow["BorrowDateTime"]);
                        $returnDateTime = strtotime($bookDetailsRow["ReturnDateTime"]);

                        // Substracting the ReturnDateTime and BorrowDateTime, returned in seconds
                        $bookBorrowDurationSecs = $returnDateTime - $borrowDateTime;

                        // Converting seconds into days and convert it to a whole number by the conversion of float to interger
                        $borrowDuration = intval($bookBorrowDurationSecs / 86400);
                      ?>

                      <td title="Borrow Duration"><?php echo $borrowDuration; ?></td>

                      <td>
                          <a href="updateBookDetails.php?isbn=<?php echo $ISBN ?>"> Edit </a>
						            | <a href="deleteBook.php?isbn=<?php echo $ISBN ?>"
                          onClick="return confirm('This book and along with connections to this book will be removed.\nAre you such you want to continue?')">
                          Remove
                        </a>
                      </td>

                      <td>
                        <button type="button" name="fineCal" style="padding: 6px;
                                                                    font-size: 15px;
                                                                    color: white;
                                                                    margin-left: 10px;
                                                                    margin-top: 6px;
                                                                    width: 100px;
                                                                    border-radius: 5px;
                                                                    background-color: #0081FF;
                                                                    border: 1px solid #0081FF"
                          onclick="
                          <?php
                            if($borrowDuration > 14){
                              $exceededDuration = ($borrowDuration - 14); // This fine is charged daily
                              $totalLateFine = ($exceededDuration * 50);
                              ?>
                                alert('Book borrow has exceeded duration limit by, <?php echo $exceededDuration; ?> days\nDaily Late Fine Charge: Rs.50\nTotal Fine: Rs.<?php echo $totalLateFine; ?>');
                              <?php
                            }
                            else if($borrowDuration <= 14){
                              ?>
                                alert('Book borrow did not exceed the duration limit (14 days).');
                              <?php
                            }
                          ?>
                          ">
                          Calculate
                        </button>

                      </td>
                    </tr>




                      <?php } ?>
                  </tbody>
                </table>
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
