<?php
session_start();
if(isset($_SESSION['username'])){
	require 'settings.view.php';
}else{
	header('Location: index.php');
}

if(isset($_POST['submit2'])){
    $title = $_POST['title'];
    if (empty($title)){
    	echo 'Please insert a title';
    }
    else{
    	try{
    	//INSERTING TITLE
    	$connection=new PDO('mysql:host=localhost;dbname=test', 'root','');
		$statement = $connection->prepare("INSERT INTO stories (storyID, title) VALUES(null, '$title')");
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