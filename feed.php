<?php

  include_once("../connection.php");
  include_once("functions.php");

  if (func::checkLoginState($conn))
  {
    $query = "SELECT * FROM stories;";
    $row = func::sqlSELECT($conn, $query, $fetch_all = true);
  }
  else
  {
    header("Location: index.php");
  }

if (isset($_POST["Go!"])){
    $query = $_POST["search"];
    $sth = $conn->prepare("SELECT title FROM stories WHERE title = '$query'");

    $sth->setFetchMode(PDO:: FETCH_OBJ);
    $sth->execute();

    if($row = $sth->fetch())
    {
        ?>
        <br><br><br>
        <table>
            <tr>
                <th>title found!</th>
            </tr>
            <tr>
                <td><?php echo $row->title; ?></td>
            </tr>

        </table>
<?php

    }
        else{
            echo "Name does not exist";

        }

}


?>



<!DOCTYPE html>
<html>
  <head>
  <link rel="stylesheet" href="assets/css/master.css">
  <link id="animation-stylesheet" rel="stylesheet" href="assets/css/title_animation.css">
  <script type="text/javascript" src="assets/js/lib/jquery-3.4.1.min.js"></script>
	<meta charset="UTF-8">

        <script type = "text/javascript">
            function active(){
                var SearchBar = document.getElementById('SearchBar');

                if(SearchBar.value == 'Search...'){
                    SearchBar.value = ''
                    SearchBar.placeholder = 'Search...'
                }
            }
            function inactive(){
                var SearchBar = document.getElementById('SearchBar');

                if(SearchBar.value == ''){
                    SearchBar.value = 'Search...'
                    SearchBar.placeholder = ''
                }
            }

        </script>

    <!-- <form method="post">
    <input type ="text" name="search" id="SearchBar" placeholder="Search" value="Search..." maxlength="35" autocomplete="off" onmousedown="active();" onblur="inactive();" /><input type="submit" id="SearchBtn" name="Go!"/>
    </form> -->

    <title>Feed</title>
	</head>
    <body>
      <!-- HEADER START -->
      <div id="header">

        <!-- DROPDOWN START -->
        <div class="dropdown">

          <div class="hamburger">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
          </div>

          <div class="body">
            <?php
            $user_id = $_COOKIE["user_id"];
            echo "<a href='profile.php?id=$user_id'>My profile</a><br>";
            ?>

            <input type="checkbox" id="title-toggle-button" />
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

      <div id="feed-box">
        <a class="feed-button" id="feed-button-addstory" href="private_options.php"><div class="feed-button-text">Create private game</div></a>
        <a class="feed-button" id="feed-button-addstory" href="settings.php"><div class="feed-button-text">Create new story</div></a>
        <?php
          foreach ($row as $storydata)
          {
            $currentTitle = $storydata["title"];
          	$currentID = $storydata["story_id"];

          	echo "<a class='feed-button' href='editor.php?id=$currentID'><div class='feed-button-text'>$currentTitle</div></a>";
          }
        ?>
      </div>
      <script type="text/javascript" src="assets/js/theme_change.js"></script>
      <script type="text/javascript" src="assets/js/main.js"></script>
  </body>
</html>
