<?php
  // Starts the SESSION period
  session_start();

//  // Checks if the SEESION variables are already assigned and if the membershipType is Librarian (65350003)
//  if (!isset($_SESSION['username']) || !isset($_SESSION['membershipType']) || $_SESSION['membershipType'] != "65350003") {
//    header("location: ../../logout.php");
//  }

  include_once("../LSULibraryDBConnection.php");


  // Login Process
  if(isset($_POST['submit'])){
    $enteredUsername = $_POST['username'];
    $enteredPassword = $_POST['password'];
    $selectedMembershipType = $_POST['membershipTypeLogin'];

    if(empty($enteredUsername) || empty($enteredPassword) || $selectedMembershipType == "NULL"){
      if(empty($enteredUsername)){
        ?> <script>
          alert("ERROR: Username field was not filled");
        </script> <?php
      }
      if(empty($enteredPassword)){
        ?> <script>
          alert("ERROR: Password field was not filled");
        </script> <?php
      }
      if($selectedMembershipType == "NULL"){
        ?> <script>
          alert("ERROR: Membership type was not selected.");
        </script> <?php
      }
    }
    else{

      $systemLoginSQL = "SELECT * FROM Login WHERE Username = '$enteredUsername' AND lutUserTypeID = '$selectedMembershipType';";
      $systemLoginResult = mysqli_query($databaseConn, $systemLoginSQL);
      $rowCount = mysqli_num_rows($systemLoginResult);
      $passwordDB = "";

      $systemLoginRow = mysqli_fetch_array($systemLoginResult);

      // Retrieving lLoginID of the user from the database
      $lLoginIDDB = $systemLoginRow["LoginID"];

      if($rowCount == 0){
        ?> <script>
          alert("Account Not Available. Please Register");
        </script> <?php
      }
      else if($rowCount == 1){

        // Retrieving the password hash value from the database
        $passwordDB = $systemLoginRow["Password"];

        // Checking if the user entered password and hash value from the database is similar
        if(password_verify($enteredPassword, $passwordDB)){

          // Assigning the username from the database to this variable
          $usernameDB = $systemLoginRow["Username"];

          // Assigning session variables with the details of the current username
          session_start();
          $_SESSION['username'] = $usernameDB;
          $_SESSION['membershipType'] = $selectedMembershipType;
          $_SESSION['start'] = time();
          $_SESSION['expire'] = ($_SESSION['start'] + (240 * 60)); // Current SESSION will be active for four hours only.

          // For userType: Librarian
          if($selectedMembershipType == 65350003){
            header("location: ../librarianDashboard/librarianDashboard.php");
          }


          // For userType: Student and Professor
          if($selectedMembershipType == 65350001 || $selectedMembershipType == 65350002){

            // Checking if the account status (member status) is active
            $accountStatusSQL = "SELECT mms.MemberStatus FROM MemberMemberStatus mms
                                INNER JOIN UniversityMember um ON um.mmsMemberStatusID = mms.MemberStatusID
                                INNER JOIN User u ON u.UserID = um.uUserID
                                WHERE u.lLoginID = '$lLoginIDDB';";
            $accountStatusResult = mysqli_query($databaseConn, $accountStatusSQL);

            $accountStatus = "";

            while($accountStatusRow = mysqli_fetch_array($accountStatusResult)){
              $accountStatus = $accountStatusRow["MemberStatus"];
            }

            if($accountStatus == "Active"){

              header("location: ../studentProfessorDashboard/studentProfessorDashboard.php");

            }
            else{
              ?> <script>
                alert("Account is currently <?php echo $accountStatus; ?>, please contact librarian to resolve this.");
              </script> <?php

              echo "<script> location.href='../logout.php'; </script>";
            }
          }
        }
        else{
          ?> <script>
            alert("Entered credentials are incorrect. Please recheck.");
          </script> <?php
        }
      }
    }
  }

  // Registering new student into the system process
  if(isset($_POST['memberSubmit'])){

    $enteredFirstName = $_POST['firstName'];
    $enteredMiddleName = $_POST['middleName'];
    $enteredLastName = $_POST['lastName'];
    $enteredEmailAddress = $_POST['email'];
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
    $selectedPosition = $_POST['studentPosition'];
    $enteredUsernameS = $_POST['Username'];
    $enteredPasswordS = $_POST['Password'];
    $enteredConfirmPasswordS = $_POST['confirmPassword'];
    $selectedStatus = $_POST['statusSelect'];

    if(empty($enteredFirstName) || empty($enteredLastName) || empty($enteredEmailAddress) || empty($enteredMobileNumber) ||
      empty($enteredStreetAddress) || empty($enteredCity) || $selectedProvience == "NULL" || empty($enteredZipPostalCode) ||
      empty($enteredUniversityNo) || $selectedFaculty == "NULL" || empty($enteredDegreeProgram) || empty($enteredBatch) ||
      $selectedPosition == "NULL" || empty($enteredUsernameS) || empty($enteredPasswordS) || empty($enteredConfirmPasswordS) ||
      $selectedStatus == "NULL" || $enteredPasswordS != $enteredConfirmPasswordS
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

      if(empty($enteredUsernameS)){
        ?> <script>
          alert("ERROR: Username was not filled");
        </script> <?php
      }

      if(empty($enteredPasswordS)){
        ?> <script>
          alert("ERROR: Password was not filled");
        </script> <?php
      }

      if(empty($enteredConfirmPasswordS)){
        ?> <script>
          alert("ERROR: Confirm Password was not filled");
        </script> <?php
      }

      if($selectedStatus == "NULL"){
        ?> <script>
          alert("ERROR: Status was not selected");
        </script> <?php
      }

      if($enteredPasswordS != $enteredConfirmPasswordS){
        ?> <script>
          alert("ERROR: Entered Passwords don't match");
        </script> <?php
      }

    }
    else{

          // Converting enter passowrd value into a hash value to store in the database
          $enteredPasswordHash = password_hash($enteredPasswordS, PASSWORD_DEFAULT);

          // Inserting new record into Login table
          $loginSQL = "INSERT INTO Login (Username, Password, lutUserTypeID) VALUES
                      ('$enteredUsernameS', '$enteredPasswordHash', 65350001);";
          mysqli_query($databaseConn, $loginSQL);

          // Retrieving the LoginID of the newly added recprd from the Login table
          $loginIDSQL = "SELECT LoginID FROM Login WHERE Username = '$enteredUsernameS'
                          AND Password = '$enteredPasswordHash';";
          $loginIDResult = mysqli_query($databaseConn, $loginIDSQL);
          $loginIDRow = mysqli_fetch_array($loginIDResult);
          $loginIDDB = $loginIDRow["LoginID"];

          // Insert new record into the User table
          $userSQL = "INSERT INTO User (FirstName, MiddleName, LastName, EmailAddress,
            StreetAddress, upProvienceID, MobileNumber, TelephoneNumber, lLoginID)
            VALUES ('$enteredFirstName', '$enteredMiddleName', '$enteredLastName', '$enteredEmailAddress',
            '$enteredStreetAddress', '$selectedProvience', '$enteredMobileNumber', '$enteredTelephoneNumber',
            '$loginIDDB');";
          mysqli_query($databaseConn, $userSQL);

          // Retrieving the UserID of the newly added record from the User table
          $userIDDBSQL = "SELECT UserID FROM User WHERE lLoginID = '$loginIDDB';";
          $userIDDBResult = mysqli_query($databaseConn, $userIDDBSQL);
          $userIDDBRow = mysqli_fetch_array($userIDDBResult);
          $userIDDB = $userIDDBRow["UserID"];



        // Checking if the entered city is already available in the UserCity table.
        $checkCity = "";
        $existingCityID = "";
        $cityDBSQL = "SELECT * FROM UserCity";
        $cityDBResult = mysqli_query($databaseConn, $cityDBSQL);
        while($cityDBRow = mysqli_fetch_array($cityDBResult)){
          if($cityDBRow["City"] == $enteredCity){
            $existingCityID = $cityDBRow["CityID"];
            $checkCity = 1;
          }
          else if($cityDBRow["City"] != $enteredCity){
            $checkCity = 0;
          }
        }


        // Checking if the city is already existing in the UserCity table
        if($checkCity == 1){
          // Updating User table record with city ID for the newly added record
          $cityUpdateSQL = "UPDATE User SET ucCityID = '$existingCityID' WHERE UserID = '$userIDDB';";
          mysqli_query($databaseConn, $cityUpdateSQL);
        }
        else if($checkCity == 0){
          // Inserting new city record into the UserCity table
          $cityInsertSQL = "INSERT INTO UserCity (City) VALUES ('$enteredCity');";
          mysqli_query($databaseConn, $cityInsertSQL);

          //Retrieving CityID from the UserCity tsble for the newly added record
          $cityIDDBSQL = "SELECT CityID FROM UserCity WHERE City = '$enteredCity';";
          $cityIDDBResult = mysqli_query($databaseConn, $cityIDDBSQL);
          $cityIDDBRow = mysqli_fetch_array($cityIDDBResult);
          $cityIDDB = $cityIDDBRow["CityID"];

          // Updating User table record with city ID for the newly added record
          $cityUpdateSQL = "UPDATE User SET ucCityID = '$cityIDDB' WHERE UserID = '$userIDDB';";
          mysqli_query($databaseConn, $cityUpdateSQL);
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
          }
          else if($zipDBRow["ZipPostalCode"] != $enteredZipPostalCode){
            $checkCity = 0;
          }
        }

        // Checking if zip value is available in the UserZipPostalCode table
        if($checkZip == 1){
          // Updating User table record with ZPCID for the newly added record
          $zipUpdateSQL = "UPDATE User SET uzpcZPCID = '$existingZipID' WHERE UserID = '$userIDDB';";
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
          $t2 = $zipUpdateSQL = "UPDATE User SET uzpcZPCID = '$zipIDDB' WHERE UserID = '$userIDDB';";
          mysqli_query($databaseConn, $zipUpdateSQL);
        }


          // Insert new record into the UniversityMember table
          $universityMemberSQL = "INSERT INTO UniversityMember (uUserID, UniversityNo, mmtMemberTypeID,
                                  mmsMemberStatusID, mfFacultyID, mpPositionID) VALUES ('$userIDDB',
                                  '$enteredUniversityNo', 44120001, '$selectedStatus',
                                  '$selectedFaculty', '$selectedPosition');";
          mysqli_query($databaseConn, $universityMemberSQL);

          // Inserting new record into the Student table
          $studentSQL = "INSERT INTO Student (umUserID, umUniversityNo)
                        VALUES ('$userIDDB', '$enteredUniversityNo')";
          mysqli_query($databaseConn, $studentSQL);


        // Checking if the entered batch is already available in the StudentBatch Table.
        $checkBatch = "";
        $existingBatchID = "";
        $batchDBSQL = "SELECT * FROM StudentBatch";
        $batchDBResult = mysqli_query($databaseConn, $batchDBSQL);
        while($batchDBRow = mysqli_fetch_array($batchDBResult)){
          if($batchDBRow["Batch"] == $enteredBatch){
            $existingBatchID = $batchDBRow["BatchID"];
            $checkBatch = 1;
          }
          else if($batchDBRow["Batch"] != $enteredBatch){
            $checkBatch = 0;
          }
        }

        // Checking if the entered batch is already available in the StudentBatch Table.
        if($checkBatch == 1){
          // Updating Student table for the newly added records
          $batchUpdateSQL = "UPDATE Student SET sbBatchID = '$existingBatchID' WHERE
                            umUserID = '$userIDDB' AND umUniversityNo = '$enteredUniversityNo';";
          mysqli_query($databaseConn, $batchUpdateSQL);
        }
        else if($checkBatch == 0){
          // Inserting new record into the StudentBatch table
          $studentBatchInsert = "INSERT INTO StudentBatch (Batch) VALUES ('$enteredBatch');";
          mysqli_query($databaseConn, $studentBatchInsert);

          // Retrieving the BatchID from the newly added record
          $batchIDDBSQL = "SELECT BatchID FROM StudentBatch WHERE Batch = '$enteredBatch';";
          $batchIDDBResult = mysqli_query($databaseConn, $batchIDDBSQL);
          $batchIDDBRow = mysqli_fetch_array($batchIDDBResult);
          $batchIDDB = $batchIDDBRow["BatchID"];

          // Updating Student table record with the new batchID
          $studentUpdateSQL = "UPDATE Student SET sbBatchID = '$batchIDDB' WHERE umUserID = '$userIDDB'
                              AND umUniversityNo = '$enteredUniversityNo';";
          mysqli_query($databaseConn, $studentUpdateSQL);
        }



        // Checking if the entered degree program is already available in the StudentDegreeProgram Table.
        $checkProgram = "";
        $existingProgramID = "";
        $programDBSQL = "SELECT * FROM StudentDegreeProgram;";
        $programDBResult = mysqli_query($databaseConn, $programDBSQL);
        while($programDBRow = mysqli_fetch_array($programDBResult)){
          if($programDBRow["DegreeProgram"] == $enteredDegreeProgram){
            $existingProgramID = $programDBRow["DegreeProgramID"];
            $checkProgram = 1;
          }
          else if($programDBRow["DegreeProgram"] != $enteredDegreeProgram){
            $checkProgram = 0;
          }
        }

        // Checking if the entered degree program is already in the StudentDegreeProgram Table.
        if($checkProgram == 1){
          // Updateing the Student record with the DegreeProgramID
          $studentUpdateSQL = "UPDATE Student SET sdpDegreeProgramID = '$existingProgramID'
                              WHERE umUserID = '$userIDDB' AND umUniversityNo = '$enteredUniversityNo';";
          mysqli_query($databaseConn, $studentUpdateSQL);
        }
        else if($checkProgram == 0){
          // Inserting new record into StudentDegreeProgram table
          $degreeInsertSQL = "INSERT INTO StudentDegreeProgram (DegreeProgram)
                              VALUES ('$enteredDegreeProgram');";
          mysqli_query($databaseConn, $degreeInsertSQL);

          // Retrieving DegreeProgramID of the newly added record from the StudentDegreeProgram table
          $degreeProgramIDSQL = "SELECT DegreeProgramID FROM StudentDegreeProgram
                        WHERE DegreeProgram = '$enteredDegreeProgram';";
          $degreeProgramIDResult = mysqli_query($databaseConn, $degreeProgramIDSQL);
          $degreeProgramIDRow = mysqli_fetch_array($degreeProgramIDResult);
          $degreeProgramID = $degreeProgramIDRow["DegreeProgramID"];

          // Updating Student table with the DegreeProgramID for the newly added record
          $degreeUpdatedSQL = "UPDATE Student SET sdpDegreeProgramID = '$degreeProgramID' WHERE umUserID = '$userIDDB'
                              AND umUniversityNo = '$enteredUniversityNo';";
          mysqli_query($databaseConn, $degreeUpdatedSQL);
        }

        ?> <script>
          alert("Student Account has been successfully created. Login is now eligible.");
        </script> <?php

        //echo "<script> location.href='../index.php'; </script>";

    }


  }

?>

<!DOCTYPE html>
<html>
  <head>
    <title> LSU Library - Registration </title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/png" sizes="1500x1500" href="../assets/images/LSULibraryLogo.png">

    <!-- Retrieving default layout style sheet -->
    <link rel="stylesheet" href="../assets/css/defaultLayout.css">

    <!-- Retrieving signPage script  -->
    <script type="text/javascript" src="../assets/javascript/signupPage.js"></script>

    <!-- Retrieving font-awesome library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <script src="../assets/bootstrap/js/jquery.min.js"></script>
    <script src="../assets/bootstrap/js/popper.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>


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

    <style>
    .modal-dialog{
      width: 600px;
    }

    .modal-backdrop{
      background-image: linear-gradient(to right, #9993ff, #86e9fd);
    }

    .formText{
      font-family: 'Roboto', sans-serif;
      font-size: 20px;
      margin-top: 5px;
      margin-left: 50px;
      margin-bottom: 0px;
    }

    .modal-body input[type=text], .modal-body input[type=password], .modal-body select{
      width: 400px;
      padding: 12px;
      padding-left: 60px;
      font-size: 18px;
      border-color:  #dfefff;
      border-radius: 5px;
      margin-top: 2px;
      margin-left: 60px;
      margin-bottom: 10px;
      transition-duration: 0.4s;
    }

    .modal-body input[type=text]:hover, .modal-body input[type=password]:hover, .modal-body select:hover{
      border-color: #00B1D2FF;
      box-shadow: 2px 1px 2px #00B1D2FF;
    }

    .modal-body input[type=submit], .modal-body input[type=reset]{
      font-family: 'Roboto', sans-serif;
      font-size: 20px;
      margin-top: 10px;
      margin-left: 50px;
      padding: 8px;
      border-radius: 7px;
      transition-duration: 0.4s;
      background-color: white;
      border-color: #00B1D2FF;
      width: 200px;
    }

    .modal-body input[type=submit]:hover, .modal-body input[type=reset]:hover{
      background-color: #00B1D2FF;
      color: white;
    }

    .modal-body i{
      font-size: 30px;
      color: #00B1D2FF;
      position: relative;
      top: 5px;
      left: 110px;
    }

    #remeberMeText{
      font-size: 15px;
      padding-top: 5px;
      padding-bottom: 15px;
    }

    #forgotPasswordText a{
      font-size: 15px;
      color: #00B1D2FF;
      text-decoration: none;
    }

    .modal-footer p{
      font-family: 'Roboto', sans-serif;
      font-size: 15px;
    }

    .modal-footer p a{
      text-decoration: none;
      color: #00B1D2FF;
    }

    #signupFormButton{
      width: 450px;
      margin-top: 20px;
      margin-bottom: 20px;
    }


    </style>

  </head>
  <body  onload="displayFillAllMandatoryFieldsMessage();">
    <!-- MAIN SECTION - Begin -->
        <!-- HEADER SECTION - Begin -->
        <div style="height: 140px; width: 100%;">
              <div id="logoSection">

                <img src="../assets/Images/LSULibraryLogo.png" alt="LSU Library Logo" id="lsuLibraryLogoIcon">

                <h1 id="mainTitle"> LSU <span id="mainTitleSpan">Library</span> </h1>

                <p id="mainTitleSub">Lowa State University</p>

                <img src="../assets/Images/LSUUniversityLogo.png" alt="LSU Logo" id="lsuLogoIcon">

              </div>

              <table id="navSection">
                <tr>
                  <td class="navItem" id="navItem2">
                    <td class="navItem" id="navItem2"> <a href="#" data-toggle="modal" data-target="#loginFormModel">Login</a> </td>
                  </td>
                </tr>
              </table>

        </div>

        <!-- Login Form Modal - Begin -->
          <!-- Modal -->
          <div class="modal fade" id="loginFormModel">
            <div class="modal-dialog modal-lg modal-dialog-centered">
              <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                  <h4 class="modal-title">Login to LSU Library Management System</h4>
                  <button type="button" data-dismiss="modal" class="close">
                    <span>&times;</span>
                  </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                  <form method="POST" action="signupStudentPage.php">
                    <p class="formText">Username </p>
                    <i class="fa fa-user-circle-o"></i>
                    <input type="text" name="username" placeholder="Enter your USERNAME" required>

                    <p class="formText">Password </p>
                    <i class="fa fa-key"></i>
                    <input type="password" name="password" placeholder="Enter your PASSWORD" required>

                    <p class="formText">Membership Type </p>
                    <i class="fa fa-group"></i>
                    <select name="membershipTypeLogin">
                      <option value="NULL" selected>Select a Category</option>
                      <option value="65350001">Student</option>
                      <option value="65350002">Professor</option>
                      <option value="65350003">Librarian</option>
                    </select>
                    <br>

                    <p class="formText" id="remeberMeText">
                      <input type="checkbox" name="rememberMe">
                      Remember Me
                    </p>

                    <input type="submit" name="submit" value="Login">
                    <input type="reset" name="reset" value="Clear">

                    <p class="formText" id="forgotPasswordText">
                      <a href="#">Forgot your password?</a>
                    </p>

                  </form>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                  <p>Don't have an account? <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#signupFormModel">SignUp></a></p>
                </div>

              </div>
            </div>
          </div>
        <!-- Login Form Modal - End -->

        <!-- HEADER SECTION - End -->


        <!-- BODY SECTION - Begin -->
          <!-- NavBar - Begin -->
            <div style="background-color: #004182;
                        width: 100%;
                        height: 120px;">
              <p style="font-size: 30px;
                        color: white;
                        text-align: center;
                        padding-top: 35px;">Member Registration</p>

            </div>

          <!-- Outer Background -->
          <div style="width: 100%;
                      height: 1615px;
                      background-color: #F6F6F6;">


            <button type="button" name="return" style="color: #FFFFFF;
                                                      background-color: #5EAFFF;
                                                      border-color: #5EAFFF;
                                                      padding: 5px;
                                                      border-radius: 5px;
                                                      width: 140px;
                                                      position: absolute;
                                                      top: 300px;
                                                      left: 470px;" onClick="window.location.href = '../index.php';">
              <i class="fa fa-arrow-left" style="font-size: 20px;
                                                margin-right: 10px;"></i>
              Return
            </button>

            <div style="width: 55%;
                        height: 1450px;
                        background-color: #FFFFFF;
                        border-radius: 10px;
                        position: relative;
                        left: 50%;
                        transform: translateX(-50%);
                        top: 100px;">

              <p style="font-size: 30px;
                        padding-top: 25px;
                        text-align: center;"><b>Student Membership</b></p>

              <style>
                #signupForm{
                  height: 1000px;
                  width: 80%;
                  position: absolute;
                  top: 100px;
                  left: 15%;
                  transition: translateX(-85%);
                }

                .formText{
                  font-size: 18px;
                  padding-left: 60px;
                  padding-bottom: 10px;
                }

                .formInput{
                  padding: 10px;
                  border-radius: 7px;
                  width: 250px;
                  margin-top: 0px;
                  margin-left: 95px;;
                  margin-bottom: 20px;
                  border-color: #ccc;
                }

                .mandatoryAsterisk{
                  color: red;
                  font-size: 20px;
                  font-weight: bold;
                  position: absolute;
                }

                #submitButton{
                  padding: 5px;
                  border-radius: 5px;
                  margin-left: 50%;
                  margin-right: 10px;
                  background-color: #0081FF;
                  color: #FFFFFF;
                  width: 100px;
                  border-color: #0081FF;
                }

                #resetButton{
                  padding: 5px;
                  border-radius: 5px;
                  background-color: #DEDEDE;
                  color: #000000;
                  width: 100px;
                  border-color: #DEDEDE;
                }

              </style>

              <!-- Signup Form SECTION - Begin -->
              <div id="signupForm">
                <form action="signupStudentPage.php" method="POST" onSubmit="return confirm('Are all the entered details accurate?');">

                  <p class="formText">Full Name</p>
                      <input type="text" name="firstName" placeholder="First Name" class="formInput" required
                      title="Mandatory, Only Uppercase Initials and Lowercase Alphabetic Characters"
                      data-toggle="tooltip" data-placement="left">
                      <p class="mandatoryAsterisk" style="top: 40px;
                                                          left: 326px;">*</p>

                      <input type="text" name="middleName" placeholder="Middle Name" class="formInput"
                      title="Optional, Only Uppercase Initials and Lowercase Alphabetic Characters"
                      data-toggle="tooltip" data-placement="left"
                      style="margin-left: 20px;">

                    <br>
                      <input type="text" name="lastName" placeholder="Last Name" class="formInput" required
                      title="Mandatory, Only Uppercase Initials and Lowercase Alphabetic Characters"
                      data-toggle="tooltip" data-placement="left"
                      style="width: 527px;">
                      <p class="mandatoryAsterisk" style="top: 108px;
                                                          left: 605px;">*</p>

                  <p class="formText">Email Address</p>
                    <input type="email" name="email" placeholder="eg:- sample@provider.com" class="formInput" required
                    title="Mandatory, Enter valid email address"
                    data-toggle="tooltip" data-placement="left">
                    <p class="mandatoryAsterisk" style="top: 216px;
                                                        left: 328px;">*</p>

                  <p class="formText">Phone Number</p>
                    <input type="number" name="mobileNumber" placeholder="Mobile Number" class="formInput" required
                    title="Mandatory, Only 10 numeric characters"
                    data-toggle="tooltip" data-placement="left">
                    <p class="mandatoryAsterisk" style="top: 328px;
                                                        left: 328px;">*</p>

                    <input type="number" name="telephoneNumber" placeholder="Telephone Number" class="formInput"
                    style="margin-left: 20px;"
                    title="Optional, Only 10 numeric characters"
                    data-toggle="tooltip" data-placement="left">

                  <p class="formText">Address</p>
                    <input type="text" name="streetAddress" placeholder="Street Address" class="formInput" required
                    title="Mandatory, Only Uppercase Initials, Lowercase Alphabetic and Numeric Characters"
                    data-toggle="tooltip" data-placement="left">
                    <p class="mandatoryAsterisk" style="top: 438px;
                                                        left: 328px;">*</p>

                    <input type="text" name="city" placeholder="City" class="formInput" required
                    style="margin-left: 20px;"
                    title="Mandatory, Only Uppercase Initials, Lowercase Alphabetic and Numeric Characters"
                    data-toggle="tooltip" data-placement="left">
                    <p class="mandatoryAsterisk" style="top: 438px;
                                                        left: 603px;">*</p>

                    <br>

                    <select name="provienceSelect" class="formInput"
                    title="Mandatory, Select the Provience"
                    data-toggle="tooltip" data-placement="left">
                      <option value="NULL">Provience</option>
                      <option value="24140001">Central</option>
                      <option value="24140002">Eastern</option>
                      <option value="24140003">North Central</option>
                      <option value="24140004">Northern</option>
                      <option value="24140005">North Western</option>
                      <option value="24140006">Sabaragamuwa</option>
                      <option value="24140007">Southern</option>
                      <option value="24140008">Uva</option>
                      <option value="24140009">Western</option>
                    </select>
                    <p class="mandatoryAsterisk" style="top: 504px;
                                                        left: 328px;">*</p>

                    <input type="text" name="zipPostalCode" placeholder="Zip/Postal Code" class="formInput"
                    style="margin-left: 20px;" required
                    title="Mandatory, Only Numeric Characters"
                    data-toggle="tooltip" data-placement="left">
                    <p class="mandatoryAsterisk" style="top: 504px;
                                                        left: 603px;">*</p>

                  <p class="formText">University Information</p>
                    <input type="text" name="universityIndexNo" placeholder="University Index No" class="formInput"
                    title="Mandatory, Enter only numeric characters" required
                    data-toggle="tooltip" data-placement="left">
                    <p class="mandatoryAsterisk" style="top: 614px;
                                                        left: 328px;">*</p>


                    <select name="facultySelect" class="formInput"
                    style="margin-left: 20px;"
                    title="Mandatory, Select the Faculty"
                    data-toggle="tooltip" data-placement="left">
                      <option value="NULL">Faculty</option>
                      <?php
                        // Retrieving the faculties from the database, MemberFaculty table
                        $facultySQL = "SELECT * FROM MemberFaculty;";
                        $facultyResult = mysqli_query($databaseConn, $facultySQL);
                        while($facultyRow = mysqli_fetch_array($facultyResult)){
                      ?>
                      <option value="<?php echo $facultyRow["FacultyID"];?>"><?php echo $facultyRow["Faculty"];} ?></option>
                    </select>
                    <p class="mandatoryAsterisk" style="top: 614px;
                                                        left: 603px;">*</p>

                    <br>

                    <input type="text" name="degreeProgram" placeholder="Degree Program" class="formInput" required
                    title="Mandatory, Only Uppercase Initials, Lowercase Alphabetic and Numeric Characters"
                    data-toggle="tooltip" data-placement="left">
                    <p class="mandatoryAsterisk" style="top: 685px;
                                                        left: 328px;">*</p>

                    <input type="text" name="batch" placeholder="Batch (eg:- Spring 2017)" class="formInput"
                    style="margin-left: 20px;" required
                    title="Mandatory,  Only Uppercase Initials, Lowercase Alphabetic and Numeric Characters"
                    data-toggle="tooltip" data-placement="left">
                    <p class="mandatoryAsterisk" style="top: 685px;
                                                        left: 603px;">*</p>

                    <br>

                    <select name="studentPosition" class="formInput"
                    title="Mandatory,  Select the Position"
                    data-toggle="tooltip" data-placement="left">
                      <option value="NULL">Position</option>
                      <option value="92130001">Undergraduate Student</option>
                      <option value="92130002">Postgraduate Student</option>
                      <option value="92130003">Alumni</option>
                    </select>
                    <p class="mandatoryAsterisk" style="top: 750px;
                                                        left: 328px;">*</p>

                  <p class="formText">Login Credentails</p>
                    <input type="text" name="Username" placeholder="Username" class="formInput" required
                    title="Mandatory, Only Uppercase, Lowercase Alphabetic and Numeric Characters, Minimum Length: 10, Maximum Length: 15"
                    data-toggle="tooltip" data-placement="left">
                    <p class="mandatoryAsterisk" style="top: 858px;
                                                        left: 328px;">*</p>

                    <br>

                    <input type="password" name="Password" placeholder="Enter Password" class="formInput" required
                    title="Mandatory, Only Uppercase, Lowercase Alphabetic Characters, One Numeric and One Special Character, Minimum Length: 10, Maximum Length: 20"
                    data-toggle="tooltip" data-placement="left">
                    <p class="mandatoryAsterisk" style="top: 925px;
                                                        left: 328px;">*</p>

                    <input type="password" name="confirmPassword" placeholder="Confirm Password" class="formInput"
                    style="margin-left: 20px;" required
                    title="Mandatory, Only Uppercase, Lowercase Alphabetic Characters, One Numeric and One Special Character, Minimum Length: 10, Maximum Length: 20"
                    data-toggle="tooltip" data-placement="left">
                    <p class="mandatoryAsterisk" style="top: 925px;
                                                        left: 603px;">*</p>

                    <br>

                    <select name="statusSelect" class="formInput"
                    title="Mandatory, Select the Status"
                    data-toggle="tooltip" data-placement="left">
                      <option value="NULL">Status</option>
                      <?php
                        // Retrieving the status from the database, MemberStatus table
                        $statusSQL = "SELECT * FROM MemberMemberStatus;";
                        $statusResult = mysqli_query($databaseConn, $statusSQL);
                        while($statusRow = mysqli_fetch_array($statusResult)){
                      ?>
                      <option value="<?php echo $statusRow["MemberStatusID"];?>"><?php echo $statusRow["MemberStatus"];} ?></option>
                    </select>
                    <p class="mandatoryAsterisk" style="top: 992px;
                                                        left: 328px;">*</p>
                    </select>


                    <div class="formText">
                      <p style="margin-top: 20px;
                                text-decoration: underline;">Terms and Conditions</p>
                      <p>Please read through the <a href="#">Terms and Conditions</a> and tick the below <br>box to continue the registration</p>
                      <input type="checkbox" name="tAndCAgreement" title="Mandatory, Tick Checkbox if agree" required
                        data-toggle="tooltip" data-placement="left" style="height: 20px;
                                                                            width: 20px;">
                      <p style="position: absolute;
                                left: 140px;
                                top: 1190px;"
                                title="Mandatory, Tick Checkbox if agree"
                                data-toggle="tooltip" data-placement="left">I have read and I agree to the Terms and Conditions</p>
                    </div>

                  <br>

                  <br>
                  <button type="submit" name="memberSubmit" id="submitButton">Submit</button>
                  <button type="reset" name="memberReset" id="resetButton">Reset</button>

                </form>
              </div>
            <!-- Signup Form SECTION - End -->
            </div>
          </div>
        <!-- BODY SECTION - End -->


        <!-- FOOTER SECTION - Begin -->
          <div id="footer">

            <div id="footerLogoSection">

              <img src="../assets/images/LSULibraryLogo.png" alt="LSU Library Logo" id="lsuLibraryLogoIcon">

              <h1 id="mainTitle"> LSU <span id="mainTitleSpan">Library</span> </h1>

              <p id="mainTitleSub">Lowa State University</p>

              <img src="../assets/images/LSUUniversityLogo.png" alt="LSU Logo" id="lsuLogoIcon">

            </div>

            <p id="footerText1Main">LSU Library - <span id="footerText1Sub">Lowa State University</span> &copy; 2020</p>
          </div>
        <!-- FOOTER SECTION - End -->

    <!-- MAIN SECTION - End -->
  </body>
</html>
