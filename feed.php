<?php

  include_once("../connection.php");
  include_once("functions.php");

  if (func::checkLoginState($conn))
  {
    $query = "SELECT * FROM stories;";
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
	<link rel="stylesheet" href="assets/css/styles.css">
  <link rel="stylesheet" href="assets/css/feed.css">
  <link rel="stylesheet" href="assets/css/hamburger.css">
  <link id="animation-stylesheet" rel="stylesheet" href="assets/css/title_animation.css">
  <script type="text/javascript" src="assets/js/lib/jquery-3.4.1.min.js"></script>
	<meta charset="UTF-8">
    <title>Feed</title>
	</head>
    <body>
      <div id="header">

        <div class="dropdown">
          <div class="hamburger">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
          </div>
          <div class="body">

          </div>
        </div>
        <div class="header-title">
          <div class="title" id="title-main">INKKER.IO</div>
          <div class="title" id="title-shadow-one">INKKER.IO</div>
          <div class="title" id="title-shadow-two">INKKER.IO</div>
        </div>
      </div>
      <div id="feed-box">
        <a class="feed-button" id="feed-button-addstory" href="settings.php"><div class="feed-button-text">Create new story</div></a>
        <?php
          foreach ($row as $storydata)
          {
            $currentTitle = $storydata["title"];
          	$currentID = $storydata["story_id"];

          	echo "<a class='feed-button' href='editor.php?id=$currentID'><div class='feed-button-text'>$currentTitle</div></a>";
          }
        ?>
      </div>

      <script type="text/javascript" src="assets/js/main.js"></script>
  </body>
</html>
