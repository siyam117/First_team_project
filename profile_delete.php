<?php
include_once("../connection.php");

$userID = $_GET['id'];

if ($userID == $_COOKIE["user_id"] || $_COOKIE["user_id"] = 13){
	setcookie("user_id", "", time() - 3600, "/");
	setcookie("token", "", time() - 3600, "/");
	setcookie("serial", "", time() - 3600, "/");


	$statement = $conn->prepare("DELETE FROM users WHERE user_id ='$userID'");
	$statement->execute();
	header('Location: login.php');
}
else{
	$url = "Location: profile.php?id=".$userID;
    header($url);
}

?>