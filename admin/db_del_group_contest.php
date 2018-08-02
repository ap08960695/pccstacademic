<?php
    session_start();
    include_once('../condb.php');
    $sql = "SELECT meta FROM config WHERE meta='userAdmin' AND value='".md5($_SESSION['user'])."'";
    $result = mysql_query($sql);
	  if(mysql_num_rows($result)!=1){
		header("Location: ../login.php");
		exit();
	  }

    $group_name = $_POST['group_name'];
    
    $sql = "DELETE FROM contest_group WHERE group_name='$group_name';";
    if(mysql_query($sql ,$conn)){
		header("location:add_group_contest.php?act=success_delete");
	}else{
		header("location:add_group_contest.php?act=error_delete");
	}
	
    mysql_close($conn);
?>
