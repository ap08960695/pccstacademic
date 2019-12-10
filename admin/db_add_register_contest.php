<?php
session_start();
include_once('../condb.php');
include_once('admin_check.php');
$check_empty = 0;
foreach ($_POST as $key => $value) {
	$_SESSION[$key] = $_POST[$key];
	if ($key != "register_score" && $_POST[$key] == "")
		$check_empty = 1;
}
if ($check_empty) {
	mysqli_close($conn);
	header("location:edit_score.php?act=error_empty&s=" . $_POST['register_contest']);
	exit();
}
if ($_POST['register_score'] == "")
	$_POST['register_score'] = -1;
else if ($_POST['register_score'] < 0)
	$_POST['register_score'] = 0;
$_POST['register_school'] = explode(",", $_POST['register_school'])[0];

$sql = "INSERT INTO register (school_id,subject_id,name,score,status,running_year) VALUES ('" . $_POST['register_school'] . "','" . $_POST['register_contest'] . "','" . $_POST['register_name'] . "'," . $_POST['register_score'] . ",1,'$running_year')";
$result = mysqli_query_log($conn, $sql);
if (!$result) {
	mysqli_close($conn);
	header("location:edit_score.php?act=error_add&s=" . $_POST['register_contest']);
	exit();
} else {
	foreach ($_POST as $key => $value) {
		unset($_SESSION[$key]);
	}
	mysqli_close($conn);
	header("location:edit_score.php?act=success_add&s=" . $_POST['register_contest']);
	exit();
}
mysqli_close($conn);
