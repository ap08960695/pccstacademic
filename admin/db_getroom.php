<?php
    session_start();
    include_once('../condb.php');
    $sql = "SELECT meta FROM config WHERE meta='userAdmin' AND value='".md5($_SESSION['user'])."'";
    $result = mysql_query($sql);
	  if(mysql_num_rows($result)!=1){
		echo "[]";
		exit();
	  }

	$sql = "SELECT id,room_name,amount_student FROM room";
    $result = mysql_query($sql ,$conn);
	if($result){
		$room = [];
		while($row = mysql_fetch_array($result)){
			array_push($room,["room_id"=>$row['id'],"room_name"=>$row['room_name'],"limit_student"=>$row['amount_student']]);
		}
		echo json_encode($room);
	}else{
		echo "[]";
	}
	mysql_close($conn);
	
	 
?>
