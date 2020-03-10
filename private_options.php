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
    <title>Private Games</title>
  </head>
  <body>
    <form action="private_username.php" method="get">
      <input type="text" autocomplete="off" placeholder="Enter PIN" name="lobby_id">
      <button type="submit">Enter</button>
    </form>
    <form action="private_username.php" method="post">
      <input type="hidden" name="create">
      <button type="submit">Create a new game</button>
    </form>
  </body>
</html>
