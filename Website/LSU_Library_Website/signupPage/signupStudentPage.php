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
            header("location: librarianDashboard/librarianDashboard.php");
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

              header("location: studentProfessorDashboard/studentProfessorDashboard.php");

            }
            else{
              ?> <script>
                alert("Account is currently <?php echo $accountStatus; ?>, please contact librarian to resolve this.");
              </script> <?php

              echo "<script> location.href='logout.php'; </script>";
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

?>

<!DOCTYPE html>
<html>
  <head>
    <title> LSU Library - Dashboard </title>

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

    .modal-body input[type=text], input[type=password], select{
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

    .modal-body input[type=text]:hover, input[type=password]:hover, select:hover{
      border-color: #00B1D2FF;
      box-shadow: 2px 1px 2px #00B1D2FF;
    }

    .modal-body input[type=submit], input[type=reset]{
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

    .modal-body input[type=submit]:hover, input[type=reset]:hover{
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
                  <form method="POST" action="index.php">
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
                  <p>Don't have an account? <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#signupFormModel">SignUp >></a></p>
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
                      height: 1600px;
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
                        height: 1350px;
                        background-color: #FFFFFF;
                        border-radius: 10px;
                        position: relative;
                        left: 50%;
                        transform: translateX(-50%);
                        top: 100px;">

              <p style="font-size: 30px;
                        padding-top: 25px;
                        text-align: center;"><b>Student Registration</b></p>

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

                #addBookSubmitButton{
                  padding: 5px;
                  border-radius: 5px;
                  margin-left: 50%;
                  margin-right: 10px;
                  background-color: #0081FF;
                  color: #FFFFFF;
                  width: 100px;
                  border-color: #0081FF;
                }

                #addBookResetButton{
                  padding: 5px;
                  border-radius: 5px;
                  background-color: #DEDEDE;
                  color: #000000;
                  width: 100px;
                  border-color: #DEDEDE;
                }

                #asteriskImportant{
                  color: red;
                }
              </style>

              <!-- Signup Form SECTION - Begin -->
              <div id="signupForm">
                <form action="manageBooks.php" method="POST">

                  <p class="formText">Full Name</p>
                      <input type="text" name="firstName" placeholder="First Name" required class="formInput"
                      title="Mandatory, Only Uppercase Initials and Lowercase Alphabetic Characters"
                      data-toggle="tooltip" data-placement="right">
                      <p class="mandatoryAsterisk" style="top: 40px;
                                                          left: 326px;">*</p>

                      <input type="text" name="middleName" placeholder="Middle Name"  class="formInput"
                      title="Optional, Only Uppercase Initials and Lowercase Alphabetic Characters"
                      data-toggle="tooltip" data-placement="right"
                      style="margin-left: 20px;">

                    <br>
                      <input type="text" name="lastName" placeholder="Last Name" required class="formInput"
                      title="Mandatory, Only Uppercase Initials and Lowercase Alphabetic Characters"
                      data-toggle="tooltip" data-placement="right"
                      style="width: 527px;">
                      <p class="mandatoryAsterisk" style="top: 108px;
                                                          left: 605px;">*</p>

                  <p class="formText">Email Address</p>
                    <input type="email" name="email" placeholder="eg:- sample@provider.com" required class="formInput"
                    title="Mandatory, Enter valid email address"
                    data-toggle="tooltip" data-placement="right">
                    <p class="mandatoryAsterisk" style="top: 216px;
                                                        left: 328px;">*</p>

                  <p class="formText">Phone Number</p>
                    <input type="number" name="mobileNumber" placeholder="Mobile Number" required class="formInput"
                    title="Mandatory, Only 10 numeric characters"
                    data-toggle="tooltip" data-placement="right">
                    <p class="mandatoryAsterisk" style="top: 328px;
                                                        left: 328px;">*</p>

                    <input type="number" name="landNumber" placeholder="Telephone Number" class="formInput"
                    style="margin-left: 20px;"
                    title="Optional, Only 10 numeric characters"
                    data-toggle="tooltip" data-placement="right">

                  <p class="formText">Address</p>
                    <input type="text" name="laneAdress" placeholder="Street Address" required class="formInput"
                    title="Mandatory, Only Uppercase Initials and Lowercase Alphabetic Characters"
                    data-toggle="tooltip" data-placement="right">
                    <p class="mandatoryAsterisk" style="top: 438px;
                                                        left: 328px;">*</p>

                    <input type="text" name="city" placeholder="City" required class="formInput"
                    style="margin-left: 20px;"
                    title="Mandatory, Only Uppercase Initials and Lowercase Alphabetic Characters"
                    data-toggle="tooltip" data-placement="right">
                    <p class="mandatoryAsterisk" style="top: 438px;
                                                        left: 603px;">*</p>

                    <br>
                    <select name="provience">
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
                    <input type="text" name="city" placeholder="Postal/Zip Code" required>
                    <span id="asteriskImportant">*</span>
                  <p>University Information</p>
                    <input type="text" name="universityIndexNo" placeholder="University Index No" required>
                    <span id="asteriskImportant">*</span>
                    <br>
                    <select name="faculty">
                      <option value="">Faculty</option>
                      <option value="">Faculty of Engineering</option>
                      <option value="Faculty of Science">Faculty of Science</option>
                      <option value="Faculty of Computing">Faculty of Computing</option>
                      <option value="Faculty of Business">Faculty of Business</option>
                    </select>
                    <span id="asteriskImportant">*</span>
                    <br>
                    <input type="text" name="degreeProgram" placeholder="Degree Program" required>
                    <br>
                    <input type="text" name="batch" placeholder="Batch (eg:- Spring 2017)" required>
                    <span id="asteriskImportant">*</span>
                    <br>
                    <select name="studentPosition">
                      <option value="">Position</option>
                      <option value="Undergraduate Student">Undergraduate Student</option>
                      <option value="Postgraduate Student">Postgraduate Student</option>
                      <option value="Alumni">Alumni</option>
                    </select>
                    <span id="asteriskImportant">*</span>
                  <p>Login Credentails</p>
                    <input type="text" name="username" placeholder="Username" required>
                    <span id="asteriskImportant">*</span>
                    <br>
                    <input type="password" name="password" placeholder="Enter Password" required>
                    <span id="asteriskImportant">*</span>
                    <input type="password" name="confirmPassword" placeholder="Confirm Password" required>
                    <span id="asteriskImportant">*</span>
                  <p>Terms and Conditions</p>
                  <p>Please read through the Terms and Constions and tick the below <br>box to continue the registration</p>
                  <input type="checkbox" name="tAndCAgreement">
                    <p>I have read and I agree to the Terms and Conditions</p>
                  <br>

                  <br>
                  <button type="submit" name="addBookSubmit" id="addBookSubmitButton">Submit</button>
                  <button type="reset" name="addBookReset" id="addBookResetButton">Reset</button>

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
