<?php

  include_once("../connection.php");
  include_once("functions.php");

  if (isset($_GET["id"]))
  {
    $lobby_id = $_GET["id"];

    $row = func::sqlSELECT($conn, "SELECT * FROM private_stories WHERE lobby_id='$lobby_id';");

    if (empty($row))
    {
      header("Location: private_options.php");
    }

    if (!func::checkPrivateSession($conn, $lobby_id))
    {
      header("Location: private_username.php?id=$lobby_id");
    }

    $creator_user_id = $row["creator_user_id"];
    $private_user_id = $_COOKIE["Puser_id"];

    $row = func::sqlSELECT($conn, "SELECT * FROM private_users WHERE user_id='$private_user_id';");

    $self_username = $row["username"];
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

    <title>Lobby</title>
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






    <?php

    if ($creator_user_id == $private_user_id)
    {
      echo "<button type='button' name='button' onclick='window.location.href='private_editor.php?id=''>Start Game</button>";
    }

    echo "Your username is " . $self_username;

    ?>



    <div class="usernames-box">

    </div>

    <script type="text/javascript" src="assets/js/private_lobby.js"></script>
    <script type="text/javascript" src="assets/js/main.js"></script>
  </body>
</html>
