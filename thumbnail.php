<?php

  include_once("../connection.php");
  include_once("functions.php");

  if (func::checkLoginState($conn))
  {

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
  <script type="text/javascript" src="assets/js/lib/jquery-3.4.1.min.js"></script>
  <script src="https://kit.fontawesome.com/e82695925e.js" crossorigin="anonymous"></script>
	<meta charset="UTF-8">
    <title>Thumbnail</title>
	</head>



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
  





  <body>
    <div id="profile-box"><div class = "profile-text">
      <?php
      $id = $_COOKIE["user_id"];
      echo "<form action='settings.php' method='post'>
      <button name='returnButton' type='submit' style='background-color: Transparent;
                background-repeat:no-repeat;
                border: none;
                cursor:pointer;
                overflow: hidden;
                outline:none;
                float:right;'><img src = 'assets/images/return.png' width = 45 height = 45></button>
     </form>";
     ?>
      <div class = 'editprofile'>Select thumbnail</div>
      <hr>
      <form action = 'settings.php' method = "POST">
        <div class="pp-select">
          <label>
            <input type="radio" name="storypic" value="default">
            <img src='assets/images/storydefault.jpg' alt='pp' class='profilepic' width = 300 height = 250>
          </label>
          <label>
            <input type="radio" name="storypic" value="1">
            <img src='assets/images/story1.jpg' alt='pp' class='profilepic' width = 300 height = 250>
          </label>
          <label>
            <input type="radio" name="storypic" value="2">
            <img src='assets/images/story2.jpg' alt='pp' class='profilepic' width = 300 height = 250>
          </label>
          <label>
            <input type="radio" name="storypic" value="3">
            <img src='assets/images/story3.jpg' alt='pp' class='profilepic' width = 300 height = 250>
          </label>
          <label>
            <input type="radio" name="storypic" value="4">
            <img src='assets/images/story4.jpg' alt='pp' class='profilepic' width = 300 height = 250>
          </label>
          <label>
            <input type="radio" name="storypic" value="5">
            <img src='assets/images/story5.jpg' alt='pp' class='profilepic' width = 300 height = 250>
          </label>
          <br><br>
          <button type='submit' name='submitpic' class="btn-standard btn-login">Confirm</button>
        </div>
      </form>
    
  </div></div>
    <script type="text/javascript" src="assets/js/theme_change.js"></script>
    <script type="text/javascript" src="assets/js/main.js"></script>
  </body>

</html>
