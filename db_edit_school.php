<?php
include_once('condb.php');

$code = $_POST["code"];
$usern = $_POST['usern'];
$passwd = $_POST['passwd'];
$cpasswd = $_POST['cpasswd'];

if ($passwd != $cpasswd) {
	header('Location: forgetpass.php?running_year=' . $running_year . '&act=error_pass');
} else if ($usern == "" || $passwd == "" || $cpasswd == "") {
	header('Location: forgetpass.php?running_year=' . $running_year . '&act=error_empty');
} else {
	$sql = "select * from school where user='" . $usern . "' AND code<>'$code' AND running_year = '$running_year'";
	$result = mysqli_query_log($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		header('Location: forgetpass.php?running_year=' . $running_year . '&act=error_same');
	} else {
		$sql = "select * from school where code='$code' and code is not null AND running_year = '$running_year'";
		$result = mysqli_query_log($conn, $sql);
		if (mysqli_num_rows($result) == 1) {
			$sql = "UPDATE `school` SET user='" . $usern . "',pass='" . $passwd . "' WHERE code='$code' AND running_year = '$running_year'";
			if ($result = mysqli_query_log($conn, $sql)) {
				mysqli_close($conn);
				header("location:login.php?running_year=" . $running_year . "&act=success_reset");
			} else header("location:forgetpass.php?running_year=" . $running_year . "&act=error_query");
		} else header('Location: forgetpass.php?running_year='  . $running_year . '&act=error_code');
	}
}
