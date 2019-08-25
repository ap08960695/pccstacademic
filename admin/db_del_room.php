<?php
    session_start();
    include_once('../condb.php');
    include_once('admin_check.php');

    $code = $_POST['code'];
    
    $sql = "DELETE FROM room WHERE id='$code';";
    if(mysqli_query($conn,$sql)){
		header("location:add_room.php?act=success_delete");
	}else{
		header("location:add_room.php?act=error_delete");
	}
	
    mysqli_close($conn);
