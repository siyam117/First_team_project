<?php

  include_once("../connection.php");
  include_once("functions.php");



  if (isset($_POST["lobby_id"]) && isset($_POST["username"]))
  {
    $lobby_id = $_POST["lobby_id"];

    $rows = func::sqlSELECT($conn, "SELECT * FROM private_stories WHERE lobby_id='$lobby_id';");
    if (empty($rows))
    {
      header("Location: private_options.php");
    }

    $username = $_POST["username"];

    $private_user_id = func::addNewUserPRIVATE($conn, $username, $lobby_id);

    if ($private_user_id != null)
    {
      func::startNewSessionPRIVATE($conn, $private_user_id);

      usleep(100000);

      header("Location: private_lobby.php?id=$lobby_id");
    }
  }

  else if (isset($_GET["id"]))
  {
    $lobby_id = $_GET["id"];

    $rows = func::sqlSELECT($conn, "SELECT * FROM private_stories WHERE lobby_id='$lobby_id';");
    if (empty($rows))
    {
      header("Location: private_options.php");
    }
  }

  else
  {
    header("Location: private_options.php");
  }

?>



<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="assets/css/master.css">
    <script type="text/javascript" src="assets/js/lib/jquery-3.4.1.min.js"></script>

    <title>Join Game</title>
  </head>
  <body>


    <!-- HEADER START -->
    <div id="header">

      <!-- DROPDOWN START -->
      <?php

      if (func::checkLoginState($conn))
      {

        echo '<div class="dropdown">';

          echo '<div class="hamburger-container">';
            echo '<div class="hamburger">';
              echo '<span class="bar"></span>';
              echo '<span class="bar"></span>';
              echo '<span class="bar"></span>';
            echo '</div>';
          echo '</div>';

          echo '<div class="body">';
            echo '<div class="inner-body">';

              echo '<div class="section">';

                $user_id = $_COOKIE["user_id"];
                echo "<a class='dropdown-button' href='profile.php?id=$user_id'>MY PROFILE <i class='fas fa-user'></i></a>";

              echo '</div>';

              echo '<div class="section">';
                echo '<a class="dropdown-button" href="logout.php">LOG OUT</a>';
              echo '</div>';

            echo '</div>';
          echo '</div>';

        echo '</div>';

      }

      ?>
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




    <form action="private_username.php" method="post">
      <?php
      echo "<input type='hidden' name='lobby_id' value='$lobby_id'>"
      ?>
      <input class="input-field" type="text" autocomplete="off" placeholder="Username" name="username">
      <button class="btn-standard" type="submit">Enter</button>
    </form>

    <script type="text/javascript" src="assets/js/main.js"></script>
  </body>
</html>
