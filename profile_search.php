<?php

  include_once("../connection.php");
  include_once("functions.php");

  if (func::checkLoginState($conn))
  {
    $search = $_GET['search'];
    echo "Searching for <i>$search</i>:<br><br>";
    $statement = $conn->prepare("SELECT * FROM users WHERE username LIKE '$search%';");
    $statement->execute();
    $result = $statement->fetchAll();
    if (empty($result)){
      echo "No results found.";
      echo "<br><br>";
    }
    else{
      foreach ($result as $row){
        $userID = $row['user_id'];
        $user = $row['username'];

        echo "<a href='profile.php?id=$userID'>$user</a>";
        echo "<br><br>";
      }
    }
    $id = $_COOKIE["user_id"];
    echo "<a href='profile.php?id=$id'>Return to profile</a>";
  }
  else
  {
    header("Location: index.php");
  }

?>



<!DOCTYPE html>
<html>
  <head>
  <script type="text/javascript" src="assets/js/lib/jquery-3.4.1.min.js"></script>
	<meta charset="UTF-8">
    <title>Search Profiles</title>
	</head>

  <body>
   
  </body>

</html>
