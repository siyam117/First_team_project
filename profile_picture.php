<?php

  include_once("../connection.php");
  include_once("functions.php");

  if (func::checkLoginState($conn))
  {
    //changing profile picture
    if (isset($_POST["pp"])){
      $picture = ($_POST["pp"]);
      $id = $_COOKIE["user_id"];
      $conn->exec("UPDATE users SET picture = '$picture' WHERE user_id = $id;");
      $url = 'Location: profile_edit.php?id='.$id;
      header($url);
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
  <script type="text/javascript" src="assets/js/lib/jquery-3.4.1.min.js"></script>
  <script src="https://kit.fontawesome.com/e82695925e.js" crossorigin="anonymous"></script>
	<meta charset="UTF-8">
    <title>Profile Pictures</title>
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
      <div class = 'editprofile'>Select your new profile picture</div>
      <hr>
      <form action = 'profile_picture.php' method = "POST">
        <div class="pp-select">
          <label>
            <input type="radio" name="pp" value="assets/images/default.jpg">
            <img src='assets/images/default.jpg' alt='pp' class='profilepic' width = 150 height = 150>
          </label>
          <label>
            <input type="radio" name="pp" value="assets/images/1.jpg">
            <img src='assets/images/1.jpg' alt='pp' class='profilepic' width = 150 height = 150>
          </label>
          <label>
            <input type="radio" name="pp" value="assets/images/2.jpg">
            <img src='assets/images/2.jpg' alt='pp' class='profilepic' width = 150 height = 150>
          </label>
          <label>
            <input type="radio" name="pp" value="assets/images/3.jpg">
            <img src='assets/images/3.jpg' alt='pp' class='profilepic' width = 150 height = 150>
          </label>
          <label>
            <input type="radio" name="pp" value="assets/images/4.jpg">
            <img src='assets/images/4.jpg' alt='pp' class='profilepic' width = 150 height = 150>
          </label>
          <label>
            <input type="radio" name="pp" value="assets/images/5.jpg">
            <img src='assets/images/5.jpg' alt='pp' class='profilepic' width = 150 height = 150>
          </label>
          <?php
            $totalViews = 0;
            $id = $_COOKIE["user_id"];
            $sql = "SELECT * FROM stories WHERE creator_user_id = '$id'";
            $row = func::sqlSELECT($conn, $sql, $fetch_all = true);
            foreach ($row as $results){
              $story_view = $results["views"];
              $totalViews += $story_view;
            }
            if ($totalViews > 999){
              echo "<label>
                      <input type=\"radio\" name=\"pp\" value=\"assets/images/exclusive.jpg\">
                      <img src='assets/images/exclusive.jpg' alt='pp' class='profilepic' width = 150 height = 150>
                    </label>";
            }
          ?>
          <br><br>
          <button type='submit' name='submit' class="btn-standard btn-login">Confirm</button>
        </div>
      </form>
      <br>
      <?php
      $id = $_COOKIE["user_id"];
      echo "<a class='edit-button' href='profile_edit.php?id=$id'><div class='editor-button-text'>Cancel</div></a>";
      ?>
  </div></div>
    <script type="text/javascript" src="assets/js/theme_change.js"></script>
    <script type="text/javascript" src="assets/js/main.js"></script>
  </body>

</html>
