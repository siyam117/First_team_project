<?php

	include_once("connection.php");
	include_once("functions.php");

	if(func::checkLoginState($conn))
	{
		if(isset($_POST["title"])){
				$title = $_POST["title"];
				if (empty($title))
				{
					echo "Please insert a title";
				}
				else
				{
				//INSERTING TITLE
				$statement = $conn->prepare("INSERT INTO stories (title) VALUES ('$title');");
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
        <button type="submit" name="submit2">Create story</button>
        <br>
        <br>

        <a href="feed.php">Cancel</a><br>
        <a href="logout.php">Log out</a><br>
</form>
</body>
</html>
