<?php
  include_once("../../LSULibraryDBConnection.php");

    $bookCatalogID = $_GET['id'];

    // Updating the book records as unasigned to any book catalogs
    $bookCatalogIDChangeSQL = "UPDATE Book SET bcID = '' WHERE bcID = '$bookCatalogID'";

    mysqli_query($databaseConn, $bookCatalogIDChangeSQL);

    // Deleting record from BookCatalog table
    $bookCatalogSQL = "DELETE FROM BookCatalog WHERE ID = '$bookCatalogID'";

    mysqli_query($databaseConn, $bookCatalogSQL);

    ?>
      <script>
        alert("Book Catalog has been successfully removed.");
      </script>
    <?php

    echo "<script> location.href='manageBookCatalog.php'; </script>";

    //header("Location: librarianDashboard.php");

?>
