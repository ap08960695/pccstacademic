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
    $name = $_POST['name'];
    $usern = $_POST['usern'];
    $passwd = $_POST['passwd'];
    $user = $_SESSION["usr"];
    //$sql = "";

    $sql = "INSERT INTO `school` (`user`, `pass`, `code`, `display`, `u_date`, `status`) VALUES ('$usern', '$passwd', '$code', '$name', NOW(), 1);";
    $result = mysql_query($sql ,$conn);

    //echo $sql;

    header("location:addschool.php");
    $conn->close();
?>
