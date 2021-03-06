<?php

  include_once("../connection.php");
  include_once("functions.php");

  if (func::checkLoginState($conn))
  {
    //searching for usernames
    $userID = $_GET['id'];
    if (isset($_POST["username"])){
      if (!empty($_POST["username"])){
        $user = $_POST["username"];
        $redirect = "Location: profile_search.php?search=".$user;
        header($redirect);
      }
      else{
        $activeID = $_COOKIE["user_id"];
        $redirect = "Location: profile.php?id=".$activeID;
        header($redirect);
      }
    }
    //getting user info to post on website
    
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
  <link rel="stylesheet" href="assets/css/master.css">
  <script type="text/javascript" src="assets/js/lib/jquery-3.4.1.min.js"></script>
  <script src="https://kit.fontawesome.com/e82695925e.js" crossorigin="anonymous"></script>
  <meta charset="UTF-8">
    <title>Profile</title>
  </head>

  <body>




    <!-- HEADER START -->
      <div id="header">

        <!-- DROPDOWN START -->
        <div class="dropdown">

          <div class="hamburger-container">
            <div class="hamburger">
              <span class="bar"></span>
              <span class="bar"></span>
              <span class="bar"></span>
            </div>
          </div>

          <div class="body">
            <div class="inner-body">

              <div class="section">
                <?php
                  echo "<a class=\"dropdown-button\" href=\"feed.php\">FEED <i class='fas fa-home'></i></a>"; 
                ?>  
              </div>

              <div class="section">
                <a class="dropdown-button" href="logout.php">LOG OUT</a>
              </div>

            </div>
          </div>

        </div>
        <!-- DROPDOWN END -->
         <!-- INBOX START -->
        <div class = "inbox">
          <?php
           $userID = $_GET['id'];
            $query = "SELECT * FROM messages WHERE to_id = $userID;";
            $unreadstories = func::sqlSELECT($conn, $query, $fetch_all = true);
            $img = "<img src='assets/images/mail.png' width=75 height=75>";
            foreach ($unreadstories as $rows)
            {
              $unread = $rows['unread'];
              if ($unread){
                 $img = "<img src='assets/images/unread.png' width=75 height=75>";
              }
            }
            echo "<form action='inbox.php' method='post'>";
            echo "<button name='inboxbutton' type='submit' style='background-color: Transparent;
                  background-repeat:no-repeat;
                  border: none;
                  cursor:pointer;
                  overflow: hidden;
                  outline:none;'>$img</button>";
            echo "</form>"
          ?>
        </div>
        <!-- INBOX END -->
        <!-- TITLE START -->
        <a id="header-title" href="index.php">
          <div class="glitch-container">
            <div class="glitch-text" id="glitch-main">INKKER.IO</div>
            <div class="glitch-text" id="glitch-shadow-one">INKKER.IO</div>
            <div class="glitch-text" id="glitch-shadow-two">INKKER.IO</div>
          </div>
        </a>
        <!-- TITLE END -->

      </div>
      <!-- HEADER END -->
    




    <div id="profile-box"><div class = "profile-text">
    
    <form action="profile.php" method="post" class = "search-form"> 
    <div class='editprofile'>Search for a profile:</div><br>
    <input id="SearchBar" id="search-field" type="text" autocomplete="off" placeholder="Username" name="username">
    <button id="SearchBtn" type="submit" name="button">Search</button>
    <hr>

      </form>
     <?php
      echo "<div class ='profile-container'><img src='$picture' width='250' height='250' class = 'profile_picture'>";
      echo "<div class ='user-text'>".$username."'s profile</div></div>";
      //echo "<hr>";
      echo "<div class = 'clear'>";
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
      echo "<hr>Total Likes: ".$totalLikes;
      echo "<br>Total Views: ".$totalViews;
      //calculating total views
      //allowing edit button if this is the users profile page
      if ($userID == $_COOKIE["user_id"] || $_COOKIE["user_id"] == 1){
        echo "<hr><a class='edit-button' href='profile_edit.php?id=$userID'><div class='editor-button-text'>Edit profile</div></a>";
      }
      else{
        $id = $_COOKIE["user_id"];
        echo "<hr><a class='edit-button' href='compose.php?id=$id'><div class='editor-button-text'>Message</div></a>";
        echo "<a class='edit-button' href='profile.php?id=$id'><div class='editor-button-text'>Return to my profile</div></a>";
      }

     ?>
   </div>
   </div>
   </div>
      <script type="text/javascript" src="assets/js/theme_change.js"></script>
      <script type="text/javascript" src="assets/js/main.js"></script>
  </body>

</html>
