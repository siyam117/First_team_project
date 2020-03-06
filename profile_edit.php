<?php

  include_once("../connection.php");
  include_once("functions.php");

  if (func::checkLoginState($conn))
  {
    $userID = $_GET['id'];
    $id = $_COOKIE["user_id"];
    $query = "SELECT * FROM users WHERE user_id = $userID;";
    $row = func::sqlSELECT($conn, $query, $fetch_all = true);
    $url = "Location: profile_edit.php?id=".$userID;
    foreach ($row as $results){
      $username = $results["username"];
      $picture = $results["picture"];
      $salt = $results["password_salt"];
    }
    if ($userID == $id){
      
      if(isset($_POST['submitUser'])){
        $username2 = $_POST['username'];

        if(!empty($username2)){
          if(func::checkUniqueUsername($conn, $username2)){
            $username2 = filter_var($username2, FILTER_SANITIZE_STRING);
            $statement = $conn->prepare("UPDATE users SET username = '$username' WHERE user_id ='$id'");
            $statement->execute();
            echo '<script language="javascript">';
            echo 'alert("Username changed")';
            echo '</script>';
          }
          else{
            echo "Username already exists";
          }
        }
        else{
          echo "Please insert your new username";
        }
      }

      if(isset($_POST['submitPass'])){
        $password = $_POST['password'];
        $passwordOld = $_POST['passwordOld'];

        if(!empty($password) && !empty($passwordOld)){
          $password = filter_var($password, FILTER_SANITIZE_STRING);
          $passwordOld = filter_var($passwordOld, FILTER_SANITIZE_STRING);
          $checkPassword = func::checkPassword($conn, $username, $passwordOld);

          if($checkPassword){
            $password = func::passwordHash($password, $salt);
            $conn->exec("UPDATE users SET password = '$password' WHERE user_id = '$userID';");
            echo '<script language="javascript">';
            echo 'alert("Password changed")';
            echo '</script>';
          }
          else{
            echo "Incorrect old password";
          }
        }
        else{
          echo "Please insert your new and old passwords";
        }
      }
      if(isset($_POST['submitEmail'])){
        $email = $_POST['email'];

        if(!empty($email)){
          if(func::checkUniqueEmail($conn, $email)){
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            $conn->exec("UPDATE users SET email = '$email' WHERE user_id = '$userID';");
            echo '<script language="javascript">';
            echo 'alert("Email changed")';
            echo '</script>';
          }
          else{
            echo "Email taken";
          }
        }
        else{
          echo "Please insert your new email";
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
  <script type="text/javascript" src="assets/js/lib/jquery-3.4.1.min.js"></script>
  <meta charset="UTF-8">
    <title>Profile Edit</title>
  </head>

  <body>
     <?php
    if ($userID == $_COOKIE["user_id"]){
      echo "<br>";
      echo "Edit ".$username."'s profile<br>";
      echo "<hr>";
      echo "<img src ='$picture'><br>";
      echo "<a href='profile_picture.php'>Change your profile picture</a>";
      echo "<hr>";
      echo "Enter new login credentials:";

    }
    else{
      $id = $_GET['id'];
      $url = "Location: profile.php?id=".$id;
      header($url);
    }
  
     ?>

    <form action="" method="POST"><br>
        <p2>New Username:</p2><br> 
        <input type="text" name="username"> <br>
        <button type='submit' name='submitUser'>Change username</button>
        <hr>
        <p2>New Password:</p2> <br>
        <input type="password" name="password"><br>
        <p2>Old Password:</p2> <br>
        <input type="password" name="passwordOld"><br>
        <button type='submit' name='submitPass'>Change password</button>
        <hr>
        <p2>New Email:</p2> <br>
        <input type="email" name="email"><br>
        <button type='submit' name='submitEmail'>Change email</button>
        <hr>
    </form>
    <a href="profile_delete.php">Delete profile</a><hr>
    <?php
    echo "<a href='profile.php?id=$userID'>Return</a><br>";
    ?>
  </body>

</html>
