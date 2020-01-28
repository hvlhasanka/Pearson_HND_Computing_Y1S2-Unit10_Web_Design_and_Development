<?php
  include_once("../../LSULibraryDBConnection.php");

  // Checks if the SEESION variables are already assigned and if the membershipType is Librarian (65350003)
  if (!isset($_SESSION['username']) || !isset($_SESSION['membershipType']) || $_SESSION['membershipType'] != "65350003") {
    header("location: ../../logout.php");
  }

  // Book Catalog ID value that was retrieved from the previous web page
  $bookCatalogID = $_GET['id'];

  if(isset($_POST['updateUpdateButton'])){

    $name = $_POST['name'];

    if(empty($name)){
      ?> <script>
        alert("ERROR: Book Catalog Name field is not filled.");
      </script> <?php
    }
    else{
      // Updating record in BookCatalog Table
      $bookCatalogSQL = "UPDATE BookCatalog SET Name = '$name' WHERE CatalogID = '$bookCatalogID';";

      mysqli_query($databaseConn, $bookCatalogSQL);

      ?> <script>
        alert("Book Catalog details successfully updated.");
      </script> <?php

      echo "<script> location.href='manageBookCatalog.php'; </script>";
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

    <!-- Retrieving form layout style sheet -->
    <link rel="stylesheet" href="../../assets/css/formLayout.css">

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
                  <td class="navItem" id="navItem1"> <a href="" data-toggle="popover" data-trigger="hover" data-placement="bottom" title="Options"
                    data-content="View Account Details" style="color: black;"> <?php echo $_SESSION['username']; ?></a> </td>
                  <td class="navItem" id="navItem2"> <a href="../../logout.php">Logout</a> </td>
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
                <li class="nav-item active">
                  <a class="nav-link" href="manageBookCatalog.php">Manage Book Catalogs</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">Manage Borrow and Returning Details</a>
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
                      height: 550px;
                      background-color: #F6F6F6;">

            <!-- Return Button -->
            <button type="button" name="return" style="color: #FFFFFF;
                                                      background-color: #5EAFFF;
                                                      border-color: #5EAFFF;
                                                      padding: 5px;
                                                      border-radius: 5px;
                                                      width: 140px;
                                                      position: absolute;
                                                      top: 440px;
                                                      left: 30%;" onClick="window.location.href = 'manageBookCatalog.php';">
              <i class="fa fa-arrow-left" style="font-size: 20px;
                                                margin-right: 10px;"></i>
              Return
            </button>

            <!-- Existing Books section -->
            <div style="width: 45%;
                        height: 380px;
                        background-color: #FFFFFF;
                        border-radius: 10px;
                        position: relative;
                        left: 50%;
                        transform: translateX(-50%);
                        top: 100px;">

              <p style="font-size: 20px;
                        padding-left: 15%;;
                        padding-top: 20px;"><b>Update Book Catalog Details</b></p>

              <style>
                .formText{
                  font-size: 18px;
                  padding-left: 75px;
                }

                .formInput{
                  padding: 10px;
                  border-radius: 7px;
                  width: 300px;
                  margin-top: 0px;
                  margin-left: 95px;;
                  margin-bottom: 20px;
                  border-color: #ccc;
                }

                #formUpdateButton{
                  padding: 5px;
                  border-radius: 5px;
                  margin-top: 20px;
                  margin-left: 35%;
                  margin-right: 10px;
                  background-color: #0081FF;
                  color: #FFFFFF;
                  width: 100px;
                  border-color: #0081FF;
                }

                #formResetButton{
                  padding: 5px;
                  border-radius: 5px;
                  background-color: #DEDEDE;
                  color: #000000;
                  width: 100px;
                  border-color: #DEDEDE;
                }
              </style>



              <!-- Update Book Details Form -->
              <div style="position: absolute;
                          left:50%;
                          transform: translateX(-50%);">
                <form action="updateBookCatalogDetails.php?id=<?php echo $bookCatalogID; ?>" method="POST">
                  <p class="formText">ID:</p>
                  <input type="text" name="id" placeholder="Enter ID" required class="formInput" value="<?php echo $bookCatalogID; ?>" readonly
                    style="background-color: #E4E4E4;">

                  <p class="formText">Name:</p>
                  <!-- Retrieving existing details of the existing book catalog from the database -->
                  <?php
                    $bookCatalogNameSQL = "SELECT Name FROM BookCatalog WHERE CatalogID = '$bookCatalogID';";
                    $bookCatalogNameResult = mysqli_query($databaseConn, $bookCatalogNameSQL);
                    while($bookCatalogNameRow = mysqli_fetch_array($bookCatalogNameResult)){
                  ?>
                  <input type="text" name="name" value=" <?php echo $bookCatalogNameRow['Name']; } ?> " required class="formInput">

                  <br>
                  <button type="submit" name="updateUpdateButton" id="formUpdateButton">Update</button>
                  <button type="reset" name="updateResetButton" id="formResetButton">Reset</button>

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
