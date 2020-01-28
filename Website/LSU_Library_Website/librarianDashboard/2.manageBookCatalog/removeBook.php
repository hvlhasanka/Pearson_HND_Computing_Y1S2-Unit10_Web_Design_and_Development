<?php
  include_once("../../LSULibraryDBConnection.php");

    // Retrieving ISBN nad book catalog ID from the previous web page
    $bookCatalogID = $_GET['id'];
    $ISBN = $_GET['isbn'];

    // Removing record from BookCatologHasBook TABLE
    $bookSQL = "DELETE FROM BookCatalogHasBook WHERE bISBN = '$ISBN';";

    mysqli_query($databaseConn, $bookSQL);

    // Retrieving the current no of books in the book catalog.
    // Updating the NoOfBooks in book catalog
    $noOfBooksSQL = "UPDATE BookCatalog SET NoOfBooks = (SELECT (COUNT(bISBN))
                    FROM BookCatalogHasBook WHERE bcCatalogID = '$bookCatalogID') WHERE CatalogID = '$bookCatalogID';";

    mysqli_query($databaseConn, $noOfBooksSQL);

    header("location: viewBooks.php?id=$bookCatalogID");
?>
