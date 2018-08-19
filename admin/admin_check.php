<?php
	$sql = "SELECT meta FROM config WHERE (meta='userAdmin' AND value='".md5($_SESSION['user'])."') OR (meta='passAdmin' AND value='".md5($_SESSION['pass'])."')";
    $result = mysql_query($sql);
	if(mysql_num_rows($result)!=2){
		mysql_close($conn);
		header("Location: ../login.php");
		exit();
	}
?>