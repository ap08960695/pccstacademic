<?php
    session_start();
	include_once('../condb.php');
    include_once('admin_check.php');
	$check_empty = 0;
	foreach($_POST as $key => $value){
		$_SESSION[$key] = $_POST[$key];
		if($_POST[$key]=="")
			$check_empty = 1;
	}
	if($check_empty){
		mysqli_close($conn);
		header("location:add_room.php?act=error_empty");
		exit();
	}
	
	$sql = "INSERT INTO room (room_name,amount_student) VALUES ('".$_POST['place_name']."',".$_POST['place_limit'].")";
	$result = mysqli_query_log($conn,$sql);
	if(!$result){
		mysqli_close($conn);
		header("location:add_room.php?act=error_add");
		exit();
	}else{
		foreach($_POST as $key => $value){
			unset($_SESSION[$key]);
		}
		mysqli_close($conn);
		header("location:add_room.php?act=success_add");
		exit();
	}
	mysqli_close($conn);
