<?php
session_start();
if(isset($_SESSION['username'])){
	require 'settings.view.php';
}else{
	header('Location: index.php');
}

if(isset($_POST['submit2'])){
    $title = $_POST['title'];
		$num_sec = $_POST['section_amount'];
		$sec_length = $_POST['section_length'];
    if (empty($title) || empty($num_sec) || empty($sec_length)){
    	echo 'Please do not leave any field empty.';
    }
    else{
    	try{
    	//INSERTING TITLE
    	require 'connection.php';
		$statement = $connection->prepare("INSERT INTO stories (storyID, title, section_amount, section_length) VALUES(null, '$title', '$num_sec', '$sec_length')");
		$statement->execute(
			array(':title'=> $title));

		//RETRIEVING STORY ID
		$statement=$connection->prepare('SELECT storyID FROM stories WHERE title = :Title ORDER BY storyID DESC');

		$statement->execute(
			array(':Title'=> $title));
		$row = $statement->fetch(PDO::FETCH_ASSOC);
		$id = $row["storyID"];

		$link = 'Location: editor.php?id='.$id;
		header($link);

		}catch(PDOException $e){
		echo "Error: ".$e->getMessage();
		}
    }
}
?>
