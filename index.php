<?php
session_start();
if(isset($_SESSION['username'])){
		header('Location: feed.php');
}else{
		header('Location: login.php');
}
?>