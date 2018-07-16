<?php
    session_start();
    include_once('condb.php');
    if(!isset($_SESSION["user"]))
    {
        header("location:login.php");
    }

    $school_code = $_SESSION["code"];
    $schoolname = $_SESSION["display"];

    $user = $_SESSION["usr"];
	//echo $_POST["std1id"]."<br>\n";
	//echo $_POST["std2id"]."<br>\n";
	//echo $_POST["teachid"]."<br>\n";
	print_r($_POST["score"]);
    $std1id = explode(",", $_POST["std1id"]);
	$std2id = explode(",", $_POST["std2id"]);
	$teachid = explode(",", $_POST["teachid"]);
	$arrscore = $_POST["score"];
	$subject = $_POST["subject"];
	$teacherscore = array();
	
	$sql = "SELECT * FROM `subject` WHERE code = '".$subject."';";
	$result = mysql_query($sql ,$conn);
    if (mysql_num_rows($result) > 0) {
        while($row = mysql_fetch_array($result)) {
			$person = $row['person'];									
		}
	}
	//echo $subject."|".$person."<br>\n";
	
    if(!empty($std1id)) {
        mysql_query($sql);
		$k = 0;
		if($person == 1) {
			for($i = 0; $i < count($std1id); $i++) {
				if($std1id[$i] != ""){
					if($arrscore[$k] != "") {
						$score = "'".$arrscore[$i]."'";
					} else {
						$score = "NULL";
					}
					$sql = "UPDATE `register` SET score = ".$score." WHERE id = '".$std1id[$i]."';";
					$result = mysql_query($sql ,$conn);
					//echo $sql."<br>\n";
					
					$idtech = $teachid[$i];
					if($teacherscore[$idtech] < $arrscore[$k]) {
						$teacherscore[$idtech] = $arrscore[$k];
					}
					
					$sql = "UPDATE `register` SET score = ".$teacherscore[$idtech]." WHERE id = '".$teachid[$i]."';";
					$result = mysql_query($sql ,$conn);
					//echo $sql."<br>\n";
					$k++;
				}
			}
		} else {
			for($i = 0; $i < count($std1id); $i++) {
				if($std1id[$i] != ""){
					if($arrscore[$k] != "") {
						$score = "'".$arrscore[$i]."'";
					} else {
						$score = "NULL";
					}
					$sql = "UPDATE `register` SET score = ".$score." WHERE id = '".$std1id[$i]."';";
					$result = mysql_query($sql ,$conn);
					//echo $sql."<br>\n";
					$sql = "UPDATE `register` SET score = ".$score." WHERE id = '".$std2id[$i]."';";
					$result = mysql_query($sql ,$conn);
					//echo $sql."<br>\n";
					
					$idtech = $teachid[$i];
					if($teacherscore[$idtech] < $arrscore[$k]) {
						$teacherscore[$idtech] = $arrscore[$k];
					}
					
					$sql = "UPDATE `register` SET score = ".$teacherscore[$idtech]." WHERE id = '".$teachid[$i]."';";
					$result = mysql_query($sql ,$conn);
					//echo $sql."<br>\n";
					$k++;
				}
			}
		}
    }

    header("location:report_subject.php");
    $conn->close();
?>
