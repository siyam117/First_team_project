<?php
session_start();
if(isset($_SESSION['username'])){
}else{
	header('Location: index.php');
}
//connection
require 'connection.php';

if(!$connection)
{
	die("Connection failed: " . mysqli_connect_error());
}

//selecting all stories
$currentTitle = '';
$currentID = '';

$statement = $connection->query("SELECT * FROM stories");

//looping through each story, printing out an URL to editor
//story id is passed through URL
echo "<br><br><br><br><br><br><br><br><br><br>";
?>
 <button class="submit-button" onclick="window.location.href = 'settings.php';">Create new story</button><br>
<?php
while ($row = $statement->fetch())
{
	$currentTitle = $row['title']; 
	$currentID = $row['storyID'];
	
	echo "<div class='story-box'><p>";
	echo "<a href='editor.php?id=$currentID'>$currentTitle</a>";
	echo "</p></div>";
}


require 'feed.view.php';
?>
