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
    <title>Lobby</title>
  </head>
  <body>
    <button type="button" name="button" onclick="window.location.href='private_editor.php'">Start Game</button>
  </body>
</html>
