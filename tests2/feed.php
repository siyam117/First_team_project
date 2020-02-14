<?php
session_start();
if(isset($_SESSION['username'])){
	require 'feed.view.php';
}else{
	header('Location: index.php');
}

$conn=mysqli_connect('localhost', 'root','','test');
if(!$conn)
{
die("Connection failed: " . mysqli_connect_error());
}
$statement='SELECT * FROM stories';

$result = mysqli_query($conn,$statement);

echo '<br>';
$currentTitle = '';
$currentID = '';
while($row = mysqli_fetch_array($result))
	{
		$currentTitle = $row['title']; 
		$currentID = $row['storyID'];
	    echo "<br>"."<a href='editor.php?id=$currentID'>$currentTitle</a>";
	}


?>