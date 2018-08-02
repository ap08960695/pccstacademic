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

    $code = $_POST['code'];
    
    $sql = "DELETE FROM contest WHERE code='$code';";
    if(mysql_query($sql ,$conn)){
		$sql = "DELETE FROM room_contest WHERE contest_code='$code';";
		if(mysql_query($sql ,$conn)){
			$sql = "DELETE FROM contest_group WHERE contest_code='$code';";
			if(mysql_query($sql ,$conn)){
				header("location:add_contest.php?act=success_delete");
			}else header("location:add_contest.php?act=error_delete");
		}else {
			header("location:add_contest.php?act=error_delete");
		}
	}else{
		header("location:add_contest.php?act=error_delete");
	}
	
    mysql_close($conn);
?>
