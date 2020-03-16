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
  <script type="text/javascript" src="assets/js/lib/jquery-3.4.1.min.js"></script>
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
    <h>Choose your profile picture:</h>
    <form action = 'profile_picture.php' method = "POST">
      <img src='assets/images/default.jpg'><br>
      <input type="radio" name="pp" value="assets/images/default.jpg"><br><br>
      <img src='assets/images/1.jpg'><br>
      <input type="radio" name="pp" value="assets/images/1.jpg"><br><br>
      <img src='assets/images/2.jpg'><br>
      <input type="radio" name="pp" value="assets/images/2.jpg"><br><br>
      <img src='assets/images/3.jpg'><br>
      <input type="radio" name="pp" value="assets/images/3.jpg"><br><br>
      <button type='submit' name='submit'>Confirm</button>
    </form>
    <br>
    <?php
    $id = $_COOKIE["user_id"];
    echo "<a href='profile_edit.php?id=$id'>Cancel</a>";
    ?>
  </body>

</html>
