<?php
include_once("../connection.php");
include_once("functions.php");

$story_id = $_GET['id'];
$stories = func::sqlSELECT($conn, "SELECT * FROM stories WHERE story_id='$story_id';");

$views = $stories["views"];

$NewViews = $views + 1;

$statement = $conn->prepare("UPDATE stories SET views = $NewViews WHERE story_id = '$story_id'");
$statement->execute();

$location = "Location: editor.php?id=".$story_id;
header($location);
?>