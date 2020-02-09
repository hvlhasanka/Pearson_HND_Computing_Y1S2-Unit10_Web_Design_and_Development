<!-- Code Developed and Maintained by Hewa Vidanage Lahiru Hasanka -->

<?php
  // Starts the SESSION period
  session_start();

  // Checks if the SEESION variables are already assigned and if the membershipType is Librarian (65350003)
  if (!isset($_SESSION['username']) || !isset($_SESSION['membershipType']) || $_SESSION['membershipType'] != "65350003") {
    header("location: ../../logout.php");
  }

  // Retrieving code block for MySQL database connection
  include_once("../LSULibraryDBConnection.php");

  // Retrieving code block to check if the book reserve time period has exceeded or not
  include_once("../checkBookReserveTimePeriod.php");

?>

<!DOCTYPE html>
<html>
  <head>
    <title> LSU Library - Dashboard </title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/png" sizes="1500x1500" href="../assets/images/LSULibraryLogo.png">

    <!-- Retrieving default layout style sheet -->
    <link rel="stylesheet" href="../assets/css/defaultLayout.css">

    <!-- Retrieving font-awesome library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <script src="../assets/bootstrap/js/jquery.min.js"></script>
    <script src="../assets/bootstrap/js/popper.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>

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

		<a href="librarianDashboard.php">
                  <img src="../assets/Images/LSULibraryLogo.png" alt="LSU Library Logo" id="lsuLibraryLogoIcon">
                </a>

                <h1 id="mainTitle"> LSU <span id="mainTitleSpan">Library</span> </h1>

                <p id="mainTitleSub">Lowa State University</p>

                <img src="../assets/Images/LSUUniversityLogo.png" alt="LSU Logo" id="lsuLogoIcon">

              </div>

              <table id="navSection">
                <tr>
                  <td class="navItem" id="navItem1">
                    <a href="5.accountDetails/librarianAccountDetails.php" data-toggle="popover" data-trigger="hover" data-placement="bottom" title="Options"
                    data-content="View Account Details" style="color: black;">
                      <?php echo $_SESSION['username']; ?> &nbsp
                      <i class="fa fa-bars" style="font-size: 32px;
                                                  color: #00B1D2FF;"></i> &nbsp
                    </a>
                  </td>

                  <td class="navItem" id="navItem2">
                    <a href="../logout.php">Logout</a>
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

          <!-- Outer Background -->
          <div style="width: 100%;
                      height: 920px;
                      background-color: #F6F6F6;">

            <div style="width: 55%;
                        height: 800px;
                        background-color: #FFFFFF;
                        border-radius: 10px;
                        position: relative;
                        left: 50%;
                        transform: translateX(-50%);
                        top: 20px;">

              <p style="font-size: 30px;
                        padding-top: 25px;
                        text-align: center;"><b>HOME</b></p>

              <style>
                #container{
                  height: 1000px;
                  width: 80%;
                  position: absolute;
                  top: 100px;
                  left: 25%;
                  transition: translateX(-75%);
                }

              </style>

              <!-- Main Container -->
              <div id="container">

                <!-- Manage Books Cell -->
                <a href="1.manageBooks/manageBooks.php">
                  <div style="width: 240px;
                              height: 200px;
                              background-color: #e42c64;
                              border-radius: 10px;
                              margin: 10px;
                              margin-bottom: 30px;">
                    <p style="font-size: 30px;
                              color: #FFFFFF;
                              margin-left: 20px;
                              position: absolute;
                              top: 60px;">Manage <br> Books</p>
                  </div>
                </a>

                <!-- Manage Book Catalogs Cell -->
                <a href="2.manageBookCatalog/manageBookCatalog.php">
                  <div style="width: 240px;
                              height: 200px;
                              background-color: #614ad3;
                              border-radius: 10px;
                              margin: 10px;
                              margin-bottom: 30px;">
                    <p style="font-size: 30px;
                              color: #FFFFFF;
                              margin-left: 20px;
                              position: absolute;
                              top: 290px;">Manage <br> Book Catalogs</p>
                  </div>
                </a>

                <!-- Manage Borrow and Return Details Cell -->
                <a href="3.manageBookBorrowAndReturnDetails/manageBookBorrowAndReturnDetails.php">
                  <div style="width: 240px;
                              height: 430px;
                              background-color: #2d248a;
                              border-radius: 10px;
                              position: absolute;
                              top: 0px;
                              left: 240px;
                              margin: 10px;
                              margin-left: 40px;">
                    <p style="font-size: 30px;
                              color: #FFFFFF;
                              margin-left: 20px;
                              position: absolute;
                              top: 110px;">Manage Book <br> Borrow and <br> Return Details</p>
                  </div>
                </a>

                <!-- Manage Member Details Cell -->
                <a href="4.manageMemberDetails/manageMemberDetails.php">
                  <div style="width: 510px;
                              height: 180px;
                              background-color: #2330B2;
                              border-radius: 10px;
                              margin: 10px;">
                    <p style="font-size: 30px;
                              color: #FFFFFF;
                              margin-left: 20px;
                              position: absolute;
                              top: 510px;">Manage <br> Member Details</p>
                  </div>
                </a>

              </div>


          </div>
        </div>

        <!-- BODY SECTION - End -->


        <!-- FOOTER SECTION - Begin -->
          <div id="footer">

            <div id="footerLogoSection">

              <img src="../assets/images/LSULibraryLogo.png" alt="LSU Library Logo" id="lsuLibraryLogoIcon">

              <h1 id="mainTitle"> LSU <span id="mainTitleSpan">Library</span> </h1>

              <p id="mainTitleSub">Lowa State University</p>

              <img src="../assets/images/LSUUniversityLogo.png" alt="LSU Logo" id="lsuLogoIcon">

            </div>

            <p id="footerText1Main">LSU Library - <span id="footerText1Sub">Lowa State University</span> &copy; 2020</p>
          </div>
        <!-- FOOTER SECTION - End -->

    <!-- MAIN SECTION - End -->
  </body>
</html>
