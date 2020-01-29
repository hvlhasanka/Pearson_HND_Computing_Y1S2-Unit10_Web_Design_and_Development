<?php
  include_once("LSULibraryDBConnection.php");

  session_start();

  $enteredUsername = $_SESSION['username'];

  $selectedMemberType = $_SESSION['memberType'];

  // Retrieving the lLoginID from the Login table
  $loginIDSQL = "SELECT LoginID FROM Login WHERE Username = '$enteredUsername' AND lutUserTypeID = '$selectedMemberType';";

  $loginIDResult = mysqli_query($databaseConn, $loginIDSQL);

  $loginIDResult = mysqli_fetch_array($loginIDResult);

  $lLoginIDDB = $loginIDResult["LoginID"];

  ?> <script>
    alert("Account is currently <?php echo $loginIDResult; ?>");
  </script> <?php


  // Unassigning value in session variable
  unset($_SESSION['username']);

  unset($_SESSION['memberType']);

  // Removing session variable
  session_destroy();


  // Adding the Logout date time into the database to LoginLogout Table
  $loginSQL = "INSERT INTO LoginLogout (lLoginID) VALUES ('$lLoginIDDB');";

  mysqli_query($databaseConn, $loginSQL);

  // Web page directory after session removal
  echo "<script> location.href='index.php'; </script>";
  exit;
?>
