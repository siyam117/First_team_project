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
    <title>Private</title>
    <script type="text/javascript" src="assets/js/lib/jquery-3.4.1.min.js"></script>

  </head>
  <body>
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
  </body>
</html>
