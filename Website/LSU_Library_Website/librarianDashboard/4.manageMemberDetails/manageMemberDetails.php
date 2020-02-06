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


  // Process of deleting a student account
  if(isset($_GET['removestudentUserID'])){

    $studentUserID = $_GET['removestudentUserID'];

    // Retrieving UniversityNo from UniversityNo Table
    $universityNoSQL = "SELECT UniversityNo FROM UniversityMember WHERE uUserID = '$studentUserID';";
    $universityNoResult = mysqli_query($databaseConn, $universityNoSQL);
    $universityNoRow = mysqli_fetch_array($universityNoResult);
    $studentUniversityNo = $universityNoRow['UniversityNo'];

    // Deleting record from the Student table
    $studentDeleteSQL = "DELETE FROM Student WHERE umUserID = '$studentUserID' AND umUniversityNo = '$studentUniversityNo';";
    mysqli_query($databaseConn, $studentDeleteSQL);

    // Deleteng records from Borrow table
    $borrowSQL = "DELETE FROM Borrow WHERE umUserID = '$studentUserID' AND umUniversityNo = '$studentUniversityNo';";
    mysqli_query($databaseConn, $borrowSQL);

    // Deleting record from University Member table
    $universityMemberSQL = "DELETE FROM UniversityMember WHERE uUserID = '$studentUserID' AND UniversityNo = '$studentUniversityNo';";
    mysqli_query($databaseConn, $universityMemberSQL);

    // Deleting records from UserManageLogin table
    $userManageLoginSQL = "DELETE FROM UserManageLogin WHERE uUserID = '$studentUserID';";
    mysqli_query($databaseConn, $userManageLoginSQL);

    // Retrieving lLoginID from User table
    $loginIDSQL = "SELECT lLoginID FROM User WHERE UserID  = '$studentUserID';";
    $loginIDResult = mysqli_query($databaseConn, $loginIDSQL);
    $loginIDRow = mysqli_fetch_array($loginIDResult);
    $loginID = $loginIDRow['lLoginID'];

    // Deleting record from User table
    $userSQL = "DELETE FROM User WHERE UserID = '$studentUserID';";
    mysqli_query($databaseConn, $userSQL);

    // Deleting record from Login table
    $loginSQL = "DELETE FROM Login WHERE LoginID = '$loginID';";
    mysqli_query($databaseConn, $loginSQL);

    ?> <script>
      alert("Student account has been successfully deleted.");
    </script> <?php

    echo "<script> location.href='manageMemberDetails.php'; </script>";

  }

  // Process of deleting a professor account
  if(isset($_GET['removeprofessorUserID'])){

    $professorUserID = $_GET['removeprofessorUserID'];

    // Retrieving UniversityNo from UniversityNo Table
    $universityNoSQL = "SELECT UniversityNo FROM UniversityMember WHERE uUserID = '$professorUserID';";
    $universityNoResult = mysqli_query($databaseConn, $universityNoSQL);
    $universityNoRow = mysqli_fetch_array($universityNoResult);
    $professorUniversityNo = $universityNoRow['UniversityNo'];

    // Deleting record from the Professor table
    $professorSQL = "DELETE FROM Professor WHERE umUserID = '$professorUserID' AND umUniversityNo = '$professorUniversityNo';";
    mysqli_query($databaseConn, $professorSQL);

    // Deleteng records from Borrow table
    $borrowSQL = "DELETE FROM Borrow WHERE umUserID = '$professorUserID' AND umUniversityNo = '$professorUniversityNo';";
    mysqli_query($databaseConn, $borrowSQL);

    // Deleting record from University Member table
    $universityMemberSQL = "DELETE FROM UniversityMember WHERE uUserID = '$professorUserID' AND UniversityNo = '$professorUniversityNo';";
    mysqli_query($databaseConn, $universityMemberSQL);

    // Deleting records from UserManageLogin table
    $userManageLoginSQL = "DELETE FROM UserManageLogin WHERE uUserID = '$professorUserID';";
    mysqli_query($databaseConn, $userManageLoginSQL);

    // Retrieving lLoginID from User table
    $loginIDSQL = "SELECT lLoginID FROM User WHERE UserID  = '$professorUserID';";
    $loginIDResult = mysqli_query($databaseConn, $loginIDSQL);
    $loginIDRow = mysqli_fetch_array($loginIDResult);
    $loginID = $loginIDRow['lLoginID'];

    // Deleting record from User table
    $userSQL = "DELETE FROM User WHERE UserID = '$professorUserID';";
    mysqli_query($databaseConn, $userSQL);

    // Deleting record from Login table
    $loginSQL = "DELETE FROM Login WHERE LoginID = '$loginID';";
    mysqli_query($databaseConn, $loginSQL);

    ?> <script>
      alert("Professor account has been successfully deleted.");
    </script> <?php

    echo "<script> location.href='manageMemberDetails.php'; </script>";

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

    <!-- jQuery to enable the popover implementation -->
    <script>
      $(document).ready(function(){
        $('[data-toggle="popover"]').popover();
      });
    </script>

  </head>
  <body>
    <!-- MAIN SECTION - Begin -->
        <!-- HEADER SECTION - Begin -->
        <div style="height: 140px; width: 100%;">
              <div id="logoSection">

		<a href="../librarianDashboard.php">
                  <img src="../../assets/Images/LSULibraryLogo.png" alt="LSU Library Logo" id="lsuLibraryLogoIcon">
                </a>

                <h1 id="mainTitle"> LSU <span id="mainTitleSpan">Library</span> </h1>

                <p id="mainTitleSub">Lowa State University</p>

                <img src="../../assets/Images/LSUUniversityLogo.png" alt="LSU Logo" id="lsuLogoIcon">

              </div>

              <table id="navSection">
                <tr>
                  <td class="navItem" id="navItem1">
                    <a href="" data-toggle="popover" data-trigger="hover" data-placement="bottom" title="Options"
                    data-content="View Account Details" style="color: black;">
                      <?php echo $_SESSION['username']; ?> &nbsp
                      <i class="fa fa-bars" style="font-size: 32px;
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
            <div style="background-color: #3498DB;
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


            <nav class="navbar navbar-expand-sm bg-dark navbar-dark" style="height: 100px;">
              <ul class="navbar-nav" style="text-align: center;
                                            position: absolute;
                                            left: 50%;
                                            transform: translate(-50%,-0%);
                                            font-size: 20px;">
                <li class="nav-item">
                  <a class="nav-link" href="../librarianDashboard.php">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="../1.manageBooks/manageBooks.php">Manage Books</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="../2.manageBookCatalog/manageBookCatalog.php">Manage Book Catalogs</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="../3.manageBookBorrowAndReturnDetails/manageBookBorrowAndReturnDetails.php">Manage Book Borrow and Returning Details</a>
                </li>
                <li class="nav-item active">
                  <a class="nav-link" href="manageMemberDetails.php">Manage Member Details</a>
                </li>
              </ul>
            </nav>

            <style>
              nav li{
                margin-left:30px;
                margin-right:30px;
                width: 185px;
              }
            </style>
          <!-- NavBar - End -->

          <!-- Outer Background -->
          <div style="width: 100%;
                      height: 1600px;
                      background-color: #F6F6F6;">

            <!-- Book Borrow Details Section -->
            <div style="width: 85%;
                        height: 700px;
                        background-color: #FFFFFF;
                        border-radius: 10px;
                        position: relative;
                        left: 50%;
                        transform: translateX(-50%);
                        top: 20px;">

              <p style="font-size: 20px;
                        padding-left: 30px;
                        padding-top: 20px;"><b>Student Member Details</b></p>

              <div style="width: 95%;
                          height: 600px;
                          background-color: white;
                          position: absolute;
                          left: 50%;
                          transform: translateX(-50%);
                          overflow-y: scroll;
                          overflow-x: scroll;">

                <!-- Retrieving details of the existing student account from the database -->
                <?php
                  $studentDetailsSQL = "SELECT * FROM User u INNER JOIN Login l ON l.LoginID = u.lLoginID
                                    INNER JOIN UserCity uc ON uc.CityID = u.ucCityID
                                    INNER JOIN UserZipPostalCode uzpc ON uzpc.ZPCID = u.uzpcZPCID
                                    INNER JOIN UserProvience up ON up.ProvienceID = u.upProvienceID
                                    INNER JOIN UniversityMember um ON um.uUserID = u.UserID
                                    INNER JOIN MemberMembershipType mmt ON mmt.MembershipTypeID = um.mmtMembershipTypeID
                                    INNER JOIN MemberFaculty mf ON mf.FacultyID = um.mfFacultyID
                                    INNER JOIN Student s ON s.umUserID = um.uUserID AND s.umUniversityNo = um.UniversityNo
                                    INNER JOIN StudentDegreeProgram sdp ON sdp.DegreeProgramID = s.sdpDegreeProgramID
                                    INNER JOIN StudentBatch sb ON sb.BatchID = s.sbBatchID
                                    INNER JOIN MemberPosition mp ON mp.PositionID = um.mpPositionID
                                    INNER JOIN MemberMemberStatus mms ON mms.MemberStatusID = um.mmsMemberStatusID;";

                  $studentDetailsResult = mysqli_query($databaseConn, $studentDetailsSQL);

                ?>

                <table class="table table-hover fixed_header" style="border-radius: 10px;">
                  <thead>
                    <tr>
                      <th> First Name </th>
                      <th> Middle Name </th>
                      <th> Last Name </th>
                      <th> Email Address </th>
                      <th> Mobile Number </th>
                      <th> Telephone Number </th>
                      <th> Street Address </th>
                      <th> City </th>
                      <th> Zip/Postal Code </th>
                      <th> Provience </th>
                      <th> University Index No </th>
                      <th> Faculty </th>
                      <th> Degree Program </th>
                      <th> Batch </th>
                      <th> Position </th>
                      <th> Username </th>
                      <th> Member Status </th>
                      <th> Modification </th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                        while($studentDetailsRow = mysqli_fetch_array($studentDetailsResult)){
                          $studentUserID = $studentDetailsRow['UserID'];
                      ?>
                    <tr>
                      <td title="First Name"><?php echo $studentDetailsRow["FirstName"]; ?></td>
                      <td title="Middle Name"><?php echo $studentDetailsRow["MiddleName"]; ?></td>
                      <td title="Last Name"><?php echo $studentDetailsRow["LastName"]; ?></td>
                      <td title="Email Address"><?php echo $studentDetailsRow["EmailAddress"]; ?></td>
                      <td title="Mobile Number"><?php echo $studentDetailsRow["MobileNumber"]; ?></td>
                      <td title="Telephone Number"><?php echo $studentDetailsRow["TelephoneNumber"]; ?></td>
                      <td title="Street Address"><?php echo $studentDetailsRow["StreetAddress"]; ?></td>
                      <td title="City"><?php echo $studentDetailsRow["City"]; ?></td>
                      <td title="Zip/Postal Code"><?php echo $studentDetailsRow["ZipPostalCode"]; ?></td>
                      <td title="Provience"><?php echo $studentDetailsRow["Provience"]; ?></td>
                      <td title="University Index No"><?php echo $studentDetailsRow["UniversityNo"]; ?></td>
                      <td title="Faculty"><?php echo $studentDetailsRow["Faculty"]; ?></td>
                      <td title="Degree Program"><?php echo $studentDetailsRow["DegreeProgram"]; ?></td>
                      <td title="Batch"><?php echo $studentDetailsRow["Batch"]; ?></td>
                      <td title="Position"><?php echo $studentDetailsRow["Position"]; ?></td>
                      <td title="Username"><?php echo $studentDetailsRow["Username"]; ?></td>
                      <td title="Member Status"><?php echo $studentDetailsRow["MemberStatus"]; ?></td>

                      <td>
                          <a href="updateStudentDetails.php?updatestudentUsername=<?php echo $studentDetailsRow["Username"]; ?>"> Edit </a>
                          | <a href="manageMemberDetails.php?removestudentUserID=<?php echo $studentUserID; ?>"
                          onClick="return confirm('Student Account will be deleted. Along with all connections to this account.\nAre you such you want to continue?')">
                          Delete
                          </a>
                      </td>
                    </tr>
                      <?php } ?>
                  </tbody>
                </table>
              </div>

            </div>




            <!-- Book Return Details Section -->
            <div style="width: 85%;
                        height: 700px;
                        background-color: #FFFFFF;
                        border-radius: 10px;
                        position: relative;
                        left: 50%;
                        transform: translateX(-50%);
                        top: 50px;">

              <p style="font-size: 20px;
                        padding-left: 30px;
                        padding-top: 20px;"><b>Professor Member Details</b></p>

              <div style="width: 95%;
                          height: 600px;
                          background-color: white;
                          position: absolute;
                          left: 50%;
                          transform: translateX(-50%);
                          overflow-y: scroll;">

                <!-- Retrieving details of the existing professor accounts from the database -->
                <?php
                  $professorDetailsSQL = "SELECT * FROM User u INNER JOIN Login l ON l.LoginID = u.lLoginID
                                          INNER JOIN UserCity uc ON uc.CityID = u.ucCityID
                                          INNER JOIN UserZipPostalCode uzpc ON uzpc.ZPCID = u.uzpcZPCID
                                          INNER JOIN UserProvience up ON up.ProvienceID = u.upProvienceID
                                          INNER JOIN UniversityMember um ON um.uUserID = u.UserID
                                          INNER JOIN MemberMembershipType mmt ON mmt.MembershipTypeID = um.mmtMembershipTypeID
                                          INNER JOIN MemberFaculty mf ON mf.FacultyID = um.mfFacultyID
                                          INNER JOIN MemberPosition mp ON mp.PositionID = um.mpPositionID
                                          INNER JOIN MemberMemberStatus mms ON mms.MemberStatusID = um.mmsMemberStatusID
                                          INNER JOIN Professor p ON p.umUserID = um.uUserID AND p.umUniversityNo = um.UniversityNo
                                          INNER JOIN ProfessorSpecialization ps ON ps.SpecializationID = p.psSpecializationID;";

                  $professorDetailsResult = mysqli_query($databaseConn, $professorDetailsSQL);

                ?>

                <table class="table table-hover fixed_header" style="border-radius: 10px;">
                  <thead>
                    <tr>
                      <th> First Name </th>
                      <th> Middle Name </th>
                      <th> Last Name </th>
                      <th> Email Address </th>
                      <th> Mobile Number </th>
                      <th> Telephone Number </th>
                      <th> Street Address </th>
                      <th> City </th>
                      <th> Zip/Postal Code </th>
                      <th> Provience </th>
                      <th> University Index No </th>
                      <th> Faculty </th>
                      <th> Position </th>
                      <th> Specialization </th>
                      <th> Username </th>
                      <th> Member Status </th>
                      <th> Modification </th>

                    </tr>
                  </thead>
                  <tbody>
                      <?php
                        while($professorDetailsRow = mysqli_fetch_array($professorDetailsResult)){
                          $professorUserID = $professorDetailsRow["UserID"];
                      ?>
                    <tr>
                      <td title="First Name"><?php echo $professorDetailsRow["FirstName"]; ?></td>
                      <td title="Middle Name"><?php echo $professorDetailsRow["MiddleName"]; ?></td>
                      <td title="Last Name"><?php echo $professorDetailsRow["LastName"]; ?></td>
                      <td title="Email Address"><?php echo $professorDetailsRow["EmailAddress"]; ?></td>
                      <td title="Mobile Number"><?php echo $professorDetailsRow["MobileNumber"]; ?></td>
                      <td title="Telephone Number"><?php echo $professorDetailsRow["TelephoneNumber"]; ?></td>
                      <td title="Street Address"><?php echo $professorDetailsRow["StreetAddress"]; ?></td>
                      <td title="City"><?php echo $professorDetailsRow["City"]; ?></td>
                      <td title="Zip/Postal Code"><?php echo $professorDetailsRow["ZipPostalCode"]; ?></td>
                      <td title="Provience"><?php echo $professorDetailsRow["Provience"]; ?></td>
                      <td title="University Index No"><?php echo $professorDetailsRow["UniversityNo"]; ?></td>
                      <td title="Faculty"><?php echo $professorDetailsRow["Faculty"]; ?></td>
                      <td title="Position"><?php echo $professorDetailsRow["Position"]; ?></td>
                      <td title="Specialization"><?php echo $professorDetailsRow["Specialization"]; ?></td>
                      <td title="Username"><?php echo $professorDetailsRow["Username"]; ?></td>
                      <td title="Member Status"><?php echo $professorDetailsRow["MemberStatus"]; ?></td>

                      <td>
                          <a href="updateProfessorDetails.php?updateprofessorUsername=<?php echo $professorDetailsRow["Username"]; ?>"> Edit </a>
                          | <a href="manageMemberDetails.php?removeprofessorUserID=<?php echo $professorUserID; ?>"
                          onClick="return confirm('Professor Account will be deleted. Along with all connections to this account.\nAre you such you want to continue?')">
                          Delete
                          </a>
                      </td>

                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
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
