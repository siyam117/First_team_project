<?php

  include_once("connection.php");
  include_once("functions.php");

  if (func::checkLoginState($conn))
  {
    header("location:feed.php");
  }
  else
  {
    header("location:login.php");
  }

?>
