<?php
session_start();
include_once('../condb.php');
include_once('admin_check.php');

$value = $_POST['running_option'];
$sql = "UPDATE config SET value='" . $value . "' WHERE meta='runningYear'";
if (mysqli_query_log($conn, $sql)) {
	header("location:config.php?act=success_update_year");
} else {
	header("location:config.php?act=error_update_year");
}
mysqli_close($conn);
