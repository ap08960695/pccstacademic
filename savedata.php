<?php
    session_start();
    include_once('condb.php');
    if(!isset($_SESSION["user"]))
    {
        header("location:login.php");
    }

    $school_code = $_SESSION["code"];
    $schoolname = $_SESSION["display"];

    $arrstudent = $_POST['student'];
    $arrteacher = $_POST['teacher'];
    $user = $_SESSION["usr"];
    
	
	$sql = "UPDATE register SET status=0 WHERE school_id='$school_code'";
	mysql_query($sql);
	$sql_string = "";
	$list_name = [];
	$len_name = 0;
	foreach($arrstudent as $key => $value){
		foreach($value as $sub_value){
			if($sub_value!=""){
				$sql_string .= "('$school_code', $key,'$sub_value'),";
				$list_name[$sub_value] = 1;
				$len_name++;
			}
		}
		
	}
	if($len_name!=count($list_name)){
		$sql = "UPDATE register SET status=1 WHERE school_id='$school_code'";
		mysql_query($sql);
		$sql_string="";
		header("location:index.php?error=update_student");
		exit();
	}
	if($sql_string!=""){
		$sql_string = substr($sql_string, 0, -1);
		$sql = "INSERT INTO `register` (`school_id`, `subject_id`, `name`) VALUES $sql_string;";
		$result = mysql_query($sql ,$conn);
		if(!$result){
			$sql = "UPDATE register SET status=1 WHERE school_id='$school_code'";
			mysql_query($sql);
			header("location:index.php?error=update_student");
			exit();
		}else{
			$sql = "DELETE FROM register WHERE school_id='$school_code' AND status=0";
			mysql_query($sql);
		}
	}
	
	$sql = "UPDATE register_teacher SET status=0 WHERE school_id='$school_code'";
	mysql_query($sql);
	$sql_string = "";
	foreach($arrteacher as $key => $value){
		foreach($value as $sub_value){
			if($sub_value!=""){
				$sql_string .= "('$school_code', $key,'$sub_value'),";
			}
		}
		
	}
	if($sql_string!=""){
		$sql_string = substr($sql_string, 0, -1);
		$sql = "INSERT INTO `register_teacher` (`school_id`, `subject_id`, `name`) VALUES $sql_string;";
		$result = mysql_query($sql ,$conn);
		if(!$result){
			$sql = "UPDATE register_teacher SET status=1 WHERE school_id='$school_code'";
			mysql_query($sql);
			header("location:index.php?error=update_teacher");
			exit();
		}else{
			$sql = "DELETE FROM register_teacher WHERE school_id='$school_code' AND status=0";
			mysql_query($sql);
		}
	}
	
    mysql_close($conn);
    header("location:index.php?success=true");
?>
