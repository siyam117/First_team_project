<?php

	include_once("connection.php");
	include_once("functions.php");

	if(func::checkLoginState($conn))
	{
		$story_id = $_GET['id'];

		$stories = func::sqlSELECT($conn, "SELECT * FROM stories WHERE story_id='$story_id';");

		$creator_user_id = $stories["creator_user_id"];
		$story_title = $stories["title"];
		$section_amount = $stories["section_amount"];

		$users = func::sqlSELECT($conn, "SELECT * FROM users WHERE user_id='$creator_user_id';");

		$creator_username = $users["user_id"];

		$sections = func::sqlSELECT($conn, "SELECT * FROM sections WHERE story_id='$story_id' ORDER BY section_order ASC;", $fetch_all = true);
	}
	else
	{
		header('Location: index.php');
	}

?>



<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="assets/css/styles.css">
	  <link rel="stylesheet" href="assets/css/editor.css">
		<title>Editor</title>
	</head>
	<body>
		<div id="story-display-box">
			<div id="story-display-box-header">
				<a href="feed.php">Go Back</a><br>
				<div id="story-title"><?php echo $story_title; ?></div>
			</div>
			<hr>
			<div id="story-display-box-body">
				<?php
					foreach ($sections as $sectiondata)
					{
						$section_text = $sectiondata["section_text"];

						echo "<div class='story-section'>$section_text</div>";
					}
				?>
			</div>
		</div>
	</body>
</html>
