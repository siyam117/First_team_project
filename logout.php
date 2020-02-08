<?php

  include_once("config.php");

  setcookie("username", "", time() - 3600);
  setcookie("user_id", "", time() - 3600);
  setcookie("token", "", time() - 3600);
  setcookie("serial", "", time() - 3600);

  header("location:login.php");

?>
