<?php

  include_once("../../../connection.php");
  include_once("../../functions.php");

  if (isset($_POST["id"]))
  {
    $lobby_id = $_POST["id"];
    $rows = func::sqlSELECT($conn, "SELECT * FROM private_users WHERE lobby_id='$lobby_id' ORDER BY created_timestamp DESC;", $fetch_all = true);
    foreach ($rows as $row)
    {
      if ($row["user_id"] != $_COOKIE["Puser_id"])
      {
        echo "<div>" . $row["username"] . "</div>";
      }
    }
  }

?>
