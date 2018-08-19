<?php
    session_start();
    include_once('../condb.php');
    include_once('admin_check.php');
    

    $group_name = $_POST['group_name'];
    
    $sql = "DELETE FROM contest_group WHERE group_name='$group_name';";
    if(mysql_query($sql ,$conn)){
		header("location:add_group_contest.php?act=success_delete");
	}else{
		header("location:add_group_contest.php?act=error_delete");
	}
	
    mysql_close($conn);
?>
