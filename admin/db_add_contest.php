<?php
session_start();
include_once('../condb.php');
include_once('admin_check.php');
$check_empty = 0;
foreach ($_POST as $key => $value) {
	$_SESSION[$key] = $_POST[$key];
	if ($key != "room" && $key != "date_start" && $key != "date_end" && $_POST[$key] == "")
		$check_empty = 1;
}
if ($check_empty) {
	mysqli_close($conn);
	header("location:add_contest.php?act=error_empty");
	exit();
}

$sql = "SELECT * FROM contest WHERE running_year='$running_year' AND code='" . $_POST['contest_code'] . "'";
$result = mysqli_query_log($conn, $sql);
if (mysqli_num_rows($result) > 0) {
	header("location:add_contest.php?act=error_add_same");
	mysqli_close($conn);
	exit();
}
if ($_POST['date_start'] == "") {
	$start_date = "00-00-00 00:00";
} else {
	$start_date = date_format(date_create_from_format("d/m/Y H:i", $_POST['date_start']), 'Y-m-d H:i:s');
}
if ($_POST['date_end'] == "") {
	$end_date = "00-00-00 00:00";
} else {
	$end_date = date_format(date_create_from_format("d/m/Y H:i", $_POST['date_end']), 'Y-m-d H:i:s');
}
$sql = "INSERT INTO contest (code,contest_name,education,type,person,person_inter,person_host,teacher_person,platform,date_start,date_end,running_year) VALUES ('" . $_POST['contest_code'] . "','" . $_POST['contest_name'] . "','" . $_POST['contest_education'] . "','" . $_POST['contest_type'] . "'," . $_POST['contest_person'] . "," . $_POST['contest_person_inter'] . "," . $_POST['contest_person_host'] . "," . $_POST['contest_person_teacher'] . ",'" . $_POST['contest_platform'] . "','" . $start_date . "','" . $end_date . "','" . $running_year . "')";
$result = mysqli_query_log($conn, $sql);
if (!$result) {
	mysqli_close($conn);
	header("location:add_contest.php?act=error_add");
	exit();
} else {
	if ($_POST['room'] != "") {
		$room = split(",", $_POST['room']);
		$string_room = "";
		for ($i = 0; $i < count($room); $i++) {
			$sql = "SELECT * FROM room WHERE id=" . $room[$i];
			$result = mysqli_query_log($conn, $sql);
			$row = mysqli_fetch_array($result);

			$string_room .= "(";
			$string_room .= $_POST['contest_code'] . ",";
			$string_room .= "'" . $row['room_name'] . "',";
			$string_room .= $row['amount_student'] . ",";
			$string_room .= "'" . $running_year . "'";
			$string_room .= "),";
		}
		$string_room = substr($string_room, 0, -1);
		$sql = "INSERT INTO room_contest (contest_code,room_name,amount_student,running_year) VALUES $string_room";
		$result = mysqli_query_log($conn, $sql);
		if (!$result) {
			$sql = "DELETE FROM contest WHERE running_year='$running_year' AND code='" . $_POST['contest_code'] . "'";
			$result = mysqli_query_log($conn, $sql);
			mysqli_close($conn);
			header("location:add_contest.php?act=error_add");
			exit();
		} else {
			foreach ($_POST as $key => $value) {
				unset($_SESSION[$key]);
			}
			mysqli_close($conn);
			header("location:add_contest.php?act=success_add");
			exit();
		}
	} else {
		foreach ($_POST as $key => $value) {
			unset($_SESSION[$key]);
		}
		mysqli_close($conn);
		header("location:add_contest.php?act=success_add");
		exit();
	}
}
mysqli_close($conn);
