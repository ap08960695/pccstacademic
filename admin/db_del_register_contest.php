<?php
session_start();
include_once('../condb.php');
include_once('admin_check.php');

$sql = "DELETE FROM register WHERE running_year = '$running_year' AND id=" . $_GET['id'] . ";";
if (mysqli_query_log($conn, $sql)) {
  header("location:edit_score.php?act=success_delete&s=" . $_GET['register_contest']);
} else {
  header("location:edit_score.php?act=error_delete&s=" . $_GET['register_contest']);
}
mysqli_close($conn);
