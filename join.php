<?php

  include_once("../connection.php");
  include_once("functions.php");

  if (func::checkLoginState($conn))
  {
    ;
  }
  else
  {
    header("Location: index.php");
  }

?>



<!DOCTYPE html>
<html>
  <head>
    <title>Join Game</title>
  </head>
  <body>
    <form action="private_lobby.php" method="get">
      <input type="text" autocomplete="off" placeholder="Username" name="username">
      <input type="text" autocomplete="off" placeholder="Enter PIN" name="lobby_id">
      <button type="submit" name="button">Enter</button>
    </form>
    <button type="button" name="button" onclick="window.location.href='private_lobby.php?create=true'">Create a new game</button>
  </body>
</html>
