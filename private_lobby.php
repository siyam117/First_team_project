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
    <title>Lobby</title>

    <script type="text/javascript" src="assets/js/lib/jquery-3.4.1.min.js"></script>
  </head>
  <body>
    <button type="button" name="button" onclick="window.location.href='private_editor.php'">Start Game</button>
    <?php

    echo "Your username is " . $self_username;

    ?>

    <div class="usernames-box">

    </div>

    <script type="text/javascript" src="assets/js/private_lobby.js"></script>
  </body>
</html>
