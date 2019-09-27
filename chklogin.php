<?php
session_start();
include_once('condb.php');

$sql = "SELECT meta FROM config WHERE (meta='userAdmin' AND value='" . md5($_POST['user']) . "') OR (meta='passAdmin' AND value='" . md5($_POST['pass']) . "')";
$result = mysqli_query_log($conn, $sql);
if (mysqli_num_rows($result) == 2) {
    $_SESSION['user'] = $_POST['user'];
    $_SESSION['pass'] = $_POST['pass'];
    header("Location: admin/");
    exit();
}
$sql = "SELECT user,code,display FROM school WHERE user = '" . $_POST['user'] . "' AND pass = '" . $_POST['pass'] . "' AND status = 1 AND running_year = '$running_year';";
$result = mysqli_query_log($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    if ($row = mysqli_fetch_array($result)) {
        print_r($row);
        $_SESSION['user'] = $row['user'];
        $_SESSION['code'] = $row['code'];
        $_SESSION['display'] = $row['display'];
        header("Location: index.php?running_year=" . $running_year);
        exit();
    }
} else {
    header("Location: login.php?err=1&?running_year=" . $running_year);
    exit();
}
