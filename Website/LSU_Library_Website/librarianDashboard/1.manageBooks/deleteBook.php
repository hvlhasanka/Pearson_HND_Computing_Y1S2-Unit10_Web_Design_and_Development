<?php
  include_once("../../LSULibraryDBConnection.php");

    $ISBN = $_GET['isbn'];

    /* Deleting record from BookAuthor table */
    $bookAuthorSQL = "DELETE FROM BookAuthor WHERE bISBN='$ISBN';";

    $bookAuthorResult = mysqli_query($databaseConn, $bookAuthorSQL);

    /* Deleting record from ReservedBook table */
    $reservedBookSQL = "DELETE FROM ReservedBook WHERE bISBN='$ISBN';";

    $reservedBookResult = mysqli_query($databaseConn, $reservedBookSQL);

      /* Retrieving BorrowDetails ID from the Borrow table */
      $borrowDetailsIDSQL = "SELECT bdBDID FROM Borrow WHERE bISBN = '$ISBN';";

      $borrowDetailsIDResult = mysqli_query($databaseConn, $borrowDetailsIDSQL);

      $borrowDetailsID = "";

      while($borrowDetailsIDRow = mysqli_fetch_array($borrowDetailsIDResult)){

        $borrowDetailsID = $borrowDetailsIDRow['bdBDID'];

        /* Deleting record from Borrow table */
        $borrowSQL = "DELETE FROM Borrow WHERE bID='$borrowDetailsID';";

        $borrowResult = mysqli_query($databaseConn, $borrowSQL);

        /* Deleting record from LibrarianManageBorrowDetails table */
        $LMBDSQL = "DELETE FROM LibrarianManageBorrowDetails WHERE bID='$borrowDetailsID';";

        $LMBDResult = mysqli_query($databaseConn, $LMBDSQL);

        /* Deleting record from BorrowDetails table */
        $borrowDetailsSQL = "DELETE FROM BorrowDetails WHERE bID='$borrowDetailsID';";

        $borrowDetailsResult = mysqli_query($databaseConn, $borrowDetailsSQL);
      }

    /* Deleting record from LibrarianManageBook table */
    $LMBSQL = "DELETE FROM LibrarianManageBook WHERE bISBN='.$ISBN.';";

    $LMBResult = mysqli_query($databaseConn, $LMBSQL);

    /* Deleting record from Book table */
    $bookSQL = "DELETE FROM Book WHERE ISBN='.$ISBN.';";
echo $ISBN;
    $bookResult = mysqli_query($databaseConn, $bookSQL);

    ?>
      <script>
        alert("Record and Connections to this record has been successfully removed.");
      </script>
    <?php

    echo "<script> location.href='librarianDashboard.php'; </script>";
  //  exit;

    //header("Location: librarianDashboard.php");

?>
