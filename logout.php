<?php

  setcookie("user_id", "", time() - 3600, "/");
  setcookie("token", "", time() - 3600, "/");
  setcookie("serial", "", time() - 3600, "/");

  header("location:login.php");

?>
