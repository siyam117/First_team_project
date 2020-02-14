<?php
session_start();
if(isset($_SESSION['username'])){
	require 'editor.view.php';
}else{
	header('Location: index.php');
}

$bookID = $_GET['id'];
echo 'Book id is '.$bookID;
?>