<?php
  session_start();
  if(!isset($_SESSION['id']))
    header("Location: forum.php");
  else
      header("Location: index.php");

  $_SESSION = [];
  session_destroy();
  header("Location: index.php")

?>
