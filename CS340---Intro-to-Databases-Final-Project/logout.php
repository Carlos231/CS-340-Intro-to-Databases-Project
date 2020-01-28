<?php
  session_start();
  session_destroy();
  header("location: account.php");
  exit("Logging you out");
?>
