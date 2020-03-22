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

    if (isset($_POST["message"]))
    {
      $private_user_id = $_COOKIE["Puser_id"];
      $sent_message = $_POST["message"];
      $current_timestamp = time();

      $conn->exec("INSERT INTO private_livechats (sender_id, lobby_id, sent_time, message_content) VALUES ($private_user_id, '$lobby_id', $current_timestamp, '$sent_message');");
    }


    elseif ($_POST["reason"] == "players")
    {
      $private_user_id = $_COOKIE["Puser_id"];
      $current_timestamp = time();
      $conn->exec("UPDATE private_users SET last_refreshed=$current_timestamp WHERE user_id='$private_user_id' AND lobby_id='$lobby_id';");

      $rows = func::sqlSELECT($conn, "SELECT * FROM private_users WHERE lobby_id='$lobby_id' ORDER BY created_timestamp DESC;", $fetch_all = true);
      foreach ($rows as $row)
      {
        if (time() - $row["last_refreshed"] > 5)
        {
          $private_user_id = $row["user_id"];
          $conn->exec("DELETE FROM private_users WHERE lobby_id='$lobby_id' AND user_id=$private_user_id;");
          $conn->exec("DELETE FROM private_sessions WHERE session_user_id=$private_user_id;");
        }

        if ($row["user_id"] != $_COOKIE["Puser_id"])
        {
          echo "<div>" . $row["username"] . "</div>";
        }
      }
    }


    elseif ($_POST["reason"] == "messages")
    {
      $private_user_id = $_COOKIE["Puser_id"];

      $rows = func::sqlSELECT($conn, "SELECT * FROM private_livechats WHERE lobby_id='$lobby_id' ORDER BY sent_time ASC;", $fetch_all = true);
      foreach ($rows as $row)
      {
        $message_content = $row["message_content"];
        $sender_user_id = $row["sender_id"];

        $rows2 = func::sqlSELECT($conn, "SELECT * FROM private_users WHERE lobby_id='$lobby_id' AND user_id='$sender_user_id';");
        $sender_username = $rows2["username"];

        echo "<div><span>$sender_username: </span>$message_content</div>";
      }
    }


  }

?>
