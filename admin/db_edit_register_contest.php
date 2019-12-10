<?php
session_start();
include_once('../condb.php');
include_once('admin_check.php');
$check_empty = 0;
foreach ($_POST as $key => $value) {
    if ($key != "register_score" && $_POST[$key] == "")
        $check_empty = 1;
}
if ($check_empty) {
    mysqli_close($conn);
    header("location:edit_score.php?act=error_empty&s=" . $_POST['register_contest']);
    exit();
}
if ($_POST['register_score'] == "")
    $_POST['register_score'] = -1;
else if ($_POST['register_score'] < 0)
    $_POST['register_score'] = 0;
$_POST['register_school'] = explode(",", $_POST['register_school'])[0];

$sql = "UPDATE register SET name='" . $_POST['register_name'] . "',score=" . $_POST['register_score'] . " WHERE running_year = '" . $running_year . "' AND id=" . $_POST['id'];
$result = mysqli_query_log($conn, $sql);
if (!$result) {
    mysqli_close($conn);
    header("location:edit_score.php?act=error_update&s=" . $_POST['register_contest']);
    exit();
} else {
    mysqli_close($conn);
    header("location:edit_score.php?act=success_update&s=" . $_POST['register_contest']);
    exit();
}
mysqli_close($conn);
