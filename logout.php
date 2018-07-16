<?php
      session_start();
      include_once('condb.php');
      session_destroy();
      header("Location: login.php");
?>
