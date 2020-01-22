<?php
  include_once("../../LSULibraryDBConnection.php");

  $ISBN = $_GET['isbn'];



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
    <script src="../../assets/javascript/jquery.min.js"></script>
    <script src="../../assets/bootstrap/js/bootstrap.min.js"></script>

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
                  <td></td>
                  <td></td>
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
                <li class="nav-item active">
                  <a class="nav-link" href="librarianDashboard.php">Manage Books</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="../2.manageBookCatalog/manageBookCatalog.php">Manage Book Catalogs</a>
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
              }
            </style>
          <!-- NavBar - End -->

          <!-- Outer Background -->
          <div style="width: 100%;
                      height: 880px;
                      background-color: #F6F6F6;">

            <!-- Existing Books section -->
            <div style="width: 45%;
                        height: 840px;
                        background-color: #FFFFFF;
                        border-radius: 10px;
                        position: relative;
                        left: 50%;
                        transform: translateX(-50%);
                        top: 20px;">

              <p style="font-size: 20px;
                        padding-left: 15%;;
                        padding-top: 20px;"><b>Update Book Details</b></p>

              <style>
                .updateBookFormText{
                  font-size: 18px;
                  padding-left: 75px;
                }

                .updateBookInput{
                  padding: 10px;
                  border-radius: 7px;
                  width: 300px;
                  margin-top: 0px;
                  margin-left: 95px;;
                  margin-bottom: 20px;
                  border-color: #ccc;
                }

                #updateBookUpdateButton{
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

                #updateBookResetButton{
                  padding: 5px;
                  border-radius: 5px;
                  background-color: #DEDEDE;
                  color: #000000;
                  width: 100px;
                  border-color: #DEDEDE;
                }
              </style>

              <!-- Retrieving existing details of the existing books from the database -->
              <?php
                $bookDetailsSQL = "SELECT b.Name, ba.Availability, b.RegisteredDateTime FROM Book b
                                  INNER JOIN BookAvailability ba ON ba.BAID = b.baBAID
                                  WHERE b.ISBN = '$ISBN';";

                $bookDetailsResult = mysqli_query($databaseConn, $bookDetailsSQL);
              ?>

              <!-- Update Book Details Form -->
              <div style="position: absolute; left:50%; transform: translateX(-50%);">
                <form action="updateBookDetails.php" method="POST">
                  <p class="updateBookFormText">ISBN:</p>
                  <input type="text" name="isbn" placeholder="Enter ISBN" required class="updateBookInput" value="<?php echo $ISBN; ?>">

                  <p class="updateBookFormText">Book Name:</p>
                  <?php
                    while($bookDetailsRow = mysqli_fetch_array($bookDetailsResult)){
                  ?>
                  <textarea rows = "5" cols = "40" name="name" placeholder="Enter Book Name" required class="updateBookInput"
                    ><?php echo $bookDetailsRow['Name']; ?>
                  </textarea>



                  <?php
                    // Retrieving existing author names of the existing books from the database
                    $bookAuthorDetailsSQL = "SELECT Author FROM BookAuthor WHERE bISBN = '$ISBN';";
                    $bookAuthorDetailsResult = mysqli_query($databaseConn, $bookAuthorDetailsSQL);
                    $bookAuthorDetailsRowCount = mysqli_num_rows($bookAuthorDetailsResult);
                    // Implemention if there is only one author name
                    if($bookAuthorDetailsRowCount == 1){
                      while($bookAuthorDetailsRow = mysqli_fetch_array($bookAuthorDetailsResult)){
                        ?>
                        <p class="updateBookFormText">First Auther Name:</p>
                        <input type="text" name="author1" placeholder="Enter First Author" required class="updateBookInput"
                          value="<?php echo $bookAuthorDetailsRow["Author"]; ?>">

                        <p class="updateBookFormText">Second Author Name:</p>
                        <input type="text" name="author2" placeholder="Not Available" class="updateBookInput">
                        <?php
                      }
                    }
                    // Implemention if there are two author names
                    else if($bookAuthorDetailsRowCount == 2){
                      $authorName = [];
                      while($bookAuthorDetailsRow = mysqli_fetch_array($bookAuthorDetailsResult)){
                        $authorName[] = $bookAuthorDetailsRow["Author"];
                      }
                      ?>
                      <p class="updateBookFormText">First Auther Name:</p>
                      <input type="text" name="author1" placeholder="Enter First Author" required class="updateBookInput"
                        value="<?php echo $authorName[0]; ?>">

                      <p class="updateBookFormText">Second Author Name:</p>
                      <input type="text" name="author2" placeholder="Enter Second Author" class="updateBookInput"
                        value="<?php echo $authorName[1]; ?>">
                      <?php
                    }
                  ?>

                  <p class="updateBookFormText">Select Book Availability Type:</p>
                  <select name="bookAvailabilitySelect" class="updateBookInput">
                    <!-- Retrieving the book availability types from the database -->
                    <?php
                      $bookAvailabilitySQL = "SELECT * FROM BookAvailability";

                      $bookAvailabilityResult = mysqli_query($databaseConn, $bookAvailabilitySQL);

                      while($bookAvailabilityRow = mysqli_fetch_array($bookAvailabilityResult)){
                    ?>
                      <option value="<?php echo $bookAvailabilityRow["BAID"] ?>"><?php echo $bookAvailabilityRow["Availability"] ?></option>
                    <?php } ?>
                  </select>
                  <br>
                  <button type="submit" name="updateBookUpdate" id="updateBookUpdateButton">Update</button>
                  <button type="reset" name="updateBookReset" id="updateBookResetButton">Reset</button>

                </form>

              </div>

              <?php } ?>


              <button type="button" name="return" style="color: #FFFFFF;
                                                        background-color: #5EAFFF;
                                                        border-color: #5EAFFF;
                                                        padding: 5px;
                                                        border-radius: 5px;
                                                        width: 140px;
                                                        position: absolute;
                                                        top: 770px;
                                                        left: 40px;" onClick="window.location.href = 'librarianDashboard.php';">
                <i class="fa fa-arrow-left" style="font-size: 20px;
                                                  margin-right: 10px;"></i>
                Return
              </button>

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
