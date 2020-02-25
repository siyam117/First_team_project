<?php

	include_once("connection.php");
	include_once("functions.php");

	if(func::checkLoginState($conn))
	{
		$storyID = $_GET['id'];
		echo "Story id is " . $storyID;
	}
	else
	{
		header('Location: index.php');
	}
?>



<!DOCTYPE html>
<html>
	<head>
		<title>Editor</title>
	</head>
	<body>
		<h>You're in editor</h><br>
		<a href="feed.php">Feed</a><br>
	</body>
</html>
