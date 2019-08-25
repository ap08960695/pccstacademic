<?php
include_once('../condb.php');
$sql = "SELECT * FROM school";
if ($re = mysqli_query($conn, $sql)) {
    $count = 1;
    while ($row = mysqli_fetch_assoc($re)) {
        $user = "test" . intval($count++);
        $sql = "UPDATE school SET user='" . md5($user) . "',pass='" . md5($user) . "' WHERE id=" . $row['id'];
        mysqli_query($conn, $sql);
    }
}
mysqli_close($conn);
