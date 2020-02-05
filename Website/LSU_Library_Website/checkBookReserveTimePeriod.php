<?php

  // Retrieving the current datetime
  date_default_timezone_set('Asia/Colombo');
  $currentDateTime = date('Y-m-d h:i:s', time());

  // Checking if the reserved books have reached their time duration of 24 hours
  $retrieveReservedDateTimeSQL = "SELECT ISBN, ReserveDateTime FROM Book;";
  $retrieveReservedDateTimeResult = mysqli_query($databaseConn, $retrieveReservedDateTimeSQL);
  while($retrieveReservedDateTimeRow = mysqli_fetch_array($retrieveReservedDateTimeResult)){
    $bookISBN = $retrieveReservedDateTimeRow["ISBN"];
    $borrowDateTime = $retrieveReservedDateTimeRow["ReserveDateTime"];

    $assignedReturnTimeDuration = strtotime("+24 hour", strtotime($borrowDateTime));

    $assignedReturnDate = date("Y-m-d h:i:s", $assignedReturnTimeDuration);

    if($currentDateTime > $assignedReturnDate){
      // Updating Book table due to expiration of book reserve time period - 24 hours
      $updateReservseSQL = "UPDATE Book SET baAvailabilityID = 55240001, ReserveDateTime = NULL, uUserID_ReservedBy = NULL
                            WHERE ISBN = '$bookISBN';";
      mysqli_query($databaseConn, $updateReservseSQL);
    }
  }

?>
