<?php

	$sql = "SELECT * FROM school WHERE user = '".$_SESSION['user']."' AND code = '".$_SESSION['code']."' AND status = 1;";
	$result = mysql_query($sql);
	if(mysql_num_rows($result)!=1){
		header("Location: login.php");
		exit();
	} else {
		$school_info = mysql_fetch_assoc($result);
	}
?>