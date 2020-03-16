<?php

  include_once("../connection.php");
  include_once("functions.php");


  if (isset($_POST["create"]) && isset($_POST["username"]))
  {
    $username = $_POST["username"];
    $lobby_id = func::generateUniqueLobbyID($conn);

    if ($lobby_id != null)
    {
      $private_user_id = func::addNewUserPRIVATE($conn, $username, $lobby_id);

      if ($private_user_id != null)
      {
        func::startNewSessionPRIVATE($conn, $private_user_id);
        $conn->exec("INSERT INTO private_stories (lobby_id, creator_user_id, title) VALUES ('$lobby_id', '$private_user_id', 'Untitled');");

        header("Location: private_lobby.php?id=$lobby_id");
      }
    }
  }

?>



<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="assets/css/master.css">
    <script type="text/javascript" src="assets/js/lib/jquery-3.4.1.min.js"></script>

    <title>Private Games</title>
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




    <form action="private_username.php" method="get">
      <input type="text" autocomplete="off" placeholder="Enter PIN" name="id">
      <button type="submit">Enter</button>
    </form>
    <form action="private_options.php" method="post">
      <input type="hidden" name="create">
      <input type="text" autocomplete="off" placeholder="Username" name="username">
      <button type="submit">Create a new game</button>
    </form>
  </body>
</html>
