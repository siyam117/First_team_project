<?php

  include_once("../connection.php");
  include_once("functions.php");

  if (func::checkLoginState($conn))
  {
    if (isset($_POST["search"]) && $_POST["search"] != 'Search...'){
      $search = $_POST["search"];
      //getting creator name
      $sql = "SELECT * FROM users WHERE username = '$search';";
      $row = func::sqlSELECT($conn, $sql, $fetch_all = true);
      foreach ($row as $results){
        $creator_id = $results["user_id"];
      }
      if (empty($creator_id)){
        $query = "SELECT * FROM stories WHERE title LIKE '%$search%';";
      }
      else{
        //searches both tables for the query entered
        $query = "SELECT * FROM stories WHERE title LIKE '%$search%' OR creator_user_id = $creator_id;";
      }
    }
    else{
      $query = "SELECT * FROM stories;";
    }
    $row = func::sqlSELECT($conn, $query, $fetch_all = true);
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

        <script type = "text/javascript">
            function active(){
                var SearchBar = document.getElementById('SearchBar');

                if(SearchBar.value == 'Search...'){
                    SearchBar.value = ''
                    SearchBar.placeholder = 'Search...'
                }
            }
            function inactive(){
                var SearchBar = document.getElementById('SearchBar');

                if(SearchBar.value == ''){
                    SearchBar.value = 'Search...'
                    SearchBar.placeholder = ''
                }
            }

        </script>

    <title>Feed</title>
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
                $user_id = $_COOKIE["user_id"];
                echo "<a class='dropdown-button' href='profile.php?id=$user_id'>MY PROFILE <i class='fas fa-user'></i></a>";
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
            $query = "SELECT * FROM messages WHERE to_id = $user_id;";
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






      <form method="post" style="display: block;">
      <input type ="text" name="search" id="SearchBar" placeholder="Search" value="Search..." maxlength="35" autocomplete="off" onmousedown="active();" onblur="inactive();" /><input type="submit" id="SearchBtn" value="Search"/>
      </form>


      <div id="feed-box">
        <a class="btn-standard btn-feed btn-feed-top" href="private_options.php"><div class="feed-button-text">Create private game</div></a>
        <a class="btn-standard btn-feed btn-feed-top" href="settings.php"><div class="feed-button-text">Create new story</div></a>
        <section class = "stories-list">
        <?php
          foreach ($row as $storydata)
          {
            $currentTitle = $storydata["title"];
            $currentID = $storydata["story_id"];
            $creatorID = $storydata["creator_user_id"];
            $stmt = "SELECT * FROM users WHERE user_id = $creatorID;";
            $userrow = func::sqlSELECT($conn, $stmt, $fetch_all = true);
            if (empty($userrow)){
              $creator = "deleted";
            }
            else{
              foreach ($userrow as $result){
                $creator = $result["username"];
              }
            }
            
            $sql = "SELECT COUNT(*) FROM `$currentID`";
            $result = $conn->prepare($sql);
            $result->execute();
            //getting total number of likes
            $number_of_likes = $result->fetchColumn();
            $number_of_likes += 0;
            if ($number_of_likes>999999){
              $number_of_likes = substr($number_of_likes, 0, -6);
              $number_of_likes = $number_of_likes.'M';
            }
            else if ($number_of_likes>999){
              $number_of_likes = substr($number_of_likes, 0, -3);
              $number_of_likes = $number_of_likes.'K';
            }

            echo "<a class='btn-standard btn-feed stories' href='viewadder.php?id=$currentID'><hr class ='divider'><div class='feed-button-image'><img src = 'assets/images/default.jpg' width = 100% height = 360></div><div class='feed-button-text stories'>$currentTitle</div><div class='creator'>by $creator</div><div class='likeimage'><div class='nolikes'>$number_of_likes</div><img src = 'assets/images/like.png' alt = 'likes' width=50 height=50></div></a>";
          }
        ?>
        </section>
      </div>

      <script type="text/javascript" src="assets/js/theme_change.js"></script>
      <script type="text/javascript" src="assets/js/main.js"></script>
  </body>
</html>
