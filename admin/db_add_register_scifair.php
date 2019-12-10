<?php
session_start();
include_once('../condb.php');
include_once('admin_check.php');
$check_empty = 0;
foreach ($_POST as $key => $value) {
    if ($_POST[$key] == "")
        $check_empty = 1;
}
if (!isset($_GET['type'])) {
    mysqli_close($conn);
    header("location:cert_maker_scifair.php?act=error_empty");
    exit();
}
if ($check_empty) {
    mysqli_close($conn);
    header("location:cert_maker_scifair.php?act=error_empty");
    exit();
}
$_POST['register_school'] = explode(",", $_POST['register_school'])[0];

$sql = "INSERT INTO register_scifair (school_name,name,reward,type,subject,running_year) VALUES ('" . $_POST['register_school'] . "','" . $_POST['register_name'] . "','" . $_POST['register_reward'] . "','" . $_GET['type'] . "','" . $_POST['register_subject'] . "','$running_year')";
$result = mysqli_query_log($conn, $sql);
if (!$result) {
    mysqli_close($conn);
    header("location:cert_maker_scifair.php?act=error_add");
    exit();
} else {
    foreach ($_POST as $key => $value) {
        unset($_SESSION[$key]);
    }
    mysqli_close($conn);
    header("location:cert_maker_scifair.php?act=success_add");
    exit();
}
mysqli_close($conn);
