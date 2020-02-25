<?php

  include_once("connection.php");
  include_once("functions.php");

  if (!func::checkLoginState($conn))
  {
    if (isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["passwordOne"]) && isset($_POST["passwordTwo"]))
    {
      $username = $_POST["username"];
      $email = $_POST["email"];
      $passwordOne = $_POST["passwordOne"];
      $passwordTwo = $_POST["passwordTwo"];

      $allFieldsFilled = (!empty($username) && !empty($email) && !empty($passwordOne) && !empty($passwordTwo));
      $passwordsMatch = ($passwordOne == $passwordTwo);
      $usernameUnique = func::checkUniqueUsername($conn, $username);
      $emailUnique = func::checkUniqueEmail($conn, $email);

      if ($allFieldsFilled && $passwordsMatch && $usernameUnique && $emailUnique)
      {
        func::addNewUser($conn, $username, $email, $passwordOne);
        header("location:login.php");
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
    <title>Register</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/title_animation.css">
    <script type="text/javascript" src="assets/js/lib/jquery-3.4.1.min.js"></script>
  </head>
  <body>
    <form id="homepage-form" action="register.php" method="post">
      <input class="input-field" id="username-field" type="text" autocomplete="off" placeholder="Username" name="username">
      <input class="input-field" id="email-field" type="email" autocomplete="off" placeholder="Email" name="email">
      <input class="input-field" id="password-field-one" type="password" autocomplete="off" placeholder="Password" name="passwordOne">
      <input class="input-field" id="password-field-two" type="password" autocomplete="off" placeholder="Re-type Password" name="passwordTwo">
      <button class="submit-button" id="register-button"  type="submit" name="button" disabled>Register</button>
      <div id="register-error">
        <?php
          if (isset($allFieldsFilled) && isset($passwordsMatch) && isset($usernameUnique) && isset($emailUnique))
          {
            if (!$allFieldsFilled)
            {
              echo "fill in everything!";
            }
            else if (!$passwordsMatch)
            {
              echo "passwords must match!";
            }
            else if (!$usernameUnique)
            {
              echo "username already exists!";
            }
            else if (!$emailUnique)
            {
              echo "email already exists!";
            }
          }
        ?>
      </div>
    </form>

    <script type="text/javascript" src="assets/js/register.js"></script>
  </body>
</html>
