<?php
session_start();
include_once('../condb.php');
include_once('admin_check.php');
if ($_POST['act'] == "update_profile") {
	$sql = "UPDATE school SET display='" . $_POST['school_display'] . "',email='" . $_POST['school_email'] . "',amper='" . $_POST['school_amper'] . "',changwat='" . $_POST['school_changwat'] . "',addrcode='" . $_POST['school_zip'] . "',phone='" . $_POST['school_phone'] . "' WHERE running_year = '$running_year' AND code='" . $_POST['school_code'] . "'";
	$result = mysqli_query($conn, $sql);
	if (!$result) {
		mysqli_close($conn);
		header("location:edit_school.php?act=error_edit");
		exit();
	} else {
		mysqli_close($conn);
		header("location:index.php?act=success_edit_school");
		exit();
	}
} else if ($_POST['act'] == "update_password") {
	if ($_POST['school_pass'] == $_POST['school_pass_confirm']) {
		$sql = "UPDATE school SET pass='" . $_POST['school_pass'] . "' WHERE running_year = '$running_year' AND code='" . $_POST['school_code'] . "'";
		$result = mysqli_query($conn, $sql);
		if (!$result) {
			mysqli_close($conn);
			header("location:edit_school.php?act=error_edit_pass");
			exit();
		} else {
			mysqli_close($conn);
			header("location:index.php?act=success_edit_school");
			exit();
		}
	} else {
		mysqli_close($conn);
		header("location:edit_school.php?act=error_edit_pass");
		exit();
	}
}
