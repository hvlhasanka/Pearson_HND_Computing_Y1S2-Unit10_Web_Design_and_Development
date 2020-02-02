<?php
  // Starts the SESSION period
  session_start();

  // Checks if the SEESION variables are already assigned and if the membershipType is Librarian (65350003)
  if (!isset($_SESSION['username']) || !isset($_SESSION['membershipType']) || $_SESSION['membershipType'] != "65350001") {
    header("location: ../../logout.php");
  }

  $userUsername = $_SESSION['username'];

  include_once("../../LSULibraryDBConnection.php");

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
    $enteredUniversityNo = $_POST['universityIndexNo'];
    $selectedFaculty = $_POST['facultySelect'];
    $enteredDegreeProgram = $_POST['degreeProgram'];
    $enteredBatch = $_POST['batch'];
    $selectedPosition = $_POST['positionSelect'];
    $enteredUsername = $_POST['username'];

    if(empty($enteredFirstName) || empty($enteredLastName) || empty($enteredEmailAddress) || empty($enteredMobileNumber) ||
      empty($enteredStreetAddress) || empty($enteredCity) || $selectedProvience == "NULL" || empty($enteredZipPostalCode) ||
      empty($enteredUniversityNo) || $selectedFaculty == "NULL" || empty($enteredDegreeProgram) || empty($enteredBatch) ||
      $selectedPosition == "NULL" || empty($enteredUsername)
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

      if(empty($enteredUniversityNo)){
        ?> <script>
          alert("ERROR: University Index No was not filled");
        </script> <?php
      }

      if($selectedFaculty == "NULL"){
        ?> <script>
          alert("ERROR: Faculty was not selected");
        </script> <?php
      }

      if(empty($enteredDegreeProgram)){
        ?> <script>
          alert("ERROR: Degree Program was not filled");
        </script> <?php
      }

      if(empty($enteredBatch)){
        ?> <script>
          alert("ERROR: Batch was not filled");
        </script> <?php
      }

      if($selectedPosition == "NULL"){
        ?> <script>
          alert("ERROR: Position was not selected");
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


      $userSQL = "UPDATE User SET FirstName = '$enteredFirstName', MiddleName = '$enteredMiddleName',
                  LastName = '$enteredLastName', EmailAddress = '$enteredEmailAddress', MobileNumber = '$enteredMobileNumber',
                  TelephoneNumber = '$enteredTelephoneNumber', StreetAddress = '$enteredStreetAddress', LastName = '$enteredLastName'
                  WHERE lLoginID = '$loginID';";
      mysqli_query($databaseConn, $userSQL);


      // Checking if the newly entered City is already available in the UserCity table
      $checkCity = "";
      $existingCityID = "";
      $checkCitySQL = "SELECT * FROM UserCity";
      $checkCityResult = mysqli_query($databaseConn, $checkCitySQL);
      while($checkCityRow = mysqli_fetch_array($checkCityResult)){
        if($checkCityRow["City"] == $enteredCity){
          $existingCityID = ["CityID"];
          $checkCity = 1;
        }
        else if($checkCityRow["City"] != $enteredCity){
          $checkCity = 0;
        }
      }

      if($checkCity == 1){
        // Updating User table with CityID
        $existingCityIDSQL = "UPDATE User ucCityID = '$existingCityID' WHERE lLoginID = '$loginID';";
        mysqli_query($databaseConn, $existingCityIDSQL);
      }
      else if($checkCity == 0){

      }



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
                    <a href="accountDetails.php" data-toggle="popover" data-trigger="hover" data-placement="bottom" title="Options"
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
                        padding-top: 10px;">Member Dashboard</p>
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
                      height: 1900px;
                      background-color: #F6F6F6;">

            <button type="button" name="return" style="color: #FFFFFF;
                                                      background-color: #5EAFFF;
                                                      border-color: #5EAFFF;
                                                      padding: 5px;
                                                      border-radius: 5px;
                                                      width: 140px;
                                                      position: absolute;
                                                      top: 340px;
                                                      left: 470px;" onClick="window.location.href = 'accountDetails.php';">
              <i class="fa fa-arrow-left" style="font-size: 20px;
                                                margin-right: 10px;"></i>
              Return
            </button>


            <div style="width: 55%;
                        height: 1690px;
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
                  border-color: #0081FF;
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
                  border-color: #DEDEDE;
                  margin-top: 110px;
                  margin-left: -120px;
                }
              </style>

              <?php

                $retrieveDetailsSQL = "SELECT * FROM User u INNER JOIN Login l ON l.LoginID = u.lLoginID
                                    INNER JOIN UserCity uc ON uc.CityID = u.ucCityID
                                    INNER JOIN UserZipPostalCode uzpc ON uzpc.ZPCID = u.uzpcZPCID
                                    INNER JOIN UserProvience up ON up.ProvienceID = u.upProvienceID
                                    INNER JOIN UniversityMember um ON um.uUserID = u.UserID
                                    INNER JOIN MemberMemberType mmt ON mmt.MemberTypeID = um.mmtMemberTypeID
                                    INNER JOIN MemberFaculty mf ON mf.FacultyID = um.mfFacultyID
                                    INNER JOIN Student s ON s.umUserID = um.uUserID AND s.umUniversityNo = um.UniversityNo
                                    INNER JOIN StudentDegreeProgram sdp ON sdp.DegreeProgramID = s.sdpDegreeProgramID
                                    INNER JOIN StudentBatch sb ON sb.BatchID = s.sbBatchID
                                    INNER JOIN MemberPosition mp ON mp.PositionID = um.mpPositionID
                                    INNER JOIN MemberMemberStatus mms ON mms.MemberStatusID = um.mmsMemberStatusID
                                    WHERE l.Username = '$userUsername';";
                $retrieveDetailsResult = mysqli_query($databaseConn, $retrieveDetailsSQL);
                $retrieveDetailsRow = mysqli_fetch_array($retrieveDetailsResult);

              ?>

              <!-- Main Container -->
              <div id="container">

                <form action="updateDetails.php" method="POST">

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
                            <option value="<?php echo $provienceRow["AvailabilityID"]; ?>"
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
                      <td> <p class="containerMainTextStyle">University Details</p> </td>
                    </tr>
                    <tr>
                      <td> <p class="containerSubTextStyle">University Index No: </p> </td>
                      <td>
                        <input type="text" name="universityIndexNo" class="updateFormInput" required readonly placeholder="University Index No" value="<?php echo $retrieveDetailsRow['UniversityNo']; ?>"
                        title="Not Editable"
                        data-toggle="tooltip" data-placement="right">
                      </td>
                    </tr>
                    <tr>
                      <td> <p class="containerSubTextStyle">Faculty: </p> </td>
                      <td>
                        <select name="facultySelect" class="updateFormInput"
                        title="Mandatory, Select the Faculty"
                        data-toggle="tooltip" data-placement="right">
                          <!-- Retrieving the selected faculty from the database -->
                          <?php
                              $selectedFacultyID = $retrieveDetailsRow["FacultyID"];
                              $selectedFaculty = $retrieveDetailsRow["Faculty"];
                          ?>
                          <!-- Retrieving the faculties from the database -->
                          <?php
                            $facultySQL = "SELECT * FROM MemberFaculty;";
                            $facultyResult = mysqli_query($databaseConn, $facultySQL);
                            while($facultyRow = mysqli_fetch_array($facultyResult)){
                          ?>
                            <option value="<?php echo $facultyRow["FacultyID"]; ?>"
                              <?php
                                // If the provience is equal to the selected faculty, 'selected will be echoed'
                                if($facultyRow["FacultyID"] == $selectedFacultyID && $facultyRow["Faculty"] == $selectedFaculty)
                                {
                                  echo "selected";
                                }
                              ?> ><?php echo $facultyRow["Faculty"]; ?>
                            </option>
                          <?php } ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td> <p class="containerSubTextStyle">Degree Program: </p> </td>
                      <td>
                        <input type="text" name="degreeProgram" class="updateFormInput" required placeholder="Degree Program" value="<?php echo $retrieveDetailsRow['DegreeProgram']; ?>"
                        title="Mandatory, Only Uppercase Initials, Lowercase Alphabetic and Numeric Characters"
                        data-toggle="tooltip" data-placement="right">
                      </td>
                    </tr>
                    <tr>
                      <td> <p class="containerSubTextStyle">Batch: </p> </td>
                      <td>
                        <input type="text" name="batch" class="updateFormInput" required placeholder="Batch" value="<?php echo $retrieveDetailsRow['Batch']; ?>"
                        title="Mandatory,  Only Uppercase Initials, Lowercase Alphabetic and Numeric Characters"
                        data-toggle="tooltip" data-placement="right">
                      </td>
                    </tr>
                    <tr>
                      <td> <p class="containerSubTextStyle">Position: </p> </td>
                      <td>
                        <select name="positionSelect" class="updateFormInput"
                        title="Mandatory, Select the Position"
                        data-toggle="tooltip" data-placement="right">
                          <!-- Retrieving the selected position from the database -->
                          <?php
                              $selectedPositionID = $retrieveDetailsRow["PositionID"];
                              $selectedPosition = $retrieveDetailsRow["Position"];
                          ?>
                            <option value="92130001"
                              <?php
                                // If the provience is equal to the selected position, 'selected will be echoed'
                                if(92130001 == $selectedPositionID && "Undergraduate" == $selectedPosition)
                                {
                                  echo "selected";
                                }
                              ?> >Undergraduate
                            </option>
                            <option value="92130002"
                              <?php
                                // If the provience is equal to the selected position, 'selected will be echoed'
                                if(92130002 == $selectedPositionID && "Postgraduate" == $selectedPosition)
                                {
                                  echo "selected";
                                }
                              ?> >Postgraduate
                            </option>
                            <option value="92130003"
                              <?php
                                // If the provience is equal to the selected position, 'selected will be echoed'
                                if(92130003 == $selectedPositionID && "Alumni" == $selectedPosition)
                                {
                                  echo "selected";
                                }
                              ?> >Alumni
                            </option>
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
