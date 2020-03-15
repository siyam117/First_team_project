<?php

	include_once("../connection.php");
	include_once("functions.php");

	if(func::checkLoginState($conn))
	{
		$user_id = $_COOKIE["user_id"];

		if(isset($_POST["title"]) && isset($_POST["section_amount"]) && isset($_POST["section_length"]))
		{
			$title = $_POST["title"];
			$section_amount = $_POST["section_amount"];
			$section_length = $_POST["section_length"];

			$amount_acceptable = $section_amount <= 20;
			$length_acceptable = $section_length <= 1000;

			if ($amount_acceptable && $length_acceptable)
			{
				if (empty($title)) {echo "Please insert a title";}
				else if (empty($section_amount)) {echo "Please insert a section amount";}
				else if (empty($section_length)) {echo "Please insert a section length";}
				else
				{
					$title = func::cleanEditorInput($title);

					//INSERTING STORY
					$statement = $conn->prepare("INSERT INTO stories (creator_user_id, title, section_amount, section_length) VALUES ($user_id, '$title', $section_amount, $section_length);");
					$statement->execute();

					//RETRIEVING STORY ID
					$row = func::sqlSELECT($conn, "SELECT * FROM stories WHERE title='$title' ORDER BY story_id DESC;");

					$storyID = $row["story_id"];

					//CREATING A LIKES TABLE FOR EACH STORY
					$sql ="CREATE TABLE `".$storyID."` (like_id INT( 50 ) AUTO_INCREMENT PRIMARY KEY, user_id VARCHAR( 255 ))";
    				$conn->exec($sql);

					header("Location: editor.php?id=$storyID");
				}
			}
		}
  }
	else
	{
		header("Location: index.php");
	}

?>



<!DOCTYPE html>
<html>
    <head>
			<link rel="stylesheet" href="assets/css/master.css">
			<link id="animation-stylesheet" rel="stylesheet" href="assets/css/title_animation.css">
        <meta charset="UTF-8">
        <title></title>
			<script src="https://kit.fontawesome.com/e82695925e.js" crossorigin="anonymous"></script>
		  <script type="text/javascript" src="assets/js/lib/jquery-3.4.1.min.js"></script>
	</head>
    <body>

			
			<!-- HEADER START -->
      <div id="header">

        <!-- DROPDOWN START -->
        <div class="dropdown">

          <div class="hamburger-container">
            <div class="hamburger">
              <span class="bar"></span>
              <span class="bar"></span>
              <span class="bar"></span>
            </div>
          </div>

          <div class="body">
            <div class="inner-body">

              <div class="section">
                <?php
                $user_id = $_COOKIE["user_id"];
                echo "<a class='profile-button' href='profile.php?id=$user_id'>MY PROFILE <i class='fas fa-user'></i></a>";
                ?>
              </div>

              <!-- <div class="section">
                <input type="checkbox" id="title-toggle-button" />
              </div> -->

            </div>
          </div>

        </div>
        <!-- DROPDOWN END -->

        <!-- TITLE START -->
        <div id="header-title">
          <div class="glitch-container">
            <div class="glitch-text" id="glitch-main">INKKER.IO</div>
            <div class="glitch-text" id="glitch-shadow-one">INKKER.IO</div>
            <div class="glitch-text" id="glitch-shadow-two">INKKER.IO</div>
          </div>
        </div>
        <!-- TITLE END -->

      </div>
      <!-- HEADER END -->





        <!-- <form action="settings.php" id="homepage-loginbox" method="POST">
        <input class="input-field" id="username-field" type="text" autocomplete="off" placeholder="Title" name="title">

        <h>Create a new story</h><br> -->

				<form action="settings.php" method="POST" id="settingspage-box">
				<input class="input-field" id="username-field" type="text" autocomplete="off" placeholder="Title" name="title">
				<label class ="settings_text">Number Of Sections</label>
				<input class="slider" id="username-field" type="range" autocomplete="off" min="5" max = "20" value="10" placeholder="Number of Sections " name="section_amount">
				<label class = "settings_text">Section Length</label>
				<input class="slider" id="username-field" type="range" autocomplete="off" min="5" max = "20" value="10" placeholder="Section Length (1000 Max)" name="section_length">
				<button class="submit-button" id="login-button" type="submit" name="button">Create Story <i class="fas fa-sign-in-alt"></i></button>

				<br>
				<br>

        <a href="feed.php">Cancel</a><br>
        <a href="logout.php">Log out</a><br>
</form>
</body>
</html>
