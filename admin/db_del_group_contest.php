<?php
session_start();
include_once('../condb.php');
include_once('admin_check.php');


$group_name = $_POST['group_name'];

$sql = "DELETE FROM contest_group WHERE running_year = '$running_year' AND group_name='$group_name';";
if (mysqli_query_log($conn, $sql)) {
  header("location:add_group_contest.php?act=success_delete");
} else {
  header("location:add_group_contest.php?act=error_delete");
}

mysqli_close($conn);
