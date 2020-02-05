<?php
  // Starts the SESSION period
  session_start();

  // Checks if the SEESION variables are already assigned and if the membershipType is Librarian (65350003)
  if (!isset($_SESSION['username']) || !isset($_SESSION['membershipType']) || $_SESSION['membershipType'] != "65350003") {
    header("location: ../../logout.php");
  }

  // Retrieving code block for MySQL database connection
  include_once("../../LSULibraryDBConnection.php");

  // Retrieving code block to check if the book reserve time period has exceeded or not
  include_once("../../checkBookReserveTimePeriod.php");


  $userUsername = $_SESSION['username'];

  

  if(isset($_POST['updateSubmit'])){
    $enteredFirstName = $_POST['firstName'];
    $enteredMiddleName = $_POST['middleName'];
    $enteredLastName = $_POST['lastName'];
    $enteredEmailAddress = $_POST['emailAddress'];
    $enteredMobileNumber = $_POST['mobileNumber'];
    $enteredTelephoneNumber = $_POST['telephoneNumber'];
    $enteredStreetAddress = $_POST['streetAddress'];
    $enteredCity = $_POST['city'];
    $selectedProvience = $_POST['provienceSelect'];
    $enteredZipPostalCode = $_POST['zipPostalCode'];
    $enteredUsername = $_POST['username'];

    if(empty($enteredFirstName) || empty($enteredLastName) || empty($enteredEmailAddress) || empty($enteredMobileNumber) ||
      empty($enteredStreetAddress) || empty($enteredCity) || $selectedProvience == "NULL" || empty($enteredZipPostalCode) ||
      empty($enteredUsername)
    ){

      if(strlen($enteredMobileNumber) != 10){
        ?> <script>
          alert("ERROR: Phone Number doesn't have 10 characters");
        </script> <?php
      }

      if(strlen($enteredTelephoneNumber) != 10){
        ?> <script>
          alert("ERROR: Telephone Number doesn't have 10 characters");
        </script> <?php
      }

      if(empty($enteredFirstName)){
        ?> <script>
          alert("ERROR: First Name was not filled");
        </script> <?php
      }

      if(empty($enteredLastName)){
        ?> <script>
          alert("ERROR: Last Name was not filled");
        </script> <?php
      }

      if(empty($enteredEmailAddress)){
        ?> <script>
          alert("ERROR: Email Address was not filled");
        </script> <?php
      }

      if(empty($enteredMobileNumber)){
        ?> <script>
          alert("ERROR: Mobile Number was not filled");
        </script> <?php
      }

      if(empty($enteredStreetAddress)){
        ?> <script>
          alert("ERROR: Street Address was not filled");
        </script> <?php
      }

      if(empty($enteredCity)){
        ?> <script>
          alert("ERROR: City was not filled");
        </script> <?php
      }

      if($selectedProvience == "NULL"){
        ?> <script>
          alert("ERROR: Provience was not selected");
        </script> <?php
      }

      if(empty($enteredZipPostalCode)){
        ?> <script>
          alert("ERROR: Zip/Postal Code was not filled");
        </script> <?php
      }

      if(empty($enteredUsername)){
        ?> <script>
          alert("ERROR: Username was not filled");
        </script> <?php
      }

    }
    else{

      $loginIDSQL = "SELECT LoginID FROM Login WHERE Username = '$userUsername';";
      $loginIDResult = mysqli_query($databaseConn, $loginIDSQL);
      $loginIDRow = mysqli_fetch_array($loginIDResult);
      $loginID = $loginIDRow["LoginID"];

      $userIDSQL = "SELECT * FROM User WHERE lLoginID = '$loginID';";
      $userIDResult = mysqli_query($databaseConn, $userIDSQL);
      $userIDRow = mysqli_fetch_array($userIDResult);
      $userID = $userIDRow["UserID"];

      $userSQL = "UPDATE User SET FirstName = '$enteredFirstName', MiddleName = '$enteredMiddleName',
                  LastName = '$enteredLastName', EmailAddress = '$enteredEmailAddress', MobileNumber = '$enteredMobileNumber',
                  TelephoneNumber = '$enteredTelephoneNumber', StreetAddress = '$enteredStreetAddress', upProvienceID = '$selectedProvience'
                  WHERE lLoginID = '$loginID';";
      mysqli_query($databaseConn, $userSQL);


      // Checking if the newly entered City is already available in the UserCity table
      $checkCity = "";
      $existingCityID = "";
      $checkCitySQL = "SELECT * FROM UserCity;";
      $checkCityResult = mysqli_query($databaseConn, $checkCitySQL);
      while($checkCityRow = mysqli_fetch_array($checkCityResult)){
        if($checkCityRow["City"] == $enteredCity){
          $existingCityID = $checkCityRow["CityID"];
          $checkCity = 1;
          break;
        }
        else if($checkCityRow["City"] != $enteredCity){
          $checkCity = 0;
        }
      }

      if($checkCity == 1){
        // Updating User table with CityID
        $existingCityIDSQL = "UPDATE User SET ucCityID = '$existingCityID' WHERE lLoginID = '$loginID';";
        mysqli_query($databaseConn, $existingCityIDSQL);
      }
      else if($checkCity == 0){
        // Inserting new record into UserCity table
        $insertCity = "INSERT INTO UserCity (City) VALUES ('$enteredCity');";
        mysqli_query($databaseConn, $insertCity);

        // Retrieving CityID of the newly added record
        $retrieveCityIDSQL = "SELECT * FROM UserCity WHERE City = '$enteredCity';";
        $retrieveCityIDResult = mysqli_query($databaseConn, $retrieveCityIDSQL);
        $retrieveCityIDRow = mysqli_fetch_array($retrieveCityIDResult);
        $newCityID = $retrieveCityIDRow["CityID"];

        // Updating User table with the CityID
        $newCityIDSQL = "UPDATE User SET ucCityID = '$newCityID' WHERE lLoginID = '$loginID';";
        mysqli_query($databaseConn, $newCityID);
      }

      // Checking if the entered zipPostalCode is already available in the UserZipPostalCode table.
      $checkZip = "";
      $existingZipID = "";
      $zipDBSQL = "SELECT * FROM UserZipPostalCode;";
      $zipDBResult = mysqli_query($databaseConn, $zipDBSQL);
      while($zipDBRow = mysqli_fetch_array($zipDBResult)){
        if($zipDBRow["ZipPostalCode"] == $enteredZipPostalCode){
          $existingZipID = $zipDBRow["ZPCID"];
          $checkZip = 1;
          break;
        }
        else if($zipDBRow["ZipPostalCode"] != $enteredZipPostalCode){
          $checkCity = 0;
        }
      }

      // Checking if zip value is available in the UserZipPostalCode table
      if($checkZip == 1){
        // Updating User table record with ZPCID for the newly added record
        $zipUpdateSQL = "UPDATE User SET uzpcZPCID = '$existingZipID' WHERE lLoginID = '$loginID';";
        mysqli_query($databaseConn, $zipUpdateSQL);
      }
      else if($checkZip == 0){
        // Inserting new zipPostalCode record into the UserZipPostalCode table
        $zipInsertSQL = "INSERT INTO UserZipPostalCode (ZipPostalCode) VALUES ('$enteredZipPostalCode');";
        mysqli_query($databaseConn, $zipInsertSQL);

        // Retrieving ZPCIDID from the UserZipPostalCode table for the newly added record
        $zipIDDBSQL = "SELECT ZPCID FROM UserZipPostalCode WHERE ZipPostalCode = '$enteredZipPostalCode';";
        $zipIDDBResult = mysqli_query($databaseConn, $zipIDDBSQL);
        $zipIDDBRow = mysqli_fetch_array($zipIDDBResult);
        $zipIDDB = $zipIDDBRow["ZPCID"];

        // Updating User table record with ZPCID for the newly added record
        $zipUpdateSQL = "UPDATE User SET uzpcZPCID = '$zipIDDB' WHERE lLoginID = '$loginID';";
        mysqli_query($databaseConn, $zipUpdateSQL);
      }


      // Updating Login Table
      $loginSQL = "UPDATE Login SET Username = '$enteredUsername' WHERE LoginID = '$loginID';";
      mysqli_query($databaseConn, $loginSQL);

      $_SESSION['username'] = "$enteredUsername";

      ?> <script>
        alert("Account Details successfully updated");
      </script> <?php

      echo "<script> location.href='librarianAccountDetails.php'; </script>";

    }

  }

?>

<!DOCTYPE html>
<html>
  <head>
    <title> LSU Library - Dashboard </title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/png" sizes="1500x1500" href="../../assets/images/LSULibraryLogo.png">

    <!-- Retrieving default layout style sheet -->
    <link rel="stylesheet" href="../../assets/css/defaultLayout.css">

    <!-- Retrieving font-awesome library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
    <script src="../../assets/bootstrap/js/jquery.min.js"></script>
    <script src="../../assets/bootstrap/js/popper.min.js"></script>
    <script src="../../assets/bootstrap/js/bootstrap.min.js"></script>


    <script>
      // jQuery to enable the bootstrap popover implementation
      $(document).ready(function(){
        $('[data-toggle="popover"]').popover();
      });

      // jQuery to enable the bootstrap tooltip implementation
      $(document).ready(function(){
          $('[data-toggle="tooltip"]').tooltip();
      });

    </script>


  </head>
  <body>
    <!-- MAIN SECTION - Begin -->
        <!-- HEADER SECTION - Begin -->
        <div style="height: 140px; width: 100%;">
              <div id="logoSection">

                <a href="../studentProfessorDashboard.php">
                  <img src="../../assets/Images/LSULibraryLogo.png" alt="LSU Library Logo" id="lsuLibraryLogoIcon">
                </a>

                <h1 id="mainTitle"> LSU <span id="mainTitleSpan">Library</span> </h1>

                <p id="mainTitleSub">Lowa State University</p>

                <img src="../../assets/Images/LSUUniversityLogo.png" alt="LSU Logo" id="lsuLogoIcon">

              </div>

              <table id="navSection">
                <tr>
                  <td class="navItem" id="navItem1">
                    <a href="librarianAccountDetails.php" data-toggle="popover" data-trigger="hover" data-placement="bottom" title="Options"
                    data-content="View Account Details" style="color: black;">
                      <?php echo $userUsername ?> &nbsp
                      <i class="fa fa-user" style="font-size: 32px;
                                                  color: #00B1D2FF;"></i> &nbsp
                    </a>
                  </td>

                  <td class="navItem" id="navItem2">
                    <a href="../../logout.php">Logout</a>
                  </td>
                </tr>
              </table>

        </div>

        <!-- HEADER SECTION - End -->


        <!-- BODY SECTION - Begin -->
          <!-- NavBar - Begin -->
            <div style="background-color: #004182;
                        width: 100%;
                        height: 160px;">
              <p style="font-size: 30px;
                        color: white;
                        text-align: center;
                        padding-top: 10px;">Librarian Dashboard</p>

              <!-- Spinner -->
              <div style="position: absolute;
                          left: 50%;
                          transform: translate(-50%,-0%);">
                <div class="spinner-grow text-light" style="height: 80px;
                                                            width: 80px;">
                </div>
              </div>
            </div>

          <!-- Outer Background -->
          <div style="width: 100%;
                      height: 1450px;
                      background-color: #F6F6F6;">

            <button type="button" name="return" style="color: #FFFFFF;
                                                      background-color: #5EAFFF;
                                                      border: 1px solid #5EAFFF;
                                                      padding: 5px;
                                                      border-radius: 5px;
                                                      width: 140px;
                                                      position: absolute;
                                                      top: 340px;
                                                      left: 470px;" onClick="window.location.href = 'librarianAccountDetails.php';">
              <i class="fa fa-arrow-left" style="font-size: 20px;
                                                margin-right: 10px;"></i>
              Return
            </button>


            <div style="width: 55%;
                        height: 1250px;
                        background-color: #FFFFFF;
                        border-radius: 10px;
                        position: relative;
                        left: 50%;
                        transform: translateX(-50%);
                        top: 100px;">

              <p style="font-size: 30px;
                        padding-top: 25px;
                        text-align: center;"><b>Update Details</b></p>


              <style>
                #container{
                  height: 1000px;
                  width: 80%;
                  position: absolute;
                  top: 100px;
                  left: 25%;
                  transition: translateX(-75%);
                }

                .containerMainTextStyle{
                  font-size: 22px;
                }

                .containerSubTextStyle{
                  font-size: 18px;
                  padding-left: 20px;
                }

                .updateFormInput{
                  padding: 10px;
                  border-radius: 7px;
                  width: 300px;
                  margin-top: 10px;
                  margin-left: 12px;;
                  margin-bottom: 20px;
                  border: 1px solid #CCC;
                }

                #updateSubmitButton{
                  padding: 5px;
                  font-size: 20px;
                  border-radius: 5px;
                  margin-top: 30px;
                  margin-left: 38%;
                  margin-right: 10px;
                  background-color: #0081FF;
                  color: #FFFFFF;
                  width: 390px;
                  height: 50px;
                  border: 1px solid #0081FF;
                  position: absolute;
                  left: 15%;
                  transform: translateX(-85%);
                }

                #updateResetButton{
                  padding: 5px;
                  border-radius: 5px;
                  background-color: #DEDEDE;
                  color: #000000;
                  width: 100px;
                  border: 1px solid #DEDEDE;
                  margin-top: 110px;
                  margin-left: -120px;
                }
              </style>

              <?php

                $retrieveDetailsSQL = "SELECT * FROM User u INNER JOIN Login l ON l.LoginID = u.lLoginID
                                      INNER JOIN UserCity uc ON uc.CityID = u.ucCityID
                                      INNER JOIN UserZipPostalCode uzpc ON uzpc.ZPCID = u.uzpcZPCID
                                      INNER JOIN UserProvience up ON up.ProvienceID = u.upProvienceID
                                      WHERE l.Username = '$userUsername';";
                $retrieveDetailsResult = mysqli_query($databaseConn, $retrieveDetailsSQL);
                $retrieveDetailsRow = mysqli_fetch_array($retrieveDetailsResult);

              ?>

              <!-- Main Container -->
              <div id="container">

                <form action="librarianUpdateDetails.php" method="POST">

                  <table>

                    <tr>
                      <td> <p class="containerMainTextStyle">Student Details</p> </td>
                    </tr>
                    <tr>
                      <td> <p class="containerSubTextStyle">First Name: </p> </td>
                      <td>
                        <input type="text" name="firstName" class="updateFormInput" required placeholder="First Name" value="<?php echo $retrieveDetailsRow['FirstName']; ?>"
                        title="Mandatory, Only Uppercase Initials and Lowercase Alphabetic Characters"
                        data-toggle="tooltip" data-placement="right">
                      </td>
                    </tr>
                    <tr>
                      <td> <p class="containerSubTextStyle">Middle Name: </p> </td>
                      <td>
                        <input type="text" name="middleName" class="updateFormInput" placeholder="Middle Name" value="<?php echo $retrieveDetailsRow['MiddleName']; ?>"
                        title="Optional, Only Uppercase Initials and Lowercase Alphabetic Characters"
                        data-toggle="tooltip" data-placement="right">
                      </td>
                    </tr>
                    <tr>
                      <td> <p class="containerSubTextStyle">Last Name: </p> </td>
                      <td>
                        <input type="text" name="lastName" class="updateFormInput" required placeholder="Last Name" value="<?php echo $retrieveDetailsRow['LastName']; ?>"
                        title="Mandatory, Only Uppercase Initials and Lowercase Alphabetic Characters"
                        data-toggle="tooltip" data-placement="right">
                      </td>
                    </tr>
                    <tr>
                      <td> <p class="containerSubTextStyle">Email Address: </p> </td>
                      <td>
                        <input type="text" name="emailAddress" class="updateFormInput" required placeholder="Email Address" value="<?php echo $retrieveDetailsRow['EmailAddress']; ?>"
                        title="Mandatory, Enter valid email address"
                        data-toggle="tooltip" data-placement="right">
                      </td>
                    </tr>
                    <tr>
                      <td> <p class="containerSubTextStyle">Mobile Number: </p> </td>
                      <td>
                        <input type="text" name="mobileNumber" class="updateFormInput" required placeholder="Mobile Number" value="<?php echo $retrieveDetailsRow['MobileNumber']; ?>"
                        title="Mandatory, Only 10 numeric characters"
                        data-toggle="tooltip" data-placement="right">
                      </td>
                    </tr>
                    <tr>
                      <td> <p class="containerSubTextStyle">Telephone Number: </p> </td>
                      <td>
                        <input type="text" name="telephoneNumber" class="updateFormInput" placeholder="Telephone Number" value="<?php echo $retrieveDetailsRow['TelephoneNumber']; ?>"
                        title="Optional, Only 10 numeric characters"
                        data-toggle="tooltip" data-placement="right">
                      </td>
                    </tr>
                    <tr>
                      <td> <p class="containerSubTextStyle">Street Address: </p> </td>
                      <td>
                        <input type="text" name="streetAddress" class="updateFormInput" required placeholder="Street Address" value="<?php echo $retrieveDetailsRow['StreetAddress']; ?>"
                        title="Mandatory, Only Uppercase Initials, Lowercase Alphabetic and Numeric Characters"
                        data-toggle="tooltip" data-placement="right">
                      </td>
                    </tr>
                    <tr>
                      <td> <p class="containerSubTextStyle">City: </p> </td>
                      <td>
                        <input type="text" name="city" class="updateFormInput" required placeholder="City" value="<?php echo $retrieveDetailsRow['City']; ?>"
                        title="Mandatory, Only Uppercase Initials, Lowercase Alphabetic and Numeric Characters"
                        data-toggle="tooltip" data-placement="right">
                      </td>
                    </tr>
                    <tr>
                      <td> <p class="containerSubTextStyle">Zip/Postal Code: </p> </td>
                      <td>
                        <input type="text" name="zipPostalCode" class="updateFormInput" required placeholder="Zip/Postal Code" value="<?php echo $retrieveDetailsRow['ZipPostalCode']; ?>"
                        title="Mandatory, Only 5 Numeric Characters"
                        data-toggle="tooltip" data-placement="right">
                      </td>
                    </tr>
                    <tr>
                      <td> <p class="containerSubTextStyle">Provience: </p> </td>
                      <td>
                        <select name="provienceSelect" class="updateFormInput"
                        title="Mandatory, Select the Provience"
                        data-toggle="tooltip" data-placement="right">
                          <!-- Retrieving the selected provience from the database -->
                          <?php
                              $selectedProvienceID = $retrieveDetailsRow["ProvienceID"];
                              $selectedProvience = $retrieveDetailsRow["Provience"];
                          ?>
                          <!-- Retrieving the proviences from the database -->
                          <?php
                            $provienceSQL = "SELECT * FROM UserProvience;";
                            $provienceResult = mysqli_query($databaseConn, $provienceSQL);
                            while($provienceRow = mysqli_fetch_array($provienceResult)){
                          ?>
                            <option value="<?php echo $provienceRow["ProvienceID"]; ?>"
                              <?php
                                // If the provience is equal to the selected provience, 'selected will be echoed'
                                if($provienceRow["ProvienceID"] == $selectedProvienceID && $provienceRow["Provience"] == $selectedProvience)
                                {
                                  echo "selected";
                                }
                              ?> ><?php echo $provienceRow["Provience"]; ?>
                            </option>
                          <?php } ?>
                        </select>
                      </td>
                    </tr>

                    <tr>
                      <td> <p class="containerMainTextStyle">Login Details</p> </td>
                    </tr>
                    <tr>
                      <td> <p class="containerSubTextStyle">Username: </p> </td>
                      <td>
                        <input type="text" name="username" class="updateFormInput" required placeholder="Username" value="<?php echo $retrieveDetailsRow['Username']; ?>"
                        title="Mandatory, Only Uppercase, Lowercase Alphabetic and Numeric Characters, Minimum Length: 10, Maximum Length: 15"
                        data-toggle="tooltip" data-placement="right">
                      </td>
                    </tr>
                  </table>

                  <button type="submit" name="updateSubmit" id="updateSubmitButton">Update</button>
                  <button type="reset" name="updateReset" id="updateResetButton">Reset</button>

                </form>

              </div>

          </div>
        </div>

        <!-- BODY SECTION - End -->


        <!-- FOOTER SECTION - Begin -->
          <div id="footer">

            <div id="footerLogoSection">

              <img src="../../assets/images/LSULibraryLogo.png" alt="LSU Library Logo" id="lsuLibraryLogoIcon">

              <h1 id="mainTitle"> LSU <span id="mainTitleSpan">Library</span> </h1>

              <p id="mainTitleSub">Lowa State University</p>

              <img src="../../assets/images/LSUUniversityLogo.png" alt="LSU Logo" id="lsuLogoIcon">

            </div>

            <p id="footerText1Main">LSU Library - <span id="footerText1Sub">Lowa State University</span> &copy; 2020</p>
          </div>
        <!-- FOOTER SECTION - End -->

    <!-- MAIN SECTION - End -->
  </body>
</html>
