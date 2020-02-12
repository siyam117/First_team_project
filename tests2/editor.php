<?php
session_start();
if(isset($_SESSION['username'])){
	require 'editor.view.php';
}else{
	header('Location: index.php');
}

$bookTitle = $_GET['title'];
echo "title is ".$bookTitle;
?>