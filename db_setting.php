<?php
    include_once('condb.php');

    
	if($_POST['password']!=$_POST['repassword']){
		mysql_close($conn);
		header("location:setting.php?act=error_password");
		exit();
	}
		
	$sql = "UPDATE school SET ";
	if($_POST['username']!=""){
		$sql .= "user='".md5($_POST['username'])."',";
	}
	if($_POST['password']!=""){
		$sql .= "pass='".md5($_POST['password'])."',";
	}
	$sql .= "display='".$_POST['display']."',email='".$_POST['email']."',amper='".$_POST['district']."',changwat='".$_POST['province']."',addrcode='".$_POST['zip']."'";
	$sql .= " WHERE code='".$_POST['code']."'";
	if(mysql_query($sql ,$conn)){
		if($_POST['username']!="")
			$_SESSION['user'] = md5($_POST['username']);
		$_SESSION['display'] = $_POST['display'];
				
		header('Location: setting.php?act=update_success');
	}else{
		header("location:setting.php?act=update_error");	
	}
?>
