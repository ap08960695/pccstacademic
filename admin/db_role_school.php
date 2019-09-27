<?php
    session_start();
    include_once('../condb.php');
    include_once('admin_check.php');
    
    $check_empty =0;
	foreach($_POST as $key => $value){
		$_SESSION[$key] = $_POST[$key];
		if($_POST[$key]==""){
			$check_empty = 1;
		}
	}
	if($check_empty==1){
		mysqli_close($conn);
		header("location:config.php?act=error_empty_role");
		exit();
	}
	$value = "";
	if($_POST['school_option']=="1"){
		$value = "all";
	}else if($_POST['school_option']=="2"){
		$value = "edit";
	}else if($_POST['school_option']=="3"){
		$value = "view";
	} 
    $sql = "UPDATE config SET value='".$value."' WHERE meta='schoolRole'";
    if(mysqli_query_log($conn,$sql)){
		header("location:config.php?act=success_update_role");
	}else{
		header("location:config.php?act=error_update_role");
	}
    mysqli_close($conn);
