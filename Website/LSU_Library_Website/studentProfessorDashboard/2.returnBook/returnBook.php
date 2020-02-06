<?php
  // Starts the SESSION period
  session_start();

  $userUsername = $_SESSION['username'];

  // Checks if the SEESION variables are already assigned and if the membershipType is studet (65350001) or professor (65350002)
  if (!isset($_SESSION['username']) || !isset($_SESSION['membershipType']) || $_SESSION['membershipType'] == "65350003") {
    header("location: ../../logout.php");
  }

  // Retrieving code block for MySQL database connection
  include_once("../../LSULibraryDBConnection.php");

  // Retrieving code block to check if the book reserve time period has exceeded or not
  include_once("../../checkBookReserveTimePeriod.php");

  if(isset($_POST['returnSubmit'])){

    $bookISBN = $_POST['bookISBN'];

    if(empty($bookISBN)){
      ?> <script>
        alert("ERROR: Book ISBN field was not filled");
      </script> <?php
    }
    else{

      // Updating Book Table
      $bookSQL = "UPDATE Book SET baAvailabilityID = 55240001 WHERE ISBN = '$bookISBN';";
      mysqli_query($databaseConn, $bookSQL);

      // Retrieving the UserID of the currently logged in account
      $userIDDBSQL = "SELECT UserID FROM User u
                      INNER JOIN Login l ON l.LoginID = u.lLoginID
                      WHERE l.Username = '$userUsername';";
      $userIDDBResult = mysqli_query($databaseConn, $userIDDBSQL);
      $userIDDBRow = mysqli_fetch_array($userIDDBResult);
      $userID = $userIDDBRow["UserID"];

      // Retrieving the BorrowID from the Borrow Table
      $borrowIDSQL = "SELECT bbBorrowID FROM Borrow WHERE umUserID = '$userID' AND bISBN = '$bookISBN';";
      $borrowIDResult = mysqli_query($databaseConn, $borrowIDSQL);
      $borrowIDRow = mysqli_fetch_array($borrowIDResult);
      $borrowID = $borrowIDRow["bbBorrowID"];

      // Retrieving the current datetime
      date_default_timezone_set('Asia/Colombo');
      $returnDateTime = date('Y-m-d h:i:s', time());

      // Retrieving book borrowed datetime from the BookBorrow Table
      $borrowDateTimeSQL = "SELECT BorrowDateTime FROM BookBorrow WHERE $borrowID = '$borrowID';";
      $borrowDateTimeResult = mysqli_query($databaseConn, $borrowDateTimeSQL);
      $borrowDateTimeRow = mysqli_fetch_array($borrowDateTimeResult);
      $borrowDateTime = $borrowDateTimeRow["BorrowDateTime"];

      $assignedReturnDateDuration = strtotime("+14 day", strtotime($borrowDateTime));

      $assignedReturnDate = date("Y-m-d", $assignedReturnDateDuration);

      if($returnDateTime > $assignedReturnDate){
        ?> <script>
          alert("Provide book to librarian.\nUnder consideration of the librarian fine may get charged.\nContact librarian for more details.\nThank You");
        </script> <?php
      }
      else if($returnDateTime <= $assignedReturnDate){
        ?> <script>
          alert("Provide book to librarian. Thank You");
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
                <li class="nav-item">
                  <a class="nav-link" href="../1.searchBook/searchBook.php">Search Book</a>
                </li>
                <li class="nav-item active">
                  <a class="nav-link" href="returnBook.php">Return Book</a>
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
                      height: 1050px;
                      background-color: #F6F6F6;">

            <div style="width: 50%;
                        height: 300px;
                        background-color: #FFFFFF;
                        border-radius: 10px;
                        position: relative;
                        left: 50%;
                        transform: translateX(-50%);
                        top: 30px;">

              <style>
                #container{
                  height: 1000px;
                  width: 94%;
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
                  width: 250px;
                }

                #returnBookSubmit{
                  padding: 5px;
                  border-radius: 5px;
                  background-color: #0081FF;
                  color: #FFFFFF;
                  width: 350px;
                  height: 50px;
                  border: 1px solid #0081FF;
                  font-size: 20px;
                  margin-left: 25px;
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
                          top: -100px;
                          left: -10px;"><b>Return Borrowed Book</b></p>

                <form method="POST" action="returnBook.php">

                  <p class="formText">Book ISBN:
                    <input type="text" name="bookISBN" placeholder="ISBN" class="formInput" style="margin-left: 58px;" required>
                  </p>

                  <button type="submit" name="returnSubmit" id="returnBookSubmit">Return Book</button>

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
