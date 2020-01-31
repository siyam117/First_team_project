<?php
$servername = "localhost";
$username = "username";
$password = "password";

$conn = new mysqli($servername, $username, $password);

$sql = "CREATE DATABASE myDB";

$conn->close();
?>
