<?php
  include_once("../LSULibraryDBConnection.php");

  if(isset($_POST['addBookSubmit'])){

    $ISBN = $_POST['isbn'];
    $author1 = $_POST['author1'];

    $addBookSQL = "INSERT INTO BookAuthor VALUES ('$ISBN', '$author1');";

    $addBookResult = mysqli_query($databaseConn, $addBookSQL);

      ?> <script>
        alert("<?php echo $addBookResult; ?>");
      </script> <?php

      header("Location: librarianDashboard.php");

  }

?>
