<?php

  include_once("../connection.php");
  include_once("functions.php");

  if (func::checkLoginState($conn))
  {
    //changing profile picture
    if (isset($_POST["pp"])){
      $picture = ($_POST["pp"]);
      $id = $_COOKIE["user_id"];
      $conn->exec("UPDATE users SET picture = '$picture' WHERE user_id = $id;");
      $url = 'Location: profile_edit.php?id='.$id;
      header($url);
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
    <title>Profile Pictures</title>
	</head>

  <body>
    <h>Choose your profile picture:</h>
    <form action = 'profile_picture.php' method = "POST">
      <img src='assets/images/default.jpg'><br>
      <input type="radio" name="pp" value="assets/images/default.jpg"><br><br>
      <img src='assets/images/1.jpg'><br>
      <input type="radio" name="pp" value="assets/images/1.jpg"><br><br>
      <img src='assets/images/2.jpg'><br>
      <input type="radio" name="pp" value="assets/images/2.jpg"><br><br>
      <img src='assets/images/3.jpg'><br>
      <input type="radio" name="pp" value="assets/images/3.jpg"><br><br>
      <button type='submit' name='submit'>Confirm</button>
    </form>
    <br>
    <?php
    $id = $_COOKIE["user_id"];
    echo "<a href='profile_edit.php?id=$id'>Cancel</a>";
    ?>
  </body>

</html>
