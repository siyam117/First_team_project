<?php

	include_once("../connection.php");
	include_once("functions.php");

	if(func::checkLoginState($conn))
	{
		//likes
		$userID = $_COOKIE["user_id"];
		$story_id = $_GET['id'];

		$query = "SELECT * FROM `$story_id` WHERE user_id = '$userID'";

   		$row = func::sqlSELECT($conn, $query, $fetch_all = true);

		if (!empty($row)){
			$like = "Unlike";
		}
		else{
			$like = "Like";
		}

		$stories = func::sqlSELECT($conn, "SELECT * FROM stories WHERE story_id='$story_id';");

		$creator_user_id = $stories["creator_user_id"];
		$story_title = $stories["title"];
		$section_amount = $stories["section_amount"];
		$section_length = $stories["section_length"];
		$views = $stories["views"];

		$NewViews = $views + 1;
		$statement = $conn->prepare("UPDATE stories SET views = $NewViews WHERE story_id = '$story_id'");
        $statement->execute();


		$users = func::sqlSELECT($conn, "SELECT * FROM users WHERE user_id='$creator_user_id';");

		$creator_username = $users["user_id"];

		//INSERTS NEW SECTION IF ONE WAS SUBMITTED
		if (isset($_POST["sectionOrder"]) && isset($_POST["sectionText"]))
		{
			$writer_user_id = $_COOKIE["user_id"];
			$section_order = $_POST["sectionOrder"];
			$section_text = $_POST["sectionText"];

			$section_text = func::cleanEditorInput($section_text);

			if ($section_text != null)
			{

				$word_count = count(explode(" ", $section_text));

				if ($word_count > 0 && $word_count <= $section_length)
				{
					$stmt = $conn->prepare("INSERT INTO sections (story_id, writer_user_id, section_order, section_text) VALUES ($story_id, $writer_user_id, $section_order, '$section_text');");
					$stmt->execute();
				}

			}
		}

		$sections = func::sqlSELECT($conn, "SELECT * FROM sections WHERE story_id='$story_id' ORDER BY section_order ASC;", $fetch_all = true);

		$empty_sections = $section_amount - count($sections);

		if (isset($_POST["likeButton"])){
			if ($like === "Like"){
				$sql = "INSERT INTO `$story_id` (`like_id`, `user_id`) VALUES (NULL, '$userID');";
				$like = "Unlike";
				$conn->exec($sql);
			}else{
				$sql = "DELETE FROM `$story_id` WHERE `user_id` = '$userID'";
				$like = "Like";
				$conn->exec($sql);
			}
		}
		if (isset($_POST["deleteButton"])){
			$sql = "DELETE FROM stories WHERE `story_id` = '$story_id'";
			$conn->exec($sql);
			$sql = "DROP TABLE `$story_id`";
			$conn->exec($sql);
			header("Location: feed.php");
		}
		if (isset($_POST["reportButton"])){
			$url = "Location: report.php?id=$story_id";
			header($url);
		}
	}
	else
	{
		header('Location: index.php');
	}

?>



<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="assets/css/master.css">
		<script type="text/javascript" src="assets/js/lib/jquery-3.4.1.min.js">
		</script>
		<title>Editor</title>
	</head>
		<body oncopy="return false" oncut="return false" onpaste="return false">



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





			<div id="story-display-box">
				<div id="story-display-box-header">
					<a href="feed.php">Go Back</a><br>

					<?php
					//LIKE BUTTON
					if ($like === "Like"){
						$img = "<img src='assets/images/like.png' width=35 height=35>";
					}
					else{
						$img = "<img src='assets/images/unlike.png' width=35 height=35>";
					}
					echo "<form action='editor.php?id=$story_id' method='post'>";
					echo "<button name='likeButton' type='submit' style='background-color: Transparent;
						    background-repeat:no-repeat;
						    border: none;
						    cursor:pointer;
						    overflow: hidden;
						    outline:none;'>$img</button>";
					$sql = "SELECT COUNT(*) FROM `$story_id`";
					$result = $conn->prepare($sql);
					$result->execute();
					//getting total number of likes
					$number_of_likes = $result->fetchColumn();
					$number_of_likes += 0;
					if ($number_of_likes>999999){
						$number_of_likes = substr($number_of_likes, 0, -6);
						$number_of_likes = $number_of_likes.'M';
					}
					else if ($number_of_likes>999){
						$number_of_likes = substr($number_of_likes, 0, -3);
						$number_of_likes = $number_of_likes.'K';
					}
					if ($NewViews>999999){
						$NewViews = substr($NewViews, 0, -6);
						$NewViews = $NewViews.'M';
					}
					else if ($NewViews>999){
						$NewViews = substr($NewViews, 0, -3);
						$NewViews = $NewViews.'K';
					}

					echo "<font color='white'>".$number_of_likes." LIKES || ".$NewViews." VIEWS</font>";
					echo "</form>";

					?>

					<div id="story-title"><?php echo $story_title; ?></div>
					<?php
					//REPORT/DELETE
					$admin = false;

					if ($userID == 1){
						$admin = true;
					}
					if($admin){
						$report = "<img src = 'assets/images/delete.png' width=35 height=35>";
						echo "<form action='editor.php?id=$story_id' method='post'>";
						echo "<button name='deleteButton' type='submit' style='background-color: Transparent;
						    background-repeat:no-repeat;
						    border: none;
						    cursor:pointer;
						    overflow: hidden;
						    outline:none;'>$report</button>";
						echo "</form>";
					}
					else{
						$report = "<img src = 'assets/images/report.png' width=35 height=35>";
						echo "<form action='editor.php?id=$story_id' method='post'>";
						echo "<button name='reportButton' type='submit' style='background-color: Transparent;
						    background-repeat:no-repeat;
						    border: none;
						    cursor:pointer;
						    overflow: hidden;
						    outline:none;'>$report</button>";
						echo "</form>";
					}
					?>
				</div>
				<br>
				<hr id="title-body-line">
				<div id="story-display-box-body">
					<?php
						foreach ($sections as $sectiondata)
						{
							$section_text = $sectiondata["section_text"];
							echo "<div class='story-section'><div class='story-section-text'>$section_text</div></div><hr class='section-line'>";
						}
						if ($empty_sections > 0)
						{
							$section_order = count($sections) + 1;
							echo "<div class='story-section story-section-input-button'><div class='story-section-input-clickhere'>Click Here To Add</div></div>";
							echo "<textarea class='story-section-input-field' name='sectionText' form='story-section-input-form'></textarea>";
							echo "<form class='story-section-input-form' id='story-section-input-form' action='editor.php?id=$story_id' method='post'><input type='hidden' name='sectionOrder' value='$section_order'><button class='btn-standard' type='submit'>Submit</button><div class='story-section-input-form-wordcount'>0/$section_length Words</div></form>";
							echo "<hr class='section-line'>";
						}
						for ($i=0; $i < $empty_sections - 1; $i++)
						{
							echo "<div class='story-section story-section-empty'></div><hr class='section-line'>";
						}
					?>
				</div>
			</div>

		<script type="text/javascript" src="assets/js/editor.js"></script>
		<script type="text/javascript" src="assets/js/main.js"></script>
	</body>
</html>
