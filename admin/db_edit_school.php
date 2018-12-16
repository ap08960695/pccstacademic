<?php
    session_start();
    include_once('../condb.php');
    include_once('admin_check.php');
    
	$sql = "UPDATE school SET display='".$_POST['school_display']."',email='".$_POST['school_email']."',amper='".$_POST['school_amper']."',changwat='".$_POST['school_changwat']."',addrcode='".$_POST['school_zip']."',phone='".$_POST['school_phone']."'";
	$result = mysql_query($sql ,$conn);
	if(!$result){
		mysql_close($conn);
		header("location:edit_school.php?act=error_edit");
		exit();
	}else{
		mysql_close($conn);
		header("location:index.php?act=success_edit_school");
		exit();	
	}
?>
