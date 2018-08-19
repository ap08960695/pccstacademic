<?php
    session_start();
    include_once('../condb.php');
    include_once('admin_check.php');

	$sql = "SELECT id,room_name,amount_student FROM room";
    $result = mysql_query($sql ,$conn);
	if($result){
		$room = array();
		while($row = mysql_fetch_array($result)){
			array_push($room,array("room_id"=>$row['id'],"room_name"=>$row['room_name'],"limit_student"=>$row['amount_student']));
		}
		echo json_encode($room);
	}else{
		echo "[]";
	}
	mysql_close($conn);
	
	 
?>
