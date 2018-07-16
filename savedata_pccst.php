<?php
    session_start();
    include_once('condb.php');
    if(!isset($_SESSION["user"]))
    {
        header("location:login.php");
    }

    $school_code = $_SESSION["code"];
    $schoolname = $_SESSION["display"];

    $stdcode = $_POST['stdcode'];
    $teachcode = $_POST['teachcode'];
    $arrstudent = $_POST['student'];
    $arrteacher = $_POST['teacher'];
    $user = $_SESSION["usr"];
    $arrstdcode = $_POST['code']; //explode(",", $stdcode);
    $arrteachcode = $teachcode; //explode(",", $teachcode);
    //$sql = "";
	print_r($teachcode);

    if(!empty($arrstudent)) {
        $sql = "UPDATE `register` SET `status`= 0 WHERE school_id = '$school_code' AND subject_id = '$arrstdcode[0]';";
        mysql_query($sql);
        for($i = 0; $i < count($arrstudent); $i++) {
            if($arrstudent[$i] != ""){
                $sql = "INSERT INTO `register` (`school_id`, `subject_id`, `no`, `name`, `u_date`, `status`) VALUES ('$school_code', '$arrstdcode[$i]', 1, '$arrstudent[$i]', NOW(), 1);";
                $result = mysql_query($sql ,$conn);
				//echo $sql."\n";
            }
        }

        for($i = 0; $i < count($arrteacher); $i++) {
            if($arrteacher[$i] != ""){
                $sql = "INSERT INTO `register` (`school_id`, `subject_id`, `no`, `name`, `u_date`, `status`) VALUES ('$school_code', '$arrteachcode[$i]', 0, '$arrteacher[$i]', NOW(), 1);";
                $result = mysql_query($sql ,$conn);
				//echo $sql."\n";
            }
        }

    }

    //echo $sql;

    header("location:index_pccst.php?subject=".$arrstdcode[0]);
    $conn->close();

?>
