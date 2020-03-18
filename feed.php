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
      $query = "SELECT * FROM stories WHERE title LIKE '%$search%' OR creator_user_id = $creator_id;";
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

    <form method="post">
    <input type ="text" name="search" id="SearchBar" placeholder="Search" value="Search..." maxlength="35" autocomplete="off" onmousedown="active();" onblur="inactive();" /><input type="submit" id="SearchBtn" name="Go!"/>
    </form>

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



      <div id="feed-box">
        <a class="btn-standard btn-feed btn-feed-top" href="private_options.php"><div class="feed-button-text">Create private game</div></a>
        <a class="btn-standard btn-feed btn-feed-top" href="settings.php"><div class="feed-button-text">Create new story</div></a>
        <?php
          foreach ($row as $storydata)
          {
            $currentTitle = $storydata["title"];
            $currentID = $storydata["story_id"];

            echo "<a class='btn-standard btn-feed' href='editor.php?id=$currentID'><div class='feed-button-text'>$currentTitle</div></a>";
          }
        ?>
      </div>

      <script type="text/javascript" src="assets/js/theme_change.js"></script>
      <script type="text/javascript" src="assets/js/main.js"></script>
  </body>
</html>
