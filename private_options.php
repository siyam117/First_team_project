<?php

  include_once("../connection.php");
  include_once("functions.php");

  if (func::checkLoginState($conn))
  {

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
