<?php
    /*session_start();
    include_once('../condb.php');
    
	$sql = "SELECT * FROM subject";
    $result = mysqli_query($conn,$sql);
	if ($result) {
		while($row = mysqli_fetch_array($result)) {
			
			if($row['room1']!=""){
				$sql = "SELECT id FROM room WHERE room_name='".$row['room1']."'";
				$r = mysqli_fetch_array(mysqli_query($conn,$sql));
				$sql = "INSERT INTO room_contest (contest_code,room_id) VALUES ('".$row['code']."',".$r['id'].")";
				mysqli_query($conn,$sql);
			}
			if($row['room2']!=""){
				$sql = "SELECT id FROM room WHERE room_name='".$row['room2']."'";
				$r = mysqli_fetch_array(mysqli_query($conn,$sql));
				$sql = "INSERT INTO room_contest (contest_code,room_id) VALUES ('".$row['code']."',".$r['id'].")";
				mysqli_query($conn,$sql);
			}
			if($row['room3']!=""){
				$sql = "SELECT id FROM room WHERE room_name='".$row['room3']."'";
				$r = mysqli_fetch_array(mysqli_query($conn,$sql));
				$sql = "INSERT INTO room_contest (contest_code,room_id) VALUES ('".$row['code']."',".$r['id'].")";
				mysqli_query($conn,$sql);
			}
		}
	}
    mysqli_close($conn);*/
