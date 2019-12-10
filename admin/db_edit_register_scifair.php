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

$sql = "UPDATE register_scifair SET name='" . $_POST['register_name'] . "',reward='" . $_POST['register_reward'] . "',school_name='" . $_POST['register_school'] . "' ,subject='" . $_POST['register_subject'] . "'WHERE running_year = '" . $running_year . "' AND id=" . $_POST['id'];
$result = mysqli_query_log($conn, $sql);
if (!$result) {
    mysqli_close($conn);
    header("location:cert_maker_scifair.php?act=error_update");
    exit();
} else {
    mysqli_close($conn);
    header("location:cert_maker_scifair.php?act=success_update");
    exit();
}
mysqli_close($conn);
