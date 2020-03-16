<?php

  include_once("../connection.php");
  include_once("functions.php");

  if (func::checkLoginState($conn))
  {
    if (isset($_POST["text"]))
    {
      $text = $_POST["text"];
      $writer_user_id = $_COOKIE["user_id"];
      $conn->exec("INSERT INTO private_sections (lobby_id, section_text, writer_user_id) VALUES ('aiud', '$text', $writer_user_id);");
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

    <title>Private</title>
  </head>
  <body>


    <!-- HEADER START -->
    <div id="header">

      <!-- DROPDOWN START -->
      <?php

      if (func::checkLoginState($conn))
      {

        echo '<div class="dropdown">';

          echo '<div class="hamburger-container">';
            echo '<div class="hamburger">';
              echo '<span class="bar"></span>';
              echo '<span class="bar"></span>';
              echo '<span class="bar"></span>';
            echo '</div>';
          echo '</div>';

          echo '<div class="body">';
            echo '<div class="inner-body">';

              echo '<div class="section">';

                $user_id = $_COOKIE["user_id"];
                echo "<a class='dropdown-button' href='profile.php?id=$user_id'>MY PROFILE <i class='fas fa-user'></i></a>";

              echo '</div>';

              echo '<div class="section">';
                echo '<a class="dropdown-button" href="logout.php">LOG OUT</a>';
              echo '</div>';

            echo '</div>';
          echo '</div>';

        echo '</div>';

      }

      ?>
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





    <input type="text" name="" value="">
    <button type="button" name="button">Click</button>
    <div class="box">

    </div>

    <script type="text/javascript">
      $("button").click(function(){
        $.ajax({
          type: "POST",
          url: "private.php",
          data: "text=" + $("input").val(),
        });
        console.log($(".box").html());
        $.get("private_fetch.php?id=aiud", function(data, status) {
          $(".box").html(data);
        });
      });
    </script>

    <script type="text/javascript" src="assets/js/main.js"></script>
  </body>
</html>
