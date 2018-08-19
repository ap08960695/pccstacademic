<?php
    session_start();
    include_once('../condb.php');
    include_once('admin_check.php');
    
    $user = $_POST['username'];
	$pass = $_POST['password'];
	$pass_con = $_POST['password_confire'];
	$check_empty =0;
	foreach($_POST as $key => $value){
		$_SESSION[$key] = $_POST[$key];
		if($_POST[$key]==""){
			$check_empty = 1;
		}
	}
	if($check_empty==1){
		mysql_close($conn);
		header("location:config.php?act=error_empty");
		exit();
	}
    if($pass_con != $pass){
		mysql_close($conn);
		header("location:config.php?act=error_pass_same");
		exit();
	}
    $sql = "UPDATE config SET value='".md5($user)."' WHERE meta='userAdmin'";
    if(mysql_query($sql ,$conn)){
		$sql = "UPDATE config SET value='".md5($pass)."' WHERE meta='passAdmin'";
		if(mysql_query($sql ,$conn)){
			foreach($_POST as $key => $value){
				unset($_SESSION[$key]);
			}
			header("location:school.php?act=success_update");
		}else{
			header("location:school.php?act=error_update_pass");
		}
	}else{
		header("location:school.php?act=error_update_user");
	}
    mysql_close($conn);
?>
