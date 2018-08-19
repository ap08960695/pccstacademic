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
		mysql_close($conn);
		header("location:add_room.php?act=error_empty");
		exit();
	}
	
	$sql = "INSERT INTO room (room_name,amount_student) VALUES ('".$_POST['place_name']."',".$_POST['place_limit'].")";
	$result = mysql_query($sql ,$conn);
	if(!$result){
		mysql_close($conn);
		header("location:add_room.php?act=error_add");
		exit();
	}else{
		foreach($_POST as $key => $value){
			unset($_SESSION[$key]);
		}
		mysql_close($conn);
		header("location:add_room.php?act=success_add");
		exit();
	}
	mysql_close($conn);
?>
