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
    <link rel="stylesheet" href="assets/css/master.css">
    <link id="animation-stylesheet" rel="stylesheet" href="assets/css/title_animation.css">
    <script src="https://kit.fontawesome.com/e82695925e.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="assets/js/lib/jquery-3.4.1.min.js"></script>
  </head>
  <body>
    <div id="homepage-center">

      <div id="login-title">
        <div class="glitch-container">
          <div class="glitch-text" id="glitch-main">INKKER.IO</div>
          <div class="glitch-text" id="glitch-shadow-one">INKKER.IO</div>
          <div class="glitch-text" id="glitch-shadow-two">INKKER.IO</div>
        </div>
      </div>

      <div id="login-caption">
        <div class="glitch-container">
          <div class="glitch-text" id="glitch-main">A NEW WAY OF WRITING</div>
          <div class="glitch-text" id="glitch-shadow-one">A NEW WAY OF WRITING</div>
          <div class="glitch-text" id="glitch-shadow-two">A NEW WAY OF WRITING</div>
        </div>
      </div>



      <div class="container-standard container-login">
        <form action="login.php" method="post">
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

          <input class="input-field input-login" type="text" autocomplete="off" placeholder="Username" name="username">
          <input class="input-field input-login" type="password" autocomplete="off" placeholder="Password" name="password">
          <button class="btn-standard btn-login" type="submit" name="button" disabled>Login <i class="fas fa-sign-in-alt"></i></button>
        </form>
      </div>


      <button class="btn-standard btn-login" onclick="window.location.href = 'register.php';" name="button">Register</button>
    </div>

    <script type="text/javascript" src="assets/js/login.js"></script>
    <script type="text/javascript" src="assets/js/title_animation_toggle.js"></script>
  </body>
</html>
