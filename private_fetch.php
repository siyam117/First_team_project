<?php

  include_once("../connection.php");
  include_once("functions.php");

  if (func::checkLoginState($conn))
  {
    if (isset($_GET["id"]))
    {
      sleep(0.1);
      $lobby_id = $_GET["id"];
      $rows = func::sqlSELECT($conn, "SELECT * FROM private_sections WHERE lobby_id='$lobby_id';", $fetch_all = true);
      foreach ($rows as $row)
      {
        echo "<div>" . $row["section_text"] . "</div>";
      }
    }
  }
  else
  {
    header("Location: index.php");
  }

?>
