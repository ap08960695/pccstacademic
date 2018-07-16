<?php
    session_start();
    include_once('condb.php');
    if(!isset($_SESSION["user"]))
    {
        header("location:login.php");
    }

    $school_code = $_SESSION["code"];
    $schoolname = $_SESSION["display"];

    $code = $_POST['code'];
    //$sql = "";

    $sql = "UPDATE school SET status = 0 WHERE code = '$code';";
    $result = mysql_query($sql ,$conn);

    //echo $sql;

    header("location:addschool.php");
    $conn->close();
?>
