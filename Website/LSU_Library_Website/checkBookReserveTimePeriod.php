<!-- Code Developed and Maintained by Hewa Vidanage Lahiru Hasanka -->

<?php

  // Retrieving the current datetime
  date_default_timezone_set('Asia/Colombo');
  $currentDateTime = date('Y-m-d h:i:s', time());

  // Checking if the reserved books have reached their time duration of 24 hours
  $retrieveReservedDateTimeSQL = "SELECT ISBN, baAvailabilityID, ReserveDateTime FROM Book;";
  $retrieveReservedDateTimeResult = mysqli_query($databaseConn, $retrieveReservedDateTimeSQL);
  while($retrieveReservedDateTimeRow = mysqli_fetch_array($retrieveReservedDateTimeResult)){
    $bookISBN = $retrieveReservedDateTimeRow["ISBN"];
    $availabilityID = $retrieveReservedDateTimeRow["baAvailabilityID"];
    $borrowDateTime = $retrieveReservedDateTimeRow["ReserveDateTime"];

    $assignedReturnTimeDuration = strtotime("+24 hour", strtotime($borrowDateTime));

    $assignedReturnDate = date("Y-m-d h:i:s", $assignedReturnTimeDuration);

    // Checking if the assigned book availability is set as borrowed.
    if($availabilityID == 55240004){

      if($currentDateTime > $assignedReturnDate){
        // Updating Book table due to expiration of book reserve time period - 24 hours
        $updateReservseSQL = "UPDATE Book SET baAvailabilityID = 55240001, ReserveDateTime = NULL, uUserID_ReservedBy = NULL
                              WHERE ISBN = '$bookISBN';";
        mysqli_query($databaseConn, $updateReservseSQL);
      }

    }

  }

?>
