<?php

  include_once("../connection.php");
  include_once("functions.php");

  if (func::checkLoginState($conn))
  {
    if (isset($_GET["create"]))
    {
      if ($_GET["create"])
      {
        $creator_user_id = $_COOKIE["user_id"];

        $lobby_id = func::generateUniqueLobbyID($conn);
        if ($lobby_id == null) {header("Location: index.php");}

        $conn->exec("INSERT INTO private_stories (lobby_id, creator_user_id) VALUES ('$lobby_id', $creator_user_id);");
        header("Location: private_lobby.php?id=$lobby_id");
      }
    }

    if (isset($_POST["create"]))
    {

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
    <title>Lobby</title>
  </head>
  <body>
    <button type="button" name="button" onclick="window.location.href='private_editor.php'">Start Game</button>
  </body>
</html>
