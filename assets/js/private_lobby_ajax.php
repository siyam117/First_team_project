<?php

  include_once("../../../connection.php");
  include_once("../../functions.php");

  if (isset($_POST["id"]))
  {
    $lobby_id = $_POST["id"];

    if (!func::checkPrivateSession($conn, $lobby_id))
    {
      return;
    }

    $private_user_id = $_COOKIE["Puser_id"];
    $current_timestamp = time();
    $conn->exec("UPDATE private_users SET last_refreshed=$current_timestamp WHERE user_id='$private_user_id' AND lobby_id='$lobby_id';");

    $rows = func::sqlSELECT($conn, "SELECT * FROM private_users WHERE lobby_id='$lobby_id' ORDER BY created_timestamp DESC;", $fetch_all = true);
    foreach ($rows as $row)
    {
      if ($row["user_id"] != $_COOKIE["Puser_id"] && time() - $row["last_refreshed"] < 5)
      {
        echo "<div>" . $row["username"] . "</div>";
      }
    }
  }

?>
