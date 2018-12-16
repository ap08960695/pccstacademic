<?php
	session_start();
    include_once('condb.php');
	include_once('user_check.php');
	
	if($_POST['password']!=$_POST['repassword']){
		mysql_close($conn);
		header("location:setting.php?act=error_password");
		exit();
	}	
	$sql = "UPDATE school SET ";
	if($_POST['username']!=""){
		$sql_ch = "select * from school where (user='".md5($_POST['username'])."') AND code<>'".$_POST['code']."'";
		$result = mysql_query($sql_ch ,$conn);
		if($result){
			if(mysql_num_rows($result)>0){
				mysql_close($conn);
				header('Location: setting.php?act=error_same');
				exit();
			}else $sql .= "user='".md5($_POST['username'])."',";
		}else {
			mysql_close($conn);
			header('Location: setting.php?act=update_error');
			exit();
		}
	}
	if($_POST['password']!=""){
		$sql .= "pass='".md5($_POST['password'])."',";
	}
	$sql_ch = "select * from school where (display='".$_POST['display']."') AND code<>'".$_POST['code']."'";
	$result = mysql_query($sql_ch ,$conn);
	if($result){
		if(mysql_num_rows($result)>0){
			mysql_close($conn);
			header('Location: setting.php?act=error_same');
			exit();
		}
	}else {
		mysql_close($conn);
		header('Location: setting.php?act=update_error');
		exit();
	}
	$sql .= "display='".$_POST['display']."',email='".$_POST['email']."',amper='".$_POST['district']."',changwat='".$_POST['province']."',addrcode='".$_POST['zip']."',phone='".$_POST['phone']."'";
	$sql .= " WHERE code='".$_POST['code']."'";
	if(mysql_query($sql ,$conn)){
		if($_POST['username']!="")
			$_SESSION['user'] = md5($_POST['username']);
		$_SESSION['display'] = $_POST['display'];
		header('Location: setting.php?act=update_success');
	}else{
		mysql_close($conn);
		header("location:setting.php?act=update_error");	
		exit();
	}
	mysql_close($conn);
?>
