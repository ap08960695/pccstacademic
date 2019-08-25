<?php
    session_start();
    include_once('../condb.php');
    include_once('admin_check.php');

	$sql = "SELECT id,room_name,amount_student FROM room";
    $result = mysqli_query($conn,$sql);
	if($result){
		$room = array();
		while($row = mysqli_fetch_array($result)){
			array_push($room,array("room_id"=>$row['id'],"room_name"=>$row['room_name'],"limit_student"=>$row['amount_student']));
		}
		echo json_encode($room);
	}else{
		echo "[]";
	}
	mysqli_close($conn);
