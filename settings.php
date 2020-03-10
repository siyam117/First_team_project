<?php

	include_once("../connection.php");
	include_once("functions.php");

	if(func::checkLoginState($conn))
	{
		$user_id = $_COOKIE["user_id"];

		if(isset($_POST["title"]) && isset($_POST["section_amount"]) && isset($_POST["section_length"]))
		{
			$title = $_POST["title"];
			$section_amount = $_POST["section_amount"];
			$section_length = $_POST["section_length"];

			$amount_acceptable = $section_amount <= 20;
			$length_acceptable = $section_length <= 1000;

			if ($amount_acceptable && $length_acceptable)
			{
				if (empty($title)) {echo "Please insert a title";}
				else if (empty($section_amount)) {echo "Please insert a section amount";}
				else if (empty($section_length)) {echo "Please insert a section length";}
				else
				{
					$title = func::cleanEditorInput($title);

					//INSERTING STORY
					$statement = $conn->prepare("INSERT INTO stories (creator_user_id, title, section_amount, section_length) VALUES ($user_id, '$title', $section_amount, $section_length);");
					$statement->execute();

					//RETRIEVING STORY ID
					$row = func::sqlSELECT($conn, "SELECT * FROM stories WHERE title='$title' ORDER BY story_id DESC;");

					$storyID = $row["story_id"];

					header("Location: editor.php?id=$storyID");
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
			<link rel="stylesheet" href="assets/css/styles.css">
			<link rel="stylesheet" href="assets/css/hamburger.css">
			<link id="animation-stylesheet" rel="stylesheet" href="assets/css/title_animation.css">
        <meta charset="UTF-8">
        <title></title>
	</head>
    <body>
			<div id="header">
      <?php
      $user_id = $_COOKIE["user_id"];
      echo "<a href='profile.php?id=$user_id'>My profile</a><br>";
      ?>

        <div class="dropdown">
          <div class="hamburger">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
          </div>
          <div class="body">
            <input type="checkbox" id="title-toggle-button" />
          </div>
        </div>
        <div class="header-title">
          <div class="title" id="title-main">INKKER.IO</div>
          <div class="title" id="title-shadow-one">INKKER.IO</div>
          <div class="title" id="title-shadow-two">INKKER.IO</div>
        </div>
      </div>

        <h>Create a new story</h><br>

        <form action="settings.php" method="POST">
        <p>Title:</p>
        <input type="text" name="title"> <br>
				<p>Number of Sections (20 Max):</p>
        <input type="text" name="section_amount"> <br>
        <p>Section Length (1000 Max):</p>
        <input type="text" name="section_length"> <br>
        <button type="submit">Create story</button>
        <br>
        <br>

        <a href="feed.php">Cancel</a><br>
        <a href="logout.php">Log out</a><br>
</form>
</body>
</html>
