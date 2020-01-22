<?php
  include_once("../../LSULibraryDBConnection.php");
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

    <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
    <script src="../assets/javascript/jquery.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>

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
                .addBookFormText{
                  font-size: 18px;
                  padding-left: 75px;
                }

                .addBookInput{
                  padding: 10px;
                  border-radius: 7px;
                  width: 300px;
                  margin-top: 0px;
                  margin-left: 95px;;
                  margin-bottom: 20px;
                  border-color: #ccc;
                }

                #addBookSubmitButton{
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

                #addBookResetButton{
                  padding: 5px;
                  border-radius: 5px;
                  background-color: #DEDEDE;
                  color: #000000;
                  width: 100px;
                  border-color: #DEDEDE;
                }
              </style>

              <div style="position: absolute; left:50%; transform: translateX(-50%);">
                <form action="addNewBook.php" method="POST">
                  <p class="addBookFormText">ISBN:</p>
                  <input type="text" name="isbn" placeholder="Enter ISBN" required class="addBookInput">

                  <p class="addBookFormText">Book Name:</p>
                  <textarea rows = "5" cols = "40" name="name" placeholder="Enter Book Name" required class="addBookInput"></textarea>

                  <p class="addBookFormText">First Auther Name:</p>
                  <input type="text" name="author1" placeholder="Enter First Author" required class="addBookInput">

                  <p class="addBookFormText">Second Author Name:</p>
                  <input type="text" name="author2" placeholder="Enter Second Author" class="addBookInput">

                  <p class="addBookFormText">Select Book Availability Type:</p>
                  <select name="bookAvailabilitySelect" class="addBookInput">
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
                  <button type="submit" name="addBookSubmit" id="addBookSubmitButton">Submit</button>
                  <button type="reset" name="addBookReset" id="addBookResetButton">Reset</button>

                </form>

              </div>

              <button type="button" name="return" style="color: #FFFFFF;
                                                        background-color: #5EAFFF;
                                                        border-color: #5EAFFF;
                                                        padding: 5px;
                                                        border-radius: 5px;
                                                        width: 100px;" onClick="window.location.href = 'librarianDashboard.php';">Return</button>

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
