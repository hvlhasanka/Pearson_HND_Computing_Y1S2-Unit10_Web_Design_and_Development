<?php

  // Retrieving code block for MySQL database connection
  include_once("../../LSULibraryDBConnection.php");

  // Retrieving code block to check if the book reserve time period has exceeded or not
  include_once("../../checkBookReserveTimePeriod.php");

    $bookCatalogID = $_GET['id'];

    // Deleting record from LibrarianManageBookCatalog table
    $manageBookCatalogSQL = "DELETE FROM BookCatalogHasBook WHERE bcCatalogID = '$bookCatalogID';";

    mysqli_query($databaseConn, $manageBookCatalogSQL);

    // Deleting record from BookCatalogHasBook table
    $bookSQL = "DELETE FROM BookCatalogHasBook WHERE bcCatalogID = '$bookCatalogID';";

    mysqli_query($databaseConn, $bookSQL);

    // Deleting record from BookCatalog table
    $bookCatalogSQL = "DELETE FROM BookCatalog WHERE CatalogID = '$bookCatalogID';";

    mysqli_query($databaseConn, $bookCatalogSQL);


    ?>
      <script>
        alert("Book Catalog has been successfully removed.");
      </script>
    <?php

    echo "<script> location.href='manageBookCatalog.php'; </script>";

    //header("Location: librarianDashboard.php");

?>
