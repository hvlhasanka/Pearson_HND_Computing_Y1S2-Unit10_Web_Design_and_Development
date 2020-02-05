<?php
  // Starts the SESSION period
  session_start();

  // Checks if the SEESION variables are already assigned and if the membershipType is Librarian (65350003)
  if (!isset($_SESSION['username']) || !isset($_SESSION['membershipType']) || $_SESSION['membershipType'] != "65350003") {
    header("location: ../../logout.php");
  }

    // Retrieving code block for MySQL database connection
  include_once("../../LSULibraryDBConnection.php");

  // Retrieving code block to check if the book reserve time period has exceeded or not
  include_once("../../checkBookReserveTimePeriod.php");


  $userUsername = $_SESSION['username'];

  if(isset($_POST['cborrowdetails'])){

    $currentISBN = $_GET['borrowisbn'];
    $borrowID = $_GET['borrowid'];
    $currentUserUsername = $_GET['userusername'];

    $newUserUsername = $_POST['cborrowMember'];
    $newBookISBN = $_POST['cborrowbook'];
    $newBorrowDateTime = $_POST['cborrowdt'];
    $newExpectedReturnDateTime = $_POST['cexreturndt'];

    if(empty($newUserUsername) || empty($newBookISBN) || empty($newBorrowDateTime) || empty($newExpectedReturnDateTime)){
      ?> <script>
        alert("ERROR: At least one of the fields must be filled.");
      </script><?php
    }
    else{

      // Process of undating the borrow member username
      // Retrieving the UserID and UniversityNo of the current Username
      $currentUserDetailSQL = "SELECT um.uUserID, um.UniversityNo FROM UniversityMember um
                        INNER JOIN User u ON u.UserID = um.uUserID
                        INNER JOIN Login l ON l.LoginID = u.lLoginID
                        WHERE l.Username = '$currentUserUsername';";
      $currentUserDetailResult = mysqli_query($databaseConn, $currentUserDetailSQL);
      $currentUserDetailRow = mysqli_fetch_array($currentUserDetailResult);
      $currentuUserID = $currentUserDetailRow["uUserID"];
      $currentUniversityNo = $currentUserDetailRow["UniversityNo"];

      // Retrieving the UserID and UniversityNo of the new Username
      $newUserDetailSQL = "SELECT um.uUserID, um.UniversityNo FROM UniversityMember um
                        INNER JOIN User u ON u.UserID = um.uUserID
                        INNER JOIN Login l ON l.LoginID = u.lLoginID
                        WHERE l.Username = '$newUserUsername';";
      $newUserDetailResult = mysqli_query($databaseConn, $newUserDetailSQL);
      $newUserDetailRow = mysqli_fetch_array($newUserDetailResult);
      $newuUserID = $newUserDetailRow["uUserID"];
      $newUniversityNo = $newUserDetailRow["UniversityNo"];

      // Updating Borrow Table with new Username
      $newBorrowMemberSQL = "UPDATE Borrow SET umUserID = '$newuUserID', umUniversityNo = '$newUniversityNo'
                            WHERE umUserID = '$currentuUserID' AND umUniversityNo = '$currentUniversityNo';";
      mysqli_query($databaseConn, $newBorrowMemberSQL);


      // Process of undating the borrow book
      $bookBorrowSQL = "UPDATE Borrow SET bISBN = '$newBookISBN' WHERE bISBN = '$currentISBN';";
      mysqli_query($databaseConn, $bookBorrowSQL);

      // Process of updating the borrow datetime
      // Converting value from DateTime-Local input to mysql compatible datetime format
      $borrowDateTimeMySQL = date("Y-m-d h:i:s", strtotime($newBorrowDateTime));
      // Updating value
      $borrowDateTimeSQL = "UPDATE BookBorrow SET BorrowDateTime = '$borrowDateTimeMySQL' WHERE BorrowID = '$borrowID';";
      mysqli_query($databaseConn, $borrowDateTimeSQL);

      // Process of updating the return datetime
      // Converting value from DateTime-Local input to mysql compatible datetime format
      $ExReturnDateTimeMySQL = date("Y-m-d h:i:s", strtotime($newExpectedReturnDateTime));
      // Updating value
      $returnDateTimeSQL = "UPDATE BookBorrow SET ReturnDateTime = '$ExReturnDateTimeMySQL' WHERE BorrowID = '$borrowID';";
      mysqli_query($databaseConn, $returnDateTimeSQL);

      ?><script>
        alert("Borrow details are successfully updated.");
      </script><?php

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


    <script>
      // jQuery to enable the bootstrap popover implementation
      $(document).ready(function(){
        $('[data-toggle="popover"]').popover();
      });

      // jQuery to enable the bootstrap tooltip implementation
      $(document).ready(function(){
          $('[data-toggle="tooltip"]').tooltip();
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
                    <a href="../5.accountDetails/librarianAccountDetails.php" data-toggle="popover" data-trigger="hover" data-placement="bottom" title="Options"
                    data-content="View Account Details" style="color: black;">
                      <?php echo $userUsername ?> &nbsp
                      <i class="fa fa-user" style="font-size: 32px;
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

          <!-- Outer Background -->
          <div style="width: 100%;
                      height: 1000px;
                      background-color: #F6F6F6;">

            <button type="button" name="return" style="color: #FFFFFF;
                                                      background-color: #5EAFFF;
                                                      border: 1px solid #5EAFFF;
                                                      padding: 5px;
                                                      border-radius: 5px;
                                                      width: 140px;
                                                      position: absolute;
                                                      top: 340px;
                                                      left: 470px;" onClick="window.location.href = 'manageBookBorrowAndReturnDetails.php';">
              <i class="fa fa-arrow-left" style="font-size: 20px;
                                                margin-right: 10px;"></i>
              Return
            </button>


            <div style="width: 55%;
                        height: 620px;
                        background-color: #FFFFFF;
                        border-radius: 10px;
                        position: relative;
                        left: 50%;
                        transform: translateX(-50%);
                        top: 100px;">

              <p style="font-size: 30px;
                        padding-top: 25px;
                        margin-left: 40px;
                        text-align: center;"><b>Update Borrow Details</b></p>


              <style>
                #container{
                  height: 1000px;
                  width: 80%;
                  position: absolute;
                  top: 100px;
                  left: 25%;
                  transition: translateX(-75%);
                }

                .updateFormText{
                  font-size: 18px;
                  padding-left: 75px;
                }

                .updateFormInput{
                  padding: 10px;
                  border-radius: 7px;
                  width: 300px;
                  margin-top: -10px;
                  margin-left: 120px;;
                  margin-bottom: 20px;
                  border: 1px solid #CCC;
                }

                #updateSubmitButton{
                  padding: 5px;
                  border-radius: 5px;
                  margin-top: 80px;
                  margin-left: 38%;
                  margin-right: 10px;
                  background-color: #0081FF;
                  color: #FFFFFF;
                  width: 300px;
                  height: 50px;
                  border: 1px solid #0081FF;
                  position: absolute;
                  left: 12%;
                  transform: translateX(-88%);
                }

                #updateResetButton{
                  padding: 5px;
                  border-radius: 5px;
                  background-color: #DEDEDE;
                  color: #000000;
                  width: 100px;
                  border: 1px solid #DEDEDE;
                  position: absolute;
                  top: 440px;
                  left: -100px;
                }

              </style>

              <!-- Main Container -->
              <div id="container">



                <form action="updateBorrowDetails.php?borrowisbn=<?php echo $_GET['borrowisbn']; ?>&borrowid=<?php echo $_GET['borrowid']; ?>&userusername=<?php echo $_GET['userusername']; ?>"
                  method="POST">

                  <p class="updateFormText">Change Borrow Member: </p>

                  <input type="text" name="cborrowMember" class="updateFormInput" placeholder="Member Username"
                  title="Only Uppercase, Lowercase Alphabetic and Numeric Characters, Minimum Length: 10, Maximum Length: 15"
                  data-toggle="tooltip" data-placement="right" value="<?php echo $_GET['userusername']; ?>">

                  <p class="updateFormText">Change Borrow Book: </p>
                  <input type="text" name="cborrowbook" class="updateFormInput" placeholder="Book ISBN"
                  title="Only Numeric characters with a length of 10 to 13 characters"
                  data-toggle="tooltip" data-placement="right" value="<?php echo $_GET['borrowisbn']; ?>">

                  <?php
                  $rBorrowID = $_GET['borrowid'];

                  // Retrieving Borrow DateTime and Expected Return DateTime from the BookBorrow Table
                  $dateTimeSQL = "SELECT DATE_FORMAT(BorrowDateTime, '%Y-%m-%dT%H:%i') AS 'BorrowDateTime',
                                  DATE_FORMAT(ReturnDateTime, '%Y-%m-%dT%H:%i') AS 'ReturnDateTime'
                                  FROM BookBorrow WHERE BorrowID = '$rBorrowID';";
                  $dateTimeResult = mysqli_query($databaseConn, $dateTimeSQL);
                  $dateTimeRow = mysqli_fetch_array($dateTimeResult);
                  $bdt = $dateTimeRow['BorrowDateTime'];
                  $rdt = $dateTimeRow['ReturnDateTime'];
                  ?>

                  <p class="updateFormText">Change Borrow DateTime: </p>
                  <input type="datetime-local" name="cborrowdt" class="updateFormInput"
                  title="Select a date and time"
                  data-toggle="tooltip" data-placement="right" value="<?php echo $bdt; ?>">

                  <p class="updateFormText">Change Expected Return DateTime: </p>
                  <input type="datetime-local" name="cexreturndt" class="updateFormInput"
                  title="Select a date and time"
                  data-toggle="tooltip" data-placement="right" value="<?php echo $rdt; ?>">

                  <button type="submit" name="cborrowdetails" id="updateSubmitButton">Update Details</button>
                  <button type="submit" name="updateResetButton" id="updateResetButton">Reset</button>

                </form>

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
