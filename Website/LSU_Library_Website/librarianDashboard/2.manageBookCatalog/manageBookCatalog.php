<!-- Code Developed and Maintained by Hewa Vidanage Lahiru Hasanka -->

<?php

  session_start();

  // Checks if the SEESION variables are already assigned and if the membershipType is Librarian (65350003)
  if (!isset($_SESSION['username']) || !isset($_SESSION['membershipType']) || $_SESSION['membershipType'] != "65350003") {
    header("location: ../../logout.php");
  }

  // Retrieving code block for MySQL database connection
  include_once("../../LSULibraryDBConnection.php");

  // Retrieving code block to check if the book reserve time period has exceeded or not
  include_once("../../checkBookReserveTimePeriod.php");

  // Creating a new book catalog process
  if(isset($_POST['createBookCatalogSubmit'])){

    $Name = $_POST['name'];

    if (empty($Name)){
      ?> <script>
        alert("ERROR: Book Catalog Name field is not filled.");
      </script> <?php
    }
    else{

      // Checking if this book catalog already exists
      $checkBCSQL = "SELECT * FROM BookCatalog WHERE Name = '$Name';";

      $checkBCResult = mysqli_query($databaseConn, $checkBCSQL);

      $checkBCCount = mysqli_num_rows($checkBCResult);

      if($checkBCCount == 0){

        // Inserting new book catalog details into the BookCatalog table
        $bookCatalogSQL = "INSERT INTO BookCatalog (Name) VALUES ('$Name')";

        mysqli_query($databaseConn, $bookCatalogSQL);


        ?> <script>
          alert("New Book Catalog successfully created.");
        </script> <?php

        echo "<script> location.href='manageBookCatalog.php'; </script>";

      }
      else{

        ?> <script>
          alert("Book catalog already exists");
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

		            <a href="../librarianDashboard.php">
                  <img src="../../assets/Images/LSULibraryLogo.png" alt="LSU Library Logo" id="lsuLibraryLogoIcon">
                </a>

                <h1 id="mainTitle"> LSU <span id="mainTitleSpan">Library</span> </h1>

                <p id="mainTitleSub">Lowa State University</p>

                <img src="../../assets/Images/LSUUniversityLogo.png" alt="LSU Logo" id="lsuLogoIcon">

              </div>

              <table id="navSection">
                <tr>
                  <td class="navItem" id="navItem1"> <a href="../5.accountDetails/librarianAccountDetails.php" data-toggle="popover" data-trigger="hover" data-placement="bottom" title="Options"
                    data-content="View Account Details" style="color: black;"><?php echo $_SESSION['username']; ?> &nbsp
                    <i class="fa fa-bars" style="font-size: 32px;
                                                color: #00B1D2FF;"></i> &nbsp
                    </a>
                  </td>
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
                  <a class="nav-link" href="../3.manageBookBorrowAndReturnDetails/manageBookBorrowAndReturnDetails.php">Manage Borrow and Returning Details</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="../4.manageMemberDetails/manageMemberDetails.php">Manage Member Details</a>
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
                      height: 715px;
                      background-color: #F6F6F6;">

            <!-- Existing Books section -->
            <div style="width: 70%;
                        height: 500px;
                        background-color: #FFFFFF;
                        border-radius: 10px;
                        position: relative;
                        left: 50%;
                        transform: translateX(-50%);
                        top: 20px;">

              <p style="font-size: 20px;
                        padding-left: 30px;
                        padding-top: 20px;"><b>Existing Book Catalogs</b></p>

              <div style="width: 95%;
                          height: 400px;
                          background-color: white;
                          position: absolute;
                          left: 50%;
                          transform: translateX(-50%);
                          overflow-y: scroll;">

                <!-- Retrieving details of the existing books from the database -->
                <?php
                  $bookCatalogDetailsSQL = "SELECT CatalogID, Name, NoOfBooks, CreatedDateTime FROM BookCatalog;";

                  $bookCatalogDetailsResult = mysqli_query($databaseConn, $bookCatalogDetailsSQL);

                ?>

                <table class="table table-hover" style="border-radius: 10px;">
                  <thead>
                    <tr>
                      <th>  </th>
                      <th> ID </th>
                      <th> Name </th>
                      <th> No Of Books </th>
                      <th> Created Date Time </th>
                      <th> Modifications </th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                        while($bookCatalogDetailsRow = mysqli_fetch_array($bookCatalogDetailsResult)){
                      ?>
                    <tr>
                      <td title="View, Add, Remove Books"> <a href="viewBooks.php?id=<?php echo $bookCatalogDetailsRow["CatalogID"] ?>"> View Books </a> </td>
                      <td title="Book Catalog ID"> <?php echo $bookCatalogDetailsRow["CatalogID"]; ?></td>
                      <td title="Book Catalog Name"> <?php echo $bookCatalogDetailsRow["Name"]; ?></td>
                      <td title="No Of Books"> <?php echo $bookCatalogDetailsRow["NoOfBooks"]; ?></td>
                      <td title="Created Date Time"> <?php echo $bookCatalogDetailsRow["CreatedDateTime"]; ?></td>
                      <td title="Modifications">
                           <a href="updateBookCatalogDetails.php?id=<?php echo $bookCatalogDetailsRow["CatalogID"] ?>"> Edit </a>
						            |  <a href="deleteBookCatalog.php?id=<?php echo $bookCatalogDetailsRow["CatalogID"] ?>" onClick="return confirm('Are you sure you want to delete this Book Catalog?')"> Delete </a>
                      </td>
                    </tr>
                      <?php } ?>
                  </tbody>
                </table>
              </div>

            </div>

            <!-- Add new book section -->
            <div style="width: 620px;
                        height: 100px;
                        background-color: #FFFFFF;
                        border-radius: 10px;
                        position: relative;
                        left: 50%;
                        transform: translateX(-50%);
                        top: 40px;">

              <p style="font-size: 20px;
                        padding-left: 50px;
                        padding-top: 40px;" data-toggle="modal" data-target="#addBookModal"><b>Create New Book Catalog</b></p>

              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addBookModal"
               style="padding: 10px;
                      width: 200px;
                      position: absolute;
                      left: 370px;
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
                    <h4 class="modal-title">Create New Book Catalog</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <!-- Modal - Body -->
                  <div class="modal-body">

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
                        border: 1px solid #ccc;
                      }

                      .mandatoryAsterisk{
                        color: red;
                        font-size: 20px;
                        font-weight: bold;
                        position: absolute;
                        left: 84%;
                      }

                      #formSubmitButton{
                        padding: 5px;
                        border-radius: 5px;
                        margin-left: 50%;
                        margin-right: 10px;
                        background-color: #0081FF;
                        color: #FFFFFF;
                        width: 100px;
                        border: 1px solid #0081FF;
                      }

                      #formResetButton{
                        padding: 5px;
                        border-radius: 5px;
                        background-color: #DEDEDE;
                        color: #000000;
                        width: 100px;
                        border: 1px solid #DEDEDE;
                      }
                    </style>

                    <form action="manageBookCatalog.php" method="POST">
                      <p class="formText">ID:</p>

                        <?php
                          // Retrieving the latest book catalog ID and incrementing it by one to represent the new book catalog ID
                          $bookCatalogIDSQL = "SELECT CatalogID FROM BookCatalog ORDER BY CreatedDateTime DESC LIMIT 1;";
                          $bookCatalogIDResult = mysqli_query($databaseConn, $bookCatalogIDSQL);
                          $bookCatalogID = "";
                          while($bookCatalogIDRow = mysqli_fetch_array($bookCatalogIDResult)){
                            $bookCatalogID = $bookCatalogIDRow["CatalogID"];
                          }
                        ?>

                      <input type="text" name="bookCatalogID" class="formInput" readonly value="<?php echo ($bookCatalogID + 1); ?> " style="background-color: #E4E4E4;">
                      <p class="formText">Name:</p>
                      <input type="message" name="name" placeholder="Enter Name" required class="formInput">
                      <p class="mandatoryAsterisk" style="top: 170px;">*</p>
                      <br>
                      <button type="submit" name="createBookCatalogSubmit" id="formSubmitButton">Submit</button>
                      <button type="reset" name="createBookCatalogReset" id="formResetButton">Reset</button>

                    </form>
                  </div>

                  <!-- Modal - Footer -->
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
