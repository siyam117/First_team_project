<?php

	include_once("../connection.php");
	include_once("functions.php");

	if(func::checkLoginState($conn))
	{
		$user_id = $_COOKIE["user_id"];
		if(!empty($_POST["storypic"])){
			$thumbnail = $_POST["storypic"];
		}else{
			$thumbnail = "default";
		}
		
		if(isset($_POST["title"]) && isset($_POST["section_amount"]) && isset($_POST["section_length"]))
		{
			$title = $_POST["title"];
			$section_amount = $_POST["section_amount"];
			$section_length = $_POST["section_length"];
			$thumbnailfinal = $_POST["thumbnail"];

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
					$statement = $conn->prepare("INSERT INTO stories (creator_user_id, title, section_amount, section_length, story_image, views) VALUES ($user_id, '$title', $section_amount, $section_length, '$thumbnailfinal', 0);");
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
                echo "<a class='dropdown-button' href='profile.php?id=$user_id'>MY PROFILE <i class='fas fa-user'></i></a>";
                ?>
              </div>

              <div class="section">
                <a class="dropdown-button" href="logout.php">LOG OUT</a>
              </div>

            </div>
          </div>

        </div>
        <!-- DROPDOWN END -->

        <!-- TITLE START -->
        <a id="header-title" href="index.php">
          <div class="glitch-container">
            <div class="glitch-text" id="glitch-main">INKKER.IO</div>
            <div class="glitch-text" id="glitch-shadow-one">INKKER.IO</div>
            <div class="glitch-text" id="glitch-shadow-two">INKKER.IO</div>
          </div>
        </a>
        <!-- TITLE END -->

      </div>
      <!-- HEADER END -->





        <!-- <form action="settings.php" id="homepage-loginbox" method="POST">
        <input class="input-field" id="username-field" type="text" autocomplete="off" placeholder="Title" name="title">

        <h>Create a new story</h><br> -->
			<div id="settings-box">
        	<?php
					echo "<form action=\"thumbnail.php\" method=\"POST\">
							<button class=\"btn-standard btn-login\" id=\"create-button\"  type=\"submit\" name=\"thumb\">Choose Thumbnail</button></form>";

					$image = "<img src='assets/images/story".$thumbnail.".jpg' alt='thumbnail' width = 300 height = 250>";
					echo $image;

			?>
			<form action="settings.php" method="POST">
				<?php
				echo "<input type=\"hidden\" name=\"thumbnail\" value='$thumbnail'>"
				?>
				
				<br><label class ="settings_text">Title</label><br><br>
			<div class="slider-hold">
				
				<input class="input-field-settings" id="username-field" type="text" autocomplete="off" placeholder="Title" name="title"><br>
				<br><br><br>
				<label class ="settings_text">Number Of Sections</label><br>
				
				<span id="rangeValue">0</span>
				<script type="text/javascript" src="assets/js/slider.js"></script>
				<input class="range" id="username-field" onmousemove="rangeSlider(this.value)" onchange="rangeSlider(this.value)" type="range" min="5" max = "20" value="5" name="section_amount">
				
			</div>
				<br>
			<div class="slider-hold">
				<label class = "settings_text">Section Length</label> <br>
				<span id="rangeValues">0</span>
				<script type="text/javascript" src="assets/js/rangeSlider2.js"></script>
				<input class="range" id="username-field" onchange="rangeSlider2(this.value)" onmousemove="rangeSlider2(this.value)" type="range" autocomplete="off" min="10" step="5" max = "300" value="10" placeholder="Section Length (1000 Max)" name="section_length">
				<br>

				<br><br>
				<button class="btn-standard btn-login" id="create-button"  type="submit" name="button">Create Story &#10003;</button>

				<br>
				
			</div>
	
       
			</form>
		</div>
			<button class="btn-standard btn-login"  onclick="window.location.href = 'feed.php';" type="button" name="button" >Cancel </button>
			<button class="btn-standard btn-login"  onclick="window.location.href = 'logout.php';" type="button" name="button" >Log Out <i class="fas fa-sign-in-alt"></i></button>

			<script type="text/javascript" src="assets/js/main.js"></script>
</body>
</html>
