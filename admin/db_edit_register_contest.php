<?php
session_start();
include_once('../condb.php');
include_once('admin_check.php');
$check_empty = 0;
foreach ($_POST['register_name'] as $key => $value) {
    if ($_POST['register_name'][$key] == "")
        $check_empty = 1;
}
if ($check_empty) {
    mysqli_close($conn);
    header("location:edit_score.php?act=error_empty&s=" . $_POST['register_contest']);
    exit();
}
if ($_GET['type'] == "student") {
    foreach ($_POST['register_name'] as $key => $value) {
        if ($_POST['register_score'][$key] == "")
            $_POST['register_score'][$key] = -1;
        else if ($_POST['register_score'][$key] < 0)
            $_POST['register_score'][$key] = 0;
        $sql = "UPDATE register SET name='" . $_POST['register_name'][$key] . "',score=" . $_POST['register_score'][$key] . " WHERE running_year = '" . $running_year . "' AND id=" . $key . ";";
        $result = mysqli_query_log($conn, $sql);
        if (!$result) {
            mysqli_close($conn);
            header("location:edit_score.php?act=error_update&s=" . $_POST['register_contest']);
            exit();
        }
    }
} else if ($_GET['type'] == "teacher") {
    foreach ($_POST['register_name'] as $key => $value) {
        $sql = "UPDATE register_teacher SET name='" . $_POST['register_name'][$key] . "' WHERE running_year = '" . $running_year . "' AND id=" . $key . ";";
        $result = mysqli_query_log($conn, $sql);
        if (!$result) {
            mysqli_close($conn);
            header("location:edit_score.php?act=error_update&s=" . $_POST['register_contest']);
            exit();
        }
    }
}
mysqli_close($conn);
header("location:edit_score.php?act=success_update&s=" . $_POST['register_contest']);
exit();
