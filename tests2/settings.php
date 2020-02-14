<?php
session_start();
if(isset($_SESSION['username'])){
	require 'settings.view.php';
}else{
	header('Location: index.php');
}
?>