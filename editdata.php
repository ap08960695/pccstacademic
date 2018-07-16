<?php
    session_start();
    include_once('condb.php');
    if(!isset($_SESSION["user"]))
    {
        header("location:login.php");
    }

    $school_code = $_SESSION["code"];
    $schoolname = $_SESSION["display"];

    $stdcode = $_POST['id'];
    $teachcode = $_POST['teachid'];
    $arrstudent = $_POST['student'];
    $arrteacher = $_POST['teacher'];
    $user = $_SESSION["usr"];
    $arrstdcode = $stdcode; //explode(",", $stdcode);
    $arrteachcode = $teachcode; //explode(",", $teachcode);
    //$sql = "";

    if(!empty($arrstudent)) {
        //$sql = "UPDATE `register` SET `status`= 0 WHERE school_id = '$school_code';";
        //mysql_query($sql);
        for($i = 0; $i < count($arrstudent); $i++) {
            if($arrstudent[$i] != ""){
                //$sql = "INSERT INTO `register` (`school_id`, `subject_id`, `no`, `name`, `u_date`, `status`) VALUES ('$school_code', '$arrstdcode[$i]', 1, '$arrstudent[$i]', NOW(), 1);";
                $sql = "UPDATE `register` SET `name` = '".$arrstudent[$i]."' WHERE id = '".$arrstdcode[$i]."';";
				$result = mysql_query($sql ,$conn);
            }
        }

        for($i = 0; $i < count($arrteacher); $i++) {
            if($arrteacher[$i] != ""){
                //$sql = "INSERT INTO `register` (`school_id`, `subject_id`, `no`, `name`, `u_date`, `status`) VALUES ('$school_code', '$arrteachcode[$i]', 0, '$arrteacher[$i]', NOW(), 1);";
				$sql = "UPDATE `register` SET `name` = '".$arrteacher[$i]."' WHERE id = '".$arrteachcode[$i]."';";
                $result = mysql_query($sql ,$conn);
            }
        }
    }

    //echo $sql;

    header("location:report_subject.php");
    $conn->close();
?>
