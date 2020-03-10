<?php

  include_once("../connection.php")

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
    <title>Join Game</title>
  </head>
  <body>
    <form action="private_lobby.php" method="post">
      <input type="text" autocomplete="off" placeholder="Username" name="username">
      <button type="submit">Enter</button>
    </form>
  </body>
</html>
