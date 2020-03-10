<?php

  class func
  {
    public static function checkLoginState($conn)
    {
      if (!isset($_SESSION["user_id"]) || !isset($_COOKIE["PHPSESSID"]))
      {
        session_start();
      }
      if (isset($_COOKIE["user_id"]) && isset($_COOKIE["token"]) && isset($_COOKIE["serial"]))
      {
        $user_id = $_COOKIE["user_id"];
        $token = $_COOKIE["token"];
        $serial = $_COOKIE["serial"];

        $row = func::sqlSELECT($conn, "SELECT * FROM sessions WHERE session_user_id=$user_id AND session_token='$token' AND session_serial='$serial';");

        if (!empty($row))
        {
          if ($row["session_user_id"] == $_COOKIE["user_id"] && $row["session_token"] == $_COOKIE["token"] && $row["session_serial"] == $_COOKIE["serial"])
          {
            if ($row["session_user_id"] == $_SESSION["user_id"] && $row["session_token"] == $_SESSION["token"] && $row["session_serial"] == $_SESSION["serial"])
            {
              return true;
            }
          }
        }
      }
    }

    public static function checkPrivateSession($conn, $lobby_id)
    {
      if (isset($_COOKIE["Puser_id"]) && isset($_COOKIE["Ptoken"]))
      {
        $user_id = $_COOKIE["Puser_id"];
        $token = $_COOKIE["Ptoken"];

        $row = func::sqlSELECT($conn, "SELECT * FROM private_sessions WHERE session_user_id=$user_id AND session_token='$token';");

        if (empty($row))
        {
          return false;
        }
        if (!($row["session_user_id"] == $_COOKIE["Puser_id"] && $row["session_token"] == $_COOKIE["Ptoken"]))
        {
          return false;
        }

        $row = func::sqlSELECT($conn, "SELECT * FROM private_users WHERE user_id=$user_id AND lobby_id='$lobby_id';");

        if (empty($row))
        {
          return false;
        }

        return true;
      }
    }

    public static function startNewSession($conn, $user_id)
    {

      $conn->exec("DELETE FROM sessions WHERE session_user_id=$user_id;");

      $token = func::generateString32bit();
      $serial = func::generateString32bit();

      func::createCookie($user_id, $token, $serial);
      func::createSession($user_id, $token, $serial);

      $timestamp = time();
      $conn->exec("INSERT INTO sessions (session_token, session_serial, session_timestamp, session_user_id) VALUES ('$token', '$serial', $timestamp, $user_id);");
    }

    public static function startNewSessionPRIVATE($conn, $private_user_id)
    {
      $conn->exec("DELETE FROM private_sessions WHERE session_user_id=$private_user_id;");

      $token = func::generateString32bit();

      setCookie("Puser_id", $private_user_id, time() + (3600), "/");
      setCookie("Ptoken", $token, time() + (3600), "/");

      $timestamp = time();
      $conn->exec("INSERT INTO private_sessions (session_token, session_timestamp, session_user_id) VALUES ('$token', $timestamp, $private_user_id);");
    }

    public static function createCookie($user_id, $token, $serial)
    {
      setCookie("user_id", $user_id, time() + (3600), "/");
      setCookie("token", $token, time() + (3600), "/");
      setCookie("serial", $serial, time() + (3600), "/");
    }

    public static function createSession($user_id, $token, $serial)
    {
      if (!isset($_SESSION["user_id"]) || !isset($_COOKIE["PHPSESSID"]))
      {
        session_start();
      }
      $_SESSION["user_id"] = $user_id;
      $_SESSION["token"] = $token;
      $_SESSION["serial"] = $serial;
    }

    public static function addNewUser($conn, $username, $email, $password)
    {
      $salt = func::generateString32bit();
      $password = func::passwordHash($password, $salt);
      $created_timestamp = time();
      $pp = "assets/images/default.jpg";

      $conn->exec("INSERT INTO users (username, email, password, password_salt, created_timestamp, picture)
      VALUES ('$username', '$email', '$password', '$salt', '$created_timestamp', '$pp');");
    }

    public static function addNewUserPRIVATE($conn, $username, $lobby_id)
    {
      $private_user_id = func::generateUniquePrivateUserID($conn);
      $created_timestamp = time();

      if ($private_user_id == null)
      {
        return null;
      }
      else
      {
        $conn->exec("INSERT INTO private_users (user_id, username, lobby_id, created_timestamp) VALUES ($private_user_id, '$username', '$lobby_id', $created_timestamp);");
        return $private_user_id;
      }
    }

    public static function checkPassword($conn, $username, $password)
    {
      $stmt = $conn->prepare("SELECT * FROM users WHERE username='$username';");
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!empty($row))
      {
        $salt = $row["password_salt"];

        if (func::passwordHash($password, $salt) == $row["password"])
        {
          return true;
        }
      }
      return false;
    }

    public static function checkUniqueUsername($conn, $username)
    {
      $row = func::sqlSELECT($conn, "SELECT * FROM users WHERE username='$username';");

      if (empty($row))
      {
        return true;
      }
      else
      {
        return false;
      }
    }

    public static function checkUniqueEmail($conn, $email)
    {
      $row = func::sqlSELECT($conn, "SELECT * FROM users WHERE email='$email';");

      if (empty($row))
      {
        return true;
      }
      else
      {
        return false;
      }
    }

    public static function cleanEditorInput($text)
    {
      $text = trim($text);
      $text = strip_tags($text);

      if (!preg_match("/^([\x20-\x7E]|\n|\r)+$/", $text)) {
        return null;
      }

      $text = str_replace("'", "\'", $text);

      return $text;
    }

    public static function sqlSELECT($conn, $query, $fetch_all = false)
    {
      $stmt = $conn->prepare($query);
      $stmt->execute();

      if ($fetch_all)
      {
        return $stmt->fetchAll();
      }
      else
      {
        return $stmt->fetch(PDO::FETCH_ASSOC);
      }
    }

    public static function passwordHash($password, $salt)
    {
      $password .= $salt;
      $password .= "HCw9LnvxhMK0KvEWPmVNSmp1OV28CLof";
      for ($x=0; $x < 10000; $x++) {
        $password = hash("sha256", $password);
      }
      return $password;
    }

    public static function generateString32bit()
    {
      $characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789.";
      $string = "";
      for ($x = 1; $x <= 32; $x++) {
        $randomInt = rand(0, strlen($characters) - 1);
        $string .= $characters[$randomInt];
      }
      return $string;
    }

    public static function generateUniqueLobbyID($conn)
    {
      $unique = false;
      $fail_count = 0;

      while (!$unique) {
        $characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $lobby_id = "";
        for ($x = 1; $x <= 5; $x++) {
          $randomInt = rand(0, strlen($characters) - 1);
          $lobby_id .= $characters[$randomInt];
        }

        $row = func::sqlSELECT($conn, "SELECT * FROM private_stories WHERE lobby_id='$lobby_id';");
        if (empty($row))
        {
          $unique = true;
          $fail_count++;
        }

        if ($fail_count >= 10) {return null;}
      }

      return $lobby_id;
    }

    public static function generateUniquePrivateUserID($conn)
    {
      $unique = false;
      $fail_count = 0;

      while (!$unique) {
        $characters = "0123456789";
        $private_user_id = "";
        for ($x = 1; $x <= 10; $x++) {
          $randomInt = rand(0, strlen($characters) - 1);
          $private_user_id .= $characters[$randomInt];
        }

        $row = func::sqlSELECT($conn, "SELECT * FROM private_users WHERE user_id='$private_user_id';");
        if (empty($row))
        {
          $unique = true;
          $fail_count++;
        }

        if ($fail_count >= 20) {return null;}
      }

      return $private_user_id;
    }
  }

?>
