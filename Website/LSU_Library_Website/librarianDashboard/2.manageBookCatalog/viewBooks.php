<?php
  include_once("../../LSULibraryDBConnection.php");

  // ID retrieved from the previous web page
  $bookCatalogID = $_GET['id'];

  if(isset($_POST['addBookSubmit'])){

    $ISBN = $_POST['isbn'];

    if(empty($ISBN)){
      ?> <script>
        alert("ERROR: ISBN field is not filled.");
      </script> <?php
    }
    else{
      // Checking if this book was already added to this book catalog
      $checkISBNSQL = "SELECT bISBN FROM BookCatalogHasBook WHERE bcID = '$bookCatalogID' AND bISBN = '$ISBN';";
      $checkISBNResult = mysqli_query($databaseConn, $checkISBNSQL); ;
      if($checkISBNResult = 1){
        ?> <script>
          alert("Book already added into this book catalog");
        </script> <?php

        echo "<script> location.href='viewBooks.php?id=</script> <?php echo $bookCatalogID; ?> <script>'; </script>";
      }
      else if($checkISBNResult = 0){
        // Adding book into a book catalog
        $addBookSQL = "INSERT INTO BookCatalogHasBook VALUES ('$bookCatalogID', '$ISBN');";

        mysqli_query($databaseConn, $addBookSQL);

        ?> <script>
          alert("Book successfully added into book catalog.");
        </script> <?php

        echo "<script> location.href='viewBooks.php?id=<?php echo $bookCatalogID; ?>'; </script>";
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
                  <td class="navItem" id="navItem1"> <a href="#">Welcome</a> </td>
                  <td class="navItem" id="navItem2"> <a href="#" data-toggle="modal" data-target="#loginFormModel">Logout</a> </td>
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
                  <a class="nav-link" href="../1.manageBook/manageBook.php">Manage Books</a>
                </li>
                <li class="nav-item active">
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

                <?php
                  $bookCatalogNameSQL = "SELECT Name FROM BookCatalog WHERE ID = '$bookCatalogID';";
                  $bookCatalogNameResult = mysqli_query($databaseConn, $bookCatalogNameSQL);
                  $bookCatalogName = "";
                  while($bookCatalogNameRow = mysqli_fetch_array($bookCatalogNameResult)){
                    $bookCatalogName = $bookCatalogNameRow["Name"];
                  }
                ?>

              <p style="font-size: 20px;
                        padding-left: 30px;
                        padding-top: 20px;"><b>Available Books in Book Catalog: <?php echo $bookCatalogName; ?></b></p>

              <div style="width: 95%;
                          height: 790px;
                          background-color: white;
                          position: absolute;
                          left: 50%;
                          transform: translateX(-50%);
                          overflow-y: scroll;">

                <!-- Retrieving details of the existing books from the database -->
                <?php
                  $bookDetailsSQL = "SELECT b.ISBN, b.Name, ba.Availability, b.RegisteredDateTime FROM Book b
                                    INNER JOIN BookAvailability ba ON ba.ID = b.baID
                                    ORDER BY RegisteredDateTime DESC;";

                  $bookDetailsResult = mysqli_query($databaseConn, $bookDetailsSQL);

                ?>

                <table class="table table-hover fixed_header" style="border-radius: 10px;">
                  <thead>
                    <tr>
                      <th> ISBN </th>
                      <th> Name </th>
                      <th> Author Name </th>
                      <th> Availability </th>
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

                      <td title="Availability"><?php echo $bookDetailsRow["Availability"]; ?></td>
                      <td title="Registered Date Time"><?php echo $bookDetailsRow["RegisteredDateTime"]; ?></td>
                      <td>
						            <a href="removeBook.php?id=<?php echo $ISBN ?>"
                          onClick="return confirm('This book will be removed from this catalog.\nAre you such you want to continue?')">
                          Remove Book
                        </a>
                      </td>
                    </tr>
                      <?php } ?>
                  </tbody>
                </table>
              </div>

            </div>

            <!-- Add new book section -->
            <div style="width: 35%;
                        height: 100px;
                        background-color: #FFFFFF;
                        border-radius: 10px;
                        position: relative;
                        left: 50%;
                        transform: translateX(-50%);
                        top: 35px;">

              <p style="font-size: 20px;
                        padding-left: 50px;
                        padding-top: 40px;"><b>Add Book to Book Catalog</b></p>

              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addBookModal"
               style="padding: 10px;
                      width: 35%;
                      position: absolute;
                      left: 350px;
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
                    <h4 class="modal-title">Add Book</h4>
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

                    <form action="viewBooks.php?id=<?php echo $bookCatalogID; ?>" method="POST">
                      <p class="formText">ISBN:</p>
                      <input type="text" name="isbn" placeholder="Enter ISBN" required class="formInput">
                      <p class="mandatoryAsterisk" style="top: 55px;">*</p>

                      <br>
                      <button type="submit" name="addBookSubmit" id="addBookSubmitButton">Submit</button>
                      <button type="reset" name="addBookReset" id="addBookResetButton">Reset</button>

                    </form>

                  </div>

                  <!-- Modal - Footer -->
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  </div>

                </div>
              </div>
            </div>

            <!-- Return Button -->
            <button type="button" name="return" style="color: #FFFFFF;
                                                      background-color: #5EAFFF;
                                                      border-color: #5EAFFF;
                                                      padding: 5px;
                                                      border-radius: 5px;
                                                      width: 140px;
                                                      position: absolute;
                                                      top: 1430px;
                                                      left: 250px;" onClick="window.location.href = 'manageBookCatalog.php';">
              <i class="fa fa-arrow-left" style="font-size: 20px;
                                                margin-right: 10px;"></i>
              Return

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
