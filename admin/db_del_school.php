<?php
session_start();
include_once('../condb.php');
include_once('admin_check.php');

$code = $_POST['code'];
$user = $_POST['user'];

$sql = "DELETE FROM school WHERE running_year = '$running_year' AND user='$user';";
if (mysqli_query_log($conn, $sql)) {
    header("location:index.php?act=success_delete&user=$user");
} else {
    header("location:index.php?act=error_delete");
}

mysqli_close($conn);
