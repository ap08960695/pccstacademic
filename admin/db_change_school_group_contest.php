<?php
    session_start();
    include_once('../condb.php');
    include_once('admin_check.php');

	$user = $_GET['user'];
	$group = $_GET['group'];
    
	$sql = "UPDATE school SET group_contest='$group' WHERE user='$user';";
    $result = mysql_query($sql ,$conn);
	if(mysql_query($sql ,$conn)){
		header("location:index.php?act=success_update");
	}else{
		header("location:index.php?act=error_update");
	}
	mysql_close($conn);
?>
