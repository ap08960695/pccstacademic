<?php
session_start();
include_once('../condb.php');
include_once('admin_check.php');

$user = $_POST['username'];
$pass = $_POST['password'];
$pass_con = $_POST['password_confire'];
$check_empty = 0;
foreach ($_POST as $key => $value) {
	if ($_POST[$key] == "") {
		$check_empty = 1;
	}
}
if ($check_empty == 1) {
	mysqli_close($conn);
	header("location:config.php?act=error_empty");
	exit();
}
if ($pass_con != $pass) {
	mysqli_close($conn);
	header("location:config.php?act=error_pass_same");
	exit();
}
$sql = "UPDATE config SET value='" . md5($user) . "' WHERE meta='userAdmin'";
if (mysqli_query_log($conn, $sql)) {
	$sql = "UPDATE config SET value='" . md5($pass) . "' WHERE meta='passAdmin'";
	if (mysqli_query_log($conn, $sql)) {
		foreach ($_POST as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:index.php?act=success_update");
	} else {
		header("location:index.php?act=error_update_pass");
	}
} else {
	header("location:index.php?act=error_update_user");
}
mysqli_close($conn);
