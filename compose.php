<?php

  include_once("../connection.php");
  include_once("functions.php");

  if (func::checkLoginState($conn))
  {
    if (isset($_POST['sendMessage'])){
      if (!empty($_POST['subject']) && !empty($_POST['message']) && !empty($_POST['to'])){
        $tousernamePM = $_POST['to'];
        $query = "SELECT * FROM users WHERE username = '$tousernamePM';";
        $usernamerow = func::sqlSELECT($conn, $query, $fetch_all = true);
        if (!empty($usernamerow)){
          foreach ($usernamerow as $results){
            $toIDPM = $results["user_id"];
          }
          $subjectPM = htmlspecialchars(filter_var($_POST['subject'], FILTER_SANITIZE_STRING));
          $messsagePM = htmlspecialchars(filter_var($_POST['message'], FILTER_SANITIZE_STRING));
          $fromPM = $_COOKIE["user_id"];
          $date = date("Y/m/d");
          $unread = 1;
          $conn->exec("INSERT INTO messages (to_id, from_id, message, subject, date, unread)
          VALUES ('$toIDPM', '$fromPM', '$messsagePM', '$subjectPM', '$date', '$unread');");
          header("Location: inbox.php");
        }
      }
    }
    if (!empty($_GET['id'])){
      $toID = $_GET['id'];
      $stmt = "SELECT * FROM users WHERE user_id = $toID;";
      $userrow = func::sqlSELECT($conn, $stmt, $fetch_all = true);
      foreach ($userrow as $result){
         $tousername = $result["username"];
      }
    }
    else{
      $tousername = '';
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
       <form action='inbox.php' method='post'>
      <button name='returnButton' type='submit' style='background-color: Transparent;
                background-repeat:no-repeat;
                border: none;
                cursor:pointer;
                overflow: hidden;
                outline:none;
                float:right;'><img src = 'assets/images/return.png' width = 45 height = 45></button>
     </form>
      <form action="compose.php" method="POST" id='messageForm'>
        <button class="btn-standard btn-edit" type='submit' name='sendMessage'>Send</button>
        <label>To:</label>
        <?php
        echo "<input class=\"input-field input-profile\" type=\"text\" name=\"to\" value = $tousername><br>"
        ?>
        <label>Subject:</label>
        <input class="input-field input-profile" type="text" name="subject"><br>
      </form>
      Message:<br>
      <textarea cols="100" rows="15" name="message" form="messageForm">
      </textarea>
    </div></div>
  <script type="text/javascript" src="assets/js/theme_change.js"></script>
  <script type="text/javascript" src="assets/js/main.js"></script>
  </body>

</html>
