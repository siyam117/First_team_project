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
    

   

  <div id="profile-box">
      <form action='feed.php' method='post'>
      <button name='returnButton' type='submit' style='background-color: Transparent;
                background-repeat:no-repeat;
                border: none;
                cursor:pointer;
                overflow: hidden;
                outline:none;
                float:right;'><img src = 'assets/images/return.png' width = 45 height = 45></button>
     </form>
     <br><br><br>
     <a class='btn-standard btn-feed btn-compose' href='compose.php'><div class='feed-button-text'>+</div></a>
  <br>
    <?php
      $user_id = $_COOKIE["user_id"];
      $query = "SELECT * FROM messages WHERE to_id = $user_id ORDER BY message_id DESC;";
      $results = func::sqlSELECT($conn, $query, $fetch_all = true);
      foreach ($results as $row)
      {
        $subject = $row["subject"];
        $message_id = $row["message_id"];
        $from_id = $row["from_id"];
        $date = $row["date"];
        $unread = $row['unread'];
        $stmt = "SELECT * FROM users WHERE user_id = $from_id;";
        $userrow = func::sqlSELECT($conn, $stmt, $fetch_all = true);
        foreach ($userrow as $result){
          $username = $result["username"];
        }
        
        if ($unread){
           echo "<a class='btn-standard btn-feed btn-feed-top' href='message.php?id=$message_id'><div class='feed-button-text'>'$subject' from $username ($date)</div></a>";
        }else{
          echo "<a class='btn-standard btn-feed' href='message.php?id=$message_id'><div class='feed-button-text'>'$subject' from $username ($date)</div></a>";
        }
       
      }
    ?>
  </div>

  <script type="text/javascript" src="assets/js/theme_change.js"></script>
  <script type="text/javascript" src="assets/js/main.js"></script>
  </body>

</html>
