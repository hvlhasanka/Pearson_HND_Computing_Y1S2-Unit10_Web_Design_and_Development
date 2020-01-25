<?php
  include_once("../../LSULibraryDBConnection.php");

  if(isset($_POST['addBookSubmit'])){

    $ISBN = $_POST['isbn'];
    $Name = $_POST['name'];
    $author1 = $_POST['author1'];
    $author2 = $_POST['author2'];
    $bookAvailabilityType = $_POST['bookAvailabilitySelect'];

    if (empty($ISBN) || empty($Name) || empty($author1)){
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
    }
    else{

      // Adding record into Book table
      $bookSQL = "INSERT INTO Book (ISBN, Name, baBAID) VALUES ('$ISBN', '$Name', '$bookAvailabilityType');";

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
        alert("New Record successfully added.");
      </script> <?php

      echo "<script> location.href='librarianDashboard.php'; </script>";
      exit;

    }
  }

?>

<!DOCTYPE html>
<html>
  <head>
    <title>  LSU Library - Add New Book </title>
    <link rel="icon" type="image/png" sizes="1500x1500" href="../../assets/images/LSULibraryLogo.png">
  </head>
</html>
