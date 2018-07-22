<?php
    session_start();
    include_once('../condb.php');
    $sql = "SELECT meta FROM config WHERE meta='userAdmin' AND value='".md5($_SESSION['user'])."'";
    $result = mysql_query($sql);
	  if(mysql_num_rows($result)!=1){
		header("Location: ../login.php");
		exit();
	  }

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
