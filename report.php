<?php

  include_once("../connection.php");
  include_once("functions.php");

  if (func::checkLoginState($conn))
  {
    $id = $_GET["id"];
    if(isset($_POST["reported"])){
      $comment = htmlspecialchars($_POST["comment"]);
      $message = "User reported story with ID ".$id.". <br>Additional details: <br>".$comment;
      mail('email','REPORT', $message);
      header("Location: feed.php");
    }

  }
  else
  {
    header("Location: index.php");
  }

?>



<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="assets/css/master.css">
    <link id="animation-stylesheet" rel="stylesheet" href="assets/css/title_animation.css">
    <script src="https://kit.fontawesome.com/e82695925e.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="assets/js/lib/jquery-3.4.1.min.js"></script>
	<meta charset="UTF-8">
    <title>Report</title>
	</head>

  <body>



    <!-- HEADER START -->
    <div id="header">

      <!-- DROPDOWN START -->
      <div class="dropdown">

        <div class="hamburger-container">
          <div class="hamburger">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
          </div>
        </div>

        <div class="body">
          <div class="inner-body">

            <div class="section">
              <?php
              $user_id = $_COOKIE["user_id"];
              echo "<a class='dropdown-button' href='profile.php?id=$user_id'>MY PROFILE <i class='fas fa-user'></i></a>";
              ?>
            </div>

            <div class="section">
              <a class="dropdown-button" href="logout.php">LOG OUT</a>
            </div>

          </div>
        </div>

      </div>
      <!-- DROPDOWN END -->

      <!-- TITLE START -->
      <a id="header-title" href="index.php">
        <div class="glitch-container">
          <div class="glitch-text" id="glitch-main">INKKER.IO</div>
          <div class="glitch-text" id="glitch-shadow-one">INKKER.IO</div>
          <div class="glitch-text" id="glitch-shadow-two">INKKER.IO</div>
        </div>
      </a>
      <!-- TITLE END -->

    </div>
    <!-- HEADER END -->
    




    <div id="profile-box"><div class = "profile-text">
      <form action='feed.php' method='post'>
      <button name='returnButton' type='submit' style='background-color: Transparent;
                background-repeat:no-repeat;
                border: none;
                cursor:pointer;
                overflow: hidden;
                outline:none;
                float:right;'><img src = 'assets/images/return.png' width = 45 height = 45></button>
     </form>
    <p>Report a story:</p>
    <hr>
    Provide some additional details:<br>
    <textarea rows="4" cols="50" name="comment" form="reportform">
    </textarea>
    <?php
    echo "<form action ='report.php?id=$id' method = 'POST' id='reportform'>";
    ?>
      <button class="btn-standard btn-edit" type="submit" name="reported">Report</button>
    </form>
    <br>
  </div></div>
  </body>

</html>
