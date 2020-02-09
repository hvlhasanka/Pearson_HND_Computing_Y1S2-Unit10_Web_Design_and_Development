<!-- Code Developed and Maintained by Hewa Vidanage Lahiru Hasanka -->

<?php

  // Assigning mysqli_connect function parameters to the variables
  $serverName = "localhost";
  $username = "root";
  $password = "";
  $databaseName = "LSULibraryDB";

  // Establishing a MySQL database connection
  $databaseConn = mysqli_connect($serverName, $username, $password, $databaseName);

  // Checking connection
  if(!$databaseConn){
    die("Connection failed: " . mysqli_connect_error());
  }

?>
