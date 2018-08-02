<?php
    session_start();
    include_once('../condb.php');
    $sql = "SELECT meta FROM config WHERE meta='userAdmin' AND value='".md5($_SESSION['user'])."'";
    $result = mysql_query($sql);
	  if(mysql_num_rows($result)!=1){
		header("Location: ../login.php");
		exit();
	  }

	$user = $_GET['user'];
	$group = $_GET['group'];
    
	$sql = "UPDATE school SET group_contest='$group' WHERE user='$user';";
    $result = mysql_query($sql ,$conn);
	if(mysql_query($sql ,$conn)){
		header("location:school.php?act=success_update");
	}else{
		header("location:school.php?act=error_update");
	}
	mysql_close($conn);
?>
