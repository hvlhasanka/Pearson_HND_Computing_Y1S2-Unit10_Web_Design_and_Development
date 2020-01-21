<?php
  include_once("../../LSULibraryDBConnection.php");

    $ISBN = $_GET['isbn'];

    $deleteBookSQL = "DELETE FROM BookAuthor WHERE bISBN='$ISBN';";

    $deleteBookResult = mysqli_query($databaseConn, $deleteBookSQL);

      ?> <script>
        alert("<?php echo $deleteBookResult; ?>");
      </script> <?php

      header("Location: librarianDashboard.php");

?>
