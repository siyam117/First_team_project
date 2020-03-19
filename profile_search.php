<?php

  include_once("../connection.php");
  include_once("functions.php");

  if (func::checkLoginState($conn))
  {
   
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
    <title>Profile Search</title>
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
      <!-- HEADER END -->a
      <div id="profile-box"><div class = "profile-text">
        <form action="profile.php" method="post" class = "search-form"> 
        <label>Search for a profile:</label><br>
        <input id="SearchBar" id="search-field" type="text" autocomplete="off" placeholder="Username" name="username">
        <button id="SearchBtn" type="submit" name="button">Search</button>
        <hr>
        <?php
         $search = $_GET['search'];
        echo "Searching for '<i>$search</i> ' :<br><br>";
        $statement = $conn->prepare("SELECT * FROM users WHERE username LIKE '$search%';");
        $statement->execute();
        $result = $statement->fetchAll();
        if (empty($result)){
          echo "No results found.";
          echo "<br><br>";
        }
        else{
          foreach ($result as $row){
            $userID = $row['user_id'];
            $user = $row['username'];

            echo "<a href='profile.php?id=$userID'>$user</a>";
            echo "<br><br>";
          }
        }
        $id = $_COOKIE["user_id"];
        echo "<hr><a class='edit-button' href='profile.php?id=$id'><div class='editor-button-text'>Return to my profile</div></a>";
        ?>
      </div>
    <script type="text/javascript" src="assets/js/theme_change.js"></script>
    <script type="text/javascript" src="assets/js/main.js"></script>
  </body>

</html>
