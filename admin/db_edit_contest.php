<?php
    session_start();
	date_default_timezone_set('Asia/Bangkok');
    include_once('../condb.php');
    $sql = "SELECT meta FROM config WHERE meta='userAdmin' AND value='".md5($_SESSION['user'])."'";
    $result = mysql_query($sql);
	if(mysql_num_rows($result)!=1){
		mysql_close($conn);
		header("Location: ../login.php");
		exit();
	}
	$check_empty = 0;
	foreach($_POST as $key => $value){
		$_SESSION[$key] = $_POST[$key];
		if($key!="room" && $key!="date_start" && $key!="date_end" && $_POST[$key]==""){
			$check_empty = 1;
			echo $key." ".$_POST[$key];
		}
	}
	if($check_empty){
		mysql_close($conn);
		header("location:edit_contest.php?act=error_empty");
		exit();
	}
	
	if($_POST['date_start']==""){
		$start_date = "00-00-00 00:00";
	}else{
		$start_date = date_format(date_create_from_format("d/m/Y H:i",$_POST['date_start']), 'Y-m-d H:i:s');
	}
	if($_POST['date_end']==""){
		$end_date = "00-00-00 00:00";
	}else{
		$end_date = date_format(date_create_from_format("d/m/Y H:i",$_POST['date_end']), 'Y-m-d H:i:s');
	}
	
	$sql = "UPDATE contest SET contest_name='".$_POST['contest_name']."',education='".$_POST['contest_education']."',type='".$_POST['contest_type']."',person=".$_POST['contest_person'].",teacher_person=".$_POST['contest_person_teacher'].",platform='".$_POST['contest_platform']."',date_start='".$start_date."',date_end='".$end_date."' WHERE code='".$_POST['contest_code']."'";
	$result = mysql_query($sql ,$conn);
	if(!$result){
		mysql_close($conn);
		header("location:edit_contest.php?act=error_edit");
		exit();
	}else{
		if($_POST['room']!=""){
			$sql = "DELETE FROM room_contest WHERE contest_code=".$_POST['contest_code'];
			$result = mysql_query($sql ,$conn);
			if(!$result){
				header("location:edit_contest.php?act=error_edit_room");
				exit();
			}
				
			$room = split(",",$_POST['room']);
			$string_room = "";
			for($i = 0;$i < count($room);$i++){
				$string_room .= "(";
				$string_room .= $_POST['contest_code'].",";
				$string_room .= $room[$i];
				$string_room .= "),";
			}
			$string_room = substr($string_room,0,-1);
			$sql = "INSERT INTO room_contest (contest_code,room_id) VALUES $string_room";
			$result = mysql_query($sql ,$conn);
			if(!$result){
				$sql = "DELETE FROM contest WHERE code='".$_POST['contest_code']."'";
				$result = mysql_query($sql ,$conn);
				mysql_close($conn);
				header("location:edit_contest.php?act=error_edit");
				exit();
			}else{
				foreach($_POST as $key => $value){
					unset($_SESSION[$key]);
				}
				mysql_close($conn);
				header("location:add_contest.php?act=success_edit");
				exit();
			}
		}else{
			foreach($_POST as $key => $value){
				unset($_SESSION[$key]);
			}
			mysql_close($conn);
			header("location:add_contest.php?act=success_edit");
			exit();
		}
	}
	mysql_close($conn);
?>