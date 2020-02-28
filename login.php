<?php

  include_once("../connection.php");
  include_once("functions.php");

  if (!func::checkLoginState($conn))
  {
    if (isset($_POST["username"]) && isset($_POST["password"]))
    {
      $username = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
      $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);

      $loginSuccess = func::checkPassword($conn, $username, $password);

      if ($loginSuccess)
      {
        $row = func::sqlSELECT($conn, "SELECT * FROM users WHERE username='$username';");

        $user_id = $row["user_id"];
        func::startNewSession($conn, $user_id);
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
    <link rel="stylesheet" href="assets/css/login.css">
    <link id="animation-stylesheet" rel="stylesheet" href="assets/css/title_animation.css">
    <script src="https://kit.fontawesome.com/e82695925e.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="assets/js/lib/jquery-3.4.1.min.js"></script>
  </head>
  <body>
    <button id="title-toggle-button" type="button">TOGGLE TITLE</button>
    <div id="homepage-center">
      <div id="homepage-title">
        <div class="title" id="title-main">INKKER.IO</div>
        <div class="title" id="title-shadow-one">INKKER.IO</div>
        <div class="title" id="title-shadow-two">INKKER.IO</div>
      </div>
      <form id="homepage-loginbox" action="login.php" method="post">
        <div id="login-error">
          <?php
            if (isset($loginSuccess))
            {
              if (!$loginSuccess)
              {
                echo "<div>Incorrect username/password!</div>";
              }
            }
          ?>
        </div>
        <input class="input-field" id="username-field" type="text" autocomplete="off" placeholder="Username" name="username">
        <input class="input-field" id="password-field" type="password" autocomplete="off" placeholder="Password" name="password">
        <button class="submit-button" id="login-button" type="submit" name="button" disabled>Login <i class="fas fa-sign-in-alt"></i></button>
      </form>
      <button class="submit-button" onclick="window.location.href = 'register.php';" name="button">Register</button>
    </div>

    <script type="text/javascript" src="assets/js/login.js"></script>
    <script type="text/javascript" src="assets/js/title_animation_toggle.js"></script>
  </body>
</html>
