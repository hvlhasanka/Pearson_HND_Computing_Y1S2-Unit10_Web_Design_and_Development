<?php
  // Starts the SESSION period
  session_start();

  // Checks if the SEESION variables are already assigned and if the membershipType is Librarian (65350003)
  if (!isset($_SESSION['username']) || !isset($_SESSION['membershipType']) || $_SESSION['membershipType'] != "65350001") {
    header("location: ../../logout.php");
  }

  $userUsername = $_SESSION['username'];

  include_once("../../LSULibraryDBConnection.php");

  // Process of changing the password
  if(isset($_POST['cPasswordSubmit'])){

    $enteredCurrentPassword = $_POST['currentPassword'];
    $enteredNewPassword = $_POST['newPassword'];
    $enteredCNewPassword = $_POST['confirmNewPassword'];

    if(empty($enteredCurrentPassword) || empty($enteredNewPassword) || empty($enteredCNewPassword) || $enteredNewPassword != $enteredCNewPassword){

      if(empty($enteredCurrentPassword)){
        ?> <script>
          alert("ERROR: Current Password field was not filled.");
        </script> <?php
      }

      if(empty($enteredNewPassword)){
        ?> <script>
          alert("ERROR: New Password field was not filled.");
        </script> <?php
      }

      if(empty($enteredCNewPassword)){
        ?> <script>
          alert("ERROR: Confirm New Password field was not filled.");
        </script> <?php
      }

      if($enteredNewPassword != $enteredCNewPassword){
        ?> <script>
          alert("ERROR: Entered New Passwords don't match");
        </script> <?php
      }

    }
    else{

      $currentPasswordHashDBSQL = "SELECT Password FROM Login WHERE Username = '$userUsername';";
      $currentPasswordHashDBResult = mysqli_query($databaseConn, $currentPasswordHashDBSQL);
      $currentPasswordHashDBRow = mysqli_fetch_array($currentPasswordHashDBResult);
      $currentPasswordHashDB = $currentPasswordHashDBRow['Password'];

      // Checking if the enter current password is same as hash value that is already existing in the database
      if(password_verify($enteredCurrentPassword, $currentPasswordHashDB)){

        // Converting entered new password value into a hash value to check value from the database
        $enteredNewPasswordHash = password_hash($enteredNewPassword, PASSWORD_DEFAULT);

        $updatePasswordSQL = "UPDATE Login SET Password = '$enteredNewPasswordHash' WHERE Username = '$userUsername';";
        mysqli_query($databaseConn, $updatePasswordSQL);

        ?> <script>
          alert("Password successfully updated.");
        </script> <?php

        echo "<script> location.href='accountDetails.php'; </script>";

      }
      else{
        ?> <script>
          alert("ERROR: Entered current password is invalid");
        </script> <?php
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

    <!-- Retrieving signPage script  -->
    <script type="text/javascript" src="../../assets/javascript/signupPage.js"></script>

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
  <body onload="displayFillAllMandatoryFieldsMessage();">
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
                      height: 1000px;
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
                        height: 520px;
                        background-color: #FFFFFF;
                        border-radius: 10px;
                        position: relative;
                        left: 50%;
                        transform: translateX(-50%);
                        top: 100px;">

              <p style="font-size: 30px;
                        padding-top: 25px;
                        text-align: center;"><b>Change Password</b></p>


              <style>
                #container{
                  height: 1000px;
                  width: 80%;
                  position: absolute;
                  top: 100px;
                  left: 25%;
                  transition: translateX(-75%);
                }

                .updateFormText{
                  font-size: 18px;
                  padding-left: 75px;
                }

                .updateFormInput{
                  padding: 10px;
                  border-radius: 7px;
                  width: 300px;
                  margin-top: -10px;
                  margin-left: 120px;;
                  margin-bottom: 20px;
                  border: 1px solid #CCC;
                }

                #updateSubmitButton{
                  padding: 5px;
                  border-radius: 5px;
                  margin-top: 80px;
                  margin-left: 38%;
                  margin-right: 10px;
                  background-color: #0081FF;
                  color: #FFFFFF;
                  width: 300px;
                  height: 50px;
                  border-color: #0081FF;
                  position: absolute;
                  left: 9%;
                  transform: translateX(-91%);
                }

                .mandatoryAsterisk{
                  color: red;
                  font-size: 20px;
                  font-weight: bold;
                  position: absolute;
                }

              </style>

              <!-- Main Container -->
              <div id="container">

                <form action="changePassword.php" method="POST">

                  <p class="updateFormText">Current Password: </p>
                  <input type="password" name="currentPassword" required class="updateFormInput"
                  title="Mandatory, Only Uppercase, Lowercase Alphabetic Characters, One Numeric and One Special Character, Minimum Length: 10, Maximum Length: 20"
                  data-toggle="tooltip" data-placement="left">
                  <p class="mandatoryAsterisk" style="top: 30px;
                                                      left: 405px;">*</p>

                  <p class="updateFormText">New Password: </p>
                  <input type="password" name="newPassword" required class="updateFormInput"
                  title="Mandatory, Only Uppercase, Lowercase Alphabetic Characters, One Numeric and One Special Character, Minimum Length: 10, Maximum Length: 20"
                  data-toggle="tooltip" data-placement="left">
                  <p class="mandatoryAsterisk" style="top: 130px;
                                                      left: 405px;">*</p>

                  <p class="updateFormText">Confirm New Password: </p>
                  <input type="password" name="confirmNewPassword" required class="updateFormInput"
                  title="Mandatory, Only Uppercase, Lowercase Alphabetic Characters, One Numeric and One Special Character, Minimum Length: 10, Maximum Length: 20"
                  data-toggle="tooltip" data-placement="left">
                  <p class="mandatoryAsterisk" style="top: 228px;
                                                      left: 405px;">*</p>

                  <button type="submit" name="cPasswordSubmit" id="updateSubmitButton">Update Password</button>

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
