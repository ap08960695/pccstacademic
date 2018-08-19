<?php
    session_start();
    include_once('../condb.php');
    include_once('admin_check.php');

    $code = $_POST['code'];
    
    $sql = "DELETE FROM room WHERE id='$code';";
    if(mysql_query($sql ,$conn)){
		header("location:add_room.php?act=success_delete");
	}else{
		header("location:add_room.php?act=error_delete");
	}
	
    mysql_close($conn);
?>
