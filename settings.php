<?php

	include_once("connection.php");
	include_once("functions.php");

	if(func::checkLoginState($conn))
	{
		$user_id = $_COOKIE["user_id"];

		if(isset($_POST["title"]) && isset($_POST["num_sec"]) && isset($_POST["sec_length"]))
		{
			$title = $_POST["title"];
			$section_amount = $_POST["num_sec"];
			$section_length = $_POST["sec_length"];

			if (empty($title))
			{
				echo "Please insert a title";
			}
			else
			{

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
	else
	{
		header("Location: index.php");
	}

?>



<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
	</head>
    <body>
        <h>Create a new story</h><br>

        <form action="settings.php" method="POST">
        <p>Title:</p>
        <input type="text" name="title"> <br>
				<p>Number of Sections:</p>
        <input type="text" name="num_sec"> <br>
        <p>Section Length:</p>
        <input type="text" name="sec_length"> <br>
        <button type="submit" name="submit2">Create story</button>
        <br>
        <br>

        <a href="feed.php">Cancel</a><br>
        <a href="logout.php">Log out</a><br>
</form>
</body>
</html>
