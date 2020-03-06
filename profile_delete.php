<?php
setcookie("user_id", "", time() - 3600, "/");
setcookie("token", "", time() - 3600, "/");
setcookie("serial", "", time() - 3600, "/");

include_once("../connection.php");

$id = $_COOKIE["user_id"];

$statement = $conn->prepare("DELETE FROM users WHERE user_id ='$id'");
$statement->execute();

header('Location: login.php');
?>