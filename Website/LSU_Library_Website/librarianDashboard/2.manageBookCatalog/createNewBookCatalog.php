<?php
  include_once("../../LSULibraryDBConnection.php");

  if(isset($_POST['createBookCatalogSubmit'])){

    $Name = $_POST['name'];

    if (empty($Name)){
      ?> <script>
        alert("ERROR: Book Catalog Name field is not filled.");
      </script> <?php
    }
    else{

      // Inserting new book catalog details into the BookCatalog table
      $bookCatalogSQL = "INSERT INTO BookCatalog (Name) VALUES ('$Name')";

      mysqli_query($databaseConn, $bookCatalogSQL);


      ?> <script>
        alert("New Book Catalog successfully created.");
      </script> <?php

      echo "<script> location.href='manageBookCatalog.php'; </script>";

    }
  }

?>

<!DOCTYPE html>
<html>
  <head>
    <title>  LSU Library - Create Book Catalog </title>
    <link rel="icon" type="image/png" sizes="1500x1500" href="../../assets/images/LSULibraryLogo.png">
  </head>
</html>
