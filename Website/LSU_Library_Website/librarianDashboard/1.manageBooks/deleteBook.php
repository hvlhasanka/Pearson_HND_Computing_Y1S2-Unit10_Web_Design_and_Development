<?php
  include_once("../../LSULibraryDBConnection.php");

    $ISBN = $_GET['isbn'];

    /* Deleting record from BookAuthor table */
    $bookAuthorSQL = "DELETE FROM BookAuthor WHERE bISBN='$ISBN';";

    mysqli_query($databaseConn, $bookAuthorSQL);

    /* Deleting record from ReservedBook table */
    $reservedBookSQL = "DELETE FROM ReservedBook WHERE bISBN='$ISBN';";

    mysqli_query($databaseConn, $reservedBookSQL);

      /* Retrieving BorrowDetails ID from the Borrow table */
      $borrowDetailsIDSQL = "SELECT bdID FROM Borrow WHERE bISBN = '$ISBN';";

      $borrowDetailsIDResult = mysqli_query($databaseConn, $borrowDetailsIDSQL);

      $borrowDetailsID = "";

      while($borrowDetailsIDRow = mysqli_fetch_array($borrowDetailsIDResult)){

        $borrowDetailsID = $borrowDetailsIDRow['bdID'];

        /* Deleting record from Borrow table */
        $borrowSQL = "DELETE FROM Borrow WHERE bdID='$borrowDetailsID';";

        mysqli_query($databaseConn, $borrowSQL);

        /* Deleting record from LibrarianManageBorrowDetails table */
        $LMBDSQL = "DELETE FROM LibrarianManageBorrowDetails WHERE bdID='$borrowDetailsID';";

        mysqli_query($databaseConn, $LMBDSQL);

        /* Deleting record from BorrowDetails table */
        $borrowDetailsSQL = "DELETE FROM BorrowDetails WHERE ID='$borrowDetailsID';";

        mysqli_query($databaseConn, $borrowDetailsSQL);
      }

    /* Deleting record from LibrarianManageBook table */
    $LMBSQL = "DELETE FROM LibrarianManageBook WHERE bISBN='$ISBN';";

    mysqli_query($databaseConn, $LMBSQL);

    /* Deleting record from Book table */
    $bookSQL = "DELETE FROM Book WHERE ISBN='$ISBN';";

    mysqli_query($databaseConn, $bookSQL);

    ?>
      <script>
        alert("Book and connections to this book has been successfully removed.");
      </script>
    <?php

    echo "<script> location.href='librarianDashboard.php'; </script>";

    //header("Location: librarianDashboard.php");

?>
