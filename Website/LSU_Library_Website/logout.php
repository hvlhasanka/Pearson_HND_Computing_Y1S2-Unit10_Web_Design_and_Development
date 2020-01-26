
<?php
  session_start();
  // Unassigning value in session variable
  unset($_SESSION['email']);

  // Removing session variable
  session_destroy();

  // Web page directory after session removal
  header("Location: index.php");
  exit;
?>
