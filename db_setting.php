<?php
session_start();
include_once('condb.php');
include_once('user_check.php');

if ($_POST['password'] != $_POST['repassword']) {
	mysqli_close($conn);
	header("location:setting.php?act=error_password");
	exit();
}
$sql = "UPDATE school SET ";
if ($_POST['username'] != "") {
	$sql_ch = "select * from school where (user='" . $_POST['username'] . "') AND running_year = '$running_year' AND code<>'" . $_POST['code'] . "'";
	$result = mysqli_query($conn, $sql_ch);
	if ($result) {
		if (mysqli_num_rows($result) > 0) {
			mysqli_close($conn);
			header('Location: setting.php?act=error_same');
			exit();
		} else $sql .= "user='" . $_POST['username'] . "',";
	} else {
		mysqli_close($conn);
		header('Location: setting.php?act=update_error');
		exit();
	}
}
if ($_POST['password'] != "") {
	$sql .= "pass='" . $_POST['password'] . "',";
}
$sql_ch = "select * from school where (display='" . $_POST['display'] . "') AND code<>'" . $_POST['code'] . "' AND running_year = '$running_year'";
$result = mysqli_query($conn, $sql_ch);
if ($result) {
	if (mysqli_num_rows($result) > 0) {
		mysqli_close($conn);
		header('Location: setting.php?act=error_same');
		exit();
	}
} else {
	mysqli_close($conn);
	header('Location: setting.php?act=update_error');
	exit();
}
$sql .= "display='" . $_POST['display'] . "',email='" . $_POST['email'] . "',amper='" . $_POST['district'] . "',changwat='" . $_POST['province'] . "',addrcode='" . $_POST['zip'] . "',phone='" . $_POST['phone'] . "'";
$sql .= " WHERE code='" . $_POST['code'] . "' AND running_year = '$running_year'";
if (mysqli_query($conn, $sql)) {
	if ($_POST['username'] != "")
		$_SESSION['user'] = $_POST['username'];
	$_SESSION['display'] = $_POST['display'];
	header('Location: setting.php?act=update_success');
} else {
	mysqli_close($conn);
	header("location:setting.php?act=update_error");
	exit();
}
mysqli_close($conn);
