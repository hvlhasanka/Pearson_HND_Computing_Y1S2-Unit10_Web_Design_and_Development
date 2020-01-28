<?php
  // Starts the SESSION period
  session_start();

  // Checks if the SEESION variables are already assigned and if the membershipType is Librarian (65350003)
  //if (!isset($_SESSION['username']) || !isset($_SESSION['membershipType']) || $_SESSION['membershipType'] != "65350003") {
  //  header("location: ../../logout.php");
  //}

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
                <li class="nav-item active">
                  <a class="nav-link" href="manageBooks.php">Manage Books</a>
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
                width: 160px;
              }
            </style>
          <!-- NavBar - End -->

          <!-- Outer Background -->
          <div style="width: 100%;
                      height: 1100px;
                      background-color: #F6F6F6;">

            <!-- Existing Books section -->
            <div style="width: 75%;
                        height: 880px;
                        background-color: #FFFFFF;
                        border-radius: 10px;
                        position: relative;
                        left: 50%;
                        transform: translateX(-50%);
                        top: 20px;">

              <p style="font-size: 20px;
                        padding-left: 30px;
                        padding-top: 20px;"><b>Existing Books</b></p>

              <div style="width: 95%;
                          height: 790px;
                          background-color: white;
                          position: absolute;
                          left: 50%;
                          transform: translateX(-50%);
                          overflow-y: scroll;">

                <!-- Retrieving details of the existing books from the database -->
                <?php
                  $bookDetailsSQL = "SELECT b.ISBN, b.Name, bc.Category, ba.Availability, b.ReserveDateTime, b.RegisteredDateTime FROM Book b
                                    INNER JOIN BookAvailability ba ON ba.AvailabilityID = b.baAvailabilityID
                                    INNER JOIN BookCategory bc ON bc.CategoryID = b.bcCategoryID
                                    ORDER BY RegisteredDateTime DESC;";

                  $bookDetailsResult = mysqli_query($databaseConn, $bookDetailsSQL);

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
                      <th> Registered Date Time </th>
                      <th> Modifications </th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                        while($bookDetailsRow = mysqli_fetch_array($bookDetailsResult)){
                          $ISBN = $bookDetailsRow["ISBN"];
                      ?>
                    <tr>
                      <td title="ISBN"><?php echo $ISBN ?></td>
                      <td title="Book Name"><?php echo $bookDetailsRow["Name"]; ?></td>

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

                      <td title="Category"><?php echo $bookDetailsRow["Category"]; ?></td>

                      <td title="Availability"><?php echo $bookDetailsRow["Availability"]; ?></td>

                      <td title="Reserved Date Time"><?php echo $bookDetailsRow["ReserveDateTime"]; ?></td>

                      <td title="Registered Date Time"><?php echo $bookDetailsRow["RegisteredDateTime"]; ?></td>

                      <td>
                          <a href="updateBookDetails.php?isbn=<?php echo $ISBN ?>"> Edit </a>
						            | <a href="deleteBook.php?isbn=<?php echo $ISBN ?>"
                          onClick="return confirm('This book and along with connections to this book will be removed.\nAre you such you want to continue?')">
                          Delete
                        </a>
                      </td>
                    </tr>
                      <?php } ?>
                  </tbody>
                </table>
              </div>

            </div>

            <!-- Add new book section -->
            <div style="width: 27%;
                        height: 100px;
                        background-color: #FFFFFF;
                        border-radius: 10px;
                        position: relative;
                        left: 50%;
                        transform: translateX(-50%);
                        top: 35px;">

              <p style="font-size: 20px;
                        padding-left: 50px;
                        padding-top: 40px;"><b>Add New Book</b></p>

              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addBookModal"
               style="padding: 10px;
                      width: 35%;
                      position: absolute;
                      left: 270px;
                      top: 30px;">
                Click Here
              </button>

            </div>



            <!-- Add new book modal -->
            <div class="modal fade" id="addBookModal">
              <div class="modal-dialog">
                <div class="modal-content">

                  <!-- Modal - Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Add New Book</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <!-- Modal - Body -->
                  <div class="modal-body">

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

                      .mandatoryAsterisk{
                        color: red;
                        font-size: 20px;
                        font-weight: bold;
                        position: absolute;
                        left: 84%;
                      }

                      #addBookSubmitButton{
                        padding: 5px;
                        border-radius: 5px;
                        margin-left: 50%;
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

                    <form action="manageBooks.php" method="POST">
                      <p class="addBookFormText">ISBN:</p>
                      <input type="text" name="isbn" placeholder="Enter ISBN" required class="addBookInput">
                      <p class="mandatoryAsterisk" style="top: 55px;">*</p>

                      <p class="addBookFormText">Book Name:</p>
                      <textarea rows = "5" cols = "40" name="name" placeholder="Enter Book Name" required class="addBookInput"></textarea>
                      <p class="mandatoryAsterisk" style="top: 170px;">*</p>

                      <p class="addBookFormText">First Auther Name:</p>
                      <input type="text" name="author1" placeholder="Enter First Author" required class="addBookInput">
                      <p class="mandatoryAsterisk" style="top: 375px;">*</p>

                      <p class="addBookFormText">Second Author Name:</p>
                      <input type="text" name="author2" placeholder="Enter Second Author" class="addBookInput">

                      <p class="addBookFormText">Select Book Category Type:</p>
                      <select name="bookCategorySelect" class="addBookInput">
                        <option value="NULL" selected>Select Category</option>
                        <!-- Retrieving the book category types from the database -->
                        <?php
                          $bookCategorySQL = "SELECT * FROM BookCategory";

                          $bookCategoryResult = mysqli_query($databaseConn, $bookCategorySQL);

                          while($bookCategoryRow = mysqli_fetch_array($bookCategoryResult)){
                        ?>
                          <option value="<?php echo $bookCategoryRow["CategoryID"]; ?>"><?php echo $bookCategoryRow["Category"]; ?></option>
                        <?php } ?>
                      </select>
                      <p class="mandatoryAsterisk" style="top: 595px;">*</p>

                      <p class="addBookFormText">Select Book Availability Type:</p>
                      <select name="bookAvailabilitySelect" class="addBookInput">
                        <option value="NULL" selected>Select Availability</option>
                        <!-- Retrieving the book availability types from the database -->
                        <?php
                          $bookAvailabilitySQL = "SELECT * FROM BookAvailability";

                          $bookAvailabilityResult = mysqli_query($databaseConn, $bookAvailabilitySQL);

                          while($bookAvailabilityRow = mysqli_fetch_array($bookAvailabilityResult)){
                        ?>
                          <option value="<?php echo $bookAvailabilityRow["AvailabilityID"]; ?>"><?php echo $bookAvailabilityRow["Availability"]; ?></option>
                        <?php } ?>
                      </select>
                      <p class="mandatoryAsterisk" style="top: 706px;">*</p>
                      <br>
                      <button type="submit" name="addBookSubmit" id="addBookSubmitButton">Submit</button>
                      <button type="reset" name="addBookReset" id="addBookResetButton">Reset</button>

                    </form>

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
