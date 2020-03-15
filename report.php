<?php

  include_once("../connection.php");
  include_once("functions.php");

  if (func::checkLoginState($conn))
  {
    $id = $_GET["id"];
    if(isset($_POST["reported"])){
      $comment = htmlspecialchars($_POST["comment"]);
      $message = "User reported story with ID ".$id.". <br>Additional details: <br>".$comment;
      mail('email','REPORT', $message);
      header("Location: feed.php");
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
	<meta charset="UTF-8">
    <title>Report</title>
	</head>

  <body>
    <div class="header-title">
      <div class="title" id="title-main">INKKER.IO</div>
      <div class="title" id="title-shadow-one">INKKER.IO</div>
      <div class="title" id="title-shadow-two">INKKER.IO</div>


    </div>
    <div class="create" id="create-main">REPORT A STORY</div>
    <div class="create" id="create-shadow-one">REPORT A STORY</div>
    <div class="create" id="create-shadow-two">REPORT A STORY</div>
  </div>
  
    <p>Report a story:</p>
    <hr>
    Provide some additional details:<br>
    <textarea rows="4" cols="50" name="comment" form="reportform">
    </textarea>
    <?php
    echo "<form action ='report.php?id=$id' method = 'POST' id='reportform'>";
    ?>
      <button type="submit" name="reported">Report</button>
    </form>
    <br>
    <a href = 'feed.php'>Cancel</a>
  </body>

</html>
