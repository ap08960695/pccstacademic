<?php
    session_start();
    include_once('../condb.php');
    include_once('admin_check.php');
    
	$sql = "UPDATE school SET display='".$_POST['school_display']."',email='".$_POST['school_email']."',amper='".$_POST['school_amper']."',changwat='".$_POST['school_changwat']."',addrcode='".$_POST['school_zip']."',phone='".$_POST['school_phone']."' WHERE code='".$_POST['school_code']."'";
	$result = mysqli_query($conn,$sql);
	if(!$result){
		mysqli_close($conn);
		header("location:edit_school.php?act=error_edit");
		exit();
	}else{
		mysqli_close($conn);
		header("location:index.php?act=success_edit_school");
		exit();	
	}
