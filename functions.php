<?php

  class func
  {
    public static function checkLoginState($dbh)
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

        $query = "SELECT * FROM sessions WHERE session_user_id=$user_id AND session_token='$token' AND session_serial='$serial';";

        $stmt = $dbh->prepare($query);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

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

    public static function startNewSession($dbh, $username, $user_id)
    {

      $dbh->exec("DELETE FROM sessions WHERE session_user_id=$user_id;");

      $token = func::generateString32bit();
      $serial = func::generateString32bit();

      func::createCookie($username, $user_id, $token, $serial);
      func::createSession($username, $user_id, $token, $serial);

      $timestamp = time();
      $dbh->exec("INSERT INTO sessions (session_token, session_serial, session_timestamp, session_user_id) VALUES ('$token', '$serial', $timestamp, $user_id);");
    }

    public static function createCookie($username, $user_id, $token, $serial)
    {
      setCookie("username", $username, time() + (60), "/");
      setCookie("user_id", $user_id, time() + (60), "/");
      setCookie("token", $token, time() + (60), "/");
      setCookie("serial", $serial, time() + (60), "/");
    }

    public static function createSession($username, $user_id, $token, $serial)
    {
      if (!isset($_SESSION["user_id"]) || !isset($_COOKIE["PHPSESSID"]))
      {
        session_start();
      }
      $_SESSION["username"] = $username;
      $_SESSION["user_id"] = $user_id;
      $_SESSION["token"] = $token;
      $_SESSION["serial"] = $serial;
    }

    public static function addNewUser($dbh, $username, $email, $password)
    {
      $salt = func::generateString32bit();
      $password = func::passwordHash($password, $salt);
      $created_timestamp = time();

      echo $salt;
      echo $password;
      echo $created_timestamp;

      $dbh->exec("INSERT INTO users (username, email, password, password_salt, created_timestamp)
      VALUES ('$username', '$email', '$password', '$salt', $created_timestamp);");
    }

    public static function checkPassword($dbh, $username, $password)
    {
      $stmt = $dbh->prepare("SELECT * FROM users WHERE username='$username';");
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
      $characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!.";
      $string = "";
      for ($x = 1; $x <= 32; $x++) {
        $randomInt = rand(0, 63);
        $string .= $characters[$randomInt];
      }
      return $string;
    }
  }

?>
