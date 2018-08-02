<?php
    session_start();
    include_once('../condb.php');
    
	$sql = "SELECT * FROM subject";
    $result = mysql_query($sql ,$conn);
	if ($result) {
		while($row = mysql_fetch_array($result)) {
			
			if($row['room1']!=""){
				$sql = "SELECT id FROM room WHERE room_name='".$row['room1']."'";
				$r = mysql_fetch_array(mysql_query($sql ,$conn));
				$sql = "INSERT INTO room_contest (contest_code,room_id) VALUES ('".$row['code']."',".$r['id'].")";
				mysql_query($sql ,$conn);
			}
			if($row['room2']!=""){
				$sql = "SELECT id FROM room WHERE room_name='".$row['room2']."'";
				$r = mysql_fetch_array(mysql_query($sql ,$conn));
				$sql = "INSERT INTO room_contest (contest_code,room_id) VALUES ('".$row['code']."',".$r['id'].")";
				mysql_query($sql ,$conn);
			}
			if($row['room3']!=""){
				$sql = "SELECT id FROM room WHERE room_name='".$row['room3']."'";
				$r = mysql_fetch_array(mysql_query($sql ,$conn));
				$sql = "INSERT INTO room_contest (contest_code,room_id) VALUES ('".$row['code']."',".$r['id'].")";
				mysql_query($sql ,$conn);
			}
		}
	}
    mysql_close($conn);
?>
