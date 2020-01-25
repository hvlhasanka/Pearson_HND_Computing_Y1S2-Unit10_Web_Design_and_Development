<?php
  include_once("../../LSULibraryDBConnection.php");

  // ISBN value that was retrieved from the previous web page
  $ISBN = $_GET['isbn'];

  if(isset($_POST['updateBookUpdate'])){

    $name = $_POST['name'];
    $firstAuthor = $_POST['author1'];
    $secondAuthor = $_POST['author2'];
    $bookAvailabilityType = $_POST['bookAvailabilitySelect'];

    if(empty($name) || empty($firstAuthor)){
      if(empty($name)){
        ?> <script>
          alert("ERROR: Book Name field is not filled.");
        </script> <?php
      }
      if(empty($firstAuthor)){
        ?> <script>
          alert("ERROR: First Author Name field is not filled.");
        </script> <?php
      }
    }
    else{
      // Updating records in Book Table
      $bookSQL = "UPDATE Book SET ISBN = '$ISBNNew', Name = '$name', baBAID = '$bookAvailabilityType'
                  WHERE ISBN = '$ISBNPrevious';";
      $bookResult = mysqli_query($databaseConn, $bookSQL);

      // Checking if the second author field is empty
      if(empty($secondAuthor)){
        // Adding (first author) record into BookAuthor table
        $bookAuthor1SQL = "UPDATE BookAuthor SET Author '$firstAuthor' WHERE bISBN = '$ISBN';";

        $bookAuthor1Result = mysqli_query($databaseConn, $bookAuthor1SQL);
      }
      // Checking if the second author field is not empty
      else if(!empty($secondAuthor)){
        // Adding (first author) record into BookAuthor table
        $bookAuthor1SQL = "UPDATE BookAuthor SET Author '$firstAuthor' WHERE bISBN = '$ISBN';";

        $bookAuthor1Result = mysqli_query($databaseConn, $bookAuthor1SQL);

        // Adding (second author) record into BookAuthor table
        $bookAuthor2SQL = "UPDATE BookAuthor SET Author '$secondAuthor' WHERE bISBN = '$ISBN';";

        $bookAuthor2Result = mysqli_query($databaseConn, $bookAuthor2SQL);
      }

      ?> <script>
        alert("Book details Successfully Updated.");
      </script> <?php

      echo "<script> location.href='librarianDashboard.php'; </script>";

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
                      height: 1060px;
                      background-color: #F6F6F6;">

            <button type="button" name="return" style="color: #FFFFFF;
                                                      background-color: #5EAFFF;
                                                      border-color: #5EAFFF;
                                                      padding: 5px;
                                                      border-radius: 5px;
                                                      width: 140px;
                                                      position: absolute;
                                                      top: 430px;
                                                      left: 470px;" onClick="window.location.href = 'manageBooks.php';">
              <i class="fa fa-arrow-left" style="font-size: 20px;
                                                margin-right: 10px;"></i>
              Return
            </button>

            <!-- Update Book Details section -->
            <div style="width: 45%;
                        height: 920px;
                        background-color: #FFFFFF;
                        border-radius: 10px;
                        position: relative;
                        left: 50%;
                        transform: translateX(-50%);
                        top: 100px;">

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



              <!-- Update Book Details Form -->
              <div style="position: absolute; left:50%; transform: translateX(-50%);">
                <form action="updateBookDetails.php?isbn=<?php echo $ISBN; ?>" method="POST">
                  <p class="updateBookFormText">ISBN:</p>
                  <input type="text" name="isbnNew" placeholder="Enter ISBN" required class="updateBookInput" value="<?php echo $ISBN; ?>" readonly
                    style="background-color: #E4E4E4;">

                  <p class="updateBookFormText">Book Name:</p>
                  <!-- Retrieving existing details of the existing books from the database -->
                  <?php
                    $bookDetailsSQL = "SELECT Name FROM Book WHERE ISBN = '$ISBN';";
                    $bookDetailsResult = mysqli_query($databaseConn, $bookDetailsSQL);
                    while($bookDetailsRow = mysqli_fetch_array($bookDetailsResult)){
                  ?>
                  <textarea rows = "5" cols = "40" name="name" placeholder="Enter Book Name" required class="updateBookInput"
                    ><?php echo $bookDetailsRow['Name']; ?>
                  </textarea>
                <?php } ?>


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


                  <p class="updateBookFormText">Select Book Category Type:</p>
                  <select name="bookCategorySelect" class="updateBookInput">
                    <!-- Retrieving the selected book category type from the database -->
                    <?php
                      $selectedBookCategoryID = "";
                      $selectedBookCategory = "";
                      $selectedBookCategorySQL = "SELECT bka.ID, bkc.Category FROM BookCategory bka
                                                      INNER JOIN Book b ON b.bkcID = bkc.ID WHERE b.ISBN = '$ISBN';";
                      $selectedBookCategoryResult = mysqli_query($databaseConn, $selectedBookCategorySQL);
                      while ($selectedBookCategoryRow = mysqli_fetch_array($selectedBookCategoryResult)) {
                        $selectedBookCategoryID = $selectedBookCategoryRow["ID"];
                        $selectedBookCategory = $selectedBookCategoryRow["Category"];
                      }
                    ?>
                    <!-- Retrieving the book category types from the database -->
                    <?php
                      $bookCategorySQL = "SELECT * FROM BookCategory";
                      $bookCategoryResult = mysqli_query($databaseConn, $bookCategorySQL);
                      while($bookCategoryRow = mysqli_fetch_array($bookCategoryResult)){
                    ?>
                      <option value="<?php echo $bookCategoryRow["ID"]; ?>"
                        <?php
                          // If the book category type is equal to the selected book category type, 'selected will be echoed'
                          if($bookCategoryRow["ID"] == $selectedBookCategoryID && $bookCategoryRow["Category"] == $selectedBookCategory)
                          {
                            echo "selected";
                          }
                        ?> ><?php echo $bookCategoryRow["Category"]; ?>
                      </option>
                    <?php } ?>
                  </select>


                  <p class="updateBookFormText">Select Book Availability Type:</p>
                  <select name="bookAvailabilitySelect" class="updateBookInput">
                    <!-- Retrieving the selected book availability type from the database -->
                    <?php
                      $selectedBookAvailabilityID = "";
                      $selectedBookAvailability = "";
                      $selectedBookAvailabilitySQL = "SELECT ba.ID, ba.Availability FROM BookAvailability ba
                                                      INNER JOIN Book b ON b.baID = ba.ID WHERE b.ISBN = '$ISBN';";
                      $selectedBookAvailabilityResult = mysqli_query($databaseConn, $selectedBookAvailabilitySQL);
                      while ($selectedBookAvailabilityRow = mysqli_fetch_array($selectedBookAvailabilityResult)) {
                        $selectedBookAvailabilityID = $selectedBookAvailabilityRow["ID"];
                        $selectedBookAvailability = $selectedBookAvailabilityRow["Availability"];
                      }
                    ?>
                    <!-- Retrieving the book availability types from the database -->
                    <?php
                      $bookAvailabilitySQL = "SELECT * FROM BookAvailability";
                      $bookAvailabilityResult = mysqli_query($databaseConn, $bookAvailabilitySQL);
                      while($bookAvailabilityRow = mysqli_fetch_array($bookAvailabilityResult)){
                    ?>
                      <option value="<?php echo $bookAvailabilityRow["ID"]; ?>"
                        <?php
                          // If the book availability type is equal to the selected book availability type, 'selected will be echoed'
                          if($bookAvailabilityRow["ID"] == $selectedBookAvailabilityID && $bookAvailabilityRow["Availability"] == $selectedBookAvailability)
                          {
                            echo "selected";
                          }
                        ?> ><?php echo $bookAvailabilityRow["Availability"]; ?>
                      </option>
                    <?php } ?>
                  </select>
                  <br>
                  <button type="submit" name="updateBookUpdate" id="updateBookUpdateButton">Update</button>
                  <button type="reset" name="updateBookReset" id="updateBookResetButton">Reset</button>

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
