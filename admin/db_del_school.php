<?php
    session_start();
    include_once('../condb.php');
    include_once('admin_check.php');
    
    $code = $_POST['code'];
	$user = $_POST['user'];
    
    $sql = "DELETE FROM school WHERE user='$user';";
    if(mysql_query($sql ,$conn)){
		header("location:school.php?act=success_delete&user=$user");
	}else{
		header("location:school.php?act=error_delete");
	}
	
    mysql_close($conn);
?>
