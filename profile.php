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
      //calculating total likes of this user's created story
      $totalLikes = 0;
      $totalViews = 0;
      $sql = "SELECT * FROM stories WHERE creator_user_id = '$userID'";
      $row = func::sqlSELECT($conn, $sql, $fetch_all = true);
      foreach ($row as $results){
        $story_id = $results["story_id"];
        $story_view = $results["views"];
        $totalViews += $story_view;
        $sql2 = "SELECT COUNT(*) FROM `$story_id`";
        $result = $conn->prepare($sql2); 
        $result->execute(); 
        //getting total number of likes
        $number_of_likes = $result->fetchColumn();
        $totalLikes += $number_of_likes;
      }
      if ($totalLikes>999999){
          $totalLikes = substr($totalLikes, 0, -6);
          $totalLikes = $totalLikes.'M';
        }
        else if ($totalLikes>999){
          $totalLikes = substr($totalLikes, 0, -3);
          $totalLikes = $totalLikes.'K';
        }
        if ($totalViews>999999){
          $totalViews = substr($totalViews, 0, -6);
          $totalViews = $totalViews.'M';
        }
        else if ($totalViews>999){
          $totalViews = substr($totalViews, 0, -3);
          $totalViews = $totalViews.'K';
        }
      echo "<p>Total Likes: ".$totalLikes;
      echo "<br>Total Views: ".$totalViews;
      echo "</p><hr>";
      //calculating total views
      //allowing edit button if this is the users profile page
      if ($userID == $_COOKIE["user_id"]){
        echo "<a href='profile_edit.php?id=$userID'>Edit profile</a><hr>";
        echo "<a href='logout.php'>Log out</a><hr>";
      }
      echo "<a href='feed.php'>Return to feed</a>";
     ?>
  </body>

</html>
