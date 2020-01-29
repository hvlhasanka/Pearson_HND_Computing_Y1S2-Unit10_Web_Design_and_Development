<?php
  include_once("LSULibraryDBConnection.php");

  // SignUp process
  if(isset($_POST['signUp'])){

    $selectMemberType = $_POST['memberTypeSignUp'];

    if($selectMemberType == "65350001"){
      echo "<script> var selectedPositionConfirmation = confirm('Are you sure you want to continue: '); </script>";
      echo "<script> if(selectedPositionConfirmation == 1){ location.href='signupPage/signupStudentPage.php'; } </script>";
    }
    if($selectMemberType == "65350002"){
      echo "<script> var selectedPositionConfirmation = confirm('Are you sure you want to continue: '); </script>";
      echo "<script> if(selectedPositionConfirmation == 1){ location.href='signupPage/signupProfessorPage.php'; } </script>";
    }
    else if($selectMemberType == "65350003"){
      echo "<script> var selectedPositionConfirmation = confirm('Are you sure you want to continue: '); </script>";
      echo "<script> if(selectedPositionConfirmation == 1){ location.href='signupPage/signupLibrarianPage.php'; } </script>";
    }
    else{
      ?> <script>
        alert("ERROR: Member Type not selected");
      </script> <?php
    }

  }



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
    <title> LSU Library - Home </title>

    <link rel="icon" type="image/png" sizes="1500x1500" href="assets/images/LSULibraryLogo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Retrieving default layout style sheet -->
    <link rel="stylesheet" href="assets/css/defaultLayout.css">

    <!-- Retrieving signPage script  -->
    <script type="text/javascript" src="assets/javascript/signupPage.js"></script>

    <!-- Retrieving font-awesome library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Serif:100&display=swap" rel="stylesheet">

    <!-- Bootstrap links - begin -->
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <script src="assets/bootstrap/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/popper.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
	<!-- Bootstrap links - end -->

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

    #body{
      height: 1350px;
    }

    #bodySection1Text1{
      font-size: 30px;
      color: #00B1D2FF;
      font-family: 'Roboto', sans-serif;
      margin-top: 170px;
      margin-left: 400px;
    }

    #bodyImg1{
      width: 650px;
      height: 400px;
      position: relative;
      top: -240px;
      left: 665px;
    }

    #bodySection2Text1{
      font-size: 30px;
      color: #00B1D2FF;
      font-family: 'Roboto', sans-serif;
      position: relative;
      top: -180px;
      left: 780px;
    }

    #bodySection2Table{
      position: relative;
      top: -160px;
      left: 380px;
    }

    #bodySection2Table td{
      padding-left: 20px;
      padding-bottom: 20px;
    }

    .bodySection2Cards{
      width: 18rem;
      height: 24rem;
      border-radius: 20px;
    }

    .bodySection2Cards img{
      width: 250px;
      height: 250px;
      padding-left: 30px;
      padding-top: 30px;
    }

    #bodySection3Text1{
      font-size: 30px;
      color: #00B1D2FF;
      font-family: 'Roboto', sans-serif;
      margin-top: -150px;
      margin-left: 545px;
    }
  </style>
  </head>

  <body>
      <!-- HEADER SECTION - Begin -->
        <div id="header">

          <div id="logoSection">
            <a href="homePage.php">
              <img src="assets/images/LSULibraryLogo.png" alt="LSU Library Logo" id="lsuLibraryLogoIcon">
            </a>

              <h1 id="mainTitle"> LSU <span id="mainTitleSpan">Library</span> </h1>

              <p id="mainTitleSub">Lowa State University</p>

            <img src="assets/images/LSUUniversityLogo.png" alt="LSU Logo" id="lsuLogoIcon">

          </div>

          <table id="navSection">
            <tr>
              <td class="navItem" id="navItem1"> <a href="#" data-toggle="modal" data-target="#signupFormModel">SignUp</a> </td>
              <td class="navItem" id="navItem2"> <a href="#" data-toggle="modal" data-target="#loginFormModel">Login</a> </td>
            </tr>
          </table>
        </div>
      <!-- HEADER SECTION - End -->

      <!-- Bootstrap Modals Section - Begin -->

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

        <!-- SignUp Form Modal - Begin -->
          <!-- Modal -->
          <div class="modal fade" id="signupFormModel">
            <div class="modal-dialog modal-lg modal-dialog-centered">
              <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                  <h4 class="modal-title">SignUp to LSU Library Management System</h4>
                  <button type="button" data-dismiss="modal" class="close">
                    <span>&times;</span>
                  </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                  <p class="formText">Select a Member Type</p>
                  <form method="POST" action="index.php">
                    <i class="fa fa-group"></i>
                    <select name="memberTypeSignUp">
                      <option value="NULL" selected>Member Type</option>
                      <option value="65350001">Student</option>
                      <option value="65350002">Professor</option>
                      <option value="65350003">Librarian</option>
                    </select>
                    <br>
                    <input type="submit" name="signUp" value="Continue" id="signupFormButton">
                  </form>
                </div>

              </div>
            </div>
          </div>
        <!-- SignUp Form Modal - End -->
      <!-- Bootstrap Models Section - End -->

      <!-- BODY SECTION - Begin -->
        <div id="body">

          <!-- Body Section 1 - Begin -->
            <p id="bodySection1Text1">Welcome <br>to the<br><b> land of knowledge </b></p>
            <img src="assets/images/HomePage/bodyImg1.jpg" alt="Cover Image" id="bodyImg1">
          <!-- Body Section 1 - End -->

          <!-- Body Section 2 - Begin -->
            <p id="bodySection2Text1">FEATURES</p>

            <table id="bodySection2Table">
              <tr>
                <td>

                  <div class="card bg-info text-white bodySection2Cards">
                    <img src="assets/images/HomePage/homePageBodySection2Img1.jpg" class="card-img-top" alt="Image 1">
                    <div class="card-body">
                      <p class="card-text">
                        University Students and Professors from LSU can become a library member and access all the facilities
                      </p>
                    </div>
                  </div>

                </td>
                <td>

                  <div class="card bg-info text-white bodySection2Cards">
                    <img src="assets/images/HomePage/homePageBodySection2Img2.jpg" class="card-img-top" alt="Image 2">
                    <div class="card-body">
                      <p class="card-text">
                        Members can search for any book with a powerful searching tool
                      </p>
                    </div>
                  </div>

                </td>
                <td>

                  <div class="card bg-info text-white bodySection2Cards">
                    <img src="assets/images/HomePage/homePageBodySection2Img3.jpg" class="card-img-top" alt="Image 3">
                    <div class="card-body">
                      <p class="card-text">
                        Members can check the books' availability for borrowing
                      </p>
                    </div>
                  </div>

                </td>
              </tr>
              <tr>
                <td>

                  <div class="card bg-info text-white bodySection2Cards">
                    <img src="assets/images/HomePage/homePageBodySection2Img4.jpg" class="card-img-top" alt="Image 4">
                    <div class="card-body">
                      <p class="card-text">
                        Members can reserve a book for 24 hours before finalizing it for borrowing.
                      </p>
                    </div>
                  </div>

                </td>
                <td>

                  <div class="card bg-info text-white bodySection2Cards">
                    <img src="assets/images/HomePage/homePageBodySection2Img5.png" class="card-img-top" alt="Image 5">
                    <div class="card-body">
                      <p class="card-text">
                        Our web application is simple and easy to use.
                      </p>
                    </div>
                  </div>

                </td>
                <td>

                  <div class="card bg-info text-white bodySection2Cards">
                    <img src="assets/images/HomePage/homePageBodySection2Img6.jpg" class="card-img-top" alt="Image 6">
                    <div class="card-body">
                      <p class="card-text">
                        Members can update their account details or remove it
                      </p>
                    </div>
                  </div>

                </td>
              </tr>
            </table>
          <!-- Body Section 2 - End -->

          <!-- Body Section 3 - Begin -->
            <p id="bodySection3Text1"><b>SignUp now</b> to get your hands on these features</p>
          <!-- Body Section 3 - End -->

        </div>
      <!-- BODY SECTION - End -->

      <!-- FOOTER SECTION - Begin -->
        <div id="footer">

          <div id="footerLogoSection">

            <img src="assets/images/LSULibraryLogo.png" alt="LSU Library Logo" id="lsuLibraryLogoIcon">

            <h1 id="mainTitle"> LSU <span id="mainTitleSpan">Library</span> </h1>

            <p id="mainTitleSub">Lowa State University</p>

            <img src="assets/images/LSUUniversityLogo.png" alt="LSU Logo" id="lsuLogoIcon">

          </div>

          <p id="footerText1Main">LSU Library - <span id="footerText1Sub">Lowa State University</span> &copy; 2020</p>
        </div>
      <!-- FOOTER SECTION - End -->

  </body>
</html>
