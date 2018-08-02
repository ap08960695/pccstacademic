<?php
    session_start();
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
		echo $key." ".$_POST[$key]."<br>";
		$_SESSION[$key] = $_POST[$key];
		if($_POST[$key]=="")
			$check_empty = 1;
	}
	if($check_empty){
		mysql_close($conn);
		header("location:add_group_contest.php?act=error_empty");
		exit();
	}
	
	$sql = "SELECT COUNT(*) FROM contest_group WHERE group_name='".$_POST['place_name']."'";
	$result = mysql_query($sql ,$conn);
	if(mysql_num_rows($result)>0){
		header("location:add_group_contest.php?act=error_add_same");
		mysql_close($conn);
		exit();
	}
	
	$list = split(",",$_POST['contest_list']);
	$list_string = "";
	for($i=0;$i<count($list);$i++){
		$list_string .= "(";
		$list_string .= "'".$_POST['place_name']."',";
		$list_string .= "'".$list[$i]."'";
		$list_string .= "),";
	}
	$list_string = substr($list_string,0,-1);
	
	$sql = "INSERT INTO contest_group (group_name,contest_code) VALUES ".$list_string;
	$result = mysql_query($sql ,$conn);
	if(!$result){
		mysql_close($conn);
		header("location:add_group_contest.php?act=error_add");
		exit();
	}else{
		foreach($_POST as $key => $value){
			unset($_SESSION[$key]);
		}
		mysql_close($conn);
		header("location:add_group_contest.php?act=success_add");
		exit();
	}
	mysql_close($conn);
?>
