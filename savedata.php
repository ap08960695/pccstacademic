<?php
session_start();
include_once('condb.php');
include_once('user_check.php');

$school_code = $school_info["code"];
$schoolname = $school_info["display"];

$arrstudent = $_POST['student'];
$arrteacher = $_POST['teacher'];


$sql = "UPDATE register SET status=0 WHERE running_year = '$running_year' AND school_id='$school_code'";
mysqli_query($conn, $sql);
$sql_string = "";
$len_name = 0;
foreach ($arrstudent as $key => $value) {
	foreach ($value as $sub_value) {
		if (preg_replace('/[ -]/', '', $sub_value) != "") {
			$sql_string .= "('$school_code', $key,'$sub_value',-1,'$running_year'),";
			$list_name[$sub_value] = 1;
			$len_name++;
		} else if ($_POST['role'] == "edit") {
			$sql_string .= "('$school_code', $key,'$sub_value','$running_year'),";
		}
	}
}
if ($len_name != count($list_name)) {
	$sql = "UPDATE register SET status=1 WHERE running_year = '$running_year' AND school_id='$school_code'";
	mysqli_query($conn, $sql);
	header("location:user_register.php?error=update_student_same");
	exit();
} else if ($sql_string != "") {
	$sql_string = substr($sql_string, 0, -1);
	$sql = "INSERT INTO `register` (`school_id`, `subject_id`, `name`, `score`,`running_year`) VALUES $sql_string;";
	$result = mysqli_query($conn, $sql);
	if (!$result) {
		$sql = "UPDATE register SET status=1 WHERE running_year = '$running_year' AND school_id='$school_code'";
		mysqli_query($conn, $sql);
		header("location:user_register.php?error=update_student");
		exit();
	} else {
		$sql = "DELETE FROM register WHERE running_year = '$running_year' AND school_id='$school_code' AND status=0";
		mysqli_query($conn, $sql);
	}
}

$sql = "UPDATE register_teacher SET status=0 WHERE running_year = '$running_year' AND school_id='$school_code'";
mysqli_query($conn, $sql);
$sql_string = "";
foreach ($arrteacher as $key => $value) {
	foreach ($value as $sub_value) {
		if ($sub_value != "") {
			$sql_string .= "('$school_code', $key,'$sub_value','$running_year'),";
		}
	}
}
if ($sql_string != "") {
	$sql_string = substr($sql_string, 0, -1);
	$sql = "INSERT INTO `register_teacher` (`school_id`, `subject_id`, `name`,`running_year`) VALUES $sql_string;";
	$result = mysqli_query($conn, $sql);
	if (!$result) {
		$sql = "UPDATE register_teacher SET status=1 WHERE running_year = '$running_year' AND school_id='$school_code'";
		mysqli_query($conn, $sql);
		header("location:user_register.php?error=update_teacher");
		exit();
	} else {
		$sql = "DELETE FROM register_teacher WHERE running_year = '$running_year' AND school_id='$school_code' AND status=0";
		mysqli_query($conn, $sql);
	}
}
mysqli_close($conn);
header("location:user_register.php?success=true");
