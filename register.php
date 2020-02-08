<?php

  include_once("config.php");
  include_once("functions.php");

  if (!func::checkLoginState($dbh))
  {
    if (isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["password"]))
    {
      $username = $_POST["username"];
      $email = $_POST["email"];
      $password = $_POST["password"];

      func::addNewUser($dbh, $username, $email, $password);

      header("location:login.php");
    }
  }
  else
  {
    header("location:index.php");
  }

?>



<!DOCTYPE html>
<html>
  <head>
    <title>Register</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/title_animation.css">
  </head>
  <body>
    <form id="homepage-form" action="register.php" method="post">
      <input class="input-field" type="text" autocomplete="off" placeholder="Username" name="username">
      <input class="input-field" type="text" autocomplete="off" placeholder="Email" name="email">
      <input class="input-field" type="password" autocomplete="off" placeholder="Password" name="password">
      <input class="input-field" type="password" autocomplete="off" placeholder="Re-type Password" name="password">
      <button class="submit-button" type="submit" name="button">Register</button>
    </form>
  </body>
</html>
