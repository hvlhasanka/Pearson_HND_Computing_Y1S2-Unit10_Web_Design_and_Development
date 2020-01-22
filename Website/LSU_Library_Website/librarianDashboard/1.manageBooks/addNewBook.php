<?php
  include_once("../LSULibraryDBConnection.php");

  if(isset($_POST['addBookSubmit'])){

    $ISBN = $_POST['isbn'];
    $Name = $_POST['name'];
    $author1 = $_POST['author1'];
    $author1 = $_POST['author2'];
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

    $addBookSQL = "INSERT INTO BookAuthor VALUES ('$ISBN', '$author1');";

    $addBookResult = mysqli_query($databaseConn, $addBookSQL);

      ?> <script>
        alert("<?php echo $addBookResult; ?>");
      </script> <?php

      header("Location: librarianDashboard.php");

  }

?>
