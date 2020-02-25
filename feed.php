<?php

  include_once("connection.php");
  include_once("functions.php");

  $user_id = $_COOKIE["user_id"];

  $row = func::sqlSELECT($conn, "SELECT username, password FROM users WHERE user_id='$user_id';");

  echo "Welcome " . $row["username"] . "!";
  echo "<br>Your password is " . $row["password"];

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
