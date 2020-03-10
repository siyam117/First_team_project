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
    <title>Join Game</title>
  </head>
  <body>
    <form action="private_username.php" method="post">
      <?php
      echo "<input type='hidden' name='lobby_id' value='$lobby_id'>"
      ?>
      <input type="text" autocomplete="off" placeholder="Username" name="username">
      <button type="submit">Enter</button>
    </form>
  </body>
</html>
