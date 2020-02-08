<?php

  include_once("config.php");
  include_once("functions.php");

  if (!func::checkLoginState($dbh))
  {
    if (isset($_POST["username"]) && isset($_POST["password"]))
    {
      $username = $_POST["username"];
      $password = $_POST["password"];

      if (func::checkPassword($dbh, $username, $password))
      {
        $stmt = $dbh->prepare("SELECT * FROM users WHERE username='$username';");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $user_id = $row["user_id"];
        func::startNewSession($dbh, $username, $user_id);
        header("location:index.php");
      }
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
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/title_animation.css">
    <script src="https://kit.fontawesome.com/e82695925e.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="assets/js/lib/jquery-3.4.1.min.js"></script>
  </head>
  <body>
    <div id="homepage-center" class="centered">
      <div id="homepage-title">
        <div class="title" id="title-main">INKKER.IO</div>
        <div class="title" id="title-shadow-one">INKKER.IO</div>
        <div class="title" id="title-shadow-two">INKKER.IO</div>
      </div>
      <form id="homepage-form" action="login.php" method="post">
        <input class="input-field" type="text" autocomplete="off" placeholder="Username" name="username">
        <input class="input-field" type="password" autocomplete="off" placeholder="Password" name="password">
        <button class="submit-button" type="submit" name="button">Login <i class="fas fa-sign-in-alt"></i></button>
      </form>
      <button class="submit-button" onclick="window.location.href = 'register.php';" name="button">Register</button>
    </div>
  </body>
</html>
