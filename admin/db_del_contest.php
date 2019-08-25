<?php
    session_start();
    include_once('../condb.php');
	include_once('admin_check.php');
    $code = $_POST['code'];
    
    $sql = "DELETE FROM contest WHERE code='$code';";
    if(mysqli_query($conn,$sql)){
		$sql = "DELETE FROM room_contest WHERE contest_code='$code';";
		if(mysqli_query($conn,$sql)){
			$sql = "DELETE FROM contest_group WHERE contest_code='$code';";
			if(mysqli_query($conn,$sql)){
				header("location:add_contest.php?act=success_delete");
			}else header("location:add_contest.php?act=error_delete");
		}else {
			header("location:add_contest.php?act=error_delete");
		}
	}else{
		header("location:add_contest.php?act=error_delete");
	}
	
    mysqli_close($conn);
