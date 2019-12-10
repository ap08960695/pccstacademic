<?php
session_start();
include_once('../condb.php');
include_once('admin_check.php');

$sql = "DELETE FROM register_scifair WHERE running_year = '$running_year' AND id=" . $_POST['id'] . ";";
if (mysqli_query_log($conn, $sql)) {
    header("location:cert_maker_scifair.php?act=success_delete");
} else {
    header("location:cert_maker_scifair.php?act=error_delete");
}
mysqli_close($conn);
