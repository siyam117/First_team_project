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
	<meta charset="UTF-8">
    <title>Feed</title>
	</head>
    <body>
      <div id="header">
        <button class="header-button" onclick="window.location.href = 'logout.php';">Log out</button><br>
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
</body>
</html>
