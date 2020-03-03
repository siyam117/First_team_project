<?php

	include_once("../connection.php");
	include_once("functions.php");

	if(func::checkLoginState($conn))
	{
		$story_id = $_GET['id'];

		$stories = func::sqlSELECT($conn, "SELECT * FROM stories WHERE story_id='$story_id';");

		$creator_user_id = $stories["creator_user_id"];
		$story_title = $stories["title"];
		$section_amount = $stories["section_amount"];
		$section_length = $stories["section_length"];

		$users = func::sqlSELECT($conn, "SELECT * FROM users WHERE user_id='$creator_user_id';");

		$creator_username = $users["user_id"];

		//INSERTS NEW SECTION IF ONE WAS SUBMITTED
		if (isset($_POST["sectionOrder"]) && isset($_POST["sectionText"]))
		{
			$writer_user_id = $_COOKIE["user_id"];
			$section_order = $_POST["sectionOrder"];
			$section_text = $_POST["sectionText"];

			$section_text = func::cleanEditorInput($section_text);

			if ($section_text != null)
			{

				$word_count = count(explode(" ", $section_text));

				if ($word_count > 0 && $word_count <= $section_length)
				{
					$stmt = $conn->prepare("INSERT INTO sections (story_id, writer_user_id, section_order, section_text) VALUES ($story_id, $writer_user_id, $section_order, '$section_text');");
					$stmt->execute();
				}

			}
		}

		$sections = func::sqlSELECT($conn, "SELECT * FROM sections WHERE story_id='$story_id' ORDER BY section_order ASC;", $fetch_all = true);

		$empty_sections = $section_amount - count($sections);
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
		<script type="text/javascript" src="assets/js/lib/jquery-3.4.1.min.js"></script>
		<title>Editor</title>
	</head>
		<body oncopy="return false" oncut="return false" onpaste="return false">
		<div id="story-display-box">
			<div id="story-display-box-header">
				<a href="feed.php">Go Back</a><br>
				<div id="story-title"><?php echo $story_title; ?></div>
			</div>
			<hr id="title-body-line">
			<div id="story-display-box-body">
				<?php
					foreach ($sections as $sectiondata)
					{
						$section_text = $sectiondata["section_text"];
						echo "<div class='story-section'><div class='story-section-text'>$section_text</div></div><hr class='section-line'>";
					}
					if ($empty_sections > 0)
					{
						$section_order = count($sections) + 1;
						echo "<div class='story-section story-section-input-button'><div class='story-section-input-clickhere'>Click Here To Add</div></div>";
						echo "<textarea class='story-section-input-field' name='sectionText' form='story-section-input-form'></textarea>";
						echo "<form class='story-section-input-form' id='story-section-input-form' action='editor.php?id=$story_id' method='post'><input type='hidden' name='sectionOrder' value='$section_order'><button class='story-section-input-form-button' type='submit'>Submit</button><div class='story-section-input-form-wordcount'>0/$section_length Words</div></form>";
						echo "<hr class='section-line'>";
					}
					for ($i=0; $i < $empty_sections - 1; $i++)
					{
						echo "<div class='story-section story-section-empty'></div><hr class='section-line'>";
					}
				?>
			</div>
		</div>

		<script type="text/javascript" src="assets/js/editor.js"></script>
	</body>
</html>
