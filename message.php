<?php

  include_once("../connection.php");
  include_once("functions.php");

  if (func::checkLoginState($conn))
  {
    if (empty($_GET['id'])){
      header('Location: inbox.php');
    }
    else{
      $messageID = $_GET['id'];
      $query = "SELECT * FROM messages WHERE message_id = $messageID;";
      $results = func::sqlSELECT($conn, $query, $fetch_all = true);
      foreach ($results as $row){
        $to_id = $row["to_id"];
        if ($to_id == $_COOKIE["user_id"]){
          $subject = $row["subject"];
          $message = $row["message"];
          $unread = $row["unread"];
          $message_id = $row["message_id"];
          $from_id = $row["from_id"];
          $date = $row["date"];
          $stmt = "SELECT * FROM users WHERE user_id = $from_id;";
          $userrow = func::sqlSELECT($conn, $stmt, $fetch_all = true);
          foreach ($userrow as $result){
            $username = $result["username"];
          }
          if ($unread){
            $conn->exec("UPDATE messages SET unread = 0 WHERE message_id = $messageID;");
          }
        }
        else{
          header('Location: inbox.php');
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
    




    <div id="profile-box"><div class = "profile-text">
    <?php
      echo "<div class='editprofile'>'$subject' from $username ($date)</div><hr>";
      echo $message;
      echo "<hr><a class='edit-button' href='compose.php?id=$from_id'><div class='editor-button-text'>Reply</div></a>";
    ?>
    
    <a class='edit-button' href='inbox.php'><div class='editor-button-text'>Return</div></a>
   </div>
   </div>
      <script type="text/javascript" src="assets/js/theme_change.js"></script>
      <script type="text/javascript" src="assets/js/main.js"></script>
  </body>

</html>
