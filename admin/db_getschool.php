<?php
    session_start();
    include_once('../condb.php');
    include_once('admin_check.php');

	$sql = "SELECT code,display FROM school WHERE running_year = '$running_year'";
    $result = mysqli_query_log($conn,$sql);
	if($result){
		$school = array();
		while($row = mysqli_fetch_array($result)){
			array_push($school,array("code"=>$row['code'],"display"=>$row['display']));
		}
		echo json_encode($school);
	}else{
		echo "[]";
	}
	mysqli_close($conn);
