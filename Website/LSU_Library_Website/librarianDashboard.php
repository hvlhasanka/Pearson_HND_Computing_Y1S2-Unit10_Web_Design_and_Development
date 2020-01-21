<!DOCTYPE html>
<html>
  <head>
    <title> LSU Library - Dashboard </title>

    <link rel="icon" type="image/png" sizes="1500x1500" href="assets/images/LSULibraryLogo.png">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <script src="assets/javascript/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>

    <style>
      *{
        margin: 0;
      }

      #logoSection{
        position: relative;
        top: -100px;
        left: 440px;
      }

      #lsuLibraryLogoIcon{
        height: 95px;
        width: 95px;
        position: relative;
        top: 122px;
        left: -120px;
      }

      #mainTitle{
        color: #0692c2;
        letter-spacing: 4px;
        font-family: 'Noto Sans', sans-serif;
        font-size: 40px;
        padding-top: 30px;
        padding-left: 8px;
      }

      #mainTitleSpan{
        letter-spacing: 1px;
      }

      #mainTitleSub{
        font-size: 22px;
        font-family: verdana;
        color: #0692c2;
        letter-spacing: 1px;
      }

      #lsuLogoIcon{
        height: 62px;
        width: 150px;
        position: relative;
        top: -90px;
        left: 300px;
      }

      #navSection{
        position: relative;
        top: -240px;
        left: 1180px;
      }

      .navItem{
        padding-left: 20px;
      }

      .navItem a{
        font-size: 25px;
        text-decoration: none;
        color: #00B1D2FF;
        font-family: verdana;
        font-size: 20px;
        border-style: solid;
        border-width: thin;
        border-radius: 6px;
        padding: 6px;
      }

      #navItem1 a{
        border-color: white;
        transition-duration: 0.4s;
      }

      #navItem1 a:hover{
        background-color: lightblue;
        color: white;
      }

      #navItem2 a{
        transition-duration: 0.4s;
      }

      #navItem2 a:hover{
        border-color: #00B1D2FF;
        background-color: lightblue;
        color: white;
      }


    </style>
  </head>
  <body>
    <!-- MAIN SECTION - Begin -->
        <!-- HEADER SECTION - Begin -->
        <div style="height: 140px; width: 100%;">
              <div id="logoSection">

                <img src="assets/Images/LSULibraryLogo.png" alt="LSU Library Logo" id="lsuLibraryLogoIcon">

                <h1 id="mainTitle"> LSU <span id="mainTitleSpan">Library</span> </h1>

                <p id="mainTitleSub">Lowa State University</p>

                <img src="assets/Images/LSUUniversityLogo.png" alt="LSU Logo" id="lsuLogoIcon">

              </div>

              <table id="navSection">
                <tr>
                  <td></td>
                  <td></td>
                </tr>
              </table>

        </div>

        <!-- HEADER SECTION - End -->


        <!-- BODY SECTION - Begin -->
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

        <!-- Functionalities Section -->
        <!-- Main section -->
        <div style="background-color: blue
                    height: 100%;
                    width: 100%;">
          <!-- Grid Section -->
          <div class="row">
            <p style="font-size: 20px;
                      position: absolute;
                      top: 15px;
                      left: 20px;"> <b>Book Management</b> </p>

            <div id="accordion" style="width: 850px;
                                      height: 50px;
                                      position: relative;
                                      top: 20px;
                                      left: 25%;">
              <!-- Grid Component 1 -->
              <div class="col-sm-12">
                <!-- Card 1 -->
                <div class="card">
                  <div class="card-header">
                    <a class="card-link" data-toggle="collapse" href="#collapseOne">
                      Collapsible Group Item #1
                    </a>
                  </div>
                  <div id="collapseOne" class="collapse show" data-parent="#accordion" style="background-color: #EBFCFF;">
                    <div class="card-body">
                      Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    </div>
                  </div>
                </div>
              </div>

              <!-- Grid Component 2 -->
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                    <a class="collapsed card-link" data-toggle="collapse" href="#collapseTwo">
                      Collapsible Group Item #2
                    </a>
                  </div>
                  <div id="collapseTwo" class="collapse" data-parent="#accordion">
                    <div class="card-body">
                      Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    </div>
                  </div>
                </div>
              </div>

              <!-- Grid Component 3 -->
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                    <a class="collapsed card-link" data-toggle="collapse" href="#collapseThree">
                      Collapsible Group Item #3
                    </a>
                  </div>
                  <div id="collapseThree" class="collapse" data-parent="#accordion">
                    <div class="card-body">
                      Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>

        <!-- BODY SECTION - End -->












        <!-- FOOTER SECTION - Begin -->




        <!-- FOOTER SECTION - End -->
    <!-- MAIN SECTION - End -->
  </body>
</html>
