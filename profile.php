<?php

  include_once("../connection.php");
  include_once("functions.php");

  if (func::checkLoginState($conn))
  {
    //searching for usernames
    if (isset($_POST["username"])){
      if (!empty($_POST["username"])){
        $user = $_POST["username"];
        $redirect = "Location: profile_search.php?search=".$user;
        header($redirect);
      }
    }
    //getting user info to post on website
    $userID = $_GET['id'];
    $query = "SELECT * FROM users WHERE user_id = $userID;";
    $row = func::sqlSELECT($conn, $query, $fetch_all = true);
    foreach ($row as $results){
      $username = $results["username"];
      $email = $results["email"];
      $picture = $results["picture"];
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
    <title>Profile</title>
	</head>

  <body>
    <p>Search for a profile:</p>
    <form action="profile.php" method="post">

    <input class="input-field" id="search-field" type="text" autocomplete="off" placeholder="Username" name="username">
    <button class="submit-button" id="search-button" type="submit" name="button">Search</button>
    <hr>

      </form>
     <?php
      echo "<br>";
      echo "<p>".$username."'s profile</p><br>";
      echo "<hr>";
      echo "<img src='$picture' width='100' height='100'>";
      echo "<hr>";
      //allowing edit button if this is the users profile page
      if ($userID == $_COOKIE["user_id"]){
        echo "<a href='profile_edit.php?id=$userID'>Edit profile</a><hr>";
        echo "<a href='logout.php'>Log out</a><hr>";
      }
      echo "<a href='feed.php'>Return to feed</a>";
     ?>
  </body>

</html>
