<?php

  include_once("config.php");
  include_once("functions.php");

  if (func::checkLoginState($dbh))
  {
    echo "Welcome " . $_SESSION["username"] . "!";

    $user_id = $_COOKIE["user_id"];

    $stmt = $dbh->prepare("SELECT password FROM users WHERE user_id='$user_id';");
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<br>Your password is " . $row["password"];
  }
  else
  {
    header("location:login.php");
  }

?>



<!DOCTYPE html>
<html>
  <head>
    <title>inkker.io</title>
  </head>
  <body>
    <a href="logout.php">Log out</a>
  </body>
</html>
