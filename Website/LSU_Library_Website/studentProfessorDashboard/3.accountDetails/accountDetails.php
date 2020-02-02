<?php
  // Starts the SESSION period
  session_start();

  // Checks if the SEESION variables are already assigned and if the membershipType is Librarian (65350003)
  if (!isset($_SESSION['username']) || !isset($_SESSION['membershipType']) || $_SESSION['membershipType'] != "65350001") {
    header("location: ../../logout.php");
 }

 $userUsername = $_SESSION['username'];

  include_once("../../LSULibraryDBConnection.php");

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
                      height: 1380px;
                      background-color: #F6F6F6;">

            <button type="button" name="return" style="color: #FFFFFF;
                                                      background-color: #5EAFFF;
                                                      border-color: #5EAFFF;
                                                      padding: 5px;
                                                      border-radius: 5px;
                                                      width: 140px;
                                                      position: absolute;
                                                      top: 340px;
                                                      left: 470px;" onClick="window.location.href = '../studentProfessorDashboard.php';">
              <i class="fa fa-arrow-left" style="font-size: 20px;
                                                margin-right: 10px;"></i>
              Return
            </button>


            <div style="width: 55%;
                        height: 1100px;
                        background-color: #FFFFFF;
                        border-radius: 10px;
                        position: relative;
                        left: 50%;
                        transform: translateX(-50%);
                        top: 100px;">

              <p style="font-size: 30px;
                        padding-top: 25px;
                        text-align: center;"><b>Account Details</b></p>


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
                  padding-left: 60px;
                }

                .containerSubTextStyle{
                  font-size: 18px;
                  padding-left: 75px;
                }

                .containerUserDataTextStyle{
                  font-size: 18px;
                  padding-left: 75px;
                }

              </style>

              <!-- Main Container -->
              <div id="container">

                <?php

                  $retrieveUserSQL = "SELECT * FROM User u INNER JOIN Login l ON l.LoginID = u.lLoginID
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
                  $retrieveUserResult = mysqli_query($databaseConn, $retrieveUserSQL);
                  $retrieveUserRow = mysqli_fetch_array($retrieveUserResult);

                ?>

                <table>

                  <tr>
                    <td> <p class="containerSubTextStyle">Membership Type: </p> <td>
                    <td> <p class="containerUserDataTextStyle"> <?php echo $retrieveUserRow["MemberType"]; ?> </p> <td>
                  </tr>

                  <tr>
                    <td> <p class="containerMainTextStyle">Student Details</p> <td>
                  </tr>
                  <tr>
                    <td> <p class="containerSubTextStyle">First Name: </p> <td>
                    <td> <p class="containerUserDataTextStyle"> <?php echo $retrieveUserRow["FirstName"]; ?> </p> <td>
                  </tr>
                  <tr>
                    <td> <p class="containerSubTextStyle">Middle Name: </p> <td>
                    <td> <p class="containerUserDataTextStyle"> <?php echo $retrieveUserRow["MiddleName"]; ?> </p> <td>
                  </tr>
                  <tr>
                    <td> <p class="containerSubTextStyle">Last Name: </p> <td>
                    <td> <p class="containerUserDataTextStyle"> <?php echo $retrieveUserRow["LastName"]; ?> </p> <td>
                  </tr>
                  <tr>
                    <td> <p class="containerSubTextStyle">Email Address: </p> <td>
                    <td> <p class="containerUserDataTextStyle"> <?php echo $retrieveUserRow["EmailAddress"]; ?> </p> <td>
                  </tr>
                  <tr>
                    <td> <p class="containerSubTextStyle">Mobile Number: </p> <td>
                    <td> <p class="containerUserDataTextStyle"> <?php echo $retrieveUserRow["MobileNumber"]; ?> </p> <td>
                  </tr>
                  <tr>
                    <td> <p class="containerSubTextStyle">Telephone Number: </p> <td>
                    <td> <p class="containerUserDataTextStyle"> <?php echo $retrieveUserRow["TelephoneNumber"]; ?> </p> <td>
                  </tr>
                  <tr>
                    <td> <p class="containerSubTextStyle">Street Address: </p> <td>
                    <td> <p class="containerUserDataTextStyle"> <?php echo $retrieveUserRow["StreetAddress"]; ?> </p> <td>
                  </tr>
                  <tr>
                    <td> <p class="containerSubTextStyle">City: </p> <td>
                    <td> <p class="containerUserDataTextStyle"> <?php echo $retrieveUserRow["City"]; ?> </p> <td>
                  </tr>
                  <tr>
                    <td> <p class="containerSubTextStyle">Zip/Postal Code: </p> <td>
                    <td> <p class="containerUserDataTextStyle"> <?php echo $retrieveUserRow["ZipPostalCode"]; ?> </p> <td>
                  </tr>
                  <tr>
                    <td> <p class="containerSubTextStyle">Provience: </p> <td>
                    <td> <p class="containerUserDataTextStyle"> <?php echo $retrieveUserRow["Provience"]; ?> </p> <td>
                  </tr>

                  <tr>
                    <td> <p class="containerMainTextStyle">University Details</p> <td>
                  </tr>
                  <tr>
                    <td> <p class="containerSubTextStyle">University Index No: </p> <td>
                    <td> <p class="containerUserDataTextStyle"> <?php echo $retrieveUserRow["UniversityNo"]; ?> </p> <td>
                  </tr>
                  <tr>
                    <td> <p class="containerSubTextStyle">Faculty: </p> <td>
                    <td> <p class="containerUserDataTextStyle"> <?php echo $retrieveUserRow["Faculty"]; ?> </p> <td>
                  </tr>
                  <tr>
                    <td> <p class="containerSubTextStyle">Degree Program: </p> <td>
                    <td> <p class="containerUserDataTextStyle"> <?php echo $retrieveUserRow["DegreeProgram"]; ?> </p> <td>
                  </tr>
                  <tr>
                    <td> <p class="containerSubTextStyle">Position: </p> <td>
                    <td> <p class="containerUserDataTextStyle"> <?php echo $retrieveUserRow["Position"]; ?> </p> <td>
                  </tr>

                  <tr>
                    <td> <p class="containerMainTextStyle">Login Details</p> <td>
                  </tr>
                  <tr>
                    <td> <p class="containerSubTextStyle">Username: </p> <td>
                    <td> <p class="containerUserDataTextStyle"> <?php echo $retrieveUserRow["Username"]; ?> </p> <td>
                  </tr>
                  <tr>
                    <td> <p class="containerSubTextStyle">Status: </p> <td>
                    <td> <p class="containerUserDataTextStyle"> <?php echo $retrieveUserRow["MemberStatus"]; ?> </p> <td>
                  </tr>

                </table>

                <button type="button" name="changePassword" style="color: #FFFFFF;
                                                                  background-color: #6A6A6A;
                                                                  border-color: #6A6A6A;
                                                                  padding: 5px;
                                                                  border-radius: 5px;
                                                                  width: 360px;
                                                                  position: absolute;
                                                                  top: 930px;
                                                                  left: 120px;" onClick="window.location.href = 'changePassword.php';">
                  <i class="fa fa-unlock" style="font-size: 20px;
                                                margin-right: 10px;"></i>
                  Change Password
                </button>

              </div>

              <button type="button" name="updateDetails" style="color: #FFFFFF;
                                                                background-color: #1F6DBE;
                                                                border-color: #1F6DBE;
                                                                padding: 5px;
                                                                border-radius: 5px;
                                                                width: 300px;
                                                                height: 50px;
                                                                position: absolute;
                                                                top: 1130px;
                                                                left: 690px;" onClick="window.location.href = 'updateDetails.php';">
                <i class="fa fa-edit" style="font-size: 20px;
                                            margin-right: 10px;"></i>
                Update Details
              </button>


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
